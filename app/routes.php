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
    Route::get('/sent', 'ArticleController@showSentArticles');
    Route::get('/accepted', 'ArticleController@showAcceptedArticles');
    Route::post('/create', 'ArticleController@postCreate');
    Route::post('/getArticle', 'ArticleController@getArticle');
    Route::post('/sending', 'ArticleController@postSendArticle');
    Route::post('/publishing', 'ArticleController@postPublishArticle');
    Route::post('/returning', 'ArticleController@postDontPublishArticle');
    Route::post('/deleting', 'ArticleController@postDeleteArticle');
    Route::post('/deletingDraft', 'ArticleController@postDeleteDraft');
    Route::post('/sendReview', 'ArticleController@postCreateReview');
    Route::post('/getReview', 'ArticleController@getReview');
});

Route::group(array('prefix' => 'manage'), function() {
    Route::get('/articles', 'ArticleController@showArticleManagement');
    Route::get('/sections', 'ArticleController@showSectionManagement');
    Route::post('/sections/deleting', 'ArticleController@postDeleteSection');
    Route::post('/sendReview', 'ArticleController@postCreateSection');
    Route::post('/getSection', 'ArticleController@getSection');
});
