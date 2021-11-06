<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['topic_id','question_content','question_mark'];
    protected $primaryKey = 'question_id';
    protected $table = 'questions';
    
    public function answers(){
        return $this->hasMany('App\Models\Answer','question_id');
    }

    public function topics(){
        return $this->belongsTo('App\Models\Topic','topic_id');
    }

    public function lessons(){
        return $this->belongsToMany('App\Models\Lesson','lesson_contents','question_id','lesson_id');
    }
}
