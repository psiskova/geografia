<?php

class TaskController extends BaseController {

    public function show($id) {
        if (!$task = Task::find($id)) {
            return Redirect::action('ArticleController@showHome')
                            ->with('error', '');
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
            $questions = Question::where('task_id', '=', $task->id)->get(['id'])->toArray();
            $studentans = StudentAnswer::where('user_id', '=', Auth::id())->whereIn('question_id', $questions)->get();
            if (count($studentans) > 0) {
                return View::make('tasks.test.show', array(
                            'task' => $task,
                            'class' => $obj,
                            'disabled' => true,
                ));
            }
        }
        return View::make('tasks.' . ($task->isHomework() ? 'hw' : 'test') . '.show', array(
                    'task' => $task,
                    'class' => $obj
        ));
    }

    public function showActual() {
        $tasks = Task::afterStart()->beforeStop()->orderBy('stop', 'asc')->get();
        return View::make('tasks.actual', array(
                    'tasks' => $tasks
        ));
    }

    public function showAll() {
        if (Auth::user()->isStudent()) {
            $class = Student::where('user_id', '=', Auth::id())->first()->classs;
            $tasks = Task::where('class_id', '=', $class->id)->afterStart()->orderBy('stop', 'asc')->get();
        } else {
            $tasks = Task::orderBy('stop', 'desc')->get();
        }
        return View::make('tasks.all', array(
                    'tasks' => $tasks
        ));
    }

}
