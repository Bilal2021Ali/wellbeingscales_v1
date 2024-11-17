<?php

require_once __DIR__ . "/../Tools/exportStudents/ExportStudentsByClass.php";
require_once __DIR__ . "/../Tools/exportStudents/ExportStudentsBySchool.php";
require_once __DIR__ . "/../Tools/exportStudents/ExportStudentsById.php";

use Tools\ExportAsExcel;
use Tools\exportStudents\ExportStudentsByClass;
use Tools\exportStudents\ExportStudentsById;
use Tools\exportStudents\ExportStudentsBySchool;

class Export extends CI_Controller
{
    public function class()
    {
        $id = $this->uri->segment(3);
        $this->response->abort_if(404, empty($id) || !is_numeric($id));

        try {
            $builder = new ExportStudentsByClass($id, $this);
            $builder->export();
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }

    public function all()
    {
        $this->load->library('session');
        $sessionData = $this->session->userdata('admin_details');

        try {
            $builder = new ExportStudentsBySchool($sessionData['admin_id'], $this);
            $builder->export();
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }

    public function student()
    {
        $id = $this->uri->segment(3);
        $this->response->abort_if(404, empty($id) || !is_numeric($id));

        $this->load->library('session');
        $sessionData = $this->session->userdata('admin_details');

        try {
            $builder = new ExportStudentsById($id, $this);
            $builder->export();
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
}