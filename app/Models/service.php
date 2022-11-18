<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\post;
use App\Models\service_type_name;
class service extends Model
{
    protected $table="services";

    protected $fillable = [
        'classify_type_id',
        'service_type_id',
        'city',
    ];

    public function post(){
        return $this->morphOne(post::class, 'posts_classify');
    }

    public function serviceTypeName(){
        return $this->belongsTo(service_type_name::class, 'service_type_id', 'id');
    }

    public function services_type(){
        return $this->morphTo();
    }
}
