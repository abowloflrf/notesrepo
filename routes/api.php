<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::group(['middleware' => 'api', 'prefix' => 'notes'], function ($router) {
    Route::get('', 'NotesController@getNotesList');
    Route::post('', 'NotesController@createNote');
    Route::get('{uuid}', 'NotesController@getSingleNote');
    Route::post('{uuid}', 'NotesController@updateSingleNote');
    Route::delete('{uuid}', 'NotesController@deleteSingleNote');
});
Route::group(['middleware' => 'api', 'prefix' => 'folder'], function ($router) {
    Route::post('new', 'FolderController@createFolder');
    Route::delete('empty', 'FolderController@emptyFolder');
    Route::post('rename', 'FolderController@renameFolder');
});