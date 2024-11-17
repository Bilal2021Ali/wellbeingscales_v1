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

        * {
            text-transform: inherit !important;
        }

        .choisesContainer {
            display: flex;
            justify-content: space-around;
            flex-wrap: nowrap;
            flex-direction: row;
            align-items: center;
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
            <div class="row">
                <div class="container">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <img src="<?= base_url("assets/sv_themes/images/" . $serv_img) ?>.png" alt="">
                                    </div>
                                    <hr class="w-100">
                                    <div class="col-lg-6">
                                        <h6>Category :</h6>
                                        <p><?= $serv_data[0]['Title_en'] ?></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6>Assessment Title :</h6>
                                        <p><?= $serv_data[0]['set_name_en'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="my_answers" token="<?= md5(time()); ?>" method="post">
                <div class="row">
                    <div class="container">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Reference: </h3><br>
                                            <p class="text-muted col-12 p-0 w-100" style="overflow : auto"><?= $serv_data[0]['reference_en'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Instructions: </h3><br>
                                            <p class="text-muted col-12 p-0 w-100" style="overflow : auto"><?= $serv_data[0]['Message'] ?></p>
                                            <hr>
                                            <span>
                                                <div class="custom-control custom-checkbox mb-4">
                                                    <input type="checkbox" name="showname" checked class="custom-control-input" id="horizontal-customCheck">
                                                    <label class="custom-control-label" for="horizontal-customCheck">Show my name with my responses. </label>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div class="col-12 ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-danger" role="alert" style="display: none;"></div>
                                    <?php foreach ($used_groups as $group_key => $group_quastion) {  ?>
                                        <div class="card quastions">
                                            <div class="card-body">
                                                <h4 class="card-title mb-3"><?= $group_quastion['title_en']; ?></h4>
                                                <?php
                                                $questions = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                                                FROM `sv_st_questions`
                                                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                                                WHERE `sv_st_questions`.`Group_id` = '" . $group_quastion['Id'] . "' 
                                                ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                                                ?>
                                                <?php foreach ($questions as $question_key => $question) { ?>
                                                    <?php $questions_counter++; ?>
                                                    <div class="card">
                                                        <div class="card-body quastions-title">
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title'] ?> <span class="text-danger">*</span></h3>
                                                        </div>
                                                    </div>
                                                    <div class="row choisesContainer px-2">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="card col">
                                                                <div class="card-body">
                                                                    <div class="custom-control custom-radio mr-2">
                                                                        <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter ?>" value="<?= $choice['Id'] . '_' . $question['Id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
                                                                        <label class="custom-control-label" for="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter;  ?>"><?= $choice['title_en'] ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>

                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php  }  ?>
                                    <?php if (!empty($static_questions)) { ?>
                                        <div class="card quastions">
                                            <div class="card-body">
                                                <?php foreach ($static_questions as $question_key => $question) { ?>
                                                    <?php $questions_counter++; ?>
                                                    <div class="card">
                                                        <div class="card-body quastions-title">
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title'] ?> <span class="text-danger">*</span></h3>
                                                        </div>
                                                    </div>

                                                    <div class="row choisesContainer px-2">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="card col">
                                                                <div class="card-body">
                                                                    <div class="custom-control custom-radio mr-2">
                                                                        <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>" value="<?= $choice['Id'] . '_' . $question['Id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
                                                                        <label class="custom-control-label" for="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>"><?= $choice['title_en'] ?></label>
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
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title">Informed Consent:
                                                <hr>
                                            </h3>
                                            <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                                <input class="custom-control-input chkbox" class="agree" type="checkbox" id="agree_1">
                                                <label class="custom-control-label" for="agree_1">
                                                    I agree to the terms and conditions set forth by QlickHealth and its partners. I do not hold QlickHealth and the scale developers liable for any loss or harm resulting from the administration of this assessment
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                                <input class="custom-control-input chkbox" class="agree" type="checkbox" id="agree_2">
                                                <label class="custom-control-label" for="agree_2">
                                                    I grant QlickHealth the right to use and share my responses and the data incurred from the questionnaire with healthcare professionals and researchers for research purposes, plans of action, and interventions.
                                                </label>
                                            </div>
                                            <hr>
                                            <h6 class="mt-2"><b>By ticking the boxes, you are attesting that you have read and understood the information presented above.</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Disclaimer : </h3><br>
                                        <p class="text-muted col-12 p-0"><?= $serv_data[0]['disclaimer_en'] ?? "--" ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3>Thank you!</h3><br>
                                        <p class="text-muted">We appreciate your time in completing this survey.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
<script>
    $("#my_answers").on('submit', function(e) {
        e.preventDefault();
        alert('Sorry you cant complete this survey');
    });
</script>

</html>