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
        </tr>
    </thead>
    <tbody>
        @foreach($hw as $h)
        <tr>
            <td>
                {{ HTML::linkAction('TaskController@show', $h->name, array('id' => $h->id), array()) }}
            </td>
            <td>
                <a href="#">{{Classs::find($h->class_id)->name}}</a>
            </td>
            <td>
                <button type="button" class="btn btn-default editTask" data-id="{{$h->id}}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default showSolutions" data-id="{{$h->id}}">
                    <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                {{{ Carbon::parse($h->start)->format('d.m.Y H:m') }}}
            </td>
            <td>
                {{{ Carbon::parse($h->stop)->format('d.m.Y H:m') }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop