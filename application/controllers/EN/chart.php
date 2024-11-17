<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Chart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Chart_model');
    }

    public function index()
    {
        $data['ministry_count'] = $this->Chart_model->get_ministry_count();
        $data['company_count'] = $this->Chart_model->get_company_count();
        $this->load->view('chart', $data);
    }
}
