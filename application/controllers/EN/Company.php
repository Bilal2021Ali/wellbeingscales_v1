<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Company extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || $sessiondata['level'] !== 1 || $sessiondata['type'] !== "Company") {
            redirect('EN/Users');
            exit();
        }
    }

    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('encrypt_url');
        $this->load->model('company/sv_company_reports');
        if (!empty($sessiondata)) {
            $data['our_schoolsList'] = implode(',', array_column($this->db->query("SELECT `Id` FROM `l1_co_department` WHERE
            `Added_By` = " . $sessiondata['admin_id'] . " ORDER BY `Id` DESC ")->result_array(), 'Id'));
            $data['page_title'] = "Qlick Health | Dashboard ";
            $data['sessiondata'] = $sessiondata;
            $data['climate_survyes'] = $this->sv_company_reports->GetClimatesurveys();
            //type
            $NORMAL = $this->GetTotal(36.3, 37.5);
            $data['NORMAL'] = $NORMAL;
            // 36.8 --- 36.9 --- 38 --- 38.1 -- 40 --- 40.1 -- 45 -- 1000 
            $MODERATE = $this->GetTotal(37.6, 38.4);
            $data['MODERATE'] = $MODERATE;
            $HIGH = $this->GetTotal(38.5, 45);
            $data['HIGH'] = $HIGH;
            $LOW = $this->GetTotal(0, 36.2);
            $data['LOW'] = $LOW;
            $Emp_Tests = $this->GetTotal(45.1, 1000);
            $data['Emp_Tests'] = $Emp_Tests;
            $data['Total_tests'] = $this->labtests_counter($sessiondata['admin_id']);
            $our_schools = $this->db->query("SELECT 
            `School_Name_EN`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'
            ORDER BY `Id` DESC ")->result_array();
            $arr = array();
            if (!empty($this->lastdateofentry_in_labtest($our_schools, 'Teacher'))) {
                $arr[] = $this->lastdateofentry_in_labtest($our_schools, 'Teacher');
            }

            if (!empty($this->lastdateofentry_in_labtest($our_schools, 'Student'))) {
                $arr[] = $this->lastdateofentry_in_labtest($our_schools, 'Student');
            }

            if (!empty($this->lastdateofentry_in_labtest($our_schools, 'Staff'))) {
                $arr[] = $this->lastdateofentry_in_labtest($our_schools, 'Staff');
            }

            if (!empty($this->lastdateofentry_in_labtest($our_schools, 'Site'))) {
                $arr[] = $this->lastdateofentry_in_labtest($our_schools, 'Site');
            }
            $data['filters'] = [
                'dept' => "",
                'title' => "",
            ];
            if ($this->input->method() == "post") {
                $data['filters']['dept'] = ($this->input->post('dept') && is_numeric($this->input->post('dept'))) ? $this->input->post('dept') : "";
                $data['filters']['title'] = $this->input->post('search');
            }
            $data['departments'] = $this->db->where('Added_By', $sessiondata['admin_id'])->get('l1_co_department')->result_array();
            $data['climate_survyes'] = $this->sv_company_reports->GetClimatesurveys($data['filters']);
            $data['test'] = $arr;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/dash');
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    private function GetTotal($from = "", $To = "")
    {
        $sessiondata = $this->session->userdata('admin_details');
        $counter = $this->db->from('l2_co_patient')
            ->join('l1_co_department', 'l1_co_department.Added_By = ' . $sessiondata['admin_id'] . '')
            ->join('l2_co_monthly_result', 'l2_co_patient.UserType = l2_co_monthly_result.UserType 
        AND l2_co_patient.Id = l2_co_monthly_result.UserId')
            ->where('l2_co_patient.Added_By', 'l1_co_department.Id', false)
            ->where('l2_co_monthly_result.Created', date("Y-m-d"))
            ->where('l2_co_monthly_result.Result >= ', $from)
            ->where('l2_co_monthly_result.Result <= ', $To)
            ->get();
        return $counter->num_rows();
    }

    private function labtests_counter($id)
    {
        $our_schools = $this->db->query("SELECT 
     `School_Name_EN`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $id . "' ORDER BY `Id` DESC ")->result_array();
        //print_r($our_schools); 
        $counter = 0;
        foreach ($our_schools as $school) {
            $counter +=  $this->Get_CounterForThisType_Ministry($school['Id'], "Student");
            $counter +=  $this->Get_CounterForThisType_Ministry($school['Id'], "Teacher");
            $counter +=  $this->Get_CounterForThisType_Ministry($school['Id'], "Staff");
            $counter +=  $this->Get_CounterForThisType_Ministry($school['Id'], "Site");
        }
        return ($counter);
    }

    private function Get_CounterForThisType_Ministry($id, $type)
    {
        $counter = 0;
        $today = date("Y-m-d");
        if ($type == "Student") {
            $query_users = $this->db->query(" SELECT * FROM `l2_student` WHERE `Added_By` = '" . $id . "'  ")->result_array();
        } else if ($type == "Teacher") {
            $query_users = $this->db->query(" SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $id . "'  ")->result_array();
        } elseif ($type == "Staff") {
            $query_users = $this->db->query(" SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $id . "'  ")->result_array();
        } elseif ($type == "Site") {
            $query_users = $this->db->query(" SELECT * FROM `l2_site` WHERE `Added_By` = '" . $id . "'  ")->result_array();
        }
        foreach ($query_users as $user) {
            $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
            `UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' ")->num_rows();
            $counter += $Results;
        }

        return ($counter);
    }

    private function lastdateofentry_in_labtest($schools, $type)
    {
        $date = array();
        foreach ($schools as $school) {
            $id = $school['Id'];
            $today = date("Y-m-d");
            if ($type == "Student") {
                $query_users = $this->db->query(" SELECT * FROM `l2_student` WHERE `Added_By` = '" . $id . "'  ")->result_array();
            } else if ($type == "Teacher") {
                $query_users = $this->db->query(" SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $id . "'  ")->result_array();
            } elseif ($type == "Staff") {
                $query_users = $this->db->query(" SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $id . "'  ")->result_array();
            } elseif ($type == "Site") {
                $query_users = $this->db->query(" SELECT * FROM `l2_site` WHERE `Added_By` = '" . $id . "'  ")->result_array();
            }

            if (!empty($query_users)) {
                foreach ($query_users as $user) {
                    $Results = $this->db->query("SELECT `Created`,`Time` FROM `l2_labtests` WHERE 
            `UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' ORDER BY `Id` DESC ")->result_array();
                    if (!empty($Results)) {
                        $thedate =  $Results[0]['Created'] . ' ' . $Results[0]['Time'];
                        $date[] = $thedate;
                    }
                }
            }
        }

        return ($date);
    }


    public function addDepartment()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Registration School ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/addDepartment');
        $this->load->view('EN/inc/footer');
    }

    public function Monitors_routes_company()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata; {


            $links[] = array(
                'name' => " DAILY REPORT ", "link" => base_url('EN/Company/All_Tests_Today'),
                "desc" => "", "icon" => "DTemperature.png"
            );

            $links[] = array(
                'name' => " ATTENDANCE REPORT ", "link" => base_url('EN/Company/Attendance_Report'),
                "desc" => "", "icon" => "AttendancebyDatser.png"
            );

            $links[] = array(
                'name' => " REFRIGERATORS REPORT ", "link" => base_url('EN/Company/Refrigerator_access'),
                "desc" => "", "icon" => "Refrigerator_Trip.png"
            );

            $links[] = array(
                'name' => " LAB REPORT ", "link" => base_url('EN/Company/Lab_Reports'),
                "desc" => "", "icon" => "LabReport.png"
            );

            $links[] = array(
                'name' => " REFRIGERATORS TRIP REPORT ", "link" => base_url('EN/Company/refrigerators'),
                "desc" => "", "icon" => "Refrigerator_Trip.png"
            );
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | List all ";
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Global/Links/Lists', $data);
            $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
        }
    }


    public  function DepartmentsList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Departments List ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $listofadmins['listofadmins'] = $this->db->query("SELECT *, l1_co_department.Id as Dept_Id
        FROM l1_co_department 
        LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l1_co_department`.`Id` 
        AND `l2_avatars`.`Type_Of_User` = 'department_Company'
        WHERE `l1_co_department`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        ORDER  BY `l1_co_department`.`Id` DESC")->result_array();
        // $this->response->dd($listofadmins['listofadmins']);
        $this->load->view('EN/Company/Department_List', $listofadmins);
        $this->load->view('EN/inc/footer');
    }

    public function Refrigerator_access()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Departments List ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $datas = $this->db->query(" 
        SELECT `refrigerator_result_daily`.`TimeStamp` AS Result_date ,
        `refrigerator_result_daily`.`Result` AS Temp ,
        `refrigerator_result_daily`.`Humidity` AS Humidity ,
        `refrigerator_area`.`mac_adress` as device_mac , 
        `refrigerator_area`.`Description` as device_Description, 
        `refrigerator_levels`.`device_name` as device_name, 
        `refrigerator_levels`.`min_temp` AS min , `refrigerator_levels`.`max_temp` AS max ,
        `l1_co_department`.`Dept_Name_EN` AS Dept_name,
        CONCAT(`refrigerator_levels`.`min_temp`,' / ' , `refrigerator_levels`.`max_temp`) as device_type
        FROM refrigerator_result_daily
        JOIN `refrigerator_area` ON `refrigerator_result_daily`.`Machine_Id` = `refrigerator_area`.`Id`
        JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type`
        JOIN `v0_area_device_permission` ON `v0_area_device_permission`.`area_id` = `refrigerator_area`.`Id`
        JOIN `l1_co_department` ON `l1_co_department`.`Id` = `refrigerator_area`.`source_id`
        WHERE `refrigerator_area`.`user_type` = 'company_department' ")->result_array();
        $list['datas'] = $datas;
        $this->load->view('EN/Company/Refrigeraters', $list);
        $this->load->view('EN/inc/footer');
    }

    private function generatecode($sessiondata, $n_id)
    {
        $parent = $this->db->query("SELECT Added_By,Country FROM `l0_organization` 
		WHERE Id = '" . $sessiondata . "' ORDER BY `Id` DESC")->result_array();
        $parentId =  str_pad($parent[0]['Added_By'], 4, '0', STR_PAD_LEFT);
        $s_id = str_pad($sessiondata, 4, '0', STR_PAD_LEFT);
        $country =  $parent[0]['Country'];
        $g_country = str_pad($country, 4, '0', STR_PAD_LEFT);
        $genrationcode = $g_country . $parentId . $s_id . $n_id;
        return ($genrationcode);
    }

    public function startAddingDep()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;


        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Username')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim');
            $this->form_validation->set_rules('Manager_AR', 'Manager AR', 'trim');
            $this->form_validation->set_rules('Manager_EN', 'Manager EN', 'trim');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('Username', 'User name', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('position', ' position', 'trim|required|min_length[1]|max_length[30]');
            $this->form_validation->set_rules('countries', 'countries', 'trim|required|max_length[5]');
            $this->form_validation->set_rules('DepartmentId', 'Department Id', 'trim|required|min_length[3]|max_length[30]');
            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $username = $this->input->post('Username');
                $position = $this->input->post('position');
                // Selects     
                $city = $this->input->post('city');
                $Type = $this->input->post('Type');
                $countries_branch = $this->input->post('countries');
                $isselected = 0;
                $password =  "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $My_Id = $sessiondata['admin_id'];
                $region =  str_pad($countries_branch, 4, '0', STR_PAD_LEFT);
                $parentId =  str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
                $rand = rand(1000, 9999);
                $genrationcode = $region . $parentId . $rand;

                if (is_numeric($city)) {
                    $isselected++;
                } else {
                    echo 'Please select the city';
                }



                if ($isselected == 1) {
                    $iscorrent = $this->db->query("SELECT * FROM `v_login` WHERE Username = '" . $username . "' ")->result_array();

                    if (empty($iscorrent)) {
                        $data = [
                            'Username'     => $username,
                            'password'     => $hash_pass,
                            'Dept_Name_AR' => $Arabic_Title,
                            'Dept_Name_EN' => $English_Title,
                            'Created'      => date('Y-m-d'),
                            'Manager_EN'   => $Manager_EN,
                            'Manager_AR'   => $Manager_AR,
                            'Phone'        => $Phone,
                            'Email'        => $Email,
                            'Citys'        => $city,
                            'Type_Of_Dept' => $Type,
                            'Position'     => $position,
                            'Dept_Type'    => 'Department',
                            'Country'      => $countries_branch,
                            'Added_By'     => $My_Id,
                            'generation'   => $genrationcode,
                            'DepartmentId' => $this->input->post('DepartmentId'),
                            'company_type' => '3',
                        ];
                        if ($this->db->insert('l1_co_department', $data)) {
                        //    $this->sendNewUserEmail($Email, $password, $username);
                            $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`, `Company_Type` ,`Created`,`generation`)
                            VALUES ('" . $username . "','" . $hash_pass . "','department', '3' ,'" . date('Y-m-d') . "','" . $genrationcode . "')"); ?>
                            <script>
                                Swal.fire({
                                    title: 'Added ',
                                    text: 'The data was successfully added. The information was successfully sent ',
                                    icon: 'success',
                                    confirmButtonColor: '#5b8ce8',
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            </script>
                        <?php
                        } else {
                            echo "We apologize, we currently have a problem processing the request";
                        }
                    } else {
                        echo 'This username is already in use';
                    }
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "Please enter the information";
        }
    }

    public function startAddingBr()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Username')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name ', 'trim');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('position', 'Manager Position', 'trim|required|numeric');
            $this->form_validation->set_rules('countries_branch', 'countries branch', 'trim|max_length[5]');

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $username = $this->input->post('Username');
                $position = $this->input->post('position');
                // Selects     
                $city = $this->input->post('city');
                $Type = $this->input->post('Type');
                $countries_branch = $this->input->post('countries_branch');
                $isselected = 0;
                $password =  "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $My_Id = $sessiondata['admin_id'];

                if (is_numeric($city)) {
                    $isselected++;
                } else {
                    echo 'Please Select The city';
                }
                if ($isselected == 1) {
                    $iscorrent = $this->db->query("SELECT * FROM `v_login` WHERE Username = '" . $username . "' ")->result_array();
                    $data = [
                        "Username" => $username,
                        "password" => $hash_pass,
                        "Dept_Name_AR" =>  $Arabic_Title,
                        "Dept_Name_EN" => $English_Title,
                        "Created" => date('Y-m-d'),
                        "Manager_EN" => $Manager_EN,
                        "Manager_AR" => $Manager_AR,
                        "Phone" => $Phone,
                        "Email" => $Email,
                        "Citys" => $city,
                        "Type_Of_Dept" => $Type,
                        "Position" => $position,
                        "Dept_Type" => 'Bransh',
                        "Country" =>  $countries_branch,
                        "Added_By" => $My_Id,
                        "company_type" => '7',
                    ];
                    if (empty($iscorrent)) {
                        if ($this->db->insert('l1_co_department', $data)) {
                        //    $this->sendNewUserEmail($Email, $password, $username);
                            $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type` ,`company_type` ,`Created`) VALUES ('" . $username . "','" . $hash_pass . "','department' , '7' ,'" . date('Y-m-d') . "')");
                        ?>
                            <script>
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'The data were inserted successfully. The email will be sent to <?= $Email ?> ',
                                    icon: 'success',
                                    confirmButtonColor: '#5b8ce8',
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            </script>
                        <?php
                        } else {
                            echo "Sorry, the system has a problem right now.";
                        }
                    } else {
                        echo 'The User Name ' . '"' . $username . '"' . ' is already exist';
                    }
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "Please provide the data needed.";
        }
    }

    private function sendNewUserEmail($email, $pass, $username)
    {
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.track.qlickhealth.com',
            'smtp_port' => 465,
            'smtp_user' => 'no_reply@track.qlickhealth.com',
            'smtp_pass' => 'Bd}{kKW]eTfH',
            'smtp_crypto' => 'ssl',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $messg = '<center>
          <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $username . ' </h3>
          <h3>Your password is : ' . $pass . ' </h3>
          <a href=""' . base_url() . '"EN/Users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';

        $this->email->initialize($config);
        $this->email->set_newline('\r\n');
        $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
        $this->email->bcc('emails@qlicksystems.com');
        $this->email->to($email);
        $this->email->subject(' Department - Your User Name And Password ');
        $this->email->message($messg);
        if (!$this->email->send()) {
            //echo $this->email->print_debugger();     
            echo 'We have an error in sending the email . Please try again later. ';
        } else {
            echo "The Email is Sended !";
        }
        return ('traryradet');
    }

    public function UpdateDepartmentData()
    {
        $id = $this->uri->segment(4);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update department ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $adminInfos['DepartmentData'] = $this->db->query("SELECT * FROM l1_co_department 
            WHERE Id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->load->view('EN/Company/Upadate_Department', $adminInfos);
            $this->load->view('EN/inc/footer');
        } else {
            redirect("EN/Company");
        }
    }

    public function startUpdatingDepart()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;

        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('countries', 'countries', 'trim|required|numeric');
            $this->form_validation->set_rules('city', 'city', 'trim|required|numeric');
            $this->form_validation->set_rules('Type', ' Type', 'trim|required');
            $this->form_validation->set_rules('position', ' Position', 'trim|required');
            $id = $this->input->post('ID');

            if ($this->form_validation->run()) {
                if (is_numeric($id)) {
                    $Arabic_Title = $this->input->post('Arabic_Title');
                    $English_Title = $this->input->post('English_Title');
                    $Manager_AR = $this->input->post('Manager_AR');
                    $Manager_EN = $this->input->post('Manager_EN');
                    $Phone = $this->input->post('Phone');
                    $Email = $this->input->post('Email');
                    $countries = $this->input->post('countries');
                    $city = $this->input->post('city');
                    $Type_Of_Dept = $this->input->post('Type');
                    $position = $this->input->post('position');

                    $data = [
                        'Dept_Name_AR' =>  $Arabic_Title,
                        'Dept_Name_EN' =>  $English_Title,
                        'Citys' =>  $city,
                        'Country' =>  $countries,
                        'Manager_EN' =>  $Manager_EN,
                        'Manager_AR' =>  $Manager_AR,
                        'Email' =>  $Email,
                        'Phone' =>  $Phone,
                        'Type_Of_Dept' =>  $Type_Of_Dept,
                        'Position' =>  $position,
                    ];
                    if ($this->db->where('Id', $id)->set($data)->update('l1_co_department')) {
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'The data is updated successfully.',
                                icon: 'success',
                                confirmButtonColor: '#5b8ce8',
                            });
                            setTimeout(function() {
                                location.href = "<?= base_url(); ?>EN/Company/DepartmentsList";
                            }, 1500);
                        </script>
                    <?php
                        echo "<h3>The system is updated successfully. </h3>";
                    }
                } else {
                    echo "<script>location.reload();</script>";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    // enable and desable the dep 
    public function changeDepartmentstatus()
    {
        $id = $this->input->post('adminid');
        $this->db->query("UPDATE l1_co_department SET `status` = IF(`status`=1, 0, 1) WHERE Id = '" . $id . "' ");
    }

    // company profile
    public function Profile()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 1 && $sessiondata['type'] == "Company") {
            $data['page_title'] = "Qlick System | Profile ";
            $data['sessiondata'] = $sessiondata;
            $data['data'] = $this->db->where('Id', $sessiondata['admin_id'])->get('l0_organization')->result_array()[0] ?? redirect('EN/Company');
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Profiles/Company_Profile');
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    // start updating the company data
    public function UpdateMinstry_profile()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 1 && $sessiondata['type'] == "Company") {
            $this->load->library('form_validation');
            if ($this->input->post('Send')) {
                $this->form_validation->set_rules('AR_Title', 'name in arabic', 'trim|required');
                $this->form_validation->set_rules('EN_Title', 'name in rnglish', 'trim|required');
                $this->form_validation->set_rules('Phone', 'phone', 'trim|required|numeric');
                $this->form_validation->set_rules('Manager', 'Manager', 'trim|required|min_length[2]|max_length[20]');
                if ($this->form_validation->run()) {
                    $AR_Title = $this->input->post('AR_Title');
                    $EN_Title = $this->input->post('EN_Title');
                    $Phone = $this->input->post('Phone');
                    $Username = $this->input->post('Username');
                    $Manager = $this->input->post('Manager');
                    if ($this->db->query("UPDATE `l0_organization` 
                SET `AR_Title` = '" . $AR_Title . "', `EN_Title` = '" . $EN_Title . "', `Tel` = '" . $Phone . "',
               `Manager` = '" . $Manager . "', `verify` = 1
                WHERE `Id` = '" . $sessiondata['admin_id'] . "' ")) {
                        echo "The data is updated.";
                    ?>
                        <script>
                            Swal.fire({
                                title: ' updated ',
                                text: 'Updated successfully',
                                icon: 'success',
                                confirmButtonColor: '#5b8ce8',
                            });
                            setTimeout(function() {
                                location.href = "<?= base_url(); ?>EN/Company";
                            }, 800)
                        </script>
                    <?php
                    } else {
                        echo "Sorry we have a problem";
                    }
                } else {
                    echo validation_errors();
                }
            } else {
                echo "NO INFORMATION!";
            }
        }
    }

    public function Add_UserType()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Add an Usertype ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/addUsertype');
        $this->load->view('EN/inc/footer');
    }


    public function All_Tests_Today()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/All_Tests_Today');
        $this->load->view('EN/inc/footer');
    }

    public function Attendance_Report()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Attendance Report ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/Attendance_Report');
        $this->load->view('EN/inc/footer');
    }

    public function Lab_Reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Report ";
        $data['sessiondata'] = $sessiondata;
        $data['tests'] = $this->db->get('r_testcode')->result_array();
        $data['userData'] = $this->db->get_where("l0_organization", ["Id" => $sessiondata['admin_id']])->result_array()[0] ?? array();
        if (empty($data['userData'])) {
            session_destroy();
            redirect("AR/users/");
        }
        if ($this->input->method() == "post") {
            $data['start'] = $this->input->post("start");
            $data['end'] = $this->input->post("end");
            $data['selected_tests'] = $this->input->post("tests") ?? array_column($data['tests'], "Test_Desc");
        } else {
            $data['start'] = date('Y-m-d');
            $data['end'] = date('Y-m-d');
            $data['selected_tests'] = array_column($data['tests'], "Test_Desc");
        }
        $Acceptedtests = array();
        foreach ($data['selected_tests'] as $test) {
            $Acceptedtests[] = '"' . $test . '"';
        }

        // setup all accepted departments
        $ids = array();
        $ids[] = $sessiondata['admin_id'];
        $our_depts = $this->db->query("SELECT Id , Dept_Name_EN FROM `l1_co_department` WHERE Added_by = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($our_depts as $dept) {
            $ids[] = $dept['Id'];
        }

        $data['userData'] = $this->db->get_where("l0_organization", ["Id" => $sessiondata['admin_id']])->result_array()[0] ?? array();
        if (empty($data['userData'])) {
            session_destroy();
            redirect("EN/Users/");
        }

        $permission_depts = $this->db->query("SELECT DISTINCT(v0_departments_results_permissions.by_dept)
        FROM `l1_co_department` 
        JOIN v0_departments_results_permissions ON `v0_departments_results_permissions`.`to_dept` IN (" . implode(',', $ids) . ")
        AND v0_departments_results_permissions.list = 1  ")->result_array();
        foreach ($permission_depts as $perdepts) {
            $ids[] = $perdepts['by_dept'];
        }
        // query
        $data['Results'] = $this->db->query(" SELECT 
        l1_co_department.Dept_Name_EN AS H_name ,
        concat(l2_co_patient.F_name_EN , ' ',l2_co_patient.M_name_EN , ' ' , l2_co_patient.L_name_EN) AS P_name ,
        '--' AS HIC_num ,
        l2_co_patient.National_Id AS QID ,
        l2_co_patient.DOP , l2_co_patient.Nationality ,
        l2_co_labtests.TimeStamp AS Test_Date ,
        l2_co_labtests.Test_Description AS Test_Type ,
        IF(l2_co_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
        IF(l2_co_patient.Gender = 1 , 'Male' , 'Female') AS Gender
        FROM l2_co_labtests 
        JOIN l2_co_patient ON l2_co_patient.Id = l2_co_labtests.UserId AND l2_co_patient.UserType = l2_co_labtests.UserType 
        JOIN l1_co_department ON l2_co_patient.Added_By = l1_co_department.Id
        WHERE l1_co_department.Id IN (" . implode(',', $ids) . ")
        AND l2_co_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
        AND l2_co_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();

        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/Lab_Reports');
        $this->load->view('EN/inc/footer');
    }


    public function refrigerators()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Report ";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "post") {
            $data['from'] = $this->input->post("start");
            $data['to'] = $this->input->post("end");
            $data['tripName'] = $this->input->post("trip_name");
            $data['selected'] = $this->input->post("machine");
            $data['department'] = $this->input->post("department");
        } else {
            $data['tripName'] = "";
            $data['selected'] = "";
            $data['department'] = "";
        }
        $conditions = array();
        // conditions
        if ($data['selected'] !== "") {
            $conditions['Machine_Id'] = $data['selected'];
            $trips = $this->db->query("SELECT DISTINCT trip_name 
            FROM `refrigerator_result_log_Daily` 
            WHERE Machine_Id = '" . $conditions['Machine_Id'] . "'
            ORDER BY `Machine_Id` ASC")->result_array();
        } else {
            $trips = array();
        }
        if ($data['tripName'] !== "") {
            $conditions['trip_name'] = $data['tripName'];
        }

        $data['time_chart'] = array();
        $data['results_chart'] = array();
        $data['Humidity_chart'] = array();
        $ids = array();
        $our_depts = $this->db->query("SELECT Id , Dept_Name_EN FROM `l1_co_department` 
        WHERE Added_by = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($our_depts as $dept) {
            $ids[] = $dept['Id'];
        }
        $data['depts'] = $our_depts;
        if ($data['department'] == "") {
            $condition = "AND ra.`source_id` IN (" . implode(',', $ids) . ")";
        } else {
            $condition = "AND ra.`source_id` = '" . $data['department'] . "' ";
        }
        // results array 
        // $data['results'] = $this->db->get_where("refrigerator_result_log_Daily" , $conditions)->result_array();

        $data['results'] = $this->db->query("SELECT o.`EN_Title`,cd.`Dept_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId 
        ,rrld.`mUtcTime`, rrld.`trip_name` , rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
        FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_co_department` AS cd,`l0_organization` AS o
        WHERE ra.`Id` = rrld.`Machine_Id`
        AND ra.`user_type` = rrld.`user_type`
        AND ra.`source_id` =cd.`Id`
        AND cd.`Added_By` =o.`Id`
        " . ($data['selected'] !== "" ? "AND rrld.`Machine_Id` = " . $data['selected'] : '') . "
        " . ($data['tripName'] !== "" ? 'AND rrld.`trip_name` = ' . "'" . $data['tripName'] . "'" : '') . "
        AND rrld.`user_type`= 'company_department'
        $condition ;")->result_array();

        if ($data['selected'] !== "") {
            $selects = $this->db->query("SELECT o.`EN_Title`,cd.`Dept_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId ,rrld.`mUtcTime`,rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
            FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_co_department` AS cd,`l0_organization` AS o
            WHERE ra.`Id` = rrld.`Machine_Id`
            AND ra.`user_type` = rrld.`user_type`
            AND ra.`source_id` = cd.`Id`
            AND cd.`Added_By` = o.`Id`
            AND rrld.`user_type`= 'company_department'
            AND ra.`source_id` IN (" . implode(',', $ids) . ")  GROUP BY ra.Id; ; ")->result_array();
            $data['trips'] = array();
            $data['machines'] = $selects;
        }
        // trips list
        // machens choise
        $data['machiens'] = array();
        $data['trips'] = $trips;
        foreach ($data['results'] as $key => $result) {
            if ($result['Created'] == date('Y-m-d')) {
                $data['time_chart'][] = "'" . $result['Time'] . "'";
                $data['results_chart'][] = $result['Result'];
                $data['Humidity_chart'][] = $result['Humidity'];
            }
        }

        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/refrigeratorsReports');
        $this->load->view('EN/inc/footer');
    }


    public function machenesForDepartment()
    {
        if ($this->input->method() == "post") {
            $id = $this->input->post("dept_id");
            $oldIds = array();
            $machiens = array();
            $results = $this->db->get("refrigerator_result_log_Daily")->result_array();
            foreach ($results as $key => $result) {
                if (!in_array($result['Machine_Id'], $oldIds)) {
                    if ($result['user_type'] == 'Visitor') {
                        $name = $this->db->query("SELECT Description AS dev_name , l1_co_department.Dept_Name_EN
                        FROM refrigerator_visitor 
                        JOIN `l1_co_department` ON `l1_co_department`.`Id` = `refrigerator_visitor`.`source_id`
                        WHERE refrigerator_visitor.Id = '" . $result["Machine_Id"] . "' AND  `l1_co_department`.`Id` = '" . $id . "' LIMIT 1 ")->result_array();
                        if (!empty($name)) {
                            $oldIds[] = $result['Machine_Id'];
                            $machiens[] = array("id" => $result['Machine_Id'], "name" => $name[0]['dev_name']);
                        }
                    } else {
                        $name = $this->db->query("SELECT Description AS dev_name ,  l1_co_department.Dept_Name_EN
                        FROM refrigerator_area 
                        JOIN `l1_co_department` ON `l1_co_department`.`Id` = `refrigerator_area`.`source_id`
                        WHERE refrigerator_area.Id = '" . $result["Machine_Id"] . "' AND user_type = 'company_department'
                        AND `l1_co_department`.`Id` = '" . $id . "'  LIMIT 1 ")->result_array();
                        if (!empty($name)) {
                            $oldIds[] = $result['Machine_Id'];
                            $machiens[] = array("id" => $result['Machine_Id'], "name" => $name[0]['dev_name']);
                        }
                    }
                }
            }
            $this->response->json($machiens);
        }
    }


    public function tripNames_forthisMachine()
    {
        if ($this->input->method() == "post") {
            $id = $this->input->post('machine_id');
            $trips = $this->db->query("SELECT DISTINCT trip_name 
            FROM `refrigerator_result_log_Daily` 
            WHERE Machine_Id = '" . $id . "'
            ORDER BY `Machine_Id` ASC")->result_array();
            $this->response->json($trips);
        }
    }

    public function Message()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Messages ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Component/Message');
        $this->load->view('EN/inc/footer');
    }

    public function get_questions_of_avalaible_surveys()
    {
        if ($this->input->post("group_id") && $this->input->post('s_type')) {
            $group = $this->input->post("group_id");
            if ($this->input->post('s_type') == "fillable") {
                $q_name = "sv_st_fillable_questions";
            } else {
                $q_name = "sv_st_questions";
            }
            $quastins = $this->db->query("SELECT *,`" . $q_name . "`.`Id` AS q_id
                        FROM `" . $q_name . "`
                        INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `" . $q_name . "`.`question_id`
                        WHERE `survey_id` = '" . $group . "' ")->result_array();
            if (!empty($quastins)) {
                foreach ($quastins as $key => $question) { ?>
                    <div id="question_<?= $question['q_id']   ?>" class="animate__animated">
                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none" style="border: 0px;">
                                <a href="#quas_<?= $question['q_id'] ?>" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="quas_<?= $question['q_id'] ?>">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            <?= ($key + 1) . ". " . $question['en_title'];  ?>
                                            <i class="mdi mdi-chevron-up float-right accor-down-icon" style="margin-top: -5px;"></i>
                                        </h6>
                                    </div>
                                </a>

                                <div id="quas_<?= $question['q_id'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <h6><?= $question['code'];  ?> | <?= $question['TimeStamp'];  ?></h6>
                                        <p><?= $question['en_desc'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <img src="<?= base_url() ?>assets/images/404-error.png" alt="" class="w-100">
                <h3 class="text-center">No data found !!</h3>
<?php }
        }
    }

    public function Wellness()
    {
        $this->load->library('session');
        $this->load->model('company/sv_company_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Messages ";
        $data['sessiondata'] = $sessiondata;
        $prms_surv = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`surveys` = '1' ")->result_array();
        if (!empty($prms_surv)) {
            if (empty($this->sv_company_reports->our_departments())) {
                $data['hasntnav'] = true;
                $this->load->view('EN/inc/header', $data);
                return $this->load->view('EN/Company/Empty-systeme');
            }
            // sql
            $data['avalaible_surveys'] = $this->sv_company_reports->avalaible_surveys();
            // exit(); our_surveys
            $data['our_surveys'] = $this->sv_company_reports->our_published_surveys($sessiondata['admin_id']);
            $data['expired_surveys'] = $this->sv_company_reports->our_surveys($sessiondata['admin_id'], true);
            $data['our_published_surveys'] = $this->sv_company_reports->published_by_department($sessiondata['admin_id']);
            $data['completed_surveys'] = $this->sv_company_reports->completed_surveys();
            $data['used_categorys'] = $this->sv_company_reports->usedcategorys();
            $data['surveys_for_males'] = $this->sv_company_reports->surveys_by_gender('1');
            $data['surveys_for_females'] = $this->sv_company_reports->surveys_by_gender('2');
            $data['types'] = $this->sv_company_reports->counter_of_completed_surveys_by_types();
            $data['ages_with_groups'] = $this->sv_company_reports->ages_for_all_passed_users($sessiondata['admin_id'], true);
            $data['supported_types'] = $this->sv_company_reports->supported_types();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/Wellness');
            $this->load->view('EN/inc/footer');
        } else {
            $dataDes['to'] = "EN/Company";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function survey_reports()
    {
        $accepte = ["staff", "teachers", "students", "parents"];
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->db->Is_existInTable($this->uri->segment(4), 'sv_school_published_surveys') && !$this->uri->segment(5)) {
            $this->load->model('company/sv_company_reports');
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['types'] = $this->db->where('EXISTS(SELECT Id FROM `l2_co_patient` WHERE `l2_co_patient`.`UserType` = `r_usertype`.`Id`)')->get('r_usertype')->result_array();
            $data['users_passed_survey'] = $this->sv_company_reports->users_passed_survey($serv_id);
            foreach ($data['types'] as $key => $type) {
                $data['by_type'][$type['Id']] = [
                    'name' => $type['UserType'],
                    'results' => $this->sv_company_reports->users_passed_survey($serv_id, $type['Id'])
                ];
            }
            $data['used_choices'] = $this->sv_company_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_company_reports->get_surv_quastions($serv_id);
            $data['main_surv_id'] = $this->sv_company_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_company_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_company_reports->users_passed_survey($serv_id, null, 'M'));
            $data['females_count'] = $this->count_gender($this->sv_company_reports->users_passed_survey($serv_id, null, 'F'));
            $data['radial_chart_dataset']['data'] = implode(',', array_map(function ($k) {
                return sizeof($k['results']);
            }, $data['by_type']));
            $data['radial_chart_dataset']['percentage'] = implode(',', array_map(function ($k) use ($data) {
                return $this->calc_perc(sizeof($k['results']), sizeof($data['users_passed_survey']));
            }, $data['by_type']));
            $data['radial_chart_dataset']['labels'] = implode(',', array_map(function ($k) {
                return '"' . $k['name'] . '"';
            }, $data['by_type']));
            // choices
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "id" => $choice['Id'], "counter" => 0);
            }
            $data['choice_arr'] = $choice_arr;
            // $this->response->json($data);
            // exit();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/survey_report');
            $this->load->view('EN/inc/footer');
        }
    }


    function calc_perc($perc, $all)
    {
        $x = $perc;
        $y = $all;
        if ($x > 0 && $y > 0) {
            $percent = $x / $y;
            $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
        } else {
            $percent_friendly = 0; // change 2 to # of decimals
        }
        return $percent_friendly;
    }

    private function count_gender($result_array)
    {
        $counter = 0;
        foreach ($result_array as $key => $result) {
            if (!empty($result['U_Name'])) {
                $counter++;
            }
        }
        return $counter;
    }

    public function survey_preview()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $this->load->model('company/sv_company_reports'); // loading the model
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_co_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar 
            FROM `sv_st1_co_surveys` 
            JOIN `sv_co_published_surveys` ON `sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->sv_company_reports->our_departments(true) . ")
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_co_published_surveys`.`Id` = $serv_id ")->result_array();
            if (!empty($data['serv_data'])) {
                $group = $data['serv_data'][0]['main_survey_id'];
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' ")->result_array();
                $group_coices = $data['serv_data'][0]['group_id'];
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                $this->load->view("EN/Company/inc/preview_header", $data);
                $this->load->view("EN/Company/preview_survey");
                $this->load->view("EN/inc/footer");
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('AR/Company/wellness');
        }
    }


    public function use_this_survey()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            /// start loding page
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Manage Surveys";
            $data['sessiondata'] = $sessiondata;
            $data['survey_type'] = "withchoices";
            $list['serv_data'] = $this->db->query(" SELECT `sv_st_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`status` AS status,
            `sv_st_category`.`Cat_en`,
            `sv_st_category`.`Cat_ar`,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
            COUNT(`sv_st_questions`.`survey_id`) AS questions_count
            FROM `sv_st_surveys`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id` 
            INNER JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
            INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
            WHERE `sv_st_surveys`.`status` = '1' AND `sv_st_surveys`.`Id` = '" . $serv_id . "'
            GROUP BY `sv_st_questions`.`survey_id`")->result_array();
            $list['questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id 
            FROM `sv_st_questions` 
            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
            WHERE `survey_id` = '" . $serv_id . "' ")->result_array();
            if (!empty($list['serv_data']) && !empty($list['questions'])) {
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Company/use_this_survey', $list);
                $this->load->view('EN/inc/footer');
            } else {
                return redirect("EN/Company/wellness");
            }
        } else {
            // show error page
        }
    }

    public function start_using_serv()
    {
        if ($this->input->post("serv_id") && is_numeric($this->input->post("serv_id"))) {
            $this->load->library('form_validation');
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            // validation
            $this->form_validation->set_rules('title_en', 'EN title', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('title_ar', 'AR title', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('Start', 'Start Date', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('End', 'End Date', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('avalaible_to', 'avalaible to', 'trim|required');
            $this->form_validation->set_rules('status', 'status', 'trim|required');
            $surveyType = $this->input->post('surveyType') == "fillable" ? "fillable" : "notfillable";
            if ($this->form_validation->run()) {
                $data  = array(
                    'Title_en'        => $this->input->post('title_en'),
                    'Title_ar'        => $this->input->post('title_ar'),
                    'Startting_date'  => $this->input->post('Start'),
                    'End_date'        => $this->input->post('End'),
                    'Avalaible_to'    => $this->input->post('avalaible_to'),
                    'Status'          => $this->input->post('status') == 1 ? "0" : "1",
                    'Survey_id'       => $this->input->post('serv_id'),
                    'Created'         => date('Y-m-d'),
                    'Time'            => date("H:i:s"),
                    'survey_type'     => $surveyType,
                    'Published_by'    => $sessiondata["admin_id"]
                );
                if ($this->db->insert('sv_st1_co_surveys', $data)) {
                    if ($this->input->post('status') == '2') {
                        echo "ok_enabled";
                    } else {
                        echo "ok_disabled";
                    }
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function change_serv_status()
    {
        if ($this->input->post("serv_id") && $this->input->post("type")) {
            $id = $this->input->post("serv_id");
            if ($this->input->post("type") == "change") {
                if ($this->db->query("UPDATE sv_st1_co_surveys SET status = IF(status=1, 0, 1) WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            } elseif ($this->input->post("type") == "delete") {
                if ($this->db->query("DELETE FROM `sv_st1_co_surveys` WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            } elseif ($this->input->post("type") == "update_date" && $this->input->post("new_date")) {
                $new_date = $this->input->post("new_date");
                if ($this->db->query("UPDATE sv_st1_co_surveys SET `End_date` = '" . $new_date . "' WHERE Id = '" . $id . "'")) {
                    echo "ok";
                }
            }
        }
    }

    public function ClimatesLinks()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $data['sessiondata'] = $sessiondata;
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $links  = array();
            $links[] = array('name' => "CLIMATE LIBRARY", "link" => base_url('EN/Company/ClimateSurveys'), "desc" => "", "icon" => "aaaclimate.png");
            $links[] = array('name' => "CLIMATE DASHBOARD", "link" => base_url('EN/Company/Climate-Dashboard'), "desc" => "", "icon" => "aaaclimate.png");

            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Climate Links List";
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Global/Links/Lists', $data);
            $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
        } else {
            $dataDes['to'] = "EN/Company";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function ClimateSurveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $this->load->model('company/sv_company_reports'); // loading the model
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = "Qlick Health | Climate Surveys List ";
            if ($this->input->method() == "get") {
                $data['surveys'] = $this->sv_company_reports->ClimatesurveysLibrary();
                $data['oursurveys'] = $this->sv_company_reports->OurClimatesurveys();
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Company/ClimateSurveys');
                $this->load->view('EN/inc/footer');
            } elseif ($this->input->method() == "put") {
                if ($this->input->input_stream('surveyId')) {
                    $serv_id = $this->input->input_stream('surveyId');
                    if ($this->db->query("UPDATE `scl_st_co_climate` SET status = IF(status=1, 0, 1) WHERE Id = '" . $serv_id . "'")) {
                        echo "ok";
                    }
                } else {
                    echo "error";
                }
            }
        } else {
            $dataDes['to'] = "EN/Company";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }


    public function climatePreview()
    {
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                if ($this->input->method() == 'get') {
                    $data['page_title'] = "Qlick Health | Manage Choices ";
                    $data['sessiondata'] = $sessiondata;
                    $data['choices'] =  $this->db
                        ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
                    sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
                        ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
                        ->from('scl_st_choices')
                        ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
                        ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
                        ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
                        ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
                        ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
                        ->where('servey_id', $this->uri->segment(4))
                        ->order_by('position', 'ASC')
                        ->get()->result_array();
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/Company/climatePreview');
                    $this->load->view('EN/inc/footer');
                }
            }
        } else {
            $dataDes['to'] = "EN/Company";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }


    public function newclimatesurvey()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "Qlick Health | New Climate Survey  ";
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $this->load->model('company/sv_company_reports'); // loading the model
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $data['survId'] = $this->uri->segment(4);
                if ($this->input->method() == "get") {
                    $data['serv_data'] = $this->sv_company_reports->getAClimateSurvey($data['survId']);
                    if (!empty($data['serv_data'])) {
                        $this->load->view('EN/inc/header', $data);
                        $this->load->view('EN/Company/newclimatesurvey');
                        $this->load->view('EN/inc/footer');
                    } else {
                        echo "No data found !!";
                        return redirect("EN/Company/ClimateSurveys");
                    }
                } elseif ($this->input->method() == "post") {
                    if ($this->input->post("serv_id") && is_numeric($this->input->post("serv_id"))) {
                        $this->load->library('form_validation');
                        $this->load->library('session');
                        $sessiondata = $this->session->userdata('admin_details');
                        // validation
                        $this->form_validation->set_rules('title_en', 'EN title', 'trim|required|max_length[200]');
                        $this->form_validation->set_rules('title_ar', 'AR title', 'trim|required|max_length[200]');
                        $this->form_validation->set_rules('Start', 'Start Date', 'trim|required|exact_length[10]');
                        $this->form_validation->set_rules('End', 'End Date', 'trim|required|exact_length[10]');
                        $this->form_validation->set_rules('avalaible_to', 'avalaible to', 'trim|required');
                        $this->form_validation->set_rules('status', 'status', 'trim|required');
                        if ($this->form_validation->run()) {
                            $data  = array(
                                'Title_en'        => $this->input->post('title_en'),
                                'Title_ar'        => $this->input->post('title_ar'),
                                'Startting_date'  => $this->input->post('Start'),
                                'End_date'        => $this->input->post('End'),
                                'Avalaible_to'    => $this->input->post('avalaible_to'),
                                'Status'          => $this->input->post('status') == 1 ? "0" : "1",
                                'Climate_id'      => $this->input->post('serv_id'),
                                'Created'         => date('Y-m-d'),
                                'Time'            => date("H:i:s"),
                                'Published_by'    => $sessiondata["admin_id"]
                            );
                            if ($this->db->insert('scl_st_co_climate', $data)) {
                                if ($this->input->post('status') == '2') {
                                    echo "ok_enabled";
                                } else {
                                    echo "ok_disabled";
                                }
                            }
                        } else {
                            echo validation_errors();
                        }
                    }
                }
            } else {
            }
        } else {
            $dataDes['to'] = "EN/Company";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function ClimateReports()
    {
        $this->load->library('session');
        $this->load->model('company/sv_company_reports');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('encrypt_url');
        if (is_numeric($this->encrypt_url->safe_b64decode($this->uri->segment(4)))) {
            $data['surveyid'] = $this->encrypt_url->safe_b64decode($this->uri->segment(4));
            // exit($data['surveyid']);
            if (!empty($this->sv_company_reports->GetClimatesurveys(['surveyid' => $data['surveyid'], 'show_codes' => true]))) {
                $data['fulldata'] = $this->sv_company_reports->GetClimatesurveys(['surveyid' => $data['surveyid'], 'show_codes' => true])[0];
                $data['choices'] = $this->sv_company_reports->ClimateChoices(['surveyid' => $data['surveyid']]);
                $data['colors'] = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
                $data['types'] = $this->db->where_in('Id', explode(',', $data['fulldata']['typeslist']))->get('r_usertype')->result_array();
                $data['filters'] = array(
                    [
                        "name" => "type",
                        "filters" => []
                    ], [
                        "name" => "male",
                        "filters" => ['gender' => "M"]
                    ], [
                        "name" => "female",
                        "filters" => ['gender' => "F"]
                    ], [
                        "name" => "age",
                        "filters" => ['age' => [
                            'min' => 12,
                            "max" => 20
                        ]]
                    ]
                );
                $data['age'] = array('from' => 12, 'to' => 20);
                if (is_numeric($this->input->post('age_from')) && ($this->input->post('age_from') < $this->input->post('age_to'))) {
                    $data['age']['from'] = $this->input->post('age_from');
                }
                if (is_numeric($this->input->post('age_to')) && ($this->input->post('age_to') > $this->input->post('age_from'))) {
                    $data['age']['to'] = $this->input->post('age_to');
                }
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Company/ClimateReports');
                $this->load->view('EN/inc/footer');
            } else {
                echo "Error in finding this survey";
            }
        } else {
            echo "Error in finding this survey";
        }
    }

    public function Consultants()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4)) { // show the page
            if (!in_array(strtolower($this->uri->segment(4)), ['managment', 'reports', 'chat'])) {
                redirect('EN/Company/Consultants'); // go back to the links page
            } else {
                $link = strtolower($this->uri->segment(4));
                switch ($link) {
                    case 'managment':
                        $this->ConsultantsCRUD(); // show the managment page 
                        break;
                    case 'reports':
                        $this->ConsultantReports(); // show the managment page 
                        break;
                    case 'chat':
                        $this->ConsultantChat(); // show the managment page 
                        break;
                    default:
                        print_r($this->uri->segment_array());
                        echo "Can't Find This Page Sorry !";
                        break;
                }
            }
        } else { // show the links
            $links  = array();
            $links[] = array(
                'name' => "CONSULTANT MANAGEMENT", "link" => base_url('EN/Company/Consultants/Managment'),
                "desc" => "", "icon" => "DTemperature.png"
            );
            $links[] = array(
                'name' => "CONSULTANT REPORT", "link" => base_url('EN/Company/Consultants/Reports'),
                "desc" => "", "icon" => "DTemperature.png"
            );
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Consultants ";
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Global/Links/Lists', $data);
            $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
        }
    }

    private function ConsultantReports() // private
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        if ($this->input->method() == "get") {
            $body['files'] = $this->db->select('FileName AS link , Created AS UploadedAt , Comments , l1_consultant_reports.Id')
                ->select('(SELECT COUNT(Id) 
                                FROM l0_consultant_chat 
                                WHERE l0_consultant_chat.about = l1_consultant_reports.Id 
                                AND receiver_id = "' . $sessiondata['admin_id'] . '" AND receiver_usertype = "' . $sessiondata['type'] . '"
                                AND sender_usertype = "consultant" AND read_at IS NULL) AS UnreadMessages')
                ->from('l1_consultant_reports')
                ->where('AccountId', $sessiondata['admin_id'])
                ->where('AccountType', "C")
                ->get()->result_array();
            $this->load->view('EN/Component/Consultant/list', $body);
        }
        $this->load->view('EN/inc/footer');
    }

    private function ConsultantsCRUD() // provate test
    { // Consultants managments (CRUD) page
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        $this->load->library('form_validation');
        if ($this->input->method() == "get") {
            if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->input->is_ajax_request()) { // request for account details
                try {
                    $id = $this->uri->segment(5);
                    $account = $this->db->select('l1_consultants.name , l1_consultants.Id , v_login.Username')
                        ->from('l1_consultants')
                        ->join("v_login", "v_login.Id = l1_consultants.loginkey")
                        ->where("l1_consultants.Added_By", $sessiondata['admin_id'])
                        ->where("l1_consultants.Id", $id)
                        ->get()->result_array();
                    if (!empty($account)) {
                        $account = $account[0];
                        $children = array_column($this->db->select('account_id')->from('l1_consultants_children')->where('consultant_id', $id)->get()->result_array(), "account_id");
                        return $this->response->json(['status' => 'ok', 'details' => $account, "children" => $children]);
                    } else {
                        return $this->response->json(['status' => 'error', 'message' => "Sorry we Can't Find This User"]);
                    }
                } catch (\Throwable $th) {
                    return $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later"]);
                }
            } else {
                $data['children'] = $this->db->select("l1_co_department.Id AS id , l1_co_department.Dept_Name_EN AS text ")->from('l1_co_department')->where('l1_co_department.Added_By', $sessiondata['admin_id'])->get()->result_array();
                $data['accounts'] = $this->db->select('l1_consultants.name , l1_consultants.Id , v_login.Username')
                    ->select('(SELECT COUNT(Id) FROM `l1_consultants_children` WHERE `consultant_id` = `l1_consultants`.`Id` ) AS ChildrenCounter')
                    ->from('l1_consultants')
                    ->join("v_login", "v_login.Id = l1_consultants.loginkey")
                    ->where("l1_consultants.Added_By", $sessiondata['admin_id'])
                    ->get()->result_array();
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Component/Consultant/Managment', $data);
                $this->load->view('EN/inc/footer');
            }
        } else if ($this->input->method() == "post") {
            if ($this->input->post("_activeid")) { // update request
                $activeid = $this->input->post("_activeid");
                // validation start
                $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]');
                $this->form_validation->set_rules('children[]', 'children', 'trim|required', array('required' => 'Select one School at least.'));
                if ($this->form_validation->run()) {
                    try {
                        $this->db->where("Id", $activeid)->set(["name" => $this->input->post('name')])->update("l1_consultants");
                        // deleting the old children
                        $this->db->where('consultant_id', $activeid)->delete('l1_consultants_children');
                        // inserting the new ones
                        $children = array();
                        foreach ($this->input->post("children") as $key => $school) {
                            $children[] = [
                                'consultant_id' => $activeid,
                                'account_id'    => $school,
                            ];
                        }
                        $this->db->insert_batch("l1_consultants_children", $children);
                        // returing the status success 
                        return $this->response->json(['status' => "ok"]);
                    } catch (\Throwable $th) {
                        return $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later"]);
                    }
                } else {
                    return $this->response->json(['status' => 'error', 'message' => validation_errors('', '')]);
                }
            } else {
                $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]');
                $this->form_validation->set_rules('username', 'username', 'trim|required|is_unique[v_login.Username]|min_length[3]|max_length[30]');
                $this->form_validation->set_rules('children[]', 'children', 'trim|required', array('required' => 'Select one School at least.'));
                if ($this->form_validation->run()) {
                    try {
                        $login = [
                            "username" => $this->input->post('username'),
                            "password" => password_hash("12345678", PASSWORD_DEFAULT),
                            "Type"     => "consultant",
                        ];
                        $this->db->insert('v_login', $login); // login data
                        $loginkey = $this->db->insert_id();
                        $consultants = [
                            "name"     => $this->input->post('name'),
                            "Added_By" => $sessiondata['admin_id'],
                            "loginkey" => $loginkey,
                        ];
                        $this->db->insert('l1_consultants', $consultants); // user data
                        $consultantkey = $this->db->insert_id();
                        $children = array();
                        foreach ($this->input->post("children") as $key => $school) { // preparing the children data
                            $children[] = [
                                'consultant_id' => $consultantkey,
                                'account_id'    => $school,
                            ];
                        }
                        $this->db->insert_batch("l1_consultants_children", $children);
                        return $this->response->json(['status' => "ok"]);
                    } catch (\Throwable $th) {
                        return $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later"]);
                    }
                } else {
                    return $this->response->json(['status' => 'error', 'message' => validation_errors('', '')]);
                }
            }
        } else if ($this->input->method() == "delete") {
            if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->input->is_ajax_request()) { // deleting
                $this->db->where('Id', $this->uri->segment(5))->delete("l1_consultants");
                return $this->response->json(['status' => "ok"]);
            }
        } else {
            return $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later"]);
        }
    }

    public function ConsultantChat()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && $this->uri->segment(4) == "chat" && is_numeric($this->uri->segment(5))) {
            // for chat
            $body['fileid'] = $this->uri->segment(5);
            $Consultantdata = $this->db->where('Id', $body['fileid'])->get("l1_consultant_reports")->row();
            if (empty($Consultantdata)) {
                return redirect('EN/Company/Consultant');
            }
            $body['target'] = $Consultantdata->UploadedBy;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Component/Consultant/chat', $body);
        } else {
            redirect("EN/Consultants/Reports");
        }
    }

    public function survey_report_view()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $ourdepartments = implode(',', array_column($this->db->get_where("l1_co_department", ["Added_By" => $sessiondata['admin_id']])->result_array(), "Id"));
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_co_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`Message_ar` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_co_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_co_published_surveys` ON `sv_st1_co_surveys`.`Id` = `sv_co_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_co_published_surveys`.`theme_link`
            WHERE `sv_co_published_surveys`.`Id` = '" . $serv_id . "' AND `sv_st1_co_surveys`.`Status` = '1'
            AND  `sv_co_published_surveys`.`Created_By` IN (" . $ourdepartments . ") ")->result_array();
            if (!empty($data['serv_data'])) {
                $data['serv_theme'] = $data['serv_data'][0]['serv_theme'];
                $data['serv_img'] = $data['serv_data'][0]['image_name'];
                $group = $data['serv_data'][0]['main_survey_id'];
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' ")->result_array();
                $group_coices = $data['serv_data'][0]['group_id'];
                $data['group_choices'] = $group_coices;
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                $this->load->view('EN/inc/header', $data);
                $this->load->view("EN/Company/report_view_survey");
                $this->load->view("EN/inc/footer");
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('AR/DashboardSystem/wellness');
        }
    }

    public function question_detailed_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) &&  $this->uri->segment(7)) {
            $survey_id = $this->uri->segment(4);
            $question_id = $this->uri->segment(5);
            $group_choices = $this->uri->segment(6);
            $this->load->library('session');
            $data['__count'] = 0;
            $sessiondata = $this->session->userdata('admin_details');
            $choices = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
            WHERE `group_id` = '" . $group_choices . "' ")->result_array();
            foreach ($choices as $choice) {
                $data['__count']++;
                $data['sessiondata'] = $sessiondata;
                $data['serv_id']     = $survey_id;
                $data['name']        = $choice['title_en'];
                $data['question_id'] = $question_id;
                $data['choice_id']   = $choice['Id'];
                $data['question_id'] = $question_id;
                $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_co_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice['Id'] . "' ")->num_rows();
                $all_count = $this->db->query(" SELECT Id FROM `sv_st1_co_answers_values` WHERE `question_id` = '" . $question_id . "'  ")->num_rows();
                $perc = $this->calc_perc($data['use_count'], $all_count);
                $data['perc'] = $perc;
                $data['types'] = $this->db->where('EXISTS(SELECT Id FROM `l2_co_patient` WHERE `l2_co_patient`.`UserType` = `r_usertype`.`Id`)')->get('r_usertype')->result_array();
                $data['TypesLabels'] = implode(',', array_map(function ($k) {
                    return '"' . $k['UserType'] . '"';
                }, $data['types']));
                $data['by_types'] = [];
                $data['by_types']['total'] = $this->db->query(" SELECT `sv_st1_co_answers_values`.`Id` AS Total FROM sv_st1_co_answers_values 
                JOIN `sv_st1_co_answers` ON `sv_st1_co_answers`.`Id` = `sv_st1_co_answers_values`.`answers_data_id` 
                WHERE `sv_st1_co_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_co_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_co_answers_values`.`choice_id` = '" . $choice['Id'] . "' ")->num_rows();
                foreach ($data['types'] as $key => $type) {
                    $data['by_types'][$type['UserType']] = $this->db->query(" SELECT `sv_st1_co_answers_values`.`Id` AS Total FROM sv_st1_co_answers_values 
                    JOIN `sv_st1_co_answers` ON `sv_st1_co_answers`.`Id` = `sv_st1_co_answers_values`.`answers_data_id` 
                    JOIN `l2_co_patient` ON `sv_st1_co_answers`.`user_id` = `l2_co_patient`.`Id`
                    WHERE `sv_st1_co_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_co_answers_values`.`question_id` = '" . $question_id . "' 
                    AND `sv_st1_co_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `l2_co_patient`.`UserType` = '" . $type['Id'] . "' ")->num_rows();
                }
                //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
                $this->load->model('company/sv_company_reports');
                $data['males'] = $this->count_gender($this->sv_company_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "0"));
                $data['females'] = $this->count_gender($this->sv_company_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "1"));
                $this->load->view("EN/company/inc/report_question_survey", $data);
            }
        } else {
            redirect('AR/Schools/wellness');
        }
    }

    public function question_choice_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && $this->uri->segment(7) !== null) {
            $survey_id   = $this->uri->segment(4);
            $choice_id   = $this->uri->segment(5);
            $question_id = $this->uri->segment(6);
            $perc = $this->uri->segment(7);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $choice_data = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
            WHERE `Id` = '" . $choice_id . "' ")->result_array();
            $data['name']        = $choice_data[0]['title_en'];
            $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_co_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice_id . "' ")->num_rows();
            $data['sessiondata'] = $sessiondata;
            $data['serv_id']     = $survey_id;
            $data['question_id'] = $question_id;
            $data['choice_id']   = $choice_id;
            $data['perc'] = $perc;
            $data['types'] = $this->db->where('EXISTS(SELECT Id FROM `l2_co_patient` WHERE `l2_co_patient`.`UserType` = `r_usertype`.`Id`)')->get('r_usertype')->result_array();
            $data['TypesLabels'] = implode(',', array_map(function ($k) {
                return '"' . $k['UserType'] . '"';
            }, $data['types']));
            $data['by_types'] = [];
            $data['by_types']['total'] = $this->db->query(" SELECT `sv_st1_co_answers_values`.`Id` AS Total FROM sv_st1_co_answers_values 
            JOIN `sv_st1_co_answers` ON `sv_st1_co_answers`.`Id` = `sv_st1_co_answers_values`.`answers_data_id` 
            WHERE `sv_st1_co_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_co_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_co_answers_values`.`choice_id` = '" . $choice_id . "' ")->num_rows();
            foreach ($data['types'] as $key => $type) {
                $data['by_types'][$type['UserType']] = $this->db->query(" SELECT `sv_st1_co_answers_values`.`Id` AS Total FROM sv_st1_co_answers_values 
                JOIN `sv_st1_co_answers` ON `sv_st1_co_answers`.`Id` = `sv_st1_co_answers_values`.`answers_data_id` 
                JOIN `l2_co_patient` ON `sv_st1_co_answers`.`user_id` = `l2_co_patient`.`Id`
                WHERE `sv_st1_co_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_co_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_co_answers_values`.`choice_id` = '" . $choice_id . "' AND `l2_co_patient`.`UserType` = '" . $type['Id'] . "' ")->num_rows();
            }
            // $data['by_types'] = $this->db->query("SELECT 
            // (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            // JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            // WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            // AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
            // (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            // JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            // WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            // AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
            // (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            // JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            // WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            // AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
            // (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            // JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            // WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            // AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
            // (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            // JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            // WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            // AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' ) AS Total  
            // ")->result_array();
            //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
            $this->load->model('company/sv_company_reports');
            $data['males'] = $this->count_gender($this->sv_company_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "0"));
            $data['females'] = $this->count_gender($this->sv_company_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "1"));
            $this->load->view("EN/company/inc/report_question_survey", $data);
        }
    }

    public function climate_results_chart()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->db->Is_existInTable($this->uri->segment(4), 'scl_published_claimate') && !$this->uri->segment(5)) {
            $this->load->library('session');
            $this->load->model('company/sv_company_reports');
            $this->load->model('helper');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = 'Qlick Health | Chart survey';
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['surveyId'] = $this->uri->segment(4);
            $data['survey_data'] = $this->sv_company_reports->GetClimatesurveys([], $data['surveyId']);
            if (empty($data['survey_data'])) {
                echo "can't find any data sorry !";
                exit();
            }
            if (!$this->helper->forCompany($data['survey_data']->By_department)->isThere()) {
                echo "This Departments Doesn't contain any members";
                return false;
            }
            $data['userstypes'] = $this->helper->forCompany($data['survey_data']->By_department)->get();
            $data['colors'] = array(
                '#FF6633', '#FFB399', '#FF33FF', '#00B3E6',
                '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
                '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
                '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
                '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
                '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
                '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
            );
            $data['choices'] = $this->db
                ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
                sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
                ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
                ->select('COUNT(scl_co_climate_answers.Id) AS ChooseingTimes')
                ->from('scl_st_choices')
                ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
                ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
                ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
                ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
                ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
                ->join('scl_co_climate_answers', 'scl_co_climate_answers.climate_id = ' . $data['surveyId'] . ' AND  scl_co_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left')
                ->where('servey_id', $data['survey_data']->main_survey_id)
                ->order_by('position', 'ASC')
                ->group_by('scl_st_choices.Id')
                ->get()->result_array();
            $data['users_passed_survey'] = $this->sv_company_reports->GetClimateAnswers($data['surveyId']);
            $data['byUserType'] = [];
            foreach ($data['userstypes'] as $userstype) {
                $data['byUserType'][$userstype['code']] = $this->sv_company_reports->GetClimateAnswers($data['surveyId'], ["ByType" => $userstype['code']]);
            }
            $data['Males'] = $this->sv_company_reports->GetClimateAnswers($data['surveyId'], ["gender" => 'M']);
            $data['Females'] = $this->sv_company_reports->GetClimateAnswers($data['surveyId'], ["gender" => 'F']);
            // $this->response->json($data);
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/climate_results_chart');
            $this->load->view('EN/inc/footer');
        } else {
            echo "survey not found...";
            exit();
        }
    }

    public function Climate_Dashboard()
    {
        $this->load->library('session');
        $this->load->model('company/sv_company_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Add an Usertype ";
        $data['sessiondata'] = $sessiondata;
        $data['climate_survyes'] = $this->sv_company_reports->GetClimatesurveys();
        $data['departments'] = $this->db->where('Added_By', $sessiondata['admin_id'])->get('l1_co_department')->result_array();
        $data['fullpage'] = true;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Company/inc/climate_dashboard');
        $this->load->view('EN/inc/footer');
    }

    public function categorys_reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | survey report ";
        $permission = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "'
        AND `user_type` = 'Company' AND `v0_permissions`.`surveys` = '1' ")->result_array();
        if (!empty($permission)) {
            $this->load->model('company/sv_company_reports');
            $this->load->model('helper');
            if (!$this->uri->segment(4)) { // when the category not choosed
                $data['categorys'] = $this->sv_company_reports->usedcategorys($sessiondata['admin_id']); // return categorys used in this school
                $data['surveys'] = $this->sv_company_reports->our_surveys(); // return categorys used in this school
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Company/category_report', $data);
                $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
            } else {
                /**
                 *  category_by_gender :
                 *      @user id
                 *      @gender cose (1 = male , 2 = female)
                 *      @usertype code 
                 *      @cat id
                 */
                $data['cat_id'] = $this->uri->segment(4);
                $sessiondata = $this->session->userdata('admin_details');
                $data['surveys_for_males'] = $this->sv_company_reports->category_by_gender('1', "", $data['cat_id']);
                $data['surveys_for_females'] = $this->sv_company_reports->category_by_gender('2', "", $data['cat_id']);
                $data['surveys_for_all_genders'] = $this->sv_company_reports->category_by_gender('', "", $data['cat_id']);
                // for students
                $data['types'] = $this->helper->forCompany($this->sv_company_reports->our_departments(true))->get();
                foreach ($data['types']  as $key => $type) {
                    $data['types_counter'][$type["code"]] = $this->sv_company_reports->category_by_gender($type["code"], "", $data['cat_id']);
                }
                $data['surveys'] = $this->sv_company_reports->category_publishid_surveys($data['cat_id']);
                // $this->response->json($data);
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Company/category_report_charts', $data);
                $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
            }
        } else {
            $dataDes['to'] = "EN/Company-Departments";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    } //category

    public function questions_reports()
    {
        $this->load->model('company/sv_company_reports');
        $this->load->model('helper');
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['survey_id'] = $this->uri->segment(4);
            $data['types'] = $this->helper->forCompany($this->sv_company_reports->our_departments(true))->get();
            $data['page_title'] = "QlickSystems | Questions Reports ";
            $data['quastions_all_data'] = $this->sv_company_reports->get_surv_quastions($data['survey_id']);
            $cutted_array = array_column($data['quastions_all_data'], 'en_title');
            $questions = array_map(function ($name) {
                return '"' . $name . '"';
            }, $cutted_array);
            $data['quastions'] = $cutted_array;
            $data['survey_quastions'] = $questions;
            $data['get_choices'] = $this->sv_company_reports->survey_q_results($data['survey_id']);
            $used_choices = array_column($data['get_choices'], "choices_en");
            $used_choices = array_map(function ($choices) {
                return '"' . $choices . '"';
            }, $used_choices);
            $data['used_choices'] = $used_choices;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/Questions_Reports', $data);
            $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
        } else {
            redirect('EN/Company-Departments/categorys_reports');
        }
    }

    public function counter_questions()
    {
        $this->load->model('helper');
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['survey_id'] = $this->uri->segment(4);
            $data['page_title'] = "QlickSystems | Questions Reports ";
            $this->load->model('company/sv_company_reports');
            $data['quastions_all_data'] = $this->sv_company_reports->get_surv_quastions($data['survey_id']);
            $cutted_array = array_column($data['quastions_all_data'], 'en_title');
            $questions = array_map(function ($name) {
                return '"' . $name . '"';
            }, $cutted_array);
            $data['quastions'] = $cutted_array;
            $data['survey_quastions'] = $questions;
            $data['get_choices'] = $this->sv_company_reports->survey_q_results($data['survey_id']);
            $used_choices = array_column($data['get_choices'], "choices_en");
            $used_choices = array_map(function ($choices) {
                return '"' . $choices . '"';
            }, $used_choices);
            $data['used_choices'] = $used_choices;
            $data['types'] = $this->helper->forCompany($this->sv_company_reports->our_departments(true))->get();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/Questions_Counter', $data);
            $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
        } else {
            redirect('EN/Company-Departments/categorys_reports');
        }
    }

    public function results_by_question_chart()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->db->Is_existInTable($this->uri->segment(4), 'sv_school_published_surveys') && !$this->uri->segment(5)) {
            $this->load->library('session');
            $this->load->model('helper');
            $this->load->model('company/sv_company_reports');
            $sessiondata = $this->session->userdata('admin_details');
            $serv_id = $this->uri->segment(4);
            // filters
            if ($this->input->method() == "post") {
                $data['filters']['deparments'] = $this->input->post('deparments');
                $data['filters']['userstypes'] = $this->input->post('userstypes');
            } else {
                $data['filters']['deparments'] = null;
                $data['filters']['userstypes'] = null;
            }
            $data['users_passed_survey'] = $this->sv_company_reports->users_passed_survey($serv_id);
            $data['used_choices'] = $this->sv_company_reports->survey_q_results($serv_id);
            $data['colors'] = array(
                '#FF6633', '#FFB399', '#FF33FF', '#00B3E6',
                '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
                '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
                '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
                '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
                '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
                '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
            );
            $ids = $data['filters']['deparments'] == null ? $this->sv_company_reports->our_departments(true) : implode(', ', $data['filters']['deparments']);
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_co_surveys`.`title_en` AS Title_en,
            `sv_st1_co_surveys`.`Startting_date` AS From_date,
            `sv_st1_co_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_st_surveys`.`reference_en` AS  reference,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_co_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_co_published_surveys` ON `sv_st1_co_surveys`.`Id` = `sv_co_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_co_published_surveys`.`theme_link`
            WHERE `sv_co_published_surveys`.`Id` = '" . $serv_id . "' AND `sv_st1_co_surveys`.`Status` = '1'
            AND `sv_co_published_surveys`.`Created_By` IN (" . $ids . ") ")->result_array();
            if (empty($data['serv_data'])) {
                echo "No Data Found !!";
                exit();
            }
            $data['serv_data'] = $data['serv_data'][0];
            $data['users_passed_survey'] = $this->sv_company_reports->users_passed_survey($serv_id);
            $data['serv_theme'] = $data['serv_data']['serv_theme'];
            $data['serv_img'] = $data['serv_data']['image_name'];
            $group = $data['serv_data']['main_survey_id'];
            $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
            $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' ")->result_array();
            $group_coices = $data['serv_data']['group_id'];
            $data['group_choices'] = $group_coices;
            $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
            $data['males_count'] = $this->count_gender($this->sv_company_reports->users_passed_survey($serv_id, null, 'M'));
            $data['females_count'] = $this->count_gender($this->sv_company_reports->users_passed_survey($serv_id, null, 'F'));
            $data['types'] = $this->db->where('EXISTS(SELECT Id FROM `l2_co_patient` WHERE `l2_co_patient`.`UserType` = `r_usertype`.`Id`)')->get('r_usertype')->result_array();
            $data['users_passed_survey'] = $this->sv_company_reports->users_passed_survey($serv_id);
            $data['userstypes'] = $this->helper->forCompany($this->sv_company_reports->our_departments(true))->get();
            $data['byUserType'] = [];
            foreach ($data['userstypes'] as $userstype) {
                if (!empty($data['filters']['userstypes'])) {
                    if (in_array($userstype['code'], $data['filters']['userstypes'])) {
                        $data['byUserType'][$userstype['code']] = $this->sv_company_reports->users_passed_survey($serv_id,  $userstype['code']);
                    }
                } else {
                    $data['byUserType'][$userstype['code']] = $this->sv_company_reports->users_passed_survey($serv_id,  $userstype['code']);
                }
            }
            // filters provider
            $data['deparments'] = $this->sv_company_reports->our_departments();
            $finishing_all_data = $this->sv_company_reports->timeOfFinishingForThisSurvey($serv_id);
            $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
            $data['serv_id'] = $serv_id;
            $data['page_title'] = 'Qlick Health | Chart survey';
            $data['sessiondata'] = $sessiondata;
            // $this->response->json($data);
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Company/results_by_question_chart');
            $this->load->view('EN/inc/footer');
        } else {
            echo "No Data Found !!";
        }
    }

    private function calculate_avg_time($returned_data)
    {
        $durations = array_column($returned_data, 'Finishing_time');
        $sum = 0.0;
        foreach ($durations as $duration) {
            list($h, $m, $s) = explode(':', $duration);
            $sum += $h * 3600 + $m * 60 + $s;
        }
        if ($sum !== 0.0) {
            $avg = ($sum / count($durations));
            $hours = floor($avg / 3600);
            $mins = floor($avg / 60 % 60);
            $secs = floor($avg % 60);
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            return $timeFormat;
        } else {
            return "--:--:--";
        }
    }
}
