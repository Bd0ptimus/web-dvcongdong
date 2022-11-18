<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\posts;
use App\Models\User;
class post_interaction extends Model
{
    protected $table="post_interaction";
    protected $fillable=[
        'user_id',
        'post_id',
        'interaction_type',
    ];

    public function post(){
        return $this->belongsTo(posts::class, 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
