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
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

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

                    .image_container img {
                        margin: auto;
                        width: 100%;
                        max-width: 800px;
                    }
                </style>
                <?php
                $idd = $sessiondata['admin_id'];
                $get_style = $this->db->query(" SELECT `r_style`.`en_co_type`,`r_style`.`en_co_type_sub`
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
                                        <img src="<?= base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 018 - عداد الاقسام </h4>

                        <div class="row">

                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #605091;">
                                        <div class="float-right mt-2">
                                            <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools">
                                        </div>
                                        <div>
                                            <?php
                                            $id = $sessiondata['admin_id'];
                                            $all_ministry = $this->db->query("SELECT * FROM `l1_co_department`
                                             WHERE Added_By = $idd ")->num_rows();
                                            $lastminED = $this->db->query("SELECT * FROM `l1_co_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();

                                            ?>
                                            <h4 class="mb-1 mt-1">
                                                <span data-plugin="counterup"><?= $all_ministry ?></span>
                                            </h4>
                                            <?php foreach ($get_style as $style) { ?>
                                                <p class="mb-0"> مجموع الأقسام</p>
                                            <?php } ?>
                                        </div>
                                        <p class="text-muted"><span class="mr-1" style="color: #e1da6a;">
                                                <?php if (!empty($lastminED)) { ?>
                                                    <?php foreach ($lastminED as $last) { ?>
                                                        <?= $last['Created'] ?></span><br>
                                            <?php foreach ($get_style as $style) { ?>
                                        <p class="text-muted"> آخر قسم مسجل </p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <?= "--/--/--" ?><br>
                                <?php foreach ($get_style as $style) { ?>
                                    آخر قسم مسجل
                                <?php } ?>
                            <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #605091;">
                                        <div class="float-right mt-2">
                                            <img src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="Test" width="50px">
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
                                                <span data-plugin="counterup"><?= $studentscounter;  ?></span>
                                            </h4>
                                            <p class="mb-0">مجموع المستخدمين</p>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                <?php
                                                //print_r($test);
                                                if (!empty($lastaddeds)) {
                                                    $last = sizeof($lastaddeds);
                                                ?>
                                                    <?= $lastaddeds[$last - 1]; ?></span><br>
                                            آخر مستخدم مسجل
                                        <?php } else { ?>
                                            <?= "--/--/--"; ?></span><br>
                                            آخر مستخدم مسجل
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #344267;">
                                        <div class="float-right mt-2">
                                            <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools">
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
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allDev ?></span></h4>
                                            <p class="mb-0">مجموع الأجهزة</p>
                                        </div>
                                        <?php if (!empty($ListOfThis)) { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?= $ListOfThis[0]; ?></span><br>
                                                آخر جهاز مسجل
                                            </p>
                                        <?php } else { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?= "--/--/--" ?></span><br>
                                                آخر جهاز مسجل
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #694811;">
                                        <div class="float-right mt-2">
                                            <img src="<?= base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px">
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
                                                <span data-plugin="counterup"><?= $allSites ?></span>
                                            </h4>
                                            <p class="mb-0"> مجموع المواقع</p>
                                        </div>
                                        <?php if (!empty($ListOfSitesforThis)) { ?>
                                            <p class="mt-3 mb-0">
                                                <span class="mr-1" style="color: #e1da6a;">
                                                    <?= $ListOfSitesforThis[0] ?>
                                                </span><br>
                                                آخر موقع مسجل
                                            </p>
                                        <?php } else { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                    <?= "--/--/--" ?></span><br>
                                                آخر موقع مسجل
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                        </div> <!-- end row-->
                        <br>
                        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 019 - إدارة الأقسام </h4>
                        <div class="container-fluid" style="overflow: auto;">

                            <div class="card">

                                <div class="card-body">
                                    <?php if (!empty($listofadmins)) { ?>
                                        <table id="visi_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الصورة </th>
                                                    <th>الاسم بالعربي</th>
                                                    <th>الاسم بالانجليزي </th>
                                                    <th>النوع</th>
                                                    <th>اسم المستخدم</th>
                                                    <th>المدينة</th>
                                                    <th>التعديل</th>
                                                    <th class="actions">الحالة</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($listofadmins as $sn => $admin) { ?>
                                                    <tr>
                                                        <th scope="row"><?= $sn + 1; ?></th>
                                                        <td>
                                                            <?php if (!empty($admin['Link'])) { ?>
                                                                <img src="<?= base_url(); ?>uploads/avatars/<?= $admin['Link'] ?>" class="avatar-xs rounded-circle " alt="<?= $admin['Dept_Name_EN'] ?>">
                                                        </td>
                                                    <?php } else { ?>
                                                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="<?= $admin['Dept_Name_EN'] ?>"></td>
                                                    <?php } ?>
                                                    </td>
                                                    <td><?= $admin['Dept_Name_AR']; ?></td>
                                                    <td><?= $admin['Dept_Name_EN']; ?></td>
                                                    <td><?= $admin['Type_Of_Dept']; ?></td>
                                                    <td><?= $admin['Username']; ?></td>
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
                                                        <a href="<?= base_url() ?>AR/DashboardSystem/UpdateDepartmentData/<?= $admin['Dept_Id']; ?>">
                                                            <i class="uil-pen" style="font-size: 25px;" title="التعديل"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" data-user-id="<?= $admin['Dept_Id']; ?>" <?= $admin['status'] == 1 ? "checked" : "" ?>>
                                                            <span class="slider round"></span></label>
                                                    </td>
                                                    </tr>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    <?php  } else { ?>
                                        <div class="empty col-lg-12 text-center">
                                            <h3>لايوجد بيانات</h3>
                                            <?php if (trim($sessiondata["type"]) == 'Ministry') { ?>
                                                <a href="<?= base_url() ?>AR/DashboardSystem/addSchool">
                                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light">إضافة مدرسة</button></a>
                                            <?php } else { ?>
                                                <a href="<?= base_url() ?>AR/DashboardSystem/addDepartment">
                                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light">إضافة قسم</button></a>
                                            <?php } ?>
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
            <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
            <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
            <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
            <!-- Datatable init js -->
            <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
            <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>
            <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="<?= base_url(); ?>assets/js/app.js"></script>
            <script>
                $('table').DataTable();
                $('table').on('change', '.switch input', function() {
                    const userId = $(this).attr('data-user-id');
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>AR/DashboardSystem/changeDepartmentstatus',
                        data: {
                            adminid: userId,
                        },
                        success: function(data) {
                            Swal.fire(
                                'تحديث البيانات',
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
            </script>
</body>

</html>