<?php

namespace App\Http\Controllers;

use App\Caliber;
use App\Member;
use App\ShootingSession;
use App\Utilities\Ammo\PurchasedAmmoRepository;
use App\Utilities\Shooting\ShootingSessionRepository;
use Illuminate\Http\Request;

class ShootingController extends Controller
{
    public function index(ShootingSessionRepository $repo, PurchasedAmmoRepository $ammoRepo)
    {
        $session = $repo->getActiveSession();

        if (empty($session)) {
            $sessions = $repo->getSessionHistory();

            return view('shootings', compact('sessions', 'repo'));
        }

        $ammoSummary = $repo->getAmmoSummary($session);
        $transactions = $repo->getTransactions($session);
        $calibers = Caliber::orderBy('name')->get();
        $members = Member::with('purchasedAmmo')->orderBy('name')->get();
        $memberAmmo = $ammoRepo->createAmmoJson($members, $session);

        return view('shooting', compact(
            'session',
            'ammoSummary',
            'transactions',
            'calibers',
            'members',
            'memberAmmo'
        ));
    }

    public function create()
    {
        return view('shooting_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        ShootingSession::create($request->only('title'));

        return redirect()->route('shooting.index');
    }

    public function giveout(Request $request, ShootingSessionRepository $repository)
    {
        $repository->giveout($repository->getActiveSession(), $request);
        return redirect()->route('shooting.index');
    }

    public function takeback(Request $request, ShootingSessionRepository $repository)
    {
        $repository->takeback($repository->getActiveSession(), $request);
        return redirect()->route('shooting.index');
    }

    public function finish(ShootingSessionRepository $repository)
    {
        $repository->finishSession($repository->getActiveSession());
        return redirect()->route('shooting.index');
    }
}
