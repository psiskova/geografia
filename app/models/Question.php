<?php

class Question extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    const TEXT = 1;
    const CHOICE = 2;

    protected $table = 'questions';
    protected $fillable = array(
        'task_id',
        'text',
        'points',
        'created_at',
        'updated_at',
        'type'
    );
    protected $rules = array(
        'task_id' => 'required|exists:tasks,id',
        'text' => 'required',
        'points' => 'required',
        'type' => 'required'
    );

}
