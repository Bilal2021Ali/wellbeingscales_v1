<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proxy extends CI_Controller
{

    public function get_image()
    {
        if ($this->input->get('img_url')) {
            // $img = $this->input->get('img_url');
            $image =  $this->input->get('img_url');
            header('Content-Type: image/png');
            if (!file_exists($image)) {
                readfile(base_url("uploads/avatars/default_avatar.jpg"));
            }else{
                readfile($image);
            }
            // $image = imagecreatefromstring($this->getImage($img));
            // imagepng($image);
        }
    }

    public function imageTosmall()
    {
        if ($this->input->get('img_url')) {
            $filename = base_url("uploads/avatars/") . $this->input->get('img_url');
            $original_info = getimagesize($filename);
            $original_w = $original_info[0];
            $original_h = $original_info[1];
            $original_img = imagecreatefromjpeg($filename);
            $thumb_w = 50;
            $thumb_h = 50;
            $thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
            imagecopyresampled(
                $thumb_img,
                $original_img,
                0,
                0,
                0,
                0,
                $thumb_w,
                $thumb_h,
                $original_w,
                $original_h
            );
            // imagedestroy($thumb_img);
            // imagedestroy($original_img);
            header('Content-Type: image/jpeg');
            imagejpeg($thumb_img, null, 100);
        }
    }

    public function savegatewaydata()
    {
        //saving data here 
        if ($this->input->method() == "post") {
            $SpO2 = $this->input->post('SpO2');
            $PR = $this->input->post('PR');
            $mac = $this->input->post('mac');
            // user
            $usertype = null;
            $userid = null;
            // getting the usertype and the user id
            $staffData = $this->db->query("SELECT * FROM l2_staffs WHERE watch_mac = '" . $mac . "' ")->result_array();
            $teacherData = $this->db->query("SELECT * FROM l2_teacher WHERE watch_mac = '" . $mac . "' ")->result_array();
            $studentData = $this->db->query("SELECT * FROM l2_student WHERE watch_mac = '" . $mac . "' ")->result_array();
            // saving
            if (!empty($staffData)) {
                $usertype = "Staff";
                $userid = $staffData[0]['Id'];
            } elseif (!empty($teacherData)) {
                $usertype = "Teacher";
                $userid = $teacherData[0]['Id'];
            } elseif (!empty($studentData)) {
                $usertype = "Student";
                $userid = $studentData[0]['Id'];
            }

            if ($usertype !== null && $userid !== null) {
                $data = [
                    "SpO2"     => $SpO2,
                    "PR"       => $PR,
                    "Device"   => $mac,
                    "Result"   => 0,
                    "UserType" => $usertype,
                    "UserId"   => $userid
                ];
                $this->db->insert('l2_gateway_result', $data);
            }
        }
        $this->response->json($this->input->post());
    }
}
