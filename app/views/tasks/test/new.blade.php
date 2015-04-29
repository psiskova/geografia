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
<style>
    a{
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function () {
        //var l = Ladda.create(document.getElementById('save'));
        var selectedQuesion;

        var questions = [];

        var showAddAnswer = function () {
            $('#answer').val('');
            $('#newAnswer').modal('show');
        };

        var addAnswer = function (param) {
            $('[data-id=' + param.selectedQuesion + ']').before(function () {
                return $('<div />').attr({
                    'class': 'checkbox'
                }).append($('<label />').append($('<input />').attr({
                    'type': 'checkbox',
                    'checked': param.correct
                }).on('change', function () {
                    questions[param.selectedQuesion].answers[param.id].correct = $(this).is(':checked');
                })).append(function () {
                    return ' ' + param.text;
                }));
            });
        };

        var addQuestion = function (param) {
            if (param.type == 'text') {
                $('#questionList').append($('<li />').text(param.text).append(
                        function () {
                            return $('<span />').attr({
                                'class': 'glyphicon glyphicon-trash'
                            });
                        }
                ));
            } else {
                $('#questionList').append($('<li />').text(param.text + ' ').append(
                        function () {
                            return $('<span />').attr({
                                'class': 'glyphicon glyphicon-trash'
                            });
                        }
                ).append(
                        $('<ul />').attr({
                    'class': 'list-unstyled'
                }).append($('<li />').append(
                        $('<a />').attr({
                    'class': 'addAnswer',
                    'data-id': param.id
                }).on('click', function () {
                    selectedQuesion = $(this).attr('data-id');
                    showAddAnswer();
                }).html('<span class="glyphicon glyphicon-plus"></span> Pridaj odpoveď')))));
            }
        };

        $('#send').on('click', function () {
            console.log(questions);
            $.ajax({
                'url': "{{ action('QuestionController@postCreate') }}",
                'dataType': 'json',
                'data': {
                    'name': $('#name').val(),
                    'class_id': $('#class_id').val(),
                    'start': $('#start').val(),
                    'stop': $('#stop').val(),
                    'id': $('[name=id]').val(),
                    questions
                },
                'method': 'post',
                'success': function (result) {
                    console.log(result);
                }
            });
            return false;
        });

        $('.date').datetimepicker({
            language: 'sk'
        });

        $('#add').on('click', function () {
            $('#question').val('');
            $('#newQuestion').modal('show');
        });

        $('#addNewQuestion').on('click', function () {
            if ($('#question').val()) {
                var id = questions.length;
                questions.push({
                    'text': $('#question').val(),
                    'id': id,
                    'type': $('[name=type]:checked').val(),
                    'answers': []
                });
                addQuestion({
                    'text': $('#question').val(),
                    'type': $('[name=type]:checked').val(),
                    'id': id
                });
                $('#newQuestion').modal('hide');
            }
        });

        $('#addNewAnswer').on('click', function () {
            if ($('#answer').val()) {
                var id = questions[selectedQuesion].answers.length;
                questions[selectedQuesion].answers.push({
                    'text': $('#answer').val(),
                    'id': id,
                    'correct': false
                });
                addAnswer({
                    'text': $('#answer').val(),
                    'id': id,
                    'selectedQuesion': selectedQuesion
                });
                $('#newAnswer').modal('hide');
            }
        });
        
        
        @if(isset($task))
            $.ajax({
                'url': "{{ action('QuestionController@loadData') }}",
                'dataType': 'json',
                'data': {
                    'id': $('[name=id]').val()
                },
                'method': 'post',
                'success': function (result) {
                    result.forEach(function(val){
                        var id = questions.length;
                        var type = val.type == 2 ? 'choice' : 'text';
                        questions.push({
                            'text': val.text,
                            'id': id,
                            'type': type,
                            'answers': []
                        });
                        addQuestion({
                            'text': val.text,
                            'type': type,
                            'id': id
                        });
                        if(type == 'choice'){
                            val.answers.forEach(function(answer){
                                var answer_id = questions[id].answers.length;
                                questions[id].answers.push({
                                    'text': answer.text,
                                    'id': answer_id,
                                    'correct': answer.correct == 1 ? true : false
                                });
                                addAnswer({
                                    'text': answer.text,
                                    'id': answer_id,
                                    'selectedQuesion': id,
                                    'correct': answer.correct == 1 ? true : false
                                });
                            });
                        }
                    });
                }
            });
        @endif
    });
</script>
@stop

@section('middle')
{{ Form::open(array('action' => 'QuestionController@postCreate', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}

{{ Form::hidden('id', isset($task->id) ? $task->id : '') }}
<div class="form-group">
    <label for="name" class="col-md-2 control-label" style="text-align:left">Názov</label>
    <div class="col-md-10">
        <input type="text" id="name" name="name" class="form-control" value="{{{ $task->name or '' }}}">
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
    <label for="start" class="col-md-2 control-label" style="text-align:left">Začiatok</label>
    <div class="col-md-3">
        <div class="input-group date">
            <input type="text" class="form-control" placeholder="" id="start" name="start" value="@if(isset($task)){{{Carbon::parse($task->start)->format('d.m.Y H:m') }}}@endif">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <label for="stop" class="col-md-2 col-md-offset-2 control-label" style="text-align:left">Koniec</label>
    <div class="col-md-3">
        <div class="input-group date">
            <input type="text" class="form-control" placeholder="" id="stop" name="stop" value="@if(isset($task)){{{Carbon::parse($task->stop)->format('d.m.Y H:m') }}}@endif">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
</div>
<button type="button" id="add" class="btn btn-default">Nová otázka</button>
<div class="thumbnail" style="margin-top: 10px">
    <h3>Všetky otázky</h3>
    <ol id="questionList"></ol>
</div>
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

<div class="modal fade" id="newAnswer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nová odpoveď</h4>
            </div>
            <div class="modal-body" id="newQuestionBody">
                <form role="form">
                    <div class="form-group">
                        <label for="question" class="control-label">Nová odpoveď:</label>
                        <input class="form-control" id="answer"></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="addNewAnswer" class="btn btn-default">Pridaj odpoveď</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>
@stop