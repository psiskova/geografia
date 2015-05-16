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
                    'password' => Input::get('password'),
                    'confirmed' => 1), Input::get('remember'))) {
            return Redirect::action('ArticleController@showHome')
                            ->with('message', 'Prihlásenie prebehlo úspešne');
        }
        return Redirect::action('LoginController@getLogin')
                        ->with('error', 'Nie je možné prihlásiť');
    }

    public function postRegister() {
        $input = Input::all();
        $rules = array(
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_again' => 'same:password',
        );

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator)
                            ->withInput();
        }
        User::create(array(
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'confirmed' => 0
        ));
        return Redirect::action('LoginController@getLogin')
                        ->with('message', 'Užívateľ bol úspešne vytvorený.');
    }

    public function getRegister() {
        return View::make('register');
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::action('ArticleController@showHome')
                        ->with('message', 'Odhlásenie prebehlo úspešne');
    }

}
