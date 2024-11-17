<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once __DIR__ . "../../../../vendor/autoload.php";
require_once __DIR__ . "/../../BaseControllers/Ministry/courses.php";
require_once __DIR__ . "/../../Menus/MinistryMenus.php";
require_once __DIR__ . "/../../BaseControllers/Ministry/SubAccountsManager.php";
require_once __DIR__ . "/../../Traits/schools/SpeakOut.php";
require_once __DIR__ . "/../../Traits/CountriesAndCities.php";
require_once __DIR__ . "/../../Traits/Ministry/Profile.php";
require_once __DIR__ . "/../../Traits/Ministry/Dashboard.php";
require_once __DIR__ . "/../../Traits/Ministry/Controllers.php";
require_once __DIR__ . "/../../Traits/Reusable/Protection.php";
require_once __DIR__ . "/../../Traits/schools/Incidents.php";
require_once __DIR__ . "/../../Traits/Shared/DoctorReport.php";
require_once __DIR__ . "/../../Traits/schools/StudentsAttendance.php";
require_once __DIR__ . "/../../Traits/Ministry/MinistryRefrigerator.php";


use App\Traits\Ministry\MinistryRefrigerator;
use App\Traits\schools\StudentsAttendance;
use BaseControllers\Ministry\Courses as MinistryCoursesHelper;
use BaseControllers\Ministry\SubAccountsManager;
use Traits\Ministry\Controllers;
use Traits\schools\SpeakOut;
use Traits\schools\Incidents;
use Traits\Ministry\Profile;
use Traits\CountriesAndCities;
use Traits\Ministry\Dashboard;
use Traits\Reusable\Protection;
use Traits\Shared\DoctorReport;

if(!function_exists('bcadd')) {
    function bcadd($var = null) {
        return $var;
    }
}

if(!function_exists('bcmul')) {
    function bcmul($var = null) {
        return $var;
    }
}

if(!function_exists('bcdiv')) {
    function bcdiv($var = null) {
        return $var;
    }
}

if(!function_exists('bcmod')) {
    function bcmod($var = null) {
        return $var;
    }
}


/**
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property Response $response
 * @property CI_DB_query_builder $db
 * @property CI_Lang $lang
 */
class DashboardSystem extends CI_Controller
{
    use Protection, SpeakOut, Incidents, Profile, CountriesAndCities, Dashboard, Controllers, DoctorReport, StudentsAttendance , MinistryRefrigerator;

    public const LANGUAGE = "EN";
    public const COLORS = ['#FF6633', '#FFB399', '#FF33FF', '#00B3E6',
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];
    public const TYPE = "ministry";
    public array $permissions_array = [];
    public int $JORDAN = 102;
    public MinistryCoursesHelper $coursesHelper;
    public array $sessionData = [];
    public SubAccountsManager $consultantsManager;
    public SubAccountsManager $controllersManager;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || $sessiondata['level'] !== 1) {
            redirect('users');
            exit();
        } else {
            $data['temperatureandlabs'] = $this->permissions->temperatureandlabs();
            $this->permissions_array["temperatureandlabs"] = $data['temperatureandlabs'];
            $this->load->vars($data);
        }
        $this->sessionData = $sessiondata;

        $this->coursesHelper = new MinistryCoursesHelper($this, "en");
        $this->consultantsManager = new SubAccountsManager($this, "l1_consultants", "l1_consultants_children", "consultant");
        $this->controllersManager = new SubAccountsManager($this, "l1_controllers", "l1_controllers_children", "controller");
    }

    public function _showPage(...$options) // for private classes
    {
        $this->show(...$options);
    }

    protected function show($view, $data = [])
    {
        $sessionData = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessionData;
        $this->load->view('EN/inc/header', $data);
        $this->load->view($view);
        $this->load->view('EN/inc/footer');
    }

    public function latest_dashboard()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $this->load->model('ministry/Ministry_Functions');
        $data['cards'] = $this->Ministry_Functions->DashboardCards();
        $this->show('EN/Ministry/latest-dashboard', $data);
    }

    public function addSystem()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Registration System ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` DESC LIMIT 10')->result_array();
        $this->show('EN/add_level1_system2', $data);
    }

    public function GrantSystemTest()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Registration System ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` DESC LIMIT 10')->result_array();
        $this->show('EN/grantSystemTest', $data);
    }

    public function available_surveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `surveys` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $data['page_title'] = "Qlick Health | Manage Surveys";
            $data['sessiondata'] = $sessiondata;
            $data['surveys'] = $this->db->query(" SELECT
            `sv_st_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`status` AS status,
            `sv_st_category`.`Cat_en` AS Title_en,
            `sv_st_category`.`Cat_ar` AS Title_ar,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `en_answer_group`.`title_en` AS choices_en_title ,
            `ar_answer_group`.`title_en` AS choices_ar_title ,
            COUNT(`sv_st_questions`.`survey_id`) AS questions_count
            FROM `sv_st_surveys`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            INNER JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
            INNER JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
            INNER JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
            WHERE `sv_st_surveys`.`status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M'
            GROUP BY `sv_st_questions`.`survey_id` ")->result_array();
            $this->show('EN/Ministry/Manage_available_surveys', $data);
        } else {
            $dataDes['to'] = "EN/dashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
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
            if ($this->uri->segment(5) && $this->uri->segment(5) == "fillable") {
                $data['survey_type'] = "fillable";
                $data['serv_data'] = $this->db->query(" SELECT `sv_st_fillable_surveys`.`Id` AS survey_id,
                `sv_st_fillable_surveys`.`status` AS status,
                `sv_st_category`.`Cat_en`,
                `sv_st_category`.`Cat_ar`,
                `sv_st_fillable_surveys`.`code` AS serv_code,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                COUNT(`sv_st_fillable_questions`.`survey_id`) AS questions_count
                FROM `sv_st_fillable_surveys`
                INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id` 
                INNER JOIN `sv_st_fillable_questions` ON `sv_st_fillable_questions`.`survey_id` = `sv_st_fillable_surveys`.`Id`
                JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_fillable_surveys`.`category`
                WHERE `sv_st_fillable_surveys`.`status` = '1' AND `sv_st_fillable_surveys`.`Id` = '" . $serv_id . "'
                GROUP BY `sv_st_fillable_questions`.`survey_id` ")->result_array();
                $data['questions'] = $this->db->query("SELECT  *
                FROM `sv_st_fillable_questions` 
                WHERE `sv_st_fillable_questions`.`survey_id` = '" . $serv_id . "' ")->result_array();
            } else {
                $data['survey_type'] = "withchoices";
                $data['serv_data'] = $this->db->query(" SELECT `sv_st_surveys`.`Id` AS survey_id,
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
                WHERE `sv_st_surveys`.`status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_surveys`.`Id` = '" . $serv_id . "'
                GROUP BY `sv_st_questions`.`survey_id`")->result_array();
                $data['questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id 
                FROM `sv_st_questions` 
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `survey_id` = '" . $serv_id . "' ")->result_array();
            }
            if (!empty($data['serv_data']) && !empty($data['questions'])) {
                $this->show('EN/Ministry/use_this_survey', $data);
            } else {
                return redirect("EN/DashboardSystem/wellness");
            }
        } else {
            // show error page
        }
    }

    public function startAddingSystem()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;

        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Client_type', 'Client type', 'trim|required|alpha');
            $this->form_validation->set_rules('Client_Department', 'Client Department', 'trim|required|alpha');
            $this->form_validation->set_rules('cousntrie', 'countrie', 'trim|required|numeric');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Client_type = $this->input->post('Client_type');
                $Client_Department = $this->input->post('Client_Department');
                $username = $this->input->post('Username');
                $countrie = $this->input->post('cousntrie');
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);

                if (
                    $Client_type == "Ministry" || $Client_type == "Company"
                    && $Client_Department == "Department" || $Client_Department == "School"
                ) {
                    $iscorrent = $this->db->query("SELECT * FROM `l0_organization` WHERE username = '" . $username . "' ")->result_array();

                    if (empty($iscorrent)) {
                        $data = [
                            'Username' => $username,
                            'password' => $hash_pass,
                            'AR_Title' => $Arabic_Title,
                            'Type' => $Client_type,
                            'Created' => date('Y-m-d'),
                            'EN_Title' => $English_Title,
                            'Department' => $Client_Department,
                            'CountryID' => $countrie,
                            'Company_Type' => '3',
                        ];
                        if ($this->db->insert('l0_organization', $data)) {
                            echo "<script>$('.card .InputForm').html('');</script>";
                            echo '<script>
                                $("#Toast").addClass("inserted_suc");
                            </script>';

                            echo "<h3>The System is Created successfuly </h3><h5>USERNAME : " . $username . " <h5>
                            <h5>PASSWORD : " . $password . " <h5>";
                            echo '<button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal" id="SendEmail"> Send By Email </button>';
                            echo '<button type="button" class="btn btn-dark waves-effect waves-light" style="margin: auto 10px;"> Back To Main Dashboard </button>';
                            echo '<script>
                            $("#getedusername").attr("value","' . $username . '");
                            $("#getedpassword").attr("value","' . $password . '");
                            </script>';
                        }
                    } else {
                        echo 'The user name ' . '"' . $username . '"' . ' is already exist';
                    }
                } else {
                    echo "The Client type or the Client Department you selected is not found ";
                }
            } else {
                echo validation_errors();
            }
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
                    <div id="question_<?php echo $question['q_id'] ?>" class="animate__animated">
                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none" style="border: 0px;">
                                <a href="#quas_<?php echo $question['q_id'] ?>" class="text-dark" data-toggle="collapse"
                                   aria-expanded="true" aria-controls="quas_<?php echo $question['q_id'] ?>">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            <?php echo ($key + 1) . ". " . $question['en_title']; ?>
                                            <i class="mdi mdi-chevron-up float-right accor-down-icon"
                                               style="margin-top: -5px;"></i>
                                        </h6>
                                    </div>
                                </a>

                                <div id="quas_<?php echo $question['q_id'] ?>" class="collapse"
                                     aria-labelledby="headingOne" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <h6><?php echo $question['code']; ?>
                                            | <?php echo $question['TimeStamp']; ?></h6>
                                        <p><?php echo $question['en_desc'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <img src="<?php echo base_url() ?>assets/images/404-error.png" alt="" class="w-100">
                <h3 class="text-center">No data found!!</h3>
                <?php
            }
        }
    }

    public function change_serv_status()
    {
        if ($this->input->post("serv_id") && $this->input->post("type")) {
            $id = $this->input->post("serv_id");
            if ($this->input->post("type") == "change") {
                if ($this->db->query("UPDATE sv_st1_surveys SET status = IF(status=1, 0, 1) WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            } elseif ($this->input->post("type") == "delete") {
                if ($this->db->query("DELETE FROM `sv_st1_surveys` WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            } elseif ($this->input->post("type") == "update_date" && $this->input->post("new_date")) {
                $new_date = $this->input->post("new_date");
                if ($this->db->query("UPDATE sv_st1_surveys SET `End_date` = '" . $new_date . "' WHERE Id = '" . $id . "'")) {
                    echo "ok";
                }
            }
        }
    }

    public function SendInfosEmail()
    {
        $this->load->library('session');
        if ($this->input->post('sendToEmail') && $this->input->post('getedpassword') && $this->input->post('getedusername')) {
            if (!empty($this->input->post('sendToEmail')) && !empty($this->input->post('getedpassword')) && !empty($this->input->post('getedusername'))) {
                $username = $this->input->post('getedusername');
                $password = $this->input->post('getedpassword');
                $email = $this->input->post('sendToEmail');
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
                //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $username . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';

                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
                $this->email->to($email);
                $this->email->bcc('emails@qlicksystems.com');
                $this->email->subject(' You User Name And Password ');
                $this->email->message($messg);

                if (!$this->email->send()) {
                    echo $this->email->print_debugger();
                    echo 'We have an error in sending the email . Please try again later.';
                } else {
                    echo "The Email is Sended";
                    $this->session->set_flashdata('email_sended', 'true');
                    echo "
          <script>
          location.href = '" . base_url() . "EN/DashboardSystem/addSystem';
          </script>
          ";
                }
            }
        }
    }

    public function Message()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Messages ";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/Component/Message', $data);
    }

    public function SendUpdatedInfosEmail()
    {
        $this->load->library('session');
        if ($this->input->post('sendToEmail') && $this->input->post('getedusername')) {

            if (!empty($this->input->post('sendToEmail')) && !empty($this->input->post('getedusername'))) {
                $username = $this->input->post('getedusername');
                $email = $this->input->post('sendToEmail');
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
                //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                $messg = "<center>
          <img src='https://qlickhealth.com/admin/assets/img/qlick-health-logo.png' >
          <h3> Hi there <h3> 
          <h2>Your User name is Updeted To : $username <h2>
          </center>";


                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('jobs@qlicksystems.com', 'qlickhealth');
                $this->email->to($email);
                $this->email->subject(' You User Name And Password ');
                $this->email->message($messg);

                if (!$this->email->send()) {
                    echo 'We have an error in sending the email . Please try again later.';
                } else {
                    echo "the email is sended";
                    $this->session->set_flashdata('email_sended', 'true');
                    echo "
          <script>
          location.href = '" . base_url() . "EN/DashboardSystem/UpdateSystem';
          </script>
          ";
                }
            }
        }
    }

    public function UpdateSystem()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Update System ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` ASC')->result_array();
        $this->show('EN/SuperAdmin/Upadate_System2', $data);
    }

    public function changestatus()
    {
        $id = $this->input->post('adminid');
        $adminstatus = $this->db->query("SELECT * FROM `l0_organization` WHERE  Id = '" . $id . "' LIMIT 1")->result_array();
        foreach ($adminstatus as $adminstat) {
            if ($adminstat['status'] == 1) {
                $enable = true;
                $text = 'disabled';
            } else {
                $enable = false;
                $text = 'enabled';
            }
            $name = $adminstat['Username'];
        }
        if ($enable) {
            $this->db->query("UPDATE l0_organization SET `status` = '0' WHERE Id = '" . $id . "' ");
        } else {
            $this->db->query("UPDATE l0_organization SET `status` = '1' WHERE Id = '" . $id . "' ");
        }
        echo $name . "  is now  " . $text;
    }

    public function listofadmins()
    {
        $id = $this->uri->segment(3);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $data['theadminData'] = $this->db->query("SELECT * FROM l0_organization 
            WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->show('EN/SuperAdmin/UpadateSystemData', $data);
        }
    }

    public function UpdateSystemData()
    {
        $id = $this->uri->segment(3);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $data['theadminData'] = $this->db->query("SELECT * FROM l0_organization 
            WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->show('EN/SuperAdmin/UpadateSystemData', $data);
        }
    }

    public function UpdateSchoolData()
    {
        $id = $this->uri->segment(4);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $data['schoolData'] = $this->db->query("SELECT * FROM l1_school 
            WHERE id = '" . $id . "' AND `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $data['JORDAN'] = $this->JORDAN; // 102 as jordan id
            if (!empty($data['schoolData'])) {
                $this->show('EN/SuperAdmin/UpadateSchoolData', $data);
            } else {
                redirect("EN/DashboardSystem");
            }
        } else {
            redirect("EN/DashboardSystem");
        }
    }

    public function UpdateDepartmentData()
    {
        $id = $this->uri->segment(4);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update department ";
            $data['sessiondata'] = $sessiondata;
            $data['DepartmentData'] = $this->db->query("SELECT * FROM l1_department 
            WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->show('EN/Upadate_Department', $data);
        } else {
            redirect("DashboardSystem");
        }
    }

    public function startUpdatingSystem()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;

        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Client_type', 'Client type', 'trim|required|alpha');
            $this->form_validation->set_rules('Client_Department', 'Client Department', 'trim|required|alpha');
            $this->form_validation->set_rules('cousntrie', 'countrie', 'trim|required|numeric');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Client_type = $this->input->post('Client_type');
                $Client_Department = $this->input->post('Client_Department');
                $username = $this->input->post('Username');
                $countrie = $this->input->post('cousntrie');
                $id = $this->input->post('ID');

                if (
                    $Client_type == "Ministry" || $Client_type == "Company"
                    && $Client_Department == "Department" || $Client_Department == "School"
                ) {
                    $iscorrent = $this->db->query("SELECT *
          FROM `admin` WHERE username = '" . $username . "' AND Id != '" . $id . "' ")->result_array();
                    if (empty($iscorrent)) {
                        if ($this->db->query("UPDATE l0_organization
          SET AR_Title = '" . $Arabic_Title . "', EN_Title = '" . $English_Title . "', Username = '" . $username . "',
          CountryID = '" . $countrie . "', Department = '" . $Client_Department . "' , Type = '" . $Client_type . "' 
          WHERE id = '" . $id . "' ")) {
                            echo '
               <script>
               $("#getedusername").attr("value","' . $username . '");
               </script>';


                            echo "<script>$('.card .InputForm').html('');</script>";
                            echo '<script>
               $("#Toast").addClass("inserted_suc");
               </script>';

                            echo "<h3>The system is updated successfully. </h3><h5>USERNAME : " . $username . " <h5>";

                            echo '
               <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal"> Send By Email </button>';
                            echo '<button type="button" onClick="back();" id="back" class="btn btn-dark waves-effect waves-light" style="margin: auto 10px;"> Back To Systems List  </button>';

                            echo '
               <script>
               $("#getedusername").attr("value","' . $username . '");
               </script>';
                        }
                    } else {
                        echo 'This User Name Is Already Used';
                    }
                } else {
                    echo "The Client type or the Client Department you selected is not found ";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function addSchool()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 1 && $sessiondata['type'] == "Ministry") {
            $data['page_title'] = "Qlick System | Registration School ";
            $data['sessiondata'] = $sessiondata;
            $data['directorate'] = $this->db->get("r_directorate")->result_array();
            $data['sub_directorate'] = $this->db->get("r_directorate_titles")->result_array();
            $data['JORDAN'] = $this->JORDAN;
            $this->show('EN/Ministry/add_school', $data);
        } else {
            redirect('users');
        }
    }

    public function addDepartment()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 1 && $sessiondata['type'] == "Company") {
            $data['page_title'] = "Qlick System | Registration School ";
            $data['sessiondata'] = $sessiondata;
            $this->show('EN/addDepartment', $data);
        } else {
            redirect('users');
        }
    }

    public function startAddingSchool()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;

        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Username')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name', 'trim');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('Country', 'Country', 'trim|required|numeric');
            $this->form_validation->set_rules('city', 'city', 'trim|required|numeric');
            $this->form_validation->set_rules('SchoolId', 'School Id', 'trim|required|max_length[30]');

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $username = $this->input->post('Username');
                $clases = $this->input->post('Clases');
                $Country = $this->input->post('Country');
                $city = $this->input->post('city');
                // Selects
                $School_Gender = $this->input->post('School_Gender');
                $city = $this->input->post('city');
                $Type = $this->input->post('Type');
                $isselected = 0;
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $My_Id = $sessiondata['admin_id'];
                if ($School_Gender == "Male" || $School_Gender == "Female" || $School_Gender == "mix") {
                    $isselected++;
                } else {
                    echo 'Please Select The Gender Of School';
                }
                if (is_numeric($city)) {
                    $isselected++;
                } else {
                    echo 'Please Select The city';
                }
                if ($isselected == 2) {
                    $iscorrent = $this->db->query("SELECT * FROM `l1_school` WHERE Username = '" . $username . "' ")->result_array();
                    $region = str_pad($Country, 4, '0', STR_PAD_LEFT);
                    $parentId = str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
                    $rand = rand(1000, 9999);
                    $genrationcode = $region . $parentId . $rand;
                    if (empty($iscorrent)) {
                        $data = [
                            'Username' => $username,
                            'password' => $hash_pass,
                            'School_Name_AR' => $Arabic_Title,
                            'School_Name_EN' => $English_Title,
                            'Created' => date('Y-m-d'),
                            'Manager_EN' => $Manager_EN,
                            'Manager_AR' => $Manager_AR,
                            'Phone' => $Phone,
                            'Email' => $Email,
                            'Citys' => $city,
                            'Gender' => $School_Gender,
                            'Country' => $Country,
                            'Type_Of_School' => $Type,
                            'Added_By' => $My_Id,
                            'generation' => $genrationcode,
                            'SchoolId' => $this->input->post("SchoolId"),
//                            'Directorate_Id' => 0,
//                            'Directorate_Type_Id' => 0,
                        ];

                        if ($Country == $this->JORDAN) {
                            $data['Directorate_Id'] = $this->input->post("directorate") ?? 0;
                            $data['Directorate_Type_Id'] = $this->input->post("sub_directorate") ?? 0;
                        }

                        if ($this->db->insert('l1_school', $data)) {
                            $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type` , `Company_Type` ,`Created`,`generation`) 
                            VALUES ('" . $username . "','" . $hash_pass . "','school' , '5' ,'" . date('Y-m-d') . "','" . $genrationcode . "')");
                            //    $this->sendNewUserEmail($Email, $password, $username);
                            ?>
                            <script>
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'The data were inserted successfully. The email will be sent to <?php echo $Email; ?>',
                                    icon: 'success',
                                    confirmButtonColor: '#5b8ce8',
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            </script>
                            <?php
                        } else {
                            // $this->db->_error_message();
                        }
                    } else {
                        echo 'The user name ' . '"' . $username . '"' . ' is already exist';
                    }
                } else {
                    echo "please cheke out the data";
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "Please provide the data needed.";
        }
    }

    public function UpdateSchool()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Update System ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadmins'] = $this->db->query('SELECT * FROM l1_school WHERE Added_By = "' . $sessiondata['admin_id'] . '" ORDER BY `Id` ASC')->result_array();
        $this->show('EN/Ministry/Upadate_School', $data);
    }

    public function DepartmentsList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Update System ";
        $data['sessiondata'] = $sessiondata;
        $data['link'] = "DashboardSystem";
        $data['listofadmins'] = $this->db->query('SELECT * , Id as Dept_Id FROM l1_department WHERE Added_By = "' . $sessiondata['admin_id'] . '" ORDER BY `Id` ASC')->result_array();
        $this->show('EN/Ministry/Department_List', $data);
    }

    public function SendSchoolInfosEmail()
    {
        $this->load->library('session');
        if ($this->input->post('sendToEmail') && $this->input->post('getedpassword') && $this->input->post('getedusername')) {

            if (
                !empty($this->input->post('sendToEmail')) && !empty($this->input->post('getedpassword'))
                && !empty($this->input->post('getedusername'))
            ) {
                $username = $this->input->post('getedusername');
                $password = $this->input->post('getedpassword');
                $email = $this->input->post('sendToEmail');
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
                //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";

                $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $username . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
                $this->email->to($email);
                $this->email->subject(' You User Name And Password ');
                $this->email->message($messg);

                if (!$this->email->send()) {
                    echo 'We have an error in sending the email . Please try again later.';
                } else {
                    echo "the email is sended";
                    $this->session->set_flashdata('email_sended', 'true');
                    echo "
          <script>
          location.href = '" . base_url() . "EN/DashboardSystem/addSchool';
          </script>
          ";
                }
            }
        }
    }

    public function startAddingDep()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('Type', 'Department Type', 'trim|required');
            $this->form_validation->set_rules('Country', 'Country', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $parentId = str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
            $rand = rand(1000, 9999);
            $genrationcode = $parentId . $rand;

            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $username = $this->input->post('Username');

                $data = [
                    "Dept_Name_AR" => $Arabic_Title,
                    "Dept_Name_EN" => $English_Title,
                    "Manager_EN" => $Manager_EN,
                    "Manager_AR" => $Manager_AR,
                    "Email" => $Email,
                    "Phone" => $Phone,
                    "Citys" => $this->input->post('city'),
                    "Country" => $this->input->post('Country'),
                    "Type_Of_Dept" => $this->input->post('Type'),
                    "Added_By" => $sessiondata['admin_id'],
                    "Username" => $username,
                    "password" => $hash_pass,
                ];
                $iscorrent = $this->db->query("SELECT * FROM `v_login` WHERE Username = '" . $username . "' ")->result_array();
                if (empty($iscorrent)) {
                    if ($this->db->set($data)->insert('l1_department')) {
                        // $this->sendNewUserEmail($Email, $password, $username);
                        $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`, `Company_Type` ,`Created`,`generation`) 
                        VALUES ('" . $username . "','" . $hash_pass . "','department' , '6' ,'" . date('Y-m-d') . "','" . $genrationcode . "')");
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'The data were inserted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#5b8ce8',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        </script>
                        <?php
                    }
                } else {
                    echo 'The user name ' . '"' . $username . '"' . ' is already taken';
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function changeDepartmentstatus()
    {
        $id = $this->input->post('adminid');
        $adminstatus = $this->db->query("SELECT * FROM `l1_department` WHERE  Id = '" . $id . "' LIMIT 1")->result_array();
        foreach ($adminstatus as $adminstat) {
            if ($adminstat['status'] == 1) {
                $enable = true;
                $text = 'disabled';
            } else {
                $enable = false;
                $text = 'enabled';
            }
            $name = $adminstat['Username'];
        }
        if ($enable) {
            $this->db->query("UPDATE l1_department SET `status` = '0' WHERE Id = '" . $id . "' ");
        } else {
            $this->db->query("UPDATE l1_department SET `status` = '1' WHERE Id = '" . $id . "' ");
        }
        echo $name . "  is now  " . $text;
    }

    public function startUpdatingSchool()
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
            $this->form_validation->set_rules('Type', 'School Type', 'trim|required');
            $this->form_validation->set_rules('School_Gender', 'School Gender', 'trim|required');
            $this->form_validation->set_rules('Country', 'Country', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');

            $id = $this->input->post('ID');

            if ($this->form_validation->run()) {
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');

                if (is_numeric($id)) {
                    $Arabic_Title = $this->input->post('Arabic_Title');
                    $English_Title = $this->input->post('English_Title');
                    $Manager_AR = $this->input->post('Manager_AR');
                    $Manager_EN = $this->input->post('Manager_EN');
                    $Phone = $this->input->post('Phone');
                    $Email = $this->input->post('Email');
                    $Type = $this->input->post('Type');
                    $Country = $this->input->post('Country');
                    $City = $this->input->post('city');
                    $School_Gender = $this->input->post('School_Gender');

                    $data = [
                        'School_Name_AR' => $Arabic_Title,
                        'School_Name_EN' => $English_Title,
                        'Type_Of_School' => $Type,
                        'Gender' => $School_Gender,
                        'Citys' => $City,
                        'Country' => $Country,
                        'Manager_EN' => $Manager_EN,
                        'Manager_AR' => $Manager_AR,
                        'Email' => $Email,
                        'Phone' => $Phone,
                        'Directorate_Id' => 0,
                        'Directorate_Type_Id' => 0,
                    ];

                    if ($Country == $this->JORDAN) {
                        $data['Directorate_Id'] = $this->input->post("directorate") ?? 0;
                        $data['Directorate_Type_Id'] = $this->input->post("sub_directorate") ?? 0;
                    }

                    if ($this->db->set($data)->where("Added_By", $sessiondata['admin_id'])->where("id", $id)->update("l1_school")) {
                        ?>
                        <script>
                            Swal.fire(
                                'success',
                                'The data is updated successfully.',
                                'success'
                            )
                            setTimeout(function () {
                                location.href = "<?php echo base_url(); ?>EN/DashboardSystem/UpdateSchool";
                            }, 1000)
                        </script>
                        <?php

                    }
                } else {
                    echo "<script>
                    location.reload();
                    </script>";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function startUpdatingDepart()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('Type', 'Department Type', 'trim|required');
            $this->form_validation->set_rules('Country', 'Country', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $id = $this->input->post('ID');
            if ($this->form_validation->run()) {
                if (is_numeric($id)) {
                    $Arabic_Title = $this->input->post('Arabic_Title');
                    $English_Title = $this->input->post('English_Title');
                    $Manager_AR = $this->input->post('Manager_AR');
                    $Manager_EN = $this->input->post('Manager_EN');
                    $Phone = $this->input->post('Phone');
                    $Email = $this->input->post('Email');
                    $data = [
                        "Dept_Name_AR" => $Arabic_Title,
                        "Dept_Name_EN" => $English_Title,
                        "Manager_EN" => $Manager_EN,
                        "Manager_AR" => $Manager_AR,
                        "Email" => $Email,
                        "Phone" => $Phone,
                        "Citys" => $this->input->post('city'),
                        "Country" => $this->input->post('Country'),
                        "Type_Of_Dept" => $this->input->post('Type'),
                    ];
                    if ($this->db->where('id', $id)->set($data)->update('l1_department')) {
                        echo "ok";
                    }
                } else {
                    echo "<script>
                    location.reload();
                    </script>";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function AddNewTest()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick System |  Add New Test ";
            $data['sessiondata'] = $sessiondata;
            $this->show('EN/AddTest', $data);
        } else {
            redirect('users');
        }
    }

    public function StartAddNewTest()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('TestCode', 'Test Code', 'trim|required');
            // The Units
            $UnitType = $this->input->post('UnitType');
            if ($UnitType == 1) {
                $this->form_validation->set_rules('Min', 'Min', 'trim|numeric|required');
                $this->form_validation->set_rules('Max', 'Max', 'trim|numeric|required');
            } else {
                $this->form_validation->set_rules('Positive', 'Max Unit', 'trim|required|required');
                $this->form_validation->set_rules('Negative', 'Max Unit', 'trim|required|required');
            }
            // type 1
            $this->form_validation->set_rules('MinUnit', 'Min Unit', 'trim');
            $this->form_validation->set_rules('MaxUnit', 'Max Unit', 'trim');
            // type 2
            $this->form_validation->set_rules('UnitePositive', 'Unite Positive', 'trim');
            $this->form_validation->set_rules('UniteNegative', 'Unite Negative', 'trim');
            if ($this->form_validation->run()) {
                $MinUnit = $this->input->post('MinUnit');
                $MaxUnit = $this->input->post('MaxUnit');
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $TestCode = $this->input->post('TestCode');

                $UnitePositive = $this->input->post('UnitePositive');
                $UniteNegative = $this->input->post('UniteNegative');

                $iscorrentCode = $this->db->query("SELECT * FROM l0_tests WHERE TestCode ='" . $TestCode . "'")->result_array();
                if (empty($iscorrentCode)) {
                    if ($UnitType == 1) {
                        $Min = $this->input->post('Min');
                        $Max = $this->input->post('Max');

                        if ($this->input->post('MaxUnit')) {
                            $MaxUnit = $this->input->post('MaxUnit');
                        } else {
                            $MaxUnit = '';
                        }

                        if ($this->input->post('MinUnit')) {
                            $MinUnit = $this->input->post('MinUnit');
                        } else {
                            $MinUnit = '';
                        }

                        if ($this->db->query("INSERT INTO `l0_tests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES
           ('" . $Arabic_Title . "', '" . $English_Title . "', '" . $TestCode . "', 
           '" . $Min . "', '" . $Max . "','" . date('Y-m-d') . "', '" . $MaxUnit . "', '" . $MinUnit . "', '1'); ")) {
                            $sended = true;
                        }
                    } else {
                        $Positive = $this->input->post('Positive');
                        $Negative = $this->input->post('Negative');

                        if ($this->input->post('UnitePositive')) {
                            $UnitePositive = $this->input->post('UnitePositive');
                        } else {
                            $UnitePositive = '';
                        }

                        if ($this->input->post('UniteNegative')) {
                            $UniteNegative = $this->input->post('UniteNegative');
                        } else {
                            $UniteNegative = '';
                        }
                        if ($this->db->query("INSERT INTO `l0_tests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES ('" . $Arabic_Title . "', '" . $English_Title . "', '" . $TestCode . "', 
           '" . $Negative . "', '" . $Positive . "','" . date('Y-m-d') . "', '" . $UnitePositive . "', '" . $UniteNegative . "', '0'); ")) {
                            $sended = true;
                        }
                    }

                    if ($sended) {
                        echo "   
        <script>   
        Swal.fire({
        title: 'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b8ce8',
        cancelButtonColor: '#f46a6a'
          });
        </script>   
          ";
                        /* echo "
        <script>
    $('#sa-warning').click(function () {
      Swal.fire({
        title:'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b73e8',
        cancelButtonColor: '#21307A' ,
        confirmButtonText: 'Add New One'
        cancelButtonText: 'Back To Dashboard'
      }).then(function (result) {
        if (result.value) {
        Location.reload();
        }else{
        location.href =  '".base_url()."EN/Dashboard'

         }
          }
          )}; //Parameter


        </script>
          ";*/
                    }
                } else {
                    echo "This Test is Already Added";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function TestsList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick System |  Add New Test ";
            $data['sessiondata'] = $sessiondata;
            $data['listofadmins'] = $this->db->query('SELECT * FROM l0_tests ORDER BY `Id` DESC ')->result_array();
            $this->show('EN/TestsList', $data);
        } else {
            redirect('users');
        }
    }

    public function ConnectedTests()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick System |   Manage Connecting  ";
            $data['sessiondata'] = $sessiondata;
            $data['listofadmins'] = $this->db->query('SELECT * FROM l0_systemtwithtest ORDER BY `Id` DESC ')->result_array();
            $this->show('EN/ConnectedTests', $data);
        } else {
            redirect('users');
        }
    }

    public function UpdateTestData()
    {
        $this->load->library('session');
        $id = $this->uri->segment(3);
        $sessiondata = $this->session->userdata('admin_details');
        if (is_numeric($id) && $sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $data['TestData'] = $this->db->query("SELECT * FROM l0_tests 
          WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->show('EN/UpdateTestData', $data);
        } else {
            redirect('users');
        }
    }

    public function StartUpdateTestData()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('TestCode', 'Test Code', 'trim|required');
            // The Units
            $UnitType = $this->input->post('UnitType');
            if ($UnitType == 1) {
                $this->form_validation->set_rules('Min', 'Min', 'trim|numeric|required');
                $this->form_validation->set_rules('Max', 'Max', 'trim|numeric|required');
            } else {
                $this->form_validation->set_rules('Positive', 'Max Unit', 'trim|required|required');
                $this->form_validation->set_rules('Negative', 'Max Unit', 'trim|required|required');
            }
            // type 1
            $this->form_validation->set_rules('MinUnit', 'Min Unit', 'trim');
            $this->form_validation->set_rules('MaxUnit', 'Max Unit', 'trim');
            // type 2
            $this->form_validation->set_rules('UnitePositive', 'Unite Positive', 'trim');
            $this->form_validation->set_rules('UniteNegative', 'Unite Negative', 'trim');
            if ($this->form_validation->run()) {
                $MinUnit = $this->input->post('MinUnit');
                $MaxUnit = $this->input->post('MaxUnit');
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $TestCode = $this->input->post('TestCode');
                $id = $this->input->post('ID');

                $UnitePositive = $this->input->post('UnitePositive');
                $UniteNegative = $this->input->post('UniteNegative');

                $iscorrentCode = $this->db->query("SELECT * FROM l0_tests WHERE TestCode ='" . $TestCode . "' AND Id != '" . $id . "' ")->result_array();
                if (empty($iscorrentCode)) {
                    if ($UnitType == 1) {
                        $Min = $this->input->post('Min');
                        $Max = $this->input->post('Max');

                        if ($this->input->post('MaxUnit')) {
                            $MaxUnit = $this->input->post('MaxUnit');
                        } else {
                            $MaxUnit = '';
                        }

                        if ($this->input->post('MinUnit')) {
                            $MinUnit = $this->input->post('MinUnit');
                        } else {
                            $MinUnit = '';
                        }

                        /* if($this->db->query("INSERT INTO `tbltests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES
           ('".$Arabic_Title."', '".$English_Title."', '".$TestCode."',
           '".$Min."', '".$Max."','".date('Y-m-d')."', '".$MaxUnit."', '".$MinUnit."', '1'); ")){ */
                        if ($this->db->query(" UPDATE `l0_tests` SET TestName_AR = '" . $Arabic_Title . "' ,
     TestName_EN = '" . $English_Title . "', TestCode = '" . $TestCode . "' , TestMin = '" . $Min . "', TestMax = '" . $Max . "', 
     Created = '" . date('Y-m-d') . "' ,MaxUnit = '" . $MaxUnit . "', MinUnit = '" . $MinUnit . "' ,Ch= '1'  WHERE Id = '" . $id . "' ")) {
                            $sended = true;
                        }
                    } else {
                        $Positive = $this->input->post('Positive');
                        $Negative = $this->input->post('Negative');

                        if ($this->input->post('UnitePositive')) {
                            $UnitePositive = $this->input->post('UnitePositive');
                        } else {
                            $UnitePositive = '';
                        }

                        if ($this->input->post('UniteNegative')) {
                            $UniteNegative = $this->input->post('UniteNegative');
                        } else {
                            $UniteNegative = '';
                        }
                        /*if($this->db->query("INSERT INTO `tbltests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES ('".$Arabic_Title."', '".$English_Title."', '".$TestCode."',
           '".$Negative."', '".$Positive."','".date('Y-m-d')."', '".$UnitePositive."', '".$UniteNegative."', '0'); ")){*/
                        if ($this->db->query(" UPDATE `tbltests` SET TestName_AR = '" . $Arabic_Title . "' ,
     TestName_EN = '" . $English_Title . "', TestCode = '" . $TestCode . "' , TestMin = '" . $Negative . "', TestMax = '" . $Positive . "', 
     Created = '" . date('Y-m-d') . "' ,MaxUnit = '" . $UnitePositive . "', MinUnit = '" . $UniteNegative . "', Ch= '0' WHERE Id = '" . $id . "' ")) {
                            $sended = true;
                        }
                    }

                    if ($sended) {
                        echo "   
        <script>   
        Swal.fire({
        title: 'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b8ce8',
        cancelButtonColor: '#f46a6a'
          });
        </script>   
          ";
                        /* echo "
        <script>
    $('#sa-warning').click(function () {
      Swal.fire({
        title:'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b73e8',
        cancelButtonColor: '#21307A' ,
        confirmButtonText: 'Add New One'
        cancelButtonText: 'Back To Dashboard'
      }).then(function (result) {
        if (result.value) {
        Location.reload();
        }else{
        location.href =  '".base_url()."EN/Dashboard'

         }
          }
          )}; //Parameter


        </script>
          ";*/
                    } else {
                        echo "error";
                    }
                } else {
                    echo "This Test is Already Added";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function StartLink()
    {
        $this->load->library('form_validation');
        if ($this->input->post('System') && $this->input->post('Test')) {
            $this->form_validation->set_rules('System', 'System', 'trim|required');
            $this->form_validation->set_rules('Test', 'test type', 'trim|required');
            if ($this->form_validation->run()) {
                $system = $this->input->post('System');
                $Test = $this->input->post('Test');
                if (is_numeric($system) && is_numeric($Test)) {

                    $isexist = $this->db->query("SELECT * FROM l0_systemtwithtest WHERE SystemId = '" . $system . "' AND TestId = '" . $Test . "' ")->num_rows();
                    if ($isexist == 0) {
                        if ($this->db->query("INSERT INTO `l0_systemtwithtest` (`SystemId`, `TestId` ,`Created`)
       VALUES ('" . $system . "', '" . $Test . "','" . date('Y-m-d') . "');")) {
                            echo "The Test Was Added";
                            echo "   
        <script>   
        Swal.fire({
        title: 'Success',
        text: 'The Test Was Added !',
        icon: 'success',
        confirmButtonColor: '#5b8ce8',
          });
        </script>   
          ";
                        } else {
                            echo "Oops!! We have an error";
                        }
                    } else {
                        echo "This system is already exists";
                    }
                }
            } else {
            }
        } else {
            echo
            '<script>
          location.reload();
          </script>';
        }
    }

    public function getTests()
    {
        $id = $this->input->post('id');
        $tests = $this->db->query("SELECT * FROM  l0_tests ")->result_array();
        $corent = $this->db->query("SELECT * FROM l0_systemtwithtest WHERE SystemId = '" . $id . "' ")->result_array();
        $options = 0;
        echo '<Select Class="custom-select" name="Test">';
        if (!empty($corent)) {
            foreach ($corent as $ses) {
                $idTest = $ses['TestId'];
                $ids_array = array();
                $ids_array[] = $idTest;
                foreach ($tests as $data) {
                    if (!in_array($data['Id'], $ids_array)) {
                        echo '<option value="' . $idTest . '" class="option" >' . $data['TestCode'] . '</option>';
                        $options++;
                    }
                }
            }
        } else {
            $testslist = $this->db->query("SELECT * FROM l0_tests ")->result_array();
            foreach ($testslist as $test) {
                echo '<option value="' . $test['Id'] . '" class="option" >' . $test['TestCode'] . '</option>';
            }
            $options++;
            print_r($testslist);
        }
        if ($options <= 0) {
            echo '<option value="no Data Found" class="option" >No data found</option>';
        }
        echo '</select>';
    }

    public function DeletConnect()
    {
        $id = $this->input->post('Conid');
        if ($this->db->query(" DELETE FROM l0_systemtwithtest WHERE Id = '" . $id . "'  ")) {
            echo "The connect deleted";
        } else {
            echo "Oops we have an error please try again later";
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
                $data = array(
                    'Title_en' => $this->input->post('title_en'),
                    'Title_ar' => $this->input->post('title_ar'),
                    'Startting_date' => $this->input->post('Start'),
                    'End_date' => $this->input->post('End'),
                    'Avalaible_to' => $this->input->post('avalaible_to'),
                    'Status' => $this->input->post('status') == 1 ? "0" : "1",
                    'Survey_id' => $this->input->post('serv_id'),
                    'Created' => date('Y-m-d'),
                    'Time' => date("H:i:s"),
                    'survey_type' => $surveyType,
                    'Published_by' => $sessiondata["admin_id"]
                );
                if ($this->db->insert('sv_st1_surveys', $data)) {
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

    public function sites_reports()
    {
        if ($this->permissions_array["temperatureandlabs"]) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Sites Results";
            $data['sessiondata'] = $sessiondata;
            $this->show('EN/Ministry/Rep/sites_reports', $data);
        } else {
            $dataDes['to'] = "EN/DashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function wellness()
    {
        $this->load->library('session');
        $this->load->model('ministry/sv_ministry_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data = [];
        $data['page_title'] = "Qlick Health | Add Device";
        $data['sessiondata'] = $sessiondata;
        $schoolsIds = $this->sv_ministry_reports->getSchools(true);
        $schoolsIdsAsStr = implode(",", $schoolsIds);

        if (empty($schoolsIds)) {
            $data['hasntnav'] = true;
            $this->load->view('EN/inc/header', $data);
            return $this->load->view('EN/Ministry/Empty-systeme');
        }

        $data['expired_surveys'] = $this->sv_ministry_reports->expired_surveys();
        $data['completed_surveys'] = $this->sv_ministry_reports->completed_surveys();
        $data['answerd_quastions'] = $this->sv_ministry_reports->answerd_quastions();
        $data['themes'] = array();
        $data['teachers_surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_en` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `en_answer_group`.`title_en` AS choices_en_title ,
        `ar_answer_group`.`title_en` AS choices_ar_title 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $schoolsIdsAsStr . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '3' 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        WHERE `sv_st_surveys`.`targeted_type` = 'M'
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        $data['teachers_quastions'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_en` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_questions`.`Id`   AS q_id,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `en_answer_group`.`title_en` AS choices_en_title ,
        `ar_answer_group`.`title_en` AS choices_ar_title 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $schoolsIdsAsStr . ")
        JOIN `sv_school_published_surveys_types` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`targeted_type` = 'M'
        GROUP BY  `sv_st_questions`.`Id`  ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        $data['teachers_completed_surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_en` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `en_answer_group`.`title_en` AS choices_en_title ,
        `ar_answer_group`.`title_en` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $schoolsIdsAsStr . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '3' ) 
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        $finishing_teachers_data = $this->db->query(" SELECT
        `sv_st1_answers`.`finishing_time` AS Finishing_time,
        AVG(`sv_st1_answers`.`finishing_time`) AS Finishing_time_avg ,
        SUM(`sv_st1_answers`.`finishing_time`) AS sum_of_all
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $schoolsIdsAsStr . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '3' ) 
        GROUP BY `sv_st1_surveys`.`survey_id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        $data['surveys'] = $this->sv_ministry_reports->our_surveys($sessiondata['admin_id']);
        $data['fillable_surveys'] = $this->sv_ministry_reports->our_surveys($sessiondata['admin_id'], true);
        $data['our_surveys'] = $data['surveys'];
        $data['avalaible_surveys'] = $this->sv_ministry_reports->avalaible_surveys();
        $data['avalaible_fillable_surveys'] = $this->sv_ministry_reports->avalaible_surveys(true); // return avalaible_fillable_surveys
        // reports
        $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
        $data['surveys_for_all_genders'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id']);
        $ages_arr = array_column($this->sv_ministry_reports->ages_forall_users($sessiondata['admin_id'], false), "DOP");
        $users_passed_survey_ages_options_ages = array_column($this->sv_ministry_reports->ages_for_all_passed_users($sessiondata['admin_id'], false), "DOP");
        $data['used_categorys'] = $this->sv_ministry_reports->usedcategorys();
        // teachers start
        $data['teachers_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '3');
        $data['teachers_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '3');
        $data['teachers_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '3');
        $finishing_teachers_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '3');
        $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
        // staffs start
        $data['staff_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '1');
        $data['staff_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '1');
        $data['staff_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '1');
        $finishing_staffs_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '1');
        $data['finishing_time_staff'] = $this->calculate_avg_time($finishing_staffs_data);
        // parents start
        $data['parents_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '4');
        $data['parents_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '4');
        $data['parents_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '4');
        $finishing_parents_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '4');
        $data['finishing_time_parents'] = $this->calculate_avg_time($finishing_parents_data);
        // students start
        $data['students_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '2');
        $data['students_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '2');
        $data['students_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
        $finishing_students_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '2');
        $data['finishing_time_students'] = $this->calculate_avg_time($finishing_students_data);

        // loading the vie2
        $data['surveys_for_males'] = [];
        $data['surveys_for_females'] = [];
        $data['surveys_for_males']['active'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '1', "", false);
        $data['surveys_for_females']['active'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '2', "", false);
        $data['surveys_for_males']['expired'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '1', "", true);
        $data['surveys_for_females']['expired'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '2', "", true);
        // $data['surveys_for_all_genders'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id']);
        $finishing_all_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id']);
        $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
        $data['ages'] = array_count_values($ages_arr);
        $data['users_passed_survey_ages_options_ages'] = array_count_values($users_passed_survey_ages_options_ages);
        //$data['ages_with_groups'] = $this->sv_ministry_reports->ages_forall_users($sessiondata['admin_id'], true);
        $data['ages_with_groups'] = $this->sv_ministry_reports->ages_for_all_passed_users($sessiondata['admin_id'], true);
        foreach (['expired', 'active'] as $type) {
            $data['teachers_surveys'][$type] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '3', ($type == "expired"));
            $data['staff_surveys'][$type] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '1', ($type == "expired"));
            $data['parents_surveys'][$type] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '4', ($type == "expired"));
            $data['students_surveys'][$type] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '2', ($type == "expired"));
        }
        // students reports
        $data['gend_students_males'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('M', '2'));
        $data['gend_students_females'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('F', '2'));
        $data['students_matural'] = $this->sv_ministry_reports->martial_status('2');
        // teachers reports
        $data['gend_teachers_males'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('M', '3'));
        $data['gend_teachers_females'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('F', '3'));
        $data['teachers_matural'] = $this->sv_ministry_reports->martial_status('3');
        // staff reports
        $data['gend_staffs_males'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('M', '1'));
        $data['gend_staffs_females'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('F', '1'));
        $data['staffs_matural'] = $this->sv_ministry_reports->martial_status('1');
        // parents reports
        $data['gend_parents_males'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('M', '4'));
        $data['gend_parents_females'] = sizeof($this->sv_ministry_reports->get_all_surv_percintage_by_gender('F', '4'));
        $data['parents_matural'] = $this->sv_ministry_reports->martial_status('4');
        /// published surveys counters
        $counter_of_published_surveys = array();
        $counter_of_published_surveys['students'] = sizeof($this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '2'));
        $counter_of_published_surveys['teachers'] = sizeof($this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '3'));
        $counter_of_published_surveys['staffs'] = sizeof($this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '1'));
        $counter_of_published_surveys['Parents'] = sizeof($this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '4'));
        // Expired  surveys counters
        $counter_of_expired_surveys = array();
        $counter_of_expired_surveys['students'] = sizeof($this->sv_ministry_reports->expired_surveys_by_type($sessiondata['admin_id'], '2'));
        $counter_of_expired_surveys['teachers'] = sizeof($this->sv_ministry_reports->expired_surveys_by_type($sessiondata['admin_id'], '3'));
        $counter_of_expired_surveys['staffs'] = sizeof($this->sv_ministry_reports->expired_surveys_by_type($sessiondata['admin_id'], '1'));
        $counter_of_expired_surveys['Parents'] = sizeof($this->sv_ministry_reports->expired_surveys_by_type($sessiondata['admin_id'], '4'));
        // completed  surveys counters surveys
        $counter_of_completed_surveys = array();
        $counter_of_completed_surveys['students'] = sizeof($this->sv_ministry_reports->completed_surveys('2'));
        $counter_of_completed_surveys['teachers'] = sizeof($this->sv_ministry_reports->completed_surveys('3'));
        $counter_of_completed_surveys['staffs'] = sizeof($this->sv_ministry_reports->completed_surveys('1'));
        $counter_of_completed_surveys['Parents'] = sizeof($this->sv_ministry_reports->completed_surveys('4'));
        // passing arrays to the view  answered questions
        $data['counter_of_published_surveys'] = $counter_of_published_surveys;
        $data['counter_of_expired_surveys'] = $counter_of_expired_surveys;
        $data['counter_of_completed_surveys'] = $counter_of_completed_surveys;
        $data['categorys'] = $this->db->query("SELECT * FROM `sv_st_category`
        WHERE (action_en_url AND report_en_url AND media_en_url) IS NOT NULL ORDER BY `Id` DESC ")->result_array();
        $this->load->helper('directory');
        $data['gallery_files'] = directory_map('./assets/images/gallery');
        $this->show('EN/Ministry/wellness', $data);
    }

    public function our_surveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `surveys` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $data['page_title'] = "Qlick Health | Manage Surveys";
            $data['sessiondata'] = $sessiondata;
            $data['surveys'] = $this->db->query(" SELECT
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `en_answer_group`.`title_en` AS choices_en_title ,
            `ar_answer_group`.`title_en` AS choices_ar_title 
          /*COUNT(`sv_st_questions`.`survey_id`) AS questions_count */
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
          /*INNER JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id` */
            JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar` 
            WHERE `sv_st_surveys`.`targeted_type` = 'M'")->result_array();
            //JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
            $this->show('EN/Ministry/Manage_our_surveys', $data);
        } else {
            $dataDes['to'] = "EN/dashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    private function calculate_avg_time($returned_data)
    {
        $durations = array_column($returned_data, 'Finishing_time');
        $sum = '0';
        foreach ($durations as $duration) {
            list($h, $m, $s) = explode(':', $duration);
            $sum = bcadd($sum, bcmul($h, '3600'));
            $sum = bcadd($sum, bcmul($m, '60'));
            $sum = bcadd($sum, $s);
        }
        $count = count($durations);
        if ($count !== 0) {
            $avg = bcdiv($sum, $count);
            $hours = floor($avg / 3600);
            $mins = intval(bcdiv(bcmod($avg, '3600'), '60'));
            $secs = bcmod($avg, '60');
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            return $timeFormat;
        } else {
            return "--:--:--";
        }
    }

    public function survey_preview()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar 
            FROM `sv_st1_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st1_surveys`.`Id` = '" . $data['serv_id'] . "' ")->result_array();

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
                $this->load->view("EN/Ministry/inc/preview_header", $data);
                $this->load->view("EN/Ministry/preview_survey");
                $this->load->view("EN/inc/footer");
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('EN/Ministry/wellness');
        }
    }

    public function survey_reports()
    {
        $accepte = ["staff", "teachers", "students", "parents"];
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && !$this->uri->segment(5)) {
            // start querys here
            $this->load->model('ministry/sv_ministry_reports');
            $serv_id = $this->uri->segment(4);
            if (empty($this->sv_ministry_reports->get_surv_data($serv_id))) {
                echo "No data found !";
                return;
            }
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['users_types'] = array(1, 2, 3, 4);
            // for all
            $data['users_passed_survey'] = $this->sv_ministry_reports->users_passed_survey($serv_id);
            $data['allPassed_Counter'] = sizeof($data['users_passed_survey']);
            // Staffs
            $data['Staffs'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '1');
            // teachers
            $data['Teachers'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '3');
            // students
            $data['Students'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '2');
            // Parents
            $data['Parents'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '4');
            $data['used_choices'] = $this->sv_ministry_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_ministry_reports->get_surv_quastions($serv_id);
            $data['results_array'] = array();
            $data['main_surv_id'] = $this->sv_ministry_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_ministry_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_ministry_reports->get_surv_percintage_by_gender($serv_id, 'M'));
            $data['females_count'] = $this->count_gender($this->sv_ministry_reports->get_surv_percintage_by_gender($serv_id, 'F'));
            $data['cond'] = "AND EXISTS (SELECT Id FROM `sv_school_published_surveys` WHERE `Serv_id` = '" . $data['serv_id'] . "')";
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "counter" => 0);
            }
            $data['choice_arr'] = $choice_arr;
            $this->show('EN/Ministry/survey_report', $data);
        } elseif ($this->uri->segment(5) && in_array(strtolower($this->uri->segment(5)), $accepte)) { // here start the spicific function page
            // setting variables
            $type = $this->uri->segment(5);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['type_of_user'] = strtolower($type);
            $ourschools = implode(',', array_column($this->db->get_where("l1_school", ["Added_By" => $sessiondata['admin_id']])->result_array(), "Id"));
            // start data getting
            $this->load->model('ministry/sv_ministry_reports');
            $serv_id = $this->uri->segment(4);
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['serv_id'] = $serv_id;
            if ($data['type_of_user'] == "staff") {
                $ages_array = $this->sv_ministry_reports->get_users_ages($serv_id, '1');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $user_type_code = '1';
                $data['count_all'] = $this->db->query("SELECT Id FROM l2_staff WHERE `Added_By` IN ( " . $ourschools . " )")->num_rows();
            } elseif ($data['type_of_user'] == "teachers") {

                $ages_array = $this->sv_ministry_reports->get_users_ages($serv_id, '3');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $data['count_all'] = $this->db->query("SELECT Id FROM l2_teacher WHERE `Added_By` IN ( " . $ourschools . " )")->num_rows();
                $user_type_code = '3';
            } elseif ($data['type_of_user'] == "students") {
                // making the data for showing it in #radial_chart

                $levels = array();
                $accepted_foreach = array();
                $simple_levels_names_arr = array();
                $avalaible_types_of_classes = $this->db->get('education_profile')->result_array();
                $students_completed_surveys = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
                $ages_array = $this->sv_ministry_reports->get_users_ages($serv_id, '2');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                // students_completed_surveys
                foreach ($avalaible_types_of_classes as $cl_id => $class) {
                    $levels[$class['name']] = 0;
                    $simple_levels_names_arr[] = $class['name'];
                    $accepted_foreach[$class['name']] = explode(";", $class['Classes']);
                }
                foreach ($students_completed_surveys as $key => $students) {
                    foreach ($levels as $key => $level) {
                        if (in_array($students['Student_class'], $accepted_foreach[$key])) {
                            $levels[$key] = $levels[$key] + 1;
                        }
                    }
                }
                $lables_arr = array_map(function ($name) {
                    return "'" . $name . "'";
                }, $simple_levels_names_arr);
                // pass the data
                $data['levels'] = $levels;
                $data['lables_arr'] = $lables_arr;
                // static
                $data['count_all'] = $this->db->query("SELECT Id FROM l2_student WHERE `Added_By` IN ( " . $ourschools . " )")->num_rows();
                $user_type_code = '2';
            } elseif ($data['type_of_user'] == "parents") {

                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '4');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $data['count_all'] = "10"; // chnage later
                $user_type_code = '4';
            }
            // for all
            $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
            $data['allPassed_Counter'] = sizeof($data['users_passed_survey']);
            $data['used_choices'] = $this->sv_school_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_school_reports->get_surv_quastions($serv_id);
            $data['results_array'] = array();
            $data['main_surv_id'] = $this->sv_school_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_school_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M', $user_type_code));
            $data['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F', $user_type_code));
            $data['users_types'] = array($user_type_code);
            $data['reportdata'] = $this->sv_school_reports->users_passed_survey($serv_id, $user_type_code);
            $data['user_code'] = $user_type_code;
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "counter" => 0);
            }
            $data['choice_arr'] = $choice_arr;
            $this->show('EN/Ministry/survey_report_sp', $data);
        } else {
            $this->load->view('EN/Global/accessForbidden');
        }
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

    public function school_survey_reports()
    {
        $data['fromMinistry'] = true;
        $accepte = ["staff", "teachers", "students", "parents"];
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->db->Is_existInTable($this->uri->segment(4), 'sv_school_published_surveys') && !$this->uri->segment(5)) {
            // start querys here
            $this->load->model('schools/sv_school_reports');
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['users_types'] = array(1, 2, 3, 4);
            // for all
            $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
            // $this->response->dd($data['users_passed_survey']);
            $data['allPassed_Counter'] = sizeof($data['users_passed_survey']);
            // Staffs
            $data['Staffs'] = $this->sv_school_reports->users_passed_survey($serv_id, '1');
            // teachers
            $data['Teachers'] = $this->sv_school_reports->users_passed_survey($serv_id, '3');
            // students
            $data['Students'] = $this->sv_school_reports->users_passed_survey($serv_id, '2');
            // Parents
            $data['Parents'] = $this->sv_school_reports->users_passed_survey($serv_id, '4');
            $data['used_choices'] = $this->sv_school_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_school_reports->get_surv_quastions($serv_id);
            $data['results_array'] = array();
            $data['main_surv_id'] = $this->sv_school_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_school_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M'));
            $data['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F'));
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "id" => $choice['Id'], "counter" => 0);
            }
            // $this->response->dd($choice_arr);
            $data['choice_arr'] = $choice_arr;
            $this->show('EN/schools/survey_report', $data);
        } elseif ($this->uri->segment(5) && in_array(strtolower($this->uri->segment(5)), $accepte)) { // here start the spicific function page
            // setting variables
            $type = $this->uri->segment(5);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['type_of_user'] = strtolower($type);
            // start data getting
            $this->load->model('schools/sv_school_reports');
            $serv_id = $this->uri->segment(4);
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['serv_id'] = $serv_id;
            if ($data['type_of_user'] == "staff") {
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '1');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $user_type_code = '1';
                $data['count_all'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->num_rows();
            } elseif ($data['type_of_user'] == "teachers") {
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '3');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $data['count_all'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '3';
            } elseif ($data['type_of_user'] == "students") {
                // making the data for showing it in #radial_chart
                $levels = array();
                $accepted_foreach = array();
                $simple_levels_names_arr = array();
                $avalaible_types_of_classes = $this->db->get('education_profile')->result_array();
                $students_completed_surveys = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '2');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                // students_completed_surveys
                foreach ($avalaible_types_of_classes as $cl_id => $class) {
                    $levels[$class['name']] = 0;
                    $simple_levels_names_arr[] = $class['name'];
                    $accepted_foreach[$class['name']] = explode(";", $class['Classes']);
                }
                foreach ($students_completed_surveys as $key => $students) {
                    foreach ($levels as $key => $level) {
                        if (in_array($students['Student_class'], $accepted_foreach[$key])) {
                            $levels[$key] = $levels[$key] + 1;
                        }
                    }
                }
                $lables_arr = array_map(function ($name) {
                    return "'" . $name . "'";
                }, $simple_levels_names_arr);
                // pass the data
                $data['levels'] = $levels;
                $data['lables_arr'] = $lables_arr;
                // static
                $data['count_all'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '2';
            } elseif ($data['type_of_user'] == "parents") {
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '4');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $data['count_all'] = "10"; // chnage later
                $user_type_code = '4';
            }
            // for all
            $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
            $data['allPassed_Counter'] = sizeof($data['users_passed_survey']);
            $data['used_choices'] = $this->sv_school_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_school_reports->get_surv_quastions($serv_id);
            $data['results_array'] = array();
            $data['main_surv_id'] = $this->sv_school_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_school_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M', $user_type_code));
            $data['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F', $user_type_code));
            $data['users_types'] = array($user_type_code);
            $data['reportdata'] = $this->sv_school_reports->users_passed_survey($serv_id, $user_type_code);
            $data['user_code'] = $user_type_code;
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "counter" => 0);
            }
            $data['choice_arr'] = $choice_arr;
            $this->show('EN/schools/survey_report_sp', $data);
        } else {
            $this->load->view('EN/Global/accessForbidden');
        }
    }

    public function school_survey_report_view()
    {
        $this->load->model('schools/sv_school_reports');
        $data['fromMinistry'] = true;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
            WHERE `sv_school_published_surveys`.`Id` = '" . $serv_id . "' AND `sv_st1_surveys`.`Status` = '1'
            AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            if (!empty($data['serv_data'])) {
                $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
                $data['serv_theme'] = $data['serv_data'][0]['serv_theme'];
                $data['serv_img'] = $data['serv_data'][0]['image_name'];
                $group = $data['serv_data'][0]['main_survey_id'];
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'
                ORDER BY `sv_st_groups`.`position` ASC")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' 
                ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                $group_coices = $data['serv_data'][0]['group_id'];
                $data['group_choices'] = $group_coices;
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                $this->show("EN/schools/report_view_survey", $data);
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('EN/schools/wellness');
        }
    }

    public function schools_question_choice_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && $this->uri->segment(7)) {
            $survey_id = $this->uri->segment(4);
            $choice_id = $this->uri->segment(5);
            $question_id = $this->uri->segment(6);
            $perc = $this->uri->segment(7);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $choice_data = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
            WHERE `Id` = '" . $choice_id . "' ")->result_array();
            $data['name'] = $choice_data[0]['title_en'];
            $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice_id . "' ")->num_rows();
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $survey_id;
            $data['question_id'] = $question_id;
            $data['choice_id'] = $choice_id;
            $data['question_id'] = $question_id;
            $data['perc'] = $perc;
            $data['by_types'] = $this->db->query("SELECT 
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' ) AS Total  
            ")->result_array();
            //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
            $this->load->model('schools/sv_school_reports');
            $data['males'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "M"));
            $data['females'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "F"));
            $this->load->view("EN/schools/report_question_survey", $data);
        }
    }

    public function school_question_detailed_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && $this->uri->segment(7)) {
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
                $data['serv_id'] = $survey_id;
                $data['name'] = $choice['title_en'];
                $data['question_id'] = $question_id;
                $data['choice_id'] = $choice['Id'];
                $data['question_id'] = $question_id;
                $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice['Id'] . "' ")->num_rows();
                $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "'  ")->num_rows();
                $perc = $this->calc_perc($data['use_count'], $all_count);
                $data['perc'] = $perc;
                $data['by_types'] = $this->db->query("SELECT 
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' ) AS Total  
                ")->result_array();
                //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
                $this->load->model('schools/sv_school_reports');
                $data['males'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "M"));
                $data['females'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "F"));
                $this->load->view("EN/schools/report_question_survey", $data);
            }
        } else {
            redirect('EN/Schools/wellness');
        }
    }

    private function calc_perc($perc, $all)
    {
        $x = $perc;
        $y = $all;
        if ($x > 0 && $y > 0) {
            $percent = $x / $y;
            $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
        } else {
            $percent_friendly = 0;
        }
        return $percent_friendly;
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
            $ourschools = implode(',', array_column($this->db->get_where("l1_school", ["Added_By" => $sessiondata['admin_id']])->result_array(), "Id"));
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
            WHERE `sv_school_published_surveys`.`Id` = '" . $serv_id . "' AND `sv_st1_surveys`.`Status` = '1'
            AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_school_published_surveys`.`By_school` IN (" . $ourschools . ") ")->result_array();
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
                $this->show("EN/Ministry/report_view_survey", $data);
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('EN/DashboardSystem/wellness');
        }
    }

    public function serv_reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $user_id = $sessiondata['admin_id'];
        $this->load->model('ministry/sv_ministry_reports'); // loading the model
        // preparing the data
        // get results four card in top
        $data['surveys'] = $this->sv_ministry_reports->our_surveys($user_id);
        $data['expired_surveys'] = $this->sv_ministry_reports->expired_surveys($user_id);
        $data['completed_surveys'] = $this->sv_ministry_reports->completed_surveys($user_id);
        $data['answerd_quastions'] = $this->sv_ministry_reports->answerd_quastions($user_id);
        // sp
        // teachers start
        $data['teachers_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '3');
        $data['teachers_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '3');
        $data['teachers_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '3');
        $finishing_teachers_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '3');
        $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
        // staffs start
        $data['staff_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '1');
        $data['staff_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '1');
        $data['staff_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '1');
        $finishing_staffs_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '1');
        $data['finishing_time_staff'] = $this->calculate_avg_time($finishing_staffs_data);
        // parents start
        $data['parents_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '4');
        $data['parents_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '4');
        $data['parents_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '4');
        $finishing_parents_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '4');
        $data['finishing_time_parents'] = $this->calculate_avg_time($finishing_parents_data);
        // students start
        $data['students_surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], '2');
        $data['students_quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], '2');
        $data['students_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
        $finishing_students_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '2');
        $data['finishing_time_students'] = $this->calculate_avg_time($finishing_students_data); // Assign a value to $finishing_time_students

        // loading the vie2
        $data['surveys_for_males'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '1');
        $data['surveys_for_females'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '2');
        $data['surveys_for_all_genders'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id']);
        $finishing_all_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id']);
        // published durveys fo the scroll of reports
        $data['our_surveys'] = $this->sv_ministry_reports->our_surveys($sessiondata['admin_id'], '2');
        $data['count_all_staffs'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->num_rows();
        $data['count_all_Teachers'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->num_rows();
        $data['count_all_Students'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
        $data['avalaible_types_of_classes'] = $this->db->get('education_profile')->result_array();
        $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
        $this->load->view('EN/Ministry/inc/serv_reports', $data); // loading the view
    }

    public function specific_surveys_reports()
    {
        $accepte = ["staff", "teachers", "students", "parents"];
        if ($this->uri->segment(4) && in_array(strtolower($this->uri->segment(4)), $accepte)) {
            $this->load->library('session');
            $today = date('Y-m-d');
            $data['type_of_user'] = strtolower($this->uri->segment(4));
            $this->load->model('ministry/sv_ministry_reports'); // loading the model
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | specific surveys reports";
            $data['sessiondata'] = $sessiondata;
            $schooltype = $this->db->query(" SELECT `Type_Of_School` FROM `l1_school` WHERE `Id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            $data['themes'] = $this->db->query(" SELECT * FROM `sv_st_themes` ")->result_array();

            if ($data['type_of_user'] == "staff") {
                $user_type_code = '1';
                $data['count_all'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->num_rows();
            } elseif ($data['type_of_user'] == "teachers") {
                $data['count_all'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '3';
            } elseif ($data['type_of_user'] == "students") {
                $data['students_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
                $data['count_all'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '2';
            } elseif ($data['type_of_user'] == "parents") {
                $data['count_all'] = "10"; // TODO : real parents counter
                $user_type_code = '4';
            }
            // get results from model
            $data['surveys'] = $this->sv_ministry_reports->Get_surveys();
            $data['expired_surveys'] = $this->sv_ministry_reports->expired_surveys();
            $data['answerd_quastions'] = $this->sv_ministry_reports->answerd_quastions($sessiondata['admin_id']);
            $data['used_categorys'] = $this->sv_ministry_reports->usedcategorys($sessiondata['admin_id']);
            // teachers start
            $data['surveys'] = $this->sv_ministry_reports->specific_type_surveys($sessiondata['admin_id'], $user_type_code);
            $data['quastions'] = $this->sv_ministry_reports->specific_type_questions($sessiondata['admin_id'], $user_type_code);
            $data['completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], $user_type_code);
            $finishing_data = $this->sv_ministry_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], $user_type_code);
            $data['finishing_time'] = $this->calculate_avg_time($finishing_data);
            // loading the vie2 completed_surveys
            $data['surveys_for_males'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '1', $user_type_code);
            $data['surveys_for_females'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], '2', $user_type_code);
            $data['surveys_for_all_genders'] = $this->sv_ministry_reports->surveys_by_gender($sessiondata['admin_id'], "", $user_type_code);
            // published durveys fo the scroll of reports
            $data['our_surveys'] = $this->sv_ministry_reports->surveysByType($sessiondata['admin_id'], $user_type_code);
            // totals counter
            $data['avalaible_types_of_classes'] = $this->db->get('education_profile')->result_array();
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | " . $data['type_of_user'] . " Reports ";
            $data['sessiondata'] = $sessiondata;
            $this->show('EN/Ministry/specific_surveys_reports', $data);
        } else {
            redirect('EN/DashboardSystem/wellness');
        }
    }

    public function question_choice_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) !== null && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) !== null && $this->uri->segment(7) !== null) {
            $survey_id = $this->uri->segment(4);
            $choice_id = $this->uri->segment(5);
            $question_id = $this->uri->segment(6);
            $perc = $this->uri->segment(7);
            $this->load->library('session');
            $survey = $this->db->where("Id", $survey_id)->limit(1)->get("sv_school_published_surveys")->row();
            if (empty($survey)) {
                echo "Invalid Data : Could Not Find The Survey";
                return;
            }

            $school = $this->db->where("Id", $survey->By_school)->limit(1)->get("l1_school")->row();
            if (empty($school)) {
                echo "Invalid Data : Could Not Find The School Account Any More ";
                return;
            }

            $sessiondata = $this->session->userdata('admin_details');
            $choice_data = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices` WHERE `Id` = '" . $choice_id . "' ")->result_array();
            $data['name'] = $choice_data[0]['title_en'];
            $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice_id . "' ")->num_rows();
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $survey_id;
            $data['question_id'] = $question_id;
            $data['choice_id'] = $choice_id;
            $data['perc'] = $perc;
            $data['by_types'] = $this->db->query("SELECT 
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' ) AS Total ")->result_array();
            //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)

            require_once APPPATH . 'models/schools/sv_school_reports.php';
            $sv_school_reports_modal = new sv_school_reports($school->Id);

            $data['males'] = $this->count_gender($sv_school_reports_modal->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "M"));
            $data['females'] = $this->count_gender($sv_school_reports_modal->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "F"));

            $this->load->view("EN/schools/report_question_survey", $data);
        } else {
            print_r($this->uri->segment_array());
        }
    }

    public function question_detailed_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && $this->uri->segment(7)) {
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
                $data['serv_id'] = $survey_id;
                $data['name'] = $choice['title_en'];
                $data['question_id'] = $question_id;
                $data['choice_id'] = $choice['Id'];
                $data['question_id'] = $question_id;
                $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice['Id'] . "' ")->num_rows();
                $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "'  ")->num_rows();
                $perc = $this->calc_perc($data['use_count'], $all_count);
                $data['perc'] = $perc;
                $data['by_types'] = $this->db->query("SELECT 
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' ) AS Total  
                ")->result_array();
                //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
                $this->load->model('schools/sv_school_reports');
                $data['males'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "M"));
                $data['females'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "F"));
                $this->load->view("EN/schools/report_question_survey", $data);
            }
        } else {
            redirect('EN/Schools/wellness');
        }
    }

    public function categorys_reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | survey report ";
        if (!$this->uri->segment(4)) { // when the category not chosen
            $this->load->model('ministry/sv_ministry_reports'); // loading the model
            $data['categorys'] = $this->sv_ministry_reports->usedcategorys(); // return categorys used in this school
            $data['surveys'] = $this->sv_ministry_reports->our_surveys($sessiondata['admin_id']); // return categorys used in this school
            $data['schools'] = $this->sv_ministry_reports->schoolsBySurveys();
            $this->show('EN/Ministry/category_report', $data);
        } else { // when we have a category error
            /**
             *  category_by_gender :
             * @user id
             * @gender cose (1 = male , 2 = female)
             * @usertype code
             * @cat id
             */
            $data['cat_id'] = $this->uri->segment(4);
            $this->load->model('ministry/sv_ministry_reports'); // loading the model
            $sessiondata = $this->session->userdata('admin_details');
            $data['surveys_for_males'] = $this->sv_ministry_reports->category_by_gender($sessiondata['admin_id'], '1', "", $data['cat_id']);
            $data['surveys_for_females'] = $this->sv_ministry_reports->category_by_gender($sessiondata['admin_id'], '2', "", $data['cat_id']);
            $data['surveys_for_all_genders'] = $this->sv_ministry_reports->category_by_gender($sessiondata['admin_id'], '', "", $data['cat_id']);
            // for students
            $data['students_completed_surveys'] = $this->sv_ministry_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2', $data['cat_id']);
            $data['count_all'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
            $data['avalaible_types_of_classes'] = $this->db->get('education_profile')->result_array();
            // Staffs
            $data['Staffs'] = $this->sv_ministry_reports->users_passed_category($data['cat_id'], '1');
            // teachers
            $data['Teachers'] = $this->sv_ministry_reports->users_passed_category($data['cat_id'], '3');
            // students
            $data['Students'] = $this->sv_ministry_reports->users_passed_category($data['cat_id'], '2');
            // Parents
            $data['Parents'] = $this->sv_ministry_reports->users_passed_category($data['cat_id'], '4');
            $data['surveys'] = $this->sv_ministry_reports->category_publishid_surveys($sessiondata['admin_id'], $data['cat_id']);
            $this->show('EN/Ministry/category_report_charts', $data);
        }
    }

    public function questions_reports()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['survey_id'] = $this->uri->segment(4);
            $data['page_title'] = "QlickSystems | Questions Reports ";
            $this->load->model('ministry/sv_ministry_reports'); // loading the model
            $data['quastions_all_data'] = $this->sv_ministry_reports->get_surv_quastions($data['survey_id']);
            $cutted_array = array_column($data['quastions_all_data'], 'en_title');
            $questions = array_map(function ($name) {
                return '"' . $name . '"';
            }, $cutted_array);
            $data['quastions'] = $cutted_array;
            $data['survey_quastions'] = $questions;
            $data['get_choices'] = $this->sv_ministry_reports->survey_q_results($data['survey_id']);
            $used_choices = array_column($data['get_choices'], "choices_en");
            $used_choices = array_map(function ($choices) {
                return '"' . $choices . '"';
            }, $used_choices);
            $data['used_choices'] = $used_choices;
            $data['types'] = array(
                [
                    "name" => "staff",
                    "code" => "1"
                ],
                [
                    "name" => "Teacher",
                    "code" => "3"
                ],
                [
                    "name" => "Student",
                    "code" => "2"
                ],
                [
                    "name" => "Parent",
                    "code" => "4"
                ]
            );
            // $this->response->json($data);
            $this->show('EN/Ministry/Questions_Reports', $data);
        } else {
            redirect('EN/DashboardSystem/categorys_reports');
        }
    }

    public function counter_questions()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['survey_id'] = $this->uri->segment(4);
            $data['page_title'] = "QlickSystems | Questions Reports ";
            $this->load->model('ministry/sv_ministry_reports'); // loading the model
            $data['quastions_all_data'] = $this->sv_ministry_reports->get_surv_quastions($data['survey_id']);
            $cutted_array = array_column($data['quastions_all_data'], 'counter_charts_en');
            $questions = array_map(function ($name) {
                return '"' . $name . '"';
            }, $cutted_array);
            $data['quastions'] = $cutted_array;
            $data['survey_quastions'] = $questions;
            $data['get_choices'] = $this->sv_ministry_reports->survey_q_results($data['survey_id']);
            $used_choices = array_column($data['get_choices'], "choices_en");
            $used_choices = array_map(function ($choices) {
                return '"' . $choices . '"';
            }, $used_choices);
            $data['used_choices'] = $used_choices;
            $data['types'] = array(
                [
                    "name" => "staff",
                    "code" => "1"
                ],
                [
                    "name" => "Teacher",
                    "code" => "3"
                ],
                [
                    "name" => "Student",
                    "code" => "2"
                ],
                [
                    "name" => "Parent",
                    "code" => "4"
                ]
            );
            $this->show('EN/Ministry/Questions_Counter', $data);
        } else {
            redirect('EN/DashboardSystem/categorys_reports');
        }
    }


    // not added to links yet

    public function school_reports()
    {
        $data['page_title'] = "QlickSystems | School Reports ";
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');

        // stopping the page if the id not found
        if (!$this->uri->segment(4) || !is_numeric($this->uri->segment(4))) {
            redirect("EN/DashboardSystem/categorys_reports/");
            exit();
        } else {
            $school_id = $this->uri->segment(4);
            $school_data = $this->db->get_where('l1_school', array('Id' => $school_id, "Added_By" => $sessiondata['admin_id']), 1)->row();
            if (!empty($school_data)) {
                $data['school_data'] = $school_data;
            } else {
                redirect("EN/DashboardSystem/categorys_reports/");
                exit();
            }
        }

        require_once APPPATH . 'models/schools/Sv_school_reports.php';
        $sv_school_reports_modal = new sv_school_reports($school_id);
        // start page
        $data['sessiondata'] = $sessiondata;
        $data['school_id'] = $school_id;
        // $this->load->model('schools/sv_school_reports');
        $data['our_surveys'] = $sv_school_reports_modal->our_surveys($school_id);
        $data['surveys_for_males'] = $sv_school_reports_modal->surveys_by_gender($school_id, '1');
        $data['surveys_for_females'] = $sv_school_reports_modal->surveys_by_gender($school_id, '2');
        $data['surveys_for_all_genders'] = $sv_school_reports_modal->surveys_by_gender($school_id);
        $ages_arr = array_column($sv_school_reports_modal->ages_forall_users($school_id, false), "DOP");
        $users_passed_survey_ages_options_ages = array_column($sv_school_reports_modal->ages_for_all_passed_users($school_id, false), "DOP");
        $data['used_categorys'] = $sv_school_reports_modal->usedcategorys($school_id);
        $data['expired_surveys'] = $sv_school_reports_modal->expired_surveys($school_id);
        $data['completed_surveys'] = $sv_school_reports_modal->completed_surveys($school_id);
        // teachers start
        $data['teachers_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '3');
        $data['teachers_quastions'] = $sv_school_reports_modal->specific_type_questions($school_id, '3');
        $data['teachers_completed_surveys'] = $sv_school_reports_modal->specific_type_completed_surveys($school_id, '3');
        $finishing_teachers_data = $sv_school_reports_modal->specific_type_timeOfFinishing($school_id, '3');
        $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
        // staffs start
        $data['staff_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '1');
        $data['staff_quastions'] = $sv_school_reports_modal->specific_type_questions($school_id, '1');
        $data['staff_completed_surveys'] = $sv_school_reports_modal->specific_type_completed_surveys($school_id, '1');
        $finishing_staffs_data = $sv_school_reports_modal->specific_type_timeOfFinishing($school_id, '1');
        $data['finishing_time_staff'] = $this->calculate_avg_time($finishing_staffs_data);
        // parents start
        $data['parents_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '4');
        $data['parents_quastions'] = $sv_school_reports_modal->specific_type_questions($school_id, '4');
        $data['parents_completed_surveys'] = $sv_school_reports_modal->specific_type_completed_surveys($school_id, '4');
        $finishing_parents_data = $sv_school_reports_modal->specific_type_timeOfFinishing($school_id, '4');
        $data['finishing_time_parents'] = $this->calculate_avg_time($finishing_parents_data);
        // students start
        $data['students_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '2');
        $data['students_quastions'] = $sv_school_reports_modal->specific_type_questions($school_id, '2');
        $data['students_completed_surveys'] = $sv_school_reports_modal->specific_type_completed_surveys($school_id, '2');
        $finishing_students_data = $sv_school_reports_modal->specific_type_timeOfFinishing($school_id, '2');
        $data['finishing_time_students'] = $this->calculate_avg_time($finishing_students_data);

        // loading the vie2
        $data['surveys_for_males'] = $sv_school_reports_modal->surveys_by_gender($school_id, '1');
        $data['surveys_for_females'] = $sv_school_reports_modal->surveys_by_gender($school_id, '2');
        $data['surveys_for_all_genders'] = $sv_school_reports_modal->surveys_by_gender($school_id);
        $finishing_all_data = $sv_school_reports_modal->specific_type_timeOfFinishing($school_id);
        $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
        $data['ages'] = array_count_values($ages_arr);
        $data['users_passed_survey_ages_options_ages'] = array_count_values($users_passed_survey_ages_options_ages);
        $data['ages_with_groups'] = $sv_school_reports_modal->ages_forall_users($school_id, true);
        $data['ages_with_groups'] = $sv_school_reports_modal->ages_for_all_passed_users($school_id, true);
        $data['teachers_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '3');
        $data['staff_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '1');
        $data['parents_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '4');
        $data['students_surveys'] = $sv_school_reports_modal->specific_type_surveys($school_id, '2');
        // students reports
        $data['gend_students_males'] = $sv_school_reports_modal->surveys_by_gender($school_id, '1', '2');
        $data['gend_students_females'] = $sv_school_reports_modal->surveys_by_gender($school_id, '2', '2');
        $data['gend_students_all'] = $sv_school_reports_modal->surveys_by_gender($school_id, '', '2');
        $data['students_matural'] = $sv_school_reports_modal->martial_status($school_id, '2');
        // teachers reports
        $data['gend_teachers_males'] = $sv_school_reports_modal->surveys_by_gender($school_id, '1', '3');
        $data['gend_teachers_females'] = $sv_school_reports_modal->surveys_by_gender($school_id, '2', '3');
        $data['gend_teachers_all'] = $sv_school_reports_modal->surveys_by_gender($school_id, '', '3');
        $data['teachers_matural'] = $sv_school_reports_modal->martial_status($school_id, '3');
        // staff reports
        $data['gend_staffs_males'] = $sv_school_reports_modal->surveys_by_gender($school_id, '1', '1');
        $data['gend_staffs_females'] = $sv_school_reports_modal->surveys_by_gender($school_id, '2', '1');
        $data['gend_staffs_all'] = $sv_school_reports_modal->surveys_by_gender($school_id, '', '1');
        $data['staffs_matural'] = $sv_school_reports_modal->martial_status($school_id, '1');
        // parents reports
        $data['gend_parents_males'] = $sv_school_reports_modal->surveys_by_gender($school_id, '1', '4');
        $data['gend_parents_females'] = $sv_school_reports_modal->surveys_by_gender($school_id, '2', '4');
        $data['gend_parents_all'] = $sv_school_reports_modal->surveys_by_gender($school_id, '', '4');
        $data['parents_matural'] = $sv_school_reports_modal->martial_status($school_id, '4');
        /// published surveys counters
        $counter_of_published_surveys = array();
        $counter_of_published_surveys['students'] = sizeof($sv_school_reports_modal->specific_type_surveys($school_id, '2'));
        $counter_of_published_surveys['teachers'] = sizeof($sv_school_reports_modal->specific_type_surveys($school_id, '3'));
        $counter_of_published_surveys['staffs'] = sizeof($sv_school_reports_modal->specific_type_surveys($school_id, '1'));
        $counter_of_published_surveys['Parents'] = sizeof($sv_school_reports_modal->specific_type_surveys($school_id, '4'));
        // Expired  surveys counters
        $counter_of_expired_surveys = array();
        $counter_of_expired_surveys['students'] = sizeof($sv_school_reports_modal->expired_surveys_by_type($school_id, '2'));
        $counter_of_expired_surveys['teachers'] = sizeof($sv_school_reports_modal->expired_surveys_by_type($school_id, '3'));
        $counter_of_expired_surveys['staffs'] = sizeof($sv_school_reports_modal->expired_surveys_by_type($school_id, '1'));
        $counter_of_expired_surveys['Parents'] = sizeof($sv_school_reports_modal->expired_surveys_by_type($school_id, '4'));
        // completed  surveys counters
        $counter_of_completed_surveys = array();
        $counter_of_completed_surveys['students'] = sizeof($sv_school_reports_modal->completed_surveys($school_id, '2'));
        $counter_of_completed_surveys['staffs'] = sizeof($sv_school_reports_modal->completed_surveys($school_id, '1'));
        $counter_of_completed_surveys['teachers'] = sizeof($sv_school_reports_modal->completed_surveys($school_id, '3'));
        $counter_of_completed_surveys['Parents'] = sizeof($sv_school_reports_modal->completed_surveys($school_id, '4'));
        // passing arrays to the view  answerd_quastions
        $data['counter_of_published_surveys'] = $counter_of_published_surveys;
        $data['counter_of_expired_surveys'] = $counter_of_expired_surveys;
        $data['counter_of_completed_surveys'] = $counter_of_completed_surveys;
        $data['categorys'] = $this->db->query("SELECT * FROM `sv_st_category`  WHERE (action_en_url AND report_en_url AND media_en_url) IS NOT NULL ORDER BY `Id` DESC ")->result_array();
        $this->load->helper('directory');
        $data['gallery_files'] = directory_map('./assets/images/gallery');
        $this->show('EN/Ministry/school_report', $data);
    } //category

    public function school_reports_climate()
    {
        $data['page_title'] = "QlickSystems | School Reports ";
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');

        // stopping the page if the id not found
        if (!$this->uri->segment(4) || !is_numeric($this->uri->segment(4))) {
            redirect("EN/DashboardSystem/category_report_climate/");
            exit();
        } else {
            $school_id = $this->uri->segment(4);
            $school_data = $this->db->get_where('l1_school', array('Id' => $school_id, "Added_By" => $sessiondata['admin_id']), 1)->result_array();
            if (sizeof($school_data) > 0) {
                $data['school_data'] = $school_data[0];
            } else {
                redirect("EN/DashboardSystem/category_report_climate/");
                exit();
            }
        }
        // start page
        $data['sessiondata'] = $sessiondata;
        $data['school_id'] = $school_id;
        $this->load->model('schools/sv_school_reports');
        $data['our_surveys'] = $this->sv_school_reports->our_surveys($school_id);
        $data['surveys_for_males'] = $this->sv_school_reports->surveys_by_gender($school_id, '1');
        $data['surveys_for_females'] = $this->sv_school_reports->surveys_by_gender($school_id, '2');
        $data['surveys_for_all_genders'] = $this->sv_school_reports->surveys_by_gender($school_id);
        $ages_arr = array_column($this->sv_school_reports->ages_forall_users($school_id, false), "DOP");
        $users_passed_survey_ages_options_ages = array_column($this->sv_school_reports->ages_for_all_passed_users($school_id, false), "DOP");
        $data['used_categorys'] = $this->sv_school_reports->usedcategorys($school_id);
        $data['expired_surveys'] = $this->sv_school_reports->expired_surveys($school_id);
        $data['completed_surveys'] = $this->sv_school_reports->completed_surveys($school_id);
        // teachers start
        $data['teachers_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '3');
        $data['teachers_quastions'] = $this->sv_school_reports->specific_type_questions($school_id, '3');
        $data['teachers_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($school_id, '3');
        $finishing_teachers_data = $this->sv_school_reports->specific_type_timeOfFinishing($school_id, '3');
        $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
        // staffs start
        $data['staff_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '1');
        $data['staff_quastions'] = $this->sv_school_reports->specific_type_questions($school_id, '1');
        $data['staff_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($school_id, '1');
        $finishing_staffs_data = $this->sv_school_reports->specific_type_timeOfFinishing($school_id, '1');
        $data['finishing_time_staff'] = $this->calculate_avg_time($finishing_staffs_data);
        // parents start
        $data['parents_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '4');
        $data['parents_quastions'] = $this->sv_school_reports->specific_type_questions($school_id, '4');
        $data['parents_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($school_id, '4');
        $finishing_parents_data = $this->sv_school_reports->specific_type_timeOfFinishing($school_id, '4');
        $data['finishing_time_parents'] = $this->calculate_avg_time($finishing_parents_data);
        // students start
        $data['students_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '2');
        $data['students_quastions'] = $this->sv_school_reports->specific_type_questions($school_id, '2');
        $data['students_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($school_id, '2');
        $finishing_students_data = $this->sv_school_reports->specific_type_timeOfFinishing($school_id, '2');
        $data['finishing_time_students'] = $this->calculate_avg_time($finishing_students_data);
        // loading the vie2
        $data['surveys_for_males'] = $this->sv_school_reports->surveys_by_gender($school_id, '1');
        $data['surveys_for_females'] = $this->sv_school_reports->surveys_by_gender($school_id, '2');
        $data['surveys_for_all_genders'] = $this->sv_school_reports->surveys_by_gender($school_id);
        $finishing_all_data = $this->sv_school_reports->specific_type_timeOfFinishing($school_id);
        $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
        $data['ages'] = array_count_values($ages_arr);
        $data['users_passed_survey_ages_options_ages'] = array_count_values($users_passed_survey_ages_options_ages);
        $data['ages_with_groups'] = $this->sv_school_reports->ages_forall_users($school_id, true);
        $data['ages_with_groups'] = $this->sv_school_reports->ages_for_all_passed_users($school_id, true);
        $data['teachers_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '3');
        $data['staff_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '1');
        $data['parents_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '4');
        $data['students_surveys'] = $this->sv_school_reports->specific_type_surveys($school_id, '2');
        // students reports
        $data['gend_students_males'] = $this->sv_school_reports->surveys_by_gender($school_id, '1', '2');
        $data['gend_students_females'] = $this->sv_school_reports->surveys_by_gender($school_id, '2', '2');
        $data['gend_students_all'] = $this->sv_school_reports->surveys_by_gender($school_id, '', '2');
        $data['students_matural'] = $this->sv_school_reports->martial_status($school_id, '2');
        // teachers reports
        $data['gend_teachers_males'] = $this->sv_school_reports->surveys_by_gender($school_id, '1', '3');
        $data['gend_teachers_females'] = $this->sv_school_reports->surveys_by_gender($school_id, '2', '3');
        $data['gend_teachers_all'] = $this->sv_school_reports->surveys_by_gender($school_id, '', '3');
        $data['teachers_matural'] = $this->sv_school_reports->martial_status($school_id, '3');
        // staff reports
        $data['gend_staffs_males'] = $this->sv_school_reports->surveys_by_gender($school_id, '1', '1');
        $data['gend_staffs_females'] = $this->sv_school_reports->surveys_by_gender($school_id, '2', '1');
        $data['gend_staffs_all'] = $this->sv_school_reports->surveys_by_gender($school_id, '', '1');
        $data['staffs_matural'] = $this->sv_school_reports->martial_status($school_id, '1');
        // parents reports
        $data['gend_parents_males'] = $this->sv_school_reports->surveys_by_gender($school_id, '1', '4');
        $data['gend_parents_females'] = $this->sv_school_reports->surveys_by_gender($school_id, '2', '4');
        $data['gend_parents_all'] = $this->sv_school_reports->surveys_by_gender($school_id, '', '4');
        $data['parents_matural'] = $this->sv_school_reports->martial_status($school_id, '4');
        /// published surveys counters
        $counter_of_published_surveys = array();
        $counter_of_published_surveys['students'] = sizeof($this->sv_school_reports->specific_type_surveys($school_id, '2'));
        $counter_of_published_surveys['teachers'] = sizeof($this->sv_school_reports->specific_type_surveys($school_id, '3'));
        $counter_of_published_surveys['staffs'] = sizeof($this->sv_school_reports->specific_type_surveys($school_id, '1'));
        $counter_of_published_surveys['Parents'] = sizeof($this->sv_school_reports->specific_type_surveys($school_id, '4'));
        // Expired  surveys counters
        $counter_of_expired_surveys = array();
        $counter_of_expired_surveys['students'] = sizeof($this->sv_school_reports->expired_surveys_by_type($school_id, '2'));
        $counter_of_expired_surveys['teachers'] = sizeof($this->sv_school_reports->expired_surveys_by_type($school_id, '3'));
        $counter_of_expired_surveys['staffs'] = sizeof($this->sv_school_reports->expired_surveys_by_type($school_id, '1'));
        $counter_of_expired_surveys['Parents'] = sizeof($this->sv_school_reports->expired_surveys_by_type($school_id, '4'));
        // completed  surveys counters
        $counter_of_completed_surveys = array();
        $counter_of_completed_surveys['students'] = sizeof($this->sv_school_reports->completed_surveys($school_id, '2'));
        $counter_of_completed_surveys['staffs'] = sizeof($this->sv_school_reports->completed_surveys($school_id, '1'));
        $counter_of_completed_surveys['teachers'] = sizeof($this->sv_school_reports->completed_surveys($school_id, '3'));
        $counter_of_completed_surveys['Parents'] = sizeof($this->sv_school_reports->completed_surveys($school_id, '4'));
        // passing arrays to the view  answerd_quastions
        $data['counter_of_published_surveys'] = $counter_of_published_surveys;
        $data['counter_of_expired_surveys'] = $counter_of_expired_surveys;
        $data['counter_of_completed_surveys'] = $counter_of_completed_surveys;
        $data['categorys'] = $this->db->query("SELECT * FROM `sv_st_category`
            WHERE (action_en_url AND report_en_url AND media_en_url) IS NOT NULL ORDER BY `Id` DESC ")->result_array();
        $this->load->helper('directory');
        $data['gallery_files'] = directory_map('./assets/images/gallery');
        $this->show('EN/Ministry/school_report', $data);
    }

    public function return_surveys_of_category()
    {
        if ($this->input->post('cat_id')) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $category_id = $this->input->post('cat_id');
            $results = $this->db->query("SELECT
            `sv_st1_surveys`.`TimeStamp` AS creating_date ,
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
            (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter ,
            (SELECT COUNT(Id) FROM `sv_school_published_surveys` WHERE `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` ) AS surveys_count_published
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Published_by` = '" . $sessiondata['admin_id'] . "' AND `sv_st_surveys`.`category` = '" . $category_id . "'
            AND `sv_st_surveys`.`targeted_type` = 'M' GROUP BY `sv_st1_surveys`.`Id`")->result_array();
            if (!empty($results)) {
                $this->response->json(["status" => 'ok', "data" => $results, "cat" => $results[0]['Title_en']]);
            } else {
                $this->response->json(["status" => 'ok', "data" => [], "cat" => "No Title"]);
            }
        } else {
            $this->response->json(["status" => 'error', "data" => [], "cat" => "No Title"]);
        }
    }

    public function labs_report()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | disease report ";
        $data["classes"] = $this->schoolHelper->getActiveSchoolClassesByStudents();
        $data['tests'] = $this->db->get('r_testcode')->result_array();
        if ($this->input->method() == "post") {
            // validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start', 'start', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('end', 'end', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('classes[]', 'Classes', 'trim|required|multiple_select');
            $this->form_validation->set_rules('tests[]', 'test type', 'trim|required|multiple_select');
            // check
            if ($this->form_validation->run()) {
                $tests = array();
                $inputtests = $this->input->post('tests');
                foreach ($this->input->post('tests') as $test_inp) {
                    $tests[] = str_replace(" ", '_', $test_inp);
                }
                $school_id = $this->input->post('school');
                // students
                $this->db->select("`r_levels`.`Class` AS class , `r_levels`.`Id` AS Class_key ");
                $this->db->from('l2_labtests');
                $this->db->join('l2_student', 'l2_student.Id = l2_labtests.UserId');
                $this->db->join('r_levels', 'r_levels.Id = l2_student.Class');
                $this->db->where('l2_labtests.UserType', 'Student');
                $this->db->where('l2_labtests.Created >=', date('Y-m-d', strtotime($this->input->post('start'))));
                $this->db->where('l2_labtests.Created <=', date('Y-m-d', strtotime($this->input->post('end'))));
                $this->db->where('l2_student.Added_By', $school_id);
                $this->db->where_in('l2_labtests.Test_Description', $this->input->post('tests'));
                $this->db->where_in('l2_student.Class', $this->input->post('classes'));
                $this->db->group_by('l2_student.Class');
                $students = $this->db->get()->result_array();
                // charts
                $studentsresults = array();
                $teachersresults = array();
                // second chart
                $secondChart = array('students' => array(), "teachers" => array(), "staffs" => array());
                ?>

                <div class="tab-pane active" id="teachers" role="tabpanel">
                    <div class="table-responsive">
                        <table id="teachers_table" class="table">
                            <thead>
                            <th>#</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                            </thead>
                            <?php $t_positives = 0;
                            $t_nigatives = 0; ?>
                            <tbody>
                            <tr>
                                <td>Results</td>
                                <?php foreach ($tests as $key => $test) { ?>
                                    <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_teacher.Added_By = '" . $school_id . "' ")->num_rows(); ?>
                                    <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_teacher.Added_By = '" . $school_id . "' ")->num_rows(); ?>
                                    <?php $secondChart['teachers'][$test] = ["Positive" => $Positive, "Negative" => $Negative, "both" => $Positive + $Negative]; ?>
                                    <?php $t_positives += $Positive;
                                    $t_nigatives += $Negative; ?>
                                    <td class="text-center">
                                        <span
                                                class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                        <span
                                                class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                        <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= $this->calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                    </td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="column_chart_teachers" class="apex-charts" dir="ltr"></div>
                    <hr>
                    <h3 class="card-title text-center">Test Chart:</h3>
                    <div id="second_chart_teachers" class="apex-charts" dir="ltr"></div>
                </div>

                <div class="tab-pane" id="Staff" role="tabpanel">
                    <div class="table-responsive">
                        <table id="teachers_table" class="table">
                            <thead>
                            <th>#</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                            </thead>
                            <?php $t_positives = 0;
                            $t_nigatives = 0; ?>
                            <tbody>
                            <tr>
                                <td>Results</td>
                                <?php foreach ($tests as $key => $test) { ?>
                                    <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $school_id . "' ")->num_rows(); ?>
                                    <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $school_id . "' ")->num_rows(); ?>
                                    <?php $secondChart['staffs'][$test] = ["Positive" => $Positive, "Negative" => $Negative, "both" => $Positive + $Negative]; ?>
                                    <?php $t_positives += $Positive;
                                    $t_nigatives += $Negative; ?>
                                    <td class="text-center">
                                        <span
                                                class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                        <span
                                                class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                        <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= $this->calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                    </td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="column_chart_teachers" class="apex-charts" dir="ltr"></div>
                    <hr>
                    <h3 class="card-title text-center">Test Chart:</h3>
                    <div id="second_chart_staffs" class="apex-charts" dir="ltr"></div>
                </div>
                <div class="tab-pane" id="students" role="tabpanel">
                    <div class="table-responsive">
                        <table id="students_table" class="table">
                            <thead>
                            <th>#</th>
                            <th>Class name</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                            </thead>
                            <tbody>
                            <?php foreach ($students as $i => $student) { ?>
                                <?php $positives = 0;
                                $nigatives = 0; ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $student['class'] ?></td>
                                    <?php foreach ($tests as $key => $test) { ?>
                                        <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_student.Added_By = '" . $school_id . "' ")->num_rows();
                                        ?>
                                        <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_student.Added_By = '" . $school_id . "'  ")->num_rows(); ?>
                                        <?php $secondChart['students'][$test] = ["Positive" => ($secondChart['students'][$test]["Positive"] ?? 0) + $Positive, "Negative" => ($secondChart['students'][$test]["Negative"] ?? 0) + $Negative, "both" => ($secondChart['students'][$test]["both"] ?? 0) + ($Positive + $Negative)]; ?>
                                        <?php $positives += $Positive;
                                        $nigatives += $Negative; ?>
                                        <td class="text-center">
                                            <span
                                                    class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                            <span
                                                    class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                            <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= $this->calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $studentsresults[] = ['value' => $this->calc_perc($positives, ($positives + $nigatives)), "name" => $student['class']];
                                ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div id="column_chart_students" class="apex-charts" dir="ltr"></div>
                    <hr>
                    <h3 class="card-title text-center">Test Chart:</h3>
                    <div id="second_chart_students" class="apex-charts" dir="ltr"></div>
                </div>
                <hr>
                <?php
                $chartClasses = array();
                foreach ($students as $class) {
                    $chartClasses[] = '"' . $class['class'] . '"';
                }
                $labels = array();
                foreach ($tests as $test) {
                    $labels[] = '"' . str_replace("_", " ", $test) . '"';
                }
                ?>
                <script>
                    $('.table').DataTable();

                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [
                            <?php foreach ($chartClasses as $i => $student) { ?> {
                                name: "<?= $studentsresults[$i]['name'] ?>",
                                data: [<?= $studentsresults[$i]['value'] ?>]
                            },
                            <?php } ?>
                        ],
                        colors: ['#f1b44c', '#5b73e8', '#34c38f'],
                        xaxis: {
                            categories: [<?= implode(',', $chartClasses); ?>],
                        },
                        yaxis: {
                            title: {
                                text: ' Prevalence Rate '
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "Prevalence Rate  : " + val + "%"
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(
                        document.querySelector("#column_chart_students"),
                        options
                    );
                    chart.render();

                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Positive',
                            data: [<?= implode(",", array_column($secondChart["students"], "Positive")) ?>]
                        }, {
                            name: 'Negative',
                            data: [<?= implode(",", array_column($secondChart["students"], "Negative")) ?>]
                        }, {
                            name: 'Total',
                            data: [<?= implode(",", array_column($secondChart["students"], "both")) ?>]
                        }],
                        colors: ['#f46a6a', '#34c38f', '#5b73e8'],
                        xaxis: {
                            categories: [<?= implode(',', $labels); ?>],
                        },
                        yaxis: {
                            title: {
                                text: 'Result(s)'
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Result(s)"
                                }
                            }
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#second_chart_students"), options);
                    chart.render();

                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Positive',
                            data: [<?= implode(",", array_column($secondChart["staffs"], "Positive")) ?>]
                        }, {
                            name: 'Negative',
                            data: [<?= implode(",", array_column($secondChart["staffs"], "Negative")) ?>]
                        }, {
                            name: 'Total',
                            data: [<?= implode(",", array_column($secondChart["staffs"], "both")) ?>]
                        }],
                        colors: ['#f46a6a', '#34c38f', '#5b73e8'],
                        xaxis: {
                            categories: [<?= implode(',', $labels); ?>],
                        },
                        yaxis: {
                            title: {
                                text: 'Result(s)'
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Result(s)"
                                }
                            }
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#second_chart_staffs"), options);
                    chart.render();

                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Positive',
                            data: [<?= implode(",", array_column($secondChart["teachers"], "Positive")) ?>]
                        }, {
                            name: 'Negative',
                            data: [<?= implode(",", array_column($secondChart["teachers"], "Negative")) ?>]
                        }, {
                            name: 'Total',
                            data: [<?= implode(",", array_column($secondChart["teachers"], "both")) ?>]
                        }],
                        colors: ['#f46a6a', '#34c38f', '#5b73e8'],
                        xaxis: {
                            categories: [<?= implode(',', $labels); ?>],
                        },
                        yaxis: {
                            title: {
                                text: 'Result(s)'
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Result(s)"
                                }
                            }
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#second_chart_teachers"), options);
                    chart.render();
                </script>
            <?php } else {
                $this->response->json(['status' => "error", "messages" => validation_errors("<p class='mb-0'> + ", "</p>")]);
            }
        } else {
            $this->load->model('ministry/sv_ministry_reports');
            $data['our_schools'] = $this->sv_ministry_reports->our_schools();
            $this->show('EN/Ministry/labs_reports', $data);
        }
    }

    public function supported_school_classes() // gets school id , returns supported classes as json
    {
        if ($this->input->method() == "post" && $this->input->post('school_id')) {
            $classes = $this->schoolHelper->school_classes($this->input->post('school_id'));
            $data = array();
            foreach ($classes as $key => $row) {
                $data[] = array("id" => $row['Id'], "text" => $row['Class']);
            }
            $this->response->json($data);
        } else {
            $this->response->json(["status" => "error"]);
        }
    }

    public function ai_report()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Questions Reports ";
        if ($this->input->method() == "post" && $this->input->post('school')) {
            if ($this->input->method() == "post") {
                // validation
                $this->load->library('form_validation');
                $this->form_validation->set_rules('start', 'start', 'trim|required|exact_length[10]');
                $this->form_validation->set_rules('end', 'end', 'trim|required|exact_length[10]');
                $this->form_validation->set_rules('classes[]', 'classes', 'trim|required|multiple_select');
                $this->form_validation->set_rules('tests[]', 'test type', 'trim|required|multiple_select');
                $this->form_validation->set_rules('cities[]', 'city', 'trim|required');
                $this->form_validation->set_rules('school[]', 'school', 'trim|required|multiple_select');
                // check
                if ($this->form_validation->run()) {
                    $tests = array();
                    $data['inputtests'] = $this->input->post('tests');
                    foreach ($this->input->post('tests') as $test_inp) {
                        $tests[] = str_replace(" ", '_', $test_inp);
                    }
                    $schools_ids = $this->input->post('school[]');
                    // students
                    $data['schools'] = $this->db->query("SELECT * FROM `l1_school` WHERE Id IN (" . implode(",", $schools_ids) . ")")->result_array();
                    $data['tests'] = $tests;
                    $data['classes'] = $this->input->post('classes');
                    $data['start'] = $this->input->post('start');
                    $data['end'] = $this->input->post('end');
                    $this->load->view("EN/Ministry/inc/ai_report_results", $data);
                } else {
                    echo validation_errors();
                }
            }
        } elseif ($this->input->method() == "get") {
            $this->load->model('ministry/sv_ministry_reports');
            $data['our_schools'] = $this->sv_ministry_reports->our_schools();
            $data['tests'] = $this->db->get('r_testcode')->result_array();
            $data['classes'] = $this->db->query("SELECT * , `r_levels`.`Class` AS Class , `r_levels`.`Id` AS Id  FROM l2_school_classes
            JOIN `r_levels` ON `r_levels`.`Id` = `l2_school_classes`.`class_key`
            WHERE `l2_school_classes`.`school_id` IN (" . implode(",", array_column($data['our_schools'], "Id")) . ") ORDER BY `r_levels`.`Id` ASC ")->result_array();
            $data['cities'] = $this->db->query("SELECT r_cities.* , (SELECT COUNT(Id) FROM l1_school 
            WHERE l1_school.Citys = r_cities.Id AND l1_school.Added_By = '" . $sessiondata['admin_id'] . "') AS useTimes 
            FROM `r_cities`
            JOIN l1_school ON l1_school.Citys = r_cities.Id
            WHERE l1_school.Added_By = '" . $sessiondata['admin_id'] . "' GROUP BY l1_school.Citys ")->result_array();
            $this->show('EN/Ministry/ai_report_from', $data);
        }
    }

    public function ai_report_2()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Questions Reports ";
        if ($this->input->method() == "post" && $this->input->post('school')) {
            if ($this->input->method() == "post") {
                // validation
                $this->load->library('form_validation');
                $this->form_validation->set_rules('start', 'start', 'trim|required|exact_length[10]');
                $this->form_validation->set_rules('end', 'end', 'trim|required|exact_length[10]');
                $this->form_validation->set_rules('classes[]', 'Classes', 'trim|required|multiple_select');
                $this->form_validation->set_rules('tests[]', 'test type', 'trim|required|multiple_select');
                $this->form_validation->set_rules('cities[]', 'city', 'trim|required');
                $this->form_validation->set_rules('school[]', 'school', 'trim|required|multiple_select');
                // check
                if ($this->form_validation->run()) {
                    $tests = array();
                    $tests_string = array();
                    $data['inputtests'] = $this->input->post('tests');
                    foreach ($this->input->post('tests') as $test_inp) {
                        $tests[] = str_replace(" ", '_', $test_inp);
                    }
                    foreach ($this->input->post('tests') as $test_inp) {
                        $tests_string[] = "'" . $test_inp . "'";
                    }
                    $schools_ids = $this->input->post('school[]');
                    // students
                    $data['schools'] = $this->db->query("SELECT * FROM `l1_school` WHERE Id IN (" . implode(",", $schools_ids) . ")")->result_array();
                    $data['tests'] = $tests;
                    $data['tests_string'] = $tests_string;
                    $data['classes'] = $this->input->post('classes');
                    $data['start'] = $this->input->post('start');
                    $data['end'] = $this->input->post('end');
                    $this->load->view("EN/Ministry/inc/ai_report2_results", $data);
                } else {
                    echo validation_errors();
                }
            }
        } elseif ($this->input->method() == "get") {
            $this->load->model('ministry/sv_ministry_reports');
            $data['our_schools'] = $this->sv_ministry_reports->our_schools();
            $data['tests'] = $this->db->get('r_testcode')->result_array();
            $data['classes'] = $this->db->query("SELECT * , `r_levels`.`Class` AS Class , `r_levels`.`Id` AS Id  FROM l2_school_classes
            JOIN `r_levels` ON `r_levels`.`Id` = `l2_school_classes`.`class_key`
            WHERE `l2_school_classes`.`school_id` IN (" . implode(",", array_column($data['our_schools'], "Id")) . ") ORDER BY `r_levels`.`Id` ASC ")->result_array();
            $data['cities'] = $this->db->query("SELECT r_cities.* , (SELECT COUNT(Id) FROM l1_school 
            WHERE l1_school.Citys = r_cities.Id AND l1_school.Added_By = '" . $sessiondata['admin_id'] . "') AS useTimes 
            FROM `r_cities`
            JOIN l1_school ON l1_school.Citys = r_cities.Id
            WHERE l1_school.Added_By = '" . $sessiondata['admin_id'] . "' GROUP BY l1_school.Citys ")->result_array();
            $this->show('EN/Ministry/ai_report_from', $data);
        }
    }

    public function av_schools_in_city() // gets school id , returns supported classes as json
    {
        if ($this->input->method() == "post" && $this->input->post('city_Id')) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $schools = $this->db->query("SELECT * FROM `l1_school` WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND Citys IN (" . implode(',', $this->input->post('city_Id')) . ") ")->result_array();
            $data = array();
            foreach ($schools as $row) {
                $data[] = array("id" => $row['Id'], "text" => $row['School_Name_EN']);
            }
            $this->response->json($data);
        } else {
            $this->response->json(["status" => "error"]);
        }
    }

    public function permissions()
    {
        if ($this->input->method() == 'get') {
            if ($this->uri->segment(4) && $this->uri->segment(5) && is_numeric($this->uri->segment(5))) {
                $User_id = $this->uri->segment(5);
                $data['page_title'] = "Qlick Health | Update System ";
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $data['sessiondata'] = $sessiondata;
                $data['User_id'] = $User_id;
                $data['User_type'] = $this->uri->segment(4);
                if ($this->uri->segment(4) == "school") {
                    $data['user_data'] = $this->db->query(
                        " SELECT l1_school.* , v1_permissions.*,
                    IFNULL(l2_avatars.Link,'default_avatar.jpg')  AS Link 
                    FROM `l1_school`
                    LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l1_school`.`Id` 
                    AND `l2_avatars`.`Type_Of_User` = 'school'
                    LEFT JOIN `v1_permissions` ON `v1_permissions`.`user_id` = `l1_school`.`Id`
                    WHERE `l1_school`.`Id` = '" . $User_id . "' 
                    ORDER BY `l1_school`.`Id` DESC LIMIT 1"
                    )->result_array();
                }
                $this->show('EN/Ministry/permissions', $data);
            }
        } else {
            if ($this->input->post('permType') && $this->input->post('User')) {
                $permType = $this->input->post('permType');
                $User = $this->input->post('User');
                $user_type = $this->input->post('user_type');
                $today = date("Y-m-d");
                $time = date("h:i:s");
                $is_in_permissions = $this->db->query("SELECT `Id`,`$permType` FROM `v1_permissions`
                WHERE `user_id` = '" . $User . "' AND `user_type` = '" . $user_type . "' LIMIT 1 ")->result_array();
                if (!empty($is_in_permissions)) {
                    $perm_id = $is_in_permissions[0]['Id'];
                    $perm_status = $is_in_permissions[0]["$permType"];
                    if ($perm_status == 0) {
                        $new_status = 1;
                    } else {
                        $new_status = 0;
                    }
                    $this->db->query(" UPDATE `v1_permissions`
                    SET `$permType` = '" . $new_status . "',
                    `Created` = '" . $today . "' , `Time` = '" . $time . "'
                    WHERE `Id` = '" . $perm_id . "' ");
                    if ($new_status == 0) {
                        echo "This permission is now disabled for this user";
                    } else {
                        echo "This permission is now enabled for this user";
                    }
                } else {
                    $this->db->query("INSERT INTO `v1_permissions`
                    ( `user_id`, `user_type`, `$permType`, `Created`, `Time` ) 
                    VALUES ('" . $User . "','" . $user_type . "','1','" . $today . "','" . $time . "')");
                    echo "This permission is now enabled for this user";
                }
            }
        }
    }

    public function reports_routes()
    {
        if ($this->permissions_array["temperatureandlabs"]) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $links = array();
			$links[] = array('name' => "COOLING CONTROL", "link" => base_url('EN/DashboardSystem/schools-refrigerators'), "desc" => "", "icon" => "Refrigeratorcards.png");
            $links[] = array('name' => "AI: Lab Reports", "link" => base_url('EN/DashboardSystem/labs_report'), "desc" => "", "icon" => "LabReports.png");
            $links[] = array('name' => "AI: Total of Diseases", "link" => base_url('EN/DashboardSystem/ai_report'), "desc" => "", "icon" => "DiseasePrevalence.png");
            $links[] = array('name' => "AI: Percentage of Disease", "link" => base_url('EN/DashboardSystem/ai_report_2'), "desc" => "", "icon" => "details.png");
            $links[] = array('name' => "Refrigerator Trip​", "link" => base_url('EN/DashboardSystem/refrigerators_trips'), "desc" => "", "icon" => "Refrigerator_Trip.png");
            $links[] = array(
                'name' => "Students Single Medical Assessment", "link" => base_url('EN/DashboardSystem/patient-single-report'),
                "desc" => "", "icon" => "AttendenceByDataPerUser.png"
            );
            $links[] = array(
                'name' => "Students Profile Medical Assessment", "link" => base_url('EN/DashboardSystem/patient-profile-report'),
                "desc" => "", "icon" => "AttendenceByDataPerUser.png"
            );
            $links[] = array(
                'name' => "Students Buss Attendance", "link" => base_url('EN/DashboardSystem/student-buss-attendance'),
                "desc" => "", "icon" => "AttendenceByDataPerUser.png"
            );
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | List all ";
            $this->show('EN/Global/Links/Lists', $data);
        } else {
            $dataDes['to'] = "EN/DashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

// Controller: DashboardSystem.php

    public function resultsmap()
    {
        $this->load->library('session');
        $this->load->model('ministry/sv_ministry_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "QlickSystems | List all ";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "post") {
            $data['startdate'] = $this->input->post('start');
            $data['enddate'] = $this->input->post('end');
            $data['alertby'] = $this->input->post("colorsInOrderBy");
        } else {
            $data['startdate'] = date('Y-m-d');
            $data['enddate'] = date('Y-m-d');
            $data['alertby'] = "Temperature";
        }
        $data['schools'] = $this->sv_ministry_reports->fullDataOfour_schools();
        $this->db->select_max('Latitude');
        $data['maxLat'] = $this->db->get('l1_school')->result_array()[0]['Latitude'] ?? 0;
        $this->db->select_max('Longitude');
        $data['maxLong'] = $this->db->get('l1_school')->result_array()[0]['Longitude'] ?? 0;
        $this->show('EN/Ministry/results_map', $data);
    }

    public function schoolResults()
    {
        if ($this->input->post('schoolId')) {
            $schoolId = $this->input->post('schoolId');
            $schoolData = $this->db->get_where('l1_school', array('Id' => $schoolId))->result_array();
            if (!empty($schoolData)) {
                $this->response->json([
                    "schoolname" => $schoolData[0]["School_Name_EN"],
                    "status" => 'ok',
                    "low" => $this->GetTotalIn_all($schoolId, 0, 36.2),
                    "normal" => $this->GetTotalIn_all($schoolId, 36.3, 37.5),
                    "moderate" => $this->GetTotalIn_all($schoolId, 37.6, 38.4),
                    "high" => $this->GetTotalIn_all($schoolId, 38.5, 45),
                ]);
            } else {
                $this->response->json(["status" => 'error']);
            }
        } else {
            $this->response->json(["status" => 'error']);
        }
    }

    private function GetTotalIn_all($schoolId, $from, $To)
    {
        $counter = 0;
        $today = date("Y-m-d");
        $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $schoolId . "'")->result_array();
        foreach ($Ourstaffs as $staff) {
            $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
            AND Created = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }

        $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "' AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResultsT as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }

        $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($OurStudents as $Student_çJDJD) {
            $getResults_Student = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Student_çJDJD['Id'] . "' AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
            foreach ($getResults_Student as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }
        return ($counter);
    }

    public function Lab_Reports()
    {
        if ($this->permissions_array["temperatureandlabs"]) {
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
        WHERE l1_school.Added_by = '" . $sessiondata['admin_id'] . "'
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
        WHERE l1_school.Added_by = '" . $sessiondata['admin_id'] . "'
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
        WHERE l1_school.Added_by = '" . $sessiondata['admin_id'] . "'
        AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
        AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();

            $this->show('EN/Ministry/Lab_Reports', $data);
        } else {
            $dataDes['to'] = "EN/DashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function refrigerators_trips()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Report ";
        $data['sessiondata'] = $sessiondata;
        $ids = array();
        $ids[] = $sessiondata['admin_id'];
        $our_depts = $this->db->query("SELECT Id , School_Name_EN FROM `l1_school` WHERE Added_by = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($our_depts as $dept) {
            $ids[] = $dept['Id'];
        }
        $data['depts'] = $our_depts;
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
            $data['trips'] = $this->db->query("SELECT DISTINCT trip_name 
            FROM `refrigerator_result_log_Daily` 
            WHERE Machine_Id = '" . $conditions['Machine_Id'] . "'
            ORDER BY `Machine_Id` ASC")->result_array();
        } else {
            $data['trips'] = array();
        }


        if ($data['tripName'] !== "") {
            $conditions['trip_name'] = $data['tripName'];
        }

        if ($data['department'] == "") {
            $departmentCond = "IN (" . implode(',', $ids) . ")";
        } else {
            $departmentCond = " = " . $this->input->post("department");
        }

        //results array
        // $data['results'] = $this->db->get_where("refrigerator_result_log_Daily", $conditions)->result_array();
        // machens choise
        $data['machiens'] = array();
        $oldIds = array();
        $deptsNames = array();
        if ($data['department'] == "") {
            $condition = "AND ra.`source_id` IN (" . implode(',', $ids) . ")";
        } else {
            $condition = "AND ra.`source_id` = '" . $data['department'] . "' ";
        }
        $data['results'] = $this->db->query("SELECT o.`EN_Title`,cd.`School_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId 
        ,rrld.`mUtcTime`, rrld.`trip_name` , rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
        FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_school` AS cd,`l0_organization` AS o
        WHERE ra.`Id` = rrld.`Machine_Id`
        AND ra.`user_type` = rrld.`user_type`
        AND ra.`source_id` =cd.`Id`
        AND cd.`Added_By` =o.`Id`
        " . ($data['selected'] !== "" ? "AND rrld.`Machine_Id` = " . $data['selected'] : '') . "
        " . ($data['tripName'] !== "" ? 'AND rrld.`trip_name` = ' . "'" . $data['tripName'] . "'" : '') . "
        AND rrld.`user_type`= 'school'
        $condition ;")->result_array();

        if ($data['selected'] !== "") {
            $selects = $this->db->query("SELECT o.`EN_Title`,cd.`School_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId ,rrld.`mUtcTime`,rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
            FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_school` AS cd,`l0_organization` AS o
            WHERE ra.`Id` = rrld.`Machine_Id`
            AND ra.`user_type` = rrld.`user_type`
            AND ra.`source_id` = cd.`Id`
            AND cd.`Added_By` = o.`Id`
            AND rrld.`user_type`= 'school'
            AND ra.`source_id` IN (" . implode(',', $ids) . ");")->result_array();
            $data['trips'] = array();
            $data['machines'] = $selects;
        }

        //chart data provider
        $data['results_chart'] = array();
        $data['time_chart'] = array();
        $data['Humidity_chart'] = array();
        foreach ($data['results'] as $key => $result) {
            if ($result['Created'] == date('Y-m-d')) {
                $data['time_chart'][] = "'" . $result['Time'] . "'";
                $data['results_chart'][] = $result['Result'];
                $data['Humidity_chart'][] = $result['Humidity'];
            }
        }

        $this->show('EN/Ministry/refrigeratorsReports', $data);
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
                        $name = $this->db->query("SELECT Description AS dev_name , l1_school.School_Name_EN
                        FROM refrigerator_visitor 
                        JOIN `l1_school` ON `l1_school`.`Id` = `refrigerator_visitor`.`source_id`
                        WHERE refrigerator_visitor.Id = '" . $result["Machine_Id"] . "' AND  `l1_school`.`Id` = '" . $id . "' LIMIT 1 ")->result_array();
                        if (!empty($name)) {
                            $oldIds[] = $result['Machine_Id'];
                            $machiens[] = array("id" => $result['Machine_Id'], "name" => $name[0]['dev_name']);
                        }
                    } else {
                        $name = $this->db->query("SELECT Description AS dev_name ,  l1_school.School_Name_EN
                        FROM refrigerator_area 
                        JOIN `l1_school` ON `l1_school`.`Id` = `refrigerator_area`.`source_id`
                        WHERE refrigerator_area.Id = '" . $result["Machine_Id"] . "' AND user_type = 'school'
                        AND `l1_school`.`Id` = '" . $id . "'  LIMIT 1 ")->result_array();
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

    public function ClimateSurveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $this->load->model('ministry/sv_ministry_reports'); // loading the model
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = "Qlick Health | Climate Surveys List ";
            if ($this->input->method() == "get") {
                $data['surveys'] = $this->sv_ministry_reports->ClimatesurveysLibrary();
                $data['oursurveys'] = $this->sv_ministry_reports->OurClimatesurveys();
                // $this->response->json($data);
                $this->show('EN/Ministry/Climatesurveys', $data);
            } elseif ($this->input->method() == "put") {
                if ($this->input->input_stream('surveyId')) {
                    $serv_id = $this->input->input_stream('surveyId');
                    if ($this->db->query("UPDATE `scl_st_climate` SET status = IF(status=1, 0, 1) WHERE Id = '" . $serv_id . "'")) {
                        echo "ok";
                    }
                } else {
                    echo "error";
                }
            }
        } else {
            $dataDes['to'] = "EN/dashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function climatePreview()
    {
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                if ($this->input->method() == 'get') {
                    $data['page_title'] = "Qlick Health | Manage Choices ";
                    $data['sessiondata'] = $sessiondata;
                    $data['choices'] = $this->db
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
                    $this->show('EN/Ministry/climatePreview', $data);
                }
            }
        } else {
            $dataDes['to'] = "EN/dashboardSystem";
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
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $data['survId'] = $this->uri->segment(4);
                if ($this->input->method() == "get") {
                    $data['serv_data'] = $this->db->query(" SELECT
                `scl_st0_climate`.`TimeStamp` AS created_at ,
                `scl_st0_climate`.`Id` AS survey_id,
                `scl_st0_climate`.`status` AS status,
                `sv_st_category`.`Cat_en`,
                `sv_st_category`.`Cat_ar`,
                `scl_st0_climate`.`answer_group` AS group_id,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                `sv_set_template_answers`.`title_en` AS choices_title ,
                `sv_questions_library`.`en_title` AS question ,
                (SELECT COUNT(`scl_published_claimate`.`Id`) 
                FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id` ) AS isUsed 
                FROM `scl_st0_climate`
                INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
                JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`
                INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
                LEFT JOIN `scl_st_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`
                LEFT JOIN `scl_published_claimate` ON `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id`
                JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
                WHERE `scl_st0_climate`.`Id` = '" . $data['survId'] . "' AND `scl_st0_climate`.`targeted_type` = 'M' 
                ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
                    if (!empty($data['serv_data'])) {
                        $this->show('EN/Ministry/newclimatesurvey', $data);
                    } else {
                        echo "No data found !!";
                        return redirect("EN/DashboardSystem/ClimateSurveys");
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
                            $data = array(
                                'Title_en' => $this->input->post('title_en'),
                                'Title_ar' => $this->input->post('title_ar'),
                                'Startting_date' => $this->input->post('Start'),
                                'End_date' => $this->input->post('End'),
                                'Avalaible_to' => $this->input->post('avalaible_to'),
                                'Status' => $this->input->post('status') == 1 ? "0" : "1",
                                'Climate_id' => $this->input->post('serv_id'),
                                'Created' => date('Y-m-d'),
                                'Time' => date("H:i:s"),
                                'Published_by' => $sessiondata["admin_id"]
                            );
                            if ($this->db->insert('scl_st_climate', $data)) {
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
            $dataDes['to'] = "EN/dashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function ClimatesLinks()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $prms_survey = $this->db->query(" SELECT `surveys` ,`Created`
        FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
        if (!empty($prms_survey)) {
            $data['sessiondata'] = $sessiondata;
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $links = array();
            $links[] = array('name' => "Climate Library", "link" => base_url('EN/DashboardSystem/ClimateSurveys'), "desc" => "", "icon" => "online-library.png");
            $links[] = array('name' => "Climate Report", "link" => base_url('EN/DashboardSystem/Climate-Dashboard'), "desc" => "", "icon" => "climate-dashboard.png");

            //$links[] = array('name' => "School Climate", "link" => base_url('EN/DashboardSystem/school-reports-climate'), "desc" => "", "icon" => "knowledge.png");
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Climate Links List";
            $this->show('EN/Global/Links/Lists', $data);
        } else {
            $dataDes['to'] = "EN/DashboardSystem";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function ClimateReports()
    {
        $this->load->library('session');
        $this->load->model('ministry/sv_ministry_reports');
        $data['page_title'] = "Qlick Health | Climate Survey Preview ";
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('encrypt_url');
        if (is_numeric($this->encrypt_url->safe_b64decode($this->uri->segment(4)))) {
            $data['surveyid'] = $this->encrypt_url->safe_b64decode($this->uri->segment(4));
            // exit($data['surveyid']);
            if (!empty($this->sv_ministry_reports->GetClimatesurveys(['surveyid' => $data['surveyid']]))) {
                $data['fulldata'] = $this->sv_ministry_reports->GetClimatesurveys(['surveyid' => $data['surveyid']])[0];
                $data['choices'] = $this->sv_ministry_reports->ClimateChoices(['surveyid' => $data['surveyid']]);
                $data['colors'] = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
                $data['types'] = explode(',', $data['fulldata']['typeslist']);
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
                $this->show('EN/Ministry/ClimateReports', $data);
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
        $data["page_title"] = " Consultants ";
        if ($this->uri->segment(4)) { // show the page
            if (!in_array(strtolower($this->uri->segment(4)), ['managment', 'reports', 'chat', "gallery"])) {
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
                    case 'gallery':
                        $this->ConsultantMedia($data);
                        break;
                    default:
                        echo "Can't Find This Page Sorry !";
                        break;
                }
            }
        } else { // show the links
            $links = array();
            $links[] = array(
                'name' => "Consultant Management", "link" => base_url('EN/DashboardSystem/Consultants/Managment'),
                "desc" => "", "icon" => "DTemperature.png"
            );
            $links[] = array(
                'name' => "Consultant Report", "link" => base_url('EN/DashboardSystem/Consultants/Reports'),
                "desc" => "", "icon" => "climate-report.png"
            );
            $links[] = array(
                'name' => "Media Gallery", "link" => base_url('EN/DashboardSystem/Consultants/Gallery'),
                "desc" => "", "icon" => "climate-report.png"
            );
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Consultants ";
            $this->show('EN/Global/Links/Lists', $data);
        }
    }

    private function ConsultantsCRUD(): void
    {
        // Consultants managements (CRUD) page
        $this->consultantsManager->crud();
    }

    private function ConsultantReports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $data['files'] = $this->db->select('FileName AS link , Created AS UploadedAt , Comments , l1_consultant_reports.Id')
                ->select('(SELECT COUNT(Id) 
                            FROM l0_consultant_chat 
                            WHERE l0_consultant_chat.about = l1_consultant_reports.Id 
                            AND receiver_id = "' . $sessiondata['admin_id'] . '" AND receiver_usertype = "' . $sessiondata['type'] . '"
                            AND sender_usertype = "consultant" AND read_at IS NULL) AS UnreadMessages')
                ->from('l1_consultant_reports')
                ->where('AccountId', $sessiondata['admin_id'])
                ->where('AccountType', "M")
                ->get()->result_array();

            $this->show('EN/Component/Consultant/list', $data);
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
            $data['fileid'] = $this->uri->segment(5);
            $Consultantdata = $this->db->where('Id', $data['fileid'])->get("l1_consultant_reports")->row();
            if (empty($Consultantdata)) {
                return redirect('EN/DashboardSysteme/Consultant');
            }
            $data['target'] = $Consultantdata->UploadedBy;
            $this->show('EN/Component/Consultant/chat', $data);
        } else {
            redirect("EN/DashboardSystem/Consultants/Reports");
        }
    }

    private function ConsultantMedia($data)
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $files = $this->db->where('AccountId', $sessiondata['admin_id'])->where('AccountType', 'ministries')->get('sv_st_consultant_media_links')->result_array();
        $this->show('EN/Component/Consultant/MediaGallery', array_merge($data, ['files' => $files]));
    }

    public function results_by_question_chart()
    {
        $id = $this->uri->segment(4);
        if ($id && is_numeric($id) && !$this->uri->segment(5)) {
            if (empty($this->db->where('Id', $id)->limit(1)->get('sv_school_published_surveys')->row())) {
                $this->response->abort();
            }

            $this->load->library('session');
            $this->load->model('ministry/sv_ministry_reports');
            $sessiondata = $this->session->userdata('admin_details');
            $serv_id = $this->uri->segment(4);
            $publishedSurveys = array_column($this->db->where('Serv_id', $serv_id)->select('id')->get('sv_school_published_surveys')->result_array(), 'id');
            if (empty($publishedSurveys)) {
                echo "no results yet...";
                exit();
            } else {
                $publishedSurveys = implode(',', $publishedSurveys);
            }
            if ($this->input->method() == "post") {
                $hasFilters = true;
                $data['filters']['schools'] = $this->input->post('schools');
                $data['filters']['classes'] = $this->input->post('classes');
            } else {
                $data['filters']['schools'] = null;
                $data['filters']['classes'] = null;
            }
            $data['users_passed_survey'] = $this->sv_ministry_reports->users_passed_survey($serv_id, "", $data['filters']);
            $data['used_choices'] = $this->sv_ministry_reports->survey_q_results($serv_id);
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
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_school_published_surveys`.`Id` as surveyId,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_st_surveys`.`reference_en` AS  reference,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
            WHERE `sv_school_published_surveys`.`Id` IN (" . $publishedSurveys . ") AND `sv_st1_surveys`.`Status` = '1' ")->result_array();
            if (!empty($data['serv_data'])) {
                $data['serv_data'] = $data['serv_data'][0];
                $data['users_passed_survey'] = $this->sv_ministry_reports->users_passed_survey($serv_id, "", $data['filters']);
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
                $data['Staffs'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '1', $data['filters']);
                $data['Teachers'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '3', $data['filters']);
                $data['Students'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '2', $data['filters']);
                $data['Parents'] = $this->sv_ministry_reports->users_passed_survey($serv_id, '4', $data['filters']);
                $data['males_count'] = $this->count_gender($this->sv_ministry_reports->get_surv_percintage_by_gender($serv_id, 'M', "", $data['filters']));
                $data['females_count'] = $this->count_gender($this->sv_ministry_reports->get_surv_percintage_by_gender($serv_id, 'F', "", $data['filters']));
                $finishing_all_data = $this->sv_ministry_reports->timeOfFinishingForThisSurvey($serv_id);
                $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
                $data['serv_id'] = $serv_id;
                $data['page_title'] = 'Qlick Health | Chart survey';
                $data['sessiondata'] = $sessiondata;
                $data['schools'] = $this->db->query("SELECT * FROM `l1_school` WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array();
                $data['classes'] = $this->db->query("SELECT * , `r_levels`.`Class` AS Class , `r_levels`.`Id` AS Id  FROM r_levels ORDER BY `r_levels`.`Id` ASC ")->result_array();
                // $this->response->json($data);
                $this->show('EN/Ministry/results_by_question_chart', $data);
            } else {
                echo "No Data Found !!";
            }
        } else {
            echo "No Data Found !!";
        }
    }

    public function climate_results_chart()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->db->Is_existInTable($this->uri->segment(4), 'scl_published_claimate') && !$this->uri->segment(5)) {
            $this->load->library('session');
            $this->load->model('ministry/sv_ministry_reports');
            $data['page_title'] = 'Qlick Health | Chart survey';
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['surveyId'] = $this->uri->segment(4);
            $data['survey_data'] = $this->sv_ministry_reports->GetClimatesurveys([], $data['surveyId']);
            if (empty($data['survey_data'])) {
                echo "can't find any data sorry !";
                exit();
            }
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
            $data['users_passed_survey'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id);
            $data['Staffs'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id, ["ByType" => '1']);
            $data['Students'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id, ["ByType" => '2']);
            $data['Teachers'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id, ["ByType" => '3']);
            $data['Parents'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id, ["ByType" => '4']);
            $data['Males'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id, ["gender" => 'M']);
            $data['Females'] = $this->sv_ministry_reports->GetClimateAnswers($data['survey_data']->survey_id, $data['survey_data']->main_survey_id, ["gender" => 'F']);
            // $this->response->json($data);
            $this->show('EN/Ministry/climate_results_chart', $data);
        } else {
            echo "survey not found...";
            exit();
        }
    }

    public function Climate_Dashboard()
    {
        $this->load->library('session');
        $this->load->model('ministry/sv_ministry_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Add an Usertype ";
        $data['sessiondata'] = $sessiondata;
        $data['our_schools'] = $this->db->query("SELECT 
        `School_Name_EN`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `status` = '1'
        ORDER BY `Id` DESC ")->result_array();
        $data['fullpage'] = true;
        $data['filters'] = [
            'school' => "",
            'title' => "",
            'from' => "",
            'to' => "",
        ];
        if ($this->input->method() == "post") {
            $data['filters']['school'] = ($this->input->post('school') && is_numeric($this->input->post('school'))) ? $this->input->post('school') : "";
            $data['filters']['title'] = $this->input->post('search');
            $data['filters']['from'] = $this->input->post('from') ?? "";
            $data['filters']['to'] = $this->input->post('to') ?? "";
        }

        $data['climate_surveys'] = $this->sv_ministry_reports->GetClimatesurveys($data['filters']);

        // building the conditions
        if (!empty($data['filters']['school'])) {
            $schools = $data['filters']['school'];
        } else {
            $schools = $this->sv_ministry_reports->getSchools();
            $this->response->abort_if(404, empty($schools));
        }

        // getting the data
        $cond = $this->ClimateConditionsBuilder($data["filters"]);

        $data['results'] = $this->db->query("SELECT sscc.`Climate_id`,
        setd.title_en as title,
        setd.Id as setId,
        COUNT(sca.`climate_id`) d1,
        SUM(ssc.`mark`) ss ,
        sq.`en_title` AS question ,
        ss0c.`category` AS category_id ,
        (SUM(ssc.`mark`) /COUNT(sca.`climate_id`))/(SELECT COUNT(`id`)
        FROM `scl_st_choices` 
        WHERE  `servey_id` =sscc.`Climate_id`
        GROUP BY `servey_id`) *100  ff 
        FROM `scl_climate_answers` AS sca ,
            `scl_published_claimate` spc,
            `scl_st_climate` AS sscc ,
            `scl_st_choices` AS ssc,
            `scl_st0_climate` AS ss0c,
            `sv_questions_library` AS sq,
            `sv_sets` AS setd
        WHERE sca.`climate_id` =spc.`Id`
            AND spc.`climate_id` =sscc.`id`  
            AND sscc.`Climate_id` =ssc.`servey_id`
            AND sca.`answer_id` =ssc.id
            AND ss0c.`Id` = sscc.`Climate_id`
            AND sq.`Id` = ss0c.`question_id`
            AND setd.`Id` = ss0c.`set_id`
            AND spc.By_school IN (" . $schools . ")
            $cond
        GROUP BY setd.`Id` ")->result_array();

        $this->show('EN/Ministry/inc/climate_dashboard', $data);
    }

    private function ClimateConditionsBuilder($filters = [])
    {
        $cond = "";
        if (!empty($filters["class"])) {
            $cond .= " AND (CASE
                WHEN sca.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = sca.`user_id` AND `l2_student`.`Class` IN (" . implode(",", $filters['class']) . ") LIMIT  1 )
            ELSE NULL
            END) IS NOT NULL";
        }
        if (!empty($filters['usertype'])) {
            $cond .= ' AND sca.user_type IN (' . implode(",", $filters['usertype']) . ")";
        }
        if (!empty($filters['gender'])) {
            $cond .= " AND (CASE
                WHEN sca.`user_type` = '1' THEN (SELECT Id FROM `l2_staff` WHERE `l2_staff`.`Id` = sca.`user_id` AND `l2_staff`.`Gender` IN (" . implode(",", $filters['gender']) . ") LIMIT 1 )
                WHEN sca.`user_type` = '2' THEN (SELECT Id FROM `l2_student` WHERE `l2_student`.`Id` = sca.`user_id` AND `l2_student`.`Gender` IN (" . implode(",", $filters['gender']) . ") LIMIT  1 )
                WHEN sca.`user_type` = '3' THEN (SELECT Id FROM `l2_teacher` WHERE `l2_teacher`.`Id` = sca.`user_id` AND `l2_teacher`.`Gender` IN (" . implode(",", $filters['gender']) . ") LIMIT 1 )
                WHEN sca.`user_type` = '4' THEN (SELECT Id FROM `l2_parents` WHERE `l2_parents`.`Id` = sca.`user_id` AND `l2_parents`.`gender` IN (" . implode(",", $filters['gender']) . ") LIMIT 1 )
                ELSE NULL
            END) IS NOT NULL";
        }
        if (!empty($filters['category'])) {
            $cond .= " AND ss0c.category IN (" . implode(",", $filters['category']) . ") ";
        }

        if (!empty($filters['from'])) {
            $cond .= " AND sca.TimeStamp >= '" . $filters["from"] . " 00:00:00'";
        }

        if (!empty($filters['to'])) {
            $cond .= " AND sca.TimeStamp <= '" . $filters["to"] . " 23:59:59'";
        }

        return $cond;
    }

    public function Climate_Report()
    {
        $this->load->library('session');
        $this->load->model('helper');
        $this->load->model('ministry/sv_ministry_reports');
        $data['page_title'] = 'Qlick Health | Chart survey';
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        // filters data provider
        $data["filterssource"]['classes'] = $this->schoolHelper->school_classes($sessiondata['admin_id']);
        $data["filterssource"]['genders'] = [
            [
                "name" => "M",
                "display" => "Male"
            ],
            [
                "name" => "F",
                "display" => "Female"
            ]
        ];
        $data["filterssource"]['category'] = $this->sv_ministry_reports->getclimatesurveyslibrary(true);
        $data["filterssource"]['userstypes'] = $this->helper->get();
        // showing old filters values
        $data['filters'] = [
            'class' => ($this->input->post("class[]") == null || in_array("all", $this->input->post("class[]"))) ? [] : $this->input->post("class[]"),
            'gender' => [],
            'category' => ($this->input->post("category[]") == null || in_array("all", $this->input->post("category[]"))) ? [] : $this->input->post("category[]"),
            'usertype' => ($this->input->post("usertype[]") == null || in_array("all", $this->input->post("usertype[]"))) ? [] : $this->input->post("usertype[]"),
            "from" => $this->input->post("start") ?? date("Y-m-d"),
            "to" => $this->input->post("end") ?? date("Y-m-d"),
        ];
        // values transforming
        if (!empty($this->input->post("gender"))) {
            foreach ($this->input->post("gender") as $filter) {
                $data["filters"]["gender"][] = "'" . $filter . "'";
            }
        }
        // building the conditions
        $cond = $this->ClimateConditionsBuilder($data["filters"]);
        $schools = $this->sv_ministry_reports->getSchools();
        if (empty($schools)) {
            $this->output->set_status_header('404');
            die();
        }
        // getting the data
        $data['results'] = $this->db->query("SELECT sscc.`Climate_id`,
        setd.title_en as title,
        COUNT(sca.`climate_id`) d1,
        SUM(ssc.`mark`) ss ,
        sq.`en_title` AS question ,
        (SUM(ssc.`mark`) /COUNT(sca.`climate_id`))/(SELECT COUNT(`id`)
        FROM `scl_st_choices` 
        WHERE  `servey_id` =sscc.`Climate_id`
        GROUP BY `servey_id`) *100  ff 
        FROM `scl_climate_answers` AS sca ,
            `scl_published_claimate` spc,
            `scl_st_climate` AS sscc ,
            `scl_st_choices` AS ssc,
            `scl_st0_climate` AS ss0c,
            `sv_questions_library` AS sq,
            `sv_sets` AS setd
        WHERE sca.`climate_id` =spc.`Id`
            AND spc.`climate_id` =sscc.`id`  
            AND sscc.`Climate_id` =ssc.`servey_id`
            AND sca.`answer_id` =ssc.id
            AND ss0c.`Id` = sscc.`Climate_id`
            AND sq.`Id` = ss0c.`question_id`
            AND setd.`Id` = ss0c.`set_id`
            AND spc.By_school IN (" . $schools . ")
            $cond
        GROUP BY ss0c.`Id` ")->result_array();
        $data["hidefilters"] = true;
        $this->show('EN/Ministry/climate-dashboard', $data);
    }

    public function category_report_climate()
    {
        $this->load->library('session');
        $this->load->model('helper');
        $data['page_title'] = 'Qlick Health | report climate';
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;

        $this->load->model('ministry/sv_ministry_reports'); // loading the model
        $data['surveys'] = $this->sv_ministry_reports->OurClimatesurveys(); // return categorys used in this school
        $data['schools'] = $this->sv_ministry_reports->schoolsBySurveys();
        $this->show('EN/Ministry/schools-climates', $data);
    }

    public function QM()
    {
        $this->load->library('session');
        $this->load->library('encrypt_url');
        $this->load->model('HealthyModal');
        $this->load->model('ministry/sv_ministry_reports'); // loading the model
        $sessiondata = $this->session->userdata('admin_details');
        $permissions = $this->db->query(" SELECT `surveys` ,`Created` FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `v0_permissions`.`qmcommunity` = '1' LIMIT 1 ")->result_array();
        if (empty($permissions)) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
            return;
        }
        $schools = $this->sv_ministry_reports->our_schools();
        if (empty($schools)) {
            echo "Sorry We Couldn't Find Any Data";
            return;
        }
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $data['activeLanguage'] = 'EN';
        $data['tests'] = $this->db->select("healthy_sessions.*, l1_school.School_Name_EN as schoolName")->where_in("owner", array_column($schools, 'Id'))
            ->join("l1_school", "l1_school.Id = healthy_sessions.owner")
            ->order_by("id", "DESC")->get("healthy_sessions")->result_array();
        $this->lang->load('QM', "english");
        $this->show("Healthy/history", $data);
    }

    public function qm_results()
    {
        $this->load->model('HealthyModal');
        $this->load->library('encrypt_url');
        $this->load->model('ministry/sv_ministry_reports'); // loading the model

        $sessiondata = $this->session->userdata('admin_details');
        $permissions = $this->db->query(" SELECT `surveys` ,`Created` FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Ministry' AND `v0_permissions`.`qmcommunity` = '1' LIMIT 1 ")->result_array();
        if (empty($permissions)) {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
            return;
        }
        $key = $this->uri->segment(4) ? $this->uri->segment(4) : null;

        if (empty($key)) {
            redirect('Healthy/en_history');
            return;
        }
        $schools = $this->sv_ministry_reports->our_schools();
        if (empty($schools)) {
            echo "Sorry We Couldn't Find Any Data";
            return;
        }
        $key = $this->encrypt_url->safe_b64decode($key);
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $this->session->userdata('admin_details');
        $data += $this->HealthyModal->langauge('en')->getResults($key, array_column($schools, 'Id'));
        $data['activeLanguage'] = "en";
        $this->lang->load('QM', "english");
        $this->show('Healthy/results', $data);
    }

    public function publish_course()
    {
        $this->coursesHelper->publishCourse();
    }

    public function courses_category()
    {
        $this->coursesHelper->courses();
    }

    public function courses()
    {
        $this->coursesHelper->categories();
    }

    public function course()
    {
        $this->coursesHelper->course();
    }

    public function getSpeakOutModel()
    {
        $this->load->model('schools/speak_out');
        $school = $this->input->post("school") ?? null;
        $gender = $this->input->post("defaultGender") ?? null;

        if (!empty($school) && is_numeric($school)) {
            return $this->speak_out->setId($school);
        }

        if (!empty($gender)) {
            return $this->speak_out->setGender($gender);
        }

        $schools = $this->db->select("Id")->where('Added_By', $this->sessionData['admin_id'])->get('l1_school')->result_array();
        return $this->speak_out->setIsMinistry(true)->setLanguage(self::LANGUAGE)->setId(array_column($schools, "Id"));
    }

    public function speak_out()
    {
        $this->lang->load('SpeakOut', "english");
        $this->load->helper('text');
        if ($this->input->method() === "post") {
            if ($this->input->post('id') && $this->input->post('for') == "media") {
                $id = $this->input->post('id');
                $medias = $this->db->get_where("l3_mylifereportsmedia", ["report_id" => $id])->result_array();
                $this->response->json(['status' => "ok", "data" => $medias]);
            }

            $country = $this->input->post("country");
            $city = $this->input->post("city");
            $this->showSpeakOutReports($country, $city);
            return;
        }
        $data = $this->getFiltersValues();
        $this->show("EN/Ministry/speak-out-reports", $data);
    }

    private function labtests_counter($id)
    {
        $our_schools = $this->db->query("SELECT 
     `School_Name_EN`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $id . "' ORDER BY `Id` DESC ")->result_array();
        //print_r($our_schools);
        $counter = 0;
        foreach ($our_schools as $school) {
            $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Student");
            $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Teacher");
            $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Staff");
            $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Site");
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
                        $thedate = $Results[0]['Created'] . ' ' . $Results[0]['Time'];
                        $date[] = $thedate;
                    }
                }
            }
        }

        return ($date);
    }

    private function GetTotal($from, $To)
    {
        $counter = 0;
        //$this->load->library( 'session' );
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();
        $schools = $this->db->query("SELECT * FROM `l1_school`
          WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();

        foreach ($schools as $school) {
            $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE 
          `Added_By` = '" . $school['Id'] . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $ID = $staff['Id'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
          AND Result_Date = '" . $today . "' AND UserType = 'Staff'  ORDER BY `Id` DESC LIMIT 1")->result_array();
                //AND `Result` >= ".$from." AND `Result` <= ".$To."
                foreach ($getResults as $results) {
                    if ($results['Result'] >= $from && $results['Result'] <= $To) {
                        $counter++;
                    }
                }
            }

            $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE 
          `Added_By` = '" . $school['Id'] . "' ")->result_array();
            foreach ($OurTeachers as $Teacher) {
                $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
          AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
                //AND `Result` > ".$from." AND `Result` < ".$To."
                foreach ($getResultsT as $results) {
                    if ($results['Result'] >= $from && $results['Result'] <= $To) {
                        $counter++;
                    }
                }
            }

            $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE 
          `Added_By` = '" . $school['Id'] . "' ")->result_array();
            foreach ($OurStudents as $Students) {
                $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Students['Id'] . "'
          AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1")->result_array();
                // AND `Result` > ".$from."  AND `Result` < ".$To."
                foreach ($getResultsT as $results) {
                    if ($results['Result'] >= $from && $results['Result'] <= $To) {
                        $counter++;
                    }
                }
            }
        }

        return ($counter);
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
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $username . ' </h3>
          <h3>Your password is : ' . $pass . ' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';

        $this->email->initialize($config);
        $this->email->set_newline('\r\n');
        $this->email->from('jobs@qlicksystems.com', 'qlicksystems.com');
        $this->email->to($email);
        $this->email->bcc('emails@qlicksystems.com');
        $this->email->subject(' Your User Name And Password ');
        $this->email->message($messg);
        if (!$this->email->send()) {
            echo 'We have an error in sending the email . Please try again later. ';
        } else {
            echo "The Email is Sended !";
        }
        return ('traryradet');
    }

    private function getSpeakOutUsersIds(): array
    {
        $school = $this->input->post("school") ?? null;
        if (!empty($school) && is_numeric($school)) {
            return [$school];
        }

        $schools = $this->db->select("Id")->where('Added_By', $this->sessionData['admin_id'])->get('l1_school')->result_array();
        return array_column($schools, "Id");
    }

    private function getAccountSupportedIds(): array
    {
        $this->load->model('ministry/sv_ministry_reports'); // loading the model
        $schoolsIds = $this->sv_ministry_reports->getSchools(true);
        $this->response->abort_if(403, empty($schoolsIds));

        return $schoolsIds;
    }
} //end extend
