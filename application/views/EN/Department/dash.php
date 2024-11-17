<!doctype html>
<html lang="en">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<body class="light menu_light logo-white theme-white">
    <style>
        .spinner-border {
            margin: auto !important;
        }

        #SelectTheClassCard {
            display: none;
        }

        #freepik_stories-empty {
            width: 100%;
            max-width: 300px;
            margin: auto;
        }

        #drawChart {
            text-align: center;
            padding: 10px;
        }

        .badge {
            text-transform: capitalize;
            padding: 5px;
        }

        .notStatic {
            margin-top: 12px;
        }

        .notStatic .card-body {
            padding-top: 0px !important;
        }

        .notStatic .card-body .col-xl-9,
        .notStatic .card-body .col-xl-8 {
            padding-top: 8px;
        }

        .notStatic .card-body .badge {
            color: #fff;
        }

        th {
            font-size: 13px;
        }

        .card.notStatic span {
            border-radius: 10px;
            font-size: 29px;
            margin-left: -21px;
        }
    </style>
    <style>
        .More {
            border: 1px solid #000;
            padding: 1px 11px;
            border-radius: 3px;
            margin-left: -14px;
            background: rgba(255, 255, 255, 0.80);
            cursor: pointer;
        }

        .out {
            font-size: 23px;
            color: #a90000;
            cursor: pointer;
            text-align: center;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <?php
                $parent = $this->db->query("SELECT Added_By FROM `l1_department` 
WHERE Id = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC")->result_array();
                $parentId =  $parent[0]['Added_By'];
                $parent_Infos = $this->db->query("SELECT * FROM `l0_organization` 
WHERE Id = '" . $parentId . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $parent_name = $parent_Infos[0]['Username'];
                ?>
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/dashboard.png" style="width: 25px;margin: auto 5px;">Department Dashboard</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $parent_name ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $sessiondata['username']; ?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                <div class="card-body" style="background-color: #022326;">
                                    <div class="float-right mt-2">
                                        <!-- <div id="CharTTest1"></div>-->
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/team.png" alt="schools" width="50px">
                                    </div>
                                    <div>
                                        <?php
                                        $idd = $sessiondata['admin_id'];
                                        $all = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsStaff = $this->db->query("SELECT * FROM `l2_staff`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                        <p class="mb-0">Number of Staff</p>
                                    </div>
                                    <?php if (!empty($lastsStaff)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php foreach ($lastsStaff as $last) { ?>
                                                    <?php echo $last['Created'] ?></span><br>
                                            Last Registered Staff
                                        <?php } ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php echo "--/--/--"; ?></span><br>
                                            Last Registered Staff
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Teachers  -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #ff26be;padding: 5px">
                                <div class="card-body" style="background-color: #2e001f;">
                                    <div class="float-right mt-2">
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/add-user.png" alt="schools" width="50px">
                                    </div>
                                    <div>
                                        <?php
                                        $allstudents = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                        $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1">
                                            <span data-plugin="counterup"><?php echo $allstudents ?></span>
                                        </h4>
                                        <p class="mb-0">Number of Teachers</p>
                                    </div>
                                    <?php if (!empty($lastsTeachers)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php foreach ($lastsTeachers as $last) { ?>
                                                    <?php echo $last['Created'] ?></span><br>
                                            Last Registered Teacher
                                        <?php } ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php echo "--/--/--"; ?></span><br>
                                            Last Registered Teacher
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #3cf2a6;padding: 5px">
                                <div class="card-body" style="background-color: #00261a;">
                                    <div class="float-right mt-2">
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/student.png" alt="schools" width="50px">
                                    </div>
                                    <div>
                                        <?php
                                        $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsStudent = $this->db->query("SELECT * FROM `l2_student` 
					WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1">
                                            <span data-plugin="counterup"><?php echo $allstudents ?></span>
                                        </h4>
                                        <p class="mb-0">Number of Students</p>
                                    </div>
                                    <?php if (!empty($lastsStudent)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php foreach ($lastsStudent as $last) { ?>
                                                    <?php echo $last['Created'] ?></span><br>
                                            Last Registered Student
                                        <?php } ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php echo "--/--/--"; ?></span><br>
                                            Last Registered Student
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #ffd70d;padding: 5px">
                                <div class="card-body" style="background-color: #262002;">
                                    <div class="float-right mt-2">
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pin.png" alt="schools" width="50px">
                                    </div>
                                    <div>
                                        <?php
                                        $Allsites = $this->db->query("SELECT * FROM `l2_site` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsSites = $this->db->query("SELECT * FROM `l2_site`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1">
                                            <span data-plugin="counterup"><?php echo $Allsites ?></span>
                                        </h4>
                                        <p class="mb-0">Number of Sites</p>
                                    </div>
                                    <?php if (!empty($lastsSites)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php foreach ($lastsSites as $last) { ?>
                                                    <?php echo $last['Created'] ?></span><br>
                                            Last Registered Site
                                        <?php } ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php echo "--/--/--"; ?></span><br>
                                            Last Registered Site
                                        </p>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row-->
                <?php $today = date("Y-m-d"); ?>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card_body ">
                                <div style="padding: 20px;padding-bottom: 0px;">
                                    <div class="float-right">
                                        <div class="dropdown">
                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted" data-toggle="modal" data-target="#myModal"><b>Select Lab Test</b>
                                                    <i class="mdi mdi-chevron-down ml-1"></i>
                                                </span>
                                            </a>
                                            <style>
                                                .dropdown-menu * {
                                                    cursor: pointer;
                                                }

                                                .card.notStatic span {
                                                    border-radius: 10px;
                                                }
                                            </style>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <li class="dropdown-item" onClick="Tempratur();">TEMPERATURE</li>
                                                <?php
                                                $list_Tests = $this->db->query("SELECT * FROM `r_testcode`")->result_array();
                                                foreach ($list_Tests as $test) {
                                                ?>
                                                    <li class="dropdown-item" onClick="Get_plus_minus('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title">
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/menu.png" style="width: 25px;margin: auto 5px;">
                                        Daily Lab Tests Counters <?php echo $today; ?>
                                    </h4>
                                </div>
                                <div class="row" style="padding: 20px;" id="TempCounters">
                                    <div class="col-xl-12">
                                        <div class="card-body" style="border-radius: 5px;border: 3px solid #0eacd8;padding: 9px;">
                                            <h4 class="card-title">
                                                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Temperature
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3 text-center">
                                        <div class="card notStatic">
                                            <div class="card-body" style="padding: 5px">
                                                <div class="card-body badge-soft-success" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 6px solid #34ccc7;">
                                                    <div class="row" style="margin-top: 13px;">
                                                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;margin-top: 5px;">
                                                        </div>
                                                        <div class="col-xl-10">
                                                            <?php
                                                            $idd = $sessiondata['admin_id'];
                                                            $all = $this->db->query("SELECT * FROM `l2_patient` WHERE `Added_By` = $idd ")->num_rows();
                                                            $lastsStaff = $this->db->query("SELECT * FROM `l2_patient`  WHERE `Added_By` = $idd 
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                                            ?>
                                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $NORMAL; ?></span></h4>
                                                            <p class="mb-0 badge badge-success font-size-12">Normal Temperature</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Teachers  -->
                                    <div class="col-md-6 col-xl-3 text-center">
                                        <div class="card notStatic">
                                            <div class="card-body" style="padding: 5px">
                                                <div class="card-body badge-soft-warning" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 6px solid #f1b44c;">
                                                    <div>
                                                        <?php
                                                        $allstudents = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                                        $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/orange.png" alt="Low Temperature" style="width: 30px;">
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <p class="mb-0 badge badge-warning font-size-12">Low Temperature</p>
                                                                <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home <?php echo $LOW_In_Home; ?></span>
                                                                <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;display: block;">Quarantine <?php echo $LOW_In_Quern; ?></span>
                                                                <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;display: block;">No Action <?php echo $LOW_In_School; ?></span>
                                                            </div>
                                                            <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                                <h4 class="mb-1 mt-1">
                                                                    <span data-plugin="counterup"><?php echo $LOW_In_Home + $LOW_In_Quern + $LOW_In_School; ?></span>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-->
                                    <div class="col-md-6 col-xl-3 text-center">
                                        <div class="card notStatic">
                                            <div class="card-body" style="padding: 5px">
                                                <div class="card-body badge-soft-danger" style="border-radius: 4px;border: 6px solid #f57d6a;height: 130px;">
                                                    <div class="float-right mt-2">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/red.png" alt="Low Temperature" style="width: 30px;">
                                                        </div>
                                                        <div class="col-xl-8">
                                                            <?php
                                                            $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                                            $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                                            ?>
                                                            <p class="mb-0 badge badge-danger font-size-12">High Temperature</p>
                                                            <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home <?php echo $HIGH_In_Home; ?></span>
                                                            <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;display: block;">Quarantine <?php echo $HIGH_In_Quern; ?></span>
                                                            <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;display: block;">No Action <?php echo $HIGH_In_School; ?></span>
                                                        </div>
                                                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                            <h4 class="mb-1 mt-1">
                                                                <span data-plugin="counterup"><?php echo $HIGH_In_Home + $HIGH_In_Quern + $HIGH_In_School ?></span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-->
                                    <!-- end col-->
                                    <div class="col-md-6 col-xl-3 text-center">
                                        <div class="card notStatic">
                                            <div class="card-body" style="padding: 5px">
                                                <div class="card-body badge-soft-info" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 6px solid #50a5f1;">
                                                    <div class="row" style="margin-top: 13px;">
                                                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Blue.png" alt="Low Temperature" style="width: 30px;margin-top: 5px;">
                                                        </div>
                                                        <div class="col-xl-10">
                                                            <?php
                                                            $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                                            $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                                            ?>
                                                            <h4 class="mb-1 mt-1">
                                                                <span data-plugin="counterup"><?php echo $Emp_Tests; ?></span>
                                                            </h4>
                                                            <p class="mb-0 badge badge-info font-size-12" style="width: 103px;">No Tests</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-->
                                </div>
                            </div>



                            <div class="row" style="padding: 20px;" id="Plus_Minus">
                            </div>
                        </div>
                        <!-- end row-->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown">
                                                    <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted" data-toggle="modal" data-target="#myModal"><b>Select Lab Test</b><i class="mdi mdi-chevron-down ml-1"></i></span>
                                                    </a>
                                                    <style>
                                                        .dropdown-menu * {
                                                            cursor: pointer;
                                                        }
                                                    </style>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;position: relative;">
                                                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_staff_list','#New_Staff_List');">TEMPERATURE</li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="staff_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </h4>
                                        <h4 class="card-title mb-4">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Daily Lab Tests List <?php echo $today; ?> <font color=#e13e2b>(Staff) </font>
                                        </h4>
                                        (<span id="STAFFSNOSHOWTESTNAME">TEMPERATURE</span>)
                                        </h4>

                                        <div data-simplebar style="height: 400px;overflow: auto;">
                                            <div id="simpl_staff_list">
                                                <?php
                                                $list = array();
                                                $today = date("Y-m-d");
                                                $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                                                foreach ($Ourstaffs as $staff) {
                                                    $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                                                    $ID = $staff['Id'];
                                                    $Position_Staff = $staff['Position'];
                                                    $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
                                                    foreach ($getResults as $results) {
                                                        $list[] = array("Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Result_Date'], 'position' => $Position_Staff);
                                                    }
                                                } ?>
                                                <table class="table table-borderless table-centered table-nowrap table_sites ">
                                                    <thead>
                                                        <th> img </th>
                                                        <th> Name </th>
                                                        <th> Result </th>
                                                        <th> Risk </th>
                                                        <th> Action </th>
                                                    </thead>
                                                    <tbody>
                                                        <style>
                                                            .badge {
                                                                text-align: center;
                                                            }

                                                            .Td-Results {
                                                                color: #FFFFFF;
                                                            }
                                                        </style>
                                                        <?php foreach ($list as $staffsRes) { ?>

                                                            <tr>
                                                                <td style="width: 20px;">
                                                                    <?php
                                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                                    ?>
                                                                    <?php if (empty($avatar)) {  ?>
                                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $staffsRes['position']; ?></p>
                                                                </td>
                                                                <?php /* if($staffsRes['Result'] > 36.3 && $staffsRes['Result'] < 37.7 ){ ?>
<td><span class="badge badge-soft-success font-size-12" style="width: 100%;"><?php echo $staffsRes['Result']; ?></span>
<?php }elseif($staffsRes['Result'] > 37.8 ){ ?>
<td><span class="badge badge-soft-danger font-size-12" style="width: 100%;"><?php echo $staffsRes['Result']; ?></span>
<?php }else{ ?>
<td><span class="badge badge-soft-warning font-size-12" style="width: 100%;"><?php echo $staffsRes['Result']; ?></span>
<?php } */ ?>
                                                                <?php boxes_Colors($staffsRes['Result']); ?>
                                                                <?php /*
<td>
<?php if($staffsRes['Result'] <= 45 && $staffsRes['Result'] >= 40.1 ){ ?>
<span class="badge badge-danger font-size-12" style="width: 100%;border-radius: 10px;"></span>
<?php }elseif($staffsRes['Result'] <= 40 && $staffsRes['Result'] >= 38.1 ){ ?>
<span class="badge badge-warning font-size-12" style="width: 100%;border-radius: 10px;"></span>
<?php }elseif($staffsRes['Result'] <= 38 && $staffsRes['Result'] >= 37 ){ ?>
<span class="badge badge-success font-size-12" style="width: 100%;border-radius: 10px;"></span>
<?php }elseif($staffsRes['Result'] <= 36 ){ ?>
<span class="badge badge-info font-size-12" 
style="width: 100%;border-radius: 10px;background-color: #FFE500;color: #7C7C7C;"></span>
<?php }else{ ?>
<span class="badge badge-info font-size-12" 
style="width: 100%;border-radius: 10px;background-color: #272727;color: #FFFFFF;">  </span>
<?php } ?>
</td> 
*/ ?>
                                                                <td>
                                                                    <a href="javascript:void(0);" class="px-3 text-primary" onClick="setmemberInAction(<?php echo $staffsRes['Id'] ?>,'Staff','Home');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Stay Home" theid="23">
                                                                        <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                                                                    </a>
                                                                    <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" onClick="setmemberInAction(<?php echo $staffsRes['Id'] ?>,'Staff','Quarantine',);" data-placement="top" title="Quarantine" theid="23">
                                                                        <img src="<?php echo base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="New_Staff_List"></div>
                                            <!-- enbd table-responsive-->
                                        </div> <!-- data-sidebar-->
                                    </div><!-- end card-body-->
                                </div> <!-- end card-->
                            </div><!-- end col -->
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">
                                                    <div class="float-right">
                                                        <div class="dropdown">
                                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted" data-toggle="modal" data-target="#myModal"><b>Select Lab Test</b><i class="mdi mdi-chevron-down ml-1"></i></span>
                                                            </a>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                                <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');">TEMPERATURE </li>
                                                                <?php foreach ($list_Tests as $test) { ?>
                                                                    <li class="dropdown-item" onClick="home_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </h4>
                                                <h4 class="card-title mb-4">
                                                    <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;">
                                                    Stay Home(<span id="STAYHOMESHOWTESTNAME">TEMPERATURE</span>) <?php echo $today; ?> <font color=#e13e2b>(Staff, Teachers)</font>
                                                </h4>


                                                <div data-simplebar style="height: 350px;overflow: auto;">
                                                    <div id="simpl_home_list">
                                                        <?php
                                                        $listTeachers = array();
                                                        $today = date("Y-m-d");
                                                        $OurStudens = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
                                                        foreach ($OurStudens as $Teacher) {
                                                            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
                                                            $ID = $Teacher['Id'];
                                                            $Position = $Teacher['Position'];
                                                            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                            AND UserType = 'Student'  AND `Action` = 'Home' ORDER BY `Id` DESC LIMIT 1")->result_array();
                                                            foreach ($getResults_Teacheer as $T_results) {
                                                                $lastReads = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                                AND UserType = 'Student'  ORDER BY `Id` DESC LIMIT 1")->result_array();
                                                                $lastRead = $lastReads[0]['Result'];
                                                                $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
                                                                $listTeachers[] = array(
                                                                    "Username" => $Teachername, "Id" => $ID,
                                                                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                                                                    "Result" => $T_results['Result'], "Creat" => $T_results['Result_Date'],
                                                                    "Class_OfSt" => $this->schoolHelper->teacherClasses($ID , true), "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                                                                );
                                                            }
                                                        } ?>

                                                        <table class="table table-borderless table-centered table-nowrap table_sites ">
                                                            <thead>
                                                                <th> img </th>
                                                                <th> Name </th>
                                                                <th> Date &amp; Time </th>
                                                                <th> Result </th>
                                                                <th> Risk </th>
                                                                <th> Days </th>
                                                                <th> Action </th>
                                                            </thead>
                                                            <tbody>
                                                                <style>
                                                                    .badge {
                                                                        text-align: center;
                                                                    }
                                                                </style>
                                                                <script>
                                                                    var Home_Count_S = <?php echo sizeof($listTeachers); ?>;
                                                                </script>
                                                                <?php foreach ($listTeachers as $TeacherRes) { ?>
                                                                    <?php //print_r($TeacherRes); 
                                                                    ?>
                                                                    <tr>
                                                                        <td style="width: 20px;">
                                                                            <?php
                                                                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                                                            ?>
                                                                            <?php if (empty($avatar)) {  ?>
                                                                                <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td>

                                                                            <h6 class="mb-1 font-weight-normal" style="font-size: 15px;"><?php echo $TeacherRes['Username']; ?></h6>
                                                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?php echo $TeacherRes['Class_OfSt']; ?></p>
                                                                        </td>
                                                                        <td style="font-size: 12px;"><?php echo $TeacherRes['LastReadDate']; ?></td>
                                                                        <?php boxes_Colors($TeacherRes['LastRead']); ?>
                                                                        <td>
                                                                            <?php
                                                                            $from_craet = $TeacherRes['Creat'];
                                                                            //echo $from_craet;
                                                                            //$toTime = $today-$from_craet;
                                                                            $finalDate = dateDiffInDays($from_craet, $today);
                                                                            if ($finalDate == 0) {
                                                                                echo "Today";
                                                                            } elseif ($finalDate > 2) {
                                                                                echo $finalDate . " Days";
                                                                            } else {
                                                                                echo $finalDate . " Day";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="out">
                                                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'Student','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit">
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php StayHomeOf('Teacher'); ?>
                                                                <?php StayHomeOf('Staff'); ?>

                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end simpl_home_list  -->
                                                    <div id="New_home_List"></div>
                                                </div> <!-- data-sidebar-->
                                            </div><!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">
                                                    <div class="float-right">
                                                        <div class="dropdown">
                                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted" data-toggle="modal" data-target="#myModal"><b>Select Lab Test</b><i class="mdi mdi-chevron-down ml-1"></i></span>
                                                            </a>
                                                            <style>
                                                                .dropdown-menu * {
                                                                    cursor: pointer;
                                                                }
                                                            </style>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                                <li class="dropdown-item" onclick="Tempratur_List('#simpl_quarantin_list','.New_quarantin_List');">TEMPERATURE </li>
                                                                <?php foreach ($list_Tests as $test) { ?>
                                                                    <li class="dropdown-item" onClick="quarntine_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </h4>
                                                <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Quarantine (<span id="STAYQuarantineNOSHOWTESTNAME">TEMPERATURE</span>) <?php echo $today; ?> <font color=#e13e2b> (Staff, Teachers)</font>
                                                </h4>

                                                <div data-simplebar style="height: 350px;overflow: auto;">
                                                    <div id="simpl_quarantin_list">
                                                        <?php
                                                        $today = date("Y-m-d");
                                                        $listTeachers = array();
                                                        $today = date("Y-m-d");
                                                        $OurTeachers = $this->db->query("SELECT `l2_student`.* , `r_levels`.`Class_ar` AS StudentClass 
                                                        FROM `l2_student`
                                                        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                                                        WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                                                        foreach ($OurTeachers as $Teacher) {
                                                            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
                                                            $ID = $Teacher['Id'];
                                                            $Position = $Teacher['Position'];

                                                            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                            AND UserType = 'Student' AND `Action` = 'Quarantine' ORDER BY `Id` DESC LIMIT 1")->result_array();
                                                            foreach ($getResults_Teacheer as $T_results) {
                                                                $lastReads = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                                AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1")->result_array();
                                                                $lastRead = $lastReads[0]['Result'];
                                                                $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
                                                                $listTeachers[] = array(
                                                                    "Username" => $Teachername, "Id" => $ID, "TestId" => $T_results['Id'],
                                                                    "Testtype" => $T_results['Device_Test'], "Result" => $T_results['Result'],
                                                                    "Creat" => $T_results['Result_Date'], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
                                                                    "Class_OfSt_q" => $Teacher['StudentClass']
                                                                );
                                                            }
                                                        }

                                                        ?>


                                                        <table class="table table-borderless table-centered table-nowrap table_sites ">
                                                            <thead>
                                                                <th>img</th>
                                                                <th> Name </th>
                                                                <th> Date &amp; Time </th>
                                                                <th> Result </th>
                                                                <th> Risk </th>
                                                                <th> Days </th>
                                                                <th> Action </th>
                                                            </thead>
                                                            <tbody>
                                                                <style>
                                                                    .badge {
                                                                        text-align: center;
                                                                    }
                                                                </style>
                                                                <?php foreach ($listTeachers as $TeacherRes) { ?>
                                                                    <?php //print_r($TeacherRes); 
                                                                    ?>
                                                                    <tr>
                                                                        <td style="width: 20px;">
                                                                            <?php
                                                                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                                                            ?>
                                                                            <?php if (empty($avatar)) {  ?>
                                                                                <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                            <h6 class="mb-1 font-weight-normal" style="font-size: 15px;"><?php echo $TeacherRes['Username']; ?></h6>
                                                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?php echo $TeacherRes['Class_OfSt_q']; ?></p>
                                                                        </td>
                                                                        <td style="font-size: 12px;"><?php echo $TeacherRes['LastReadDate']; ?></td>
                                                                        <?php boxes_Colors($TeacherRes['LastRead']); ?>
                                                                        <td>
                                                                            <?php
                                                                            $from_craet = $TeacherRes['Creat'];
                                                                            //echo $from_craet;
                                                                            //$toTime = $today-$from_craet;
                                                                            $finalDate = dateDiffInDays($from_craet, $today);
                                                                            if ($finalDate == 0) {
                                                                                echo "Today";
                                                                            } elseif ($finalDate > 2) {
                                                                                echo $finalDate . " Days";
                                                                            } else {
                                                                                echo $finalDate . " Day";
                                                                            }
                                                                            ?>
                                                                        </td>

                                                                        <td class="out">
                                                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'Student','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit">
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php StayHomeOfQuarantin('Teacher');  ?>
                                                                <?php StayHomeOfQuarantin('Staff'); ?>

                                                            </tbody>
                                                        </table>
                                                    </div> <!-- enbd table-responsive-->
                                                    <div class="New_quarantin_List"></div>
                                                </div>
                                            </div> <!-- data-sidebar-->
                                        </div><!-- end card-body-->
                                    </div> <!-- end card-->
                                </div><!-- end col -->
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;">Daily Lab Tests List <?php echo $today; ?> <font color=#e13e2b> (Sites)</font>
                                        </h4>

                                        <table class="table table_sites">
                                            <thead>
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>Device ID</th>
                                                    <th>Site Name</th>
                                                    <th>Date &amp; Time</th>
                                                    <th>Batch No</th>
                                                    <th>Test Type</th>
                                                    <th>Result</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php GetListOfSites($list_Tests); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;"> Lab Tests Sites List <font color=#e13e2b> (Closed Sites for Decontamination)</font>
                                        </h4>
                                        <table class="table table_sites">
                                            <thead>
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>Device ID</th>
                                                    <th>Site Name</th>
                                                    <th>Date &amp; Time</th>
                                                    <th>Batch No</th>
                                                    <th>Test Type</th>
                                                    <th>Result</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php GetListOfSites_InCleaning($list_Tests); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div> <!-- container-fluid -->

                </div>
                <div id="return"></div>
                <!-- End Page-content -->
            </div>
        </div>
    </div>
</body>

<!-- apexcharts -->
<script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script>
    try {
        $(".table_sites").DataTable();
    } catch (err) {
        console.log("Error " + err);
    }

    <?php


    ?>
    try {
        options = {
            chart: {
                height: 339,
                type: "line",
                stacked: !1,
                toolbar: {
                    show: !1
                }
            },
            stroke: {
                width: [0, 2, 4],
                curve: "smooth"
            },
            plotOptions: {
                bar: {
                    columnWidth: "30%"
                }
            },
            colors: ["#5b73e8", "#f1b44c"],
            series: [{
                name: "School",
                type: "column",
                data: [<?php foreach ($studentsCount as $count) {
                            echo $count['Count'] . ',';
                        } ?>]

            }, {
                name: "Total Student Tested",
                type: "line",
                data: [<?php foreach ($studentsCount as $countResult) {
                            echo $countResult['Results'] . ',';
                        } ?>]
            }],
            fill: {
                //opacity: [.85, .25, 1],
                gradient: {
                    inverseColors: !1,
                    shade: "light",
                    type: "vertical",
                    opacityFrom: .85,
                    opacityTo: .55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: [<?php foreach ($studentsCount as $schoolName) {
                            echo '"' . $schoolName['name'] . '",';
                        } ?>],
            markers: {
                size: 0
            },
            yaxis: {
                title: {
                    text: "Points"
                }
            },
            tooltip: {
                shared: !0,
                intersect: !1,
                y: {
                    formatter: function(e) {
                        return void 0 !== e ? e.toFixed(0) + " points" : e
                    }
                }
            },
            grid: {
                borderColor: "#f1f1f1"
            },
            labels: {
                show: !1,
                formatter: function(e) {
                    return e + "%"
                }
            },
        };
        (chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options)).render();
    } catch (err) {
        console.log("Error " + err);
    }


    function GetStaffChart() {
        $('#SelectTheClassCard').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/ChartofTempForStaff',
            beforeSend: function() {
                $('#drawChart').html('');
                $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#drawChart').removeAttr('disabled', '');
                $('#drawChart').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    }

    function GetTeacherChart() {
        $('#SelectTheClassCard').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/ChartofTempForTeacher',
            beforeSend: function() {
                $('#drawChart').html('');
                $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#drawChart').removeAttr('disabled', '');
                $('#drawChart').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    }

    function GetStudentChart() {
        $('#drawChart').html("");
        $('#SelectTheClassCard').slideDown();
    }

    $("#SelectFromClass").change(function() {
        var selectedclass = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Schools/ChartTempOfClass',
            data: {
                NumberOfClass: selectedclass,
            },
            beforeSend: function() {
                // setting a timeout
                $("#drawChart").html('Please Wait.....');
            },
            success: function(data) {
                $('#drawChart').html("");
                $('#drawChart').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                )
            }
        });
    });

    function GetTheStaffResults() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/ListResultsOfStaffs',
            beforeSend: function() {
                $('#ResultsTable').html('');
                $('#ResultsTable').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#ResultsTable').removeAttr('disabled', '');
                $('#ResultsTable').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    }

    function GetTheTeacherResults() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/ListResultsOfTeachers',
            beforeSend: function() {
                $('#ResultsTable').html('');
                $('#ResultsTable').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#ResultsTable').removeAttr('disabled', '');
                $('#ResultsTable').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    }

    function GetTheStudentsResultsForClass(className) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/ListResultsOfDtudents',
            data: {
                class: className,
            },
            beforeSend: function() {
                $('#ResultsTableStudents').html('');
                $('#ResultsTableStudents').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#ResultsTableStudents').removeAttr('disabled', '');
                $('#ResultsTableStudents').html(data);
            },
            ajaxError: function() {
                $('#ResultsTableStudents').css('background-color', '#DB0404');
                $('#ResultsTableStudents').html("Ooops! Error was found.");
            }
        });
    }

    function ConnectedWithClass(className) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/ListConnectedTeachers',
            data: {
                class: className,
            },
            beforeSend: function() {
                $('#TeachersCon').html('');
                $('#TeachersCon').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#TeachersCon').removeAttr('disabled', '');
                $('#TeachersCon').html(data);
            },
            ajaxError: function() {
                $('#TeachersCon').css('background-color', '#DB0404');
                $('#TeachersCon').html("Ooops! Error was found.");
            }
        });
    }

    function setmemberInAction(id, usertype, action) {
        var theId = id;
        Swal.fire({
            title: ' Are you sure you want to do this action?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes, I am sure!`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Schools/ApplyActionOnMember',
                    data: {
                        S_Id: theId,
                        Action: action,
                        UserType: usertype,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            }
        });
    }

    function SET_SiteInAction(id) {
        var theId = id;
        Swal.fire({
            title: ' Are you sure you want to do this action?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes, I am sure!`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Ajax/Set_ActiononSite',
                    data: {
                        S_Id: theId,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            }
        });
    }

    function Remove_SiteFromAction(id) {
        var theId = id;
        Swal.fire({
            title: ' Are you sure you want to do this action?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes, I am sure!`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Ajax/Remove_ActiononSite',
                    data: {
                        S_Id: theId,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            }
        });
    }

    function RemoveThisMemberFrom(id, usertype, action) {
        var theId = id;
        console.log(theId);

        Swal.fire({
            title: ' Sure You Want Do This Action  ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes, I am sure!`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Schools/ApplyActionOnMember',
                    data: {
                        S_Id: theId,
                        Action: action,
                        UserType: usertype,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            }
        });
    }

    function RemoveThisMemberFrom_lab(id, usertype, action) {
        var theId = id;
        console.log(theId);

        Swal.fire({
            title: ' Sure You Want Do This Action  ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes, I am sure!`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Schools/ApplyLabActionOnMember_lab',
                    data: {
                        S_Id: theId,
                        Action: action,
                        UserType: usertype,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            }
        });
    }

    function Get_plus_minus(type) {
        //alert('The '+type);
        $('#TempCounters').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Results/GetResultsCounterFor',
            data: {
                TeatsType: type,
            },
            success: function(data) {
                $('#Plus_Minus').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    function Tempratur() {
        $('#Plus_Minus').html('');
        $('#TempCounters').slideDown();
    }

    function Tempratur_students() {
        $('.New_Select').html("");
        $('.New_Data').html("");
        $('#ResultsTableStudents').slideDown();
        $('.classes_temp').show();
    }

    function Tempratur_List(id, emp) {
        if (id == '#simpl_home_list' && emp == '#New_home_List') {
            $('#STAYHOMESHOWTESTNAME').html('TEMPERATURE ');
        } else if (id == '#simpl_quarantin_list' && emp == '.New_quarantin_List') {
            $('#STAYQuarantineNOSHOWTESTNAME').html('TEMPERATURE ');
        } else if (id == '#simpl_staff_list' && emp == '#New_Staff_List') {
            $('#STAFFSNOSHOWTESTNAME').html('TEMPERATURE ');
        } else if (id == '#simpl_Teacher_list' && emp == '#New_Teacher_List') {
            $('#TEACHERSSNOSHOWTESTNAME').html('TEMPERATURE ');
        }

        $(id).slideDown();
        $(emp).html('');
    }

    function Get_plus_minus_students(type) {
        $('#ResultsTableStudents').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/ajax/GetClassesList',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('.New_Select').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
        $('.classes_temp').hide();
    }

    function staff_labTests(type) {
        $('#STAFFSNOSHOWTESTNAME').html(type);
        $('#simpl_staff_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/ajax/Get_Staffs_List',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Staff_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }

    function quarntine_labTests(type) {
        $('#STAYQuarantineNOSHOWTESTNAME').html(type);
        $('#simpl_quarantin_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/ajax/Get_Quaranrine_List',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('.New_quarantin_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }
    //simpl_home_list

    function home_labTests(type) {
        $('#STAYHOMESHOWTESTNAME').html(type);
        $('#simpl_home_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/ajax/Get_home_List',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_home_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }


    function Teacher_labTests(type) {
        $('#TEACHERSSNOSHOWTESTNAME').html(type);
        $('#simpl_Teacher_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/ajax/Get_Teachers_List',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Teacher_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }
</script>

<?php

function StayHomeOf($type)
{
    $ci = &get_instance();
    $count_home = 0;
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
    if ($type == "Teacher") {
        $ours = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
    } else {
        $ours = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
    }

    $listTeachers = array();
    $today = date("Y-m-d");
    foreach ($ours as $Teacher) {
        $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
        $ID = $Teacher['Id'];
        $Position = $Teacher['Position'];

        $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "'  AND `Action` = 'Home' ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($getResults_Teacheer as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
            $listTeachers[] = array(
                "Username" => $Teachername, "Id" => $ID,
                "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Result_Date'],
                "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
            );
        }
    } ?>
    <style>
        .badge {
            text-align: center;
        }
    </style>
    <?php
    $count_home += sizeof($listTeachers);
    foreach ($listTeachers as $TeacherRes) { ?>
        <?php //print_r($TeacherRes); 
        ?>
        <tr>
            <td style="width: 20px;">
                <?php
                $avatar = $ci->db->query("SELECT * FROM `l2_avatars`
          WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                ?>
                <?php if (empty($avatar)) {  ?>
                    <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                <?php } ?>
            </td>
            <td>
                <h6 class="mb-1 font-weight-normal" style="font-size: 15px;"><?php echo $TeacherRes['Username']; ?></h6>
                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?php echo $TeacherRes['Class_OfSt']; ?></p>
            </td>
            <td style="font-size: 12px;">
                <?php echo $TeacherRes['LastReadDate']; ?>
            </td>
            <?php boxes_Colors($TeacherRes['LastRead']); ?>
            <td>
                <?php
                $from_craet = $TeacherRes['Creat'];
                //echo $from_craet;
                //$toTime = $today-$from_craet;
                $finalDate = dateDiffInDays($from_craet, $today);
                if ($finalDate == 0) {
                    echo "Today";
                } elseif ($finalDate > 2) {
                    echo $finalDate . " Days";
                } else {
                    echo $finalDate . " Day";
                }
                ?>
            </td>
            <td class="out">
                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'<?php echo $type ?>','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit">
            </td>
        </tr>

    <?php } ?>
    <script>
        var count_home_f = <?php echo $count_home; ?>;
        console.log(count_home_f);
        $('#Stay_Counter').html(count_home_f + Home_Count_S);
    </script>
<?php
}

function dateDiffInDays($date1, $date2)
{
    // Calculating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1);

    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400));
}


function StayHomeOfQuarantin($type)
{
    $ci = &get_instance();
    $count = 0;
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
    if ($type == "Teacher") {
        $ours = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
    } else {
        $ours = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
    }

    $listTeachers = array();
    $today = date("Y-m-d");
    foreach ($ours as $Teacher) {
        $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
        $ID = $Teacher['Id'];
        $Position = $Teacher['Position'];
        $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "'  AND `Action` = 'Quarantine' ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($getResults_Teacheer as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
            $listTeachers[] = array(
                "Username" => $Teachername, "Id" => $ID,
                "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Result_Date'],
                "Class_OfSt" => $Position,
                "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
            );
        }
    } ?>
    <style>
        .badge {
            text-align: center;
        }
    </style>
    <?php
    foreach ($listTeachers as $TeacherRes) { ?>
        <?php //print_r($TeacherRes); 
        ?>
        <tr>
            <td style="width: 20px;">
                <?php
                $avatar = $ci->db->query("SELECT * FROM `l2_avatars`
          WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                ?>
                <?php if (empty($avatar)) {  ?>
                    <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                <?php } ?>
            </td>
            <td>
                <h6 class="mb-1 font-weight-normal" style="font-size: 15px;"><?php echo $TeacherRes['Username']; ?></h6>
                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?php echo $TeacherRes['Class_OfSt']; ?></p>
            </td>
            <td style="font-size: 12px;">
                <?php echo $TeacherRes['LastReadDate']; ?>
            </td>
            <?php boxes_Colors($TeacherRes['LastRead']); ?>
            <td>
                <?php
                $from_craet = $TeacherRes['Creat'];
                //echo $from_craet;
                //$toTime = $today-$from_craet;
                $finalDate = dateDiffInDays($from_craet, $today);
                if ($finalDate == 0) {
                    echo "Today";
                } elseif ($finalDate > 2) {
                    echo $finalDate . " Days";
                } else {
                    echo $finalDate . " Day";
                }
                ?>
            </td>
            <td class="out">
                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'<?php echo $type ?>','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit">
            </td>
        </tr>

    <?php }
}


function GetListOfSites($list_Tests)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Site_Code` ASC ")->result_array();
    foreach ($list_Tests as $test) {
        get_site_of_test($sitesForThisUser, $test['Test_Desc']);
    }
    //print_r($sitesForThisUser);
}


function get_site_of_test($sitesForThisUser, $testType)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    foreach ($sitesForThisUser as $site) {
        $name = $site['Description'];
        $ID = $site['Id'];
        $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND 
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
        //print_r($getResults);
        foreach ($getResults as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
            //if(!empty($lastRead)){
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
            $listSites[] = array(
                "name" => $name, "Id" => $ID,
                "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                "Device_ID" =>  $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action']
            );
            //}	
        }
    }
    ///print_r($listSites);
    foreach ($listSites as $siteResult) { ?>
        <tr>
            <td><?php echo $siteResult['TestId'] ?></td>
            <td><?php echo $siteResult['Device_ID'] ?></td>
            <td><?php echo $siteResult['name'] ?></td>
            <td><?php echo $siteResult['LastReadDate'] ?></td>
            <td><?php echo $siteResult['Batch'] ?></td>
            <td><?php echo $siteResult['Testtype'] ?></td>
            <?php if ($siteResult['Action'] == "School") { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">positive (+)</span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">Negative (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">positive (+)</span></td>
                <?php } ?>
            <?php } ?>
            <td>
                <?php if ($siteResult['Action'] == "School") { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Close for decontamination">
                <?php } ?>
            </td>
        </tr>
    <?php
    }
}

function get_site_of_test_In($sitesForThisUser, $testType, $action, $date = false)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    if (!$date) {
        foreach ($sitesForThisUser as $site) {
            $name = $site['Description'];
            $ID = $site['Id'];
            $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND `Action` = '" . $action . "' AND
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
            //print_r($getResults);
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                    "Device_ID" =>  $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action']
                );
                //}	
            }
        }
    } else {
        foreach ($sitesForThisUser as $site) {
            $name = $site['Description'];
            $ID = $site['Id'];
            $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
     AND UserType = 'Site' AND `Action` = '" . $action . "' AND
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
            //print_r($getResults);
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                    "Device_ID" =>  $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action']
                );
                //}	
            }
        }
    }
    ///print_r($listSites);
    foreach ($listSites as $siteResult) { ?>
        <tr>
            <td><?php echo $siteResult['TestId'] ?></td>
            <td><?php echo $siteResult['Device_ID'] ?></td>
            <td><?php echo $siteResult['name'] ?></td>
            <td><?php echo $siteResult['LastReadDate'] ?></td>
            <td><?php echo $siteResult['Batch'] ?></td>
            <td><?php echo $siteResult['Testtype'] ?></td>
            <?php if ($siteResult['Action'] == "School") { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #d2d2d2;">positive (+)</span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #008700;color: #ffffff;">Negative (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #B82100;color: #d2d2d2;">positive (+)</span></td>
                <?php } ?>
            <?php } ?>
            <td>
                <?php if ($siteResult['Action'] == "School") { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Close for decontamination">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" alt="Remove" width="20px" onclick="Remove_SiteFromAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Decontamiation Done !">
                <?php } ?>
            </td>
        </tr>
    <?php
    }
}


function GetListOfSites_InCleaning($list_Tests)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Site_Code` ASC ")->result_array();
    foreach ($list_Tests as $test) {
        get_site_of_test_In($sitesForThisUser, $test['Test_Desc'], 'Cleaning', true);
    }
}


function boxes_Colors($result)
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
	<?php if ($result >= 38.500 && $result <= 45.500 ) { ?> 
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
	<?php if ($result >= 38.500 && $result <= 45.500 ) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">High</span>
    <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">Moderate</span>
    <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">No Risk</span>
    <?php } elseif ($result <= 36.200) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;">Low</span>
    <?php } elseif ($result >= 45.501) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">Error</span>
    <?php } ?>
    </td>

<?php
}


?>