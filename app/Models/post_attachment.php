<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\post;
class post_attachment extends Model
{
    protected $table="post_attachments";
    protected $fillable=[
        "attachment_path",
        "post_id",
        "attachment_type",
    ];

    public function post(){
        return $this->belongsTo(post::class, 'post_id', 'id');
    }
}
