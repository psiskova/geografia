@extends('articles.article')

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
@stop