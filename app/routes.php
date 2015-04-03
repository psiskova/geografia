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

Route::get('/', 'ArticleController@showHome');
Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');

Route::group(array('prefix' => 'section'), function() {
    Route::get('/{id}', 'ArticleController@showSection');
});

Route::group(array('prefix' => 'article'), function() {
    Route::get('/show/{id}', 'ArticleController@show');
    Route::get('/create/{id?}', 'ArticleController@getCreate');
    Route::get('/drafts', 'ArticleController@showDrafts');
    Route::get('/sent/{id?}', 'ArticleController@showSentArticles');
    Route::get('/accepted/{id?}', 'ArticleController@showAcceptedArticles');
    Route::post('/create', 'ArticleController@postCreate');
    Route::post('/kebab', 'ArticleController@getArticle');
});

Route::group(array('prefix' => 'manage'), function() {
    Route::get('/articles', 'ArticleController@showArticleManagement');
    Route::get('/sections', 'ArticleController@showSectionManagement');
});
