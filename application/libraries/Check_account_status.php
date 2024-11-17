<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_account_status {
    public $CI;
    function __construct() {
        $CI =& get_instance();
        $CI->load->database();
    }

    public function schools($user_id)
    {
        $CI =& get_instance();
        // default status array
        $status = array(
            "Profile"  => false ,
            "Classes"  => false ,
            "sites"    => false ,
            "Areas"    => false ,
            "Devices"  => false ,
            "Staffs"   => false ,
            "Teachers" => false ,
            "Students" => false ,
        );

        // the main data
        $school_data_from_main_table = $CI->db->get_where('l1_school', array('Id' => $user_id), 1)->result_array();
        if(!empty($school_data_from_main_table)){
            // profile verify
            $is_verifyed = $school_data_from_main_table[0]['verify'] == "1" ? true : false;
            $status['Profile'] = $is_verifyed;
            // classes verify
            
            $classes = $CI->db->query("SELECT * FROM l2_school_classes
            JOIN `r_levels` ON `r_levels`.`Id` = `l2_school_classes`.`class_key`
            WHERE `l2_school_classes`.`school_id` = '" . $user_id . "' ORDER BY `r_levels`.`Id` ASC ")->result_array();
            $status['Classes'] = empty($classes) ? false : true;
            // sites verify
            $sites = $CI->db->query("SELECT Id FROM `l2_site` WHERE Added_By = '".$user_id."'")->result_array();
            $status['sites'] = empty($sites) ? false : true;
            // Areas verify
            $areas = $CI->db->query("SELECT Id FROM `air_areas` WHERE source_id = '".$user_id."' AND `user_type` = 'school' ")->result_array();
            $status['Areas'] = empty($areas) ? false : true;
            // Devices verify
            $Devices = $CI->db->query("SELECT Id FROM l2_devices  WHERE Added_By = '".$user_id."' AND `UserType` = 'school' ")->result_array();
            $status['Devices'] = empty($Devices) ? false : true;
            // Staffs verify
            $Staffs = $CI->db->query("SELECT Id FROM l2_staff  WHERE Added_By = '".$user_id."'")->result_array();
            $status['Staffs'] = empty($Staffs) ? false : true;
            // 	l2_teacher verify
            $Teachers = $CI->db->query("SELECT Id FROM l2_teacher WHERE Added_By = '".$user_id."'")->result_array();
            $status['Teachers'] = empty($Teachers) ? false : true;
            // 	l2_teacher verify
            $Students = $CI->db->query("SELECT Id FROM 	l2_student WHERE Added_By = '".$user_id."'")->result_array();
            $status['Students'] = empty($Students) ? false : true;
        }
        return $status;
    }

}