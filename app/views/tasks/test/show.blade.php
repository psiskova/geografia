@extends('tasks.task')

@section('middle')
<h3 style="margin-bottom: 0; text-align: center">{{{ $task->name }}}</h3>
<br>
<i>{{{ $task->stop }}}</i>
<br>
{{ $->text }}
@stop