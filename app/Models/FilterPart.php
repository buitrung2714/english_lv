<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterPart extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['part_id','filter_id','filter_topic_level','filter_part_amount_topic'];
    protected $primaryKey = 'filter_part_id';
    protected $table = 'filter_parts';
    
    public function levels(){
        return $this->belongsToMany('App\Models\Level','filter_topic_levels','filter_part_id','level_id');
    }

    public function parts(){
        return $this->belongsTo('App\Models\Part','part_id');
    }
    public function filter_structure(){
        return $this->belongsTo('App\Models\FilterStructure','filter_id');
    }
}
