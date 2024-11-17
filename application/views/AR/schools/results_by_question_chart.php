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

    .bs-popover-top>.arrow::after,
    .bs-popover-auto[x-placement^="top"]>.arrow::after {
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
                    <h5 class="card text-center" style="background: #add138; padding: 30px;color: #2E1E1E;border-radius: 20px;"><?= $serv_data['set_name_ar'] ?> </h5>
                    <hr>
                    <p><?= $serv_data['reference'] ?></p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card" style="background : #98d077;">
                                <div class="card-body">
                                    <p class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Respondents.png") ?>" alt=""> مجموع المستجيبين <span class="float-right"><?= sizeof($users_passed_survey); ?> </span></p>
                                    <p class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Time.png") ?>" alt=""> الوقت <span class="float-right"><?= $finishing_time_all ?></span></p>
                                    <p class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/male_counter.png") ?>" alt=""> إجابات الذكور<span class="float-right"><?= $males_count ?> </span></p>
                                    <p class="mb-0 text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/female_counter.png") ?>" alt="">إجابات الإناث <span class="float-right"><?= $females_count ?> </span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" style="background : #98d077;">
                                <div class="card-body">
                                    <p class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Staffs.png") ?>" style="width:55px" alt=""> إجابات الموظفين <span class="float-right"> <?= sizeof($Staffs) ?> </span></p>
                                    <p class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Students.png") ?>" style="width:55px" alt="">إجابات الطلاب <span class="float-right"><?= sizeof($Students) ?> </span></p>
                                    <p class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Parents.png") ?>" style="width:55px" alt="">إجابات أولياء الأمور <span class="float-right"><?= sizeof($Parents) ?> </span></p>
                                    <p class="mb-0 text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/teachers.png") ?>" style="width:55px" alt=""> إجابات المعلمين <span class="float-right"><?= sizeof($Teachers) ?> </span></p>
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
                                    <div class="choice p-2 col <?= $sn == 0 ? 'start-b-r' : "" ?>" style="background-color: <?= $colors[$sn]; ?>;"></div>
                                <?php } ?>
                            </div>
                            <p class="mt-2">عرض النتائج في نطاق التاريخ: من</b> : <?= $serv_data['From_date'] ?> <b>إلى</b> : <?= $serv_data['To_date'] ?>
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
                                        <?php foreach ($used_groups as $group_key => $group_quastion) {  ?>
                                            <div class="card mb-1 shadow-none">
                                                <a href="#collapse<?= $group_key; ?>" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $group_key; ?>">
                                                    <div class="card-header" id="headingOne">
                                                        <h6 class="m-0">
                                                            <?= $group_quastion['title_ar']; ?>
                                                            <i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                                        </h6>
                                                    </div>
                                                </a>

                                                <div id="collapse<?= $group_key; ?>" class="collapse show" aria-labelledby="heading<?= $group_key; ?>" data-parent="#accordion">
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
                                                            <h3 class="card-title">Q<?= $questions_counter ?>. <?= $question['ar_title'] ?>
                                                                <span class="open_more_q float-right" link="<?= base_url('AR/schools/question_detailed_report/' . $serv_id . "/" . $question['q_id'] . "/" . $group_choices . '/' . md5(time())) ?>" target="_blank" rel="noopener noreferrer"><i class="uil uil-analytics"></i></span>
                                                            </h3>
                                                            <div class="row p-2 rowOfChoices">
                                                                <?php if (!empty($users_passed_survey)) { ?>
                                                                    <?php foreach ($choices as $key => $choice) { ?>
                                                                        <?php
                                                                        $use_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "'  AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ")")->num_rows();
                                                                        $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "'  AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ") ")->num_rows();
                                                                        $perc_result = calc_perc($use_count, $all_count);
                                                                        $totalPerc += $perc_result;  ?>
                                                                        <div data-container="body" data-toggle="popover" data-placement="top" title="<?= $choice['choices_ar'];  ?>" data-content="- <?= $use_count ?> تمت الإجابة عن طريق هذا الاختيار من المستخدمين <br> - كانت النسبة المئوية للمستخدمين الذين حددوا هذه الإجابة<?= $perc_result ?>% <br> - إجمالي المستخدمين الذين أجابوا على هذا السؤال: <?= $all_count ?>" class="choice text-center col text-truncate p-2 m-0 <?= $key == 0 ? 'start-b-r' : '' ?>" data-width="<?= $perc_result ?>" style="background-color: <?= $colors[$key]; ?>;width: <?= $perc_result ?>%;" data-perc-total="<?= $totalPerc ?>">
                                                                            <?= $use_count ?> (<?= $perc_result ?>%)
                                                                        </div>
                                                                    <?php } ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <p class="p-2 text-center w-100 bg-warning text-white br-2 rounded">لم يتم العثور على إجابات لهذا الاستطلاع.</p>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php  }  ?>
                                    </div>
                                    <?php if (!empty($static_questions)) { ?>
                                        <div class="card quastions">
                                            <div class="card-body">
                                                <?php foreach ($static_questions as $question_key => $question) { ?>
                                                    <?php $questions_counter++; ?>
                                                    <?php $totalPerc = 0; ?>
                                                    <h3 class="card-title">Q<?= $questions_counter ?>. <?= $question['ar_title'] ?></h3>
                                                    <div class="row p-2 rowOfChoices">
                                                        <?php if (!empty($users_passed_survey)) { ?>
                                                            <?php foreach ($choices as $key => $choice) { ?>
                                                                <?php
                                                                $use_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "'  AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ")")->num_rows();
                                                                $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "'  AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ") ")->num_rows();
                                                                $perc_result = calc_perc($use_count, $all_count);
                                                                $totalPerc += $perc_result; ?>
                                                                <div data-container="body" data-toggle="popover" data-placement="top" title="<?= $choice['title_ar'];  ?>" data-html="true" data-content="- <?= $use_count ?> تمت الإجابة عن طريق هذا الاختيار من المستخدمين <br> - كانت النسبة المئوية للمستخدمين الذين حددوا هذه الإجابة<?= $perc_result ?>% <br> -إجمالي المستخدمين الذين أجابوا على هذا السؤال:  <?= $all_count ?>" class="choice text-center col text-truncate p-2 m-0" style="background-color: <?= $colors[$key]; ?>" data-width="<?= $perc_result ?>" data-perc-total="<?= $totalPerc ?>">
                                                                    <?= $use_count ?>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <p class="p-2 text-center w-100 bg-warning text-white br-2 rounded">لم يتم العثور على إجابات لهذا الاستطلاع.</p>
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
<script>
    // $('.rowOfChoices .choice:last-child').each(function() {
    //     var value_is = $(this).attr('data-perc-total');
    //     var width_default = Number($(this).attr('data-width'));
    //     console.log(width_default);
    //     if (value_is > 100) {
    //         var minus = value_is - 100;
    //         $(this).css('width', (width_default - minus) + '%');
    //     }
    //     // console.log(value_is);
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