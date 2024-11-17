<?php
$staffs = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_staff` ")->result_array();
$teachers = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_teacher` ")->result_array();
$students = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_student` ")->result_array();

$students_ages = isset($ages_with_groups['Student']) ? array_count_values(array_column($ages_with_groups['Student'], "DOP")) : array();
$teachers_ages = isset($ages_with_groups['teacher']) ? array_count_values(array_column($ages_with_groups['teacher'], "DOP")) : array();
$staffs_ages = isset($ages_with_groups['staff']) ? array_count_values(array_column($ages_with_groups['staff'], "DOP")) : array();
$parents_ages = isset($ages_with_groups['parents']) ? array_count_values(array_column($ages_with_groups['parents'], "DOP")) : array();
?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.theme.default.min.css">

<style>
    .font-size-70 {
        font-size: 70px;
        margin-bottom: 10px;
        display: block;
    }

    .count_in_list {
        width: 120px !important;
        height: 120px !important;
        margin: auto;
    }

    .firstCard * {
        color: #fff;
    }

    .firstCard.card-body {
        border-radius: 5px
    }

    .firstCard .uil-arrow-right {
        margin-left: 10px;
        transition: 0.2s all;
    }

    img.ic_img {
        width: 60px;
        margin-bottom: 20px;
    }

    .ontypecard .card-body * {
        color: #fff;
        cursor: default;
    }

    .ontypecard .card-body {
        border-radius: 5px;
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
</style>
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
        <div class="col-lg-12">
            <br><h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                Reports for: <?= $school_data->School_Name_EN; ?>
            </h4><br>

            <br><h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 036 COUNTER CARDS-ALL SURVEYS</h4>
            <div class="row">

                <div class="col-lg-3">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--yellow);">
                            <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img"
                                 alt="">
                            <h4>TOTAL PUBLISHED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?php echo sizeof($our_surveys); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--blue);">
                            <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img"
                                 alt="">
                            <h4>TOTAL EXPIRED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?php echo sizeof($expired_surveys) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--green);">
                            <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img"
                                 alt="">
                            <h4>TOTAL COMPLETED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?php echo sizeof($completed_surveys) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--pink);">
                            <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img"
                                 alt="">
                            <h4>TOTAL CATEGORIES</h4>
                            <h1 data-plugin="counterup"><?php echo sizeof($used_categorys) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 038 SUMMARY OF RESPONDENTS BASED ON PUBLISHED RESEARCH SURVEYS</h4>

                    <div class="card">
                        <div class="card-body">
                            <div class="hori-timeline mt-5" dir="center">
                                <div class="owl-carousel owl-theme navs-carousel events" id="our_surveys_list">
                                    <?php
                                    foreach ($our_surveys as $survey) { ?>
                                        <div class="item ml-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                            <strong class="display-4 m-0 text-primary"
                                                                    style="font-family: 'Almarai';"><?= $survey['answers_counter']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <span>Survey Code: Surv-<?= $survey['survey_id'] ?></span>
                                                    <h5 class="font-size-16 mb-1"><a href="#"
                                                                                     class="text-dark"><?= $survey['set_name_en']; ?></a>
                                                    </h5>
                                                    <p class="text-muted mb-2"><?php echo 'From :' . $survey['From_date'] . ' <br> To :' . $survey['To_date'] ?></p>
                                                </div>

                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 039 Summary of user types based on published search surveys</h4>

                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <?php /*?> <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Graphical Presentation of Responses According to Gender</h3>
                                    <h3 class="card-title text-center">
                                        <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                                    </h3>
                                    <div id="genders_dunat" style="margin-bottom: 62px;"></div>
                                </div>
                            </div>
                        </div><?php */ ?>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title mb-5">Graphical Presentation of Published Surveys According to
                                        User Types</h3>
                                    <div id="basic_type_chart" class="mb-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php /*?><div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Presentation of Responses According to Age for all User in all School</h3>
                            <h3 class="card-title text-center">

                                <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                            </h3>
                            <div id="basic_ages_chart"></div>
                        </div>
                    </div>
                </div><?php */ ?>
                <?php /*?><div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"> Graphical Presentation of Responses According to Age for all User Used Surveys in all School </h3>
                            <h3 class="card-title text-center">
                                <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                            </h3>
                            <div id="users_passed_survey_ages_chart"></div>
                        </div>
                    </div>
                </div><?php */ ?>

            </div>

            <div class="row">
                <div class="col-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 040 DATA FREQUENCY OF STUDENTS</h4>
                </div>
            </div>

            <div class="row ">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution of Published Surveys By Gender</h3>
                            <div id="students_genders"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Graphical Distribution By Marital Status</h3>
                            <div id="mar_status_students"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-5">Graphical Distribution by Age</h3>
                            <div id="students_ages"></div>
                        </div>
                    </div>
                </div>
            </div>
            <br><h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 041 STUDENT COUNTERS</h4>
            <div class="row">

                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--yellow);">
                            <i class="uil uil-clipboard-notes font-size-70"></i>
                            <h4>TOTAL PUBLISHED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_published_surveys['students'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--blue);">
                            <i class="uil uil-calendar-slash font-size-70"></i>
                            <h4>TOTAL EXPIRED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['students'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--green);">
                            <i class="uil uil-check font-size-70"></i>
                            <h4>TOTAL COMPLETED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_completed_surveys['students']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ontypecard">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-comment-alt-question font-size-70"></i>
                            <h4> TOTAL QUESTIONS OF SURVEYS </h4>
                            <h1 data-plugin="counterup"><?= sizeof($students_quastions) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-clock-eight font-size-70"></i>
                            <h4> AVERAGE TIME RESPONSE </h4>

                            <h1><?php echo $finishing_time_students; ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 041 DATA FREQUENCY OF TEACHERS</h4>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution of Published Surveys By Gender</h3>
                            <div id="teachers_genders"></div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution By Marital Status</h3>
                            <div id="mar_status_teachers"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution by Age</h3>
                            <div id="teachers_ages"></div>
                        </div>
                    </div>
                </div>
            </div>
            <br><h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 042 TEACHER COUNTERS</h4>
            <div class="row">

                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--yellow);">
                            <i class="uil uil-clipboard-notes font-size-70"></i>
                            <h4>TOTAL PUBLISHED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_published_surveys['teachers'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--blue);">
                            <i class="uil uil-calendar-slash font-size-70"></i>
                            <h4>TOTAL EXPIRED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['teachers'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--green);">
                            <i class="uil uil-check font-size-70"></i>
                            <h4>TOTAL COMPLETED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_completed_surveys['teachers']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row ontypecard">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-comment-alt-question font-size-70"></i>
                            <h4> TOTAL QUESTIONS OF SURVEYS </h4>
                            <h1 data-plugin="counterup"><?= sizeof($teachers_quastions) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-clock-eight font-size-70"></i>
                            <h4> AVERAGE TIME RESPONSE </h4>
                            <h1><?= $finishing_time_teachers; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 043 DATA FREQUENCY OF STAFF</h4>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution of Published Surveys By Gender</h3>
                            <div id="staffs_genders"></div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution By Marital Status</h3>
                            <div id="mar_status_staffs"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution by Age</h3>
                            <div id="staffs_ages"></div>
                        </div>
                    </div>
                </div>
            </div>
            <br><h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 044 STAFF COUNTERS</h4>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--yellow);">
                            <i class="uil uil-clipboard-notes font-size-70"></i>
                            <h4>TOTAL PUBLISHED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_published_surveys['staffs'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--blue);">
                            <i class="uil uil-calendar-slash font-size-70"></i>
                            <h4>TOTAL EXPIRED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['staffs'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--green);">
                            <i class="uil uil-check font-size-70"></i>
                            <h4>TOTAL COMPLETED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_completed_surveys['staffs']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ontypecard">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-comment-alt-question font-size-70"></i>
                            <h4> TOTAL QUESTIONS OF SURVEYS </h4>
                            <h1 data-plugin="counterup"><?= sizeof($staff_quastions) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-clock-eight font-size-70"></i>
                            <h4> AVERAGE TIME RESPONSE </h4>
                            <h1><?= $finishing_time_staff; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 045 DATA FREQUENCY OF PARENTS</h4>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution of Published Surveys By Gender</h3>
                                <div id="parents_genders"></div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution By Marital Status</h3>
                            <div id="mar_status_parents"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Graphical Distribution by Age</h3>
                            <div id="parents_ages"></div>
                        </div>
                    </div>
                </div>
            </div>

            <br><h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 046 PARENT COUNTERS</h4>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--yellow);">
                            <i class="uil uil-clipboard-notes font-size-70"></i>
                            <h4>TOTAL PUBLISHED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_published_surveys['Parents'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--blue);">
                            <i class="uil uil-calendar-slash font-size-70"></i>
                            <h4>TOTAL EXPIRED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['Parents'] ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-ronded">
                        <div class="card-body firstCard text-center" style="background: var(--green);">
                            <i class="uil uil-check font-size-70"></i>
                            <h4>TOTAL COMPLETED SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= $counter_of_completed_surveys['Parents']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ontypecard">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-comment-alt-question font-size-70"></i>
                            <h4> TOTAL QUESTIONS OF SURVEYS</h4>
                            <h1 data-plugin="counterup"><?= sizeof($parents_quastions) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" style="background: var(--orange);">
                            <i class="uil uil-clock-eight font-size-70"></i>
                            <h4> AVERAGE TIME RESPONSE </h4>
                            <h1><?= $finishing_time_parents; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <br><h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CHW 047 AVERAGE TIME RESPONSE FOR ALL USERS</h4>
                    <div class="card p-4">
                        <div class="card-body text-center">
                            <i class="uil uil-clock-eight font-size-70"></i>
                            <h4> AVERAGE TIME RESPONSE </h4>
                            <h1><?= $finishing_time_all; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
<script>
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
    // column chart with datalabels
    var b_ages_options = {
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        series: [
            <?php foreach ($ages as $key =>  $age) { ?> {
                name: '<?= $key ?>',
                data: [<?= $age ?>]
            },
            <?php } ?>
        ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_keys($ages)); ?>],
            position: 'top',
            labels: {
                offsetY: -18,

            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,

            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " users";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#basic_ages_chart"), b_ages_options);
    chart_ages.render();
    // column chart with datalabels
    var users_passed_survey_ages_options = {
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        series: [
            <?php
            foreach ($users_passed_survey_ages_options_ages as $key =>  $age) { ?> {
                name: '<?= $key ?>',
                data: [<?= $age ?>]
            },
            <?php } ?>
        ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_keys($ages)); ?>],
            position: 'top',
            labels: {
                offsetY: -18,

            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,

            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " users";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#users_passed_survey_ages_chart"), users_passed_survey_ages_options);
    chart_ages.render();

    var options = {
        chart: {
            height: 450,
            type: 'bar'
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: true
        },
        series: [{
            name: "counter",
            data: [<?= $counter_of_completed_surveys['teachers'] ?>, <?= $counter_of_completed_surveys['staffs'] ?>, <?= $counter_of_completed_surveys['students'] ?>, <?= $counter_of_completed_surveys['Parents'] ?>]
        }],
        colors: ['#34c38f'],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: ['Teachers', 'Staff', 'Students', 'Parents'],
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#basic_type_chart"),
        options
    );

    chart.render();


    var genders_dunat = {
        series: [<?= $surveys_for_males ?>, <?= $surveys_for_females ?>],
        labels: ["Males", "Females"],
        chart: {
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#genders_dunat"), genders_dunat);
    chart.render();

    // students 
    var s_genders_dunat = {
        series: [<?= $gend_students_males ?>, <?= $gend_students_females ?>],
        labels: ["Males", "Females"],
        chart: {
            height: "200px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#students_genders"), s_genders_dunat);
    chart.render();

    var students_ages_options = {
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: false,
                    position: 'top', // top, center, bottom
                },
            }
        },
        series: [
            <?php foreach ($students_ages as $key =>  $students_age) { ?> {
                name: '<?= $key ?>',
                data: [<?= $students_age ?>]
            },
            <?php } ?>
        ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_keys($students_ages)); ?>],
            position: 'top',
            labels: {
                offsetY: -18,
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: false,
                offsetY: -35,
            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return " ";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#students_ages"), students_ages_options);
    chart_ages.render();

    <?php
    $s_keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($students_matural));
    ?>
    var m_students = {
        series: [<?= implode(',', array_values($students_matural)) ?>],
        labels: [<?= implode(',', $s_keys_string) ?>],
        chart: {
            height: "100px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var stchart = new ApexCharts(document.querySelector("#mar_status_students"), m_students);
    stchart.render();
    // teachers_genders 
    var genders_dunat = {
        series: [<?= $gend_teachers_males ?>, <?= $gend_teachers_females ?>],
        labels: ["Males", "Females"],
        chart: {
            height: "200px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#teachers_genders"), genders_dunat);
    chart.render();


    var teachers_ages_options = {
        chart: {
            height: 375,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        series: [
            <?php foreach ($teachers_ages as $key =>  $teachers_age) { ?> {
                name: '<?= $key ?>',
                data: [<?= $teachers_age ?>]
            },
            <?php } ?>
        ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_keys($teachers_ages)); ?>],
            position: 'top',
            labels: {
                offsetY: -18,

            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,

            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " users";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#teachers_ages"), teachers_ages_options);
    chart_ages.render();
    <?php
    $keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($teachers_matural));
    ?>
    var m_teachers = {
        series: [<?= implode(',', array_values($teachers_matural)) ?>],
        labels: [<?= implode(',', $keys_string) ?>],
        chart: {
            height: "100px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#mar_status_teachers"), m_teachers);
    chart.render();

    // staffs 
    var genders_dunat = {
        series: [<?= $gend_staffs_males ?>, <?= $gend_staffs_females ?>],
        labels: ["Males", "Females"],
        chart: {
            height: "200px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#staffs_genders"), genders_dunat);
    chart.render();


    var teachers_ages_options = {
        chart: {
            height: 375,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        series: [
            <?php foreach ($staffs_ages as $key =>  $staffs_age) { ?> {
                name: '<?= $key ?>',
                data: [<?= $staffs_age ?>]
            },
            <?php } ?>
        ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_keys($staffs_ages)); ?>],
            position: 'top',
            labels: {
                offsetY: -18,

            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,

            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " users";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#staffs_ages"), teachers_ages_options);
    chart_ages.render();
    <?php
    $keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($staffs_matural));
    ?>
    var m_staffs = {
        series: [<?= implode(',', array_values($staffs_matural)) ?>],
        labels: [<?= implode(',', $keys_string) ?>],
        chart: {
            height: "100px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#mar_status_staffs"), m_staffs);
    chart.render();

    // Parents 
    var genders_dunat = {
        series: [<?= $gend_parents_males ?>, <?= $gend_parents_females ?>],
        labels: ["Males", "Females"],
        chart: {
            height: "200px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#parents_genders"), genders_dunat);
    chart.render();


    var parents_ages_options = {
        chart: {
            height: 375,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        series: [
            <?php foreach ($parents_ages as $key =>  $parents_age) { ?> {
                name: '<?= $key ?>',
                data: [<?= $parents_age ?>]
            },
            <?php } ?>
        ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_keys($parents_ages)); ?>],
            position: 'top',
            labels: {
                offsetY: -18,

            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,

            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " users";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#parents_ages"), parents_ages_options);
    chart_ages.render();
    <?php
    $keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($parents_matural));
    ?>
    var m_parents = {
        series: [<?= implode(',', array_values($parents_matural)) ?>],
        labels: [<?= implode(',', $keys_string) ?>],
        chart: {
            height: "100px",
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 150
                },
                legend: {
                    show: false,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    verticalAlign: 'middle',
                    floating: false,
                    fontSize: '14px',
                    offsetX: 0
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#mar_status_parents"), m_parents);
    chart.render();
</script>