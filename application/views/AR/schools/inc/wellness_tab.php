<?php
$staffs = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_staff` ")->result_array();
$teachers = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_teacher` ")->result_array();
$students = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_student` ")->result_array();
$cards_surveys = $this->db->query(" SELECT MAX(`sv_st1_surveys`.`TimeStamp`) AS LastCreated , COUNT(`sv_st1_surveys`.`Id`) AS Total_Count 
    FROM `sv_st1_surveys`
    JOIN `l1_school` ON `l1_school`.`Id` = '" . $sessiondata["admin_id"] . "'
    JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` AND `sv_st1_surveys`.`Published_by` = `l0_organization`.`Id`
    JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
    JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
    JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
    JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
    WHERE `sv_st1_surveys`.`Avalaible_to` = '" . $type . "' OR `sv_st1_surveys`.`Avalaible_to` = '1'
    AND  `sv_st1_surveys`.`Status` = '1'
    AND `sv_st1_surveys`.`status` = '1' 
    AND (`sv_st1_surveys`.`Avalaible_to` = '" . $type . "' OR `sv_st1_surveys`.`Avalaible_to` = '1' ) ")->result_array();
$students_ages = isset($ages_with_groups['Student']) ? array_count_values(array_column($ages_with_groups['Student'], "DOP")) : array();
$teachers_ages = isset($ages_with_groups['teacher']) ? array_count_values(array_column($ages_with_groups['teacher'], "DOP")) : array();
$staffs_ages = isset($ages_with_groups['staff']) ? array_count_values(array_column($ages_with_groups['staff'], "DOP")) : array();
$parents_ages = isset($ages_with_groups['parents']) ? array_count_values(array_column($ages_with_groups['parents'], "DOP")) : array();
?>
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
<div class="col-lg-12">
    <br>
    <h4 class="card-title"
        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CHW 036 مجاميع الإستبيانات</h4>
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>مجموع الإستبيانات المنشورة</h4>
                    <h1 data-plugin="counterup">
                        <?= sizeof($our_surveys); ?>
                    </h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--blue);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>مجموع الإستبيانات المنتهية</h4>
                    <h1 data-plugin="counterup"><?= sizeof($expired_surveys) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--green);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>مجموع الإستبيانات المكتملة</h4>
                    <h1 data-plugin="counterup"><?= sizeof($completed_surveys) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--pink);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>مجموع التصنيفات المستخدمة</h4>
                    <h1 data-plugin="counterup"><?= sizeof($used_categorys) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 class="card-title"
        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CHW 037 التقارير التفصيلية</h4>
    <div class="row cardsoflinks">
        <div class="col-lg-3">
            <a href="<?= base_url('AR/schools/specific_surveys_reports/Students') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--purple);">
                        <img src="<?= base_url('assets/images/icons/Students.png') ?>" alt="">
                        <h4 class="text-white">تقارير الطلاب<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="<?= base_url('AR/schools/specific_surveys_reports/teachers') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--cyan);">
                        <img src="<?= base_url('assets/images/icons/teachers.png') ?>" alt="">
                        <h4 class="text-white">تقارير المعلمين<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="<?= base_url('AR/schools/specific_surveys_reports/Staff') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--red);">
                        <img src="<?= base_url('assets/images/icons/Staffs.png') ?>" alt="">
                        <h4 class="text-white">تقارير الموظفين<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="<?= base_url('AR/schools/specific_surveys_reports/Parents') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--gray);">
                        <img src="<?= base_url('assets/images/icons/Parents.png') ?>" alt="">
                        <h4 class="text-white">تقارير أولياء الأمور<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 038 ملخص الإستبيانات المنشورة</h4>

            <div class="card">
                <div class="card-body">
                    <div class="hori-timeline mt-5" dir="ltr">
                        <div class="owl-carousel owl-theme navs-carousel events" id="our_surveys_list">
                            <?php foreach ($our_surveys as $survey) { ?>
                                <div class="item ml-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                    <strong class="display-4 m-0 text-primary"
                                                            style="font-family: 'Almarai';"><?= $survey['answers_counter']; ?></strong>
                                                </div>
                                            </div>
                                            <span>رمز الإستبيان المنشور : <?= $survey['survey_id'] ?></span>
                                            <h5 class="font-size-16 mb-1"><a href="#"
                                                                             class="text-dark"><?= $survey['set_name_ar']; ?></a>
                                            </h5>
                                            <p class="text-muted mb-2"><?= 'من تاريخ :' . $survey['From_date'] . ' <br> إلى تاريخ :' . $survey['To_date'] ?></p>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <?php if ($survey['answers_counter'] > 0) { ?>
                                                <a href="<?= base_url("AR/schools/survey-reports/" . $survey['survey_id']); ?>"
                                                   class="btn btn-outline-light text-truncate"><i
                                                            class="uil uil-notes mr-1"></i>التقارير</a>
                                            <?php } ?>
                                            <a href="<?= base_url("AR/schools/survey-preview/" . $survey['survey_id']); ?>"
                                               target="_blank" class="btn btn-outline-light text-truncate"><i
                                                        class="uil uil-eye mr-1"></i> معاينة </a>
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
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 039 ملخص المشاركين في الإستبيانات</h4>

        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">الرسم البياني - جنس المشاركين</h3>
                            <h3 class="card-title text-center">
                                <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset=""
                                     width="200px">
                            </h3>
                            <div id="genders_dunat"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">الرسم البياني - فئات المشاركين</h3>
                            <h3 class="card-title text-center">
                                <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset=""
                                     width="200px">
                            </h3>
                            <div id="basic_type_chart" class="mb-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 040 ملخص إستجابات الطلاب مع الإستبيانات</h4>

        </div>
    </div>
    <div class="row ">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الجنس</h3>
                    <div id="students_genders"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">الرسم البياني - حسب الحالة الإجتماعية</h3>
                    <div id="mar_status_students"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-5">الرسم البياني - حسب العمر</h3>
                    <div id="students_ages"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 class="card-title"
        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CHW 041 مجاميع الإستبيانات - الطلاب</h4>
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <i class="uil uil-clipboard-notes font-size-70"></i>
                    <h4>مجموع الإستبيانات المنشورة</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_published_surveys['students'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--blue);">
                    <i class="uil uil-calendar-slash font-size-70"></i>
                    <h4>مجموع الإستبيانات المنتهية</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['students'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--green);">
                    <i class="uil uil-check font-size-70"></i>
                    <h4>مجموع الإستبيانات المكتملة</h4>
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
                    <h4> مجموع أسئلة الإستبيانات</h4>
                    <h1 data-plugin="counterup"><?= sizeof($students_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> متوسط زمن الإستجابة </h4>
                    <h1><?= $finishing_time_students; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 041 ملخص إستجابات المعلمين مع الإستبيانات</h4>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الجنس</h3>
                    <div id="teachers_genders"></div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الحالة الإجتماعية</h3>
                    <div id="mar_status_teachers"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب العمر
                    </h3>
                    <div id="teachers_ages"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 class="card-title"
        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CHW 042 مجاميع الإستبيانات - المعلمين</h4>
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <i class="uil uil-clipboard-notes font-size-70"></i>
                    <h4>مجموع الإستبيانات المنشورة</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_published_surveys['teachers'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--blue);">
                    <i class="uil uil-calendar-slash font-size-70"></i>
                    <h4>مجموع الإستبيانات المنتهية</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['teachers'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--green);">
                    <i class="uil uil-check font-size-70"></i>
                    <h4>مجموع الإستبيانات المكتملة</h4>
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
                    <h4> مجموع أسئلة الإستبيانات </h4>
                    <h1 data-plugin="counterup"><?= sizeof($teachers_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> متوسط زمن الإستجابة </h4>
                    <h1><?= $finishing_time_teachers; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 043 ملخص إستجابات الموظفين مع الإستبيانات</h4>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الجنس</h3>
                    <div id="staffs_genders"></div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الحالة الإجتماعية</h3>
                    <div id="mar_status_staffs"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب العمر</h3>
                    <div id="staffs_ages"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 class="card-title"
        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CHW 044 مجاميع الموظفين</h4>
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <i class="uil uil-clipboard-notes font-size-70"></i>
                    <h4>مجموع الإستبيانات المنشورة</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_published_surveys['staffs'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--blue);">
                    <i class="uil uil-calendar-slash font-size-70"></i>
                    <h4>مجموع الإستبيانات المنتهية</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['staffs'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--green);">
                    <i class="uil uil-check font-size-70"></i>
                    <h4>مجموع الإستبيانات المكتملة</h4>
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
                    <h4>مجموع أسئلة الإستبيانات</h4>
                    <h1 data-plugin="counterup"><?= sizeof($staff_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> متوسط زمن الإستجابة </h4>
                    <h1><?= $finishing_time_staff; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 045 ملخص إستجابات أولياء الأمور مع الإستبيانات</h4>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الجنس</h3>
                    <div id="parents_genders"></div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب الحالة الإجتماعية</h3>
                    <div id="mar_status_parents"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الرسم البياني - حسب العمر</h3>
                    <div id="parents_ages"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 class="card-title"
        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CHW 046 مجاميع أولياء الأمور</h4>
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <i class="uil uil-clipboard-notes font-size-70"></i>
                    <h4>مجموع الإستبيانات المنشورة</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_published_surveys['Parents'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--blue);">
                    <i class="uil uil-calendar-slash font-size-70"></i>
                    <h4>مجموع الإستبيانات المنتهية</h4>
                    <h1 data-plugin="counterup"><?= $counter_of_expired_surveys['Parents'] ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--green);">
                    <i class="uil uil-check font-size-70"></i>
                    <h4>مجموع الإستبيانات المكتملة</h4>
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
                    <h4> مجموع أسئلة الإستبيانات</h4>
                    <h1 data-plugin="counterup"><?= sizeof($parents_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> متوسط زمن الإستجابة</h4>
                    <h1><?= $finishing_time_parents; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CHW 047 متوسط زمن الإستجابة لجميع فئات المشاركين في الإستبيانات</h4>
            <div class="card p-4">
                <div class="card-body text-center">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> متوسط زمن الإستجابة لجميع فئات المشاركين في الإستبيانات </h4>
                    <h1><?= $finishing_time_all; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
            categories: ['معلمين', 'موظفين', 'طلاب', 'أولياء أمور'],
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#basic_type_chart"),
        options
    );
    chart.render();
    var genders_dunat = {
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
            data: [<?= $surveys_for_males ?>, <?= $surveys_for_females ?>]
        }],
        colors: ['#f46a6a'],
        grid: {
            borderColor: '#34c38f',
        },
        xaxis: {
            categories: ["ذكور", "إناث"],
        }
    }
    var chart = new ApexCharts(document.querySelector("#genders_dunat"), genders_dunat);
    chart.render();
    // students
    var s_genders_dunat = {
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
            data: [<?= $gend_students_males ?>, <?= $gend_students_females ?>]
        }],
        colors: ['#34c38f'],
        grid: {
            borderColor: '#34c38f',
        },
        xaxis: {
            categories: ["ذكور", "إناث"],
        }
    }
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
        labels: ["الذكور", "إناث"],
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
        labels: ["ذكور", "إناث"],
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
        labels: ["ذكور", "إناث"],
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