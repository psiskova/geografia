@extends('tasks.task')

@section('middle')
<h3>Správa úloh</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Názov úlohy</th>
            <th class="text-center">Trieda</th>
            <th class="text-center">Upraviť</th>
            <th class="text-center">Riešenia</th>
            <th class="text-center">Štart</th>
            <th class="text-center">Deadline</th>
            <th class="text-center">Zmazať</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>
                {{{ $task->name }}}
            </td>
            <td>
                <a href="#">{{Classs::find($task->class_id)->name}}</a>
            </td>
            <td>
                <a href="{{ action('HomeworkController@getCreate', array('id' => $task->id )) }}">
                    <button type="button" class="btn btn-default editTask" data-id="{{$task->id}}">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </a>
            </td>
            <td>
                <a href="{{ action('HomeworkController@getAllSolutions', array('id' => Homework::where('task_id', '=', $task->id)->first()->id )) }}">
                    <button type="button" class="btn btn-default" data-id="{{$task->id}}">
                        <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                    </button>
                </a>
            </td>
            <td>
                {{{ Carbon::parse($task->start)->format('d.m.Y H:m') }}}
            </td>
            <td>
                {{{ Carbon::parse($task->stop)->format('d.m.Y H:m') }}}
            </td>
            <td>
                {{ Form::open(array('action' => 'HomeworkController@delete', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default delete" data-id="{{$task->id}}" value="{{$task->id}}" name="id">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop