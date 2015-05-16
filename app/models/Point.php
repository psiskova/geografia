<?php

class Point extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'points';
    protected $fillable = array(
        'task_id',
        'user_id',
        'points',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'task_id' => 'required|exists:tasks,id',
        'user_id' => 'required|exists:users,id',
        'points' => 'required|integer|min:0'
    );

}
