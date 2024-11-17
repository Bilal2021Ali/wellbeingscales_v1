<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Untitled Document</title>
</head>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/timePicker.css">
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/app.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
<style>
    .card {
        border: 0px;
        width: 100%;
        box-shadow: 0 0px 0px rgba(15, 34, 58, 0.12);
    }

    .uil-circuit {
        font-size: 22px;
        margin-right: 10px;
        color: #00a707;
    }

    .lastresult {
        text-align: center;
        border: 2px solid #0eacd8;
    }

    .lastresult span {
        font-size: 12px;
    }

    .lastresult * {
        color: #fff;
    }

    .custom-select {
        width: 130px;
        float: right;
        margin-top: -50px;
    }

    input[type="color"] {
        width: 50px;
        padding: 0px;
        border: 0px;
        border-radius: 100% !important;
        margin: auto;
        height: 50px;
        display: inline-block;
        -webkit-appearance: none;
        float: right;
        margin-right: 137px;
    }

    #color {
        -webkit-appearance: none;
        padding: 0;
        border: none;
        border-radius: 100%;
        width: 30px;
        height: 30px;
    }

    #color::-webkit-color-swatch {
        border: none;
        border-radius: 100%;
        padding: 0;
    }

    #color::-webkit-color-swatch-wrapper {
        border: none;
        border-radius: 100%;
        padding: 0;
    }

    .ShowData {
        width: 100%;
        background: transparent;
        border: 0px;
        font-size: 18px;
        margin-bottom: -15px;
        text-align: center;
        transition: 0.2s all;
    }

    .ShowData:hover {
        transition: 0.2s all;
        font-size: 22px;
    }

    .timepicker li.cell-2:hover {
        background: #5b73e8;
        color: #fff;
        border-radius: 5px;
    }
</style>
<?php
// <?php echo $data[0]['Area']; 	
$data = $this->db->query("
SELECT 
`air_result`.`device_id`,
air_result.* ,
`air_areas`.`Description` as `Area`
FROM `air_result` 
JOIN `air_areas` ON `air_areas`.`Id` = `air_result`.`device_id`
WHERE `air_result`.`User_type` = 'Company_Department' 
AND `air_result`.`source_id` = '" . $sessiondata['admin_id'] . "' 
AND `air_areas`.`user_type` = 'Company_Department' AND
`air_areas`.`source_id` =  '" . $sessiondata['admin_id'] . "'
AND `air_areas`.`mac_adress` = '" . $device_mac . "'
ORDER BY `air_result`.`Id` DESC ")->result_array();
//print_r($data);	
?>

<body>
    <div class="main-content">
        <div class="page-content">
            <?php if (!empty($data)) {  ?>
                <div class="container-fluid">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="uil uil-circuit"></i>Area details </h4>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="card">
                            <div class="card-body">
                                <h3>Specification</h3>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #694811">
                                            <div class="card-body">
                                                <h2>AQ</h2>
                                                <h3> <?php echo $data[0]['aq']  ?> <span>ppm</span></h3>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #364692">
                                            <div class="card-body">
                                                <h3>Carbon dioxide (co²)</h3>
                                                <h3> <?php echo $data[0]['co2']  ?> <span>ppm</span></h3>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #2E338C">
                                            <div class="card-body">
                                                <h3>Humidity</h3>
                                                <h3> <?php echo $data[0]['humidity']  ?> <span>%</span></h3>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #F25C69">
                                            <div class="card-body">
                                                <h3>Temperature</h3>
                                                <h3> <?php echo $data[0]['Temperature_c']  ?> <span>c°</span></h3>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-box align-items-center justify-content-between" style="background: #fff;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Daily</span> </a>
                                            </li>
                                            <li class="nav-item" onClick="getweekly()"> <a class="nav-link" data-toggle="tab" href="#getweekly" role="tab"> <span class="d-block d-sm-none"><i class="far fa-user"></i></span> <span class="d-none d-sm-block">Weekly</span> </a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages1" role="tab"> <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span> <span class="d-none d-sm-block">Specific Date</span> </a> </li>
                                        </ul>
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="home1" role="tabpanel">
                                                <form id="Daily">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control bs-timepicker" placeholder="From" id="Daily_from" required length="5" autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control bs-timepicker" placeholder="To" id="Daily_to" required length="5" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="row pl-2 pr-2">
                                                        <button type="Submit" class="btn btn-primary waves-effect w-100"> Show Results <i class="uil uil-angle-down"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="getweekly" role="tabpanel"></div>
                                            <div class="tab-pane" id="messages1" role="tabpanel">
                                                <form id="specific_date">
                                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                                                        <input type="text" class="form-control" placeholder="From" name="Start" autocomplete="off" id="specific_date_from" required>
                                                        <input type="text" class="form-control" placeholder="To" name="End" autocomplete="off" id="specific_date_to" required>
                                                    </div>
                                                    <div class="row pl-2 pr-2">
                                                        <button type="Submit" class="btn btn-primary waves-effect w-100"> Show Results <i class="uil uil-angle-down"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-title-desc">Result Graphs
                                            <input class="form-control" type="color" value="#5b8ce8" id="color" data-toggle="tooltip" data-placement="top" title="" data-original-title="the line color">
                                        </p>
                                        <select id="type" class="custom-select">
                                            <option value="aq">Air Quality</option>
                                            <option value="humidity">humidity</option>
                                            <option value="dewpoint_c">dewpoint c</option>
                                            <option value="Temperature_c">Temperature c</option>
                                            <option value="Temperature_f">Temperature f</option>
                                            <option value="ch2o">Ch2O</option>
                                            <option value="dewpoint_f">dewpoint f</option>
                                            <option value="pc0_3">pc 0.3</option>
                                            <option value="pc1">pc 1</option>
                                            <option value="pc2_5">pc 2.5</option>
                                            <option value="pc5">pc 5</option>
                                            <option value="pc10">pc 10</option>
                                            <option value="pm">pm</option>
                                            <option value="pm1">pm 1</option>
                                            <option value="pc5">pc 5</option>
                                            <option value="pc10">pc 10</option>
                                            <option value="Pressure">Pressure</option>
                                        </select>
                                        <div id="line_chart_dashed" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  } else {  ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="error-img"> <img src="<?php echo base_url() ?>assets/images/no_data_in_table.svg" alt="" class="img-fluid mx-auto d-block"> </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-uppercase mt-4">No data </h4>
                            <p class="text-muted">Sorry, we cannot find any results. </p>
                        </div>
                    </div>
                </div>
            <?php  }  ?>
        </div>
    </div>
    <script src="<?php echo base_url() ?>assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
    <script>
        $(function() {
            $('.bs-timepicker').timepicker();
        });

        var json_data = <?php echo json_encode($data);  ?>;

        function getweekly() {
            json_data = $.parseJSON($.ajax({
                url: '<?php echo base_url() ?>AR/Ajax/gitDeviceResults',
                dataType: "json",
                async: false,
                type: 'POST',
                data: {
                    device_mac: '<?php echo $device_mac  ?>',
                    type: 'weekly',
                }
            }).responseText);
            drawChart($('#type').children("option:selected").val());
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 300,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            }
            Command: toastr["success"]("The data was updated successfully!", "success")
        }

        var options = {
            chart: {
                height: 380,
                type: "line",
                zoom: {
                    enabled: !0
                },
                toolbar: {
                    show: !0
                }
            },
            colors: ["#5b8ce8"],
            dataLabels: {
                enabled: !1
            },
            stroke: {
                width: [3, 4, 3],
                curve: "smooth",
                dashArray: [0, 8, 5]
            },
            series: [{
                name: "",
                data: []
            }],
            title: {
                text: "",
                align: "left"
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: []
            },
            tooltip: {
                y: [{
                    title: {
                        formatter: function(e) {
                            return e;
                        }
                    }
                }, {
                    title: {
                        formatter: function(e) {
                            return e;
                        }
                    }
                }, {
                    title: {
                        formatter: function(e) {
                            return e
                        }
                    }
                }]
            },
            grid: {
                borderColor: "#f1f1f1"
            }
        };

        var chart = new ApexCharts(document.querySelector("#line_chart_dashed"), options);
        chart.render();


        $("#Daily").on('submit', function(e) {
            e.preventDefault();
            json_data = $.parseJSON($.ajax({
                url: '<?php echo base_url() ?>AR/Ajax/gitDeviceResults',
                dataType: "json",
                async: false,
                type: 'POST',
                data: {
                    device_mac: '<?php echo $device_mac  ?>',
                    from: $('#Daily_from').val(),
                    to: $('#Daily_to').val(),
                    type: 'Daily',
                }
            }).responseText);
            drawChart($('#type').children("option:selected").val());
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 300,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            }
            Command: toastr["success"]("The data was updated successfully!", "success")
        });

        $("#specific_date").on('submit', function(e) {
            e.preventDefault();
            if ($('#specific_date_from').val().length == 10 && $('#specific_date_to').val().length == 10) {
                json_data = $.parseJSON($.ajax({
                    url: '<?php echo base_url() ?>AR/Ajax/gitDeviceResults',
                    dataType: "json",
                    async: false,
                    type: 'POST',
                    data: {
                        device_mac: '<?php echo $device_mac  ?>',
                        from: $('#specific_date_from').val(),
                        to: $('#specific_date_to').val(),
                        type: 'specific_date',
                    }
                }).responseText);
                drawChart($('#type').children("option:selected").val());
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 300,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                }
                Command: toastr["success"]("The data was updated successfully!", "success")
            } else {
                Swal.fire(
                    'sorry',
                    'Please enter the dates',
                    'warning');
            }
        });

        $("#type").change(function() {
            var selected_type = $(this).children("option:selected").val();
            drawChart(selected_type);
        });

        drawChart("aq");

        console.log(json_data);

        function drawChart(passed_type, first = "") {
            var val = passed_type;
            var data_arr = [];
            var categories_arr = [];
            json_data.map(data_json => {
                switch (val) {
                    case "humidity":
                        data_arr.push(data_json.humidity);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "dewpoint_c":
                        data_arr.push(data_json.dewpoint_c);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "Temperature_c":
                        data_arr.push(data_json.Temperature_c);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "Temperature_f":
                        data_arr.push(data_json.Temperature_f);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "aq":
                        data_arr.push(data_json.aq);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "ch2o":
                        data_arr.push(data_json.ch2o);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "dewpoint_f":
                        data_arr.push(data_json.dewpoint_f);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pc0_3":
                        data_arr.push(data_json.pc0_3);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pc1":
                        data_arr.push(data_json.pc1);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pc2_5":
                        data_arr.push(data_json.pc2_5);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pc5":
                        data_arr.push(data_json.pc5);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pc10":
                        data_arr.push(data_json.pc10);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pm":
                        data_arr.push(data_json.pm);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pm1":
                        data_arr.push(data_json.pm1);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pm2_5":
                        data_arr.push(data_json.pm2_5);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "pm10":
                        data_arr.push(data_json.pm10);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    case "Pressure":
                        data_arr.push(data_json.Pressure);
                        categories_arr.push(data_json.TimeStamp);
                        break;
                    default:
                        console.log(val);
                }
            });
            chart.updateSeries([{
                name: val.replace('_', ' '),
                data: data_arr,
            }]);
            chart.updateOptions({
                xaxis: {
                    categories: categories_arr,
                },
                title: {
                    text: val.replace('_', ' '),
                    align: "left"
                }
            });
            window.scrollTo(0, document.body.scrollHeight);
        }

        var color = "#5b8ce8";
        $('#color').change(function() {
            color = $('#color').val();
            chart.updateOptions({
                colors: [color],
            });
            window.scrollTo(0, document.body.scrollHeight);
        });
    </script>

</html>