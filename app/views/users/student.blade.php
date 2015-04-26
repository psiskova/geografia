@extends('users.user')
@section('middle')
<h3>Zoznam žiakov</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Meno</th>
            <th class="text-center">Trieda</th>
            <th class="text-center">Povoliť užívateľa</th>
            <th class="text-center">Blokovať užívateľa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>
                {{{ $student->fullName() }}}
            </td>
            <td>
                {{{ Classs::find(Student::where('user_id', '=', $student->id)->first()->class_id)->name or ''}}}
            </td>
            <td>
                <button type="button" class="btn btn-default unbanStudent" data-id="{{$student->id}}">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default banStudent" data-id="{{$student->id}}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
