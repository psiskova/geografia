@extends('tasks.task')

@section('middle')
<h3>{{{ $task->name }}}</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Meno žiaka</th>
            <th class="text-center">Trieda</th>
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
                
            </td>
            <td>
                {{{ Carbon::parse($user->created_at)->format('d.m.Y H:m') }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop