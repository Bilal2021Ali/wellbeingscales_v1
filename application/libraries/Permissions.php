<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permissions
{

    public $userId = 0;
    public $type = 0;
    public $cond = 0;
    public array $cache = [];

    public function __construct()
    {
        // the session data
        $CI = &get_instance();
        $CI->load->library('session');
        $sessiondata = $CI->session->userdata('admin_details');
        if (isset($sessiondata['admin_id'])) {
            $this->userId = $sessiondata['admin_id'];
            $this->type = $sessiondata['type'];
            if ($this->type == "school") {
                $this->cond = "WHERE  `l1_school`.`Id` = '" . $this->userId . "' ";
            } else {
                $this->cond = "WHERE  `l0_organization`.`Id` = '" . $this->userId . "' ";
            }
        }
    }


    public function temperatureandlabs()
    {
        $CI = &get_instance();
        $prms = $CI->db->query(" SELECT `v0_permissions`.`TemperatureAndLab` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`TemperatureAndLab` = '1'
        $this->cond ")->result_array();
        if (!empty($prms)) {
            return true;
        } else {
            return false;
        }
    }

    public function attendance(): bool
    {
        return $this->permission('attendance');
    }

    private function permission(string $key): bool
    {
        if (isset($this->cache[$key])) return $this->cache[$key];

        $CI = &get_instance();
        $check = $CI->db->query(" SELECT `v1_permissions`.`" . $key . "` , `v1_permissions`.`Created`
        FROM `l1_school` 
        JOIN `v1_permissions` ON `v1_permissions`.`user_id` = `l1_school`.`Id` AND `v1_permissions`.`user_type` = 'school'
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l1_school`.`Added_By` AND `v0_permissions`.`user_type` = 'Ministry'
        AND  `v1_permissions`.`" . $key . "` = '1' AND `v0_permissions`.`" . $key . "` = '1'
        WHERE  `l1_school`.`Id` = '" . $this->userId . "' LIMIT 1 ")->result_array();

        $this->cache[$key] = !empty($check);
        return $this->cache[$key];
    }

    public function accessdenied()
    {
        $CI = &get_instance();
        $CI->load->view("EN/Global/Components/accessdenied");
    }

    public function apicopy()
    {
        $CI = &get_instance();
        $perm = $CI->db->get_where("l0_global_settings", ["Id" => 1])->row();
        if ($perm->api_copy == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function school()
    {
        $CI = &get_instance();
        return $CI->db->query(" SELECT `v1_permissions`.*
        FROM `l1_school` 
        JOIN `v1_permissions` ON `v1_permissions`.`user_id` = `l1_school`.`Id` AND `v1_permissions`.`user_type` = 'school'
        WHERE  `l1_school`.`Id` = '" . $this->userId . "'   ")->result_array()[0] ?? [];
    }

    public function qmCommunity()
    {
        $CI = &get_instance();
        $check = $CI->db->query(" SELECT `v1_permissions`.`qmcommunity` , `v1_permissions`.`Created`
        FROM `l1_school` 
        JOIN `v1_permissions` ON `v1_permissions`.`user_id` = `l1_school`.`Id` AND `v1_permissions`.`user_type` = 'school'
        AND  `v1_permissions`.`qmcommunity` = '1'
        WHERE  `l1_school`.`Id` = '" . $this->userId . "' LIMIT 1 ")->result_array();
        return !empty($check);
    }

    public function incidents(): bool
    {
        return $this->permission('incidents');
    }

    public function smart_qr_code()
    {
        $CI = &get_instance();
        $check = $CI->db->query(" SELECT `v0_permissions`.`smart_qr_code` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN l0_organization ON l0_organization.Id = l1_school.Added_By
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`Id` AND `v0_permissions`.`user_type` = 'Ministry'
        AND  `v0_permissions`.`smart_qr_code` = '1'
        WHERE  `l1_school`.`Id` = '" . $this->userId . "' LIMIT 1 ")->result_array();
        return !empty($check);
    }


}
