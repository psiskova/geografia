<?php

class Article extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    const DRAFT = 1;
    const SENT = 2;
    const ACCEPTED = 3;

    protected $table = 'articles';
    protected $fillable = array(
        'user_id',
        'section_id',
        'caption',
        'text',
        'state',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'section_id' => 'required|exists:sections,id',
        'caption' => 'required'
    );

    public function scopeAccepted($query) {
        return $query->where('state', '=', self::ACCEPTED);
    }

    public function scopeDraft($query) {
        return $query->where('state', '=', self::DRAFT);
    }

    public function scopeSent($query) {
        return $query->where('state', '=', self::SENT);
    }

    public function scopeArticleSection($query, $id) {
        return $query->where('section_id', '=', $id);
    }

    public function scopeArticleAuthor($query, $id) {
        return $query->where('user_id', '=', $id);
    }

    public function scopeSearch($query, $text) {
        return $query->where('caption', 'like', '%' . $text . '%')
                        ->orWhere('updated_at', 'like', '%' . $text . '%');
    }

    public function user() {
        return $this->hasOne('User', 'id', 'user_id');
    }

}
