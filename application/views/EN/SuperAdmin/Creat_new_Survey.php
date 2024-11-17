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
        padding-top: 15px;
    }

    .card.shadow-none {
        border: 1px solid #eaeaea;
        margin-bottom: 5px;
        background: #0eacd812;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
          
                <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 013: Create Survey</h4>
				
                <div class="row" id="surveyCreatContainer">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card" style="border: 0px">
                            <div class="card-body p-4">
							<div class="row">
        
        <!-- end col-->
        
        <div class="col-md-6 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #2e4962;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="" width="50px"> </div>
              <div>
                <?php
                $all_Active = $this->db->query( "SELECT * FROM `sv_st1_surveys`" )->num_rows();
                $lastsActive = $this->db->query( "SELECT * FROM `sv_st1_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();

                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                  <?= $all_Active ?>
                  </span> </h4>
                <p class="mb-0">Ministry Surveys</p>
              </div>
              <?php if (!empty($lastsActive)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                <?php foreach ($lastsActive as $lastActive) { ?>
                <?= $lastActive['TimeStamp'] ?>
                </span><br>
                Last Actived Surveys
                <?php } ?>
                <?php } else { ?>
              <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                Last Actived Surveys </p>
              <?php } ?>
              </p>
            </div>
          </div>
        </div>
        <!-- end col-->
                <div class="col-md-6 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #2e4962;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="" width="50px"> </div>
              <div>
                <?php
                $all_sv_school = $this->db->query( "SELECT * FROM `sv_school_published_surveys` " )->num_rows();
                $lastsv_school = $this->db->query( "SELECT * FROM `sv_school_published_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();
                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                  <?= $all_sv_school ?>
                  </span> </h4>
                <p class="mb-0">School Surveys </p>
                </p>
              </div>
              <?php if (!empty($lastsv_school)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                <?php foreach ($lastsv_school as $lastsqv_school) { ?>
                <?= $lastsqv_school['TimeStamp'] ?>
                </span><br>
                Last Actived Surveys
                <?php } ?>
                <?php } else { ?>
              <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                Last Actived Surveys </p>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- end col-->
        <div class="col-md-6 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #3f3836;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
              <div>
                <?php
                $all_Active = $this->db->query( "SELECT * FROM `sv_st1_co_surveys`" )->num_rows();
                $lastsActive = $this->db->query( "SELECT * FROM `sv_st1_co_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();

                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                  <?= $all_Active ?>
                  </span> </h4>
                <p class="mb-0">Company Surveys</p>
              </div>
              <?php if (!empty($lastsActive)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                <?php foreach ($lastsActive as $lastActive) { ?>
                <?= $lastActive['TimeStamp'] ?>
                </span><br>
                Last Actived Surveys
                <?php } ?>
                <?php } else { ?>
              <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                Last Actived Surveys </p>
              <?php } ?>
              </p>
            </div>
          </div>
        </div>
        <!-- end col-->
        

        
        <div class="col-md-6 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #3f3836;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
              <div>
                <?php
                $all_sv_school = $this->db->query( "SELECT * FROM `sv_co_published_surveys` " )->num_rows();
                $lastsv_school = $this->db->query( "SELECT * FROM `sv_co_published_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();
                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                  <?= $all_sv_school ?>
                  </span> </h4>
                <p class="mb-0">Department Surveys </p>
                </p>
              </div>
              <?php if (!empty($lastsv_school)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                <?php foreach ($lastsv_school as $lastsqv_school) { ?>
                <?= $lastsqv_school['TimeStamp'] ?>
                </span><br>
                Last Actived Surveys
                <?php } ?>
                <?php } else { ?>
              <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                Last Actived Surveys </p>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- end col--> 
        
      </div>
                                <form id="servey_creat">
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                                        0001: Select Category Name</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                               
                                                <select id="title_en" name="category" class="form-control select_set">
                                                    <?php foreach ($ctegories as $ctegory) {  ?>
                                                        <option value="<?= $ctegory['Id']  ?>"><?= $ctegory['Cat_en'] . ' - ' . $ctegory['Cat_ar']; ?></option>
                                                    <?php  }  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                                        0002: Select Survey Set Name</h4>
                                    <div class="form-group">
                                        
                                        <select id="Set" name="set" class="form-control select_set">
                                            <?php foreach ($sets as $set) {  ?>
                                                <option value="<?= $set['Id']  ?>"><?= $set['title_en']; ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                                        0003: Select Questions</h4>
                                    <div class="col-lg-12">
                                        
                                    </div>
                                    <div class="col-md-12 ml-auto">
                                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                            <table class="table questionsselectTable">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Question by English</th>
                                                    <th>Question by Arabic</th>
                                                    <th>Description by English</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;"> 0004: Chosen Questions</h4>
                                    <div class="selected-questions-list">

                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0005: Select type of survey</h4>
                                    <div class="row mt-5 mb-3 ml-2">
                                        
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
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0006: Select type of answers model</h4>
                                    <div class="form-group answers">
                                       
                                        <select id="answer_group_EN" name="answer_group" class="form-control select_set">
                                            <?php foreach ($answers as $answer) {  ?>
                                                <option value="<?= $answer['Id']  ?>"><?= $answer['title_en']; ?> | <?= $answer['title_ar']; ?> </option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0007: Select mobile style</h4>
                                    <div class="form-group">
                                       
                                        <select id="style" name="style" class="form-control select_set">
                                            <?php foreach ($styles as $style) {  ?>
                                                <option value="<?= $style['Id']  ?>"><?= $style['name']; ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0008: Select targeted account type</h4>
                                    <div class="form-group answers">
                                        
                                        <select id="targetedtypes" name="targetedtypes" class="form-control select_set">
                                            <option value="M">Ministries</option>
                                            <option value="C">Companies</option>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0009: Select targeted account</h4>
                                    <div class="form-group" id="ministriesAccounts">
                                        
                                        <select name="targetedaccounts[]" multiple="multiple" data-placeholder="Choose ..." class="form-control select_set">
                                            <?php foreach ($Ministries as $Ministry) { ?>
                                                <option value="<?= $Ministry['Id'] ?>"><?= $Ministry['EN_Title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="CompaniesAccounts">
                                        <label class="float-left">Targeted Accounts (Companies):</label>
                                        <select multiple="multiple" data-placeholder="Choose ..." class="form-control select_set">
                                            <?php foreach ($Companies as $Company) { ?>
                                                <option value="<?= $Company['Id'] ?>"><?= $Company['EN_Title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0010: Reference</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                           
                                            <textarea class="form-control styledInput" name="reference_en" id="reference_en" cols="30" rows="10" placeholder="Write your reference for english version"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                        
                                            <textarea class="form-control styledInput" name="reference_ar" id="reference_ar" cols="30" rows="10" placeholder="Write your reference for arabic version"></textarea>
                                        </div>
                                    </div>
									<br>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0011: Disclaimer </h4>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            
                                            <textarea class="form-control styledInput" name="disclaimer_en" id="disclaimer_en" cols="30" rows="10" placeholder="Write your disclaimer for english version"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <textarea class="form-control styledInput" name="disclaimer_ar" id="disclaimer_ar" cols="30" rows="10" placeholder="Write your disclaimer for arabic version"></textarea>
                                        </div>
                                    </div>
									<br>
                                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0012: Message </h4>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                           
                                            <textarea class="form-control" name="message_en" id="message_en" cols="30" rows="10" placeholder="Write your message for english version"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            
                                            <textarea class="form-control" name="message_ar" id="message_ar" cols="30" rows="10" placeholder="Write your message for arabic version"></textarea>
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
    $('#CompaniesAccounts').hide();

    $('#targetedtypes').change(function() {
        var val = $('#targetedtypes option:checked').val();
        console.log('Value :', val);
        if (val == 'M') {
            $('#ministriesAccounts').show();
            $('#CompaniesAccounts').hide();
            $('#ministriesAccounts select').attr('name', 'targetedaccounts[]');
            $('#CompaniesAccounts select').removeAttr('name');
        } else {
            $('#CompaniesAccounts').show();
            $('#ministriesAccounts').hide();
            $('#CompaniesAccounts select').attr('name', 'targetedaccounts[]');
            $('#ministriesAccounts select').removeAttr('name');
        }
    });

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
        const thisVal = $(this).val();
        const question = $(this).parent().parent().parent().find('.en-question').html() ?? "---";
        if (inArray(thisVal, selectedQuestions)) {
            var result = selectedQuestions.filter(elem => thisVal !== elem);
            selectedQuestions = result;
            $('.question-preview-card-' + thisVal).remove();
        } else {
            $('.selected-questions-list').append(`<div class="card shadow-none question-preview-card-${thisVal}">
                                    <div class="card-body">
                                        <p class="mb-0 font-weight-bold text-dark">#${thisVal}</p>
                                        <span class="font-weight-light text-muted">${question}</span>
                                    </div>
                                </div>`);
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
                    className: "en-question",
                    data: 'questionEn',
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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
                                var newAction = '<a href="' + action.link + '" class="btn card p-1">';
                                newAction += '<div class="afterCreatAction">';
                                newAction += '<i class="uil ' + action.icon + ' float-left"></i>';
                                newAction += '<div>';
                                newAction += '<h3>' + action.title + '</h3>';
                                newAction += '<p>' + action.description + '</p>';
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