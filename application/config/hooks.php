<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller'] = [
    'class' => 'CountryMiddleware',
    'function' => 'handle',
    'filename' => 'CountryMiddleware.php',
    'filepath' => 'hooks',
    'params' => [
        'acceptedCountries' => config_item("accepted_countries")
    ]
];