@extends('layouts.2_9')

@section('left')
<ul class="nav nav-pills nav-stacked">
    <li role="presentation">{{ HTML::linkAction('TaskController@showActual', 'Aktuálne zadania', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation"><a href="#" class="nav nav-pills nav-stacked">Všetky zadania</a></li>
    <li role="presentation"><a href="#" class="nav nav-pills nav-stacked">Nové zadanie</a></li>
    <li role="presentation"><a href="#" class="nav nav-pills nav-stacked">Správa úloh</a></li>
    <li role="presentation"><a href="#" class="nav nav-pills nav-stacked">Správa testov</a></li>
</ul>
@stop