<!doctype html>
<html lang="arabic">

<head>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
    <link href="<?php echo base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>

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

        .InfosCards h4,
        .InfosCards p {
            color: #fff;
        }

        .InfosCards .card-body {
            border-radius: 5px;
        }
    </style>
</head>

<body class="light menu_light logo-white theme-white">
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

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <br>
        <h4 class="card-title"
            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            MOE 009 - مجموع المدارس والاقسام</h4>
        <div class="row">
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #344267;">
                        <div class="float-right mt-2">
                            <!-- <div id="CharTTest1"></div>-->
                            <img src="<?= base_url(); ?>assets/images/icons/counterschools.png" alt="schools"
                                 width="50px"></i>
                        </div>
                        <div>
                            <?php
                            $idd = $sessiondata['admin_id'];
                            $all = $this->db->query("SELECT * FROM `l1_school` WHERE `Added_By` = $idd ")->num_rows();
                            $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                            ?>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                            <p class="mb-0">مجموع المدارس</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                             <?php if (!empty($lasts)) { ?>
                                             <?php foreach ($lasts

                                             as $last) { ?>
                                             <?php echo $last['Created'] ?></span><br>
                            أخر مدرسة تم إضافتها
                            <?php } ?>
                            <?php } else { ?>
                                <?php echo "--/--/--"; ?></span><br>
                                أخر مدرسة تم إضافتها
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #605091;">
                        <div class="float-right mt-2">
                            <img src="<?= base_url(); ?>assets/images/icons/counterdepartments.png" alt="department"
                                 width="50px">
                        </div>
                        <div>
                            <?php
                            $all_ministry = $this->db->query("SELECT * FROM `l1_department`
                                             WHERE Added_By = $idd ")->num_rows();
                            $lastminED = $this->db->query("SELECT * FROM `l1_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();

                            ?>
                            <h4 class="mb-1 mt-1">
                                <span data-plugin="counterup"><?php echo $all_ministry ?></span>
                            </h4>
                            <p class="mb-0"> مجموع الأقسام</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                             <?php if ($lastminED) { ?>
                                             <?php foreach ($lastminED

                                             as $last) { ?>
                                             <?php echo $last['Created'] ?></span><br>
                            أخر قسم تم إضافته
                            <?php } ?>
                            <?php } else { ?>
                                <?php echo "--/--/--"; ?></span><br>
                                أخر قسم تم إضافته
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #344267;">
                        <div class="float-right mt-2">
                            <img src="<?= base_url(); ?>assets/images/icons/counterschools.png" alt="device"
                                 width="50px">
                        </div>
                        <div>
                            <?php
                            $allEn = $this->db->query("SELECT * FROM `l1_school`
               WHERE `Added_By` = $idd AND `status` = '1' ")->num_rows();
                            $allDes = $this->db->query("SELECT * FROM `l1_school`
               WHERE `Added_By` = $idd AND `status` = '0' ")->num_rows();
                            ?>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allEn ?></span></h4>
                            <p class="mb-0">إجمالي المدارس المفعلة</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;"><?php echo $allDes ?></p>
                        <p class="mb-0">إجمالي المدارس المعطلة</p>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #605091;">
                        <div class="float-right mt-2">
                            <img src="<?= base_url(); ?>assets/images/icons/counterdepartments.png" alt="device"
                                 width="50px">
                        </div>
                        <div>
                            <?php
                            $allEn = $this->db->query("SELECT * FROM `l1_department`
               WHERE `Added_By` = $idd AND `status` = '1' ")->num_rows();
                            $allDes = $this->db->query("SELECT * FROM `l1_department`
               WHERE `Added_By` = $idd AND `status` = '0' ")->num_rows();
                            ?>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allEn ?></span></h4>
                            <p class="mb-0">إجمالي الأقسام المفعلة</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;"><?php echo $allDes ?></p>
                        <p class="mb-0">إجمالي الأقسام المعطلة</p>
                    </div>
                </div>
            </div> <!-- end col-->

        </div> <!-- end row-->

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

<!--        <div class="row">-->
<!--            <div class="col-xl-12">-->
<!--                <br>-->
<!---->
<!--                <h4 class="card-title"-->
<!--                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">-->
<!--                    MOE 010 - إضافة مدارس وأقسام</h4>-->
<!--                <div class="card">-->
<!---->
<!--                    <div class="card-body">-->
<!--                        <h4 class="card-title" id="title">إضافة مدرسة جديدة أو قسم جديد</h4>-->
<!--                        <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">-->
<!--                            <span id="Toast">ملاحظة: أضف قسم جديد غير جاهز حتى الآن</span>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-12" style="margin: 18px auto;padding: 0px;">-->
<!--                            <label>إختر النوع</label>-->
<!--                            <select name="addingType" id="addingType" class="custom-select">-->
<!--                                <option value="0" class="option">إختر النوع</option>-->
<!--                                <option value="School" class="option">+ مدرسة</option>-->
<!--                                <option value="Department" class="option">+ قسم</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!---->
<!--                        <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;" id="addSchool">-->
<!--                            <hr style="border-width: 3px;border-top-color: #d24d4d;margin: 30px auto;">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom01">إسم المدرسة بالعربية</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom01"-->
<!--                                               placeholder="إسم المدرسة بالعربية" name="Arabic_Title" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom02">إسم المدرسة بالإنجليزي </label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="إسم المدرسة بالإنجليزي" name="English_Title" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group mb-4">-->
<!--                                        <label class="control-label">الدولة بالانجليزي</label>-->
<!--                                        <select style="width: 100%;display: block;height: 50px;"-->
<!--                                                class="form-control select2" name="Country">-->
<!--                                            --><?php
//                                            $list = $this->db->query("SELECT * FROM `r_countries` ORDER BY `name` ASC")->result_array();
//
//                                            foreach ($list as $site) { ?>
<!---->
<!---->
<!--                                                <option --><?php //= $site['id'] == '173' ? "selected" : "" ?>
<!--                                                        value="--><?php //= $site['id']; ?><!--"> --><?php //= $site['name']; ?><!-- </option>-->
<!--                                            --><?php //} ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="cities">-->
<!--                                        <label for="">المدينة بالانجليزي</label>-->
<!--                                        <input type="text" readonly class="form-control" placeholder="City">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom01">اسم المدير بالعربي</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom01"-->
<!--                                               placeholder="اسم المدير بالعربي" name="Manager_AR" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom02">اسم المدير بالانجليزي</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="اسم المدير بالانجليزي" name="Manager_EN" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label>رقم الهاتف</label>-->
<!--                                        <input type="text" class="form-control" placeholder="رقم الهاتف" name="Phone"-->
<!--                                               required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom02">الإيميل</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="الإيميل" name="Email" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <label>إختر نوع المدرسة</label>-->
<!--                                    <select name="Type" class="custom-select">-->
<!--                                        <option value="Government" class="option">حكومية</option>-->
<!--                                        <option value="Private" class="option">خاصة</option>-->
<!--                                        <option value="Community" class="option">مجتمعية</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-6">-->
<!--                                    <label>إختر جنس المدرسة</label>-->
<!--                                    <select name="School_Gender" class="custom-select">-->
<!--                                        <option value="Male" class="option">ذكور</option>-->
<!--                                        <option value="Female" class="option">إناث</option>-->
<!--                                        <option value="mix" class="option">ذكور وإناث</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!---->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">-->
<!--                                    <div class="form-group">-->
<!--                                        <label>اسم المستخدم</label>-->
<!--                                        <input type="text" class="form-control" placeholder="User Name" name="Username"-->
<!--                                               required>-->
<!--                                        <div class="valid-feedback">-->
<!--                                            جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">-->
<!--                                    <div class="form-group">-->
<!--                                        <label>رقم المدرسة: </label>-->
<!--                                        <input type="text" class="form-control" placeholder="رقم المدرسة"-->
<!--                                               name="SchoolId" required>-->
<!--                                        <div class="valid-feedback">-->
<!--                                            جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                            </div>-->
<!--                            <button class="btn btn-primary" type="Submit">أضف</button>-->
<!--                            <button type="button" class="btn btn-light" id="back">إلغاء</button>-->
<!--                        </form>-->
<!---->
<!--                        <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;"-->
<!--                              id="addDepartment">-->
<!--                            <hr style="border-width: 3px;border-top-color: #219824;margin: 30px auto;">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom01">إسم القسم بالعربي</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom01"-->
<!--                                               placeholder="إسم القسم بالعربي" name="Arabic_Title" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom02">إسم القسم بالإنجليزي</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="إسم القسم بالإنجليزي" name="English_Title" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom01">اسم المدير بالعربي</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom01"-->
<!--                                               placeholder="اسم المدير بالعربي" name="Manager_AR" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom02">اسم المدير بالانجليزي</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="اسم المدير بالانجليزي" name="Manager_EN" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom01"> رقم الهاتف </label>-->
<!--                                        <input type="text" class="form-control" placeholder="رقم الهاتف" name="Phone"-->
<!--                                               required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="validationCustom02">الإيميل</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="الإيميل" name="Email" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!---->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6">-->
<!--                                    --><?php //$citiesarray = $this->db->query('SELECT * FROM `r_cities` ORDER BY `Name_EN` ASC')->result_array(); ?>
<!--                                    <label> المدينة </label>-->
<!--                                    <select name="city" class="custom-select">-->
<!--                                        <option value="6" class="option"> Doha</option>-->
<!--                                        --><?php //foreach ($citiesarray as $cities) { ?>
<!--                                            <option value="--><?php //echo $cities['Id']; ?><!--" class="option">-->
<!--                                                --><?php //echo $cities['Name_EN']; ?>
<!--                                            </option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
<!---->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-6">-->
<!--                                    <label>إختر نوع القسم</label>-->
<!--                                    <select name="Type" class="custom-select">-->
<!--                                        <option value="Government" class="option">حكومي</option>-->
<!--                                        <option value="Private" class="option">خاص</option>-->
<!--                                        <option value="Community" class="option">مجتمعي</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!---->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">-->
<!--                                    <div class="form-group">-->
<!--                                        <label>اسم المستخدم</label>-->
<!--                                        <input type="text" class="form-control" id="validationCustom02"-->
<!--                                               placeholder="اسم المستخدم" name="Username" required>-->
<!--                                        <div class="valid-feedback">جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-4">-->
<!--                                    <div class="form-group">-->
<!--                                        <label>رمز تعريف المدرسة : </label>-->
<!--                                        <input type="text" class="form-control" placeholder="School Id" name="SchoolId"-->
<!--                                               required>-->
<!--                                        <div class="valid-feedback">-->
<!--                                            جيد-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <button class="btn btn-primary" type="Submit"> أضف</button>-->
<!--                            <button type="button" class="btn btn-light" id="back">إلغاء</button>-->
<!--                        </form>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!---->
<!--        </div>-->


        <div class="row">

            <!-- end card -->

            <div class="col-xl-6">
                <br>
                <h4 class="card-title"
                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE 011 - قائمة أخر المدارس</h4>
                <div class="card">

                    <div class="card-body" style="height: 600px;overflow: auto">

                        <h4 class="card-title">قائمة أخر المدارس</h4><br>
                        <table class="table mb-0">
                            <?php $listofadmins = $this->db->query("SELECT * FROM `l1_school` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array(); ?>
                            <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;">إسم المدرسة</th>
                                <th>المدينة</th>
                                <th>الحالة</th>
                                <th>سجل الدخول</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $s_number = 0;
                            foreach ($listofadmins as $adminData) {
                                $s_number++;
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $s_number; ?>
                                    </th>
                                    <td>
                                        <?php echo $adminData['School_Name_AR'] ?>
                                    </td>

                                    <td>
                                        <?php
                                        $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                       WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                        foreach ($contriesarray as $contrie) {
                                            echo $contrie['Name_EN'];
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($adminData['status'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?= $classname; ?>">
                                        <?php if ($adminData['status']) { ?>
                                            <i class="uil-check" style="font-size: 20px;"></i>
                                        <?php } else { ?>
                                            <i class="" style="font-size: 14px;">X</i>
                                        <?php } ?>
                                    </td>
                                    <?php
                                    if ($adminData['verify'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    $ClassesCho = $this->db->query("SELECT * FROM `l2_grades`
								   WHERE Id = '" . $adminData['Id'] . "' LIMIT 1")->result_array();
                                    ?>
                                    <td class="<?php echo $classname; ?>">
                                        <?php if (!empty($ClassesCho)) { ?>
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
            <div class="col-xl-6">
                <br>
                <h4 class="card-title"
                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE 012 - قائمة أخر الأقسام</h4>
                <div class="card">
                    <div class="card-body" style="height: 600px;">
                        <h4 class="card-title">قائمة أخر الأقسام</h4><br>
                        <table class="table mb-0">
                            <?php $listofadmins = $this->db->query("SELECT * FROM `l1_department` WHERE
                                         Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array(); ?>
                            <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;">إسم القسم</th>
                                <th>المدينة</th>
                                <th>الحالة</th>
                                <th>سجل الدخول</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $s_number = 0;
                            foreach ($listofadmins as $adminData) {
                                $s_number++;
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $s_number; ?>
                                    </th>
                                    <td>
                                        <?php echo $adminData['Dept_Name_AR'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
								   WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                        foreach ($contriesarray as $contrie) {
                                            echo $contrie['Name_EN'];
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($adminData['status'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?= $classname; ?>">
                                        <?php if ($adminData['status']) { ?>
                                            <i class="uil-check" style="font-size: 20px;"></i>
                                        <?php } else { ?>
                                            <i class="" style="font-size: 14px;">X</i>
                                        <?php } ?>
                                    </td>
                                    <?php
                                    if ($adminData['verify'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?php echo $classname; ?>">
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
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/rating-init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script>
    $('.select2').select2();
    $("#addSchool").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/startAddingSchool',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('button[type="Submit"]').attr('disabled', '');
                $('button[type="Submit"]').html('إنتظر من فضلك');
            },
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);
                $('button[type="Submit"]').removeAttr('disabled', '');
                $('button[type="Submit"]').html('إرسال');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("نعتذر لدينا مشكلة");
            }
        });
    });

    $('select[name="Country"]').change(function () {
        var countryId = $(this).val();
        getcities(countryId);
    });

    function getcities(cid) {
        var countryId = cid;
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/Ajax/getThisCountrycities',
            data: {
                id: countryId,
            },
            beforeSend: function () {
                $('.cities').html('please wait...');
            },
            success: function (data) {
                $('.cities').html(data);
            },
            ajaxError: function () {
                $('.cities').css('background-color', '#B40000');
                $('.cities').html("Ooops! Error was found.");
            }
        });
    }


    function sendbyemail() {
        $('.myModal').addClass('myModalActive');
        $('.outer').css('display', 'block');
    }


    $("#sendToemail").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/SendSchoolInfosEmail',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#statusbox').css('display', 'block');
                $('#statusbox').html('<p style="width: 100%;margin: 0px;"> إنتظر من فضلك </p>')
                $('#sendingbutton').attr('disabled', 'disabled');
                $('#sendingbutton').html('إنتظر من فضلك');
            },
            success: function (data) {
                $('#statusbox').css('display', 'block');
                $('#statusbox').html(data);

            },
            ajaxError: function () {
                $('#statusbox').css('background-color', '#DB0404');
                $('#statusbox').html("Ooops! Error was found.");
            }
        });
    });

    $("#addDepartment").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/startAddingDep',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);

            },
            ajaxError: function () {
                $('#Toast').css('background-color', '#B40000');
                $('#Toast').html("نعتذر لدينا مشكلة");
            }
        });
    });


    // Cancel *

    $('#back').click(function () {
        location.href = "<?php echo base_url() . "DashboardSystem/AddSchool"; ?>";
    });

    function back() {
        location.href = "<?php echo base_url() . "DashboardSystem/AddSchool"; ?>";
    }

    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
        output.innerHTML = this.value;
    }
</script>
<script src="<?php echo base_url(); ?>assets/js/pages/range-sliders.init.js"></script><!-- Ion Range Slider-->
<script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<!-- Range slider init js-->
<script>
    $('form:not(#sendToemail)').hide();

    $(document).ready(function () {

        $("#addingType").change(function () {
            var selectedunit = $(this).children("option:selected").val();
            if (selectedunit == 'School') {
                $('#addSchool').show();
                $('#addDepartment').hide();
                $('#title').html(" إضافة مدرسة ");
            } else if (selectedunit == 'Department') {
                $('#addSchool').hide();
                $('#addDepartment').show();
                $('#title').html("إضافة قسم");
            } else {
                $('#addSchool').hide();
                $('#addDepartment').hide();
                $('#title').html("Add");
            }

        });

    });
</script>
</body>

</html>