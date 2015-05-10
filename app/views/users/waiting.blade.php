@extends('users.user')

@section('header')
<script>
    $(document).ready(function () {
        $('.user_role').on('change', function(){
            $('.class_id[data-id=' + $(this).attr('data-id') + ']').attr({'disabled': $(this).val() !== '0'});
        });
    });
</script>
@stop
@section('middle')
<h3>Zoznam čakajúcich na schválenie</h3>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Meno</th>
            <th class="text-center">Administrátor</th>
            <th class="text-center">Trieda</th>
            <th class="text-center">Povoliť užívateľa</th>
            <th class="text-center">Zmazať užívateľa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registered as $r)
        <tr>
            {{ Form::open(array('action' => 'UserController@acceptUser', 'method' => 'post')) }}
            <td>
                {{{ $r->fullName() }}}
            </td>
            <td>
                <select class="form-control user_role" name="user_role" data-id="{{$r->id}}">
                    <option value="0">študent</option>
                    <option value="1">učiteľ</option>
                    <option value="2">administrátor</option>
                </select>
            </td>
            <td>
                <select class="form-control class_id" name="class_id" data-id="{{$r->id}}">
                    @foreach(Classs::all() as $class)
                    <option value="{{ $class->id }}">{{{ $class->name }}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <button type="submit" class="btn btn-default acceptUser" data-id="{{$r->id}}" value="{{$r->id}}" name="id">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </td>
            {{ Form::close() }}
            <td>
                {{ Form::open(array('action' => 'UserController@deleteUser', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default banTeacher" data-id="{{$r->id}}" value="{{$r->id}}" name="id">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
