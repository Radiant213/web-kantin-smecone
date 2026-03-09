<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KioskApplication extends Model
{
    protected $fillable = [
        'user_id',
        'kiosk_id',
        'status',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kiosk()
    {
        return $this->belongsTo(Kiosk::class);
    }
}
