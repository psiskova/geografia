@extends('layouts.2_7_3')

@section('left')
<ul class="nav nav-pills nav-stacked">
    @if(in_array(Route::currentRouteAction(), ['ArticleController@showHome', 'HomeController@showWelcome'])) 
    @foreach(Section::all() as $section)
    <li role="presentation">{{ HTML::linkAction('ArticleController@showHome', $section->name, array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    @endforeach
    @else
    <li role="presentation" class="active">{{ HTML::linkAction('ArticleController@getCreate', 'Nový článok', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation">{{ HTML::linkAction('ArticleController@showDrafts', 'Koncepty', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li>
    <li role="presentation"><a href="#">Odoslané články</a></li>
    <li role="presentation"><a href="#">Publikované články</a></li>
    @endif
</ul>
@stop