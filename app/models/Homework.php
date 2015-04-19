<?php

class Homework extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'homeworks';
    protected $fillable = array(
        'class_id',
        'text',
        'points',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'text' => 'required',
        'points' => 'required'
    );

}
