<?php

class Section extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    protected $table = 'sections';
    protected $fillable = array(
        'name',
        'root',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'name' => 'required'
    );

}
