<?php

namespace Traits\Ministry;

trait Profile
{

    private function loadMinistryProfileLanguage(): self
    {
        $this->lang->load('MinistryProfile', self::LANGUAGE === "EN" ? "english" : "arabic");
        return $this;
    }

    public function profile()
    {
        $this->load->library('session');
        $data['page_title'] = "Qlick System | Profile ";

        $Id = $this->sessionData['admin_id'];
        $data['profile'] = $this->db->where("Id", $Id)->limit(1)->get("l0_organization")->result_array()[0] ?? null;
        $this->response->abort_if(404, empty($data['profile']));

        if ($this->input->method() === "post") {
            $this->saveMinistryProfile();
            return;
        }

        $data['countries'] = $this->db->order_by("Name", "asc")->get("r_countries")->result_array();
        $data['JORDAN'] = $this->JORDAN;
        $data['language'] = self::LANGUAGE;

        $this->loadMinistryProfileLanguage()->show('EN/Profiles/Ministry_Profile', $data);
    }


    private function saveMinistryProfile()
    {
        $this->loadMinistryProfileLanguage()->load->library('form_validation');
        $this->form_validation->set_rules('AR_Title', 'Arabic Title', 'trim|required');
        $this->form_validation->set_rules('EN_Title', 'English Title', 'trim|required');
        $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
        $this->form_validation->set_rules('Manager', 'Manager', 'trim|required|min_length[2]|max_length[20]');

        if (!$this->form_validation->run()) {
            $this->response->json(['status' => "error", "message" => validation_errors()]);
        }


        $data = [
            'AR_Title' => $this->input->post('AR_Title') ?? "",
            'EN_Title' => $this->input->post('EN_Title') ?? "",
            'Tel' => $this->input->post('Phone') ?? "",
            'Manager' => $this->input->post('Manager') ?? "",
            'Email' => $this->input->post('Email') ?? "",
            'verify' => 1
        ];

        $this->db->where('Id', $this->sessionData['admin_id'])->set($data)->update('l0_organization');
        $this->response->json(['status' => "ok"]);
    }

}