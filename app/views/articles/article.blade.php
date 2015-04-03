@extends('layouts.2_7_3')

@section('left')
<ul class="nav nav-pills nav-stacked">
    @if(in_array(Route::currentRouteAction(), ['ArticleController@showHome', 'ArticleController@show', 'ArticleController@showSection', 'HomeController@showWelcome'])) 
    @foreach(Section::all() as $section)
    <li role="presentation">{{ HTML::linkAction('ArticleController@showSection', $section->name, array($section->id), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    @endforeach
    @else
    <li role="presentation">{{ HTML::linkAction('ArticleController@getCreate', 'Nový článok', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation">{{ HTML::linkAction('ArticleController@showDrafts', 'Koncepty', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation">{{ HTML::linkAction('ArticleController@showSentArticles', 'Odoslané články', array(1), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation">{{ HTML::linkAction('ArticleController@showAcceptedArticles', 'Publikované články', array(1), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation">{{ HTML::linkAction('ArticleController@showArticleManagement', 'Správa článkov', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation">{{ HTML::linkAction('ArticleController@showSectionManagement', 'Správa rubrík', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    @endif
</ul>
@stop