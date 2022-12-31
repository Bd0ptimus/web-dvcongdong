<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminis_checking extends Model
{
    protected $table = 'adminis_checking';
    protected $fillable = [
        'name',
        'dob',
        'passport_series',
        'passport_expired',
        'status',
        'user_id',
        'response_require',
        'result_comment',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
