<?php

class LoginController extends BaseController {

    public function getLogin() {
        if (Auth::check()) {
            return Redirect::action('ArticleController@showHome');
        }
        return View::make('login');
    }

    public function postLogin() {
        if (Auth::attempt(array(
                    'email' => Input::get('email'),
                    'password' => Input::get('password')), Input::get('remember'))) {
            return Redirect::action('ArticleController@showHome')
                            ->with('message', Lang::get('common.login_successful'));
        }
        return Redirect::back()
                        ->withInput(Input::except('password'));
    }
    
    public function postRegister() {
        
    }

}
