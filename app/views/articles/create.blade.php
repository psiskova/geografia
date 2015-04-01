@extends('articles.article')

@section('header')
{{ HTML::style('css/font-awesome.min.css') }}
{{ HTML::style('css/summernote.css') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
{{ HTML::script('js/summernote.min.js') }}
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}
<script>
    $(document).ready(function () {
        var l = Ladda.create(document.getElementById('save'));
        function save() {
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@postCreate") }}',
                'dataType': 'json',
                'data': {
                    'caption': $('#caption').val(),
                    'section_id': $('#section_id').val(),
                    'text': $('.summernote').code()
                },
                'success': function (result) {
                    for (var key in result) {
                        $('#' + key).closest('.form-group').addClass('has-error');
                    }
                }
            }).always(function () {
                l.stop();
            });
        }

        $('.summernote').summernote({
            height: 150
        });

        $('#save').on('click', function () {
            $('.has-error').removeClass('has-error');
            l.start();
            save();
            return false;
        });

    });
</script>
@stop

@section('middle')
<form class="form-horizontal">
    <div class="form-group">
        <label for="caption" class="col-md-3 control-label">Nadpis</label>
        <div class="col-md-9">
            <input type="text" id="caption" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="section_id" class="col-md-3 control-label">Rubrika</label>
        <div class="col-md-9">
            <select class="form-control" id="section_id">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Text</label>
        <div class="col-md-9">
            <div class="summernote">

            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-3 col-md-9">
            <button id="save" class="btn btn-primary ladda-button pull-right" data-style="expand-left">
                <span class="ladda-label">expand-left</span>
            </button>
        </div>
    </div>
</form>
@stop