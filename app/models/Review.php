<?php

class Review extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'reviews';
    protected $fillable = array(
        'user_id',
        'article_id',
        'text',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'article_id' => 'required|exists:articles,id',
        'text' => 'required'
    );

}
