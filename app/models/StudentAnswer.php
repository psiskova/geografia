<?php

class StudentAnswer extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'studentAnswers';
    protected $fillable = array(
        'user_id',
        'question_id',
        'answer_id',
        'text',
        'created_at',
        'updated_at',
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'question_id' => 'required|exists:questions,id',
        'answer_id' => 'exists:correctanswers,id',
    );

}
