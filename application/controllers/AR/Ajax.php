<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($sessiondata) && $method == "POST") {
        } elseif ($method == "POST" && isset($_GET['syncing'])) {
        } else {
            ?>
            <script>
                location.href = "<?= base_url(); ?>AR/users";
                alert('Please refresh the page');
            </script>
            <?php
            //redirect('AR/users');
            exit();
        }
    }


    public function GetClassesList()
    {
        $sessiondata = $this->session->userdata('admin_details');
        ?>
        <div class="float-right">
            <div class="dropdown classes_temp">
                <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <span class="text-muted">
                        المرحلة الدراسية
                        <i class="mdi mdi-chevron-down ml-1"></i></span>
                </a>
                <style>
                    .dropdown-menu * {
                        cursor: pointer;
                    }
                </style>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <?php
                    $classes = $this->schoolHelper->getActiveSchoolClassesByStudents(); // return classes array
                    if (!empty($classes)) { ?>
                        <?php foreach ($classes as $class) { ?>
                            <li class="dropdown-item"
                                onClick="GetTheStudentsLabResultsForClass(<?= $class['Id'] ?>)"><?= $class['Class']; ?></li>
                        <?php } ?>
                    <?php } else { ?>
                        <li class="dropdown-item">
                            لا يوجد صفوف في النظام التعليمي
                        </li>
                    <?php } ?>
                </div>
            </div>
        </div>
        <script>
            function GetTheStudentsLabResultsForClass(className) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>AR/ajax/ListLabResultsOfStudents',
                    data: {
                        class: className,
                        testType: '<?= $this->input->post('TestDesc'); ?>',
                    },
                    beforeSend: function () {
                        $('.New_Data').html('');
                        $('.New_Data').append('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
                    },
                    success: function (data) {
                        $('.New_Data .spinner-border').remove();
                        $('.New_Data').removeAttr('disabled', '');
                        $('.New_Data').append(data);
                    },
                    ajaxError: function () {
                        $('#ResultsTableStudents').css('background-color', '#DB0404');
                        $('#ResultsTableStudents').html("Ooops! لدينا خطأ");
                    }
                });
            }
        </script>
    <?php }

    public function ListLabResultsOfStudents()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST" && $this->input->post("class") !== "") {
            $class = $this->input->post("class");
            $sessiondata = $this->session->userdata('admin_details');
            $testType = $this->input->post('testType');
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT `l2_student`.* , `r_levels`.`Class` AS Class_name FROM l2_student
            JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
            WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `l2_student`.`Class` = '" . $class . "' ")->result_array();
            //print_r($Ourstaffs);
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
                $ID = $staff['Id'];
                $Grade = $staff['Grades'];
                $getResults = $this->db->query("SELECT * FROM `l2_labtests` WHERE `UserId` = '" . $ID . "' AND `Created` = '" . $today . "'
                AND UserType = 'Student' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array(
                        "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Created'], "Symptoms" => $results['Symptoms'], "Time" => $results['Time'], "In" => $results['Action'], 'Grade' => $Grade
                    );
                }
            } ?>
            <p style="margin-top: 45px;text-align:center;"><?= $testType; ?></p>
            <table class="table table-borderless table-centered table-nowrap" id="student_result_lab_tb">
                <thead>
                <tr>
                    <th> #</th>
                    <th> الصورة</th>
                    <th> الاسم</th>
                    <th> المعلمين</th>
                    <th> الصف</th>
                    <th> التاريخ</th>
                    <th> الوقت</th>
                    <th> النتيجة</th>
                    <th> الأعراض</th>
                    <th> الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <style>
                    .badge {
                        text-align: center;
                    }
                </style>
                <?php foreach ($list as $staffsRes) { ?>
                    <tr>
                        <td><?= $staffsRes['TestId']; ?></td>
                        <td style="width: 20px;">
                            <?php
                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                            ?>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                        </td>
                        <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal"><?= $staffsRes['Username']; ?></h3>
                                <td>
                                    <h6 class="font-size-15 mb-1 font-weight-normal"> <?= $staffsRes['Username']; ?></h6>
                                    <?php if ($staffsRes['In'] == "Home") { ?>
                                        <p class="font-size-13 mb-0 text-primary"><b><?= $staffsRes['In'] ?></b></p>
                                    <?php } elseif ($staffsRes['In'] == "Quarantine") { ?>
                                        <p class="font-size-13 mb-0 text-danger"><b><?= $staffsRes['In'] ?></b></p>
                                    <?php } else { ?>
                                        <p class="font-size-13 mb-0 text-success"><?= $staffsRes['In'] ?></p>
                                    <?php } ?>
                                </td>
                        </td>
                        <td style="padding-left: 40px;z-index: 1000;">
                            <?php
                            $teacher = $this->db->query("SELECT * FROM  `l2_teacher`  
                                JOIN `l2_teachers_classes` ON `l2_teachers_classes`.`class_id` = '" . $class . "'
                                AND `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id`
                                WHERE  `Added_By` = '" . $sessiondata['admin_id'] . "' LIMIT 2 ")->result_array();
                            $isHimTeavher = array();
                            foreach ($teacher as $teach) {
                                $avatar_teach = $this->db->query("SELECT * FROM `l2_avatars`
                                    WHERE `For_User` = '" . $teach['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                ?>
                                <?php if (empty($avatar_teach)) { ?>
                                    <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                         class="avatar-xs rounded-circle " alt="..."
                                         style="margin-left:-20px;border: 3px solid #fff;">
                                <?php } else { ?>
                                    <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar_teach[0]['Link']; ?>"
                                         class="avatar-xs rounded-circle " alt="..."
                                         style="margin-left:-20px;border: 3px solid #fff;">
                                <?php }
                            }
                            ?>
                            <span class="More">
                                    <a class="right-bar-toggle" onClick="initRightSidebar();"
                                       title="Double click to display the information">
                                        <?= sizeof($teacher) ? sizeof($teacher) . "+" : "0"; ?>
                                    </a>
                                </span>
                        </td>
                        <td>
                            <?= $staffsRes['Grade']; ?>
                        </td>
                        <td>
                            <?= $staffsRes['Creat']; ?>
                        </td>
                        <td>
                            <?= $staffsRes['Time']; ?>
                        </td>
                        <?php $this->Boxes_Colors($staffsRes['Result']); ?>
                        <td><?php
                            $symps = $staffsRes['Symptoms'];
                            $Symps_array = explode(';', $symps);
                            //print_r($Symps_array);
                            if (!empty($symps)) {
                                foreach ($Symps_array as $sympsArr) {
                                    //print_r($sympsArr);
                                    //echo sizeof($Symps_array);
                                    $SempName = $this->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                                    foreach ($SempName as $name) {
                                        echo $name['symptoms_AR'] . ",";
                                    }
                                }
                            } else {
                                echo "لا توجد أعراض";
                            }
                            ?></td>
                        <td>
                            <a href="javascript:void(0);" class="px-3 text-primary goHome_labtests"
                               data-toggle="tooltip" data-placement="top" title="stay home"
                               data-original-title="Stay Home" theId="<?= $staffsRes['Id']; ?>">
                                <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                            </a>
                            <a href="javascript:void(0);" class="text-danger Quarantine_labtests" data-toggle="tooltip"
                               data-placement="top" title="Quarantine " data-original-title="Quarantine"
                               theId="<?= $staffsRes['Id']; ?>">
                                <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <script>
                try {
                    $("#student_result_lab_tb").DataTable();
                } catch (err) {
                    null;
                }
                $('.goHome_labtests').each(function () {
                    $(this).click(function () {
                        var theId = $(this).attr('theId');
                        console.log(theId);
                        Swal.fire({
                            title: 'هل ترغب بنقل الطالب إلى الحجر المنزلي؟',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: `yes`,
                            cancelButtonText: `cancel`,
                            icon: 'warning',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?= base_url(); ?>AR/Schools/SetStudentInHouse_LabTests',
                                    data: {
                                        S_Id: theId,
                                        Action: 'Home',
                                    },
                                    success: function (data) {
                                        Swal.fire(
                                            'success',
                                            data,
                                            'success'
                                        );
                                        $('#' + theId).remove();
                                    },
                                    ajaxError: function () {
                                        Swal.fire(
                                            'error',
                                            'oops! لدينا خطأ',
                                            'error'
                                        )
                                    }
                                });
                            }
                        })
                    });
                });
                $('.Quarantine_labtests').each(function () {
                    $(this).click(function () {
                        var theId = $(this).attr('theId');
                        console.log(theId);
                        Swal.fire({
                            title: 'هل ترغب بنقل الطالب إلى الحجر الصحي؟ ',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: `yes`,
                            cancelButtonText: `cancel`,
                            icon: 'warning',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?= base_url(); ?>AR/Schools/SetStudentInHouse_LabTests',
                                    data: {
                                        S_Id: theId,
                                        Action: 'Quarantine',
                                    },
                                    success: function (data) {
                                        Swal.fire(
                                            'success',
                                            data,
                                            'success'
                                        );
                                        $('#' + theId).remove();
                                    },
                                    ajaxError: function () {
                                        Swal.fire(
                                            'error',
                                            'oops!! لدينا خطأ',
                                            'error'
                                        )
                                    }
                                });
                            }
                        })
                    });
                });

                function initRightSidebar() {
                    // right side-bar toggle
                    $('.right-bar-toggle').on('click', function (e) {
                        $('body').toggleClass('right-bar-enabled');
                    });
                    $(document).on('click', 'body', function (e) {
                        if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                            return;
                        }
                        $('body').removeClass('right-bar-enabled');
                        return;
                    });
                    ConnectedWithClass(<?= $class; ?>);
                }
            </script>
            <?php
        } else {
            echo "لا يوجد مراحل دراسية";
        } // end if post    
    } // end Function    

    public function Get_Staffs_List()
    {
        $sessiondata = $this->session->userdata('admin_details');
        ?>
        <div id="simpl_staff_list">
            <?php
            $list = array();
            $testType = $this->input->post('TestDesc');
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
                $ID = $staff['Id'];
                $Action = $staff['Action'];
                $Position_Staff = $staff['Position'];
                $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
				AND Created = '" . $today . "' AND UserType = 'Staff' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Created'] . " " . $results['Time'], 'position' => $Position_Staff, "Action" => $Action);
                }
            } ?>
            <table class="table table-borderless table-centered table-nowrap Lab_Table" id="staff_lab_table_results">
                <thead>
                <th>#</th>
                <th> الصورة</th>
                <th> الاسم</th>
                <th> الحالة</th>
                <th> التاريخ &amp; الوقت</th>
                <th> النتيجة</th>
                <th> الإجراءات</th>
                </thead>
                <tbody>
                <style>
                    .badge {
                        text-align: center;
                    }
                </style>
                <?php foreach ($list as $sn => $staffsRes) { ?>
                    <tr>
                        <td><?= $sn + 1 ?></td>
                        <td style="width: 20px;">
                            <?php
                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                            ?>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                        </td>
                        <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal"><?= $staffsRes['Username']; ?></h6>
                            <p class="text-muted font-size-13 mb-0"><i
                                        class="mdi mdi-user"></i> <?= $staffsRes['position']; ?></p>
                        </td>
                        <td><?= $staffsRes['Action']; ?></td>
                        <td><?= $staffsRes['Creat']; ?></td>
                        <?php $this->Boxes_Colors($staffsRes['Result']); ?>
                        <td>
                            <a href="javascript:void(0);" class="px-3 text-primary"
                               onClick="setmemberInLabAction(<?= $staffsRes['Id'] ?>,'Staff','Home');"
                               data-toggle="tooltip" data-placement="top" title="stay home"
                               data-original-title="stay home">
                                <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                            </a>
                            <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip"
                               onClick="setmemberInLabAction(<?= $staffsRes['Id'] ?>,'Staff','Quarantine');"
                               data-placement="top" title="Quarantine">
                                <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="return_lab"></div>
        <script>
            try {
                $('#staff_lab_table_results').DataTable();
            } catch (err) {
                null;
            }

            function setmemberInLabAction(id, usertype, action) {
                var theId = id;
                Swal.fire({
                    title: 'هل أنت متأكد أنك تريد القيام بهذا الإجراء؟',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `yes`,
                    cancelButtonText: `cancel`,
                    icon: 'warning',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>AR/Schools/ApplyLabActionOnMember_lab',
                            data: {
                                S_Id: theId,
                                Action: action,
                                UserType: usertype,
                            },
                            success: function (data) {
                                $('#return_lab').html(data);
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! لدينا خطأ',
                                    'error'
                                )
                            }
                        });
                    }
                });
            }
        </script>
        <?php
    }

    public function Get_Staffs_List_comp()
    {
        $sessiondata = $this->session->userdata('admin_details');
        ?>
        <div id="simpl_staff_list">
            <?php
            $list = array();
            $testType = $this->input->post('TestDesc');
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
                $ID = $staff['Id'];
                $Position_Staff = $staff['Position'];
                $action = $staff['Action'];
                $u_type = $staff['UserType'];
                $getResults = $this->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $u_type . "' 
AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array(
                        "Username" => $staffname, "Id" => $ID,
                        "Testtype" => $results['Device_Test'],
                        "Result" => $results['Result'], "Creat" => $results['Created'] . " " . $results['Time'],
                        'position' => $Position_Staff, "UserType" => $u_type, "Symptoms" => $results['Symptoms'],
                        "Action" => $action
                    );
                }
            }
            ?>
            <table class="table table-borderless table-centered table-nowrap Lab_Table">
                <thead>
                <th> الصورة</th>
                <th> الاسم</th>
                <th> النتيجة</th>
                <th> الأعراض</th>
                <th> نوع المستخدم</th>
                <th> التاريخ &amp; الوقت</th>
                <th> حالة المستخدم</th>
                <th> الإجراءات</th>
                </thead>
                <tbody>
                <?php
                foreach ($list as $staffsRes) {
                    ?>
                    <tr>
                        <td style="width: 20px;">
                            <?php
                            $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                                WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = '" . $staffsRes['UserType'] . "' LIMIT 1 ")->result_array();
                            ?>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                        </td>
                        <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal"><?= $staffsRes['Username']; ?></h6>
                            <p class="text-muted font-size-13 mb-0"><i
                                        class="mdi mdi-user"></i> <?= $staffsRes['position']; ?></p>
                        </td>
                        <?php $this->Boxes_Colors($staffsRes['Result']); ?>
                        <td><?php
                            $symps = $staffsRes['Symptoms'];
                            $Symps_array = explode(';', $symps);
                            if (!empty($symps)) {
                                foreach ($Symps_array as $sympsArr) {
                                    $SempName = $this->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                                    foreach ($SempName as $name) {
                                        echo $name['symptoms_AR'] . ",";
                                    }
                                }
                            } else {
                                echo "بدون أعراض";
                            }
                            ?></td>
                        <td><?= $staffsRes['UserType']; ?></td>
                        <td><?= $staffsRes['Creat']; ?></td>
                        <td><?= $staffsRes['Action'] ?></td>
                        <td>
                            <a href="javascript:void(0);" class="px-3 text-primary"
                               onClick="setmemberInLabAction(<?= $staffsRes['Id'] ?>,'<?= $staffsRes['UserType']; ?>','Home');"
                               data-toggle="tooltip" data-placement="top" title="stay home">
                                <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                            </a>
                            <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip"
                               onClick="setmemberInLabAction(<?= $staffsRes['Id'] ?>,'<?= $staffsRes['UserType']; ?>','Quarantine');"
                               data-placement="top" title=" Quarantine ">
                                <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="return_lab"></div>
        <script>
            try {
                $('.Lab_Table').DataTable();
            } catch (err) {
                null;
            }

            function setmemberInLabAction(id, usertype, action) {
                var theId = id;
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `yes`,
                    cancelButtonText: ` cancel `,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>AR/Company_Departments/ApplyLabActionOnMember_lab',
                            data: {
                                S_Id: theId,
                                Action: action,
                                UserType: usertype,
                            },
                            success: function (data) {
                                $('#return_lab').html(data);
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! لدينا خطأ',
                                    'error'
                                )
                            }
                        });
                    }
                });
            }
        </script>
        <?php
    }

    public function Get_Teachers_List()
    {
        $sessiondata = $this->session->userdata('admin_details'); ?>
        <?php
        $list = array();
        $testType = $this->input->post('TestDesc');
        $today = date("Y-m-d");
        $Ourstaffs = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
            $ID = $staff['Id'];
            $Action = $staff['Action'];
            $Position_Staff = $staff['Position'];
            $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
            AND Created = '" . $today . "' AND UserType = 'Teacher' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults as $results) {
                $list[] = array("Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Created'] . " " . $results['Time'], 'position' => $Position_Staff, "Action" => $Action);
            }
        } ?>
        <table class="table table-borderless table-centered table-nowrap Lab_Table">
            <thead>
            <th>#</th>
            <th> الصورة</th>
            <th> الاسم</th>
            <th> الحالة</th>
            <th> التاريخ &amp; الوقت</th>
            <th> النتيجة</th>
            <th> الإجراءات</th>
            </thead>
            <tbody>
            <style>
                .badge {
                    text-align: center;
                }
            </style>
            <?php foreach ($list as $sn => $staffsRes) { ?>
                <tr>
                    <td><?= $sn + 1 ?></td>
                    <td style="width: 20px;">
                        <?php
                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                            WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                        if (empty($avatar)) { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } ?>
                    </td>
                    <td>
                        <h6 class="font-size-15 mb-1 font-weight-normal"><?= $staffsRes['Username']; ?></h6>
                        <p class="text-muted font-size-13 mb-0"><i
                                    class="mdi mdi-user"></i> <?= $staffsRes['position']; ?></p>
                    </td>
                    <td><?= $staffsRes['Action']; ?></td>
                    <td><?= $staffsRes['Creat']; ?></td>
                    <?php if ($staffsRes['Result'] == '1') { ?>
                        <td>
                                <span class="badge font-size-12"
                                      style="width: 100%;background-color: #ff0000;color: #d2d2d2;">
                                    <?= " إيجابي (+)"; ?>
                                </span>
                        </td>
                    <?php } else { ?>
                        <td>
                                <span class="badge font-size-12"
                                      style="width: 100%;background-color: #34c38f;color: #ffffff;">
                                    <?= " سلبي (-)"; ?></span>
                        </td>
                    <?php } ?>
                    <td>
                        <a href="javascript:void(0);" class="px-3 text-primary"
                           onClick="setmemberInLabAction(<?= $staffsRes['Id'] ?>,'Teacher','Home');" title="Home ">
                            <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                        </a>
                        <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip"
                           onClick="setmemberInLabAction(<?= $staffsRes['Id'] ?>,'Teacher','Quarantine',);"
                           title="Quarantine">
                            <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px">
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div id="return_lab_Teach"></div>
        <script>
            try {
                $('.Lab_Table').DataTable();
            } catch (err) {
                null;
            }

            function setmemberInLabAction(id, usertype, action) {
                var theId = id;
                Swal.fire({
                    title: ' هل أنت متأكد؟ ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: ` yes `,
                    cancelButtonText: ` cancel `,
                    icon: 'warning',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>AR/Schools/ApplyLabActionOnMember_lab',
                            data: {
                                S_Id: theId,
                                Action: action,
                                UserType: usertype,
                            },
                            success: function (data) {
                                $('#return_lab_Teach').html(data);
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! لدينا خطأ',
                                    'error'
                                )
                            }
                        });
                    }
                });
            }
        </script>
        <?php
    }

    public function Get_Quaranrine_List()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $testType = $this->input->post('TestDesc');
        $listTeachers = array();
        $today = date("Y-m-d");
        $students = $this->db->query("SELECT `l2_student`.* , `r_levels`.`Class` AS Class_name FROM l2_student
        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
        WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($students as $student) {
            $studentname = $student['F_name_AR'] . ' ' . $student['L_name_AR'];
            $ID = $student['Id'];
            $Position = $student['Position'];
            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $student['Id'] . "'
            AND UserType = 'Student' AND `Action` = 'Quarantine' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $student['Id'] . "'
                AND UserType = 'Student' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . ' ' . $lastReads[0]['Time'];
                $liststudents[] = array(
                    "Username" => $studentname, "Id" => $ID, "TestId" => $T_results['Id'],
                    "Testtype" => $T_results['Device_Test'], "Result" => $T_results['Result'],
                    "Creat" => (empty($student['last_change_status_date']) ? "0000-00-00 00:00:00" : $student['last_change_status_date']),
                    "Class_OfSt_q" => $student['Class_name'], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                );
            }
        }
        ?>
        <table class="table table-borderless table-centered table-nowrap Lab_Table-Labtets">
            <thead>
            <th> الصورة</th>
            <th> الاسم</th>
            <th> التاريخ &amp; الوقت</th>
            <th> النتيجة</th>
            <th> عدد الأيام</th>
            <th> الإجراءات</th>
            </thead>
            <tbody>
            <style>
                .badge {
                    text-align: center;
                }
            </style>
            <?php foreach ($listTeachers as $TeacherRes) { ?>
                <tr>
                    <td style="width: 20px;">
                        <?php
                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                            WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                        ?>
                        <?php if (empty($avatar)) { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } ?>
                    </td>
                    <td>
                        <h6 class="mb-1 font-weight-normal"
                            style="font-size: 13px;"><?= $TeacherRes['Username']; ?></h6>
                        <p class="text-muted font-size-13 mb-0"><i
                                    class="mdi mdi-user"></i><?= $TeacherRes['Class_OfSt_q']; ?></p>
                    </td>
                    <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
                    <?php $this->Boxes_Colors($TeacherRes['LastRead']); ?>
                    <td>
                        <?php
                        $from_craet = $TeacherRes['Creat'];
                        //echo $from_craet;
                        //$toTime = $today-$from_craet;
                        $date_exp = explode(" ", $from_craet)[0];
                        $finalDate = $this->dateDiffInDays($from_craet, $today);
                        if ($finalDate == 0) {
                            echo "اليوم";
                        } elseif ($finalDate > 2) {
                            echo $finalDate . " أيام";
                        } else {
                            echo $finalDate . " أيام";
                        }
                        ?>
                    </td>
                    <td class="out">
                        <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" width="14px"
                             onClick="RemoveThisMemberFrom_lab(<?= $TeacherRes['Id']; ?>,'Student','School');">
                    </td>
                </tr>
            <?php } ?>
            <?php $this->lab_StayHomeOfQuarantin('Teacher', $testType); ?>
            <?php $this->lab_StayHomeOfQuarantin('Staff', $testType); ?>
            </tbody>
        </table>
        <script>
            try {
                $('.Lab_Table-Labtets').DataTable();
            } catch (err) {
                null;
            }
        </script>
        <?php
    }

    public function Get_Quaranrine_List_co()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $testType = $this->input->post('TestDesc');
        $listTeachers = array();
        $today = date("Y-m-d");
        $listUsers = $this->db->query("SELECT
concat(`F_name_AR`,' ',`L_name_AR`) as Username , `l2_co_patient`.`UserType` ,`l2_co_patient`.`Position` ,
`l2_co_patient`.`Id` as UserId , `l2_co_labtests`.`Created` as Creat ,
concat( `l2_co_labtests`.`Created`,' ',`l2_co_labtests`.`Time`) as LastReadDate ,
`l2_co_labtests`.`Result` as LastRead ,`l2_co_avatars`.`Link`
FROM  `l2_co_patient` 
JOIN `l2_co_labtests` ON `l2_co_patient`.`UserType` = `l2_co_labtests`.`UserType`
LEFT JOIN `l2_co_avatars`
ON `l2_co_patient`.`Id` =  `l2_co_avatars`.`For_User` AND `l2_co_avatars`.`Type_Of_User` = `l2_co_patient`.`UserType`
inner join (
  select max(TimeStamp) as latest 
  from l2_co_labtests 
  group by UserId
) r on `l2_co_labtests`.`TimeStamp`  = r.latest 
WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'
AND `l2_co_patient`.`Action` = 'Quarantine' AND `l2_co_patient`.`Id` = `l2_co_labtests`.`UserId`
AND `l2_co_labtests`.`Test_Description` = '" . $testType . "'
ORDER BY `l2_co_labtests`.`TimeStamp` DESC")->result_array();
        //echo $this->db->last_query();
        ?>
        <table class="table table-borderless table-centered table-nowrap Lab_Table-Labtets">
            <thead>
            <th> الصورة</th>
            <th> الاسم</th>
            <th> التاريخ &amp; الوقت</th>
            <th> النتيجة</th>
            <th> عدد الأيام</th>
            <th> الإجراءات</th>
            </thead>
            <tbody>
            <style>
                .badge {
                    text-align: center;
                }
            </style>
            <?php foreach ($listUsers as $User) { ?>
                <tr>
                    <td style="width: 20px;">
                        <?php if (empty($User['Link'])) { ?>
                            <img src="<?= base_url(); ?>uploads/co_avatars/default_avatar.jpg"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/co_avatars/<?= $User['Link']; ?>"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } ?>
                    </td>
                    <td>
                        <h6 class="mb-1 font-weight-normal" style="font-size: 13px;"><?= $User['Username']; ?></h6>
                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?= $User['Position']; ?>
                        </p>
                    </td>
                    <td style="font-size: 12px;"><?= $User['LastReadDate']; ?></td>
                    <?php $this->Boxes_Colors($User['LastRead']); ?>
                    <td>
                        <?php
                        $from_craet = $User['Creat'];
                        $finalDate = $this->dateDiffInDays($from_craet, $today);
                        if ($finalDate == 0) {
                            echo "اليوم";
                        } elseif ($finalDate > 2) {
                            echo $finalDate . " أيام";
                        } else {
                            echo $finalDate . " أيام";
                        }
                        ?>
                    </td>
                    <td class="out">
                        <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" width="14px"
                             onClick="RemoveThisMemberFrom_lab(<?= $User['UserId']; ?>,'<?= $User['UserType'] ?>','work');">
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <script>
            try {
                $('.Lab_Table-Labtets').DataTable();
            } catch (err) {
                null;
            }
        </script>
        <?php
    }

    private function lab_StayHomeOfQuarantin($type, $testType)
    {
        $count = 0;
        $sessiondata = $this->session->userdata('admin_details');
        if ($type == "Teacher") {
            $ours = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        } else {
            $ours = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        }
        $listTeachers = array();
        $today = date("Y-m-d");
        foreach ($ours as $Teacher) {
            $Teachername = $Teacher['F_name_AR'] . ' ' . $Teacher['L_name_AR'];
            $ID = $Teacher['Id'];
            $Position = $Teacher['Position'];
            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "'  AND `Action` = 'Quarantine' AND `Test_Description` = '" . $testType . "' 
            ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
                AND UserType = '" . $type . "' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . ' ' . $lastReads[0]['Time'];
                $listTeachers[] = array(
                    "Username" => $Teachername, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                    "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                    "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                );
            }
        } ?>
        <style>
            .badge {
                text-align: center;
            }
        </style>
        <?php
        $count += sizeof($listTeachers);
        foreach ($listTeachers as $TeacherRes) { ?>
            <?php //print_r($TeacherRes); 
            ?>
            <tr>
                <td style="width: 20px;">
                    <?php
                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                    WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                    ?>
                    <?php if (empty($avatar)) { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } ?>
                </td>
                <td>
                    <h6 class="mb-1 font-weight-normal" style="font-size: 13px;"><?= $TeacherRes['Username']; ?></h6>
                    <p class="text-muted font-size-13 mb-0"><i
                                class="mdi mdi-user"></i><?= $TeacherRes['Class_OfSt']; ?></p>
                </td>
                <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
                <?php if ($TeacherRes['LastRead'] == '1') { ?>
                    <td>
                        <span class="badge font-size-12" style="width: 100%;background-color: #ff0000;color: #d2d2d2;">
                            <?= "(+) إيجابي "; ?>
                        </span>
                    </td>
                <?php } else { ?>
                    <td>
                        <span class="badge font-size-12" style="width: 100%;background-color: #34c38f;color: #ffffff;">
                            <?= " (-) سلبي "; ?>
                        </span>
                    </td>
                <?php } ?>
                <td>
                    <?php
                    $from_craet = $TeacherRes['Creat'];
                    $date_exp = explode(" ", $from_craet)[0];
                    //echo $from_craet;
                    //$toTime = $today-$from_craet;
                    $finalDate = $this->dateDiffInDays($date_exp, $today);
                    if ($finalDate == 0) {
                        echo "اليوم";
                    } elseif ($finalDate > 2) {
                        echo $finalDate . "أيام";
                    } else {
                        echo $finalDate . "أيام";
                    }
                    ?>
                </td>
                <td class="out">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" width="14px"
                         onClick="RemoveThisMemberFrom_lab(<?= $TeacherRes['Id']; ?>,'<?= $type ?>','School');">
                </td>
            </tr>
        <?php }
    }

    private function dateDiffInDays($date1, $date2)
    {
        // Calculating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1);
        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400));
    }

    public function Get_home_List()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $testType = $this->input->post('TestDesc');
        $listTeachers = array();
        $today = date("Y-m-d");
        $OurTeachers = $this->db->query("SELECT `l2_student`.* , `r_levels`.`Class` AS Class_name FROM l2_student
        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
        WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            $Teachername = $Teacher['F_name_AR'] . ' ' . $Teacher['L_name_AR'];
            $ID = $Teacher['Id'];
            $His_Class_Q = $Teacher['Class_name'];
            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
			AND UserType = 'Student' AND `Action` = 'Home' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
				AND UserType = 'Student' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . ' ' . $lastReads[0]['Time'];
                $listTeachers[] = array(
                    "Username" => $Teachername, "Id" => $ID, "TestId" => $T_results['Id'],
                    "Testtype" => $T_results['Device_Test'], "Result" => $T_results['Result'],
                    "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                    "Class_OfSt_q" => $His_Class_Q, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                );
            }
        } ?>
        <table class="table table-borderless table-centered table-nowrap Lab_Table">
            <thead>
            <th> الصورة</th>
            <th> الاسم</th>
            <th> التاريخ &amp; الوقت</th>
            <th> النتيجة</th>
            <th> عدد الأيام</th>
            <th> الإجراءات</th>
            </thead>
            <tbody>
            <style>
                .badge {
                    text-align: center;
                }
            </style>
            <script>
                var Quarnt_Count_S = <?= sizeof($listTeachers); ?>;
            </script>
            <?php foreach ($listTeachers as $TeacherRes) { ?>
                <?php //print_r($TeacherRes);
                ?>
                <tr>
                    <td style="width: 20px;">
                        <?php $avatar = $this->db->query("SELECT * FROM `l2_avatars`
							WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                        ?>
                        <?php if (empty($avatar)) { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                 class="avatar-xs rounded-circle " alt="...">
                        <?php } ?>
                    </td>
                    <td>
                        <h6 class="mb-1 font-weight-normal"
                            style="font-size: 13px;"><?= $TeacherRes['Username']; ?></h6>
                        <p class="text-muted font-size-13 mb-0"><i
                                    class="mdi mdi-user"></i><?= $TeacherRes['Class_OfSt_q']; ?></p>
                    </td>
                    <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
                    <?php $this->Boxes_Colors($TeacherRes['LastRead']); ?>
                    <td>
                        <?php
                        $from_craet = $TeacherRes['Creat'];
                        //echo $from_craet;
                        //$toTime = $today-$from_craet;
                        $date_exp = explode(" ", $from_craet)[0];
                        $finalDate = $this->dateDiffInDays($date_exp, $today);
                        if ($finalDate == 0) {
                            echo "اليوم";
                        } elseif ($finalDate > 2) {
                            echo $finalDate . "أيام";
                        } else {
                            echo $finalDate . "أيام";
                        }
                        ?>
                    </td>
                    <td class="out">
                        <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" width="14px"
                             onClick="RemoveThisMemberFrom_lab(<?= $TeacherRes['Id']; ?>,'Student','School');">
                    </td>
                </tr>
            <?php } ?>
            <?php $this->lab_StayHomeOf('Teacher', $testType); ?>
            <?php $this->lab_StayHomeOf('Staff', $testType); ?>
            </tbody>
        </table>
        <script>
            $('.Lab_Table').DataTable();
        </script>
        <?php
    }

    public function Get_home_List_company()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $testType = $this->input->post('TestDesc');
        ?>
        <table class="table table-borderless table-centered table-nowrap Lab_Table">
            <thead>
            <th> الصورة</th>
            <th> الاسم</th>
            <th> التاريخ &amp; الوقت</th>
            <th> النتيجة</th>
            <th> عدد الأيام</th>
            <th> الإجراءات</th>
            </thead>
            <tbody>
            <?php $this->lab_StayHomeOf_company_users('Home', $testType); ?>
            </tbody>
        </table>
        <script>
            $('.Lab_Table').DataTable();
        </script>
        <?php
    }

    public function Get_home_List_Ministry()
    {
        ?>
        <table class="table Lab_Table" style="width: 100%;">
            <thead>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>إيجابي</th>
            <th>سلبي</th>
            <th>المجموع</th>
            </thead>
            <tbody>
            <?php
            $List = array();
            //echo is_numeric($counter);
            $testDesc = $this->input->post("TestName");
            $sessiondata = $this->session->userdata('admin_details');
            $testType = $this->input->post('TestDesc');
            $our_schools = $this->db->query("SELECT 
     `School_Name_AR`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
            //print_r($our_schools);
            foreach ($our_schools as $school) {
                $counter = 0;
                $counter_Positive = 0;
                $counter_Nigative = 0;
                //echo "---".$school['Id']."<br>";
                $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Student", $testDesc);
                $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Teacher", $testDesc);
                $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Staff", $testDesc);
                $counter += $this->Get_CounterForThisType_Ministry($school['Id'], "Site", $testDesc);
                // Positive
                $counter_Positive += $this->Get_CounterForThisType_Ministry($school['Id'], "Student", $testDesc, '1');
                $counter_Positive += $this->Get_CounterForThisType_Ministry($school['Id'], "Teacher", $testDesc, '1');
                $counter_Positive += $this->Get_CounterForThisType_Ministry($school['Id'], "Staff", $testDesc, '1');
                $counter_Positive += $this->Get_CounterForThisType_Ministry($school['Id'], "Site", $testDesc, '1');
                // Nigative
                $counter_Nigative += $this->Get_CounterForThisType_Ministry($school['Id'], "Student", $testDesc, '0');
                $counter_Nigative += $this->Get_CounterForThisType_Ministry($school['Id'], "Teacher", $testDesc, '0');
                $counter_Nigative += $this->Get_CounterForThisType_Ministry($school['Id'], "Staff", $testDesc, '0');
                $counter_Nigative += $this->Get_CounterForThisType_Ministry($school['Id'], "Site", $testDesc, '0');
                ?>
                <tr>
                    <td style="width: 20px;">
                        <?php $avatr_school = $this->db->query("SELECT `Link` FROM `l2_avatars` WHERE 
          `Type_Of_User` = 'school' AND `For_User` = '" . $school['Id'] . "' ORDER BY `Id` DESC LIMIT 1 ")->result_array(); ?>
                        <?php if (!empty($avatr_school)) {
                            $link = $avatr_school[0]['Link'];
                        } else {
                            $link = "default_avatar.jpg";
                        }
                        ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $link; ?>" class="avatar-xs rounded-circle "
                             alt="<?= $school['School_Name_AR'] ?>">
                    </td>
                    <td>
                        <h6 class="font-size-15 mb-1 font-weight-normal"><?= $school['School_Name_AR']; ?></h6>
                    </td>
                    <td>
                            <span class="badge font-size-12"
                                  style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">
                                <?= $counter_Positive; ?>
                            </span>
                    </td>
                    <td>
                            <span class="badge font-size-12"
                                  style="width: 100%;background-color: #00ab00;color: #F4F4F4;">
                                <?= $counter_Nigative; ?>
                            </span>
                    </td>
                    <td style="text-align: right;">
                        <span class="badge badge-info font-size-12" style="width: 100%;"><?= $counter; ?></span>
                    </td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
        <script>
            $('.Lab_Table').DataTable();
        </script>
        <?php
    }

    private function Get_CounterForThisType_Ministry($id, $type, $testDesc, $result = "")
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
        if ($result !== "") {
            foreach ($query_users as $user) {
                $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
                `UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' 
                AND `Test_Description` = '" . $testDesc . "' LIMIT 1 ")->num_rows();
                $counter += $Results;
            }
        } else {
            foreach ($query_users as $user) {
                $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
                `UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' 
                AND `Test_Description` = '" . $testDesc . "' AND `Result` = '" . $result . "' LIMIT 1  ")->num_rows();
                $counter += $Results;
            }
        }
        return ($counter);
    }

    private function lab_StayHomeOf($type, $testType)
    {
        $count = 0;
        $sessiondata = $this->session->userdata('admin_details');
        if ($type == "Teacher") {
            $ours = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        } else {
            $ours = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        }
        $listTeachers = array();
        $today = date("Y-m-d");
        foreach ($ours as $Teacher) {
            $Teachername = $Teacher['F_name_AR'] . ' ' . $Teacher['L_name_AR'];
            $ID = $Teacher['Id'];
            $Position = $Teacher['Position'];
            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
			AND UserType = '" . $type . "'  AND `Action` = 'Home' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
				AND UserType = '" . $type . "' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . ' ' . $lastReads[0]['Time'];
                $listTeachers[] = array(
                    "Username" => $Teachername, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                    "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                    "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                );
            }
        } ?>
        <style>
            .badge {
                text-align: center;
            }
        </style>
        <?php
        $count += sizeof($listTeachers);
        foreach ($listTeachers as $TeacherRes) { ?>
            <?php //print_r($TeacherRes); 
            ?>
            <tr>
                <td style="width: 20px;">
                    <?php
                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                    WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                    ?>
                    <?php if (empty($avatar)) { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } ?>
                </td>
                <td>
                    <h6 class="mb-1 font-weight-normal" style="font-size: 13px;"><?= $TeacherRes['Username']; ?></h6>
                    <p class="text-muted font-size-13 mb-0"><i
                                class="mdi mdi-user"></i><?= $TeacherRes['Class_OfSt']; ?></p>
                </td>
                <td style="font-size: 12px;">
                    <?= $TeacherRes['Creat']; ?>
                </td>
                <?php $this->Boxes_Colors($TeacherRes['LastRead']); ?>
                <td>
                    <?php
                    $from_craet = $TeacherRes['Creat'];
                    //echo $from_craet;
                    //$toTime = $today-$from_craet;
                    $date_exp = explode(" ", $from_craet)[0];
                    $finalDate = $this->dateDiffInDays($date_exp, $today);
                    if ($finalDate == 0) {
                        echo "اليوم";
                    } elseif ($finalDate > 2) {
                        echo $finalDate . "أيام";
                    } else {
                        echo $finalDate . "أيام";
                    }
                    ?>
                </td>
                <td class="out">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" width="14px"
                         onClick="RemoveThisMemberFrom_lab(<?= $TeacherRes['Id']; ?>,'<?= $type ?>','School');">
                </td>
            </tr>
            <script>
                var count_Quarnt_f = <?= $count; ?>;
                $("#Quirnrtin_Counter").html(count_Quarnt_f + Quarnt_Count_S);
            </script>
            <?php
        }
    }

    private function lab_StayHomeOf_company_users($action, $testType)
    {
        $count = 0;
        $sessiondata = $this->session->userdata('admin_details');
        $ours = $this->db->query("SELECT * FROM l2_co_patient WHERE 
        `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Action` = '" . $action . "' ")->result_array();
        $listTeachers = array();
        $today = date("Y-m-d");
        foreach ($ours as $Teacher) {
            $Teachername = $Teacher['F_name_AR'] . ' ' . $Teacher['L_name_AR'];
            $ID = $Teacher['Id'];
            $Position = $Teacher['Position'];
            $type = $Teacher['UserType'];
            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $this->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . ' ' . $lastReads[0]['Time'];
                $listTeachers[] = array(
                    "Username" => $Teachername, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "U_Type" => $type
                );
            }
        } ?>
        <style>
            .badge {
                text-align: center;
            }
        </style>
        <?php
        $count += sizeof($listTeachers);
        foreach ($listTeachers as $TeacherRes) { ?>
            <?php //print_r($TeacherRes); 
            ?>
            <tr>
                <td style="width: 20px;">
                    <?php
                    $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
              WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $TeacherRes['U_Type'] . "' LIMIT 1 ")->result_array();
                    ?>
                    <?php if (empty($avatar)) { ?>
                        <img src="<?= base_url(); ?>uploads/co_avatars/default_avatar.jpg"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } ?>
                </td>
                <td>
                    <h6 class="mb-1 font-weight-normal" style="font-size: 13px;"><?= $TeacherRes['Username']; ?></h6>
                    <p class="text-muted font-size-13 mb-0"><i
                                class="mdi mdi-user"></i><?= $TeacherRes['Class_OfSt']; ?></p>
                </td>
                <td style="font-size: 12px;">
                    <?= $TeacherRes['LastReadDate']; ?>
                </td>
                <?php $this->Boxes_Colors($TeacherRes['LastRead']); ?>
                <td>
                    <?php
                    $from_craet = $TeacherRes['Creat'];
                    //echo $from_craet;
                    //$toTime = $today-$from_craet;
                    $finalDate = $this->dateDiffInDays($from_craet, $today);
                    if ($finalDate == 0) {
                        echo "اليوم";
                    } elseif ($finalDate > 2) {
                        echo $finalDate . "أيام";
                    } else {
                        echo $finalDate . "أيام";
                    }
                    ?>
                </td>
                <td class="out">
                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" width="14px"
                         onClick="RemoveThisMemberFrom_lab(<?= $TeacherRes['Id']; ?>,'<?= $TeacherRes['U_Type'] ?>','School');">
                </td>
            </tr>
            <?php
        }
    }

    public function Set_ActiononSite()
    {
        if ($this->input->post('S_Id')) {
            $id = $this->input->post('S_Id');
            $action = "Cleaning";
            $this->db->query("UPDATE `l2_labtests` SET `Action` = '" . $action . "' WHERE `UserType` = 'Site' AND `UserId` = '" . $id . "' ");
            echo " تم إيقاف الموقع مؤقتًا للتعقيم ";
            ?>
            <script>
                Swal.fire({
                    title: ' الرجاء تحديث الصفحة ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `ok`,
                    cancelButtonText: `No`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
            <?php
        }
    }

    public function Set_ActiononSite_comp()
    {
        if ($this->input->post('S_Id')) {
            $id = $this->input->post('S_Id');
            $action = "Cleaning";
            $this->db->query("UPDATE `l2_co_labtests` SET `Action` = '" . $action . "' WHERE `UserType` = 'Site' AND `UserId` = '" . $id . "' ");
            echo " تم إيقاف الموقع مؤقتًا للتعقيم ";
            ?>
            <script>
                Swal.fire({
                    title: ' الرجاء تحديث الصفحة ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `ok`,
                    cancelButtonText: `No`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
            <?php
        }
    }

    public function Remove_ActiononSite()
    {
        if ($this->input->post('S_Id')) {
            $id = $this->input->post('S_Id');
            $action = "School";
            $this->db->query("UPDATE `l2_labtests` SET `Action` = '" . $action . "' WHERE `UserType` = 'Site' AND `UserId` = '" . $id . "' ");
            ?>
            <script>
                Swal.fire({
                    title: ' الرجاء تحديث الصفحة ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `ok`,
                    cancelButtonText: `No`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
            <?php
        }
    }

    public function Remove_ActiononSite_comp()
    {
        if ($this->input->post('S_Id')) {
            $id = $this->input->post('S_Id');
            $action = "work";
            $this->db->query("UPDATE `l2_co_labtests` SET `Action` = '" . $action . "' WHERE `UserType` = 'Site' AND `UserId` = '" . $id . "' ");
            ?>
            <script>
                Swal.fire({
                    title: ' الرجاء تحديث الصفحة ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `ok`,
                    cancelButtonText: `No`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
            <?php
        }
    }

    private function Boxes_Colors($result)
    { ?>
        <?php if ($result == '1') { ?>
        <td>
                <span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #FFFFFF;">
                    <?= "(+) إيجابي"; ?>
                </span>
        </td>
    <?php } else { ?>
        <td>
                <span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">
                    <?= "(-) سلبي  "; ?>
                </span>
        </td>
    <?php }
    }

    public function sites_data_table()
    {
        ?>
        <?php
        $List = array();
        $testname = $this->input->post('TestName');
        //echo is_numeric($counter);    
        $sessiondata = $this->session->userdata('admin_details');
        $our_schools = $this->db->query("SELECT 
     `School_Name_AR`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
        //print_r($our_schools); 
        $serial_num = 0;
        foreach ($our_schools as $school) {
            $serial_num++;
            $counter = 0;
            $counter_Positive = 0;
            $counter_Nigative = 0;
            //echo "---".$school['Id']."<br>";
            $counter += $this->counter_of_sites_results($school['Id'], $testname, "", "Cleaning");
            // Positive 
            $counter_Positive += $this->counter_of_sites_results($school['Id'], $testname, "1");
            // Nigative 
            $counter_Nigative += $this->counter_of_sites_results($school['Id'], $testname, "0");
            ?>
            <tr>
                <td>
                    <?= $serial_num; ?>
                </td>
                <td>
                    <h6 class="font-size-15 mb-1 font-weight-normal"><?= $school['School_Name_AR']; ?></h6>
                </td>
                <td>
                    <span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">
                        <?= $counter_Positive; ?>
                    </span>
                </td>
                <td>
                    <span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #F4F4F4;">
                        <?= $counter_Nigative; ?>
                    </span>
                </td>
                <td style="text-align: right;">
                    <span class="badge badge-info font-size-12" style="width: 100%;"><?= $counter; ?></span>
                </td>
            </tr>
            <?php
        } ?>
    <?php }

    private function counter_of_sites_results($id, $testName, $result = "", $action = "")
    {
        $counter = 0;
        $today = date("Y-m-d");
        $query_users = $this->db->query(" SELECT * FROM `l2_site` WHERE `Added_By` = '" . $id . "'  ")->result_array();
        if ($result == "" && $action == "") {
            foreach ($query_users as $user) {
                $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
            `UserType` = 'Site' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "'
			 AND `Test_Description` = '" . $testName . "'  ")->num_rows();
                $counter += $Results;
            }
        } elseif ($result !== "" && $action == "") {
            foreach ($query_users as $user) {
                $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
            `UserType` = 'Site' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "'
             AND `Result` = '" . $result . "'  AND `Test_Description` = '" . $testName . "' ")->num_rows();
                $counter += $Results;
            }
        } elseif ($action !== "" && $result == "") {
            foreach ($query_users as $user) {
                $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
            `UserType` = 'Site' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "'
             AND `Test_Description` = '" . $testName . "' AND `Action` = '" . $action . "' LIMIT 1 ")->num_rows();
                $counter += $Results;
            }
        }
        return ($counter);
    }

    public function csvTest()
    {
        $filename = './uploads/Csv/staff.csv';
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
        foreach ($the_big_array as $arr) {
            print_r($arr);
        }
    }

    public function getThisCountrycities()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $cites = $this->db->query("SELECT * FROM `r_cities` WHERE `Country_Id` = '" . $id . "' ORDER BY `Name_EN` ASC ")->result_array();
            if (!empty($cites)) {
                ?>
                <div class="form-group mb-4">
                    <label class="control-label"
                           style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;width: 100%;">
                        تحديد المدينة</label>
                    <select name="city" class="form-control">
                        <?php
                        foreach ($cites as $city) {
                            ?>
                            <option value="<?= $city['Id'] ?>" <?= $this->uri->segment(4) ? ($city['Id'] == $this->uri->segment(4) ? "selected" : "") : "" ?>><?= $city['Name_EN'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <?php
            } else {
                echo "عذرا ، لا توجد أي مدن في الوقت الحالي";
            }
        }
    }

    public function UploadSiteReport()
    {
        $name = date("Y-M-D") . "_" . time();
        $config['upload_path'] = './uploads/sites_reports/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '2000';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if ($this->input->post('site_result_id') && is_numeric($this->input->post('site_result_id'))) {
            $test_id = $this->input->post('site_result_id');
            if (!$this->upload->do_upload('csvFileStaff')) {
                $errors = array('error' => $this->upload->display_errors());
                foreach ($errors as $error) {
                    echo $error;
                }
            } else {
                $this->db->set('Report_link', $name . ".pdf");
                $this->db->where('Id', $test_id);
                if (isset($_GET['type'])) {
                    $this->db->update('l2_co_labtests');
                } else {
                    $this->db->update('l2_labtests');
                }
                ?>
                <style>
                    .dummy-positioning {
                        width: 100%;
                        align-items: center;
                        justify-content: center;
                    }

                    .success-icon {
                        display: inline-block;
                        width: 8em;
                        height: 8em;
                        font-size: 20px;
                        border-radius: 50%;
                        border: 4px solid #96df8f;
                        background-color: #fff;
                        position: relative;
                        overflow: hidden;
                        transform-origin: center;
                        animation: showSuccess 180ms ease-in-out;
                        transform: scale(1);
                    }

                    .success-icon__tip,
                    .success-icon__long {
                        display: block;
                        position: absolute;
                        height: 4px;
                        background-color: #96df8f;
                        border-radius: 10px;
                    }

                    .success-icon__tip {
                        width: 2.4em;
                        top: 4.3em;
                        left: 1.4em;
                        transform: rotate(45deg);
                        animation: tipInPlace 300ms ease-in-out;
                        animation-fill-mode: forwards;
                        animation-delay: 180ms;
                        visibility: hidden;
                    }

                    .success-icon__long {
                        width: 4em;
                        transform: rotate(-45deg);
                        top: 3.7em;
                        left: 2.75em;
                        animation: longInPlace 140ms ease-in-out;
                        animation-fill-mode: forwards;
                        visibility: hidden;
                        animation-delay: 440ms;
                    }

                    @keyframes showSuccess {
                        from {
                            transform: scale(0);
                        }

                        to {
                            transform: scale(1);
                        }
                    }

                    @keyframes tipInPlace {
                        from {
                            width: 0em;
                            top: 0em;
                            left: -1.6em;
                        }

                        to {
                            width: 2.4em;
                            top: 4.3em;
                            left: 1.4em;
                            visibility: visible;
                        }
                    }

                    @keyframes longInPlace {
                        from {
                            width: 0em;
                            top: 5.1em;
                            left: 3.2em;
                        }

                        to {
                            width: 4em;
                            top: 3.7em;
                            left: 2.75em;
                            visibility: visible;
                        }
                    }
                </style>
                <div class="dummy-positioning d-flex">
                    <div class="success-icon">
                        <div class="success-icon__tip"></div>
                        <div class="success-icon__long"></div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "آسف لدينا مشكلة";
        }
    }

    public function uploadStaffCsv()
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
            echo $this->addcsvStaff($name);
            ?>
            <script>
                $('#Staff').html('');
            </script>
            <?php
        }
    }

    private function addcsvStaff($name)
    {
        $filename = './uploads/Csv/' . $name . '.txt';
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
        if ($s_ar == 13) {
            unset($the_big_array[0]);
            foreach ($the_big_array as $array) {
                //print_r($array);
                $counter++;
                echo $array[4];
                ?>
                <script>
                    $('#exportinSatff').html('<?= " إنتظر من فضلك جاري تصدير  :" . $array[1] . "   - " . $all; ?>');
                    $('.Staffprogress').attr('style', 'width: <?= $this->get_percentage($all, $counter); ?>%');
                </script>
                <?php if ($all == $counter) { ?>
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'تم إدخال البيانات بنجاح',
                            icon: 'success'
                        });
                        setTimeout(function () {
                            $('.Staffprogress').addClass('bg-success');
                            SetTheTable();
                        }, 900);
                    </script>
                    <?php
                    if (unlink('./uploads/Csv/' . $name . '.txt')) {
                        //// later 
                    }
                }
                ?>
                <?php
                $ad_id = $sessiondata['admin_id'];
                $password = "NEWSTAFF";
                $genration = $this->generatecode($sessiondata['admin_id'], $array[9]);
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                // start add the 
                $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $array[9] . "'")->num_rows();
                if ($iscrrent == 0) {
                    if (strtolower($array[8]) == "M") {
                        $gender = 0;
                        $pref = "Mr.";
                    } else {
                        $gender = 1;
                        $pref = "Ms.";
                    }
                    $dop = date("d-m-Y", strtotime($array[6]));
                    $data = [
                        'Added_By' => $sessiondata['admin_id'],
                        'Prefix' => $pref,
                        'F_name_EN' => $array[0],
                        'F_name_AR' => $array[3],
                        'M_name_EN' => $array[1],
                        'M_name_AR' => $array[4],
                        'L_name_AR' => $array[5],
                        'L_name_EN' => $array[2],
                        'DOP' => $dop,
                        'Phone' => $array[7],
                        'Gender' => $gender,
                        'National_id' => $array[9],
                        'UserName' => $array[9],
                        'Nationality' => $array[10],
                        'Position' => $array[11],
                        'Email' => $array[12],
                        'Password' => $hash_pass,
                        'generation' => $genration,
                    ];
                    if ($this->db->insert('l2_staff', $data)) {
                        $national = [
                            'National_Id' => $array[9],
                            'Geted_From' => 'Staff',
                            'generation' => $genration,
                        ];
                        // $this->db->insert('v_nationalids', $national);
                        $login = [
                            'Username' => $array[9],
                            'Password' => $hash_pass,
                            'Type' => 'Staff',
                            'generation' => $genration,
                        ];
                        // $this->db->insert('v_login', $login);
                        $users[] = array("Username" => $array[9], "Password" => $password);
                    }
                }
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: " آسف لدينا مشكلة ",
                    text: 'هذا ليس ملف CSV للموظفين',
                    icon: 'warning',
                    confirmButtonColor: '#007E15'
                });
            </script>
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
				<th>الاسم</th>
				<th>كلمة المرور</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user) { ?>
			<tr>
				<td><?= $user['Username']; ?></td>
				<td><?= $user['Password'] ?></td>
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

    public function uploadTeacherCsv()
    {
        $name = date("Y-M-D") . "_" . time();
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFileTeacher')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            echo $this->addcsvTeacher($name);
            ?>
            <script>
                $('#Staff').html('');
            </script>
            <?php
        }
    }

    private function addcsvTeacher($name)
    {
        $filename = './uploads/Csv/' . $name . '.txt';
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
        $Position = $the_big_array[0][11];
        if ($s_ar == 14 && $Position == "Position") {
            unset($the_big_array[0]);
            foreach ($the_big_array as $array) {
                //print_r($array);
                $counter++;
                ?>
                <script>
                    $('#exportinTeacher').html('<?= " Please wait, exporting ... " . $array[1] . "   - " . $all; ?>');
                    $('.Teacherprogress').attr('style', 'width: <?= $this->get_percentage($all, $counter); ?>%');
                </script>
                <?php if ($all == $counter) { ?>
                    <script>
                        $('.Teacherprogress').addClass('bg-success');
                        setTimeout(function () {
                            Swal.fire({
                                title: 'Success!',
                                text: 'تم إدخال البيانات بنجاح',
                                icon: 'success'
                            });
                            SetTheTable();
                        }, 900);
                    </script>
                    <?php
                    if (unlink('./uploads/Csv/' . $name . '.txt')) {
                        //// later 
                    }
                }
                ?>
                <?php
                $ad_id = $sessiondata['admin_id'];
                $password = "NEWTEACHER";
                $genration = $this->generatecode($sessiondata['admin_id'], $array[9]);
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                // start add the 
                $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $array[9] . "'")->num_rows();
                if ($iscrrent == 0) {
                    if (strtolower($array[8]) == "M") {
                        $gender = 0;
                        $pref = "Mr.";
                    } else {
                        $gender = 1;
                        $pref = "Ms.";
                    }
                    $classes = $this->ClassName($array[13], "teacher");
                    $data = [
                        'Added_By' => $sessiondata['admin_id'],
                        'Prefix' => $pref,
                        'F_name_EN' => $array[0],
                        'F_name_AR' => $array[3],
                        'M_name_EN' => $array[1],
                        'M_name_AR' => $array[4],
                        'L_name_AR' => $array[5],
                        'L_name_EN' => $array[2],
                        'DOP' => $array[6],
                        'Phone' => $array[7],
                        'Gender' => $gender,
                        'National_Id' => $array[9],
                        'UserName' => $array[9],
                        'Nationality' => $array[10],
                        'Position' => $array[11],
                        'Email' => $array[12],
                        'Classes' => $classes,
                        'Password' => $hash_pass,
                        'generation' => $genration,
                    ];
                    if ($this->db->insert('l2_teacher', $data)) {
                        $national = [
                            'National_Id' => $array[9],
                            'Geted_From' => 'Teacher',
                            'generation' => $genration,
                        ];
                        // $this->db->insert('v_nationalids', $national);
                        $login = [
                            'Username' => $array[9],
                            'Password' => $hash_pass,
                            'Type' => 'Teacher',
                            'generation' => $genration,
                        ];
                        // $this->db->insert('v_login', $login);
                        $users[] = array("Username" => $array[9], "Password" => $password);
                    }
                }
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: " آسف لدينا مشكلة  ",
                    text: 'هذا ليس ملف CSV للمعلمين',
                    icon: 'warning',
                    confirmButtonColor: '#0358CC'
                });
            </script>
            <?php
        }
        ?>
        <script>
            function SetTheTable() {
                $('.Teacherprogress').slideUp();
                swal.close();
                $('.TeacherUpload').html(`
         <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
		<table id="Users_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
			<thead>
			<tr>
				<th>الاسم</th>
				<th>كلمة المرور</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user) { ?>
			<tr>
				<td><?= $user['Username']; ?></td>
				<td><?= $user['Password'] ?></td>
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

    public function uploadStudentCsv()
    {
        $name = date("Y-M-D") . "_" . time();
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFileStudent')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error;
            }
        } else {
            echo $this->addcsvStudent($name);
            ?>
            <script>
                $('#Staff').html('');
            </script>
            <?php
        }
    }

    private function ClassName($name, $arr = "")
    {
        if ($arr == "") {
            switch ($name) {
                case "KG1":
                    $class_res = '0';
                    break;
                case "KG2":
                    $class_res = '1';
                    break;
                default:
                    $class_res = $name + 1;
            }
        } else {
            $class_res = "";
            $classes = $name;
            $explodedClasses = explode(';', $classes);
            foreach ($explodedClasses as $class) {
                settype($class, "string");
                trim($class);
                if ($class !== '') {
                    $EchoClass = '';
                    if ($class == "KG1") {
                        $EchoClass = '0';
                    } else if ($class == "KG2") {
                        $EchoClass = '1';
                    } else {
                        echo $class;
                        settype($class, "integer");
                        $EchoClass = $class + 1;
                    }
                }
                $class_res .= $EchoClass . ";";
            }
        }
        return ($class_res);
    }

    private function addcsvStudent($name)
    {
        $filename = './uploads/Csv/' . $name . '.txt';
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
        if ($s_ar == 14 && $the_big_array[0][11] == "Grade") {
            unset($the_big_array[0]);
            //$grade = $the_big_array[1][11];	
            foreach ($the_big_array as $array) {
                //print_r($array);
                $counter++;
                ?>
                <script>
                    $('#exportinStudent').html('<?= "Please wait, exporting ..." . $array[1] . "   - " . $all; ?>');
                    $('.Studentprogress').attr('style', 'width: <?= $this->get_percentage($all, $counter); ?>%');
                </script>
                <?php if ($all == $counter) { ?>
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'تم إدخال البيانات بنجاح',
                            icon: 'success'
                        });
                        setTimeout(function () {
                            $('.Studentprogress').addClass('bg-success');
                            SetTheTable();
                        }, 900);
                    </script>
                    <?php
                    if (unlink('./uploads/Csv/' . $name . '.txt')) {
                        //// later 
                    }
                }
                ?>
                <?php
                $ad_id = $sessiondata['admin_id'];
                $password = "NEWSTUDENT";
                $genration = $this->generatecode($sessiondata['admin_id'], $array[9]);
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                // start add the 
                $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $array[9] . "'")->num_rows();
                if ($iscrrent == 0) {
                    if (strtolower($array[8]) == "M") {
                        $gender = 0;
                        $pref = "Mr.";
                    } else {
                        $gender = 1;
                        $pref = "Ms.";
                    }
                    $class = $this->ClassName($array[13]);
                    $data = [
                        'Added_By' => $sessiondata['admin_id'],
                        'Prefix' => $pref,
                        'F_name_EN' => $array[0],
                        'F_name_AR' => $array[3],
                        'M_name_EN' => $array[1],
                        'M_name_AR' => $array[4],
                        'L_name_AR' => $array[5],
                        'L_name_EN' => $array[2],
                        'DOP' => $array[6],
                        'Phone' => $array[7],
                        'Gender' => $gender,
                        'National_Id' => $array[9],
                        'UserName' => $array[9],
                        'Nationality' => $array[10],
                        'Grades' => $array[11],
                        'Email' => $array[12],
                        'Class' => $class,
                        'Password' => $hash_pass,
                        'generation' => $genration,
                    ];
                    if ($this->db->insert('l2_student', $data)) {
                        $national = [
                            'National_Id' => $array[9],
                            'Geted_From' => 'Student',
                            'generation' => $genration,
                        ];
                        // $this->db->insert('v_nationalids', $national);
                        $login = [
                            'Username' => $array[9],
                            'Password' => $hash_pass,
                            'Type' => 'Student',
                            'generation' => $genration,
                        ];
                        // $this->db->insert('v_login', $login);
                        $users[] = array("Username" => $array[9], "Password" => $password);
                    }
                }
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: "آسف لدينا مشكلة  ",
                    text: 'هذا ليس ملف CSV للطلاب',
                    icon: 'warning',
                    confirmButtonColor: '#F00004'
                });
            </script>
            <?php
        }
        ?>
        <script>
            function SetTheTable() {
                $('.Studentprogress').slideUp();
                swal.close();
                $('.StudentUpload').html(`
         <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
		<table id="Users_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
			<thead>
			<tr>
				<th>الاسم</th>
				<th>كلمة المرور</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user) { ?>
			<tr>
				<td><?= $user['Username']; ?></td>
				<td><?= $user['Password'] ?></td>
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

    private function generatecode($sessiondata, $n_id)
    {
        $parent = $this->db->query("SELECT Added_By FROM `l1_school` 
WHERE Id = '" . $sessiondata . "' ORDER BY `Id` DESC")->result_array();
        $parentId = str_pad($parent[0]['Added_By'], 4, '0', STR_PAD_LEFT);
        $s_id = str_pad($sessiondata, 4, '0', STR_PAD_LEFT);
        $genrationcode = $parentId . $s_id . $n_id;
        return ($genrationcode);
    }

    public function GetDataSchoolMonthResults()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('User')) {
            $this->form_validation->set_rules('Start', 'start date', 'trim|required');
            $this->form_validation->set_rules('End', 'end date', 'trim|required');
            $this->form_validation->set_rules('User', 'user name', 'trim|required');
            // English     
            if ($this->form_validation->run()) {
                $userarr = explode(',', $this->input->post('User'));
                if (sizeof($userarr) == 3) {
                    $type = $userarr[0];
                    $Id = $userarr[1];
                    $name = $userarr[2];
                    $from = $this->input->post("Start");
                    $To = $this->input->post("End");
                    /*
			  SELECT * FROM `l2_monthly_result` WHERE `UserType` = 'Staff' AND `UserId` = '10' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' AND `Created` >= '2020-12-01' AND `Created` <= '2020-12-24' GROUP BY `Created` ORDER BY Id DESC
			  */
                    /*  WHERE `UserType` = '".$type."' AND `UserId` = '".$Id."' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' */
                    if (empty($_GET)) {
                        $tableName = "l2_monthly_result";
                    } else {
                        $tableName = "l2_co_monthly_result";
                    }
                    $alldata = $this->db->query("SELECT *
			  FROM `" . $tableName . "`
			  WHERE `UserType` = '" . $type . "' AND `UserId` = '" . $Id . "' 
			  AND `Created` >= '" . $from . "' AND `Created` <= '" . $To . "' ORDER BY Id DESC ")->result_array();
                    if (!empty($alldata)) {
                        ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                        <script>
                            var options = {
                                    chart: {
                                        height: 380,
                                        type: "line",
                                    },
                                    colors: ["#5b73e8", "#f1b44c"],
                                    stroke: {
                                        width: [3, 3],
                                        curve: "straight"
                                    },
                                    series: [{
                                        name: "Results",
                                        data: [<?php foreach ($alldata as $datach) {
                                            echo $datach['Result'] . ',';
                                        } ?>]
                                    }],
                                    title: {
                                        text: "نتائج درجات الحرارة: <?= $name; ?> ",
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
                                    colors: ["#f1b44c"],
                                    dataLabels: {
                                        enabled: !0,
                                        formatter: function (e) {
                                            return e + "°"
                                        },
                                        offsetY: -20,
                                        style: {
                                            fontSize: "12px",
                                            colors: ["#FFFFFF"]
                                        }
                                    },
                                    xaxis: {
                                        categories: [<?php foreach ($alldata as $datach) {
                                            echo '"' . $datach['Created'] . '",';
                                        } ?>],
                                        title: {
                                            text: "تاريخ"
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: "درجات الحرارة"
                                        },
                                        min: 5,
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="students_button"></div>
                                    <table id="Students_table"
                                           class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th> #</th>
                                            <th> التاريخ &amp; الوقت</th>
                                            <th> النتيجة</th>
                                            <th> الحالة</th>
                                            <th class="text-center"> ضغط الدم</th>
                                            <th class="text-center"> أكسجين الدم</th>
                                            <th class="text-center"> معدل ضربات القلب</th>
                                            <th class="text-center"> الوزن</th>
                                            <th> الجهاز</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($alldata as $data) { ?>
                                            <tr>
                                                <td><?= $data['Id']; ?></td>
                                                <td><?= $data['Created'] . " " . $data['Time']; ?></td>
                                                <?php $this->boxes_Colors_temp($data['Result']); ?>
                                                <td class="text-center">
                                                    <strong><?= $data['Blood_pressure_min'] . "/" . $data['Blood_pressure_max'] ?></strong>
                                                </td>
                                                <td class="text-center"><strong><?= $data['Blood_oxygen'] ?></strong>
                                                </td>
                                                <td class="text-center"><strong><?= $data['Heart_rate'] ?></strong></td>
                                                <td class="text-center"><strong><?= $data['weight'] ?></strong></td>
                                                <td><?= $data["Device"]; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script>
                            var table_st = $('#Students_table').DataTable({
                                lengthChange: false,
                                buttons: ['copy', 'excel', 'pdf'],
                            });
                            table_st.buttons().container().appendTo('#Students_table_wrapper .col-md-6:eq(0)');
                        </script>
                        <?php
                    } else {
                        ?>
                        <div class="col-md-12">
                            <div class="text-center">
                                <div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4">
                                            <div class="error-img">
                                                <img src="<?= base_url(); ?>assets/images/500-error.png" alt=""
                                                     class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="text-uppercase mt-4"> لا يوجد معلومات </h4>
                                <p class="text-muted">عذرا ، لم نتمكن من العثور على أي معلومات تتعلق بهذا
                                    المستخدم."<?= $name; ?>"</p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'آسف لدينا مشكلة',
                            text: 'آسف لدينا مشكلة',
                            icon: 'error'
                        });
                        location.reload();
                    </script>
                    <?php
                }
            } else {
                $errors_1 = str_replace("<p>", "", validation_errors());
                $errors = str_replace("</p>", '\n', $errors_1);
                ?>
                <script>
                    Swal.fire({
                        title: 'sorry',
                        text: `<?= $errors; ?>`,
                        icon: 'error'
                    });
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'Remind',
                    text: "الرجاء تحديد المستخدم",
                    icon: 'warning'
                });
            </script>
            <?php
        }
    }

    private function boxes_Colors_temp($result)
    {
        ?>
        <style>
            .Td-Results_font span {
                font-size: 20px !important;
                padding: 6px;
            }

            .Td-Results .badge {
                padding: 6px;
            }
        </style>
        <td class="Td-Results_font">
            <?php if ($result >= 38.500 && $result <= 45.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"><?= $result; ?></span>
                <!-- Hight -->
            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"><?= $result; ?></span>
                <!-- Low -->
            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"><?= $result; ?></span>
                <!-- No Risk -->
            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"><?= $result; ?></span>
                <!-- Moderate -->
            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"><?= $result; ?></span>
                <!-- Error -->
            <?php } ?>
        </td>
        <td class="Td-Results">
            <?php if ($result >= 38.500 && $result <= 45.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">عالي</span>
            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">معتدل</span>
            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">طبيعي</span>
            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;">منخفض</span>
            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">قراءة خاطئة</span>
            <?php } ?>
        </td>
        <?php
    }

    public function sync()
    {
        $this->load->model('Test_db2');
        $error = 0;
        $all = 0;
        $success = 0;
        $allavatars_staff = $this->db->query(" SELECT Id,National_Id FROM l2_staff ")->result_array();
        $allavatars_teacher = $this->db->query(" SELECT Id,National_Id FROM l2_teacher ")->result_array();
        $allavatars_student = $this->db->query(" SELECT Id,National_Id FROM l2_student ")->result_array();
        $all += sizeof($allavatars_staff);
        $all += sizeof($allavatars_teacher);
        $all += sizeof($allavatars_student);
        foreach ($allavatars_staff as $avatar_staff) {
            $type = 'Staff';
            if ($this->Test_db2->sync_avatars($avatar_staff['National_Id'], $type, $avatar_staff['Id']) == "Error") {
                $error++;
            } else {
                $success++;
            }
        }
        foreach ($allavatars_teacher as $avatar_teacher) {
            $type = 'Teacher';
            if ($this->Test_db2->sync_avatars($avatar_teacher['National_Id'], $type, $avatar_teacher['Id']) == "Error") {
                $error++;
            } else {
                $success++;
            }
        }
        foreach ($allavatars_student as $avatar_student) {
            $type = 'Student';
            if ($this->Test_db2->sync_avatars($avatar_student['National_Id'], $type, $avatar_student['Id']) == "Error") {
                $error++;
            } else {
                $success++;
            }
        }
        echo "Operation finished, $success has been moved out of $all";
    }

    public function Attendence_in_of()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('User')) {
            $this->form_validation->set_rules('Start', 'start date', 'trim|required');
            $this->form_validation->set_rules('End', 'end date', 'trim|required');
            $this->form_validation->set_rules('User', 'user name', 'trim|required');
            // English     
            if ($this->form_validation->run()) {
                $userarr = explode(',', $this->input->post('User'));
                if (sizeof($userarr) == 3) {
                    $type = $userarr[0];
                    $Id = $userarr[1];
                    $name = $userarr[2];
                    $from = $this->input->post("Start");
                    $To = $this->input->post("End");
                    if ($type == "Staff" || $type == "Teacher" || $type == "Student") {
                        $alldata = $this->db->query("SELECT * FROM `l2_attendance_result`
				        WHERE `UserType` = '" . $type . "' AND `UserId` = '" . $Id . "'
                        AND `Created` >= '" . $from . "' AND `Created` <= '" . $To . "'
                        AND (`Added_By` = 'SmartPass' OR `Added_By` = 'Smart GateWay') AND  `Device_last` != 'MAC ADDRESS' AND `Device_first` != 'MAC ADDRESS' 
                        ORDER BY Id DESC ")->result_array();
                    } else {
                        // $alldata = $this->db->query("SELECT * FROM `l2_co_attendance_result` 
                        // ORDER BY Id DESC ")->result_array();
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">لدينا خطأ ، يرجى تحديث الصفحة والمحاولة مرة أخرى</h3>
                            </div>
                        </div>
                        <?php
                        exit();
                    } ?>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <table id="data_results" class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th> التاريخ</th>
                                        <th> وقت الدخول</th>
                                        <th> جهاز الدخول</th>
                                        <th> نتيجة الدخول</th>
                                        <th> وقت الخروج</th>
                                        <th> جهاز الخروج</th>
                                        <th> نتيجة الخروج</th>
                                        <th> المجموع</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($alldata as $data) { ?>
                                        <tr>
                                            <td><?= $data['Created'] ?></td>
                                            <td><?= $data['Time_first'] ?></td>
                                            <td><?= $data['Device_first'] ?></td>
                                            <td><?= $data['Result_first'] ?></td>
                                            <td><?= $data['Time_last'] ?></td>
                                            <td><?= $data['Device_last'] ?></td>
                                            <td><?= $data['Result_last'] ?></td>
                                            <?php
                                            $from = new DateTime($data['Created'] . ' ' . $data['Time_first']);
                                            $to = new DateTime($data['Date_out'] . ' ' . $data['Time_last']);
                                            if ($from > $to) {
                                                $finished_at_s = "-- days --:--:--";
                                            } else {
                                                $timediff = date_diff($from, $to);
                                                $finished_at_s = $timediff->d . ' أيام ' . $timediff->h . ':' . $timediff->i . ':' . $timediff->s;
                                            }
                                            ?>
                                            <td><?= $finished_at_s; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <script>
                        var table_st = $('#data_results').DataTable({
                            lengthChange: false,
                            buttons: ['copy', 'excel', 'pdf', 'colvis'],
                        });
                        table_st.buttons().container().appendTo('#data_results_wrapper .col-md-6:eq(0)');
                    </script>
                <?php } else { ?>
                    <script>
                        Swal.fire({
                            title: 'Problem',
                            text: 'We apologize, we have a problem',
                            icon: 'error'
                        });
                        location.reload();
                    </script>
                    <?php
                }
            } else {
                $errors_1 = str_replace("<p>", "", validation_errors());
                $errors = str_replace("</p>", '\n', $errors_1);
                ?>
                <script>
                    Swal.fire({
                        title: 'آسف لدينا مشكلة',
                        text: ` <?= $errors; ?>`,
                        icon: 'error'
                    });
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'warning',
                    text: "الرجاء تحديد المستخدم",
                    icon: 'warning'
                });
            </script>
            <?php
        }
    }

    public function Attendence_in_of_all()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Start', 'تاريخ البداية', 'trim|required');
        $this->form_validation->set_rules('End', 'تاريخ الإنتهاء', 'trim|required');
        // English 
        if ($this->form_validation->run()) {
            $from = $this->input->post("Start");
            $To = $this->input->post("End");
            $all_data = array();
            $all_data_staff = $this->db->query(" SELECT l2_staff.Id, l2_staff.F_name_AR, l2_staff.L_name_AR , 
            l2_attendance_result.Result_first ,l2_attendance_result.Result_last , 
            l2_attendance_result.Time_first , l2_attendance_result.Time_last , l2_attendance_result.Device_first , 
            l2_attendance_result.Device_last ,l2_attendance_result.Created 
            FROM l2_staff
            INNER JOIN l2_attendance_result
            ON l2_staff.Id=l2_attendance_result.UserId AND l2_attendance_result.UserType = 'Staff'
            AND l2_staff.Added_By = '" . $sessiondata['admin_id'] . "' AND l2_attendance_result.Created >= '" . $from . "'
            AND l2_attendance_result.Created <= '" . $To . "' ")->result_array();
            $all_data_teacher = $this->db->query("SELECT l2_teacher.Id, l2_teacher.F_name_AR, l2_teacher.L_name_AR , 
            l2_attendance_result.Result_first ,l2_attendance_result.Result_last , 
            l2_attendance_result.Time_first , l2_attendance_result.Time_last , l2_attendance_result.Device_first , 
            l2_attendance_result.Device_last ,l2_attendance_result.Created 
            FROM l2_teacher
            INNER JOIN l2_attendance_result
            ON l2_teacher.Id=l2_attendance_result.UserId AND l2_attendance_result.UserType = 'Teacher'
            AND l2_teacher.Added_By = '" . $sessiondata['admin_id'] . "' AND l2_attendance_result.Created >= '" . $from . "'
            AND l2_attendance_result.Created <= '" . $To . "' ")->result_array();
            $all_data_student = $this->db->query("SELECT l2_student.Id, l2_student.F_name_AR, l2_student.L_name_AR , 
            l2_attendance_result.Result_first ,l2_attendance_result.Result_last , 
            l2_attendance_result.Time_first , l2_attendance_result.Time_last , l2_attendance_result.Device_first , 
            l2_attendance_result.Device_last ,l2_attendance_result.Created 
            FROM l2_student
            INNER JOIN l2_attendance_result
            ON l2_student.Id=l2_attendance_result.UserId AND l2_attendance_result.UserType = 'Student'
            AND l2_student.Added_By = '" . $sessiondata['admin_id'] . "' AND l2_attendance_result.Created >= '" . $from . "'
            AND l2_attendance_result.Created <= '" . $To . "' ")->result_array();
            $s_num_s = 0;
            $s_num_t = 0;
            $s_num_st = 0;
            if (!empty($all_data_staff) || !empty($all_data_teacher) || !empty($all_data_student)) {
                ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified bg-light" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#navpills2-home" role="tab"
                                       aria-selected="false">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block"> الموظفين </span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#navpills2-profile" role="tab"
                                       aria-selected="true">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">المعلمين</span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#navpills2-messages" role="tab"
                                       aria-selected="false">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">الطلاب</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="navpills2-home" role="tabpanel">
                                    <table id="staff_table"
                                           class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> الاسم</th>
                                            <th> التاريخ</th>
                                            <th> وقت الدخول</th>
                                            <th> جهاز الدخول</th>
                                            <th> نتيجة الدخول</th>
                                            <th> وقت الخروج</th>
                                            <th> جهاز الخروج</th>
                                            <th> نتيجة الخروج</th>
                                            <th> المجموع</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($all_data_staff as $data) {
                                            $s_num_s++;
                                            ?>
                                            <tr>
                                                <td><?= $s_num_s; ?></td>
                                                <td><?= $data['F_name_AR'] . ' ' . $data['L_name_AR']; ?></td>
                                                <td><?= $data['Created'] ?></td>
                                                <td><?= $data['Time_first'] ?></td>
                                                <td><?= $data['Device_first'] ?></td>
                                                <td><?= $data['Result_first'] ?></td>
                                                <td><?= $data['Time_last'] ?></td>
                                                <td><?= $data['Device_last'] ?></td>
                                                <td><?= $data['Result_last'] ?></td>
                                                <?php
                                                $in = $data['Time_first'];
                                                $out = $data['Time_last'];
                                                $in_time_exp = explode(':', $in);
                                                $out_time_exp = explode(':', $out);
                                                // hours
                                                $in_hour = $in_time_exp[0];
                                                $out_hour = $out_time_exp[0];
                                                // minuts
                                                $in_minuts = $in_time_exp[1];
                                                $out_minuts = $out_time_exp[1];
                                                $beetween_hours = $out_hour - $in_hour;
                                                $beetween_minuts = $in_minuts - $out_minuts;
                                                $btm = str_pad($beetween_minuts, 2, '0', STR_PAD_LEFT);
                                                if ($in == "00:00:00" || $out == "00:00:00") {
                                                    ?>
                                                    <td>--</td>
                                                <?php } else { ?>
                                                    <td><?= $beetween_hours . ":" . abs($btm); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane " id="navpills2-profile" role="tabpanel">
                                    <table id="teacher_table"
                                           class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> الاسم</th>
                                            <th> التاريخ</th>
                                            <th> وقت الدخول</th>
                                            <th> جهاز الدخول</th>
                                            <th> نتيجة الدخول</th>
                                            <th> وقت الخروج</th>
                                            <th> جهاز الخروج</th>
                                            <th> نتيجة الخروج</th>
                                            <th> المجموع</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($all_data_teacher as $data) {
                                            $s_num_t++;
                                            ?>
                                            <tr>
                                                <td><?= $s_num_t; ?></td>
                                                <td><?= $data['F_name_AR'] . ' ' . $data['L_name_AR']; ?></td>
                                                <td><?= $data['Created'] ?></td>
                                                <td><?= $data['Time_first'] ?></td>
                                                <td><?= $data['Device_first'] ?></td>
                                                <td><?= $data['Result_first'] ?></td>
                                                <td><?= $data['Time_last'] ?></td>
                                                <td><?= $data['Device_last'] ?></td>
                                                <td><?= $data['Result_last'] ?></td>
                                                <?php
                                                $in = $data['Time_first'];
                                                $out = $data['Time_last'];
                                                $in_time_exp = explode(':', $in);
                                                $out_time_exp = explode(':', $out);
                                                // hours
                                                $in_hour = $in_time_exp[0];
                                                $out_hour = $out_time_exp[0];
                                                // minuts
                                                $in_minuts = $in_time_exp[1];
                                                $out_minuts = $out_time_exp[1];
                                                $beetween_hours = $out_hour - $in_hour;
                                                $beetween_minuts = $in_minuts - $out_minuts;
                                                $btm = str_pad($beetween_minuts, 2, '0', STR_PAD_LEFT);
                                                if ($in == "00:00:00" || $out == "00:00:00") {
                                                    ?>
                                                    <td>--</td>
                                                <?php } else { ?>
                                                    <td><?= $beetween_hours . ":" . abs($btm); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="navpills2-messages" role="tabpanel">
                                    <table id="Students_table"
                                           class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> الاسم</th>
                                            <th> التاريخ</th>
                                            <th> وقت الدخول</th>
                                            <th> جهاز الدخول</th>
                                            <th> نتيجة الدخول</th>
                                            <th> وقت الخروج</th>
                                            <th> جهاز الخروج</th>
                                            <th> نتيجة الخروج</th>
                                            <th> المجموع</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($all_data_student as $data) {
                                            $s_num_st++;
                                            ?>
                                            <tr>
                                                <td><?= $s_num_st; ?></td>
                                                <td><?= $data['F_name_AR'] . ' ' . $data['L_name_AR']; ?></td>
                                                <td><?= $data['Created'] ?></td>
                                                <td><?= $data['Time_first'] ?></td>
                                                <td><?= $data['Device_first'] ?></td>
                                                <td><?= $data['Result_first'] ?></td>
                                                <td><?= $data['Time_last'] ?></td>
                                                <td><?= $data['Device_last'] ?></td>
                                                <td><?= $data['Result_last'] ?></td>
                                                <?php
                                                $in = $data['Time_first'];
                                                $out = $data['Time_last'];
                                                $in_time_exp = explode(':', $in);
                                                $out_time_exp = explode(':', $out);
                                                // hours
                                                $in_hour = $in_time_exp[0];
                                                $out_hour = $out_time_exp[0];
                                                // minuts
                                                $in_minuts = $in_time_exp[1];
                                                $out_minuts = $out_time_exp[1];
                                                $beetween_hours = $out_hour - $in_hour;
                                                $beetween_minuts = $in_minuts - $out_minuts;
                                                $btm = str_pad($beetween_minuts, 2, '0', STR_PAD_LEFT);
                                                if ($in == "00:00:00" || $out == "00:00:00") {
                                                    ?>
                                                    <td>--</td>
                                                <?php } else { ?>
                                                    <td><?= $beetween_hours . ":" . abs($btm); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var table_st = $('#staff_table').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'colvis'],
                    });
                    table_st.buttons().container().appendTo('#staff_table_wrapper .col-md-6:eq(0)');
                    var table_st = $('#teacher_table').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'colvis'],
                    });
                    table_st.buttons().container().appendTo('#teacher_table_wrapper .col-md-6:eq(0)');
                    var table_st = $('#Students_table').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'colvis'],
                    });
                    table_st.buttons().container().appendTo('#Students_table_wrapper .col-md-6:eq(0)');
                </script>
                <?php
            } else {
                ?>
                <div class="col-md-12">
                    <div class="text-center">
                        <div>
                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <div class="error-img">
                                        <img src="<?= base_url(); ?>assets/images/500-error.png" alt=""
                                             class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-uppercase mt-4">لم نعثر على أي معلومات</h4>
                        <p class="text-muted">عذرا ، لم نتمكن من العثور على أي معلومات لهذا المستخدم. الرجاء إدخال
                            المعلومات أو اختيار مستخدم آخر.</p>
                    </div>
                </div>
                <?php
            }
        } else {
            $errors_1 = str_replace("<p>", "", validation_errors());
            $errors = str_replace("</p>", '\n', $errors_1);
            ?>
            <script>
                Swal.fire({
                    title: 'error',
                    text: ` <?= $errors; ?>`,
                    icon: 'error'
                });
            </script>
            <?php
        }
    }

    public function Attendence_in_of_all_co()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Start', 'start date', 'trim|required');
        $this->form_validation->set_rules('End', ' end date ', 'trim|required');
        // English 
        if ($this->form_validation->run()) {
            $from = $this->input->post("Start");
            $To = $this->input->post("End");
            $all_data = array();
            $all_data = $this->db->query(" SELECT l2_co_patient.Id, l2_co_patient.F_name_EN, l2_co_patient.L_name_EN , 
		  l2_co_attendance_result.Result_first ,l2_co_attendance_result.Result_last , 
		  l2_co_attendance_result.Time_first , l2_co_attendance_result.Time_last , l2_co_attendance_result.Device_first , 
		  l2_co_attendance_result.Device_last ,l2_co_attendance_result.Created AS Result_date
		  FROM l2_co_patient
		  INNER JOIN l2_co_attendance_result
		  ON l2_co_patient.Id=l2_co_attendance_result.UserId AND l2_co_attendance_result.UserType = l2_co_patient.UserType
		  AND l2_co_patient.Added_By = '" . $sessiondata['admin_id'] . "' AND l2_co_attendance_result.Created >= '" . $from . "'
		  AND l2_co_attendance_result.Created <= '" . $To . "' ")->result_array();
            $s_num_s = 0;
            if (!empty($all_data)) {
                ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="results_table" class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> الاسم</th>
                                    <th> التاريخ</th>
                                    <th> وقت الدخول</th>
                                    <th> جهاز الدخول</th>
                                    <th> نتيجة الدخول</th>
                                    <th> وقت الخروج</th>
                                    <th> جهاز الخروج</th>
                                    <th> نتيجة الخروج</th>
                                    <th> المجموع</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($all_data as $data) {
                                    $s_num_s++;
                                    ?>
                                    <tr>
                                        <td><?= $s_num_s; ?></td>
                                        <td><?= $data['F_name_AR'] . ' ' . $data['L_name_AR']; ?></td>
                                        <td><?= $data['Result_date'] ?></td>
                                        <td><?= $data['Time_first'] ?></td>
                                        <td><?= $data['Device_first'] ?></td>
                                        <td><?= $data['Result_first'] ?></td>
                                        <td><?= $data['Time_last'] ?></td>
                                        <td><?= $data['Device_last'] ?></td>
                                        <td><?= $data['Result_last'] ?></td>
                                        <?php
                                        $in = $data['Time_first'];
                                        $out = $data['Time_last'];
                                        $in_time_exp = explode(':', $in);
                                        $out_time_exp = explode(':', $out);
                                        // hours
                                        $in_hour = $in_time_exp[0];
                                        $out_hour = $out_time_exp[0];
                                        // minuts
                                        $in_minuts = $in_time_exp[1];
                                        $out_minuts = $out_time_exp[1];
                                        $beetween_hours = $out_hour - $in_hour;
                                        $beetween_minuts = $in_minuts - $out_minuts;
                                        $btm = str_pad($beetween_minuts, 2, '0', STR_PAD_LEFT);
                                        if ($in == "00:00:00" || $out == "00:00:00") {
                                            ?>
                                            <td>--</td>
                                        <?php } else { ?>
                                            <td><?= $beetween_hours . ":" . abs($btm); ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    var table_st = $('#results_table').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                    table_st.buttons().container().appendTo('#results_table_wrapper  .col-md-6:eq(0)');
                </script>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="text-center">
                        <div>
                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <div class="error-img">
                                        <img src="<?= base_url(); ?>assets/images/500-error.png" alt=""
                                             class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-uppercase mt-4">لم نعثر على أي معلومات</h4>
                        <p class="text-muted">عذرا ، لم نتمكن من العثور على أي معلومات لهذا المستخدم. الرجاء إدخال
                            المعلومات أو اختيار مستخدم آخر.</p><br>
                    </div>
                </div>
            <?php }
        } else {
            $errors_1 = str_replace("<p>", "", validation_errors());
            $errors = str_replace("</p>", '\n', $errors_1);
            ?>
            <script>
                Swal.fire({
                    title: 'error',
                    text: ` <?= $errors; ?>`,
                    icon: 'error'
                });
            </script>
            <?php
        }
    }

    public function sync_device()
    {
        $done = 0;
        $respons = "";
        $device_results = $this->input->post();
        if (!empty($device_results)) {
            foreach ($device_results as $result) {
                $user_data = $this->db->query("SELECT Id,user_type,source_id FROM 
				`air_areas` WHERE `mac_adress` = '" . $result['Device_Mac'] . "'")->result_array();
                $done++;
                $time = date("H:i:s");
                $date = date("Y-m-d");
                //print_r($result);
                $data = [
                    'User_type' => $user_data[0]['user_type'] ?? "",
                    'source_id' => $user_data[0]['source_id'] ?? "",
                    'device_id' => $user_data[0]['Id'] ?? "",
                    'Device_Mac' => $result['Device_Mac'],
                    'humidity' => $result['humidity'],
                    'ch2o' => $result['ch2o'],
                    'voc_EtOH' => $result['voc_EtOH'],
                    'pm10' => $result['pm10'],
                    'voc_Isobutylene' => $result['voc_Isobutylene'],
                    "pm2_5" => $result['pm2_5'],
                    'pm1' => $result['pm1'],
                    'pm' => $result['pm'],
                    'dewpoint_f' => $result['dewpoint_f'],
                    'dewpoint_c' => $result['dewpoint_c'],
                    'Temperature_c' => $result['Temperature_c'],
                    'Temperature_f' => $result['Temperature_f'],
                    'Pressure' => $result['Pressure'],
                    'co2' => $result['co2'],
                    'aq' => $result['aq'],
                    'pc0_3' => $result['pc0_3'],
                    'pc0_5' => $result['pc0_5'],
                    'pc1' => $result['pc1'],
                    'pc2_5' => $result['pc2_5'],
                    'pc5' => $result['pc5'],
                    'pc10' => $result['pc10'],
                    'created' => $date,
                    'time' => $time,
                ];
                if ($this->db->insert('air_result_gateway', $data)) {
                    echo "Inserted";
                } else {
                    print_r($this->db->error());
                    echo $this->db->last_query();
                }
                if ($done == sizeof($device_results)) {
                    $respons = "success";
                }
            }
            echo $respons;
        }
    }

    public function FeedBack()
    {
        if (
            $this->input->post('img_txt') && $this->input->post('url') && $this->input->post('feedback_desc')
            && $this->input->post('sessiondata')
        ) {
            $img_txt = $this->input->post('img_txt');
            $url = $this->input->post('url');
            $feedback_desc = $this->input->post('feedback_desc');
            $sessiondata = $this->input->post('sessiondata');
            $name = date('Y-d-m') . time();
            $ip = $this->getIPAddress();
            $data = $img_txt;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents('./uploads/feedBack/' . $name . '.png', $data);
            $data = [
                "img_txt" => $name,
                "page_url" => $url,
                "feedback_desc" => $feedback_desc,
                "session_data" => $sessiondata,
                "user_ip" => $ip
            ];
            if ($this->db->insert('feedBack', $data)) {
                $this->load->library('email');
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'mail.track.qlickhealth.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'no_reply@track.qlickhealth.com',
                    'smtp_pass' => 'Bd}{kKW]eTfH',
                    'smtp_crypto' => 'ssl',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $pageName = explode("/", $url);
                $page = $pageName[(sizeof($pageName)) - 2] . " / " . $pageName[(sizeof($pageName)) - 1];
                //$link = base_url()."AR/users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                $messg = '<center>
				  <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
				  <h2> Hi there <h2> 
				  <h3> we have a feedBack About This Page ' . $page . '</h3>
				  <h3> the Time Of sending FeedBack : ' . date('Y-m-d H:m:s') . ' </h3>
				  <a href="' . base_url() . 'FeedBack/ShowFeedBacks' . '" 
				   style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;"> Go To the page Of error </a>
				  </center>';
                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
                $this->email->to("beclose2022@gmail.com");
                $this->email->bcc("beclose2030@gmail.com");
                $this->email->subject(' New FeedBack in qlicksystems From : ' . $ip);
                $this->email->message($messg);
                if ($this->email->send()) {
                    echo "FeedBack Sended ";
                } else {
                    echo "error in email send";
                    echo $this->email->print_debugger();
                }
            } else {
                echo "error in insert";
                print_r($this->db->error());
            }
        } else {
            echo "error in post send";
            print_r($this->input->post());
        }
    }

    private function getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function gitDeviceResults()
    {
        $data = [];
        if ($this->input->post("type")) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $device_mac = $this->input->post("device_mac");
            if ($this->input->post("type") == "Daily") {
                $data = $this->db->query(" SELECT `air_result_gateway`.`device_id`,
				air_result_gateway.* ,
				`air_areas`.`Description` as `Area`
				FROM `air_result_gateway` 
				JOIN `air_areas` ON `air_areas`.`Id` = `air_result_gateway`.`device_id`
				WHERE `air_result_gateway`.`User_type` = 'school' 
				AND `air_result_gateway`.`source_id` = '" . $sessiondata['admin_id'] . "' 
				AND `air_areas`.`user_type` = 'school' AND
				`air_areas`.`source_id` =  '" . $sessiondata['admin_id'] . "'
				AND `air_areas`.`mac_adress` = '" . $device_mac . "'
				AND `air_result_gateway`.`time` BETWEEN '" . $this->input->post("from") . ":00' AND '" . $this->input->post("to") . ":00'
                AND `air_result_gateway`.`Created` = '" . date("Y-m-d") . "'
				ORDER BY `air_result_gateway`.`Id` DESC ")->result_array();
            } elseif ($this->input->post("type") == "weekly") {
                //2021-01-24
                $from = date("Y-m-") . (date("d") - 7);
                $to = date("Y-m-d");
                //echo "from is = ".$from;
                //echo "to is = ".$to."<br>";
                $data = $this->db->query(" SELECT `air_result_week`.`device_id`,
				air_result_week.* ,
				`air_areas`.`Description` as `Area`
				FROM `air_result_week` 
				JOIN `air_areas` ON `air_areas`.`Id` = `air_result_week`.`device_id`
				WHERE `air_result_week`.`User_type` = 'school' 
				AND `air_result_week`.`source_id` = '" . $sessiondata['admin_id'] . "' 
				AND `air_areas`.`user_type` = 'school' AND
				`air_areas`.`source_id` =  '" . $sessiondata['admin_id'] . "'
				AND `air_areas`.`mac_adress` = '" . $device_mac . "'
				AND `air_result_week`.`created` BETWEEN '" . $from . "' AND '" . $to . "'
				ORDER BY `air_result_week`.`Id` DESC ")->result_array();
                //echo $this->db->last_query();
            } elseif ($this->input->post("type") == "specific_date") {
                $from = $this->input->post("from");
                $to = $this->input->post("to");
                $data = $this->db->query(" SELECT `air_result_month`.`device_id`,
				air_result_month.* ,
				`air_areas`.`Description` as `Area`
				FROM `air_result_month` 
				JOIN `air_areas` ON `air_areas`.`Id` = `air_result_month`.`device_id`
				WHERE `air_result_month`.`User_type` = 'school' 
				AND `air_result_month`.`source_id` = '" . $sessiondata['admin_id'] . "' 
				AND `air_areas`.`user_type` = 'school' AND
				`air_areas`.`source_id` =  '" . $sessiondata['admin_id'] . "'
				AND `air_areas`.`mac_adress` = '" . $device_mac . "'
				AND `air_result_month`.`created` BETWEEN '" . $from . "' AND '" . $to . "'
				ORDER BY `air_result_month`.`Id` DESC ")->result_array();
            }
            echo json_encode($data);
        }
    }

    public function SaveMessage()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $accepted = array(
            [
                'code' => 1,
                'name' => 'super',
            ],
            [
                'code' => 2,
                'name' => 'company',
            ],
            [
                'code' => 3,
                'name' => 'ministry',
            ],
            [
                'code' => 4,
                'name' => 'department',
            ],
            [
                'code' => 5,
                'name' => 'school',
            ],
            [
                'code' => 6,
                'name' => 'department_company',
            ]
        );
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('messageen', 'Message EN', 'trim|required|min_length[3]|max_length[1000]');
        $this->form_validation->set_rules('messagear', 'Message AR', 'trim|required|min_length[3]|max_length[1000]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[1,0]');
        if (!empty($sessiondata) && in_array(strtolower($sessiondata['type']), array_column($accepted, "name"))) {
            if ($this->form_validation->run()) {
                $typecode = str_replace(array_column($accepted, "name"), array_column($accepted, "code"), trim(strtolower($sessiondata['type'])));
                $data = [
                    "message_en" => $this->input->post('messageen'),
                    "message_ar" => $this->input->post('messagear'),
                    "status" => $this->input->post('status'),
                    "type" => $typecode,
                    "typeID" => $sessiondata['admin_id'],
                ];
                if ($this->db->insert('r_messages', $data)) {
                    $this->response->json(['status' => "ok"]);
                } else {
                    $this->response->json(['status' => "error", 'message' => "عذرا ، حدث خطأ غير متوقع ... يرجى المحاولة مرة أخرى في وقت لاحق"]);
                }
            } else {
                $this->response->json(['status' => "error", 'message' => "يرجى التحقق من المدخلات  "]);
            }
        } else {
            $this->response->json(['status' => "error", 'message' => "unexpected error... please try again later"]);
        }
    }
}
