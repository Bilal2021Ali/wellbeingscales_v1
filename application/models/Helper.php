<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helper extends CI_Model
{
    public $usertype = null;
    public $target = null;
    public $lang = "en";
    public $onlycodes = false;
    public $singular = false;
    // valid
    public $key = null;
    public $alltypes = [
        "single" => [
            "satff" => [
                'name_en' => "staff",
                'name_ar' => "موظف",
                "code" => 1,
            ],
            "students" => [
                'name_en' => "student",
                'name_ar' => "طالب",
                "code" => 2,
            ],
            "teachers" => [
                'name_en' => "teacher",
                'name_ar' => "معلم",
                "code" => 3,
            ],
            "parents" => [
                'name_en' => "parents",
                'name_ar' => "ولي أمر",
                "code" => 4,
            ],
        ],
        "plural" => [
            "satff" => [
                'name_en' => "staff",
                'name_ar' => "موظفين",
                "code" => 1,
            ],
            "students" => [
                'name_en' => "students",
                'name_ar' => "طالب",
                "code" => 2,
            ],
            "teachers" => [
                'name_en' => "teachers",
                'name_ar' => "معلم",
                "code" => 3,
            ],
            "parents" => [
                'name_en' => "parents",
                'name_ar' => "أولياء الامور",
                "code" => 4,
            ],
        ]
    ];
    public function TypesReferences()
    {
        $types = [
            'Ministry' => [
                "table" => "l0_organization",
                "homescreen" => "DashboardSystem",
            ],
            'Company' => [
                "table" => "l0_organization",
                "homescreen" => "Company",
            ],
            'school' => [
                "table" => "l1_school",
                "homescreen" => "schools",
            ],
            'department_Company' => [
                "table" => "l1_co_department",
                "homescreen" => "Company_Departments"
            ]
        ];
        return $types;
    }

    public function forCompany($id)
    {
        if (gettype($id) == "string") {
            $condition = "`l2_co_patient`.`Added_By` IN (" . $id . ") ";
        } else {
            $condition = "`l2_co_patient`.`Added_By` = '" . $id . "'";
        }
        $supported_types = $this->db->query("SELECT `r_usertype`.`code` , r_usertype.Id ,`r_usertype`.`UserType` AS name_en , `r_usertype`.`AR_UserType` AS name_ar
        FROM `r_usertype` 
        JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
        AND $condition GROUP BY `r_usertype`.`Id`")->result_array();
        $data = array();
        foreach ($supported_types as $key => $type) {
            $data[$type['name_en']] = [
                "name_en" => $type['name_en'],
                "name_ar" => $type['name_ar'],
                "code" => $type['Id'],
            ];
        }
        $result['plural'] = $data;
        $result['single'] = $data;
        $this->alltypes = $result;
        return $this;
    }

    public function isThere()
    {
        return empty($this->alltypes) ? false : true;
    }

    public function Language($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    public function onlycodes()
    {
        $this->onlycodes = true;
        return $this;
    }

    public function singular()
    {
        $this->singular = true;
        return $this;
    }

    public function only($u)
    {
        $this->usertype = $u;
        return $this;
    }

    public function get()
    {
        $result = [];
        $getfrom = $this->alltypes['plural'];
        if ($this->singular) {
            $getfrom = $this->alltypes['single'];
        }
        if ($this->usertype !== null) {
            foreach ($getfrom as $key => $value) {
                if ($key == $this->usertype) {
                    $getfrom = [$key => $value];
                }
            }
        }
        if ($this->onlycodes) {
            return array_column($this->getfrom, 'code');
        }
        foreach ($getfrom as $key => $value) {
            $result[] = ['name' => $value[$this->lang == "en" ? "name_en" : "name_ar"], "code" => $value['code']];
        }
        return $result;
    }

    public function set($k)
    {
        $this->key = $k;
        return $this;
    }

    public function isValid()
    {
        $found = false;
        $i = 0;
        $data = array_column($this->alltypes['single'], 'code');
        while (!$found && $i < sizeof($this->alltypes['single'])) {
            if ($data[$i] == $this->key) $found = true;
            $i++;
        }
        return $found;
    }
}
