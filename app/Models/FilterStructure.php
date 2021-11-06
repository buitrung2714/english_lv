<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterStructure extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['filter_name','filter_status'];
    protected $primaryKey = 'filter_id';
    protected $table = 'filter_structures';
    protected $hidden = ['pivot'];
    public function lessons(){
        return $this->hasMany('App\Models\Lesson','filter_id');
    }

    public function parts(){
        return $this->belongsToMany('App\Models\Part', 'filter_parts', 'filter_id', 'part_id',)->withPivot('filter_topic_level','filter_part_amount_topic');
    }

    public function routes(){
        return $this->belongsToMany('App\Models\Route', 'detail_routes', 'filter_id', 'route_id');
    }
}
