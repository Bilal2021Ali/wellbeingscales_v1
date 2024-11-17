<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />

<style>
    .choisesContainer .card {
        cursor: pointer;
    }

    .select2-container {
        width: 100% !important;
    }

    .delete_question {
        color: #f46a6a;
        font-size: 20px;
        cursor: pointer;
    }

    .get_avalaible_questions {
        position: fixed;
        bottom: 65px;
        right: 10px;
        border: 0px;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 100%;
        z-index: 1000;
        -webkit-box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
        box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
    }

    .editableValue {
        padding: 5px;
        border: 0px;
        outline: none;
    }

    .flex {
        display: flex;
    }

    .ApproveBtn {
        transition: 0.3s all;
        transform: scale(0);
        transform-origin: top;
    }

    .tab-pane.active-update .ApproveBtn {
        transform: scale(1);
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="modal fade zoom-in" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Questions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="push_questions">
                        <div class="modal-body addquestions_div">
                            <h3 class="text-center">Please wait<span id="wait">.</span></h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="Submit" class="btn btn-primary add_q_btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if ($survey['isUsed'] == '0') { ?>
            <button data-toggle="tooltip" class="get_avalaible_questions" style="bottom : 60px;" data-placement="top" title="" data-original-title="add new questions to this survey">
                <i class="uil uil-plus-circle" data-toggle="modal" data-target="#exampleModal" group=""></i>
            </button>
        <?php } ?>
        <div id="choiseValue" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="choiseValueLabel" aria-hidden="true">
            <form class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="choiseValueLabel"> Choice Mark </h5>
                        <button type="button" class="btn btn-radius text-black" data-dismiss="modal" aria-label="Close">x
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="font-size-16">Change The choice value</h5>
                        <input type="number" value="" placeholder="Enter The value" name="mark" class="form-control">
                        <input type="hidden" value="" name="activeId" class="form-control">
                        <input type="hidden" value="" name="choice" class="form-control">
                        <input type="hidden" value="" name="question" class="form-control">
                        <input type="hidden" value="" name="markKey" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="container">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 bg-success" style="height: 60px;border-radius: 4px;">
                                            <p class="text-white text-center mt-3">This is an editable survey area not just preview</p>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12">
                                                    <a href="<?= base_url("EN/Dashboard/survey-preview/" . $serv_id . "/" . $serv_type . "/ar"); ?>" class="w-100 btn-warning btn waves-effect">
                                                        Go The AR Preview
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <a href="<?= base_url("EN/Dashboard/survey-preview/" . $serv_id . "/" . $serv_type . "/en"); ?>" class="w-100 btn-warning btn waves-effect">
                                                        Go The EN Preview
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="w-100">
                                        <div class="col-lg-6">
                                            <ul class="nav nav-pills float-right" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-toggle="tab" href="#category-en" role="tab">
                                                        <span>Preview EN</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#category-ar" role="tab">
                                                        <span>Preview AR</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-3 text-muted">
                                                <h6>Category Title:</h6>
                                                <div class="tab-pane active" id="category-en" role="tabpanel">
                                                    <p><?= $survey['Cat_en'] ?></p>
                                                </div>
                                                <div class="tab-pane" id="category-ar" role="tabpanel">
                                                    <p><?= $survey['Cat_ar'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="nav nav-pills float-right" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-toggle="tab" href="#set_name-en" role="tab">
                                                        <span>Preview EN</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#set_name-ar" role="tab">
                                                        <span>Preview AR</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-3 text-muted">
                                                <h6>Survey Title:</h6>
                                                <div class="tab-pane active" id="set_name-en" role="tabpanel">
                                                    <p><?= $survey['set_name_en'] ?></p>
                                                </div>
                                                <div class="tab-pane" id="set_name-ar" role="tabpanel">
                                                    <p><?= $survey['set_name_ar'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-pills float-right" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-toggle="tab" href="#Reference-en" role="tab">
                                                        <span>Edit Reference EN</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#Reference-ar" role="tab">
                                                        <span>Edit Reference AR</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-3 text-muted">
                                                <h6>Reference:</h6>
                                                <div class="tab-pane active" id="Reference-en" role="tabpanel">
                                                    <div class="flex">
                                                        <input class="editableValue w-100" data-original-value="<?= $survey['reference_en'] ?>"" name=" reference" data-lang="en" type="text" value="<?= $survey['reference_en'] ?>">
                                                        <i class="uil uil-pen text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Reference"></i>
                                                    </div>
                                                    <button class="btn btn-success btn-rounded approvechanges w-100 mt-1 ApproveBtn"><i class="uil uil-check"></i> Approve Changes</button>
                                                </div>
                                                <div class="tab-pane" id="Reference-ar" role="tabpanel">
                                                    <div class="flex">
                                                        <input class="editableValue w-100" dir="rtl" data-original-value="<?= $survey['reference_en'] ?>"" name=" reference" data-lang="ar" type="text" value="<?= $survey['reference_ar'] ?>">
                                                        <i class="uil uil-pen text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Reference"></i>
                                                    </div>
                                                    <button class="btn btn-success btn-rounded approvechanges w-100 mt-1 ApproveBtn"><i class="uil uil-check"></i> Approve Changes</button>
                                                </div>
                                            </div>
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
                                            <ul class="nav nav-pills float-right" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-toggle="tab" href="#message-en" role="tab">
                                                        <span>Edit Instructions EN</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#message-ar" role="tab">
                                                        <span>Edit Instructions AR</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-3 text-muted">
                                                <h6>Instructions: </h6>
                                                <div class="tab-pane active" id="message-en" role="tabpanel">
                                                    <div class="flex">
                                                        <input class="editableValue w-100" data-original-value="<?= $survey['Message_en'] ?>"" name=" Message" data-lang="en" type="text" value="<?= $survey['Message_en'] ?>">
                                                        <i class="uil uil-pen text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Value to update !!"></i>
                                                    </div>
                                                    <button class="btn btn-success btn-rounded approvechanges w-100 mt-1 ApproveBtn"><i class="uil uil-check"></i> Approve Changes</button>
                                                </div>
                                                <div class="tab-pane" id="message-ar" role="tabpanel">
                                                    <div class="flex">
                                                        <input class="editableValue w-100" dir="rtl" data-original-value="<?= $survey['Message_ar'] ?>"" name=" Message" data-lang="ar" type="text" value="<?= $survey['Message_ar'] ?>">
                                                        <i class="uil uil-pen text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Value to update !!"></i>
                                                    </div>
                                                    <button class="btn btn-success btn-rounded approvechanges w-100 mt-1 ApproveBtn"><i class="uil uil-check"></i> Approve Changes</button>
                                                </div>
                                            </div>
                                            <!-- <p class="text-muted col-12 p-0 w-100" style="overflow : auto"><?= $survey['Message'] ?></p> -->
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
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger" role="alert" style="display: none;"></div>
                            <div id="sortGroups">
                                <?php foreach ($used_groups as $group_key => $group_quastion) {  ?>
                                    <div class="card quastions" data-id="<?= $group_quastion['Id'] ?>">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3"><?= $group_quastion['title_en']; ?></h4>
                                            <?php
                                            if ($serv_type == "choices") {
                                                $questions = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                                                FROM `sv_st_questions`
                                                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                                                WHERE `sv_st_questions`.`Group_id` = '" . $group_quastion['Id'] . "' ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                                            } else {
                                                $questions = $this->db->query(" SELECT *,`sv_st_fillable_questions`.`Id` AS q_id
                                                FROM `sv_st_fillable_questions`
                                                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_fillable_questions`.`question_id`
                                                WHERE `sv_st_fillable_questions`.`Group_id` = '" . $group_quastion['Id'] . "' ORDER BY `sv_st_fillable_questions`.`position` ASC")->result_array();
                                            }
                                            ?>
                                            <div id="Groupequestions_<?= $group_key ?>">
                                                <?php foreach ($questions as $question_key => $question) { ?>
                                                    <?php $questions_counter++; ?>
                                                    <div id="question_<?= $question['q_id'] ?>" class="question" data-id="<?= $question['q_id'] ?>">
                                                        <div class="card <?= $serv_type == "choices" ? "" : "mb-0" ?>">
                                                            <div class="card-body quastions-title">
                                                                <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title'] ?> <span class="text-danger">*</span>
                                                                    <?php if ($survey['isUsed'] == '0') { ?>
                                                                        <i class="uil uil-trash delete_question float-right" data-surv-type="<?= $serv_type ?>" for="<?= $question['q_id']  ?>"></i>
                                                                    <?php } ?>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <?php if ($serv_type == "choices") {  ?>
                                                            <div class="row choisesContainer px-2">
                                                                <?php foreach ($choices as $key => $choice) { ?>
                                                                    <?php
                                                                    $q = $this->db->get_where("sv_st_answers_mark", ["choice_id" => $choice['Id'], "question_id" => $question['q_id'], "survey_id" => $serv_id])->result_array();
                                                                    $num = $q[0]['mark'] ?? 0;
                                                                    ?>
                                                                    <div class="card col" data-mark-id="markC_<?= $question['q_id'] . "_" . $key . "_" . '_' . $choice['Id'] ?>" data-id="<?= $choice['Id'] ?>" data-q-id="<?= $question['q_id'] ?>">
                                                                        <div class="card-body">
                                                                            <label for="customRadio_<?= $question_key . "_" . $key . "_" . $group_key . '_' . $questions_counter;  ?>">
                                                                                <b id="markC_<?= $question['q_id'] . "_" . $key . "_" . '_' . $choice['Id'] ?>">(<?= $num ?>)</b>
                                                                                <?= $choice['title_en'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row px-2 my-2">
                                                                <input type="text" name="" placeholder="Answer.." class="form-control">
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
                                        <div id="QuestionsSort">
                                            <?php foreach ($static_questions as $question_key => $question) { ?>
                                                <?php $questions_counter++; ?>
                                                <div id="question_<?= $question['q_id'] ?>" data-id="<?= $question['q_id'] ?>">
                                                    <div class="card <?= $serv_type == "choices" ? "" : "mb-0" ?>">
                                                        <div class="card-body quastions-title">
                                                            <h3 class="card-title"><?= $questions_counter ?> . <?= $question['en_title'] ?> <span class="text-danger">*</span>
                                                                <?php if ($survey['isUsed'] == '0') { ?>
                                                                    <i class="uil uil-trash delete_question float-right" data-surv-type="<?= $serv_type ?>" for="<?= $question['q_id']  ?>"></i>
                                                                <?php } ?>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <?php if ($serv_type == "choices") {  ?>
                                                        <div class="row choisesContainer px-2">
                                                            <?php foreach ($choices as $key => $choice) { ?>
                                                                <?php
                                                                $q = $this->db->get_where("sv_st_answers_mark", ["choice_id" => $choice['Id'], "question_id" => $question['q_id'], "survey_id" => $serv_id])->result_array();
                                                                $num = $q[0]['mark'] ?? 0;
                                                                ?>
                                                                <div class="card col" data-mark-id="markC_<?= $question['q_id'] . "_" . $key . "_" . '_' . $choice['Id'] ?>" data-id="<?= $choice['Id'] ?>" data-q-id="<?= $question['q_id'] ?>">
                                                                    <div class="card-body">
                                                                        <b id="markC_<?= $question['q_id'] . "_" . $key . "_" . '_' . $choice['Id'] ?>">(<?= $num ?>)</b>
                                                                        <?= $choice['title_en'] ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="row px-2 my-2">
                                                            <input type="text" name="" placeholder="Answer.." class="form-control">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="nav nav-pills float-right" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-toggle="tab" href="#Disclaimer-en" role="tab">
                                                <span>Edit Disclaimer EN</span>
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-toggle="tab" href="#Disclaimer-ar" role="tab">
                                                <span>Edit Disclaimer AR</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3 text-muted">
                                        <h3>Disclaimer: </h3>
                                        <div class="tab-pane active" id="Disclaimer-en" role="tabpanel">
                                            <div class="flex">
                                                <input class="editableValue w-100" data-original-value="<?= $survey['disclaimer_en'] ?>"" name=" disclaimer" data-lang="en" type="text" value="<?= $survey['disclaimer_en'] ?>">
                                                <i class="uil uil-pen text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Value to update !!"></i>
                                            </div>
                                            <button class="btn btn-success btn-rounded approvechanges w-100 mt-1 ApproveBtn"><i class="uil uil-check"></i> Approve Changes</button>
                                        </div>
                                        <div class="tab-pane" id="Disclaimer-ar" role="tabpanel">
                                            <div class="flex">
                                                <input class="editableValue w-100" dir="rtl" data-original-value="<?= $survey['disclaimer_ar'] ?>"" name=" disclaimer" data-lang="ar" type="text" value="<?= $survey['disclaimer_ar'] ?>">
                                                <i class="uil uil-pen text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Value to update !!"></i>
                                            </div>
                                            <button class="btn btn-success btn-rounded approvechanges w-100 mt-1 ApproveBtn"><i class="uil uil-check"></i> Approve Changes</button>
                                        </div>
                                    </div>
                                    <!-- <p class="text-muted col-12 p-0"><?= $survey['disclaimer_en'] ?? "--" ?></p> -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" integrity="sha512-zYXldzJsDrNKV+odAwFYiDXV2Cy37cwizT+NkuiPGsa9X1dOz04eHvUWVuxaJ299GvcJT31ug2zO4itXBjFx4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    new Sortable(sortGroups, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onChange: function(evt) {
            var newsorting = [];
            $(evt.to).children().each(function() {
                newsorting.push($(this).attr('data-id'));
            });
            console.log(newsorting);
            updatequestionssorting(newsorting, "groups");
        }
    });
    new Sortable(QuestionsSort, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onChange: function(evt) {
            var newsorting = [];
            $(evt.to).children().each(function() {
                newsorting.push($(this).attr('data-id'));
            });
            console.log(newsorting);
            updatequestionssorting(newsorting, "questions");
        }
    });
    <?php foreach ($used_groups as $k => $group) { ?>
        new Sortable(Groupequestions_<?= $k ?>, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onChange: function(evt) {
                var newsorting = [];
                $(evt.to).children().each(function() {
                    newsorting.push($(this).attr('data-id'));
                });
                updatequestionssorting(newsorting, "questions");
            }
        });
    <?php } ?>

    function updatequestionssorting(newsorting, type = "questions") {
        $.ajax({
            type: "POST",
            url: "<?= current_url() ?>",
            data: {
                newsorting: newsorting,
                type: type,
            },
            success: function(response) {
                if (response.status == "ok") {
                    Command: toastr["success"]("The sorting has been successfully updated ");
                }
                else {
                    Command: toastr["error"]("Sorry !! we have an unexpected error, please try again later");
                }
            }
        });
    }

    $('.choisesContainer .card').dblclick(function() {
        $('#choiseValue input[name="choice"]').val($(this).attr('data-id'));
        $('#choiseValue input[name="question"]').val($(this).attr('data-q-id'));
        $('#choiseValue input[name="markKey"]').val($(this).attr('data-mark-id'));
        $('#choiseValue input[name="mark"]').val('');
        $('#choiseValue input[name="activeId"]').val('');
        $('#choiseValue input[name="mark"]').attr('placeholder', 'Please wait....');
        $.ajax({
            type: "GET",
            url: "<?= base_url("EN/Dashboard/ChoicesValues/"); ?>" + $(this).attr('data-id') + "/" + $(this).attr('data-q-id') + "/" + <?= $serv_id ?>,
            success: function(response) {
                if (response.status == "ok") {
                    $('#choiseValue').modal('show');
                    $('#choiseValue input[name="mark"]').attr('placeholder', 'Update the value');
                    $('#choiseValue input[name="mark"]').val(response.activeMark);
                    $('#choiseValue input[name="activeId"]').val(response.activeId);
                } else {
                    $('#choiseValue input[name="mark"]').attr('placeholder', 'insert a value');
                    $('#choiseValue input[name="activeId"]').val(0);
                    $('#choiseValue').modal('show');
                }
            }
        });
    });


    $('#choiseValue form').on('submit', function(e) {
        e.preventDefault();
        var markValId = $('#choiseValue input[name="markKey"]').val();
        $('#choiseValue button[type="form"]').attr('disabled', "");
        $('#choiseValue button[type="form"]').html('Please wait...');
        console.log(markValId);
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Dashboard/ChoicesValues/") . $serv_id; ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#choiseValue button[type="form"]').attr('disabled', "");
                $('#choiseValue button[type="form"]').html('Please wait...');
                if (response.status == "ok") {
                    // message later on
                    $("#" + markValId).html('(' + $('#choiseValue input[name="mark"]').val() + ')');
                    Command: toastr["success"]("The mark has been successfully updated ");
                    $('#choiseValue').modal('hide');
                } else {
                    Command: toastr["error"]("Sorry !! we have an unexpected error, please try again later");
                }
            }
        });
    });

    $('.delete_question').each(function() {
        $(this).click(function() {
            const Id = $(this).attr('for');
            const type = $(this).attr('data-surv-type');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    //DELETE 	
                    $.ajax({
                        type: 'DELETE',
                        url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
                        data: {
                            question_id: Id,
                            sv_type: type,
                            sv_id: <?= $serv_id ?>,
                        },
                        success: function(data) {
                            if (data === "ok") {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Your question has been deleted.',
                                    icon: 'success'
                                }).then(function(result) {
                                    $('#question_' + Id).addClass('animate__flipOutX');
                                    setTimeout(function() {
                                        $('#question_' + Id).remove();
                                    }, 800);
                                });
                            } else {
                                Swal.fire(
                                    'error',
                                    'Oops! We have an unexpected error.',
                                    'error'
                                );
                            }
                        },
                        ajaxError: function() {
                            Swal.fire(
                                'error',
                                'oops!! we have a error',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    $('.get_avalaible_questions').click(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
            data: {
                requestFor: 'av_questions',
                group_id: <?= $serv_id; ?>,
                sv_type: "<?= $serv_type == "choices" ? "notfillable" : "fillable" ?>",
            },
            beforeSend: function() {
                $('.add_q_btn').hide();
                $('.addquestions_div').html(`<h3 class="text-center">Please wait<span id="wait">.</span></h3>`);
            },
            success: function(data) {
                $('.add_q_btn').show();
                $('.addquestions_div').html(data);
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

    $("#push_questions").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/push_new_questions',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.add_q_btn').attr('disabled', '');
                $('.add_q_btn').html('Plase wait ...');
            },
            success: function(data) {
                $('#statusbox').html(data);
                $('.add_q_btn').removeAttr('disabled');
                $('.add_q_btn').html('save changes ');
                if (data == "ok") {
                    $('#exampleModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The Questions you Selected was added Successfully to this Survey ',
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 600);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'Sorry we have error Now !! Please Try Later',
                    });
                }
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    $('.editableValue').on('keydown keypress keyup', function() {
        var $this = this;
        var value = $(this).val();
        if ($(this).attr('data-original-value') !== value && value.length > 3) {
            $(this).parent().parent().addClass("active-update")
        } else {
            $(this).parent().parent().removeClass("active-update")
        }
    });

    $('.ApproveBtn').click(function() {

        var $thi = $(this);
        $(this).parent().find('.editableValue').attr("disabled", "");
        var data = {
            "value": $(this).parent().find('.editableValue').val(),
            "language": $(this).parent().find('.editableValue').attr("data-lang"),
            "name": $(this).parent().find('.editableValue').attr("name"),
            "surveKey": <?= $serv_id ?>,
            "surveKey": <?= $serv_id ?>,
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Dashboard/tipsManagment"); ?>",
            data: data,
            success: function(response) {
                console.log("response");
                if (response.status == "ok") {
                    console.log("successfully");
                    console.log($thi.parent().html());
                    $thi.parent().find('.editableValue').removeAttr("disabled");
                    $thi.parent().find('.editableValue').attr("data-original-value", data.value);
                    $thi.parent().removeClass("active-update");
                    Command: toastr["success"]("The value has been updated successfully");
                } else {
                    Command: toastr["error"]("Sorry we couldn't update the value. Please try again later ");
                }
            }
        });
    });
</script>