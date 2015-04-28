@extends('layouts.2_9')

@section('left')
<ul class="nav nav-pills nav-stacked">
    <li role="presentation">{{ HTML::linkAction('UserController@showStudents', 'Žiaci', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('UserController@showClasses', 'Triedy', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('UserController@showTeachers', 'Učitelia', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
    <li role="presentation">{{ HTML::linkAction('UserController@showWaiting', 'Neschválení', array(), array('class' => 'nav nav-pills nav-stacked')) }}</li> 
</ul>
@stop