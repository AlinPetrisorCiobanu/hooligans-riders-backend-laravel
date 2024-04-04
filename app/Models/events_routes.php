<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class events_routes extends Model
{
    use HasFactory;
    protected $table = 'events_routes';
    protected $fillable = [
        'id_user',
        'date',
        'kms',
        'img',
        'participants',
        'targeted_users',
        'maps',
        'is_active'
    ];
    public function usersData(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_events' , 'id_event' , 'id_user');
    }
}
