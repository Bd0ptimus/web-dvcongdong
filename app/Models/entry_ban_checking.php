<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
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

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
