@extends('tasks.task')

@section('header')
{{ HTML::style('css/font-awesome.min.css') }}
{{ HTML::style('css/summernote.css') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
{{ HTML::script('js/summernote.min.js') }}
{{ HTML::script('js/moment.min.js') }}
{{ HTML::script('js/locales.min.js') }}
{{ HTML::script('js/datepicker.min.js') }}
{{ HTML::style('css/datepicker.min.css') }}
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}

<script>
    $(document).ready(function () {
        //var l = Ladda.create(document.getElementById('save'));
        $('.summernote').summernote({
            height: '150px'
        });
//TODO overit datumy a spol
        $('#send').on('click', function () {
            if ($('.summernote').code()) {
                $('[name=text]').val($('.summernote').code());
                return true;
            }
            return false;
        });

        $('.date').datetimepicker({
            language: 'sk'
        });

        @if (isset($task))
            $.ajax({
                'url': '{{ action("HomeworkController@getText") }}',
                'method': 'post',
                'data': {
                    'id': {{ $task->id }}
                },
                'dataType': 'json',
                'success': function(result){
                    $('.summernote').code(result.text);
                }
            });
        @endif
    });
</script>
@stop

@section('middle')
{{ Form::open(array('action' => 'HomeworkController@postCreate', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}

{{ Form::hidden('text', '') }}
{{ Form::hidden('id', isset($task->id) ? $task->id : '') }}
<div class="form-group">
    <label for="name" class="col-md-2 control-label" style="text-align:left">Názov</label>
    <div class="col-md-10">
        <input type="text" id="name" class="form-control" name="name" value="{{{ $task->name or '' }}}">
    </div>
</div>
<div class="form-group">
    <label for="class_id" class="col-md-2 control-label" style="text-align:left">Trieda</label>
    <div class="col-md-10">
        <select class="form-control" id="class_id" name="class_id">
            @foreach(Classs::all() as $class)
            <option value="{{ $class->id }}" @if(isset($task) && $task->class_id == $class->id) selected @endif>{{{ $class->name }}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="class" class="col-md-2 control-label" style="text-align:left">Začiatok</label>
    <div class="col-md-3">
        <div class="input-group date">
            <input type="text" class="form-control" placeholder="" id="start" name="start" value="@if(isset($task)){{{Carbon::parse($task->start)->format('d.m.Y H:m') }}}@endif">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <label for="class" class="col-md-2 col-md-offset-2 control-label" style="text-align:left">Koniec</label>
    <div class="col-md-3">
        <div class="input-group date">
            <input type="text" class="form-control" placeholder="" id="stop" name="stop" value="@if(isset($task)){{{Carbon::parse($task->stop)->format('d.m.Y H:m') }}}@endif">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="points" class="col-md-2 control-label" style="text-align:left">Body</label>
    <div class="col-md-3">
        <input type="text" id="points" class="form-control" name="points" value="@if(isset($task)) {{{ $task->getObj()->points }}} @endif">
    </div>
</div>
<br><b>Zadanie:</b>
<div class="form-group">
    <div class="col-md-12">
        <div class="summernote">

        </div>
    </div>
</div>
{{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
{{ Form::close() }}
@stop