<?php

/**
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Basic_functions $schoolHelper
 * @property CI_Input $input
 * @property Response $response
 */
class Controller extends CI_Controller
{
    public array $sessionData;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $session = $this->session->userdata('admin_details');
        if (empty($session)) {
            redirect('EN/Users');
            exit();
        }

        $this->sessionData = $session;
        if ($this->sessionData['level'] !== 0 || $this->sessionData['type'] !== "controller") {
            redirect('EN/Users');
            exit();
        }
    }

    public function _show(string $view, array $extraData = [])
    {
        $data['page_title'] = "Qlick System | Controller";
        $data['sessiondata'] = $this->sessionData;

        $this->load->view('EN/inc/header', array_merge($data, $extraData));
        $this->load->view($view);
        $this->load->view('EN/inc/footer');
    }

    public function index(): void
    {
        $this->_show('Shared/Controllers/index');
    }

    private function schools(): array
    {
        return $this->db->select("l1_school.Id as id, School_Name_EN as name")
            ->join("l1_school", "l1_school.Id = l1_controllers_children.account_id")
            ->where("controller_id", $this->sessionData['admin_id'])
            ->get('l1_controllers_children')
            ->result_array();
    }

    public function transfer(): void
    {
        $data['schools'] = $this->schools();

        if ($this->input->method() === 'post') {
            $this->transformStudentsBatch();
            return;
        }

        $this->_show('Shared/Controllers/transfer', $data);
    }

    public function transformStudentsBatch(): void
    {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $students = $this->input->post('students_ids');
        $class = $this->input->post('student_class');

        if (empty($from) || empty($to) || empty($students) || empty($class)) {
            $this->response->json(["status" => "error", "message" => "Please fill all fields"]);
        }

        $schools = array_column($this->schools(), "id");
        if (!in_array($from, $schools) || !in_array($to, $schools)) {
            $this->response->json(["status" => "error", "message" => "Invalid school"]);
        }

        $this->db->trans_start();
        $this->db->where_in("Id", $students)->update("l2_student", ["Added_By" => $to, "Class" => $class]);
        $this->db->trans_complete();

        $this->response->json(['status' => "ok"]);
    }

    public function school_classes(): void
    {
        $id = $this->input->post('school');
        $data['classes'] = $this->schoolHelper->school_classes($id);
        $data['direction'] = $this->input->post("direction");

        $this->load->view('Shared/Controllers/inc/classes', $data);
    }

    public function students(): void
    {
        $class = $this->input->post('class');
        $school = $this->input->post('school');

        $data['students'] = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name, National_Id , Grades , Phone , Nationality , DOP , Gender ,l2_student.Id as id , l2_avatars.Link as avatar, r_levels.Class as class_name")
            ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'", "LEFT")
            ->join('r_levels', 'r_levels.Id = l2_student.Class')
            ->where("l2_student.Added_By", $school)
            ->where("r_levels.Id", $class)
            ->get("l2_student")
            ->result_array();

        $this->load->view('Shared/Controllers/inc/students', $data);
    }
}