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
	<br><br>
                            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> REP 047: Disease Report</h4>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Disease Report</h3>
                    <hr>
                    <form method="post" id="search">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Select Classes<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="classes[]">Select all</span>
                                <select name="classes[]" id="" class="select2 form-control select2-multiple" multiple="multiple">
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?= $class['Id'] ?>"><?= $class['Class']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="" class="mt-1">Select Section<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="grades[]">Select all</span>
                                <select name="grades[]" id="" class="select2 form-control select2-multiple" multiple="multiple">
                                    <?php foreach ($this->config->item("av_grades") as $grade) { ?>
                                        <option value="<?= $grade['value'] ?>"><?= $grade['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Date Range <span class="text-danger">*</span>:</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" autocomplete="off" placeholder="Start Date" />
                                    <input type="text" class="form-control" name="end" autocomplete="off" placeholder="End Date" />
                                </div>
                                <label class="form-label">Test Types<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="tests[]">Select all</span>
                                <select name="tests[]" id="" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Test Types">
                                    <?php foreach ($tests as $test) { ?>
                                        <option value="<?= $test['Test_Desc'] ?>"><?= $test['Test_Desc']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2" type="submit">Generate </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
		<h4 class="card-title" style="background: #add138; padding: 10px;color: #add138;border-radius: 4px;">Report</h4>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#teachers" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                            <span class="d-none d-sm-block">Teachers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#students" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Students</span>
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
                "title": "Name"
            },
            {
                "data": "Result",
                "title": "Result"
            },
            {
                "data": "testName",
                "title": "Test Type"
            },
            {
                "data": "resultDate",
                "title": "Date & time"
            },
            {
                "data": "Action",
                "title": "Action"
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
                "title": "Name"
            },
            {
                "data": "Result",
                "title": "Result"
            },
            {
                "data": "testName",
                "title": "Test Type"
            },
            {
                "data": "resultDate",
                "title": "Date & time"
            },
            {
                "data": "Action",
                "title": "Action"
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
            url: '<?= base_url("EN/schools/disease_report"); ?>',
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
                        data.students[i]['Result'] = student.Result == 1 ? '<span class="badge rounded-pill bg-danger text-white">Positive</span>' : '<span class="badge rounded-pill bg-success text-white">Negative</span>';
                    });
                    students_table.clear();
                    students_table.rows.add(data.students);
                    students_table.draw();
                    // teachers
                    data.teachers.forEach((student , s) => {
                        data.teachers[s]['#'] = s + 1;
                        data.teachers[s]['Result'] = student.Result == 1 ? '<span class="badge rounded-pill bg-danger text-white">Positive</span>' : '<span class="badge rounded-pill bg-success text-white">Negative</span>';
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
                Command: toastr["error"]("We have an error, Please try again later");
            }
        });
    });
</script>