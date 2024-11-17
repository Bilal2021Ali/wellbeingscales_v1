<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Company_Departments extends CI_Controller
{
    public $permissions_array = array();
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $method = $_SERVER['REQUEST_METHOD'];
        $this->permissions_array["apicopy"] = $this->permissions->apicopy();
        if (isset($sessiondata)) {
            $this->lang->load('form_validation_lang', 'arabic');
            if ($sessiondata['level'] == 2 && $sessiondata['type'] == "department_Company") {
            } else if ($sessiondata['type'] == "Dept_Perm" && $method == "POST") {
            } else {
                redirect('AR/users');
                exit();
            }
            $this->permissions_array["apicopy"] = $this->permissions->apicopy();
        } else {
            redirect('AR/users');
            exit();
        }
    }

    private function apicopy()
    {
        // $Api_db = $this->load->database('Api_db', TRUE);
        $url = 'https://qlickhealth.com/admin/api/QA/services/copyTrackUsers';
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function Add_Position()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add New Position ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/add_position');
        $this->load->view('AR/inc/footer');
    }
    public function startAddNewPosition()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('UserType_En') && $this->input->post('code')) {
            $this->form_validation->set_rules('UserType_En', 'نوع المستخدم بالإنجليزي', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('UserType_Ar', 'نوع المستخدم بالعربي', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('code', 'Code', 'trim|required|exact_length[9]');
            if ($this->form_validation->run()) {
                $UserType_Ar = $this->input->post('UserType_Ar');
                $UserType_En = $this->input->post('UserType_En');
                $code = $this->input->post('code');
                $corrent = $this->db->query("SELECT * FROM  `r_usertype` WHERE `UserType` = '" . $UserType_En . "' 
			    OR `Code` = '" . $code . "' ")->result_array();
                if (empty($corrent)) {
                    if ($this->db->query("INSERT INTO `r_usertype`(`UserType`, `AR_UserType`, `Code` , `Created`)
			        VALUES ('" . $UserType_En . "','" . $UserType_Ar . "' , '" . $code . "' ,'" . date('Y-m-d') . "')")) { ?>
                        <script>
                            Swal.fire({
                                title: 'تمت العملية',
                                text: ' تمت الإضافة بنجاح ',
                                icon: 'success'
                            });
                        </script>
                    <?php
                    } else {
                    ?>
                        <script>
                            Swal.fire({
                                title: ' مشكلة ',
                                text: 'نعتذر لدينا مشكلة حاليا الرجاء المحاولة لاحقا',
                                icon: 'error'
                            });
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'مشكلة',
                            text: 'هذا النوع من المستخدمين مدخل من قبل',
                            icon: 'error'
                        });
                    </script>
                <?php
                }
            } else { ?>
                <script>
                    Swal.fire({
                        title: 'تحذير ',
                        text: 'لقد أدخلت معلومات خاطئة الرجاء التحقق من المشكلة وإعادة المحاولة',
                        icon: 'warning'
                    });
                    location.reload();
                </script>
            <?php }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'نعتذر',
                    text: 'الرجاء إدخال معلومات ',
                    icon: 'error'
                });
            </script>
        <?php
        }
    }
    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('encrypt_url');
        $this->load->model('departments/sv_reports');
        if (!empty($sessiondata)) {
            $data['page_title'] = "Qlick Health | Dashboard ";
            $data['sessiondata'] = $sessiondata;
            $data['NORMAL'] = $this->GetTotalIn_all(36.3, 37.5);
            // Low Temp Counter
            $data['LOW'] = $this->GetTotalIn_all(0, 36.2);
            $data['LOW_In_Home'] = $this->GetTotalIn(0, 36.2, 'Home');
            $data['LOW_In_Quern'] = $this->GetTotalIn(0, 36.2, 'Quarantine');
            $data['LOW_In_School'] = $this->GetTotalIn(0, 36.2, 'work');
            $data['HIGH'] = $this->GetTotalIn_all(38.5, 45);
            $data['HIGH_In_Home'] = $this->GetTotalIn(38.5, 45, 'Home');
            $data['HIGH_In_Quern'] = $this->GetTotalIn(38.5, 45, 'Quarantine');
            $data['HIGH_In_School'] = $this->GetTotalIn(38.5, 45, 'work');
            $data['MODERATE'] = $this->GetTotalIn_all(37.6, 38.4);
            $data['Emp_Tests'] = $this->Temp_GetTotal_Not();
            $data['climate_survyes'] = $this->sv_reports->GetClimatesurveys();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/dash');
            $this->load->view('AR/inc/footer');
        } else {
            redirect('users');
        }
    }
    //links routs
    public function Adding_routes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $links  = array();
        $links[] = array('name' => "اضف جهاز", "link" => base_url('AR/Company_Departments/AddDevice'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "إضافة مستخدم", "link" => base_url('AR/Company_Departments/AddMembers'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "إضافة نوع مستخدم", "link" => base_url('AR/Company_Departments/Add_Position'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $permission_visitors = $this->db->query(" SELECT `v0_permissions`.`visitors` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`visitors` = '1' ")->result_array();
        if (!empty($permission_visitors)) {
            $links[] = array('name' => "الزوار العموميين", "link" => base_url('AR/Company_Departments/Public_Visitors'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        }
        $links[] = array('name' => "الزوار", "link" => base_url('AR/Company_Departments/Visitors'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "الثلاجات", "link" => base_url('AR/Company_Departments/Refrigeraters'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Global/Links/Lists', $data);
        $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
    }
    public function lists_routes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $links  = array();
        $links[] = array('name' => "LIST OF USERS ", "link" => base_url('AR/Company_Departments/ListOfPatients'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "LIST OF SITES", "link" => base_url('AR/Company_Departments/listOfSites'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "LIST OF MEMBER TYPES", "link" => base_url('AR/Company_Departments/MembersList'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Global/Links/Lists', $data);
        $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
    }
    public function reports_routes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $links  = array();
        $links[] = array('name' => "تقرير الحضور", "link" => base_url('AR/Company_Departments/Attendance_Report'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "التقرير حسب التاريخ", "link" => base_url('AR/Company_Departments/monthResults'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => " تقرير الحضور حسب التاريخ ", "link" => base_url('AR/Company_Departments/attendance_result'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "تقرير الحضور حسب التاريخ للجميع", "link" => base_url('AR/Company_Departments/attendance_result_for_all'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "تقرير المواقع", "link" => base_url('AR/Company_Departments/sites_reports'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "تقرير المختبرات ", "link" => base_url('AR/Company_Departments/Lab_Reports'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => " رحلات الثلاجات", "link" => base_url('AR/Company_Departments/refrigerators'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array(
            'name' => "لوحة معلومات ", "link" => base_url('AR/Company-Departments/climate-dashboard'),
            "desc" => "", "icon" => "AttendenceByDataPerUser.png");

        $permission_depts = $this->db->query("SELECT DISTINCT(v0_schools_results_permissions.by_school) , 
        `l1_school`.`School_Name_EN`
        FROM `v0_schools_results_permissions` 
        JOIN l1_school ON `v0_schools_results_permissions`.`to_school` = '" . $sessiondata['admin_id'] . "' AND l1_school.Id = v0_schools_results_permissions.by_school
        AND v0_schools_results_permissions.list = 1  ")->result_array();
        if (!empty($permission_depts)) {
            $links[] = array('name' => "المختبرات المدرسية", "link" => base_url('AR/Company_Departments/schools_Lab_Reports'),"desc" => "", "icon" => "AttendenceByDataPerUser.png");
        }
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Global/Links/Lists', $data);
        $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
    }
    public function monitors_routes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $links  = array();
        $links[] = array('name' => "البيئة", "link" => base_url('AR/Company_Departments/MacheneRP'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "الحجر الصحي", "link" => base_url('AR/Company_Departments/Quarantine_monitor'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "الحجر المنزلي", "link" => base_url('AR/Company_Departments/StayHome_monitor'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "التقرير اليومي", "link" => base_url('AR/Company_Departments/Daily_monitor'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "سمارت باس", "link" => base_url('AR/Company_Departments/smart_pass_monitor'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array('name' => "الزائرون حسب الجهاز", "link" => base_url('AR/Company_Departments/Visitors'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $links[] = array(
            'name' => "EMPLOYEE CARDS", "link" => base_url('AR/Company_Departments/employeescards'),
            "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        $permission_visitors = $this->db->query(" SELECT `v0_permissions`.`visitors` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`visitors` = '1' ")->result_array();
        if (!empty($permission_visitors)) {
            $links[] = array('name' => "مراقبة الزوار", "link" => base_url('AR/Company_Departments/visitor_report'), "desc" => "", "icon" => "AttendenceByDataPerUser.png");
        }
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Global/Links/Lists', $data);
        $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
    }
    private function GetTotalIn($from, $To, $In)
    {
        $counter = 0;
        //$this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();
        $Ourstaffs = $this->db->query("SELECT Id,UserType FROM l2_co_patient
		 WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = '" . $In . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            //$staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
            $ID = $staff['Id'];
            $type = $staff['UserType'];
            $getResults = $this->db->query("SELECT * FROM l2_co_monthly_result WHERE `UserId` = '" . $staff['Id'] . "'
		 AND Created = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            if (!empty($getResults)) {
                foreach ($getResults as $results) {
                    if ($results['Result'] > $from && $results['Result'] < $To) {
                        $counter++;
                    }
                }
            }
        }
        //echo $counter;
        return ($counter);
    }
    private function GetTotalIn_all($from, $To)
    {
        /*$from = 37.6;
		 $To = 40.1;
		 $In = 'School';*/
        $counter = 0;
        //$this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();
        $Ourstaffs = $this->db->query("SELECT Id,UserType FROM
		 l2_co_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        foreach ($Ourstaffs as $staff) {
            // $staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
            $ID = $staff['Id'];
            $type = $staff['UserType'];
            $getResults = $this->db->query("SELECT * FROM l2_co_monthly_result WHERE `UserId` = '" . $staff['Id'] . "'
		 AND Created = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            // AND `Result` > ".$from." AND `Result` < ".$To."	 
            if (!empty($getResults)) {
                foreach ($getResults as $results) {
                    if ($results['Result'] > $from && $results['Result'] < $To) {
                        $counter++;
                    }
                }
            }
        }
        //echo $counter;
        return ($counter);
    }
    private function GetTotal($where, $type, $action = "")
    {
        $counter = 0;
        //$this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();
        $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];
            $type = $staff['UserType'];
            if (!empty($action)) {
                $getResults = $this->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $staff['Id'] . "'
	AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
	AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            foreach ($getResults as $results) {
                $counter++;
            }
        }
        return ($counter);
    }
    private function Temp_GetTotal_Not($action = "")
    {
        $counter = 0;
        //$this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();
        $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            $ID = $staff['Id'];
            $type = $staff['UserType'];
            if (!empty($action)) {
                $getResults = $this->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staff['Id'] . "'
	AND Created = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults_staff = $this->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staff['Id'] . "'
	AND Created = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResults_staff)) {
                $counter++;
            }
        }
        return ($counter);
    }
    public function AddMembers()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $data['sites'] = $this->db->query("SELECT * FROM `l2_co_site` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/AddMembers');
        $this->load->view('AR/inc/footer');
    }
    public function MembersList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Members List ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Avatars');
        $this->load->view('AR/inc/footer');
    }
    public function ChangeAvatarList()
    {
        if ($this->input->post('usertype')) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> الإسم </th>
                        <th> الرقم الوطني </th>
                        <th> الجنسية </th>
                        <th> الإجراءات </th>
                    </tr>
                </thead>
                <?php
                ///// this is the new page
                $type =  $this->input->post('usertype');
                $users = $this->db->query(" SELECT * FROM `l2_co_patient` WHERE `UserType` = '" . $type . "' 
		AND `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                if (!empty($users)) {
                    foreach ($users as $admin) {
                ?>
                        <tr>
                            <td>
                                <?php
                                $avatar = $this->db->query(" SELECT concat('" . base_url() . "uploads/co_avatars/',l2_co_avatars.Link) as Link
			FROM l2_co_avatars WHERE `For_User` = '" . $admin['Id'] . "' AND Type_Of_User = '" . $admin['UserType'] . "'  ")->result_array();
                                if (!empty($avatar)) {
                                ?>
                                    <img src="<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle">
                                <?php } else { ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo $admin['F_name_EN'] . '+' . $admin['L_name_EN'] ?>&background=random" class="avatar-xs rounded-circle">
                                <?php } ?>
                            </td>
                            <td><?php echo $admin['F_name_AR'] . ' ' . $admin['L_name_AR']; ?></td>
                            <td><?php echo $admin['National_Id']; ?></td>
                            <td><?php echo $admin['Nationality']; ?></td>
                            <td>
                                <a href="<?php echo base_url() ?>AR/Company_Departments/ChangeMemberAvatar/<?php echo $type ?>/<?php echo $admin['Id']; ?>/<?php
                                                                                                                                                                        echo $admin['National_Id']; ?>">
                                    <i class="uil uil-user" style="font-size: 25px;" title="Edit"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } ?>
                </tbody>
            </table>
            <script>
                $("table").DataTable();
            </script>
            <?php } else {
            echo "Please Choose User Type !!";
        }
    }
    public function Lab_Tests()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Tests";
        $devices_counter = $this->db->query("SELECT * FROM  `l2_co_devices`
        WHERE `Added_by` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        $data['supported_departments'] = $this->db->query("SELECT DISTINCT(v0_departments_results_permissions.by_dept) , 
        `l1_co_department`.`Dept_Name_EN`
        FROM `v0_departments_results_permissions` 
        JOIN l1_co_department ON `v0_departments_results_permissions`.`to_dept` = '" . $sessiondata['admin_id'] . "' AND l1_co_department.Id = v0_departments_results_permissions.by_dept
        AND v0_departments_results_permissions.adding = 1  ")->result_array();
        $data['sessiondata'] = $sessiondata;
        $data['permission_depts'] = $this->db->query("SELECT DISTINCT(v0_schools_results_permissions.by_school) , 
        `l1_school`.`School_Name_EN`
        FROM `v0_schools_results_permissions` 
        JOIN l1_school ON `v0_schools_results_permissions`.`to_school` = '" . $sessiondata['admin_id'] . "' AND l1_school.Id = v0_schools_results_permissions.by_school
        AND v0_schools_results_permissions.adding = 1  ")->result_array();
        if ($devices_counter !== 0) {
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/Test_lab');
            $this->load->view('AR/inc/footer');
        } else {
            $data['hasntnav'] = true;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Global/NoDecvices');
            $this->load->view('AR/inc/footer');
        }
    }
    public function User_permissions()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | صلاحيات المستخدم";
        $data['sessiondata'] = $sessiondata;
        $user_id = 0;
        $valid = false;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $user_id = $this->uri->segment(4);
            $userchecking = $this->db->get_where('l2_co_patient', array('Id' => $user_id, 'Added_By' => $sessiondata['admin_id']))->result_array();
            if (!empty($userchecking)) {
                $valid = true;
            }
        }
        if ($valid) {
            $data['user_data'] = $userchecking;
            $data['user_id']   = $user_id;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/user_permition');
            $this->load->view('AR/inc/footer');
        } else {
            redirect('AR/Company_Departments/ListOfPatients');
        }
    }
    public function ChangeMemberAvatar()
    {
        if ($this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(6)) {
            $userType = $this->uri->segment(4);
            $UserId = $this->uri->segment(5);
            $nationalid = $this->uri->segment(6);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $Body['user_type'] = $userType;
            $Body['user_id'] = $UserId;
            $Body['nationalid'] = $nationalid;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/ChangePhotoForMember', $Body);
            $this->load->view('AR/inc/footer');
        } else {
            redirect("AR/Company_Departments/MembersList");
        }
    }

    public function AddDevice()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Device ";
        $data['sessiondata'] = $sessiondata;
        $data['devices_types'] = $this->db->get("r_device_type")->result_array();
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && !empty($this->db->get_where("l2_co_devices", ["Added_By" => $sessiondata['admin_id'], "UserType" => 'school', "Id" => $this->uri->segment(4)])->result_array())) {
            $data['device_data'] = $this->db->get_where("l2_co_devices", ["Added_By" => $sessiondata['admin_id'], "UserType" => 'school', "Id" => $this->uri->segment(4)])->result_array()[0] ?? array();
            $data['vehicles'] =  $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
            LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
            WHERE `l2_vehicle`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND NOT EXISTS (SELECT Id FROM `l2_co_devices` WHERE car_id = `l2_vehicle`.`Id` AND `l2_co_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "' AND `l2_co_devices`.`Id` != '" . $this->uri->segment(4) . "' ) ")->result_array();
        } else {
            $data['vehicles'] =  $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
            LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
            WHERE `l2_vehicle`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND NOT EXISTS (SELECT Id FROM `l2_co_devices` WHERE car_id = `l2_vehicle`.`Id` AND `l2_co_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "')   ")->result_array();
            $data["device"]['D_Id'] = 0;
        }
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/AddDevice');
        $this->load->view('AR/inc/footer');
    }

    public function Profile()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | school Profile";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Profiles/department_Co_Profile');
        $this->load->view('AR/inc/footer');
    }

    public function Public_Visitors()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $prms = $this->db->query(" SELECT `v0_permissions`.`visitors` , `v0_permissions`.`Created`
          FROM `l1_co_department` 
          JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
          JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
          AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
          WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms)) {
            $permission = $prms[0];
        } else {
            $permission = "";
        }
        $data['visitors'] = $this->db->query(" SELECT 
        `l2_visitors`.`Id` AS user_id,
        `l2_visitors`.`F_name_EN` AS full_name,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`Added_By` AS Added_By,
        `l2_visitors`.`watch_mac` AS watch_mac,
        `l2_visitors`.`machine_mac` AS machine_mac
        FROM `l2_visitors` ")->result_array();
        if (!empty($permission) && $permission['visitors'] == '1') {
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/Public_Visitors');
            $this->load->view('AR/inc/footer');
        } else {
            $dataDes['to'] = "AR/Company_Departments";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        }
    }
    public function Visitors()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $data['visitors'] = $this->db->query(" SELECT 
        `l2_visitors`.`Id` AS user_id,
        `l2_visitors`.`F_name_EN` AS full_name,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`Added_By` AS Added_By,
        `l2_visitors`.`watch_mac` AS watch_mac,
        `l2_visitors`.`machine_mac` AS machine_mac
        FROM `l2_visitors` 
        JOIN `l2_co_devices` ON `l2_co_devices`.`D_Id` = `l2_visitors`.`machine_mac`
        AND `l2_co_devices`.`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Department_comp/Visitors');
        $this->load->view('EN/inc/footer');
    }
    // public function visitor_report()
    // {
    //     $this->load->library('session');
    //     $sessiondata = $this->session->userdata('admin_details');
    //     $data['page_title'] = "Qlick Health | Add Members";
    //     $data['sessiondata'] = $sessiondata;
    //     $data['visitors_results'] = $this->db->query(" SELECT * ,
    //     `l2_visitors_result`.`TimeStamp` AS result_time
    //     FROM `l2_visitors` 
    //     RIGHT JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` ")->result_array();
    //     $data['start'] = date('Y-m-d');
    //     $data['end'] = date('Y-m-d');
    //     $this->load->view('AR/inc/header', $data);
    //     $this->load->view('AR/Department_comp/visitors_reports');
    //     $this->load->view('AR/inc/footer');
    // }
    public function visitor_report()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $this->load->library('pagination');
        $config['base_url'] = base_url("AR/Company-Departments/visitor-report");
        $config['total_rows'] =  $this->db->query(" SELECT * ,
        `l2_visitors_result`.`TimeStamp` AS result_time
        FROM `l2_visitors` 
        RIGHT JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` ")->num_rows();
        $config['per_page'] = 15;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination navigation mt-2" style="justify-content: center;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item page-link">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item page-link">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item page-link">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item page-link">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="bg-primary active text-white page-item page-link"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item page-link">';
        $config['num_tag_close'] = '</li>';
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $data['visitors_results'] = $this->db->query(" SELECT * ,
        `l2_visitors_result`.`TimeStamp` AS result_time
        FROM `l2_visitors` 
        RIGHT JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` 
        LIMIT $page," . $config['per_page'] . " ")->result_array();
        $data['start'] = date('Y-m-d');
        $data['end'] = date('Y-m-d');
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/visitors_reports');
        $this->load->view('AR/inc/footer');
    }

    public function smart_pass_monitor()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $data['today'] = date("Y-m-d");
            $data['start'] = $data['today'];
            $data['end'] = $data['today'];
            $data['visitors_results'] = $this->db->query(" SELECT * ,
            `l2_visitors_result`.`TimeStamp` AS result_time
            FROM `l2_visitors` 
            JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` 
            JOIN `l2_co_devices`  ON `l2_visitors_result`.`Device` = `l2_co_devices`.`D_Id` AND `l2_co_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "'
            WHERE `l2_visitors_result`.`Added_By` = 'SmartPass' AND `l2_visitors_result`.`Created` = '" . $data['today'] . "'
            ORDER BY `l2_visitors_result`.`TimeStamp` DESC ")->result_array();
        } elseif ($this->input->method() == "post" && $this->input->post("start") && $this->input->post("end")) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start', 'start date', 'trim|required');
            $this->form_validation->set_rules('end', 'end date', 'trim|required');
            if ($this->form_validation->run()) {
                $data['start'] = $this->input->post("start");
                $data['end'] = $this->input->post("end");
                $data['visitors_results'] = $this->db->query(" SELECT * ,
                `l2_visitors_result`.`TimeStamp` AS result_time
                FROM `l2_visitors` 
                JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` 
                JOIN `l2_co_devices`  ON `l2_visitors_result`.`Device` = `l2_co_devices`.`D_Id` AND `l2_co_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "'
                WHERE `l2_visitors_result`.`Added_By` = 'SmartPass' AND `l2_visitors_result`.`Created` >= '" . $data['start'] . "' AND `l2_visitors_result`.`Created` <= '" . $data['end'] . "'
                ORDER BY `l2_visitors_result`.`TimeStamp` DESC ")->result_array();
            } else {
                $data['error'] = "Please set start and end date !!";
                $data['today'] = date("Y-m-d");
                $data['visitors_results'] = $this->db->query(" SELECT * ,
                `l2_visitors_result`.`TimeStamp` AS result_time
                FROM `l2_visitors` 
                JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` 
                JOIN `l2_co_devices`  ON `l2_visitors_result`.`Device` = `l2_co_devices`.`D_Id` AND `l2_co_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "'
                WHERE `l2_visitors_result`.`Added_By` = 'SmartPass' AND `l2_visitors_result`.`Created` = '" . $data['today'] . "'
                ORDER BY `l2_visitors_result`.`TimeStamp` DESC ")->result_array();
            }
        }
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/visitors_reports');
        $this->load->view('AR/inc/footer');
    }
    public function Refrigeraters()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $data['Refrigeraters'] = $this->db->query(" SELECT * FROM `refrigerator_visitor` ")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Refrigeraters');
        $this->load->view('AR/inc/footer');
    }
    public function add_visitor()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            $valid = false;
            $exist = false;
            $data['user_data'] = $this->db->query(" SELECT 
            `Id` AS user_id,
            `F_name_EN` AS full_name,
            `National_Id` AS National_Id,
            `Added_By` AS Added_By,
            `watch_mac` AS watch_mac,
            `machine_mac` AS machine_mac,
            `phone`,
            `DOP`
            FROM `l2_visitors` WHERE `Id` = '" . $id . "' ")->result_array();
            if (!empty($data['user_data'])) {
                $valid = true;
                //dd-m-yyyy
                $data['dop'] = date("d-m-Y", strtotime($data['user_data'][0]['DOP']));
            }
        }
        if ($valid) {
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Department_comp/add_Visitor');
            $this->load->view('EN/inc/footer');
        } else {
            redirect('EN/Company_Departments/Visitors');
        }
    }
    public function update_visitor()
    { // this function creted for cobtroling not added visitors -- link from visitor_report -- for all
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            $data['page_title'] = "Qlick Health | update data ";
            $data['sessiondata'] = $sessiondata;
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $id = $this->uri->segment(4);
                $valid = false;
                $exist = false;
                $data['user_data'] = $this->db->query(" SELECT 
                    `Id` AS user_id,
                    `F_name_EN` AS full_name,
                    `National_Id` AS National_Id,
                    `Added_By` AS Added_By,
                    `watch_mac` AS watch_mac,
                    `machine_mac` AS machine_mac,
                    `phone`,
                    `DOP`
                    FROM `l2_visitors` WHERE `Id` = '" . $id . "' ")->result_array();
                if (!empty($data['user_data'])) {
                    $valid = true;
                    $data['dop'] = date("d-m-Y", strtotime($data['user_data'][0]['DOP']));
                }
            }
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/update_visitor');
            $this->load->view('AR/inc/footer');
        } elseif ($this->input->method() == "post") {
            $this->load->library('form_validation');
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            if ($this->input->get('visitor_key')) {
                $is_req = "trim|required|is_unique[v_nationalids.National_Id]";
                $request_type = "update";
                $user_id = $this->input->get('visitor_key');
            } else {
                $is_req = "trim|is_unique[v_nationalids.National_Id]|is_unique[l2_visitors.National_Id]";
                $request_type = "add";
            }
            $this->form_validation->set_rules('Name', 'Name', $is_req);
            $this->form_validation->set_rules('National_Id', 'National_Id', $is_req);
            $this->form_validation->set_rules('DOP', 'DOP', $is_req);
            if ($this->form_validation->run()) {
                $name = empty($this->input->post('Name')) ? "" : $this->input->post('Name');
                $National_Id = empty($this->input->post('National_Id')) ? "" : $this->input->post('National_Id');
                $DOP = empty($this->input->post('DOP')) ? "" : $this->input->post('DOP');
                if ($request_type == "add") {
                    $isert_data = array(
                        "F_name_EN"   => $name,
                        "National_Id" => $National_Id,
                        "DOP"         => $DOP,
                    );
                    if ($this->db->insert('l2_visitors', $isert_data)) {
                        echo "ok";
                    }
                } else {
                    $this->db->set('F_name_EN', $name);
                    $this->db->set('National_Id', $National_Id);
                    $this->db->set('DOP', $DOP);
                    $this->db->where('Id', $user_id);
                    if ($this->db->update('l2_visitors')) {
                        echo "ok";
                    }
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function add_refrigerater()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            $valid = false;
            $exist = false;
            $data['refrigerater_data'] = $this->db->query(" SELECT * FROM `refrigerator_visitor` WHERE `Id` = '" . $id . "' ")->result_array();
            if (!empty($data['refrigerater_data'])) {
                $valid = true;
            }
        }
        if ($valid) {
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/add_refrigerater');
            $this->load->view('AR/inc/footer');
        } else {
            redirect('AR/Company_Departments/Refrigeraters');
        }
    }

    public function ListOfPatients()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List Of Patients ";
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query(" SELECT * , `l2_co_patient`.`Id` as User_Id
        FROM l2_co_patient
        LEFT JOIN `l2_co_avatars`
        ON `l2_co_patient`.`Id` =  `l2_co_avatars`.`For_User` AND `l2_co_avatars`.`Type_Of_User` = `l2_co_patient`.`UserType`
        JOIN `r_usertype`  ON `r_usertype`.`Id` = `l2_co_patient`.`UserType`
        WHERE l2_co_patient.Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/List_patient');
        $this->load->view('AR/inc/footer');
    }
    public function UpdatePatientData()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(4);
        $iscorrect = $this->db->query("SELECT * FROM l2_co_patient WHERE Id =  '" . $SUFFID . "'
        AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Staff Data ";
            $data['sessiondata'] = $sessiondata;
            $data['StaffData'] = $this->db->query("SELECT *, `l2_co_patient`.`Id` AS Id, r_usertype.Id as currentType ,
            `r_usertype`.`AR_UserType` as CurrentTrans_UserType ,`r_positions`.`AR_Position` as CurrentTrans_Position
            FROM l2_co_patient
            JOIN `r_usertype`  ON `r_usertype`.`Id` = `l2_co_patient`.`UserType`
            LEFT JOIN `r_positions` ON `r_positions`.`Position` = `l2_co_patient`.`Position`
            WHERE `l2_co_patient`.`Id`  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/Update_patient');
            $this->load->view('AR/inc/footer');
        } else {
            redirect('AR/Company_Departments');
        }
    }
    public function listOfSites()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List Of Sites ";
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query("SELECT * FROM `l2_co_site`
        WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/List_sites');
        $this->load->view('AR/inc/footer');
    }
    public function UpdateSite()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(4);
        $iscorrect = $this->db->query("SELECT * FROM l2_co_site WHERE Id =  '" . $SUFFID . "'
          AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Site Data ";
            $data['sessiondata'] = $sessiondata;
            $data['sitesdata'] = $this->db->query("SELECT * FROM l2_co_site WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/Update_site');
            $this->load->view('AR/inc/footer');
        } else {
            redirect('schools');
        }
    }
    public function UpdatePatient()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English     
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic     
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Position', 'Position', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                //    AR inputs
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                //style="padding: 10px;background: #f3f8fb;"    
                $DOP = $this->input->post('DOP');
                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $ID = $this->input->post('ID');
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    if ($this->db->query("UPDATE `l2_co_patient` SET UserType = '" . $Prefix . "' , 
                    F_name_EN = '" . $First_Name_EN . "' , M_name_EN = '" . $Middle_Name_EN . "' , L_name_EN = '" . $Last_Name_EN . "' ,
                    F_name_AR = '" . $First_Name_AR . "' , M_name_AR = '" . $Middle_Name_AR . "' , L_name_AR = '" . $Last_Name_AR . "' ,
                    DOP = '" . $DOP . "' , Phone = '" . $Phone . "' , Gender = '" . $Gender . "' ,
                    Nationality = '" . $Nationality . "' , Email = '" . $Email . "' , `Position` = '" . $Position . "' WHERE Id = '" . $ID . "' ")) {
                        echo "The Data Is Inserted.";
                        $this->apicopy();
            ?>
                        <script>
                            Swal.fire({
                                title: 'أحسنت!',
                                text: 'تم إدخال البيانات بنجاح',
                                icon: 'success'
                            });
                            setTimeout(function() {
                                location.href = "<?php echo base_url(); ?>AR/Company_Departments/ListOfPatients"
                            }, 1000);
                        </script>
                    <?php
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
        }
    }
    ///// ajax start
    public function startAddpatient()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Prefix')) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English     
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic     
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR ', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR ', 'trim|required');
            $this->form_validation->set_rules('DOP', 'date of birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('N_Id', ' national id ', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Position', 'Position', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                //    AR inputs
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                $DOP = $this->input->post('DOP');
                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $National_Id = $this->input->post('N_Id');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $password =  "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
                    if ($iscrrent == 0) {
                        $addme = "";
                        if (isset($sessiondata['Patient_ID'])) {
                            $addme = $sessiondata['Patient_ID'];
                        }
                        $gen = md5($National_Id);
                        //
                        if (isset($_GET['type'])) {
                            $machene = $this->input->post("machene");
                        } else {
                            $machene = "";
                        }
                        $data = [
                            "UserType"     => $Prefix,
                            "UserTypecode" => $Prefix,
                            "F_name_EN"    => $First_Name_EN,
                            "M_name_EN"    => $Middle_Name_EN,
                            "L_name_En"    => $Last_Name_EN,
                            "F_name_AR"    => $First_Name_AR,
                            "M_name_AR"    => $Middle_Name_AR,
                            "L_name_AR"    => $Last_Name_AR,
                            "DOP"          => $DOP,
                            "Phone"        => $Phone,
                            "Gender"       => $Gender,
                            "National_Id"  => $National_Id,
                            "Nationality"  => $Nationality,
                            "Position"     => $Position,
                            "Email"        => $Email,
                            "UserName"     => $National_Id,
                            "watch_mac"    => $machene,
                            "Added_By"     => $sessiondata['admin_id'],
                            "generation"   => $gen,
                        ];
                        if ($this->db->insert("l2_co_temp_patient", $data)) {
                            $id = $this->db->insert_id();
                            // $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From`  ,`Created` , `generation` )
                            // VALUES ('" . $National_Id . "','Staff','" . date('Y-m-d') . "'  , '" . $gen . "')");
                            // $this->db->query("INSERT INTO  `v_login` ( `Username`, `Password`, `Type` ,`Created` , `generation`)
                            // VALUES ('" . $National_Id . "','" . $hash_pass . "','Co_Employee','" . date('Y-m-d') . "' , '" . $gen . "' )");
                            $company_data = $this->db->get_where('l1_co_department', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                            if ($this->permissions_array["apicopy"]) {
                                // $post = [
                                //     "email"         => $Email,
                                //     "phone"         => $Phone,
                                //     "password"      => "25d55ad283aa400af464c76d713c07ad",
                                //     "hash"          => '9b8619251a19057cff70779273e95aa6',
                                //     "is_verified"   => '1',
                                //     "reg_id"        => $id,
                                //     "device_type"   => "IOS",
                                //     "language"      => "English",
                                //     "latitude"      => "0.1",
                                //     "longitude"     => "0.1",
                                //     "device_type"   => "iso",
                                //     "city_id"       => "789",
                                //     "country_id"    => "143",
                                //     "companyName"   => $company_data['Dept_Name_EN'] ?? "",
                                //     "nationalId"    => $National_Id,
                                //     "username"      => $First_Name_EN . " " . $Middle_Name_EN . " " . $Last_Name_EN,
                                //     "gender"        => ($Gender == "M" ? "Male" : "Female"),
                                //     "date_of_birth" => date('Y-m-d', strtotime($DOP)),
                                //     "watch_mac"     => $this->input->post('mac_address') ?? "Bind Watch",
                                //     "usertype"      => "Patient",
                                //     "companytype"   => "co_company",
                                //     "companyid"     => $sessiondata['admin_id'],
                                //     'uid'           => 'user1',
                                //     'login_type'    => 'normal',
                                //     'created'       => date('Y-m-d H:i:s'),
                                // ];
                                $this->apicopy();
                                // if () {
                                //     $this->response->json(["status" => "ok"]);
                                // } else {
                                //     $this->response->json(["status" => "error", "message" => "we have unexpected error in copying data !"]);
                                // }
                                $this->response->json(["status" => "ok"]);
                            } else {
                                $this->response->json(["status" => "ok"]);
                            }
                            // echo " Successfully completed ";
                            // echo "<script>Swal.fire({title: 'done',text: 'The information has been stored successfully',icon: 'success'});</script>";
                            if (isset($_GET['type']) && isset($_GET['v_id'])) {
                                $this->db->delete('l2_visitors', array('id' => $_GET['v_id']));
                            }
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
                            //$link = base_url()."AR/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                            $messg = '<center>
                            <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
                            <h2> Hi there <h2> 
                            <h3>Your User name is : ' . $National_Id . ' </h3>
                            <h3>Your password is : ' . $password . ' </h3>
                            <a href=""' . base_url() . '"AR/Users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
                            </center>';
                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
                            $this->email->bcc('emails@qlicksystems.com');
                            $this->email->to($Email);
                            $this->email->subject(' department User - You User Name And Password ');
                            $this->email->message($messg);
                            if (!$this->email->send()) {
                                // echo ' We have a problem in sending email, username is : ' . $National_Id . ' ; The password is : ' . $password . ' ';
                            } else {
                                // echo "<script>Swal.fire({title: ' added ',text: 'An email has been sent with the information',icon: 'success'});</script>";
                                // echo "<script>
                                //     //location.href = '" . base_url() . "AR/Company_Departments/AddMembers';
                                // </script>
                                // ";
                            }
                        }
                    } else {
                        echo " This National Identification Number already exists ";
                    }
                } else {
                    echo " Please correct the upload date ";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function startAddTeacher()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English     
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic     
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('N_Id', 'National Id', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Position', 'Position', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            //$this->form_validation->set_rules( 'Classes', 'Classes', 'trim|required' );
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                //    AR inputs
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                $DOP = $this->input->post('DOP');
                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $National_Id = $this->input->post('N_Id');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $clases = $this->input->post('Classes');
                $i = 0;
                $recent = array();
                $data = array();
                $classesnum = $this->db->query("SELECT * FROM `r_levels` ")->num_rows();
                $Val = '';
                for ($i = 0; $i <= $classesnum; $i++) {
                    if (isset($clases[$i])) {
                        $Val = $Val . $i . ';';
                    }
                }
                $password =  "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
                    if ($iscrrent == 0) {
                        if ($this->db->query("INSERT INTO 
          `l2_teacher` ( `Prefix`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Position`,`Email`,
          `Password`,`UserName`, `Classes` , `Created`)
          VALUES ('" . $Prefix . "',
          '" . $First_Name_EN . "', '" . $Middle_Name_EN . "', '" . $Last_Name_EN . "', 
          '" . $First_Name_AR . "', '" . $Middle_Name_AR . "', '" . $Last_Name_AR . "', 
          '" . $DOP . "', '" . $Phone . "', '" . $Gender . "', '" . $National_Id . "', '" . $Nationality . "','" . $Position . "',
          '" . $Email . "','" . $hash_pass . "','" . $National_Id . "', '" . $Val . "', '" . date('Y-m-d') . "');")) {
                            //                     $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
                            //   VALUES ('" . $National_Id . "','Teacher','" . date('Y-m-d') . "')");
                            echo "The Data Is Inserted.";
                            echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";
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
          <h3>Your User name is : ' . $National_Id . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://qlicksystems.com/education/AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';
                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
                            $this->email->to($Email);
                            $this->email->subject(' You User Name And Password ');
                            $this->email->message($messg);
                            if (!$this->email->send()) {
                                echo $this->email->print_debugger();
                                echo 'We have an error in sending the email . Please try again later.';
                            } else {
                                echo "<script>Swal.fire({title: 'Success!',text: 'a Email Was Sended To The Email you Entred !',icon: 'success'});</script>";
                                echo "
          <script>
          location.href = '" . base_url() . "AR/Departments/AddMembers';
          </script>
          ";
                            }
                        }
                    } else {
                        echo "الرقم الوطني موجود مسبقا.";
                    }
                } else {
                    echo "الرجاء إدخال تاريخ الميلاد بشكل صحيح";
                }
            } else {
                echo validation_errors();
            }
        }
    }
    public function ListofDevices()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List of Staff ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadevices'] = $this->db->query("SELECT * FROM 
          l2_devices WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND `UserType` = 'Dept' ")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/List_Devices');
        $this->load->view('AR/inc/footer');
    }
    public function DeletDevice()
    {
        $id = $this->input->post('Conid');
        if ($this->db->query(" DELETE FROM l2_devices WHERE Id = '" . $id . "'  ")) {
            echo "تم حذف الجهاز";
        } else {
            echo "عفوا لدينا خطأ. الرجاء المحاولة مرة أخرى لاحقا";
        }
    }

    public function startUpdatingdepartment()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Dept_Name_AR')) {
            $this->form_validation->set_rules('Dept_Name_AR', 'Arabic Name', 'trim|required');
            $this->form_validation->set_rules('Dept_Name_EN', 'English Name', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Name In Arabic', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager Name In English', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('city', 'Username', 'trim|required');
            $this->form_validation->set_rules('Type', 'Type', 'trim|required');
            $this->form_validation->set_rules('DepartmentId', 'رمز تعريف الفرع', 'trim|required|min_length[3]|max_length[30]');

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Dept_Name_AR');
                $English_Title = $this->input->post('Dept_Name_EN');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $Type = $this->input->post('Type');
                $data = [
                    'Dept_Name_AR' =>  $Arabic_Title,
                    'Dept_Name_EN' =>  $English_Title,
                    'Citys'        =>  $this->input->post('city'),
                    'Country'      =>  $this->input->post('Country'),
                    'Manager_EN'   =>  $Manager_EN,
                    'Manager_AR'   =>  $Manager_AR,
                    'Email'        =>  $Email,
                    'Phone'        =>  $Phone,
                    'Type_Of_Dept' =>  $Type,
                    'DepartmentId' =>  $this->input->post('DepartmentId'),
                ];
                if ($this->db->where('Id', $sessiondata['admin_id'])->set($data)->update('l1_co_department')) { ?>
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'The data is updated successfully.',
                            icon: 'success'
                        });
                        setTimeout(function() {
                            location.href = "<?php echo base_url(); ?>AR/Company_Departments";
                        }, 1500);
                    </script>
            <?php
                }
            } else {
                echo validation_errors();
            }
        }
    }
    public function AddClasses()
    {
        /////// adding classes
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $clases = $this->input->post('Classes');
        $isExist = $this->db->query("SELECT * FROM l2_grades WHERE Id = '" . $sessiondata['admin_id'] . "'")->result_array();
        $i = 0;
        $recent = array();
        $data = array();
        $classesnum = $this->db->query("SELECT * FROM `r_levels` ")->num_rows();
        $Val = '';
        for ($i = 0; $i <= $classesnum; $i++) {
            if (isset($clases[$i])) {
                $data["`" . $i . "`"] = '1';
                $Val = $Val . $i . ';';
            } else {
                $data["`" . $i . "`"] = '0';
            }
        }
        echo $Val;
        if (empty($isExist)) {
            $data['id'] = $sessiondata['admin_id'];
            $this->db->insert('l2_grades', $data);
            $this->db->query("INSERT INTO `v_schoolgrades` 
               (`S_id`, `Levels`, `Created`) VALUES ('" . $sessiondata['admin_id'] . "', '" . $Val . "', '" . date('Y-m-d') . "');");
            echo "The data was inserted successfully.";
            echo "<script>
               Swal.fire({title: 'Success!',text: 'The data is inserted successfully.',icon: 'success'});
               location.reload();     
               </script>";
        } else {
            $this->db->query("UPDATE  `v_schoolgrades` SET `Levels` = '" . $Val . "' , `Created` = '" . date('Y-m-d') . "' WHERE 
               `S_id` = '" . $sessiondata['admin_id'] . "' ");
            echo "The data was updated successfully.";
            echo "<script>
               Swal.fire({title: 'Success!',text: 'The data is updated successfully.',icon: 'success'});
               location.reload();     
               </script>";
            $this->db->set($data);
            $this->db->where('id', $sessiondata['admin_id']);
            $this->db->update('l2_grades');
        }
    }
    public function startAddDevice()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $School_Id = $sessiondata['admin_id'];
        $this->load->library('form_validation');
        $Device_Id = $this->input->post('Device_Id');
        $this->form_validation->set_rules('Device_Id', 'Device MAC', 'trim|required');
        $this->form_validation->set_rules('Comments', 'Comments', 'trim|required');
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Site_ar', 'Site AR', 'trim|required');
        $this->form_validation->set_rules('Description_ar', 'Description AR', 'trim|required');
        $this->form_validation->set_rules('car_id', 'The car', 'trim|required|numeric');
        $this->form_validation->set_rules('device_type', 'device type', 'trim|required|numeric');
        if ($this->form_validation->run()) {
            // $this->response->dd($this->input->post());
            if ($this->input->post('Device_Id')) {
                $pattern = "/@/";
                $is_has_aroabas = preg_match($pattern, $Device_Id);
                if ($is_has_aroabas) {
                    echo "<script>
                    Swal.fire({title: 'Error!',text: 'You Cant Enter \"@\" In The device Name',icon: 'error'});
                    </script>";
                } else {
                    $Site = $this->input->post('Site');
                    $Description = $this->input->post('Description');
                    $comments = $this->input->post("Comments");
                    if ($this->input->post("device_id") !== "0") {
                        $conter = 0;
                    } else {
                        $conter = $this->db->query("SELECT * FROM `l2_co_devices` WHERE D_Id = '" . $Device_Id . "'  ")->num_rows();
                    }
                    if ($conter == 0) {
                        $data = [
                            "D_Id" => $Device_Id,
                            "Added_by" => $School_Id,
                            "Comments" => $comments,
                            "Created" => date('Y-m-d'),
                            "UserType" => 'school',
                            "Site" => $Site,
                            "Description" => $Description,
                            "Site_ar" => $this->input->post("Site_ar"),
                            "Description_ar" => $this->input->post("Description_ar"),
                            "device_type" => $this->input->post("device_type"),
                            "car_id" => ($this->input->post("car_id") ?? 0)
                        ];
                        if ($this->input->post("device_id") !== "0") {
                            $this->db->set($data);
                            $this->db->where('Id', $this->input->post("device_id"));
                            $this->db->update('l2_co_devices');
                        } else {
                            $this->db->insert("l2_co_devices", $data);
                        }
                        echo "<script>Swal.fire({title: 'Success!',text: 'The device is " . ($this->input->post("device_id") !== 0 ? "updated" : "inserted") . " successfully.',icon: 'success'});location.href =  '" . base_url("AR/Company_Departments/AddDevice") . "';</script>";
                    } else {
                        echo "<script>Swal.fire({title: 'Error!',text: 'This Device Id is Already Exist !!',icon: 'error'});</script>";
                    }
                }
            }
        } else {
            $text = validation_errors();
            $f_text = str_replace("<p>", " ", $text);
            $l_text = str_replace("</p>", "\n", $f_text);
            ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: `<?php echo $l_text; ?>`,
                    icon: 'error',
                });
            </script>
            <?php
        }
    }
    public function startAddBatch()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Batch')) {
            $Batch = $this->input->post('Batch');
            $ForDevice = $this->input->post("ForDevice");
            $conter = $this->db->query("SELECT * FROM `l2_batches` WHERE Batch_Id = '" . $Batch . "'")->num_rows();
            if ($conter == 0) {
                $this->db->query("INSERT INTO 
          `l2_batches` ( `Batch_Id`, `For_Device`,`Created`)
          VALUES ('" . $Batch . "', '" . $ForDevice . "', '" . date('Y-m-d') . "')");
                echo "<script>
               Swal.fire({title: 'Success!',text: 'The Batch is Added successfully.',icon: 'success'});
               location.reload();     
               </script>";
            } else {
                echo "<script>
               Swal.fire({title: 'Error!',text: 'This Batch Id is Already Exist !!',icon: 'error'});
               </script>";
            }
        } else {
            echo "<script>
               Swal.fire({title: 'Error!',text: 'Please Enter Valid Batch',icon: 'error'});
               </script>";
        }
    }
    public function startAddSite()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Site', 'الموقع', 'trim|required');
        $this->form_validation->set_rules('Description', 'الوصف', 'trim|required');
        $this->form_validation->set_rules('Site_for', 'site type', 'trim|required');
        if ($this->form_validation->run()) {
            $addme = "";
            if (isset($sessiondata['Patient_ID'])) {
                $addme = $sessiondata['Patient_ID'];
            }
            $gen = rand(10000, 100000) . time();
            $Site = $this->input->post("Site");
            $Description = $this->input->post("Description");
            $Site_for = $this->input->post("Site_for");
            if ($this->db->query("INSERT INTO 
            `l2_co_site` (`Site_Code`, `Description`, `Added_By` , `Add_Me` , `Site_for` , `Created` , `generation`) 
            VALUES ('" . $Site . "', '" . $Description . "', '" . $sessiondata['admin_id'] . "' , '" . $addme . "' ,  '" . $Site_for . "' ,  '" . date('Y-m-d') . "' , '" . $gen . "')")) { ?>
                <script>
                    Swal.fire({
                        title: 'تمت الإضافة',
                        text: 'تمت الإضافة بنجاح',
                        icon: 'success'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 900);
                </script>
                <?php
            }
        } else {
            echo validation_errors();
        }
    }
    public function startAddMachine()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('name', 'mac adress', 'trim|required|is_unique[refrigerator_area.mac_adress]');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('Site', 'site', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post("name");
            $type = $this->input->post("type");
            $Site = $this->input->post("Site");
            $description = $this->input->post("description");
            $pid = $sessiondata['admin_id'];
            $generatecode = $this->generatecode($sessiondata['admin_id'], "");
            if (filter_var($name, FILTER_VALIDATE_MAC)) {
                $data = [
                    'mac_adress' => $name,
                    'type' => $type,
                    'source_id' => $pid,
                    'generation' => $generatecode,
                    'Site_Id' => $Site,
                    'user_type' => 'company_department',
                    'Description' =>  $description,
                    'Company_Type' => 3,
                ];
                if ($this->db->insert("refrigerator_area", $data)) { ?>
                    <script>
                        Swal.fire({
                            title: 'Added ',
                            text: 'The data was added successfully.',
                            icon: 'success'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 900);
                    </script>
                <?php
                }
                if ($this->input->get("type") && $this->input->get("v_id")) {
                    $id = $this->input->get("v_id");
                    $this->db->delete('refrigerator_visitor', array('Id' => $id));
                }
            } else {
                echo "Please enter Valid Mac Address";
            }
        } else {
            echo validation_errors();
        }
    }
    public function startAddArea()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('MAC', 'MAC Address', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        if ($this->form_validation->run()) {
            $Site = $this->input->post("Site");
            $MAC = $this->input->post("MAC");
            $Description = $this->input->post("Description");
            $generatecode = $sessiondata['admin_id'] . $MAC . rand(1000, 9999);
            $this->db->select('*');
            $this->db->from('air_areas');
            $this->db->where('mac_adress', $MAC); // Produces: WHERE name = 'Joe'
            $mac_counter = $this->db->get()->num_rows();
            if ($mac_counter <= 0) {
                $data = [
                    'source_id'    => $sessiondata['admin_id'],
                    'mac_adress'   => $MAC,
                    'user_type'    => 'Company_Department',
                    'Site_Id'      => $Site,
                    'Description'  => $Description,
                    'generation'   => $generatecode,
                    'Company_Type' => '2',
                ];
                if ($this->db->insert('air_areas', $data)) {
                ?>
                    <script>
                        Swal.fire({
                            title: ' Added  ',
                            text: 'Added successfully',
                            icon: 'success'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 900);
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    Swal.fire({
                        title: ' Problem  ',
                        text: 'This MAC Address Already exist',
                        icon: 'warning'
                    });
                    $('#MAC').val('');
                </script>
            <?php
            }
        } else {
            echo validation_errors();
        }
    }
    public function StartUpdateSite()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        if ($this->form_validation->run()) {
            $Description = $this->input->post("Description");
            $ID = $this->input->post("AZF_UFGFDX");
            if ($this->db->query("UPDATE `l2_co_site` SET `Description` = '" . $Description . "' WHERE `Id` = $ID ")) { ?>
                <script>
                    Swal.fire({
                        title: 'تم التحديث',
                        text: 'تم التحديث بنجاح ',
                        icon: 'success'
                    });
                    setTimeout(function() {
                        location.href = "<?php echo base_url(); ?>AR/Company_Departments/listOfSites";
                    }, 1000);
                </script>
            <?php
            } else {
                echo "error";
            }
        } else {
            echo validation_errors();
        }
    }
    private function generatecode($sessiondata, $n_id)
    {
        $parent = $this->db->query("SELECT Added_By FROM `l1_co_department` 
		WHERE Id = '" . $sessiondata . "' ORDER BY `Id` DESC")->result_array();
        $parentId =  str_pad($parent[0]['Added_By'], 4, '0', STR_PAD_LEFT);
        $s_id = str_pad($sessiondata, 4, '0', STR_PAD_LEFT);
        $genrationcode = $parentId . $s_id . $n_id;
        return ($genrationcode);
    }
    public function startAddPermition()
    {
        $this->load->library('form_validation');
        if ($this->input->post('selectedPerm')) {
            $this->form_validation->set_rules('selectedPerm', 'User', 'trim|required');
            if ($this->form_validation->run()) {
                $Id = $this->input->post('selectedPerm');
                /* $ex_permition = explode(';',$selectedPerm);
           $Id = $ex_permition[0];     
           $Type = $ex_permition[1]; */
                $this->db->query("UPDATE `l2_patient` SET Perm = 1 WHERE Id = '" . $Id . "'");
                echo "The permission was added.";
                echo "<script>
          Swal.fire({
          title: 'Success!',
          text: 'The permission was added.',
          icon: 'success'
          });
          </script>";  ?>
                <script>
                    location.href = "<?php echo base_url();  ?>AR/Department_comp";
                </script>
            <?php
            } else {
                echo validation_errors();
            }
        } else {
            echo "Please Select A Staff or Teacher !!";
        }
    }
    public function DeletPermition()
    {
        if ($this->input->post("Conid") && $this->input->post("TypeOfuser")) {
            $ID =  $this->input->post("Conid");
            $this->db->query("UPDATE `l2_patient` SET PermSchool = 0 WHERE Id = '" . $ID . "' ");
            echo "تم إزالة الإذن !!";
        }
    }
    // ajax end tests start
    public function tests()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Enter Results ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Test');
        $this->load->view('AR/inc/footer');
    }
    public function ChartTempOfUsers()
    {
        $UserType = $this->input->post("UserType");
        if ($UserType !== "") {
            $UserType = $this->input->post("UserType");
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            ?>
            <div id="hereGetedStudents">
                <?php
                $today = date("Y-m-d");
                $counter = 0;
                $Ourstaffs1 = $this->db->query("SELECT * FROM l2_co_patient WHERE 
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `UserType` = '" . $UserType . "'  ")->result_array();
                foreach ($Ourstaffs1 as $staffs) {
                    $resultsIntable = $this->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staffs['Id'] . "' AND UserType = '" . $UserType . "'
AND Created = '" . $today . "' ORDER BY `Id` DESC LIMIT 1")->num_rows();
                    if ($resultsIntable == 0) {
                        $counter++;
                    }
                }
                ?>
                <h4 class="card-title mb-4">مجموع المستخدمين بدون فحوصات <a href=""> <?php echo $counter; ?></a></h4>
                <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
            </div>
            <?php
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
AND `UserType` = '" . $UserType . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
                $getResults = $this->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $UserType . "'
ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffname, "Result" => $results['Result']);
                }
            }
            ?>
            <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
            <!-- apexcharts init -->
            <script>
                var options = {
                        chart: {
                            height: 300,
                            type: "line",
                            zoom: {
                                enabled: !1
                            },
                            toolbar: {
                                show: !1
                            }
                        },
                        colors: ["#5b73e8"],
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            width: [3, 3],
                            curve: "straight"
                        },
                        series: [{
                            name: "درجات الحرارة",
                            // here data
                            data: [<?php foreach ($list as $finalresults) {
                                        echo $finalresults['Result'] . ',';
                                    } ?>]
                        }],
                        title: {
                            text: "درجات الحرارة",
                            align: "left"
                        },
                        grid: {
                            row: {
                                colors: ["transparent", "transparent"],
                                opacity: .2
                            },
                            borderColor: "#f1f1f1"
                        },
                        markers: {
                            style: "inverted",
                            size: 6
                        },
                        xaxis: {
                            categories: [<?php foreach ($list as $names) {
                                                echo '"' . $names['Username'] . '",';
                                            } ?>],
                            title: {
                                text: "الأسماء"
                            }
                        },
                        yaxis: {
                            title: {
                                text: "درجات الحرارة"
                            },
                            min: 30,
                            max: 40
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "right",
                            floating: !0,
                            offsetY: -25,
                            offsetX: -5
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: {
                                    toolbar: {
                                        show: !1
                                    }
                                },
                                legend: {
                                    show: !1
                                }
                            }
                        }]
                    },
                    chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options);
                chart.render();
            </script>
        <?php } else {
            echo "<h4>اختر نوع المستخدم</h4>";
        }
    }
    public function All_Tests_Today()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/All_Tests_Today');
        $this->load->view('AR/inc/footer');
    }
    public function Quarantine_monitor()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Quarantine Monitor";
        $data['sessiondata'] = $sessiondata;
        $data['action'] = "Quarantine";
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Quarantine_monitor');
        $this->load->view('AR/inc/footer');
    }
    public function StayHome_monitor()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Quarantine Monitor";
        $data['sessiondata'] = $sessiondata;
        $data['action'] = "Home";
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Quarantine_monitor');
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
        $this->load->view('AR/Department_comp/Attendance_Report');
        $this->load->view('AR/inc/footer');
    }
    public function ApplyActionOnMember()
    {
        $Id = $this->input->post("S_Id");
        $Action = $this->input->post("Action");
        $UserType = $this->input->post("UserType");
        if ($this->db->query("UPDATE `l2_co_result` SET `Action` = '" . $Action . "' WHERE `UserType` = '" . $UserType . "'  AND UserId = '" . $Id . "' ")) {
            echo " تمت العملية بنجاح";
            $this->db->query("UPDATE `l2_co_patient` SET `Action` = '" . $Action . "' WHERE Id = '" . $Id . "' ")
        ?>
            <script>
                Swal.fire({
                    title: ' يفضل تحديث الصفحة الأن ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `حسنا , حدث`,
                    cancelButtonText: `لاحقا`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    title: 'نعتذر لدينا مشاكل حاليا ',
                    showDenyButton: true,
                    confirmButtonText: `حسنا`,
                    icon: 'error',
                })
            </script>
        <?php
        }
    }
    public function ApplyLabActionOnMember_lab()
    {
        $Id = $this->input->post("S_Id");
        $Action = $this->input->post("Action");
        $UserType = $this->input->post("UserType");
        if ($this->db->query("UPDATE `l2_co_labtests` SET `Action` = '" . $Action . "' WHERE 
		 `UserType` = '" . $UserType . "'  AND UserId = '" . $Id . "' ")) {
            $this->db->query("UPDATE `l2_co_patient` SET `Action` = '" . $Action . "' WHERE Id = '" . $Id . "' ")
        ?>
            <script>
                Swal.fire({
                    title: ' يفضل تحديث الصفحة الأن ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `حسنا , حدث`,
                    cancelButtonText: `لاحقا`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    title: 'نعتذر لدينا مشاكل حاليا ',
                    showDenyButton: true,
                    confirmButtonText: `حسنا`,
                    icon: 'error',
                })
            </script>
        <?php
        }
    }
    public function MacheneRP()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        //to_dept
        $data['datas'] = $this->db->query(" SELECT 
		`refrigerator_result_daily`.`TimeStamp` AS Result_date ,
		`refrigerator_result_daily`.`Result` AS Temp ,
		`refrigerator_result_daily`.`Humidity` AS Humidity ,
		`refrigerator_result_daily`.`user_type` AS user_type_daily ,
		`refrigerator_area`.`mac_adress` as device_mac , 
		`refrigerator_area`.`Description` as device_Description, 
		`refrigerator_levels`.`device_name` as device_name, 
		`refrigerator_levels`.`min_temp` AS min , `refrigerator_levels`.`max_temp` AS max ,
		CONCAT(`refrigerator_levels`.`min_temp`,' / ' , `refrigerator_levels`.`max_temp`) as device_type
		FROM refrigerator_result_daily
		JOIN `refrigerator_area` ON `refrigerator_result_daily`.`Machine_Id` = `refrigerator_area`.`Id`
		JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type`
		WHERE `refrigerator_area`.`source_id` = '" . $sessiondata['admin_id'] . "'
		AND `refrigerator_area`.`user_type` = 'company_department'
        AND `refrigerator_result_daily`.`user_type` = 'company_department' ")->result_array();
        $data['acceses'] = $this->db->query(" SELECT 
        `refrigerator_result_daily`.`TimeStamp` AS Result_date ,
        `refrigerator_result_daily`.`Result` AS Temp ,
        `refrigerator_result_daily`.`Humidity` AS Humidity ,
		`refrigerator_result_daily`.`user_type` AS user_type ,
        `refrigerator_area`.`mac_adress` as device_mac , 
        `refrigerator_area`.`Description` as device_Description, 
        `refrigerator_levels`.`device_name` as device_name, 
        `refrigerator_levels`.`min_temp` AS min , `refrigerator_levels`.`max_temp` AS max ,
        CONCAT(`l1_co_department`.`Dept_Name_EN`,' / ' , `l0_organization`.`EN_Title`)  AS by_parents ,
        CONCAT(`refrigerator_levels`.`min_temp`,' / ' , `refrigerator_levels`.`max_temp`) as device_type
        FROM refrigerator_result_daily
        JOIN `refrigerator_area` ON `refrigerator_result_daily`.`Machine_Id` = `refrigerator_area`.`Id`
        JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type`
        JOIN `v0_area_depts_devices_permissions` ON `v0_area_depts_devices_permissions`.`to_dept` = '" . $sessiondata['admin_id'] . "'
        JOIN `l1_co_department` ON `v0_area_depts_devices_permissions`.`by_dept` = `l1_co_department`.`Id` 
        JOIN `l0_organization` ON `l0_organization`.`Id` = `l1_co_department`.`Added_By` 
        WHERE `refrigerator_area`.`source_id` = '" . $sessiondata['admin_id'] . "'
        AND `refrigerator_result_daily`.`user_type` = 'company_department' ")->result_array();
        // echo $this->db->last_query();
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/macheneRP');
        $this->load->view('AR/inc/footer');
    }
    public function DeleteUser()
    {
        if ($this->input->post("userid") && $this->input->post("user_type") && $this->input->post("national_id")) {
            $user_id = $this->input->post("userid");
            $National_id = $this->input->post("national_id");
            $user_type = $this->input->post("user_type");
            $this->db->where('Id', $user_id);
            $this->db->delete('l2_co_patient');
            $this->db->query("DELETE FROM `v_nationalids` WHERE `National_Id` = '" . $National_id . "' ");
            $this->db->query("DELETE FROM `v_login` WHERE `Username` = '" . $National_id . "' AND `Type` = '" . $user_type . "' ");
            echo " تم حذف المستخدم بنجاح  ";
        } else {
            echo "error";
        }
    }
    public function monthResults()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Month Results";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/monthResults');
        $this->load->view('AR/inc/footer');
    }
    public function attendance_result()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Month Results";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Attendance_Report_in_out');
        $this->load->view('AR/inc/footer');
    }
    public function attendance_result_for_all()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Month Results";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Attendance_Report_in_out_for_all');
        $this->load->view('AR/inc/footer');
    }
    public function sites_reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Sites Results";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/sites_reports');
        $this->load->view('AR/inc/footer');
    }
    public function LoadFromCsv()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Load From CSV";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Load_From_CSV');
        $this->load->view('AR/inc/footer');
    }
    public function Daily_monitor()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Daily monitor";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Daily_monitor');
        $this->load->view('AR/inc/footer');
    }
    public function uploadUsersCsv()
    {
        $name = date("Y-M-D") . "_" . time();
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFileStaff')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            echo $this->addcsvUser($name);
        ?>
            <script>
                $('#Staff').html('');
            </script>
            <?php
        }
    }
    private function addcsvUser($name)
    {
        $filename = './uploads/Csv/' . $name['file_name'];
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        // The nested array to hold all the arrays
        $the_big_array = [];
        $users = array();
        // Open the file for reading
        if (($h = fopen("{$filename}", "r")) !== FALSE) {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                // Each individual array is being pushed into the nested array
                $the_big_array[] = $data;
            }
            // Close the file
            fclose($h);
        }
        //var_dump($);
        $s_ar = sizeof($the_big_array[0]);
        $counter = 0;
        $all = sizeof($the_big_array) - 1;
        if ($s_ar == 14 && strtolower($the_big_array[0][0]) == "user type") {
            unset($the_big_array[0]);
            foreach ($the_big_array as $array) {
                //print_r($array);
                $counter++;
                //	echo $array[5];
            ?>
                <script>
                    $('#exportinSatff').html('<?php echo " إنتظر من فضلك جاري تصدير  :" . $array[2] . "   - " . $all; ?>');
                    $('.Staffprogress').attr('style', 'width: <?php echo $this->get_percentage($all, $counter); ?>%');
                </script>
                <?php if ($all == $counter) { ?>
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: ' تمت الإضافة بنجاح ',
                            icon: 'success'
                        });
                        setTimeout(function() {
                            $('.Staffprogress').addClass('bg-success');
                            SetTheTable();
                        }, 900);
                    </script>
                <?php
                    if (unlink('./uploads/Csv/' . $name['file_name'])) {
                        //// later 
                    }
                }
                ?>
            <?php
                $ad_id = $sessiondata['admin_id'];
                $password =  "12345678";
                $genration = $this->generatecode($sessiondata['admin_id'], $array[10]);
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                // start add the 
                $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $array[10] . "'")->num_rows();
                if ($iscrrent == 0) {
                    if (strtolower($array[9]) == "M") {
                        $gender = 0;
                    } else {
                        $gender = 1;
                    }
                    $created = date("Y-m-d H:i:s");
                    $dop = date("d-m-Y", strtotime($array[6]));
                    $data = [
                        'UserType'    => $array[0],
                        'Added_By'    => $sessiondata['admin_id'],
                        'F_name_EN'   => $array[1],
                        'F_name_AR'   => $array[4],
                        'M_name_EN'   => $array[2],
                        'M_name_AR'   => $array[5],
                        'L_name_AR'   => $array[6],
                        'L_name_EN'   => $array[3],
                        'DOP'         => $dop,
                        'Phone'          => $array[8],
                        'Gender'      => $gender,
                        'National_id' => $array[10],
                        'UserName'    => $array[10],
                        'Nationality' => $array[11],
                        'Position'       => $array[12],
                        'Email'       => $array[13],
                        'Password'       => $hash_pass,
                        'generation'  => $genration,
                        'Created'     => $created,
                    ];
                    if ($this->db->insert('l2_co_patient', $data)) {
                        $national = [
                            'National_Id' => $array[10],
                            'Geted_From'  => 'Co_Employee',
                            'generation'  => $genration,
                        ];
                        // $this->db->insert('v_nationalids', $national);
                        $login = [
                            'Username'    => $array[10],
                            'Password'    => $hash_pass,
                            'Type'        => 'Co_Employee',
                            'generation'  => $genration,
                        ];
                        // $this->db->insert('v_login', $login);
                        $users[] = array("Username" => $array[10], "Password" => $password);
                    }
                }
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: " مشكلة  ",
                    text: 'هذا ليس ملف csv للموظفين <?php echo $s_ar . " ----- - - - 1" . strtolower($the_big_array[0][0])  ?> ',
                    icon: 'warning',
                    confirmButtonColor: '#007E15'
                });
            </script>
            <div class="col-lg-12">
                <button class="btn btn-primary btn-lg btn-block waves-effect waves-light mt-2" onClick="location.reload();">
                    أعد المحاولة
                </button>
            </div>
        <?php
        }
        ?>
        <script>
            function SetTheTable() {
                $('.Staffprogress').slideUp();
                swal.close();
                $('.staffUpload').html(`
         <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
		<table id="Users_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
			<thead>
			<tr>
				<th>Name</th>
				<th>Password</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user) { ?>
			<tr>
				<td><?php echo $user['Username']; ?></td>
				<td><?php echo $user['Password'] ?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
			</div>
			`);
                var table_st = $('#Users_table').DataTable({
                    lengthChange: false,
                    buttons: ['excel', 'pdf']
                });
                table_st.buttons().container().appendTo('#Users_table_wrapper .col-md-6:eq(0)');
            }
        </script>
        <?php
    }
    private function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round($number / ($total / 100), 2);
        } else {
            return 0;
        }
    }
    public function sync()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->model('Test_db2');
        $error = 0;
        $all = 0;
        $success = 0;
        $allavatars_staff = $this->db->query(" SELECT Id,National_Id,UserType FROM l2_co_patient 
	WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $all += sizeof($allavatars_staff);
        foreach ($allavatars_staff as $avatar_staff) {
            $type = $avatar_staff['UserType'];
            if ($this->Test_db2->sync_avatars_co($avatar_staff['National_Id'], $type, $avatar_staff['Id']) == "Error") {
                $error++;
            } else {
                $success++;
            }
        }
        echo "إنتهت العملية , تم نقل $success من أصل $all";
    }
    public function Air_Quality_Dashboard()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Air Quality Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $prms = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
	  FROM `l1_co_department` 
	  JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
	  JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
	  AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
	  WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms)) {
            $permission = $prms[0];
        } else {
            $permission = "";
        }
        if (!empty($permission) && $permission['Air_quality'] == '1') {
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/air_quality');
            $this->load->view('AR/inc/footer');
        } else {
            $dataDes['to'] = "AR/Company_Departments";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        }
    }

public function Realtime_Dashboard()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | More Details ";
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4)) {
            $device_mac = $this->uri->segment(4);
            $data['device_mac'] = $device_mac;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/Realtime_Dashboard');
            $this->load->view('AR/inc/footer');
        } else {
            $this->load->view('custom404view');
        }
    }
    public function Refrigerator()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | More Details ";
        $data['sessiondata'] = $sessiondata;
        $device_mac = $this->uri->segment(4);
        $data['device_mac'] = $device_mac;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Refrigerator');
        $this->load->view('AR/inc/footer');
    }
    public function Permissions_user_edit()
    {
        if ($this->input->post('permType') && $this->input->post("User")) {
            $permType = $this->input->post('permType');
            $id = $this->input->post("User");
            if ($this->db->query("UPDATE `l2_co_patient` SET `$permType` = IF($permType=1, 0, 1) WHERE `Id` = '" . $id . "' ")) {
                echo "ok";
            }
            //SET status = IF(status=1, 0, 1) 
        }
    }
    public function Lab_Reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Report ";
        $data['sessiondata'] = $sessiondata;
        $data['tests'] = $this->db->get('r_testcode')->result_array();
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
        foreach ($data['selected_tests'] as $key => $test) {
            $Acceptedtests[] = '"' . $test . '"';
        }
        $ids = array();
        $ids[] = $sessiondata['admin_id'];
        $permission_depts = $this->db->query("SELECT DISTINCT(v0_departments_results_permissions.by_dept) , 
        `l1_co_department`.`Dept_Name_EN`
        FROM `v0_departments_results_permissions` 
        JOIN l1_co_department ON `v0_departments_results_permissions`.`to_dept` = '" . $sessiondata['admin_id'] . "' AND l1_co_department.Id = v0_departments_results_permissions.by_dept
        AND v0_departments_results_permissions.list = 1  ")->result_array();
        foreach ($permission_depts as $id) {
            $ids[] = $id['by_dept'];
        }
        $data['userData'] = $this->db->get_where("l1_co_department", ["Id" => $sessiondata['admin_id']])->result_array()[0] ?? array();
        if (empty($data['userData'])) {
            session_destroy();
            redirect("AR/users/");
        }
        $data['Results'] = $this->db->query(" SELECT 
        l1_co_department.Dept_Name_AR AS H_name ,
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
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/Lab_Reports');
        $this->load->view('AR/inc/footer');
    }
    public function schools_Lab_Reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Report ";
        $data['sessiondata'] = $sessiondata;
        $data['tests'] = $this->db->get('r_testcode')->result_array();
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
        $ids = array();
        $permission_depts = $this->db->query("SELECT DISTINCT(v0_schools_results_permissions.by_school) , 
        `l1_school`.`School_Name_EN`
        FROM `v0_schools_results_permissions` 
        JOIN l1_school ON `v0_schools_results_permissions`.`to_school` = '" . $sessiondata['admin_id'] . "' AND l1_school.Id = v0_schools_results_permissions.by_school
        AND v0_schools_results_permissions.list = 1  ")->result_array();
        foreach ($permission_depts as $id) {
            $ids[] = $id['by_school'];
        }
        if (empty($ids)) {
            $dataDes['to'] = "AR/Company_Departments";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        } else {
            $data['students'] = $this->db->query(" SELECT 
            l1_school.School_Name_EN AS H_name ,
            concat(l2_student.F_name_EN , ' ',l2_student.M_name_EN , ' ' , l2_student.L_name_EN) AS P_name ,
            '--' AS HIC_num ,
            l2_student.National_Id AS QID ,
            l2_student.DOP , l2_student.Nationality ,
            l2_labtests.TimeStamp AS Test_Date ,
            l2_labtests.Test_Description AS Test_Type ,
            IF(l2_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
            IF(l2_student.Gender = 1 , 'Male' , 'Female') AS Gender
            FROM l2_labtests 
            JOIN l2_student ON l2_student.Id = l2_labtests.UserId AND l2_labtests.UserType = 'Student'
            JOIN l1_school ON l2_student.Added_By = l1_school.Id
            WHERE l1_school.Id IN (" . implode(',', $ids) . ")
            AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
            AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();
            $data['teachers'] = $this->db->query(" SELECT 
            l1_school.School_Name_EN AS H_name ,
            concat(	l2_teacher.F_name_EN , ' ',	l2_teacher.M_name_EN , ' ' , l2_teacher.L_name_EN) AS P_name ,
            '--' AS HIC_num ,
            l2_teacher.National_Id AS QID ,
            l2_teacher.DOP , l2_teacher.Nationality ,
            l2_labtests.TimeStamp AS Test_Date ,
            l2_labtests.Test_Description AS Test_Type ,
            IF(l2_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
            IF(	l2_teacher.Gender = 1 , 'Male' , 'Female') AS Gender
            FROM l2_labtests 
            JOIN l2_teacher ON l2_teacher.Id = l2_labtests.UserId AND l2_labtests.UserType = 'Teacher'
            JOIN l1_school ON l2_teacher.Added_By = l1_school.Id
            WHERE l1_school.Id IN (" . implode(',', $ids) . ")
            AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
            AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();
            $data['staff'] = $this->db->query(" SELECT 
            l1_school.School_Name_EN AS H_name ,
            concat(	l2_staff.F_name_EN , ' ',	l2_staff.M_name_EN , ' ' , 	l2_staff.L_name_EN) AS P_name ,
            '--' AS HIC_num ,
            l2_staff.National_Id AS QID ,
            l2_staff.DOP , l2_staff.Nationality ,
            l2_labtests.TimeStamp AS Test_Date ,
            l2_labtests.Test_Description AS Test_Type ,
            IF(l2_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
            IF(	l2_staff.Gender = 1 , 'Male' , 'Female') AS Gender
            FROM l2_labtests 
            JOIN l2_staff ON l2_staff.Id = l2_labtests.UserId AND l2_labtests.UserType = 'Staff'
            JOIN l1_school ON l2_staff.Added_By = l1_school.Id
            WHERE l1_school.Id IN (" . implode(',', $ids) . ")
            AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
            AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/schools_Lab_Reports');
            $this->load->view('AR/inc/footer');
        }
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
        } else {
            $data['tripName'] = "";
            $data['selected'] = "";
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
        AND ra.`source_id` = '" . $sessiondata['admin_id'] . "'; ")->result_array();
        if ($data['selected'] !== "") {
            $selects = $this->db->query("SELECT o.`EN_Title`,cd.`Dept_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId ,rrld.`mUtcTime`,rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
            FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_co_department` AS cd,`l0_organization` AS o
            WHERE ra.`Id` = rrld.`Machine_Id`
            AND ra.`user_type` = rrld.`user_type`
            AND ra.`source_id` = cd.`Id`
            AND cd.`Added_By` = o.`Id`
            AND rrld.`user_type`= 'company_department'
            AND ra.`source_id` = '" . $sessiondata['admin_id'] . "'  GROUP BY ra.Id;")->result_array();
            $data['trips'] = array();
            $data['machines'] = $selects;
        } else {
            $data['machines'] = $this->db->query("SELECT o.`EN_Title`,cd.`Dept_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId 
            ,rrld.`mUtcTime`, rrld.`trip_name` , rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
            FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_co_department` AS cd,`l0_organization` AS o
            WHERE ra.`Id` = rrld.`Machine_Id`
            AND ra.`user_type` = rrld.`user_type`
            AND ra.`source_id` =cd.`Id`
            AND cd.`Added_By` =o.`Id`
            AND rrld.`user_type`= 'company_department'
            AND ra.`source_id` = '" . $sessiondata['admin_id'] . "' GROUP BY ra.Id; ")->result_array();
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
        $this->load->view('AR/Department_comp/refrigeratorsReports');
        $this->load->view('AR/inc/footer');
    }
    public function tripNames_forthisMachine()
    {
        if ($this->input->method() == "post") {
            $id = $this->input->post('machine_id');
            $trips = $this->db->query("SELECT DISTINCT trip_name 
            FROM `refrigerator_result_log_Daily` 
            WHERE Machine_Id = '" . $id . "'
            ORDER BY `trip_name` DESC")->result_array();
            $this->response->json($trips);
        }
    }

    public function employeescards()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | STUDENTS CARDS';
        $data['sessiondata'] = $sessiondata;
        $data['students'] = $this->db->query("SELECT CONCAT(`l2_co_patient`.`F_name_EN`,' ',`l2_co_patient`.`L_name_EN`) AS `name` ,  `l2_co_avatars`.`Link` AS useravatar  ,
            `l2_co_patient`.`DOP` ,`l2_co_patient`.`Gender` , `l2_co_result`.* 
            FROM `l2_co_result`
            JOIN `l2_co_patient` ON `l2_co_result`.`UserId` = `l2_co_patient`.`Id` AND `l2_co_result`.`UserType` = `l2_co_result`.`UserType` 
            LEFT JOIN `l2_co_avatars` ON `l2_co_avatars`.`For_User` = `l2_co_patient`.`Id` AND `l2_co_avatars`.`Type_Of_User` = `l2_co_result`.`UserType`
            WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "' GROUP BY `l2_co_patient`.`Id` ORDER BY `l2_co_patient`.`F_name_EN` DESC  ")->result();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/employeescardsreport');
        $this->load->view('AR/inc/footer');
    }

    public function csv_users_check()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | CSV ';
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query(" SELECT * , `l2_co_patient`.`Id` as User_Id
        FROM l2_co_patient
        LEFT JOIN `l2_co_avatars`
        ON `l2_co_patient`.`Id` =  `l2_co_avatars`.`For_User` AND `l2_co_avatars`.`Type_Of_User` = `l2_co_patient`.`UserType`
        WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND `l2_co_patient`.`adding_method` = 'csv' ")->result_array();
        $data['dontshowchart'] = true;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Department_comp/List_patient');
        $this->load->view('EN/inc/footer');
    }

    public function Message()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health |  الرسائل";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Component/Message');
        $this->load->view('AR/inc/footer');
    }


    public function Climate()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $prms_survey = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Claimate` = '1'
        WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms_survey)) {
            $links  = array();
            if ($this->uri->segment('4')) {
                $page = $this->uri->segment('4');
                if ($page == "athletes") {
                    $links[] = array(
                        'name' => "DASHBOARD", "link" => base_url('AR/Company_Departments/ClaimateDashboard'),
                        "desc" => "", "icon" => "sportwel.png"
                    );
                    $links[] = array(
                        'name' => "INDIVIDUAL REPORT", "link" => base_url('AR/Company_Departments/ClimateIndividualReport'),
                        "desc" => "", "icon" => "sport2.png"
                    );
                    $links[] = array(
                        'name' => "GROUP REPORT", "link" => base_url('AR/Company_Departments/ClaimateGroupReport'),
                        "desc" => "", "icon" => "sport2.png"
                    );
                } elseif ($page == "survey") {
                    $links[] = array(
                        'name' => "DASHBOARD", "link" => base_url('AR/Company_Departments/ClaimateDashboard'),
                        "desc" => "", "icon" => "sportwel.png"
                    );
                    $links[] = array(
                        'name' => "INDIVIDUAL REPORT", "link" => base_url('AR/Company_Departments/ClimateIndividualReport'),
                        "desc" => "", "icon" => "sport2.png"
                    );
                    $links[] = array(
                        'name' => "GROUP REPORT", "link" => base_url('AR/Company_Departments/ClaimateGroupReport'),
                        "desc" => "", "icon" => "sport2.png"
                    );
                }
            } else {
                $links[] = array(
                    'name' => "ATHLETES WELLNESS DASHBOARD", "link" => base_url('AR/Company_Departments/Climate/athletes'),
                    "desc" => "", "icon" => "sportwel.png"
                );
                //
                $links[] = array(
                    'name' => "ATHLETES WELLNESS SURVEY", "link" => base_url('AR/Company_Departments/Climate/survey'),
                    "desc" => "", "icon" => "sport2.png"
                );
                $links[] = array(
                    'name' => "CLIMATE SURVEYS", "link" => base_url('AR/Company_Departments/ClimateSurveys'),
                    "desc" => "", "icon" => "sport2.png"
                );
            }

            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | List all ";
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Global/Links/Lists', $data);
            $this->load->view('AR/inc/footer'); //`sv_st_category`.`Id`
        } else {
            $dataDes['to'] = "AR/Company_Departments";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        }
    }

    public function ClaimateDashboard()
    {
        $this->load->library('session');
        $this->load->library('encrypt_url');
        $this->load->model('departments/sv_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Claimate` = '1'
        WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms_survey)) {
            $data['page_title'] = "Qlick Health | CLIMATE DASHBOARD ";
            $data['sessiondata'] = $sessiondata;
            $data['climate_survyes'] = $this->sv_reports->GetClimatesurveys();
            $data['climateAverageChart'] = $this->sv_reports->climateAverageChart();
            // $data['Answers'] = $this->sv_reports->Answer();
            $data['types'] = $this->db->get('r_usertype')->result_array();
            // $this->response->dd($data['usersWhoAnsweredToday']);
            // $this->response->dd($data['climateAverageChart']);
            if ($this->input->method() == "post") {
                $data['from'] = $this->input->post("from");
                $data['to'] = $this->input->post("to");
            } else {
                $data['from'] = date('Y-m-d');
                $data['to'] = date('Y-m-d');
            }
            $data['usersWhoAnsweredToday'] = $this->db->query("SELECT CONCAT(l2_co_patient.F_name_EN ,' ',l2_co_patient.L_name_EN) AS userName , l2_co_patient.National_Id , l2_co_patient.Id ,
                l2_co_avatars.Link as Avatar
                FROM l2_co_patient 
                JOIN `scl_co_climate_answers` ON `scl_co_climate_answers`.`user_id` = `l2_co_patient`.`Id`
                JOIN `l2_co_avatars` ON `l2_co_avatars`.`For_User` = `l2_co_patient`.`Id` AND Type_Of_User = `l2_co_patient`.`UserType`
                WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
                AND scl_co_climate_answers.TimeStamp >= '" . date($data['from'] . ' 00:00:00') . "' AND scl_co_climate_answers.TimeStamp <= '" . date($data['to'] . ' 23:59:59') . "'
                GROUP BY `scl_co_climate_answers`.`user_id` ")->result_array();
            $data['scores'] = $this->db->get("r_z_scores")->result_array();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department_comp/ClaimateDashboard');
            $this->load->view('AR/inc/footer');
        } else {
            $dataDes['to'] = "AR/ClaimateDashboard";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        }
    }

    public function ClimateSurveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Claimate` = '1'
        WHERE `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms_survey)) {
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = "Qlick Health | Climate Surveys List ";
            if ($this->input->method() == "get") {
                $this->load->model('departments/sv_reports');
                $data['userstypes'] = $this->db->get("r_usertype")->result_array();
                $data['oursurveys'] = $this->sv_reports->getclimatesurveyslibrary();
                $data['published_surveys'] = $this->sv_reports->GetClimatesurveys();
                // $this->response->dd($data['userstypes']);
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Department_comp/ClimateSurveys');
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
            } elseif ($this->input->method() == "post") {
                if ($this->input->post('type') && $this->input->post('gender') && $this->input->post('serv_id')) {
                    $this->load->library('session');
                    $sessiondata = $this->session->userdata('admin_details');
                    $user_id = $sessiondata['admin_id'];
                    $types = $this->input->post('type');
                    $genders = $this->input->post('gender');
                    $types_arr = array();
                    $genders_arr = array();
                    $data  = array(
                        'By_department'   => $user_id,
                        'climate_id'      => $this->input->post('serv_id'),
                        'Created'         => date('Y-m-d'),
                        'Time'            => date("H:i:s"),
                    );
                    if ($this->db->insert('scl_published_co_claimate', $data)) {
                        echo "ok";
                        $last_serv = $this->db->query("SELECT Id FROM `scl_published_co_claimate`
                        WHERE `By_department` = '" . $user_id . "' ORDER BY Id DESC LIMIT 1 ")->result_array();
                        if (!empty($last_serv)) {
                            // types  
                            $serv_id = $last_serv[0]['Id'];
                            foreach ($types as $type) {
                                $types_arr[] = array(
                                    "Climate_id"  =>  $serv_id,
                                    "Type_code"   =>  $type,
                                    "Created"     =>  date('Y-m-d'),
                                    "Time"        =>  date('H:i:s'),
                                );
                            }
                            if ($this->db->insert_batch('scl_published_co_claimate_types', $types_arr)) {
                                echo "ok";
                            }
                            // gender add
                            foreach ($genders as $gender) {
                                $genders_arr[] = array(
                                    "Climate_id"   =>  $serv_id,
                                    "Gender_code"  =>  $gender,
                                    "Created"      =>  date('Y-m-d'),
                                    "Time"         =>  date('H:i:s'),
                                );
                            }
                            if ($this->db->insert_batch('scl_published_co_claimate_genders', $genders_arr)) {
                                echo "ok";
                            }
                            echo "ok";
                        }
                    }
                }
            }
        } else {
            $dataDes['to'] = "AR/Company_Departments";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        }
    }

    public function climatePreview()
    {
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Claimate` = '1'
        WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
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
                    $this->load->view('AR/Department_comp/climatePreview');
                    $this->load->view('AR/inc/footer');
                }
            }
        } else {
            $dataDes['to'] = "AR/Company_Departments";
            $this->load->view('AR/Global/disabledPerm', $dataDes);
        }
    }

    public function ClimateReports()
    {
        $this->load->library('session');
        $this->load->model('departments/sv_reports');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('encrypt_url');
        if (is_numeric($this->encrypt_url->safe_b64decode($this->uri->segment(4)))) {
            $data['surveyid'] = $this->encrypt_url->safe_b64decode($this->uri->segment(4));
            // exit($data['surveyid']);
            if (!empty($this->sv_reports->GetClimatesurveys(['surveyid' => $data['surveyid'], 'show_codes' => true]))) {
                $data['fulldata'] = $this->sv_reports->GetClimatesurveys(['surveyid' => $data['surveyid'], 'show_codes' => true])[0];
                $data['choices'] = $this->sv_reports->ClimateChoices(['surveyid' => $data['surveyid']]);
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
                $this->load->view('AR/Department_comp/ClimateReports');
                $this->load->view('AR/inc/footer');
            } else {
                echo "Error in finding this survey";
            }
        } else {
            echo "Error in finding this survey";
        }
    }

    public function ClimateIndividualReport()
    {
        $this->load->library('session');
        $this->load->library('encrypt_url');
        $this->load->model('departments/sv_reports');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['users'] = $this->db->query("SELECT CONCAT(l2_co_patient.F_name_EN ,' ',l2_co_patient.L_name_EN) AS userName , l2_co_patient.National_Id , l2_co_patient.Id ,
        l2_co_avatars.Link as Avatar , l2_co_patient.UserType 
        FROM l2_co_patient 
        JOIN `l2_co_avatars` ON `l2_co_avatars`.`For_User` = `l2_co_patient`.`Id` AND Type_Of_User = `l2_co_patient`.`UserType`
        WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        if ($this->uri->segment(4) && in_array($this->uri->segment(4), array_column($data['users'], "Id"))) {
            $data['full_user_data'] = array_filter($data['users'], function ($u) {
                return $u['Id'] == $this->uri->segment(4);
            });
            $data['results'] = $this->db->where(['UserId' => $this->uri->segment(4)])->order_by('Id', 'DESC')->get("l2_co_result");
            if ($data['results']->num_rows() > 0 && !empty($data['full_user_data'])) {
                sort($data['full_user_data']);
                $data['full_user_data'] = $data['full_user_data'][0];
                $data['results'] = $data['results']->result_array()[0];
                $data['uid'] = $this->uri->segment(4);
                $data['climate_survyes'] = $this->sv_reports->GetClimatesurveys();
                // exit(print_r($data['climate_survyes']));scores
            } else {
                $data['error'] = "No data Found For This User";
            }
        }
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/ClimateIndividualReport');
        $this->load->view('AR/inc/footer');
    }

    public function ClaimateGroupReport()
    {
        $this->load->library('session');
        $this->load->model('departments/sv_reports');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('pagination');
        $config['base_url'] = base_url("AR/Company_Departments/ClaimateGroupReport");
        $config['per_page'] = 15;
        $config['total_rows'] =  $this->db->query("SELECT l2_co_patient.Id FROM l2_co_patient 
        JOIN `scl_co_climate_answers` ON `scl_co_climate_answers`.`user_id` = `l2_co_patient`.`Id`
        JOIN `l2_co_avatars` ON `l2_co_avatars`.`For_User` = `l2_co_patient`.`Id` AND Type_Of_User = `l2_co_patient`.`UserType`
        WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        GROUP BY `scl_co_climate_answers`.`user_id` ")->num_rows();
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination navigation mt-2" style="justify-content: center;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item page-link">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item page-link">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item page-link">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item page-link">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="bg-primary active text-white page-item page-link"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item page-link">';
        $config['num_tag_close'] = '</li>';
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $data['set_id'] = $this->uri->segment(4);
        $data['climate_survyes'] = $this->sv_reports->GetClimatesurveys();
        $data['scores'] = $this->db->get("r_z_scores")->result_array();
        $data['usersWhoAnsweredToday'] = $this->db->query("SELECT CONCAT(l2_co_patient.F_name_EN ,' ',l2_co_patient.L_name_EN) AS userName , l2_co_patient.UserType , l2_co_patient.National_Id , l2_co_patient.Id ,
        l2_co_avatars.Link as Avatar
        FROM l2_co_patient 
        JOIN `scl_co_climate_answers` ON `scl_co_climate_answers`.`user_id` = `l2_co_patient`.`Id`
        JOIN `l2_co_avatars` ON `l2_co_avatars`.`For_User` = `l2_co_patient`.`Id` AND Type_Of_User = `l2_co_patient`.`UserType`
        WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        GROUP BY `scl_co_climate_answers`.`user_id` 
        LIMIT $page," . $config['per_page'] . "  ")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/ClaimateGroupReport');
        $this->load->view('AR/inc/footer');
    }

    public function Wellness()
    {
        $this->load->library('session');
        $this->load->model('departments/sv_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Messages ";
        $data['sessiondata'] = $sessiondata;
        $userdata = $this->db->get_where('l1_co_department', ['Id' => $sessiondata['admin_id']])->result_array();
        if (empty($userdata)) {
            session_destroy();
            redirect("EN/Users/");
        }
        $saurce_id = $userdata[0]['Added_By'];
        $prms_survey = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
        FROM `l1_co_department` 
        JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Claimate` = '1'
        WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms_survey)) {
            // sql
            if ($this->input->method() == "get") {
                $data['expired_surveys'] = $this->db->query(" SELECT
                `sv_st1_co_surveys`.`Id` AS survey_id,
                `sv_st_surveys`.`Id` AS main_survey_id,
                `sv_st1_co_surveys`.`Status` AS status,
                `sv_st1_co_surveys`.`title_en` AS Title_en,
                `sv_st1_co_surveys`.`title_ar` AS Title_ar,
                `sv_st1_co_surveys`.`Startting_date` AS From_date,
                `sv_st1_co_surveys`.`End_date` AS To_date,
                `sv_st_surveys`.`answer_group_en` AS group_id,
                `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
                `sv_st_surveys`.`code` AS serv_code,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                `sv_set_template_answers`.`title_en` AS choices_en_title ,
                `sv_set_template_answers`.`title_ar` AS choices_ar_title 
                FROM `sv_st1_co_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                WHERE `sv_st1_co_surveys`.`End_date` < '" . date('Y-m-d') . "' AND `sv_st1_co_surveys`.`Published_by` = '" . $saurce_id . "'  ")->result_array();
                $data['surveys'] = $this->sv_reports->our_surveys();
                $data['avalaible_surveys'] = $this->sv_reports->avalaible_surveys();
                // print_r($data);
                // exit();
                $data['our_surveys'] = $this->sv_reports->our_published_surveys(); // only published this time
                $data['expired_surveys'] = $this->sv_reports->our_surveys(true);
                $data['completed_surveys'] = $this->sv_reports->completed_surveys();
                $data['used_categorys'] = $this->sv_reports->usedcategorys();
                $data['surveys_for_males'] = $this->sv_reports->surveys_by_gender('1');
                $data['surveys_for_females'] = $this->sv_reports->surveys_by_gender('2');
                $data['types'] = $this->sv_reports->counter_of_completed_surveys_by_types();
                $data['supported_types'] = $this->sv_reports->supported_types();
                $data['themes'] = $this->db->get('sv_st_themes')->result_array();
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Department_comp/Wellness');
                $this->load->view('EN/inc/footer');
            } elseif ($this->input->method() == "post" && $this->input->post('type') && $this->input->post('gender') && $this->input->post('serv_id')) {
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $user_id = $sessiondata['admin_id'];
                $types = $this->input->post('type');
                $genders = $this->input->post('gender');
                $levels = $this->input->post('levels');
                $theme = $this->input->post('theme') ? $this->input->post('theme') : "0";
                $types_arr = array();
                $genders_arr = array();
                $levels_arr = array();
                $data  = array(
                    'Created_By'       => $user_id,
                    'Serv_id'         => $this->input->post('serv_id'),
                    'Created'         => date('Y-m-d'),
                    'Time'            => date("H:i:s"),
                    "theme_link"      => $theme
                );
                if ($this->db->insert('sv_co_published_surveys', $data)) {
                    $last_serv = $this->db->query("SELECT Id FROM `sv_co_published_surveys`
                    WHERE `Created_By` = '" . $user_id . "' ORDER BY Id DESC LIMIT 1 ")->result_array();
                    if (!empty($last_serv)) {
                        // types  
                        $serv_id = $last_serv[0]['Id'];
                        foreach ($types as $type) {
                            $types_arr[] = array(
                                "Survey_id"   =>  $serv_id,
                                "Type_code"   =>  $type,
                                "Created"     =>  date('Y-m-d'),
                                "Time"        =>  date('H:i:s'),
                            );
                        }
                        if ($this->db->insert_batch('sv_co_published_surveys_types', $types_arr)) {
                            // gender add
                            foreach ($genders as $gender) {
                                $genders_arr[] = array(
                                    "Survey_id"   =>  $serv_id,
                                    "Gender_code"   =>  $gender,
                                    "Created"     =>  date('Y-m-d'),
                                    "Time"        =>  date('H:i:s'),
                                );
                            }
                            if ($this->db->insert_batch('sv_co_published_surveys_genders', $genders_arr)) {
                                $this->response->json(['status' => 'ok']);
                            }
                        }
                    }
                }
            }
        } else {
            $dataDes['to'] = "EN/Company";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
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

    public function Consultant()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && $this->uri->segment(4) == "chat" && is_numeric($this->uri->segment(5))) {
                // for chat
                $body['fileid'] = $this->uri->segment(5);
                $Consultantdata = $this->db->where('Id', $body['fileid'])->get("l1_consultant_reports")->row();
                if (empty($Consultantdata)) {
                    return redirect('AR/Company_Departments/Consultant');
                }
                $body['target'] = $Consultantdata->UploadedBy;
                $this->load->view('AR/Component/Consultant/chat', $body);
            } else {
                $body['files'] = $this->db->select('FileName AS link , Created AS UploadedAt , Comments , l1_consultant_reports.Id')
                    ->select('(SELECT COUNT(Id) 
                                FROM l0_consultant_chat 
                                WHERE l0_consultant_chat.about = l1_consultant_reports.Id 
                                AND receiver_id = "' . $sessiondata['admin_id'] . '" AND receiver_usertype = "' . $sessiondata['type'] . '"
                                AND sender_usertype = "consultant" AND read_at IS NULL) AS UnreadMessages')
                    ->from('l1_consultant_reports')
                    ->where('AccountId', $sessiondata['admin_id'])
                    ->where('AccountType', "D")
                    ->get()->result_array();
                $this->load->view('AR/Component/Consultant/list', $body);
            }
        }
        $this->load->view('AR/inc/footer');
    }

    public function climate_dashboard()
    {
        $this->load->library('session');
        $this->load->model('helper');
        $sessiondata = $this->session->userdata('admin_details');
        if (!$this->helper->forCompany($sessiondata['admin_id'])->isThere()) {
            echo "This Departments Doesn't contain any members";
            return false;
        }
        $data['userstypes'] = $this->helper->forCompany($sessiondata['admin_id'])->get();
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        // source
        $data['t'] = 1;
        $data['c'] = 'd';
        $cond = "";
        $today = "'" . date('Y-m-d');
        if ($this->input->method() == "post") {
            $data['t'] = $this->input->post('t');
            $data['c'] = $this->input->post('c');
            $cond = "";
            switch ($data['c']) {
                case 'd':
                    $date = "'" . date('Y-m-d');
                    break;
                case 'y':
                    $date = "'" . date('Y-01-01');
                    break;
                case 'm':
                    $date = "'" . date('Y-m-01');
                    break;
                default:
                    $date = "'" . date('Y-m-d');
                    break;
            }
        } else {
            $date = "'" . date('Y-m-d');
        }
        $cond .= $date ? "AND sca.TimeStamp >=" . $date . " 00:00:00'" . " AND sca.TimeStamp <=" . $today . " 23:59:59'" : "";
        if ($this->helper->set($data['t'])->isValid()) {
            $cond .= "AND sca.user_type = '" . $data['t'] . "'";
        }
        $data['results'] = $this->db->query("SELECT sscc.`Climate_id`,
        sscc.Title_en as title,
        COUNT(sca.`climate_id`) d1,
        SUM(ssc.`mark`) ss ,
        (SUM(ssc.`mark`) /COUNT(sca.`climate_id`))/(SELECT COUNT(`id`)
        FROM `scl_st_choices` 
        WHERE  `servey_id` =sscc.`Climate_id`
        GROUP BY `servey_id`) *100  ff 
        FROM `scl_co_climate_answers` AS sca ,
            `scl_published_co_claimate` spc,
            `scl_st_co_climate` AS sscc ,
            `scl_st_choices` AS ssc
        WHERE sca.`climate_id` =spc.`Id`
            AND spc.`climate_id` =sscc.`id`  
            AND sscc.`Climate_id` =ssc.`servey_id`
            AND sca.`answer_id` =ssc.id
            $cond
        GROUP BY sscc.`Climate_id`,sca.`climate_id`")->result_array();
        // echo $this->db->last_query();
        // $this->response->json($data);
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department_comp/climate-dashboard', $data);
        $this->load->view('AR/inc/footer');
    }
}//end extand     
