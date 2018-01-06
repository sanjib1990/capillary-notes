<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notes</title>
    <link rel="stylesheet" href="{!! elixir('css/app.css') !!}">
</head>
<body>
<div class="container">
    <div class="col-md-12 add_note_form">
        <nav>
            <a href="{!! route('map') !!}">MAP</a>
        </nav>
        <div class="row">
            <div class="jumbotron">
                <h2>Your Notes<span class="pull-right">
                    <button class="btn btn-success add glyphicon glyphicon-plus"
                            data-toggle="modal"
                            data-target="#notes_modal">
                    </button>
                </span></h2>
            </div>
        </div>
    </div>

    <div class="col-md-12 add_notes">
        <div class="row notes_list">
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="notes_modal" tabindex="-1" role="dialog" aria-labelledby="notes_modal_lable">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="notes_modal_label"><span class="operation">Add</span> Notes:</h4>
            </div>
            <div class="modal-body">
                <form id="notes_form">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="desc">Note:</label>
                        <textarea name="note" id="note" class="form-control note" cols="30" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success form_submit">Submit</button>
            </div>
        </div>
    </div>
</div>
</body>
<script src="http://wzrd.in/standalone/uuid@latest"></script>
<script src="{!! elixir('/js/app.js') !!}"></script>
</html>
