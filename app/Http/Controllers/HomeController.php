<?php

namespace App\Http\Controllers;

use App\Utilities\Ammo\AmmoCalculator;
use App\Utilities\Shooting\ShootingSessionRepository;

class HomeController extends Controller
{
    public function index(AmmoCalculator $ammoCalculator, ShootingSessionRepository $sessionRepository)
    {
        $ammos = $ammoCalculator->getAmmoForEachCaliber();
        $session = $sessionRepository->getActiveSession();

        return view('home', compact('ammos', 'session'));
    }
}
