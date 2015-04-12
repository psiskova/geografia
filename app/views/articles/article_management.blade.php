@extends('articles.article')

@section('header')
<script>
    $(document).ready(function () {
        var id;
        
        function loadReview(area, dialog){
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@getReview") }}',
                'dataType': 'json',
                'data': {
                    'article_id': id
                },
                'success': function (result) {
                    if(result['text']) {
                      area.val(result['text']);
                    }
                    else {
                      area.val('');
                    }
                    dialog.modal('show');
                }
            });
        }
        
        $('.addReview').on('click', function(){
            id = $(this).attr('data-id');
            loadReview($('#reviewAdd'), $('#addReview'));
            
        });
        $('#addReviewButton').on('click', function(){
            if($('#reviewAdd').val()){
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@postCreateReview") }}',
                'dataType': 'json',
                'data': {
                    'article_id': id,
                    'text': $('#reviewAdd').val()
                },
                'success': function (result) {
                    $('#addReview').modal('hide');
                }
            });
        }
        });
        
        $('.showReview').on('click', function(){
            id = $(this).attr('data-id');
            loadReview($('#reviewShow'), $('#showReview'));
        });
        
    });
</script>
@stop

@section('middle')
<h4>Nehodnotené články:</h4> 
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Nadpis</th>
            <th class="text-center">Autor</th>
            <th class="text-center">Upraviť</th>
            <th class="text-center">Pridať recenziu</th>
            <th class="text-center">Publikovať</th>
            <th class="text-center">Nepublikovať</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sentArticles as $sentArticle)
        <tr>
            <td>
                {{ HTML::linkAction('ArticleController@show', $sentArticle->caption, array('id' => $sentArticle->id), array()) }}
            </td>
            <td>
                {{{ $sentArticle->user->fullName() }}}
            </td>
            <td>
                <a href="{{ action('ArticleController@getCreate', array('id' => $sentArticle->id)) }}">
                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </a>
            </td>
            <td>
                <button type="button" class="btn btn-default addReview" data-id="{{$sentArticle->id}}">
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                {{ Form::open(array('action' => 'ArticleController@postPublishArticle', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default publishArticle" data-id="{{$sentArticle->id}}" value="{{$sentArticle->id}}" name="id">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
            <td>
                {{ Form::open(array('action' => 'ArticleController@postDontPublishArticle', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default returnArticle" data-id="{{$sentArticle->id}}" value="{{$sentArticle->id}}" name="id">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<h4>Publikované články:</h4> 
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th class="text-center">Nadpis</th>
            <th class="text-center">Autor</th>
            <th class="text-center">Zobraziť recenziu</th>
            <th class="text-center">Zmazať</th>
        </tr>
    </thead>
    <tbody>
        @foreach($acceptedArticles as $acceptedArticle)
        <tr>
            <td>
                {{ HTML::linkAction('ArticleController@show', $acceptedArticle->caption, array('id' => $acceptedArticle->id), array()) }}
            </td>
            <td>
                {{{ $acceptedArticle->user->fullName() }}}
            </td>
            <td>
                <button type="button" class="btn btn-default showReview" data-id="{{$acceptedArticle->id}}">
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                {{ Form::open(array('action' => 'ArticleController@postDeleteArticle', 'method' => 'post')) }}
                <button type="submit" class="btn btn-default delete" data-id="{{$acceptedArticle->id}}" value="{{$acceptedArticle->id}}" name="id">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="addReview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ohodnotenie článku</h4>
            </div>
            <div class="modal-body" id="addReviewBody">
                <form role="form">
                    <div class="form-group">
                        <label for="review" class="control-label">Hodnotenie:</label>
                        <textarea class="form-control" id="reviewAdd"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary" id="addReviewButton">Ohodnoť</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showReview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ohodnotenie článku</h4>
            </div>
            <div class="modal-body" id="showReviewBody">
                <form role="form">
                    <div class="form-group">
                        <label for="review" class="control-label">Hodnotenie:</label>
                        <textarea disabled class="form-control" id="reviewShow" style="height: 150px;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>
@stop

