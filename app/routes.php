<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', 'HomeController@showWelcome');
Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');

Route::group(array('prefix'=>'article'), function(){
    Route::get('/show/{id}', 'ArticleController@show');
    Route::get('/create/{id?}', 'ArticleController@getCreate');
    Route::post('/create', 'ArticleController@postCreate');
});