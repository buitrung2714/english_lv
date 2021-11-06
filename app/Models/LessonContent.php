<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonContent extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['lesson_id','question_id'];
    protected $primaryKey = 'lesson_content_id';
    protected $table = 'lesson_contents';

    public function lessons(){
        return $this->belongsTo('App\Models\Lesson','lesson_id');
    }

    public function questions(){
        return $this->belongsTo('App\Models\Question','question_id');
    }

    public function results(){
        return $this->belongsToMany('App\Models\Result','answer_students','lesson_content_id','result_id')->withPivot('ans_id_stu','ans_task','note','mark');
    }
}
