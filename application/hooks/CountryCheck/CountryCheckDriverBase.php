<?php

namespace CountryCheck;

use CI_Controller;

abstract class CountryCheckDriverBase
{
    public CI_Controller $CI;

    public function __construct(public string $ip)
    {
        $this->CI =& get_instance();
    }

    public function getDataFromApi(string $url): ?object
    {
        if ($this->get_http_response_code($url) != "200") {
            return null;
        }

        return json_decode(file_get_contents($url));
    }

    protected function get_http_response_code($url): string
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

    public function get(): ?string
    {
        $name = $this->fetch();
        return empty($name) ? null : strtolower($name);
    }

    abstract function fetch(): ?string;
}