<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
class real_estate extends Model
{
    protected $table="real_estates";

    protected $fillable = [
        'square',
        'city',
        'address',
        'price',
        'number_room',
    ];

    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }
}
