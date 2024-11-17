<?php

namespace Traits\schools;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

trait LabTests
{

    private function getUser(string $type, string $id): ?array
    {
        $user = null;
        switch ($type) {
            case "staff":
                $user = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name , National_Id , DOP , Gender  , l2_staff.Id as id , l2_avatars.Link as avatar, r_positions_sch.Position as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_staff` . `Id` and `l2_avatars` . `Type_Of_User` = 'Staff'", "LEFT")
                    ->join("r_positions_sch", "`r_positions_sch`.`Id` = `l2_staff`.`Position`", "LEFT")
                    ->where("l2_staff.Id", $id)
                    ->limit(1)
                    ->get("l2_staff")
                    ->result_array()[0] ?? null;
                break;
            case "student":
                $user = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name, National_Id , DOP , Gender ,l2_student.Id as id , l2_avatars.Link as avatar, r_levels.Class as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'", "LEFT")
                    ->join('r_levels', 'r_levels.Id = l2_student.Class')
                    ->where("l2_student.Id", $id)
                    ->limit(1)
                    ->get("l2_student")
                    ->result_array()[0] ?? null;
                break;
            case "teacher":
                $user = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name, National_Id , DOP , Gender ,l2_teacher.Id as id , l2_avatars.Link as avatar")
                    ->select("(SELECT GROUP_CONCAT(r_levels.Class) 
                FROM `l2_teachers_classes` 
                JOIN `r_levels` ON `r_levels`.`Id` = `l2_teachers_classes`.`class_id`
                WHERE `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id` ) as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_teacher` . `Id` and `l2_avatars` . `Type_Of_User` = 'Teacher'", "LEFT")
                    ->where("l2_teacher.Id", $id)
                    ->limit(1)
                    ->get("l2_teacher")
                    ->result_array()[0] ?? null;
                break;
        }

        return $user;
    }

    public function lab_result()
    {
        $type = strtolower($this->uri->segment(4));
        $resultId = $this->uri->segment(5);
        $this->response->abort_if(404, empty($resultId) || !in_array($type, ['staff', 'teacher', 'student']));

        $tables = [
            'staff' => "l2_staff",
            'teacher' => "l2_teacher",
            'student' => "l2_student"
        ];
        $table = $tables[$type];

        $result = $this->db->select("l2_labtests.Result , l2_labtests.UserId , Test_Description as testType , l2_labtests.TimeStamp")
            ->join($table, $table . ".Id = l2_labtests.UserId")
            ->where("l2_labtests.Id", $resultId)
            ->where($table . ".Added_By", $this->sessionData['admin_id'])
            ->limit(1)
            ->get("l2_labtests")
            ->row();
        $settings = $this->db->get('l0_global_settings', 1)->result_array()[0] ?? null;
        $this->response->abort_if(503, empty($settings) || empty($result));

        $user = $this->getUser($type, $result->UserId);
        $this->response->abort_if(404, empty($user));

        $labels = [
            'staff' => "Position",
            'student' => "Class",
            'teacher' => "Classes",
        ];
        $data = [
            'result' => $result->Result === "1" ? 'positive' : 'negative',
            'settings' => $settings,
            'user' => $user,
            'age' => $this->schoolHelper->calculateAge($user['DOP']),
            'schoolName' => $this->schoolHelper->account['School_Name_EN'],
            'label' => $labels[$type],
            'testType' => $result->testType,
            'testDate' => $result->TimeStamp,
        ];
        $resultHtml = $this->load->view("EN/inc/lab-report", $data, TRUE);

        // Create a new Dompdf instance
        $dompdf = new Dompdf();
        // Set the paper size and orientation
        $dompdf->setOptions(new Options(['isRemoteEnabled' => true]))->setPaper('A4');
        // Render the HTML as PDF
        $dompdf->loadHtml($resultHtml);
        $dompdf->render();


        ///$this->response->json([$result]);
        // Output the generated PDF to the browser
        $slugify = function (string $text) {
            return str_replace(" ", "-", strtolower($text));
        };

        $dompdf->stream($slugify($user['name']) . "-" . $slugify($data['testType']) . "-result-" . date("Y-m-d") . ".pdf", array('Attachment' => 0));

    }

}