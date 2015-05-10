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
Route::get('/register', 'LoginController@getRegister');
Route::post('/register', 'LoginController@postRegister');
Route::get('/logout', 'LoginController@getLogout');

Route::group(array('prefix' => 'section'), function() {
    Route::get('/{id}', 'ArticleController@showSection');
});

Route::group(array('prefix' => 'article'), function() {
    Route::get('/show/{id}', 'ArticleController@show');
    Route::group(array('before' => 'auth'), function() {
        Route::get('/drafts', 'ArticleController@showDrafts');
        Route::get('/sent', 'ArticleController@showSentArticles');
        Route::get('/accepted', 'ArticleController@showAcceptedArticles');
        Route::post('/create', 'ArticleController@postCreate');
        Route::get('/create/{id?}', 'ArticleController@getCreate');
        Route::post('/getArticle', 'ArticleController@getArticle');
        Route::post('/sending', 'ArticleController@postSendArticle');
        Route::post('/publishing', 'ArticleController@postPublishArticle');
        Route::post('/returning', 'ArticleController@postDontPublishArticle');
        Route::post('/deleting', 'ArticleController@postDeleteArticle');
        Route::post('/deletingDraft', 'ArticleController@postDeleteDraft');
        Route::post('/sendReview', 'ArticleController@postCreateReview');
        Route::post('/getReview', 'ArticleController@getReview');
    });
});

Route::group(array('prefix' => 'manage'), function() {
    Route::group(array('before' => 'teacher-or-admin'), function() {
        Route::get('/articles', 'ArticleController@showArticleManagement');
        Route::get('/sections', 'ArticleController@showSectionManagement');
        Route::post('/sections/deleting', 'ArticleController@postDeleteSection');
        Route::post('/sendReview', 'ArticleController@postCreateSection');
        Route::post('/getSection', 'ArticleController@getSection');
        Route::get('/homework', 'HomeworkController@manage');
        Route::post('/homework/delete', 'HomeworkController@delete');
        Route::get('/test', 'QuestionController@manage');
        Route::post('/test/delete', 'QuestionController@delete');
        Route::get('/students', 'UserController@showStudents');
        Route::get('/classes', 'UserController@showClasses');
        Route::get('/waiting', 'UserController@showWaiting');
        Route::post('/class/postCreate', 'UserController@postCreateClass');
        Route::post('/class/getClass', 'UserController@getClass');
        Route::post('/class/deleting', 'UserController@postDeleteClass');
        Route::post('/user/deleting', 'UserController@deleteUser');
        Route::post('/user/accepting', 'UserController@acceptUser');
    });
    Route::group(array('before' => 'admin'), function() {
        Route::get('/teachers', 'UserController@showTeachers');
    });
});

Route::group(array('prefix' => 'task'), function() {
    Route::get('/actual', 'TaskController@showActual');
    Route::get('/all', 'TaskController@showAll');
    Route::get('/show/{id}', 'TaskController@show');

    Route::group(array('prefix' => 'homework'), function() {
        Route::post('/save', 'HomeworkController@save');
        Route::get('/create/{id?}', 'HomeworkController@getCreate');
        Route::get('/getAllSolutions/{id}', 'HomeworkController@getAllSolutions');
        Route::post('/create', 'HomeworkController@postCreate');
        Route::post('/getText', 'HomeworkController@getText');
        Route::post('/addPoints', 'HomeworkController@addPoints');
        Route::get('/show/solution{id}', 'HomeworkController@showSolution');
    });
    Route::group(array('prefix' => 'tests'), function() {
        Route::post('/save', 'QuestionController@save');
        Route::get('/create/{id?}', 'QuestionController@getCreate');
        Route::post('/create', 'QuestionController@postCreate');
        Route::get('/getAllSolutions/{id}', 'QuestionController@getAllSolutions');
        Route::post('/loadData', 'QuestionController@loadData');
    });
});

Route::group(array('prefix' => 'class'), function() {
    Route::get('/{id}', 'UserController@showClass');
});
