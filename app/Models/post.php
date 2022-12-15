<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

//Models
use App\Models\User;
use App\Models\classify;
use App\Models\city;
use App\Models\post_attachment;
use App\Models\post_interaction;
use App\Models\post_comment;
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
        'access_times',
        'number_comment_accept',
        'rating_score',
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

    public function checkPostLiked($userId, $postId){
        $postInteraction = post_interaction::where('user_id',$userId)->where('post_id',$postId)->first();
        if(isset($postInteraction)){
            $return = $postInteraction->interaction_type == LIKE;
            return $return;
        }
        return false;
    }

    public function postComments(){
        return $this->hasMany(post_comment::class, 'post_id', 'id');
    }

}
