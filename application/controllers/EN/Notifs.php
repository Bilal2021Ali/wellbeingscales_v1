<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Notifs extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata)) {
            redirect('users');
            exit();
        }
    }

    public function ControllerGetter($type)
    {
        $controller = null;
        switch ($type) { // getting the data based on the type
            case 'school':
                $controller = 'schools';
                break;
            case 'department_Company':
                $controller = 'Company_Departments';
                break;
            case 'Ministry':
                $controller = 'DashboardSystem';
                break;
            case 'Company':
                $controller = 'Company';
                break;
            case 'consultant':
                $controller = 'consultant';
                break;
            default:
                exit("Error !!");
                break;
        }
        return $controller;
    }

    public function notification()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $num = $this->db->query("SELECT `Id` FROM `v_notification` WHERE 
        `For_User` = '" . $sessiondata['admin_id'] . "' AND `User_Type` = '" . $sessiondata['type'] . "' AND Is_read  = '0' ")->num_rows();
        $newmessages = $this->db->query("SELECT Id , TimeStamp
                    FROM l0_consultant_chat 
                    WHERE  receiver_id = '" . $sessiondata['admin_id'] . "' AND receiver_usertype = '" . $sessiondata['type'] . "'
                    AND sender_usertype = 'consultant' AND read_at IS NULL")->result_array();
        if (!empty($num) || !empty($newmessages)) {
            echo $num + sizeof($newmessages);
        }
    }

    public function notificationList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $nots = $this->db->query("SELECT * FROM `v_notification` WHERE 
        `For_User` = '" . $sessiondata['admin_id'] . "' 
        AND `User_Type` = '" . $sessiondata['type'] . "' AND Is_read  = '0' ")->result_array();
        $newmessages = $this->db->query("SELECT Id , TimeStamp
            FROM l0_consultant_chat 
            WHERE  receiver_id = '" . $sessiondata['admin_id'] . "' AND receiver_usertype = '" . $sessiondata['type'] . "'
            AND sender_usertype != '" . $sessiondata['type'] . "' AND read_at IS NULL")->result_array();
        $actionlink = base_url("EN/" . $this->ControllerGetter($sessiondata['type']) . "/Consultant/");
        if (!empty($newmessages)) { ?>
            <a href="<?= $actionlink ?>" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-warning rounded-circle font-size-16">
                            <i class="uil-message"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1"><?= sizeof($newmessages) ?> New Message(s) : <span class="float-right badge rounded-pill bg-danger p-1 text-white">Important</span></h6>
                        <div class="font-size-12 text-muted">
                            <p class="text-muted">You have new messages </p>
                            <p class="mb-0"><i class="mdi mdi-clock-outline mr-2"></i>The Last Message Received At : <?= $newmessages[(sizeof($newmessages) - 1)]['TimeStamp'] ?? "--:--:--" ?></p>
                        </div>
                    </div>
                </div>
            </a>
            <?php
        }
        if (!empty($nots)) {
            foreach ($nots as $not) { ?>
                <a href="" class="text-reset notification-item">
                    <div class="media">
                        <div class="avatar-xs mr-3">
                            <span class="avatar-title bg-muted rounded-circle font-size-16">
                                <i class="uil-user"></i>
                            </span>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 mb-1">Notification</h6>
                            <div class="font-size-12 text-muted">
                                <p class="text-muted">The user "<?php echo $not['User_Entred'] ?>" was entered</p>
                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i><?php echo $not['Created'] ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            }
        } else {   ?>
            <a href="" class="text-reset notification-item">
                <div class="media">
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">No notifications found for you.</h6>
                    </div>
                </div>
                </div>
            </a>
<?php }
    }

    public function SetReaded()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->db->query("UPDATE `v_notification` SET `Is_read` = '1' WHERE 
      `User_Type` = '" . $sessiondata["type"] . "' AND `For_User` = '" . $sessiondata["admin_id"] . "' ");
    }
}


