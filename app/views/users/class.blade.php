@extends('users.user')
@section('middle')
<h3>Zoznam tried</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Názov</th>
            <th class="text-center">Rok</th>
            <th class="text-center">Upraviť</th>
            <th class="text-center">Zmazať triedu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $class)
        <tr>
            <td>
                {{ HTML::linkAction('UserController@showClass', $class->name, array('id' => $class->id), array()) }}
            </td>
            <td>
                {{{ $class->year }}}
            </td>
            <td>
                <button type="button" class="btn btn-default unbanStudent" data-id="{{$class->id}}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default banStudent" data-id="{{$class->id}}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
