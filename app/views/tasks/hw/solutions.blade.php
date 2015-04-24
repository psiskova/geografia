@extends('tasks.task')

@section('middle')
<h3>{{{ $homework->task->name }}}</h3>
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
        @foreach($solutions as $solution)
        <tr>
            <td>
                {{ $solution->user->fullName() }}
            </td>
            <td>
                {{{ $homework->task->classs->name }}}
            </td>
            <td>
                {{ $solution->points . ' / ' . $homework->points }}
            </td>
            <td>
                {{{ Carbon::parse($solution->created_at)->format('d.m.Y H:m') }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop