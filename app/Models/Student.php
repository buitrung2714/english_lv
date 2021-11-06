<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
     public $timestamps = false;
    protected $fillable = ['student_name','student_email','student_password','student_token','student_status'];
    protected $primaryKey = 'student_id';
    protected $table = 'students';

    public function results(){
        return $this->hasMany('App\Models\Result','student_id');
    }

    public function study_route(){
        return $this->hasMany('App\Models\StudyRoute','student_id');
    }
}
