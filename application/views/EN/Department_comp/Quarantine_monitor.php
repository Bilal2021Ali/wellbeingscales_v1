<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
    .result strong {
        font-size: 30px;
    }

    .Td-Results_font span {
        font-size: 20px !important;
        padding: 6px;
    }

    .Td-Results .badge {
        padding: 6px;
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
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"> <?= $action ?> Monitoring </h4>
                        </div>
                    </div>
                </div>
                <?php

                function data_of_user($type, $sessiondata, $action)
                {
                    $ci = &get_instance();
                    $list = array();
                    $today = date("Y-m-d");
                    //UserType
                    $Ourstaffs = $ci->db->query("SELECT * 
			FROM l2_co_patient
			WHERE `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'
			AND `l2_co_patient`.`Action` = '" . $action . "' ")->result_array();
                    //print_r($Ourstaffs);
                    foreach ($Ourstaffs as $staff) {
                        $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                        $ID = $staff['Id'];
                        $Position_Staff = $staff['Position'];

                        $getResults = $ci->db->query("SELECT * FROM l2_co_monthly_result WHERE `UserId` = '" . $staff['Id'] . "' 
                        AND UserType = '" . $type . "' ORDER BY `TimeStamp` DESC LIMIT 1 ")->result_array();
                        foreach ($getResults as $results) {
                            $creat = $results['Created'] . ' ' . $results['Time'];
                            $list[] = array(
                                "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'],
                                "Testtype" => $results['Device_Test'],
                                "Result" => $results['Result'], "Creat" => $creat, 'position' => $Position_Staff, "Symp" => $results['Symptoms'],
                                "Added_By" => $results['Added_By'], "Device" => $results['Device'], "type" => $type,
                                "Blood_pressure_min" => $results['Blood_pressure_min'],
                                "Blood_oxygen" => $results['Blood_oxygen'], "Heart_rate" => $results['Heart_rate'],
                                "Blood_pressure_max" => $results['Blood_pressure_max'],
                                "weight" => $results['weight'], "Glucose" => $results['Glucose']
                            );
                        }
                    }
                    return ($list);
                }

                $Staff_list = array();
                $tbl_prefix = $this->db->query("SELECT * FROM `r_usertype`")->result_array();
                foreach ($tbl_prefix as $pref) {
                    $Staff_list[] = data_of_user($pref['Id'], $sessiondata, $action);
                }

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
                                echo $name['symptoms_AR'] . ",";
                            }
                        }
                    } else {
                        echo " no symptoms ";
                    }
                }
                $dialostics = $this->db->query("SELECT * FROM `r_dialosticbp`")->result_array(); ?>
                <style>
                    .badge {
                        text-align: center;
                    }

                    .Td-Results {
                        color: #FFFFFF;
                    }

                    .result {
                        border: 4px solid #fff !important;
                    }

                    th {
                        text-align: center;
                    }


                    .result .Unit {
                        position: relative;
                        bottom: -20px;
                        left: -40px;
                        font-size: 13px;
                    }

                    .formcontainer table span {
                        text-transform: none;
                    }

                    .result .col-sm-6 {
                        border: 1px solid #fff;
                    }
                </style>
                <!-- end page title -->
                <div class="row formcontainer" id="Staff_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> </h4>
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="font-size:18px"> Name </th>
                                            <th style="font-size:18px" width="14%"> Result </th>
                                            <th style="font-size:18px" class="text-center" width="14%"> Blood Pressure </th>
                                            <th style="font-size:18px" class="text-center" width="14%"> Oxygen </th>
                                            <th style="font-size:18px" class="text-center" width="14%"> Heart Beat </th>
                                            <th style="font-size:18px" class="text-center" width="14%"> Weight </th>
                                            <th style="font-size:18px" class="text-center" width="14%"> Glucose </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($Staff_list as $results) {
                                            foreach ($results as $staffsRes) {  ?>
                                                <tr>
                                                    <td class="text-center result"><?php $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                                                    WHERE `For_User` = '" . $staffsRes['Id'] . "' AND 
                                                    `Type_Of_User` = '" . $staffsRes['type'] . "' LIMIT 1 ")->result_array();
                                                                                    ?>
                                                        <?php if (empty($avatar)) {  ?>
                                                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle mr-2" alt="...">
                                                        <?php } else { ?>
                                                            <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle mr-2" alt="...">
                                                        <?php } ?>
                                                        <h6 class="font-size-15 mb-1 font-weight-normal"><?= $staffsRes['Username']; ?></h6>
                                                        <p class="text-muted" style="font-size: 10px;"><?= $staffsRes['Creat'] ?> </p>
                                                    </td>
                                                    <?php boxes_Colors($staffsRes['Result'], $dialostics[0], "Temperature", "C°", "-26px", "Temperature.png"); ?>
                                                    <?php Blood_pressure($staffsRes['Blood_pressure_min'], $staffsRes['Blood_pressure_max'], $dialostics[1], $dialostics[2], "BloodPressure02.png"); ?>
                                                    <?php boxes_Colors($staffsRes['Blood_oxygen'], $dialostics[3], "Oxygen", "%", "-46px", "Oxygen.png"); ?>
                                                    <?php boxes_Colors($staffsRes['Heart_rate'], $dialostics[4], "Heart rate ", "bpm", "-26px", "Puls.png"); ?>
                                                    <?php boxes_Colors($staffsRes['weight'], $dialostics[5], "Weight", "kg", "-26px", "Wieght.png"); ?>
                                                    <?php boxes_Colors($staffsRes['Glucose'], $dialostics[6], "Glucose", "mmol/L", "-26px", "Glucose.png"); ?>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
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
    <style>
        strong {
            font-size: 16px;
        }
    </style>
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
        $(document).ready(function() {
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
    </script>
</body>
<?php
function boxes_Colors($result, $condition, $text, $unit, $left = "-26px", $img = "")
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
            <img src="<?= base_url("assets/images/icons/" . $img)  ?>" alt="" class="icon__"><?= $text ?>
        </h6>
        <strong style="color: #<?= $color_font ?>;display : block;margin-top: 18px;">
            <?= $result; ?>
        </strong>
        <span style="color: #<?= $color_font ?>;left: <?= $left ?>" class="Unit">
            <?= $unit ?>
            </h6>
    </td>
<?php  } ?>
<?php
function Blood_pressure($result_f, $result_l, $condition, $condition_l, $img, $date = "--:--:--")
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
                    <h6 style="color: #191919">
                        <img src="<?= base_url("assets/images/icons/" . $img)  ?>" alt="" class="icon__"></img>
                    </h6>
                </div>
                <div class="col-sm-6" style="background: #<?= $back_font_f ?>;padding : 10px;"><strong style="color: #<?= $color_font_f ?>;display : block;"><?= $result_f; ?></strong></div>
                <div class="col-sm-6" style="background: #<?= $back_font_l ?>;padding : 10px;"><strong style="color: #<?= $color_font_l ?>;display : block;"><?= $result_l; ?></strong></div>
            </div>
            <span style="color: #<?= $color_font_f ?>;left: 0px;top: 10px;font-weight: lighter;" class="Unit"><?= "mmHg" ?>
                <?= $date !== "00:00:00" ? "<br>" . $date : "<br>" . "--:--:--"; ?> </span>
        </h6>
    </td>
<?php  } ?>

</html>