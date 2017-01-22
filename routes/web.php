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
Route::get('/checkEmail', 'HomeController@checkEmail');
Route::get('/getInboxEmails', 'HomeController@getInboxEmails');
