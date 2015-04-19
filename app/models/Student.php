<?php

class Student extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'students';
    protected $fillable = array(
        'class_id',
        'user_id',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'class_id' => 'required|exists:classes,id',
    );

}
