<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/* Index Routes */
Route::get('/', 'IndexController@page');

Route::get('/page/{page?}', 'IndexController@page');

/* Set Up Auth Routes */
Auth::routes();

/* Upload Routes */
Route::get('/upload', 'UploadController@index')->middleware('auth');

Route::post('upload/upload', 'UploadController@upload');

Route::get('upload/upload', 'UploadController');

/* Image Routes */
//Route::get('/image', 'ImageController@index');
Route::get('/image', 'ImageController@noImage');

Route::get('/image/{pid}', 'ImageController@index');

// Edit Image.
Route::get('/image/{pid}/edit', 'ImageController@edit');

Route::post('image/comment', 'ImageController@comment');

Route::get('image/comment', 'ImageController');

/* Search Routes */
Route::get('search', 'SearchController@index');

