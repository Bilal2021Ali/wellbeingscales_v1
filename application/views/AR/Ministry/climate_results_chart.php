<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<style>
    .choice {
        margin-top: 10px;
        min-height: 10px;
        color: #fff;
    }

    .start-b-r {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .end-b-r {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .card {
        box-shadow: 0 0px 0px rgb(15 34 58 / 12%);
    }

    .rowOfChoices .choice:first-child {
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .rowOfChoices .choice:last-child {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .default-choices-colors .choice:last-child {
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .img-icon {
        width: 55px;
        margin-right: 10px;
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
<?php $questions_counter = 0; ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h1 class="card text-center" style="background: #add138; padding: 30px;color: #2E1E1E;border-radius: 20px;"><?= $survey_data->set_name_en ?> </h1>
                    <hr>
                    <p><?= $serv_data['reference'] ?? "--" ?></p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card" style="background : #98d077;">
                                <div class="card-body">
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Respondents.png") ?>" alt=""> Total Respondents <span class="float-right"><?= sizeof($users_passed_survey); ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/male_counter.png") ?>" alt=""> Male Respondents <span class="float-right"><?= sizeof($Males) ?> </span></h3>
                                    <h3 class="mb-0 text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/female_counter.png") ?>" alt=""> Female Respondents <span class="float-right"><?= sizeof($Females) ?> </span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" style="background : #98d077;">
                                <div class="card-body">
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Staffs.png") ?>" style="width:55px" alt=""> Staff Respondents <span class="float-right"> <?= sizeof($Staffs) ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Students.png") ?>" style="width:55px" alt=""> Student Respondents <span class="float-right"><?= sizeof($Students) ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Parents.png") ?>" style="width:55px" alt=""> Parent Respondents <span class="float-right"><?= sizeof($Parents) ?> </span></h3>
                                    <h3 class="mb-0 text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/teachers.png") ?>" style="width:55px" alt=""> Teacher Respondents <span class="float-right"><?= sizeof($Teachers) ?> </span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 px-5 default-choices-colors" style="display: grid;align-items: center;">
                            <div class="row">
                                <?php foreach ($users_passed_survey as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        <?= $used_choice['title_en'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($users_passed_survey as $sn => $used_choice) { ?>
                                    <div class="choice col p-2 <?= $sn == 0 ? 'start-b-r' : '' ?>" style="background-color: <?= $colors[$sn]; ?>"></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($users_passed_survey as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        <?= $used_choice['ChooseingTimes'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <p class="mt-2">Showing results on the date range: <br><b>From</b>: <?= $survey_data->from_date ?> <b>To</b> : <?= $survey_data->to_date ?>
                                <br><b>Category Name:</b> <?= $survey_data->Cat_en ?>
                                <br><b>Survey Name:</b> <?= $survey_data->set_name_en ?> <br>
                                <br><h3> Question : <?= $survey_data->question ?></h3> <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js") ?>"></script>
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