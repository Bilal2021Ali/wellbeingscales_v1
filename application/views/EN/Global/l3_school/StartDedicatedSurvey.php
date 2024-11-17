<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <style>
        .quastions-title {
            background-color: rgb(255 235 59 / 13%);
        }

        * {
            text-transform: inherit !important;
        }

        .noserv_img {
            max-width: 250px;
            width: 100%;
            margin: auto;
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
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">The student :</label>
                                            <select class="form-control select2" name="Student">
                                                <option> The current student </option>
                                                <?php foreach ($students as $student) { ?>
                                                    <option value="<?= $student['Id'] ?>"><?= $student['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <a href="<?= base_url("EN/" .  $this->router->fetch_class() . "/DedicatedSurvey/" . $serv_id); ?>" class="link btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-1">Start the survey</a>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($user_data)) { ?>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div>
                                                    <p class="mb-1">Name :</p>
                                                    <h5 class="font-size-16"><?= $user_data['name'] ?></h5>
                                                </div>
                                                <div>
                                                    <p class="mb-1">Gender :</p>
                                                    <h5 class="font-size-16"><?= $user_data['Gender'] == "1" ? "Male" : "Female" ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <p class="mb-1">Date of birth :</p>
                                                    <h5 class="font-size-16"><?= $user_data['DOP'] ?></h5>
                                                </div>
                                                <div>
                                                    <p class="mb-1">Age :</p>
                                                    <h5 class="font-size-16"><?= get_age($user_data['DOP']) ?> yo</h5>
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
            <?php if (!empty($user_data)) { ?>
                <form id="my_answers">
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
                                                                <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title']; ?> <span class="text-danger">*</span></h3>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-center">
                                                            <?php foreach ($choices as $key => $choice) { ?>
                                                                <div class="col col-xs-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="custom-control custom-radio mr-2">
                                                                                <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter ?>" value="<?= $choice['Id'] . '_' . $question['q_id'] ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
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
                                                                <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title']; ?> <span class="text-danger">*</span></h3>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-center">
                                                            <?php foreach ($choices as $key => $choice) { ?>
                                                                <div class="col col-xs-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="custom-control custom-radio mr-2">
                                                                                <input type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>" value="<?= $choice['Id'] . '_' . $question['q_id'] . '_' . $key ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
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
                                        <button class="btn btn-primary  waves-effect waves-light" type="Submit"> Submit Answers </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } else { ?>
                <div class="container text-center pt-2">
                    <img src="<?php echo base_url("assets/images/no_surveys_found.svg") ?>" class="noserv_img" alt="">
                    <h3 class="mt-2">Select The student Please</h3>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script>
    $('.link').hide();
    $('.select2').select2();
    $('select[name="Student"]').change(function() {
        if ($(this).val() !== "The current student") {
            $('.link').show();
            $('.link').attr('href', "<?= base_url("EN/" .  $this->router->fetch_class() . "/DedicatedSurvey/" . $serv_id); ?>/" + $(this).val());
        } else {
            $('.link').hide();
            $('.link').attr('href', "<?= base_url("EN/" .  $this->router->fetch_class() . "/DedicatedSurvey/" . $serv_id); ?>");
        }
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
                $('button[type="Submit"]').html("Please wait...");
            },
            success: function(data) {
                if (data !== "ok") {
                    $('.alert').slideDown();
                    $('.alert').html(data.message);
                    $('button[type="Submit"]').removeAttr('disabled', '');
                    $('button[type="Submit"]').html("Save");
                    var elmnt = document.body;
                    elmnt.scrollTop = 10;
                } else {
                    $('.alert').slideDown();
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.alert').html('success , Thank you for your time.');
                    setTimeout(function() {
                        location.href = "<?= base_url("EN/" .  $this->router->fetch_class() . "/DedicatedSurvey/" . $serv_id); ?>";
                    }, 1000);
                }
            },
            ajaxError: function() {
                $('.alert').css('background-color', '#DB0404');
                $('.alert').html("Ooops! Error was found.");
            }
        });
    });
</script>
<?php function get_age($date)
{
    $sortedDate = date('Y-m-d', strtotime($date));
    $year = explode("-", $sortedDate)[0];
    $age = date('Y') - $year;
    if (date('md') < date('md', strtotime($date))) {
        return $age - 1;
    }
    return $age;
} ?>

</html>