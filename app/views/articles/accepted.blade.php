@extends('articles.article')

@section('middle')
<h4>Publikované články</h4>
@foreach($acceptedArticles as $accepted)
{{ HTML::linkAction('ArticleController@show', $accepted->caption, array('id' => $accepted->id), array()) }}
<br>
@endforeach
@stop