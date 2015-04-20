<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;
    
    const TEACHER = 0;
    const ADMIN = 1;
    const STUDENT = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $fillable = array(
        'name',
        'last_name'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    public function fullName() {
        return $this->name . ' ' . $this->last_name;
    }
    
    public function scopeTeachers($query) {
        return $query->where('admin', '=', self::TEACHER);
    }
    
    public function scopeStudents($query) {
        return $query->where('admin', '=', self::STUDENT);
    }

}
