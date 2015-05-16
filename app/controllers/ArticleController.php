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
            $input['user_id'] = Auth::id();
            $input['state'] = Article::DRAFT;
            if (!$article = Article::find($input['id'])) {
                $article = Article::create($input);
            } else {
                $input['state'] = $article->state;
                $input['user_id'] = $article->user_id;
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

    public function postPublishArticle() {
        $input = Input::all();
        $article = Article::find($input['id']);
        if (count(Review::where('article_id', '=', $input['id'])->get()) == 0) {
            return Redirect::action('ArticleController@showArticleManagement')
                            ->with('error', 'Chýba ohodnotenie článku!');
        } else {
            $article->state = Article::ACCEPTED;
            $article->save();
            return Redirect::action('ArticleController@showArticleManagement')
                            ->with('message', 'Článok bol publikovaný');
        }
    }

    public function postDontPublishArticle() {
        $input = Input::all();
        $article = Article::find($input['id']);
        if (count(Review::where('article_id', '=', $input['id'])->get()) == 0) {
            return Redirect::action('ArticleController@showArticleManagement')
                            ->with('error', 'Chýba ohodnotenie článku!');
        } else {
            $article->state = Article::DRAFT;
            $article->save();
            return Redirect::action('ArticleController@showArticleManagement')
                            ->with('message', 'Článok bol vrátený na prepracovanie');
        }
    }

    public function postDeleteArticle() {
        $input = Input::all();
        if (count(Review::where('article_id', '=', $input['id'])->get()) == 0) {
            Article::find($input['id'])->delete();
        } else {
            $review = Review::where('article_id', '=', $input['id'])->first();
            $review->delete();
            Article::find($input['id'])->delete();
        }
        return Redirect::action('ArticleController@showArticleManagement')
                        ->with('message', 'Článok bol zmazaný');
    }

    public function postDeleteDraft() {
        if (Request::ajax()) {
            $input = Input::all();
            if (count(Review::where('article_id', '=', $input['id'])->get()) == 0) {
                Article::find($input['id'])->delete();
            } else {
                $review = Review::where('article_id', '=', $input['id'])->first();
                $review->delete();
                Article::find($input['id'])->delete();
            }
        }
    }

    public function getArticle() {
        if (Request::ajax()) {
            $article = Article::find(Input::all('id'))[0];
            return Response::json($article);
        }
    }

    public function showHome($query = null) {
        $articles = Article::accepted();
        if (isset(Input::all()['query']) && Input::all()['query'] != '') {
            $users = User::where('name', 'like', '%' . Input::all()['query'] . '%')
                            ->orWhere('last_name', 'like', '%' . Input::all()['query'] . '%')->get(['id'])->toArray();
            if (count($users) == 0) {
                $articles = $articles->search(Input::all()['query']);
            } else {
                $articles = $articles->whereIn('user_id', $users);
            }
        }
        $articles = $articles->orderBy('articles.updated_at', 'desc')->take(5)->get();
        return View::make('articles.show', array(
                    'articles' => $articles
        ));
    }

    public function showDrafts() {
        $id = Auth::id();
        $drafts = Article::draft()->articleAuthor($id)->orderBy('created_at', 'desc')->get();
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
        $id = Auth::id();
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
        $id = Auth::id();
        $acceptedArticles = Article::accepted()->articleAuthor($id)->orderBy('created_at', 'desc')->get();
        return View::make('articles.accepted', array(
                    'acceptedArticles' => $acceptedArticles
        ));
    }

    public function showArticleManagement() {
        $sentArticles = Article::sent()->orderBy('updated_at', 'desc')->get();
        $acceptedArticles = Article::accepted()->orderBy('updated_at', 'desc')->get();
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

    public function postDeleteSection() {
        $input = Input::all();
        if (count(Article::where('section_id', '=', $input['id'])->get()) == 0) {
            Section::find($input['id'])->delete();
            return Redirect::action('ArticleController@showSectionManagement')
                            ->with('message', 'Rubrika bola zmazaná');
        } else {
            return Redirect::action('ArticleController@showSectionManagement')
                            ->with('message', 'Rubriku nemožno zmazať, obsahuje články!');
        }
    }

    public function getSection() {
        if (Request::ajax()) {
            return Response::json(Section::find(Input::all()['id']));
        }
    }

    public function postCreateSection() {
        if (Request::ajax()) {
            $input = Input::all();
            if ($section = Section::find($input['id'])) {
                $section->update($input);
            } else {
                $section = Section::create($input);
            }
            $section->save();
            return Response::json($section);
        }
    }

    public function postCreateReview() {
        if (Request::ajax()) {
            $input = Input::all();
            $input['user_id'] = Auth::id();
            if (count(Review::where('article_id', '=', $input['article_id'])->get()) == 0) {
                $review = Review::create($input);
            } else {
                $review = Review::where('article_id', '=', $input['article_id'])->first();
                $review->update($input);
            }
            $review->save();
            return Response::json(array(
                        'result' => 'ok'
            ));
        }
    }

    public function getReview() {
        $input = Input::all();
        $input['user_id'] = Auth::id();
        if (Request::ajax()) {
            $review = Review::where('article_id', '=', $input['article_id'])->first();
            return Response::json($review);
        }
    }

}
