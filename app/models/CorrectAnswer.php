<?php

class CorrectAnswer extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    const CORRECT = 1;

    protected $table = 'correctanswers';
    protected $fillable = array(
        'question_id',
        'text',
        'correct',
        'created_at',
        'updated_at',
    );
    protected $rules = array(
        'question_id' => 'required|exists:questions,id',
        'text' => 'required'
    );

    public function isCorrect() {
        return $this->correct == self::CORRECT;
    }

}
