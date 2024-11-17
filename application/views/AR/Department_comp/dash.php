<!doctype html>
<html lang="en">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<?php
$today = date("Y-m-d");
$idd = $sessiondata['admin_id'];
?>

<body class="light menu_light logo-white theme-white">
    <script>
        function UploadTheReportPdf(testId) {
            $('#site_result_id').val(testId);
            $('.theform').fadeIn();
            $('.StatusBoxStaff').html("");
        }
    </script>
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
    <style>
        th {
            text-align: center;
        }

        td {
            text-align: center;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                            أهلا وسهلا بكم في نظام متابعة درجات الحرارة والفحوصات المخبرية - <?php echo $sessiondata['f_name'] ?>
                        </h4>
                    </div>
                </div>

                <!-- start page title -->
                <?php
                //ChartofTempForStaff
                $parent = $this->db->query("SELECT Added_By FROM `l1_co_department` 
WHERE Id = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC")->result_array();
                $parentId =  $parent[0]['Added_By'];
                $parent_Infos = $this->db->query("SELECT * FROM `l0_organization` 
WHERE Id = '" . $parentId . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $parent_name = $parent_Infos[0]['Username'];

                $list_Tests = $this->db->query("SELECT * FROM `r_testcode`")->result_array();

                $supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`AR_UserType`
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
AND `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
                $usersConter = 0;
                foreach ($supported_types as $type) {
                    $allUsersByType =  $this->db->query("SELECT * FROM `l2_co_patient` 
WHERE `UserType` = '" . $type['UserType'] . "'
AND `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
                    if (!empty($allUsersByType)) {
                        $usersConter += sizeof($allUsersByType);
                    }
                }

                $allDevices = 0;
                $ListOfThisDevice;
                $All_added_Devices = $this->db->query("SELECT * FROM `l2_co_devices`
WHERE `Added_By` = $idd AND `Comments` = 'Thermometer'  ")->result_array();
                foreach ($All_added_Devices as $DevCr) {
                    $allDevices++;
                    $ListOfThisDevice[] = $DevCr["Created"];
                }

                $allDevices_lab = 0;
                $ListOfThisDevice_lab;
                $All_added_Devices_lab = $this->db->query("SELECT * FROM `l2_co_devices`
WHERE `Added_By` = $idd AND `Comments` = 'Lab'  ")->result_array();
                foreach ($All_added_Devices_lab as $DevCr) {
                    $allDevices_lab++;
                    $ListOfThisDevicelab[] = $DevCr["Created"];
                }

                ?>
                <?php /*?><div class="row">
<div class="col-md-3 col-xl-3 InfosCards">
<div class="card">
	<div class="card-body"  style="background-color: #3df0f0;padding: 5px">
	   <div class="card-body" style="background-color: #022326;" >
			<div class="float-right mt-2">
			   <!-- <div id="CharTTest1"></div>-->
 <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px">     
			</div>
			<div>
				 <?php
$all = $this->db->query("SELECT * FROM `l2_co_devices` WHERE `Added_By` = $idd  ")->num_rows(); 
$lasts = $this->db->query("SELECT * FROM `l2_co_devices`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
				 ?>
				<h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
				<p class="mb-0">مجموع الأجهزة</p>
			</div>
			<?php if(!empty($lasts)){ ?>
			<p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
			<?php foreach($lasts as $last){ ?>     
			<?php echo $last['Created'] ?></span><br>
			 آخر جهاز تم إضافته
			</p>
			<?php } ?>
			<?php }else{ ?>
			<p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
			<?php echo "--/--/--" ?></span><br>
			 آخر جهاز تم إضافته
			</p>
			<?php } ?>
	 </div> 
	</div>
	</div>
</div> <!-- end col-->
<div class="col-md-3 col-xl-3 InfosCards">
  <div class="card">
	  <div class="card-body" style="background-color: #ff26be;padding: 5px">
		  <div class="card-body"  style="background-color: #2e001f;">
					<div class="float-right mt-2">
		 <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Devices_Icons.png" 
		  alt="schools" width="50px">     
					</div>
					<div>
						 <?php 
$allDevices = 0;
$ListOfThisDevice;                              
$All_added_Devices = $this->db->query("SELECT * FROM `l2_co_devices`
WHERE `Added_By` = $idd AND `Comments` = 'Thermometer'  ")->result_array(); 
foreach($All_added_Devices as $DevCr ){
$allDevices++;
$ListOfThisDevice[] = $DevCr["Created"];
}
					?>
	 <h4 class="mb-1 mt-1">
	 <span data-plugin="counterup"><?php echo $allDevices ?></span>
	 </h4>
	 <p class="mb-0">مجموع موازين الحرارة</p>
					</div>
					<?php if(!empty($ListOfThisDevice)){ ?>
					<p class="mt-3 mb-0">
						<span class="mr-1">
					<?php echo $ListOfThisDevice[0] ?>
						</span><br>
					 أخر ميزان حرارة تم إضافته
					</p>
					<?php }else{ ?>
					<p class="mt-3 mb-0">
					<span class="mr-1">
					<?php echo "--/--/--"; ?>
					</span><br>
					 أخر ميزان حرارة تم إضافته
					</p>
					<?php } ?>
		  </div>
	  </div>
  </div>
</div> <!-- end col-->
<div class="col-md-3 col-xl-3 InfosCards">
  <div class="card">
	  <div class="card-body" style="background-color: #ffd70d;padding: 5px">
		  <div class="card-body" style="background-color: #262002;">
					<div class="float-right mt-2">
		 <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Lab_Devices_Icons.png" 
		  alt="schools" width="50px">     
					</div>
					<div>
<?php 
$allDevices_lab = 0;
$ListOfThisDevice_lab;                              
$All_added_Devices_lab = $this->db->query("SELECT * FROM `l2_co_devices`
WHERE `Added_By` = $idd AND `Comments` = 'Lab'  ")->result_array(); 
foreach($All_added_Devices_lab as $DevCr ){
$allDevices_lab++;
$ListOfThisDevicelab[] = $DevCr["Created"];
}
?>
	 <h4 class="mb-1 mt-1">
	 <span data-plugin="counterup"><?php echo $allDevices_lab ?></span>
	 </h4>
	 <p class="mb-0">مجموع الأجهزة المخبرية</p>
					</div>
					<?php if(!empty($ListOfThisDevicelab)){ ?>
					<p class="mt-3 mb-0"><span class="mr-1">
					<?php echo $ListOfThisDevicelab[0] ?>
						</span><br>
						أخر جهاز مخبري تم إضافته
					</p>
					<?php }else{ ?>
					<p class="mt-3 mb-0">
					<span class="mr-1" >
					<?php echo "--/--/--"; ?>
					</span><br>
						أخر جهاز مخبري تم إضافته
					</p>
					<?php } ?>
		  </div>
	  </div>
  </div>
</div> <!-- end col-->
<div class="col-md-3 col-xl-3 InfosCards">
					  <div class="card">
						  <div class="card-body"  style="background-color: #3cf2a6;padding: 5px">
							  <div class="card-body" style="background-color: #00261a;">
										<div class="float-right mt-2">
							 <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Lab_Devices_Icons.png" 
							  alt="schools" width="50px">     
										</div>
										<div>
			   <?php 
			   $allDevicesGateway = 0;
			   $ListOfThisDevice;                              
			   $All_added_Devices_Gateway = $this->db->query("SELECT * FROM `l2_co_devices`
			   WHERE `Added_By` = $idd AND `Comments` = 'Gateway'  ")->result_array(); 
			   foreach($All_added_Devices_Gateway as $DevGateway ){
					$allDevicesGateway++;
					$ListOfThisDeviceGateway[] = $DevGateway["Created"];
			   }
			   ?>
						 <h4 class="mb-1 mt-1">
						 <span data-plugin="counterup"><?php echo $allDevicesGateway ?></span>
						 </h4>
						 <p class="mb-0">مجموع أجهزة البوابات</p>
										</div>
										<?php if(!empty($ListOfThisDeviceGateway)){ ?>
										<p class="mt-3 mb-0"><span class="mr-1">
										<?php echo $ListOfThisDeviceGateway[0] ?>
											</span><br>
										 أخر جهاز بوابة تم إضافته
										</p>
										<?php }else{ ?>
										<p class="mt-3 mb-0">
										<span class="mr-1" >
										<?php echo "--/--/--"; ?>
										</span><br>
										 أخر جهاز بوابة تم إضافته
										</p>
										<?php } ?>
							  </div>
						  </div>
					  </div>
					</div> <!-- end col-->
</div> 
<?php */ ?>
                <div class="row">
                    <div class="col-md-3 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                <div class="card-body" style="background-color: #022326;">
                                    <div class="float-right mt-2">
                                        <!-- <div id="CharTTest1"></div>-->
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px">
                                    </div>
                                    <div>
                                        <?php
                                        $idd = $sessiondata['admin_id'];
                                        $all = $this->db->query("SELECT * FROM `l2_co_devices` WHERE `Added_By` = $idd  ")->num_rows();
                                        $lasts = $this->db->query("SELECT * FROM `l2_co_devices`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                        <p class="mb-0">مجموع الأجهزة</p>
                                    </div>
                                    <?php if (!empty($lasts)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
                                                <?php foreach ($lasts as $last) { ?>
                                                    <?php echo $last['Created'] ?></span><br>
                                            آخر جهاز تم إضافته
                                        </p>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
                                            <?php echo "--/--/--" ?></span><br>
                                        آخر جهاز تم إضافته
                                    </p>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                <div class="card-body" style="background-color: #605091;">
                                    <div class="float-right mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/temperature_counter.png" alt="Test" width="50px"> </div>
                                    <div>
                                        <?php
                                        $studentscounter = 0;
                                        $lastaddeds = array();
                                        $patient = $this->db->query(" SELECT Created FROM 
				  `l2_co_patient` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
                                        if (!empty($patient)) {
                                            $studentscounter += sizeof($patient);
                                            $lastaddeds[] = $patient[0]['Created'];
                                        }
                                        ?>
                                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                                                <?php echo $studentscounter;  ?>
                                            </span> </h4>
                                        <p class="mb-0">مجموع المستخدمين</p>
                                    </div>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                            <?php
                                            //print_r($test);
                                            if (!empty($lastaddeds)) {
                                                $last = sizeof($lastaddeds);
                                            ?>
                                                <?php echo $lastaddeds[$last - 1]; ?></span><br>
                                        أخر مستخدم تم إضافته
                                    <?php } else { ?>
                                        <?php echo "--/--/--"; ?></span><br>
                                        أخر مستخدم تم إضافته
                                    <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                <div class="card-body" style="background-color: #694811;">
                                    <div class="float-right mt-2"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px"> </div>
                                    <div>
                                        <?php
                                        $allSites = 0;
                                        $ListOfSitesforThis = array();
                                        /*$All_added_schools = $this->db->query("SELECT * FROM `l1_school`
              WHERE `Added_By` = $idd ")->result_array();*/
                                        $SitesforThis = $this->db->query("SELECT * FROM `l2_co_site`
                    WHERE Added_by = '" . $sessiondata['admin_id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($SitesforThis as $Sites) {
                                            $allSites++;
                                            $ListOfSitesforThis[] = $Sites["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                        ?>
                                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?php echo $allSites ?></span> </h4>
                                        <p class="mb-0">مجموع المواقع</p>
                                    </div>
                                    <?php if (!empty($ListOfSitesforThis)) { ?>
                                        <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> <?php echo $ListOfSitesforThis[0] ?> </span><br>
                                            اخر موقع تم إضافته </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?php echo "--/--/--" ?></span><br>
                                            اخر موقع تم إضافته </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                <div class="card-body" style="background-color: #00261a;">
                                    <div class="float-right mt-2">
                                        <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Lab_Devices_Icons.png" alt="schools" width="50px">
                                    </div>
                                    <div>
                                        <?php
                                        $allDevicesGateway = 0;
                                        $ListOfThisDevice;
                                        $All_added_Devices_Gateway = $this->db->query("SELECT * FROM `l2_co_devices`
WHERE `Added_By` = $idd AND `Comments` = 'Gateway'  ")->result_array();
                                        foreach ($All_added_Devices_Gateway as $DevGateway) {
                                            $allDevicesGateway++;
                                            $ListOfThisDeviceGateway[] = $DevGateway["Created"];
                                        }
                                        ?>
                                        <h4 class="mb-1 mt-1">
                                            <span data-plugin="counterup"><?php echo $allDevicesGateway ?></span>
                                        </h4>
                                        <p class="mb-0">مجموع أجهزة البوابات</p>
                                    </div>
                                    <?php if (!empty($ListOfThisDeviceGateway)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1">
                                                <?php echo $ListOfThisDeviceGateway[0] ?>
                                            </span><br>
                                            أخر جهاز بوابة تم إضافته
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0">
                                            <span class="mr-1">
                                                <?php echo "--/--/--"; ?>
                                            </span><br>
                                            أخر جهاز بوابة تم إضافته
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div>


                <div class="row">
                    <div class="col-xl-12">

                        <div class="card">
                            <div class="card-body ">

                                <div style="padding: 20px;padding-bottom: 0px;">
                                    <div class="float-right">

                                        <div class="dropdown">
                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted"><b>إختر نوع الفحص</b><i class="mdi mdi-chevron-down ml-1"></i></span>
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
                                                <li class="dropdown-item" onClick="Tempratur();">الحرارة</li>
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
                                        المؤشرات اليومية <?php echo $today; ?>
                                    </h4>
                                </div>
                                <div class="row" style="padding: 20px;" id="TempCounters">
                                    <div class="col-xl-12">
                                        <div class="card-body" style="border-radius: 5px;border: 3px solid #0eacd8;padding: 9px;">
                                            <h4 class="card-title">
                                                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> الحرارة
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
                                                            <p class="mb-0 badge badge-success font-size-12">حرارة طبيعية</p>
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
                                                        $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                                                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/orange.png" alt="Low Temperature" style="width: 30px;">
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <p class="mb-0 badge badge-warning font-size-12">حرارة منخفضة</p>
                                                                <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">الحجر المنزلي <?php echo $LOW_In_Home; ?></span>
                                                                <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;display: block;">الحجر الصحي <?php echo $LOW_In_Quern; ?></span>
                                                                <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;display: block;">لا إجرائات <?php echo $LOW_In_School; ?></span>
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
                                                            $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                                            ?>
                                                            <p class="mb-0 badge badge-danger font-size-12">حرارة عالية</p>
                                                            <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">الحجر المنزلي <?php echo $HIGH_In_Home; ?></span>
                                                            <span class="badge font-size-12" style="width: 104px;background-color: #ff2e00;color: #fff;margin: 5px auto;display: block;">الحجر الصحي <?php echo $HIGH_In_Quern; ?></span>
                                                            <span class="badge font-size-12" style="width: 104px;background-color: #00ab00;color: #fff;margin: 5px auto;display: block;"> لا إجرائات <?php echo $HIGH_In_School; ?></span>
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
                                                            <h4 class="mb-1 mt-1">
                                                                <span data-plugin="counterup"><?php echo $MODERATE; ?></span>
                                                            </h4>
                                                            <p class="mb-0 badge badge-info font-size-12" style="width: 103px;"> متوسطة </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-->
                                </div>
                            </div>

                            <style>
                                * {
                                    list-style: none;
                                    margin: 0;
                                    padding: 0;
                                    box-sizing: border-box;
                                }

                                .title {
                                    background: #f3f4f8;
                                    padding: 15px;
                                    font-size: 18px;
                                    text-align: center;
                                    text-transform: uppercase;
                                    letter-spacing: 3px;
                                }

                                .file_upload_list li .file_item {
                                    display: flex;
                                    border-bottom: 1px solid #f3f4f8;
                                    padding: 15px 20px;
                                }

                                .file_item .format {
                                    background: #8178d3;
                                    border-radius: 10px;
                                    width: 45px;
                                    height: 40px;
                                    line-height: 40px;
                                    color: #fff;
                                    text-align: center;
                                    font-size: 12px;
                                    margin-right: 15px;
                                }

                                .file_item .file_progress {
                                    width: calc(100% - 60px);
                                    font-size: 14px;
                                }

                                .file_item .file_info,
                                .file_item .file_size_wrap {
                                    display: flex;
                                    align-items: center;
                                }

                                .file_item .file_info {
                                    justify-content: space-between;
                                }

                                .file_item .file_progress .progress {
                                    width: 100%;
                                    height: 4px;
                                    background: #efefef;
                                    overflow: hidden;
                                    border-radius: 5px;
                                    margin-top: 8px;
                                    position: relative;
                                }

                                .file_item .file_progress .progress .inner_progress {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background: #58e380;
                                }

                                .file_item .file_size_wrap .file_size {
                                    margin-right: 15px;
                                }

                                .file_item .file_size_wrap .file_close {
                                    border: 1px solid #8178d3;
                                    color: #8178d3;
                                    width: 20px;
                                    height: 20px;
                                    line-height: 18px;
                                    text-align: center;
                                    border-radius: 50%;
                                    font-size: 10px;
                                    font-weight: bold;
                                    cursor: pointer;
                                }

                                .file_item .file_size_wrap .file_close:hover {
                                    background: #8178d3;
                                    color: #fff;
                                }

                                .choose_file label {
                                    display: block;
                                    border: 2px dashed #8178d3;
                                    padding: 15px;
                                    width: calc(100% - 20px);
                                    margin: 10px;
                                    text-align: center;
                                    cursor: pointer;
                                }

                                .choose_file #choose_file {
                                    outline: none;
                                    opacity: 0;
                                    width: 0;
                                }

                                .choose_file span {
                                    font-size: 14px;
                                    color: #8178d3;
                                }

                                .choose_file label:hover span {
                                    text-decoration: underline;
                                }
                            </style>
                            <style>
                                .file_upload_list {
                                    text-align: center;
                                }

                                .card {
                                    border: 0px;
                                }

                                .progress {
                                    margin-top: 10px;
                                }

                                h6 {
                                    padding: 5px;
                                }
                            </style>
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myModalLabel"> إرفع ملف التقرير </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="theform">
                                                <div class="file_upload_list">
                                                    <i class="display-4 text-muted uil uil-cloud-upload"></i>
                                                </div>
                                                <form id="uploadPdf" name="Pdf_site">
                                                    <div class="choose_file">
                                                        <label for="choose_file">
                                                            <input type="file" id="choose_file" name="csvFileStaff" accept=".pdf">
                                                            <input type="hidden" id="site_result_id" name="site_result_id">
                                                            <span>إختر ملف</span>
                                                        </label>
                                                    </div>
                                                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 
				StatusbtnStaff">
                                                        إبدأ الرفع
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="StatusBoxStaff">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">إلغاء</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <!-- modal -->
                            <script>
                                $("#uploadPdf").on('submit', function(e) {
                                    e.preventDefault();
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo base_url(); ?>AR/Ajax/UploadSiteReport?type="Dept"',
                                        data: new FormData(this),
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function(data) {
                                            $('.theform').fadeOut();
                                            $('.StatusBoxStaff').html(data);
                                            $('.StatusbtnStaff').removeAttr('disabled');
                                        },
                                        beforeSend: function() {
                                            $('.StatusbtnStaff').attr('disabled', '');
                                            $('.StatusbtnStaff').html('إنتظر من فضلك');
                                        },
                                        ajaxError: function() {
                                            $('.alert.alert-info').css('background-color', '#DB0404');
                                            $('.alert.alert-info').html("Ooops! Error was found.");
                                        }
                                    });
                                });
                            </script>

                            <div class="row" style="padding: 20px;" id="Plus_Minus">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="counters_chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <img src="<?php echo base_url(); ?>assets/images/lo1.png" style="width: 25px;margin: auto 5px;">
                                            مجموع المستخدمين : <span data-plugin="counterup"><?php echo $usersConter ?></span>
                                        </h4>
                                        <div id="column_chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown">
                                                    <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted"><b>إختر نوع الفحص</b><i class="mdi mdi-chevron-down ml-1"></i></span>
                                                    </a>
                                                    <style>
                                                        .dropdown-menu * {
                                                            cursor: pointer;
                                                        }
                                                    </style>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;position: relative;">
                                                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_staff_list','#New_Staff_List');">الحرارة</li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item" onClick="staff_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </h4>
                                        <h4 class="card-title mb-4">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;">
                                            الفحوصات المخبرية اليومية <?php echo $today; ?>
                                        </h4>
                                        (<span id="STAFFSNOSHOWTESTNAME">الحرارة</span>)
                                        </h4>
                                        <style>
                                            .badge {
                                                text-align: center;
                                            }

                                            .Td-Results {
                                                color: #FFFFFF;
                                            }
                                        </style>
                                        <div data-simplebar style="height: 400px;overflow: auto;">
                                            <div id="simpl_staff_list">
                                                <?php
                                                $list = array();
                                                $today = date("Y-m-d");
                                                $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                                                foreach ($Ourstaffs as $staff) {
                                                    $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
                                                    $ID = $staff['Id'];
                                                    $action = $staff['Action'];
                                                    $Position_Staff = $staff['Position'];
                                                    $type = $staff['UserType']; // reading result by Result_Date instead of created 
                                                    $getResults = $this->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staff['Id'] . "'
                                                    AND Result_Date = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                                                    foreach ($getResults as $results) {
                                                        $list[] = array(
                                                            "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'],
                                                            "Result" => $results['Result'], "Creat" => $results['Created'], 'position' => $Position_Staff, "UserType" => $type,
                                                            "Creat" => $results['Created'] . ' ' . $results['Time'], "Action" => $action
                                                        );
                                                    }
                                                } ?>
                                                <table class="table table-borderless table-centered table-nowrap table_sites ">
                                                    <thead>
                                                        <th width="10%"> الصورة </th>
                                                        <th width="14%"> الإسم </th>
                                                        <th width="12%" class="text-center"> النتيجة </th>
                                                        <th width="12%" class="text-center"> الحالة </th>
                                                        <th width="12%" class="text-center"> نوع المستخدم </th>
                                                        <th width="12%" class="text-center"> التاريخ والوقت </th>
                                                        <th width="12%" class="text-center">حالة المستخدم</th>
                                                        <th width="12%" class="text-center">إجراءات </th>
                                                    </thead>
                                                    <tbody>

                                                        <?php foreach ($list as $staffsRes) { ?>

                                                            <tr>
                                                                <td style="width: 20px;">
                                                                    <?php
                                                                    $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = '" . $staffsRes['UserType'] . "' LIMIT 1 ")->result_array();
                                                                    ?>
                                                                    <?php if (empty($avatar)) {  ?>
                                                                        <img src="<?php echo base_url(); ?>uploads/co_avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $staffsRes['position']; ?></p>
                                                                </td>
                                                                <?php boxes_Colors($staffsRes['Result']); ?>
                                                                <?php $userTranslate = $this->db->query("SELECT `AR_UserType` FROM `r_usertype` 
	WHERE UserType = '" . $staffsRes['UserType'] . "' ")->result_array(); ?>
                                                                <td class="text-center"><?php echo $userTranslate[0]['AR_UserType']; ?></td>
                                                                <td class="text-center"><?php echo $staffsRes['Creat']; ?></td>
                                                                <?php
                                                                $faction = "";
                                                                if ($staffsRes['Action'] == "work") {
                                                                    $faction = "العمل";
                                                                } elseif ($staffsRes['Action'] == "الحجر الصحي") {
                                                                    $faction = "الحجر الصحي";
                                                                } else {
                                                                    $faction  = "الحجر المنزلي";
                                                                    //$faction  = $staffsRes['Action'];
                                                                }
                                                                ?>
                                                                <td class="text-center"> <?php echo $faction ?></td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0);" class="px-3 text-primary" onClick="setmemberInAction(<?php echo $staffsRes['Id'] ?>,'<?php echo $staffsRes['UserType']; ?>','Home');" data-toggle="tooltip" data-placement="top" title="" data-original-title="الحجر المنزلي" theid="23">
                                                                        <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                                                                    </a>
                                                                    <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" onClick="setmemberInAction(<?php echo $staffsRes['Id'] ?>,'<?php echo $staffsRes['UserType']; ?>','Quarantine',);" data-placement="top" title="الحجر الصحي" theid="23">
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
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;">الفحوصات المخبرية <?php echo $today; ?>
                                            <font color=#e13e2b> (المواقع)</font>
                                        </h4>

                                        <table class="table table_sites">
                                            <thead>
                                                <tr>
                                                    <th> إسم الموقع </th>
                                                    <th> وصف الموقع </th>
                                                    <th> التاريخ والوقت </th>
                                                    <th> رقم الباتش </th>
                                                    <th> نوع الفحص </th>
                                                    <th> النتيجة </th>
                                                    <th> الإجراءات </th>
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
                                        <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;">قائمة فحوصات المواقع <font color=#e13e2b> (المواقع المغلقة للتعقيم)</font>
                                        </h4>
                                        <table class="table table_sites">
                                            <thead>
                                                <tr>
                                                    <th> إسم الموقع </th>
                                                    <th> وصف الموقع</th>
                                                    <th> التاريخ والوقت</th>
                                                    <th> رقم الباتش </th>
                                                    <th> نوع الفحص </th>
                                                    <th> النتيجة</th>
                                                    <th> التقرير</th>
                                                    <th> الإجراءات </th>
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
                <!-- end page title -->
                <!-- end row-->
                <?php
                $today = date("Y-m-d");
                $allUsersTypes = $this->db->query("SELECT * FROM `r_usertype`")->result_array();
                // id = $sessiondata['admin_id'];
                function actionsCounter($action, $id)
                {
                    $today = date("Y-m-d");
                    $ci = &get_instance();
                    $ci->load->library('session');
                    $sessiondata = $ci->session->userdata('admin_details');
                    //$allUsersTypes = $ci->db->query("SELECT * FROM `r_usertype`")->result_array();
                    $ci->db->select('*');
                    $ci->db->from('r_usertype');
                    $allUsersTypes = $ci->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`UserType`
	 FROM `r_usertype` 
	 JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
	 AND `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();

                    foreach ($allUsersTypes as $type) {
                        $count_home = 0;
                        $u_type = $type['UserType'];
                        $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = '" . $id . "'
	 AND `UserType` = '" . $u_type . "' AND `Action` = '" . $action . "' ")->result_array();
                        foreach ($ours as $user) {
                            $count_home++;
                        }
                        echo $count_home . ",";
                    }
                }

                ?>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown">
                                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">
                                                    <b>إختر نوع الفحص</b><i class="mdi mdi-chevron-down ml-1"></i></span>
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
                                    الحجر المنزلي(<span id="STAYHOMESHOWTESTNAME">الحرارة</span>)
                                </h4>


                                <div data-simplebar style="height: 350px;overflow: auto;">
                                    <div id="simpl_home_list">
                                        <table class="table table-borderless table-centered table-nowrap table_sites ">
                                            <thead>
                                                <th> الصورة </th>
                                                <th> الإسم </th>
                                                <th> التاريخ والوقت </th>
                                                <th> النتيجة </th>
                                                <th> الحالة </th>
                                                <th> الأيام </th>
                                                <th> الإجراءات </th>
                                            </thead>
                                            <tbody>
                                                <style>
                                                    .badge {
                                                        text-align: center;
                                                    }
                                                </style>
                                                <?php StayHomeOf(); ?>
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
                                                <span class="text-muted"><b>إختر نوع الفحص</b><i class="mdi mdi-chevron-down ml-1"></i></span>
                                            </a>
                                            <style>
                                                .dropdown-menu * {
                                                    cursor: pointer;
                                                }
                                            </style>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                <li class="dropdown-item" onclick="Tempratur_List('#simpl_quarantin_list','.New_quarantin_List');">الحرارة </li>
                                                <?php foreach ($list_Tests as $test) { ?>
                                                    <li class="dropdown-item" onClick="quarntine_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </h4>
                                <h4 class="card-title mb-4"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> الحجر الصحي (<span id="STAYQuarantineNOSHOWTESTNAME">الحرارة</span>) </h4>

                                <div data-simplebar style="height: 350px;overflow: auto;">
                                    <div id="simpl_quarantin_list">
                                        <table class="table table-borderless table-centered table-nowrap table_sites ">
                                            <thead>
                                                <th> الصورة </th>
                                                <th> الإسم </th>
                                                <th> التاريخ والوقت </th>
                                                <th> النتيجة </th>
                                                <th> الحالة </th>
                                                <th> الأيام </th>
                                                <th> الإجراءات </th>
                                            </thead>
                                            <tbody>
                                                <?php StayHomeOfQuarantin();  ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                    <div class="New_quarantin_List"></div>
                                </div>
                            </div> <!-- data-sidebar-->
                        </div><!-- end card-body-->
                    </div>
                </div><!-- end col -->
                <div id="return"></div>
                <?php $this->load->view('AR/Department_comp/inc/climate_dashboard')  ?>
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
        $(".table_sites").DataTable({
            language: {
                url: '<?php echo base_url(); ?>assets/js/arabic_datatable.json'
            }
        });
    } catch (err) {
        console.log("Error " + err);
    }

    function GetStaffChart() {
        $('#SelectTheClassCard').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/ChartofTempForStaff',
            beforeSend: function() {
                $('#drawChart').html('');
                $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">جاري التحميل</span></div>');
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



    function GetTheStaffResults() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/ListResultsOfStaffs',
            beforeSend: function() {
                $('#ResultsTable').html('');
                $('#ResultsTable').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">جاري التحميل</span></div>');
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
            url: '<?php echo base_url(); ?>AR/schools/ListResultsOfDtudents',
            data: {
                class: className,
            },
            beforeSend: function() {
                $('#ResultsTableStudents').html('');
                $('#ResultsTableStudents').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">جاري التحميل</span></div>');
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
            url: '<?php echo base_url(); ?>AR/schools/ListConnectedTeachers',
            data: {
                class: className,
            },
            beforeSend: function() {
                $('#TeachersCon').html('');
                $('#TeachersCon').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">جاري التحميل</span></div>');
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
            title: 'متأكد من هذا الإجراء',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: ` نعم `,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Company_Departments/ApplyActionOnMember',
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
                            'oops!! لدينا خطأ',
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
            title: 'متأكد من هذا الإجراء',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: ` نعم `,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Ajax/Set_ActiononSite_comp',
                    data: {
                        S_Id: theId,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
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

    function Remove_SiteFromAction(id) {
        var theId = id;
        Swal.fire({
            title: 'متأكد من هذا الإجراء',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: ` نعم `,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Ajax/Remove_ActiononSite_comp',
                    data: {
                        S_Id: theId,
                    },
                    success: function(data) {
                        $('#return').html(data);
                    },
                    ajaxError: function() {
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

    function RemoveThisMemberFrom(id, usertype, action) {
        var theId = id;
        //console.log(theId + "  type  " + usertype +  "  action  " + action );
        Swal.fire({
            title: 'متأكد من هذا الإجراء',
            showCancelButton: true,
            confirmButtonText: ` نعم `,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Company_Departments/ApplyActionOnMember',
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
                            'oops!! لدينا خطأ',
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
            title: 'متأكد من هذا الإجراء',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: ` نعم `,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Company_Departments/ApplyLabActionOnMember_lab',
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
                            'oops!! لدينا خطأ',
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
            url: '<?php echo base_url(); ?>AR/Results_company/GetResultsCounterFor',
            data: {
                TeatsType: type,
            },
            success: function(data) {
                $('#Plus_Minus').html(data);
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
            url: '<?php echo base_url(); ?>AR/ajax/GetClassesList',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('.New_Select').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
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
            url: '<?php echo base_url(); ?>AR/ajax/Get_Staffs_List_comp',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Staff_List').html(data);
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

    function quarntine_labTests(type) {
        $('#STAYQuarantineNOSHOWTESTNAME').html(type);
        $('#simpl_quarantin_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/ajax/Get_Quaranrine_List_co',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('.New_quarantin_List').html(data);
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
    //simpl_home_list

    function home_labTests(type) {
        $('#STAYHOMESHOWTESTNAME').html(type);
        $('#simpl_home_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/ajax/Get_home_List_company',
            data: {
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


    function Teacher_labTests(type) {
        $('#TEACHERSSNOSHOWTESTNAME').html(type);
        $('#simpl_Teacher_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/ajax/Get_Teachers_List',
            data: {
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Teacher_List').html(data);
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

<?php

function StayHomeOf()
{
    $ci = &get_instance();
    $count_home = 0;
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');

    $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE 
	 `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Action` = 'Home'   ")->result_array();
    $listTeachers = array();
    $today = date("Y-m-d");
    foreach ($ours as $Teacher) {
        $Teachername = $Teacher['F_name_AR'] . ' ' . $Teacher['L_name_AR'];
        $ID = $Teacher['Id'];
        $Position = $Teacher['Position'];
        $type = $Teacher['UserType'];
        $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($getResults_Teacheer as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
            $listTeachers[] = array(
                "Username" => $Teachername, "Id" => $ID,
                "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
                "U_Type" => $type
            );
        }
    }
    $count_home += sizeof($listTeachers);
    foreach ($listTeachers as $TeacherRes) { ?>
        <tr>
            <td style="width: 20px;">
                <?php
                $avatar = $ci->db->query("SELECT * FROM `l2_co_avatars`
          WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $TeacherRes['U_Type'] . "' LIMIT 1 ")->result_array();
                ?>
                <?php if (empty($avatar)) {  ?>
                    <img src="<?php echo base_url(); ?>uploads/co_avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
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
                    echo "اليوم";
                } elseif ($finalDate > 2) {
                    echo $finalDate . " أيام";
                } else {
                    echo $finalDate . " يوم";
                }
                ?>
            </td>
            <td class="out">
                <?php //print_r($TeacherRes); 
                ?>
                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'<?php echo $TeacherRes['U_Type'] ?>','work');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title=" مغادرة الحجر">
            </td>
        </tr>
    <?php }
}

function StayHomeOfQuarantin()
{
    $ci = &get_instance();
    $count_home = 0;
    $ci->load->library('session');
    $sessiondata = $ci->session->userdata('admin_details');
    ///////
    $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE 
	 `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Action` = 'Quarantine'  ")->result_array();
    $listTeachers = array();
    $today = date("Y-m-d");
    foreach ($ours as $Teacher) {
        $Teachername = $Teacher['F_name_AR'] . ' ' . $Teacher['L_name_AR'];
        $ID = $Teacher['Id'];
        $Position = $Teacher['Position'];
        $type = $Teacher['UserType'];
        $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($getResults_Teacheer as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
            $listTeachers[] = array(
                "Username" => $Teachername, "Id" => $ID,
                "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
                "U_Type" => $type
            );
        }
    }
    $count_home += sizeof($listTeachers);
    foreach ($listTeachers as $TeacherRes) { ?>
        <tr>
            <td style="width: 20px;">
                <?php
                $avatar = $ci->db->query("SELECT * FROM `l2_co_avatars`
          WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $TeacherRes['U_Type'] . "' LIMIT 1 ")->result_array();
                ?>
                <?php if (empty($avatar)) {  ?>
                    <img src="<?php echo base_url(); ?>uploads/co_avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
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
                    echo "اليوم";
                } elseif ($finalDate > 2) {
                    echo $finalDate . " أيام";
                } else {
                    echo $finalDate . " يوم";
                }
                ?>
            </td>
            <td class="out">
                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'<?php echo $TeacherRes['U_Type']; ?>','work');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="مغادرة الحجر">
            </td>
        </tr>
    <?php }
}

function dateDiffInDays($date1, $date2)
{
    // Calculating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1);

    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400));
}

function GetListOfSites($list_Tests)
{
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_co_site` WHERE 
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
        $site_name = $site['Site_Code'];
        $getResults = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND 
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
        //print_r($getResults);
        foreach ($getResults as $T_results) {
            $lastReads = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
            //if(!empty($lastRead)){
            $lastRead = $lastReads[0]['Result'];
            $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
            $listSites[] = array(
                "name" => $name, "Id" => $ID,
                "Testtype" => $T_results['Test_Description'],
                "Device_ID" =>  $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "site_name" => $site_name
            );
            //}	
        }
    }
    ///print_r($listSites);
    foreach ($listSites as $siteResult) {
    ?>
        <tr>
            <td><?php echo $siteResult['name'] ?></td>
            <td><?php echo $siteResult['site_name'] ?></td>
            <td><?php echo $siteResult['LastReadDate'] ?></td>
            <td><?php echo $siteResult['Batch'] ?></td>
            <td><?php echo $siteResult['Testtype'] ?></td>
            <?php if ($siteResult['Action'] == "work") { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">سلبي (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">إيجابي(+)</span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">سلبي (-)</span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">إيجابي (+)</span></td>
                <?php } ?>
            <?php } ?>
            <td>
                <?php if ($siteResult['Action'] == "work") { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="مغلق للتعقيم">
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
            $site_name = $site['Site_Code'];
            $getResults = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND `Action` = '" . $action . "' AND
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
            //print_r($getResults);
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                    "Device_ID" =>  $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
                );
                //}	
            }
        }
    } else {
        foreach ($sitesForThisUser as $site) {
            $name = $site['Description'];
            $site_name = $site['Site_Code'];
            $ID = $site['Id'];
            $getResults = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $site['Id'] . "'
     AND UserType = 'Site' AND `Action` = '" . $action . "' AND
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
            //print_r($getResults);
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "Testtype" => $T_results['Test_Description'], "TestId" => $T_results['Id'],
                    "Device_ID" =>  $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name
                );
                //}	
            }
        }
    }
    ///print_r($listSites);
    foreach ($listSites as $siteResult) { ?>
        <tr>
            <td><?php echo $siteResult['name'] ?></td>
            <td><?php echo $siteResult['SiteName'] ?></td>
            <td><?php echo $siteResult['LastReadDate'] ?></td>
            <td><?php echo $siteResult['Batch'] ?></td>
            <td><?php echo $siteResult['Testtype'] ?></td>
            <?php if ($siteResult['Action'] == "School") { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;"> (-) سلبي </span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #d2d2d2;"> (+) إيجابي </span></td>
                <?php } ?>
            <?php } else { ?>
                <?php if ($siteResult['Result'] == '0') { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #008700;color: #ffffff;"> (-) سلبي </span></td>
                <?php } else { ?>
                    <td><span class="badge font-size-12" style="width: 100%;background-color: #B82100;color: #d2d2d2;"> (+) إيجابي </span></td>
                <?php } ?>
            <?php } ?>
            <td>
                <i class="uil uil-file" data-toggle="modal" data-target="#myModal" style="font-size: 19px;color: #2eb6ef;cursor: pointer;" onClick="UploadTheReportPdf(<?php echo $siteResult['TestId'] ?>);"></i>
            </td>
            <td>
                <?php if ($siteResult['Action'] == "School") { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="أغلق للتعقيم">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" alt="Remove" width="20px" onclick="Remove_SiteFromAction(<?php echo $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="تم التعقيم">
                <?php } ?>
            </td>
        </tr> <?php
            }
        }


        function GetListOfSites_InCleaning($list_Tests)
        {
            $ci = &get_instance();
            $ci->load->library('session');
            $today = date("Y-m-d");
            $listSites = array();
            $sessiondata = $ci->session->userdata('admin_details');
            $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_co_site` WHERE 
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
        <?php if ($result >= 38.50 && $result <= 45.00) { ?>
            <!-- Hight Bilal 26 Dec 2020 -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"> <?php echo $result; ?> </span>
        <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
            <!-- Moderate -->
            <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"> <?php echo $result; ?> </span>
        <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
            <!-- No Risk -->
            <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"> <?php echo $result; ?></span>
        <?php } elseif ($result <= 36.20) { ?>
            <!-- Low -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"> <?php echo $result; ?> </span>
        <?php } elseif ($result > 45) { ?>
            <!-- Error -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"> <?php echo $result; ?> </span>
        <?php } ?>
    </td>

    <td class="Td-Results">
        <?php if ($result >= 38.50 && $result <= 45.00) { ?>
            <span class="badge error" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">عالي</span>
            <!-- Hight Bilal 26 Dec 2020 -->
        <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">معتدل</span>
            <!-- Moderate -->
        <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">طبيعي</span>
        <?php } elseif ($result <= 36.20) { ?>
            <!-- Low -->
            <span class="badge" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">منخفض</span>
        <?php } elseif ($result > 45) { ?>
            <!-- Error -->
            <span class="badge" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">قراءة خاطئة</span>
        <?php } ?>
    </td>

<?php
        }


?>




<script>
    // here chart start
    options = {
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
                foreach ($supported_types as $type) {
                    $allUsersByType =  $this->db->query("SELECT *
			FROM `l2_co_patient`
			WHERE `UserType` = '" . $type['UserType'] . "'
			AND `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
                    echo sizeof($allUsersByType) . ",";
                }
                ?>
            ],
        }, {
            name: "الحجر الصحي",
            data: [<?php actionsCounter("الحجر الصحي", $sessiondata['admin_id']); ?>],
        }, {
            name: "الحجر المنزلي",
            data: [<?php actionsCounter("الحجر المنزلي", $sessiondata['admin_id']); ?>],
        }, ],
        colors: ["#f1b44c", "#5b73e8", "#34c38f"],
        xaxis: {
            categories: [
                <?php
                foreach ($supported_types as $type) {
                    echo '"' . $type['AR_UserType'] . '",';
                }
                ?>
            ]
        },
        yaxis: {
            title: {
                text: "counter"
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



    options = {
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
            enabled: !1
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "منخفض",
            data: [<?php echo $LOW  ?>]
        }, {
            name: "معتدل",
            data: [<?php echo $NORMAL  ?>]
        }, {
            name: "عالي",
            data: [<?php echo $HIGH   ?>]
        }, {
            name: "متوسط",
            data: [<?php echo $MODERATE  ?>]
        }, {
            name: "الكل",
            data: [<?php echo (($LOW) + ($NORMAL) + ($HIGH) + ($MODERATE))  ?>]
        }],
        colors: ["#5b73e8", "#34c38f", "#f46a6a", "#f1b44c", "#74788d"],
        xaxis: {
            categories: ["مجموع فحوصات الحرارة"]
        },
        yaxis: {
            title: {
                text: ""
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
    (chart = new ApexCharts(document.querySelector("#radial_chart"), options)).render();

    options = {
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
            enabled: !1
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "الأجهزة",
            data: [<?php echo $all  ?>]
        }, {
            name: "أجهزة الحرارة",
            data: [<?php echo $allDevices  ?>]
        }, {
            name: "الأجهزة المخبرية",
            data: [<?php echo $allDevices_lab   ?>]
        }, {
            name: " أجهزة البوابات ",
            data: [<?php echo $allDevicesGateway  ?>]
        }],
        colors: ["#f46a6a", "#f1b44c", "#5b73e8", "#34c38f"],
        xaxis: {
            categories: ["مجموع الأجهزة "]
        },
        yaxis: {
            title: {
                text: ""
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
    (chart = new ApexCharts(document.querySelector("#counters_chart"), options)).render();
</script>