<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Company extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->config->set_item('language', 'arabic');
        if (!isset($sessiondata) || $sessiondata['level'] !== 1 || $sessiondata['type'] !== "Company") {
            redirect('AR/users');
            exit();
        }
    }

    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->model('company/sv_company_reports');
        $this->load->library('encrypt_url');
        if (!empty($sessiondata)) {
            $data['climate_survyes'] = $this->sv_company_reports->GetClimatesurveys();
            $data['our_schoolsList'] = implode(',', array_column($this->db->query("SELECT `Id` FROM `l1_co_department` WHERE
            `Added_By` = " . $sessiondata['admin_id'] . " ORDER BY `Id` DESC ")->result_array(), 'Id'));
            $data['page_title'] = "Qlick Health | Dashboard ";
            $data['sessiondata'] = $sessiondata;
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

            $data['test'] = $arr;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Company/dash');
            $this->load->view('AR/inc/footer', $data);
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
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Company/addDepartment');
        $this->load->view('AR/inc/footer');
    }

    public function Monitors_routes_company()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata; {
            $links  = array();

            $links[] = array(
                'name' => " DAILY REPORT ", "link" => base_url('AR/Company/All_Tests_Today'),
                "desc" => "", "icon" => "DTemperature.png"
            );

            $links[] = array(
                'name' => " ATTENDANCE REPORT ", "link" => base_url('AR/Company/Attendance_Report'),
                "desc" => "", "icon" => "AttendancebyDatser.png"
            );

            $links[] = array(
                'name' => " REFRIGERATORS REPORT ", "link" => base_url('AR/Company/Refrigerator_access'),
                "desc" => "", "icon" => "Refrigerator_Trip.png"
            );

            $links[] = array(
                'name' => " LAB REPORT ", "link" => base_url('AR/Company/Lab_Reports'),
                "desc" => "", "icon" => "LabReport.png"
            );

            $links[] = array(
                'name' => " REFRIGERATORS TRIP REPORT ", "link" => base_url('AR/Company/refrigerators'),
                "desc" => "", "icon" => "Refrigerator_Trip.png"
            );
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | List all ";
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Global/Links/Lists', $data);
            $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
        }
    }

    public  function DepartmentsList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Departments List ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $listofadmins['listofadmins'] = $this->db->query("SELECT *, l1_co_department.Id as Dept_Id
        FROM l1_co_department 
        LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l1_co_department`.`Id` 
        AND `l2_avatars`.`Type_Of_User` = 'department_Company'
        WHERE `l1_co_department`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        ORDER  BY `l1_co_department`.`Id` DESC")->result_array();
        $this->load->view('AR/Company/Department_List', $listofadmins);
        $this->load->view('AR/inc/footer');
    }

    public function Refrigerator_access()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Departments List ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
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
        $this->load->view('AR/Company/Refrigeraters', $list);
        $this->load->view('AR/inc/footer');
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
            $this->form_validation->set_rules('Arabic_Title', 'الإسم بالعربي', 'trim');
            $this->form_validation->set_rules('English_Title', 'الإسم بالإنجليزي', 'trim');
            $this->form_validation->set_rules('Manager_AR', 'إسم المدير بالعربي', 'trim');
            $this->form_validation->set_rules('Manager_EN', 'إسم المدير بالإنجليزي', 'trim');
            $this->form_validation->set_rules('Phone', 'رقم الهاتف', 'trim|numeric');
            $this->form_validation->set_rules('Email', 'الإيميل', 'trim|valid_email');
            $this->form_validation->set_rules('Username', 'إسم المستخدم', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('position', 'وظيفة المستخدم', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('countries', 'الدولة', 'trim|required|max_length[5]');
            $this->form_validation->set_rules('DepartmentId', 'رمز تعريف الفرع', 'trim|required|min_length[3]|max_length[30]');

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
                $password =  substr(md5(time()), 0, 16);
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                $My_Id = $sessiondata['admin_id'];

                $region =  str_pad($countries_branch, 4, '0', STR_PAD_LEFT);
                $parentId =  str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
                $rand = rand(1000, 9999);
                $genrationcode = $region . $parentId . $rand;

                if (is_numeric($city)) {
                    $isselected++;
                } else {
                    echo 'إختر المدينة من فضلك';
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
                        ];
                        if ($this->db->insert('l1_co_department', $data)) {
                        //    $this->sendNewUserEmail($Email, $password, $username);
                            $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type` ,`Company_Type`,`Created`,`generation`)
                            VALUES ('" . $username . "','" . $hash_pass . "','department', '6' ,'" . date('Y-m-d') . "','" . $genrationcode . "')"); ?>
                            <script>
                                Swal.fire({
                                    title: 'تمت الإضافة',
                                    text: 'تمت الإضافة بنجاح , تم إرسال المعلومات بنجاح للإيميل ',
                                    icon: 'success',
                                    confirmButtonColor: '#5b8ce8',
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            </script>
                        <?php
                        } else {
                            echo "نعتذر لدينا مشكلة في معالجة الطلب حاليا";
                        }
                    } else {
                        echo 'إسم المستخدم هذا مستعمل من قبل';
                    }
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "من فضلك أدخل المعلومات";
        }
    }

    public function startAddingBr()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;

        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Username')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim');
            $this->form_validation->set_rules('Manager_AR', 'Manager Name In Arabic', 'trim');
            $this->form_validation->set_rules('Manager_EN', 'Manager Name In English', 'trim');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('position', 'Manager Position', 'trim|required|min_length[3]|max_length[30]');
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
                $password =  substr(md5(time()), 0, 16);
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                $My_Id = $sessiondata['admin_id'];


                if (is_numeric($city)) {
                    $isselected++;
                } else {
                    echo 'Please Select The city';
                }



                if ($isselected == 1) {
                    $iscorrent = $this->db->query("SELECT * FROM `v_login` WHERE Username = '" . $username . "' ")->result_array();

                    if (empty($iscorrent)) {
                        if ($this->db->query("INSERT INTO `l1_co_department` (
                        `Username`,`password`,
                        `Dept_Name_AR`, `Dept_Name_EN`,
                        `Created`, `Manager_EN`, `Manager_AR`,
                        `Phone`,`Email`,
                        `Citys`,`Type_Of_Dept`,`Position`,`Dept_Type`,`Country`,
                        `Added_By`)
                        
                        VALUES (
                        '" . $username . "','" . $hash_pass . "',
                        '" . $Arabic_Title . "','" . $English_Title . "'
                        ,'" . date('Y-m-d') . "','" . $Manager_EN . "','" . $Manager_AR . "',
                        '" . $Phone . "','" . $Email . "'
                        ,'" . $city . "','" . $Type . "','" . $position . "','Bransh','" . $countries_branch . "',$My_Id)")) {
                        //    $this->sendNewUserEmail($Email, $password, $username);
                            // $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`,`Created`) VALUES ('" . $username . "','" . $hash_pass . "','department','" . date('Y-m-d') . "')");
                        ?>
                            <script>
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'The data were inserted successfully. The email will be sent to <?php echo $Email ?> ',
                                    icon: 'success',
                                    confirmButtonColor: '#5b8ce8',
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            </script>
                        <?php
                        } else {
                            echo "عذرا ، النظام لديه مشكلة الآن.";
                        }
                    } else {
                        echo 'The User Name ' . '"' . $username . '"' . ' is already exist';
                    }
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "يرجى تقديم البيانات المطلوبة.";
        }
    }

    private function sendNewUserEmail($email, $pass, $username)
    {
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.hostinger.com',
            'smtp_port' => 465,
            'smtp_user' => 'jobs@qlicksystems.com',
            'smtp_pass' => 'O?#f:Kc19#z',
            'smtp_crypto' => 'ssl',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $username . ' </h3>
          <h3>Your password is : ' . $pass . ' </h3>
          <a href=""' . base_url() . '"AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';

        $this->email->initialize($config);
        $this->email->set_newline('\r\n');
        $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
        $this->email->bcc('emails@qlicksystems.com');
        $this->email->to($email);
        $this->email->subject(' Department - Your User Name And Password ');
        $this->email->message($messg);
        if (!$this->email->send()) {
            //echo $this->email->print_debugger();     
            echo 'We have an error in sending the email . Please try again later.';
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
            $this->load->view('AR/inc/header', $data);
            $adminInfos['DepartmentData'] = $this->db->query("SELECT * FROM l1_co_department 
            WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->load->view('AR/Company/Upadate_Department', $adminInfos);
            $this->load->view('AR/inc/footer');
        } else {
            redirect("AR/DashboardSystem");
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
            $this->form_validation->set_rules('Manager_AR', 'Manager Name In Arabic', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager Name In English', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('countries', 'countries', 'trim|required|numeric');
            $this->form_validation->set_rules('city', 'city', 'trim|required|numeric');
            $this->form_validation->set_rules('Type', 'نوع القسم', 'trim|required');
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
                                title: 'تم!',
                                text: 'تم تحديث المعلومات بنجاح',
                                icon: 'success',
                                confirmButtonColor: '#5b8ce8',
                            });
                            setTimeout(function() {
                                location.href = "<?php echo base_url(); ?>AR/Company/DepartmentsList";
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
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Profiles/Company_Profile');
            $this->load->view('AR/inc/footer');
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
                $this->form_validation->set_rules('AR_Title', 'الإسم بالعربي', 'trim|required');
                $this->form_validation->set_rules('EN_Title', 'الإسم بالإنجليزي', 'trim|required');
                $this->form_validation->set_rules('Phone', 'رقم الهاتف', 'trim|required|numeric');
                $this->form_validation->set_rules('Manager', 'المدير', 'trim|required|min_length[2]|max_length[20]');
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
                                title: 'تمت التعديل',
                                text: 'تم التعديل بنجاح',
                                icon: 'success',
                                confirmButtonColor: '#5b8ce8',
                            });
                            setTimeout(function() {
                                location.href = "<?php echo base_url(); ?>AR/Company";
                            }, 800)
                        </script>
                    <?php
                    } else {
                        echo "آسف لدينا مشكلة";
                    }
                } else {
                    echo validation_errors();
                }
            } else {
                echo "لاتوجد معلومات  !";
            }
        }
    }

    public function Add_UserType()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Add an Usertype ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Company/addUsertype');
        $this->load->view('AR/inc/footer');
    }


    public function All_Tests_Today()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Company/All_Tests_Today');
        $this->load->view('AR/inc/footer');
    }

    public function Attendance_Report()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Attendance Report ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Company/Attendance_Report');
        $this->load->view('AR/inc/footer');
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
            redirect("AR/Users/");
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
        concat(l2_co_patient.F_name_AR , ' ',l2_co_patient.M_name_AR , ' ' , l2_co_patient.L_name_AR) AS P_name ,
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

        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Company/Lab_Reports');
        $this->load->view('AR/inc/footer');
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
        $our_depts = $this->db->query("SELECT Id , Dept_Name_AR FROM `l1_co_department` 
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

        $data['results'] = $this->db->query("SELECT o.`EN_Title`,cd.`Dept_Name_AR`, ra.`Description` AS machene , ra.Id AS machineId 
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
            $selects = $this->db->query("SELECT o.`EN_Title`,cd.`Dept_Name_AR`, ra.`Description` AS machene , ra.Id AS machineId ,rrld.`mUtcTime`,rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
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

        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Company/refrigeratorsReports');
        $this->load->view('AR/inc/footer');
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
        $data['page_title'] = "Qlick Health | Message";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Component/Message');
        $this->load->view('AR/inc/footer');
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
                $this->load->view('AR/inc/header', $data);
                return $this->load->view('AR/Company/Empty-systeme');
            }
            // sql
            $data['avalaible_surveys'] = $this->sv_company_reports->avalaible_surveys();
            // exit();
            $data['our_surveys'] = $this->sv_company_reports->our_published_surveys($sessiondata['admin_id']);
            $data['expired_surveys'] = $this->sv_company_reports->our_surveys($sessiondata['admin_id'], true);
            $data['completed_surveys'] = $this->sv_company_reports->completed_surveys();
            $data['used_categorys'] = $this->sv_company_reports->usedcategorys();
            $data['surveys_for_males'] = $this->sv_company_reports->surveys_by_gender('1');
            $data['surveys_for_females'] = $this->sv_company_reports->surveys_by_gender('2');
            $data['types'] = $this->sv_company_reports->counter_of_completed_surveys_by_types();
            $data['ages_with_groups'] = $this->sv_company_reports->ages_for_all_passed_users($sessiondata['admin_id'], true);
            $data['supported_types'] = $this->sv_company_reports->supported_types();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Company/Wellness');
            $this->load->view('AR/inc/footer');
        } else {
            $dataDes['to'] = "AR/Company";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
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
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Company/use_this_survey', $list);
                $this->load->view('AR/inc/footer');
            } else {
                return redirect("AR/Company/wellness");
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
            $links[] = array('name' => "الرفاهية", "link" => base_url('AR/Company/ClimateSurveys'), "desc" => "", "icon" => "sport2.png");

            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Climate Links List";
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Global/Links/Lists', $data);
            $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
        } else {
            $dataDes['to'] = "AR/Company";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
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
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Company/ClimateSurveys');
                $this->load->view('AR/inc/footer');
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
            $dataDes['to'] = "AR/Company";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
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
                    $this->load->view('AR/inc/header', $data);
                    $this->load->view('AR/Company/climatePreview');
                    $this->load->view('AR/inc/footer');
                }
            }
        } else {
            $dataDes['to'] = "AR/Company";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
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
                        $this->load->view('AR/inc/header', $data);
                        $this->load->view('AR/Company/newclimatesurvey');
                        $this->load->view('AR/inc/footer');
                    } else {
                        echo "No data found !!";
                        return redirect("AR/Company/ClimateSurveys");
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
            $dataDes['to'] = "AR/Company";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
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
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Company/ClimateReports');
                $this->load->view('AR/inc/footer');
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
                redirect('AR/Company/Consultants'); // go back to the links page
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
                'name' => "CONSULTANT MANAGEMENT", "link" => base_url('AR/Company/Consultants/Managment'),
                "desc" => "", "icon" => "DTemperature.png"
            );
            $links[] = array(
                'name' => "CONSULTANT REPORTS", "link" => base_url('AR/Company/Consultants/Reports'),
                "desc" => "", "icon" => "DTemperature.png"
            );
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Consultants ";
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Global/Links/Lists', $data);
            $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
        }
    }

    private function ConsultantReports() // private
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
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
            $this->load->view('AR/Component/Consultant/list', $body);
        }
        $this->load->view('AR/inc/footer');
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
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Component/Consultant/Managment', $data);
                $this->load->view('AR/inc/footer');
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
                return redirect('AR/Company/Consultant');
            }
            $body['target'] = $Consultantdata->UploadedBy;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Component/Consultant/chat', $body);
        } else {
            redirect("AR/Consultants/Reports");
        }
    }
}
