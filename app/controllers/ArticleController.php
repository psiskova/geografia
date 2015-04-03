<?php

class ArticleController extends BaseController {

    public function show($id) {
        if (!$article = Article::find($id)) {
            return Redirect::action('ArticleController@showHome')
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
        $articles = Article::accepted()->orderBy('created_at', 'desc')->take(5)->get();
        return View::make('articles.show', array(
                    'articles' => $articles
        ));
    }

    public function showDrafts() {
        $drafts = Article::draft()->orderBy('created_at', 'desc')->get();
        return View::make('articles.draft', array(
                    'drafts' => $drafts
        ));
    }

    public function showSentArticles($id = null) {
        /* if (!$id) {
          $sentArticles = Article::sent()->orderBy('created_at', 'desc')->get();
          return View::make('articles.article_management', array(
          'sentArticles' => $sentArticles
          ));
          } */
        $sentArticles = Article::sent()->articleAuthor($id)->orderBy('created_at', 'desc')->get();
        return View::make('articles.sent', array(
                    'sentArticles' => $sentArticles
        ));
    }

    public function showAcceptedArticles($id = null) {
        /*  if (!$id) {
          $acceptedArticles = Article::accepted()->orderBy('created_at', 'desc')->get();
          return View::make('articles.article_management', array(
          'acceptedArticles' => $acceptedArticles
          ));
          } */
        $acceptedArticles = Article::accepted()->articleAuthor($id)->orderBy('created_at', 'desc')->get();
        return View::make('articles.accepted', array(
                    'acceptedArticles' => $acceptedArticles
        ));
    }

    public function showArticleManagement() {
        $sentArticles = Article::sent()->orderBy('created_at', 'desc')->get();
        $acceptedArticles = Article::accepted()->orderBy('created_at', 'desc')->get();
        return View::make('articles.article_management', array(
                    'acceptedArticles' => $acceptedArticles,
                    'sentArticles' => $sentArticles
        ));
    }

    public function showSection($id) {
        if (!$articlesInSection = Article::articleSection($id)->accepted()->orderBy('created_at', 'desc')->get()) {
            return Redirect::action('ArticleController@showHome')
                            ->with('error', 'Sorry bro');
        }
        return View::make('articles.section', array(
                    'articlesInSection' => $articlesInSection
        ));
    }

    public function showSectionManagement() {
        $sections = Section::all();
        return View::make('articles.section_management', array(
                    'sections' => $sections
        ));
    }

}
