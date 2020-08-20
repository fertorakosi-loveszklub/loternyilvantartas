<?php

namespace App\Utilities\Ammo;

use App\Caliber;
use App\Member;
use App\ShootingSession;

class PurchasedAmmoRepository
{
    public function getAmmo(Member $member, Caliber $caliber): int
    {
        return (int) optional($member->purchasedAmmo->where('caliber_id', $caliber->id)->first())->quantity;
    }

    public function increaseAmmo(Member $member, Caliber $caliber, int $quantity): int
    {
        $currentAmmo = $this->getAmmo($member, $caliber);
        return $this->setAmmo($member, $caliber, $currentAmmo + $quantity);
    }

    public function decreaseAmmo(Member $member, Caliber $caliber, int $quantity): int
    {
        return $this->increaseAmmo($member, $caliber, -$quantity);
    }

    public function setAmmo(Member $member, Caliber $caliber, int $quantity): int
    {
        $member->purchasedAmmo()->updateOrCreate(
            ['caliber_id' => $caliber->id],
            ['quantity' => $quantity]
        );

        return $quantity;
    }

    public function adjustAmmoFromGiveout(Member $member, array $calibers)
    {
        $availableCalibers = Caliber::all()->keyBy('id');

        foreach ($calibers as $caliberId => $quantity) {
            $caliber = $availableCalibers->get($caliberId);
            $currentAmmo = $this->getAmmo($member, $caliber);

            if ($quantity > $currentAmmo) {
                $this->setAmmo($member, $caliber, $quantity);
            }
        }
    }

    public function reduceAmmoAfterTakeback(Member $member, ShootingSession $session, array $calibers)
    {
        $availableCalibers = Caliber::all()->keyBy('id');

        foreach ($calibers as $caliberId => $ammoTakenBack) {
            $caliber = $availableCalibers->get($caliberId);
            $ammoGivenOut = $session->transactions
                ->where('member_id', $member->id)
                ->where('quantity', '>', 0)
                ->where('caliber_id', $caliberId)
                ->sum('quantity');

            $usedAmmo = $ammoGivenOut - $ammoTakenBack;
            $this->decreaseAmmo($member, $caliber, $usedAmmo);
        }
    }

    public function createAmmoJson($members, ShootingSession $session)
    {
        $calibers = Caliber::all();

        return collect($members)
            ->mapWithKeys(function ($member) use ($calibers, $session) {
                $ammos = collect($calibers)->mapWithKeys(function ($caliber) use ($member, $session) {
                    $alreadyGivenOut = $session->transactions()
                        ->where('member_id', $member->id)
                        ->where('caliber_id', $caliber->id)
                        ->sum('quantity');

                    return [$caliber->id => $this->getAmmo($member, $caliber) - $alreadyGivenOut];
                });

                return [$member->id => $ammos];
            })
            ->toArray();
    }
}
