<?php

namespace CountryCheck\Drivers;

use CountryCheck\CountryCheckDriverBase;
use Throwable;

class GeoPlugin extends CountryCheckDriverBase
{
    function fetch(): ?string
    {
        try {
            return $this->getDataFromApi("http://www.geoplugin.net/json.gp?ip=" . $this->ip)?->geoplugin_countryCode ?? null;
        } catch (Throwable) {
            return null;
        }
    }
}