<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caliber extends Model
{
    protected $fillable = [
        'name'
    ];

    public function ammoTransactions()
    {
        return $this->hasMany(AmmoTransaction::class);
    }
}
