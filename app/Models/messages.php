<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'name',
        'last_name',
        'data',
        'message',
        'is_active'
    ];
}
