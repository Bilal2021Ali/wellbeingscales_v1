<?php

namespace App\Traits\schools;

require_once __DIR__ . "/../Shared/RefrigeratorCards.php";

use App\Traits\Shared\RefrigeratorCards;

/**
 * @property array $sessionData
 */
trait SchoolRefrigeratorResults
{

    use RefrigeratorCards;

    public function refrigerator_cards(): void
    {
        $userId = $this->sessionData['admin_id'];
        $this->showRefrigeratorCards($userId);
    }

}