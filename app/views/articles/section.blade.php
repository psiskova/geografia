@extends('articles.article')

@section('middle')
@foreach($articlesInSection as $articleInSection)
{{ HTML::linkAction('ArticleController@show', $articleInSection->caption, array('id' => $articleInSection->id), array()) }}
<br>
@endforeach
@stop

