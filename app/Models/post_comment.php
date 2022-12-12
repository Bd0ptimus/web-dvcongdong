<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\post;
use App\Models\User;
use App\Models\post_comment_attachment;
class post_comment extends Model
{
    protected $table='post_comments';
    protected $fillable = [
        'post_id',
        'writer_id',
        'comments',
        'star',
        'comment_accept'
    ];

    public function post(){
        return $this->belongsTo(post::class, 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'writer_id', 'id');
    }

    public function postCommentAttachments(){
        return $this->hasMany(post_comment_attachment::class, 'post_comment_id', 'id');
    }
}
