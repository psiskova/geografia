<?php

class Classs extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'classes';
    protected $fillable = array(
        'name',
        'year',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'name' => 'required',
    );

}
