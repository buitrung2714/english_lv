<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['skill_id','part_no','part_topic_max','part_des','part_name','part_amount_ques_per_topic'];
    protected $primaryKey = 'part_id';
    protected $table = 'parts';
    
    public function skills(){
        return $this->belongsTo('App\Models\Skill','skill_id');
    }

    public function topics(){
        return $this->hasMany('App\Models\Topic','part_id');
    }

    // public function filter_part(){
    //     return $this->hasMany('App\Models\FilterPart','part_id');
    // }
    public function filters(){
       
        return $this->belongsToMany('App\Models\FilterStructure','filter_parts','part_id', 'filter_id')->withPivot('filter_topic_level','filter_part_amount_topic');
    }

}

