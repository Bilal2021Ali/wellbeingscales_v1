<!doctype html>
<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>

<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<body class="light menu_light logo-white theme-white">
    <app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
        <!---->
        <app-main _nghost-pjk-c134="" class="ng-star-inserted">
            <section class="content">
                <style>
                    .InfosCards h4,
                    .InfosCards p {
                        color: #fff;
                    }

                    .InfosCards .card-body {
                        border-radius: 5px;
                    }
                </style>
                <?php
                $idd = $sessiondata['admin_id'];
                $get_style = $this->db->query(" SELECT `r_style`.`ar_co_type`,`r_style`.`ar_co_type_sub`
FROM `l0_organization` JOIN `r_style` ON `l0_organization`.`Style_type_id`  = `r_style`.`Id` 
WHERE  `l0_organization`.`Id` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
                //print_r($listofadmins);
                ?>
                <div class="main-content">
                    <div class="page-content">

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <br>
                                    <div class="row image_container">
                                        <img src="<?php echo base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 018 - إدارة الأقسام </h4>
                        <div class="row">

                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #605091;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools">
                                        </div>
                                        <div>
                                            <?php
                                            $all_ministry = $this->db->query("SELECT * FROM `l1_co_department`
                                             WHERE Added_By = $idd ")->num_rows();
                                            $lastminED = $this->db->query("SELECT * FROM `l1_co_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();

                                            ?>
                                            <h4 class="mb-1 mt-1">
                                                <span data-plugin="counterup"><?php echo $all_ministry ?></span>
                                            </h4>
                                            <?php foreach ($get_style as $style) { ?>
                                                <p class="mb-0"> مجموع <?php echo $style['ar_co_type']; ?> </p>
                                            <?php } ?>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php if (!empty($lastminED)) { ?>
                                                    <?php foreach ($lastminED as $last) { ?>
                                                        <?php echo $last['Created'] ?></span><br>
                                            <?php foreach ($get_style as $style) { ?>
                                        <p class="mb-0"> آخر <?php echo $style['ar_co_type_sub']; ?> تم إضافته </p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <?php echo "--/--/--" ?><br>
                                آخر قسم/ فرع تم إضافته
                            <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #605091;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/temperature_counter.png" alt="Test" width="50px">
                                        </div>
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
                                            <h4 class="mb-1 mt-1">
                                                <span data-plugin="counterup"><?php echo $studentscounter;  ?></span>
                                            </h4>
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
                            </div> <!-- end col -->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #344267;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools">
                                        </div>
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
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?php echo $ListOfThis[0]; ?></span><br>
                                                أخر جهاز تم إضافته
                                            </p>
                                        <?php } else { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?php echo "--/--/--" ?></span><br>
                                                أخر جهاز تم إضافته
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #694811;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px">
                                        </div>
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
                                            <h4 class="mb-1 mt-1">
                                                <span data-plugin="counterup"><?php echo $allSites ?></span>
                                            </h4>
                                            <p class="mb-0">مجموع المواقع</p>
                                        </div>
                                        <?php if (!empty($ListOfSitesforThis)) { ?>
                                            <p class="mt-3 mb-0">
                                                <span class="mr-1" style="color: #e1da6a;">
                                                    <?php echo $ListOfSitesforThis[0] ?>
                                                </span><br>
                                                أخر موقع تم إضافته
                                            </p>
                                        <?php } else { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?php echo "--/--/--" ?></span><br>
                                                أخر موقع تم إضافته
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                        </div> <!-- end row-->
                        <div class="container-fluid" style="overflow: auto;">

                            <div class="card">
                                <div class="card-body">
                                    <?php if (!empty($listofadmins)) { ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> الصورة </th>
                                                    <th>العنوان بالعربي</th>
                                                    <th> العنوان بالإنجليزي </th>
                                                    <th>النوع</th>
                                                    <th>إسم المستخدم</th>
                                                    <th>  المدينة </th>
                                                    <th>تعديل</th>
                                                    <th class="actions">الحالة</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 0;
                                                foreach ($listofadmins as $admin) {
                                                    $sn++;
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $sn; ?></th>
                                                        <td>
                                                            <?php if (!empty($admin['Link'])) { ?>
                                                                <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $admin['Link'] ?>" class="avatar-xs rounded-circle " alt="<?php echo $admin['Dept_Name_AR'] ?>">
                                                        </td>
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="<?php echo $admin['Dept_Name_AR'] ?>"></td>
                                                    <?php } ?>
                                                    </td>
                                                    <td><?php echo $admin['Dept_Name_AR']; ?></td>
                                                    <td><?php echo $admin['Dept_Name_EN']; ?></td>
                                                    <?php if ($admin['Type_Of_Dept'] == "Government") { ?>
                                                        <td>حكومي</td>
                                                    <?php } else { ?>
                                                        <td> خاص </td>
                                                    <?php } ?>
                                                    <td><?php echo $admin['Username']; ?></td>

                                                    <td>
                                                        <?php
                                                        $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                        WHERE id = '" . $admin['Citys'] . "' ORDER BY `Name_EN` ASC LIMIT 1")->result_array();
                                                        foreach ($contriesarray as $contrie) {
                                                            echo $contrie['Name_EN'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url() ?>AR/Company/UpdateDepartmentData/<?= $admin['Dept_Id']; ?>">
                                                            <i class="uil-pen" style="font-size: 25px;" title="Edit"></i>
                                                        </a>
                                                    </td>
                                                    <?php
                                                    if ($admin['status'] == 1) {
                                                        $cheked = 'checked';
                                                    } else {
                                                        $cheked = '';
                                                    }

                                                    ?>
                                                    <td><label class="switch">
                                                            <input type="checkbox" theAdminId="<?php echo $admin['Id']; ?>" id="status" <?php echo $cheked; ?>>
                                                            <span class="slider round"></span></label></td>
                                                    </tr>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    <?php  } else { ?>
                                        <div class="empty col-lg-12 text-center">
                                            <h3>لاتوجد معلومات</h3>
                                            <?php
                                            if (trim($sessiondata["type"]) == 'Ministry') {
                                            ?>
                                                <a href="<?php echo base_url() ?>AR/DashboardSystem/addSchool">
                                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light">أضف قسم جديد</button></a>
                                            <?php
                                            } else {
                                                echo $sessiondata["type"];
                                            ?>
                                                <a href="<?php echo base_url() ?>AR/Company/addDepartment">
                                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light">أضف قسم جديد</button></a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                            </table>
                        </div>
                    </div>
                </div>
                </div>

            </section>
            <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
            <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
            <!-- Datatable init js -->
            <script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
            <script>
                $('table').DataTable();
                $('input[type="checkbox"]').each(function() {
                    $(this).change(function() {
                        var theAdminId = $(this).attr('theAdminId');
                        console.log(theAdminId);
                        console.log(this.checked);
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>AR/Company/changeDepartmentstatus',
                            data: {
                                adminid: theAdminId,
                            },
                            success: function(data) {
                                Swal.fire(
                                    'تم التحديث',
                                    data,
                                    'success'
                                )
                            },
                            ajaxError: function() {
                                Swal.fire(
                                    'error',
                                    'oops!! لدينا خطأ',
                                    'error'
                                )
                            }
                        });

                    });
                });
            </script>



</body>

</html>