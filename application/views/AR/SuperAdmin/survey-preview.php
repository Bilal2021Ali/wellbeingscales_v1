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
$answerPlaceholder = $activeLanguage == "en" ? "answer" : "الاجابة";
?>

<style>
    .lang-btn:hover {
        transform: scale(1);
    }

    .lang-btn {
        transition: 0.5s all;
        transform: scale(0.7);
        position: fixed !important;
        bottom: 10px;
        left: 10px;
        z-index: 10000;
    }
</style>

<body>
    <div class="page-content">
        <a href="<?= $activeLanguage == "en" ? "ar" : "en" ?>" class="btn btn-warning waves-effect waves-light btn-rounded lang-btn shadow">Change To The <?= $activeLanguage == "en" ? "AR" : "EN" ?> Version</a>
        <div class="row">
            <div class="container">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <img src="<?= base_url("assets/images/invoice_logo.png") ?>" alt="">
                                </div>
                                <hr class="w-100">
                                <div class="col-lg-6">
                                    <h6><?= $activeLanguage == "en"  ? "Category:" : "فئة:" ?></h6>
                                    <p><?= $serv_data[0]['Title_' . $activeLanguage] ?></p>
                                </div>
                                <div class="col-lg-6">
                                    <h6><?= $activeLanguage == "en"  ? "Assessment Title :" : "عنوان التقييم:" ?></h6>
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
                                        <h3><?= $activeLanguage == "en"  ? "Reference:" : "مرجع:" ?> </h3><br>
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
                                        <h3><?= $activeLanguage == "en"  ? "Instructions:" : "تعليمات:" ?></h3><br>
                                        <p class="text-muted col-12 p-0 w-100" style="overflow : auto"><?= $serv_data[0]['Message'] ?></p>
                                        <hr>
                                        <span>
                                            <div class="custom-control custom-checkbox mb-4">
                                                <input type="checkbox" name="showname" checked class="custom-control-input" id="horizontal-customCheck">
                                                <label class="custom-control-label" for="horizontal-customCheck"><?= $activeLanguage == "en"  ? "Show my name with my responses.:" : "أظهر اسمي مع إجاباتي:" ?> </label>
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
                                                        <h3 class="card-title"><?= $questions_counter ?> . <?= $question[$activeLanguage . '_title'] ?> <span class="text-danger">*</span></h3>
                                                    </div>
                                                </div>
                                                <?php if ($type == "choices") { ?>
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
                                                <?php } else { ?>
                                                    <input type="text" autocomplete="off" data-parsley-minlength="3" data-parsley-maxlength="50" required class="form-control mb-2" placeholder="<?= $answerPlaceholder ?>">
                                                <?php }  ?>
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
                                                        <h3 class="card-title"><?= $questions_counter ?> . <?= $question[$activeLanguage . '_title'] ?> <span class="text-danger">*</span></h3>
                                                    </div>
                                                </div>
                                                <?php if ($type == "choices") { ?>
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
                                                <?php } else { ?>
                                                    <input type="text" autocomplete="off" data-parsley-minlength="3" data-parsley-maxlength="50" required class="form-control mb-2" placeholder="<?= $answerPlaceholder ?>">
                                                <?php }  ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="choices" value="<?= $questions_counter; ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title"><?= $activeLanguage == "en"  ? "Informed Consent:" : "موافقة مسبقة:" ?>
                                            <hr>
                                        </h3>
                                        <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                            <input class="custom-control-input chkbox" class="agree" type="checkbox" id="agree_1">
                                            <label class="custom-control-label" for="agree_1">
                                                <?php if ($activeLanguage == "en") { ?>
                                                    I agree to the terms and conditions set forth by QlickHealth and its partners. I do not hold QlickHealth and the scale developers liable for any loss or harm resulting from the administration of this assessment
                                                <?php } else { ?>
                                                    أوافق على الشروط والأحكام المنصوص عليها من قبل QlickHealth وشركائها. لا أحمل شركة QlickHealth ومطوري الميزان المسؤولية عن أي خسارة أو ضرر ناتج عن إدارة هذا التقييم
                                                <?php }  ?>
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                            <input class="custom-control-input chkbox" class="agree" type="checkbox" id="agree_2">
                                            <label class="custom-control-label" for="agree_2">
                                                <?php if ($activeLanguage == "en") { ?>
                                                    I grant QlickHealth the right to use and share my responses and the data incurred from the questionnaire with healthcare professionals and researchers for research purposes, plans of action, and interventions.
                                                <?php } else { ?>
                                                    أمنح QlickHealth الحق في استخدام ومشاركة إجاباتي والبيانات التي تم الحصول عليها من الاستبيان مع المتخصصين في الرعاية الصحية والباحثين لأغراض البحث وخطط العمل والتدخلات.
                                                <?php }  ?>
                                            </label>
                                        </div>
                                        <hr>
                                        <?php if ($activeLanguage == "en") { ?>
                                            <h6 class="mt-2"><b>By ticking the boxes, you are attesting that you have read and understood the information presented above.</b></h6>
                                        <?php } else { ?>
                                            من خلال تحديد المربعات ، فإنك تقر بأنك قد قرأت وفهمت المعلومات الواردة أعلاه.
                                        <?php }  ?>
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
                                    <h3><?= $activeLanguage == "en"  ? "Disclaimer:" : "إخلاء المسؤولية:" ?> </h3><br>
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
                                    <h3><?= $activeLanguage == "en"  ? "Thank you!" : "شكرا !" ?></h3><br>
                                    <p class="text-muted"><?= $activeLanguage == "en"  ? "We appreciate your time in completing this survey." : "نحن نقدر وقتك في استكمال هذا الاستطلاع" ?></p>
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