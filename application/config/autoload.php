<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include Composer autoload
require_once FCPATH . 'vendor/autoload.php';

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
| These are the things you can load automatically:
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
*/

$autoload['packages'] = [];

$autoload['libraries'] = [
    'database',
    'encryption',
    'parser',
    'response',
    'permissions',
    'EmailSender',
    'subaccounts',
    'labels_formatter',
    'ministry_permissions'
];

$autoload['drivers'] = [];

$autoload['helper'] = [
    'url',
    'language',
    'general'
];

$autoload['config'] = [];

$autoload['language'] = [];

$autoload['model'] = [
    'schools/Basic_functions' => 'schoolHelper',
    'Helper',
    'Links'
];
