<?php

class UserController extends BaseController {

    public function showTeachers() {
        $teachers = User::teachers()->orderBy('last_name', 'asc')->get();
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
    }
    