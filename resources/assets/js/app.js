"use strict";

let noteList    = {};
let rawList     = [];
let baseUri     = '/api/v1/notes';

$(function () {
    // Get all the notes for the user
    getNotes();

    $('#notes_modal').on('hidden.bs.modal', function () {
        $("#notes_form")[0].reset();
    });

    $(document).on('click', ".add", function () {
        $(".operation").html('Add');
        $(".form_submit")
            .removeClass('update_note')
            .addClass('create_note')
    });

    $(document).on('click', ".edit", function () {
        $(".operation").text('Edit');
        $(".form_submit")
            .removeClass('create_note')
            .addClass('update_note')
            .data('uuid', $(this).data('uuid'))
        $("#title").val(noteList[$(this).data('uuid')].title);
        $(".note").val(noteList[$(this).data('uuid')].notes);
    });

    $(document).on('click', '.delete', function () {
        deleteNote($(this).data('uuid'));
    })

    $(document).on('click', '.create_note', function () {
        let params  = getParams();

        if (! params) {
            return false;
        }

        createNote(params);
    });

    $(document).on('click', '.update_note', function () {
        let params  = getParams();

        if (! params) {
            return false;
        }

        updateNote($(this).data('uuid'), params);
    });
});

/**
 * Get params.
 *
 * @return {*}
 */
function getParams() {
    let params  = {};

    params.title    = $("#title").val().trim();
    if (empty(params.title)) {
        alert('Please enter Title');
        return false;
    }

    params.notes    = $("#note").val().trim();
    if (empty(params.notes)) {
        alert('Please enter Notes.');
        return false;
    }

    return params;
}

/**
 * Get the list of notes.
 */
function getNotes () {
    showLoader();

    $.ajax({
        url     : baseUri,
        headers : jsonHeader(),
        success : function (result) {
            rawList = result.data;

            renderNotes(rawList);

            hideLoader();
        },
        error   : function (error) {
            console(error);
            hideLoader();
        }
    });
}

/**
 * Render the notes list.
 *
 * @param list
 */
function renderNotes (list, sort = true) {
    let html    = "";

    if (sort) {
        list.sort(sortByCreatedAt);
    }

    $.each(list, function (index, obj) {
        noteList[obj.uuid]   =  {
            title   : obj.title,
            notes   : obj.notes
        }
        html += getListTemplate(obj);
    })

    $(".notes_list").html(html);
}

/**
 * Create notes.
 *
 * @param data
 */
function createNote (data) {
    showLoader();

    $.ajax({
        url     : baseUri,
        type    : 'POST',
        data    : JSON.stringify(data),
        headers : jsonHeader(),
        success : function (result) {
            rawList.push(result.data);
            noteList[result.data.uuid]   =  {
                title           : result.data.title,
                notes           : result.data.notes,
                "created_at"    : result.data.created_at
            }

            renderNotes(rawList);
            hideLoader();
            $('#notes_modal').modal('toggle');

            swal(
                'Success',
                'Note Created',
                'success'
            );
        },
        error   : function (error) {
            console(error);
            hideLoader();
        }
    });
}

/**
 * Update notes.
 *
 * @param uuid
 * @param data
 */
function updateNote (uuid, data) {
    showLoader();

    $.ajax({
        url     : baseUri + '/' + uuid,
        type    : 'PUT',
        data    : JSON.stringify(data),
        headers : jsonHeader(),
        success : function () {
            rawList = updateInObject(uuid, data);
            noteList[uuid]   =  {
                title   : data.title,
                notes   : data.notes
            }

            renderNotes(rawList, false);
            hideLoader();
            $('#notes_modal').modal('toggle');

            swal(
                'Success',
                'Note Updated',
                'success'
            )
        },
        error   : function (error) {
            console(error);
            hideLoader();
        }
    });
}

/**
 * Update an item in raw list.
 *
 * @param uuid
 * @param obj
 */
function updateInObject(uuid, obj) {
    //Find index of specific object using findIndex methode.
    let objIndex = rawList.findIndex((obj => obj.uuid == uuid));

    //Update object's name property.
    rawList[objIndex].title = obj.title;
    rawList[objIndex].notes = obj.notes;

    return rawList;
}

/**
 * Delete a note.
 *
 * @param uuid
 */
function deleteNote (uuid) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then(function () {
        showLoader();

        $.ajax({
            url     : baseUri + '/' + uuid,
            type    : 'DELETE',
            headers : jsonHeader(),
            success : function () {
                rawList = removeByAttr(rawList, 'uuid', uuid);
                delete noteList.uuid;

                renderNotes(rawList);
                hideLoader();

                swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            },
            error   : function (error) {
                console(error);
                hideLoader();
            }
        });
    });
}

/**
 * Set Cookie
 *
 * @param cname
 * @param cvalue
 * @param exdays
 *
 * @return void
 */
function setCookie(cname, cvalue, exdays = 30) {
    let d = new Date();

    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires=" + d.toGMTString();

    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get a specific cookie
 *
 * @param cname
 * @returns {*}
 */
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');

    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return null;
}

/**
 * Get the list template.
 *
 * @param object
 * @return {string}
 */
function getListTemplate(object) {
    return '<div class="well well-lg">'+
        '<span class="note_text">'+object.title+'</span> ' +
        '<span class="pull-right"> ' +
        '<button class="btn btn-primary edit glyphicon glyphicon-edit " ' +
        'data-toggle="modal"data-target="#notes_modal" data-uuid="'+object.uuid+'"> </button> ' +
        '<button class="btn btn-danger delete glyphicon glyphicon-trash" data-uuid="'+object.uuid+'"></button> ' +
        '</span> </div>'
}

/**
 * Get JSON header for API Call.
 *
 * @return {{Content-Type: string, Accept: string, Cookie-Id: *}}
 */
function jsonHeader() {
    return {
        "Content-Type":"application/json",
        "Accept":"application/json",
        "Cookie-Id": getCookieId()
    };
}

/**
 * Get cookie Id.
 *
 * @return {*}
 */
function getCookieId() {
    let cookieId    = getCookie('cookie_id');

    if (! cookieId) {
        cookieId    = uuid.v4();

        setCookie('cookie_id', cookieId);
    }

    return cookieId;
}

/**
 * Show Loader
 */
function showLoader(text = 'Please Wait . . .') {
    $('body').loadingModal({
        text: text,
        animation: 'fadingCircle'
    });
}

/**
 * Hide Loader
 */
function hideLoader() {
    $('body').loadingModal('hide');
    $('body').loadingModal('destroy');
}

/**
 * Verify for emptiness.
 *
 * @param item
 * @returns {boolean}
 */
function empty(item) {
    return item == null || item == undefined || item.length == 0
}

/**
 * sort list by date.
 *
 * @param a
 * @param b
 * @return {number}
 */
function sortByCreatedAt(a, b){
    return new Date(b.created_at) - new Date(a.created_at);
}

/**
 * Remove object by attr.
 *
 * @param arr
 * @param attr
 * @param value
 * @return {*}
 */
function removeByAttr(arr, attr, value){
    var i = arr.length;
    while(i--){
        if( arr[i]
            && arr[i].hasOwnProperty(attr)
            && (arguments.length > 2 && arr[i][attr] === value ) ){

            arr.splice(i,1);

        }
    }
    return arr;
}