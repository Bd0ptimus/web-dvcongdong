<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\service;
class service_medical extends Model
{
    protected $table="service_medicals";

    protected $fillable = [
        "content",
    ];

    public function service(){
        return $this->morphOne(service::class, 'services_type');

    }
}
