@extends('tasks.task')

@section('middle')
<h3>{{{ $task->name }}}</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Meno žiaka</th>
            <th class="text-center">Trieda</th>
            <th class="text-center">Riešenie</th>
            <th class="text-center">Body</th>
            <th class="text-center">Odoslané</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                {{ User::find($user->user_id)->fullName() }}
            </td>
            <td>
                {{{ $task->classs->name }}}
            </td>
            <td>
                <a href="{{ action('QuestionController@showSolution', array('task_id' => $task->id, 'user_id' => $user->user_id )) }}">
                    <button type="button" class="btn btn-default showSolution" data-id="{{$user->user_id}}">
                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                    </button>
                </a>
            </td>
            <td>
                {{{ (Point::where('task_id', '=', $task->id)->where('user_id', '=', $user->user_id)->first()->points) .  ' / ' . $task->points }}}
            </td>
            <td>
                {{{ Carbon::parse($user->created_at)->format('d.m.Y H:m') }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop