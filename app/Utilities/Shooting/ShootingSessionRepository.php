<?php
/**
 * Created by Feki Webstudio - 2020. 01. 25.
 * @author nxu
 * @copyright Copyright (c) 2020, Feki Webstudio Kft.
 */

namespace App\Utilities\Shooting;

use App\AmmoTransaction;
use App\ShootingSession;
use App\Utilities\ViewModels\ShootingSessionViewModel;

class ShootingSessionRepository
{
    public function getActiveSession()
    {
        return ShootingSession::whereNull('closed_at')->first();
    }

    public function getSessionHistory()
    {
        $sessions = ShootingSession::orderBy('closed_at', 'desc')
            ->paginate(10);

        $sessions->getCollection()
            ->transform(function ($session) {
                return new ShootingSessionViewModel($session, $this->getAmmoSummary($session));
            });

        return $sessions;
    }

    public function getTransactions(ShootingSession $session)
    {
        return $session->transactions()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAmmoSummary(ShootingSession $session)
    {
        return $session->transactions()
            ->selectRaw('caliber_id')
            ->selectRaw('SUM(quantity) as ammo')
            ->groupBy('caliber_id')
            ->with('caliber')
            ->get()
            ->sortBy('caliber.name')
            ->filter->ammo;
    }

    public function giveout(ShootingSession $session, $request)
    {
        $this->saveQuantityChange($session, $request);
    }

    public function takeback(ShootingSession $session, $request)
    {
        $this->saveQuantityChange($session, $request, -1);
    }

    public function finishSession(ShootingSession $session)
    {
        if (! empty($session->closed_at)) {
            throw new \Exception('A lövészet már korábban lezárásra került.');
        }

        $ammoSummary = collect($this->getAmmoSummary($session))
            ->filter(function ($ammo) {
                return $ammo->ammo > 0;
            });

        foreach ($ammoSummary as $ammo) {
            AmmoTransaction::create([
                'caliber_id' => $ammo->caliber_id,
                'quantity' => $ammo->ammo * -1,
                'title' => $session->title
            ]);
        }

        $session->update(['closed_at' => now()]);
    }

    protected function saveQuantityChange(ShootingSession $session, $request, $multiplier = 1)
    {
        $transactions = collect($request->get('quantity'))
            ->map(function($quantity, $caliberId) use ($multiplier) {
                return [
                    'quantity' => $quantity * $multiplier,
                    'caliber_id' => $caliberId,
                ];
            })
            ->filter->quantity
            ->toArray();

        $session->transactions()->createMany($transactions);
    }
}
