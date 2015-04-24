<?php

class TaskController extends BaseController {

    public function show($id) {
        if (!$task = Task::find($id)) {
            return Redirect::action('ArticleController@showHome')
                            ->with('error', 'Sorry bro');
        }
        $obj = $task->getObj();
        if ($task->isHomework()) {
            $solution = Solution::where('user_id', '=', Auth::id())->where('homework_id', '=', $obj->id)->first();
            if ($solution) {
                return View::make('tasks.hw.show', array(
                            'task' => $task,
                            'class' => $obj,
                            'disabled' => true,
                            'text' => $solution->text
                ));
            }
        } else {
            
        }
        return View::make('tasks.' . ($task->isHomework() ? 'hw' : 'test') . '.show', array(
                    'task' => $task,
                    'class' => $obj
        ));
    }

    public function showActual() {
        $tasks = Task::afterStart()->beforeStop()->orderBy('updated_at', 'desc')->get();
        return View::make('tasks.actual', array(
                    'tasks' => $tasks
        ));
    }

    public function showAll() {
        $tasks = Task::orderBy('updated_at', 'desc')->get();
        return View::make('tasks.all', array(
                    'tasks' => $tasks
        ));
    }

}
