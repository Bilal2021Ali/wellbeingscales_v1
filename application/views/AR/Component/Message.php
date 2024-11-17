<link rel="stylesheet" type="text/css" href="<?= base_url('assets/libs/toastr/build/toastr.min.css'); ?>">
<style>
    .loading {
        position: absolute;
        display: flex;
        align-items: center;
        width: 100%;
        height: 100%;
        text-align: center;
        background: #fff;
        z-index: 1000;
    }
</style>
<div class="main-content">
    <div class="page-content">
	<br>  <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CO026: نظام الرسائل </h4>
        <div class="col-xl-6 ">
            <form class="card needs-validation" novalidate>
                <div class="loading">
                    <div class="spinner-border text-info m-auto" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="card-title mb-2">أضف رسالة جديدة</h3>
                    <p>أضف رسالة جديدة إلى مكتبتك</p>
                    <hr>
                    <div>
                        <label for="validationTooltip01">الرسالة بالإنجليزي :</label>
                        <textarea name="messageen" id="validationTooltip01" data-parsley-min="6" data-parsley-max="1000" class="form-control mb-3" required placeholder="الرسالة بالإنجليزي"></textarea>
                        <div class="valid-tooltip">جيد</div>
                    </div>
                    <div>
                        <label for="validationTooltip02">الرسالة بالعربي:</label>
                        <textarea name="messagear" id="validationTooltip02" data-parsley-min="6" data-parsley-max="1000" class="form-control" required placeholder="الرسالة بالعربي"></textarea>
                        <div class="valid-tooltip">جيد</div>
                    </div>
                    <label class="mt-2">الخصوصية :</label>
                    <select name="status" class="form-control">
                        <option value="0">خاصة</option>
                        <option value="1">عامة</option>
                    </select>
                    <button type="submit" class="btn btn-primary waves-effect waves-light w-100 mt-2">
                        حفظ <i class="uil uil-users ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/parsleyjs/parsley.min.js') ?>"></script>
<script src="<?= base_url('assets/js/pages/form-validation.init.js') ?>"></script>
<script src="<?= base_url('assets/libs/toastr/build/toastr.min.js') ?>"></script>
<script>
    $('.loading').hide();
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
    $('form').submit(function (e) {   
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            type: "POST",
            url: "<?= base_url("AR/ajax/SaveMessage"); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('.loading').hide();
                if (response.status == "ok") {
                    Command: toastr["success"]("تم الحفظ بنجاح");
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }else{
                    Command: toastr["error"](response.message)
                }
            }
        });
    });
</script>