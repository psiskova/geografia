@extends('tasks.task')

@section('header')
{{ HTML::style('css/font-awesome.min.css') }}
{{ HTML::style('css/summernote.css') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
{{ HTML::script('js/summernote.min.js') }}
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}
<style>
    .glyphicon-refresh-animate {
        -animation: spin .7s infinite linear;
        -webkit-animation: spin2 .7s infinite linear;
    }

    @-webkit-keyframes spin2 {
        from { -webkit-transform: rotate(0deg);}
        to { -webkit-transform: rotate(360deg);}
    }

    @keyframes spin {
        from { transform: scale(1) rotate(0deg);}
        to { transform: scale(1) rotate(360deg);}
    }

    dd{
        word-wrap: break-word;
    }

    .panel-heading a:after {
        font-family:'Glyphicons Halflings';
        content:"\e114";
        float: right;
        color: grey;
    }

    .collapsed > a:after {
        -webkit-transform: rotate(-90deg); 
        -moz-transform: rotate(-90deg); 
        -ms-transform: rotate(-90deg); 
        -o-transform: rotate(90deg); 
        transform: rotate(-90deg);
    }
</style>
@stop

@section('middle')
<h3 style="margin-bottom: 0; text-align: center">{{{ $task->name }}}</h3>
<br>
<br>
<div class="panel panel-default noselect">
    <div class="panel-heading" data-toggle="collapse" data-target="#collapseOne">
        <a href="javascript:void(0);">{{{ $task->name }}} {{{ Carbon::parse($task->stop)->format('d.m.Y H:m') }}}</a>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            {{ $class->text }}
        </div>
    </div>
</div>

<h3>Text</h3>
{{ Form::open(array('action' => 'HomeworkController@save', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
{{ Form::hidden('homework_id', $class->id) }}
{{ Form::hidden('text', '') }}
<div class="form-group">
    <div class="col-md-12">
        @if(isset($disabled))
            {{ $text }}
        @else
        <div class="summernote">

        </div>
        @endif
    </div>
</div>
@if(!isset($disabled))
{{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
@endif
{{ Form::close() }}
@stop