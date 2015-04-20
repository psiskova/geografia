<?php

class HomeworkController extends BaseController {

    public function save() {
        $input = Input::all();
        $input['user_id'] = 1;
        $input['class_id'] = 1;
        $solution = Solution::create($input);
        if ($solution->save()) {
            return Redirect::action('TaskController@showActual')
                            ->with('message', 'Úloha bola uložená');
        }
        dd($solution->getErrors());
        return Redirect::back();
    }

    public function getCreate($id = null) {
        return View::make('tasks.hw.new', array(
            'id' => $id
        ));
    }
    public function postCreate() {
        return View::make('tasks.hw.new', array(
        ));
    }
    
    public function manage(){
        $hw = Task::homework()->orderBy('updated_at', 'desc')->get();
        return View::make('tasks.hw.manage', array(
                    'hw' => $hw
        ));
    }

}
