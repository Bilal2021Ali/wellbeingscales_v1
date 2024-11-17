<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css"/>
<style>
    .addone {
        position: absolute;
        bottom: auto;
        top: 10px;
    }

    .alert p {
        margin: 0px;
    }

    .accordion-body {
        padding: 10px;
    }

    .delete {
        color: var(--danger);
    }

    .edit {
        cursor: pointer;
        color: var(--green);
    }

    .select2-container {
        width: 100% !important;
        margin-bottom: 10px !important;
    }

    .badge {
        padding: 10px;
        font-size: 13px;
        text-align: center;
        width: 100%;
        display: inline;
    }

    .badge.bg-dark {
        background-color: #a8a8a8 !important;
        color: #0f1b02 !important;
    }

    .badge.bg-success {
        background-color: #7cd992 !important;
        color: #0f1b02 !important;
    }

    .badge.bg-warning {
        background-color: #f7e463 !important;
        color: #0f1b02 !important;
    }

    .badge.bg-danger {
        background-color: #eb6161 !important;
        color: #0f1b02 !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container">
            <div class="modal fade addaction" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Feedback:</h5>
                            <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal"
                                    aria-label="Close">x
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="new">
                                <div class="alert alert-danger" role="alert"></div>
<!--                                <label class="form-label">Report forwarded to:</label><br>-->
<!--                                <select class="form-control select2 w-100 mb-2" name="user" id="">-->
<!--                                    <optgroup label="Staff">-->
<!--                                        --><?php //foreach ($staffs as $staff) { ?>
<!--                                            <option value="staff:--><?php //= $staff['Id'] ?><!--">--><?php //= $staff['F_name_EN'] . " " . $staff['L_name_EN'] ?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </optgroup>-->
<!--                                    <optgroup label="Teacher">-->
<!--                                        --><?php //foreach ($teachers as $teacher) { ?>
<!--                                            <option value="teacher:--><?php //= $teacher['Id'] ?><!--">--><?php //= $teacher['F_name_EN'] . " " . $teacher['L_name_EN'] ?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </optgroup>-->
<!--                                </select>-->
                                <br>
                                <label for="">Your comment En:</label>
                                <textarea name="text_en" id="" cols="30" rows="8" class="form-control"
                                          placeholder="Please write your feedback here in En"></textarea>

                                <label for="">Your comment Ar:</label>
                                <textarea name="text_ar" id="" cols="30" rows="8" class="form-control"
                                          placeholder="Please write your feedback here in Ar"></textarea>

                                <input type="hidden" name="type" value="new">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100  mt-1">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade update" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Feedback:</h5>
                            <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal"
                                    aria-label="Close">x
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="updateform">
                                <div class="alert alert-danger" role="alert"></div>
                                <input type="hidden" name="id" value="">
                                <label class="form-label">Report by:</label><br>
                                <select class="form-control select2 w-100 mb-2" name="user" id="">
                                    <optgroup label="Staff">
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option id="staff__<?= $staff['Id'] ?>"
                                                    value="staff:<?= $staff['Id'] ?>"><?= $staff['F_name_EN'] . " " . $staff['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="Teacher">
                                        <?php foreach ($teachers as $teacher) { ?>
                                            <option id="teacher__<?= $teacher['Id'] ?>"
                                                    value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_EN'] . " " . $teacher['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                                <br>
                                <label for="">Update your comment En:</label>
                                <textarea name="text_en" id="" cols="30" rows="8" class="form-control"
                                          placeholder="Please write your feedback here in En"></textarea>

                                <label for="">Update your comment Ar:</label>
                                <textarea name="text_ar" id="" cols="30" rows="8" class="form-control"
                                          placeholder="Please write your feedback here in Ar"></textarea>

                                <input type="hidden" name="type" value="update">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100 mt-1">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade update-priority" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Priority:</h5>
                            <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal"
                                    aria-label="Close">x
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="updatePriority">
                                <label class="form-label">Select a Priority:</label><br>
                                <input type="hidden" name="type" value="priority">
                                <select class="form-control select2 w-100 mb-2" name="Priority" id="">
                                    <?php foreach (all_priorities() as $id => $priority) { ?>
                                        <option value="<?= $id ?>" <?= $id == $report->priority ? 'selected' : '' ?>><?= $priority['name'] ?> <?= $id == $report->priority ? '| Active' : '' ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100 mt-1">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                CH 100: List of Students for Speak Out</h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <label for="priority">Priority: <span class="badge rounded-pill"
                                                                  style="background-color:<?= priority($report->priority)['bg'] ?>;color : #fff"><?= priority($report->priority)['text'] ?></span><i
                                        class="uil uil-pen float-right edit ml-2" data-toggle="modal"
                                        data-target=".update-priority"></i>
                                <?php if ($report->closed !== '1') { ?>
                                    <section data-toggle="modal" data-target=".addaction">
                                        <button class="feedback_btn addone" type="button" data-toggle="tooltip"
                                                data-placement="left" title="" data-original-title="Add new action">
                                            <i class="uil uil-plus"></i>
                                        </button>
                                    </section>
                                <?php } ?>
                            </label>
                            <hr>
                            <?php if (!empty($actions)) { ?>
                                <div id="accordion" class="custom-accordion">
                                    <?php foreach ($actions as $sn => $action) { ?>
                                        <a href="#collapse_<?= $sn ?>" class="text-dark collapsed"
                                           data-toggle="collapse" aria-expanded="false"
                                           aria-controls="collapse_<?= $sn ?>">
                                            <div class="card-header mt-1" id="headingThree">
                                                <h6 class="m-0">
                                                    <strong><?= $action['TimeStamp'] ?></strong>
                                                    <i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                                    <?php if ($report->closed !== '1') { ?>
                                                        <i class="uil uil-trash float-right delete mr-2"
                                                           data-action-id="<?= $action['Id'] ?>"></i>
                                                        <i class="uil uil-pen float-right edit mr-2"
                                                           data-action-id="<?= $action['Id'] ?>" data-toggle="modal"
                                                           data-target=".update"></i>
                                                    <?php } ?>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapse_<?= $sn ?>" class="collapse <?= $sn == 0 ? "show" : "" ?>"
                                             aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="accordion-body">
                                                <?= $action['text_en'] ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                No actions yet
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script>
    $('.select2').select2();
    $('#new .alert').hide();
    $('#updateform .alert').hide();
    $('#updatePriority button').hide();
    // new
    $("#new").on('submit', function (e) {
        e.preventDefault();
        $('#new .alert').hide();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#new .btn').attr('disabled', 'disabled');
                $('#new .btn').html('Please wait…');
            },
            success: function (response) {
                $('#new .btn').removeAttr('disabled', 'disabled');
                $('#new .btn').html('submit');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Action added',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 700);
                } else {
                    $('#new .alert').show();
                    $('#new .alert').html(response.errors);
                }
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    // update action
    $('.edit').click(function () {
        var id = $(this).attr('data-action-id');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                type: "olddata",
                id: id,
            },
            success: function (response) {
                if (response.status == "ok") {
                    $('#updateform input[name="id"]').val(response.data.Id);
                    var selected = "#" + response.data.usertype + "__" + response.data.userid;
                    $(selected).attr('selected', "selected");
                    $(".select2-selection__rendered").html($(selected).html());
                    $('#updateform textarea[name="text_en"]').html(response.data.text_en);
                    $('#updateform textarea[name="text_ar"]').html(response.data.text_ar);
                } else {
                    $('.update').modal('hide');
                    Swal.fire({
                        title: 'sorry!',
                        text: "we can't find this action , Please refresh the page and try again. ​",
                        icon: 'error'
                    });
                }
            }
        });
    });
    //update
    $("#updateform").on('submit', function (e) {
        e.preventDefault();
        $('#updateform .alert').hide();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#updateform .btn').attr('disabled', 'disabled');
                $('#updateform .btn').html('Please wait…');
            },
            success: function (response) {
                $('#updateform .btn').removeAttr('disabled', 'disabled');
                $('#updateform .btn').html('submit');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Action added',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 700);
                } else {
                    $('#updateform .alert').show();
                    $('#updateform .alert').html(response.errors);
                }
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    $('.delete').click(function () {
        var id = $(this).attr('data-action-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {
                        id: id
                    },
                    success: function (data) {

                        if (data == "ok") {
                            Swal.fire({
                                title: "Deleted",
                                text: 'the action has been Deleted ',
                                icon: 'success',
                                confirmButtonColor: '#5b73e8'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: "error",
                                text: 'sorry wa have a error',
                                icon: 'error',
                                confirmButtonColor: '#5b73e8'
                            });
                        }
                    },
                    ajaxError: function () {
                        Swal.fire({
                            title: "error",
                            text: 'sorry wa have a error',
                            icon: 'error',
                            confirmButtonColor: '#5b73e8'
                        });
                    }
                });
            }
        });
    });

    $('select[name="Priority"]').change(function () {
        var id = $(this).val();
        console.log(id);
        if (id !== <?= $report->priority ?>) {
            $('#updatePriority button').show();
        } else {
            $('#updatePriority button').hide();
        }
    });
    $("#updatePriority").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#updatePriority .btn').attr('disabled', 'disabled');
                $('#updatePriority .btn').html('Please wait…');
            },
            success: function (response) {
                $('#updatePriority .btn').removeAttr('disabled', 'disabled');
                $('#updatePriority .btn').html('submit');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Action added',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 700);
                } else {
                    Swal.fire({
                        title: 'sorry!',
                        text: 'We have unexpected error , please try again later.',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    })
</script>