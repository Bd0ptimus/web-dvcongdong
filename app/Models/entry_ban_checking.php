<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entry_ban_checking extends Model
{
    protected $table="entry_ban_checking";
    protected $fillable = [
        'name_russian',
        'name_latin',
        'dob',
        'passport_series',
        'passport_expired',
        'status',
        'result',
        'result_comment',
        'response_require',
        'user_id',
    ];
}
