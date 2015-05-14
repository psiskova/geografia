@extends('users.user')
@section('header')
<script>
    $(document).ready(function () {
        $('.user_role').on('change', function () {
            var user_id = $(this).attr('data-id');
            var user_role = $(this).val();
            $.ajax({
                'url': '{{ action("UserController@changeRole") }}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'user_id': user_id,
                    'user_role': user_role
                }
            });
        });
        
        $('.unbanTeacher').on('click', function () {
            var that = this;
            $.ajax({
                'url': '{{action("UserController@unbanTeacher")}}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'user_id': $(this).attr('data-id')
                },
                'success': function () {
                    $(that).attr({
                        'disabled': true
                    });
                    $('.banTeacher[data-id=' + $(that).attr('data-id') + ']').attr({
                        'disabled': false
                    });
                }
            });
        });
        
        $('.banTeacher').on('click', function () {
            var that = this;
            $.ajax({
                'url': '{{action("UserController@banTeacher")}}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'user_id': $(this).attr('data-id')
                },
                'success': function () {
                    $(that).attr({
                        'disabled': true
                    });
                    $('.unbanTeacher[data-id=' + $(that).attr('data-id') + ']').attr({
                        'disabled': false
                    });
                }
            });
        });

    });
</script>
@stop
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
                <select class="form-control user_role" name="user_role" data-id="{{$teacher->id}}">
                    <option value="1" @if(User::where('id', '=', $teacher->id)->first()->admin == 1) selected @endif>učiteľ</option>
                    <option value="2" @if(User::where('id', '=', $teacher->id)->first()->admin == 2) selected @endif>administrátor</option>
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-default unbanTeacher" @if(User::where('id', '=', $teacher->id)->first()->ban == 0) disabled @endif data-id="{{$teacher->id}}">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default banTeacher" @if(User::where('id', '=', $teacher->id)->first()->ban == 1) disabled @endif data-id="{{$teacher->id}}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
