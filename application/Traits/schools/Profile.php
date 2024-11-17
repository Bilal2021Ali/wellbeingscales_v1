<?php

namespace Traits\schools;

trait Profile
{
    public function Profile(): void
    {
        $data['data'] = $this->db->where("id", $this->sessionData['admin_id'])->get("l1_school")->result_array()[0] ?? null;
        $this->response->abort_if(404, empty($data['data']));

        $this->lang->load("SchoolProfile", self::LANGUAGE === "EN" ? "english" : "arabic");
        $data['page_title'] = "Qlick Health | school Profile";
        $data['attendance_rule'] = $this->db->where("Added_By", $this->sessionData['admin_id'])->where("Action", "School")
            ->get("r_attendance_rule")
            ->result_array();
        $data['classesList'] = $this->db->select('*')
            ->select("(SELECT COUNT(Id) FROM `l2_student` WHERE `Added_By` = {$this->sessionData['admin_id']} AND `Class` = `r_levels`.`Id`) AS UsingCounter")
            ->select("(SELECT COUNT(Id) FROM `l2_school_classes` WHERE `school_id` = {$this->sessionData['admin_id']} AND `class_key` = `r_levels`.`Id`) AS isExist")
            ->from('r_levels')
            ->get()
            ->result_array();
        $this->show('Shared/Schools/Profile/Profile', $data);
    }
}