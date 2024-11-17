<?php
defined('BASEPATH') or exit ('No direct script access allowed');

require_once __DIR__ . "/../Menus/SchoolMenus.php";

class Healthy extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($sessiondata)) {
            if ($sessiondata['level'] == 2 && $sessiondata['type'] == "school") {
            } else if ($sessiondata['type'] == "School_Perm" && $method == "POST") {
            } else {
                redirect('EN/users');
                exit();
            }
            $data['temperatureandlabs'] = $this->permissions->temperatureandlabs();
            $data['attendance_permissions'] = $this->permissions->attendance();
            $data['apicopy'] = $this->permissions->apicopy();
            $this->permissions_array["temperatureandlabs"] = $data['temperatureandlabs'];
            $this->permissions_array["apicopy"] = $data['apicopy'];
            $this->permissions_array["attendance_permissions"] = $data['attendance_permissions'];
            $this->sessiondata = $sessiondata;
            $this->load->vars($data);
        } else {
            redirect('EN/users');
            exit();
        }
    }

    public function New()
    {
        if (!$this->permissions->qmCommunity()) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
            return;
        }
        $this->load->library('session');
        $this->load->model('HealthyModal');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $sessiondata;
        // validate language or fallback on en
        $language = $this->uri->segment(3) ? $this->uri->segment(3) : "en";
        if (!$this->HealthyModal->ValidateLanguage($language)) {
            redirect('Healthy/EN');
            return;
        }
        $data['activeLanguage'] = strtolower($this->uri->segment(3) ? $this->uri->segment(3) : 'en');
        if (!in_array($data['activeLanguage'], ['ar', 'en'])) {
            echo "Invalid Link";
            return;
        }
        $data += $this->HealthyModal->langauge($language)->get();
        $this->lang->load('QM', $data['activeLanguage'] == "en" ? "english" : "arabic");
        $data['counters'] = [10, 50, 100];
        $data['classesNames'] = ['warning', 'success', 'danger'];
        $data['languages'] = $this->HealthyModal::SUPPORTED_LANGUAGES;
        $this->load->view(strtoupper($data['activeLanguage']) . '/inc/header', $data);
        $this->load->view('Healthy/index');
        $this->load->view(strtoupper($data['activeLanguage']) . '/inc/footer');
    }

    public function save()
    {
        if (!$this->permissions->qmCommunity()) {
            $this->response->json(['status' => 'error', 'message' => 'invalid data']);
            return;
        }
        $this->load->model('HealthyModal');
        $this->load->library('encrypt_url');
        if ($this->input->method() !== "post") {
            $this->response->json(['status' => 'error', 'message' => 'sorry we had an unexpected error please refresh the page and try again']);
        }

        $language = $this->uri->segment(3) ? $this->uri->segment(3) : "en";

        if (!$this->HealthyModal->ValidateLanguage($language)) {
            $this->response->json(['status' => 'error', 'message' => 'invalid data']);
        }

        $data = $this->input->post();
        if (!isset($data['answers']) || !isset($data['priorities'])) {
            $this->response->json(['status' => 'error', 'message' => 'invalid data']);
        };

        $mergedData = [];
        foreach ($data['answers'] as $answer) {
            $priority = array_filter($data['priorities'], function ($value) use ($answer) {
                return $value['question'] == $answer['question'];
            });
            if (empty($priority)) { // skip if the priority is invalid
                continue;
            }
            $answer += ['priority' => array_values($priority)[0]['id'], 'priorityValue' => array_values($priority)[0]['value']];
            $mergedData[] = $answer;
        }

        if (empty($mergedData)) {
            $this->response->json(['status' => 'error', 'message' => 'invalid data']);
        }

        $id = $this->HealthyModal->save($mergedData);
        $key = $this->encrypt_url->safe_b64encode($id);

        $this->response->json(['status' => 'ok', 'key' => $key]);
    }


    public function Results()
    {
        if (!$this->permissions->qmCommunity()) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
            return;
        }
        $this->load->model('HealthyModal');
        $this->load->library('encrypt_url');
        $key = $this->uri->segment(3) ? $this->uri->segment(3) : null;
        $language = $this->uri->segment(4) ? $this->uri->segment(4) : 'en';
        $language = in_array(strtolower($language), ['en', 'ar']) ? strtolower($language) : 'en';
        if (empty($key)) {
            redirect('Healthy/History');
            return;
        }

        $key = $this->encrypt_url->safe_b64decode($key);
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->session->userdata('admin_details');
        $data += $this->HealthyModal->langauge("en")->getResults($key);
        $data['activeLanguage'] = $language;
        $this->load->view(strtoupper($language ?? 'en') . '/inc/header', $data);
        $this->load->view('Healthy/results');
        $this->load->view('EN/inc/footer');
    }
}