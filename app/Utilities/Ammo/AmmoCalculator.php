<?php
/**
 * Created by Feki Webstudio - 2020. 01. 25.
 * @author nxu
 * @copyright Copyright (c) 2020, Feki Webstudio Kft.
 */

namespace App\Utilities\Ammo;

use App\AmmoTransaction;
use App\Caliber;

class AmmoCalculator
{
    public function getAmmo(Caliber $caliber)
    {
        return $caliber->ammoTransactions()->sum('quantity');
    }

    public function getAmmoForEachCaliber()
    {
        return AmmoTransaction::selectRaw('caliber_id')
            ->selectRaw('SUM(quantity) as ammo')
            ->groupBy('caliber_id')
            ->with('caliber')
            ->get();
    }
}
