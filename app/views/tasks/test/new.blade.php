@extends('tasks.task')

@section('header')
{{ HTML::style('css/font-awesome.min.css') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
{{ HTML::script('js/moment.min.js') }}
{{ HTML::script('js/locales.min.js') }}
{{ HTML::script('js/datepicker.min.js') }}
{{ HTML::style('css/datepicker.min.css') }}
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}

<script>
    $(document).ready(function() {
        //var l = Ladda.create(document.getElementById('save'));
        $('#send').on('click', function() {
            return false;
        });

        $('.date').datetimepicker({
            language: 'sk'
        });
    });
</script>
@stop

@section('middle')
{{ Form::open(array('action' => 'QuestionController@postCreate', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}

{{ Form::hidden('text', '') }}
<div class="form-group">
    <label for="caption" class="col-md-2 control-label" style="text-align:left">Názov</label>
    <div class="col-md-10">
        <input type="text" id="caption" class="form-control">
    </div>
</div>
<div class="form-group">
    <label for="class" class="col-md-2 control-label" style="text-align:left">Trieda</label>
    <div class="col-md-10">
        <select class="form-control" id="id">
            @foreach(Classs::all() as $class)
            <option value="{{ $class->id }}">{{{ $class->name }}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="class" class="col-md-2 control-label" style="text-align:left">Začiatok</label>
    <div class="col-md-3">
        <div class="input-group date">
            <input type="text" class="form-control" placeholder="" maxlength="10" id="start">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <label for="class" class="col-md-2 col-md-offset-2 control-label" style="text-align:left">Koniec</label>
    <div class="col-md-3">
        <div class="input-group date">
            <input type="text" class="form-control" placeholder="" maxlength="10" id="start">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
</div>
{{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
{{ Form::close() }}
@stop