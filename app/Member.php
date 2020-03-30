<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'birth_year',
        'name',
    ];

    public function purchasedAmmo()
    {
        return $this->hasMany(PurchasedAmmo::class);
    }
}
