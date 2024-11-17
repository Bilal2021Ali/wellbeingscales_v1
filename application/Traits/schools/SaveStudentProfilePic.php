<?php

namespace Traits\schools;

trait SaveStudentProfilePic
{
    private function saveStudentProfilePic(?int $id, string $nationalId)
    {
        if (!isset($_FILES['avatar']['name']) || empty($_FILES['avatar']['name'])) return;

        // new student
        if (empty($id)) {
            $student = $this->db->select("Id")->where('National_Id', $nationalId)->where('Added_By', $this->sessionData['admin_id'])->order_by("Id", "DESC")->limit(1)->get('l2_student')->result_array();
            if (empty($student)) return;

            $id = $student[0]['Id'];
        }

        $config['upload_path'] = './uploads/avatars';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 5000; // 10 MB
        $config['file_name'] = $nationalId . ".png";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('avatar')) {
            $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors() ?? "avatar upload error"]);
        }
        $this->db->where('For_User', $id)->where('Type_Of_User', 'Student')->delete('l2_avatars');
        $this->db->insert('l2_avatars', [
            "For_User" => $id,
            "Link" => $this->upload->data()['file_name'],
            "Type_Of_User" => "Student",
        ]);
    }
}