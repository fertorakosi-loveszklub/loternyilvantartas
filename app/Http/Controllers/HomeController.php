<?php

namespace App\Http\Controllers;

use App\Utilities\Ammo\AmmoCalculator;

class HomeController extends Controller
{
    public function index(AmmoCalculator $ammoCalculator)
    {
        $ammos = $ammoCalculator->getAmmoForEachCaliber();

        return view('home', compact('ammos'));
    }
}
