<?php

namespace Traits\schools;

trait Climates
{
    public function ClaimateSurveys(): void
    {
        if (!$this->canDealWithClimateSurveys()) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
            return;
        }

        $data['page_title'] = "Qlick Health | Climate Surveys List ";
        if ($this->input->method() == "get") {
            $this->load->model('schools/sv_school_reports');
            $data['oursurveys'] = $this->sv_school_reports->getclimatesurveyslibrary();
            $this->show('EN/schools/ClaimateSurveys', $data);
        } elseif ($this->input->method() == "put") {
            if ($this->input->input_stream('surveyId')) {
                $serv_id = $this->input->input_stream('surveyId');
                if ($this->db->query("UPDATE `scl_published_claimate` SET Status = IF(Status=1, 0, 1) WHERE Id = '" . $serv_id . "'")) {
                    echo "ok";
                }
            } else {
                echo "error";
            }
        } elseif ($this->input->method() == "post") {
            $this->publishClimateSurvey();
        }
    }

    public function canDealWithClimateSurveys(): bool
    {
        $climatePermission = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Claimate` = '1'
        WHERE  `l1_school`.`Id` = '" . $this->sessionData['admin_id'] . "'  ")->result_array();

        return !empty($climatePermission);
    }

    private function publishClimateSurvey(): void
    {
        $types = $this->input->post('type');
        $genders = $this->input->post('gender');
        $serv_id = $this->input->post('serv_id');
        $this->response->abort_if(403, empty($types) || empty($genders) || empty($serv_id));

        $user_id = $this->sessionData['admin_id'];
        $levels = $this->input->post('levels');

        $types_arr = [];
        $genders_arr = [];
        $levels_arr = [];
        $data = [
            'By_school' => $user_id,
            'climate_id' => $this->input->post('serv_id'),
            'Created' => date('Y-m-d'),
            'Time' => date("H:i:s"),
        ];
        if (!$this->db->insert('scl_published_claimate', $data)) {
            echo "error";
        }

        echo "ok";
        $serv_id = $this->db->insert_id();

        foreach ($types as $type) {
            $types_arr[] = array(
                "Climate_id" => $serv_id,
                "Type_code" => $type,
                "Created" => date('Y-m-d'),
                "Time" => date('H:i:s'),
            );
        }
        if ($this->db->insert_batch('scl_published_claimate_types', $types_arr)) {
            echo "ok";
        }
        // gender add
        foreach ($genders as $gender) {
            $genders_arr[] = array(
                "Climate_id" => $serv_id,
                "Gender_code" => $gender,
                "Created" => date('Y-m-d'),
                "Time" => date('H:i:s'),
            );
        }

        if ($this->db->insert_batch('scl_published_claimate_genders', $genders_arr)) {
            echo "ok";
        }

        if (empty($levels)) {
            echo "ok";
            return;
        }

        foreach ($levels as $level) {
            $levels_arr[] = array(
                "claimate_id" => $serv_id,
                "Level_code" => $level,
                "Created" => date('Y-m-d'),
                "Time" => date('H:i:s'),
            );
        }

        if ($this->db->insert_batch('scl_published_claimate_levels', $levels_arr)) {
            echo "ok";
        }
    }

    public function climate_surveys_list(): void
    {
        $this->load->model('schools/sv_school_reports');

        $status = intval($this->input->get('status') ?? 1);
        $this->load->view("EN/schools/climate/list-of-published-climates", [
            'published_surveys' => $this->sv_school_reports->GetClimatesurveys(['list' => true, 'status' => $status], null, true)
        ]);
    }

    public function Climate()
    {
        if (!$this->canDealWithClimateSurveys()) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
            return;
        }

        $links = [];
        $links[] = [
            'name' => "School Climate Library", "link" => base_url('EN/schools/ClaimateSurveys'),
            "desc" => "", "icon" => "library.png"
        ];
        $links[] = [
            'name' => "School Climate Details", "link" => base_url('EN/schools/Climate-Details'),
            "desc" => "", "icon" => "details.png"
        ];
        $links[] = [
            'name' => "School Climate Reports", "link" => base_url('EN/schools/Climate-Report'),
            "desc" => "", "icon" => "Daily.png"
        ];
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->show('EN/Global/Links/Lists', $data);
    }

    public function climatePreview(): void
    {
        if (!$this->canDealWithClimateSurveys()) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }

        $id = $this->uri->segment(4);
		$this->response->abort_if(404, empty($id) || !is_numeric($id));
        $this->response->abort_if(404, $this->input->method() !== 'get');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $data['choices'] = $this->db
            ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
                    sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
            ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
            ->from('scl_st_choices')
            ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
            ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
            ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
            ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
            ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
            ->where('servey_id', $this->uri->segment(4))
            ->order_by('position', 'ASC')
            ->get()->result_array();
        $this->show('EN/schools/climatePreview', $data);
    }

    public function ClimateReports()
    {
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $data['sessiondata'] = $this->sessionData;
        $this->load->library('encrypt_url');
        if (is_numeric($this->encrypt_url->safe_b64decode($this->uri->segment(4)))) {
            $data['surveyid'] = $this->encrypt_url->safe_b64decode($this->uri->segment(4));
            // exit($data['surveyid']);
            if (!empty($this->sv_school_reports->GetClimatesurveys(['surveyid' => $data['surveyid']]))) {
                $data['fulldata'] = $this->sv_school_reports->GetClimatesurveys(['surveyid' => $data['surveyid']])[0];
                $data['choices'] = $this->sv_school_reports->ClimateChoices(['surveyid' => $data['surveyid']]);
                $data['colors'] = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
                $data['types'] = explode(',', $data['fulldata']['typeslist']);
                $data['filters'] = array(
                    [
                        "name" => "type",
                        "filters" => []
                    ], [
                        "name" => "male",
                        "filters" => ['gender' => "M"]
                    ], [
                        "name" => "female",
                        "filters" => ['gender' => "F"]
                    ], [
                        "name" => "age",
                        "filters" => ['age' => [
                            'min' => 12,
                            "max" => 20
                        ]]
                    ]
                );
                $data['age'] = array('from' => 12, 'to' => 20);
                if (is_numeric($this->input->post('age_from')) && ($this->input->post('age_from') < $this->input->post('age_to'))) {
                    $data['age']['from'] = $this->input->post('age_from');
                }
                if (is_numeric($this->input->post('age_to')) && ($this->input->post('age_to') > $this->input->post('age_from'))) {
                    $data['age']['to'] = $this->input->post('age_to');
                }
                $this->show('EN/schools/ClimateReports', $data);
            } else {
                echo "Error in finding this survey";
            }
        } else {
            echo "Error in finding this survey";
        }
    }

}