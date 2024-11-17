<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/animate.css" />

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

        th,
        td {
            text-align: center;
        }


        #table_sites_data th {
            text-align: center !important;
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
    $supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`AR_UserType` AS UserType
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
JOIN l1_co_department
ON l1_co_department.Added_By = '" . $sessiondata['admin_id'] . "' 
AND `l2_co_patient`.`Added_By` = l1_co_department.Id; ")->result_array();

    $list_Tests = $this->db->query("SELECT * FROM `r_testcode`")->result_array();
    $today = date("Y-m-d");

    $our_schools = $this->db->query("SELECT 
`Dept_Name_AR`,`Id` FROM `l1_co_department` 
WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();

    $allUsersTypes = $this->db->query("SELECT * FROM `r_usertype`")->result_array();

    function actionsCounter($action, $id)
    {
        $today = date("Y-m-d");
        $ci = &get_instance();
        $ci->load->library('session');
        $sessiondata = $ci->session->userdata('admin_details');
        $allOurs_dept = $ci->db->query("SELECT * FROM `l1_co_department` WHERE `Added_By` = '" . $id . "' ")->result_array();
        $allUsersTypes = $ci->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`UserType`
	 FROM `r_usertype` 
	 JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
	 JOIN l1_co_department
	 ON l1_co_department.Added_By = '" . $sessiondata['admin_id'] . "'
	 AND `l2_co_patient`.`Added_By` = l1_co_department.Id; ")->result_array();
        foreach ($allUsersTypes as $type) {
            $count_home = 0;
            foreach ($allOurs_dept as $co_dept) {
                $u_type = $type['UserType'];
                if (!empty($action)) {
                    $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = '" . $co_dept['Id'] . "' 
	 			AND `UserType` = '" . $u_type . "' AND `Action` = '" . $action . "' ")->result_array();
                } else {
                    $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = '" . $co_dept['Id'] . "' 
	 			AND `UserType` = '" . $u_type . "' ")->result_array();
                }
                $listusers = array();
                $count_home += sizeof($ours);
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

    $get_style = $this->db->query(" SELECT `r_style`.`ar_co_type` AS ar_co_type,`r_style`.`ar_co_type_sub`
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
                        <h4 class="card-title" style="background: #1a2b2f;padding: 10px;color: #f5f6f8;border-radius: 4px;"> تاريخ اليوم <?php echo $today; ?> :مرحبًا بكم في نظام تتبع درجات الحرارة والاختبارات المعملية - <?php echo $sessiondata['f_name']; ?> </h4>
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
                                            لديك الوصول
                                            <?php echo sizeof($new_perm_device_access)  ?>
                                            أجهزة <b>جديدة<?php echo sizeof($new_perm_device_access) == 1 ? "" : "s";   ?></b>
                                            <i class="mdi mdi-arrow-right"></i>
                                        </p>
                                        <div class="mt-4">
                                            <a href="<?php echo base_url() ?>AR/Company/Refrigerator_access" class="btn btn-success waves-effect waves-light"> عرض الأجهزة </a>
                                            <button class="btn btn-primary waves-effect waves-light" onClick="(function(){
							$('.newdevice').slideUp();													  
							return false;
						})();return false;">لاحقا</button>
                                        </div>
                                    </div><!--  -->
                                    <div class="col-sm-4 animate__animated animate__bounceIn animate__delay-2s">
                                        <div class="mt-4 mt-sm-0">
                                            <img src="<?php echo base_url() ?>assets/images/new_device.svg" class="img-fluid" alt="" style="width: 180px;float: right">
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
                            <div class="card-body" style="background-color: #217F0C;">
                                <div class="float-right mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools"> </div>
                                <div>
                                    <?php
                                    $all_ministry = $this->db->query("SELECT * FROM `l1_co_department`
              WHERE Added_By = $idd ")->num_rows();
                                    $lastminED = $this->db->query("SELECT * FROM `l1_co_department` WHERE 
              Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?php echo $all_ministry ?></span> </h4>
                                    <?php foreach ($get_style as $style) { ?>
                                        <p class="mb-0"> <?php echo $style['ar_co_type']; ?> مجموع </p>
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
                                <p class="mb-0"> أخر <?php echo $style['ar_co_type_sub']; ?> </p>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?php echo "--/--/--" ?></span><br>
                        <?php foreach ($get_style as $style) { ?>
                            <p class="mb-0"><?php echo  $style['ar_co_type_sub']; ?></p>
                        <?php } ?>
                    <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #605091;">
                                <div class="float-right mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/temperature_counter.png" alt="Test" width="50px"> </div>
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
                                            <?php echo $studentscounter;  ?>
                                        </span> </h4>
                                    <p class="mb-0"> مجموع المستخدمين</p>
                                </div>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php
                                        //print_r($test);
                                        if (!empty($lastaddeds)) {
                                            $last = sizeof($lastaddeds);
                                        ?>
                                            <?php echo $lastaddeds[$last - 1]; ?></span><br>
                                    أخر مستخدم تمت إضافته
                                <?php } else { ?>
                                    <?php echo "--/--/--"; ?></span><br>
                                    أخر مستخدم تمت إضافته
                                <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #344267;">
                                <div class="float-right mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools"> </div>
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
                                    $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allDev ?></span></h4>
                                    <p class="mb-0">مجموع الأجهزة</p>
                                </div>
                                <?php if (!empty($ListOfThis)) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?php echo $ListOfThis[0]; ?></span><br>
                                        أخر جهاز تمت إضافته </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?php echo "--/--/--" ?></span><br>
                                        أخر جهاز تمت إضافته </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #694811;">
                                <div class="float-right mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px"> </div>
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
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?php echo $allSites ?></span> </h4>
                                    <p class="mb-0">مجموع المواقع</p>
                                </div>
                                <?php if (!empty($ListOfSitesforThis)) { ?>
                                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> <?php echo $ListOfSitesforThis[0] ?> </span><br>
                                        أخر موقع تمت إضافته </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?php echo "--/--/--" ?></span><br>
                                        أخر موقع تمت إضافته </p>
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
                <div class="col-12">
                    <h4 class="card-title" style="background: #1a2b2f;padding: 10px;color: #f5f6f8;border-radius: 4px;">
                        نسبة البقاء في المنزل والحجر الصحي للكل <?php echo $style['ar_co_type'] ?></h4>
                </div>

                <?php /*?>	<div class="row">
		<div class="col-xl-4">
			<div class="card">
				<div class="card-body">
						<div id="fix_xhart"  dir="ltr"></div>
						<div class="col-lg-12 text-center">
							<h5> stay home <span data-plugin="counterup"><?php echo $countOf_Home; ?></span></h5>	
						</div>
						 <div id="chart-container"></div>
						<div id="qua_xhart" dir="ltr"></div>
						<div class="col-lg-12 text-center">
							<h5> Quarantine <span data-plugin="counterup"><?php echo $countOf_quar; ?></span></h5>	
						</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="card" style="max-height: 440px;" >
				<div class="card-body text-center">
					<?php //<?php echo get_percentage($studentscounter,$countOf_quar)*10
					//<img src="<?php echo base_url(); assets/images/3D_chart/pink_level.svg"  alt="" >?>
					<div style="transform: scale(0.6);position: relative;top: -180px;"
					 data-toggle="tooltip" data-placement="left" title="" data-original-title="in quarantine">
					<img src="<?php echo base_url(); ?>assets/images/3D_chart/pink_top.svg" style="position: relative;z-index: 100;">
					<div style="margin: -93px auto;height: 280px;width: 220px;transform-origin: top;">
						<div style="height: 100%;width: 100%;display: grid;align-content: center;
						position: absolute;top: 0;left: 0px;z-index: 100;">
					 	<h3 class="PercText"><?php echo get_percentage($studentscounter,$countOf_quar)  ?>%</h3>
						</div>
						<div style="height: 100%;width: 60%;background: #000;margin-right: 44px;
						transform-origin: bottom;background: linear-gradient(90deg, rgba(231,54,138,1) 0%, rgba(232,118,172,1) 100%);
						transform: scaleY(<?php echo get_percentage($studentscounter,$countOf_quar)/100  ?>);">
						</div>
					</div>
					<img src="<?php echo base_url(); ?>assets/images/3D_chart/pink_bottom.svg"
						 style="margin-top: 5px;position: relative;">
				</div>
				</div>
			</div>
		</div>
        
		<div class="col-xl-4">
			<div class="card" style="max-height: 440px;" >
				<div class="card-body text-center">
					<?php //<?php echo get_percentage($studentscounter,$countOf_quar)*10
					//<img src="<?php echo base_url(); assets/images/3D_chart/pink_level.svg"  alt="" >?>
					<div style="transform: scale(0.6);position: relative;top: -180px;" 
					 data-toggle="tooltip" data-placement="left" title="" data-original-title=" in home ">
					<img src="<?php echo base_url(); ?>assets/images/3D_chart/pink_top.svg" style="position: relative;z-index: 100;">
					<div style="margin: -93px auto;height: 280px;width: 220px;transform-origin: top;">
						<div style="height: 100%;width: 100%;display: grid;align-content: center;
						position: absolute;top: 0;left: 0px;z-index: 100;">
					 	<h3 class="PercText"><?php echo get_percentage($studentscounter,$countOf_Home)?>%</h3>
						</div>
						<div style="height: 100%;width: 60%;background: #000;margin-right: 44px;
						transform-origin: bottom;background: linear-gradient(90deg, rgba(231,54,138,1) 0%, rgba(232,118,172,1) 100%);
						transform: scaleY(<?php echo get_percentage($studentscounter,$countOf_Home)/100?>);">
						</div>
					</div>
					<img src="<?php echo base_url(); ?>assets/images/3D_chart/pink_bottom.svg"
						 style="margin-top: 5px;position: relative;">
				</div>
				</div>
			</div>
		</div>
	</div>
<?php */ ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    النسبة بين البقاء في المنزل والحجر الصحي
                                </h4>
                                <div id="donut_chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="column_chart_datalabel"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .PercText {
                        -webkit-text-stroke: 3px #e73d8e;
                        color: #e871aa;
                        font-size: 60px;
                        text-shadow: 0px 0px 4px #000;
                    }
                </style>
                <div class="col-12">
                    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                        فحوصات الحرارة</h4>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                    </div>
                </div>



                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px; ">
                                    <?php foreach ($get_style as $style) { ?>
                                        مجموع هؤلاء في كل
                                        <?php echo $style['ar_co_type'] ?> ( <span data-plugin="counterup"><?php echo $studentscounter; ?> </span>
                                        ) - رسم بياني حسب درجة الحرارة
                                    <?php } ?>
                                </h4>
                                <div id="column_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"> <img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                    <?php foreach ($get_style as $style) { ?>
                                        مجموع هؤلاء في كل<?php echo $style['ar_co_type'] ?>
                                        ( <span data-plugin="counterup"><?php echo $studentscounter; ?> </span> ) - رسم بياني حسب درجة الحرارة <?php echo $style['ar_co_type']; ?>
                                    <?php } ?>
                                </h4>
                                <div id="depts_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end row-->
                <div class="row">
                    <div class="col-md-3 col-xl-3 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #387cea;">
                                <div class="card-body badge-soft-info" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Blue.png" alt="الحرارة" style="width: 30px;margin-top: -12px;"> </div>
                                    <div class="col-lg-10">
                                        <h4 class="mb-1 mt-1" style="color: #033067;"> <span data-plugin="counterup"> <?php echo $LOW; ?></span> </h4>
                                        <p class="mb-0" style="color: #033067;"> حرارة منخفضة </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards text-center alerts_count">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
                                <div class="card-body badge-soft-success" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/green.png" alt="الحرارة" style="width: 30px;"> </div>
                                    <div class="col-xl-10">
                                        <?php
                                        $idd = $sessiondata['admin_id'];
                                        $all = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsStaff = $this->db->query("SELECT * FROM `l2_staff`  WHERE `Added_By` = $idd  
				ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1" style="color: #044300;"><span data-plugin="counterup"><?php echo $NORMAL; ?></span></h4>
                                        <p class="mb-0" style="color: #044300;">حرارة طبيعية</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #FF9600;">
                                <div class="card-body badge-soft-warning" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/orange.png" alt="الحرارة" style="width: 30px;"> </div>
                                    <div class="col-xl-10">
                                        <?php
                                        $allstudents = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                        $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  
ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1" style="color: #674403;"> <span data-plugin="counterup"><?php echo $MODERATE ?></span> </h4>
                                        <p class="mb-0" style="color: #674403;"> حرارة متوسطة </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards text-center" style="min-height: 114px;">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
                                <div class="card-body badge-soft-danger" style="min-height: 114px;">
                                    <div class="float-left mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/red.png" alt="الحرارة" style="width: 30px;"> </div>
                                    <div class="col-xl-10">
                                        <?php
                                        $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                        $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup" style="color: #670303;"><?php echo $HIGH ?></span> </h4>
                                        <p class="mb-0" style="color: #670303;"> حرارة عالية </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                        مجموع الفحوصات <?php echo $style['ar_co_type'] ?> لفحوصات درجة الحرارة والاختبارات المعملية</h4>
                </div>
                <div class="col-xl-12">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown">
                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted"> إختر الإختبار <i class="mdi mdi-chevron-down ml-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                <li class="dropdown-item" onclick="Tempratur_List('#simpl_Count_list','#New_Count_List');"> الحرارة </li>
                                                <?php foreach ($list_Tests as $test) { ?>
                                                    <li class="dropdown-item" onClick="labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                        <?php foreach ($get_style as $style) { ?>
                                            يوضح الرسم البياني إجمالي المستخدمين <?php echo $style['ar_co_type'] ?> </span>
                                        <?php } ?>
                                    </h4>
                                    (<span id="COUNTSHOWTESTNAME">الحرارة</span>)
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
                    <div class="col-12">
                        <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                            الفحوصات المخبرية</h4>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="position: relative">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    مجموع هؤلاء في الكل <?php echo $style['ar_co_type'] ?> <span data-plugin="counterup"><?php echo $studentscounter; ?> </span> الرسم البياني حسب الاختبارات المعملية
                                                <?php } ?>
                                            </h4>
                                            <div id="chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                                الاختبارات المعملية حسب-<?php echo $style['ar_co_type'] ?></h4>
                        </div>
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="position: relative">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">
                                                <div class="float-right">
                                                    <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">الإختبار<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                            <?php foreach ($list_Tests as $test) { ?>
                                                                <li class="dropdown-item" onClick="getDataChartByTestName_Company('<?php echo $test['Test_Desc']; ?>');"> <?php echo $test['Test_Desc']; ?> </li>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    مجموع هؤلاء في الكل <?php echo $style['ar_co_type'] ?> <span data-plugin="counterup"> <?php echo $studentscounter; ?> </span>يوضح الرسم البياني الاختبارات المعملية بواسطة<?php echo $style['ar_co_type']; ?>
                                                <?php } ?>
                                            </h4>
                                            </h4>
                                            <h5 class="float-left" id="__dept_chart"></h5>
                                            <div id="chart_by_dept" style="margin-top: 50px;" class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/images/ch.svg" width="40%;">
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
                            <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                                كل من في الحجر المنزلي <?php echo $style['ar_co_type'] ?> للفحوصات المخبرية</h4>
                        </div>
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">إختر الإختبار<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');">الحرارة </li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="home_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    يوضح الرسم البياني إجمالي عدد الأشخاص الموجودين في الحجر المنزلي وفقًا لنوع الفحص بشكل عام
                                                    <?php echo $style['ar_co_type'] ?> </span>
                                                <?php } ?>
                                            </h4>
                                            (<span id="STAYHOMESHOWTESTNAME">الحرارة</span>)
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

                            <div class="col-12">
                                <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                                    مجموع كل من هم في الحجر الصحي <?php echo $style['ar_co_type'] ?> للفحوصات المخبرية و الحرارة </h4>
                            </div>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">إختر الإختبار<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_Quaran_list','#New_Quaran_List');">الحرارة</li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="quarnt_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    يوضح الرسم البياني إجمالي الحجر الصحي حسب نوع الفحص في <?php echo $style['ar_co_type'] ?> </span>
                                                <?php } ?>
                                            </h4>
                                            (<span id="SQUAROMESHOWTESTNAME">درجات الحرارة</span>)
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
                                    <h5 class="m-0"> <span style="color:#0eacd8;text-align:center;"> الحجر المنزلي </span> </h5>
                                    <?php
                                    $our_depts = array();
                                    foreach ($our_schools as $school) {
                                        $high = 0;
                                        $high += GetTheCounter_OfAction($school['Id'], "الحجر المنزلي");
                                        if ($high !== 0) {
                                            $our_depts[] = array("Dept_Name_AR" => $school['Dept_Name_AR'], "Counter" => $high);
                                        }
                                    }

                                    ?>
                                    <?php if (!empty($our_depts)) {  ?>
                                        <table style="width: 100%;">
                                            <?php foreach ($our_depts as $depts) { ?>
                                                <tr>
                                                    <td><?php echo $depts['Dept_Name_AR']; ?></td>
                                                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?php echo $depts['Counter']; ?></span></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } else { ?>
                                        <div style="min-height: 409px;display: grid;align-content: center;align-items: center;">
                                            <div class="text-center">
                                                <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                                                <p class="font-16 text-muted mb-2"></p>
                                                <h5><a href="#" class="text-dark">لا توجد معلومات للعرض <span class="text-muted font-16"> -<br>
                                                            الحجر المنزلي </span> </a></h5>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card" style="border-color: #F44336;">
                                <div class="card-body" style="min-height: 469px; text-align: center;">
                                    <h5 class="m-0"> <span style="color:#ff2e00;text-align:center;"> الحجر الصحي</h5>
                                    <?php
                                    $our_depts = array();
                                    foreach ($our_schools as $school) {
                                        $high = 0;
                                        $high += GetTheCounter_OfAction($school['Id'], "الحجر الصحي");
                                        if ($high !== 0) {
                                            $our_depts[] = array("Dept_Name_AR" => $school['Dept_Name_AR'], "Counter" => $high);
                                        }
                                    }
                                    if (!empty($our_depts)) {
                                    ?>
                                        <table style="width: 100%;">
                                            <?php foreach ($our_depts as $depts) { ?>
                                                <tr>
                                                    <td><?php echo $depts['Dept_Name_AR']; ?></td>
                                                    <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?php echo $depts['Counter']; ?></span></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } else { ?>
                                        <div style="min-height: 409;display: grid;align-content: center;align-items: center;">
                                            <div class="text-center">
                                                <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                                                <p class="font-16 text-muted mb-2"></p>
                                                <h5><a href="#" class="text-dark"> لاتوجد معلومات للعرض <span class="text-muted font-16"> - الحجر الصحي </span> </a></h5>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-right: 0px;">
                            <div class="col-12">
                                <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                                    الاختبارات المعملية لجميع المواقع <?php echo $style['ar_co_type'] ?> - فحوصات مخبرية </h4>
                            </div>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">إختر الإختبار<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="sites_lab('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                                <?php foreach ($get_style as $style) { ?>
                                                    نتائج الفحوصات المخبرية للمواقع حسب نوع الفحص في <?php echo $style['ar_co_type'] ?> (<span id="sites_showType"> إختر الإختبار </span>) </h4>
                                        <?php } ?>
                                        </h4>
                                        <div id="table_sites_data">
                                            <div id="chart_by_dept" class="text-center">
                                                <div id="chart_by_dept" class="text-center">
                                                    <img src="<?php echo base_url(); ?>assets/images/complet_reg.png" width="25%;">
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
                <?php $this->load->view('AR/Company/inc/climate_dashboard')  ?>
            </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/dashboard.init.js"></script>
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
            name: "الكل",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc']) . ",";
                    } ?>]
        }, {
            name: "سلبي",
            data: [<?php foreach ($list_Tests as $test) {
                        echo Get_Data_ForeachSchool($test['Test_Desc'], '0') . ",";
                    } ?>]
        }, {
            name: "إيجابي",
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
                text: "مجموع الفحوصات"
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
                        return th + "ألف"
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
            url: '<?php echo base_url(); ?>AR/Results_company/getDataChartByTestName_Company',
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
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
    }
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
            $('#STAYHOMESHOWTESTNAME').html('درجات الحرارة');
        } else if (id == '#simpl_quarantin_list' && emp == '.New_quarantin_List') {
            $('#STAYQuarantineNOSHOWTESTNAME').html('درجات الحرارة ');
        } else if (id == '#simpl_staff_list' && emp == '#New_Staff_List') {
            $('#STAFFSNOSHOWTESTNAME').html('درجات الحرارة ');
        } else if (id == '#simpl_Teacher_list' && emp == '#New_Teacher_List') {
            $('#TEACHERSSNOSHOWTESTNAME').html('درجات الحرارة ');
        }

        $(id).slideDown();
        $(emp).html('');
    }

    function home_labTests(type) {
        $('#STAYHOMESHOWTESTNAME').html(type);
        $('#simpl_home_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/Results_company/Get_home_List_Ministry',
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

    function labTests(type) {
        $('#COUNTSHOWTESTNAME').html(type);
        $('#simpl_Count_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/Results_company/Get_home_List_Ministry',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Count_List').html(data);
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
            url: '<?php echo base_url(); ?>AR/Results_company/Get_home_List_Ministry',
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
            url: '<?php echo base_url(); ?>AR/Results_company/sites_data_table',
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
            <th class="Img_School">الصورة</th>
            <th style="text-align: center">الإسم</th>
            <th style="color: #cdfc00;">المنخفض</th>
            <th class="Risk" style="color: #00ab00;">طبيعي</th>
            <th style="color: #ff8200;">معتدل</th>
            <th style="color: #ff2e00;">عالي</th>
            <th style="color: #50a5f1">المجموع</th>
        </thead>
        <tbody>
            <?php
            $List = array();
            $our_depts = $ci->db->query(" SELECT  `Dept_Name_AR`,`Id` FROM `l1_co_department` 
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
                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $link; ?>" class="avatar-xs rounded-circle " alt="<?php echo $dept_result['Dept_Name_AR'] ?>">
                    </td>
                    <td>
                        <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $dept_result['Dept_Name_AR']; ?></h6>
                    </td>
                    <td style="background: #cdfc00;color: #3B3B3B;"><span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;"><?php echo $counter_low; ?></span></td>
                    <td style="background: #00ab00;color: #fff;"><span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;"><?php echo $counter_noRisk; ?></span></td>
                    <td style="background: #ff8200;color: #fff;"><span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;"><?php echo $counter_Moderate; ?></span></td>
                    <td style="background: #ff2e00;color: #fff;">
                        <span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"><?php echo $counter_high; ?></span>
                    </td>
                    <td style="text-align: center;" class="badge-info">
                        <span class="badge badge-info font-size-12" style="width: 100%;"><?php echo $counter; ?></span>
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
                    if ($result['Result'] > $from && $result['Result'] < $to) {
                        $counter++;
                    }
                }
            } else {
                $Results = $ci->db->query("SELECT * FROM `l2_co_monthly_result` WHERE 
			`UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' LIMIT 1 ")->result_array();
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
                    if ($result['Result'] > $from && $result['Result'] < $to) {
                        $counter++;
                    }
                }
            } else {
                $Results = $ci->db->query("SELECT * FROM `l2_co_monthly_result` WHERE 
			`UserType` = '" . $type . "' AND `UserId` = '" . $user['Id'] . "' AND `Created` = '" . $today . "' LIMIT 1 ")->result_array();
                if (!empty($Results)) {
                    foreach ($Results as $result) {
                        $counter++;
                    }
                }
            }
        }
    }




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
            <td><?php echo $siteResult['TestId'] ?></td>
            <td><?php echo $siteResult['Device_ID'] ?></td>
            <td><?php echo $siteResult['name'] ?></td>
            <td><?php echo $siteResult['LastReadDate'] ?></td>
            <td><?php echo $siteResult['Batch'] ?></td>
            <td><?php echo $siteResult['Testtype'] ?></td>
            <?php if ($siteResult['Action'] == "School") { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">سلبي (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">إيجابي (+)</span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">سلبي (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">إيجابي (+)</span></td>
                <?php } ?>
            <?php } ?>
            <td><?php if ($siteResult['Action'] == "School") { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="مغلق للتعقيم">
                <?php } ?>
            </td>
        </tr>
<?php
    }
}


?>
<script>
    options = {
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
            name: "الكل",
            data: [<?php actionsCounter("", $sessiondata['admin_id']); ?>],
        }, {
            name: " الحجر الصحي ",
            data: [<?php actionsCounter("الحجر الصحي", $sessiondata['admin_id']); ?>],
        }, {
            name: " الحجر المنزلي ",
            data: [<?php actionsCounter("الحجر المنزلي", $sessiondata['admin_id']); ?>],
        }, ],
        colors: ["#f1b44c", "#f46a6a", "#50a5f1"],
        xaxis: {
            categories: [
                <?php foreach ($supported_types as $type) { ?> "<?php echo ucfirst($type['UserType']); ?>",
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
            name: "الكل",
            data: [
                <?php
                $allourco = $this->db->query(" SELECT Dept_Name_AR , Id FROM `l1_co_department` WHERE
		`Added_By` = '" . $sessiondata['admin_id'] . "' AND `status` = '1' ")->result_array();
                foreach ($allourco as $co) {
                    $counter = 0;
                    $idd = $co['Id'];
                    $allUsersByType = array();
                    $allUsersByType_co =  $this->db->query("SELECT * FROM `l2_co_patient` 
		WHERE  `Added_By` = '" . $idd . "' ORDER BY `Id` DESC ")->result_array();
                    $counter += sizeof($allUsersByType_co);
                    echo $counter . ',';
                }
                ?>
            ],
        }, {
            name: "الحجر الصحي",
            data: [<?php actionsCounter_bydept("الحجر الصحي", $sessiondata['admin_id']); ?>],
        }, {
            name: "الحجر المنزلي",
            data: [<?php actionsCounter_bydept("الحجر المنزلي", $sessiondata['admin_id']); ?>],
        }, ],
        colors: ["#34c38f", "#f46a6a", "#50a5f1"],
        xaxis: {
            categories: [
                <?php foreach ($allourco as $dept) { ?> "<?php echo ucfirst($dept['Dept_Name_AR']); ?>",
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

    (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render();
    (chart = new ApexCharts(document.querySelector("#depts_chart"), options_dept)).render();

    var home = {
        chart: {
            height: 170,
            type: "radialBar",
        },

        series: [<?php echo get_percentage($studentscounter, $countOf_Home) ?>],
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
        labels: ["الحجر المنزلي"]
    };

    var chart = new ApexCharts(document.querySelector("#fix_xhart"), home);

    chart.render();

    var qua = {
        chart: {
            height: 170,
            type: "radialBar",
        },

        series: [<?php echo get_percentage($studentscounter, $countOf_quar) ?>],
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
        labels: ["الحجر الصحي"]
    };

    var chart = new ApexCharts(document.querySelector("#qua_xhart"), qua);
    chart.render();
    <?php if ($countOf_Home > 0 || $countOf_quar > 0) { ?>
        options = {
            chart: {
                height: 350,
                type: "donut"
            },
            series: [<?php echo $countOf_Home  ?>, <?php echo $countOf_quar  ?>],
            labels: ["حجر منزلي", "حجر صحي"],
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
                name: "المجاميع ",
                data: [<?php echo $countOf_Home  ?>, <?php echo $countOf_quar  ?>]
            }],
            colors: ["#34c38f", "#5b73e8", "#ff6f6f"],
            grid: {
                borderColor: "#f1f1f1"
            },
            xaxis: {
                categories: ["حجر منزلي", "حجر صحي"],
                position: "top",
                labels: {
                    offsetY: -18
                },
                axisBorder: {
                    show: !1
                },
                axisTicks: {
                    show: !1
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