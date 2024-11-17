<?php

namespace BaseControllers\Ministry;

class Courses
{
    public $activeLanguage = "";
    public $controllerInstance;
    public $isEn;
    public $titles;
    public $schoolsTypes = [];

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
            'activeLanguage' => $this->getLanguage(true)
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
        $data['categories'] = $this->controllerInstance->db
            ->query("SELECT sv_st_category.Cat_" . $this->getLanguage() . " AS title , sv_st_category.Id FROM sv_st_category
            JOIN scou_st0_main_courses ON scou_st0_main_courses.Category_Id = sv_st_category.Id
            LEFT JOIN scou_st_courses ON scou_st_courses.Main_Courses_Id = scou_st0_main_courses.Id
            LEFT JOIN scou_st0_courses_topics ON scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id
            JOIN scou_st0__main_courses_targeted_accounts ON scou_st0__main_courses_targeted_accounts.Main_Courses_Id = scou_st0_main_courses.Id
            WHERE scou_st0__main_courses_targeted_accounts.Organization_Id = " . $data['sessiondata']['admin_id'] . "
            AND scou_st0__main_courses_targeted_accounts.Status = 1 AND scou_st0_main_courses.Status = 1
            GROUP BY sv_st_category.Id")->result_array();
        $data['language'] = $this->controllerInstance::LANGUAGE;
        $this->show('Shared/Ministry/courses/categories', $data);
    }

    public function publishCourse()
    {
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');
        $this->controllerInstance->load->model('ministry/sv_ministry_reports');
        $isNew = true;
        $data['form'] = [
            'start' => "",
            'end' => "",
            'available-to' => "",
            'status' => "",
            'guidance-notes' => ""
        ];

        $courseId = $this->controllerInstance->uri->segment(4);
        $this->controllerInstance->response->abort_if(404, empty($courseId) || !is_numeric($courseId));

        $mainCourse = $this->controllerInstance->db->where("Id", $courseId)->limit(1)->get("scou_st0_main_courses")->result_array()[0] ?? null;
        $this->controllerInstance->response->abort_if(404, empty($mainCourse));
        $data['course'] = $mainCourse;

        $id = $this->controllerInstance->uri->segment(5);
        $this->controllerInstance->response->abort_if(404, !empty($id) && !is_numeric($id));

        if (!empty($id) && is_numeric($id)) {
            $course = $this->controllerInstance->db->where("id", $id)->where("Published_by", $data['sessiondata']['admin_id'])->limit(1)->get("scou_st_courses")->result_array()[0] ?? null;
            $this->controllerInstance->response->abort_if(404, empty($course));

            $data['form'] = [
                'start' => $course['Startting_date'],
                'end' => $course['End_date'],
                'available-to' => $course['Avalaible_to'],
                'status' => $course['Status'],
                'guidance-notes' => $course['Guidance_Notes']
            ];
            $isNew = false;
        }

        if ($this->controllerInstance->input->method() === "post") {
            $this->controllerInstance->load->library('form_validation');
            $this->controllerInstance->form_validation->set_rules('start', 'start', 'required');
            $this->controllerInstance->form_validation->set_rules('end', 'end', 'required');
            $this->controllerInstance->form_validation->set_rules('available-to', 'available-to', 'required');
            $this->controllerInstance->form_validation->set_rules('status', 'status', 'required|numeric');
            if (!$this->controllerInstance->form_validation->run()) {
                $this->controllerInstance->response->json(['status' => 'error', 'message' => validation_errors()]);
            }
            $form = [
                'Startting_date' => $this->controllerInstance->input->post("start"),
                'End_date' => $this->controllerInstance->input->post("end"),
                'Avalaible_to' => $this->controllerInstance->input->post("available-to"),
                'Status' => $this->controllerInstance->input->post("status"),
                'Main_Courses_Id' => $courseId,
                'Published_by' => $data['sessiondata']['admin_id'],
                'Guidance_Notes' => $this->controllerInstance->input->post("notes") ?? ""
            ];
            if ($isNew) {
                $this->controllerInstance->db->insert('scou_st_courses', $form);
            } else {
                $this->controllerInstance->db->where("Id", $id)->set($form)->insert('scou_st_courses');
            }

            $this->controllerInstance->response->json(['status' => "ok"]);
        }

        $data['schoolsTypes'] = $this->schoolsTypes;
        $this->show('Shared/Ministry/courses/publish', $data);
    }

    public function courses()
    {
        $categoryId = $this->controllerInstance->uri->segment(4);
        $this->controllerInstance->response->abort_if(404, empty($categoryId) || !is_numeric($categoryId));
        $this->controllerInstance->load->model("CoursesModel");

        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');
        $this->controllerInstance->load->model('ministry/sv_ministry_reports');
        $language = $this->getLanguage();

        $schools = $this->controllerInstance->sv_ministry_reports->getSchools(true);

        if ($this->controllerInstance->input->method() === "post") {
            $id = $this->controllerInstance->input->post("id");
            $this->controllerInstance->response->abort_if(500, empty($id) || !is_numeric($id));

            $this->controllerInstance->db->set('scou_st_courses.Status', '!Status', false)
                ->where('Id', $id)
                ->where('scou_st_courses.Published_by', $this->controllerInstance->sessionData['admin_id'])
                ->update('scou_st_courses');

            $this->controllerInstance->response->json(['success' => true]);
        }
        $data['category'] = $this->controllerInstance->db->where("Id", $categoryId)->select("Cat_" . $this->getLanguage() . " AS categoryTitle")->limit(1)->get("sv_st_category")->result_array()[0] ?? null;
        $this->controllerInstance->response->abort_if(404, empty($data['category']));

        $data['courses'] = $this->controllerInstance->CoursesModel->ministryCoursesList($schools, $categoryId, $language);
        $data['publishedCourses'] = $this->controllerInstance->CoursesModel->ministryCoursesList($schools, $categoryId, $language, true);

        $this->show('Shared/Ministry/courses/list', $data);
    }

    public function course()
    {
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');

        $courseId = $this->controllerInstance->uri->segment(4);
        $this->controllerInstance->response->abort_if(404, empty($courseId) || !is_numeric($courseId));

        $data['course'] = $this->controllerInstance->db->select("scou_st0_main_courses.* , r_language.Language , sv_st_category.Cat_" . $this->getLanguage() . " AS  categoryTitle")
            ->join("sv_st_category", "sv_st_category.Id = scou_st0_main_courses.Category_Id")
            ->join("r_language", "r_language.Id = scou_st0_main_courses.Language_Id")
            ->where("scou_st0_main_courses.Id", $courseId)
            ->limit(1)
            ->get("scou_st0_main_courses")
            ->result_array()[0] ?? null;
        $this->controllerInstance->response->abort_if(404, empty($data['course']));

        $this->showPreviewView($courseId, $data);
    }

    public function showPreviewView($courseId, $data)
    {
        $this->controllerInstance->load->model("CoursesModel");
        $this->controllerInstance->load->model("HealthyModal");

        $data['topics'] = $this->controllerInstance->CoursesModel->topics($courseId);
        $resources = $this->controllerInstance->CoursesModel->resourses($courseId, true);
        $data['resources'] = $this->controllerInstance->HealthyModal->groupBy("Courses_Topic_Id", $resources);

        $this->show('Shared/Ministry/courses/details', $data);
    }

    public function published()
    {
        $id = $this->controllerInstance->uri->segment(4);
        if (empty($id) || !is_numeric($id)) {
            $this->controllerInstance->output->set_status_header('404');
            die();
        }
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->controllerInstance->session->userdata('admin_details');
        $this->controllerInstance->load->model('ministry/sv_ministry_reports');

        $schools = $this->controllerInstance->sv_ministry_reports->getSchools(true);
        if (empty($schools)) {
            echo "Sorry You Have To Add Some Schools First";
            die();
        }

        $this->show('Shared/Ministry/courses/schools', $data);
    }
}