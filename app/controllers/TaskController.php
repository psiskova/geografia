<?php

class TaskController extends BaseController {

    public function show($id) {
        if (!$task = Task::find($id)) {
            return Redirect::action('ArticleController@showHome')
                            ->with('error', 'Sorry bro');
        }
        return View::make('tasks.' . ($task->isHomework() ? 'hw' : 'test') . '.show', array(
                    'task' => $task,
                    'class' => $task->getObj()
        ));
    }

    public function showActual() {
        $tasks = Task::afterStart()->beforeStop()->orderBy('updated_at', 'desc')->get();
        return View::make('tasks.actual', array(
                    'tasks' => $tasks
        ));
    }

}
