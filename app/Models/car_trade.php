<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
class car_trade extends Model
{
    protected $table="car_trades";

    protected $fillable = [
        'address_trading'
    ];
    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }
}
