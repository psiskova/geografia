<?php

class Homework extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'homeworks';
    protected $fillable = array(
        'task_id',
        'text',
        'points',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'task_id' => 'required|exists:tasks,id',
        'text' => 'required',
        'points' => 'required|integer'
    );

    public function task() {
        return $this->hasOne('Task', 'id', 'task_id');
    }

}
