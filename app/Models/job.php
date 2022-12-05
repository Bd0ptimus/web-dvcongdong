<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
class job extends Model
{
    protected $table="jobs";

    protected $fillable = [
        'address_working',
        'salary',
    ];
    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }
}
