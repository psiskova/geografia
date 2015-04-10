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
        return View::make('articles.create', array(
                    'id' => $id
        ));
    }

    public function postCreate() {
        if (Request::ajax()) {
            $input = Input::all();
            $input['user_id'] = 1;
            $input['state'] = Article::DRAFT;
            if (!$article = Article::find($input['id'])) {
                $article = Article::create($input);
            } else {
                $article->update($input);
            }
            $article->save();
            if (count($article->getErrors()) > 0) {
                $result = $article->getErrors();
            } else {
                $result = array(
                    'id' => $article->id
                );
            }
            return Response::json($result);
        }
    }

    public function postSendArticle() {
        $input = Input::all();
        $article = Article::find($input['id']);
        $article->state = Article::SENT;
        $article->save();
        return Redirect::action('ArticleController@showSentArticles')
                        ->with('message', 'Článok bol odoslaný na kontrolu');
    }

    public function getArticle() {
        if (Request::ajax()) {
            $article = Article::find(Input::all('id'))[0];
            return Response::json($article);
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

    public function showSentArticles() {
        /* if (!$id) {
          $sentArticles = Article::sent()->orderBy('created_at', 'desc')->get();
          return View::make('articles.article_management', array(
          'sentArticles' => $sentArticles
          ));
          } */
        $id = 1;
        $sentArticles = Article::sent()->articleAuthor($id)->orderBy('created_at', 'desc')->get();
        return View::make('articles.sent', array(
                    'sentArticles' => $sentArticles
        ));
    }

    public function showAcceptedArticles() {
        /*  if (!$id) {
          $acceptedArticles = Article::accepted()->orderBy('created_at', 'desc')->get();
          return View::make('articles.article_management', array(
          'acceptedArticles' => $acceptedArticles
          ));
          } */
        $id = 1;
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

    public function postCreateReview() {
        if (Request::ajax()) {
            $input = Input::all();
            $input['user_id'] = 1;
            if (count(Review::where('article_id', '=', $input['article_id'])->get()) == 0) {
                $review = Review::create($input);
            } else {
                $review = Review::where('article_id', '=', $input['article_id']);
                $review->update($input);
            }
            $review->save();
            return Response::json(array(
                        'result' => 'ok'
            ));
        }
    }

}
