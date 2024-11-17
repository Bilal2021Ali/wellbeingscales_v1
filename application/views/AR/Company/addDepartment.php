<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
    <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .slidecontainer {
            width: 100%;
            /* Width of the outside container */
        }

        /* The slider itself */
        .slider {
            -webkit-appearance: none;
            /* Override default CSS styles */
            appearance: none;
            width: 100%;
            /* Full-width */
            height: 25px;
            /* Specified height */
            background: #d3d3d3;
            /* Grey background */
            outline: none;
            /* Remove outline */
            opacity: 0.7;
            /* Set transparency (for mouse-over effects on hover) */
            -webkit-transition: .2s;
            /* 0.2 seconds transition on hover */
            transition: opacity .2s;
        }

        /* Mouse-over effects */
        .slider:hover {
            opacity: 1;
            /* Fully shown on mouse-over */
        }

        /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            /* Override default look */
            appearance: none;
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #4CAF50;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
        }

        .slider::-moz-range-thumb {
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #4CAF50;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
        }
    </style>
</head>

<body class="light menu_light logo-white theme-white">

    <?php
    $idd = $sessiondata['admin_id'];
    $admindata = $this->db->query("SELECT * FROM `l0_organization` WHERE `Id` = '" . $idd . "' ")->result_array();
    $country = $admindata[0]['CountryID'];
    ?>
    <style>
        .Ver i {
            background: #019C00;
            color: #fff;
            text-align: center;
            font-size: 20px;
            display: grid;
            height: 20px;
            border-radius: 13px;
            font-style: normal;
            font-weight: bold;
            line-height: 19px;
        }

        .Not i {
            background: #F8002E;
            color: #fff;
            text-align: center;
            font-size: 20px;
            display: grid;
            height: 20px;
            border-radius: 13px;
            font-size: 14px;
            font-style: normal;
            font-weight: bold;
            line-height: 19px;
        }
    </style>
    <style>
        .InfosCards h4,
        .InfosCards p {
            color: #fff;
        }

        .InfosCards .card-body {
            border-radius: 5px;
        }
    </style>
    <style>
        .tab-pane h6 {
            padding-bottom: 10px;
            color: #fff;
            border-radius: 5px;
            padding-top: 10px;
        }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                        إضافة أقسام / فروع / إدارات
                    </h4>
                </div>
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #605091;">
                            <div class="float-right mt-2">
                                <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools">
                            </div>
                            <div>
                                <?php
                                $all_ministry = $this->db->query("SELECT * FROM `l1_co_department`
				 WHERE Added_By = $idd ")->num_rows();
                                $lastminED = $this->db->query("SELECT * FROM `l1_co_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();

                                ?>
                                <h4 class="mb-1 mt-1">
                                    <span data-plugin="counterup"><?= $all_ministry ?></span>
                                </h4>
                                <p class="mb-0">مجموع الأقسام/ الفروع</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                    <?php if (!empty($lastminED)) { ?>
                                        <?php foreach ($lastminED as $last) { ?>
                                            <?= $last['Created'] ?></span><br>
                                آخر قسم/ فرع تم إضافته
                            <?php } ?>
                        <?php } else { ?>
                            <?= "--/--/--" ?></span><br>
                            آخر قسم/ فرع تم إضافته
                        <?php } ?>
                            </p>
                        </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #605091;">
                            <div class="float-right mt-2">
                                <img src="<?= base_url(); ?>assets/images/icons/png_icons/temperature_counter.png" alt="Test" width="50px">
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
                                أخر مستخدم تم إضافته
                            <?php } else { ?>
                                <?= "--/--/--"; ?></span><br>
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
                                <p class="mb-0">مجموع الاجهزة</p>
                            </div>
                            <?php if (!empty($ListOfThis)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?= $ListOfThis[0]; ?></span><br>
                                    أخر جهاز تمت إضافته
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?= "--/--/--" ?></span><br>
                                    أخر جهاز تمت إضافته
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
                                <p class="mb-0">مجموع المواقع</p>
                            </div>
                            <?php if (!empty($ListOfSitesforThis)) { ?>
                                <p class="mt-3 mb-0">
                                    <span class="mr-1" style="color: #e1da6a;">
                                        <?= $ListOfSitesforThis[0] ?>
                                    </span><br>
                                    أخر موقع تمت إضافته
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?= "--/--/--" ?></span><br>
                                    أخر موقع تمت إضافته
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div> <!-- end col-->

            </div> <!-- end row-->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="Toast"></div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-selected="true">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block"> أضف قسم </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab" aria-selected="false">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">أضف فرع</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <h6 class="text-center" style="background: #0eacd8;"> أضف قسم </h6>
                                    <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;" id="addDepartment">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom01">إسم القسم بالعربي</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="إسم القسم بالعربي" name="Arabic_Title" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom02">إسم القسم بالإنجليزي</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="إسم القسم بالإنجليزي" name="English_Title" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom01">اسم المدير بالعربي</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="اسم المدير بالعربي" name="Manager_AR" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom02">اسم المدير بالانجليزي</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="اسم المدير بالانجليزي" name="Manager_EN" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom01">رقم الهاتف</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="رقم الهاتف" name="Phone" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom02">الإيميل</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="الإيميل" name="Email" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="control-label"> الدولة </label>
                                                    <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="countries">
                                                        <?php
                                                        $list = $this->db->query("SELECT * FROM `r_countries` ORDER BY `name` ASC")->result_array();
                                                        foreach ($list as $site) { ?>
                                                            <option value="<?= $site['id'];  ?>">
                                                                <?= $site['name']; ?>
                                                            </option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="cities"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>نوع القسم</label>
                                                <select name="Type" class="custom-select">
                                                    <option value="Government" class="option">حكومي</option>
                                                    <option value="Private" class="option">خاص</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6" style="display: grid;align-items: center;">
                                                <div class="form-group">
                                                    <label> رمز تعريف القسم : </label>
                                                    <input type="text" class="form-control" placeholder="رمز تعريف القسم" name="DepartmentId" required>
                                                    <div class="valid-feedback">
                                                        Looks good
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $positions = $this->db->query("SELECT * FROM `r_positions_gm` ORDER BY `Position` DESC ")->result_array(); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>وظيفة المدير</label>
                                                    <select name="position" class="custom-select">
                                                        <?php foreach ($positions as $position) { ?>
                                                            <option value="<?= $position['Position'] ?>" class="option"><?= $position['Position'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="display: grid;align-items: center;">
                                                <div class="form-group">
                                                    <label>إسم المستخدم</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="إسم المستخدم" name="Username" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="Submit" id="sendingbutton">إضافة </button>
                                        <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <h6 class="text-center" style="background: #add138;">أضف فرع</h6>
                                    <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;" id="addBranch">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom01">إسم الفرع بالعربي</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="اسم الفرع بالعربي" name="Arabic_Title" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom02">إسم الفرع بالإنجليزي</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="إسم الفرع بالإنجليزي" name="English_Title" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom01">اسم المدير بالعربي</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="اسم المدير بالعربي" name="Manager_AR" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom02">اسم المدير بالانجليزي</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="اسم المدير بالانجليزي" name="Manager_EN" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom01">رقم الهاتف</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="رقم الهاتف" name="Phone" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="validationCustom02">الإيميل</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="الإيميل" name="Email" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="control-label"> إختر الدولة </label>
                                                    <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="countries_branch">
                                                        <?php
                                                        $list = $this->db->query("SELECT * FROM `r_countries` 
                                                        ORDER BY `name` ASC")->result_array();
                                                        foreach ($list as $site) { ?>
                                                            <option value="<?= $site['id'];  ?>">
                                                                <?= $site['name']; ?>
                                                            </option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="cities_branch"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>إختر نوع الفرع</label>
                                                <select name="Type" class="custom-select">
                                                    <option value="Government" class="option">حكومي</option>
                                                    <option value="Private" class="option">خصوصي</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php $positions = $this->db->query("SELECT * FROM `r_positions_gm` ORDER BY `Position` DESC ")->result_array(); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> وظيفة المدير</label>
                                                    <select name="position" class="custom-select">
                                                        <?php foreach ($positions as $position) { ?>
                                                            <option value="<?= $position['Position'] ?>" class="option"><?= $position['Position'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="display: grid;align-items: center;">
                                                <div class="form-group">
                                                    <label>إسم المستخدم</label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="أكتب إسم المستخدم" name="Username" required>
                                                    <div class="valid-feedback">
                                                        جيد
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="Submit" id="sendingbutton">
                                            أضف
                                        </button>
                                        <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body" style="height: 703px;">
                            <h4 class="card-title">قائمة بأحدث الفروع والأقسام</h4>
                            <table class="table mb-0">
                                <?php $listofadmins = $this->db->query("SELECT * FROM `l1_co_department` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array(); ?>
                                <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                    <tr>
                                        <th id="test"> # </th>
                                        <th style="width: 40%;">الإسم</th>
                                        <th>الدولة والمدينة</th>
                                        <th>النوع</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sn = 0;
                                    foreach ($listofadmins as $adminData) {
                                        $sn++;
                                    ?>
                                        <tr>
                                            <th scope="row">
                                                <?= $sn; ?>
                                            </th>
                                            <td>
                                                <?= $adminData['Dept_Name_AR'] ?>
                                                <p class="text-muted font-size-13 mb-0"><?= $adminData['Father']; ?></p>
                                            </td>
                                            <td>
                                                <?php
                                                $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
								   WHERE id = '" . $adminData['Citys'] . "'
								   ORDER BY `Name_EN` ASC LIMIT 1")->result_array();
                                                $ccountery = $this->db->query("SELECT * FROM `r_countries` 
								   WHERE id = '" . $adminData['Country'] . "'
								   ORDER BY `name` ASC LIMIT 1")->result_array();
                                                ?>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">
                                                    <?php
                                                    if (!empty($ccountery)) {
                                                        echo $ccountery[0]['name'];
                                                    } else {
                                                        echo "--";
                                                    }
                                                    ?>
                                                </h6>
                                                <p class="text-muted font-size-13 mb-0">
                                                    <?php
                                                    if (!empty($contriesarray)) {
                                                        echo $contriesarray[0]['Name_EN'];
                                                    } else {
                                                        echo "---";
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                            <td><?= $adminData['Dept_Type']; ?></td>
                                            <?php
                                            if ($adminData['verify'] == 1) {
                                                $classname = 'Ver';
                                            } else {
                                                $classname = 'Not';
                                            }
                                            ?>
                                            <td class="<?= $classname; ?>">
                                                <?php if (!empty($adminData['Manager']) && !empty($adminData['Phone'])) { ?>
                                                    <i class="uil-check" style="font-size: 20px;"></i>
                                                <?php } else { ?>
                                                    <i class="" style="font-size: 14px;">X</i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>

    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/rating-init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
    <script>
        $("#addDepartment").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>AR/Company/startAddingDep',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#sendingbutton').attr('disabled', '');
                    $('#sendingbutton').html('إنتظر من فضلك');
                },
                success: function(data) {
                    $('#sendingbutton').removeAttr('disabled', '');
                    $('#sendingbutton').html('حاول مجددا');
                    $('#Toast').css('display', 'block');
                    $('#Toast').html(data);
                },
                ajaxError: function() {
                    $('#Toast').css('background-color', '#B40000');
                    $('#Toast').html("Ooops! Error was found.");
                }
            });
        });

        $("#addBranch").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>AR/Company/startAddingBr',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#sendingbutton').attr('disabled', '');
                    $('#sendingbutton').html('إنتظر من فضلك');
                },
                success: function(data) {
                    $('#sendingbutton').removeAttr('disabled');
                    $('#sendingbutton').html('حاول مجددا');
                    $('#Toast').css('display', 'block');
                    $('#Toast').html(data);
                },
                ajaxError: function() {
                    $('#Toast').css('background-color', '#B40000');
                    $('#Toast').html("Ooops! Error was found.");
                }
            });
        });


        $('select[name="countries"]').change(function() {
            var countryId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>AR/Ajax/getThisCountrycities',
                data: {
                    id: countryId,
                },
                beforeSend: function() {
                    $('.cities').html('جاري التحميل');
                },
                success: function(data) {
                    $('.cities').html(data);
                },
                ajaxError: function() {
                    $('.cities').css('background-color', '#B40000');
                    $('.cities').html("Ooops! Error was found.");
                }
            });
        });

        $('select[name="countries_branch"]').change(function() {
            var countryId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>AR/Ajax/getThisCountrycities',
                data: {
                    id: countryId,
                },
                beforeSend: function() {
                    $('.cities_branch').html('جاري التحميل');
                },
                success: function(data) {
                    $('.cities_branch').html(data);
                },
                ajaxError: function() {
                    $('.cities_branch').css('background-color', '#B40000');
                    $('.cities_branch').html("Ooops! Error was found.");
                }
            });
        });


        // Cancel *

        $('#back').click(function() {
            location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
        });

        function back() {
            location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
        }


        $('#test').click(function() {
            Swal.fire({
                title: 'Success!',
                text: 'The data were inserted successfully. The email will be sent to ',
                icon: 'success',
                confirmButtonColor: '#5b8ce8',
            });
        });
    </script>
</body>

</html>