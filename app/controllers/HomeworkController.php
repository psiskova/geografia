<?php

class HomeworkController extends BaseController {

    public function getCreate($id = null) {
        $task = Task::find($id);
        if ($task && !$task->isHomework()) {
            return Redirect::action('ArticleController@showHome')
                            ->with('error', 'Nemáte prístup na túto stránku.');
        }
        return View::make('tasks.hw.new', array(
                    'task' => $task
        ));
    }

    public function save() {
        $input = Input::all();
        $input['user_id'] = Auth::id();
        $solution = Solution::create($input);
        if ($solution->save()) {
            return Redirect::action('TaskController@showActual')
                            ->with('message', 'Úloha bola uložená');
        }
        return Redirect::back();
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
        $task_id = $input['id'];
        if ($task = Task::find($input['id'])) {
            $task_copy = $task->toArray();
            $task->update($input);
            $editing = true;
        } else {
            $task = Task::create($input);
            $editing = false;
        }
        if ($task->save()) {
            $input['task_id'] = $task->id;
            if (count(Homework::where('task_id', '=', $task->id)->get()) == 0) {
                $hw = Homework::create($input);
            } else {
                array_forget($input, 'id');
                $hw = Homework::where('task_id', '=', $task->id)->first();
                $hw->update($input);
            }
            if ($hw->save()) {
                return Redirect::action('HomeworkController@getCreate')
                                ->with('message', 'Uložené');
            } else {
                if ($editing) {
                    $task->update($task_copy);
                    $task->save();
                    return Redirect::action('HomeworkController@getCreate', array('id' => $task_id))
                                    ->with('error', 'Chyba pri ukladaní');
                } else {
                    $task->delete();
                }
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

    public function showSolution($id) {
        $solution = Solution::where('id', '=', $id)->first();
        $homework = Homework::where('id', '=', $solution->homework_id)->first();
        $task = Task::where('id', '=', $homework->task_id)->first();
        return View::make('tasks.hw.show_solution', array(
                    'solution' => $solution,
                    'homework' => $homework,
                    'task' => $task
        ));
    }

    public function addPoints() {
        $input = Input::all();
        $solution = Solution::find($input['id']);
        $solution->update($input);
        if ($solution->save()) {
            return Redirect::action('HomeworkController@manage')
                            ->with('message', 'Úloha bola obodovaná');
        }
    }

    public function delete() {
        $input = Input::all();
        $hw = Homework::where('task_id', '=', $input['id'])->first();
        if ($hw && count(Solution::where('homework_id', '=', $hw->id)->get()) == 0) {
            $hw->delete();
            $task = Task::find($input['id']);
            $task->delete();
            return Redirect::action('HomeworkController@manage')
                            ->with('message', 'Úloha bola zmazaná');
        }
        return Redirect::action('HomeworkController@manage')
                        ->with('error', 'Úlohu obsahuje riešenia');
    }

}
