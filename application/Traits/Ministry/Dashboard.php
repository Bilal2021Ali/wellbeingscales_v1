<?php

namespace Traits\Ministry;

trait Dashboard
{
    public function index(): void
    {
        $language = self::LANGUAGE === "EN" ? "english" : "arabic";

        $this->load->library('session');
        $this->load->library('encrypt_url');

        $this->lang->load('MinistryDashboard', $language);
        $this->lang->load('general', $language);

        $userId = $this->sessionData['admin_id'];

        $data['activeLanguage'] = self::LANGUAGE;
        $data['list_Tests'] = $this->db->get("r_testcode")->result_array();
        $data['today'] = date("Y-m-d");
        $data['our_schools'] = $this->db->query("SELECT School_Name_EN, School_Name_AR, Username, Type_Of_School, Country, Citys, Id ,status
        FROM `l1_school` 
        WHERE `Added_By` = '" . $userId . "' ORDER BY `Id` DESC ")->result_array();
        $data['departments'] = $this->db->query('SELECT Dept_Name_AR, Dept_Name_EN, Type_Of_Dept, Username, Citys, status , Id as Dept_Id 
        FROM l1_department 
        WHERE Added_By = "' . $userId . '" ORDER BY `Id` ASC')->result_array();

        $this->load->model('ministry/Ministry_Functions');
        $this->load->model('ministry/sv_ministry_reports');

        $this->Ministry_Functions->setSchools(array_column($data['our_schools'], "Id"));

        $data['cards'] = $this->Ministry_Functions->DashboardCards();
        $data['counters'] = $this->Ministry_Functions->counters();
        $data['genders']['m'] = $this->Ministry_Functions->countUsersByGender("M");
        $data['genders']['f'] = $this->Ministry_Functions->countUsersByGender("F");
        $data['tempresults'] = $this->Ministry_Functions->tempresults();
        $data['labresults'] = $this->Ministry_Functions->LabResults();
        $data['schools_q'] = $this->Ministry_Functions->SchoolsData("Quarantine");
        $data['schools_h'] = $this->Ministry_Functions->SchoolsData("Home");
        $data['filters'] = [
            'school' => "",
            'title' => "",
        ];
//        $this->response->json($data);
        if ($this->input->method() == "post") {
            $data['filters']['school'] = ($this->input->post('school') && is_numeric($this->input->post('school'))) ? $this->input->post('school') : "";
            $data['filters']['title'] = $this->input->post('search');
        }

        $data['expired_surveys'] = $this->sv_ministry_reports->expired_surveys();
        $data['completed_surveys'] = $this->sv_ministry_reports->completed_surveys();
        $data['our_surveys'] = $this->sv_ministry_reports->our_surveys($userId);
        $data['used_categorys'] = $this->sv_ministry_reports->usedcategorys();

        $today = date("Y-m-d");
        $data['climate_surveys'] = empty($data['our_schools']) ? [] : $this->db->query("SELECT sscc.`Climate_id`,
        setd.title_en as title,
        setd.Id as setId,
        COUNT(sca.`climate_id`) d1,
        SUM(ssc.`mark`) ss ,
        sq.`en_title` AS question ,
        ss0c.`category` AS category_id ,
        (SUM(ssc.`mark`) /COUNT(sca.`climate_id`))/(SELECT COUNT(`id`)
        FROM `scl_st_choices` 
        WHERE  `servey_id` =sscc.`Climate_id`
        GROUP BY `servey_id`) *100  ff 
        FROM `scl_climate_answers` AS sca ,
            `scl_published_claimate` spc,
            `scl_st_climate` AS sscc ,
            `scl_st_choices` AS ssc,
            `scl_st0_climate` AS ss0c,
            `sv_questions_library` AS sq,
            `sv_sets` AS setd
        WHERE sca.`climate_id` =spc.`Id`
            AND spc.`climate_id` =sscc.`id`  
            AND sscc.`Climate_id` =ssc.`servey_id`
            AND sca.`answer_id` =ssc.id
            AND ss0c.`Id` = sscc.`Climate_id`
            AND sq.`Id` = ss0c.`question_id`
            AND setd.`Id` = ss0c.`set_id`
            AND sca.TimeStamp >= '" . $today . " 00:00:00'
            AND sca.TimeStamp <= '" . $today . " 23:59:59'
            AND spc.By_school IN (" . implode(',', array_column($data['our_schools'], "Id")) . ")
        GROUP BY setd.`Id` ")->result_array();

        $data['colors'] = self::COLORS;
        $data['permissions'] = $this->db->select("")
            ->where("user_type", "Ministry")
            ->where("user_id", $userId)
            ->limit(1)->get("v0_permissions")->result_array()[0] ?? [];
    
        $data['hasPermissionTo'] = function (string $name) use ($data) {
            if (empty($data['permissions'])) return false;
            return isset($data['permissions'][$name]) && intval($data['permissions'][$name]) === 1;
        };
        $data['page_title'] = "Qlick Health | Dashboard ";
        $this->show('Shared/Ministry/dashboard', $data);
    }


    public function changeSchoolstatus()
    {
        $id = $this->input->post('adminid');
        $adminStatuses = $this->db->query("SELECT * FROM `l1_school` WHERE  Id = '" . $id . "' LIMIT 1")->result_array();

        $enable = false;
        foreach ($adminStatuses as $adminStatus) {
            if ($adminStatus['status'] == 1) {
                $enable = true;
                $text = __("disabled");
            } else {
                $enable = false;
                $text = __("enabled");
            }
            $name = $adminStatus['Username'];
        }

        if ($enable) {
            $this->db->query("UPDATE l1_school SET `status` = '0' WHERE Id = '" . $id . "' ");
        } else {
            $this->db->query("UPDATE l1_school SET `status` = '1' WHERE Id = '" . $id . "' ");
        }

        echo $name . " " . __("now") . " " . $text . ".";
    }

}