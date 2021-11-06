<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerStudent extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['lesson_content_id','result_id','ans_id_stu','ans_task','note','mark'];
    // protected $primaryKey = 'lesson_content_id','result_id';
    protected $table = 'answer_students';
    
    public function lesson_content(){
        return $this->belongsTo('App\Models\LessonContent','lesson_content_id');
    }

    public function results(){
        return $this->belongsTo('App\Models\Result','result_id');
    }
}
