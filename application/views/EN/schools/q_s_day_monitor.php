<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
</head>

<style>
    .result strong {
        font-size: 30px;
    }
</style>

<body>
<!-- Begin page -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->

            <div class="row">
                <div class="col-12"><br>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        MON 042:
                        Daily Monitor</h4>
                </div>
            </div>
        </div>
        <style>
            .Td-Results_font span {
                font-size: 20px !important;
                padding: 6px;
            }

            .Td-Results .badge {
                padding: 6px;
            }
        </style>
        <?php

        function data_of_user($type, $sessiondata)
        {
            $ci = &get_instance();
            $list = array();
            $today = date("Y-m-d");

            if ($type == "Staff") {
                $Ourstaffs = $ci->db->query("SELECT `l2_staff`.* , 
                        `r_positions_sch`.`Position` AS Position_name
                        FROM l2_staff 
                        LEFT JOIN `r_positions_sch` ON `l2_staff`.`Position` = `r_positions_sch`.`Id`
                        WHERE `l2_staff`.`Added_By` = '" . $sessiondata['admin_id'] . "'   ")->result_array();
            } elseif ($type == "Teacher") {
                $Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
                    `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            } elseif ($type == "Student") {
                $Ourstaffs = $ci->db->query(" SELECT `l2_student`.* , `r_levels`.`Class` AS StudentClass 
                        FROM `l2_student`
                        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                        WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            }

            $class = null;
            $grade = null;

            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                //$ID = $staff['Id'];
                $grade = "";
                $ID = $staff['Id'];
                $action = $staff['Action'];

                $getResults = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
                        AND UserType = '" . $type . "' AND `Created` = '" . $today . "' ORDER BY `Id` DESC  LIMIT 1")->result_array();

                foreach ($getResults as $results) {
                    $creat = $results['Result_Date'];
                    $list[] = array(
                        "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'],
                        "Testtype" => $results['Device_Test'],
                        "Result" => $results['Result'], "Creat" => $creat, 'position' => $staff["Position_name"] ?? "--", "Symp" => $results['Symptoms'],
                        "Added_By" => $results['Added_By'], "Device" => $results['Device'], "type" => $type,
                        "Blood_pressure_min" => $results['Blood_pressure_min'], "time" => $results['Time'],
                        "Blood_oxygen" => $results['Blood_oxygen'], "Heart_rate" => $results['Heart_rate'],
                        "Blood_pressure_max" => $results['Blood_pressure_max'], "action" => $action,
                        "weight" => $results['weight'], "Glucose" => $results['Glucose'],
                        // times
                        "Result_Time" => ($results['Result_Date'] == null ? "--/--/--" : $results['Result_Date']) . "<br>" . $results['Result_Time'],
                        "Blood_pressure_Date" => ($results['Blood_pressure_Date'] == null ? "--/--/--" : $results['Blood_pressure_Date']) . "<br>" . $results['Blood_pressure_Time'],
                        "Blood_oxygen_Date" => ($results['Blood_oxygen_Date'] == null ? "--/--/--" : $results['Blood_oxygen_Date']) . "<br>" . $results['Blood_oxygen_Time'],
                        "Heart_rate_Date" => ($results['Heart_rate_Date'] == null ? "--/--/--" : $results['Heart_rate_Date']) . "<br>" . $results['Heart_rate_Time'],
                        "weight_Date" => ($results['weight_Date'] == null ? "--/--/--" : $results['weight_Date']) . '<br>' . $results['weight_Time'],
                        "Glucose_Date" => ($results['Glucose_Date'] == null ? "--/--/--" : $results['Glucose_Date']) . "<br>" . $results["Glucose_Time"]
                    );
                }
            }
            return ($list);
        }

        $Staff_list = data_of_user("Staff", $sessiondata, $Action);
        $Student_list = data_of_user("Student", $sessiondata, $Action);
        $Teacher_list = data_of_user("Teacher", $sessiondata, $Action);


        function symps($symps)
        {
            $ci = &get_instance();
            $Symps_array = explode(';', $symps);
            $sz = sizeof($Symps_array);
            //print_r($Symps_array);
            if ($sz > 1) {
                foreach ($Symps_array as $sympsArr) {
                    //print_r($sympsArr);
                    //echo sizeof($Symps_array);
                    $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                    foreach ($SempName as $name) {
                        echo $name['symptoms_EN'] . ",";
                    }
                }
            } else {
                echo "No Symptoms Found ";
            }
        }


        $dialostics = $this->db->query("SELECT * FROM `r_dialosticbp`")->result_array();
        ?>
        <style>
            * {
                text-transform: inherit !important;
            }

            .badge {
                text-align: center;
            }

            .Td-Results {
                color: #FFFFFF;
            }
        </style>
        <div class="control col-md-12" style="padding-bottom: 15px;">
            <button type="button" form_target="Staff_list" class="btn btn-primary w-md contr_btn"><i
                        class="uil uil-list"></i>Staff
            </button>
            <button type="button" form_target="Teachers_list" class="btn w-md contr_btn"><i class="uil uil-list"></i>Teacher
            </button>
            <button type="button" form_target="Studnts_list" class="btn w-md contr_btn"><i class="uil uil-list"></i>Student
            </button>
        </div>
        <!-- end page title -->
        <div class="row formcontainer" id="Staff_list">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Staff </h4>
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>
                                    <p style="font-size:18px">#
                                </th>
                                <th>
                                    <p style="font-size:18px"> Name
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Temperature
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Blood Pressure
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Blood Oxygen
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Heart Rate
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Weight
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Glucose
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Staff_list as $sn => $staffsRes) { ?>
                                <tr>
                                    <td style="width: 20px;"><?= $sn + 1 ?></td>
                                    <td class="text-center result"><?php
                                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                        ?>
                                        <?php if (empty($avatar)) { ?>
                                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                                 class="avatar avatar-lg rounded-circle" alt="...">
                                        <?php } else { ?>
                                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                                 class="avatar avatar-lg rounded-circle" alt="...">
                                        <?php } ?>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">
                                            <?= $staffsRes['Username']; ?>
                                        </h6>
                                        <p class="text-muted" style="font-size: 10px;">
                                            <?= $staffsRes['action'] ?>
                                        </p>
                                    </td>
                                    <?php boxes_Colors($staffsRes['Result'], $dialostics[0], "", "C°", "-26px", "Temperature.png", $staffsRes['Result_Time']); ?>
                                    <?php Blood_pressure($staffsRes['Blood_pressure_min'], $staffsRes['Blood_pressure_max'], $dialostics[1], $dialostics[2], "BloodPressure02.png", $staffsRes['Blood_pressure_Date']); ?>
                                    <?php boxes_Colors($staffsRes['Blood_oxygen'], $dialostics[3], "", "%", "-46px", "Oxygen.png", $staffsRes['Blood_oxygen_Date']); ?>
                                    <?php boxes_Colors($staffsRes['Heart_rate'], $dialostics[4], " ", "bpm", "-26px", "Puls.png", $staffsRes['Heart_rate_Date']); ?>
                                    <?php boxes_Colors($staffsRes['weight'], $dialostics[5], "", "kg", "-26px", "Wieght.png", $staffsRes['weight_Date']); ?>
                                    <?php boxes_Colors($staffsRes['Glucose'], $dialostics[6], "", "mmoI/L", "-26px", "Glucose.png", $staffsRes["Glucose_Date"]); ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row formcontainer" id="Studnts_list">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Students </h4>
                        <div class="students_button"></div>
                        <table id="Students_table" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>
                                    <p style="font-size:18px">#
                                </th>
                                <th>
                                    <p style="font-size:18px"> Name
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Temperature
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Blood Pressure
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Blood Oxygen
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Heart Rate
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Weight
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Glucose
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Student_list as $sn => $studentResults) { ?>
                                <tr>
                                    <td style="width: 20px;"><?= $sn + 1 ?></td>
                                    <td class="text-center result"><?php
                                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                WHERE `For_User` = '" . $studentResults['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                        ?>
                                        <?php if (empty($avatar)) { ?>
                                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                                 class="avatar avatar-lg rounded-circle" alt="...">
                                        <?php } else { ?>
                                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                                 class="avatar avatar-lg rounded-circle" alt="...">
                                        <?php } ?>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">
                                            <?= $studentResults['Username']; ?>
                                        </h6>
                                        <p class="text-muted" style="font-size: 10px;">
                                            <?= $studentResults['action'] ?>
                                        </p>
                                    </td>
                                    <?php boxes_Colors($studentResults['Result'], $dialostics[0], "", "C°", "-26px", "Temperature.png", $studentResults['Result_Time']); ?>
                                    <?php Blood_pressure($studentResults['Blood_pressure_min'], $studentResults['Blood_pressure_max'], $dialostics[1], $dialostics[2], "BloodPressure02.png", $studentResults['Blood_pressure_Date']); ?>
                                    <?php boxes_Colors($studentResults['Blood_oxygen'], $dialostics[3], "", "%", "-46px", "Oxygen.png", $studentResults['Blood_oxygen_Date']); ?>
                                    <?php boxes_Colors($studentResults['Heart_rate'], $dialostics[4], "", "bpm", "-26px", "Puls.png", $studentResults['Heart_rate_Date']); ?>
                                    <?php boxes_Colors($studentResults['weight'], $dialostics[5], "", "kg", "-26px", "Wieght.png", $studentResults['weight_Date']); ?>
                                    <?php boxes_Colors($studentResults['Glucose'], $dialostics[6], "", "mmoI/L", "-26px", "Glucose.png", $studentResults["Glucose_Date"]); ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row formcontainer" id="Teachers_list">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Teachers </h4>
                        <table id="Teacher_table" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>
                                    <p style="font-size:18px">#
                                </th>
                                <th>
                                    <p style="font-size:18px"> Name
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Temperature
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Blood Pressure
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Blood Oxygen
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Heart Rate
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Weight
                                </th>
                                <th class="text-center">
                                    <p style="font-size:18px"> Glucose
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Teacher_list as $sn => $TeacherResults) { ?>
                                <tr>
                                    <td style="width: 20px;"><?= $sn + 1 ?></td>
                                    <td class="text-center result"><?php
                                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                WHERE `For_User` = '" . $TeacherResults['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                        ?>
                                        <?php if (empty($avatar)) { ?>
                                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                                 class="avatar avatar-lg rounded-circle" alt="...">
                                        <?php } else { ?>
                                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                                 class="avatar avatar-lg rounded-circle" alt="...">
                                        <?php } ?>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">
                                            <?= $TeacherResults['Username']; ?>
                                        </h6>
                                        <p class="text-muted" style="font-size: 10px;">
                                            <?= $TeacherResults['action'] ?>
                                        </p>
                                    </td>
                                    <?php boxes_Colors($TeacherResults['Result'], $dialostics[0], "", "C°", "-26px", "Temperature.png", $TeacherResults['Result_Time']); ?>
                                    <?php Blood_pressure($TeacherResults['Blood_pressure_min'], $TeacherResults['Blood_pressure_max'], $dialostics[1], $dialostics[2], "BloodPressure02.png", $TeacherResults['Blood_pressure_Date']); ?>
                                    <?php boxes_Colors($TeacherResults['Blood_oxygen'], $dialostics[3], "", "%", "-46px", "Oxygen.png", $TeacherResults['Blood_oxygen_Date']); ?>
                                    <?php boxes_Colors($TeacherResults['Heart_rate'], $dialostics[4], " ", "bpm", "-26px", "Puls.png", $TeacherResults['Heart_rate_Date']); ?>
                                    <?php boxes_Colors($TeacherResults['weight'], $dialostics[5], "", "kg", "-26px", "Wieght.png", $TeacherResults['weight_Date']); ?>
                                    <?php boxes_Colors($TeacherResults['Glucose'], $dialostics[6], "", "mmoI/L", "-26px", "Glucose.png", $TeacherResults["Glucose_Date"]); ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->

</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->
<!-- JAVASCRIPT -->
<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<!-- Required datatable js -->
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url(); ?>assets/js/app.js"></script>
<script>
    $(document).ready(function () {
        //$('#Students_table').DataTable(); //Buttons examples

        var table_st = $('#Students_table').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        });
        table_st.buttons().container().appendTo('#Students_table_wrapper .col-md-6:eq(0)');

        var table_th = $('#Teacher_table').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        });
        table_th.buttons().container().appendTo('#Teacher_table_wrapper .col-md-6:eq(0)');
    });

    $('#Teachers_list').hide();
    $('#Studnts_list').hide();

    $('#Staffs_list').show();

    $('.control button').click(function () {
        $('.control button').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $('.formcontainer').hide();
        var to = $(this).attr('form_target');
        $('#' + to).show();
    });
</script>
</body>
<?php

function boxes_Colors($result, $condition, $text, $unit, $left = "-26px", $img = "", $date = "00:00:00")
{
    $color_font = "191919";
    $back_font = "f8f9fa";
    settype($result, "float");

    if ($result > $condition['low_from'] && $result < $condition['from_to']) {
        $color_font = $condition['low_font_col'];
        $back_font = $condition['low_back_col'];
    } elseif ($result > $condition['normal_from'] && $result < $condition['normal_to']) {
        $color_font = $condition['normal_font_col'];
        $back_font = $condition['normal_back_col'];
    } elseif ($result > $condition['pre_from'] && $result < $condition['pre_to']) {
        $color_font = $condition['pre_font_col'];
        $back_font = $condition['pre_back_col'];
    } elseif ($result > $condition['high_from'] && $result < $condition['hight_to']) {
        $color_font = $condition['hight_font_col'];
        $back_font = $condition['hight_back_col'];
    } elseif ($result > $condition['high2_from'] && $result < $condition['high2_to']) {
        $color_font = $condition['high2_font_col'];
        $back_font = $condition['high2_back_col'];
    }
    ?>
    <td class="text-center result" style="background: #<?= $back_font ?>">
        <h6 style="color: #<?= $color_font ?>">
            <img src="<?= base_url("assets/images/icons/" . $img) ?>" alt="" class="icon__">
            <?= $text ?>
        </h6>
        <strong style="color: #<?= $color_font ?>;display : block;margin-top: 18px;">
            <?= $result; ?>
        </strong><span style="color: #<?= $color_font ?>;left: <?= $left ?>" class="Unit">
      <?= $unit ?>
            <?= $date !== "00:00:00" ? "<br>" . $date : "<br>" . "--:--:--"; ?>
      </h6>
    </td>
<?php } ?>
<?php

function Blood_pressure($result_f, $result_l, $condition, $condition_l, $img = "", $date = "--:--:--")
{
    $color_font_f = "191919";
    $back_font_f = "f8f9fa";
    $color_font_l = "191919";
    $back_font_l = "f8f9fa";
    $bkall = "f8f9fa";
    $ci = &get_instance();
    settype($result_f, "float");
    settype($result_l, "float");
    if ($result_f >= $condition['low_from'] && $result_f <= $condition['from_to']) {
        $color_font_f = $condition['low_font_col'];
        $back_font_f = $condition['low_back_col'];
    } elseif ($result_f >= $condition['normal_from'] && $result_f <= $condition['normal_to']) {
        $color_font_f = $condition['normal_font_col'];
        $back_font_f = $condition['normal_back_col'];
    } elseif ($result_f >= $condition['pre_from'] && $result_f <= $condition['pre_to']) {
        $color_font_f = $condition['pre_font_col'];
        $back_font_f = $condition['pre_back_col'];
    } elseif ($result_f >= $condition['high_from'] && $result_f <= $condition['hight_to']) {
        $color_font_f = $condition['hight_font_col'];
        $back_font_f = $condition['hight_back_col'];
    } elseif ($result_f >= $condition['high2_from'] && $result_f <= $condition['high2_to']) {
        $color_font_f = $condition['high2_font_col'];
        $back_font_f = $condition['high2_back_col'];
    }

    $bkallcond = $ci->db->get_where("r_dialosticbp", ["Id" => "8"])->result_array();
    if ($result_f >= $bkallcond[0]['low_from'] && $result_f <= $bkallcond[0]['from_to']) {
        $bkall = $bkallcond[0]['low_back_col'];
    } elseif ($result_f >= $bkallcond[0]['normal_from'] && $result_f <= $bkallcond[0]['normal_to']) {
        $bkall = $bkallcond[0]['normal_back_col'];
    } elseif ($result_f >= $bkallcond[0]['pre_from'] && $result_f <= $bkallcond[0]['pre_to']) {
        $bkall = $bkallcond[0]['pre_back_col'];
    } elseif ($result_f >= $bkallcond[0]['high_from'] && $result_f <= $bkallcond[0]['hight_to']) {
        $bkall = $bkallcond[0]['hight_back_col'];
    } elseif ($result_f >= $bkallcond[0]['high2_from'] && $result_f <= $bkallcond[0]['high2_to']) {
        $bkall = $bkallcond[0]['high2_back_col'];
    }

    if ($result_l >= $condition_l['low_from'] && $result_l <= $condition_l['from_to']) {
        $color_font_l = $condition_l['low_font_col'];
        $back_font_l = $condition_l['low_back_col'];
    } elseif ($result_l >= $condition_l['normal_from'] && $result_l <= $condition_l['normal_to']) {
        $color_font_l = $condition_l['normal_font_col'];
        $back_font_l = $condition_l['normal_back_col'];
    } elseif ($result_l >= $condition_l['pre_from'] && $result_l <= $condition_l['pre_to']) {
        $color_font_l = $condition_l['pre_font_col'];
        $back_font_l = $condition_l['pre_back_col'];
    } elseif ($result_l >= $condition_l['high_from'] && $result_l <= $condition_l['hight_to']) {
        $color_font_l = $condition_l['hight_font_col'];
        $back_font_l = $condition_l['hight_back_col'];
    } elseif ($result_l >= $condition_l['high2_from'] && $result_l <= $condition_l['high2_to']) {
        $color_font_l = $condition_l['high2_font_col'];
        $back_font_l = $condition_l['high2_back_col'];
    }
    //print_r($condition);
    ?>
    <td class="text-center result" style="background: #<?= $bkall ?>">
        <h6 style="color: #<?= $color_font_f ?>">
            <div class="row">
                <div class="col-sm-12">
                    <h6 style="color: #191919"><img src="<?= base_url("assets/images/icons/" . $img) ?>" alt=""
                                                    class="icon__"></img></h6>
                </div>
                <div class="col-sm-6" style="background: #<?= $back_font_l ?>;padding : 10px;"><strong
                            style="color: #<?= $color_font_l ?>;display : block;">
                        <?= $result_l; ?>
                    </strong></div>
                <div class="col-sm-6" style="background: #<?= $back_font_f ?>;padding : 10px;"><strong
                            style="color: #<?= $color_font_f ?>;display : block;">
                        <?= $result_f; ?>
                    </strong></div>
            </div>
            <span style="color: #<?= $color_font_f ?>;left: 0px;top: 10px;font-weight: lighter;" class="Unit">
        <?= "mmHg" ?>
        <?= $date !== "00:00:00" ? "<br>" . $date : "<br>" . "--:--:--"; ?>
      </span>
        </h6>
    </td>
<?php } ?>

</html>