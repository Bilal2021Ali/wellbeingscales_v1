<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css"); ?>">
<style>
    .table {
        width: 100% !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <br>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> REP 047: تقرير الأمراض</h4>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">تقرير الأمراض</h3>
                    <hr>
                    <form method="post" id="search">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">تحديد المراحل الدراسية<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="classes[]">تحديد الجميع</span>
                                <select name="classes[]" id="" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="إختر الصفوف">
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?= $class['Id'] ?>"><?= $class['Class']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">الفحوصات<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="tests[]">تحديد الجميع</span>
                                <select name="tests[]" id="" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="أسماء الإختبارات">
                                    <?php foreach ($tests as $test) { ?>
                                        <option value="<?= $test['Test_Desc'] ?>"><?= $test['Test_Desc']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label class="form-label">النطاق الزمني للبحث <span class="text-danger">*</span>:</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" autocomplete="off" placeholder="تاريخ البداية" />
                                    <input type="text" class="form-control" name="end" autocomplete="off" placeholder="تاريخ الإنتهاء" />
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2" type="submit">عرض التقرير</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <h4 class="card-title" style="background: #add138; padding: 10px;color: #add138;border-radius: 4px;">التقارير</h4>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#teachers" id="default_active_tab_teacher" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                            <span class="d-none d-sm-block">المعلمين</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Staff" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">الموظفين</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#students" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">الطلاب</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content p-3 text-muted results">
                    <div class="tab-pane active" id="teachers" role="tabpanel">
                        لا يوجد بيانات
                    </div>
                    <div class="tab-pane" id="Staff" role="tabpanel">
                         لا يوجد بيانات
                    </div>
                    <div class="tab-pane" id="students" role="tabpanel">
                         لا يوجد بيانات
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>


<script>
    $('.s-all').click(function() {
        var target = $(this).attr('data-target-select');
        $('select[name="' + target + '"] option').attr('selected', '');
        var selectedItems = [];
        var allOptions = $('select[name="' + target + '"]');
        allOptions.each(function() {
            selectedItems.push($(this).val());
        });
        console.log(selectedItems);
        $('select[name="' + target + '"]').select2("val", selectedItems);
    });

    $('.select2').select2({
        closeOnSelect: false,
        allowClear: true
    });
    // submit
    $("#search").on('submit', function(e) {
        $('button[type="submit"]').attr('disabled', '');
        $('button[type="submit"]').html('Please wait...');
        $('.results').html('Please wait...');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url("AR/schools/labs_report"); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data, status, xhr) {
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').html('Generate');
                var ct = xhr.getResponseHeader("content-type") || "";
                $('.tab-pane , .nav-link').removeClass('active');
                $('#teachers , #default_active_tab_teacher').addClass('active');
                if (ct.indexOf('html') > -1) {
                    $('.results').html(data);
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 300,
                        "timeOut": 7000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    Command: toastr["error"](data.messages)
                }
            },
            ajaxError: function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 7000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                Command: toastr["error"]("لدينا خطأ ، يرجى المحاولة مرة أخرى في وقت لاحق");
            }
        });
    });

    $(document).on("keypress", ".select2-input", function(event) {
        if (event.ctrlKey || event.metaKey) {
            var id = $(this).parents("div[class*='select2-container']").attr("id").replace("s2id_", "");
            var element = $("#" + id);
            if (event.which == 97) {
                var selected = [];
                element.find("option").each(function(i, e) {
                    selected[selected.length] = $(e).attr("value");
                });
                element.select2("val", selected);
            } else if (event.which == 100) {
                element.select2("val", "");
            }
        }
    });
</script>