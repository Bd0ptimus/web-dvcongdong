<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
class garment extends Model
{
    protected $table="garments";

    protected $fillable = [
        'information',
    ];
    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }
}
