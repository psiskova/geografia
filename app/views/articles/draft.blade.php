@extends('articles.article')

@section('middle')
@foreach($drafts as $draft)
{{ HTML::linkAction('ArticleController@getCreate', $draft->caption, array('id' => $draft->id), array()) }}
@endforeach
@stop