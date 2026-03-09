<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPenjual(): bool
    {
        return $this->role === 'penjual';
    }

    public function isPembeli(): bool
    {
        return $this->role === 'pembeli';
    }

    public function kiosks()
    {
        return $this->hasMany(Kiosk::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function kioskApplications()
    {
        return $this->hasMany(KioskApplication::class);
    }
}
