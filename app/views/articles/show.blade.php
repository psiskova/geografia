@extends('articles.article')

@section('middle')
    {{{ $article->text }}}
    <br>
    {{{ $article->caption }}}
    <br>
    {{{ $article->user->fullName() }}}
    <br>
    
@stop