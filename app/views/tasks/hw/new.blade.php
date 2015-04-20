@extends('tasks.task')

@section('header')
{{ HTML::style('css/font-awesome.min.css') }}
{{ HTML::style('css/summernote.css') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
{{ HTML::script('js/summernote.min.js') }}
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}

<script>
    $(document).ready(function () {
        //var l = Ladda.create(document.getElementById('save'));
        $('.summernote').summernote({
            height: '150px'
        });

        $('#send').on('click', function () {
            if ($('.summernote').code()) {
                $('[name=text]').val($('.summernote').code());
                return true;
            }
            return false;
        });
    });
</script>
@stop

@section('middle')
{{ Form::open(array('action' => 'HomeworkController@postCreate', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}

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
    <div class="col-md-12">
        <div class="summernote">

        </div>
    </div>
</div>
{{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
{{ Form::close() }}
@stop