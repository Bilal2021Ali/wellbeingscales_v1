<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/animate.css" />

<body class="light menu_light logo-white theme-white">
    <!---->
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

        th,
        td {
            text-align: center;
        }

        .apexcharts-legend-marker {
            position: relative;
            display: inline-block;
            cursor: pointer;
            margin-right: 4px;
            margin: 8px;
            margin-bottom: 9px;
        }
    </style>
    <?php
    $supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`Id` as TypeId , `r_usertype`.`UserType`
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
JOIN l1_co_department
ON l1_co_department.Added_By = '" . $sessiondata['admin_id'] . "' 
AND `l2_co_patient`.`Added_By` = l1_co_department.Id; ")->result_array();
    $list_Tests = $this->db->query("SELECT * FROM `r_testcode`")->result_array();
    $today = date("Y-m-d");
    $our_schools = $this->db->query("SELECT 
`Dept_Name_EN`,`Id` FROM `l1_co_department` 
WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
    $allUsersTypes = $this->db->query("SELECT * FROM `r_usertype`")->result_array();
    function actionsCounter($action, $our_schoolsList)
    {
        $today = date("Y-m-d");
        $ci = &get_instance();
        $ci->load->library('session');
        $sessiondata = $ci->session->userdata('admin_details');
        //$allUsersTypes = $ci->db->query("SELECT * FROM `r_usertype`")->result_array();
        if (!empty($our_schoolsList)) {
            $allUsersTypes = $ci->db->query("SELECT `r_usertype`.`Id` as UserType
        FROM `r_usertype` 
        JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
        AND `l2_co_patient`.`Added_By` IN (" . $our_schoolsList . ") GROUP BY `r_usertype`.`Id`")->result_array();
        } else {
            $allUsersTypes = [];
        }
        foreach ($allUsersTypes as $type) {
            $count_home = 0;
            $u_type = $type['UserType'];
            if (!empty($action)) {
                $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` IN (" . $our_schoolsList . ")
                AND `UserType` = '" . $u_type . "' AND `Action` = '" . $action . "' ")->result_array();
            } else {
                $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` IN (" . $our_schoolsList . ")
                AND `UserType` = '" . $u_type . "' ")->result_array();
            }
            foreach ($ours as $user) {
                $count_home++;
            }
            echo $count_home . ",";
        }
    }
    function actionsCounter_bydept($action, $id)
    {
        //$today = date("Y-m-d");
        $ci = &get_instance();
        $ci->load->library('session');
        $sessiondata = $ci->session->userdata('admin_details');
        $allOurs_dept = $ci->db->query("SELECT * FROM `l1_co_department` WHERE `Added_By` = '" . $id . "' 
        AND `status` = '1' ")->result_array();
        $allUsersTypes = $ci->db->query("SELECT * FROM `r_usertype`")->result_array();
        foreach ($allOurs_dept as $co_dept) {
            $count_home = 0;
            $ours = $ci->db->query("SELECT Id FROM `l2_co_patient` WHERE `Added_By` = '" . $co_dept['Id'] . "'
            AND `Action` = '" . $action . "'  ")->result_array();
            $listusers = array();
            foreach ($ours as $user) {
                $listusers[] = $user;
                //print_r($listusers);
            }
            $count_home += sizeof($listusers);
            echo $count_home . ",";
        }
    }
    $idd = $sessiondata['admin_id'];
    $counter_allusers = 0;
    foreach ($supported_types as $type) {
        $allUsersByType = $this->db->query("SELECT `l2_co_patient`.`Id`,`l2_co_patient`.`UserType` FROM `l1_co_department` 
	JOIN `l2_co_patient`  ON `l2_co_patient`.`Added_By` = `l1_co_department`.`Id`
	WHERE `UserType` = '" . $type['UserType'] . "'  ")->result_array();
        if (!empty($allUsersByType)) {
            $counter_allusers += sizeof($allUsersByType);
        }
    }
    $get_style = $this->db->query(" SELECT `r_style`.`en_co_type` AS en_co_type,`r_style`.`en_co_type_sub`
FROM `l0_organization` JOIN `r_style` ON `l0_organization`.`Style_type_id`  = `r_style`.`Id` 
WHERE  `l0_organization`.`Id` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
    $new_perm_device_access = $this->db->query("SELECT * FROM `v0_area_device_permission`
WHERE `system_id` = '" . $idd . "' AND `seen` = '0' ")->result_array();
    ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"><?= $sessiondata['f_name']; ?> <br> Today's Date: <?= $today; ?> <br> Welcome to Temperature Tracking System and Laboratory Tests</h4>
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div class="page-title-right"> </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($new_perm_device_access)) {  ?>
                    <div class="col-xl-12 animate__animated animate__flipInX newdevice">
                        <div class="card bg-primary" style="border: 0px;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-sm-8 animate__animated animate__bounceIn animate__delay-2s">
                                        <p class="text-white font-size-18">
                                            You have Access to
                                            <?= sizeof($new_perm_device_access)  ?>
                                            New <b>Refrigerator<?= sizeof($new_perm_device_access) == 1 ? "" : "s";   ?></b>
                                            <i class="mdi mdi-arrow-right"></i>
                                        </p>
                                        <div class="mt-4">
                                            <a href="<?= base_url() ?>EN/Company/Refrigerator_access" class="btn btn-success waves-effect waves-light"> Check it out </a>
                                            <button class="btn btn-primary waves-effect waves-light" onClick="(function(){
							$('.newdevice').slideUp();													  
							return false;
						})();return false;">Later</button>
                                        </div>
                                    </div><!--  -->
                                    <div class="col-sm-4 animate__animated animate__bounceIn animate__delay-2s">
                                        <div class="mt-4 mt-sm-0">
                                            <img src="<?= base_url() ?>assets/images/new_device.svg" class="img-fluid" alt="" style="width: 180px;float: right">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div>
                <?php  }  ?>
                <div class="row">
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #262232;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
                                <div>
                                    <?php
                                    $all_ministry = $this->db->query("SELECT * FROM `l1_co_department`
                                             WHERE Added_By = $idd ")->num_rows();
                                    $lastminED = $this->db->query("SELECT * FROM `l1_co_department` WHERE 
											 Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $all_ministry ?></span> </h4>
                                    <?php foreach ($get_style as $style) { ?>
                                        <p class="mb-0"> <?= $style['en_co_type']; ?> Counter </p>
                                    <?php } ?>
                                </div>
                                <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;">
                                        <?php
                                        if (!empty($lastminED)) {
                                            foreach ($lastminED as $last) {
                                                echo $last['Created']
                                        ?>
                                    </span><br>
                                    <?php foreach ($get_style as $style) { ?>
                                <p class="mb-0"> last added <?= strtolower($style['en_co_type_sub']); ?> </p>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?= "--/--/--" ?></span><br>
                        <?php foreach ($get_style as $style) { ?>
                            <p class="mb-0"><?= $style['en_co_type_sub']; ?></p>
                        <?php } ?>
                    <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #262232;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $ours = $this->db->query(" SELECT * FROM `l1_co_department`
			  WHERE `Added_By` = '" . $idd . "' ")->result_array();
                                    $studentscounter = 0;
                                    $lastaddeds = array();
                                    foreach ($ours as $dept) {
                                        $patient = $this->db->query(" SELECT Created FROM 
				  `l2_co_patient` WHERE `Added_By` = '" . $dept['Id'] . "' ORDER BY `Id` DESC ")->result_array();
                                        if (!empty($patient)) {
                                            $studentscounter += sizeof($patient);
                                            $lastaddeds[] = $patient[0]['Created'];
                                        }
                                    }
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                                            <?= $studentscounter;  ?>
                                        </span> </h4>
                                    <p class="mb-0">User Counter</p>
                                </div>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php
                                        //print_r($test);
                                        if (!empty($lastaddeds)) {
                                            $last = sizeof($lastaddeds);
                                        ?>
                                            <?= $lastaddeds[$last - 1]; ?></span><br>
                                    Last added user
                                <?php } else { ?>
                                    <?= "--/--/--"; ?></span><br>
                                    Last added user
                                <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #262232;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools"> </div>
                                <div>
                                    <?php
                                    $allDev = 0;
                                    $ListOfThis = array();
                                    $All_added_schools = $this->db->query("SELECT * FROM `l1_co_department`
               WHERE `Added_By` = $idd ")->result_array();
                                    foreach ($All_added_schools as $school) {
                                        $devicesforThis = $this->db->query("SELECT * FROM `l2_co_devices`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($devicesforThis as $dvices) {
                                            $allDev++;
                                            $ListOfThis[] = $dvices["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    $lasts = $this->db->query("SELECT * FROM `l1_co_department`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allDev ?></span></h4>
                                    <p class="mb-0">Device Counter</p>
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
                    <!-- end col -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #450202;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $allSites = 0;
                                    $ListOfSitesforThis = array();
                                    /*$All_added_schools = $this->db->query("SELECT * FROM `l1_school`
              WHERE `Added_By` = $idd ")->result_array();*/
                                    foreach ($All_added_schools as $school) {
                                        $SitesforThis = $this->db->query("SELECT * FROM `l2_co_site`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($SitesforThis as $Sites) {
                                            $allSites++;
                                            $ListOfSitesforThis[] = $Sites["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $allSites ?></span> </h4>
                                    <p class="mb-0">Site Counter</p>
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
                <?php
                $countOf_Home = $this->db->query("SELECT `l2_co_patient`.`Id`
                FROM `l2_co_patient` 
                JOIN l1_co_department ON `l1_co_department`.`Id` = `l2_co_patient`.`Added_By` 
                WHERE  `l1_co_department`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND
                `l2_co_patient`.`Action` = 'Home'")->num_rows();
                $countOf_quar = $this->db->query("SELECT `l2_co_patient`.`Id`
                FROM `l2_co_patient` 
                JOIN l1_co_department ON `l1_co_department`.`Id` = `l2_co_patient`.`Added_By` 
                WHERE  `l1_co_department`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND
                `l2_co_patient`.`Action` = 'Quarantine'")->num_rows();
                ?>
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO001: Stay Home and Quarantine Proportion at All Departments by User - <?= $sessiondata['f_name']; ?> </h4>

                <?php if ($countOf_Home > 0 || $countOf_quar > 0) { ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title" style="background: #34c38f;padding: 10px;color: #f5f6f8;border-radius: 4px;"> User Counter Stay Home and Quarantine ( <?= $countOf_Home + $countOf_quar; ?> user ) </h4>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        CHART A: User Counter Stay Home and Quarantine Proportion at All Departments
                                    </h4>
                                    <div id="donut_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="card-title" style="background: #34c38f;padding: 10px;color: #f5f6f8;border-radius: 4px;"> User Counter Stay Home and Quarantine ( <?= $countOf_Home + $countOf_quar; ?> user ) </h4>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        CHART B: User Counter Stay Home and Quarantine Proportion at All Departments
                                    </h4>
                                    <div id="column_chart_datalabel"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <style>
                    .PercText {
                        -webkit-text-stroke: 3px #e73d8e;
                        color: #e871aa;
                        font-size: 60px;
                        text-shadow: 0px 0px 4px #000;
                    }
                </style>
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;">CO002: Stay Home and Quarantine Proportion at All Departments by User Type - <?= $sessiondata['f_name']; ?> </h4>
                <div class="row">
                    <div class="col-xl-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px; ">
                                    <?php foreach ($get_style as $style) { ?>
                                        CHART A: Graph by User Type ( <span data-plugin="counterup"><?= $studentscounter; ?> </span>
                                        user)
                                    <?php } ?>
                                </h4>
                                <div id="column_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row-->
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;">CO003: Stay Home and Quarantine Proportion at All Departments by Departments - <?= $sessiondata['f_name']; ?> </h4>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"> <img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                    <?php foreach ($get_style as $style) { ?>
                                        CHART A: Graph by <?= $style['en_co_type'] ?>s
                                        ( <span data-plugin="counterup"> <?= $studentscounter; ?> </span> user)
                                    <?php } ?>
                                </h4>
                                <div id="depts_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row-->
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO004: Temperature Counter at All Departments by user - <?= $sessiondata['f_name']; ?> </h4>
                <div class="row">
                    <div class="col-md-3 col-xl-3 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #387cea;">
                                <div class="card-body badge-soft-info" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Blue.png" alt="Temperature" style="width: 30px;margin-top: -12px;"> </div>
                                    <div class="col-lg-10">
                                        <h4 class="mb-1 mt-1" style="color: #033067;"> <span data-plugin="counterup"> <?= $LOW; ?></span> </h4>
                                        <p class="mb-0" style="color: #033067;"> Low Temperature </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards text-center alerts_count">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
                                <div class="card-body badge-soft-success" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;"> </div>
                                    <div class="col-xl-10">
                                        <?php
                                        $idd = $sessiondata['admin_id'];
                                        $all = $this->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsStaff = $this->db->query("SELECT * FROM `l2_co_patient`  WHERE `Added_By` = $idd  
			ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1" style="color: #044300;"><span data-plugin="counterup"><?= $NORMAL; ?></span> </h4>
                                        <p class="mb-0" style="color: #044300;">Normal Temperature</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #FF9600;">
                                <div class="card-body badge-soft-warning" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/orange.png" alt="Temperature" style="width: 30px;"> </div>
                                    <div class="col-xl-10">
                                        <?php
                                        $allstudents = $this->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                        $lastsTeachers = $this->db->query("SELECT * FROM `l2_co_patient`  WHERE `Added_By` = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1" style="color: #674403;"> <span data-plugin="counterup"><?= $MODERATE ?></span> </h4>
                                        <p class="mb-0" style="color: #674403;">Moderate Temperature </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards text-center" style="min-height: 114px;">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
                                <div class="card-body badge-soft-danger" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/red.png" alt="Temperature" style="width: 30px;"> </div>
                                    <div class="col-xl-10">
                                        <?php
                                        $allstudents = $this->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsStudent = $this->db->query("SELECT * FROM `l2_co_patient`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup" style="color: #670303;"><?= $HIGH ?></span> </h4>
                                        <p class="mb-0" style="color: #670303;"> High Temperature </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO005: Temperature Counter at All Departments by user - <?= $sessiondata['f_name']; ?> </h4>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">
                                <div class="float-right">
                                    <div class="dropdown">
                                        <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted"> Select Test <i class="mdi mdi-chevron-down ml-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                            <li class="dropdown-item" onclick="Tempratur_List('#simpl_Count_list','#New_Count_List');"> Temperature </li>
                                            <?php foreach ($list_Tests as $test) { ?>
                                                <li class="dropdown-item" onClick="labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">
                                    <img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                    <?php foreach ($get_style as $style) { ?>
                                        CHART A: Graph for Total Users ( <span data-plugin="counterup"><?= $studentscounter; ?> </span>
                                        user)
                                    <?php } ?>


                                </h4>
                                (<span id="COUNTSHOWTESTNAME">Temperature</span>)
                            </h4>
                            <div data-simplebar style="height: 385px;overflow: auto;">
                                <div id="simpl_Count_list">
                                    <?php Get_SchoolsData(); ?>
                                </div>
                                <div id="New_Count_List"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO006: Lab Test Counter at All Departments by user - <?= $sessiondata['f_name']; ?> </h4>
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="position: relative">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">


                                                <?php foreach ($get_style as $style) { ?>
                                                    CHART A: Laboratory Test Counter ( <span data-plugin="counterup"><?= $studentscounter; ?> </span>
                                                    user)
                                                <?php } ?>


                                            </h4>
                                            <div id="chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO007: Lab Test Counter Per <?= $style['en_co_type'] ?> </h4>
                        </div>
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="position: relative">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">
                                                <div class="float-right">
                                                    <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">Choose Test<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                            <?php foreach ($list_Tests as $test) { ?>
                                                                <li class="dropdown-item" onClick="getDataChartByTestName_Company('<?= $test['Test_Desc']; ?>');"> <?= $test['Test_Desc']; ?> </li>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    CHART A: Laboratory Test Counter for Each <?= $style['en_co_type'] ?>
                                                <?php } ?>
                                            </h4>
                                            </h4>
                                            <h5 class="float-left" id="__dept_chart"></h5>
                                            <div id="chart_by_dept" style="margin-top: 50px;" class="text-center">
                                                <img src="<?= base_url(); ?>assets/images/ch.svg" width="40%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>
                            #simpl_home_list td,
                            #simpl_Quaran_list td,
                            #simpl_Quaran_list th,
                            #simpl_home_list th {
                                padding: 0px;
                                border: 12px solid white;
                                border-radius: 34%;
                            }

                            #simpl_Quaran_list th,
                            #simpl_home_list th {
                                padding: 10px;
                            }

                            #simpl_home_list td span,
                            #simpl_Quaran_list td span {
                                margin-top: 7px;
                            }
                        </style>
                        <div class="col-12">
                            <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO008: Stay Home User for Temperature Checks and Lab Test <?= $style['en_co_type'] ?> </h4>

                        </div>
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">select Test<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');">Temperature </li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="home_labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    CHART A: Graph for the Total Number of People Staying at Home According to a Certain Type of Examination in All
                                                    <?= $style['en_co_type'] ?>s </span>
                                                <?php } ?>
                                            </h4>
                                            (<span id="STAYHOMESHOWTESTNAME">Temperature</span>)
                                        </h4>
                                        <div data-simplebar style="height: 385px;overflow: auto;">
                                            <div id="simpl_home_list">
                                                <?php Get_SchoolsData('Home'); ?>
                                            </div>
                                            <div id="New_home_List"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO009: Quarantined User for Temperature Checks and Lab Test <?= $style['en_co_type'] ?> </h4>
                        </div>
                        <div class="col-12">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">Select Test<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_Quaran_list','#New_Quaran_List');">Temperature</li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="quarnt_labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    CHART A: Graph for the Total Number of Quarantined People According to a Certain Type of Examination in All <?= $style['en_co_type'] ?>s </span>
                                                <?php } ?>
                                            </h4>
                                            (<span id="SQUAROMESHOWTESTNAME">Temperature</span>)
                                        </h4>
                                        <div data-simplebar style="height: 385px;overflow: auto;">
                                            <!-- enbd table-responsive-->
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
                        </div>
                        <div class="col-xl-3" style="display: none">
                            <div class="card" style="border-color: #F44336;">
                                <div class="card-body" style="min-height: 465px; text-align: center;">
                                    <h5 class="m-0"> <span style="color:#0eacd8;text-align:center;"> Stay Home </span> </h5>
                                    <?php
                                    $our_depts = array();
                                    foreach ($our_schools as $school) {
                                        $high = 0;
                                        $high += GetTheCounter_OfAction($school['Id'], "Home");
                                        if ($high !== 0) {
                                            $our_depts[] = array("Dept_Name_EN" => $school['Dept_Name_EN'], "Counter" => $high);
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($our_depts)) {  ?>
                                        <table style="width: 100%;">
                                            <?php foreach ($our_depts as $depts) { ?>
                                                <tr>
                                                    <td><?= $depts['Dept_Name_EN']; ?></td>
                                                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?= $depts['Counter']; ?></span></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } else { ?>
                                        <div style="min-height: 409px;display: grid;align-content: center;align-items: center;">
                                            <div class="text-center">
                                                <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                                                <p class="font-16 text-muted mb-2"></p>
                                                <h5><a href="#" class="text-dark">There is NO INFORMATION to Display<span class="text-muted font-16"> -<br>
                                                            Stay Home </span> </a></h5>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card" style="border-color: #F44336;">
                                <div class="card-body" style="min-height: 469px; text-align: center;">
                                    <h5 class="m-0"> <span style="color:#ff2e00;text-align:center;"> Quarantine</h5>
                                    <?php
                                    $our_depts = array();
                                    foreach ($our_schools as $school) {
                                        $high = 0;
                                        $high += GetTheCounter_OfAction($school['Id'], "Quarantine");
                                        if ($high !== 0) {
                                            $our_depts[] = array("Dept_Name_EN" => $school['Dept_Name_EN'], "Counter" => $high);
                                        }
                                    }
                                    if (!empty($our_depts)) {
                                    ?>
                                        <table style="width: 100%;">
                                            <?php foreach ($our_depts as $depts) { ?>
                                                <tr>
                                                    <td><?= $depts['Dept_Name_EN']; ?></td>
                                                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?= $depts['Counter']; ?></span></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } else { ?>
                                        <div style="min-height: 409;display: grid;align-content: center;align-items: center;">
                                            <div class="text-center">
                                                <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                                                <p class="font-16 text-muted mb-2"></p>
                                                <h5><a href="#" class="text-dark"> There is NO INFORMATION to Display <span class="text-muted font-16"> Quarantine </span> </a></h5>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-right: 0px;">
                            <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO010: Lab Tests for All <?= $style['en_co_type'] ?> Sites - Lab Tests </h4>
                            <div class="col-12">


                            </div>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">Select Test<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="sites_lab('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    CHART A: Laboratory Test Results According to a Certain Type of Examination in <?= $style['en_co_type'] ?>s </h4>
                                        <?php } ?>
                                        </h4>
                                        <div id="table_sites_data">
                                            <div id="chart_by_dept" class="text-center">
                                                <div id="chart_by_dept" class="text-center">
                                                    <img src="<?= base_url(); ?>assets/images/complet_reg.png" width="25%;">
                                                </div>
                                            </div>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="draw"></div>
                        </div>
                    </div>
                </div>
                <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO011: CLIMATE REPORT </h4>
                <?php $this->load->view('EN/Company/inc/climate_dashboard')  ?>
            </div>
</body>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script>
    $('.Table_Data').DataTable();
    var Chart_Options = {
        chart: {
            height: 200,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "30%",
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
            name: "All",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc']) . ",";
                    } ?>]
        }, {
            name: "Negative",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc'], '0') . ",";
                    } ?>]
        }, {
            name: "Positve",
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
                text: "Total checks"
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
                        return th + "Thousand"
                    } else {
                        return e
                    }
                }
            }
        }
    };
    chart = new ApexCharts(document.querySelector("#chart"), Chart_Options);
    chart.render();

    function getDataChartByTestName_Company($testname) {
        //chart_by_dept
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Results_company/getDataChartByTestName_Company',
            data: {
                testname: $testname,
            },
            beforeSend: function() {
                $('#draw').html('');
                $('#chart_by_dept').html('<div class="spinner-grow text-secondary m-1" role="status"> <span class="sr-only"> Loading... </span></div>');
            },
            success: function(data) {
                $('#chart_by_dept').html("");
                $('#draw').html(data);
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
</script>
<script>
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
            url: '<?= base_url(); ?>EN/Results_company/Get_home_List_Ministry',
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
                    'oops!! we have a error',
                    'error'
                );
            }
        });
        //$('.classes_temp').hide();
    }

    function labTests(type) {
        $('#COUNTSHOWTESTNAME').html(type);
        $('#simpl_Count_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Results_company/Get_home_List_Ministry',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Count_List').html(data);
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

    function quarnt_labTests(type) {
        $('#SQUAROMESHOWTESTNAME').html(type);
        $('#simpl_Quaran_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Results_company/Get_home_List_Ministry',
            data: {
                IN: 'Quarantine',
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Quaran_List').html(data);
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

    function sites_lab(type) {
        $('#sites_showType').html(type);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Results_company/sites_data_table',
            data: {
                TestName: type,
            },
            success: function(data) {
                $('#table_sites_data').html(data);
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
<style>
    .Img_School {
        width: 30px !important;
    }

    .Risk {
        width: 100px !important;
    }
</style>
<?php
function Get_SchoolsData($in = "")
{
    $ci = &get_instance();
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
?>
    <table class="table Table_Data" style="column-width: auto;">
        <thead>
            <th class="Img_School">Img</th>
            <th style="text-align: center">Name</th>
            <th style="color: #cdfc00;">Low</th>
            <th class="Risk" style="color: #00ab00;">Normal</th>
            <th style="color: #ff8200;">Moderate</th>
            <th style="color: #ff2e00;">High</th>
            <th style="color: #50a5f1">Total</th>
        </thead>
        <tbody>
            <?php
            $List = array();
            $our_depts = $ci->db->query(" SELECT  `Dept_Name_EN`,`Id` FROM `l1_co_department` 
	 WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `status` = '1' ORDER BY Id DESC ")->result_array();
            foreach ($our_depts as $dept_result) {
                //($id,$action,$from = "",$to = "")
                $counter = 0;
                $counter_low = 0;
                $counter_noRisk = 0;
                $counter_Moderate = 0;
                $counter_high = 0;
                /////$id,$action,$from = "",$to = ""
                $counter = GetTheCounter_OfAction($dept_result['Id'], $in);
                $counter_low = GetTheCounter_OfAction($dept_result['Id'], $in, 0, 36.2);
                $counter_noRisk = GetTheCounter_OfAction($dept_result['Id'], $in, 36.3, 37.5);
                $counter_Moderate = GetTheCounter_OfAction($dept_result['Id'], $in, 37.6, 38.4);
                $counter_high = GetTheCounter_OfAction($dept_result['Id'], $in, 38.5, 45);
            ?>
                <tr>
                    <?php
                    $avatr_school = $ci->db->query("SELECT `Link` FROM `l2_avatars` WHERE 
          `Type_Of_User` = 'department_Company' AND `For_User` = '" . $dept_result['Id'] . "'
		   ORDER BY `Id` DESC LIMIT 1 ")->result_array();
                    ?>
                    <td style="width: 20px;"><?php
                                                if (!empty($avatr_school)) {
                                                    $link = $avatr_school[0]['Link'];
                                                } else {
                                                    $link = "default_avatar.jpg";
                                                }
                                                ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $link; ?>" class="avatar-xs rounded-circle " alt="<?= $dept_result['Dept_Name_EN'] ?>">
                    </td>
                    <td>
                        <h6 class="font-size-15 mb-1 font-weight-normal"><?= $dept_result['Dept_Name_EN']; ?></h6>
                    </td>
                    <td style="background: #cdfc00;color: #3B3B3B;"><span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;"><?= $counter_low; ?></span></td>
                    <td style="background: #00ab00;color: #fff;"><span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;"><?= $counter_noRisk; ?></span></td>
                    <td style="background: #ff8200;color: #fff;"><span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;"><?= $counter_Moderate; ?></span></td>
                    <td style="background: #ff2e00;color: #fff;">
                        <span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"><?= $counter_high; ?></span>
                    </td>
                    <td style="text-align: center;" class="badge-info">
                        <span class="badge badge-info font-size-12" style="width: 100%;"><?= $counter; ?></span>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
    <?php
}
function GetTheCounter_OfAction($id, $action = "", $from = "", $to = "")
{
    $ci = &get_instance();
    $counter = 0;
    $today = date("Y-m-d");
    if ($action !== "") {
        $query_users = $ci->db->query(" SELECT * FROM `l2_co_patient` 
	WHERE `Added_By` = '" . $id . "' AND `Action` = '" . $action . "'  ")->result_array();
    } else {
        $query_users = $ci->db->query(" SELECT * FROM `l2_co_patient` 
	WHERE `Added_By` = '" . $id . "' ")->result_array();
    }
    if ($action !== "") {
        foreach ($query_users as $user) {
            $type = $user['UserType'];
            if ($from !== "" && $to !== "") {
                $Results = $ci->db->query("SELECT * FROM `l2_co_monthly_result` WHERE 
                `UserType` = '" . $type . "'  AND `UserId` = '" . $user['Id'] . "' 
                ORDER BY `TimeStamp` DESC LIMIT 1 ")->result_array();
                foreach ($Results as $result) {
                    if ($result['Result'] >= $from && $result['Result'] <= $to) {
                        $counter++;
                    }
                }
            } else {
                $Results = $ci->db->query("SELECT * FROM `l2_co_monthly_result` WHERE 
                `UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' AND Result < 45 LIMIT 1 ")->result_array();
                if (!empty($Results)) {
                    foreach ($Results as $result) {
                        $counter++;
                    }
                }
            }
        }
    } else {
        foreach ($query_users as $user) {
            $type = $user['UserType'];
            if ($from !== "" && $to !== "") {
                $Results = $ci->db->query("SELECT * FROM `l2_co_monthly_result` WHERE 
			    `UserType` = '" . $type . "'  AND `UserId` = '" . $user['Id'] . "' AND `Created` = '" . $today . "'
                ORDER BY `TimeStamp` DESC LIMIT 1 ")->result_array();
                foreach ($Results as $result) {
                    if ($result['Result'] >= $from && $result['Result'] <= $to) {
                        $counter++;
                    }
                }
            } else {
                $Results = $ci->db->query("SELECT * FROM `l2_co_monthly_result` WHERE 
			`UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' AND Result < 45  AND `Created` = '" . $today . "' LIMIT 1 ")->result_array();
                if (!empty($Results)) {
                    foreach ($Results as $result) {
                        $counter++;
                    }
                }
                //                 glq();
                // 	}
                // 	else{
                //     foreach ( $query_users as $user ) {
                //         $type = $user[ 'UserType' ];
                //         if ( $from !== "" && $to !== "" ) {
                //             $Results = $ci->db->query( "SELECT * FROM `l2_co_monthly_result` WHERE 
                // 			`UserType` = '" . $type . "'  AND `UserId` = '" . $user[ 'Id' ] . "' '
                // 			 ORDER BY `TimeStamp` DESC LIMIT 1 " )->result_array();
                // 					foreach ( $Results as $result ) {
                //                 if ( $result[ 'Result' ] > $from && $result[ 'Result' ] < $to ) {
                //                     $counter++;
            }
        }
    }
    //         } else {
    //             $Results = $ci->db->query( "SELECT * FROM `l2_co_monthly_result` WHERE 
    // 			`UserType` = '" . $type . "' AND `UserId` = '" . $user[ 'Id' ] . "' AND `Created` = '".$today."' LIMIT 1 " )->result_array();
    //             if ( !empty( $Results ) ) {
    //                 foreach ( $Results as $result ) {
    //                     $counter++;
    //                 }
    //             }
    //         }
    //     }
    // 	}
    return ($counter);
}
function Get_Data_ForeachSchool($testname, $result = "")
{
    $ci = &get_instance();
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
    $our_schools = $ci->db->query("SELECT `Id` FROM `l1_co_department` WHERE 
`Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
    $counter = 0;
    if ($result !== "") {
        foreach ($our_schools as $school) {
            $counter += Get_Counter_of_Tests($school['Id'], $testname, $result);
        }
    } else {
        foreach ($our_schools as $school) {
            $counter += Get_Counter_of_Tests($school['Id'], $testname);
        }
    }
    return ($counter);
}
function Get_Counter_of_Tests($id, $testname = "", $result = "")
{
    $ci = &get_instance();
    $counter = 0;
    $today = date("Y-m-d");
    $query_users = $ci->db->query(" SELECT * FROM `l2_co_patient` WHERE `Added_By` = '" . $id . "'  ")->result_array();
    if (!empty($testname)) {
        if ($result !== "") {
            foreach ($query_users as $user) {
                $type = $user['UserType'];
                $Results = $ci->db->query("SELECT * FROM `l2_co_labtests` WHERE 
    `UserType` = '" . $type . "' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "' AND 
	`Test_Description` = '" . $testname . "' AND `Result` = '" . $result . "' ")->num_rows();
                $counter += $Results;
            }
        } else {
            foreach ($query_users as $user) {
                $type = $user['UserType'];
                $Results = $ci->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '" . $type . "' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "' AND 
				`Test_Description` = '" . $testname . "' ")->num_rows();
                $counter += $Results;
            }
        }
    } else {
        if ($result !== "") {
            foreach ($query_users as $user) {
                $type = $user['UserType'];
                $Results = $ci->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '" . $type . "' AND `Created` = '" . $today . "' AND `UserId` = '" . $user['Id'] . "' 
				AND `Result` = '" . $result . "' ")->num_rows();
                $counter += $Results;
            }
        } else {
            foreach ($query_users as $user) {
                $type = $user['UserType'];
                $Results = $ci->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '" . $type . "' AND `Created` = '" . $today . "'
				AND `UserId` = '" . $user['Id'] . "' ")->num_rows();
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
        foreach ($getResults as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
			AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
            $listSites[] = array(
                "name" => $name, "Id" => $ID,
                "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action']
            );
        }
    }
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
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">Positive (+)</span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">Negative (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">Positive (+)</span></td>
                <?php } ?>
            <?php } ?>
            <td><?php if ($siteResult['Action'] == "School") { ?>
                    <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Close for decontamination">
                <?php } ?>
            </td>
        </tr>
<?php
    }
}
?>
<script>
    ByTypeoptions = {
        chart: {
            height: 200,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "30%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: !0,
            formatter: function(e) {
                return e
            },
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "All",
            data: [<?php actionsCounter("", $our_schoolsList); ?>],
        }, {
            name: " Quarantine ",
            data: [<?php actionsCounter("Quarantine", $our_schoolsList); ?>],
        }, {
            name: "Stay Home",
            data: [<?php actionsCounter("Home", $our_schoolsList); ?>],
        }, ],
        colors: ["#f1b44c", "#f46a6a", "#50a5f1"],
        xaxis: {
            categories: [
                <?php foreach ($supported_types as $type) { ?> "<?= ucfirst($type['UserType']); ?>",
                <?php } ?>
            ]
        },
        yaxis: {
            title: {
                text: "Counter"
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
                    return e
                }
            }
        }
    };
    <?php $allourco = $this->db->query(" SELECT Dept_Name_EN , Id FROM `l1_co_department` WHERE
		`Added_By` = '" . $sessiondata['admin_id'] . "' AND `status` = '1' ")->result_array(); ?>
    options_dept = {
        chart: {
            height: 200,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "30%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: !0,
            formatter: function(e) {
                return e
            },
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "All",
            data: [
                <?php
                foreach ($supported_types as $type) {
                    $allUsersByType =  $this->db->query("SELECT * FROM `l2_co_patient` 
                    WHERE `UserType` = '" . $type['TypeId'] . "'
                    AND `Added_By` IN  (" . $our_schoolsList . ") ORDER BY `Id` DESC ")->result_array();
                    echo sizeof($allUsersByType) . ",";
                }
                ?>
            ],
        }, {
            name: "Quarantine",
            data: [<?php actionsCounter_bydept("Quarantine", $sessiondata['admin_id']); ?>],
        }, {
            name: "Stay Home",
            data: [<?php actionsCounter_bydept("Home", $sessiondata['admin_id']); ?>],
        }, ],
        colors: ["#34c38f", "#f46a6a", "#50a5f1"],
        xaxis: {
            categories: [
                <?php foreach ($allourco as $dept) { ?> "<?= ucfirst(str_replace("\r\n", "", trim($dept['Dept_Name_EN']))); ?>",
                <?php } ?>
            ]
        },
        yaxis: {
            title: {
                text: "Counter"
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
                    return e
                }
            }
        }
    };
    (chart = new ApexCharts(document.querySelector("#column_chart"), ByTypeoptions)).render();
    (chart = new ApexCharts(document.querySelector("#depts_chart"), options_dept)).render();
    var home = {
        chart: {
            height: 170,
            type: "radialBar",
        },
        series: [<?= get_percentage($studentscounter, $countOf_Home) ?>],
        colors: ["#343a40"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "70%",
                    background: "#5b8ce8",
                },
                track: {
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        blur: 4,
                        opacity: 0.15
                    }
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#fff",
                        fontSize: "13px"
                    },
                    value: {
                        color: "#fff",
                        fontSize: "30px",
                        show: true
                    }
                }
            }
        },
        stroke: {
            lineCap: "round"
        },
        labels: ["Stay Home"]
    };
    var chart = new ApexCharts(document.querySelector("#fix_xhart"), home);
    chart.render();
    var qua = {
        chart: {
            height: 170,
            type: "radialBar",
        },
        series: [<?= get_percentage($studentscounter, $countOf_quar) ?>],
        colors: ["#343a40"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "70%",
                    background: "#f46a6a"
                },
                track: {
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        blur: 4,
                        opacity: 0.15
                    }
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#fff",
                        fontSize: "13px"
                    },
                    value: {
                        color: "#fff",
                        fontSize: "30px",
                        show: true
                    }
                }
            }
        },
        stroke: {
            lineCap: "round"
        },
        labels: ["Quarantine"]
    };
    var chart = new ApexCharts(document.querySelector("#qua_xhart"), qua);
    chart.render();
    <?php if ($countOf_Home > 0 || $countOf_quar > 0) { ?>
        options = {
            chart: {
                height: 350,
                type: "donut"
            },
            series: [<?= $countOf_Home  ?>, <?= $countOf_quar  ?>],
            labels: ["Stay Home", "Quarantine"],
            colors: ["#34c38f", "#5b73e8"],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        };
        (chart = new ApexCharts(document.querySelector("#donut_chart"), options)).render();
        options = {
            chart: {
                height: 330,
                type: "bar",
                toolbar: {
                    show: !0
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {}
                }
            },
            dataLabels: {
                enabled: !1,
                formatter: function(e) {
                    return e
                },
                offsetY: -20,
                style: {
                    fontSize: "12px",
                }
            },
            series: [{
                name: " Counters ",
                data: [<?= $countOf_Home  ?>, <?= $countOf_quar  ?>]
            }],
            colors: ["#34c38f", "#5b73e8", "#ff6f6f"],
            grid: {
                borderColor: "#f1f1f1"
            },
            xaxis: {
                categories: ["Stay Home", "Quarantine"],
                position: "top",
                labels: {
                    show: true
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    fill: {
                        type: "gradient",
                        gradient: {
                            colorFrom: "#D8E3F0",
                            colorTo: "#BED1E6",
                            stops: [0, 100],
                            opacityFrom: .4,
                            opacityTo: .5
                        }
                    }
                },
                tooltip: {
                    enabled: !0,
                    offsetY: -35
                }
            },
            fill: {
                gradient: {
                    shade: "light",
                    type: "horizontal",
                    shadeIntensity: .25,
                    gradientToColors: void 0,
                    inverseColors: !0,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                }
            },
            yaxis: {
                axisBorder: {
                    show: !1
                },
                axisTicks: {
                    show: !1
                },
                labels: {
                    show: !1,
                    formatter: function(e) {
                        return e
                    }
                }
            }
        };
        (chart = new ApexCharts(document.querySelector("#column_chart_datalabel"), options)).render();
    <?php } ?>
</script>
<?php
function get_percentage($total, $number)
{
    if ($total > 0) {
        return round($number / ($total / 100), 2);
    } else {
        return 0;
    }
}
?>

</html>