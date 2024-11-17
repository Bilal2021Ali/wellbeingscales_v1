<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
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

    .switch.disabled {
        opacity: 0.1;
    }

    .switch.disabled .slider.round {
        cursor: default !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">قائمة الجو العام:</h4>
                <br>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#navtahome" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">مكتبة الجو العام:</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#navtaprofile" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">قائمة الجو العام المنشورة:</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="navtahome" role="tabpanel">
                        <h3 class="card-title">مكتبة الجو العام:</h3>
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>التصنيف</th>
                                <th>العنوان</th>
                                <th>السؤال</th>
                                <th>الإجراءات</th>
                                </thead>
                                <tbody>
                                <?php foreach ($surveys as $key => $survey) { ?>
                                    <tr id="serv_<?= $survey['survey_id'] ?>">
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $survey['created_at'] ?></td>
                                        <td><?= $survey['Cat_en']; ?><br><?= $survey['Cat_ar'] ?></td>
                                        <td><?= $survey['set_name_en']; ?><br><?= $survey['set_name_ar'] ?></td>
                                        <td><?= $survey['question'] ?><br><?= $survey['question_ar'] ?></td>
                                        <td class="text-center">
                                            <a data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="معاينة"
                                               href="<?= base_url("AR/DashboardSystem/climatePreview/" . $survey['survey_id']); ?>"><i
                                                        class="uil uil-eye font-size-20"></i></a>
                                            <?php if (intval($survey['status']) == 1) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="استخدام الجو العام"
                                                   href="<?= base_url("AR/DashboardSystem/newclimatesurvey/" . $survey['survey_id']); ?>"><i
                                                            class="uil uil uil-channel font-size-20"></i></a>
                                            <?php } ?>
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
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>الفئة</th>
                                <th>العنوان</th>
                                <th>من تاريخ</th>
                                <th>إلى تاريخ</th>
                                <th>عداد الاستخدام</th>
                                <th>السؤال</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                                </thead>
                                <tbody>
                                <?php foreach ($oursurveys as $key => $oursurvey) { ?>
                                    <tr id="serv_<?= $oursurvey['survey_id'] ?>">
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $oursurvey['created_at'] ?></td>
                                        <td><?= $oursurvey['Cat_en']; ?><br><?= $oursurvey['Cat_ar'] ?></td>
                                        <td><?= $oursurvey['set_name_en']; ?><br><?= $oursurvey['set_name_ar'] ?></td>
                                        <td><?= $oursurvey['From_date']; ?></td>
                                        <td><?= $oursurvey['To_date']; ?></td>
                                        <td><?= $oursurvey['isUsed']; ?></td>
                                        <td><?= $oursurvey['question_ar'] ?><br><?= $oursurvey['question'] ?></td>
                                        <td>
                                            <label class="switch <?= intval($oursurvey['adminStatus']) == 0 ? 'disabled' : '' ?>"">
                                            <input type="checkbox"
                                                   name="ischecked" <?= intval($oursurvey['adminStatus']) == 0 ? 'disabled' : '' ?>
                                                   data-serv-id="<?= $oursurvey['survey_id']; ?>" <?= $oursurvey['status'] == 1 ? 'checked' : ""; ?>>
                                            <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <a data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="معاينة"
                                               href="<?= base_url("AR/DashboardSystem/climatePreview/" . $oursurvey['main_survey_id']); ?>"><i
                                                        class="uil uil-eye font-size-20"></i></a>
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
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script>
    $('table').DataTable();
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
    $('.table').on('click', '.delete', function () {
        var Id = $(this).attr('for');
        var key = $(this).attr('key');
        Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم,أحذفها!',
            cancelButtonText: 'لا, إلغاء!',
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
                            'oops!! لدينا خطأ',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // $('.table').on('change', 'input[name="ischecked"]', function() {
    //     var surveyId = $(this).attr('data-serv-Id');
    //     $.ajax({
    //         type: "PUT",
    //         url: "<?= current_url() ?>",
    //         data: {
    //             surveyId: surveyId
    //         },
    //         success: function(response) {
    //             if (response == "ok") {
    //                 Command: toastr["success"]("The Status has been successfully updated ");
    //             }
    //             else {
    //                 Command: toastr["error"]("unexpected error , please refresh tha page");
    //             }
    //         }
    //     });
    // });

    $('.table').on('change', 'input[name="ischecked"]', function () {
        if (typeof $(this).attr('disabled') == 'undefined') {
            return;
        }
        var surveyId = $(this).attr('data-serv-id');
        $.ajax({
            type: "PUT",
            url: "<?= current_url() ?>",
            data: {
                surveyId: surveyId
            },
            success: function (response) {
                if (response !== "ok") {
                    Command: toastr["error"]("unexpected error , please refresh tha page");
                }
            }
        });
    });
</script>