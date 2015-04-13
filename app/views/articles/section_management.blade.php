@extends('articles.article')

@section('header')
<script>
    $(document).ready(function () {
        var id;
        $('.editSection').on('click', function () {
            id = $(this).attr('data-id');
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@getSection") }}',
                'dataType': 'json',
                'data': {
                    'id': id
                },
                'success': function (result) {
                    $('#sectionText').val(result.name);
                    $('#changeSection').modal('show');
                }
            });
        });

        $('.addSection').on('click', function () {
            $('#changeSection').modal('show');
            $('#sectionText').val('');
            id = '';
        });

        $('#sectionText').on('keypress', function (e) {
            if (e.keyCode === 13) {
                $('#save').trigger('click');
                return false;
            }
        });

        $('#save').on('click', function () {
            if (!$('#sectionText').val()) {
                return false;
            }
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@postCreateSection") }}',
                'dataType': 'json',
                'data': {
                    'id': id,
                    'name': $('#sectionText').val()
                },
                'success': function (result) {
                    $('#changeSection').modal('hide');
                    if (id) {
                        $('.editSection[data-id=' + id + ']').closest('tr').find('a').text(result.name);
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
<h4>Rubriky:</h4> 
<br>
<button type="button" class="btn btn-default addSection" >
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
</button>
<br><br>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Názov rubriky</th>
            <th class="text-center">Upraviť názov rubriky</th>
            <th class="text-center">Zmazať rubriku</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sections as $section)
        <tr>
            <td>
                {{ HTML::linkAction('ArticleController@showSection', $section->name, array('id' => $section->id), array()) }}
            </td>
            <td>
                <button type="button" class="btn btn-default editSection" data-id="{{$section->id}}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                {{ Form::open(array('action' => 'ArticleController@postDeleteSection', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default delete" data-id="{{$section->id}}" value="{{$section->id}}" name="id">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="changeSection" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Názov rubriky</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="sectionText" class="control-label">Názov rubriky:</label>
                        <input type="text" class="form-control" id="sectionText">
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