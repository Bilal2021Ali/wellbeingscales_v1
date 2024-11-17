<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once __DIR__ . "/../Ministry/courses.php";

use BaseControllers\Ministry\Courses as MinistryCoursesHelper;

class Courses
{
    public $activeLanguage = "";
    public $controllerInstance;
    public $isEn;
    public $titles;
    public $schoolsTypes;

    public function __construct($controllerInstance, $activeLanguage)
    {
        $this->controllerInstance = $controllerInstance;
        $this->activeLanguage = $activeLanguage;
        $this->controllerInstance->load->library('session');
        $this->isEn = $this->getLanguage() == "en";
        $this->titles = [
            'category' => $this->isEn ? "Cat_en" : "Cat_ar",
            'school' => $this->isEn ? "School_Name_EN" : "School_Name_AR"
        ];
        $this->controllerInstance->load->vars([
            'activeLanguage' => $this->getLanguage(true),
            'isEn' => $this->isEn
        ]);
        $this->schoolsTypes = [
            1 => $this->isEn ? "Both" : "الكل",
            2 => $this->isEn ? "Government" : "عمومي",
            3 => $this->isEn ? "Private" : "خصوصي",
        ];
    }

    private function getLanguage($isUpper = false): string
    {
        return $isUpper ? strtoupper($this->activeLanguage) : strtolower($this->activeLanguage);
    }

    private function show($viewDir, $data)
    {
        $language = $this->getLanguage(true);
        $this->controllerInstance->lang->load('Courses', $this->isEn ? "english" : "arabic");
        $this->controllerInstance->load->view($language . '/inc/header', $data);
        $this->controllerInstance->load->view($viewDir);
        $this->controllerInstance->load->view($language . '/inc/footer');
    }

    public function categories()
    {
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');
        $data['school'] = $this->controllerInstance->schoolHelper->account;

        $data['categories'] = $this->controllerInstance->db
            ->query("SELECT sv_st_category.Cat_" . $this->getLanguage() . " AS title , sv_st_category.Id FROM sv_st_category
            JOIN scou_st0_main_courses ON scou_st0_main_courses.Category_Id = sv_st_category.Id
            LEFT JOIN scou_st_courses ON scou_st_courses.Main_Courses_Id = scou_st0_main_courses.Id
            LEFT JOIN scou_st0_courses_topics ON scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id
            JOIN scou_st0__main_courses_targeted_accounts ON scou_st0__main_courses_targeted_accounts.Main_Courses_Id = scou_st0_main_courses.Id
            WHERE scou_st0__main_courses_targeted_accounts.Organization_Id = " . $data['school']['Added_By'] . "
            AND scou_st0__main_courses_targeted_accounts.Status = 1 AND scou_st0_main_courses.Status = 1
            GROUP BY sv_st_category.Id")->result_array();
        $data['language'] = $this->controllerInstance::LANGUAGE;
        $this->show('Shared/Schools/courses/categories', $data);
    }

    public function courses()
    {
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');

        $categoryId = $this->controllerInstance->uri->segment(4);
        $this->controllerInstance->response->abort_if(404, empty($categoryId) || !is_numeric($categoryId));

        $this->controllerInstance->load->model('schools/sv_school_reports');
        $ministryId = $this->controllerInstance->sv_school_reports->school_data['Added_By'];
        $data['courses'] = $this->controllerInstance->db
            ->query("SELECT scou_st0_main_courses.Courses_Title AS courseTitle,
                    scou_st_courses.TimeStamp AS createdAt,
                   sv_st_category." . $this->titles["category"] . " as category_title,
                   scou_st_courses.Id AS courseId,
                   COUNT(scou_st0_courses_topics.Id) AS topicsCount,
                   
                   (SELECT COUNT(scou_st0_courses_resource.Id) FROM scou_st0_courses_resource WHERE scou_st0_courses_resource.Courses_Topic_Id = scou_st0_courses_topics.Id) AS resourcesCount,
                   (SELECT COUNT(scou_published_courses.Id) FROM scou_published_courses WHERE By_school = " . $data['sessiondata']['admin_id'] . "
                    AND scou_published_courses.Courses_Id = scou_st_courses.Id) AS publishedCount,
                    
                   (SELECT COUNT(*) FROM scou_published_courses 
                   JOIN `scou_user_rate_published_course` ON `scou_user_rate_published_course`.`Published_Courses_Id` = `scou_published_courses`.`Id`
                   WHERE By_school = " . $data['sessiondata']['admin_id'] . " AND scou_published_courses.Courses_Id = scou_st_courses.Id) AS reviews,
                   
                  (SELECT SUM(scou_user_rate_published_course.Rate)/COUNT(*) FROM scou_published_courses 
                   JOIN `scou_user_rate_published_course` ON `scou_user_rate_published_course`.`Published_Courses_Id` = `scou_published_courses`.`Id`
                   WHERE By_school = " . $data['sessiondata']['admin_id'] . " AND scou_published_courses.Courses_Id = scou_st_courses.Id) AS averageRate,
                   
                   sv_st_category." . $this->titles["category"] . " AS categoryTitle
            FROM scou_st0_main_courses
            JOIN sv_st_category ON scou_st0_main_courses.Category_Id = sv_st_category.Id
            JOIN scou_st_courses ON scou_st_courses.Main_Courses_Id = scou_st0_main_courses.Id
            LEFT JOIN scou_st0_courses_topics ON scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id
            JOIN scou_st0__main_courses_targeted_accounts ON scou_st0__main_courses_targeted_accounts.Main_Courses_Id = scou_st0_main_courses.Id
            WHERE scou_st0__main_courses_targeted_accounts.Organization_Id = " . $ministryId . " AND scou_st_courses.Published_by = " . $ministryId . "
            AND scou_st0__main_courses_targeted_accounts.Status = 1 AND scou_st0_main_courses.Status = 1
            AND scou_st0_main_courses.Category_Id = $categoryId
            GROUP BY scou_st0_main_courses.Id")
            ->result_array();
        $data['publishedCourses'] = $this->controllerInstance->sv_school_reports->published_courses(null , $categoryId);

        $data += $this->getPublishData($data['sessiondata']);
        $data['category'] = $this->controllerInstance->db->where("Id", $categoryId)->select("Cat_" . $this->getLanguage() . " AS categoryTitle")->limit(1)->get("sv_st_category")->result_array()[0] ?? null;
        $this->controllerInstance->response->abort_if(404, empty($data['category']));

        $this->show('Shared/Schools/courses/list', $data);
    }

    private function getPublishData($session)
    {
        $data['types'] = $this->controllerInstance->db->order_by("UserType", "ASC")->get("r_usertype_school")->result_array();
        $data['levels'] = $this->controllerInstance->schoolHelper->school_classes($session['admin_id']);
        $data['genders'] = $this->controllerInstance->db->order_by("Gender_Type", "ASC")->limit(2)->get("r_gender")->result_array(); // Get The Two Genders
        $data['course'] = [
            'users-types' => [],
            'levels' => [],
            'genders' => [],
        ];
        return $data;
    }

    public function coursePreview()
    {
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');

        $courseId = $this->controllerInstance->uri->segment(4);
        $this->controllerInstance->response->abort_if(404, empty($courseId) || !is_numeric($courseId));

        $data['course'] = $this->controllerInstance->db->select("scou_st0_main_courses.* , r_language.Language , sv_st_category.Cat_" . $this->getLanguage() . " AS  categoryTitle")
            ->join("scou_st0_main_courses", "scou_st_courses.Main_Courses_Id = scou_st0_main_courses.Id")
            ->join("sv_st_category", "sv_st_category.Id = scou_st0_main_courses.Category_Id")
            ->join("r_language", "r_language.Id = scou_st0_main_courses.Language_Id")
            ->where("scou_st_courses.Id", $courseId)
            ->limit(1)
            ->get("scou_st_courses")
            ->result_array()[0] ?? null;
        $this->controllerInstance->response->abort_if(404, empty($data['course']));

        $helper = new MinistryCoursesHelper($this->controllerInstance, $this->getLanguage());
        $helper->showPreviewView($data['course']['Id'], $data);
    }

    public function course()
    {
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');
        $data['course'] = [
            "users-types" => [],
            "levels" => [],
            "genders" => [],
        ];
        $id = $this->controllerInstance->uri->segment(4);
        $this->controllerInstance->response->abort_if(404, empty($id) || !is_numeric($id));

        $courseId = $this->controllerInstance->uri->segment(5);
        $isNew = empty($courseId) || !is_numeric($courseId);

        if ($this->controllerInstance->input->method() === "post") {
            $this->controllerInstance->load->library('form_validation');

            $this->controllerInstance->form_validation->set_rules('types[]', 'types', 'required');
            $this->controllerInstance->form_validation->set_rules('genders[]', 'genders', 'required');
            $this->controllerInstance->form_validation->set_rules('levels[]', 'levels', 'required');
            if (!$this->controllerInstance->form_validation->run()) {
                $this->controllerInstance->response->json(['status' => 'error', 'message' => validation_errors()]);
            }

            $user_id = $data['sessiondata']['admin_id'];
            $types = $this->controllerInstance->input->post('types');
            $genders = $this->controllerInstance->input->post('genders');
            $levels = $this->controllerInstance->input->post('levels');
            $types_arr = [];
            $genders_arr = [];
            $levels_arr = [];
            $data = [
                'By_school' => $user_id,
                'Courses_Id' => $id,
                'Created' => date("Y-m-d"),
                'Time' => date("H:i:s")
            ];
            if ($isNew) {
                $this->controllerInstance->db->insert('scou_published_courses', $data);
                $courseId = $this->controllerInstance->db->insert_id();
            } else {
                $this->controllerInstance->db->where("Id", $courseId)->set($data)->update('scou_published_courses');
            }
            // types
            if (!empty($types)) {
                if (!$isNew) {
                    $this->controllerInstance->db->where("Published_Courses_Id", $courseId)->delete("scou_published_courses_types");
                }
                foreach ($types as $type) {
                    $types_arr[] = [
                        "Published_Courses_Id" => $courseId,
                        "User_Type_Id" => $type,
                        "Created" => date('Y-m-d'),
                        "Time" => date('H:i:s')
                    ];
                }
                $this->controllerInstance->db->insert_batch('scou_published_courses_types', $types_arr);
            }
            // Levels
            if (!empty($levels)) {
                if (!$isNew) {
                    $this->controllerInstance->db->where("Published_Courses_Id", $courseId)->delete("scou_published_courses_levels");
                }
                foreach ($levels as $level) {
                    $levels_arr[] = [
                        "Published_Courses_Id" => $courseId,
                        "Level_Id" => $level,
                        "Created" => date('Y-m-d'),
                        "Time" => date('H:i:s')
                    ];
                }
                $this->controllerInstance->db->insert_batch('scou_published_courses_levels', $levels_arr);
            }
            // genders
            if (!empty($genders)) {
                if (!$isNew) {
                    $this->controllerInstance->db->where("Published_Courses_Id", $courseId)->delete("scou_published_courses_genders");
                }
                foreach ($genders as $gender) {
                    $genders_arr[] = [
                        "Published_Courses_Id" => $courseId,
                        "Gender_Id" => $gender,
                        "Created" => date('Y-m-d'),
                        "Time" => date('H:i:s'),
                    ];
                }
                $this->controllerInstance->db->insert_batch('scou_published_courses_genders', $genders_arr);
            }
            $this->controllerInstance->response->json(['status' => "ok"]);
        }

        if (!$isNew) { // get old data
            $course = $this->controllerInstance->db->where("Id", $courseId)->limit(1)->get("scou_published_courses")->result_array();
            $this->controllerInstance->response->abort_if(404, empty($course));

            $types = $this->controllerInstance->db->select("User_Type_Id")->where("Published_Courses_Id", $courseId)->get("scou_published_courses_types")->result_array();
            $levels = $this->controllerInstance->db->select("Level_Id")->where("Published_Courses_Id", $courseId)->get("scou_published_courses_levels")->result_array();
            $genders = $this->controllerInstance->db->select("Gender_Id")->where("Published_Courses_Id", $courseId)->get("scou_published_courses_genders")->result_array();
            $data['course'] = [
                "users-types" => array_column($types, "User_Type_Id") ?? [],
                "levels" => array_column($levels, "Level_Id") ?? [],
                "genders" => array_column($genders, "Gender_Id") ?? [],
            ];
        }

        $data += $this->getPublishData();
        $this->show("Shared/Schools/courses/publish", $data);
    }

    public function published_courses()
    {
        $id = $this->controllerInstance->uri->segment(4);
        if (empty($id) || !is_numeric($id)) {
            $this->controllerInstance->output->set_status_header('404');
            die();
        }

        $this->controllerInstance->load->library('session');
        $this->controllerInstance->load->model('schools/sv_school_reports');
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');
        $data['published_courses'] = $this->controllerInstance->sv_school_reports->published_courses($id);
        $data['schoolsTypes'] = $this->schoolsTypes;

        if ($this->controllerInstance->input->method() === "post") {
            $id = $this->controllerInstance->input->post("id");
            $this->controllerInstance->db->query("UPDATE scou_published_courses SET Status = IF(Status=1, 0, 1) WHERE Id = '" . $id . "'");
            return;
        }

        if ($this->controllerInstance->input->method() === "delete") {
            if ($this->controllerInstance->input->input_stream('id')) {
                $id = $this->controllerInstance->input->input_stream('id');
                $this->controllerInstance->db->where("Published_Courses_Id", $id)->delete("scou_published_courses_types");
                $this->controllerInstance->db->where("Published_Courses_Id", $id)->delete("scou_published_courses_levels");
                $this->controllerInstance->db->where("Published_Courses_Id", $id)->delete("scou_published_courses_genders");
                $this->controllerInstance->db->where("Id", $id)->delete("scou_published_courses");
                $this->controllerInstance->response->json(["status" => "ok"]);
            } else {
                $this->controllerInstance->response->json(["status" => "error", "message" => "invalid request"]);
            }
            return;
        }

        $this->show("Shared/Schools/courses/published-courses", $data);
    }
}