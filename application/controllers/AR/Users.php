<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Users extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->config->set_item('language', 'arabic');
    }

    public function index()
    {
        $data['page_title'] = "Qlick Education | login";
        $data['hasntnav'] = true;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata)) {
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/login');
        } else {
            $this->load->view('EN/inc/header', $data);
            $ses['sessiondata'] = $sessiondata;
            $this->load->view('EN/already_loged', $ses);
        }
    }

    public function startlogin()
    {
        // this function well get the infos from "login" view .form id loginform .
        // the data sended by ajax method POST and include "username" and "password" ;
        $this->load->library('form_validation');
        $this->load->library('session');

        if ($this->input->post('password') && $this->input->post('username')) {

            $this->form_validation->set_rules('username', 'User Name', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[16]');

            if ($this->form_validation->run()) {
                $name = $this->input->post('username');
                $password = $this->input->post('password');
                $superadmin = array();
                if ($name == "admin_9090" and $password == '12345678') {
                    $superadmin[] = array("success" => '1');
                }
                if (!empty($superadmin)) {
                    foreach ($superadmin as $row) {
                        $sess_array = array(
                            'admin_id' => '1',
                            'username' => $name,
                            'language' => 'ar',
                            'type' => 'super',
                            'level' => 0,
                        );
                    }
                    $this->session->set_userdata('admin_details', $sess_array);
                    $url = base_url() . "AR/Dashboard";
                    echo "<script> location.href = '$url' </script>";
                    echo 'you are loged in..';
                } else {
                    $fonded = $this->db->query('SELECT * FROM v_login WHERE 
                        Username = "' . $name . '" ORDER BY Id DESC LIMIT 1 ')->result_array();

                    if (!empty($fonded)) {
                        foreach ($fonded as $row) {
                            $db_password = $row['Password'];
                            //echo " pass : : m : ".$db_password."<br>";
                            //echo " pass  input : ".$password."<br>";
                            $typeofuser = $row['Type'];
                            $generate = $row['generation'];
                            $login_Id = $row['Id'];
                        }
                        if (password_verify($password, $db_password)) {

                            if ($typeofuser == "admin") {
                                $admindata = $this->db->query("SELECT * FROM l0_organization
                                            WHERE username = '" . $name . "' LIMIT 1")->result_array();
                                if (!empty($admindata)) {
                                    $valid_code = true;
                                    if ($valid_code) {
                                        foreach ($admindata as $data) {
                                            $UserId = $data['Id'];
                                            $Type = $data['Type'];
                                            $enable = $data['status'];
                                            $verify = $data['verify'];
                                            $f_name = $data['AR_Title'];
                                        }

                                        if ($enable == 0) {
                                            $url = base_url() . "AR/users/disable";
                                            echo "<script> location.href = '$url' </script>";
                                        } else {
                                            $sess_array = array(
                                                'admin_id' => $UserId,
                                                'login_id' => $login_Id,
                                                'username' => $name,
                                                'f_name' => $f_name,
                                                'language' => 'ar',
                                                'type' => $Type,
                                                'level' => 1,
                                            );
                                            // Set verify == 1 +     
                                            if ($verify !== 1) {
                                                $this->db->query('UPDATE l0_organization SET verify = 1 WHERE  Id = "' . $UserId . '" LIMIT 1 ');
                                                $this->db->query("INSERT INTO 
                                                            `v_notification` (`For_User`, `User_Type`, `User_Entred`, `Is_read`, `Created`) 
                                                            VALUES ('1', 'super', '" . $name . "', '0', '" . date('Y-m-d') . "');");
                                            }
                                            $this->session->set_userdata('admin_details', $sess_array);
                                            if ($Type == "Company") {
                                                $url = base_url() . "AR/Company";
                                            } else {
                                                $url = base_url() . "AR/DashboardSystem";
                                            }
                                            echo "<script> location.href = '$url' </script>";
                                        }
                                    } else {
                                        echo " ! نعتذر لايمكنك تسجيل الدخول  ";
                                    }
                                }
                            } else if ($typeofuser == "school") {
                                $schooldata = $this->db->query("SELECT * FROM l1_school
										WHERE username = '" . $name . "' LIMIT 1")->result_array();
                                if (!empty($schooldata)) {
                                    $valid_code = false;
                                    if (strlen($generate) == 12) {
                                        $randOfReg = $schooldata[0]['generation'];
                                        $rand_school = substr($randOfReg, 8, 12);
                                        $rand = substr($generate, 8, 12);
                                        if (strlen($rand) == 4) {
                                            if ($rand == $rand_school) {
                                                $valid_code = true;
                                            }
                                        }
                                    }

                                    if ($valid_code) {
                                        foreach ($schooldata as $data) {
                                            $UserId = $data['Id'];
                                            $enable = $data['status'];
                                            $schoolid = $data['Id'];
                                            $verify = $data['verify'];
                                            $parent = $data['Added_By'];
                                        }

                                        if ($enable == '0') {
                                            $url = base_url() . "AR/users/disable";
                                            echo "<script> location.href = '$url' </script>";
                                        } else {
                                            $sess_array = array(
                                                'admin_id' => $UserId,
                                                'login_id' => $login_Id,
                                                'username' => $name,
                                                'language' => 'ar',
                                                'type' => 'school',
                                                'level' => 2,
                                            );
                                            // Set verify == 1     
                                            if ($verify !== 1) {
                                                $this->db->query('UPDATE l1_school SET verify = 1 WHERE  Id = "' . $UserId . '" LIMIT 1 ');
                                                $this->db->query("INSERT INTO 
                                                    `v_notification` (`For_User`, `User_Type`, `User_Entred`, `Is_read`, `Created`) 
                                                    VALUES ('" . $parent . "', 'Ministry', '" . $name . "', '0', '" . date('Y-m-d') . "');");
                                            }
                                            $this->session->set_userdata('admin_details', $sess_array);
                                            $classes = $this->db->query("SELECT * FROM
                                            l2_grades WHERE Id = '" . $schoolid . "'")->result_array();
                                            if (empty($classes)) {
                                                $url = base_url() . "AR/schools/welcome";
                                            } else {
                                                $url = base_url() . "AR/schools/welcome";
                                            }
                                            echo "<script> location.href = '$url' </script>";
                                            echo "...تم تسجيل الدخول لحظات من فضلك";
                                        }
                                    } else {
                                        echo " ! نعتذر لايمكنك تسجيل الدخول  ";
                                    }
                                }
                            } else if ($typeofuser == "department") {
                                $departmentData = $this->db->query("SELECT * FROM l1_department WHERE username 
                                        = '" . $name . "' LIMIT 1")->result_array();
                                $departmentData_co = $this->db->query("SELECT * FROM l1_co_department WHERE username 
                                        = '" . $name . "' LIMIT 1")->result_array();
                                if (!empty($departmentData)) {

                                    foreach ($departmentData as $data) {
                                        $UserId = $data['Id'];
                                        $enable = $data['status'];
                                        $departmentID = $data['Id'];
                                        $verify = $data['verify'];
                                        $parent = $data['Added_By'];
                                    }
                                    if ($verify !== 1) {
                                        $this->db->query('UPDATE l1_department SET verify = 1 WHERE  Id = "' . $UserId . '" LIMIT 1 ');
                                        $this->db->query("INSERT INTO 
                                                `v_notification` (`For_User`, `User_Type`, `User_Entred`, `Is_read`, `Created`) 
                                                VALUES ('" . $parent . "', 'Company', '" . $name . "', '0', '" . date('Y-m-d') . "');");
                                    }
                                    if ($enable == '0') {
                                        $url = base_url() . "AR/users/disable";
                                        echo "<script> location.href = '$url' </script>";
                                    } else {
                                        $sess_array = array(
                                            'admin_id' => $UserId,
                                            'login_id' => $login_Id,
                                            'username' => $name,
                                            'language' => 'ar',
                                            'type' => 'department',
                                            'level' => 2,
                                        );
                                        $this->session->set_userdata('admin_details', $sess_array);
                                        $url = base_url() . "AR/Departments";
                                        echo "<script> location.href = '$url' </script>";
                                        echo "...تم تسجيل الدخول لحظات من فضلك";
                                    }
                                    ///// cheke if the department in l1_co_department 
                                } elseif (!empty($departmentData_co)) {
                                    foreach ($departmentData_co as $data) {
                                        $UserId = $data['Id'];
                                        $enable = $data['status'];
                                        $departmentID = $data['Id'];
                                        $verify = $data['verify'];
                                        $parent = $data['Added_By'];
                                        $dep_type = $data['Dept_Type'];
                                        $f_name = $data['Dept_Name_AR'];
                                    }
                                    if ($verify !== 1) {
                                        $this->db->query('UPDATE l1_department SET verify = 1 WHERE  Id = "' . $UserId . '" LIMIT 1 ');
                                        $this->db->query("INSERT INTO 
                                                `v_notification` (`For_User`, `User_Type`, `User_Entred`, `Is_read`, `Created`) 
                                                VALUES ('" . $parent . "', 'Company', '" . $name . "', '0', '" . date('Y-m-d') . "');");
                                    }
                                    if ($enable == '0') {
                                        $url = base_url() . "AR/users/disable";
                                        echo "<script> location.href = '$url' </script>";
                                    } else {
                                        $sess_array = array(
                                            'admin_id' => $UserId,
                                            'login_id' => $login_Id,
                                            'username' => $name,
                                            'f_name' => $f_name,
                                            'language' => 'ar',
                                            'type' => 'department_Company',
                                            'dept_ype' => $dep_type,
                                            'level' => 2,
                                        );
                                        $this->session->set_userdata('admin_details', $sess_array);
                                        $url = base_url() . "AR/Company_Departments";
                                        echo "<script> location.href = '$url' </script>";
                                        echo "...تم تسجيل الدخول لحظات من فضلك";
                                    }
                                }
                            } elseif ($typeofuser == "Teacher") {
                                $is_parent = $this->db->query(" SELECT * FROM v_login WHERE 
                                        Username = '" . $name . "' AND `Type` = 'Parent' ORDER BY Id DESC LIMIT 1")->result_array();
                                if (!empty($is_parent)) {
                                    // go to choise the login type
                                    $this->session->set_flashdata('name', $name);
                                    $this->session->set_flashdata('second_type', "Teacher");
                                    $url = base_url() . "AR/users/ChooseLogInType";
                                    echo "<script> location.href = '$url' </script>";
                                    echo "Please wait";
                                } else {

                                    $departmentData = $this->db->query("SELECT * FROM l2_teacher
                                            WHERE username = '" . $name . "' LIMIT 1")->result_array();
                                    if (!empty($departmentData)) {
                                        foreach ($departmentData as $data) {
                                            $UserId = $data['Id'];
                                            $SchoolId = $data['Added_By'];
                                            $perm = $data['PermSchool'];
                                        }
                                        // if ($perm == '1') {
                                        //     $sess_array = array(
                                        //         'Teacher_ID' => $UserId,
                                        //         'username' => $name,
                                        //         'admin_id' => $SchoolId,
                                        //         'language' => 'ar',
                                        //         'type' => 'School_Perm',
                                        //         'hasperm' => true,
                                        //         'level' => 3,
                                        //     );
                                        //     $this->session->set_userdata('admin_details', $sess_array);
                                        //     $url = base_url() . "AR/School_Permition";
                                        //     echo "<script> location.href = '$url' </script>";
                                        //     echo "لحظات من فضلك ...";
                                        // } else {
                                        //     $sess_array = array(
                                        //         'admin_id' => $UserId,
                                        //         'login_id' => $login_Id,
                                        //         'username' => $name,
                                        //         'language' => 'ar',
                                        //         'type' => 'Teacher',
                                        //         'level' => 3,
                                        //     );
                                        //     $this->session->set_userdata('admin_details', $sess_array);
                                        //     $url = base_url() . "AR/Teachers/Home";
                                        //     echo "<script> location.href = '$url' </script>";
                                        //     echo "لحظات من فضلك ....";
                                        // }
                                        $sess_array = array(
                                            'admin_id' => $UserId,
                                            'login_id' => $login_Id,
                                            'username' => $name,
                                            'language' => 'ar',
                                            'type' => 'Teacher',
                                            'level' => 3,
                                        );
                                        $this->session->set_userdata('admin_details', $sess_array);
                                        $url = base_url() . "AR/teachers/Home";
                                        echo "<script> location.href = '$url' </script>";
                                        echo "لحظات من فضلك ....";
                                    }
                                }
                                // End Teacher
                            } elseif ($typeofuser == "Staff") {
                                $departmentData = $this->db->query("SELECT * FROM l2_staff 
                                        WHERE username = '" . $name . "' LIMIT 1")->result_array();
                                if (!empty($departmentData)) {
                                    foreach ($departmentData as $data) {
                                        $UserId = $data['Id'];
                                        $SchoolId = $data['Added_By'];
                                        $Perm = $data['PermSchool'];
                                    }

                                    // if ($Perm == 1) {
                                    //     $sess_array = array(
                                    //         'Staff_ID' => $UserId,
                                    //         'login_id' => $login_Id,
                                    //         'username' => $name,
                                    //         'admin_id' => $SchoolId,
                                    //         'language' => 'ar',
                                    //         'type' => 'School_Perm',
                                    //         'hasperm' => true,
                                    //         'level' => 3,
                                    //     );

                                    //     $this->session->set_userdata('admin_details', $sess_array);
                                    //     $url = base_url() . "AR/School_Permition";
                                    //     echo "<script> location.href = '$url' </script>";
                                    //     echo "Signed in moments please wait...";
                                    // } else {
                                    //     $sess_array = array(
                                    //         'admin_id' => $UserId,
                                    //         'login_id' => $login_Id,
                                    //         'username' => $name,
                                    //         'language' => 'ar',
                                    //         'type' => 'staff',
                                    //         'level' => 3,
                                    //     );
                                    //     $this->session->set_userdata('admin_details', $sess_array);
                                    //     $url = base_url() . "AR/staffs/Home";
                                    //     echo "<script> location.href = '$url' </script>";
                                    //     echo "لحظات من فضلك ....";
                                    // }
                                    $sess_array = array(
                                        'admin_id' => $UserId,
                                        'login_id' => $login_Id,
                                        'username' => $name,
                                        'language' => 'ar',
                                        'type' => 'staff',
                                        'level' => 3,
                                    );
                                    $this->session->set_userdata('admin_details', $sess_array);
                                    $url = base_url() . "AR/staffs/Home";
                                    echo "<script> location.href = '$url' </script>";
                                    echo "لحظات من فضلك ....";
                                } else {
                                    echo "نأسف لم نتمكن من إيجاد هذا المستخدم !! ";
                                    //echo $v_genrate." ".$db_generate;
                                }
                                // End Staff
                            } elseif ($typeofuser == "Patient") {
                                $departmentData = $this->db->query("SELECT * FROM l2_patient 
										WHERE username = '" . $name . "' LIMIT 1")->result_array();
                                if (!empty($departmentData)) {

                                    foreach ($departmentData as $data) {
                                        $UserId = $data['Id'];
                                        $DepId = $data['Added_By'];
                                        $Perm = $data['Perm'];
                                    }
                                    // if ($Perm == 1) {
                                    //     $sess_array = array(
                                    //         'Patient_ID' => $UserId,
                                    //         'login_id' => $login_Id,
                                    //         'username' => $name,
                                    //         'admin_id' => $DepId,
                                    //         'language' => 'ar',
                                    //         'type' => 'Dept_Perm',
                                    //         'hasperm' => true,
                                    //         'level' => 3,
                                    //     );
                                    //     $this->session->set_userdata('admin_details', $sess_array);
                                    //     $url = base_url() . "AR/Departments_Permition";
                                    //     echo "<script> location.href = '$url' </script>";
                                    //     echo "...تم تسجيل الدخول لحظات من فضلك";
                                    // } else {
                                    //     $sess_array = array(
                                    //         'username' => $name,
                                    //         'admin_id' => $UserId,
                                    //         'login_id' => $login_Id,
                                    //         'language' => 'ar',
                                    //         'type' => 'Patient',
                                    //         'level' => 3,
                                    //     );
                                    //     $this->session->set_userdata('admin_details', $sess_array);
                                    //     $url = base_url() . "AR/Results";
                                    //     echo "<script> location.href = '$url' </script>";
                                    //     echo "...تم تسجيل الدخول لحظات من فضلك";
                                    // }
                                    $sess_array = array(
                                        'username' => $name,
                                        'admin_id' => $UserId,
                                        'login_id' => $login_Id,
                                        'language' => 'ar',
                                        'type' => 'Patient',
                                        'level' => 3,
                                    );
                                    $this->session->set_userdata('admin_details', $sess_array);
                                    $url = base_url() . "AR/Results";
                                    echo "<script> location.href = '$url' </script>";
                                    echo "...تم تسجيل الدخول لحظات من فضلك";
                                }
                            } elseif ($typeofuser == "Parent") {
                                $isregestred = $this->db->get_where('l2_parents', array('login_key' => $login_Id))->result_array();
                                $sess_array = array(
                                    'username' => $name,
                                    'login_id' => $login_Id,
                                    'admin_id' => empty($isregestred) ? $login_Id : $isregestred[0]['Id'],
                                    'type' => 'Parent',
                                    'regestred' => empty($isregestred) ? false : true,
                                    'level' => 2,
                                );
                                $this->session->set_userdata('admin_details', $sess_array);
                                $url = base_url("AR/Parents/Home");
                                echo "<script> location.href = '$url' </script>";
                                echo "...تم تسجيل الدخول لحظات من فضلك";
                            } elseif ($typeofuser == "Student") {
                                $studentdata = $this->db->query("SELECT * FROM l2_student WHERE 
                                        username = '" . $name . "' LIMIT 1")->result_array();
                                if (!empty($studentdata)) {

                                    foreach ($studentdata as $data) {
                                        $UserId = $data['Id'];
                                        $DepId = $data['Added_By'];
                                    }
                                    $sess_array = array(
                                        'username' => $name,
                                        'login_id' => $login_Id,
                                        'admin_id' => $UserId,
                                        'language' => 'ar',
                                        'type' => 'Student',
                                        'level' => 3,
                                    );
                                    $this->session->set_userdata('admin_details', $sess_array);
                                    $url = base_url() . "AR/Students/Home";
                                    echo "<script> location.href = '$url' </script>";
                                    echo "...تم تسجيل الدخول لحظات من فضلك";
                                }
                            } elseif ($typeofuser == "visitor") {
                                $sess_array = array(
                                    'username' => $name,
                                    'login_id' => $login_Id,
                                    'admin_id' => $login_Id,
                                    'language' => 'ar',
                                    'type' => 'Student',
                                    'level' => 3,
                                );
                                $this->session->set_userdata('admin_details', $sess_array);
                                $url = base_url() . "AR/Results";
                                echo "<script> location.href = '$url' </script>";
                                echo "Signed in moments please wait...";
                            } else {
                                echo ' the user type "' . $typeofuser . '" not supported yet !!';
                            }
                        } else {
                            echo "! إسم المستخدم أو كلمة المرور خطأ ";
                        }
                    } else {
                        echo "! إسم المستخدم أو كلمة المرور خطأ ";
                    }
                } ///// end the other typest of users
            } else {
                echo validation_errors();
            }
        }
    }

    public function CompletReg()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Manager') && $this->input->post('Phone')) {
            $admin = $this->form_validation->set_rules('Manager', 'Manager', 'trim|required');
            $phone = $this->form_validation->set_rules('Phone', 'Phone', 'trim|required');
            if ($this->form_validation->run()) {
                $admin = $this->input->post('Manager');
                $phone = $this->input->post('Phone');
                if ($this->db->query("UPDATE  l0_organization SET Manager = '" . $admin . "', Tel = '" . $phone . "' WHERE Id = '" . $sessiondata['admin_id'] . "'  ")) {
                    echo ' تم حفظ البيانات ';
                    echo '<script>location.reload();</script>';
                } else {
                    echo " نعتذر لدينا غلط ";
                }
            } else {

                echo validation_errors();
            }
        } else {
            echo " الرجاء إكمال إدخال البيانات  ";
        }
    }

    public function UpdateProfile()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $id = $sessiondata['admin_id'];
        if (is_numeric($id)) {
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('AR/inc/header', $data);
            $adminInfos['theadminData'] = $this->db->query("SELECT * FROM l0_organization 
            WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->load->view('AR/update_our_data', $adminInfos);
            $this->load->view('AR/inc/footer');
        }
    }

    public function UpdateSystem()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Update System ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $listofadmins['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` ASC')->result_array();
        $this->load->view('AR/Upadate_System', $listofadmins);
        $this->load->view('AR/inc/footer');
    }

    public function startUpdatingSystem()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;

        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');

        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager', 'Manager', 'trim|required');
            $this->form_validation->set_rules('Phone_Number', 'Phone Number', 'trim|required|alpha_numeric');

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager = $this->input->post('Manager');
                $Phone_Number = $this->input->post('Phone_Number');
                $id = $sessiondata['admin_id'];

                if ($this->db->query("UPDATE l0_organization
                SET AR_Title = '" . $Arabic_Title . "', EN_Title = '" . $English_Title . "', 
                Manager = '" . $Manager . "' , Tel = '" . $Phone_Number . "'
                WHERE id = '" . $id . "' ")) {
                    echo "<script>$('.card form').html('');</script>";
                    echo '<script>
                    $("#Toast").addClass("inserted_suc");
                    </script>';
                    echo '<script>
                    $("#Toast").css("background","#0eacd8");
                    $("#Toast").css("margin-bottom","0px");
                    </script>';
                    echo "<h3>The data is updated. successfuly </h3>";
                    echo '<button _ngcontent-gvm-c151="" mat-raised-button="" color="primary" class="mat-focus-indicator mr-3 mat-raised-button mat-button-base mat-primary" onclick="back()" id="sendbyemail">
                    <span class="mat-button-wrapper"> Back To Main Dashboard </span>
                    <span matripple="" class="mat-ripple mat-button-ripple"></span>
                    <span class="mat-button-focus-overlay"></span>
                    </button>';
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function ForgetPassword()
    {
        $data['page_title'] = "Qlick Education | login";
        $data['hasntnav'] = true;
        $this->load->view('AR/ForgetPassword');
        $this->load->view('AR/inc/header', $data);
    }

    public function checkemail()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        if ($this->form_validation->run()) {
            $Username = $this->input->post('username');
            $infos = $this->db->query(" SELECT * FROM `v_login` WHERE `Username` = '" . $Username . "' ")->result_array();
            if (!empty($infos)) {
                $Type = $infos[0]['Type'];
                $login_id = $infos[0]['Id']; ?>
                <script>
                    Swal.fire({
                        icon: "warning",
                        title: 'Please Enter Your Email',
                        input: 'email',
                        confirmButtonText: 'Submit',
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#5b8ce8",
                        preConfirm: function preConfirm(email) {
                            $('#EmailCheck').html('<h3 class="text-center w-100">Please wait...</h3>');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url(); ?>EN/Users/SendEmail',
                                data: {
                                    email: email,
                                    username: "<?php echo $Username; ?>",
                                    type: "<?php echo $Type; ?>",
                                    login_id: <?php echo $login_id   ?>
                                },
                                success: function (data) {
                                    $('#EmailCheck').html('<h3 class="text-center w-100">Close this page and check your email Please !</h3>');
                                    Swal.fire(
                                        'success',
                                        data,
                                        'success'
                                    )
                                },
                                ajaxError: function () {
                                    Swal.fire(
                                        'error',
                                        'oops!! we have a error',
                                        'error'
                                    )
                                }
                            });
                        },
                        allowOutsideClick: false
                    });
                </script>
                <?php
            } else {
                ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "We can't find this user name !!",
                        footer: '<a href>Why do I have this issue?</a>'
                    });
                </script>
                <?php
            }
        } else {
            echo validation_errors();
        }
    } //end main function

    private function isssetindb_byusername($table, $Username)
    {
        $geted = $this->db->query("SELECT * FROM `$table` WHERE Username = '" . $Username . "' ")->result_array();
        return ($geted);
    }

    private function sendResetEmail($email, $username, $type)
    {
        $expFormat = mktime(
            date("H"),
            date("i"),
            date("s"),
            date("m"),
            date("d") + 1,
            date("Y")
        );
        $expDate = date("Y-m-d H:i:s", $expFormat);
        $key = md5(2418 * 2 . "$email");
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $this->load->library('Encrypt_url');
        //$id_link = $this->base64_url_encode($login_id);
        $id_link = $this->encrypt_url->safe_b64encode($login_id);
        $this->db->query("INSERT INTO `password_reset_tbl` (`username`, `key`, `typeofUser`, `expDate`)
        VALUES ('" . $username . "', '" . $key . "', '" . $type . "', '" . $expDate . "');");
        $this->load->library('email');
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.hostinger.com',
            'smtp_port' => 465,
            'smtp_user' => 'jobs@qlicksystems.com',
            'smtp_pass' => 'O?#f:Kc19#z',
            'smtp_crypto' => 'ssl',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $messg = '';
        $messg .= '<center>';
        $messg .= ' <img src="' . base_url('assets/images/defaulticon.png') . '" alt="Wellbeing Scales" class="logo logo-dark">';
        $messg .= '<p>Dear user,</p>';
        $messg .= '<p>Please click on the following link to reset your password.</p>';
        $messg .= '<p><a style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;" 
        href="' . base_url() . 'AR/users/resetPassword/' . $key . '/' . $username . '/reset"
        target="_blank">Go To Link ' . $username . '</a></p>';
        $messg .= '<p>
          The link will expire after 1 day for security reason.</p>';
        $messg .= '<p>If you did not request this forgotten password email, no action 
        is needed, your password will not be reset. However, you may want to log into 
        your account and change your security password as someone may have guessed it.</p>';
        $messg .= '<p>Thanks,</p>';
        $messg .= '<p>qlicksystems</p>';
        $messg .= '</center>';

        $this->email->initialize($config);
        $this->email->set_newline('\r\n');
        $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
        $this->email->to($email);
        $this->email->subject(' You User Name And Password ');
        $this->email->message($messg);

        if (!$this->email->send()) {
            echo ' !! لدينا مشكلة في إرسال الإيميل حاليا يمكنك إرساله يدويا , إسم المستخدم : ' . $username . '  ';
        } else {
            echo '!! تم لإرسال الإيميل ';
        }
    }

    public function SendEmail()
    {
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $type = $this->input->post('username');
        $login_id = $this->input->post('login_id');
        $this->sendResetEmail($email, $username, $type, $login_id);
    }

    public function resetPassword()
    {
        if ($this->uri->segment(3) && $this->uri->segment(6) && $this->uri->segment(5) && $this->uri->segment(6) == "reset") {
            //print_r($this->uri->segment_array());
            $key = $this->uri->segment(4);
            $log_id = $this->uri->segment(5);
            $reset = $this->uri->segment(6);
            $this->load->library('Encrypt_url');
            $decoded_id = $this->encrypt_url->safe_b64decode($log_id);
            $expFormat = mktime(
                date("H"),
                date("i"),
                date("s"),
                date("m"),
                date("d"),
                date("Y")
            );
            $expDate = date("Y-m-d H:i:s", $expFormat);
            $passtemp = $this->db->query("SELECT * FROM `password_reset_tbl` 
            WHERE `key`='" . $key . "' and `login_id`='" . $decoded_id . "' AND `expDate` > '" . $expDate . "' ")->result_array();
            //$passtemp = array();
            if (!empty($passtemp)) {
                $data['log_id'] = $log_id;
                $this->load->view('EN/Global/set_new_password_for_forgeted', $data);
            } else {
                $this->load->view('EN/Global/expired_link');
            }
        } else {
            $this->load->view('EN/Global/accessForbidden');
        }
    }

    public function startupdating_thepassword()
    {
        $this->load->library('form_validation');
        $this->load->library('Encrypt_url');
        if ($this->input->post("pass_1") && $this->input->post("pass_2") && $this->input->post("log_id")) {
            $this->form_validation->set_rules('pass_1', 'First password', 'trim|required|min_length[6]|max_length[16]');
            $this->form_validation->set_rules('pass_2', 'Second password', 'trim|required|min_length[6]|max_length[16]|matches[pass_1]');
            $this->form_validation->set_rules('log_id', 'log_id', 'trim|required');
            if ($this->form_validation->run()) {
                $password = $this->input->post("pass_1");
                $log_id = $this->input->post("log_id");
                $id = $this->encrypt_url->safe_b64decode($log_id);
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                if ($this->db->query("UPDATE `v_login` SET `Password` = '" . $hash_pass . "' WHERE Id = '" . $id . "' ")) {
                    echo "ok";
                }
            } else {
                echo validation_errors();
            }
        }
    }


    public function UpladeImgs()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $config['upload_path'] = './uploads/avatars/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = time() . "-UserProfile" . rand(1555, 7000);
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            $data = array('upload_data' => $this->upload->data());
            $type = $sessiondata['type'];
            $name = $data['upload_data']['file_name'];
            $Priv = $this->db->query("SELECT * FROM `l2_avatars`
                WHERE For_User = '" . $sessiondata['admin_id'] . "' AND Type_Of_User = '" . $type . "' ")->result_array();
            if (empty($Priv)) {
                $this->db->query("INSERT INTO `l2_avatars` (`For_User`, `Link` ,`Type_Of_User`, `Created`) 
                VALUES ('" . $sessiondata['admin_id'] . "', '" . $name . "', '" . $type . "','" . date('Y-m-d') . "');");
            } else {
                $this->db->query("UPDATE `l2_avatars` SET `Link` = '" . $name . "'
                WHERE `For_User` = '" . $sessiondata['admin_id'] . "' AND `Type_Of_User` = '" . $type . "' ");
            }
            echo "تم تحديث الصورة الرمزية.";
            $link = "";
            if ($sessiondata['type'] == 'super') {
                $link = "AR/Dashboard";
            } elseif ($sessiondata['type'] == 'Ministry' || $sessiondata['type'] == 'Company') {
                $link = "AR/dashboardSystem";
            } elseif ($sessiondata['type'] == 'school') {
                $link = "AR/schools";
            } elseif ($sessiondata['type'] == 'department') {
                $link = "AR/Departments";
            } elseif ($sessiondata['type'] == 'Teacher') {
                $link = "";
            } elseif ($sessiondata['type'] == 'Staff') {
                $link = "";
            } elseif ($sessiondata['type'] == 'Patient') {
                $link = "AR/Departments_Permition";
            } elseif ($sessiondata['type'] == 'Parent') {
                $link = "";
            } elseif ($sessiondata['type'] == 'Student') {
                $link = "";
            } elseif ($sessiondata['type'] == 'Department_Company') {
                $link = "AR/Company_Departments";
            }
            if ($link !== "") {
                ?>
                <script>
                    location.href = "<?php echo base_url() . $link; ?>";
                </script>
                <?php
            } else {
                ?>
                <script>
                    location.reload();
                </script>
                <?php
            }
            //redirect("Results/changePhoto");
        }
    }

    public function UpladeImgsForMember()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $config['upload_path'] = './uploads/avatars/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['file_name'] = $this->input->post('NationalId');
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            $data = array('upload_data' => $this->upload->data());
            $type = $this->input->post('User_Type');
            $UserId = $this->input->post('user_id');
            $name = $data['upload_data']['file_name'];
            $Priv = $this->db->query("SELECT * FROM `l2_avatars`
                WHERE For_User = '" . $UserId . "' AND Type_Of_User = '" . $type . "' ")->result_array();
            if (empty($Priv)) {
                $this->db->query("INSERT INTO `l2_avatars` (`For_User`, `Link` ,`Type_Of_User`, `Created`) 
                VALUES ('" . $UserId . "', '" . $name . "', '" . $type . "','" . date('Y-m-d') . "');");
            } else {
                $this->db->query("UPDATE `l2_avatars` SET `Link` = '" . $name . "'
                WHERE `For_User` = '" . $UserId . "' AND `Type_Of_User` = '" . $type . "' ");
            }
            echo "تم تحديث الصورة الرمزية.";
            if ($this->input->post('Pat')) {
                $link = "AR/Departments/MembersList";
            } elseif (!$this->input->post('Pat')) {
                $link = "AR/schools/MembersList";
            }
            ?>
            <script>
                location.href = "<?php echo base_url() . $link; ?>";
            </script>
            <?php
            //redirect("Results/changePhoto");
        }
    }

    public function UpladeImgsForMember_Co()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $config['upload_path'] = './uploads/co_avatars/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = $this->input->post('nationalid');
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            $data = array('upload_data' => $this->upload->data());
            $type = $this->input->post('User_Type');
            $UserId = $this->input->post('user_id');
            $name = $data['upload_data']['file_name'];
            $Priv = $this->db->query("SELECT * FROM `l2_co_avatars`
                WHERE For_User = '" . $UserId . "' AND Type_Of_User = '" . $type . "' ")->result_array();
            if (empty($Priv)) {
                $this->db->query("INSERT INTO `l2_co_avatars` (`For_User`, `Link` ,`Type_Of_User`, `Created`) 
                VALUES ('" . $UserId . "', '" . $name . "', '" . $type . "','" . date('Y-m-d') . "');");
            } else {
                $this->db->query("UPDATE `l2_co_avatars` SET `Link` = '" . $name . "'
                WHERE `For_User` = '" . $UserId . "' AND `Type_Of_User` = '" . $type . "' ");
            }
            echo "تم تحديث الصورة بنجاح ";
            $link = "AR/Company_Departments/MembersList";
        }
        ?>
        <script>
            location.href = "<?php echo base_url() . $link; ?>";
        </script>
        <?php
        //redirect("Results/changePhoto");
    }

    public function UpladeImgsStudent()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sudentid = $this->input->post("StudentId");
        $config['upload_path'] = './uploads/avatars/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = $this->input->post("NationalId");
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            $data = array('upload_data' => $this->upload->data());

            $type = "Student";
            $name = $data['upload_data']['file_name'];
            $Priv = $this->db->query("SELECT * FROM `l2_avatars`
                WHERE For_User = '" . $sudentid . "' AND Type_Of_User = '" . $type . "' ")->result_array();
            if (empty($Priv)) {
                $this->db->query("INSERT INTO `l2_avatars` (`For_User`, `Link` ,`Type_Of_User`, `Created`) 
                VALUES ('" . $sudentid . "', '" . $name . "', '" . $type . "','" . date('Y-m-d') . "');");
            } else {
                $this->db->query("UPDATE `l2_avatars` SET `Link` = '" . $name . "'
                WHERE `For_User` = '" . $sudentid . "' AND `Type_Of_User` = '" . $type . "' ");
            }
            echo "تم تغيير الصورة بنجاح";
            if ($this->input->post('By_Perm')) { ?>
                <script>
                    location.href = "<?php echo base_url(); ?>AR/schools/MembersList";
                </script>
            <?php } elseif ($this->input->post('Class')) { ?>
                <script>
                    location.href = "<?php echo base_url(); ?>AR/Schools/MembersList";
                </script>
            <?php } else { ?>
                <script>
                    location.href = "<?php echo base_url(); ?>AR/Results/Select_Child";
                </script>
                <?php
                //redirect("Results/changePhoto");
            }
        }
    }

    public function changePhoto()
    {
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->uri->segment(4) && $this->uri->segment(3) && $this->uri->segment(3) == "Student") {
            $StudentId = $this->uri->segment(4);
            $data['StudentId'] = $StudentId;
            $data['sessiondata'] = $sessiondata;
        }
        if (!empty($sessiondata)) {
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = " Qlick Health | Enter Result ";
            $data['hasntnav'] = true;
            $this->load->view("AR/inc/header", $data);
            $this->load->view("AR/Global/changePhoto");
            $this->load->view("AR/inc/footer");
        } else {
            redirect('AR/users');
        }
    }

    public function ChildAccount()
    {
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata) && $sessiondata['type'] == 'Parent' && $this->uri->segment(3)) {
            $ID = $this->uri->segment(3);
            if (is_numeric($ID)) {
                $data['sessiondata'] = $sessiondata;
                $data['page_title'] = " Qlick Health | Edit Child Profile ";
                $data['hasntnav'] = true;
                $data['CH_ID'] = $ID;
                $student = $this->db->query("SELECT * FROM `l2_student` WHERE 
                `Parent_NID` = '" . $sessiondata['username'] . "' AND Id = '" . $ID . "' LIMIT 1 ")->result_array();
                if (!empty($student)) {
                    $maindata['studentdata'] = $student;
                    $this->load->view("AR/inc/header", $data);
                    $this->load->view("AR/Parent/Edit_Child", $maindata);
                    $this->load->view("AR/inc/footer");
                } else {
                    $error['Title'] = 'Dont Find Any Data Here !!';
                    $error['Desc'] = 'The Child You Chois May be Not Exist or Not Yours !! Please back And Try Again';
                    $error['Link'] = 'Results/Select_Child';
                    $this->load->view("AR/Global/YouCantEnter", $error);
                }
            } else {
                redirect("AR/Results/Select_Child");
            }
        } else {
            redirect("AR/Results/Select_Child");
        }
    }

    public function MyProfile()
    {
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        //print_r($sessiondata);
        if (!empty($sessiondata)) {
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = " Qlick Health | Enter Result ";
            $data['hasntnav'] = true;
            $this->load->view("AR/inc/header", $data);
            if ($sessiondata["type"] == "super") {
                $this->load->view("AR/SuperAdmin/MyProfile");
            } elseif ($sessiondata['type'] == "Company" || $sessiondata['type'] == "Ministry") {
                $this->load->view("AR/Company/MyProfile");
            } elseif ($sessiondata['type'] == "school") {
                $this->load->view("AR/schools/MyProfile");
            } elseif ($sessiondata['type'] == "department") {
                $this->load->view("AR/Department/MyProfile");
            } elseif ($sessiondata['type'] == "department_Company") {
                $this->load->view("AR/Department_comp/MyProfile");
            }
            $this->load->view("AR/inc/footer");
        } else {
            redirect('AR/users');
        }
    }

    public function ResetSuperAdmin()
    {
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata) && $this->input->post('Username')) {
            $newuser = $this->input->post('Username');
            if ($this->db->query("UPDATE superadmin SET Username = '" . $newuser . "'
          WHERE Id = '" . $sessiondata['admin_id'] . "' ")) {
                $OldNameEnc = $this->input->post("OldUserName");
                $OldName = $this->encryption->decrypt($OldNameEnc);
                $this->db->query("UPDATE `v_login` SET Username = '" . $newuser . "' WHERE Username = '" . $OldName . "'  ");
                $sessiondata['username'] = $newuser;
                ?>
                <script>
                    Swal.fire({
                        title: 'Success',
                        text: ' User Name Updated Successfully !',
                        icon: 'success',
                        confirmButtonColor: '#5b8ce8',
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                </script>
                <?php
            }
        } else {
            echo "No Data Found !!";
            ?>
            <script>
                setTimeout(function () {
                    location.reload();
                }, 500);
            </script>
            <?php
        }
    }

    public function ResetL1_Org()
    {
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
            $newuser = $this->input->post('Username');
            $EN_Title = $this->input->post('EN_Title');
            $AR_Title = $this->input->post('AR_Title');
            $Email = $this->input->post('Email');
            if ($this->db->query("UPDATE `l0_organization` SET 
                AR_Title = '" . $AR_Title . "',
                EN_Title = '" . $EN_Title . "', Email = '" . $Email . "'
                WHERE Id = '" . $sessiondata['admin_id'] . "' ")) {
                ?>
                <script>
                    Swal.fire({
                        title: 'تم',
                        text: ' تم التحديث بنجاح ',
                        icon: 'success',
                        confirmButtonColor: '#5b8ce8',
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                </script>
                <?php
            }
        } else {
            echo "No Data Found !!";
            ?>
            <script>
                setTimeout(function () {
                    location.reload();
                }, 500);
            </script>
            <?php
        }
    }

    public function SchoolUserupdate()
    {
        $this->load->library('form_validation');
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata) && $this->input->post('School_Name_AR')) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');

            $this->form_validation->set_rules('School_Name_AR', 'School Name AR', 'trim|required');
            $this->form_validation->set_rules('School_Name_EN', 'School Name EN', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager EN', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager AR', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|valid_email');

            if ($this->form_validation->run()) {
                //set The Vars
                $School_Name_AR = $this->input->post("School_Name_AR");
                $School_Name_EN = $this->input->post("School_Name_EN");
                $Manager_EN = $this->input->post("Manager_EN");
                $Manager_AR = $this->input->post("Manager_AR");
                $Phone = $this->input->post("Phone");
                $Email = $this->input->post("Email");

                if ($this->db->query("UPDATE `l1_school` SET 
                    School_Name_AR = '" . $School_Name_AR . "' , School_Name_EN = '" . $School_Name_EN . "' ,
                    Manager_EN = '" . $Manager_EN . "', Manager_AR = '" . $Manager_AR . "', Phone = '" . $Phone . "'
                    , Email = '" . $Email . "' 
                    WHERE Id = '" . $sessiondata['admin_id'] . "' ")) { ?>
                    <script>
                        Swal.fire({
                            title: 'Success',
                            text: ' User Name Updated Successfully !',
                            icon: 'success',
                            confirmButtonColor: '#5b8ce8',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    </script>
                    <?php
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "No Data Found !!";
            ?>
            <script>
                setTimeout(function () {
                    location.reload();
                }, 500);
            </script>
            <?php
        }
    }

    public function ChooseLogInType()
    {
        $this->load->library("session");
        if ($this->session->flashdata('name') && $this->session->flashdata('second_type')) {
            print_r($this->session->flashdata());
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = " Qlick Health | Enter Result ";
            $data['hasntnav'] = true;
            $data['Secondtype'] = $this->session->flashdata('second_type');
            $data['name'] = $this->session->flashdata('name');
            $this->load->view("AR/inc/header", $data);
            $this->load->view("AR/Global/ChoiseLogType");
        } else {
            redirect('AR/users');
        }
    }

    public function ChekLogInType()
    {
        if ($this->input->post('Type') && $this->input->post('Name')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('Type', 'Type', 'trim|required');
            $this->form_validation->set_rules('Name', 'Name', 'trim|required');
            if ($this->form_validation->run()) {
                $this->load->library("session");
                $type = $this->input->post('Type');
                $name = $this->input->post('Name');
                if ($type == "Staff" || $type == "Teacher" || $type = 'Parent') {
                    if ($type == "Staff") {
                        $stafflog = $this->db->query("SELECT * FROM l2_staff WHERE username = '" . $name . "' LIMIT 1")->result_array();
                        if (!empty($stafflog)) {
                            foreach ($stafflog as $data) {
                                $UserId = $data['Id'];
                                $SchoolId = $data['Added_By'];
                                $Perm = $data['PermSchool'];
                            }
                            if ($Perm !== 1) {
                                $sess_array = array(
                                    'admin_id' => $UserId,
                                    'username' => $name,
                                    'language' => 'ar',
                                    'type' => 'Satff',
                                    'level' => 3,
                                );
                                $this->session->set_userdata('admin_details', $sess_array);
                                $url = base_url() . "AR/results";
                                echo "<script> location.href = '$url' </script>";
                                echo "...تم تسجيل الدخول لحظات من فضلك";
                            } else {
                                redirect('AR/users');
                            }
                            $stafflog = $this->db->query(" SELECT * FROM  ")->result_array();
                        }
                    } elseif ($type == "Teacher") {
                        $departmentData = $this->db->query("SELECT * FROM l2_teacher WHERE username = '" . $name . "' LIMIT 1")->result_array();
                        if (!empty($departmentData)) {

                            foreach ($departmentData as $data) {
                                $UserId = $data['Id'];
                                $SchoolId = $data['Added_By'];
                                $perm = $data['PermSchool'];
                            }
                            if ($perm !== '1') {
                                $sess_array = array(
                                    'admin_id' => $UserId,
                                    'username' => $name,
                                    'language' => 'ar',
                                    'type' => 'Teacher',
                                    'level' => 3,
                                );
                                $this->session->set_userdata('admin_details', $sess_array);
                                $url = base_url() . "AR/results";
                                echo "<script> location.href = '$url' </script>";
                                echo "...تم تسجيل الدخول لحظات من فضلك";
                            }
                        }
                    } elseif ($type == "Parent") {
                        $sess_array = array(
                            'username' => $name,
                            'language' => 'ar',
                            'type' => 'Parent',
                            'level' => 2,
                        );
                        $this->session->set_userdata('admin_details', $sess_array);
                        $url = base_url() . "AR/Results/Select_Child";
                        echo "<script> location.href = '$url' </script>";
                        echo "...تم تسجيل الدخول لحظات من فضلك";
                    } else {
                        redirect('AR/users');
                    }
                } else {
                    redirect('AR/users');
                }
            }
        }
    }

    public function DepUserupdate()
    {
        $this->load->library('form_validation');
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');

            $this->form_validation->set_rules('Dept_Name_AR', 'Department Name AR', 'trim|required');
            $this->form_validation->set_rules('Dept_Name_EN', 'Department Name EN', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager EN', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager AR', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|valid_email');

            if ($this->form_validation->run()) {
                //set The Vars
                $Dept_Name_AR = $this->input->post("Dept_Name_AR");
                $Dept_Name_EN = $this->input->post("Dept_Name_EN");
                $Manager_EN = $this->input->post("Manager_EN");
                $Manager_AR = $this->input->post("Manager_AR");
                $Phone = $this->input->post("Phone");
                $Email = $this->input->post("Email");

                if (empty($_GET)) {
                    $table_name = "l1_department";
                } else {
                    $table_name = "l1_co_department";
                }

                if ($this->db->query("UPDATE `" . $table_name . "` SET 
                    Dept_Name_AR = '" . $Dept_Name_AR . "' , Dept_Name_EN = '" . $Dept_Name_EN . "' ,
                    Manager_EN = '" . $Manager_EN . "', Manager_AR = '" . $Manager_AR . "', Phone = '" . $Phone . "' , Email = '" . $Email . "' 
                    WHERE Id = '" . $sessiondata['admin_id'] . "' ")) {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'تعديل',
                            text: 'تم تحديث المعلومات بنجاح  ',
                            icon: 'success',
                            confirmButtonColor: '#5b8ce8',
                        });
                        setTimeout(function () {
                            //location.reload();
                        }, 500);
                    </script>
                    <?php
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo " لا توجد معلومات ";
            ?>
            <script>
                setTimeout(function () {
                    location.reload();
                }, 500);
            </script>
            <?php
        }
    }

    public function ResetMyPassword()
    {
        $this->load->library("session");
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = " Qlick Health | Enter Result ";
            $data['hasntnav'] = true;
            $this->load->view("AR/inc/header", $data);
            $this->load->view("AR/Global/ResetPassword");
            $this->load->view("AR/inc/footer");
        } else {
            redirect("AR/users");
        }
    }

    public function UpdatePassword()
    {
        $this->load->library("session");
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        if (
            $this->input->post('old_password') && $this->input->post('passw_1') == false &&
            $this->input->post('passw_2') == false
        ) {
            $password = $this->input->post('old_password');
            $old_hash_password = password_hash($password, PASSWORD_DEFAULT);
            $passworddata = $this->db->query("SELECT * FROM 
            `v_login` WHERE  `Username` = '" . $sessiondata['username'] . "' ")->result_array();
            if (!empty($passworddata)) {
                foreach ($passworddata as $passwordarr) {
                    $db_pass = $passwordarr['Password'];
                }
                if (password_verify($password, $db_pass)) { ?>
                    <script>
                        $('input[name="old_password"]').slideUp();
                        $('input[name="old_password"]').attr('readonly', '');
                        var all = '<label>أدخل كلمة المرور الجديدة :</label><input name="passw_1" placeholder="أدخل كلمة المرور الجديدة" class="form-control">';
                        all += '<label>:أدخل كلمة المرور مجددا</label><input name="passw_2" placeholder="أعد إدخال كلمة المرور الجديدة" class="form-control">';
                        $('.form-group').append(all);
                    </script>
                    <?php
                }
            } else {
                echo "The Password Is Not Corrrect ";
            }
        } elseif ($this->input->post('passw_1') && $this->input->post('passw_2') && $this->input->post('old_password')) {
            $this->form_validation->set_rules('passw_1', 'New Password', 'trim|required|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('passw_2', 'New Password Retype', 'trim|required|min_length[8]|max_length[20]|matches[passw_1]');
            if ($this->form_validation->run()) {
                $pass1 = $this->input->post('passw_1');
                $newpass = password_hash($pass1, PASSWORD_DEFAULT);
                if ($this->db->query("UPDATE `v_login` SET `Password` = '" . $newpass . "' 
                WHERE Username = '" . $sessiondata['username'] . "' LIMIT 1 ")) { ?>
                    <script>
                        Swal.fire({
                            title: 'نجاح',
                            text: ' لقد تم تغيير كلمة المرور بنجاح ',
                            icon: 'success',
                            confirmButtonColor: '#5b8ce8',
                        });
                        setTimeout(function () {
                            location.href = "<?php echo base_url() ?>AR/users";
                        }, 500);
                    </script>
                <?php } else { ?>
                    <script>
                        Swal.fire({
                            title: 'خطأ',
                            text: ' نعتذر لدينا خطأ ',
                            icon: 'error',
                            confirmButtonColor: '#5b8ce8',
                        });
                        setTimeout(function () {
                            location.href = "<?php echo base_url() ?>AR/users";
                        }, 500);
                    </script>
                    <?php
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "كلمة المرور المدخلة خطأ";
        }
    }

    public function logout()
    {
        $this->load->library('session');
        session_destroy();
        redirect('AR/users');
    }

    public function disable()
    {
        $this->load->view('AR/disabled');
    }
}
