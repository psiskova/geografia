@extends('articles.article')

@section('middle')
<h4>Nehodnotené články:</h4> 
@foreach($sentArticles as $sentArticle)
{{ HTML::linkAction('ArticleController@show', $sentArticle->caption, array('id' => $sentArticle->id), array()) }}
<br>
@endforeach
<br>
<h4>Publikované články:</h4> 
@foreach($acceptedArticles as $acceptedArticle)
{{ HTML::linkAction('ArticleController@show', $acceptedArticle->caption, array('id' => $acceptedArticle->id), array()) }}
<br>
@endforeach
@stop

