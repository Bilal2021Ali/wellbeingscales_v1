<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Labels_formatter
{
    const SHOW_BY_DEFAULT = 5;

    public function format(?string $value, int $take = self::SHOW_BY_DEFAULT)
    {
        $labels = explode(",", $value ?? "");
        return array_slice($labels, 0, $take);
    }

    public function hasMore(?string $value, int $take = self::SHOW_BY_DEFAULT)
    {
        $labels = explode(",", $value ?? "");
        return sizeof($labels) > $take;
    }
}