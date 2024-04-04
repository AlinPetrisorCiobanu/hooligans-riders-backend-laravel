<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'last_name',
        'date',
        'phone',
        'email',
        'nickname',
        'password',
        'role',
        'is_active',
        'confirmed',
    ];
    public function eventsData(): BelongsToMany
    {
        return $this->belongsToMany(events_routes::class , 'user_events' , 'id_user' , 'id_event');
    }
}
