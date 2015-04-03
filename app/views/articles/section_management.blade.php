@extends('articles.article')

@section('middle')
<h4>Rubriky:</h4> 
@foreach($sections as $section)
{{ HTML::linkAction('ArticleController@showSection', $section->name, array($section->id), array()) }}
<br>
@endforeach
@stop