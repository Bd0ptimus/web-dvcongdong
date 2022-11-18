<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
use App\Models\classify_types;
class classify extends Model
{
    public function posts(){
        return $this->hasMany(post::class, 'classify_id', 'id');
    }

    public function classifyTypes(){
        return $this->hasMany(classify_types::class, 'classify_id', 'id');
    }
}
