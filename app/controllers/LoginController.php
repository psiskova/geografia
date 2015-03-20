<?php

class LoginController extends BaseController {

    public function getLogin() {
        return View::make('login');
    }
    
    public function postLogin() {
        $input = Input::all();
        //$input['password']
        Auth::attempt($input, $input['remember']);
    }

}
