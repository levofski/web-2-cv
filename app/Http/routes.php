<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('api/{documentName}', 'Api\DocumentController@show');
Route::put('api/{documentName}', 'Api\DocumentController@store');
Route::post('api/{documentName}/{path}', 'Api\DocumentController@update');
Route::delete('api/{documentName}', 'Api\DocumentController@destroy');