<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    const ADMIN = 2;
    const TEACHER = 1;
    const STUDENT = 0;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $fillable = array(
        'name',
        'last_name',
        'email',
        'password',
        'confirmed',
        'admin'
    );

    public function isStudent() {
        return $this->admin == self::STUDENT;
    }

    public function isTeacher() {
        return $this->admin == self::TEACHER;
    }

    public function isAdmin() {
        return $this->admin == self::ADMIN;
    }

    public function fullName() {
        return $this->name . ' ' . $this->last_name;
    }

    public function scopeTeachers($query) {
        return $query->where('admin', '=', self::TEACHER);
    }

    public function scopeStudents($query) {
        return $query->whereIn('id', Student::all(['user_id'])->toArray())->where('confirmed', '=', 1);
    }

}
