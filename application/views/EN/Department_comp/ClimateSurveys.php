<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<style>
    .delete {
        color: #fd0000;
        cursor: pointer;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #CB0002;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #00bd06;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #00bd06;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .select2-container {
        width: 100% !important;
    }

    .badge-m-1 {
        margin: 2px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div id="PublishSurveyForm" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="PublishSurveyFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="PublishSurveyFormLabel">Publish This Survey :</h5>
                        <button type="button" class="btn-close btn btn-rounded" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="publish_this_serv">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">This survey is for : </label><span
                                            class="float-right text-primary btn s-all" data-target-select="type[]">Select all</span>
                                        <select class="select2 form-control select2-multiple select-survey-respondents"
                                                multiple="multiple" data-placeholder="Choose ..." name="type[]">
                                            <?php foreach ($userstypes as $usertype) { ?>
                                                <option
                                                    value="<?= $usertype['Id'] ?>"><?= $usertype['UserType'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Gender : </label>
                                        <select class="select2 form-control select2-multiple" multiple="multiple"
                                                data-placeholder="Choose ..." name="gender[]">
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="serv_id">
                                <div class="col-lg-12">
                                    <button type="Submit"
                                            class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">
                                        Publish Survey
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">CLIMATE LIBRARY</h4>
                <p class="card-title-desc">Action Panel</p>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#navtahome" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Library</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#navtaprofile" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Your Climate</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="navtahome" role="tabpanel">
                        <h3 class="card-title">Climate Surveys Library</h3>
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>No</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Climate Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Question</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>
                                <?php foreach ($oursurveys as $key => $oursurvey) { ?>
                                    <tr id="serv_<?= $oursurvey['survey_id'] ?>">
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $oursurvey['created_at'] ?></td>
                                        <td><?= $oursurvey['Cat_en']; ?><br><?= $oursurvey['Cat_ar'] ?></td>
                                        <td><?= $oursurvey['set_name_en']; ?><br><?= $oursurvey['set_name_ar'] ?></td>
                                        <td><?= $oursurvey['from_date']; ?></td>
                                        <td><?= $oursurvey['to_date']; ?></td>
                                        <td><?= $oursurvey['question'] ?></td>
                                        <td class="text-center">
                                            <i data-toggle="tooltip" data-placement="top" data-original-title="Publish"
                                               data-id="<?= $oursurvey['survey_id'] ?>"
                                               class="uil uil-share-alt btn btn-rounded waves-effect btn-success font-size-20 publish"></i>
                                            <a data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Preview"
                                               href="<?= base_url("EN/Company_Departments/climatePreview/" . $oursurvey['main_survey_id']); ?>"><i
                                                    class="uil uil-eye font-size-20 btn btn-rounded waves-effect btn-success"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="navtaprofile" role="tabpanel">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>No</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Climate Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Question</th>
                                <th>Targeted Genders</th>
                                <th>Targeted Users Types</th>
                                <th>Status</th>
                                </thead>
                                <tbody>
                                <?php foreach ($published_surveys as $key => $oursurvey) { ?>
                                    <tr id="serv_<?= $oursurvey['survey_id'] ?>">
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $oursurvey['created_at'] ?></td>
                                        <td><?= $oursurvey['Cat_en']; ?><br><?= $oursurvey['Cat_ar'] ?></td>
                                        <td><?= $oursurvey['set_name_en']; ?><br><?= $oursurvey['set_name_ar'] ?></td>
                                        <td><?= $oursurvey['from_date']; ?></td>
                                        <td><?= $oursurvey['to_date']; ?></td>
                                        <td><?= $oursurvey['question'] ?></td>
                                        <td>
                                            <?php foreach (explode(',', $oursurvey['genderslist']) as $gender) { ?>
                                                <span
                                                    class="badge rounded-pill bg-primary text-white p-2"><?= str_replace(['1', '2'], ['Males', 'Females'], $gender); ?></span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div
                                                style="max-width: 150px;display: flex;flex-direction: row;flex-wrap: wrap;">
                                                <?php foreach ($this->labels_formatter->format($oursurvey['typeslist']) as $type) { ?>
                                                    <span
                                                        class="badge rounded-pill bg-danger text-white p-2 badge-m-1"><?= $type; ?></span>
                                                <?php } ?>
                                                <?php if ($this->labels_formatter->hasMore($oursurvey['typeslist'])) { ?>
                                                    <span data-value="<?= translate_types_codes($oursurvey['typeslist']) ?>"
                                                          class="badge rounded-pill bg-danger text-white p-2 badge-m-1 show-more-labels">Show More...</span>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" name="ischecked"
                                                       data-serv-key="<?= $oursurvey['survey_id']; ?>" <?= $oursurvey['status'] == 1 ? 'checked' : ""; ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
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
    $('.select-levels').slideUp();
    $('.select2').select2({
        closeOnSelect: false
    });
    $('.s-all').click(function () {
        var target = $(this).attr('data-target-select');
        $('select[name="' + target + '"] option').attr('selected', '');
        var selectedItems = [];
        var allOptions = $('select[name="' + target + '"]');
        allOptions.each(function () {
            selectedItems.push($(this).val());
        });
        $('select[name="' + target + '"]').select2("val", selectedItems);
    });

    $('table').DataTable();
    $('.table').on('click', '.delete', function () {
        var Id = $(this).attr('for');
        var key = $(this).attr('key');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to Revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                //DELETE 	
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {
                        serv_id: Id,
                    },
                    success: function (data) {
                        if (data === "ok") {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your Question has been Deleted.',
                                icon: 'success'
                            }).then(function (result) {
                                $('#serv_' + Id).addClass('animate__flipOutX');
                                setTimeout(function () {
                                    $('#serv_' + Id).remove();
                                }, 800);
                            });
                            reset_count(key);
                        } else {
                            Swal.fire(
                                'error',
                                'Oops! We have an unexpected error.',
                                'error'
                            );
                        }
                    },
                    ajaxError: function () {
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

    $('.table').on('change', 'input[name="ischecked"]', function () {
        var surveyId = $(this).attr('data-serv-key');
        $.ajax({
            type: "PUT",
            url: "<?= current_url() ?>",
            data: {
                surveyId: surveyId
            },
            success: function (response) {
                if (response !== "ok") {
                    toastr["error"]("unexpected error , please refresh tha page");
                }
            }
        });
    });

    $('.table').on('click', '.publish', function () {
        var id = $(this).attr('data-id');
        $('#PublishSurveyForm').modal('show');
        $('#PublishSurveyForm input[name="serv_id"]').val(id);
    });

    $("#publish_this_serv").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                // loading
                $('#publish_this_serv button[type="Submit"]').attr('disabled', 'disabled');
                $('#publish_this_serv button[type="Submit"]').html('Please wait ..');
            },
            success: function (data) {
                $('#publish_this_serv button[type="Submit"]').removeAttr('disabled');
                $('#publish_this_serv button[type="Submit"]').html('Publish');
                if (data == "okokokok") {
                    $('#publish').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'oops!! we have a error , Please check the inputs',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error , Please Try again later',
                    'error'
                );
            }
        });
    });
</script>
<?php $this->load->view("Shared/inc/show-more-labels") ?>