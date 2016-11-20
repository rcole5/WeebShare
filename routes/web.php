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


/* Auth Routes */
Auth::routes();


/* Upload Routes */
Route::get('/upload', 'UploadController@index')->middleware('auth');

Route::post('/upload/upload', 'UploadController@upload');

Route::get('/upload/upload', 'UploadController');


/* Image Routes */
Route::get('/image', 'ImageController@noImage');

Route::get('/image/{pid}', 'ImageController@index');

// Edit Image.
Route::get('/image/{pid}/edit', 'ImageController@edit')->middleware('uploader');

Route::post('/image/{pid}/edit/title', 'ImageController@editTitle')->middleware('uploader');

Route::post('/image/{pid}/edit/description', 'ImageController@editDescription')->middleware('uploader');

Route::post('/image/{pid}/edit/addtags', 'ImageController@addTags')->middleware('uploader');

Route::post('/image/{pid}/edit/deltag', 'ImageController@delTag')->middleware('uploader');

Route::post('/image/{pid}/edit/delete', 'ImageController@deleteImage')->middleware('uploader');

// Comments
Route::post('/image/comment', 'ImageController@comment');

Route::get('/image/comment', 'ImageController');


/* Search Routes */
Route::get('/search', 'SearchController@index');


/* User Routes */
Route::get('/user', 'UserController@noUser');

Route::get('/user/{uid}', 'UserController@index');
