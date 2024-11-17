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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>s
    <link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/libs/magnific-popup/magnific-popup.css"); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
</head>

<div class="main-content">
    <div class="page-content">
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
        <div id="PublishSurveyForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="PublishSurveyFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="PublishSurveyFormLabel">Publish This Survey :</h5>
                        <button type="button" class="btn-close btn btn-rounded" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form id="publish_this_serv">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">This survey is for : </label><span class="float-right text-primary btn s-all" data-target-select="type[]">Select all</span>
                                        <select class="select2 form-control select2-multiple select-survey-respondents" multiple="multiple" data-placeholder="Choose ..." name="type[]">
                                            <?php foreach ($supported_types as $usertype) { ?>
                                                <option value="<?= $usertype['typeKey'] ?>"><?= $usertype['name'] ?></option>
                                            <?php } ?>
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
        <div class="row mb-3">
            <div class="col-lg-12 text">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active nav_1_b" tab_for="#home" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/homewelness.png') ?>" alt="">
                            <span>HOME</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_2_b" tab_for="#wellness" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/wellness.png') ?>" alt="">
                            <span>WELLNESS DASHBOARD</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_3_b" tab_for="#manage_surveys" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/manage_survey.png') ?>" alt="">
                            <span class="d-none d-sm-block">MANAGE SURVEYS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_4_b" tab_for="#expired_surveys" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/lib_surveys.png') ?>" alt="">
                            <span class="d-none d-sm-block">SURVEY LIBRARY</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_4_b" tab_for="#published_surveys" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/lib_surveys.png') ?>" alt="">
                            <span class="d-none d-sm-block">PUBLISHED SURVEYS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_6_b" tab_for="#media" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/media.png') ?>" alt="">
                            <span class="d-none d-sm-block">MEDIA GALLERY</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_7_b" tab_for="#well_edu" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/well_edu.png') ?>" alt="">
                            <span class="d-none d-sm-block">WELLNESS EDUCATION RESOURCES </span>
                        </a>
                    </li>
                    <li class="nav-item nav_5_b">
                        <a class="nav-link" tab_for="#action_planes" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/action_planes.png') ?>" alt="">
                            <span class="d-none d-sm-block">ACTION PLANS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav_8_b" tab_for="#reports" role="tab">
                            <img src="<?php echo base_url('assets/images/icons/reports.png') ?>" alt="">
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
                                        <!-- <button class="gonext" data-img-key="<?= $i ?>"></button> -->
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
            <?php $this->load->view("EN/Department_comp/inc/WellnessTab") ?>
        </div>
        <div class="row mt2 real_wellness" id="published_surveys">
            <!-- our_published_surveys -->
            <div class="col-lg-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 057 PUBLISHED SURVEYS</h4>
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
                                    <?php foreach ($our_surveys as $key => $published_survey) {  ?>
                                        <?php
                                        $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                        WHERE `group_id` = '" . $published_survey['group_id'] . "' ")->num_rows();
                                        $answers_count = $this->db->query("SELECT Id FROM `sv_st_questions`
                                        WHERE `survey_id` = '" . $published_survey['main_survey_id'] . "' ")->num_rows();
                                        $Targeted_types =  array_column($this->db->query("SELECT r_usertype.UserType AS usertype 
                                        FROM `sv_co_published_surveys_types` 
                                        JOIN `r_usertype` ON `r_usertype`.`Id` = `sv_co_published_surveys_types`.`Type_code`
                                        WHERE Survey_id = '" . $published_survey['survey_id'] . "' ")->result_array(), 'usertype');
                                        ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $published_survey['serv_code'] ?></td>
                                            <td><?= $published_survey['publish_date'] ?></td>
                                            <td><?= $published_survey['Title_en'] ?></td>
                                            <td><?= $published_survey['set_name_en'] ?></td>
                                            <td>
                                                <div style="max-width: 150px;display: flex;flex-direction: row;flex-wrap: wrap;">
                                                    <?php foreach ($Targeted_types as $type) { ?>
                                                        <span class="badge rounded-pill bg-success text-white p-2 badge-m-1 m-1"><?= $type ?></span>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td><?= $published_survey['answers_counter'] ?></td>
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
            </div>
        </div>
        <div class="row mt2 real_wellness" id="manage_surveys">
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
                                        <td><?= $answers_count;  ?></td>
                                        <td><?= $choices_count  ?></td>
                                        <td class="text-center">
                                            <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                                                <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $st_survey['main_survey_id']; ?>"></i>
                                            </span>
                                            <span data-toggle="tooltip" data-placement="top" data-original-title="Publish this survey">
                                                <i class="uil uil-eye-slash publish" data-toggle="modal" data-target="#PublishSurveyForm" for_serv="<?= $st_survey['survey_id']; ?>"></i>
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

        <div class="row mt3 real_wellness" id="expired_surveys">
            <div class="col-lg-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 057 SURVEY LIBRARY</h4>
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
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 061 ACTION PLANS </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($used_categorys as $category) { ?>
                                <?php $media = $this->db->get_where('l1_category_resources', array('category_id' => $category['Id'], "file_language" => "EN", "file_type" => "1"))->result_array(); ?>
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
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 059 MEDIA GALLERY </h4>
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
            <?php $this->load->view('EN/Department_comp/inc/WELLNESS_EDUCATION_RESOURCES'); ?>
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
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 062 REPORTS </h4>
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
</div>
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
    $('.select2').select2({
        closeOnSelect: false
    });
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
    try {
        $('#home').slideDown();
    } catch (error) {
        console.log('------');
    }

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

    function getquestions(roupid, survType = "notFillable") {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Company_Departments/get_questions_of_avalaible_surveys',
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
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }


    // $('input[type="checkbox"]').each(function() {
    //     $(this).change(function() {
    //         var Id = $(this).attr('serv_Id');
    //         var status = this.checked ? "Enabled" : "Disabled";
    //         if (status == "Disabled") {
    //             Swal.fire({
    //                 title: "What does this mean?",
    //                 html: "When disabled, no one can use the survey.",
    //                 icon: "warning",
    //                 confirmButtonColor: "#f46a6a",
    //                 cancelButtonColor: "#34c38f",
    //                 confirmButtonText: "Ok, but you can change it anytime."
    //             }).then(function(result) {
    //                 if (result.value) {
    //                     update_status(Id);
    //                     console.log(result.value);
    //                 }
    //             });
    //         } else {
    //             update_status(Id);
    //         }
    //     });
    // });

    function update_status(Id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('EN/Company_Departments/change_serv_status') ?>',
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
                    'oops!! we have a error',
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

    $('.publish').click(function() {
        console.log($(this).attr('for_serv'));
        $('input[name="serv_id"]').val($(this).attr('for_serv'));
    });

    $("#publish_this_serv").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
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
                    Command: toastr["success"]("The survey has been published successfully. ");
                    $('#publish').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                }
                else {
                    $('#publish_this_serv button[type="Submit"]').removeAttr('disabled');
                    $('#publish_this_serv button[type="Submit"]').html('Publish');
                    console.log(data.status);
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

    function setTheme(id, title) {
        if ($('#Fillable_publish').hasClass('show')) {
            $("#fillable_theme").val(id);
            $("#fillable_theme_title").val(title);
        } else {
            $("#theme").val(id);
            $("#theme_title").val(title);
        }
    }

    function publishedsurveyStatusChanger(surveyId) {
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Company_Departments/published_surveys_control"); ?>",
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
</script>