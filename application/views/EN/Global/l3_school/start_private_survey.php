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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="my_answers" token="<?php echo md5(time()); ?>" method="post" class="custom-validation">
            <div class="row">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Instructions: </h3><br>
                                        <p class="text-muted col-12 p-0"><?= $serv_data[0]['Message'] ?></p>
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
                                            $questions = $this->db->query(" SELECT *,`sv_st_fillable_questions`.`Id` AS q_id
                                            FROM `sv_st_fillable_questions`
                                            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_fillable_questions`.`question_id`
                                            WHERE `sv_st_fillable_questions`.`Group_id` = '" . $group_quastion['Id'] . "'
                                            ORDER BY `sv_st_fillable_questions`.`position` ASC ")->result_array();
                                            ?>
                                            <?php foreach ($questions as $question_key => $question) { $questions_counter++; ?>
                                                <div class="card">
                                                    <div class="card-body quastions-title">
                                                        <h3 class="card-title"><?= $questions_counter ?> . <?= ucfirst(strtolower($question['en_title'])) ?></h3>
                                                        <hr>
                                                        <input type="text" autocomplete="off" data-parsley-minlength="3" data-parsley-maxlength="1000" name="answers[<?= $question['q_id'] ?>]" required class="form-control" placeholder="Your answer...">
                                                        <span class="error_<?= $question['q_id'] ?>_error error text-error"></span>
                                                    </div>
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
                                                        <h3 class="card-title"><?= $questions_counter ?> . <?php echo ucfirst(strtolower($question['en_title'])) ?></h3>
                                                        <hr>
                                                        <input type="text" autocomplete="off" data-parsley-minlength="3" data-parsley-maxlength="1000"  name="answers[<?= $question['q_id'] ?>]" required class="form-control" placeholder="Your answer...">
                                                        <span class="error_<?= $question['q_id'] ?>_error error text-error"></span>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="questions" value="<?= $questions_counter; ?>">
                                <button class="btn btn-primary waves-effect waves-light" type="Submit"> Submit Answers </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#my_answers").on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
            form.parsley().validate();
            if(form.parsley().isValid()){
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("".uri_string()) ?>?serv=<?= $serv_id; ?>&time=<?= date('H:i:s'); ?>',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.error.text-error').html('');
                        $('.alert').slideUp();
                        $('button[type="Submit"]').attr('disabled', '');
                        $('button[type="Submit"]').html("Please wait...");
                    },
                    success: function(reponse) {
                        $('button[type="Submit"]').removeAttr('disabled', '');
                        $('button[type="Submit"]').html("Save");
                        if(reponse.status == "validation_error"){
                            $.each(reponse.errors , function(prefix , val){
                                $('.error_' + prefix + '_error').html(val);
                            });
                        }else if (reponse.status == "error"){
                            Swal.fire({
                                    title: "error",
                                    text:  reponse.message,
                                    icon: 'error',
                                    confirmButtonColor: '#5b73e8'
                                });
                        }else if (reponse.status == "ok") {
                            setTimeout(function() {
                                location.href = "<?= base_url('EN/'.$this->router->fetch_class()."/Show_surveys") ?>";
                            }, 1000);
                        }
                    },
                    ajaxError: function() {
                        $('.alert').css('background-color', '#DB0404');
                        $('.alert').html("Ooops! Error was found.");
                    }
                }); 
            }
        });
</script>