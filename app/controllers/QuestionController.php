<?php

class QuestionController extends BaseController {

    public function getCreate($id = null) {
        $task = Task::find($id);
        if ($task && $task->isHomework()) {
            return Redirect::action('ArticleController@showHome')
                            ->with('error', 'Nemáte prístup na túto stránku.');
        }
        return View::make('tasks.test.new', array(
                    'task' => $task
        ));
    }

    public function postCreate() {
        if (Request::ajax()) {
            $input = Input::all()['questions'];
            $task_values = Input::except(['questions']);
            $task_values['user_id'] = Auth::id();
            $task_values['type'] = Task::TEST;
            try {
                $task_values['start'] = Carbon::createFromFormat('d.m.Y H:i', trim($task_values['start']));
                $task_values['stop'] = Carbon::createFromFormat('d.m.Y H:i', trim($task_values['stop']));
            } catch (Exception $e) {
                
            }
            //najprv vymazeme ak nejake su
            //Question::where('task_id', '=', Input::all()['id'])->delete();
            $task = Task::create($task_values);
            if ($task->save()) {
                foreach ($input as $question) {
                    switch ($question['type']) {
                        case 'text':
                            $questions = Question::create(array(
                                        'task_id' => $task->id,
                                        'text' => $question['text'],
                                        'type' => Question::TEXT,
                                        'points' => 10
                            ));
                            $questions->save();
                            break;
                        case 'choice':
                            $questions = Question::create(array(
                                        'task_id' => $task->id,
                                        'text' => $question['text'],
                                        'type' => Question::CHOICE,
                                        'points' => 10
                            ));
                            $questions->save();
                            foreach ($question['answers'] as $answer) {
                                $answer = CorrectAnswer::create(array(
                                            'question_id' => $questions->id,
                                            'text' => $answer['text'],
                                            'correct' => $answer['correct'] == 'true' ? 1 : 0
                                ));
                                $answer->save();
                            }
                            break;
                    }
                }
            } else {
                return Response::json($task->getErrors());
            }
            return Response::json($input);
        }
    }

    public function manage() {
        $tasks = Task::question()->orderBy('updated_at', 'desc')->get();
        return View::make('tasks.test.manage', array(
                    'tasks' => $tasks
        ));
    }

    public function getAllSolutions($id) {
        $questions = Question::where('task_id', '=', $id)->get(['id'])->toArray();
        $users = StudentAnswer::whereIn('question_id', $questions)->distinct()->get(['user_id', 'created_at']);
        return View::make('tasks.test.solutions', array(
                    'users' => $users,
                    'task' => Task::find($id)
        ));
    }

    public function save() {
        $input = Input::except(['_token']);
        foreach ($input as $key => $answer) {
            $question = Question::find($key);
            switch ($question->type) {
                case Question::TEXT:
                    $studentanswer = StudentAnswer::create(array(
                                'user_id' => Auth::id(),
                                'question_id' => $question->id,
                                'text' => $answer
                    ));
                    $studentanswer->save();
                    break;
                case Question::CHOICE:
                    foreach ($answer as $answers) {
                        $studentanswer = StudentAnswer::create(array(
                                    'user_id' => Auth::id(),
                                    'question_id' => $question->id,
                                    'answer_id' => $answers
                        ));
                        $studentanswer->save();
                    }
                    break;
            }
        }
        return Redirect::back();
    }

}
