<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css"/>
<style>
    .choice {
        margin-top: 10px;
        min-height: 10px;
        color: #fff;
    }

    .start-b-r {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .end-b-r {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .card {
        box-shadow: 0 0px 0px rgb(15 34 58 / 12%);
    }

    .rowOfChoices .choice:last-child {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .rowOfChoices .choice:first-child {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .default-choices-colors .choice:last-child {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .img-icon {
        width: 55px;
        margin-left: 10px;
    }

    .bs-popover-top > .arrow::after,
    .bs-popover-auto[x-placement^="top"] > .arrow::after {
        border-top-color: #0eacd8 !important;
    }

    .popover-body {
        background: #0eacd8 !important;
        color: #fff;
    }

    .popover-header {
        color: #fff;
        background-color: #98d077;
    }

    .choice {
        cursor: pointer;
    }
</style>
<?php
$questions_counter = 0;
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h1 class="card text-center"
                        style="background: #add138; padding: 30px;color: #2E1E1E;border-radius: 20px;"><?= $serv_data['set_name_ar'] ?> </h1>
                    <form class="row" method="post">

                        <div class="col-lg-12 school-select-container">
                            <span class="float-right text-primary btn s-all" data-target-select="schools[]"
                                  style="margin-top: -9px;">جميع المدارس</span>
                            <select name="schools[]" class="form-control select2 school-select" multiple="multiple"
                                    data-placeholder="اختر المدرسة">
                                <?php foreach ($schools as $school) { ?>
                                    <option <?= $filters['schools'] !== null ? (in_array($school['Id'], $filters['schools']) ? "selected" : "") : "selected" ?>
                                            value="<?= $school['Id'] ?>"><?= $school['School_Name_AR'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                        /*<div class="col-lg-12 mt-2 supported-classes-container">
                        <span class="float-right text-primary btn s-all" data-target-select="classes[]" style="margin-top: -9px;">جميع الفصول الدراسية</span>
                        <select name="classes[]" id="supported_classes" class="form-control select2" multiple="multiple" data-placeholder="اختر فصل دراسي">
                            <?php foreach ($classes as $class) { ?>
                                <option <?= $filters['classes'] !== null ? (in_array($class['Id'], gettype($filters['classes']) == "array" ? $filters['classes'] : []) ? "selected" : "") : "" ?> value="<?= $class['Id'] ?>"><?= $class['Class_ar'] ?></option>
                            <?php } ?>
                        </select>
                    </div>*/
                        ?>
                        <div class="col-12">
                            <button class="btn w-100 mt-2 btn-primary">تطبيق</button>
                        </div>
                    </form>
                    <hr>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="background : #98d077;">
                                <div class="card-body">
                                    <h3 class="text-white"><img class="img-icon"
                                                                src="<?= base_url("assets/images/forcharts/Staffs.png") ?>"
                                                                style="width:55px" alt=""> إجابات الموظفين <span
                                                class="float-right"> <?= sizeof($Staffs) ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon"
                                                                src="<?= base_url("assets/images/forcharts/Students.png") ?>"
                                                                style="width:55px" alt=""> إجابات الطلاب <span
                                                class="float-right"><?= sizeof($Students) ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon"
                                                                src="<?= base_url("assets/images/forcharts/Parents.png") ?>"
                                                                style="width:55px" alt=""> إجابات أولياء الأمور <span
                                                class="float-right"><?= sizeof($Parents) ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon"
                                                                src="<?= base_url("assets/images/forcharts/teachers.png") ?>"
                                                                style="width:55px" alt=""> إجابات المعلمين <span
                                                class="float-right"><?= sizeof($Teachers) ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon"
                                                                src="<?= base_url("assets/images/forcharts/male_counter.png") ?>"
                                                                style="width:55px" alt=""> إجابات (الذكور) <span
                                                class="float-right"><?= $males_count ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon"
                                                                src="<?= base_url("assets/images/forcharts/female_counter.png") ?>"
                                                                style="width:55px" alt=""> إجابات (الإناث) <span
                                                class="float-right"><?= $females_count ?> </span></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 px-5 default-choices-colors" style="display: grid;align-items: center;">
                            <div class="row">
                                <?php foreach ($used_choices as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        <?= $used_choice['choices_ar'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($used_choices as $sn => $used_choice) { ?>
                                    <div class="choice col p-2 <?= ($sn == 0 ? 'start-b-r' : '') . (($sn + 1) == sizeof($used_choices) ? "end-b-r" : '') ?>"
                                         style="background-color: <?= $colors[$sn]; ?>"></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($used_choices as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        (<?= !empty($users_passed_survey) ? $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `answers_data_id` IN (" . implode(',', array_column($users_passed_survey, 'answerkey')) . ") AND `choice_id` = '" . $used_choice['Id'] . "'   ")->num_rows() : 0 ?>
                                        )
                                    </div>
                                <?php } ?>
                            </div>
                            <p class="mt-2">عرض النتائج في نطاق التاريخ:
                                من<br><b>From</b>: <?= $serv_data['From_date'] ?> <b>To</b>
                                : <?= $serv_data['To_date'] ?>
                                <br><b>إسم التصنيف:</b> <?= $serv_data['Title_ar'] ?>
                                <br><b>عنوان الإستبيان:</b> <?= $serv_data['set_name_ar'] ?> <br>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="row p-3">
                                        <div class="col-6">
                                            الأسئلة
                                        </div>
                                        <div class="col-6">
                                            نسبة ومعدل الإستجابة (%)
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" role="alert" style="display: none;"></div>
                                    <div id="accordion" class="custom-accordion">
                                        <?php foreach ($used_groups as $group_key => $group_quastion) { ?>
                                            <div class="card mb-1 shadow-none">
                                                <a href="#collapse<?= $group_key; ?>" class="text-dark"
                                                   data-toggle="collapse" aria-expanded="true"
                                                   aria-controls="collapse<?= $group_key; ?>">
                                                    <div class="card-header" id="headingOne">
                                                        <h6 class="m-0">
                                                            <?= $group_quastion['title_ar']; ?>
                                                            <i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapse<?= $group_key; ?>" class="collapse show"
                                                     aria-labelledby="heading<?= $group_key; ?>"
                                                     data-parent="#accordion">
                                                    <div class="card-body">
                                                        <?php
                                                        $questions = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                                                        FROM `sv_st_questions`
                                                        INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                                                        WHERE `sv_st_questions`.`Group_id` = '" . $group_quastion['Id'] . "' ")->result_array();
                                                        ?>
                                                        <?php foreach ($questions as $question_key => $question) { ?>
                                                            <?php $questions_counter++; ?>
                                                            <?php $totalPerc = 0; ?>
                                                            <h3 class="card-title">Q<?= $questions_counter ?>
                                                                . <?= $question['ar_title'] ?>
                                                                <span class="open_more_q float-right"
                                                                      link="<?= base_url('AR/schools/question_detailed_report/' . $serv_id . "/" . $question['q_id'] . "/" . $group_choices . '/' . md5(time())) ?>"
                                                                      target="_blank" rel="noopener noreferrer"><i
                                                                            class="uil uil-analytics"></i></span>
                                                            </h3>
                                                            <div class="row p-2 rowOfChoices">
                                                                <?php if (!empty($users_passed_survey)) { ?>
                                                                    <?php foreach ($choices as $key => $choice) { ?>
                                                                        <?php
                                                                        $use_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "'  AND `answers_data_id` IN (" . implode(',', array_column($users_passed_survey, 'answerkey')) . ")")->num_rows();
                                                                        $all_count = $this->db->query(" SELECT sv_st1_answers_values.Id FROM `sv_st1_answers_values` JOIN sv_st1_answers ON sv_st1_answers.Id = sv_st1_answers_values.answers_data_id WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "' AND sv_st1_answers.serv_id = '" . $serv_data['surveyId'] . "' ")->num_rows();
                                                                        $perc_result = calc_perc($use_count, $all_count);
                                                                        $totalPerc += $perc_result;
                                                                        if ($perc_result > 0) { ?>
                                                                            <div data-container="body"
                                                                                 data-toggle="popover"
                                                                                 data-placement="top"
                                                                                 title="<?= $choice['title_ar']; ?>"
                                                                                 data-content="- <?= $use_count ?>  تمت الإجابة عن طريق هذا الاختيار من المستخدمين <br> - كانت النسبة المئوية للمستخدمين الذين حددوا هذه الإجابة<?= $perc_result ?>% <br> - إجمالي المستخدمين الذين أجابوا على هذا السؤال: <?= $all_count ?>"
                                                                                 class="choice text-center p-2 m-0"
                                                                                 class="choice text-center p-2 m-0 <?= $key == 0 ? 'start-b-r' : '' ?>"
                                                                                 data-width="<?= $perc_result ?>"
                                                                                 style="background-color: <?= $colors[$key]; ?>;width: <?= $perc_result ?>%;"
                                                                                 data-perc-total="<?= $totalPerc ?>">
                                                                                <?= $use_count ?>
                                                                            </div>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <p class="p-2 text-center w-100 bg-warning text-white br-2 rounded">
                                                                        لم يتم العثور على إجابات لهذا الاستطلاع.</p>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($static_questions)) { ?>
                                        <div class="card quastions">
                                            <div class="card-body">
                                                <?php foreach ($static_questions as $question_key => $question) { ?>
                                                    <?php $questions_counter++; ?>
                                                    <?php $totalPerc = 0; ?>
                                                    <h3 class="card-title">Q<?= $questions_counter ?>
                                                        . <?= $question['ar_title'] ?></h3>
                                                    <div class="row p-2 rowOfChoices">
                                                        <?php if (!empty($users_passed_survey)) { ?>
                                                            <?php foreach ($choices as $key => $choice) { ?>
                                                                <?php
                                                                $use_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "'  AND `answers_data_id` IN (" . implode(',', array_column($users_passed_survey, 'answerkey')) . ")")->num_rows();
                                                                $all_count = $this->db->query(" SELECT sv_st1_answers_values.Id FROM `sv_st1_answers_values` JOIN sv_st1_answers ON sv_st1_answers.Id = sv_st1_answers_values.answers_data_id WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "' AND sv_st1_answers.serv_id = '" . $serv_data['surveyId'] . "' ")->num_rows();
                                                                $perc_result = calc_perc($use_count, $all_count); ?>
                                                                <div data-container="body" data-toggle="popover"
                                                                     data-placement="top"
                                                                     data-id="<?= $question['q_id'] . " - " . $choice['Id'] ?>"
                                                                     title="<?= $choice['title_ar']; ?>"
                                                                     data-html="true"
                                                                     data-content="- تمت الإجابة عن طريق هذا الاختيار من المستخدمين <?= $use_count ?> <br> - كانت النسبة المئوية للمستخدمين الذين حددوا هذه الإجابة:  <?= $perc_result ?>% <br> - إجمالي المستخدمين الذين أجابوا على هذا السؤال: <?= $all_count ?>"
                                                                     class="choice text-center p-2 m-0 col text-truncate"
                                                                     style="background-color: <?= $colors[$key]; ?>;"
                                                                     data-perc-total="<?= $totalPerc ?>">
                                                                    <?= $use_count ?> (<?= $perc_result ?>%)
                                                                </div>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <p class="p-2 text-center w-100 bg-warning text-white br-2 rounded">
                                                                لم يتم العثور على إجابات لهذا الاستطلاع.</p>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js") ?>"></script>
<script>
    // $('.rowOfChoices .choice:last-child').each(function() {
    //     var value_is = $(this).attr('data-perc-total');
    //     var width_default = Number($(this).attr('data-width'));
    //     console.log(width_default);
    //     if (value_is > 100) {
    //         var minus = value_is - 101;
    //         $(this).css('width', (width_default - minus) + '%');
    //     }
    //     console.log(value_is);
    // });
    $('.select2').select2({
        closeOnSelect: false,
        allowClear: true
    });
    $('.s-all').click(function () {
        var target = $(this).attr('data-target-select');
        $('select[name="' + target + '"]').select2('destroy').find('option').prop('selected', 'selected').end().select2({
            closeOnSelect: false,
            allowClear: true
        });
    });
    // $('.school-select').change(function() {
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url('EN/DashboardSystem/supported_school_classes') ?>",
    //         data: {
    //             school_id: $(this).val(),
    //         },
    //         success: function(response) {
    //         }
    //     });
    // });
</script>
<?php
function calc_perc($perc, $all)
{
    $x = $perc;
    $y = $all;
    if ($x > 0 && $y > 0) {
        $percent = $x / $y;
        $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
    } else {
        $percent_friendly = 0;
    }
    return $percent_friendly;
} ?>