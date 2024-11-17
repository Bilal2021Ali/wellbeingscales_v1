<?php

namespace Menus\Types;

use CI_Controller;
use Types\MenuLink;

require_once __DIR__ . "/../../Types/MenuLink.php";

class SchoolMenu extends MenuLink
{
    protected function getIconsBasePath(): string
    {
        return "assets/images/icons/png_icons/school/";
    }
}