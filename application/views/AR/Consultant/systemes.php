<style>
    * {
        transition: 0.5s all;
    }

    .table td.key {
        text-align: center;
        display: grid;
        justify-content: space-around;
        align-content: space-around;
        flex-wrap: wrap;
        height: 31px;
    }

    /* thead,
    tbody {
        width: 100%;
        display: table;
    } */

    .unselect,
    .delete-report {
        position: absolute;
        top: 26px;
        left: 14px;
        cursor: pointer;
    }

    .card {
        border-color: #dfdfdf;
    }

    .card.shadow-none {
        margin-bottom: 5px;
    }

    .successfully-uploaded,
    .successfully-uploaded * {
        transition: 0.2s all;
    }

    .successfully-uploaded {
        background: #34c38f !important;
        color: #fff;
    }

    .report-chat {
        position: absolute;
        top: 26px;
        left: 37px;
    }
</style>
<div class="main-content">
    <div class="page-content">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 select-systemes-container">
                        <h3 class="card-title mb-5"> لائحة الحسابات :
                            <button disabled type="button" class="btn btn-success waves-effect waves-light float-right upload-report">
                                <i class="uil-upload mr-2"></i><span class="mr-2">|</span> رفع تقرير
                            </button>
                        </h3>
                        <div class="select-systemes overflow-auto">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>الإسم</th>
                                    <?php if ($hasparent) { ?>
                                        <th> إسم <?= $type == "schools" ? 'الوزارة' : 'الشركة' ?> </th>
                                    <?php }  ?>
                                    <th>التاريخ</th>
                                    <th>إجرائات</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($systemes as $sn => $systeme) { ?>
                                        <tr id="systeme-upload-<?= $systeme['Id'] ?>">
                                            <td class="key">
                                                <span>
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="<?= $systeme['Id'] ?>" type="checkbox" data-key="<?= $systeme['Id'] ?>" name="systeme" id="systeme-check-<?= $systeme['Id'] ?>" class="custom-control-input school-select">
                                                        <label class="custom-control-label" id="systeme-check-label-<?= $systeme['Id'] ?>" for="systeme-check-<?= $systeme['Id'] ?>"><?= $sn + 1 ?></label>
                                                    </div>
                                                </span>
                                            </td>
                                            <td class="name"><?= $systeme['title'] ?></td>
                                            <?php if ($hasparent) { ?>
                                                <td><?= $systeme['ParentName'] ?></td>
                                            <?php } ?>
                                            <td class="added-at"><?= $systeme['TimeStamp'] ?></td>
                                            <td class="text-center">
                                                <button data-toggle="tooltip" data-placement="top" title="رفع" class="btn btn-rounded waves btn-success single-upload" data-key="<?= $systeme['Id'] ?>"><i class="uil uil-upload"></i></button>
                                                <button data-toggle="tooltip" data-placement="top" title="عرض التقارير" class="btn btn-rounded waves btn-warning show-uploads" data-key="<?= $systeme['Id'] ?>"><i class="uil uil-file"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-4 hidden selected-systemes-container">
                        <h3 class="card-title mb-4"> الحساب االمختارة:</h3>
                        <div class="overflow-auto selected-systemes">
                            <div class="card shadow-none">
                                <div class="card-body">
                                    <p class="mb-0 font-weight-bold text-dark">Name Here </p>
                                    <span class="font-weight-light text-muted">Date</span>
                                    <i data-toggle="tooltip" data-placement="top" title="unselect" key="0" class="uil uil-times float-right font-size-20 text-danger unselect"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="upload-new-report" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="upload-new-reportLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upload-new-reportLabel">رفع تقرير:</h5>
                        <button type="button" class="btn-close btn btn-rounded" data-dismiss="modal" aria-label="Close"><i class="uil-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <img src="<?= base_url("assets/images/uploadFilePlaceholder.png") ?>" class="selectFile btn" width="80" alt="">
                            <input type="file" accept="application/pdf" name="newFile" class="d-none">
                            <input type="hidden" name="id" />
                            <h3 class="mt-1 text-truncate">إضغط لإختيار ملف</h3>
                            <label class="float-left">تعليق</label>
                            <textarea class="form-control" rows="3" name="comments" placeholder="Comments">بدون تعليق</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.table').DataTable({
        responsive: true
    });
    $('.selected-systemes').css("max-height", document.getElementsByClassName('.select-systemes').offsetHeight);
    var checkedKeys = [];
    $(".table").on('change', '.school-select', function(e) {
        checkedKeys = [];
        checkedValues = [];
        $('.school-select:checked').each(function() {
            checkedKeys.push(this.value);
            checkedValues.push({
                "Key": this.value,
                "Name": $(this).parent().parent().parent().parent().find('.name').html(),
                "AddedAt": $(this).parent().parent().parent().parent().find('.added-at').html()
            });
        });
        RenderSelectedList(checkedValues);
    });

    const RenderSelectedList = (checkedValues) => {
        $('.selected-systemes').html('');
        // show / hide the selected systemes list
        if (checkedValues.length > 0) {
            $('.upload-report').removeAttr('disabled');
            $('.select-systemes-container').removeClass("col-12");
            $('.select-systemes-container').addClass("col-8");
            $('.selected-systemes-container h3').html("الحسابات المختارة :");
            setTimeout(() => { // wait until the transition finish
                $('.selected-systemes-container').removeClass("hidden");
            }, 500)
            checkedValues.forEach(value => {
                $('.selected-systemes').append(`<div class="card shadow-none">
                                    <div class="card-body">
                                        <p class="mb-0 font-weight-bold text-dark">${value.Name}</p>
                                        <span class="font-weight-light text-muted">${value.AddedAt}</span>
                                        <i data-toggle="tooltip" data-placement="top" title="unselect" data-key="${value.Key}" class="uil uil-times float-right font-size-20 text-danger unselect"></i>
                                    </div>
                                </div>`);
            });
        } else {
            $('.upload-report').attr('disabled', 'disabled');
            $('.select-systemes-container').removeClass("col-8");
            $('.select-systemes-container').addClass("col-12");
            $('.selected-systemes-container').addClass("hidden");
        }
    }

    $(".table").on('click', '.single-upload', function(e) { // single upload 
        $('#upload-new-report').modal('show');
        $('#upload-new-report form input[name="id"]').val($(this).attr('data-key'));
    });

    $("body").on('click', '.unselect', function(e) { // unselect checkbox
        var key = $(this).attr('data-key');
        var elem = document.getElementById("systeme-check-label-" + key);
        if (typeof elem.onclick == "function") {
            elem.onclick.apply(elem);
        } else {
            elem.click();
        }
    });

    $("body").on('click', '.delete-report', function(e) {
        var key = $(this).attr('data-key');
        const $this = $(this);
        Swal.fire({
            title: 'متأكد؟',
            text: "لن تستطيع التراجع عن هذا الخيار!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم , إحذف',
            cancelButtonText: 'تراجع',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url() ?>",
                    data: {
                        id: key,
                    },
                    success: function(response) {
                        if (response.status == "ok") {
                            $($this).parent().parent().remove();
                        } else {
                            Swal.fire({
                                title: "مشكلة",
                                html: response.message,
                                icon: "error"
                            });
                        }
                    }
                });
            }
        });
    });

    $('.upload-report').click(function() { // multiple upload
        $('#upload-new-report form input[name="id"]').val("");
        $('#upload-new-report').modal('show');
    });

    $('.selectFile').click(function() {
        $('#upload-new-report form input[name="newFile"]').trigger('click');
    });

    $('#upload-new-report form input[name="newFile"]').change(function(e) {
        $('#upload-new-report form h3').html('الملف :' + e.target.files[0].name);
    });

    $('#upload-new-report form').on('submit', function(e) {
        e.preventDefault();
        $('#upload-new-report button[type="submit"]').attr('disabled', '');
        $('#upload-new-report button[type="submit"]').html('المرجو الإنتظار...');
        var formdata = new FormData(this);
        let unique = [...new Set(checkedKeys)];
        formdata.append('ids', unique);
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#upload-new-report button[type="submit"]').removeAttr('disabled');
                $('#upload-new-report button[type="submit"]').html('حفظ');
                if (response.status == "ok") {
                    $('#upload-new-report').modal('hide');
                    Swal.fire({
                        title: "تم",
                        text: "تم الحفظ بنجاح",
                        icon: "success",
                        onClose: () => {
                            response.accounts.forEach(account => {
                                $('#systeme-upload-' + account).addClass('successfully-uploaded');
                            });
                            setTimeout(() => {
                                $('.successfully-uploaded').removeClass('successfully-uploaded');
                            }, 1000);
                        }
                    });
                } else {
                    Swal.fire({
                        title: "مشكلة",
                        html: response.message,
                        icon: "error"
                    });
                }
            }
        });
        $('#upload-new-report form h3').html('إضغط لإختيار ملف');
    });

    // control the old uploaded files
    $('.table').on('click', '.show-uploads', function() {
        const id = $(this).attr('data-key');
        $('.select-systemes-container').removeClass("col-12");
        $('.select-systemes-container').addClass("col-8");
        $('.selected-systemes-container').removeClass("hidden");
        $('.selected-systemes-container .selected-systemes').html('<div class="spinner-border text-dark m-1" role="status"><span class="sr-only">Loading...</span></div>');
        $('.selected-systemes-container h3').html(" التقارير المرفوعة :");
        $.ajax({
            type: "GET",
            url: "<?= current_url() ?>/" + id,
            success: function(response) {
                $('.selected-systemes-container .selected-systemes').html("");
                if (response.status = "ok") {
                    if (response.files.length > 0) {
                        response.files.forEach(file => {
                            $('.selected-systemes').append(`<div class="card shadow-none">
                                        <div class="card-body">
                                            <a href="${file.link}"><p class="mb-0 font-weight-bold text-dark">رابط التقرير</p></a>
                                            <span class="font-weight-light text-muted">${file.Comments || "بدون تعليق"}</span>
                                            <i data-toggle="tooltip" data-placement="top" title="حذف" data-key="${file.Id}" class="uil uil-trash float-right font-size-20 text-danger delete-report"></i>
                                            ${file.ChatMessages > 0 ? '<a href="<?= base_url("AR/Consultant/Chat/") ?>'+ file.Id +'"><i data-toggle="tooltip" data-placement="top" title="المحادثة" class="uil uil-message float-right font-size-20 text-warning report-chat"></i></a>' : '' }
                                        </div>
                                    </div>`);
                        });
                    } else {
                        $('.selected-systemes').html('لا توجد تقارير');
                    }
                } else {
                    Swal.fire({
                        title: "مشكلة",
                        html: response.message,
                        icon: "error"
                    });
                }
            }
        });

    });
</script>