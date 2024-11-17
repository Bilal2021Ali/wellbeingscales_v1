<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?= base_url() ?>assets/libsArea/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
<link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?= base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
<link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css"/>

<body class="light menu_light logo-white theme-white">

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
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <br>
                    <div class="row image_container">
                        <img src="<?= base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            CH P004: Add New Teacher, Staff, Refrigerator, General Site, Vehicle, and Air Quality Device</h4>
        <div class="row">
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                        <div class="card-body" style="background-color: #022326;">
                            <div class="float-right mt-2">
                                <!-- <div id="CharTTest1"></div>-->
                                <img src="<?= base_url(); ?>assets/images/icons/png_icons/Staffs.png"
                                     alt="Number of Staff" width="75px"></i>
                            </div>
                            <div>
                                <?php
                                $idd = $sessiondata['admin_id'];
                                $all = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsStaff = $this->db->query("SELECT * FROM `l2_staff`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $all ?></span></h4>
                                <p class="mb-0">Staff</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsStaff

                                        as $last) { ?>
                                        <?= $last['Created'] ?></span><br>
                                Last registered staff
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
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/teachers.png"
                                    alt="department" width="75px"></div>
                            <div>
                                <?php
                                $allstudents = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allstudents ?></span></h4>
                                <p class="mb-0">Teachers</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsTeachers

                                        as $last) { ?>
                                        <?= $last['Created'] ?></span><br>
                                Last registered teacher
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
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/Students.png"
                                    alt="Number of Students" width="75px"></div>
                            <div>
                                <?php
                                $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allstudents ?></span></h4>
                                <p class="mb-0">Students</p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lastsStudent

                                        as $last) { ?>
                                        <?= $last['Created'] ?></span><br>
                                Last registered student
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
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/sites.png" alt="schools"
                                    width="50px"></div>
                            <div>
                                <?php
                                $Allsites = $this->db->query("SELECT * FROM `l2_site` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsSites = $this->db->query("SELECT * FROM `l2_site`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $Allsites ?></span></h4>
                                <p class="mb-0">Sites</p>
                            </div>
                            <?php if (!empty($lastsSites)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                            <?php foreach ($lastsSites

                                            as $last) { ?>
                                            <?= $last['Created'] ?></span><br>
                                    Last registered site
                                    <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1"
                                                           style="color: #e1da6a;"> <?= "--/--/--"; ?></span><br>
                                    Last registered site </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->

        <h4 class="card-title" style="background: #1E1E1E; padding: 10px;color:#1E1E1E;border-radius: 4px;">CH 019: Add
            New Teacher, Staff, Refrigerator, General Site, Vehicle, and Air Quality Device</h4>
        <div class="row">
            <div class="col-xl-12">
                <div class="">
                    <div class="card-body" style="padding-top: 1px;">
                        <div class="alert alert-dismissible fade show" role="alert"><span id="Toast"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="control col-md-12">
                            <button type="button" form_target="staff" class="btn btn-primary w-md contr_btn">
                                <i class="uil uil-plus"></i>Staff
                            </button>
                            <button type="button" form_target="Teacher" class="btn w-md contr_btn">
                                <i class="uil uil-plus"></i>Teacher
                            </button>
                            <button type="button" form_target="Student" class="btn w-md contr_btn">
                                <i class="uil uil-plus"></i>Student
                            </button>
                            <button type="button" form_target="Refrigerator" class="btn w-md contr_btn">
                                <i class="uil uil-plus"></i>Refrigerator
                            </button>
                            <button type="button" form_target="Site" class="btn w-md contr_btn">
                                <i class="uil uil-plus"></i>General Site
                            </button>
                            <?php if (!empty($cars_permissions)) { ?>
                                <button type="button" form_target="vehicle" class="btn w-md contr_btn">
                                    <i class="uil uil-plus"></i>Vehicle
                                </button>
                            <?php } ?>
                            <?php if (!empty($prms)) { ?>
                                <button type="button" form_target="Area" class="btn w-md contr_btn">
                                    <i class="uil uil-plus"></i>Air Quality
                                </button>
                            <?php } ?>
                        </div>

                        <div class="col-md-12 formcontainer" id="staff"><br>
                            <h4 class="card-title"
                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 020: Add New Staff</h4>
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="AddMember">
                                    <div class="card">
                                        <div class="card-body">
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <h4 class="card-title"
                                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Prefix</h4>
                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option
                                                                value="<?= $pref['Prefix']; ?>"> <?= $pref['Prefix']; ?>
                                                                .
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-8 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;" class="StaffName"></h3>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            First Name English </h4>
                                                        <input type="text" class="form-control FstaffName"
                                                               placeholder="First Name English" name="First_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Middle Name English </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name English" name="Middle_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">

                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Last Name English </h4>
                                                        <input type="text" class="form-control LstaffName"
                                                               id="validationCustom01" placeholder="Last Name English"
                                                               name="Last_Name_EN" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            First Name Arabic </h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="First Name Arabic" name="First_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Middle Name Arabic </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name ArabicR" name="Middle_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Last Name Arabic </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Last Name Arabic" name="Last_Name_AR"
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
                                                    <div class="form-group"><br>
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Date of Birth </h4>

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
                                                        <br>
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Phone </h4>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="Phone" name="Phone">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <br><h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Gender </h4>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            National ID</h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="National ID" name="N_Id" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Nationality</h4>

                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `r_countries`.`name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <option value="Qatar"> Qatar</option>
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?= $contries['name']; ?>"
                                                                        class="option"> <?= $contries['name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            MAC Address</h4>
                                                        <input id="input-ip" class="form-control input-mask"
                                                               data-inputmask="'alias': 'mac'" name="mac_address">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Position</h4>
                                                        <select class="form-control" name="Position">
                                                            <?php foreach ($Positions as $Position) { ?>
                                                                <option
                                                                    value="<?= $Position['Id'] ?>"> <?= $Position['Position'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Email</h4>
                                                        <input type="email" class="form-control" placeholder="Email"
                                                               name="Email" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Marital Status</h4>

                                                        <select class="form-control" name="relationship">
                                                            <?php foreach ($av_relationships as $av_relationship) { ?>
                                                                <option
                                                                    value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="staffsub" type="Submit">Submit form</button>
                                <button type="reset" class="btn btn-light">Cancel</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-12 formcontainer" id="Teacher"><br>
                            <h4 class="card-title"
                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 021: Add New Teacher</h4>
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="AddTeacher">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;"><br>
                                                    <h4 class="card-title"
                                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Prefix</h4>

                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option
                                                                value="<?= $pref['Prefix']; ?>"> <?= $pref['Prefix']; ?>
                                                                .
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-8 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;"
                                                        class="generatedNameTeacher"></h3>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row" style="padding: 0px;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            First Name English </h4>
                                                        <input type="text" class="form-control FTeacher_Name_EN"
                                                               placeholder="First Name English" name="First_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Middle Name English </h4>
                                                        <input type="text" class="form-control " id="validationCustom01"
                                                               placeholder="Middle Name English" name="Middle_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Last Name English </h4>
                                                        <input type="text" class="form-control LTeacher_Name_EN"
                                                               id="validationCustom01" placeholder="Last Name English"
                                                               name="Last_Name_EN" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            First Name Arabic </h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="First Name Arabic" name="First_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Middle Name Arabic </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name Arabic" name="Middle_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Last Name Arabic </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Last Name Arabic" name="Last_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Date of Birth </h4>
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
                                                    <div class="form-group"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Phone </h4>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="Phone" name="Phone">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4"><br>
                                                    <h4 class="card-title"
                                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Gender </h4>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            National ID</h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="National ID" name="N_Id" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Nationality</h4>
                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <option value="Qatar"> Qatar</option>
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?= $contries['name']; ?>"
                                                                        class="option"> <?= $contries['name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-4"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            MAC Address</h4>
                                                        <input id="input-ip" class="form-control input-mask"
                                                               data-inputmask="'alias': 'mac'" name="mac_address">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Position</h4>
                                                        <select class="form-control" name="Position">
                                                            <?php foreach ($Positions_tech as $Position) { ?>
                                                                <option
                                                                    value="<?= $Position['Id'] ?>"> <?= $Position['Position'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4"
                                                     style="margin-bottom: 11px;display: grid;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Email</h4>
                                                        <input type="email" class="form-control" placeholder="Email"
                                                               name="Email" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br><h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Classes
                                                        <span class="float-right text-white btn s-all"
                                                              data-target-select="Classes[]"
                                                              style="margin-top: -9px;">Select all</span>
                                                    </h4>
                                                    <div class="form-group">
                                                        <?php if (!empty($classes)) { ?>
                                                            <select name="Classes[]"
                                                                    class="form-control select2 select2-multiple"
                                                                    multiple="multiple" data-placeholder="Choose ..."
                                                                    id="">
                                                                <?php foreach ($classes as $class) { ?>
                                                                    <option
                                                                        value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <p>You don't have any class, Please edit the school profile
                                                                <a href="<?= base_url() ?>EN/schools/Profile">Profile</a>
                                                            </p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Marital Status</h4>
                                                        <select class="form-control" name="relationship">
                                                            <?php foreach ($av_relationships as $av_relationship) { ?>
                                                                <option
                                                                    value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
                                <button type="reset" class="btn btn-light">Cancel</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-12 formcontainer" id="Student"><br>
                            <h4 class="card-title"
                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 022: Add a New Student</h4>
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12 custom-validation" novalidate=""
                                      style="margin-bottom: 27px;" id="AddStudent">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6" style="margin-bottom: 11px;"><br>
                                                    <h4 class="card-title"
                                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Prefix</h4>
                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option
                                                                value="<?= $pref['Prefix']; ?>"> <?= $pref['Prefix']; ?>
                                                                .
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-6" style="margin-bottom: 11px;">
                                                    <h4 class="card-title"
                                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -10px;">
                                                        Avatar</h4>
                                                    <input type="file" accept="image/*" class="form-control"
                                                           name="avatar">
                                                </div>
                                                <div class="col-md-4 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;"
                                                        class="generatedNameStudent"></h3>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row" style="padding: 0px;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            First Name English </h4>
                                                        <input type="text" class="form-control StudentNameF"
                                                               placeholder="First Name English" name="First_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Middle Name English </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name English" name="Middle_Name_EN"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Last Name English </h4>
                                                        <input type="text" class="form-control StudentNameL"
                                                               id="validationCustom01" placeholder="Last Name English"
                                                               name="Last_Name_EN" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            First Name Arabic </h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="First Name Arabic" name="First_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Middle Name Arabic </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name Arabic" name="Middle_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Last Name Arabic </h4>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Last Name AR" name="Last_Name_AR"
                                                               required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body"><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Date of Birth </h4>
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
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Phone </h4>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="Phone" name="Phone">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br><h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Gender </h4>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
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
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            National ID</h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="National ID" name="N_Id" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Nationality</h4>
                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <option value="Qatar"> Qatar</option>
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?= $contries['name']; ?>"
                                                                        class="option"> <?= $contries['name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-4">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            MAC Address</h4>
                                                        <input id="input-ip" class="form-control input-mask"
                                                               data-inputmask="'alias': 'mac'" name="mac_address">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Email</h4>
                                                        <input type="email" class="form-control" placeholder="Email"
                                                               name="Email" required="">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Father/First Guardian’s National ID</h4>

                                                        <input type="text" class="form-control"
                                                               placeholder="Father/First Parent’s National ID"
                                                               data-parsley-minlength="11" required name="P_NID">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            other/ Second Guardian’s National ID</h4>

                                                        <input type="text" class="form-control"
                                                               placeholder="Mother/Second Guardian’s National ID"
                                                               name="M_NID">
                                                        <div class="valid-feedback"> Looks good!</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <br><h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Year Level</h4>

                                                    <div class="form-group">
                                                        <?php if (!empty($classes)) { ?>
                                                            <select name="Classes" class="form-control select2" id="">
                                                                <?php foreach ($classes as $class) { ?>
                                                                    <option
                                                                        value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <p>You don’t have any class. Please edit the school profile.
                                                                <a href="<?= base_url() ?>EN/schools/Profile">Profile</a>
                                                            </p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br><h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                        Section/Course</h4>
                                                    <select name="Grades" class="form-control">
                                                        <option value="">Section/Course</option>
                                                        <?php foreach ($this->config->item("av_grades") as $grade) { ?>
                                                            <option
                                                                value="<?= $grade['value'] ?>"><?= $grade['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <br><h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Marital Status</h4>
                                                        <select class="form-control" name="relationship">
                                                            <?php foreach ($av_relationships as $av_relationship) { ?>
                                                                <option
                                                                    value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="StudentSub" type="Submit">Submit form</button>
                                <button type="reset" class="btn btn-light">Cancel</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-12 formcontainer" id="Site">
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="AddSite"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        CH 025: Add a New General Site</h4>
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Type of Site English</h4>
                                                        <select style="width: 100%;display: block;height: 50px;"
                                                                class="form-control select2" name="Site">
                                                            <?php
                                                            $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                            foreach ($list as $site) {
                                                                ?>
                                                                <option
                                                                    value="<?= $site['Site_Name']; ?>"> <?= $site['Site_Code'] . ' - ' . $site['Site_Name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Description of Site English</h4>
                                                        <input type="text" class="form-control"
                                                               placeholder="Description" name="Description">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Type of Site Arabic </h4>
                                                        <select style="width: 100%;display: block;height: 50px;"
                                                                class="form-control select2" name="Site_ar">
                                                            <?php
                                                            $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                            foreach ($list as $site) {
                                                                ?>
                                                                <option
                                                                    value="<?= $site['Site_Name_ar']; ?>"> <?= $site['Site_Code'] . ' - ' . $site['Site_Name_ar']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Description of Site Arabic</h4>
                                                        <input type="text" autocomplete="off" class="form-control"
                                                               placeholder="Description" name="Description_ar">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Device Type</h4>
                                                        <select style="width: 100%;display: block;height: 50px;"
                                                                class="form-control select2" name="Site_for">
                                                            <option value="1"> Lab Test</option>
                                                            <option value="2"> Thermometer</option>
                                                            <option value="3"> Gateway</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-primary" id="StudentSub" type="Submit">Submit form</button>
                                <button type="reset" class="btn btn-light">Cancel</button>
                            </div>
                            </form>
                            <br><br>
                            <h4 class="card-title"
                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 026: List of Last Added General Sites </h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table>
                                                <thead>
                                                <th>#</th>
                                                <th>Type Site</th>
                                                <th>Description</th>
                                                <th>For</th>
                                                </thead>
                                                <tbody>
                                                <?php $codes = array(1, 2, 3); ?>
                                                <?php $names = array('Lab Test', 'Thermometer', 'Gateway'); ?>
                                                <?php foreach ($sites as $sn => $site) { ?>
                                                    <tr>
                                                        <td><?= $sn + 1 ?></td>
                                                        <td><?= $site['Site_Code'] ?></td>
                                                        <td><?= $site['Description'] ?></td>
                                                        <td><?= $site['Site_For'] == "" ? "not found" : str_replace($codes, $names, $site['Site_For']); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 formcontainer" id="Refrigerator"><br>
                            <h4 class="card-title"
                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                CH 023: Add a New Refrigerator </h4>
                            <div class="row">
                                <form class="needs-validation InputForm col-md-12" novalidate
                                      style="margin-bottom: 27px;" id="Addmachine">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4"><br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Refrigerator MAC Address</h4>

                                                        <input class="form-control input-mask" placeholder="MAC address"
                                                               data-inputmask="'alias': 'mac'" name="name"
                                                               im-insert="true">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Refrigerator Type/Range</h4>

                                                        <?php
                                                        $types = $this->db->query("SELECT * FROM  `refrigerator_levels`")->result_array();
                                                        ?>
                                                        <select name="type" class="form-control">
                                                            <?php foreach ($types as $type) { ?>
                                                                <option
                                                                    value="<?= $type['Id'] ?>"> <?= $type['device_name'] . "  (" . $type['min_temp'] . "," . $type['max_temp'] . ")" ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Type of Refrigerator Site</h4>

                                                        <select class="form-control" name="Site">
                                                            <?php
                                                            $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                            foreach ($list as $site) {
                                                                ?>
                                                                <option
                                                                    value="<?= $site['Id']; ?>"> <?= $site['Site_Code'] . ' - ' . $site['Site_Name']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <p class="card-text">Note: List of General Site </p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <br>
                                                        <h4 class="card-title"
                                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                            Description of Refrigerator</h4>

                                                        <input type="text" class="form-control"
                                                               placeholder="Description of Refrigerator"
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
                                        <button class="btn btn-primary" id="StudentSub" type="Submit">Add</button>
                                        <button type="button" class="btn btn-light" id="back">Cancel</button>
                                    </div>
                                    <br><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        CH 024: List of Last Added Refrigerators </h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-lg-12"></div>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th> #</th>
                                                    <th> MAC Address</th>
                                                    <th> Type</th>
                                                    <th> Description</th>
                                                    <th> Date &amp; Time</th>
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
                                                        <td><?= $Refrigerator['mac_adress'] ?></td>
                                                        <td><?php
                                                            echo $Refrigerator['device_name'] . '(' . $Refrigerator['min_temp'] . '-' . $Refrigerator['max_temp'] . ')';
                                                            ?></td>
                                                        <td><?= $Refrigerator['The_Site_Name'] ?></td>
                                                        <td><?= $Refrigerator['Added_in'] ?></td>
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
                            <div class="col-md-12 formcontainer" id="Area"><br>
                                <h4 class="card-title"
                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 029: Add a New Air Quality Sensor</h4>
                                <form class="needs-validation InputForm col-md-12" novalidate
                                      style="margin-bottom: 27px;" id="AddArea">
                                    <div class="row">
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Site</h4>
                                                            <select style="width: 100%;display: block;height: 50px;"
                                                                    class="form-control select2" name="Site">
                                                                <?php
                                                                $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                                foreach ($list as $site) {
                                                                    ?>
                                                                    <option
                                                                        value="<?= $site['Id']; ?>"> <?= $site['Site_Code'] . ' - ' . $site['Site_Name']; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                MAC Address</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="MAC Address" name="MAC" id="MAC">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Description</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Sensor Description" name="Description">
                                                        </div>
                                                    </div>
                                                    <p class="card-text">Note: General Site List</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <button class="btn btn-primary" id="AreaSub" type="Submit">Add</button>
                                        <button type="button" class="btn btn-light" id="back">Cancel</button>
                                    </div>
                                </form>
                                <br>
                                <h4 class="card-title"
                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 030: List of Registered Air Quality Sensors</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title"></h3>
                                        <table class="table">
                                            <thead>
                                            <th>#</th>
                                            <th>MAC Address</th>
                                            <th>Site Type</th>
                                            <th>Description</th>
                                            <th>Action</th>
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
                            <div class="col-md-12 formcontainer" id="vehicle"><br>
                                <h4 class="card-title"
                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 027: Add a New Vehicle</h4>
                                <div class="row">
                                    <form class="needs-validation InputForm col-md-12" novalidate
                                          style="margin-bottom: 27px;" id="addvehicle">
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Vehicle ID</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Vehicle ID" name="vic_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Vehicle Type</h4>
                                                            <select id="vic_type" name="vic_type"
                                                                    class="form-control select2">
                                                                <?php foreach ($vehicle_types as $vehicle_type) { ?>
                                                                    <option
                                                                        value="<?= $vehicle_type['id'] ?>"><?= $vehicle_type['type'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Vehicle Company</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Vehicle Company" name="vic_company">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Production Year</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Production Year" name="vic_year">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Production Country</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Production Country" name="vic_Country">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                MAC Address</h4>
                                                            <input id="input-ip" class="form-control input-mask"
                                                                   data-inputmask="'alias': 'mac'" name="mac_address">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Vehicle Model</h4>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Vehicle Model" name="vic_Model">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <br>
                                                            <h4 class="card-title"
                                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                                Vehicle Color</h4>
                                                            <select class="form-control select2" id="colors_select"
                                                                    name="colors_select">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <button class="btn btn-primary" type="Submit">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <h4 class="card-title"
                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                    CH 028: List of Last Added Vehicles</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card w-100">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table w-100 cars">
                                                            <thead>
                                                            <th>#</th>
                                                            <th>Vehicle ID</th>
                                                            <th>Vehicle Type</th>
                                                            <th>Company</th>
                                                            <th>Country</th>
                                                            <th>Model</th>
                                                            <th>Color</th>
                                                            <th class="text-center">Action</th>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($vehicles as $key => $vehicle) { ?>
                                                                <tr>
                                                                    <td><?= $key + 1 ?></td>
                                                                    <td><?= $vehicle['No_vehicle'] ?></td>
                                                                    <td><?= $vehicle['type_vehicle'] ?? "This type is no longer available" ?></td>
                                                                    <td><?= $vehicle['Company_vehicle'] ?></td>
                                                                    <td><?= $vehicle['Country_vehicle'] ?></td>
                                                                    <td><?= $vehicle['Model_vehicle'] ?></td>
                                                                    <td><?= $vehicle['Color_vehicle'] ?></td>
                                                                    <td class="actions">
                                                                        <a href="<?= base_url('EN/schools/Vehicles_list'); ?>">Vehicle
                                                                            Management</a>
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
<script src="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/rating-init.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
<script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"); ?>"></script>
<?php /* <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script> */ ?>
<script src="<?= base_url(); ?>assets/js/jquery.amsifyselect.js"></script>
<script>
    // ajax sending
    $('.SelectGrade').amsifySelect({
        type: 'amsify'
    });
    $(".input-mask").inputmask();
    $('.table').DataTable();

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

    $("#AddMember").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/startAddStaff',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Success',
                        text: 'Everything looks good. Thank you! ',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    $('#Toast').html(data.message);
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
            url: '<?= base_url(); ?>EN/schools/startAddTeacher',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Success',
                        text: 'Everything looks good. Thank you! ',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    $('#Toast').html(data.message);
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
            url: '<?= base_url(); ?>EN/schools/startAddStudent',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Success',
                        text: 'Everything looks good. Thank you! ',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    $('#Toast').html(data.message);
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
            url: '<?= base_url(); ?>EN/schools/startAddSite',
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
            url: '<?= base_url(); ?>EN/schools/startAddMachine',
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
            url: '<?= base_url(); ?>EN/schools/startAddArea',
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
            url: '<?= base_url(); ?>EN/schools/startaddvehicle',
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
        location.href = "<?= base_url() . "EN/schools"; ?>";
    });
    // Cancel *
    $('#back').click(function () {
        location.href = "<?= base_url() . "EN/schools"; ?>";
    });

    function back() {
        location.href = "<?= base_url() . "EN/schools"; ?>";
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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= base_url("EN/schools/air-quality/") ?>" + k,
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

</html>