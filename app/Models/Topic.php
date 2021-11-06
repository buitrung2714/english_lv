<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['part_id','level_id','topic_name','topic_audio','topic_content','topic_image','path','path_img'];
    protected $primaryKey = 'topic_id';
    protected $table = 'topics';
    
    public function levels(){
        return $this->belongsTo('App\Models\Level','level_id');
    }

    public function parts(){
        return $this->belongsTo('App\Models\Part','part_id');
    }

    public function questions(){
        return $this->hasMany('App\Models\Question','topic_id');
    }
}
