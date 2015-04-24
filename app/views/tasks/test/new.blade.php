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
    $(document).ready(function () {
        //var l = Ladda.create(document.getElementById('save'));
        $('#send').on('click', function () {
            return false;
        });

        $('.date').datetimepicker({
            language: 'sk'
        });

        $('#add').on('click', function () {
            $('#newQuestion').modal('show');
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
<button type="button" id="add" class="btn btn-default">Nová otázka</button>
{{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
{{ Form::close() }}

<div class="modal fade" id="newQuestion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nová otázka</h4>
            </div>
            <div class="modal-body" id="newQuestionBody">
                <form role="form">
                    <div class="form-group">
                        <label for="question" class="control-label">Nová otázka:</label>
                        <input class="form-control" id="question"></input>
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="type" id="textAnswer" value="text" checked> Voľná odpoveď
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" id="choice" value="choice"> Výber z možností
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="addNewQuestion" class="btn btn-default">Pridaj otázku</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>
@stop