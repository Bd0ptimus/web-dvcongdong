<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//Models
use App\Models\post;
use App\Models\post_interaction;

use App\Admin;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(post::class, 'user_id', 'id');
    }

    public function isRole($role=''){
        return Admin::user()->user_role == $role;
    }

    public function inRoles($roles=[]){
        return in_array(Admin::user()->user_role, $roles);
    }

    public function post_interactions(){
        return $this->hasMany(post_interaction::class, 'user_id', 'id');
    }
}
