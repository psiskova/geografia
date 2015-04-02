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
            $input['state'] = Article::DRAFT;
            $article = Article::create($input);
            $article->save();
            return Response::json($article->getErrors());
        }
    }

    public function showHome() {
        $articles = Article::orderBy('created_at')->take(5)->get();
        return View::make('articles.show', array(
                    'articles' => $articles
        ));
    }
    
    public function showDrafts() {
        $drafts = Article::where('state', '=', Article::DRAFT)->orderBy('created_at')->get();
        return View::make('articles.draft', array(
                    'drafts' => $drafts
        ));
    }

}
