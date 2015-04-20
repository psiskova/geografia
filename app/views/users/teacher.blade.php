@extends('users.user')
@section('middle')
<h3>Zoznam učiteľov</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Meno</th>
            <th class="text-center">Administrátor</th>
            <th class="text-center">Povoliť užívateľa</th>
            <th class="text-center">Blokovať užívateľa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
        <tr>
            <td>
                {{{ $teacher->fullName() }}}
            </td>
            <td>
                {{{ $teacher->admin }}}
            </td>
            <td>
                <button type="button" class="btn btn-default unbanTeacher" data-id="{{$teacher->id}}">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default banTeacher" data-id="{{$teacher->id}}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
