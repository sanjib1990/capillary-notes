<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix'        => 'v1/notes',
    'middleware'    => ['header', 'cookie']
], function () {
    // Create note route
    Route::post('/', 'NoteController@create')
        ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');

    // Get Note Route
    Route::get('{uuid?}', 'NoteController@get')
        ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');

    // Delete Note route
    Route::delete('{uuid}', 'NoteController@delete')
        ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');

    // Update note route
    Route::put('{uuid}', 'NoteController@update')
        ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');
});
