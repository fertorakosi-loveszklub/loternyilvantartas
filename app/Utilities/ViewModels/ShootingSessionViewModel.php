<?php
/**
 * Created by Feki Webstudio - 2020. 01. 25.
 * @author nxu
 * @copyright Copyright (c) 2020, Feki Webstudio Kft.
 */

namespace App\Utilities\ViewModels;

use App\ShootingSession;

class ShootingSessionViewModel
{
    public $created_at;
    public $title;
    public $ammoSummary;

    public function __construct(ShootingSession $model, $ammoSummary)
    {
        $this->created_at = $model->created_at;
        $this->title = $model->title;
        $this->ammoSummary = $ammoSummary;
    }
}
