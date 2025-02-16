<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function adminUsers()
    {
        return $this->hasMany(AdminUser::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    static function hasRole($roles)
    {
        $role = Auth::user()->role_id ? Auth::user()->role->name : '';

        if(!$role) {
            return false;
        }
        if(empty($roles)) {
            return true;
        }
        if(in_array($role, (array) $roles)) {
            return true;
        }
        return false;
    }
}
