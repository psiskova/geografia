<?php

class UserController extends BaseController {

    public function showTeachers() {
        $teachers = User::whereIn('admin', [User::TEACHER, User::ADMIN])->where('id', '<>', Auth::id())->orderBy('last_name', 'asc')->get();
        return View::make('users.teacher', array(
                    'teachers' => $teachers
        ));
    }

    public function showStudents() {
        $students = User::students()->orderBy('last_name', 'asc')->get();
        return View::make('users.student', array(
                    'students' => $students
        ));
    }

    public function showClasses() {
        $classes = Classs::orderBy('updated_at', 'desc')->get();
        return View::make('users.class', array(
                    'classes' => $classes
        ));
    }

    public function showWaiting() {
        $registered = User::where('confirmed', '=', '0')->orderBy('updated_at', 'desc')->get();
        return View::make('users.waiting', array(
                    'registered' => $registered
        ));
    }

    public function showClass($id) {
        $studentsInClass = Student::where('class_id', '=', $id)->orderBy('created_at', 'desc')->get();
        return View::make('users.show_students', array(
                    'studentsInClass' => $studentsInClass,
                    'id' => $id
        ));
    }

    public function postCreateClass() {
        if (Request::ajax()) {
            $input = Input::all();
            if ($classs = Classs::find($input['id'])) {
                $classs->update($input);
            } else {
                $classs = Classs::create($input);
            }
            $classs->save();
            return Response::json($classs);
        }
    }

    public function getClass() {
        if (Request::ajax()) {
            return Response::json(Classs::find(Input::all()['id']));
        }
    }

    public function postDeleteClass() {
        $input = Input::all();
        if (count(Student::where('class_id', '=', $input['id'])->get()) == 0) {
            Classs::find($input['id'])->delete();
            return Redirect::action('UserController@showClasses')
                            ->with('message', 'Trieda bola zmazaná');
        } else {
            return Redirect::action('UserController@showClasses')
                            ->with('error', 'Triedu nemožno zmazať, nie je prázdna!');
        }
    }

    public function acceptUser() {
        $input = Input::all();
        $user = User::find($input['id']);
        $user->confirmed = 1;
        $user->admin = $input['user_role'];
        $user->save();
        if ($input['user_role'] == '0') {
            $student = Student::create(array('class_id' => $input['class_id'], 'user_id' => $input['id']));
            $student->save();
        }
        return Redirect::action('UserController@showWaiting')
                        ->with('message', 'Užívateľ bol pridaný');
    }

    public function deleteUser() {
        $input = Input::all();
        User::find($input['id'])->delete();
        return Redirect::action('UserController@showWaiting')
                        ->with('message', 'Užívateľ bol zmazaný');
    }

    public function changeClass() {
        if (Request::ajax()) {
            $input = Input::all();
            Student::where('user_id', '=', $input['user_id'])->delete();
            Student::create($input)->save();
            return Response::json('ok');
        }
    }

    public function unbanStudent() {
        if (Request::ajax()) {
            $input = Input::all();
            $user = User::find($input['user_id']);
            $user->ban = 0;
            $user->save();
            return Response::json('ok');
        }
    }
    
    public function unbanTeacher() {
        if (Request::ajax()) {
            $input = Input::all();
            $user = User::find($input['user_id']);
            $user->ban = 0;
            $user->save();
            return Response::json('ok');
        }
    }

    public function banStudent() {
        if (Request::ajax()) {
            $input = Input::all();
            $user = User::find($input['user_id']);
            $user->ban = 1;
            $user->save();
            return Response::json('ok');
        }
    }
    
    public function banTeacher() {
        if (Request::ajax()) {
            $input = Input::all();
            $user = User::find($input['user_id']);
            $user->ban = 1;
            $user->save();
            return Response::json('ok');
        }
    }
    
        public function changeRole() {
        if (Request::ajax()) {
            $input = Input::all();
            $user = User::find($input['user_id']);
            $user->admin = $input['user_role'];
            $user->save();
            return Response::json('ok');
        }
    }

}
