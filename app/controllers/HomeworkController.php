<?php

class HomeworkController extends BaseController {

    public function save() {
        $input = Input::all();
        $input['user_id'] = Auth::id();
        $solution = Solution::create($input);
        if ($solution->save()) {
            return Redirect::action('TaskController@showActual')
                            ->with('message', 'Úloha bola uložená');
        }
        dd($solution->getErrors());
        return Redirect::back();
    }

    public function getCreate($id = null) {
        $task = Task::find($id);
        return View::make('tasks.hw.new', array(
                    'task' => $task
        ));
    }

    public function getText() {
        if (Request::ajax()) {
            $homework = Homework::where('task_id', '=', Input::all()['id'])->select('text')->first();
            return Response::json($homework);
        }
    }

    public function postCreate() {
        $input = Input::all();
        $input['user_id'] = Auth::id();
        $input['type'] = Task::HOMEWORK;
        try {
            $input['start'] = Carbon::createFromFormat('d.m.Y H:i', trim($input['start']));
            $input['stop'] = Carbon::createFromFormat('d.m.Y H:i', trim($input['stop']));
        } catch (Exception $e) {
            
        }
        if ($task = Task::find($input['id'])) {
            $task->update($input);
        } else {
            $task = Task::create($input);
        }
        if ($task->save()) {
            $input['task_id'] = $task->id;
            if (count(Homework::where('task_id', '=', $task->id)->get()) == 0) {
                $hw = Homework::create($input);
            } else {
                $hw = Homework::where('task_id', '=', $task->id)->first();
            }
            if ($hw->save()) {
                return Redirect::action('HomeworkController@getCreate')
                                ->with('message', 'Uložené');
            } else {
                $task->delete();
            }
        }
        return Redirect::action('HomeworkController@getCreate', array('id' => isset($input['id']) ? $input['id'] : null))
                        ->with('error', 'Chyba pri ukladaní');
    }

    public function manage() {
        $tasks = Task::homework()->orderBy('updated_at', 'desc')->get();
        return View::make('tasks.hw.manage', array(
                    'tasks' => $tasks
        ));
    }

    public function getAllSolutions($id) {
        return View::make('tasks.hw.solutions', array(
                    'solutions' => Solution::where('homework_id', '=', $id)->get(),
                    'homework' => Homework::find($id)
        ));
    }

}
