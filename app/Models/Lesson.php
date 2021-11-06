<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['filter_id','lesson_status'];
    protected $primaryKey = 'lesson_id';
    protected $table = 'lessons';
    
    public function questions(){
        return $this->belongsToMany('App\Models\Question','lesson_contents','lesson_id','question_id');
    }

    public function filter_structure(){
        return $this->belongsTo('App\Models\FilterStructure','filter_id');
    }
}
