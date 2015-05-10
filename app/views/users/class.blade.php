@extends('users.user')
@section('header')
<script>
    $(document).ready(function () {
        var id;
        
        $('.editClass').on('click', function () {
            id = $(this).attr('data-id');
            $.ajax({
                'method': 'post',
                'url': '{{ action("UserController@getClass") }}',
                'dataType': 'json',
                'data': {
                    'id': id
                },
                'success': function (result) {
                    $('#classText').val(result.name);
                    $('#changeClass').modal('show');
                }
            });
        });
        
        $('.addClass').on('click', function () {
            $('#changeClass').modal('show');
            $('#classText').val('');
            id = '';
        });
        
        $('#classText').on('keypress', function (e) {
            if (e.keyCode === 13) {
                $('#save').trigger('click');
                return false;
            }
        });

        $('#save').on('click', function () {
            if (!$('#classText').val()) {
                return false;
            }
            $.ajax({
                'method': 'post',
                'url': '{{ action("UserController@postCreateClass") }}',
                'dataType': 'json',
                'data': {
                    'id': id,
                    'name': $('#classText').val()
                },
                'success': function (result) {
                    $('#changeClass').modal('hide');
                    if (id) {
                        $('.editClass[data-id=' + id + ']').closest('tr').find('a').text(result.name);
                    } else {
                        document.location.href = document.location.href;
                    }
                }
            });
        });

    });
</script>
@stop

@section('middle')
<h3>Zoznam tried</h3>
<br>
<button type="button" class="btn btn-default addClass" >
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
</button>
<br><br>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Názov</th>
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
                <button type="button" class="btn btn-default editClass" data-id="{{$class->id}}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                {{ Form::open(array('action' => 'UserController@postDeleteClass', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default removeClass" data-id="{{$class->id}}" value="{{$class->id}}" name="id">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="changeClass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Názov triedy</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="classText" class="control-label">Názov triedy:</label>
                        <input type="text" class="form-control" id="classText">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save">Uložiť</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>
@stop
