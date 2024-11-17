<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url("assets/sv_themes/css/" . $serv_theme) ?>.css">
    <style>
        .quastions-title {
            background-color: rgb(255 235 59 / 13%);
        }

        .downBar {
            width: 100%;
            height: 0vh;
            position: fixed;
            z-index: 10000;
            background: #fff;
            bottom: 0px;
            transition: 0.5s all;
            -webkit-box-shadow: -2px -19px 49px -32px rgba(0, 0, 0, 0.87);
            -moz-box-shadow: -2px -19px 49px -32px rgba(0, 0, 0, 0.87);
            box-shadow: -2px -19px 49px -32px rgba(0, 0, 0, 0.87);
            overflow: auto;
        }

        .downBar.Show {
            transition: 0.5s all;
            height: 80vh;
        }

        .page-content {
            transition: 0.6s all;
        }

        .blured {
            filter: blur(2px);
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
            margin: auto;
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #0eabd7;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #14add8 transparent transparent transparent;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading_data {
            width: 100%;
            height: 100%;
            display: grid;
            align-items: center;
            align-content: center;
            text-align: center;
        }

        .downBar .header {
            width: 100%;
            height: 30px;
            align-items: center;
            display: grid;
            padding: 10px;
            cursor: pointer;
            font-size: 20px;
            position: fixed;
            z-index: 10000;
            background: #fff;
            border-bottom: 1px solid rgb(0 0 0 / 9%);
            padding-bottom: 30px;
        }


        .open_more_q,
        .open_moreD {
            cursor: pointer;
        }

        .custom-control.mr-2 .uil-check-circle {
            font-size: 20px;
            float: left;
            margin-right: 10px;
            margin-left: -10px;
        }
    </style>
</head>
<?php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https:/" : "http:/";
$CurPageURL = $protocol . "/" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$questions_counter = 0;
?>

<body>
    <div class="main-content">
        <div class="page-content">
            <form token="<?= md5(time()); ?>" method="post">
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-12 ">
                            <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 077 Survey V-Report</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-danger" role="alert" style="display: none;"></div>
                                    <div id="accordion" class="custom-accordion">
                                        <?php foreach ($used_groups as $group_key => $group_quastion) {  ?>
                                            <div class="card mb-1 shadow-none">
                                                <a href="#collapse<?= $group_key; ?>" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $group_key; ?>">
                                                    <div class="card-header" id="headingOne">
                                                        <h6 class="m-0">
                                                            <?= $group_quastion['title_en']; ?>
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
                                                        WHERE `sv_st_questions`.`Group_id` = '" . $group_quastion['Id'] . "' 
                                                        ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                                                        ?>
                                                        <?php foreach ($questions as $question_key => $question) { ?>
                                                            <?php $questions_counter++; ?>
                                                            <div class="card col">
                                                                <div class="card-body quastions-title">
                                                                    <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title'] ?>
                                                                        <span class="open_more_q float-right" link="<?= base_url('EN' . (isset($fromMinistry) ? "/DashboardSystem/school_question_detailed_report/" : "/schools/question_detailed_report/") . $serv_id . "/" . $question['q_id'] . "/" . $group_choices . '/' . md5(time())) ?>" target="_blank" rel="noopener noreferrer"><i class="uil uil-analytics"></i></span>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="row px-2">
                                                                <?php foreach ($choices as $key => $choice) { ?>
                                                                    <?php
                                                                    $use_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "' AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ") ")->num_rows();
                                                                    $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "'  AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ") ")->num_rows();
                                                                    ?>
                                                                    <div class="card col">
                                                                        <div class="card-body">
                                                                            <div class="mr-2">
                                                                                <label><?= $choice['title_en'] ?>(<?= calc_perc($use_count, $all_count); ?>)</label>
                                                                                <span class="open_moreD" link="<?= base_url('EN' . (isset($fromMinistry) ? "/DashboardSystem/schools_question_choice_report/" : "/schools/question_choice_report/") . $serv_id . "/" . $choice['Id'] . "/" . $question['q_id'] . "/"  . calc_perc($use_count, $all_count) . '/' . md5(time())) ?>" target="_blank" rel="noopener noreferrer">
                                                                                    <i class="uil uil-arrow-up-right"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
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
                                                    <div class="card">
                                                        <div class="card-body quastions-title">
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title'] ?>
                                                                <span class="open_more_q float-right" link="<?= base_url('EN' . (isset($fromMinistry) ? "/DashboardSystem/school_question_detailed_report/" : "/schools/question_detailed_report/") . $serv_id . "/" . $question['q_id'] . "/" . $group_choices . '/' . md5(time())) ?>" target="_blank" rel="noopener noreferrer"><i class="uil uil-analytics"></i></span>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="row px-2">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <?php
                                                            $use_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "' AND `choice_id` = '" . $choice['Id'] . "'  AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ") ")->num_rows();
                                                            $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question['q_id'] . "'   AND `answers_data_id` IN (" . implode(',',  array_column($users_passed_survey, 'answerKey')) . ") ")->num_rows();
                                                            ?>
                                                            <div class="card col">
                                                                <div class="card-body">
                                                                    <div class="mr-2">
                                                                        <label><?= $choice['title_en'] ?>(<?= calc_perc($use_count, $all_count); ?>)</label>
                                                                        <span class="open_moreD" link="<?= base_url('EN' . (isset($fromMinistry) ? "/DashboardSystem/schools_question_choice_report/" : "/schools/question_choice_report/") . $serv_id . "/" . $choice['Id'] . "/" . $question['q_id'] . "/"  . calc_perc($use_count, $all_count) . '/' . md5(time())) ?>" target="_blank" rel="noopener noreferrer">
                                                                            <i class="uil uil-arrow-up-right"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="choices" value="<?= $questions_counter; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="downBar">
        <div class="header">
            <i class="uil uil-multiply close_down"></i>
            <p style="margin: auto;width : 90%;margin-top: -25px;" class="text-center">More Detailed Report</p>
        </div>
        <div class="content"></div>
    </div>
</body>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script>
    $("#my_answers").on('submit', function(e) {
        e.preventDefault();
        alert('Sorry you cannot complete this survey');
    });

    $('.open_moreD').each(function() {
        $(this).click(function() {
            var loader = '<div class="loading_data"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>';
            var tolink = $(this).attr('link');
            $('.downBar .content').html(loader);
            $('.downBar').toggleClass('Show');
            $('.main-content').toggleClass('blured');
            $('.vertical-menu').toggleClass('blured');
            $('#page-topbar').toggleClass('blured');
            $.ajax({
                type: 'GET',
                url: tolink,
                success: function(data) {
                    $('.downBar .content').html(data);
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
        });
    });

    $('.open_more_q').each(function() {
        $(this).click(function() {
            var loader = '<div class="loading_data"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>';
            var tolink = $(this).attr('link');
            $('.downBar .content').html(loader);
            $('.downBar').toggleClass('Show');
            $('.main-content').toggleClass('blured');
            $('.vertical-menu').toggleClass('blured');
            $('#page-topbar').toggleClass('blured');
            $.ajax({
                type: 'GET',
                url: tolink,
                success: function(data) {
                    $('.downBar .content').html(data);
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
        });
    });

    $('.close_down').click(function() {
        $('.downBar').toggleClass('Show');
        $('.main-content').toggleClass('blured');
        $('.vertical-menu').toggleClass('blured');
        $('#page-topbar').toggleClass('blured');
    });
</script>

</html>
<?php
function calc_perc($perc, $all)
{
    $x = $perc;
    $y = $all;
    if ($x !== 0 && $y !== 0) {
        $percent = $x / $y;
        $percent_friendly = number_format($percent * 100, 2 - 1); // change 2 to # of decimals
    } else {
        $percent_friendly = 0;
    }
    return $percent_friendly;
}
?>