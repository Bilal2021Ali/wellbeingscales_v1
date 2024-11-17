<?php
$staffs = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_staff` ")->result_array();
$teachers = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_teacher` ")->result_array();
$students = $this->db->query(" SELECT  MAX(TimeStamp) AS LastCreated , COUNT(Id) AS Total_Count FROM `l2_student` ")->result_array();
$students_ages = isset($ages_with_groups['Student']) ? array_count_values(array_column($ages_with_groups['Student'], "DOP")) : array();
$teachers_ages = isset($ages_with_groups['teacher']) ? array_count_values(array_column($ages_with_groups['teacher'], "DOP")) : array();
$staffs_ages   = isset($ages_with_groups['staff']) ? array_count_values(array_column($ages_with_groups['staff'], "DOP")) : array();
$parents_ages   = isset($ages_with_groups['parents']) ? array_count_values(array_column($ages_with_groups['parents'], "DOP")) : array();
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

    .img-responsive.w-100.p-1 {
        max-width: 200px;
    }
</style>

<div class="col-lg-12">
    <br>
    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 036 إحصائيات الإستبيانات</h4>
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>مجموع الإستبيانات المنشورة</h4>
                    <h1 data-plugin="counterup"><?= sizeof($our_surveys); ?></h1>
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
                    <h4>مجموع المجموعات المستخدمة</h4>
                    <h1 data-plugin="counterup"><?= sizeof($used_categorys) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 037 تفاصيل التقارير حسب نوع المستخدم</h4>

    <div class="row cardsoflinks">
        <div class="col-lg-3">
            <a href="<?= base_url('AR/DashboardSystem/specific_surveys_reports/Students') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--purple);">
                        <img src="<?= base_url('assets/images/icons/Students.png') ?>" alt="">
                        <h4 class="text-white">الطلاب<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="<?= base_url('AR/DashboardSystem/specific_surveys_reports/teachers') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--cyan);">
                        <img src="<?= base_url('assets/images/icons/teachers.png') ?>" alt="">
                        <h4 class="text-white">المعلمين<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="<?= base_url('AR/DashboardSystem/specific_surveys_reports/Staff') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--red);">
                        <img src="<?= base_url('assets/images/icons/Staffs.png') ?>" alt="">
                        <h4 class="text-white">الموظفين <i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="<?= base_url('AR/DashboardSystem/specific_surveys_reports/Parents') ?>">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--gray);">
                        <img src="<?= base_url('assets/images/icons/Parents.png') ?>" alt="">
                        <h4 class="text-white">أولياء الأمور<i class="uil uil-arrow-right"></i></h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 038 عناوين الإستبيانات المنشورة وعدد المشاركين فيها</h4>
            <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;">عناوين الإستبيانات المنشورة وعدد المشاركين فيها</h4>
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
                                                    <strong class="display-4 m-0 text-primary" style="font-family: 'Almarai';"><?= $survey['answers_counter']; ?></strong>
                                                </div>
                                            </div>
                                            <span>رمز الإستبيان: إستبيان<?= $survey['survey_id'] ?></span>
                                            <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $survey['set_name_ar']; ?></a></h5>
                                            <p class="text-muted mb-2"><?= 'من :' . $survey['From_date'] . ' <br> إلى :' . $survey['To_date'] ?></p>
                                            <div class="btn-group" role="group">

                                                <?php if ($survey['answers_counter'] > 0) { ?>
                                                    <a href="<?= base_url("AR/DashboardSystem/survey_reports/" . $survey['survey_id']); ?>" class="btn btn-outline-light text-truncate"><i class="uil uil-notes mr-1"></i>التقارير</a>
                                                <?php } ?>
                                                <a href="<?= base_url("AR/DashboardSystem/survey_preview/" . $survey['survey_id']); ?>" target="_blank" class="btn btn-outline-light text-truncate"><i class="uil uil-eye mr-1"></i> معاينة </a>
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
    </div>

    <div class="row">
        <?php foreach (['active', 'expired'] as $type) { ?>
            <div class="col-12">
                <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 039 SUMMARY OF USER TYPES BASED ON <?= $type == "active" ? "PUBLISHED" : "EXPIRED" ?> RESEARCH SURVEYS</h4>
                <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> SUMMARY OF USER TYPES BASED ON <?= $type == "active" ? "PUBLISHED" : "EXPIRED" ?> RESEARCH SURVEYS </h4>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card genders_dunat_card">
                            <div class="card-body text-center">
                                <h3 class="card-title">الرسم البياني حسب الجنس</h3>
                                <h3 class="card-title ">
                                    <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                                </h3>
                                <div id="<?= $type ?>_genders_dunat"></div>
                                <?php if ($surveys_for_males[$type] <= 0 && $surveys_for_females[$type] <= 0) { ?>
                                    <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                                <?php }  ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card basic_type_chart_card">
                            <div class="card-body">
                                <h3 class="card-title">الرسم البياني للمشاركين في الاستطلاع حسب نوع المستخدم</h3>
                                <h3 class="card-title text-center">
                                    <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                                </h3>
                                <div id="<?= $type ?>_type_chart" class="mb-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php  } ?>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"> الرسم البياني حسب عمر المستخدمين المشاركين في الاستبيانات </h3>
                    <h3 class="card-title text-center">
                        <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                    </h3>
                    <div id="users_passed_survey_ages_chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">الرسم البياني للإجابات وفقًا للعمر لجميع استطلاعات المستخدم المستخدمة في جميع المدارس</h3>
                <div id="basic_ages_chart"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 040 إستبيانات الطلاب</h4>
            <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> إستبيانات الطلاب </h4>
        </div>
    </div>

    <div class="row ">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الجنس</h3>
                    <div id="students_genders"></div>
                    <?php if ($gend_students_males <= 0 && $gend_students_females <= 0) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php }  ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title mb-4">الرسم البياني حسب الحالة الاجتماعية</h3>
                    <div id="mar_status_students"></div>
                    <?php if (empty($students_matural)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title mb-5">الرسم البياني حسب العمر</h3>
                    <div id="students_ages"></div>
                    <?php if (empty($students_ages)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 041 مجاميع الطلاب</h4>
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
                    <h4> مجموع المجموعات المستخدمة </h4>
                    <h1 data-plugin="counterup"><?= sizeof($students_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> معدل زمن الاستجابة </h4>
                    <h1><?= $finishing_time_students; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 041 إستبيانات المعلمين</h4>
            <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> إستبيانات المعلمين</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الجنس</h3>
                    <div id="teachers_genders"></div>
                    <?php if ($gend_teachers_males <= 0 && $gend_teachers_females <= 0) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php }  ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mt-2">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الحالة الاجتماعية</h3>
                    <div id="mar_status_teachers"></div>
                    <?php if (empty($teachers_matural)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب العمر</h3>
                    <div id="teachers_ages"></div>
                    <?php if (empty($teachers_ages)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php }  ?>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 042 مجاميع المعلمين</h4>
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
                    <h4> مجموع المجموعات المستخدمة </h4>
                    <h1 data-plugin="counterup"><?= sizeof($teachers_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> معدل زمن الاستجابة</h4>
                    <h1><?= $finishing_time_teachers; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 043 إستبيانات الموظفين</h4>
            <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> إستبيانات الموظفين </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الجنس</h3>
                    <div id="staffs_genders"></div>
                    <?php if ($gend_staffs_males <= 0 && $gend_staffs_females <= 0) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mt-2">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الحالة الاجتماعية</h3>
                    <div id="mar_status_staffs"></div>
                    <?php if (empty($staffs_matural)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب العمر</h3>
                    <div id="staffs_ages"></div>
                    <?php if (empty($staffs_ages)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 044 مجاميع الموظفين</h4>

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
                    <h4> مجموع المجموعات المستخدمة </h4>
                    <h1 data-plugin="counterup"><?= sizeof($staff_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> معدل زمن الاستجابة </h4>
                    <h1><?= $finishing_time_staff; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 045 إستبيانات أولياء الأمور</h4>
            <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> إستبيانات أولياء الأمور </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الجنس</h3>
                    <div id="parents_genders"></div>
                    <?php if ($gend_parents_males <= 0 && $gend_parents_females <= 0) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mt-2">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب الحالة الاجتماعية</h3>
                    <div id="mar_status_parents"></div>
                    <?php if (empty($parents_matural)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">الرسم البياني حسب العمر</h3>
                    <div id="parents_ages"></div>
                    <?php if (empty($parents_ages)) { ?>
                        <img src="<?= base_url("assets/images/no_surveys_found.svg") ?>" class="img-responsive w-100 p-1">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CHW 046 مجاميع أولياء الأمور</h4>
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
                    <h4> مجموع المجموعات المستخدمة</h4>
                    <h1 data-plugin="counterup"><?= sizeof($parents_quastions) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center" style="background: var(--orange);">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> معدل زمن الاستجابة </h4>
                    <h1><?= $finishing_time_parents; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CHW 047 معدل زمن الاستجابة العام لجميع المستخدمين</h4>
            <div class="card p-4">
                <div class="card-body text-center">
                    <i class="uil uil-clock-eight font-size-70"></i>
                    <h4> معدل زمن الاستجابة </h4>
                    <h1><?= $finishing_time_all; ?></h1>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    //column chart with datalabels
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
                formatter: function(val) {
                    return " ";
                }
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
                formatter: function(val) {
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
                formatter: function(val) {
                    return val + " users";
                }
            }

        },
    }

    var chart_ages = new ApexCharts(document.querySelector("#users_passed_survey_ages_chart"), users_passed_survey_ages_options);
    chart_ages.render();
    <?php foreach (['active', 'expired'] as $type) { ?>
        var options = {
            chart: {
                height: 450,
                type: 'bar'
            },
            series: [{
                name: "counter",
                data: [<?= sizeof($teachers_surveys[$type]) ?>, <?= sizeof($staff_surveys[$type]) ?>, <?= sizeof($students_surveys[$type]) ?>, <?= sizeof($parents_surveys[$type]) ?>]
            }],
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: true
            },

            colors: ['#34c38f'],
            grid: {
                borderColor: '#f1f1f1',
            },
            yaxis: {
                labels: {
                    show: true,
                }
            },
            xaxis: {
                categories: ['Teachers', 'Staff', 'Students', 'Parents'],
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#<?= $type ?>_type_chart"),
            options
        );
        chart.render();

        <?php if (!empty($surveys_for_males[$type]) || $surveys_for_females[$type]) { ?>
            var genders_dunat = {
                series: [{
                    name: "counter",
                    data: [<?= $surveys_for_males[$type] ?>, <?= $surveys_for_females[$type] ?>]
                }],
                grid: {
                    borderColor: '#f1f1f1',
                },
                xaxis: {
                    categories: ["Males", "Females"],
                },
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
            };
            var chart = new ApexCharts(document.querySelector("#<?= $type ?>_genders_dunat"), genders_dunat);
            chart.render();
        <?php } ?>
    <?php } ?>
    // students 
    <?php if ($gend_students_males || $gend_students_females) { ?>
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
    <?php } ?>
    <?php if (!empty($students_ages)) { ?>
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
                    formatter: function(val) {
                        return val + " users";
                    }
                }

            },
        }
        var chart_ages = new ApexCharts(document.querySelector("#students_ages"), students_ages_options);
        chart_ages.render();
    <?php } ?>
    <?php
    $s_keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($students_matural));
    ?>
    <?php if (!empty($students_matural)) { ?>
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
    <?php } ?>

    // teachers_genders 
    <?php if ($gend_teachers_males || $gend_teachers_females) { ?>
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
    <?php } ?>
    <?php if (!empty($teachers_ages)) { ?>
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
                    formatter: function(val) {
                        return val + " users";
                    }
                }

            },
        }
        var chart_ages = new ApexCharts(document.querySelector("#teachers_ages"), teachers_ages_options);
        chart_ages.render();
    <?php } ?>
    <?php
    $keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($teachers_matural));
    ?>
    <?php if (!empty($teachers_matural)) { ?>
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
    <?php } ?>

    <?php if ($gend_staffs_males > 0 || $gend_staffs_females >  0) { ?>
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
    <?php } ?>

    <?php if (!empty($staffs_ages)) { ?>
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
                    formatter: function(val) {
                        return val + " users";
                    }
                }

            },
        }

        var chart_ages = new ApexCharts(document.querySelector("#staffs_ages"), teachers_ages_options);
        chart_ages.render();
    <?php } ?>


    <?php
    $keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($staffs_matural));
    ?>

    <?php if (!empty($staffs_matural)) { ?>
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
    <?php } ?>

    // Parents 
    <?php if ($gend_parents_males > 0 || $gend_parents_females > 0) { ?>
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
    <?php } ?>

    <?php if (!empty($parents_ages)) { ?>
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
                    formatter: function(val) {
                        return val + " users";
                    }
                }

            },
        }

        var chart_ages = new ApexCharts(document.querySelector("#parents_ages"), parents_ages_options);
        chart_ages.render();
    <?php } ?>
    <?php
    $keys_string = array_map(function ($keyname) {
        return ('"' . $keyname . '"');
    }, array_keys($parents_matural));
    ?>

    <?php if (!empty($parents_matural)) { ?>
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
    <?php } ?>
</script>