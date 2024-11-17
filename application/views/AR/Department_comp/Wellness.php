<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
    <link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/libs/magnific-popup/magnific-popup.css"); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
    <?php
    $ClassesList = $this->db->query("SELECT * FROM `r_levels`")->result_array();
    $classes = $this->db->query("SELECT * FROM v_schoolgrades WHERE S_id = '" . $sessiondata['admin_id'] . "' LIMIT 1 ")->result_array();
    ?>
</head>
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
        background-color: #CB0002;
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
        background-color: #00bd06;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #00bd06;
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

    .floating_action_btn {
        position: fixed !important;
        bottom: 70px;
        right: 10px;
        border: 0px;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 100%;
        z-index: 1000;
        -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    }

    .odd {
        background: #ffeaf1 !important;
    }

    .arabic,
    .arabic * {
        font-family: 'Almarai', sans-serif;
    }

    .delete {
        font-size: 23px;
        color: #fd0000;
        cursor: pointer;
    }

    .delete_question {
        font-size: 23px;
        color: #fd0000;
        cursor: pointer;
        float: right;
        margin-bottom: 20px;
    }

    .questions {
        font-size: 23px;
        color: #3c40c6;
        cursor: pointer;
    }

    .use_ser {
        font-size: 23px;
        margin-left: 10px;
    }

    .hidden_inp {
        background-color: transparent;
        border: 0px;
        font-size: 16px;
        padding-top: 0px;
        margin-top: -5px;
    }

    .card {
        border: 0px;
    }

    .theme {
        height: 100px;
        text-align: center;
        align-items: center;
        display: grid;
        border-radius: 10px;
    }

    .theme p {
        color: #fff;
        margin: 0px;
    }

    .questions,
    .fillablequestions {
        font-size: 23px;
        color: #3c40c6;
        cursor: pointer;
    }

    .publish {
        font-size: 23px;
        color: #34c38f;
        cursor: pointer;
    }

    .select2-container {
        width: 100% !important;
    }

    .tabP {
        display: grid;
        align-content: center;
        align-items: center;
        height: 100%;
    }

    .nav-link {
        height: 100%;
        display: grid;
        align-items: center;
        border: 3px solid #ffffff !important;
        cursor: pointer;
        transition-duration: 0.5s;
    }

    .nav-link i {
        font-size: 45px;
    }

    .nav-link:hover {
        background-color: #fff;
        box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
        transform: scale(1.2);
        transition-duration: 0.5s;
    }

    .nav-link img {
        width: 60px;
        margin: auto;
    }

    .nav_1_b.nav-link::after {
        content: "";
        background: #2ecc71 !important;
    }

    .nav_1_b {
        color: #2ecc71 !important;
    }

    .nav_2_b {
        color: #3498db !important;
    }

    .nav_2_b.nav-link::after {
        content: "";
        background: #3498db !important;
    }

    .nav_3_b {
        color: #9b59b6 !important;
    }

    .nav_3_b.nav-link::after {
        content: "";
        background: #9b59b6 !important;
    }

    .nav_4_b {
        color: #e74c3c !important;
    }

    .nav_4_b.nav-link::after {
        content: "";
        background: #e74c3c !important;
    }

    .nav_5_b {
        color: #2c3e50 !important;
    }

    .nav_5_b.nav-link::after {
        content: "";
        background: #2c3e50 !important;
    }

    .nav_6_b {
        color: #f39c12 !important;
    }

    .nav_6_b.nav-link::after {
        content: "";
        background: #f39c12 !important;
    }

    .nav_7_b {
        color: #16a085 !important;
    }

    .nav_7_b.nav-link::after {
        content: "";
        background: #16a085 !important;
    }

    .nav_8_b {
        color: #d35400 !important;
    }

    .nav_8_b.nav-link::after {
        content: "";
        background: #d35400 !important;
    }

    .real_wellness {
        display: none;
    }

    .bordred_title {
        width: 100%;
        background-color: #16a085;
        padding: 10px;
        text-align: center;
        color: #fff;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .title_bl {
        background-color: #0077d6;
        color: #fff;
        padding: 2px;
        margin-top: 7px;
        margin: 8px -5px;
        border-radius: 7px;
        text-align: center;
    }

    .second-title {
        background-color: #16a085;
        color: #fff;
        padding: 4px;
        text-align: center;
        border-radius: 5px;
    }

    .rotate {
        transform: rotate(-90deg);
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }

    .page-content {
        min-height: 100vh;
        background-position: center;
        background-size: cover;
        background-origin: padding-box;
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-image: url(<?= base_url('assets/images/students_dash/students_dash_bk.png'); ?>);
    }
</style>
<style>
    .gonext {
        position: absolute;
        bottom: 26px;
        left: 16px;
        width: 227px;
        height: 100px;
        background: transparent;
        border: 0px;
    }

    .cardsoflinks .firstCard img {
        width: 100px;
        float: left;
        position: absolute;
        top: -11px;
        left: 7px;
    }

    .cardsoflinks .col-lg-3 {
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .card.border-ronded .card-body {
        border-radius: 5px;
    }

    .cardsoflinks .firstCard .text-white {
        text-align: right;
        margin-right: 10px;
        margin-bottom: 0px;
    }

    #our_surveys_list .avatar-title {
        width: 100px;
        height: 100px;
        margin: auto;
    }

    .hexagon {
        width: 100px;
        height: 57.735px;
        background: red;
        position: relative;
    }

    .hexagon::before {
        content: "";
        position: absolute;
        top: -28.8675px;
        left: 0;
        width: 0;
        height: 0;
        border-left: 50px solid transparent;
        border-right: 50px solid transparent;
        border-bottom: 28.8675px solid red;
    }

    .hexagon::after {
        content: "";
        position: absolute;
        bottom: -28.8675px;
        left: 0;
        width: 0;
        height: 0;
        border-left: 50px solid transparent;
        border-right: 50px solid transparent;
        border-top: 28.8675px solid red;
    }

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }

    .Fillable_publish {
        font-size: 25px;
        cursor: pointer;
        color: #2196f3;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div id="publish" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="publishLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="publishLabel"> Publish this survey </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                                <div class="card-body">
                                    <form id="publish_this_serv">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">This survey is for : </label>
                                                    <select class="select-survey-respondents select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="type[]">
                                                        <option value="1">Staff</option>
                                                        <option value="2">Students</option>
                                                        <option value="3">Teachers</option>
                                                        <option value="4">Parents</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">Gender : </label>
                                                    <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="gender[]">
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group select-levels">
                                                    <label for="">Level of Respondents: </label>
                                                    <span class="float-right text-primary btn s-all" data-target-select="levels[]" style="margin-top: -9px;">Select all</span>
                                                    <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="levels[]">
                                                        <?php $classes = $this->schoolHelper->school_classes($sessiondata['admin_id']); ?>
                                                        <?php foreach ($classes as $class) { ?>
                                                            <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-1">
                                                <label for="theme">Survey Theme:</label><span class="float-right badge badge-pill badge-primary btn noti-icon right-bar-toggle waves-effect">from here</span>
                                                <input type="text" value="not selected" class="form-control" id="theme_title" readonly>
                                                <input type="hidden" name="theme" id="theme" value="0">
                                            </div>
                                            <input type="hidden" name="serv_id">
                                            <div class="col-lg-12">
                                                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Publish Survey</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="Fillable_publish" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Fillable_publishLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="Fillable_publishLabel"> Publish this survey </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                                <div class="card-body">
                                    <form id="fillablesurveyForm">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">This survey is for : </label>
                                                    <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="Targetusers[]">
                                                        <optgroup label="Staff">
                                                            <?php foreach ($our_staff as $staff) { ?>
                                                                <option value="staff:<?= $staff['Id'] ?>"><?= $staff['F_name_EN'] . " " . $staff['L_name_EN'] ?> (staff)</option>
                                                            <?php } ?>
                                                        </optgroup>
                                                        <optgroup label="Teachers">
                                                            <?php foreach ($our_teachers as $teacher) { ?>
                                                                <option value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_EN'] . " " . $teacher['L_name_EN'] ?> (teacher)</option>
                                                            <?php } ?>
                                                        </optgroup>
                                                        <optgroup label="Students">
                                                            <?php foreach ($our_student as $student) { ?>
                                                                <option value="student:<?= $student['Id'] ?>"><?= $student['F_name_EN'] . " " . $student['L_name_EN'] ?> (student)</option>
                                                            <?php } ?>
                                                        </optgroup>
                                                        <optgroup label="Parents">
                                                            <?php foreach ($our_parents as $parent) { ?>
                                                                <option value="parent:<?= $parent['Id'] ?>"><?= $parent['name_en'] ?> (parent)</option>
                                                            <?php } ?>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-1">
                                                <label for="theme">select the theme please : </label><span class="float-right badge badge-pill badge-primary btn noti-icon right-bar-toggle waves-effect">from here</span>
                                                <input type="text" value="not selected" class="form-control" id="fillable_theme_title" readonly>
                                                <input type="hidden" name="theme" id="fillable_theme" value="0">
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="">Instructions:</label>
                                                <textarea class="form-control mb-2" placeholder="Instructions for the respondents/users" name="Message"></textarea>
                                            </div>
                                            <input type="hidden" name="serv_id">
                                            <div class="col-lg-12">
                                                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Publish</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH P008: Wellbeing Management</h4>
            <div class="row mb-3">
                <div class="col-lg-12 text">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active nav_1_b" tab_for="#home" role="tab">
                                <img src="<?= base_url('assets/images/icons/homewelness.png') ?>" alt="">
                                <span>HOME</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_2_b" tab_for="#wellness" role="tab">
                                <img src="<?= base_url('assets/images/icons/wellness.png') ?>" alt="">
                                <span>WELLNESS DASHBOARD</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_3_b" tab_for="#manage_surveys" role="tab">
                                <img src="<?= base_url('assets/images/icons/manage_survey.png') ?>" alt="">
                                <span class="d-none d-sm-block">MANAGE SURVEYS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_4_b" tab_for="#expired_surveys" role="tab">
                                <img src="<?= base_url('assets/images/icons/lib_surveys.png') ?>" alt="">
                                <span class="d-none d-sm-block">SURVEY LIBRARY</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_4_b" tab_for="#our_published_surveys" role="tab">
                                <img src="<?= base_url('assets/images/icons/exv.png') ?>" alt="">
                                <span class="d-none d-sm-block">PUBLISHED SURVEYS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_6_b" tab_for="#media" role="tab">
                                <img src="<?= base_url('assets/images/icons/media.png') ?>" alt="">
                                <span class="d-none d-sm-block">MEDIA GALLERY</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_7_b" tab_for="#well_edu" role="tab">
                                <img src="<?= base_url('assets/images/icons/well_edu.png') ?>" alt="">
                                <span class="d-none d-sm-block">WELLNESS EDUCATION RESOURCES </span>
                            </a>
                        </li>
                        <li class="nav-item nav_5_b">
                            <a class="nav-link" tab_for="#action_planes" role="tab">
                                <img src="<?= base_url('assets/images/icons/action_planes.png') ?>" alt="">
                                <span class="d-none d-sm-block">ACTION PLANS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_8_b" tab_for="#reports" role="tab">
                                <img src="<?= base_url('assets/images/icons/reports.png') ?>" alt="">
                                <span class="d-none d-sm-block">REPORTS</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt2 real_wellness" id="home">
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 035 School Wellbeing Home Page</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="row homeimages text-center">
                                <?php for ($i = 1; $i < 2; $i++) { ?>
                                    <div class="col-lg-12 mt-1 <?= $i == 1  ? "" : "hidden" ?>" id="Home_img_<?= $i ?>">
                                        <div class="img-fluid" class="center">
                                            <img src="<?= base_url('assets/images/homeimages/S' . $i . '.png');  ?>" alt="" style="width: 75%;">
                                            <button class="gonext" data-img-key="<?= $i ?>"></button>
                                        </div>
                                    </div>
                                <?php } ?>
                                <script>
                                    $('.nav_1_b').click(function() {});
                                    $('.gonext').click(function() {
                                        var current = parseInt($(this).attr('data-img-key'));
                                        $('.homeimages .col-lg-12').addClass('hidden');
                                        if ($('#Home_img_' + (current + 1)).length > 0) {
                                            $('#Home_img_' + (current + 1)).removeClass('hidden');
                                        } else {
                                            $('#Home_img_1').removeClass('hidden');
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt2 real_wellness" id="wellness">
                <?php $this->load->view('AR/schools/inc/wellness_tab') ?>
            </div>
            <div class="row mt2 real_wellness" id="manage_surveys">
                <div class="col-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 055 Manage Surveys-Questionnaires and Assessments</h4>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                                <table class="table dt-responsive nowrap" id="surv_manage">
                                    <thead>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Scale of Choices</th>
                                        <th>User Count</th>
                                        <th>No. of Questions</th>
                                        <th>No. of Choices</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($surveys as $key => $st_survey) { ?>
                                            <?php
                                            $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                            WHERE `group_id` = '" . $st_survey['group_id'] . "' ")->num_rows();
                                            $answers_count = $this->db->query("SELECT Id FROM `sv_st_questions`
                                            WHERE `survey_id` = '" . $st_survey['main_survey_id'] . "' ")->num_rows();
                                            ?>
                                            <tr id="serv_<?= $st_survey['survey_id'];  ?>">
                                                <td class="count"><?= $key + 1;  ?></td>
                                                <td><?= $st_survey['serv_code'];  ?></td>
                                                <td><?= $st_survey['Title_en'];  ?></td>
                                                <td><?= $st_survey['set_name_en'];  ?> </td>
                                                <td><?= $st_survey['From_date']; ?></td>
                                                <td><?= $st_survey['To_date']; ?></td>
                                                <td><?= $st_survey['choices_en_title'];  ?></td>
                                                <td><?= $st_survey['use_count']; ?></td>
                                                <td><?= $answers_count;  ?></td>
                                                <td><?= $choices_count  ?></td>
                                                <td class="text-center">
                                                    <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                                                        <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $st_survey['main_survey_id']; ?>"></i>
                                                    </span>
                                                    <span data-toggle="tooltip" data-placement="top" data-original-title="Publish this survey">
                                                        <i class="uil uil-eye-slash publish" data-toggle="modal" data-target="#publish" for_serv="<?= $st_survey['survey_id']; ?>"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php  }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 056 Manage Surveys-Interview Guide</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                                <table class="table dt-responsive nowrap">
                                    <thead>
                                        <th> # </th>
                                        <th> Code </th>
                                        <th> Category </th>
                                        <th> Title </th>
                                        <th> From </th>
                                        <th> To </th>
                                        <th> Action </th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fillable_surveys as $sn => $avalaible_fillable_survey) { ?>
                                            <tr>
                                                <td><?= $sn + 1 ?></td>
                                                <td><?= $avalaible_fillable_survey['serv_code'] ?></td>
                                                <td><?= $avalaible_fillable_survey['Title_en'] ?></td>
                                                <td><?= $avalaible_fillable_survey['set_name_en'] ?></td>
                                                <td><?= $avalaible_fillable_survey['From_date'] ?></td>
                                                <td><?= $avalaible_fillable_survey['To_date'] ?></td>
                                                <td class="text-center">
                                                    <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                                                        <i class="uil uil-notes questions" data-toggle="modal" data-survey-type="fillable" data-target="#myModal" group="<?= $avalaible_fillable_survey['main_survey_id']; ?>"></i>
                                                    </span>
                                                    <span data-toggle="tooltip" data-placement="top" data-original-title="Publish this survey">
                                                        <i class="uil uil-eye-slash Fillable_publish" data-toggle="modal" data-target="#Fillable_publish" for_serv="<?= $avalaible_fillable_survey['survey_id']; ?>"></i>
                                                    </span>
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
            <div class="row mt3 real_wellness" id="expired_surveys">
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 056 SURVEY LIBRARY​</h4>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                                        <table class="table dt-responsive nowrap" id="sur_lib">
                                            <thead>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Title</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Scale Range</th>
                                                <th>Completed</th>
                                                <th>No. of Questions</th>
                                                <th>No. of Choices</th>
                                                <th>Preview</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($expired_surveys as $key => $exp_survey) { ?>
                                                    <?php
                                                    $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                                    WHERE `group_id` = '" . $exp_survey['group_id'] . "' ")->num_rows();
                                                    $answers_count = $this->db->query("SELECT Id FROM `sv_st_questions`
                                                    WHERE `survey_id` = '" . $exp_survey['main_survey_id'] . "' ")->num_rows();
                                                    ?>
                                                    <tr id="serv_<?= $exp_survey['survey_id'];  ?>">
                                                        <td class="count"><?= $key + 1;  ?></td>
                                                        <td><?= $exp_survey['serv_code'];  ?></td>
                                                        <td><?= $exp_survey['Title_en'];  ?></td>
                                                        <td><?= $exp_survey['set_name_en'];  ?> </td>
                                                        <td><?= $exp_survey['From_date']; ?></td>
                                                        <td><?= $exp_survey['To_date']; ?></td>
                                                        <td> <?= $exp_survey['choices_en_title'];  ?></td>
                                                        <td>0</td>
                                                        <td><?= $answers_count;  ?></td>
                                                        <td><?= $choices_count  ?></td>
                                                        <td class="text-center">
                                                            <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                                                                <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $exp_survey['main_survey_id']; ?>"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php  }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt3 real_wellness" id="our_published_surveys">
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 057 PUBLISHED SURVEYS</h4>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                                        <table class="table dt-responsive nowrap unfillable_publishedSuveys table_pub">
                                            <thead>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Date Published</th>
                                                <th>Category</th>
                                                <th>Title</th>
                                                <th>User Target Type</th>
                                                <th>Completed</th>
                                                <th>No. of Questions</th>
                                                <th>No. of Choices</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($published_surveys_unfillable as $key => $published_survey) {  ?>
                                                    <?php
                                                    $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                                    WHERE `group_id` = '" . $published_survey['group_id'] . "' ")->num_rows();
                                                    $answers_count = $this->db->query("SELECT Id FROM `sv_st_questions`
                                                    WHERE `survey_id` = '" . $published_survey['main_survey_id'] . "' ")->num_rows();
                                                    $search = array("1", "2", "3", "4");
                                                    $replace = array("staff", "students", "teachers", "parents");
                                                    $Targeted_types = str_replace($search, $replace, array_column($this->db->query("SELECT Type_code FROM sv_school_published_surveys_types WHERE Survey_id = '" . $published_survey['survey_id'] . "' ")->result_array(), "Type_code"));
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td><?= $published_survey['serv_code'] ?></td>
                                                        <td><?= $published_survey['publish_date'] ?></td>
                                                        <td><?= $published_survey['Title_en'] ?></td>
                                                        <td><?= $published_survey['set_name_en'] ?></td>
                                                        <td><?= implode(', ', $Targeted_types) ?></td>
                                                        <td><?= $published_survey['completed'] ?></td>
                                                        <td class="text-center"><?= $answers_count ?>
                                                            <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions" class="ml-2">
                                                                <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $published_survey['main_survey_id']; ?>"></i>
                                                            </span>
                                                        </td>
                                                        <td><?= $choices_count ?></td>
                                                        <td>
                                                            <input type="checkbox" id="pub_sur_fi_<?= $key ?>" onchange="publishedsurveyStatusChanger(<?= $published_survey['survey_id'] ?>)" data-survey-key="<?= $published_survey['survey_id'] ?>" switch="success" <?= $published_survey['status'] == 1 ? "checked" : "" ?> />
                                                            <label for="pub_sur_fi_<?= $key ?>" data-on-label="on" data-off-label="off"></label>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                                        <table class="table dt-responsive nowrap fillable_publishedSuveys table_pub" id="">
                                            <thead>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Date Published</th>
                                                <th>Category</th>
                                                <th>Title</th>
                                                <th>User Target Type</th>
                                                <th>Completed</th>
                                                <th>No. of Questions</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($published_surveys_fillable as $i => $fillable_published_survey) {  ?>
                                                    <?php
                                                    $answers_count = $this->db->query("SELECT Id FROM `sv_st_fillable_questions`
                                                    WHERE `survey_id` = '" . $fillable_published_survey['main_survey_id'] . "' ")->num_rows();
                                                    ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?></td>
                                                        <td><?= $fillable_published_survey['serv_code'] ?></td>
                                                        <td><?= $fillable_published_survey['publish_date'] ?></td>
                                                        <td><?= $fillable_published_survey['Title_en'] ?></td>
                                                        <td><?= $fillable_published_survey['set_name_en'] ?></td>
                                                        <td class="text-center"><i class="uil uil-user showanswereuser btn font-size-20 text-primary" title="show targeted users " data-toggle="modal" data-target="#userspassedsurvey" data-survey-id="<?= $fillable_published_survey['survey_id'] ?>"></i></td>
                                                        <td><?= $fillable_published_survey['completed'] ?></td>
                                                        <td class="text-center"><?= $answers_count ?>
                                                            <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                                                                <i class="uil uil-notes questions" data-toggle="modal" data-survey-type="fillable" data-target="#myModal" group="<?= $fillable_published_survey['main_survey_id'] ?>"></i>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="pub_sur_unfi_<?= $i ?>" onchange="publishedsurveyStatusChanger(<?= $fillable_published_survey['survey_id'] ?>)" switch="success" <?= $published_survey['status'] == 1 ? "checked" : "" ?> />
                                                            <label for="pub_sur_unfi_<?= $i ?>" data-on-label="on" data-off-label="off"></label>
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
            <div class="modal fade zoom-in" id="userspassedsurvey" tabindex="-1" role="dialog" aria-labelledby="userspassedsurveyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userspassedsurveyModalLabel">List of targeted Users: </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="w-100 " data-simplebar style="height: 386px;">
                                <ol class="activity-feed mb-0 pl-2 all active returnuserslist">
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('body').on('click', '.showanswereuser', function() {
                    var survey_id = $(this).attr('data-survey-id');
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>AR/schools/published_surveys_control',
                        data: {
                            survey_id: survey_id,
                            request_for: "targetedusers"
                        },
                        beforeSend: function() {
                            $('.returnuserslist').html('Please wait......');
                        },
                        success: function(data) {
                            $('.returnuserslist').html('');
                            if (data.status == "ok") {
                                var users = data.users;
                                users.forEach(user => {
                                    var newhtml = '<li class="feed-item user_answered">';
                                    newhtml += '<p class="text-muted mb-1 font-size-13"> user name: ' + user.name + ' </p>';
                                    newhtml += '<p class="mt-0 mb-0">User type: ' + user.type + ' </p>';
                                    newhtml += '</li>';
                                    $('.returnuserslist').append(newhtml);
                                });
                            } else {
                                $('.returnuserslist').html('sorry , we have an errror');
                            }
                        },
                        ajaxError: function() {
                            $('#ResultsTableStudents').css('background-color', '#DB0404');
                            $('#ResultsTableStudents').html("Ooops! Error was found.");
                        }
                    });
                });
            </script>
            <div class="row mt3 real_wellness" id="action_planes">
                <style>
                    .catyegory {
                        background-color: #eb8642;
                        margin-bottom: 40px;
                    }

                    .catyegory .card-body {
                        padding-left: 110px;
                        color: #fff;
                    }

                    .download_res {
                        width: 90px;
                        height: 90px;
                        position: absolute;
                        text-align: center;
                        display: grid;
                        align-items: center;
                        background: #29bbe7;
                        border-radius: 100%;
                        top: -12px;
                        left: -12px;
                        font-size: 40px;
                        color: #fff;
                        border: 1px solid #676767;
                    }
                </style>
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 059 WELLNESS EDUCATION RESOURCES </h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($used_categorys as $category) { ?>
                                            <?php $media = $this->db->get_where('l1_category_resources', array('category_id' => $category['Id'], "file_language" => "EN", "file_type" => '1'))->result_array(); ?>
                                            <?php $havethumb = false; ?>
                                            <?php if (!empty($media)) { ?>
                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <?php foreach ($media as $key => $filertest) { ?>
                                                            <?php $file_info = explode('.', $filertest['file_url']);
                                                            $mime_type = $file_info[sizeof($file_info) - 1]; ?>
                                                            <?php if (in_array($mime_type, ['jpg', "jpeg", "png", 'gif'])) { ?>
                                                                <?php $havethumb = true; ?>
                                                                <?php if ($filertest['file_type'] == "1") { ?>
                                                                    <img class="card-img-top img-fluid" src="<?= base_url('uploads/Category_resources/' . $filertest['file_language'] . "/" . $filertest["file_url"]) ?>" alt="Card image cap">
                                                                <?php } else { ?>
                                                                    <img class="card-img-top img-fluid" src="<?= base_url('uploads/Reports_resources/' . $filertest['file_language'] . "/" . $filertest["file_url"]) ?>" alt="Card image cap">
                                                                <?php } ?>
                                                                <?php unset($media[$key]); ?>
                                                            <?php break;
                                                            } ?>
                                                        <?php } ?>
                                                        <?php if (!$havethumb) { ?>
                                                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/Placeholder-Icon-File.png") ?>" alt="Card image cap">
                                                        <?php } ?>
                                                        <div class="card-body">
                                                            <h4 class="card-title mt-0 text-center">
                                                                <?= $category['media_name_en'] == "" ? "No title" : $category['media_name_en']; ?></h4>
                                                            <hr>
                                                            <div class="linkslist">
                                                                <?php foreach ($media as $link) { ?>
                                                                    <?php if ($link['file_type'] == "1") { ?>
                                                                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_en']) > 30 ? $link['file_name_en'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_en']) > 30 ? substr($link['file_name_en'], 0, 30) . "....." : $link['file_name_en']; ?></a>
                                                                    <?php } else { ?>
                                                                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_en']) > 30 ? $link['file_name_en'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_en']) > 30 ? substr($link['file_name_en'], 0, 30) . "....." : $link['file_name_en']; ?></a>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt3 real_wellness" id="media">
                <style>
                    .catyegory {
                        background-color: #eb8642;
                        margin-bottom: 40px;
                    }

                    .catyegory .card-body {
                        padding-left: 110px;
                        color: #fff;
                    }

                    .download_res {
                        width: 90px;
                        height: 90px;
                        position: absolute;
                        text-align: center;
                        display: grid;
                        align-items: center;
                        background: #29bbe7;
                        border-radius: 100%;
                        top: -12px;
                        left: -12px;
                        font-size: 40px;
                        color: #fff;
                        border: 1px solid #676767;
                    }

                    .mfp-bg {
                        position: fixed !important;
                    }
                </style>
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 059 WELLNESS EDUCATION RESOURCES </h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($used_categorys as $category) { ?>
                                            <?php $links = $this->db->get_where('sv_st_category_media_links', array('category_id' => $category['Id'], "langauge" => "EN"))->result_array(); ?>
                                            <?php if (!empty($links)) { ?>
                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="avatar-lg mx-auto mb-4">
                                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary" style="font-size: 50px;">
                                                                <?= sizeof($links); ?>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <h4 class="card-title mt-0 text-center">
                                                                <?= $category['media_name_en'] == "" ? "No title" : $category['media_name_en']; ?></h4>
                                                            <hr>
                                                            <div class="linkslist">
                                                                <?php foreach ($links as $link) { ?>
                                                                    <?php
                                                                    $linkparts = explode("?", trim($link['link']));
                                                                    if (sizeof($linkparts) == 2) {
                                                                        $videoid = str_replace("v=", "", $linkparts[1]);
                                                                        $thumburl = "https://img.youtube.com/vi/" . $videoid . "/0.jpg";
                                                                    } else {
                                                                        $thumburl = "https://img.youtube.com/vi/";
                                                                    }
                                                                    ?>
                                                                    <img src="<?= $thumburl ?>" alt="" class="w-100">
                                                                    <a href="<?= $link['link'] ?>" target="_blank" title="<?= strlen($link['title']) > 30 ? $link['title'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['title']) > 30 ? substr($link['title'], 0, 30) . "....." : $link['title']; ?></a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt3 real_wellness" id="well_edu">
                <?php $this->load->view('AR/schools/inc/WELLNESS_EDUCATION_RESOURCES'); ?>
            </div>
            <div class="row mt3 real_wellness" id="reports">
                <style>
                    .catyegory {
                        background-color: #eb8642;
                        margin-bottom: 40px;
                    }

                    .catyegory .card-body {
                        padding-left: 110px;
                        color: #fff;
                    }

                    .download_res {
                        width: 90px;
                        height: 90px;
                        position: absolute;
                        text-align: center;
                        display: grid;
                        align-items: center;
                        background: #29bbe7;
                        border-radius: 100%;
                        top: -12px;
                        left: -12px;
                        font-size: 40px;
                        color: #fff;
                        border: 1px solid #676767;
                    }
                </style>
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 059 WELLNESS EDUCATION RESOURCES </h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($used_categorys as $category) { ?>
                                            <?php $media = $this->db->get_where('l1_category_resources', array('category_id' => $category['Id'], "file_language" => "EN", "file_type" => "2"))->result_array(); ?>
                                            <?php $havethumb = false; ?>
                                            <?php if (!empty($media)) { ?>
                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <?php foreach ($media as $key => $filertest) { ?>
                                                            <?php $file_info = explode('.', $filertest['file_url']);
                                                            $mime_type = $file_info[sizeof($file_info) - 1]; ?>
                                                            <?php if (in_array($mime_type, ['jpg', "jpeg", "png", 'gif'])) { ?>
                                                                <?php $havethumb = true; ?>
                                                                <?php if ($filertest['file_type'] == "1") { ?>
                                                                    <img class="card-img-top img-fluid" src="<?= base_url('uploads/Category_resources/' . $filertest['file_language'] . "/" . $filertest["file_url"]) ?>" alt="Card image cap">
                                                                <?php } else { ?>
                                                                    <img class="card-img-top img-fluid" src="<?= base_url('uploads/Reports_resources/' . $filertest['file_language'] . "/" . $filertest["file_url"]) ?>" alt="Card image cap">
                                                                <?php } ?>
                                                                <?php unset($media[$key]); // removing the file from array 
                                                                ?>
                                                            <?php break;
                                                            } ?>
                                                        <?php } ?>
                                                        <?php if (!$havethumb) { ?>
                                                            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/Placeholder-Icon-File.png") ?>" alt="Card image cap">
                                                        <?php } ?>
                                                        <div class="card-body">
                                                            <h4 class="card-title mt-0 text-center">
                                                                <?= $category['media_name_en'] == "" ? "No title" : $category['media_name_en']; ?></h4>
                                                            <hr>
                                                            <div class="linkslist">
                                                                <?php foreach ($media as $link) { ?>
                                                                    <?php if ($link['file_type'] == "1") { ?>
                                                                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_en']) > 30 ? $link['file_name_en'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_en']) > 30 ? substr($link['file_name_en'], 0, 30) . "....." : $link['file_name_en']; ?></a>
                                                                    <?php } else { ?>
                                                                        <a href="<?= base_url('uploads/Reports_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_en']) > 30 ? $link['file_name_en'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_en']) > 30 ? substr($link['file_name_en'], 0, 30) . "....." : $link['file_name_en']; ?></a>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel"> Questions in the Survey </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="showquestions text-center mb-5" style="display: none;">
                                    Loading...
                                </div>
                                <div class="question_list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Themes</h5>
            </div>
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Select Theme</h6>
            <?php foreach ($themes as $theme) { ?>
                <div class="p-4 btn w-100 waves-effect waves-light" onclick="setTheme(<?= $theme['Id'] ?>,'<?= $theme['title_an']; ?>')">
                    <div class="mb-2">
                        <div class="theme" style="background-color: <?= $theme['preview_color']; ?>;">
                            <p><?= $theme['title_an']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div> <!-- end slimscroll-menu-->
    </div>
</body>
<script src="<?= base_url("assets/libs/magnific-popup/jquery.magnific-popup.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-editable/js/index.js"); ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/parsleyjs/parsley.min.js"); ?>"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/js/pages/toastr.init.js") ?>"></script>
<script src="<?= base_url("assets/js/pages/lightbox.init.js") ?>"></script>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
<script>
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 300,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('.select-levels').slideUp();
    $('.s-all').click(function() {
        var target = $(this).attr('data-target-select');
        $('select[name="' + target + '"] option').attr('selected', '');
        var selectedItems = [];
        var allOptions = $('select[name="' + target + '"]');
        allOptions.each(function() {
            selectedItems.push($(this).val());
        });
        $('select[name="' + target + '"]').select2("val", selectedItems);
    });
    $('.select-survey-respondents').change(function() {
        var results = $(this).val();
        var BreakException = {};
        var isinit = false;
        if (results.includes("2") || results.includes("3")) {
            $('.select-levels').slideDown();
        } else {
            $('.select-levels').slideUp();
        }
    });

    function setTheme(id, title) {
        if ($('#Fillable_publish').hasClass('show')) {
            $("#fillable_theme").val(id);
            $("#fillable_theme_title").val(title);
        } else {
            $("#theme").val(id);
            $("#theme_title").val(title);
        }
    }
    try {
        $('#home').slideDown();
    } catch (error) {
        console.log('------');
    }
    $('.nav-tabs .nav-link').each(function() {
        $(this).click(function() {
            var tab_name = $(this).attr('tab_for');
            $(".nav-tabs .nav-link").removeClass('active');
            $(this).addClass('active');
            if (!$(tab_name).hasClass('actived_tab_now')) {
                $('.real_wellness').slideUp();
                $('.real_wellness').removeClass("actived_tab_now");
                $(tab_name).slideDown();
                $(tab_name).addClass("actived_tab_now");
            }
        });
    });
    var btns = $('.table_pub').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#DataTables_Table_1_wrapper  .col-md-6:eq(0), #DataTables_Table_0_wrapper .col-md-6:eq(0)');
    var btns = $('#surv_manage').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#surv_manage_wrapper  .col-md-6:eq(0)');
    var btns = $('#fillable_surv_manage').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#fillable_surv_manage_wrapper  .col-md-6:eq(0)');
    var btns = $('#sur_lib').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#sur_lib_wrapper  .col-md-6:eq(0)');
    $('.select2').select2({
        closeOnSelect: false
    });
    $("body").on('click', ".questions", function(e) {
        var groupid = $(this).attr('group');
        $('.question_list').html("");
        $('.showquestions').fadeIn();
        if ($(this).attr('data-survey-type') == "fillable") {
            getquestions(groupid, 'fillable');
        } else {
            getquestions(groupid);
        }
    });

    function getquestions(roupid, typeOfSUrvey = "notFillable") {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/get_questions_of_avalaible_surveys',
            data: {
                surveyType: typeOfSUrvey,
                requestFor: 'All_questions',
                group_id: roupid,
            },
            success: function(data) {
                if (data.length > 0) {
                    $('.showquestions').fadeOut();
                    setTimeout(function() {
                        $('.question_list').html(data);
                    }, 800);
                }
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
    $("body").on('click', ".publish", function(e) {
        const serv_id = $(this).attr('for_serv');
        $('#publish_this_serv input[name="serv_id"]').val(serv_id);
    });
    $("body").on('click', ".Fillable_publish", function(e) {
        const serv_id = $(this).attr('for_serv');
        $('#fillablesurveyForm input[name="serv_id"]').val(serv_id);
    });
    $("#publish_this_serv").on('submit', function(e) {
        e.preventDefault();
        $('#publish_this_serv button[type="Submit"]').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/publish_serv',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                // loading
                $('#publish_this_serv button[type="Submit"]').attr('disabled', 'disabled');
                $('#publish_this_serv button[type="Submit"]').html('Please wait ..');
            },
            success: function(data) {
                if (data.status == "ok") {
                    $('#publish_this_serv button[type="Submit"]').attr('disabled', 'disabled');
                    $('#publish_this_serv button[type="Submit"]').html('Refreshing...');
                    Command: toastr["success"]("The survey has been created successfully.");
                    setTimeout(() => {
                        $('#publish').modal('hide');
                        location.reload();
                    }, 800);
                } else {
                    $('#publish_this_serv button[type="Submit"]').removeAttr('disabled');
                    $('#publish_this_serv button[type="Submit"]').html('Publish');
                    Swal.fire(
                        'error',
                        data.message,
                        'error'
                    );
                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error , Please Try again later',
                    'error'
                );
            }
        });
    });

    function publishedsurveyStatusChanger(surveyId) {
        $.ajax({
            type: "POST",
            url: "<?= base_url("AR/schools/published_surveys_control"); ?>",
            data: {
                survey_id: surveyId,
                request_for: "status"
            },
            success: function(data) {
                if (data == "ok") {
                    Command: toastr["success"]("The survey status is updated.");
                }
                else {
                    Command: toastr["error"](" we have error in this request , please try again later ");
                }
            },
        });
    }
    $("#fillablesurveyForm").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/publish_fillable_serv',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                // loading
                $('#fillablesurveyForm button[type="Submit"]').attr('disabled', 'disabled');
                $('#fillablesurveyForm button[type="Submit"]').html('Please wait ..');
            },
            success: function(data) {
                $('#fillablesurveyForm button[type="Submit"]').removeAttr('disabled');
                $('#fillablesurveyForm button[type="Submit"]').html('Publish');
                if (data == "ok") {
                    $('#Fillable_publish').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'oops!! we have a error , Please check the inputs',
                        'error'
                    );
                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error , Please Try again later',
                    'error'
                );
            }
        });
    });
    $('.questions').each(function() {
        $(this).click(function() {
            var groupid = $(this).attr('group');
            $('.question_list').html("");
            $('.showquestions').fadeIn();
            getquestions(groupid);
        });
    });

    function update_status(Id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/DashboardSystem/change_serv_status',
            data: {
                serv_id: Id,
                type: 'change'
            },
            success: function(data) {
                if (data === "ok") {
                    Command: toastr["success"]("The survey status was updated. " + status);
                }
                else {
                    Swal.fire(
                        'error',
                        'Oops! We have an unexpected error.',
                        'error'
                    );
                }
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
    $('#our_surveys_list').owlCarousel({
        items: 1,
        loop: false,
        margin: 0,
        nav: true,
        navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
        dots: false,
        responsive: {
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            1200: {
                items: 4
            },
        }
    });
</script>

</html>