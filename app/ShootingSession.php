<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShootingSession extends Model
{
    protected $fillable = [
        'title',
        'closed_at'
    ];

    public function transactions()
    {
        return $this->hasMany(ShootingSessionTransaction::class, 'shooting_session_id');
    }
}
