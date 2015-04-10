@extends('articles.article')

@section('header')
<script>
    $(document).ready(function () {
        var id;
        $('.addReview').on('click', function(){
            $('#addReview').modal('show');
            id = $(this).attr('data-id');
        });
        $('#addReviewButton').on('click', function(){
            if($('#review').val()){
            $.ajax({
                'method': 'post',
                'url': '{{ action("ArticleController@postCreateReview") }}',
                'dataType': 'json',
                'data': {
                    'article_id': id,
                    'text': $('#review').val()
                },
                'success': function (result) {
                }
            })
        }
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
                <button type="button" class="btn btn-default publishArticle" data-id="{{$sentArticle->id}}">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default returnArticle" data-id="{{$sentArticle->id}}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<h4>Publikované články:</h4> 
<table class="table table-hover">
    <thead>
        <tr>
            <th>Nadpis</th>
            <th>Autor</th>
            <th>Zobraziť recenziu</th>
            <th>Zmazať</th>
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
                <button type="button" class="btn btn-default delete" data-id="{{$acceptedArticle->id}}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
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
                        <label for="review" class="control-label">Hodnoteie:</label>
                        <textarea class="form-control" id="review"></textarea>
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
@stop

