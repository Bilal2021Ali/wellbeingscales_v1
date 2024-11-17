<?php

namespace Tools\exportStudents;

use CI_Controller;
use Exception;
use Tools\ExportAsExcel;

require_once __DIR__ . "/../ExportAsExcel.php";

class ExportStudentsBySchool extends ExportAsExcel
{

    public $school = [];
    public $controller;

    /**
     * @throws Exception
     */
    public function __construct(int $schoolId, $controller)
    {
        $this->controller = $controller;
        $school = $this->controller->db->select("Id ,School_Name_EN as name")->where("Id", $schoolId)->get("l1_school")->result_array()[0] ?? null;

        if (empty($school)) {
            throw new Exception("School not found");
        }

        $this->school = $school;
    }

    public function data(): array
    {
        $this->query();
        return $this->controller->db->where("Added_By", $this->school['Id'])->get()->result_array();
    }

    public function filename(): string
    {
        return $this->school['name'] . "_students" . ".xlsx";
    }

    public function controller()
    {
        return $this->controller;
    }
}