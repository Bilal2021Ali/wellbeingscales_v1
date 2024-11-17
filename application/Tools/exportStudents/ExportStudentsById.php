<?php

namespace Tools\exportStudents;

use CI_Controller;
use Exception;
use Tools\ExportAsExcel;

require_once __DIR__ . "/../ExportAsExcel.php";

class ExportStudentsById extends ExportAsExcel
{

    public $student = [];
    public $controller;

    /**
     * @throws Exception
     */
    public function __construct(int $id, $controller)
    {
        $this->controller = $controller;

        $this->query();
        $student = $this->controller->db->where("l2_student.Id", $id)->get()->result_array()[0] ?? null;

        if (empty($student)) {
            throw new Exception("Student not found");
        }

        $this->student = $student;
    }


    public function data(): array
    {
        return [$this->student];
    }

    public function filename(): string
    {
        return $this->student['F_name_EN'] . " " . $this->student['L_name_EN'] . "_students" . ".xlsx";
    }

    public function controller()
    {
        return $this->controller;
    }
}