<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
class classify_ads extends Model
{
    protected $table="classify_ads";

    protected $fillable = [
        'adContent',
    ];
    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }
}
