<?php

namespace Menus;

use CI_Controller;
use Illuminate\Support\Collection;
use Interfaces\IMenuProvider;
use Menus\Types\SchoolMenu;

require_once __DIR__ . "/../Interfaces/IMenuProvider.php";
require_once __DIR__ . "/Types/SchoolMenu.php";
require_once __DIR__ . "/BaseMenu.php";

class SchoolMenus extends BaseMenu
{
    // title is the key for the translation
    public const LINKS = [
        [
            'title' => 'dashboard',
            'icon' => 'dashboardschool.png',
            'uri' => 'schools/dashboard',
            'subUser' => ['key' => 'dashboard', 'isList' => false],
        ],
        [
            'title' => 'status',
            'icon' => 'dashboardschool.png',
            'uri' => 'schools',
            'subUser' => ['key' => 'disabled', 'isList' => false],
        ],
        [
            'title' => 'my_profile',
            'icon' => 'myprofileschool.png',
            'uri' => 'schools/Profile',
            'subUser' => ['key' => 'profile', 'isList' => false],
        ],
        [
            'title' => 'add_device',
            'icon' => 'adddeviceschool.png',
            'uri' => 'schools/AddDevice',
            'subUser' => ['key' => 'add-device', 'isList' => false],
        ],
        [
            'title' => 'add_members',
            'icon' => 'addmembersschool.png',
            'uri' => 'schools/AddMembers',
            'subUser' => ['key' => 'add-members', 'isList' => false],
        ],
        [
            'title' => 'load_from_csv',
            'icon' => 'addmembersschool.png',
            'uri' => 'schools/LoadFromCsv',
            'subUser' => ['key' => 'load-from-csv', 'isList' => false],
        ],
        [
            'title' => 'list_all',
            'icon' => 'listall.png',
            'uri' => 'schools/List-all',
            'subUser' => ['key' => 'lists', 'isList' => true],
        ],
        [
            'title' => 'temp_tests',
            'icon' => 'tempschool.png',
            'uri' => 'schools/Tests',
            'subUser' => ['key' => 'tests', 'isList' => false],
            'permission' => ['key' => 'TemperatureAndLab', 'isSchool' => false]
        ],
        [
            'title' => 'incidents',
            'icon' => 'tempschool.png',
            'uri' => 'schools/incidents',
            'subUser' => ['key' => 'incidents', 'isList' => true],
            'permission' => ['key' => 'incidents', 'isSchool' => true]
        ],
        [
            'title' => 'lab_tests',
            'icon' => 'labtestschool.png',
            'uri' => 'schools/Lab-Tests',
            'subUser' => ['key' => 'lab-tests', 'isList' => false],
            'permission' => ['key' => 'TemperatureAndLab', 'isSchool' => false]
        ],
        [
            'title' => 'wellbeing',
            'icon' => 'wellbeing.png',
            'uri' => 'schools/wellness',
            'subUser' => ['key' => 'wellness', 'isList' => false],
            'permission' => ['key' => 'surveys', 'isSchool' => false]
        ],
        [
            'title' => 'wellbeing_report',
            'icon' => 'categoryschool.png',
            'uri' => 'schools/categorys-reports',
            'subUser' => ['key' => 'categories-reports', 'isList' => false],
            'permission' => ['key' => 'surveys', 'isSchool' => false]
        ],
        [
            'title' => 'reports_routes',
            'icon' => 'monitorschool.png',
            'uri' => 'schools/reports-routes',
            'subUser' => ['key' => 'reports', 'isList' => true]
        ],
        [
            'title' => 'monitor',
            'icon' => 'monitorschool.png',
            'uri' => 'schools/Monitors_routes',
            'subUser' => ['key' => 'monitors-routes', 'isList' => true],
            'permission' => ['key' => 'TemperatureAndLab', 'isSchool' => false]
        ],
        [
            'title' => 'attendance',
            'icon' => 'monitorschool.png',
            'uri' => 'schools/attendance',
            'subUser' => ['key' => 'attendance', 'isList' => true],
            'permission' => ['key' => 'attendance', 'isSchool' => true]
        ],
        [
            'title' => 'air_quality',
            'icon' => 'airqualityschool.png',
            'uri' => 'schools/Air-Quality-Dashboard',
            'subUser' => ['key' => 'air-quality-dashboard', 'isList' => false],
            'permission' => ['key' => 'Air_quality', 'isSchool' => false]
        ],
	
        [
            'title' => 'vehicles',
            'icon' => 'Vehicle.png',
            'uri' => 'schools/Vehicles-list',
            'subUser' => ['key' => 'vehicles-list', 'isList' => false],
            'permission' => ['key' => 'cars', 'isSchool' => false]
        ],
        [
            'title' => 'smart_qr',
            'icon' => 'qr-code.png',
            'uri' => 'schools/smartqrcode',
            'subUser' => ['key' => 'smart-qr-code', 'isList' => false],
            'permission' => ['key' => 'smart_qr_code', 'isSchool' => false]
        ],
        [
            'title' => 'speak_out',
            'icon' => 'speakoutschool.png',
            'uri' => 'schools/speak-out-links',
            'subUser' => ['key' => 'speak-out', 'isList' => true],
        ],
        [
            'title' => 'news_updates',
            'icon' => 'userpages.png',
            'uri' => 'schools/L3-config',
            'subUser' => ['key' => 'l3-config', 'isList' => false],
        ],
        [
            'title' => 'school_climate',
            'icon' => 'climateschool.png',
            'uri' => 'schools/Climate',
            'subUser' => ['key' => 'climate', 'isList' => true],
            'permission' => ['key' => 'Claimate', 'isSchool' => false]
        ],
		
        [
            'title' => 'qm',
            'icon' => 'councler.png',
            'addLanguageToEnd' => true,
            'uri' => 'Healthy/New',
            'subUser' => ['key' => 'qm-healthy', 'isList' => false],
            'permission' => ['key' => 'qmcommunity', 'isSchool' => true]
        ],
        [
            'title' => 'consultant',
            'icon' => 'councler.png',
            'uri' => 'schools/Consultant',
            'subUser' => ['key' => 'consultant', 'isList' => true],
        ],
        [
            'title' => 'access_rights',
            'icon' => 'councler.png',
            'uri' => 'schools/assistance-accounts',
            'subUser' => ['key' => 'disabled', 'isList' => false],
        ],
        [
            'title' => 'courses',
            'icon' => 'councler.png',
            'uri' => 'schools/courses',
            'subUser' => ['key' => 'courses', 'isList' => false],
        ],
    ];


    public CI_Controller $controller;

    public function __construct(public string $language = "en")
    {
        $this->controller = &get_instance();

        $this->controller->lang->load('school_menu', get_full_language_name($this->language));
        $this->controller->load->library('school_permissions');
        $this->controller->load->library('Subaccounts');
    }

    /**
     * @return Collection<SchoolMenu>
     */
    public function list(): Collection
    {
        return collect(self::LINKS)->map(function (array $link): SchoolMenu {
            $menu = new SchoolMenu(
                name: $link['title'],
                link: $this->withLanguage($link['uri'], $link['addLanguageToEnd'] ?? false),
                icon: $link['icon']
            );

            if (isset($link['permission'])) {
                $result = $this->controller->school_permissions->has($link['permission']['key'], $link['permission']['isSchool'] ?? false);
                $menu->setIsVisible($result);

                if (!$result) return $menu;
            }

            if (isset($link['subUser'])) {
                if ($link['subUser']['isList']) {
                    $result = $this->controller->subaccounts->hasAny($link['subUser']['key']);
                } else {
                    $result = $this->controller->subaccounts->can($link['subUser']['key']);
                }

                $menu->setIsVisible($result);
            }

            return $menu;
        });
    }

    public function __toString(): string
    {
        return $this->print();
    }
}