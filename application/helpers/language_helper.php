<?php

if (!function_exists('__')) {

    function replacePlaceHoldersWithValues($value, $options)
    {
        foreach ($options as $key => $option) {
            $value = str_replace(':' . $key, $option, $value);
        }
        return $value;
    }

    function __(string $line, $options = [])
    {
        $CI =& get_instance();
        $value = $CI->lang->line($line);

        // NOTE : use when checking for missing translations
        // if (empty($value)) throw new Exception("missing translation :" . $line);
        return empty($options) ? $value : replacePlaceHoldersWithValues($value, $options);
    }
}