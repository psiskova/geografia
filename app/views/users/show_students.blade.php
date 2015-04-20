@extends('users.user')
@section('middle')
<h3>{{{Classs::find($id)->name}}}</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Meno</th>
        </tr>
    </thead>
    <tbody>
        @foreach($studentsInClass as $student)
        <tr>
            <td>
                {{{ User::find($student->user_id)->fullName() }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
