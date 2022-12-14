<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\User;
use App\Models\classify;
use App\Models\city;
use App\Models\post_attachment;
use App\Models\post_interaction;
class post extends Model
{
    protected $table="posts";

    protected $fillable = [
        'classify_id',
        'user_id',
        'city_id',
        'title',
        'content',
        'user_id',
        'exist_from',
        'exist_to',
        'contact_person',
        'contact_address',
        'contact_phone_number',
        'contact_email',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function classify(){
        return $this->belongsTo(User::class, 'classify_id', 'id');
    }

    public function posts_classify(){
        return $this->morphTo();
    }

    public function city(){
        return $this->belongsTo(city::class, 'city_id', 'id');
    }

    public function post_attachments(){
        return $this->hasMany(post_attachment::class , 'post_id', 'id');
    }

    public function post_interactions(){
        return $this->hasMany(post_interaction::class , 'post_id', 'id');
    }

}
