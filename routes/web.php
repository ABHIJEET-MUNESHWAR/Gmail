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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/emailList', 'HomeController@emailList');
Route::post('/sendEmail', 'HomeController@sendEmail');
Route::post('/draftEmail', 'HomeController@draftEmail');
Route::get('/checkEmail', 'HomeController@checkEmail');
Route::get('/getInboxEmails', 'HomeController@getInboxEmails');
Route::get('/getDraftEmails', 'HomeController@getDraftEmails');
Route::get('/getSentEmails', 'HomeController@getSentEmails');
Route::get('/getTrashEmails', 'HomeController@getTrashEmails');
Route::post('/getEmailDetails', 'HomeController@getEmailDetails');
Route::post('/deleteEmail', 'HomeController@deleteEmail');