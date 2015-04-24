<?php

class Solution extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'solutions';
    protected $fillable = array(
        'user_id',
        'homework_id',
        'text',
        'path',
        'points',
        'state',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'text' => 'required'
    );

    public function user() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function homework() {
        return $this->hasOne('Homework', 'id', 'homework_id');
    }

}
