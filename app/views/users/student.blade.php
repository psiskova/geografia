@extends('users.user')

@section('header')
<script>
    $(document).ready(function () {
        $('.class_id').on('change', function () {
            var user_id = $(this).attr('data-id');
            var class_id = $(this).val();
            $.ajax({
                'url': '{{ action("UserController@changeClass") }}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'user_id': user_id,
                    'class_id': class_id
                }
            });
        });

        $('.unbanStudent').on('click', function () {
            var that = this;
            $.ajax({
                'url': '{{action("UserController@unbanStudent")}}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'user_id': $(this).attr('data-id')
                },
                'success': function () {
                    $(that).attr({
                        'disabled': true
                    });
                    $('.banStudent[data-id=' + $(that).attr('data-id') + ']').attr({
                        'disabled': false
                    });
                }
            });
        });

        $('.banStudent').on('click', function () {
            var that = this;
            $.ajax({
                'url': '{{action("UserController@banStudent")}}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'user_id': $(this).attr('data-id')
                },
                'success': function () {
                    $(that).attr({
                        'disabled': true
                    });
                    $('.unbanStudent[data-id=' + $(that).attr('data-id') + ']').attr({
                        'disabled': false
                    });
                }
            });
        });
    });
</script>
@stop

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
                <select class="form-control class_id" name="class_id" data-id="{{$student->id}}">
                    @foreach(Classs::all() as $class)
                    <option value="{{ $class->id }}" @if(Student::where('user_id', '=', $student->id)->first()->class_id == $class->id) selected @endif>{{{ $class->name }}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-default unbanStudent" @if(User::where('id', '=', $student->id)->first()->ban == 0) disabled @endif data-id="{{$student->id}}">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default banStudent" @if(User::where('id', '=', $student->id)->first()->ban == 1) disabled @endif data-id="{{$student->id}}">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
