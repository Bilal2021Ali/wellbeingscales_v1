<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>assets/libs/select2/js/select2.min.js"></script>
</head>
<?php
$last = $this->db->query("SELECT Id FROM sv_st_surveys ORDER BY Id DESC")->result_array();
$number = empty($last) ? 1 : $last[0]['Id'];
$code = "Survey " . $number;
$answers = $this->db->query("SELECT * FROM sv_set_template_answers ORDER BY Id DESC ")->result_array();
?>
<style>
    .afterCreatAction {
        display: flex;
        margin-bottom: 11px;
    }
    .afterCreatAction i {
        font-size: 30px;
        color: #676767;
        border-right: 1px solid #e3e3e3;
        padding-right: 10px;
        margin-right: 9px;
        margin-top: 10px;
        padding-top: 0px;
        margin-left: 10px;
    }
    .afterCreatAction h3 {
        font-size: 17px;
    }
    .afterCreatAction p {
        margin-bottom: 1px;
        font-size: 12px;
        color: #888;
    }

    .afterCreatAction div {
        text-align: left;
        padding-top : 15px;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 013: Create Survey</h4>
                <div class="row" id="surveyCreatContainer">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card" style="border: 0px">
                            <div class="card-body p-4">
                                <form id="servey_creat">
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                                        0001: Select Category Title</h4>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="En_Title">Generated Code</label>
                                                <input type="text" value="<?= $code; ?>" readonly class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <label for="title_en">Category Title:</label>
                                                <select id="title_en" name="category" class="form-control select_set">
                                                    <?php foreach ($ctegories as $ctegory) {  ?>
                                                        <option value="<?= $ctegory['Id']  ?>"><?= $ctegory['Cat_en'] . ' - ' . $ctegory['Cat_ar']; ?></option>
                                                    <?php  }  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                                        0002: Select Survey Title</h4>
                                    <div class="form-group">
                                        <label for="Set" class="float-left">Survey Title:</label>
                                        <select id="Set" name="set" class="form-control select_set">
                                            <?php foreach ($sets as $set) {  ?>
                                                <option value="<?= $set['Id']  ?>"><?= $set['title_en']; ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                                        0003: Select Questions</h4>
                                    <div class="col-lg-12">
                                        <label for="question" class="float-left ">Question:</label><br>
                                    </div>
                                    <div class="col-md-12 ml-auto">
                                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                            <table class="table questionsselectTable">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Question EN</th>
                                                    <th>Question AR</th>
                                                    <th>Survey Description</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0004: Select Type of Survey</h4>
                                    <div class="row mt-5 mb-3 ml-2">
                                        <label for="answer_group_EN" class="float-left mr-4">Survey Type:</label>
                                        <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                            <input type="radio" class="custom-control-input chkbox" checked id="With" name="TypeOfSurvey" value="with">
                                            <label class="custom-control-label" for="With">
                                                With Choices
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                            <input type="radio" class="custom-control-input chkbox" id="without" name="TypeOfSurvey" value="without">
                                            <label class="custom-control-label" for="without">
                                                Without Choices
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group answers">
                                        <label for="answer_group_EN" class="float-left">Answers:</label>
                                        <select id="answer_group_EN" name="answer_group" class="form-control select_set">
                                            <?php foreach ($answers as $answer) {  ?>
                                                <option value="<?= $answer['Id']  ?>"><?= $answer['title_en']; ?> | <?= $answer['title_ar']; ?> </option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                    <div class="form-group answers">
                                        <label for="targetedaccounts" class="float-left">Targeted Accounts:</label>
                                        <select id="targetedaccounts" name="targetedaccounts" class="form-control select_set">
                                            <option value="M">Ministies</option>
                                            <option value="C" disabled>Companies</option>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0005: Reference &amp; Disclaimer </h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="reference_en">Reference EN :</label>
                                            <textarea class="form-control styledInput" name="reference_en" id="reference_en" cols="30" rows="10" placeholder="Reference for en version users...."></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="reference_ar">Reference AR :</label>
                                            <textarea class="form-control styledInput" name="reference_ar" id="reference_ar" cols="30" rows="10" placeholder="Reference for ar version users...."></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label for="disclaimer_en">Disclaimer EN :</label>
                                            <textarea class="form-control styledInput" name="disclaimer_en" id="disclaimer_en" cols="30" rows="10" placeholder="Disclaimer for en version users...."></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="disclaimer_ar">Disclaimer AR :</label>
                                            <textarea class="form-control styledInput" name="disclaimer_ar" id="disclaimer_ar" cols="30" rows="10" placeholder="Disclaimer for ar version users...."></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label for="disclaimer_en">Message EN :</label>
                                            <textarea class="form-control" name="message_en" id="message_en" cols="30" rows="10" placeholder="Short message for en version users...."></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="disclaimer_ar">Message AR :</label>
                                            <textarea class="form-control" name="message_ar" id="message_ar" cols="30" rows="10" placeholder="Short message for ar version users...."></textarea>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <button class="btn btn-primary btn-block goback m-0 mt-2"> Create Survey Now </button>
                                        <a href="<?= base_url() . "EN/Dashboard"; ?>" class="btn btn-light btn-sm btn-block waves-effect waves-light" style="display: block">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-100 row align-items-center AvailableActions" style="display: none;">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center"> Available Actions </h3>
                                <hr>
                                <div class="actions">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?= base_url() ?>assets/libs/parsleyjs/parsley.min.js"></script>
<script src="<?= base_url() ?>assets/js/pages/form-validation.init.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?= base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
<script src="<?= base_url("assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js") ?>"></script>
<script src="<?= base_url("assets/libs/tinymce/tinymce.min.js") ?>"></script>
<script>
    $('.select_set').select2();

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }
    var selectedQuestions = [];
    // $('.table').DataTable();
    $('.questionsselectTable ').on("change", 'input[type="checkbox"]', function() {
        var thisVal = $(this).val();
        if (inArray(thisVal, selectedQuestions)) {
            var result = selectedQuestions.filter(elem => thisVal !== elem);
            selectedQuestions = result;
        } else {
            selectedQuestions.push(thisVal);
        }
        console.log(selectedQuestions);
    });
    $(document).ready(function() {
        $('.questionsselectTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'data': function(d) {
                    d.selectedQuestions = selectedQuestions;
                    d.selectType = "multiple"
                },
                'url': "<?= base_url("EN/Dashboard/questionsprovider") ?>"
            },
            'columns': [{
                    data: 'id'
                },
                {
                    data: 'questionEn'
                },
                {
                    data: 'questionAr'
                },
                {
                    data: 'survey_description'
                },
            ]
        });
    });
    $('input[name="TypeOfSurvey"]').change(function() {
        var val = $('input[name="TypeOfSurvey"]:checked').val();
        console.log(val);
        if (val == "with") {
            $('.answers').slideDown();
        } else {
            $('.answers').slideUp();
        }
    });

    $("#servey_creat").on('submit', function(e) {
        e.preventDefault();
        var $this = this;
        var dataSS = new FormData(this);
        dataSS.append("questions", selectedQuestions);
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("EN/Dashboard/start_creat_servey"); ?>',
                    data: dataSS,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        var timerInterval;
                        Swal.fire({
                            title: 'Please Wait....',
                            backdrop: false,
                            html: 'we working on this request !',
                            onBeforeOpen: function onBeforeOpen() {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        if (data.status == 'ok') {
                            $('#surveyCreatContainer').slideUp();
                            Swal.fire(
                                'success',
                                'success!! The survey Added Successfully!',
                                'success'
                            );
                            $('.AvailableActions').show();
                            data.actions.forEach(action => {
                                var newAction = '<a href="'+ action.link +'" class="btn card p-1">';
                                        newAction += '<div class="afterCreatAction">';
                                        newAction += '<i class="uil '+ action.icon +' float-left"></i>';
                                            newAction += '<div>';
                                                newAction += '<h3>'+ action.title +'</h3>';
                                                newAction += '<p>'+ action.description +'</p>';
                                            newAction += '</div>';
                                        newAction += '</div>';
                                    newAction += '</a>';
                                $('.AvailableActions .actions').append(newAction);
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
                            'Oops! We have an unexpected error.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>

</html>