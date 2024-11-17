<?php

class Chart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Database code to retrieve the count of organizations of different types
        $this->load->database();
        $this->db->select('COUNT(*) as count');
        $this->db->from('l0_organization');
        $this->db->where('Type', 'Ministry');
        $query = $this->db->get();
        $ministry_count = $query->row()->count;
        $this->db->select('COUNT(*) as count');
        $this->db->from('l0_organization');
        $this->db->where('Type', 'Company');
        $query = $this->db->get();
        $company_count = $query->row()->count;
        
        // Highcharts code to create the chart
        $this->load->library('highcharts');
        $chart = $this->highcharts->load();
        $chart->chart->type = 'bar';
        $chart->title->text = 'Number of Organizations';
        $chart->xAxis->categories = array('Ministry', 'Company');
        $chart->yAxis->title->text = 'Count';
        $chart->series[] = array('name' => 'Organizations', 'data' => array($ministry_count, $company_count));
        echo $chart;
    }
}
