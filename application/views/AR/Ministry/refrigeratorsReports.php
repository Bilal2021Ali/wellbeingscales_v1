<link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css"); ?>">

<div class="main-content">
    <div class="page-content">
        <div class="caontainer">
            <div class="card">
                <div class="card-body">
                    <form class="row mb-3" method="POST">
                        <div class="col-lg-4">
                            <label class="form-label">تحديد المدرسة<span class="text-danger">*</span>:</label>
                            <select name="department" class="form-control">
                                <option value="" <?= $department == "" ? "selected" : "" ?>>الجميع</option>
                                <?php foreach ($depts as $dept) { ?>
                                    <option value="<?= $dept['Id'] ?>" <?= $department == $dept['Id'] ? "selected" : "" ?>><?= $dept['School_Name_AR'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">تحديد الثلاجة<span class="text-danger">*</span>:</label>
                            <select name="machine" class="form-control">
                                <option value="" <?= $selected == "" ? "selected" : "" ?>>الجميع</option>
                                <?php foreach ($machiens as $machine) { ?>
                                    <option value="<?= $machine['id'] ?>" <?= $selected == $machine['id'] ? "selected" : "" ?>><?= $machine['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">تحديد الرحلة<span class="text-danger">*</span>:</label>
                            <select name="trip_name" class="form-control">
                                <option value="" <?= $tripName == "" ? "selected" : "" ?>>الجميع</option>
                                <?php foreach ($trips as $trip) { ?>
                                    <option value="<?= $trip['trip_name'] ?>" <?= $tripName == $trip['trip_name'] ? "selected" : "" ?>><?= $trip['trip_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 mt-2" type="submit">بناء التقرير</button>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>المدرسة</th>
                            <th>التاريخ &amp; الوقت</th>
                            <th>عنوان الرحلة</th>
                            <th>النتيجة</th>
                            <th>درجة الرطوبة</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                        </thead>
                        <tbody>
                            <?php $sn = 1; ?>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td><?= $sn++  ?></td>
                                    <td><?= $result['deptName'] ?? '--' ?></td>
                                    <td><?= $result['mUtcTime'] ?></td>
                                    <td><?= $result['trip_name'] ?></td>
                                    <td><?= $result['Result'] ?></td>
                                    <td><?= $result['Humidity'] ?></td>
                                    <td><?= $result['Created'] ?></td>
                                    <td><?= $result['Time'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>

<script>
    $('select[name="department"]').change(function() {
        var id = $(this).children('option:selected').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/machenesForDepartment',
            data: {
                dept_id: id,
            },
            success: function(data) {
                if (Object.keys(data).length > 0) {
                    $('select[name="machine"]').html('<option value="" >All</option>');
                    for (let i = 0; i < Object.keys(data).length; i++) {
                        $('select[name="machine"]').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                    }
                } else {
                    $('select[name="machine"]').html('<option value="" >All</option>');
                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                )
            }
        });
    });
    $('select[name="machine"]').change(function() {
        // updating the trips list based on machine id
        var id = $(this).children('option:selected').val();
        var trip_names = {};
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/DashboardSystem/tripNames_forthisMachine',
            data: {
                machine_id: id,
            },
            success: function(data) {
                if (Object.keys(data).length > 0) {
                    $('select[name="trip_name"]').html('<option value="" >All</option>');
                    for (let i = 0; i < Object.keys(data).length; i++) {
                        $('select[name="trip_name"]').append('<option value="' + data[i].trip_name + '">' + data[i].trip_name + '</option>');
                    }
                } else {
                    $('select[name="trip_name"]').html('<option value="" >All</option>');
                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                )
            }
        });
    });
    //chart
    var options = {
        chart: {
            height: 380,
            type: 'line',
            zoom: {
                enabled: true
            },
            toolbar: {
                show: true
            }
        },
        colors: ['#5b73e8', '#f1b44c'],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: [3, 3],
            curve: 'straight'
        },
        series: [{
                name: "النتيجة",
                data: [<?= implode(',', $results_chart) ?>]
            },
            {
                name: "درجة الرطوبة",
                data: [<?= implode(',', $Humidity_chart) ?>]
            }
        ],
        title: {
            text: 'متوسط درجة الحرارة والرطوبة',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.2
            },
            borderColor: '#f1f1f1'
        },
        markers: {
            style: 'inverted',
            size: 6
        },
        xaxis: {
            categories: [<?= implode(',', $time_chart) ?>],
            title: {
                text: 'التاريخ (<?= date("Y-m-d") ?>)'
            }
        },
        yaxis: {
            title: {
                text: 'النتيجة'
            },
            min: <?= !empty($Humidity_chart) || !empty($results_chart) ? min($Humidity_chart) < min($results_chart) ?  min($Humidity_chart) : min($results_chart) : 0 ?>,
            max: <?= !empty($Humidity_chart) || !empty($results_chart) ? max($Humidity_chart) > max($results_chart) ?  max($Humidity_chart) : max($results_chart) : 0 ?>,
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -5,
            offsetX: -5
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    toolbar: {
                        show: false
                    }
                },
                legend: {
                    show: false
                },
            }
        }]
    }

    var chart = new ApexCharts(
        document.querySelector("#line_chart_datalabel"),
        options
    );
    chart.render();

    $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });
</script>