<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
class city extends Model
{
    protected $table="cities";
    protected $fillable = [
        "city"
    ];
    public function posts(){
        return $this->hasOne(post::class, 'city_id', 'id');
    }
}
