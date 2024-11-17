<?php

$CI =& get_instance();

function translate_types_codes(string $types): string
{
    global $CI;
    $types = explode(",", $types);

    $result = [];
    foreach ($types as $type) {
        $result[] = $CI::USERS_TYPES[$type];
    }

    return implode(",", $result);
}

?>