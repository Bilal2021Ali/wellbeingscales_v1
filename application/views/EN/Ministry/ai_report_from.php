<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css"); ?>">
<div class="main-content">
    <div class="page-content">
	 <h4 class="card-title" style="background: #add138; padding: 10px;color: #add138;border-radius: 4px;">REP 048: TOTAL OF DISEASES</h4>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">AI Report</h3>
                    <hr>
                    <form method="post" id="search">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Select Cities <span class="text-danger">*</span>:</label><span class="float-right text-primary btn s-all" data-target-select="cities[]">Select all</span>
                                <select name="cities[]" id="" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Select Cities">
                                    <?php foreach ($cities as $city) { ?>
                                        <option value="<?= $city['Id'] ?>"><?= $city['Name_EN'] . " (" . $city['useTimes'] . ") "; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Select School <span class="text-danger">*</span>:</label>
                                <select name="school[]" id="schoolsSelect" class="select2 form-control"  multiple="multiple"  data-placeholder="Select School">
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Select Classes<span class="text-danger">*</span>:</label><span class="float-right text-primary btn s-all" data-target-select="classes[]">Select all</span>
                                <select name="classes[]" id="supported_classes" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Select Classes">
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?= $class['Id'] ?>"><?= $class['Class']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Test Types<span class="text-danger">*</span>:</label> <span class="float-right text-primary btn s-all" data-target-select="tests[]">Select all</span>
                                <select name="tests[]" id="" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Test Types">
                                    <?php foreach ($tests as $test) { ?>
                                        <option value="<?= $test['Test_Desc'] ?>"><?= $test['Test_Desc']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">Date Range <span class="text-danger">*</span>:</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" autocomplete="off" placeholder="Start Date" />
                                    <input type="text" class="form-control" name="end" autocomplete="off" placeholder="End Date" />
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2" type="submit">Generate </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="response" class="col-12">
            
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<script>
    $('select[name="cities[]"]').change(function() {
        $("#schools").empty();
        var cityId = $('select[name="cities[]"]').val();
        $('#schoolsSelect').select2({
            closeOnSelect: false,
            allowClear: true,
            placeholder: 'Select schools',
            ajax: {
                url: '<?= base_url("EN/DashboardSystem/av_schools_in_city"); ?>',
                dataType: 'json',
                type: 'POST',
                data: {
                    city_Id: cityId,
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
            }
        });
    });

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


    $("#search").on('submit', function(e) {
        $('button[type="submit"]').attr('disabled', '');
        $('button[type="submit"]').html('Please wait...');
        $('.results').html('Please wait...');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data, status, xhr) {
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').html('Generate');
                var ct = xhr.getResponseHeader("content-type") || "";
                if (ct.indexOf('html') > -1) {
                    $('#response').html(data);
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