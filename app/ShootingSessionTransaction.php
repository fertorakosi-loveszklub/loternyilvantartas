<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShootingSessionTransaction extends Model
{
    protected $fillable = [
        'shooting_session_id',
        'caliber_id',
        'quantity',
    ];

    public function shootingSession()
    {
        return $this->belongsTo(ShootingSession::class);
    }

    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }
}
