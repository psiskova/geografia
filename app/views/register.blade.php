@extends('layouts.master')

@section('content')
<div class="col-md-6 col-md-offset-3" style="margin-top: 5em">
    {{ Form::open(array('action' => 'LoginController@postRegister', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <div class="form-group thumbnail">
        <div class="form-group">
            <div class="col-md-3">
                {{ Form::label('name', 'Meno') }}
            </div>
            <div class="col-md-9">
                {{Form::input('text', 'name', '', array('class'=>'form-control', 'placeholder' => 'Meno'))}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                {{ Form::label('last_name', 'Priezvisko') }}
            </div>
            <div class="col-md-9">
                {{Form::input('text', 'last_name', '', array('class'=>'form-control', 'placeholder' => 'Priezvisko'))}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                {{ Form::label('email', 'Email') }}
            </div>
            <div class="col-md-9">
                {{Form::email('email', '', array('class'=>'form-control', 'placeholder' => 'Email'))}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                {{ Form::label('password', 'Heslo') }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password', array('class'=>'form-control', 'placeholder' => 'Heslo')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                {{ Form::label('password_again', 'Heslo znova') }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password_again', array('class'=>'form-control', 'placeholder' => 'Heslo')) }}
            </div>
        </div>
        {{Form::submit('Registruj', array('class'=>'btn btn-default'))}}
    </div>
    {{ Form::close() }}
</div>
@stop