<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<?php
$prioritys = array(
    [
        "id" => "0",
        "name" => "متوسط"
    ], [
        "id" => "1",
        "name" => "طاريء"
    ], [
        "id" => "2",
        "name" => "هام"
    ], [
        "id" => "3",
        "name" => "هام جدا"
    ]
);
?>
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

    section {
        position: absolute;
        top: 0px;
        left: 80px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container">
            <div class="modal fade addaction" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ملاحظات جديدة:</h5>
                            <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="new">
                                <div class="alert alert-danger" role="alert"></div>
                                <label class="form-label">تقرير:</label><br>
                                <select class="form-control select2 w-100 mb-2" name="user" id="">
                                    <optgroup label="الموظفين">
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option value="staff:<?= $staff['Id'] ?>"><?= $staff['F_name_AR'] . " " . $staff['L_name_AR'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="المعلمين">
                                        <?php foreach ($teachers as $teacher) { ?>
                                            <option value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_AR'] . " " . $teacher['L_name_AR'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                                <br>
                                <label for="">ملاحظاتك باللغة الإنجليزية:</label>
                                <textarea name="text_en" id="" cols="30" rows="8" class="form-control" placeholder="ملاحظاتك باللغة الإنجليزية"></textarea>

                                <label for="">ملاحظاتك باللغة العربية:</label>
                                <textarea name="text_ar" id="" cols="30" rows="8" class="form-control" placeholder="ملاحظاتك باللغة العربية"></textarea>

                                <input type="hidden" name="type" value="new">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100  mt-1">حفظ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade update" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تحديث الملاحظات:</h5>
                            <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="updateform">
                                <div class="alert alert-danger" role="alert"></div>
                                <input type="hidden" name="id" value="">
                                <label class="form-label">التقرير بواسطة:</label><br>
                                <select class="form-control select2 w-100 mb-2" name="user" id="">
                                    <optgroup label="Staff">
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option id="staff__<?= $staff['Id'] ?>" value="staff:<?= $staff['Id'] ?>"><?= $staff['F_name_EN'] . " " . $staff['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="Teacher">
                                        <?php foreach ($teachers as $teacher) { ?>
                                            <option id="teacher__<?= $teacher['Id'] ?>" value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_EN'] . " " . $teacher['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                                <br>
                                <label for="">تحديث الملاحظات باللغة الانجليزية:</label>
                                <textarea name="text_en" id="" cols="30" rows="8" class="form-control" placeholder="تحديث الملاحظات باللغة الانجليزية"></textarea>

                                <label for="">تحديث الملاحظات باللغة العربية:</label>
                                <textarea name="text_ar" id="" cols="30" rows="8" class="form-control" placeholder="تحديث الملاحظات باللغة العربية"></textarea>

                                <input type="hidden" name="type" value="update">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100 mt-1">حفظ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade update-priority" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تحديث أولوية الشكوى:</h5>
                            <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="updatePriority">
                                <label class="form-label">تحديد الاولوية:</label><br>
                                <input type="hidden" name="type" value="priority">
                                <select class="form-control select2 w-100 mb-2" name="Priority" id="">
                                    <?php foreach ($prioritys as $priority) { ?>
                                        <option value="<?= $priority['id'] ?>" <?= $priority['id'] == $report->priority ? 'selected' : '' ?>><?= $priority['name'] ?> <?= $priority['id'] == $report->priority ? '| الحالية ' : '' ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100 mt-1">تحديث</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 100: متابعة الشكوى</h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <label for="priority">الاهمية: <span class="badge rounded-pill" style="background-color: <?= priority($report->priority)['bg'] ?>;color : #fff;"><?= priority($report->priority)['text'] ?></span><i class="uil uil-pen float-right edit ml-2" data-toggle="modal" data-target=".update-priority"></i>
                                <?php if ($report->closed !== '1') { ?>
                                    <section data-toggle="modal" data-target=".addaction">
                                        <button class="feedback_btn addone" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add new action">
                                            <i class="uil uil-plus"></i>
                                        </button>
                                    </section>
                                <?php } ?>
                            </label>
                            <hr>
                            <?php if (!empty($actions)) { ?>
                                <div id="accordion" class="custom-accordion">
                                    <?php foreach ($actions as $sn => $action) { ?>
                                        <a href="#collapse_<?= $sn ?>" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapse_<?= $sn ?>">
                                            <div class="card-header mt-1" id="headingThree">
                                                <h6 class="m-0">
                                                    <strong><?= $action['action_by'] ?? "---" ?> | <span class="ml-1"><?= $action['TimeStamp'] ?></span></strong>
                                                    <i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                                    <?php if ($report->closed !== '1') { ?>
                                                        <i class="uil uil-trash float-right delete mr-2" data-action-id="<?= $action['Id'] ?>"></i>
                                                        <i class="uil uil-pen float-right edit mr-2" data-action-id="<?= $action['Id'] ?>" data-toggle="modal" data-target=".update"></i>
                                                    <?php } ?>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapse_<?= $sn ?>" class="collapse <?= $sn == 0 ? "show" : "" ?>" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="accordion-body">
                                                <?= $action['text_ar'] ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                               بدون إجراءات
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<?php
function status($status)
{
    $response = array('text' => 0, 'bg' => 0);
    if ($status == 0) {
        $response['text'] = "معلقة";
        $response['bg'] = "#ffc003";
    } elseif ($status == 1) {
        $response['text'] = "تم مشاهدتها";
        $response['bg'] = "#8ea9dd";
    } elseif ($status == 2) {
        $response['text'] = "تم حلها";
        $response['bg'] = "#528235";
    } else {
        $response['text'] = "تم معالجتها";
        $response['bg'] = "#93d04e";
    }
    return $response;
}

function priority($status)
{
    $response = array('text' => 0, 'bg' => 0);
    if ($status == 0) {
        $response['text'] = "متوسط";
        $response['bg'] = "#01aff3";
    } elseif ($status == 1) {
        $response['text'] = "طاريء";
        $response['bg'] = "#c00000";
    } elseif ($status == 2) {
        $response['text'] = "هام";
        $response['bg'] = "#ff4f4f";
    } else {
        $response['text'] = "هام جدا";
        $response['bg'] = "#fe0000";
    }
    return $response;
}
?>
<script>
    $('.select2').select2();
    $('#new .alert').hide();
    $('#updateform .alert').hide();
    $('#updatePriority button').hide();
    // new
    $("#new").on('submit', function(e) {
        e.preventDefault();
        $('#new .alert').hide();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#new .btn').attr('disabled', 'disabled');
                $('#new .btn').html('Pleas wait ...');
            },
            success: function(response) {
                $('#new .btn').removeAttr('disabled', 'disabled');
                $('#new .btn').html('submit');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'تمت بنجاح',
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
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
    // update action
    $('.edit').click(function() {
        var id = $(this).attr('data-action-id');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                type: "olddata",
                id: id,
            },
            success: function(response) {
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
                        text: "لم نتمكن من العثور على هذا الإجراء ، يرجى تحديث الصفحة والمحاولة مرة أخرى",
                        icon: 'error'
                    });
                }
            }
        });
    });
    //update
    $("#updateform").on('submit', function(e) {
        e.preventDefault();
        $('#updateform .alert').hide();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#updateform .btn').attr('disabled', 'disabled');
                $('#updateform .btn').html('Pleas wait ...');
            },
            success: function(response) {
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
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! تم العثور على خطأ.");
            }
        });
    });

    $('.delete').click(function() {
        var id = $(this).attr('data-action-id');
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم ، احذفها!',
            cancelButtonText: 'لا ، إلغاء!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        if (data == "ok") {
                            Swal.fire({
                                title: "Deleted",
                                text: 'تم حذف الإجراء ',
                                icon: 'success',
                                confirmButtonColor: '#ff69fd'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: "error",
                                text: 'آسف لدينا خطأ',
                                icon: 'error',
                                confirmButtonColor: '#ff69fd'
                            });
                        }
                    },
                    ajaxError: function() {
                        Swal.fire({
                            title: "error",
                            text: 'آسف لدينا خطأ',
                            icon: 'error',
                            confirmButtonColor: '#5b73e8'
                        });
                    }
                });
            }
        });
    });

    $('select[name="Priority"]').change(function() {
        var id = $(this).val();
        console.log(id);
        if (id !== <?= $report->priority ?>) {
            $('#updatePriority button').show();
        } else {
            $('#updatePriority button').hide();
        }
    });
    $("#updatePriority").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#updatePriority .btn').attr('disabled', 'disabled');
                $('#updatePriority .btn').html('Pleas wait ...');
            },
            success: function(response) {
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
                        text: 'لدينا خطأ غير متوقع ، يرجى المحاولة مرة أخرى في وقت لاحق.',
                        icon: 'error'
                    });
                }
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    })
</script>