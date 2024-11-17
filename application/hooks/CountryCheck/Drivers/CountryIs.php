<?php

namespace CountryCheck\Drivers;

use CountryCheck\CountryCheckDriverBase;
use Throwable;

class CountryIs extends CountryCheckDriverBase
{

    function fetch(): ?string
    {
        try {
            return $this->getDataFromApi("https://api.country.is/" . $this->ip)?->country ?? null;
        } catch (Throwable) {
            return null;
        }
    }
}