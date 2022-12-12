<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\post_comment;
class post_comment_attachment extends Model
{
    protected $table="post_comment_attachments";
    protected $fillable = [
        'post_comment_id',
        'attachment_path',
    ];


    public function postComment(){
        return $this->belongsTo(post_comment::class, 'post_comment_id', 'id');
    }
}
