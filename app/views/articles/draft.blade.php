@extends('articles.article')

@section('middle')
<h4>Rozpísané články</h4>
@foreach($drafts as $draft)
{{ HTML::linkAction('ArticleController@getCreate', $draft->caption, array('id' => $draft->id), array()) }}
<br>
@endforeach
@stop