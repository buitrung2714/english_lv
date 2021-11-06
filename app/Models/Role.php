<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
     public $timestamps = false;
    protected $fillable = ['role_name'];
    protected $primaryKey = 'role_id';
    protected $table = 'roles';
    
    public function staff(){
        return $this->belongsToMany('App\Models\Staff','admins_role','role_id','staff_id');
    }
}
