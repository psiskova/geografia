@extends('tasks.task')

@section('middle')
<h3>Aktuálne zadania</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Názov úlohy</th>
            <th class="text-center">Body</th>
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
                @if($task->isHomework())
                @if(Solution::where('user_id', '=', Auth::id())->where('homework_id', '=',  $task->getObj()->id)->first())
                {{Solution::where('user_id', '=', Auth::id())->where('homework_id', '=',  $task->getObj()->id)->first()->points . 
                            ' / ' . $task->getObj()->points}}
                @else
                {{ '0 / ' . $task->getObj()->points}}
                @endif
                @else
                {{{ (Point::where('task_id', '=', $task->id)->where('user_id', '=', Auth::id())->first() ? Point::where('task_id', '=', $task->id)->where('user_id', '=', Auth::id())->first()->points : '0') . ' / '. $task->points }}}
                @endif
            </td>
            <td>
                {{{ Carbon::parse($task->stop)->format('d.m.Y H:m') }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop