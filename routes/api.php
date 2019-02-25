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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    // Comments
    Route::get('comments/{id}', 'CommentController@index');
    Route::post('comment', 'CommentController@store');
    Route::delete('comments/{id}', 'CommentController@destroy');

    // Replies
    Route::post('reply', 'CommentRepliesController@store');
    Route::get('replies/{id}', 'CommentRepliesController@index');
    Route::delete('replies/{id}', 'CommentRepliesController@destroy');
});


