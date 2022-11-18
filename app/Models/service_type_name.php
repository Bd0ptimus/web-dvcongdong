<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\service;
class service_type_name extends Model
{
    protected $table="service_type_names";
    protected $fillable = [
        "service_name",
    ];

    public function services(){
        return $this->hasMany(service::class, 'service_type_id', 'id');
    }
}
