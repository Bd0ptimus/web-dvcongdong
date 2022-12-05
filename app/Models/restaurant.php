<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//Models
use App\Models\post;
class restaurant extends Model
{
    protected $table="restaurants";

    protected $fillable = [
        'restaurant_address',
        'average_bill',
    ];
    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }
}
