<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['staff_name','staff_email','staff_password'];
    protected $primaryKey = 'staff_id';
    protected $table = 'staff';
    
    public function roles(){
        return $this->belongsToMany('App\Models\Role','admins_role','staff_id','role_id');
    }

    public function results(){
        return $this->hasMany('App\Models\Result','teacher_id','staff_id');
    }

    public function getAuthPassword(){
        return $this->staff_password;
    }

    public function hasRoles($role){
        return null !== $this->roles()->whereIn('role_name', $role)->first();
    }
}
