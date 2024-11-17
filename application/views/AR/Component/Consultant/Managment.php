<style>
    * {
        transition: 0.3s all;
    }

    .card {
        border: 0px;
    }

    /* modal animation */
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }

    .zoom-in {
        transform-origin: top;
        transform: scale(0) !important;
        opacity: 0;
        -webkit-transition: 0.5s all 0s;
        -moz-transition: 0.5s all 0s;
        -ms-transition: 0.5s all 0s;
        -o-transition: 0.5s all 0s;
        transition: 0.5s all 0s;
        display: block !important;
    }

    .zoom-in.show {
        opacity: 1;
        transform: scale(1) !important;
        transform: none;
    }
</style>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">

        <div id="ConsultantsForm" class="modal fade zoom-in" tabindex="-1" role="dialog"
             aria-labelledby="ConsultantsFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ConsultantsFormLabel">المستشار</h5>
                        <button type="button" class="btn-close btn-rounded text-danger btn" data-dismiss="modal"
                                aria-label="Close"><i class="uil uil-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <label type="button" class="btn btn-outline-dark w-100" for="avatar-image">
                            إختر صورة شخصية
                        </label>
                        <input type="file" accept="image/*" id="avatar-image" class="form-control mb-2 hidden"
                               name="avatar"/>
                        <label>اسم المستشار:</label>
                        <input type="text" class="form-control mb-2" name="name" placeholder="اسم المستشار"/>
                        <label>حساب المستشار (يجب أن لا يكون مكرر) :</label>
                        <div class="input-group">
                            <div class="input-group-text text-danger"><i class="uil uil-times"></i></div>
                            <input type="text" class="form-control" name="username" placeholder="اسم حساب المستشار">
                        </div>
                        <label class="mt-1"><?= $sessiondata['type'] == "Ministry" ? "Schools" : "Departments" ?>
                            :</label>
                        <select multiple="multiple" data-placeholder="تحديد..." class="form-control children"
                                name="children[]"></select>
                        <input type="hidden" name="_activeid">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <br>
        <h4 class="card-title"
            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            MOE 001 - إدارة حسابات المستشارين:
            <button class="btn btn-success waves-effect waves-light float-right add-a-consultant"><i
                        class="uil uil-plus"></i>إضافة
            </button>
        </h4>

        <div class="row">
            <?php foreach ($accounts as $sn => $consultant) { ?>
                <div class="col-xl-3 col-sm-6 consultant-account-<?= $consultant['Id'] ?>">
                    <div class="card text-center shadow-none">
                        <div class="card-body">
                            <div class="mb-4">
                                <img src="<?= $consultant['avatar'] ?? `"https://ui-avatars.com/api/?background=random&name=" . $consultant['name']` ?>"
                                     alt=""
                                     class="avatar-lg rounded-circle img-thumbnail">
                            </div>
                            <h5 class="font-size-16 mb-1 text-dark"><?= $consultant['name'] ?>
                                (<?= $consultant['ChildrenCounter'] ?>)</h5>
                            <p class="text-muted mb-2">@<?= $consultant['Username'] ?></p>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" data-key="<?= $consultant['Id'] ?>"
                                    class="btn btn-outline-light text-truncate text-danger delete"><i
                                        class="uil uil-trash me-1"></i>حذف
                            </button>
                            <button type="button" data-key="<?= $consultant['Id'] ?>"
                                    class="btn btn-outline-light text-truncate text-warning edit"><i
                                        class="uil uil-pen me-1"></i>تعديل
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<script>
    $('.add-a-consultant').click(function () {
        $(".children").val('');
        $('.children').trigger('change');
        $('#ConsultantsForm input[name="name"]').val("");
        $('#ConsultantsForm input[name="username"]').val("");
        $('#ConsultantsForm input[name="_activeid"]').val("");
        $("#ConsultantsForm").modal('show');
    });
    // select 2
    var data = <?= json_encode($children) ?>;
    $(".children").select2({
        data: data,
        closeOnSelect: false,
        allowClear: true
    });

    // saving new account
    $('form.modal-content').on('submit', function (e) {
        e.preventDefault();
        // var method = $('#ConsultantsForm input[name="_activeid"]').val() == "" ? "POST" : "PUT";
        $.ajax({
            type: "POST",
            url: "<?= current_url() ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.status == "ok") {
                    command: toastr['success']("success", 'تم إنشاء الحساب بنجاح.');
                    setTimeout(() => {
                        location.reload(true);
                    }, 500);
                } else {
                    command: toastr['error'](response.message);
                }
            }
        });
    });

    $(document).on('click', '.edit', function (e) {
        var id = $(this).attr('data-key');
        $.ajax({
            type: "GET",
            url: "<?= current_url() ?>/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    // setting the old children
                    $(".children").val(response.children);
                    $('.children').trigger('change');
                    // setting the old data 
                    $('#ConsultantsForm input[name="name"]').val(response.details.name);
                    $('#ConsultantsForm input[name="username"]').val(response.details.Username);
                    $('#ConsultantsForm input[name="_activeid"]').val(response.details.Id);
                    // opening the dialog form
                    $("#ConsultantsForm").modal('show');
                } else {
                    command: toastr['error'](response.message);
                }
            }
        });
    });

    $(document).on('click', '.delete', function (e) {
        const $this = $(this);
        Swal.fire({
            title: 'هل أنت متأكد',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `نعم`,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url(); ?>/" + $($this).attr('data-key'),
                    success: function (response) {
                        if (response.status == "ok") {
                            command: toastr['success']("success", 'تم حذف الحساب بنجاح.');
                            $(".consultant-account-" + $($this).attr('data-key')).slideUp(400, function () {
                                $(".consultant-account-" + $($this).attr('data-key')).remove();
                            });
                        } else {
                            alert('خطأ غير متوقع ، يرجى المحاولة مرة أخرى في وقت لاحق')
                        }
                    }
                });
            }
        });
    });
</script>