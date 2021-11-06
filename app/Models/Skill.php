<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['skill_name'];
    protected $primaryKey = 'skill_id';
    protected $table = 'skills';
    
    public function parts(){
        return $this->hasMany('App\Models\Part','skill_id');
    }

    public function study_route(){
        return $this->hasMany('App\Models\StudyRoute','skill_id');
    }
}

