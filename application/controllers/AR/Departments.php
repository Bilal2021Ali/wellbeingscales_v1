<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Departments extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');

        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($sessiondata)) {
            if ($sessiondata['level'] == 2 && $sessiondata['type'] == "department") {
                $this->config->set_item('language', 'arabic');
            } else if ($sessiondata['type'] == "Dept_Perm" && $method == "POST") {
                $this->config->set_item('language', 'arabic');
            } else {
                redirect('AR/users');
                exit();
            }
        } else {
            redirect('AR/users');
            exit();
        }
    }

    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
            $data['page_title'] = "Qlick Health | Dashboard ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view("inc/header", $data);
            $this->load->view("Department/dash");
            $this->load->view("inc/footer");
        } else {
            redirect('users');
        }
    }

    public function AddMembers()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/AddMembers');
        $this->load->view('AR/inc/footer');
    }

    public function MembersList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Members List ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/Avatars');
        $this->load->view('AR/inc/footer');
    }

    public function ChangeAvatarList()
    {
        if ($this->input->post('usertype')) {
?>
            <table class="table">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Picture </th>
                        <th> Name </th>
                        <th> Username </th>
                        <th> National ID </th>
                        <th> Nationality </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <?php
                $type =  $this->input->post('usertype');
                $users = $this->db->query(" SELECT * FROM `l2_patient` WHERE `UserType` = '" . $type . "' ")->result_array();
                if (!empty($users)) {
                    foreach ($users as $admin) {
                ?>
                        <tr>
                            <th scope="row"><?php echo $admin['Id']; ?></th>
                            <td>Picture</td>
                            <td><?php echo $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                            <td><?php echo $admin['UserName']; ?></td>
                            <td><?php echo $admin['National_Id']; ?></td>
                            <td><?php echo $admin['Nationality']; ?></td>
                            <td>
                                <a href="<?php echo base_url() ?>AR/Departments/ChangeMemberAvatar/<?php echo $type ?>/<?php echo $admin['Id']; ?>">
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
            echo "الرجاء اختيار نوع المستخدم !!";
        }
    }

    public function Lab_Tests()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Tests";
        $devices_counter = $this->db->query("SELECT * FROM  `l2_devices`
		  WHERE `Added_by` = '" . $sessiondata['admin_id'] . "' AND `UserType` = 'Department' ")->num_rows();
        $data['sessiondata'] = $sessiondata;
        if ($devices_counter !== 0) {
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department/Test_lab');
            $this->load->view('AR/inc/footer');
        } else {
            $data['hasntnav'] = true;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Global/NoDecvices');
            $this->load->view('AR/inc/footer');
        }
    }


    public function ChangeMemberAvatar()
    {
        if ($this->uri->segment(3) && $this->uri->segment(4)) {
            $userType = $this->uri->segment(3);
            $UserId = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Tests";
            $data['sessiondata'] = $sessiondata;
            $Body['user_type'] = $userType;
            $Body['user_id'] = $UserId;
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department/ChangePhotoForMember', $Body);
            $this->load->view('AR/inc/footer');
        }
    }


    public function AddDevice()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/AddDevice');
        $this->load->view('AR/inc/footer');
    }

    public function Profile()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | school Profile";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Profiles/departmentProfile');
        $this->load->view('AR/inc/footer');
    }

    public function ListOfPatients()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        print_r($sessiondata);
        $data['page_title'] = "Qlick Health | List Of Patients ";
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query("SELECT * FROM l2_patient
          WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/List_patient');
        $this->load->view('AR/inc/footer');
    }

    public function UpdatePatientData()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(3);
        $iscorrect = $this->db->query("SELECT * FROM l2_patient WHERE Id =  '" . $SUFFID . "'
          AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Staff Data ";
            $data['sessiondata'] = $sessiondata;
            $data['StaffData'] = $this->db->query("SELECT * FROM l2_patient
          WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department/Update_patient');
            $this->load->view('AR/inc/footer');
        } else {
            redirect('schools');
        }
    }

    public function listOfSites()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List Of Sites ";
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query("SELECT * FROM `l2_dept_site` WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/List_sites');
        $this->load->view('AR/inc/footer');
    }

    public function UpdateSite()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(3);
        $iscorrect = $this->db->query("SELECT * FROM l2_dept_site WHERE Id =  '" . $SUFFID . "'
          AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Teacher ";
            $data['sessiondata'] = $sessiondata;
            $data['sitesdata'] = $this->db->query("SELECT * FROM l2_dept_site WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/Department/Update_site');
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
            $this->form_validation->set_rules('N_Id', 'National Id', 'trim|required');
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
                $National_Id = $this->input->post('N_Id');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $old_NID = $this->input->post('old_NID');
                $ID = $this->input->post('ID');
                $password =  "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);

                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    if ($National_Id !== $old_NID) {
                        $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
                    } else {
                        $iscrrent = null;
                    }
                    if ($iscrrent == 0) {
                        if ($this->db->query("UPDATE `l2_patient` SET UserType = '" . $Prefix . "' , 
           F_name_EN = '" . $First_Name_EN . "' , M_name_EN = '" . $Middle_Name_EN . "' , L_name_EN = '" . $Last_Name_EN . "' ,
           F_name_AR = '" . $First_Name_AR . "' , M_name_AR = '" . $Middle_Name_AR . "' , L_name_AR = '" . $Last_Name_AR . "' ,
           DOP = '" . $DOP . "' , Phone = '" . $Phone . "' , Gender = '" . $Gender . "' , UserName = '" . $National_Id . "' ,
           National_Id = '" . $National_Id . "' , Nationality = '" . $Nationality . "' , Password = '" . $hash_pass . "' , 
           UserName = '" . $National_Id . "' , Email = '" . $Email . "' WHERE Id = '" . $ID . "'
           ")) {
                            $this->db->query("UPDATE `v_nationalids` SET `National_Id` = '" . $National_Id . "'
           WHERE National_Id = '" . $old_NID . "' ");
                            $this->db->query("UPDATE `v_login` SET `Username` = '" . $National_Id . "'
           WHERE Username = '" . $old_NID . "' ");

                            echo "The Data Is Inserted.";
                            echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";

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
                            //$link = base_url()."AR/users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                            $messg = '<center>
          <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $National_Id . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://qlicksystems.com/education/AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
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
          location.href = '" . base_url() . "AR/Departments/ListOfPatients';
          </script>
          ";
                            }
                        }
                    } else {
                        echo "The National ID already exists.";
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

    public function startAddStaff()
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
                        if ($this->db->query("INSERT INTO 
          `l2_staff` ( `Prefix`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Position`,`Email`,
          `Password`,`UserName`, `Created`)
          VALUES ('" . $Prefix . "',
          '" . $First_Name_EN . "', '" . $Middle_Name_EN . "', '" . $Last_Name_EN . "', 
          '" . $First_Name_AR . "', '" . $Middle_Name_AR . "', '" . $Last_Name_AR . "', 
          '" . $DOP . "', '" . $Phone . "', '" . $Gender . "', '" . $National_Id . "', '" . $Nationality . "','" . $Position . "',
          '" . $Email . "','" . $hash_pass . "','" . $National_Id . "', '".date('Y-m-d')."');")) {
        //                     $this->db->query("INSERT INTO 
        //   `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
        //   VALUES ('" . $National_Id . "','Staff','".date('Y-m-d')."')");
                            echo "The Data Is Inserted.";
                            echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";

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
                            //$link = base_url()."AR/users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                            $messg = '<center>
          <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $National_Id . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://qlicksystems.com/education/AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
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
                        echo "The National ID already exists.";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
        }
    }

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
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');

            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('N_Id', 'National Id', 'trim|required');
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
                $National_Id = $this->input->post('N_Id');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $password =  "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                print_r($sessiondata);
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

                        if ($this->db->query("INSERT INTO 
          `l2_patient` ( `UserType`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Position`,`Email`,
          `Password`,`UserName`, `Added_By` , `Add_Me` ,`Created`)
          VALUES ('" . $Prefix . "',
          '" . $First_Name_EN . "', '" . $Middle_Name_EN . "', '" . $Last_Name_EN . "', 
          '" . $First_Name_AR . "', '" . $Middle_Name_AR . "', '" . $Last_Name_AR . "', 
          '" . $DOP . "', '" . $Phone . "', '" . $Gender . "', '" . $National_Id . "', '" . $Nationality . "','" . $Position . "',
          '" . $Email . "','" . $hash_pass . "','" . $National_Id . "', '" . $sessiondata['admin_id'] . "' , '" . $addme . "' , '".date('Y-m-d')."');")) {
        //                     $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From`  ,`Created`)
        //   VALUES ('" . $National_Id . "','Staff','".date('Y-m-d')."')");
        //                     $this->db->query("INSERT INTO  `v_login` ( `Username`, `Password`, `Type` ,`Created`)
        //   VALUES ('" . $National_Id . "','" . $hash_pass . "','Patient','".date('Y-m-d')."')");
                            echo "The Data Is Inserted.";
                            echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";

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
                            //$link = base_url()."AR/users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                            $messg = '<center>
          <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $National_Id . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://qlicksystems.com/education/AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
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
          //location.href = '" . base_url() . "AR/Departments/AddMembers';
          </script>
          ";
                            }
                        }
                    } else {
                        echo "The National ID already exists.";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
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
          '" . $Email . "','" . $hash_pass . "','" . $National_Id . "', '" . $Val . "', '".date('Y-m-d')."');")) {
        //                     $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
        //   VALUES ('" . $National_Id . "','Teacher','".date('Y-m-d')."')");
                            echo "The Data Is Inserted.";
                            echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";

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
          <h3>Your User name is : ' . $National_Id . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://qlicksystems.com/education/AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
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
                        echo "The National ID already exists.";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
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
            echo "The device Deleted";
        } else {
            echo "oops We have A error Please Try Again Later";
        }
    }



    public function startAddStudent()
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
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('P_NID', 'Parent National ID', 'trim|required');
            $this->form_validation->set_rules('Classes', 'Classes', 'trim|required|numeric');

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
                $Email = $this->input->post('Email');
                $P_NID = $this->input->post('P_NID');
                $clases = $this->input->post('Classes');

                $password =  "12345678";
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);

                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
                    if ($iscrrent == 0) {
                        if ($this->db->query("INSERT INTO 
          `l2_student` ( `Prefix`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Email`,
          `Password`,`UserName`, `Parent_NID` , `Class` ,`Created`)
          VALUES ('" . $Prefix . "',
          '" . $First_Name_EN . "', '" . $Middle_Name_EN . "', '" . $Last_Name_EN . "', 
          '" . $First_Name_AR . "', '" . $Middle_Name_AR . "', '" . $Last_Name_AR . "', 
          '" . $DOP . "', '" . $Phone . "', '" . $Gender . "', '" . $National_Id . "', '" . $Nationality . "',
          '" . $Email . "','" . $hash_pass . "','" . $National_Id . "', '" . $P_NID . "','" . $clases . "', '".date('Y-m-d')."');")) {
        //                     $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
        //   VALUES ('" . $National_Id . "','Student','".date('Y-m-d')."')");

                            echo "The Data Is Inserted.";
                            echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";
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
                            //$link = base_url()."AR/users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                            $messg = '<center>
          <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
          <h2> Hi there <h2>      
          <h3>Your User name is : ' . $P_NID . ' </h3>
          <h3>Your password is : ' . $P_NID . ' </h3>
          <a href="https://qlicksystems.com/education/AR/users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          <p>Please Update Your Password !!</p>     
          </center>';


                            $this->email->initialize($config);
                            $this->email->set_newline('\r\n');
                            $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
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
                        echo "The National ID already exists.";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
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
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');
            $this->form_validation->set_rules('city', 'Username', 'trim|required');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');
            $this->form_validation->set_rules('Type', 'Type', 'trim|required');
            $id = $sessiondata['admin_id'];

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Dept_Name_AR');
                $English_Title = $this->input->post('Dept_Name_EN');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $username = $this->input->post('Username');
                $Type = $this->input->post('Type');

                $iscorrent = $this->db->query("SELECT *
          FROM `l1_department` WHERE username = '" . $username . "' AND Id != '" . $id . "' ")->result_array();
                if (empty($iscorrent)) {
                    if ($this->db->query("UPDATE l1_department
          SET Dept_Name_AR = '" . $Arabic_Title . "', Dept_Name_EN = '" . $English_Title . "', 
          Manager_EN = '" . $Manager_EN . "', Manager_AR = '" . $Manager_AR . "' , Email = '" . $Email . "', Phone = '" . $Phone . "' ,
          Username = '" . $username . "' , Type_Of_Dept = '" . $Type . "'
          WHERE id = '" . $id . "' ")) {
                        echo "<script>Swal.fire({title: 'Success!',text: 'The data is updated successfully.',icon: 'success'});</script>";
                    }
                } else {
                    echo 'This User Name Is Already Used';
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
               (`S_id`, `Levels`, `Created`) VALUES ('" . $sessiondata['admin_id'] . "', '" . $Val . "', '".date('Y-m-d')."');");
            echo "The data was inserted successfully.";
            echo "<script>
               Swal.fire({title: 'Success!',text: 'The data is inserted successfully.',icon: 'success'});
               location.reload();     
               </script>";
        } else {
            $this->db->query("UPDATE  `v_schoolgrades` SET `Levels` = '" . $Val . "' , `Created` = '".date('Y-m-d')."' WHERE 
               `S_id` = '" . $sessiondata['admin_id'] . "' ");
            echo "The Data was Updated successfully.";
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
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $School_Id = $sessiondata['admin_id'];
        $this->load->library('form_validation');
        if ($this->input->post('Device_Id')) {
            $Device_Id = $this->input->post('Device_Id');
            $comments = $this->input->post("Comments");
            $conter = $this->db->query("SELECT * FROM `l2_devices` WHERE D_Id = '" . $Device_Id . "' AND `Added_by` = '" . $sessiondata['admin_id'] . "' AND `UserType` = 'Dept' ")->num_rows();
            if ($conter == 0) {
                $this->db->query("INSERT INTO 
          `l2_devices` ( `D_Id`, `Added_by`, `Comments`, `Created`,`UserType`)
          VALUES ('" . $Device_Id . "', '" . $School_Id . "', '" . $comments . "', '".date('Y-m-d')."','Dept')");
                echo "<script>
               Swal.fire({title: 'Success!',text: 'The device is added successfully.',icon: 'success'});
               location.reload();     
               </script>";
            } else {
                echo "<script>
               Swal.fire({title: 'Error!',text: 'This Device Id is Already Exist !!',icon: 'error'});
               </script>";
            }
        } else {
            echo "<script>
               Swal.fire({title: 'Error!',text: 'Please Enter Valid Device Id',icon: 'error'});
               </script>";
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
          VALUES ('" . $Batch . "', '" . $ForDevice . "', '".date('Y-m-d')."')");
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
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        if ($this->form_validation->run()) {
            $addme = "";
            if (isset($sessiondata['Patient_ID'])) {
                $addme = $sessiondata['Patient_ID'];
            }
            $Site = $this->input->post("Site");
            $Description = $this->input->post("Description");
            if ($this->db->query("INSERT INTO 
          `l2_dept_site` (`Site_Code`, `Description`, `Added_By` , `Add_Me` , `Created`) 
          VALUES ('" . $Site . "', '" . $Description . "', '" . $sessiondata['admin_id'] . "' , '" . $addme . "' , '".date('Y-m-d')."')")) { ?>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'The data was inserted successfully.',
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

    public function StartUpdateSite()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        if ($this->form_validation->run()) {
            $Description = $this->input->post("Description");
            $ID = $this->input->post("AZF_UFGFDX");
            if ($this->db->query("UPDATE `l2_dept_site` SET `Description` = '" . $Description . "' WHERE `l2_dept_site`.`Id` = $ID ")) { ?>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'The data was updated successfully.',
                        icon: 'success'
                    });
                    setTimeout(function() {
                        location.href = "<?php echo base_url(); ?>AR/Departments/listOfSites";
                    }, 900);
                </script>
            <?php

            } else {
                echo "error";
            }
        } else {
            echo validation_errors();
        }
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
                    location.href = "<?php echo base_url();  ?>AR/schools";
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
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Department/Test');
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
                $Ourstaffs1 = $this->db->query("SELECT * FROM l2_patient WHERE 
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `UserType` = '" . $UserType . "'  ")->result_array();
                foreach ($Ourstaffs1 as $staffs) {
                    $resultsIntable = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staffs['Id'] . "' AND UserType = '" . $UserType . "'
AND Result_Date = '" . $today . "' ORDER BY `Id` DESC LIMIT 1")->num_rows();
                    if ($resultsIntable == 0) {
                        $counter++;
                    }
                }
                ?>
                <h4 class="card-title mb-4">Total Users No Temperature : <a href=""> <?php echo $counter; ?></a></h4>
                <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
            </div>
            <?php
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
AND `UserType` = '" . $UserType . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = '" . $UserType . "'
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
                            name: "Temperature",
                            // here data
                            data: [<?php foreach ($list as $finalresults) {
                                        echo $finalresults['Result'] . ',';
                                    } ?>]
                        }],
                        title: {
                            text: "Monitor Staff Temperature",
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
                                text: "Students Temperature"
                            }
                        },
                        yaxis: {
                            title: {
                                text: "Temperature"
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
            echo "<h4>Please Select User Type  !</h4>";
        }
    }

    public function Attendance_Report()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Attendance Report ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/schools/Attendance_Report');
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
        $this->load->view('AR/Department/All_Tests_Today');
        $this->load->view('AR/inc/footer');
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

}

//end extand     
