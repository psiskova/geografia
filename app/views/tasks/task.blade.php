@extends('layouts.2_9')

@section('left')
<ul class="nav nav-pills nav-stacked">
    <li role="presentation">{{ HTML::linkAction('TaskController@showActual', 'Aktuálne zadania', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('TaskController@showAll', 'Všetky zadania', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    @if(Auth::user()->admin > 0)
    <li role="presentation">{{ HTML::linkAction('HomeworkController@getCreate', 'Nová úloha', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('HomeworkController@manage', 'Správa úloh', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('QuestionController@getCreate', 'Nový test', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('QuestionController@manage', 'Správa testov', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    @endif
</ul>
@stop