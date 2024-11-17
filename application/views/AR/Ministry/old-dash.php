<!doctype html>
<html lang="en">

<body class="light menu_light logo-white theme-white">
    <style>
        .InfosCards h4,
        .InfosCards p {
            color: #fff;
        }

        .InfosCards .card-body {
            border-radius: 5px;
        }

        .dropdown-item {
            cursor: pointer;
        }

        .apexcharts-legend-text {
            margin: 5px;
        }

        .image_container img {
            margin: auto;
            width: 100%;
            max-width: 800px;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                    </div>
                </div>
                <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 001 - Daily Dashboard for Schools and Departments</h4>
                <div class="row">
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #344267;">
                                <div class="float-right mt-2">
                                    <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="schools">
                                </div>
                                <div>
                                    <?php
                                    $idd = $sessiondata['admin_id'];
                                    $all = $this->db->query("SELECT * FROM `l1_school` WHERE `Added_By` = $idd  AND `status` = '1' ")->num_rows();
                                    $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  AND `status` = '1'
                                    ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $all ?></span></h4>
                                    <p class="mb-0">Schools</p>
                                </div>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php if (!empty($lasts)) { ?>
                                            <?php foreach ($lasts as $last) { ?>
                                                <?= $last['Created'] ?></span><br>
                                    Last registered school
                                <?php } ?>
                            <?php } else { ?>
                                <?= "--/--/--"; ?></span><br>
                                Last registered school
                            <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #605091;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools"> </div>
                                <div>
                                    <?php
                                    $all_ministry = $this->db->query("SELECT * FROM `l1_department`
                                    WHERE Added_By = $idd ")->num_rows();
                                    $lastminED = $this->db->query("SELECT * FROM `l1_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $all_ministry ?></span> </h4>
                                    <p class="mb-0">Departments</p>
                                </div>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php if (!empty($lastminED)) { ?>
                                            <?php foreach ($lastminED as $last) { ?>
                                                <?= $last['Created'] ?></span><br>
                                    Last registered department
                                <?php } ?>
                            <?php } else { ?>
                                <?= "--/--/--" ?></span><br>
                                Last registered department
                            <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #344267;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools"> </div>
                                <div>
                                    <?php
                                    $allDev = 0;
                                    $ListOfThis = array();
                                    $All_added_schools = $this->db->query("SELECT * FROM `l1_school`
                                    WHERE `Added_By` = $idd  AND `status` = '1'")->result_array();
                                    foreach ($All_added_schools as $school) {
                                        $devicesforThis = $this->db->query("SELECT * FROM `l2_devices`
                                        WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($devicesforThis as $dvices) {
                                            $allDev++;
                                            $ListOfThis[] = $dvices["Created"];
                                        }
                                    }
                                    $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  AND `status` = '1'
                                    ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allDev ?></span></h4>
                                    <p class="mb-0">Devices</p>
                                </div>
                                <?php if (!empty($ListOfThis)) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= $ListOfThis[0]; ?></span><br>
                                        Last registered device </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered device </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #605091;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/temperature_counter.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $all_TestsForThis = $this->db->query("SELECT * FROM `l0_systemtwithtest`
                                    WHERE SystemId = $idd ")->num_rows();
                                    $lastminED = $this->db->query("SELECT * FROM `l0_systemtwithtest` WHERE SystemId = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $Total_tests;  ?></span> </h4>
                                    <p class="mb-0">Laboratory Tests</p>
                                </div>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php
                                        if (!empty($test)) {
                                            asort($test);
                                        ?>
                                            <?= $test[0][0];  ?></span><br>
                                    Last registered lab test
                                <?php } else { ?>
                                    <?= "--/--/--"; ?></span><br>
                                    Last registered lab test
                                <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #F25C69;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $allStaffs = 0;
                                    $ListOfThisStaff = array();
                                    $All_added_schools = $this->db->query("SELECT * FROM `l1_school`
                                    WHERE `Added_By` = $idd  AND `status` = '1' ")->result_array();
                                    foreach ($All_added_schools as $school) {
                                        $staffsForThis = $this->db->query("SELECT * FROM `l2_staff`
                                        WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($staffsForThis as $Staff) {
                                            $allStaffs++;
                                            $ListOfThisStaff[] = $Staff["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    ?>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allStaffs ?></span></h4>
                                    <p class="mb-0"> Staff </p>
                                </div>
                                <?php if (!empty($ListOfThisStaff)) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= $ListOfThisStaff[0] ?></span><br>
                                        Last registered staff </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered staff </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #2E338C;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/countersteachers.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $allTeacher = 0;
                                    $ListOfTeacherforThis = array();
                                    $All_added_schools = $this->db->query("SELECT * FROM `l1_school`
                                    WHERE `Added_By` = $idd  AND `status` = '1' ")->result_array();
                                    foreach ($All_added_schools as $school) {
                                        $TeachersforThis = $this->db->query("SELECT * FROM `l2_teacher`
                                        WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($TeachersforThis as $Teachers) {
                                            $allTeacher++;
                                            $ListOfTeacherforThis[] = $Teachers["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    $lasts = $this->db->query("SELECT * FROM `l1_school` 
                                    WHERE `Added_By` = $idd  AND `status` = '1' ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $allTeacher ?></span> </h4>
                                    <p class="mb-0">Teachers</p>
                                </div>
                                <?php if (!empty($ListOfTeacherforThis)) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= $ListOfTeacherforThis[0] ?></span><br>
                                        Last registered teacher </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered teacher </p>
                                <?php  } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #364692;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterstudents.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $allStudents = 0;
                                    $ListOfStudentsforThis = array();
                                    foreach ($All_added_schools as $school) {
                                        $StudentsforThis = $this->db->query("SELECT * FROM `l2_student`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($StudentsforThis as $Studants) {
                                            $allStudents++;
                                            $ListOfStudentsforThis[] = $Studants["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd   AND `status` = '1'
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $allStudents ?></span> </h4>
                                    <p class="mb-0">Students</p>
                                </div>
                                <?php if (!empty($ListOfStudentsforThis)) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= $ListOfStudentsforThis[0] ?></span><br>
                                        Last registered student </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered student</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #694811;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $allSites = 0;
                                    $ListOfSitesforThis = array();
                                    /*$All_added_schools = $this->db->query("SELECT * FROM `l1_school`
               WHERE `Added_By` = $idd ")->result_array();*/
                                    foreach ($All_added_schools as $school) {
                                        $SitesforThis = $this->db->query("SELECT * FROM `l2_site`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($SitesforThis as $Sites) {
                                            $allSites++;
                                            $ListOfSitesforThis[] = $Sites["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  AND `status` = '1'
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $allSites ?></span> </h4>
                                    <p class="mb-0">Sites</p>
                                </div>
                                <?php if (!empty($ListOfSitesforThis)) { ?>
                                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> <?= $ListOfSitesforThis[0] ?> </span><br>
                                        Last registered site </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered site </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row-->
                <?php if ($temperatureandlabs) { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 002 - Daily Dashboard - Counter Results for All Schools</h4>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if ($temperatureandlabs) { ?>
                        <div class="col-xl-<?= $temperatureandlabs ? "9" : "12" ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="position: relative;min-height: 490px;">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Lab Test Results Counter: <?= $today; ?></h4>
                                            <div id="chart"></div>
                                            <div class="col-lg-12 text-center">
                                                <p>(Students - Staff - Teachers)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($temperatureandlabs) { ?>
                        <div class="<?= $temperatureandlabs ? "col-xl-3" : "row w-100" ?>">
                            <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
                                <div class="card">
                                    <div class="card-body" style="padding: 0px;border: 6px solid #387cea;">
                                        <div class="card-body badge-soft-info">
                                            <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Blue.png" alt="Temperature" style="width: 30px;margin-top: -12px;"> </div>
                                            <div class="col-lg-10">
                                                <h4 class="mb-1 mt-1" style="color: #033067;"> <span data-plugin="counterup"><?= $LOW ?> </span> </h4>
                                                <p class="mb-0" style="color: #033067;"> Low Temperature </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center alerts_count">
                                <div class="card">
                                    <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
                                        <div class="card-body badge-soft-success">
                                            <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;"> </div>
                                            <div class="col-xl-10">
                                                <h4 class="mb-1 mt-1" style="color: #044300;"><span data-plugin="counterup"><?= $NORMAL; ?></span></h4>
                                                <p class="mb-0" style="color: #044300;"> Normal Temperature </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
                                <div class="card">
                                    <div class="card-body" style="padding: 0px;border: 6px solid #FF9600;">
                                        <div class="card-body badge-soft-warning">
                                            <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/orange.png" alt="Temperature" style="width: 30px;"> </div>
                                            <div class="col-xl-10">
                                                <h4 class="mb-1 mt-1" style="color: #674403;"> <span data-plugin="counterup"><?= $MODERATE ?></span> </h4>
                                                <p class="mb-0" style="color: #674403;"> Moderate Temperature</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
                                <div class="card">
                                    <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
                                        <div class="card-body badge-soft-danger">
                                            <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/red.png" alt="Temperature" style="width: 30px;"> </div>
                                            <div class="col-xl-10">
                                                <h4 class="mb-1 mt-1"> <span data-plugin="counterup" style="color: #670303;"><?= $HIGH ?></span> </h4>
                                                <p class="mb-0" style="color: #670303;"> High Temperature </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 003 - Stay Home Counter Results for All Schools</h4>
                        </div>
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">
                                                <div class="float-right">
                                                    <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted" data-toggle="modal" data-target="#myModal">Select Test <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                            <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');"> Temperature </li>
                                                            <?php foreach ($list_Tests as $test) { ?>
                                                                <li class="dropdown-item" onClick="home_labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                Stay Home (<span id="STAYHOMESHOWTESTNAME">Temperature</span>)
                                            </h4>
                                            <div data-simplebar style="height: 385px;overflow: auto;">
                                                <div id="simpl_home_list">
                                                    <?php Get_SchoolsData('Home'); ?>
                                                </div>
                                                <div id="New_home_List"> </div>
                                            </div>
                                            <!-- data-sidebar-->
                                        </div>
                                        <!-- end card-body-->
                                    </div>
                                    <!-- end card-->
                                </div>
                                <!-- end col -->
                                <div class="col-12">
                                    <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 004 - Quarantine Counter Results for All Schools</h4>
                                </div>
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">
                                                <div class="float-right">
                                                    <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted" data-toggle="modal" data-target="#myModal">Select Test <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                            <li class="dropdown-item" onclick="Tempratur_List('#simpl_Quaran_list','#New_Quaran_List');"> Temperature </li>
                                                            <?php foreach ($list_Tests as $test) { ?>
                                                                <li class="dropdown-item" onClick="quarnt_labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                Quarantine (<span id="SQUAROMESHOWTESTNAME"> Temperature</span>)
                                            </h4>
                                            <div data-simplebar style="height: 385px;overflow: auto;">
                                                <div id="simpl_Quaran_list">
                                                    <?php Get_SchoolsData('Quarantine'); ?>
                                                </div>
                                                <div id="New_Quaran_List"></div>
                                            </div>
                                            <!-- data-sidebar-->
                                        </div>
                                        <!-- end card-body-->
                                    </div>
                                    <!-- end card-->
                                </div>
                                <div class="col-xl-6">
                                    <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 005 - Stay Home Counter Results for All Schools</h4>
                                    <div class="card" style="border-color: #0eacd8;">
                                        <div class="card-body" style="min-height: 465px;text-align: center;background: radial-gradient(rgb(14 172 216 / 18%), rgb(14 172 216 / 39%));">
                                            <h5 class="m-0"> <span style="color:#0eacd8;text-align:center;"> Stay Home </span> </h5>
                                            <?php
                                            $list_schools_high = array();
                                            //print_r($our_schools); 
                                            foreach ($our_schools as $school) {
                                                $high = 0;
                                                $high += Get_CounterForThisType_Ministry($school['Id'], "Student", "Home");
                                                $high += Get_CounterForThisType_Ministry($school['Id'], "Teacher", "Home");
                                                $high += Get_CounterForThisType_Ministry($school['Id'], "Staff", "Home");
                                                if ($high !== 0) {
                                                    $list_schools_high[] = array("School_Name" => $school['School_Name_EN'], "Counter" => $high);
                                                }
                                            }
                                            ?>
                                            <?php //print_r($list_schools_high); 
                                            if (!empty($list_schools_high)) {
                                            ?>
                                                <table style="width: 100%;">
                                                    <?php foreach ($list_schools_high as $schools_high) { ?>
                                                        <tr>
                                                            <td style="text-align: left;" class="text-truncate"><?= $schools_high['School_Name']; ?></td>
                                                            <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?= $schools_high['Counter']; ?></span></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php } else { ?>
                                                <div style="min-height: 409px;display: grid;align-content: center;align-items: center;">
                                                    <div class="text-center">
                                                        <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                                                        <p class="font-16 text-muted mb-2"></p>
                                                        <h5><a href="#" class="text-dark"> No Data </a></h5>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 006 - Quarantine Counter Results for All Schools</h4>
                                    <div class="card" style="border-color: #F44336;">
                                        <div class="card-body" style="min-height: 465px;text-align: center;background: radial-gradient(rgb(216 14 14 / 18%), rgb(247 204 204 / 39%));">
                                            <h5 class="m-0"> <span style="color:#ff2e00;text-align:center;"> Quarantine </h5>
                                            <?php
                                            $list_schools_high_q = array();
                                            $our_schools = $this->db->query("SELECT 
                                            `School_Name_EN`,`Id` FROM `l1_school` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'
                                            AND `status` = '1' ORDER BY `Id` DESC ")->result_array();
                                            //print_r($our_schools); 
                                            foreach ($our_schools as $school) {
                                                $high = 0;
                                                $high += Get_CounterForThisType_Ministry($school['Id'], "Student", "Quarantine");
                                                $high += Get_CounterForThisType_Ministry($school['Id'], "Teacher", "Quarantine");
                                                $high += Get_CounterForThisType_Ministry($school['Id'], "Staff", "Quarantine");
                                                if ($high !== 0) {
                                                    $list_schools_high_q[] = array("School_Name" => $school['School_Name_EN'], "Counter" => $high);
                                                }
                                            }
                                            ?>
                                            <?php //print_r($list_schools_high); 
                                            if (!empty($list_schools_high_q)) {
                                            ?>
                                                <table style="width: 100%;">
                                                    <?php foreach ($list_schools_high_q as $schools_high_q) { ?>
                                                        <tr>
                                                            <td style="text-align: left;" class="text-truncate"><?= $schools_high_q['School_Name']; ?></td>
                                                            <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?= $schools_high_q['Counter']; ?></span></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php } else { ?>
                                                <div style="min-height: 409;display: grid;align-content: center;align-items: center;">
                                                    <div class="text-center">
                                                        <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                                                        <p class="font-16 text-muted mb-2"></p>
                                                        <h5><a href="#" class="text-dark"> No Data </a></h5>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($temperatureandlabs) { ?>
                                <div class="col-12">
                                    <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
                                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 007 - Site Counter Results for All Schools</h4>
                                </div>
                                <div class="col-lg-12" style="padding-right: 0px;">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">
                                                    <div class="float-right">
                                                        <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">Select Test <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                                <?php foreach ($list_Tests as $test) { ?>
                                                                    <li class="dropdown-item" onClick="sites_lab('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    List of Sites (<span id="sites_showType">--</span>)
                                                </h4>
                                                <div id="">
                                                    <table class="table Lab_Table" style="width: 100%;">
                                                        <thead>
                                                            <th>#</th>
                                                            <th class="text-center">Site Name </th>
                                                            <th class="text-center">Positive</th>
                                                            <th class="text-center">Negative</th>
                                                            <th class="text-center">Sterilization</th>
                                                        </thead>
                                                        <tbody id="table_sites_data">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
</body>
<!-- apexcharts -->
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script>
    $('.Table_Data').DataTable();
    var Chart_Options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: !0,
            formatter: function(e) {
                return e
            },
            offsetY: -20,
            style: {
                fontSize: "12px",
                colors: ["#FFFFFF"]
            }
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "    All   ",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc']) . ",";
                    } ?>]
        }, {
            name: "   Negative      ",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc'], '0') . ",";
                    } ?>]
        }, {
            name: "    Positive   ",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc'], '1') . ",";
                    } ?>]
        }],
        colors: ["#5b73e8", "#34c38f", "#C3343C"],
        xaxis: {
            categories: [<?php foreach ($list_Tests as $test) {
                                echo "'" . $test['Test_Desc'] . "',";
                            } ?>]
        },
        yaxis: {
            title: {
                text: "all tests"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(e) {
                    if (e >= 1000) {
                        var th = e.slice(0, 1);
                        return th + "thousnd"
                    } else {
                        return e
                    }
                }
            }
        }
    };
    chart = new ApexCharts(document.querySelector("#chart"), Chart_Options);
    chart.render();
</script>
<script>
    var myoptions = {
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 20, 36, 40, 54]
        }],
        fill: {
            colors: ["#FFF56B"]
        },
        chart: {
            type: "bar",
            width: 70,
            height: 40,
            sparkline: {
                enabled: !0
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "50%"
            }
        },
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            }
        },
        tooltip: {
            fixed: {
                enabled: !1
            },
            x: {
                show: !1
            },
            y: {
                title: {
                    formatter: function(e) {
                        return ""
                    }
                }
            },
            marker: {
                show: !1
            }
        }
    }
    chart1 = new ApexCharts(document.querySelector("#CharTTest1"), myoptions);
    chart1.render();
    var options = {
        fill: {
            colors: ["#34c38f"]
        },
        series: [70],
        chart: {
            type: "radialBar",
            width: 45,
            height: 45,
            sparkline: {
                enabled: !0
            }
        },
        dataLabels: {
            enabled: !1
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "60%"
                },
                track: {
                    margin: 0
                },
                dataLabels: {
                    show: !1
                }
            }
        }
    }

    function Tempratur_List(id, emp) {
        if (id == '#simpl_home_list' && emp == '#New_home_List') {
            $('#STAYHOMESHOWTESTNAME').html('TEMPERATURE');
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

    function home_labTests(type) {
        $('#STAYHOMESHOWTESTNAME').html(type);
        $('#simpl_home_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/ajax/Get_home_List_Ministry',
            data: {
                IN: 'Home',
                TestDesc: type,
            },
            success: function(data) {
                $('#New_home_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }

    function quarnt_labTests(type) {
        $('#SQUAROMESHOWTESTNAME').html(type);
        $('#simpl_Quaran_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/ajax/Get_home_List_Ministry',
            data: {
                IN: 'Home',
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Quaran_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }

    function sites_lab(type) {
        $('#sites_showType').html(type);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/ajax/sites_data_table',
            data: {
                TestName: type,
            },
            success: function(data) {
                $('#table_sites_data').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }
</script>
<style>
    .Img_School {
        width: 30px !important;
    }

    .Risk {
        width: 100px !important;
    }

    th,
    td {
        text-align: center;
    }
</style>
<?php
function Get_SchoolsData($in)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
?>
    <table class="table Table_Data" style="column-width: auto;">
        <thead>
            <th class="Img_School" style="width: 10%;" width="5%">Img</th>
            <th width="30%">School Name</th>
            <th style="color: #cdfc00;width: 10%;" width="10%;">Low</th>
            <th class="Risk" style="color: #00ab00;" width="10%;">No Risk</th>
            <th style="color: #ff8200;width: 10%;" width="10%;">Moderate</th>
            <th style="color: #ff2e00;width: 10%;" width="10%;">High</th>
            <th style="color: #0F0F0F;width: 10%;" width="10%;">Error</th>
            <th style="color: #50a5f1;width: 10%;" width="10%;">Total</th>
        </thead>
        <tbody>
            <?php
            $List = array();
            //echo is_numeric($counter);    
            $our_schools = $ci->db->query("SELECT 
            `School_Name_EN`,`Id` FROM `l1_school` WHERE
            `Added_By` = '" . $sessiondata['admin_id'] . "' AND `status` = '1'
            ORDER BY `Id` DESC ")->result_array();
            //print_r($our_schools); 
            foreach ($our_schools as $school) {
                $counter = 0;
                $counter_low = 0;
                $counter_high = 0;
                $counter_noRisk = 0;
                $counter_Error = 0;
                $counter_Moderate = 0;
                /*$Results = $ci->db->query("SELECT * FROM `l2_result` WHERE 
		`UserType` = '".$type."'  AND `UserId` = '".$user['Id']."' 
		AND `Action` = '".$action."' AND `Result` >= '".$from."' AND `Result` <= '".$to."' LIMIT 1 ")->num_rows();
       $counter += $Results;*/
                //echo "---".$school['Id']."<br>";
                if (Get_CounterForThisType_Ministry($school['Id'], "Student", $in) !== 0) {
                    $counter += Get_CounterForThisType_Ministry($school['Id'], "Student", $in);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in) !== 0) {
                    $counter += Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Staff", $in) !== 0) {
                    $counter += Get_CounterForThisType_Ministry($school['Id'], "Staff", $in);
                }
                // low
                if (Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 0, 36.20) !== 0) {
                    $counter_low += Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 0, 36.20);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 0, 36.20) !== 0) {
                    $counter_low += Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 0, 36.20);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 0, 36.20) !== 0) {
                    $counter_low += Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 0, 36.20);
                }
                // high
                if (Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 38.50, 45.00) !== 0) {
                    $counter_high += Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 38.50, 45.00);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 38.50, 45.00) !== 0) {
                    $counter_high += Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 38.50, 45.00);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 38.50, 45.00) !== 0) {
                    $counter_high += Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 38.50, 45.00);
                }
                // noRisk
                if (Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 36.3, 37.5) !== 0) {
                    $counter_noRisk += Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 36.3, 37.5);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 36.3, 37.5) !== 0) {
                    $counter_noRisk += Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 36.3, 37.5);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 36.3, 37.5) !== 0) {
                    $counter_noRisk += Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 36.3, 37.5);
                }
                // Error
                if (Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 45.1, 1000) !== 0) {
                    $counter_Error += Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 45.1, 1000);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 45.1, 1000) !== 0) {
                    $counter_Error += Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 45.1, 1000);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 45.1, 1000) !== 0) {
                    $counter_Error += Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 45.1, 1000);
                }
                // Moderate
                if (Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 37.60, 38.40) !== 0) {
                    $counter_Moderate += Get_CounterForThisType_Ministry($school['Id'], "Student", $in, 37.60, 38.40);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 37.60, 38.40) !== 0) {
                    $counter_Moderate += Get_CounterForThisType_Ministry($school['Id'], "Teacher", $in, 37.60, 38.40);
                }
                if (Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 37.60, 38.40) !== 0) {
                    $counter_Moderate += Get_CounterForThisType_Ministry($school['Id'], "Staff", $in, 37.60, 38.40);
                }
            ?>
                <tr>
                    <td style="width: 20px;"><?php
                                                $avatr_school = $ci->db->query("SELECT `Link` FROM `l2_avatars` WHERE 
		 `Type_Of_User` = 'school' AND `For_User` = '" . $school['Id'] . "'
		  ORDER BY `Id` DESC LIMIT 1 ")->result_array();
                                                if (!empty($avatr_school)) {
                                                    $link = $avatr_school[0]['Link'];
                                                } else {
                                                    $link = "default_avatar.jpg";
                                                }
                                                ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $link; ?>" class="avatar-xs rounded-circle " alt="<?= $school['School_Name_EN'] ?>">
                    </td>
                    <td>
                        <h6 class="font-size-15 mb-1 font-weight-normal"><?= $school['School_Name_EN']; ?></h6>
                    </td>
                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;"><?= $counter_low; ?></span></td>
                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;"><?= $counter_noRisk; ?></span></td>
                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;"><?= $counter_Moderate; ?></span></td>
                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"><?= $counter_high; ?></span></td>
                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;"><?= $counter_Error;  ?></span></td>
                    <td style="text-align: right;"><span class="badge badge-info font-size-12" style="width: 100%;"><?= $counter_low + $counter_noRisk + $counter_Moderate + $counter_high + $counter_Error; ?></span></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
function Get_CounterForThisType_Ministry($id, $type, $action, $from = "", $to = "")
{
    $ci = &get_instance();
    $counter = 0;
    if ($type == "Student") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_student` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    } else if ($type == "Teacher") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    } elseif ($type == "Staff") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    }
    foreach ($query_users as $user) {
        if ($from !== "" && $to !== "") {
            $Results = $ci->db->query("SELECT * FROM `l2_result` WHERE 
    `UserType` = '" . $type . "'  AND `UserId` = '" . $user['Id'] . "' 
	AND `Action` = '" . $action . "' AND `Result` >= '" . $from . "' AND `Result` <= '" . $to . "' LIMIT 1 ")->num_rows();
            if ($Results !== 0) {
                $counter++;
            }
        } else {
            $Results = $ci->db->query("SELECT * FROM `l2_result` WHERE 
    `UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' 
	 AND `Action` = '" . $action . "' LIMIT 1 ")->num_rows();
            $counter += $Results;
        }
    }
    return ($counter);
}
function Get_Data_ForeachSchool($testname, $result = "")
{
    $ci = &get_instance();
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
    $our_schools = $ci->db->query("SELECT 
`School_Name_EN`,`Id` FROM `l1_school` 
WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `status` = '1'
ORDER BY `Id` DESC ")->result_array();
    //print_r($our_schools);
    $counter = 0;
    if ($result !== "") {
        foreach ($our_schools as $school) {
            $counter += Get_Counter_of_Tests($school['Id'], "Student", $testname, $result);
            $counter += Get_Counter_of_Tests($school['Id'], "Teacher", $testname, $result);
            $counter += Get_Counter_of_Tests($school['Id'], "Staff", $testname, $result);
        }
    } else {
        foreach ($our_schools as $school) {
            $counter += Get_Counter_of_Tests($school['Id'], "Student", $testname);
            $counter += Get_Counter_of_Tests($school['Id'], "Teacher", $testname);
            $counter += Get_Counter_of_Tests($school['Id'], "Staff", $testname);
        }
    }
    return ($counter);
}
function Get_Counter_of_Tests($id, $type, $testtype, $result = "")
{
    $ci = &get_instance();
    $counter = 0;
    $today = date("Y-m-d");
    if ($type == "Student") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_student` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    } else if ($type == "Teacher") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    } elseif ($type == "Staff") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    } elseif ($type == "Site") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_site` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    }
    if ($testtype == "Temperature") {
        foreach ($query_users as $user) {
            $Results = $ci->db->query("SELECT * FROM `l2_result` WHERE 
    `UserType` = '" . $type . "' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "' ")->num_rows();
            $counter += $Results;
        }
    } else {
        if ($result !== "") {
            foreach ($query_users as $user) {
                $Results = $ci->db->query("SELECT * FROM `l2_labtests` WHERE 
    `UserType` = '" . $type . "' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "' AND 
	`Test_Description` = '" . $testtype . "' AND `Result` = '" . $result . "' ")->num_rows();
                $counter += $Results;
            }
        } else {
            foreach ($query_users as $user) {
                $Results = $ci->db->query("SELECT * FROM `l2_labtests` WHERE 
    `UserType` = '" . $type . "' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "' AND 
    `Test_Description` = '" . $testtype . "' ")->num_rows();
                $counter += $Results;
            }
        }
    }
    return ($counter);
}
function GetListOfSites($list_Tests, $id)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $id . "' ORDER BY `Site_Code` ASC ")->result_array();
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
                "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action']
            );
            //}	
        }
    }
    ///print_r($listSites);
    foreach ($listSites as $siteResult) {
    ?>
        <tr>
            <td><?= $siteResult['TestId'] ?></td>
            <td><?= $siteResult['Device_ID'] ?></td>
            <td><?= $siteResult['name'] ?></td>
            <td><?= $siteResult['LastReadDate'] ?></td>
            <td><?= $siteResult['Batch'] ?></td>
            <td><?= $siteResult['Testtype'] ?></td>
            <?php if ($siteResult['Action'] == "School") { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">(-) Negative</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">(+) Positive</span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">(-) Negative</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">(+) Positive</span></td>
                <?php } ?>
            <?php } ?>
            <td><?php if ($siteResult['Action'] == "School") { ?>
                    <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Close For decontamination">
                <?php } ?>
            </td>
        </tr>
<?php
    }
}
?>

</html>