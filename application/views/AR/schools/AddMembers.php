<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
<link href="<?php echo base_url() ?>assets/libsArea/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
      rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"
      rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
<link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css"/>
</head>
<style>
    .select2-container--default .select2-selection--single {
        height: 37px;
        padding-top: 3px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px;
        width: 31px;
    }

    .control {
        margin: 10px auto;
    }

    .control i {
        margin: 4px;
        font-size: 16px;
        margin-left: -1px;
    }

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

    form label:not(.dataTables_wrapper label) {
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        width: 100%;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <br>
                    <div class="row image_container">
                        <img src="<?php echo base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <br><h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            CH 019: إضافة موظف، معلم، طالب ، وسيط حراري (ثلاجة)، موقع عام، مركبة، جهاز جودة الهواء</h4>

        <div class="row">
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                        <div class="card-body" style="background-color: #022326;">
                            <div class="float-right mt-2">
                                <!-- <div id="CharTTest1"></div>-->
                                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Staffs.png"
                                     alt="Number of Staff" width="75px"></i>
                            </div>
                            <div>
                                <?php
                                $idd = $sessiondata['admin_id'];
                                $all = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsStaff = $this->db->query("SELECT * FROM `l2_staff`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                <p class="mb-0">موظف</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsStaff

                                        as $last) { ?>
                                        <?php echo $last['Created'] ?></span><br>
                                آخر موظف تم إضافته
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teachers  -->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #ff26be;padding: 5px">
                        <div class="card-body" style="background-color: #2e001f;">
                            <div class="float-right mt-2"><img
                                        src="<?php echo base_url(); ?>assets/images/icons/png_icons/teachers.png"
                                        alt="department" width="75px"></div>
                            <div>
                                <?php
                                $allstudents = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allstudents ?></span>
                                </h4>
                                <p class="mb-0">معلم</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsTeachers

                                        as $last) { ?>
                                        <?php echo $last['Created'] ?></span><br>
                                آخر معلم تم إضافته
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #3cf2a6;padding: 5px">
                        <div class="card-body" style="background-color: #00261a;">
                            <div class="float-right mt-2"><img
                                        src="<?php echo base_url(); ?>assets/images/icons/png_icons/Students.png"
                                        alt="Number of Students" width="75px"></div>
                            <div>
                                <?php
                                $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allstudents ?></span>
                                </h4>
                                <p class="mb-0">طالب</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsStudent

                                        as $last) { ?>
                                        <?php echo $last['Created'] ?></span><br>
                                آخر طالب تم إضافته
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #ffd70d;padding: 5px">
                        <div class="card-body" style="background-color: #262002;">
                            <div class="float-right mt-2"><img
                                        src="<?php echo base_url(); ?>assets/images/icons/png_icons/sites.png"
                                        alt="Number of Students" width="50px"></div>
                            <div>
                                <?php
                                $Allsites = $this->db->query("SELECT * FROM `l2_site` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsSites = $this->db->query("SELECT * FROM `l2_site`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Allsites ?></span></h4>
                                <p class="mb-0">موقع</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsSites

                                        as $last) { ?>
                                        <?php echo $last['Created'] ?></span><br>
                                آخر موقع تم إضافته
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->
        <br><h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            . </h4>
        <div class="row">
            <div class="col-xl-12">
                <div class="">
                    <div class="card-body" style="padding-top: 1px;">
                        <div class="alert alert-dismissible fade show" role="alert"><span id="Toast"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="control col-md-12">
                            <button type="button" form_target="staff" class="btn btn-primary w-md contr_btn"><i
                                        class="uil uil-plus"></i>موظف
                            </button>
                            <button type="button" form_target="Teacher" class="btn w-md contr_btn"><i
                                        class="uil uil-plus"></i> معلم
                            </button>
                            <button type="button" form_target="Student" class="btn w-md contr_btn"><i
                                        class="uil uil-plus"></i> طالب
                            </button>
                            <button type="button" form_target="Refrigerator" class="btn w-md contr_btn"><i
                                        class="uil uil-plus"></i> وسيط حراري (ثلاجة)
                            </button>
                            <button type="button" form_target="Site" class="btn w-md contr_btn"><i
                                        class="uil uil-plus"></i>موقع عام
                            </button>
                            <?php if (!empty($cars_permissions)) { ?>
                                <button type="button" form_target="vehicle" class="btn w-md contr_btn"><i
                                            class="uil uil-plus"></i> مركبة
                                </button>
                            <?php } ?>
                            <?php if (!empty($prms)) { ?>
                                <button type="button" form_target="Area" class="btn w-md contr_btn"><i
                                            class="uil uil-plus"></i> جهاز جودة الهواء
                                </button>
                            <?php } ?>
                        </div>
                        <div class="col-md-12 formcontainer" id="staff">
                            <br><br><h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 020: إضافة موظف </h4>
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="AddMember">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-2" style="margin-bottom: 11px;">
                                                    <label>الكنية</label>
                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option value="<?php echo $pref['Prefix']; ?>"> <?php echo $pref['Prefix_ar']; ?>
                                                                .
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;" class="StaffName"></h3>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 0px;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom02 "> الإسم الأول
                                                            بالإنجليزي </label>
                                                        <input type="text" class="form-control FstaffName"
                                                               placeholder="الإسم الأول بالإنجليزي" name="First_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأوسط بالإنجليزي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأوسط بالإنجليزي"
                                                               name="Middle_Name_EN" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01 ">الإسم الأخير بالإنجليزي</label>
                                                        <input type="text" class="form-control LstaffName"
                                                               id="validationCustom01"
                                                               placeholder="الإسم الأخير بالإنجليزي" name="Last_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> الإسم الأول بالعربي</label>
                                                        <input type="text" class="form-control"
                                                               placeholder=" الإسم الأول بالعربي" name="First_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01"> الإسم الأوسط بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأوسط بالعربي" name="Middle_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الاسم الاخير بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الاسم الاخير بالعربي" name="Last_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>تاريخ الميلاد</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   data-provide="datepicker" data-date-autoclose="true"
                                                                   data-date-format="yyyy-mm-dd" name="DOP">
                                                            <div class="input-group-append"><span
                                                                        class="input-group-text"><i
                                                                            class="mdi mdi-calendar"></i></span></div>
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>رقم الهاتف</label>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="رقم الهاتف" name="Phone">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>الجنس</label>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M">ذكر</option>
                                                        <option value="F">أنثى</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>الرقم الوطني</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الرقم الوطني" name="N_Id" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>الجنسية</label>
                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `r_countries`.`name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <option value="Qatar"> Qatar</option>
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?php echo $contries['name']; ?>"
                                                                        class="option"> <?php echo $contries['name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name">MAC Address</label>
                                                        <input id="input-ip" class="form-control input-mask"
                                                               data-inputmask="'alias': 'mac'" name="mac_address">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الوظيفة </label>
                                                        <select class="form-control" name="Position">
                                                            <?php foreach ($Positions as $Position) { ?>
                                                                <option value="<?= $Position['Id'] ?>"> <?php echo $Position['AR_Position'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الايميل </label>
                                                        <input type="email" class="form-control" placeholder="الايميل"
                                                               name="Email" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>نوع العلاقة</label>
                                                        <select class="form-control" name="relationship">
                                                            <?php foreach ($av_relationships as $av_relationship) { ?>
                                                                <option value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name_ar'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <button class="btn btn-primary" id="staffsub" type="Submit">حفظ</button>
                                        <button type="reset" class="btn btn-light">إلغاء</button>
                                    </div>
                            </div>

                            </form>
                        </div>
                        <div class="col-md-12 formcontainer" id="Teacher">

                            <br><br><h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 021: إضافة معلم</h4>

                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="AddTeacher">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-2" style="margin-bottom: 11px;">
                                                    <label>الكنية</label>
                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option value="<?php echo $pref['Prefix']; ?>"> <?php echo $pref['Prefix_ar']; ?>
                                                                .
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;"
                                                        class="generatedNameTeacher"></h3>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 0px;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> الإسم الأول بالإنجليزي </label>
                                                        <input type="text" class="form-control FTeacher_Name_EN"
                                                               placeholder="الإسم الأول بالإنجليزي" name="First_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأوسط بالإنجليزي</label>
                                                        <input type="text" class="form-control " id="validationCustom01"
                                                               placeholder="الإسم الأوسط بالإنجليزي"
                                                               name="Middle_Name_EN" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأخير بالإنجليزي</label>
                                                        <input type="text" class="form-control LTeacher_Name_EN"
                                                               id="validationCustom01"
                                                               placeholder="الإسم الأخير بالإنجليزي" name="Last_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> الإسم الأول بالعربي </label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الإسم الأول بالعربي" name="First_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأوسط بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأوسط بالعربي" name="Middle_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأخير بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأخير بالعربي" name="Last_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label> تاريخ الميلاد </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   data-provide="datepicker" data-date-autoclose="true"
                                                                   data-date-format="yyyy-mm-dd" name="DOP">
                                                            <div class="input-group-append"><span
                                                                        class="input-group-text"><i
                                                                            class="mdi mdi-calendar"></i></span></div>
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>رقم الهاتف</label>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="رقم الهاتف" name="Phone">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>الجنس</label>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M">ذكر</option>
                                                        <option value="F">أنثى</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>الرقم الوطني</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الرقم الوطني " name="N_Id" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>الجنسية</label>
                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <option value="Qatar"> Qatar</option>
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?php echo $contries['name']; ?>"
                                                                        class="option"> <?php echo $contries['name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> إختصاص المعلم </label>
                                                        <select class="form-control" name="Position">
                                                            <?php foreach ($Positions_tech as $Position) { ?>
                                                                <option value="<?= $Position['Id'] ?>"> <?php echo $Position['AR_Position'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"
                                                     style="margin-bottom: 11px;display: grid;">
                                                    <div class="form-group">
                                                        <label> الإيميل </label>
                                                        <input type="email" class="form-control" placeholder="الإيميل"
                                                               name="Email" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="w-100">
                                                        <span class="float-right text-primary btn s-all"
                                                              data-target-select="Classes[]"
                                                              style="margin-top: -9px;">إختر الكل</span>الفصول </label>
                                                    <!-- Classes -->
                                                    <div class="form-group">
                                                        <?php if (!empty($classes)) { ?>
                                                            <select name="Classes[]"
                                                                    class="form-control select2 select2-multiple"
                                                                    multiple="multiple" data-placeholder="Choose ..."
                                                                    id="">
                                                                <?php foreach ($classes as $class) { ?>
                                                                    <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <p>ليس لديك أي فئة !! الرجاء تحرير مل تعريف المدرسة <a
                                                                        href="<?php echo base_url() ?>AR/schools/Profile">الملف</a>
                                                            </p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> نوع العلاقة </label>
                                                        <select class="form-control" name="relationship">
                                                            <?php foreach ($av_relationships as $av_relationship) { ?>
                                                                <option value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name_ar'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name">MAC Address</label>
                                                        <input id="input-ip" class="form-control input-mask"
                                                               data-inputmask="'alias': 'mac'" name="mac_address">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="Teachersub" type="Submit">حفظ</button>
                                <button type="reset" class="btn btn-light">إلغاء</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-12 formcontainer" id="Student">
                            <br><br><h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 022: إضافة طالب</h4>

                            <div class="row">
                                <form class="needs-validation InputForm col-md-12 custom-validation" novalidate=""
                                      style="margin-bottom: 27px;" id="AddStudent">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-4 col-sm-6" style="margin-bottom: 11px;"><br>
                                                    <label>الكنية</label>
                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option value="<?php echo $pref['Prefix']; ?>"> <?php echo $pref['Prefix_ar']; ?>
                                                                .
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-6" style="margin-bottom: 11px;">
                                                    <br>
                                                    <label>الصورة الشخصية</label>
                                                    <input type="file" accept="image/*" class="form-control"
                                                           name="avatar">
                                                </div>
                                                <div class="col-md-4 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;"
                                                        class="generatedNameStudent"></h3>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 0px;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> الإسم الأول بالإنجليزي </label>
                                                        <input type="text" class="form-control StudentNameF"
                                                               placeholder="الإسم الأول بالإنجليزي" name="First_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأوسط بالإنجليزي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأوسط بالإنجليزي"
                                                               name="Middle_Name_EN" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأخير بالإنجليزي</label>
                                                        <input type="text" class="form-control StudentNameL"
                                                               id="validationCustom01"
                                                               placeholder="الإسم الأخير بالإنجليزي" name="Last_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label> الإسم الأول بالعربي </label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الإسم الأول بالعربي" name="First_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأوسط بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأوسط بالعربي" name="Middle_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأخير بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="الإسم الأخير بالعربي" name="Last_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label> تاريخ الميلاد </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   data-provide="datepicker" data-date-autoclose="true"
                                                                   data-date-format="yyyy-mm-dd" name="DOP">
                                                            <div class="input-group-append"><span
                                                                        class="input-group-text"><i
                                                                            class="mdi mdi-calendar"></i></span></div>
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>رقم الهاتف</label>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="رقم الهاتف" name="Phone">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>الجنس</label>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M">ذكر</option>
                                                        <option value="F">أنثى</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>الرقم الوطني</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الرقم الوطني" name="N_Id" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label>الجنسية</label>
                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <option value="Qatar"> Qatar</option>
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?php echo $contries['name']; ?>"
                                                                        class="option"> <?php echo $contries['name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name">MAC Address</label>
                                                        <input id="input-ip" class="form-control input-mask"
                                                               data-inputmask="'alias': 'mac'" name="mac_address">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الايميل </label>
                                                        <input type="email" class="form-control" placeholder="الايميل"
                                                               name="Email" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الرقم الوطني للأب </label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الرقم الوطني للأب"
                                                               data-parsley-minlength="11" required name="P_NID">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> :الرقم الوطني للأم(إختياري) </label>
                                                        <input type="text" class="form-control"
                                                               placeholder="الرقم الوطني للأم" name="M_NID">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>الصف:</label>
                                                    <div class="form-group">
                                                        <?php if (!empty($classes)) { ?>
                                                            <select name="Classes" class="form-control select2" id="">
                                                                <?php foreach ($classes as $class) { ?>
                                                                    <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <p> ليس لديك أي فئة !! الرجاء تحرير ملف تعريف المدرسة <a
                                                                        href="<?php echo base_url() ?>AR/schools/Profile">الملف</a>
                                                            </p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label> الشعبة</label>
                                                    <select name="Grades" class="form-control">
                                                        <option value="">إختر الصف</option>
                                                        <option value="GRADE-A-1">الشعبة A (1)</option>
                                                        <option value="GRADE-B-1">الشعبة B (2)</option>
                                                        <option value="GRADE-C-2">الشعبة C (3)</option>
                                                        <option value="GRADE-D-3">الشعبةD (4)</option>
                                                        <option value="GRADE-E-4">الشعبة E (5)</option>
                                                        <option value="GRADE-F-5">الشعبة F (6)</option>
                                                        <option value="GRADE-G-6">الشعبة G (7)</option>
                                                        <option value="GRADE-H-7">الشعبة H (8)</option>
                                                        <option value="GRADE-I-8">الشعبة I (9)</option>
                                                        <option value="GRADE-J-9">الشعبة J (10)</option>
                                                        <option value="GRADE-K-10">الشعبة K (11)</option>
                                                        <option value="GRADE-L-11">الشعبة L (12)</option>
                                                        <option value="GRADE-M-12">الشعبة M (13)</option>
                                                        <option value="GRADE-N-13">الشعبة N (14)</option>
                                                        <option value="GRADE-O-14">الشعبة O (15)</option>
                                                        <option value="GRADE-P-15">الشعبة P (16)</option>
                                                        <option value="GRADE-Q-16">الشعبة Q (17)</option>
                                                        <option value="GRADE-R-17">الشعبة R (18)</option>
                                                        <option value="GRADE-S-18">الشعبة S (19)</option>
                                                        <option value="GRADE-T-19">الشعبة T (20)</option>
                                                        <option value="GRADE-U-20">الشعبة U (21)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> نوع العلاقة </label>
                                                        <select class="form-control" name="relationship">
                                                            <?php foreach ($av_relationships as $av_relationship) { ?>
                                                                <option value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name_ar'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="StudentSub" type="Submit">حفظ</button>
                                <button type="reset" class="btn btn-light">إلغاء</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-12 formcontainer" id="Site">
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="AddSite">
                                    <br><br><h4 class="card-title"
                                                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        CH 025: إضافة موقع عام جديد</h4>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="control-label">نوع الموقع</label>
                                                        <select style="width: 100%;display: block;height: 50px;"
                                                                class="form-control select2" name="Site">
                                                            <?php
                                                            $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                            foreach ($list as $site) {
                                                                ?>
                                                                <option value="<?php echo $site['Site_Name']; ?>"> <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name_ar']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name">الوصف</label>
                                                        <input type="text" class="form-control" placeholder="الوصف"
                                                               name="Description">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <label class="control-label"> هذا الموقع ل:</label>
                                                        <select style="width: 100%;display: block;height: 50px;"
                                                                class="form-control select2" name="Site_for">
                                                            <option value="1"> جهاز مخبري</option>
                                                            <option value="2"> ميزان حرارة</option>
                                                            <option value="3"> بوابات</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="StudentSub" type="Submit">حفظ</button>
                                <button type="reset" class="btn btn-light">إلغاء</button>
                            </div>
                            </form>
                            <br>
                            <br><br><h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 026: قائمة الأجهزة المخبرية، موازين الحرارة، البوابات </h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                <th>#</th>
                                                <th>نوع الموقع</th>
                                                <th>وصف الموقع</th>
                                                <th> لــ</th>
                                                </thead>
                                                <tbody>
                                                <?php $codes = array(1, 2, 3); ?>
                                                <?php $names = array('جهاز مخبري', 'ميزان حرارة', 'بوابات'); ?>
                                                <?php foreach ($sites as $sn => $site) { ?>
                                                    <tr>
                                                        <td><?= $sn + 1 ?></td>
                                                        <td><?= $site['Site_Code'] ?></td>
                                                        <td><?= $site['Description'] ?></td>
                                                        <td><?php echo $site['Site_For'] == "" ? "لا يوجد" : str_replace($codes, $names, $site['Site_For']); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 formcontainer" id="Refrigerator">
                            <br><br><h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 023: إضافة وسيط حراري - ثلاجة </h4>
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate
                                      style="margin-bottom: 27px;" id="Addmachine">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name"> رقم الوسيط الحراري MAC
                                                            Address</label>
                                                        <input type="text" class="form-control" placeholder="Mac Adress"
                                                               name="name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name">نوع الوسيط الحراري</label>
                                                        <?php
                                                        $types = $this->db->query("SELECT * FROM  `refrigerator_levels`")->result_array();
                                                        ?>
                                                        <select name="type" class="form-control">
                                                            <?php foreach ($types as $type) { ?>
                                                                <option value="<?php echo $type['Id'] ?>"> <?php echo $type['device_name_ar'] . "  (" . $type['min_temp'] . "," . $type['max_temp'] . ")" ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="control-label">نوع موقع الوسيط الحراري</label>
                                                        <select class="form-control" name="Site">
                                                            <?php
                                                            $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                            foreach ($list as $site) {
                                                                ?>
                                                                <option value="<?php echo $site['Id']; ?>"> <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name_ar']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <p class="card-text">ملاحظة: لائحة المواقع العامة </p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label for="billing-name"> وصف الوسيط الحراري </label>
                                                        <input type="text" class="form-control" placeholder="الوصف"
                                                               name="description" autocomplete="off">
                                                    </div>
                                                </div>
                                                <?php
                                                $Refrigerators = $this->db->query(" SELECT * ,
                                                    `refrigerator_levels`.`TimeStamp` AS Added_in , 
                                                    `refrigerator_area`.`Description` AS  The_Site_Name
                                                    FROM `refrigerator_area` 
                                                    JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type` 
                                                    JOIN `r_sites` ON `r_sites`.`Id` = `refrigerator_area`.`Site_Id` 
                                                    WHERE 
                                                    `refrigerator_area`.`source_id` = '" . $sessiondata['admin_id'] . "'
                                                    AND `refrigerator_area`.`user_type` = 'school'
                                                    ORDER BY `refrigerator_area`.`Id` DESC ")->result_array();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;margin-bottom: 10px">
                                        <button class="btn btn-primary" id="StudentSub" type="Submit">أضف</button>
                                        <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                    </div>
                                    <br><br><h4 class="card-title"
                                                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        CH 024: قائمة أجهزة الوسيط الحراري - الثلاجات </h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-lg-12"></div>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th> #</th>
                                                    <th> رقم الوسيط الحراري MAC Address</th>
                                                    <th> نوع الوسيط الحراري</th>
                                                    <th> الوصف</th>
                                                    <th> التاريخ والوقت</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($Refrigerators as $Refrigerator) {
                                                    ?>
                                                    <tr>
                                                        <td><?php
                                                            $i++;
                                                            echo $i;
                                                            ?></td>
                                                        <td><?php echo $Refrigerator['mac_adress'] ?></td>
                                                        <td><?php
                                                            echo $Refrigerator['device_name_ar'] . '(' . $Refrigerator['min_temp'] . '-' . $Refrigerator['max_temp'] . ')';
                                                            ?></td>
                                                        <td><?php echo $Refrigerator['The_Site_Name'] ?></td>
                                                        <td><?php echo $Refrigerator['Added_in'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                        <?php if (!empty($prms)) { ?>
                            <div class="col-md-12 formcontainer" id="Area">
                                <br><br><h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 029: إضافة جهاز جودة الهواء</h4>
                                <div class="row">
                                    <form class="needs-validation InputForm col-md-12" novalidate
                                          style="margin-bottom: 27px;" id="AddArea">
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="control-label">نوع مكان وضع جهاز جودة
                                                                الهواء</label>
                                                            <select style="width: 100%;display: block;height: 50px;"
                                                                    class="form-control select2" name="Site">
                                                                <?php
                                                                $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                                foreach ($list as $site) {
                                                                    ?>
                                                                    <option value="<?php echo $site['Id']; ?>"> <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name_ar']; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">رقم جهاز جودة الهواء MAC
                                                                Address</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="MAC address" name="MAC" id="MAC">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">وصف الموقع</label>
                                                            <input type="text" class="form-control" placeholder="الوصف"
                                                                   name="Description">
                                                        </div>
                                                    </div>
                                                    <p class="card-text">ملاحظة : لائحة المواقع العامة</p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div style="margin-top: 10px;">
                                    <button class="btn btn-primary" id="AreaSub" type="Submit">أضف</button>
                                    <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                </div>
                                </form>
                                <br>
                                <br><br><h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 030: قائمة أجهزة جودة الهواء</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title"></h3>
                                        <table class="table">
                                            <thead>
                                            <th>#</th>
                                            <th>رقم جهاز جودة الهواء MAC Address</th>
                                            <th>نوع الموقع</th>
                                            <th>الوصف</th>
                                            <th>إجرائات</th>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($added_areas as $sn => $area) { ?>
                                                <tr class="air-quality-sensor-<?= $area['Id'] ?>">
                                                    <td><?= $sn + 1 ?></td>
                                                    <td><?= $area['mac_adress']; ?></td>
                                                    <td><?= $area['Site_name']; ?></td>
                                                    <td><?= $area['Description']; ?></td>
                                                    <td class="text-center">
                                                        <i style="cursor: pointer;" data-id="<?= $area['Id'] ?>"
                                                           class="uil uil-trash text-danger delete-sensors font-size-18"></i>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($cars_permissions)) { ?>
                            <div class="col-md-12 formcontainer" id="vehicle">
                                <br><br><h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 027: إضافة مركبة </h4>
                                <div class="row">
                                    <form class="needs-validation InputForm col-md-12" novalidate
                                          style="margin-bottom: 27px;" id="addvehicle">
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">رقم المركبة</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="معرف المركبة" name="vic_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">فئة المركبة </label>
                                                            <select id="vic_type" name="vic_type"
                                                                    class="form-control select2">
                                                                <?php foreach ($vehicle_types as $vehicle_type) { ?>
                                                                    <option value="<?= $vehicle_type['id'] ?>"><?= $vehicle_type['type_ar'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">نوع المركبة</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="شركة الإنتاج" name="vic_company">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">سنة الصنع</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="سنة التصنيع" name="vic_year">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">دولة الإنتاج </label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="دولة الإنتاج" name="vic_Country">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">رقم الساعة الخاصة بالسيارة MAC
                                                                Address</label>
                                                            <input id="input-ip" class="form-control input-mask"
                                                                   data-inputmask="'alias': 'mac'" name="mac_address">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">صنف المركبة - الطراز </label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="طراز السيارة" name="vic_Model">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="form-label" for="billing-name">اللون</label>
                                                            <select class="form-control select2" id="colors_select"
                                                                    name="colors_select">
                                                                <option value="">حدد لون المركبة</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <button class="btn btn-primary" type="Submit">أضف</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <br><br><h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 028: قائمة المركبات المضافة إلى النظام</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card w-100">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table w-100 cars">
                                                            <thead>
                                                            <th>#</th>
                                                            <th>رقم المركبة</th>
                                                            <th>فئة المركبة</th>
                                                            <th>نوع المركبة</th>
                                                            <th>دولة الإنتاج</th>
                                                            <th>صنف المركبة - الطراز</th>
                                                            <th>اللون</th>
                                                            <th class="text-center">إجرائات</th>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($vehicles as $key => $vehicle) { ?>
                                                                <tr>
                                                                    <td><?= $key + 1 ?></td>
                                                                    <td><?= $vehicle['No_vehicle'] ?></td>
                                                                    <td><?= $vehicle['type_vehicle'] ?? "هذا النوع لم يعد مدعوما" ?></td>
                                                                    <td><?= $vehicle['Company_vehicle'] ?></td>
                                                                    <td><?= $vehicle['Country_vehicle'] ?></td>
                                                                    <td><?= $vehicle['Model_vehicle'] ?></td>
                                                                    <td><?= $vehicle['Color_vehicle'] ?></td>
                                                                    <td class="actions">
                                                                        <a href="<?= base_url('AR/schools/Vehicles_list'); ?>">
                                                                            الرئيسية</a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row my-4">
                                <div class="col">
                                    <a href="<?php echo base_url(); ?>AR/schools"
                                       class="btn btn-link text-muted">
                                        <i class="uil uil-arrow-right mr-1"></i> عودة إلى لوحة البيانات المدرسية
                                    </a>
                                </div> <!-- end col -->
                            </div>
                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- end card -->
</div>
</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/rating-init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"); ?>"></script>
<?php /* <script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script> */ ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.amsifyselect.js"></script>
<script>
    // ajax sending
    $('.SelectGrade').amsifySelect({
        type: 'amsify'
    });

    $('.s-all').click(function () {
        var target = $(this).attr('data-target-select');
        $('select[name="' + target + '"] option').attr('selected', '');
        var selectedItems = [];
        var allOptions = $('select[name="' + target + '"]');
        allOptions.each(function () {
            selectedItems.push($(this).val());
        });
        $('select[name="' + target + '"]').select2("val", selectedItems);
    });

    $(".input-mask").inputmask();

    $('.table').DataTable();

    $("#AddMember").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/startAddStaff',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'إنتظر من فضلك',
                        text: ' تم حفظ المعلومات , جاري نقلها ... ',
                        icon: 'success',
                        onBeforeOpen: function () {
                            Swal.showLoading()
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "https://qlickhealth.com/admin/api/user/OTPLogin",
                        data: JSON.stringify(data.api_request_data),
                        success: function (response) {
                            response = JSON.parse(response);
                            console.log(response);
                            if (response.success == 1) {
                                Swal.fire({
                                    title: 'تم ',
                                    text: ' تم النقل بنجاح , شكرا لوقتك ',
                                    icon: 'success'
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else {
                                Swal.fire({
                                    title: 'مشكلة غير متوقعة',
                                    text: ' آسف لدينا خطأ في نسخ البيانات ، يرجى المحاولة مرة أخرى !! ',
                                    icon: 'error'
                                });
                            }
                        }
                    });
                } else {
                    $('#Toast').html(data);
                    $('#staffsub').removeAttr('disabled');
                    $('#staffsub').html('Submit !');
                }
            },
            beforeSend: function () {
                $('#staffsub').attr('disabled', '');
                $('#staffsub').html('Please wait.');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    $("#AddTeacher").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/startAddTeacher',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'إنتظر من فضلك',
                        text: ' تم حفظ المعلومات , جاري نقلها ... ',
                        icon: 'success',
                        onBeforeOpen: function () {
                            Swal.showLoading()
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "https://qlickhealth.com/admin/api/user/OTPLogin",
                        data: JSON.stringify(data.api_request_data),
                        success: function (response) {
                            response = JSON.parse(response);
                            console.log(response);
                            if (response.success == 1) {
                                Swal.fire({
                                    title: 'تم ',
                                    text: ' تم النقل بنجاح , شكرا لوقتك ',
                                    icon: 'success'
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else {
                                Swal.fire({
                                    title: 'مشكلة غير متوقعة',
                                    text: ' آسف لدينا خطأ في نسخ البيانات ، يرجى المحاولة مرة أخرى !! ',
                                    icon: 'error'
                                });
                            }
                        }
                    });
                } else {
                    $('#Toast').html(data);
                    $('#Teachersub').removeAttr('disabled');
                    $('#Teachersub').html('Submit !');
                }
            },
            beforeSend: function () {
                $('#Teachersub').attr('disabled', '');
                $('#Teachersub').html('Please wait.');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    $("#AddStudent").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/startAddStudent',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'إنتظر من فضلك',
                        text: ' تم حفظ المعلومات , جاري نقلها ... ',
                        icon: 'success',
                        onBeforeOpen: function () {
                            Swal.showLoading()
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "https://qlickhealth.com/admin/api/user/OTPLogin",
                        data: JSON.stringify(data.api_request_data),
                        success: function (response) {
                            response = JSON.parse(response);
                            console.log(response);
                            if (response.success == 1) {
                                Swal.fire({
                                    title: 'تم ',
                                    text: ' تم النقل بنجاح , شكرا لوقتك ',
                                    icon: 'success'
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else {
                                Swal.fire({
                                    title: 'مشكلة غير متوقعة',
                                    text: ' آسف لدينا خطأ في نسخ البيانات ، يرجى المحاولة مرة أخرى !! ',
                                    icon: 'error'
                                });
                            }
                        }
                    });
                } else {
                    $('#Toast').html(data);
                    $('#StudentSub').removeAttr('disabled');
                    $('#StudentSub').html('Submit !');
                }
            },
            beforeSend: function () {
                $('#StudentSub').attr('disabled', '');
                $('#StudentSub').html('Please wait.');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    $("#AddSite").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/startAddSite',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').html(data);
                $('#StudentSub').removeAttr('disabled');
                $('#StudentSub').html('Submit !');
            },
            beforeSend: function () {
                $('#StudentSub').attr('disabled', '');
                $('#StudentSub').html('Please wait.');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    $("#Addmachine").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/startAddMachine',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').html(data);
                $('#StudentSub').removeAttr('disabled');
                $('#StudentSub').html('add');
            },
            beforeSend: function () {
                $('#StudentSub').attr('disabled', '');
                $('#StudentSub').html('please wait....');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    <?php if (!empty($prms)) {  ?>
    $("#AddArea").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/startAddArea',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').html(data);
                $('#AreaSub').removeAttr('disabled');
                $('#AreaSub').html('add');
            },
            beforeSend: function () {
                $('#AreaSub').attr('disabled', '');
                $('#AreaSub').html('please wait....');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    <?php  } ?>

    <?php if (!empty($cars_permissions)) {  ?>
    $("#addvehicle").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/startaddvehicle',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire({
                        title: 'Good !',
                        text: 'The vehicle was added successfully.',
                        icon: 'success'
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                } else {
                    $('#Toast').html(data);
                }
                $('#addvehicle .btn').removeAttr('disabled');
                $('#addvehicle .btn').html('add');
            },
            beforeSend: function () {
                $('#addvehicle .btn').attr('disabled', '');
                $('#addvehicle .btn').html('please wait....');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    const CSS_COLOR_NAMES = ["AliceBlue", "AntiqueWhite", "Aqua", "Aquamarine", "Azure", "Beige", "Bisque",
        "Black", "BlanchedAlmond", "Blue", "BlueViolet", "Brown", "BurlyWood", "CadetBlue", "Chartreuse", "Chocolate",
        "Coral", "CornflowerBlue", "Cornsilk", "Crimson", "Cyan", "DarkBlue", "DarkCyan", "DarkGoldenRod", "DarkGray",
        "DarkGrey", "DarkGreen", "DarkKhaki", "DarkMagenta", "DarkOliveGreen", "DarkOrange", "DarkOrchid", "DarkRed",
        "DarkSalmon", "DarkSeaGreen", "DarkSlateBlue", "DarkSlateGray", "DarkSlateGrey", "DarkTurquoise", "DarkViolet",
        "DeepPink", "DeepSkyBlue", "DimGray", "DimGrey", "DodgerBlue", "FireBrick", "FloralWhite", "ForestGreen", "Fuchsia",
        "Gainsboro", "GhostWhite", "Gold", "GoldenRod", "Gray", "Grey", "Green", "GreenYellow", "HoneyDew", "HotPink", "IndianRed",
        "Indigo", "Ivory", "Khaki", "Lavender", "LavenderBlush", "LawnGreen", "LemonChiffon", "LightBlue", "LightCoral", "LightCyan",
        "LightGoldenRodYellow", "LightGray", "LightGrey", "LightGreen", "LightPink", "LightSalmon", "LightSeaGreen", "LightSkyBlue",
        "LightSlateGray", "LightSlateGrey", "LightSteelBlue", "LightYellow", "Lime", "LimeGreen", "Linen", "Magenta", "Maroon", "MediumAquaMarine",
        "MediumBlue", "MediumOrchid", "MediumPurple", "MediumSeaGreen", "MediumSlateBlue", "MediumSpringGreen", "MediumTurquoise", "MediumVioletRed",
        "MidnightBlue", "MintCream", "MistyRose", "Moccasin", "NavajoWhite", "Navy", "OldLace", "Olive", "OliveDrab", "Orange", "OrangeRed", "Orchid",
        "PaleGoldenRod", "PaleGreen", "PaleTurquoise", "PaleVioletRed", "PapayaWhip", "PeachPuff", "Peru", "Pink", "Plum", "PowderBlue", "Purple",
        "RebeccaPurple", "Red", "RosyBrown", "RoyalBlue", "SaddleBrown", "Salmon", "SandyBrown", "SeaGreen", "SeaShell", "Sienna", "Silver", "SkyBlue",
        "SlateBlue", "SlateGray", "SlateGrey", "Snow", "SpringGreen", "SteelBlue", "Tan", "Teal", "Thistle", "Tomato", "Turquoise", "Violet", "Wheat",
        "White", "WhiteSmoke", "Yellow", "YellowGreen"
    ];
    CSS_COLOR_NAMES.forEach(color => {
        var appen = '<option value="' + color + '">' + color + '</option>';
        $('#colors_select').append(appen);
    });
    $(".select2").select2();
    <?php  } ?>




    $('#back').click(function () {
        location.href = "<?php echo base_url() . "AR/schools"; ?>";
    });
    // إلغاء *
    $('#back').click(function () {
        location.href = "<?php echo base_url() . "AR/schools"; ?>";
    });

    function back() {
        location.href = "<?php echo base_url() . "AR/schools"; ?>";
    }

    $("input[name='Min'],input[name='Max']").TouchSpin({
        verticalbuttons: true
    }); //Bootstrap-MaxLength
    $(document).ready(function () {
        $("#UnitType").change(function () {
            var selectedunit = $(this).children("option:selected").val();
            if (selectedunit == 0) {
                $('#1').hide();
                $('#0').show();
            } else {
                $('#0').hide();
                $('#1').show();
            }
        });
        var prex = '';
        var firstname = '';
        var lastname = '';
        $('#Prefix').change(function () {
            prex = $(this).children("option:selected").val();
        });
        $('.FstaffName, .LstaffName').on("keyup keypress blur", function () {
            var firstname = $('.FstaffName').val();
            var lastname = $('.LstaffName').val();
            var all = prex + " " + firstname + " " + lastname;
            console.log('test');
            $('.StaffName').html(all);
        });
        $('.FTeacher_Name_EN, .LTeacher_Name_EN').on("keyup keypress blur", function () {
            var firstname = $('.FTeacher_Name_EN').val();
            var lastname = $('.LTeacher_Name_EN').val();
            var all = prex + " " + firstname + " " + lastname;
            console.log('test');
            $('.generatedNameTeacher').html(all);
        });
        $('.StudentNameF, .StudentNameL').on("keyup keypress blur", function () {
            var firstname = $('.StudentNameF').val();
            var lastname = $('.StudentNameL').val();
            var all = prex + " " + firstname + " " + lastname;
            console.log('test');
            $('.generatedNameStudent').html(all);
        });
    });
    $('.formcontainer').hide();
    <?php if (isset($_GET['last'])) { ?>
    <?php if ($_GET['last'] == 'Teacher') { ?>
    $('#Teacher').show();
    $('.control  button').removeClass('btn-primary');
    $('button[form_target="Teacher"]').addClass('btn-primary');
    <?php } elseif ($_GET['last'] == 'Student') { ?>
    $('.control  button').removeClass('btn-primary');
    $('button[form_target="Student"]').addClass('btn-primary');
    $('#Student').show();
    <?php } elseif ($_GET['last'] == 'Site') { ?>
    $('.control  button').removeClass('btn-primary');
    $('button[form_target="Site"]').addClass('btn-primary');
    $('#Site').show();
    <?php } else { ?>
    $('#staff').show();
    <?php } ?>
    <?php } else { ?>
    $('#staff').show();
    <?php } ?>
    $('.control button').click(function () {
        $('.control button').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $('.formcontainer').hide();
        var to = $(this).attr('form_target');
        $('#' + to).show();
        $('.generatedName').html('');
    });
    $("#classes").ionRangeSlider({
        skin: "round",
        type: "double",
        grid: true,
        min: 0,
        max: 12,
        from: 0,
        to: 12,
        values: ['KG1', 'KG2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
    });
    // $("#classes").ionRangeSlider({
    //     skin: "round",
    //     type: "double",
    //     grid: true,
    //     min: 0,
    //     max: 12,
    //     from: 0,
    //     to: 12,
    //     values: ['KG1', 'KG2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
    // });
    document.getElementById("MAC").addEventListener('keyup', function () {
        var mac = document.getElementById('MAC').value;
        if (mac.length < 2) {
            return;
        }
        var newMac = mac.replace("-", "");
        if ((isHex(mac[mac.length - 1]) && (isHex(mac[mac.length - 2])))) {
            newMac = newMac + ":";
        }
        document.getElementById('MAC').value = newMac;
    });
    $("table").on("click", ".delete-sensors", function () {
        const k = $(this).data('id');
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `نعم`,
            cancelButtonText: `إلغاء`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= base_url("AR/schools/air-quality/") ?>" + k,
                    success: function (response) {
                        if (response.status == "ok") {
                            $(".air-quality-sensor-" + k).remove();
                        } else {
                            Swal.fire({
                                title: ' Error ',
                                text: response.message ?? "",
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    });
</script>
</body>
s

</html>