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
                    <h1 class="card text-center" style="background: #add138; padding: 30px;color: #2E1E1E;border-radius: 20px;"><?= $serv_data['set_name_en'] ?> </h1>
                    <form class="row" method="post">
                        <label class="pl-2">Filters :</label>
                        <div class="col-lg-12 school-select-container">
                            <span class="float-right text-primary btn s-all" data-target-select="schools[]" style="margin-top: -9px;">Select all</span>
                            <select name="schools[]" class="form-control select2 school-select" multiple="multiple" data-placeholder="Select Schools">
                                <option value="">Select A School</option>
                                <?php foreach ($schools as $school) { ?>
                                    <option <?= $filters['schools'] !== null ?  (in_array($school['Id'], $filters['schools']) ? "selected" : "") : "" ?> value="<?= $school['Id'] ?>"><?= $school['School_Name_EN'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-2 supported-classes-container">
                            <span class="float-right text-primary btn s-all" data-target-select="classes[]" style="margin-top: -9px;">Select all</span>
                            <select name="classes[]" id="supported_classes" class="form-control select2" multiple="multiple" data-placeholder="Select Classes">
                                <option value="">Select A Class</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option <?= $filters['classes'] !== null ? (in_array($class['Id'], gettype($filters['classes']) == "array" ? $filters['classes'] : []) ? "selected" : "") : "" ?> value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn w-100 mt-2 btn-primary">Apply</button>
                        </div>
                    </form>
                    <hr>
                    <p><?= $serv_data['reference'] ?></p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card" style="background : #98d077;">
                                <div class="card-body">
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Respondents.png") ?>" alt=""> Total Respondents <span class="float-right"><?= sizeof($users_passed_survey); ?> </span></h3>
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/Time.png") ?>" alt=""> Average Time <span class="float-right"><?= $finishing_time_all ?></span></h3>
                                    <h3 class="text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/male_counter.png") ?>" alt=""> Male Respondents <span class="float-right"><?= $males_count ?> </span></h3>
                                    <h3 class="mb-0 text-white"><img class="img-icon" src="<?= base_url("assets/images/forcharts/female_counter.png") ?>" alt=""> Female Respondents <span class="float-right"><?= $females_count ?> </span></h3>
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
                                <?php foreach ($used_choices as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        <?= $used_choice['choices_en'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($used_choices as $sn => $used_choice) { ?>
                                    <div class="choice col p-2 <?= $sn == 0 ? 'start-b-r' : '' ?>" style="background-color: <?= $colors[$sn]; ?>"></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($used_choices as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        (<?= !empty($users_passed_survey) ?  $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerkey')) . ") AND `choice_id` = '" . $used_choice['Id'] . "'   ")->num_rows() : 0 ?>)
                                    </div>
                                <?php } ?>
                            </div>
                            <p class="mt-2">Showing results on the date range: <br><b>From</b>: <?= $serv_data['From_date'] ?> <b>To</b> : <?= $serv_data['To_date'] ?>
                                <br><b>Category Name:</b> <?= $serv_data['Title_en'] ?>
                                <br><b>Survey Name:</b> <?= $serv_data['set_name_en'] ?> <br>
                            </p>
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