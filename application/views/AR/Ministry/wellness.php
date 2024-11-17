<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/libs/magnific-popup/magnific-popup.css"); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/libs/toastr/build/toastr.min.css") ?>">
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
                            <h5 class="modal-title mt-0" id="publishLabel"> نشر الإستبيان </h5>
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
                                                    <label for="">هذا الإستبيان ل:</label>
                                                    <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="type[]">
                                                        <option value="1">الموظفين</option>
                                                        <option value="2">الطلاب</option>
                                                        <option value="3">المعلمين</option>
                                                        <option value="4">أولياء الأمور</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">الجنس:</label>
                                                    <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="gender[]">
                                                        <option value="1">ذكور</option>
                                                        <option value="2">إناث</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">المراحل الدراسية:</label>
                                                    <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="levels[]">
                                                        <?php $classes = $this->schoolHelper->school_classes($sessiondata['admin_id']); ?>
                                                        <?php foreach ($classes as $class) { ?>
                                                            <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-1">
                                                <label for="theme">اختر القالب المناسب:</label><span class="float-right badge badge-pill badge-primary btn noti-icon right-bar-toggle waves-effect">هنا</span>
                                                <input type="text" value="not selected" class="form-control" id="theme_title" readonly>
                                                <input type="hidden" name="theme" id="theme" value="0">
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="">التعليمات:</label>
                                                <textarea class="form-control mb-2" placeholder="Instructions for the respondents/users" name="Message"></textarea>
                                            </div>
                                            <input type="hidden" name="serv_id">
                                            <div class="col-lg-12">
                                                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">أنشر</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/MAINWELNEWSS.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div>


            <br>
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 034 إدارة الإستبيانات</h4>
            <div class="row mb-3">

                <div class="col-lg-12 text">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active nav_1_b" tab_for="#home" role="tab">
                                <img src="<?php echo base_url('assets/images/icons/homewelness.png') ?>" alt="">
                                <span>الرئيسية</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_2_b" tab_for="#wellness" role="tab">
                                <img src="<?php echo base_url('assets/images/icons/wellness.png') ?>" alt="">
                                <span>إحصائيات الإستبيانات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_3_b" tab_for="#manage_surveys" role="tab">
                                <img src="<?php echo base_url('assets/images/icons/manage_survey.png') ?>" alt="">
                                <span class="d-none d-sm-block">الإستبيانات المنشورة</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_4_b" tab_for="#expired_surveys" role="tab">
                                <img src="<?php echo base_url('assets/images/icons/lib_surveys.png') ?>" alt="">
                                <span class="d-none d-sm-block">مكتبة الإستبيانات</span>
                            </a>
                        </li>

<!--                        <li class="nav-item">-->
                        <!--                            <a class="nav-link nav_6_b" tab_for="#media" role="tab">-->
                        <!--                                <img src="-->
                        <?php //echo base_url('assets/images/icons/media.png') ?><!--" alt="">-->
                        <!--                                <span class="d-none d-sm-block">معرض الوسائط</span>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                        <!--                        <li class="nav-item">-->
                        <!--                            <a class="nav-link nav_7_b" tab_for="#well_edu" role="tab">-->
                        <!--                                <img src="-->
                        <?php //echo base_url('assets/images/icons/well_edu.png') ?><!--" alt="">-->
                        <!--                                <span class="d-none d-sm-block">موارد التعليم </span>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                        <!--                        <li class="nav-item nav_5_b">-->
                        <!--                            <a class="nav-link" tab_for="#action_planes" role="tab">-->
                        <!--                                <img src="-->
                        <?php //echo base_url('assets/images/icons/action_planes.png') ?><!--" alt="">-->
                        <!--                                <span class="d-none d-sm-block">خطط العمل</span>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                        <!--                        <li class="nav-item">-->
                        <!--                            <a class="nav-link nav_8_b" tab_for="#reports" role="tab">-->
                        <!--                                <img src="-->
                        <?php //echo base_url('assets/images/icons/reports.png') ?><!--" alt="">-->
                        <!--                                <span class="d-none d-sm-block">التقارير</span>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                    </ul>
                </div>
            </div>
            <div class="row mt2 real_wellness" id="home">
                <div class="col-lg-12">
                    <br>
                    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 035 الصفحة الرئيسية لإدارة نظام الإستبيانات المدرسي</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="row homeimages">
                                <?php for ($i = 1; $i < 2; $i++) { ?>
                                    <div class="col-lg-12 mt-1 <?= $i == 1  ? "" : "hidden" ?>" id="Home_img_<?= $i ?>">
                                        <div class="img-fluid text-center">
                                            <img src="<?php echo base_url('assets/images/homeimages/S' . $i . '.png'); ?>" alt="" style="width: 75%;">
                                            <button class="gonext" data-img-key="<?= $i ?>"></button>
                                        </div>
                                    </div>
                                <?php } ?>
                                <script>
                                    $('.nav_1_b').click(function() {

                                    });
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
                <?php $this->load->view('AR/Ministry/inc/wellness_tab') ?>
            </div>


            <div class="row mt2 real_wellness" id="manage_surveys">
                <div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/CH1.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-12">
                    <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 055 إدارة الإستبيانات - الإجابات</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                    <th> # </th>
                                    <th> رمز الإستبيان </th>
                                    <th> عنوان المجموعة </th>
                                    <th> عنوان الإستبيان </th>
                                    <th> التاريخ والوقت </th>
                                    <th> من </th>
                                    <th> إلى </th>
                                    <th> نموذج الإجابات </th>
                                    <th> المكتملة </th>
                                    <th> الأسئلة </th>
                                    <th> الإجابات </th>
                                    <th> حالة الإستبيان</th>
                                    <th> الإجراء </th>
                                </thead>
                                <tbody>
                                    <?php foreach ($surveys as $key => $survey) { ?>
                                        <?php
                                        $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                        WHERE `group_id` = '" . $survey['group_id'] . "' ")->num_rows();
                                        $answers_count = $this->db->query("SELECT Id FROM `sv_st_questions`
                                        WHERE `survey_id` = '" . $survey['main_survey_id'] . "' ")->num_rows();
                                        ?>
                                        <tr id="serv_<?= $survey['survey_id'];  ?>">
                                            <td class="count"><?= $key + 1;  ?></td>
                                            <td><?= $survey['serv_code'];  ?></td>
                                            <td><?= $survey['Title_ar'];  ?></td>
                                            <td><?= $survey['set_name_ar'];  ?> </td>
                                            <td><?= $survey['creating_date'] ?></td>
                                            <td><?= $survey['From_date']; ?></td>
                                            <td>
                                                <input for_serv="<?= $survey['survey_id'];  ?>" style="width: 122px;" type="text" class="form-control hidden_inp end_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $survey['To_date']; ?>">
                                            </td>
                                            <td> <?= $survey['choices_ar_title'];  ?></td>
                                            <td>0</td>
                                            <td><?= $answers_count;  ?></td>
                                            <td><?= $choices_count  ?></td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="ischecked" serv_Id="<?= $survey['survey_id'];  ?>" <?= $survey['status'] == 1 ? 'checked' : "";  ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <span data-toggle="tooltip" data-placement="top" data-original-title="عرض أسئلة الإستبيان">
                                                    <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $survey['main_survey_id']; ?>"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php  }  ?>
                                </tbody>
                            </table>
                        </div>
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



                        <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 056 إدارة الإستبيانات - السؤال المفتوح</h4>
                        <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                    <th> # </th>
                                    <th> رمز الاستبيان </th>
                                    <th> عنوان المجموعة </th>
                                    <th> عنوان الإستبيان </th>
                                    <th> التاريخ والوقت </th>
                                    <th> من </th>
                                    <th> إلى </th>
                                    <th> الحالة </th>
                                    <th> الإجراء </th>
                                </thead>
                                <tbody>
                                    <?php foreach ($fillable_surveys as $sn => $avalaible_fillable_survey) { ?>
                                        <tr>
                                            <td><?= $sn + 1 ?></td>
                                            <td><?= $avalaible_fillable_survey['serv_code'] ?></td>
                                            <td><?= $avalaible_fillable_survey['Title_ar'] ?></td>
                                            <td><?= $avalaible_fillable_survey['set_name_ar'] ?></td>
                                            <td><?= $avalaible_fillable_survey['creating_date'] ?></td>
                                            <td><?= $avalaible_fillable_survey['From_date'] ?></td>
                                            <td><input for_serv="<?= $avalaible_fillable_survey['survey_id'];  ?>" style="width: 122px;" type="text" class="form-control hidden_inp end_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-survey-type="fillable" value="<?= $avalaible_fillable_survey['To_date']; ?>">
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="ischecked" data-survey-type="fillable" serv_Id="<?= $avalaible_fillable_survey['survey_id'];  ?>" <?= $avalaible_fillable_survey['status'] == 1 ? 'checked' : "";  ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <span data-toggle="tooltip" data-placement="top" data-original-title="عرض أسئلة الإستبيان">
                                                    <i class="uil uil-notes questions" data-toggle="modal" data-survey-type="fillable" data-target="#myModal" group="<?= $avalaible_fillable_survey['main_survey_id']; ?>"></i>
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



            <div class="row mt3 real_wellness" id="expired_surveys">
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
                <div class="col-lg-12">
                    <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 057 مكتبة الإستبيانات</h4>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                                        <table class="table dt-responsive nowrap av_fillable_surveys_list">
                                            <thead>
                                                <th>#</th>
                                                <th>رمز الاستبيان</th>
                                                <th>عنوان المجموعة</th>
                                                <th>عنوان الاستبيان</th>
                                                <th>نموذج الإجابات</th>
                                                <th>المكتملة</th>
                                                <th>مجموع الأسئلة</th>
                                                <th>الخيارات</th>
                                                <th>الإجراء</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($avalaible_surveys as $key => $survey) {
                                                    $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                                    WHERE `group_id` = '" . $survey['group_id'] . "' ")->num_rows(); ?>
                                                    <tr id="serv_<?= $survey['survey_id'];  ?>">
                                                        <td class="count"><?= $key + 1;  ?></td>
                                                        <td><?= $survey['serv_code'];  ?></td>
                                                        <td><?= $survey['Title_ar'];  ?></td>
                                                        <td><?= $survey['set_name_ar'];  ?></td>
                                                        <td><?= $survey['choices_ar_title'];  ?></td>
                                                        <td>0</td>
                                                        <td><?= $survey['questions_count'];  ?></td>
                                                        <td><?= $choices_count  ?></td>
                                                        <td class="text-center">
                                                            <span data-toggle="tooltip" data-placement="top" data-original-title="عرض أسئلة الإستبيان">
                                                                <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $survey['survey_id']; ?>"></i>
                                                            </span>
                                                            <a href="<?= base_url() ?>AR/DashboardSystem/use_this_survey/<?= $survey['survey_id']; ?>" class="use_ser" data-toggle="tooltip" data-placement="top" data-original-title="استخدم هذا الاستبيان">
                                                                <i class="uil uil-channel"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php  }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
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
                                    <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 058 السؤال المفتوح</h4>
                                    <div class="table-responsive mb-0 av_fillable_surveys_list" data-pattern="priority-columns">
                                        <table class="table dt-responsive nowrap">
                                            <thead>
                                                <th>#</th>
                                                <th>رمز الإستبيان</th>
                                                <th>عنوان الإستبيان</th>
                                                <th>المكتملة</th>
                                                <th>مجموع الأسئلة</th>
                                                <th>الإجراء</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($avalaible_fillable_surveys as $key => $survey) { ?>
                                                    <tr id="serv_<?= $survey['survey_id'];  ?>">
                                                        <td class="count"><?= $key + 1;  ?></td>
                                                        <td><?= $survey['serv_code'];  ?></td>
                                                        <td><?= $survey['set_name_ar'];  ?><br><?= $survey['set_name_ar']  ?></td>
                                                        <td> 0 </td>
                                                        <td> <?= $survey['questions_count'] ?> </td>
                                                        <td class="text-center">
                                                            <span data-toggle="tooltip" data-placement="top" data-original-title="عرض أسئلة الإستبيان">
                                                                <i class="uil uil-notes fillablequestions" data-toggle="modal" data-target="#myModal" group="<?= $survey['survey_id']; ?>"></i>
                                                            </span>
                                                            <a href="<?= base_url() ?>AR/DashboardSystem/use_this_survey/<?= $survey['survey_id']; ?>/fillable" class="use_ser" data-toggle="tooltip" data-placement="top" data-original-title="استخدم هذا الاستبيان">
                                                                <i class="uil uil-channel"></i>
                                                            </a>
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
                    <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CH 061 خطط العمل </h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($used_categorys as $category) { ?>
                                    <?php $media = $this->db->get_where('l1_category_resources', array('category_id' => $category['Id'], "file_language" => "AR", "file_type" => "1"))->result_array(); ?>
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
                                                        <?= $category['media_name_ar'] == "" ? "بدون عنوان" : $category['media_name_ar']; ?></h4>
                                                    <hr>
                                                    <div class="linkslist">
                                                        <?php foreach ($media as $link) { ?>
                                                            <?php if ($link['file_type'] == "1") { ?>
                                                                <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_ar']) > 30 ? $link['file_name_ar'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_ar']) > 30 ? substr($link['file_name_ar'], 0, 30) . "....." : $link['file_name_ar']; ?></a>
                                                            <?php } else { ?>
                                                                <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_ar']) > 30 ? $link['file_name_ar'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_ar']) > 30 ? substr($link['file_name_ar'], 0, 30) . "....." : $link['file_name_ar']; ?></a>
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
                    <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 059 معرض الوسائط</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($used_categorys as $category) { ?>
                                            <?php $links = $this->db->get_where('sv_st_category_media_links', array('category_id' => $category['Id'], "langauge" => "AR"))->result_array(); ?>
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
                                                                <?= $category['media_name_ar'] == "" ? "بدون عنوان" : $category['media_name_ar']; ?></h4>
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
                <?php $this->load->view('AR/Ministry/inc/WELLNESS_EDUCATION_RESOURCES'); ?>
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
                    <br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CH 062 التقارير </h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($used_categorys as $category) { ?>
                                            <?php $media = $this->db->get_where('l1_category_resources', array('category_id' => $category['Id'], "file_language" => "AR", "file_type" => "2"))->result_array(); ?>
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
                                                                <?= $category['media_name_ar'] == "" ? "بدون عنوان" : $category['media_name_ar']; ?></h4>
                                                            <hr>
                                                            <div class="linkslist">
                                                                <?php foreach ($media as $link) { ?>
                                                                    <?php if ($link['file_type'] == "1") { ?>
                                                                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_ar']) > 30 ? $link['file_name_ar'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_ar']) > 30 ? substr($link['file_name_ar'], 0, 30) . "....." : $link['file_name_ar']; ?></a>
                                                                    <?php } else { ?>
                                                                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_ar']) > 30 ? $link['file_name_ar'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_ar']) > 30 ? substr($link['file_name_ar'], 0, 30) . "....." : $link['file_name_ar']; ?></a>
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
                        <h5 class="modal-title mt-0" id="myModalLabel"> أسئلة الإستبيان </h5>
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
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
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
                <h5 class="m-0">القالب</h5>
            </div>
            <hr class="mt-0" />
            <h6 class="text-center mb-0">اختر القالب:</h6>
            <?php foreach ($themes as $theme) { ?>
                <div class="p-4 btn w-100 waves-effect waves-light" onclick="setTheme(<?php echo $theme['Id'] ?>,'<?php echo $theme['title_ar']; ?>')">
                    <div class="mb-2">
                        <div class="theme" style="background-color: <?php echo $theme['preview_color']; ?>;">
                            <p><?php echo $theme['title_ar']; ?></p>
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
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/jszip/jszip.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/pdfmake/build/pdfmake.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/pdfmake/build/vfs_fonts.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.html5.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.print.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script src="<?= base_url("assets/js/pages/toastr.init.js") ?>"></script>
<script src="<?= base_url("assets/js/pages/lightbox.init.js") ?>"></script>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>

<script>
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];

    $('.table').DataTable();
    // ministry actions
    $('input[type="checkbox"]').each(function() {
        $(this).change(function() {
            var Id = $(this).attr('serv_Id');
            var status = this.checked ? "Enabled" : "Disabled";
            if (status == "Disabled") {
                Swal.fire({
                    title: "ماذا يعني هذا !!",
                    html: "يعني تعطيل هذا الاستطلاع أنه <b> لا يمكن لأي شخص استخدامه </ b> <br> (في حالة تعطيله )",
                    icon: "warning",
                    confirmButtonColor: "#f46a6a",
                    cancelButtonColor: "#34c38f",
                    confirmButtonText: "Ok , يمكنك تغييره في أي وقت"
                }).then(function(result) {
                    if (result.value) {
                        update_status(Id);
                        console.log(result.value);
                    }
                });
            } else {
                update_status(Id);
            }
        });
    });

    function update_status(Id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/change_serv_status',
            data: {
                serv_id: Id,
                type: 'change'
            },
            success: function(data) {
                if (data === "ok") {
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
                    Command: toastr["success"]("The survey status was updated. " + status);
                } else {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ غير متوقع',
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

    $('.end_date').each(function() {
        $(this).change(function() {
            const new_date = $(this).val();
            const serv_id = $(this).attr('for_serv');
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>AR/DashboardSystem/change_serv_status',
                data: {
                    new_date: new_date,
                    serv_id: serv_id,
                    type: 'update_date',
                },
                success: function(data) {
                    if (data === "ok") {
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
                        Command: toastr["success"]("this survey end date now is : " + new_date);
                    } else {
                        Swal.fire(
                            'error',
                            'oops!! لدينا خطأ',
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
        });
    });

    function setTheme(id, title) {
        $("#theme").val(id);
        $("#theme_title").val(title);
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

    var btns = $('#surv_manage').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#surv_manage_wrapper  .col-md-6:eq(0)');

    var btns = $('#sur_lib').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#sur_lib_wrapper  .col-md-6:eq(0)');

    $('.select2').select2();

    $("body").on('click', ".questions", function(e) {
        var groupid = $(this).attr('group');
        if ($(this).attr('data-survey-type')) {
            var surveyType = "fillable";
        } else {
            var surveyType = "notFillable";
        }
        $('.question_list').html("");
        $('.showquestions').fadeIn();
        getquestions(groupid, surveyType);
    });

    $(".av_fillable_surveys_list").on('click', ".fillablequestions", function(e) {
        var groupid = $(this).attr('group');
        var surveyType = "fillable";

        $('.question_list').html("");
        $('.showquestions').fadeIn();
        getquestions(groupid, surveyType);
    });

    function getquestions(roupid, survType = "notFillable") {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/get_questions_of_avalaible_surveys',
            data: {
                requestFor: 'All_questions',
                group_id: roupid,
                s_type: survType,
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

    $('.publish').each(function() {
        $(this).click(function() {
            const serv_id = $(this).attr('for_serv');
            $('input[name="serv_id"]').val(serv_id);
        });
    });
    $("#publish_this_serv").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/publish_serv',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                // loading
                $('button[type="Submit"]').attr('disabled', 'disabled');
                $('button[type="Submit"]').html('Please wait ..');
            },
            success: function(data) {
                $('button[type="Submit"]').removeAttr('disabled');
                $('button[type="Submit"]').html('Publish');
                if (data == "okokokok") {
                    $('#publish').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ ، يرجى التحقق من المدخلات',
                        'error'
                    );
                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ ، يرجى المحاولة مرة أخرى في وقت لاحق',
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
            url: '<?php echo base_url(); ?>AR/DashboardSystem/change_serv_status',
            data: {
                serv_id: Id,
                type: 'change'
            },
            success: function(data) {
                if (data === "ok") {
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
                    Command: toastr["success"]("The survey status was updated." + status);
                } else {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ',
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