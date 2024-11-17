<?php

namespace Traits\schools;
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../Enums/UsersTypes.php';
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorHTML;
use Enums\UsersTypes;

trait UserProfile
{
    public $type = "";
    public $id = "";
    public $action = "";
    public $table = "";
    public $userTypeCode = 0;
    public $tables = ['staff' => 'l2_staff', 'student' => 'l2_student', 'teacher' => 'l2_teacher'];
    public $tempTables = ['student' => 'l2_temp_student'];
    public $inputs = [
        [
            'name' => 'f_name_en',
            'label' => 'English First Name',
            'rules' => 'trim|max_length[200]',
            'column' => 'F_name_EN'
        ],
        [
            'name' => 'm_name_en',
            'label' => 'English Middle Name',
            'rules' => 'trim|max_length[200]',
            'column' => 'M_name_EN'
        ],
        [
            'name' => 'l_name_en',
            'label' => 'English Last Name',
            'rules' => 'trim|max_length[200]',
            'column' => 'L_name_EN'
        ],
        [
            'name' => 'f_name_ar',
            'label' => 'Arabic First Name',
            'rules' => 'trim|max_length[200]',
            'column' => 'F_name_AR'
        ],
        [
            'name' => 'm_name_ar',
            'label' => 'Arabic Middle Name',
            'rules' => 'trim|max_length[200]',
            'column' => 'M_name_AR'
        ],
        [
            'name' => 'l_name_ar',
            'label' => 'Arabic Last Name',
            'rules' => 'trim|max_length[200]',
            'column' => 'L_name_AR'
        ],
        [
            'name' => 'dop',
            'label' => 'Date Of Birth',
            'rules' => 'trim',
            'column' => 'DOP'
        ],
        [
            'name' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|numeric|min_length[8]|max_length[20]',
            'column' => 'Phone'
        ],

        [
            'name' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim',
            'column' => 'Gender'
        ],
        [
            'name' => 'sms-mobile',
            'label' => 'SMS / Whatsapp mobile',
            'rules' => 'trim|max_length[25]',
            'column' => 'sms_mobile'
        ],
        [
            'name' => 'hc-card-no',
            'label' => 'HC Card Number',
            'rules' => 'trim',
            'column' => 'hc_card_no'
        ],
        [
            'name' => 'hc-code-expiry',
            'label' => 'HC Code Expiry',
            'rules' => 'trim',
            'column' => 'hc_card_expiry'
        ],
        [
            'name' => 'passport-no',
            'label' => 'Passport NO',
            'rules' => 'trim',
            'column' => 'passport_no'
        ],
        [
            'name' => 'passport-expiry',
            'label' => 'Passport Expiry',
            'rules' => 'trim|max_length[14]',
            'column' => 'passport_expiry'
        ],
        [
            'name' => 'nid',
            'label' => 'National ID',
            'rules' => 'trim',
            'column' => 'National_Id'
        ],
        [
            'name' => 'nationality',
            'label' => 'Nationality',
            'rules' => 'trim',
            'column' => 'Nationality'
        ],
        [
            'name' => 'email',
            'label' => 'Email',
            'rules' => 'trim|valid_email',
            'column' => 'Email'

        ],
        [
            'name' => 'martial-status',
            'label' => 'Martial Status',
            'rules' => 'trim|valid_email',
            'column' => 'martial_status'

        ],
        [
            'name' => 'place-of-birth',
            'label' => 'Place of Birth',
            'rules' => 'trim',
            'column' => 'Place_of_Birth'
        ],
        [
            'name' => 'language',
            'label' => 'Language',
            'rules' => 'trim',
            'column' => 'language'

        ],
        [
            'name' => 'office-phone',
            'label' => 'Office Phone',
            'rules' => 'trim',
            'column' => 'office_phone'
        ],
        [
            'name' => 'po-box',
            'label' => 'PO Box',
            'rules' => 'trim|numeric',
            'column' => 'po_box'
        ],
        [
            'name' => 'last-visit-date',
            'label' => 'Last Visit Date',
            'rules' => 'trim|numeric',
            'column' => 'last_visit_date'
        ],
        [
            'name' => 'address',
            'label' => 'Address',
            'rules' => 'trim',
            'column' => 'address'
        ],
        [
            'name' => 'blood-type',
            'label' => 'Blood Type',
            'rules' => 'trim',
            'column' => 'blood_group'
        ],
        [
            'name' => 'ID Expiry Date',
            'label' => 'National-Id-Expire',
            'rules' => 'trim|max_length[14]',
            'column' => 'National_Id_Expire'
        ],
        [
            'name' => 'registration-no',
            'label' => 'Registration No',
            'rules' => 'trim',
            'column' => 'Regstration_No'
        ],
        [
            'name' => 'national-id-expire',
            'label' => 'Registration No Expiry',
            'rules' => 'trim',
            'column' => 'National_Id_Expire'
        ],
        [
            'name' => 'martial-status',
            'label' => 'Martial Status',
            'rules' => 'trim|numeric',
            'column' => 'martial_status'
        ],


        [
            'name' => 'category',
            'label' => 'Category',
            'rules' => 'trim',
            'column' => 'Category'
        ],

        [
            'name' => 'Notes',
            'label' => 'Notes',
            'rules' => 'trim',
            'column' => 'Notes'
        ],
        [
            'name' => 'requires',
            'label' => 'Requires',
            'rules' => 'trim',
            'column' => 'Requires'
        ],
        [
            'name' => 'attendance-date',
            'label' => 'Attendance Date',
            'rules' => 'trim|max_length[14]',
            'column' => 'attendance_date'
        ],
        [
            'name' => 'last_visit_date',
            'label' => 'Last Visit Date',
            'rules' => 'trim',
            'column' => 'last_visit_date'
        ],
        [
            'name' => 'watch_mac',
            'label' => 'watch mac',
            'rules' => 'trim',
            'column' => 'watch_mac'
        ],
        [
            'name' => 'ring_mac',
            'label' => 'ring mac',
            'rules' => 'trim',
            'column' => 'ring_mac'
        ],
        [
            'name' => 'registration-student-date',
            'label' => 'Registration Student Date',
            'rules' => 'trim',
            'column' => 'Created'
        ],
        [
            'name' => 'Classes',
            'label' => 'Class',
            'rules' => 'trim',
            'column' => 'Class'
        ],
        [
            'name' => 'Grades',
            'label' => 'Grade',
            'rules' => 'trim',
            'column' => 'Grades'
        ],
    ];

    public function getPrams()
    {
        $type = strtolower($this->uri->segment(4));
        $userId = $this->uri->segment(5);
        $this->response->abort_if(404, empty($userId) || !in_array($type, ['student']));

        $action = $this->uri->segment(6);
        $this->response->abort_if(404, !empty($action) && !in_array($action, ['picture', 'documents', 'card']));

        $language = self::LANGUAGE === "EN" ? "english" : "arabic";
        $this->lang->load('Profile', $language);
        $this->load->vars(['language' => self::LANGUAGE]);

        $this->type = $type;
        $this->id = $userId;
        $this->action = $action;
        $this->table = $this->tempTables[$type];

        $enumsCodes = [
            'staff' => UsersTypes::STAFF,
            'teacher' => UsersTypes::TEACHER,
            'student' => UsersTypes::STUDENT,
        ];
        $this->userTypeCode = $enumsCodes[$type];
    }

    public function getParentsIds(): array
    {
        $results = $this->db->select('lp.Id as id')
            ->from('l2_student ls')
            ->join('l2_student_parents lsp', 'ls.Id = lsp.Student_id')
            ->join('l2_parents lp', 'lsp.Parents_Id = lp.Id')
            ->where('ls.Id', $this->id)
            ->get()
            ->result_array();

        return array_column($results, "id");
    }

    private function saveNewDocument()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('file_type', 'File Type', 'trim|required|numeric');
        $this->form_validation->set_rules('file_for', 'File For', 'trim|required|numeric');
        if (!$this->form_validation->run()) {
            $this->response->json(['status' => 'error', 'message' => validation_errors()]);
        }

        $config['upload_path'] = './uploads/documents/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '51200'; // max_size in kb
        $config['encrypt_name'] = true;
        //Load upload library
        $this->load->library('upload', $config);
        // File upload
        if (!$this->upload->do_upload('file')) {
            $this->response->json([
                'status' => 'error',
                'message' => $this->upload->display_errors()
            ]);
        }

        $file = $this->upload->data();
        $for = $this->input->post("file_for");
        $this->db->insert("documents", [
            'user_type' => $this->userTypeCode,
            'user_id' => $this->id,
            'name' => $file['orig_name'],
            'fileFor' => intval($for) === 0 ? null : $for,
            'fileType' => $this->input->post("file_type"),
            'description' => $this->input->post("description") ?? "",
            'expiryDate' => $this->input->post("expiry-date") ?? "",
            'documentNumber' => $this->input->post("document-number") ?? "",
            'link' => base_url("uploads/documents/" . $file['file_name']),
        ]);

        $this->response->json(['status' => 'ok']);
    }

    private function userCard()
    {
        $data['page_title'] = "Card";
        $data['user'] = $this->getUserProfile();
        $data['active'] = "card";

        $settings = $this->db->get('l0_global_settings', 1)->result_array()[0] ?? null;
        $this->response->abort_if(503, empty($settings));

        $data['settings'] = $settings;
        $generator = new BarcodeGeneratorHTML();
        $data['barCode'] = $generator->getBarcode($data['user']['National_Id'] ?? "", $generator::TYPE_CODE_128);
        $this->show("Shared/Schools/users-profile/card", $data);
    }

    private function getUserProfile(): ?array
    {
        $user = null;
        switch ($this->type) {
            case "staff":
                $user = $this->db->select("l2_staff.* , l2_avatars.Link as avatar, r_positions_sch.Position as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_staff` . `Id` and `l2_avatars` . `Type_Of_User` = 'Staff'", "LEFT")
                    ->join("r_positions_sch", "`r_positions_sch`.`Id` = `l2_staff`.`Position`", "LEFT")
                    ->where("l2_staff.Id", $this->id)
                    ->limit(1)
                    ->get("l2_staff")
                    ->result_array()[0] ?? null;
                break;
            case "student":
                $user = $this->db->select("l2_student.*, l2_avatars.Link as avatar, r_levels.Class as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'", "LEFT")
                    ->join('r_levels', 'r_levels.Id = l2_student.Class')
                    ->where("l2_student.Id", $this->id)
                    ->limit(1)
                    ->get("l2_student")
                    ->result_array()[0] ?? null;
                break;
            case "teacher":
                $user = $this->db->select("l2_teacher.* , l2_avatars.Link as avatar")
                    ->select("(SELECT GROUP_CONCAT(r_levels.Class) FROM `l2_teachers_classes` JOIN `r_levels` ON `r_levels`.`Id` = `l2_teachers_classes`.`class_id` WHERE `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id` ) as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_teacher` . `Id` and `l2_avatars` . `Type_Of_User` = 'Teacher'", "LEFT")
                    ->where("l2_teacher.Id", $this->id)
                    ->limit(1)
                    ->get("l2_teacher")
                    ->result_array()[0] ?? null;
                break;
        }

        $this->response->abort_if(404, empty($user));
        return $user;
    }

    private function validateProfileForm(): ?string
    {
        $this->load->library('form_validation');
        foreach ($this->inputs as $input) {
            $this->form_validation->set_rules($input['name'], $input['label'], $input['rules']);
        }
        if (!$this->form_validation->run()) return validation_errors();
        return null;
    }

    private function saveProfileChanges()
    {
        $errors = $this->validateProfileForm();

        if (!empty($errors)) {
            $this->response->json(['status' => "error", "message" => $errors]);
        }


        $fullProfile = $this->db->where("Id", $this->id)->limit(1)->get("l2_student")->result_array()[0] ?? null;
        if (empty($fullProfile)) {
            $this->response->json(['status' => "error", "message" => "invalid student"]);
        }

        $data = [];
        foreach ($this->inputs as $input) {
            $data[$input['column']] = $this->input->post($input['name']) ?? "";
        }

        $data['student_id'] = $this->id;
        $fullData = array_merge($fullProfile, $data, ['user_id' => $this->id]);

        $this->db->where("user_id", $this->id)->delete($this->table);
        $this->db->set($fullData)->insert($this->table);


        // $this->response->json($fullData);
        $this->saveStudentProfilePic($this->id, $fullProfile['National_Id'] ?? time());
        $this->response->json(['status' => "ok"]);
    }

    private function showMainProfile()
    {
        $profile = $this->getUserProfile();
        $this->response->abort_if(404, empty($profile));

        if ($this->input->method() === "post") {
            $this->saveProfileChanges();
            return;
        }

        $data['active'] = "profile";
        $data['profile'] = $profile;
        $data['slugify'] = function (string $text) {
            return str_replace(" ", "-", strtolower($text));
        };
        $data['page_title'] = "Profile";
        $data['inputs'] = [
            [
                'label' => $this->lang->line('f-n-en'),
                'name' => "F_name_EN"
            ],
            [
                'label' => $this->lang->line('m-n-en'),
                'name' => "M_name_EN"
            ],
            [
                'label' => $this->lang->line('l-n-en'),
                'name' => "L_name_EN"
            ],
            [
                'label' => $this->lang->line('f-n-ar'),
                'name' => "F_name_AR"
            ],
            [
                'label' => $this->lang->line('m-n-ar'),
                'name' => "M_name_AR"
            ],
            [
                'label' => $this->lang->line('l-n-ar'),
                'name' => "L_name_AR"
            ],
        ];
        $data['countries'] = $this->db->order_by("name", "ASC")->get("r_countries")->result_array();
        $data['cities'] = $this->db->order_by("Name_EN", "ASC")->get("r_cities")->result_array();
        $data['bloodTypes'] = $this->db->order_by("bloodtype_title_en", "ASC")->get("r_blood_type")->result_array();
        $data['genders'] = [
            [
                'id' => "M",
                "Gender_Type" => "Male"
            ],
            [
                'id' => "F",
                "Gender_Type" => "Female"
            ],
        ];
        $data['martialStatuses'] = $this->db->select("l2_martial_status.* ," . (self::LANGUAGE === "EN" ? "name" : "name_ar") . " as name")
            ->get("l2_martial_status")
            ->result_array();
        $data['relationsTypes'] = $this->db->select("relations_types.* ,name_" . strtolower(self::LANGUAGE) . " as name")
            ->order_by("name_" . strtolower(self::LANGUAGE), "ASC")
            ->get("relations_types")
            ->result_array();

        $data['documents'] = $this->db->select("documents.* , r_document.Document AS fileTypeName , relations_types.name_en as documentFor")
            ->join("relations_types", "documents.fileFor = relations_types.id", "LEFT")
            ->join("r_document", "r_document.id = documents.fileType")
            ->where("user_id", $this->id)->where("user_type", $this->userTypeCode)
            ->get("documents")->result_array();
        $data['filesTypes'] = $this->db->order_by("Document", "ASC")->get("r_document")->result_array();

        $parentsIds = $this->getParentsIds();
        $data['emergencyContacts'] = empty($parentsIds) ? [] : $this->db->order_by("Id", "ASC")->where_in("id", $parentsIds)->get("l2_parents")->result_array();

        $generator = new BarcodeGeneratorHTML();
        $data['barCode'] = $generator->getBarcode($profile['National_Id'], $generator::TYPE_CODE_128);
        $data['formatDate'] = function ($date) {
            return empty($date) ? date("Y-m-d") : date("Y-m-d", strtotime($date));
        };
        $data['age'] = $this->schoolHelper->calculateAge($profile['DOP']);

        $settings = $this->db->get('l0_global_settings', 1)->result_array()[0] ?? null;
        $this->response->abort_if(503, empty($settings));
        $data['settings'] = $settings;
        $data['isSelectedGrade'] = function ($name) use ($data) {
            return $name === $data['profile']['Grades'] ? "selected" : "";
        };
        $data['isRtl'] = self::LANGUAGE === "AR" ? "rtl" : "";
        $this->show("Shared/Schools/users-profile/main", $data);
    }

    public function user_profile()
    {
        $this->getPrams();

        switch ($this->action) {
            case "documents":
                $this->saveNewDocument();
                break;
            default:
                $this->showMainProfile();
                break;
        }
    }

    public function emergency_contact()
    {
        $this->getPrams();

        $ids = $this->input->post("id");
        $keys = $this->input->post("keys");

        $newData = [];
        //$phones[$sn] ?? ""
        foreach ($keys as $sn => $key) {
            $data = [
                "relationship_id" => $this->input->post("relationship")[$sn] ?? "",
                "Name_EN" => $this->input->post("name_en")[$sn] ?? "",
                "Name_AR" => $this->input->post("name_ar")[$sn] ?? "",
                "Nationality" => $this->input->post("nationality")[$sn] ?? "",
                "National_Id" => $this->input->post("national_id")[$sn] ?? "",
                "National_Id_Expire" => $this->input->post("national_no_expiry")[$sn] ?? "",
                "passport_no" => $this->input->post("passport_no")[$sn] ?? "",
                "passport_expiry" => $this->input->post("passport_expiry")[$sn] ?? "",
                "LANGUAGE" => $this->input->post("language")[$sn] ?? "",
                "Place_of_Birth" => $this->input->post("place_of_birth")[$sn] ?? "",
                "DOP" => $this->input->post("dop")[$sn] ?? "",
                "martial_status" => $this->input->post("martial_status")[$sn] ?? "",
                "Category" => $this->input->post("category")[$sn] ?? "",
                "blood_group" => $this->input->post("blood_type")[$sn] ?? "",

                "Phone" => $this->input->post("Phone")[$sn] ?? "",
                "sms_mobile" => $this->input->post("sms_mobile")[$sn] ?? "",
                "Email" => $this->input->post("Email")[$sn] ?? "",
                "attendance_date" => $this->input->post("attendance_date")[$sn] ?? "",
                "office_phone" => $this->input->post("office_phone")[$sn] ?? "",
                "po_box" => $this->input->post("po_box")[$sn] ?? "",
                "address" => $this->input->post("address")[$sn] ?? "",
                "Regstration_No" => $this->input->post("Regstration_No")[$sn] ?? "",
                "country" => $this->input->post("country")[$sn] ?? "",

                "hc_card_no" => $this->input->post("hc_card_no")[$sn] ?? "",
                "hc_card_expiry" => $this->input->post("hc_code_expiry")[$sn] ?? "",
                "Driving_license" => $this->input->post("driving_license")[$sn] ?? "",
                "Spouse_name" => $this->input->post("spouse_name")[$sn] ?? "",
                "Degree" => $this->input->post("degree")[$sn] ?? "",
                "Requires" => $this->input->post("requires")[$sn] ?? "",
                "Gender" => $this->input->post("gender")[$sn] ?? "",
                "Notes" => $this->input->post("notes")[$sn] ?? "",
                "Student_Id" => $this->id,
            ];

            if (isset($ids[$sn])) { // updating old parent
                $id = $ids[$sn];
                $data['user_id'] = $id;
                $this->db->where("user_id", $id)->delete("l2_temp_parents");
            } else {
                $data['user_id'] = null;
            }

            $newData[] = $data;
        }

        if (!empty($newData)) {
            $this->db->insert_batch("l2_temp_parents", $newData);
        }

        $this->response->json(['status' => 'ok']);
    }
}