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
                                        <h6>الفئة:</h6>
                                        <p><?= $serv_data[0]['Title_ar'] ?></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6>عنوان التقييم:</h6>
                                        <p><?= $serv_data[0]['set_name_ar'] ?></p>
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
                                            <h3>المرجعي: </h3><br>
                                            <p class="text-muted col-12 p-0"><?= $serv_data[0]['reference_ar'] ?></p>
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
                                            <h3>تعليمات: </h3><br>
                                            <p class="text-muted col-12 p-0"><?= $serv_data[0]['Message'] ?></p>
                                            <hr>
                                            <span>
                                                <div class="custom-control custom-checkbox mb-4">
                                                    <input type="checkbox" name="showname" checked class="custom-control-input" id="horizontal-customCheck">
                                                    <label class="custom-control-label" for="horizontal-customCheck">أظهر اسمي مع الإجابات.</label>
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
                                                <h4 class="card-title mb-3"><?= $group_quastion['title_ar']; ?></h4>
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
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= ucfirst(strtolower($question['ar_title'])) ?> <span class="text-danger">*</span></h3>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-center">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="col ml-2 col-XS-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="custom-control custom-radio mr-2">
                                                                            <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter ?>" value="<?= $choice['Id'] . '_' . $question['Id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
                                                                            <label class="custom-control-label" for="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter;  ?>"><?= $choice['title'] ?></label>
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
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= ucfirst(strtolower($question['ar_title'])) ?> <span class="text-danger">*</span></h3>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-center">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="col col-xs-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="custom-control custom-radio mr-2">
                                                                            <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>" value="<?= $choice['Id'] . '_' . $question['Id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
                                                                            <label class="custom-control-label" for="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>"><?= $choice['title'] ?></label>
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
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title">موافقة مسبقة:
                                                <hr>
                                            </h3>
                                            <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                                <input class="custom-control-input chkbox" class="agree" type="checkbox" id="agree_1">
                                                <label class="custom-control-label" for="agree_1">
                                                    أوافق على الشروط والأحكام المنصوص عليها من قبل QlickHealth وشركائها. لا أحمل شركة QlickHealth ومطوري الميزان المسؤولية عن أي خسارة أو ضرر ناتج عن إدارة هذا التقييم.
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                                <input class="custom-control-input chkbox" class="agree" type="checkbox" id="agree_2">
                                                <label class="custom-control-label" for="agree_2">
                                                    أمنح QlickHealth الحق في استخدام ومشاركة إجاباتي والبيانات التي تم الحصول عليها من الاستبيان مع المتخصصين في الرعاية الصحية والباحثين لأغراض البحث وخطط العمل والتدخلات.
                                                </label>
                                            </div>
                                            <hr>
                                            <h6 class="mt-2"><b>من خلال تحديد المربعات ، فإنك تقر بأنك قد قرأت وفهمت المعلومات الواردة أعلاه.</b></h6>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary  waves-effect waves-light" type="Submit" disabled="disabled" >إرسال الإجابات</button>
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
                                        <h3> إخلاء المسؤولية:</h3><br>
                                        <p class="text-muted col-12 p-0"><?= $serv_data[0]['disclaimer_ar'] ?></p>
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
                                        <h3>شكرا لك</h3><br>
                                        <p class="text-muted">نحن نقدر وقتك في استكمال هذا الاستطلاع.</p>
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
        $('input[type="checkbox"]').each(function() {
        $(this).change(function() {
            if ($('#agree_1').is(':checked') && $('#agree_2').is(':checked')) {
                $('button[type="submit"]').removeAttr('disabled');
            } else {
                $('button[type="submit"]').attr('disabled', 'disabled');
            }
        });
    });

    $("#my_answers").on('submit', function(e) {
        e.preventDefault();
        console.log(new FormData(this));
        $.ajax({
            type: 'POST',
            url: '<?= $CurPageURL ?>?serv=<?= $serv_id; ?>&time=<?= date('H:i:s'); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.alert').slideUp();
                $('button[type="Submit"]').attr('disabled', '');
                $('button[type="Submit"]').html("ارجوك انتظر...");
            },
            success: function(data) {
                if (data !== "ok") {
                    $('.alert').slideDown();
                    $('.alert').html(data.message);
                    $('button[type="Submit"]').removeAttr('disabled', '');
                    $('button[type="Submit"]').html("إحفظ");
                    var elmnt = document.body;
                    elmnt.scrollTop = 10;
                } else {
                    $('.alert').slideDown();
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.alert').html('النجاح ، شكرا لك على وقتك');
                    setTimeout(function() {
                        location.href = "<?= base_url('AR/' . $this->router->fetch_class() . "/Show_surveys") ?>";
                    }, 1000);
                    // Swal.fire({
                    //     title: 'هل أنت متأكد',
                    //     text: "لن تتمكن من التراجع عن هذا!",
                    //     icon: 'warning',
                    //     showCancelButton: true,
                    //     confirmButtonText: 'نعم,أحذفها!',
                    //     cancelButtonText: 'No, cancel!',
                    //     confirmButtonClass: 'btn btn-success mt-2',
                    //     cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                    //     buttonsStyling: false
                    // }).then(function (result) {
                    //     if (result.value) {
                    //             location.href = "<?= base_url('AR/' . $this->router->fetch_class() . "/survey_feedback/") ?>" + data.Id + "/" + data.md5id + "";
                    //         } else if ( result.dismiss === Swal.DismissReason.cancel  ) {
                    //             location.href = "<?= base_url('AR/' . $this->router->fetch_class() . "/Show_surveys") ?>";
                    //         }
                    // });
                }
            },
            ajaxError: function() {
                $('.alert').css('background-color', '#DB0404');
                $('.alert').html("عندنا خطأ");
            }
        });
    });
</script>

</html>