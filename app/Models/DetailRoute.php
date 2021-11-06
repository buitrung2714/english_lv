<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRoute extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['route_id','filter_id','detail_route_level'];
    // protected $primaryKey = 'filter_part_id';
    protected $table = 'detail_routes';
}
