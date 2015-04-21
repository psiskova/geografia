<?php

class QuestionController extends BaseController {
    
    public function getCreate($id = null) {
        return View::make('tasks.test.new', array(
            'id' => $id
        ));
    }
    public function postCreate() {
        return View::make('tasks.test.new', array(
        ));
    }
    
}

