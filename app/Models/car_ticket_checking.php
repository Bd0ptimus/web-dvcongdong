<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car_ticket_checking extends Model
{
    protected $table ="car_ticket_checking";
    protected $fillable = [
        'car_license',
        'car_ownership_certificate',
        'status',
        'result',
        'result_comment',
    ];


}
