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
use App\Models\car_ticket_checking;
use App\Models\entry_ban_checking;
use App\Models\tax_debt_checking;
use App\Models\adminis_checking;

use App\Models\post_comment;
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
        'username',
        'user_role',
        'active',
        'phone_number',
        'third_party_type',
        'user_avatar',
        '3_party_db_id',
    ];
    protected $guard = 'web';


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

    public function carTickets(){
        return $this->hasMany(car_ticket_checking::class, 'user_id', 'id');
    }

    public function entryBans(){
        return $this->hasMany(entry_ban_checking::class, 'user_id', 'id');
    }

    public function taxDebt(){
        return $this->hasMany(tax_debt_checking::class, 'user_id', 'id');
    }
    public function adminis(){
        return $this->hasMany(adminis_checking::class, 'user_id', 'id');
    }

    public function postComments(){
        return $this->hasMany(post_comment::class, 'writer_id', 'id');
    }

}
