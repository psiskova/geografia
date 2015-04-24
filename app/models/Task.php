<?php

class Task extends Eloquent {

    use \Watson\Validating\ValidatingTrait;

    const HOMEWORK = 0;
    const TEST = 1;

    protected $table = 'tasks';
    protected $fillable = array(
        'user_id',
        'class_id',
        'start',
        'stop',
        'type',
        'state',
        'name',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'user_id' => 'required|exists:users,id',
        'class_id' => 'required|exists:classes,id',
        'start' => 'required|date',
        'stop' => 'required|date|after:start',
        'type' => 'required|in:0,1',
        'name' => 'required'
    );

    public function scopeAfterStart($query) {
        return $query->whereRaw('start < now()');
    }

    public function scopeAfterStop($query) {
        return $query->whereRaw('stop < now()');
    }

    public function scopeBeforeStop($query) {
        return $query->whereRaw('stop > now()');
    }

    public function scopeHomework($query) {
        return $query->where('type', '=', self::HOMEWORK);
    }

    public function isHomework() {
        return $this->type == self::HOMEWORK;
    }

    public function getObj() {
        switch ($this->type) {
            case self::HOMEWORK:
                return Homework::where('task_id', '=', $this->id)->first();
            case self::TEST:
                return NULL;
        };
    }
    
    public function classs(){
        return $this->hasOne('Classs', 'id', 'class_id');
    }

}
