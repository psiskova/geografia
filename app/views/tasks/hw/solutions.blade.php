@extends('tasks.task')

@section('middle')
<h3>{{{ $homework->task->name }}}</h3>
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
        @foreach($solutions as $solution)
        <tr>
            <td>
                {{ $solution->user->fullName() }}
            </td>
            <td>
                {{{ $homework->task->classs->name }}}
            </td>
            <td>
                <a href="{{ action('HomeworkController@showSolution', array('id' => $solution->id )) }}">
                    <button type="button" class="btn btn-default showSolution" data-id="{{$solution->id}}">
                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                    </button>
                </a>
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