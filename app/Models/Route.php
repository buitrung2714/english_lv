<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['route_name','route_status','route_des'];
    protected $primaryKey = 'route_id';
    protected $table = 'routes';
    
    public function filter_structure(){
        return $this->belongsToMany('App\Models\FilterStructure','detail_routes','route_id','filter_id')->withPivot('detail_route_level');
    }

}
