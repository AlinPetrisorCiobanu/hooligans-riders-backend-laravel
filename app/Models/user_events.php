<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_events extends Model
{
    use HasFactory;
    protected $table = 'user_events';
    protected $fillable = [
        'id_user',
        'id_event',
    ];
}
