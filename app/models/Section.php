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
    
    public function hasPublicArticles() {
        return Article::where('section_id', '=', $this->id)->accepted()->get()->count() > 0;
    }

}
