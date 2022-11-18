<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Models
use App\Models\classify;
class classify_types extends Model
{
    protected $table="classify_types";
    protected $fillable = [
        "type_name",
        "classify_id"
    ];
    public function classify(){
        return $this->belongsTo(classify::class, 'classify_id', 'id');
    }
}
