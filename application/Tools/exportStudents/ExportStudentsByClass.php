<?php

namespace Tools\exportStudents;

use CI_Controller;
use Exception;
use Tools\ExportAsExcel;

require_once __DIR__ . "/../ExportAsExcel.php";

class ExportStudentsByClass extends ExportAsExcel
{

    public $class = [];
    public $controller;

    /**
     * @throws Exception
     */
    public function __construct(int $classId, $controller)
    {
        $this->controller = $controller;
        $class = $this->controller->db->where("Id", $classId)->get("r_levels")->result_array()[0] ?? null;

        if (empty($class)) {
            throw new Exception("Class not found");
        }

        $this->class = $class;
    }

    public function data(): array
    {
        $this->query();
        return $this->controller->db->where("Class", $this->class['Id'])->get()->result_array();
    }

    public function filename(): string
    {
        return "students_" . $this->class['Class'] . ".xlsx";
    }

    public function controller()
    {
        return $this->controller;
    }
}