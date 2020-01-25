<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmmoTransaction extends Model
{
    protected $fillable = [
        'title',
        'quantity',
        'caliber_id'
    ];

    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }
}
