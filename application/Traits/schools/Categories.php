<?php

namespace Traits\schools;

trait Categories
{

    private function hasSurveysPermission(): bool
    {
        return !empty($this->db->query(" SELECT `v0_permissions`.`Id`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $this->sessionData['admin_id'] . "' AND `v0_permissions`.`surveys` = '1' ")->result_array());
    }

    public function categorys_reports(): void
    {
        $data['page_title'] = "QlickSystems | survey report ";
        $userId = $this->sessionData['admin_id'];
        $data['activeLanguage'] = self::LANGUAGE;

        if (!$this->hasSurveysPermission()) {
            $dataDes['to'] = self::LANGUAGE . "/schools";
            $this->load->view(self::LANGUAGE . '/Global/disabledPerm', $dataDes);
        }

        $this->lang->load('survey', self::LANGUAGE === "EN" ? "english" : "arabic");
        if (!$this->uri->segment(4)) { // when the category not choosed
            $this->load->model('schools/sv_school_reports'); // loading model
            $data['categorys'] = $this->sv_school_reports->usedcategorys($userId); // return categorys used in this school
            $data['surveys'] = $this->sv_school_reports->our_surveys($userId); // return categorys used in this school
            $this->show('Shared/Schools/wellness/category_report', $data);
            return;
        }

        /**
         *  category_by_gender :
         * @user id
         * @gender cose (1 = male , 2 = female)
         * @usertype code
         * @cat id
         */
        $data['cat_id'] = $this->uri->segment(4);
        $this->load->model('schools/sv_school_reports'); // loading model
        $data['surveys_for_males'] = $this->sv_school_reports->category_by_gender($userId, '1', "", $data['cat_id']);
        $data['surveys_for_females'] = $this->sv_school_reports->category_by_gender($userId, '2', "", $data['cat_id']);
        $data['surveys_for_all_genders'] = $this->sv_school_reports->category_by_gender($userId, '', "", $data['cat_id']);
        // for students
        $data['students_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($userId, '2', $data['cat_id']);
        $data['count_all'] = $this->db->get_where('l2_student', array('Added_By' => $userId))->num_rows();
        $data['avalaible_types_of_classes'] = $this->db->get('education_profile')->result_array();
        // Staffs
        $data['Staffs'] = $this->sv_school_reports->users_passed_category($data['cat_id'], '1');
        // teachers
        $data['Teachers'] = $this->sv_school_reports->users_passed_category($data['cat_id'], '3');
        // students
        $data['Students'] = $this->sv_school_reports->users_passed_category($data['cat_id'], '2');
        // Parents
        $data['Parents'] = $this->sv_school_reports->users_passed_category($data['cat_id'], '4');
        $data['surveys'] = $this->sv_school_reports->category_publishid_surveys($userId, $data['cat_id']);
        $this->show('Shared/Schools/wellness/category_report_charts', $data);
    } //category
}