<?php

namespace Menus;

use CI_Controller;
use Illuminate\Support\Collection;
use Interfaces\IMenuProvider;
use Menus\Types\MinistryMenu;


require_once __DIR__ . "/../Interfaces/IMenuProvider.php";
require_once __DIR__ . "/BaseMenu.php";
require_once __DIR__ . "/Types/MinistryMenu.php";

class MinistryMenus extends BaseMenu
{
    private const PREFIX = "DashboardSystem";
    public const LINKS = [
        [
            'title' => 'dashboard',
            'icon' => 'dashboardicon.png',
            'uri' => '',
            'permission' => 'dashboard'
        ],
        [
            'title' => 'profile',
            'icon' => 'profilem.png',
            'uri' => '/Profile',
            'permission' => 'profile'
        ],
        [
            'title' => 'school_list',
            'icon' => 'addschool.png',
            'uri' => '/addSchool',
            'permission' => ''
        ],
        [
            'title' => 'school_perm',
            'icon' => 'addschool.png',
            'uri' => '/UpdateSchool',
            'permission' => 'schoollist'
        ],
        [
            'title' => 'wellbeing',
            'icon' => 'wellnessicon.png',
            'uri' => '/wellness',
            'permission' => 'wellbeing'
        ],
        [
            'title' => 'wellbeing_report',
            'icon' => 'categoryicons.png',
            'uri' => '/categorys-reports',
            'permission' => 'categories'
        ],
        [
            'title' => 'site_reports',
            'icon' => 'sitelocation.png',
            'uri' => '/sites-reports',
            'permission' => 'sitereports'
        ],
        [
            'title' => 'ai_report',
            'icon' => 'aireports.png',
            'uri' => '/reports-routes',
            'permission' => 'aireports'
        ],
        [
            'title' => 'lab_report',
            'icon' => 'labreportsicon.png',
            'uri' => '/Lab-Reports',
            'permission' => 'labreports'
        ],
        [
            'title' => 'consultant',
            'icon' => 'labreportsicon.png',
            'uri' => '/Consultants',
            'permission' => 'counselor'
        ],
        [
            'title' => 'controllers',
            'icon' => 'consultation.png',
            'uri' => '/controllers',
            'permission' => 'controllers'
        ],
        [
            'title' => 'school_climate',
            'icon' => 'climate.png',
            'uri' => '/ClimatesLinks',
            'permission' => 'Claimate'
        ],
        [
            'title' => 'qm',
            'icon' => 'climate.png',
            'uri' => '/QM',
            'permission' => 'qmcommunity'
        ],
        [
            'title' => 'courses',
            'icon' => 'consultation.png',
            'uri' => '/courses',
            'permission' => 'courses'
        ],
        [
            'title' => 'speak_out',
            'icon' => 'consultation.png',
            'uri' => '/speak-out-links',
            'permission' => 'speak_out'
        ],
    ];
    public CI_Controller $controller;

    public function __construct(public string $language = "en")
    {
        $this->controller = &get_instance();
        $this->controller->lang->load('ministry_menu', get_full_language_name($this->language));
        $this->controller->load->library('ministry_permissions');
    }

    public function list(): Collection
    {
        return collect(self::LINKS)->map(function (array $link) {
            $url = $this->withLanguage(self::PREFIX . $link['uri']);
            $menu = new MinistryMenu(name: $link['title'], link: $url, icon: $link['icon']);

            if (isset($link['permission']) && !$this->controller->ministry_permissions->has($link['permission'])) {
                $menu->setIsVisible(false);
            }

            return $menu;
        });
    }
}