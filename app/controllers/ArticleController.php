<?php

class ArticleController extends BaseController {

    public function show($id) {
        if (!$article = Article::find($id)) {
            return Redirect::action('HomeController@showWelcome')
                            ->with('error', 'Sorry bro');
        }
        return View::make('articles.show', array(
                    'article' => $article
        ));
    }

    public function getCreate($id = null) {
        return View::make('articles.create');
    }

    public function postCreate() {
        if (Request::ajax()) {
            $input = Input::all();
            $input['user_id'] = 1;
            $article = Article::create($input);
            $article->save();
            return Response::json($article->getErrors());
        }
    }

}
