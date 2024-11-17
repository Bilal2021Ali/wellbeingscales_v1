<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
<link href="<?= base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
<link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?= base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
<link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
    #media_link .d-grid .btn-danger.inner {
        height: 100%;
        font-size: 20px;
    }

    .delete {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 100%;
        padding-top: 4px;
        padding-left: 10px;
        position: absolute;
        top: 10px;
        left: 10px;
        color: #b30000;
        cursor: pointer;
        border: 1px solid #eeee;
        font-size: 20px;
    }
</style>
<style>
    .switch {
        position: absolute;
        display: inline-block;
        width: 50px;
        height: 24px;
        top: 16px;
        right: 8px;
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
        background-color: #CB0002;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #75b030;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
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

    .swal2-html-container p {
        margin-bottom: 0px !important;
    }
</style>
<?php

function getIPAddress()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } //whether ip is from the remote address
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ip = getIPAddress();
//echo 'User Real IP Address - '.$_SERVER['REMOTE_ADDR'];
//print_r($sessiondata);
?>
<div class="outer"></div>
<style>
    .control {
        margin: 10px auto;
    }

    .control i {
        margin: 4px;
        font-size: 16px;
        margin-left: -1px;
    }

    .select2-results__group {
        color: #8F0002;
    }

    .bx.bxs-trash-alt {
        font-size: 24px;
        color: #e8625b;
        margin-left: 9px;
        cursor: pointer;
    }


    * {
        list-style: none;
    }

    .cancel-button-class {
        width: 100%;
        background: #C30003;
    }

    .btn.disabled,
    .btn:disabled {
        opacity: 1;
        cursor: default;
    }

    .classChoice {
        cursor: pointer;
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
                <div class="card"><br>
                    <div class="row image_container"><img src="<?= base_url(); ?>assets/images/banners/SCHOOL102.png"
                                                          alt="schools"></div>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("ch_school_profile") ?></h4>
        <div class="row">
            <!-- Staff  -->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                        <div class="card-body" style="background-color: #022326;">
                            <div class="float-right mt-2">
                                <!-- <div id="CharTTest1"></div>-->
                                <img src="<?= base_url(); ?>assets/images/schoolDashboard/icons/Staff.png" alt="schools"
                                     width="64px">
                            </div>
                            <div>
                                <?php
                                $idd = $sessiondata['admin_id'];
                                $all = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsStaff = $this->db->query("SELECT * FROM `l2_staff`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                      <?= $all ?>
                    </span></h4>
                                <p class="mb-0"><?= __("staff") ?></p>
                            </div>
                            <?php if (!empty($lastsStaff)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php foreach ($lastsStaff

                      as $last) { ?>
                      <?= $last['Created'] ?>
                    </span><br>
                                    <?= __("last_registered_staff") ?>
                                    <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?= "--/--/--"; ?>
                    </span><br> <?= __("last_registered_staff") ?> </p>
                            <?php } ?>
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
                                        src="<?= base_url(); ?>assets/images/schoolDashboard/icons/teachers.png"
                                        alt="schools" width="64px"></div>
                            <div>
                                <?php
                                $allstudents = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $idd . "' ")->num_rows();
                                $lastsTeachers = $this->db->query("SELECT * FROM `l2_teacher`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $allstudents ?>
                    </span></h4>
                                <p class="mb-0"><?= __("teachers") ?></p>
                            </div>
                            <?php if (!empty($lastsTeachers)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php foreach ($lastsTeachers

                      as $last) { ?>
                      <?= $last['Created'] ?>
                    </span><br>
                                    <?= __("last_registered_teacher") ?>
                                    <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?= "--/--/--"; ?>
                    </span><br>
                                    <?= __("last_registered_teacher") ?> </p>
                            <?php } ?>
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
                                        src="<?= base_url(); ?>assets/images/schoolDashboard/icons/Students.png"
                                        width="64px"></div>
                            <div>
                                <?php
                                $allstudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsStudent = $this->db->query("SELECT * FROM `l2_student`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $allstudents ?>
                    </span></h4>
                                <p class="mb-0"><?= __("students") ?></p>
                            </div>
                            <?php if (!empty($lastsStudent)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php foreach ($lastsStudent

                      as $last) { ?>
                      <?= $last['Created'] ?>
                    </span><br>
                                    <?= __("last_registered_student") ?>
                                    <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?= "--/--/--"; ?>
                    </span><br>
                                    <?= __("last_registered_student") ?> </p>
                            <?php } ?>
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
                                        src="<?= base_url(); ?>assets/images/schoolDashboard/icons/sites.png"
                                        alt="schools" width="64px"></div>
                            <div>
                                <?php
                                $Allsites = $this->db->query("SELECT * FROM `l2_site` WHERE `Added_By` = $idd ")->num_rows();
                                $lastsSites = $this->db->query("SELECT * FROM `l2_site`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $Allsites ?>
                    </span></h4>
                                <p class="mb-0"><?= __("sites") ?></p>
                            </div>
                            <?php if (!empty($lastsSites)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php foreach ($lastsSites

                      as $last) { ?>
                      <?= $last['Created'] ?>
                    </span><br>
                                    <?= __("last_registered_site") ?>
                                    <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?= "--/--/--"; ?>
                    </span><br>
                                    <?= __("last_registered_site") ?> </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-->
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="">
                    <div class="card-body">
                        <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                            <span id="Toast"><?= __("ch_school_profile") ?>
                            <a title="Export..." target="_blank" class="float-right"
                               href="<?= base_url(); ?>export/all">
                                <?= __("export_students") ?>
                                <i class="uil-export"></i>
                            </a>
                </span>
                        </div>
                        <div class="control col-md-12">
                            <button type="button" form_target="Profile" class="btn btn-primary w-md contr_btn"><i
                                        class="uil uil-user"></i><?= __("update_profile") ?>
                            </button>
                            <button type="button" form_target="Classes" class="btn w-md contr_btn"><i
                                        class="uil uil-list-ui-alt"></i><?= __("update_classes") ?>
                            </button>
                            <button type="button" form_target="Attendees_times" class="btn w-md contr_btn"><i
                                        class="uil uil-plus"></i> <?= __("school_time") ?>
                            </button>
                        </div>
                        <div class="col-md-12 formcontainer" id="Profile"><br>
                            <div class="row card">
                                <?php
                                $id = $sessiondata['admin_id'];
                                $schoolData = $this->db->query("SELECT * FROM l1_school 
                                    WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                                ?>
                                <?php foreach ($schoolData

                                as $data) { ?>
                                <form class="needs-validation InputForm card-body" novalidate
                                      style="margin-bottom: 27px;" id="UpdateSchool">
                                    <br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("information_editable_except_username") ?></h4>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school_english_name") ?></h4>
                                                <input type="text" class="form-control"
                                                       placeholder="<?= __("school_english_name") ?>"
                                                       name="English_Title" value="<?= $data['School_Name_EN'] ?>"
                                                       required>
                                                <div class="valid-feedback"><?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> <?= __("school_arabic_name") ?></h4>
                                                <input type="text" class="form-control" id="validationCustom01"
                                                       placeholder="<?= __("school_arabic_name") ?>"
                                                       value="<?= $data['School_Name_AR'] ?>" name="Arabic_Title"
                                                       required>
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("manager_english_name") ?></h4>
                                                <input type="text" class="form-control"
                                                       placeholder="<?= __("manager_english_name") ?>"
                                                       name="Manager_EN"
                                                       value="<?= $data['Manager_EN'] ?>" required>
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("manager_arabic_name") ?></h4>
                                                <input type="text" class="form-control" id="validationCustom01"
                                                       placeholder="<?= __("manager_arabic_name") ?>"
                                                       value="<?= $data['Manager_AR'] ?>" name="Manager_AR" required>
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school_classification") ?></h4>
                                            <select name="Type" class="custom-select">
                                                <option
                                                        value="Government" <?= $data['Type_Of_School'] == "Government" ? "selected" : "" ?>
                                                        class="option"><?= __("government") ?>
                                                </option>
                                                <option
                                                        value="Private" <?= $data['Type_Of_School'] == "Private" ? "selected" : "" ?>
                                                        class="option"><?= __("private") ?>
                                                </option>

                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school_type") ?></h4>

                                            <select name="School_Gender" class="custom-select">
                                                <option value="Male" <?= $data['Gender'] == "Male" ? "selected" : "" ?>
                                                        class="option"><?= __("all_boys") ?>
                                                </option>
                                                <option value="Female" <?= $data['Gender'] == "Female" ? "selected" : "" ?>
                                                        class="option"><?= __("all_girls") ?>
                                                </option>
                                                <option value="mix" <?= $data['Gender'] == "mix" ? "selected" : "" ?>
                                                        class="option"><?= __("mixed_boys_and_girls") ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("country") ?></h4>
                                                <select style="width: 100%;display: block;height: 50px;"
                                                        class="form-control select2" name="Country">
                                                    <?php
                                                    $list = $this->db->query("SELECT * FROM `r_countries` ORDER BY `name` ASC")->result_array();
                                                    foreach ($list as $site) {
                                                        ?>
                                                        <option
                                                                value="<?= $site['id']; ?>" <?= $site['id'] == $data['Country'] ? "selected" : "" ?>>
                                                            <?= $site['name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="cities">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> <?= __("city") ?></h4>
                                                <input type="hidden" value="<?= $data['Citys'] ?>" readonly
                                                       class="form-control" name="City"
                                                       placeholder="<?= __("select_country_to_show_cities") ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div id="directorate-response" class="row">

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("phone") ?></h4>
                                                <input type="text" class="form-control" id="validationCustom01"
                                                       placeholder="<?= __("phone") ?>" value="<?= $data['Phone'] ?>"
                                                       name="Phone" required>
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("email") ?></h4>
                                                <input type="text" class="form-control" placeholder="<?= __("email") ?>"
                                                       name="Email"
                                                       value="<?= $data['Email'] ?>" required="">
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>


                                    <div class="row">
                                        <div class="col-md-6" style="display: grid;align-items: center;">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("username") ?></h4>
                                                <input type="text" class="form-control"
                                                       placeholder="<?= __("cannot_change_username") ?>"
                                                       value="<?= $data['Username'] ?>" readonly
                                                       title="<?= __("cannot_change_username") ?> ">
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display: grid;align-items: center;">
                                            <div class="form-group">
                                                <h4 class="card-title"
                                                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school_id") ?></h4>
                                                <input type="text" class="form-control" name="SchoolId"
                                                       placeholder="<?= __("school_id") ?>"
                                                       value="<?= $data['SchoolId'] ?>">
                                                <div class="valid-feedback"> <?= __("looks_good") ?></div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <button class="btn btn-primary" type="Submit"><?= __("save_changes") ?></button>

                            <button type="button" class="btn btn-light" id="back"><?= __("cancel") ?></button>

                            <button class="btn btn-success waves-effect waves-light setTheLocation"
                                    style="float: right;" type="button">
                                <i class="mdi mdi-map-marker "></i>
                                <?= __("set_your_location") ?>
                            </button>

                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 formcontainer" id="Classes">
                        <div class="row card">
                            <form class="card-body" id="Addclasses">
                                <style>
                                    .classChoice.checked .card {
                                        border: 3px solid #35c38f;
                                    }

                                    .classChoice .avatar-title {
                                        color: #5b73e8;
                                        background-color: rgba(91, 115, 232, .25);
                                    }

                                    .classChoice.checked .avatar-title {
                                        background-color: rgba(52, 195, 143, 0.25) !important;
                                        color: #34c38f !important;
                                    }

                                    .disabled .card {
                                        border: 1px solid #636363;
                                        background: #c5c5c5;
                                        color: #fff;
                                    }

                                    .disabled .avatar-title {
                                        color: #fff !important;
                                        background: #969595;
                                    }

                                    .disabled .text-muted a {
                                        color: #fff !important;
                                    }
                                </style>
                                <br>
                                <h4 class="card-title"
                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("update_classes_identify_grade_levels") ?></h4>
                                <br>
                                <div class="row">
                                    <?php foreach ($classesList as $list) { ?>
                                        <div data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="<?= $list['UsingCounter'] > 0 ? __("cannot_control_class_students") : "" ?>"
                                             class="<?= $list['UsingCounter'] > 0 ? "disabled checked" : "" ?> col-xl-3 col-sm-6 classChoice <?= $list['isExist'] > 0 ? "checked" : "" ?>"
                                             data-class-id="<?= $list['Id']; ?>">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="avatar-lg mx-auto mb-4">
                                                        <div class="avatar-title rounded-circle text-primary"><i
                                                                    class="uil uil-check display-4 m-0"></i></div>
                                                    </div>
                                                    <h5 class="font-size-16 mb-1 text-dark">
                                                        <?= $list['Class']; ?>
                                                    </h5>
                                                    <p class="text-muted mb-2">
                                                        <a href="<?= base_url('studentsInClass/' . $list['Id']); ?>">
                                                            <?= $list['UsingCounter'] > 0 ? __("students_in_this_class") . $list['UsingCounter'] : __("no_students_in_this_class") ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                    <h3 style="margin-top: 30px;color: #5b73e8;" id="generatedName"></h3>
                                </div>
                        </div>
                        <button class="btn btn-primary updateClasses" type="Submit"><?= __("update") ?></button>
                        <button type="button" class="btn btn-light" id="back"><?= __("cancel") ?></button>
                        </form>
                    </div>
                    <script>
                        var classekeys = [];
                        $('.classChoice.checked').each(function () {
                            classekeys.push($(this).attr('data-class-id'));
                        });

                        $('.classChoice:not(.disabled)').each(function () {
                            $(this).click(function () {
                                $(this).toggleClass('checked');
                                classekeys = [];
                                $('.classChoice.checked').each(function () {
                                    classekeys.push($(this).attr('data-class-id'));
                                });
                                console.log(classekeys);
                            });
                        });
                    </script>
                    <div class="col-md-12 formcontainer" id="Permitions"><br>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                            CH 015: Set Permissions | Grant Teachers and Staff School Permissions</h4>
                        <div class="row card">
                            <form class="needs-validation InputForm card-body" novalidate style="margin-bottom: 27px;"
                                  id="addpermition">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-group mb-2">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label for="">Select User</label>
                                                        <select class="form-control select2" name="selectedPerm">
                                                            <?php
                                                            $stafflist = $this->db->query("SELECT * FROM l2_staff
                                                                    WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND PermSchool = 0 ")->result_array();
                                                            ?>
                                                            <?php if (!empty($stafflist)) { ?>
                                                                <?php foreach ($stafflist as $staff) { ?>
                                                                    <option value="<?= $staff['Id'] . ';Staff' ?>">
                                                                        <?= $staff['F_name_EN'] . ' ' . $staff['L_name_EN']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                                </optgroup>
                                                            <?php } ?>
                                                            <?php
                                                            $Teacherlist = $this->db->query("SELECT * FROM l2_teacher 
                                                                    WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND PermSchool = 0 ")->result_array();
                                                            ?>
                                                            <?php if (!empty($Teacherlist)) { ?>
                                                                <optgroup label="Teachers">
                                                                    <?php foreach ($Teacherlist as $staff) { ?>
                                                                        <option
                                                                                value="<?= $staff['Id'] . ';Teacher' ?>">
                                                                            <?= $staff['F_name_EN'] . ' ' . $staff['L_name_EN']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </optgroup>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <?php
                                        $HasPermitionsStaff = $this->db->query("SELECT * FROM l2_staff
                                                WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND PermSchool = 1 ")->result_array();
                                        $HasPermitionsTeacher = $this->db->query("SELECT * FROM l2_teacher
                                                WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND PermSchool = 1 ")->result_array();
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label> Staff Permission: </label>
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($HasPermitionsStaff as $staffperm) { ?>
                                                        <tr>
                                                            <th scope="row"><?= $staffperm['Id'] ?></th>
                                                            <td><?= $staffperm['F_name_EN'] ?></td>
                                                            <td><?= $staffperm['L_name_EN'] ?></td>
                                                            <td><i class=" bx bxs-trash-alt delet"
                                                                   theId="<?= $staffperm['Id']; ?>"
                                                                   TypeOfuser="Stuff"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <label> Teacher Permission:</label>
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($HasPermitionsTeacher as $Teacherperm) { ?>
                                                        <tr id="PERM<?= $Teacherperm['Id']; ?>">
                                                            <th scope="row"><?= $Teacherperm['Id'] ?></th>
                                                            <td><?= $Teacherperm['F_name_EN'] ?></td>
                                                            <td><?= $Teacherperm['L_name_EN'] ?></td>
                                                            <td><i class=" bx bxs-trash-alt delet"
                                                                   theId="<?= $Teacherperm['Id']; ?>"
                                                                   TypeOfuser="Teacher"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="Submit">Submit form</button>
                                <button type="button" class="btn btn-light" id="back">Cancel</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 formcontainer" id="videos"><br>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                            CH 016: Videos </h4>
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                </div>
                                <form id="media_link" class="needs-validation custom-validation repeater" novalidate>
                                    <input type="hidden" name="language" value="">
                                    <div class="inner-repeater mb-4">
                                        <div data-repeater-list="media_link" class="inner form-group">
                                            <label class="form-label">Links:</label>
                                            <div data-repeater-item class="inner mb-3 row">
                                                <div class="col-md-10 col-8">
                                                    <select name="language" id="" class="form-control mb-1" required>
                                                        <option value="both" selected>Language: EN & AR</option>
                                                        <option value="EN">Language: EN</option>
                                                        <option value="AR">Language: AR</option>
                                                    </select>
                                                    <input type="text" name="link_title" autocomplete="off"
                                                           class="inner form-control" placeholder="Link title"/>
                                                    <input type="url" parsley-type="url" name="media_link" type="url"
                                                           autocomplete="off" required=""
                                                           class="mt-1 inner form-control linkinput"
                                                           placeholder="https://www.youtube.com/url"/>
                                                    <span class="error error-text"></span>
                                                </div>
                                                <div class="col-md-2 col-4 d-grid">
                                                    <button data-repeater-delete type="button"
                                                            class="btn btn-danger btn-block inner"><i
                                                                class="uil uil-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-success inner"
                                               value="Add another link "/>
                                        <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form
                                        </button>
                                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Video List:</h3>
                                <hr>
                                <div class="row">
                                    <?php foreach ($this->db->get_where('l3_videos', ['by_school' => $sessiondata['admin_id']])->result_array() as $video) { ?>
                                        <?php
                                        $linkparts = explode("?", trim($video['link']));
                                        if (sizeof($linkparts) == 2) {
                                            $videoid = str_replace("v=", "", $linkparts[1]);
                                        } else {
                                            $videoid = "notfound";
                                        }
                                        ?>
                                        <div class="col-md-6 col-xl-4">
                                            <div class="card"><i class="uil uil-trash delete"
                                                                 data-link-id="<?= $video['Id'] ?>"></i>
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           class="MediaStatus" <?= $video["status"] == "1" ? "checked" : "" ?>
                                                           data-file-id="<?= $video["Id"] ?>">
                                                    <span class="slider round"></span> </label>
                                                <img class="card-img-top img-fluid"
                                                     src="https://img.youtube.com/vi/<?= $videoid ?>/0.jpg">
                                                <div class="card-body">
                                                    <p data-link-id="11">
                                                        <?= $video['title'] ?>
                                                    </p>
                                                    <a href="<?= $video['link'] ?>" target="_blank"
                                                       class="btn btn-primary waves-effect waves-light w-100 mt-1">Open</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 formcontainer" id="Attendees_times"><br>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school_time") ?></h4>
                        <div class="alert alert-danger alert-dismissible fade" style="display: none;" role="alert">

                        </div>
                        <form id="Attendees_times_form" class="needs-validation custom-validation repeater" novalidate>
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><?= __("first") ?> </h3>
                                    <p><?= __("note_morning_timing") ?></p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for=""><?= __("from") ?> </label>
                                            <input type="time" placeholder="<?= __("from") ?> "
                                                   class="form-control dt-picker-1"
                                                   value="<?= $attendance_rule[0]["rule_a_in"] ?? "" ?>"
                                                   name="m_from" id="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><?= __("to") ?> </label>
                                            <input type="time" placeholder="<?= __("to") ?> "
                                                   class="form-control dt-picker-2"
                                                   value="<?= $attendance_rule[0]["rule_a_out"] ?? "" ?>"
                                                   name="m_to" id="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><?= __("second") ?></h3>
                                    <p><?= __("note_afternoon_timing") ?> </p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for=""><?= __("from") ?></label>
                                            <input type="time" placeholder="<?= __("from") ?>"
                                                   class="form-control dt-picker-3"
                                                   value="<?= $attendance_rule[0]["rule_b_in"] ?? "" ?>"
                                                   name="a_from" id="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><?= __("to") ?></label>
                                            <input type="time" placeholder="<?= __("to") ?>"
                                                   class="form-control dt-picker-4"
                                                   value="<?= $attendance_rule[0]["rule_b_out"] ?? "" ?>"
                                                   name="a_to" id="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><?= __("third") ?></h3>
                                    <p><?= __("note_night_timing") ?></p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for=""><?= __("from") ?></label>
                                            <input type="time" placeholder="<?= __("from") ?>"
                                                   class="form-control dt-picker-5"
                                                   value="<?= $attendance_rule[0]["rule_c_in"] ?? "" ?>"
                                                   name="n_from" id="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><?= __("to") ?></label>
                                            <input type="time" placeholder="<?= __("to") ?>"
                                                   class="form-control dt-picker-6"
                                                   value="<?= $attendance_rule[0]["rule_c_out"] ?? "" ?>"
                                                   name="n_to" id="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <label for=""><?= __("grace_period_in_minutes") ?></label>
                                    <input type="number" placeholder="<?= __("grace_period_in_minutes") ?>" min="0"
                                           value="<?= $attendance_rule[0]["grace_period"] ?? "15" ?>"
                                           class="form-control" name="graceperiod" id="">
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1"> <?= __("submit") ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end card -->
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
<script src="<?= base_url("assets/libs/jquery.repeater/jquery.repeater.min.js"); ?>"></script>
<script src="<?= base_url("assets/js/pages/form-repeater.int.js") ?>"></script>
<?php /*<script src=" echo base_url(); assets/js/pages/form-advanced.init.js"></script>*/ ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js">
</script>
<script>
    // for (let i = 1; i <= 6; i++) {
    //     $('.dt-picker-' + i).timepicker({
    //         format: 'hh:mm tt',
    //     });
    // }
    // videos tab
    $('#videos .alert').slideUp();
    getCitys(<?= $schoolData[0]['Country'] ?>, <?= $schoolData[0]['Citys'] ?>);
    // ajax sending
    $("#UpdateSchool").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/startUpdatingSchool',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);

            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    $('.card').on('click', '.delete', function () {
        var LinkId = $(this).attr('data-link-id');
        var $this = $(this);
        Swal.fire({
            title: '<?= __("are_you_sure") ?>',
            text: "<?= __("cannot_revert") ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= base_url(); ?>EN/schools/medialinks',
                    data: {
                        linkId: LinkId,
                    },
                    success: function (data) {
                        if (data.status == "ok") {
                            $($this).parents('.col-md-6.col-xl-4').slideUp();
                            setTimeout(() => {
                                $($this).remove();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: 'sorry !',
                                text: 'We have an error in processing this request',
                                icon: 'error'
                            });
                        }
                    },
                    ajaxError: function () {
                        $('#StatusBox').css('background-color', '#B40000');
                        $('#StatusBox').html("Ooops! Error was found.");
                    }
                });
            }
        });
    });

    $(".select2").select2();
    $(".select2-limiting").select2({
        maximumSelectionLength: 2
    });
    $(".select2-search-disable").select2({
        minimumResultsForSearch: Infinity
    }); //colorpicker start


    $("#addpermition").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/startAddPermition',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);

            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    $("#Addclasses").on('submit', function (e) {
        e.preventDefault();
        if (classekeys.length > 0) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/schools/AddClasses',
                data: {
                    classes: classekeys,
                },
                success: function (data) {
                    if (data == "ok") {
                        Swal.fire({
                            title: '<?= __("success") ?>',
                            text: '<?= __("classes_updated") ?>',
                            icon: 'success'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        Swal.fire({
                            title: '<?= __("sorry") ?>',
                            text: '<?= __("oops_error") ?>',
                            icon: 'error'
                        });
                    }
                },
                ajaxError: function () {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        } else {
            Swal.fire({
                title: '<?= __("are_you_sure") ?>',
                text: "<?= __("reset_classes_confirm") ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<?= __("yes") ?>',
                cancelButtonText: '<?= __("no_cancel") ?>',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/schools/AddClasses',
                        data: {
                            classes: classekeys,
                        },
                        success: function (data) {
                            if (data == "ok") {
                                Swal.fire({
                                    title: '<?= __("success") ?>',
                                    text: '<?= __("classes_updated") ?>',
                                    icon: 'success'
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else {
                                Swal.fire({
                                    title: '<?= __("error") ?>',
                                    text: '<?= __("classes_updated") ?>',
                                    icon: 'error'
                                });
                            }
                        },
                        ajaxError: function () {
                            $('.alert.alert-info').css('background-color', '#DB0404');
                            $('.alert.alert-info').html("<?= __("oops_error") ?>");
                        }
                    });
                }
            });
        }
    });

    $('#back').click(function () {
        location.href = "<?= base_url() . "EN/schools/Profile"; ?>";
    });

    // Cancel *

    $('#back').click(function () {
        location.href = "<?= base_url() . "EN/schools/Profile "; ?>";
    });

    function back() {
        location.href = "<?= base_url() . "EN/schools/Profile "; ?>";
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

        $('input[name="First_Name_EN"], input[name="Last_Name_EN"]').on("keyup keypress blur", function () {
            var firstname = $('input[name="First_Name_EN"]').val();
            var lastname = $('input[name="Last_Name_EN"]').val();
            var all = prex + " " + firstname + " " + lastname;
            $('#generatedName').html(all);
        });

    });

    $('.formcontainer').hide();
    $('#Profile').show();

    $('.control button').click(function () {
        $('.control button').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $('.formcontainer').hide();
        var to = $(this).attr('form_target');
        $('#' + to).show();
    });

    $('.delet').each(function () {
        $(this).click(function () {
            var theId = $(this).attr('theId');
            var TypeOfuser = $(this).attr('TypeOfuser');
            console.log(theId);


            Swal.fire({
                title: 'Do you want to remove this permission?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Yes, I am sure!`,
                icon: 'warning',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Schools/DeletPermition',
                        data: {
                            Conid: theId,
                            TypeOfuser: TypeOfuser,
                        },
                        success: function (data) {
                            Swal.fire(
                                'Success',
                                data,
                                'success'
                            );
                            $('#PERM' + theId).remove();
                        },
                        ajaxError: function () {
                            Swal.fire(
                                'error',
                                'oops!! we have a error',
                                'error'
                            )
                        }
                    });
                }
            })


        });
    });


    $('select[name="Country"]').change(function () {
        var countryId = $(this).val();
        getCitys(countryId);
        getdirectorate(countryId);
    });


    function getCitys(countryId, defaulcity = "") {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Ajax/getThisCountrycities' + (defaulcity !== "" ? ("/" + defaulcity) : ""),
            data: {
                id: countryId,
            },
            beforeSend: function () {
                $('.cities').html('Please Wait..');
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


    function ipLookUp() {
        $.ajax({
            url: "https://ipapi.co/<?= $ip; ?>/json/",
            //url: 'http://ip-api.com/json',
            dataType: 'json',
            beforeSend: function () {
                $('.setTheLocation').attr('disabled', 'disabled');
                $('.setTheLocation').html('<div style="color=#fff" class="spinner-border m-1" role="status"><span class="sr-only"><?= __("loading") ?>...</span></div>');
            },
            success: function (data) {
                let lat = data.latitude;
                let lon = data.longitude;
                let city = data.city;
                let country = data.country_name;
                insertdata(lat, lon, city, country);
                $('.setTheLocation').html('<i class="uil uil-check"></i> <?= __("turn_on_ad_blocker") ?>');
                console.log("Success:", data);
                setTimeout(function () {
                    $('.setTheLocation').fadeOut();
                }, 1000);
            },
            error: function (data) {
                Swal.fire({
                    title: `<?= __("turn_off_ad_blocker") ?>`,
                    showCancelButton: true,
                    cancelButton: 'cancel-button-class',
                    icon: 'warning',
                    confirmButtonText: `<?= __("ok_reload") ?>`,
                }).then(function (result) {
                    if (result.value) {
                        window.location.reload(true)
                    } else {
                        $('.setTheLocation').html('<?= __("please_turn_off_ad_blocker") ?>');
                    }
                });
            }
        });
    }

    $('.setTheLocation').click(function () {
        if (window.canRunAds === undefined) {
            // adblocker detected, show fallback
            Swal.fire({
                title: '<?= __("turn_off_ad_blocker_short") ?>',
                showCancelButton: true,
                cancelButton: 'cancel-button-class',
                icon: 'warning',
                confirmButtonText: `<?= __("ok_reload") ?>`,
            }).then(function (result) {
                if (result.value) {
                    window.location.reload(true)
                }
            });
        } else {
            ipLookUp();
        }
    });

    function insertdata(lat, lon, city, country) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/Schools/insrtLocation',
            data: {
                lat: lat,
                lon: lon,
                city: city,
                country: country,
            }
        });

    }


    function isUrlValid(url) {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

    $("#media_link").on('submit', function (e) {
        e.preventDefault();
        $('.inner .error').html(''); // reset errors messages
        var $this = $(this);
        var errors = 0;
        var data = new FormData(this);
        var oldLinks = [];
        $('.linkinput').each(function () {
            var val = $(this).val();
            if (!isUrlValid(val)) {
                errors++;
                $(this).parents('.inner').first().children().find(".error").html("Please enter valid url");
                // $(this).parents('.inner').first().children('.error').html();
                console.log("error");
            }
            if (oldLinks.includes(val)) {
                errors++;
                $('#add_media_link .alert').slideDown();
                $('#add_media_link .alert').html("Please don't enter duplicated values");
            } else {
                oldLinks.push(val)
            }
        });
        if (errors == 0) {
            $($this).children().find('button[type="Submit"]').attr('disabled', '');
            $($this).children().find('button[type="Submit"]').html('Please wait...');
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/schools/Upload_media_link',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $($this).children().find('button[type="Submit"]').removeAttr('disabled');
                    $($this).children().find('button[type="Submit"]').html('save');
                    console.log(data.status);
                    if (data.status == "ok") {
                        Swal.fire({
                            title: 'Added !',
                            text: 'The resource has been Added .',
                            icon: 'success'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        $('#add_media_link .alert').html(data.messages.error);
                        $('#add_media_link .alert').slideDown();
                    }
                },
                ajaxError: function () {
                    $('#StatusBox').css('background-color', '#B40000');
                    $('#StatusBox').html("Ooops! Error was found.");
                }
            });
        }
    });


    $('#Attendees_times_form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/schools/Attendees_times_manage") ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response == "ok") {
                    Swal.fire({
                        title: '<?= __("success") ?>',
                        text: '<?= __("data_saved_success") ?>',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    Swal.fire({
                        title: '<?= __("error") ?>',
                        html: response,
                        icon: 'error'
                    });
                    //$('#Attendees_times_form .alert').html(response);
                }
            }
        });
    });

    $("#videos").on("change", ".MediaStatus", function () {
        const LinkId = $(this).data("file-id");
        $.ajax({
            type: 'PUT',
            url: base_url + 'EN/schools/medialinks/' + LinkId,
            success: function (data) {
                if (data.trim() !== "ok") {
                    Swal.fire({
                        title: '<?= __("sorry") ?>',
                        text: '<?= __("request_processing_error") ?>',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function () {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    getdirectorate(<?= $schoolData[0]['Country'] ?>, <?= $schoolData[0]['Directorate_Id'] ?? 0 ?>, <?= $schoolData[0]['Directorate_Type_Id'] ?? 0 ?>)

    function getdirectorate(country, directorate = null, directorate_type = null) {
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Ajax/directorate") ?>",
            data: {
                country,
                directorate,
                directorate_type
            },
            success: function (response) {
                $("#directorate-response").html(response);
            }
        });
    }
</script>
</body>

</html>