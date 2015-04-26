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
{{ Form::open(array('action' => 'QuestionController@save', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
<div class="form-group">
    <div class="col-md-12">
        <ol>
            @foreach(Question::where('task_id', '=', $task->id)->get() as $question)
            <li><strong>{{{ $question->text }}}</strong>
                <ul class="list-unstyled" style="margin-bottom: 15px">
                    @if($question->type == Question::CHOICE)
                    @foreach(CorrectAnswer::where('question_id', '=', $question->id)->get() as $answer)
                    <div class="checkbox" style="padding: 0; min-height: 0">
                        <label>
                            @if(isset($disabled))
                            <input type="checkbox" {{ count(StudentAnswer::where('user_id', '=', Auth::id())->where('question_id', '=', $question->id)->where('answer_id', '=', $answer->id)->get()) > 0 ? 'checked' : '' }} disabled> {{{ $answer->text }}}{{ (count(StudentAnswer::where('user_id', '=', Auth::id())->where('question_id', '=', $question->id)->where('answer_id', '=', $answer->id)->get()) > 0) ? ($answer->isCorrect() ? ' Správna odpoveď' : ' Nesprávna odpoveď') : (!$answer->isCorrect() ? ' Správna odpoveď' : ' Nesprávna odpoveď') }}
                            @else
                            <input type="checkbox" name="{{{ $question->id }}}[]" value="{{{ $answer->id }}}"> {{{ $answer->text }}}
                            @endif
                        </label>
                    </div>
                    @endforeach
                    @else
                    @if(isset($disabled))
                    {{{ StudentAnswer::where('user_id', '=', Auth::id())->where('question_id', '=', $question->id)->first()->text }}}
                    @else
                    <textarea class="form-control" rows="5"  name="{{{ $question->id }}}"></textarea>
                    @endif
                    @endif
                </ul>
            </li>
            @endforeach
        </ol>
    </div>
</div>
@if(!isset($disabled))
{{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
@endif
{{ Form::close() }}
@stop