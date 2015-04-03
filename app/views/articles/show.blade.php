@extends('articles.article')

@section('middle')
@if(in_array(Route::currentRouteAction(), ['ArticleController@show'])) 
<h3 style="margin-bottom: 0; text-align: center">{{{ $article->caption }}}</h3>
<br>
<i>{{{ $article->user->fullName() }}}</i>
<br>

<i>{{{ $article->updated_at }}}</i>
<br>
{{ $article->text }}
<br>
@else
@foreach ($articles as $article)
<div style="border-bottom: 1px solid black">
<h3 style="margin-bottom: 0; text-align: center">{{ HTML::linkAction('ArticleController@show', $article->caption, array('id' => $article->id), array()) }}</h3>
<br>
<i>{{{ $article->user->fullName() }}}</i>
<br>

<i>{{{ $article->updated_at }}}</i>
<br>
{{ $article->text }}
<br></div>
@endforeach
@endif
@stop