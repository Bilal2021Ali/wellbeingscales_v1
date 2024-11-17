<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" />
<style>
    .bottom-results {
        display: inline;
        padding: 10px;
        border: 1px solid #b7b7b7;
    }

    .resultsPrimary .bottom-results {
        background-color: rgb(140 255 148);
        color: #525252;
    }

    .resultsDiv .bottom-results {
        background-color: rgb(255 230 140);
        color: #525252;
    }


    .save-results {
        bottom: 70px;
        background: #585858;
        color: #fff;
        font-size: 28px;
    }

    .spinner-border {
        font-size: 5px;
    }

    .alert-dismissible .btn-close {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        padding: .9375rem 1.25rem;
    }

    .btn-close {
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
        width: 1em;
        height: 1em;
        padding: .25em .25em;
        color: #000;
        background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e) center/1em auto no-repeat;
        border: 0;
        border-radius: .25rem;
        opacity: .5;
    }

    .choise.bg-success label {
        color: #fff !important;
    }

    .standard-card {
        background-color: #daf7ff;
    }
</style>
<?php $alphabets = ["a","b","c","d","e","f","g","h","i","j","k","l","M","n","o","p","q","r","s","t","u","v","w","x","y","z"]; ?>
<div class="main-content">
    <div class="page-content">
        <?php if (!empty($serv_data)) { ?>
            <button class="feedback_btn save-results" style="bottom: 70px;" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="Save report as PDF">
                <i class="uil uil-save"></i>
            </button>
        <?php } ?>
        <div class="card">
            <div class="card-body">
                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-4 px-4 mb-0 text-center mb-2" role="alert">
                        <i class="uil uil-exclamation-octagon d-block display-4 mt-2 mb-3 text-danger"></i>
                        <h5 class="text-danger">خطأ</h5>
                        <?= $errors ?>
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                <?php } ?>
                <form method="post" class="row">
                    <div class="col-lg-4">
                        <label> حدد مستخدمًا: </label>
                        <select class="select2 form-control" data-placeholder="Choose ..." name="Targetuser">
                            <option value="">حدد مستخدمًا</option>
                            <?php if (!empty($our_teachers)) { ?>
                                <optgroup label="Teachers">
                                    <?php foreach ($our_teachers as $teacher) { ?>
                                        <option value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_AR'] . " " . $teacher['L_name_AR'] ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                            <?php if (!empty($our_parents)) { ?>
                                <optgroup label="Parents">
                                    <?php foreach ($our_parents as $parent) { ?>
                                        <option value="parent:<?= $parent['Id'] ?>"><?= $parent['name_ar'] ?> </option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="user"> حدد استطلاعًا: </label>
                        <select class="form-control" data-placeholder="Choose ..." name="survey">
                            <option value="">لا توجد بيانات (حاول اختيار مستخدم) </option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="Ruser">نتائج: </label>
                        <select class="form-control" data-placeholder="Choose ..." name="results_user">
                            <option value="">لا توجد بيانات (حاول اختيار مستخدم واستطلاع) </option>
                        </select>
                    </div>
                    <button class="btn btn-block w-100 m-2 btn-primary" type="submit"> انشاء تقرير</button>
                </form>
            </div>
        </div>
        <?php if (!empty($serv_data)) { ?>
            <div id="reportpagecanvas">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <p class="mb-1">الاسم:</p>
                                    <h5 class="font-size-16"><?= $user_data['name'] ?></h5>
                                </div>
                                <div>
                                    <p class="mb-1">الجنس:</p>
                                    <h5 class="font-size-16"><?= $user_data['Gender'] == "1" ? "Male" : "Female" ?></h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <p class="mb-1">تاريخ الميلاد:</p>
                                    <h5 class="font-size-16"><?= $user_data['DOP'] ?></h5>
                                </div>
                                <div>
                                    <p class="mb-1">العمر:</p>
                                    <h5 class="font-size-16"><?= get_age($user_data['DOP']) ?> yo</h5>
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
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title']; ?> <span class="text-danger">*</span></h3>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-center">
                                                        <?php foreach ($choices as $key => $choice) { ?>
                                                            <div class="col col-xs-12">
                                                                <div class="card choise <?= $choice['Id'] == $student_answers[$question['Id']]["choice_id"] ? "bg-success text-white" : "" ?>">
                                                                    <div class="card-body">
                                                                        <div class="custom-control custom-radio mr-2">
                                                                            <input disabled <?= $choice['Id'] == $student_answers[$question['Id']]["choice_id"] ? "checked" : "" ?> type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>" value="<?= $choice['Id'] . '_' . $question['q_id'] . '_' . $key ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
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
                                                                <div class="card choise <?= $choice['Id'] == $student_answers[$question['Id']]["choice_id"] ? "bg-success text-white" : "" ?>">
                                                                    <div class="card-body">
                                                                        <div class="custom-control custom-radio mr-2">
                                                                            <input disabled <?= $choice['Id'] == $student_answers[$question['Id']]["choice_id"] ? "checked" : "" ?> type="radio" id="customRadio_<?= $question_key . "_" . $key . "_" . $questions_counter;  ?>" value="<?= $choice['Id'] . '_' . $question['q_id'] . '_' . $key ?>" name="answer_<?= $questions_counter  ?>" class="custom-control-input">
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
                                    <hr>
                                    <!-- <div class="col-12">
                                        <label for="Ruser"> Results for : </label>
                                        <select class="form-control" name="standardType" id="standardType">
                                            <?php foreach($standards as $standard){ ?>
                                                <option value="<?= $standard['Id'] ?>"><?= $standard['Name_en'] ?> (<?= $questions_counter ?>)</option>
                                            <?php } ?>
                                        </select>
                                    </div> -->
                                    <div class="row mt-4">
                                        <?php foreach($results_groups as $sn => $result_group){ ?>
                                        <div class="col-3">
                                            <div class="card text-center standard-card" style="background-color: rgb(255 230 140);">
                                                <div class="card-body">
                                                    <?= $result_group['title_en']; ?>
                                                </div>
                                            </div>
                                            <div class="card text-center standard-card">
                                                <div class="card-body">
                                                    <?php 
                                                        $table_name = "r_28_conners";
                                                        $code = $alphabets[$sn];
                                                        $data = $this->db->get_where($table_name , ["raw_grade" => $result_group['Counter'] ])->result_array();
                                                    ?>
                                                    <?php if(empty($data)){  
                                                        echo "--";
                                                    }else{  
                                                        if($user_data['Gender'] == "1"){
                                                            echo  $data[0]['grade_M' . strtoupper($code)] ?? 'Not specified';
                                                        }else{
                                                            echo  $data[0]['grade_F' . strtoupper($code)] ?? 'Not specified';
                                                        }
                                                    } ?>
                                                </div>
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
        <?php } else { ?>
            <div class="row">
                <div class="container text-center p-5">
                    <img src="<?= base_url("assets/images/empty.svg"); ?>" style="width:100% ; max-width: 500px" alt="" srcset="">
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php if (!empty($serv_data)) { ?>
    <script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="<?= base_url("assets/libs/pdfmake/jspdf.plugin.from_html.js"); ?>"></script>
    <script src="<?= base_url("assets/libs/pdfmake/jspdf.plugin.from_html.js"); ?>"></script>

    <script>
        $('.save-results').click(function() {
            $('.save-results').html('<div class="spinner-border text-white m-1" role="status"><span class="sr-only">Loading...</span></div>');
            var doc = new jsPDF();
            // window.scrollTo(0, 0);
            html2canvas($("#reportpagecanvas")[0], {
                dpi: 192,
                scrollY: -window.scrollY
            }).then(function(canvas) {
                var img = canvas.toDataURL("image/png");
                doc.addImage(img, 'png', 15, 40, 180, 250);
                doc.save('<?= $user_data['name'] ?>-<?= md5(rand(1, 1000)) ?>.pdf');
                $('.save-results').html('<i class="uil uil-save"></i>');
            });
            // var source = window.document.getElementsByTagName("reportpagecanvas")[0];
            // doc.fromHTML(source, 15, 15);
            // doc.save('sample-document.pdf');
            // html2canvas($("#reportpagecanvas")[0], {
            //     dpi: 192,
            // }).then(function(canvas) {
            //     var imgData = canvas.toDataURL("image/png");
            //     console.log(imgData);
            //     doc.addImage(imgData, 'png', 15, 40, 200, 500);
            //     doc.save('sample-document.pdf');
            // });
        });
        // $('.').click(function() {
        //     console.log("Start");
        //     var doc = new jsPDF();
        //     var elementHTML = $('#reportpagecanvas').html();
        //     doc.fromHTML(elementHTML, 15, 15, {
        //         'width': 170,
        //     });

        //     // Save the PDF
        //     doc.save('sample-document.pdf');
        // });
    </script>
<?php } ?>
<script>
    $('select[name="Targetuser"]').change((function() {
        if ($(this).val() !== "") {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Schools/doneSurveysForUser',
                data: {
                    userData: $(this).val(),
                },
                success: function(data) {
                    if (Object.keys(data).length > 0) {
                        $('select[name="survey"]').html('');
                        $('select[name="survey"]').append('<option value="">Select a survey</option>');
                        data.forEach(survey => {
                            $('select[name="survey"]').append('<option value="' + survey.survey_id + '">' + survey.Title_en + ' - ' + survey.set_name_en + '( ' + survey.From_date + '-' + survey.To_date + ' ) </option>');
                        });
                    } else {
                        $('select[name="survey"]').html('<option value="">لم يتم العثور على بيانات (حاول اختيار مستخدم آخر)</option>');
                    }
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ',
                        'error'
                    )
                }
            });
        }
    }));

    $('select[name="survey"]').change((function() {
        if ($(this).val() !== "") {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Schools/resultsUsersForDedicatedSurvey',
                data: {
                    survey_id: $(this).val(),
                },
                success: function(data) {
                    if (Object.keys(data).length > 0) {
                        $('select[name="results_user"]').html('');
                        $('select[name="results_user"]').append('<option value="">حدد استطلاعًا</option>');
                        data.forEach(survey => {
                            $('select[name="results_user"]').append('<option value="' + survey.Id + '">' + survey.name + '</option>');
                        });
                    } else {
                        $('select[name="results_user"]').html('<option value="">لم يتم العثور على بيانات (حاول اختيار استبيان آخر)</option>');
                    }
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ',
                        'error'
                    )
                }
            });
        }
    }));

    $('.select2').select2({
        closeOnSelect: false
    });

    $('select[name="calculater"]').change(function() {
        var allresults = [];
        var value = $(this).val().split(':');
        var code = $(this).attr('id');
        $('#calcresult_' + code).html((value[0] ?? 0) * (value[1] ?? 0));
        $(this).parents('.resultsDiv').children().not('.sumResults').each(function() {
            allresults.push(Number($(this).children("span").html()));
        });
        console.log(allresults);
        sum = allresults.reduce((a, b) => a + b, 0);
        $(this).parent().parent().find(".sumResults span").html(sum)
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