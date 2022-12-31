<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
class tax_debt_checking extends Model
{
    protected $table = 'tax_debt_checking';
    protected $fillable = [
        'name',
        'dob',
        'passport_series',
        'passport_expired',
        'inn',
        'status',
        'user_id',
        'response_require',
        'result_comment',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
