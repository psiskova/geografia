@extends('articles.article')

@section('middle')
@foreach ($articles as $article) 
{{{ $article->caption }}}
<br>
{{{ $article->user->fullName() }}}
<br>
{{ $article->text }}
@endforeach
@stop