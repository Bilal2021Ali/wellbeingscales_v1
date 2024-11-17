<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css"); ?>">
<style>
    .table {
        width: 100% !important;
    }

    .badge  {
        padding: 10px;
    }
</style>
<div class="main-content">
    <div class="page-content">
	<br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> REP 047: تقرير الأمراض</h4>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">تقرير الأمراض</h3>
                    <hr>
                    <form method="post" id="search">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">حدد المراحل الدراسية:<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="classes[]">حدد الجميع</span>
                                <select name="classes[]" id="" class="select2 form-control select2-multiple" multiple="multiple">
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?= $class['Id'] ?>"><?= $class['Class']; ?></option>
                                    <?php } ?>
                                </select>
								
                                <label for="" class="mt-1">حدد الصفوف الدراسية:<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="grades[]">حدد الجميع</span>
                                <select name="grades[]" id="" class="select2 form-control select2-multiple" multiple="multiple">
                                    <?php foreach ($this->config->item("av_grades") as $grade) { ?>
                                        <option value="<?= $grade['value'] ?>"><?= $grade['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">النطاق الزمني <span class="text-danger">*</span>:</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" autocomplete="off" placeholder="من تاريخ:" />
                                    <input type="text" class="form-control" name="end" autocomplete="off" placeholder="إلى تاريخ:" />
                                </div>
								
                                <label class="form-label">نوع الفحص:<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="tests[]">جميع الفحوصات</span>
                                <select name="tests[]" id="" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Tests Names">
                                    <?php foreach ($tests as $test) { ?>
                                        <option value="<?= $test['Test_Desc'] ?>"><?= $test['Test_Desc']; ?></option>
                                    <?php } ?>
                                </select>
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
                        <a class="nav-link active" data-toggle="tab" href="#teachers" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                            <span class="d-none d-sm-block">المعلمين</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#students" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">الطلاب</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="teachers" role="tabpanel">
                        <p class="mb-0">
                        <table id="teachers_table"></table>
                        </p>
                    </div>
                    <div class="tab-pane" id="students" role="tabpanel">
                        <p class="mb-0">
                        <table id="students_table"></table>
                        </p>
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

    var students_table = $('#students_table').DataTable({
        columns: [{
                "data": "#",
                "title": "#"
            },
            {
                "data": "name",
                "title": "الإسم"
            },
            {
                "data": "Result",
                "title": "النتيجة"
            },
            {
                "data": "testName",
                "title": "نوع الفحص"
            },
            {
                "data": "resultDate",
                "title": "تاريخ الفحص"
            },
            {
                "data": "Action",
                "title": "الوضع الصحي"
            }
        ]
    });
    var teachers_table = $('#teachers_table').DataTable({
        columns: [{
                "data": "#",
                "title": "#"
            },
            {
                "data": "name",
                "title": "الاسم"
            },
            {
                "data": "Result",
                "title": "النتيجة"
            },
            {
                "data": "testName",
                "title": "نوع الفحص"
            },
            {
                "data": "resultDate",
                "title": "تاريخ الفحص"
            },
            {
                "data": "Action",
                "title": "الوضع الصحي"
            }
        ]
    });

    $('.select2').select2({
        closeOnSelect: false
    });
    // submit
    $("#search").on('submit', function(e) {
        e.preventDefault();
        $('button[type="submit"]').attr('disabled', '');
        $('button[type="submit"]').html('Please wait.....');
        $.ajax({
            type: 'POST',
            url: '<?= base_url("AR/schools/disease_report"); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').html('Generate');
                if (data.status == "ok") {
                    data.students.forEach((student , i) => {
                        data.students[i]['#'] = i+1;
                        data.students[i]['Result'] = student.Result == 1 ? '<span class="badge rounded-pill bg-danger text-white">إيجابي</span>' : '<span class="badge rounded-pill bg-success text-white">سلبي</span>';
                        if(student.Action == "الحجر المنزلي"){
                            data.students[i]['Action'] = 'الحجر المنزلي';
                        }else if(student.Action == "الحجر الصحي"){
                            data.students[i]['Action'] = 'الحجر الصحي';
                        }else{
                            data.students[i]['Action'] = 'المدرسة';
                        }
                    });
                    students_table.clear();
                    students_table.rows.add(data.students);
                    students_table.draw();
                    // teachers
                    data.teachers.forEach((teacher , s) => {
                        data.teachers[s]['#'] = s + 1;
                        data.teachers[s]['Result'] = teacher.Result == 1 ? '<span class="badge rounded-pill bg-danger text-white">إيجابي</span>' : '<span class="badge rounded-pill bg-success text-white">سلبي</span>';
                        if(teacher.Action == "الحجر المنزلي"){
                            data.teachers[s]['Action'] = 'الحجر المنزلي';
                        }else if(teacher.Action == "الحجر الصحي"){
                            data.teachers[s]['Action'] = 'الحجر الصحي';
                        }else{
                            data.teachers[s]['Action'] = 'المدرسة';
                        }
                    });
                    teachers_table.clear();
                    teachers_table.rows.add(data.teachers);
                    teachers_table.draw();
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
</script>