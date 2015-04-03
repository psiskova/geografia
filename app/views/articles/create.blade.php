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
        
        @if(isset($id) && $id !== null)
        function loadArticle(){
            alert('ahoj');
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@getArticle") }}',
                'dataType': 'json',
                'data': {
                    'id':  {{ $id }},
                },
                'success': function (result) {
                        $('#caption').val(result['caption']),
                        $('#section_id').val(result['section_id']),
                        $('#text').code(result['text'])
                }
            })
        }
        loadArticle()
        @endif

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
                @foreach(Section::all() as $section)
                <option value="{{ $section->id }}">{{{ $section->name }}}</option>
                @endforeach
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
            <button type="button" class="btn btn-primary pull-right" style="margin-left: 10px">Odošli</button>
            <button id="save" class="btn btn-primary ladda-button pull-right" data-style="expand-left">
                <span class="ladda-label">Ulož</span>
            </button>
        </div>
    </div>
</form>
@stop