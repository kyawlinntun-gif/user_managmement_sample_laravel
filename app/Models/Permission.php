<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'feature_id'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'feature_id');
    }

    static function hasPermission($user, $permission, $feature)
    {
        $hasPermission = $user->role->permissions()->where('name', $permission)->whereHas('feature', function ($query) use ($feature) {
            $query->where('name', $feature);
        })->exists();

        return $hasPermission ? true : false;
    }
}
