<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['student_id','teacher_id','total_mark','fee','result_status','route_id','submit'];
    protected $primaryKey = 'result_id';
    protected $table = 'results';
    
    public function lesson_content(){
        return $this->belongsToMany('App\Models\LessonContent','answer_students','result_id','lesson_content_id')->withPivot('mark','ans_task','ans_id_stu','note');
    }

    public function staffs(){
        return $this->belongsTo('App\Models\Staff','staff_id','teacher_id');
    }

    public function students(){
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
