<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .quastions-title {
            background-color: rgb(255 235 59 / 13%);
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
                                    <div class="col-lg-12 bg-success" style="height: 60px;border-radius: 4px;">
                                        <p class="text-white text-center mt-3">هذا القسم يحتوي على صورة</p>
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
                                        <div class="col-lg-6">
                                            <h3>إسم المشارك في الإستبيان</h3><br>
                                            <p class="text-muted col-12 p-0">أهلا وسهلا بكم في هذا الإستبيان.</p>
                                            <span>
                                                <div class="custom-control custom-checkbox mb-4">
                                                    <input type="checkbox" name="showname" checked class="custom-control-input" id="horizontal-customCheck">
                                                    <label class="custom-control-label" for="horizontal-customCheck">عرض الإسم. مع نتيجة الإستبيان </label>
                                                </div>
                                            </span>
                                        </div>
                                        <hr class="w-100">
                                        <div class="col-lg-6">
                                            <h6>فئة :</h6>
                                            <p><?= $serv_data[0]['Title_ar'] ?></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h6>عنوان التقييم :</h6>
                                            <p><?= $serv_data[0]['set_name_ar'] ?></p>
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
                                                WHERE `sv_st_questions`.`Group_id` = '" . $group_quastion['Id'] . "' ")->result_array();
                                                ?>
                                                <?php foreach ($questions as $question_key => $question) { ?>
                                                    <?php $questions_counter++; ?>
                                                    <div class="card">
                                                        <div class="card-body quastions-title">
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['ar_title'] ?> <span class="text-danger">*</span></h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="col col-xs-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="custom-control custom-radio mr-2">
                                                                            <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter ?>" value="<?= $choice['Id'] . '_' . $question['Id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
                                                                            <label class="custom-control-label" for="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter;  ?>"><?= $choice['title_ar'] ?></label>
                                                                        </div>
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
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['ar_title'] ?></h3>
                                                        </div>
                                                    </div>

                                                    <div class="row justify-center">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="col col-xs-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="custom-control custom-radio mr-2">
                                                                            <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>" value="<?= $choice['Id'] . '_' . $question['Id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
                                                                            <label class="custom-control-label" for="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>"><?= $choice['title_ar'] ?></label>
                                                                        </div>
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
                                    <button class="btn btn-primary  waves-effect waves-light" type="Submit"> إبعث الإجابات </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="container">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3>Thank you!</h3><br>
                                        <p class="text-muted">We appreciate your time in completing this survey. </p>
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
        alert('Sorry you cant cmplete this survey');
    });
</script>

</html>