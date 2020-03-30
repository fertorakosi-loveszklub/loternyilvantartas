<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasedAmmo extends Model
{
    public $table = 'purchased_ammo';

    protected $fillable = [
        'member_id',
        'caliber_id',
        'quantity'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }
}
