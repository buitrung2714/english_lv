<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['level_name'];
    protected $primaryKey = 'level_id';
    protected $table = 'levels';
    
    public function topics(){
        return $this->hasMany('App\Models\Topic','level_id');
    }

    public function filter_part(){
        return $this->belongsToMany('App\Models\FilterPart','filter_topic_levels','level_id','filter_part_id');
    }

}
