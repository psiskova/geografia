@extends('tasks.task')

@section('middle')
<h3>Aktuálne zadania</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Názov úlohy</th>
            <th class="text-center">Deadline</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>
                {{ HTML::linkAction('TaskController@show', $task->name, array('id' => $task->id), array()) }}
            </td>
            <td>
                {{{ Carbon::parse($task->stop)->format('d.m.Y H:m') }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop