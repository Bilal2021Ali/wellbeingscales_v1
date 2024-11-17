<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Links extends CI_Model
{
    public $links = array();
    public $permissions = array();
    public $user = [];

    public function __construct()
    {
        global $linksdata;
        parent::__construct();
        $this->load->library('session');
        // loading the links data from the library
        $this->load->library('Routes');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata)) {
            return [];
        } else {
            $this->user = $sessiondata;
            $this->permissions = $this->db->query(" SELECT `v0_permissions`.*
            FROM `l1_school` 
            JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
            JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
            AND  `v0_permissions`.`user_type` = `l0_organization`.`Type` 
            WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' ")->row();
            // including the links
            $this->links = $this->routes->get();
        }
    }


    public function get()
    {
        $results = [];
        if (!isset($this->links[$this->user["type"]])) {
            return $results;
        }
        foreach ($this->links[$this->user["type"]] as $key => $link) {
            if ($link["protected"] == null || $this->permissions[$link["protected"]] !== 0) {
                $results[] = $link;
            }
        }
        return $results;
    }
}
