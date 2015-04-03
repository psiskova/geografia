@extends('articles.article')

@section('middle')
<h4>Odoslané články</h4>
@foreach($sentArticles as $sent)
{{ HTML::linkAction('ArticleController@show', $sent->caption, array('id' => $sent->id), array()) }}
<br>
@endforeach
@stop
