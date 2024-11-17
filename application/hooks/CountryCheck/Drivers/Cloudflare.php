<?php

namespace CountryCheck\Drivers;

use CountryCheck\CountryCheckDriverBase;

class Cloudflare extends CountryCheckDriverBase
{
    function fetch(): ?string
    {
        $cloudflareCountry = $this->CI->input->get_request_header("cf-ipcountry");

        if (empty($cloudflareCountry)) {
            return null;
        }
        return strtolower($cloudflareCountry);
    }
}