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
            var data =  {
                'caption': $('#caption').val(),
                'section_id': $('#section_id').val(),
                'text': $('.summernote').code(),
                'id': $('#id').val()
            };
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@postCreate") }}',
                'dataType': 'json',
                'data': data,
                'success': function (result) {
                    if (result.id){
                        $('#id').val(result.id);
                        $('#save').addClass('btn-success');
                    }else{
                        for (var key in result) {
                            $('#' + key).closest('.form-group').addClass('has-error');
                        }
                        $('#save').addClass('btn-danger');
                    }
                },
                'error': function() {
                    $('#save').addClass('btn-danger');
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
            $('#save').removeClass('btn-danger').removeClass('btn-success');
            l.start();
            save();
            return false;
        });($('#id').val() === '' && $(this).addClass('btn-danger') && false) || 
        
        $('#send').on('click', function() {
            return $('#id').val() !== ''; 
        });
        
        @if(isset($id) && $id !== null)
        function loadArticle(){
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@getArticle") }}',
                'dataType': 'json',
                'data': {
                    'id':  {{ $id }},
                },
                'success': function (result) {
                    $('#caption').val(result['caption']);
                    $('#section_id').val(result['section_id']);
                    $('.summernote').code(result['text']);
                }
            })
        }
        loadArticle()
        @endif
        
        function deleteDraft(){
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@postDeleteDraft") }}',
                'dataType': 'text',
                'data': {
                    'id': $('#id').val(),
                },
                'success': function (result) {
                    $('#caption').val('');
                    $('#section_id').val('');
                    $('.summernote').code('');
                    $('#id').val('');
                }
            })
        }
        $('#delete').on('click', function(){ 
            if($('#id').val()) {
                deleteDraft();
            }
            else {
                $('#caption').val('');
                $('#section_id').val('');
                $('.summernote').code('');
                $('#id').val('');
            }
            event.preventDefault();
            return false;
        });
    });
</script>
@stop

@section('middle')
{{ Form::open(array('action' => 'ArticleController@postSendArticle', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <input type="hidden" value="{{$id or ''}}" id="id" name="id">
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
            {{Form::submit('Odošli', array('class'=>'btn btn-primary pull-right', 'style'=>'margin-left: 10px', 'id'=>'send'))}}
            {{ Form::close() }}
            <button id="save" class="btn btn-primary ladda-button pull-right" data-style="expand-left">
                <span class="ladda-label">Ulož</span>
            </button>
            <button type="button" id="delete" class="btn btn-default trash">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </div>
    </div>
@stop