<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Chart_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_ministry_count()
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('l0_organization');
        $this->db->where('Type', 'Ministry');
        $query = $this->db->get();
        return $query->row()->count;
    }

    public function get_company_count()
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('l0_organization');
        $this->db->where('Type', 'Company');
        $query = $this->db->get();
        return $query->row()->count;
    }
}
