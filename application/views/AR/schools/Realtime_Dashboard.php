<!doctype html>
<html>

<head>
    <meta charset="utf-8">
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

    .card-types {
        max-height: 370px;
        overflow: auto;
    }

    .card-types .type {
        cursor: pointer;
        padding: 10px;
        border: 1px solid rgb(58 58 58 / 23%);
        margin: 10px auto;
        border-radius: 5px;
        text-align: center;
        transition: 0.3s all;
    }

    .type.active_type {
        background: #34c38f;
        color: #fff;
        font-size: 25px;
        transition: 0.3s all;
    }

    .popover-body,
    .popover-header {
        box-shadow: 0px 0px 20px 9px rgb(0 0 0 / 12%);
    }

    .show_settings {
        cursor: pointer;
    }

    .refresh {
        transform: rotate(0deg);
        cursor: pointer;
        float: left;
        transition: 0.3s all;
    }

    .rotate {
        transform: rotate(-180deg);
        transition: 0.3s all;
    }
</style>
<?php
// <?php echo $data[0]['Area']; 	
$data = $this->db->query("
SELECT 
`air_result_gateway`.`device_id`,
air_result_gateway.* ,
`air_areas`.`Description` as `Area`
FROM `air_result_gateway` 
JOIN `air_areas` ON `air_areas`.`Id` = `air_result_gateway`.`device_id`
WHERE `air_result_gateway`.`User_type` = 'school' 
AND `air_result_gateway`.`source_id` = '" . $sessiondata['admin_id'] . "' 
AND `air_areas`.`user_type` = 'school' AND
`air_areas`.`source_id` =  '" . $sessiondata['admin_id'] . "'
AND `air_areas`.`mac_adress` = '" . $device_mac . "'
ORDER BY `air_result_gateway`.`Id` DESC ")->result_array();
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
                                <h4 class="card-title"><i class="uil uil-circuit"></i>تفاصيل المنطقة</h4>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="card">
                            <div class="card-body">
                                <h3>تخصيص</h3>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #694811">
                                            <div class="card-body">
                                                <h3> <?php echo $data[0]['aq']  ?> <span>ppm</span></h3>
                                                <h6>AQ</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #364692">
                                            <div class="card-body">
                                                <h3> <?php echo $data[0]['co2']  ?> <span>ppm</span></h3>
                                                <h6>Carbon dioxide (co²)</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #2E338C">
                                            <div class="card-body">
                                                <h3> <?php echo $data[0]['humidity']  ?> <span>%</span></h3>
                                                <h6>Humidity</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card lastresult" style="background: #F25C69">
                                            <div class="card-body">
                                                <h3> <?php echo $data[0]['Temperature_c']  ?> <span>c°</span></h3>
                                                <h6>Temperature</h6>
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
                                                        <button type="Submit" class="btn btn-primary waves-effect w-100"> إعرض النتائج <i class="uil uil-angle-down"></i></button>
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
                                                        <button type="Submit" class="btn btn-primary waves-effect w-100"> إعرض النتائج <i class="uil uil-angle-down"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title-desc">Result Graphs</p>
                                    <div id="line_chart_dashed" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center">
                                        <i class="uil uil-refresh refresh" title="reset"></i>
                                        Types <i class="uil uil-setting show_settings" style="float:right;" title="Show Settings"></i>
                                        <hr>
                                    </h3>
                                    <div class="card-types" data-simplebar="init">
                                        <div class="type" value="aq">Air Quality</div>
                                        <div class="type" value="ch2o">Ch2O</div>
                                        <div class="type" value="co2">CO2</div>
                                        <div class="type" value="dewpoint_c">Dewpoint C</div>
                                        <div class="type" value="dewpoint_f">Dewpoint F</div>
                                        <div class="type" value="humidity">Humidity</div>
                                        <div class="type" value="voc_EtOH">VOC EtOH</div>
                                        <div class="type" value="voc_Isobutylene">VOC Isobutylene</div>
                                        <div class="type" value="Temperature_c">Temperature c</div>
                                        <div class="type" value="Temperature_f">Temperature f</div>
                                        <div class="type" value="Pressure">Pressure</div>
                                        <div class="type" value="pc0_3">PC 0.3</div>
                                        <div class="type" value="pc5">PC 5.0</div>
                                        <div class="type" value="pc1">PC 1.0</div>
                                        <div class="type" value="pc2_5">PC 2.5</div>
                                        <div class="type" value="pc10">PC 10.0</div>
                                        <div class="type" value="pm">PM</div>
                                        <div class="type" value="pm1">PM1</div>
                                        <div class="type" value="pm2_5">PM2.5</div>
                                        <div class="type" value="pc10">PM10</div>
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
                                        <div class="error-img">
                                            <img src="<?php echo base_url() ?>assets/images/no_data_in_table.svg" alt="" class="img-fluid mx-auto d-block">
                                        </div>
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
    <section>
        <div id="PopoverContent" class="d-none">
            <div class="input-group">
                <input type="number" class="form-control" placeholder="Max" id="MaxVal" min="3" max="6" onChange="setNewVal(this.value)">
            </div>
        </div>
    </section>
    <script src="<?php echo base_url() ?>assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
    <script>
        var lastchoiced = "default";

        $(function() {
            $('.bs-timepicker').timepicker();
            $('.show_settings').popover({
                container: 'body',
                title: 'max Choice Types in one time',
                html: true,
                placement: 'right',
                sanitize: false,
                content: function() {
                    return $("#PopoverContent").html();
                }
            });
        });


        function setNewVal(val) {
            localStorage.setItem('maxLenght', val);
        }


        var json_data = <?php echo json_encode($data);  ?>;
        var selected_types = [];
        console.log("start ::");
        console.log(json_data);


        $('.refresh').click(function() {
            $(this).addClass('rotate');
            $('#refreshed').addClass('show');
            setTimeout(function() {
                $(this).removeClass('rotate');
            }, 500);
            selected_types = [];
            drawChart();
            $('.active_type').removeAttr('index');
            $('.type').removeClass('active_type');
        });

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
            lastchoiced = "weekly";
            drawChart(json_data);
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
                type: 'category',
                categories: [],
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
            lastchoiced = "daily";
            drawChart();
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
                lastchoiced = "specific_date";
                drawChart();
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

        $(".type").click(selected_types = selected_types, function() {
            var type = $(this).attr('value');
            var max = localStorage.getItem("maxLenght") ?? 3;
            Number(max);
            if (selected_types.length <= (max - 1)) {
                if (!$(this).hasClass('active_type')) {
                    $(this).attr('index', selected_types.length);
                    if (selected_types.length <= Number(max)) {
                        selected_types.push(type);
                        drawChart();
                    }
                    $(this).addClass('active_type');
                } else {
                    const index = $(this).attr('index');
                    selected_types.splice(index, 1);
                    $(this).removeAttr('index');
                    drawChart();
                    $(this).removeClass('active_type');
                }
            } else if ($(this).hasClass('active_type')) {
                const index = $(this).attr('index');
                selected_types.splice(index, 1);
                $(this).removeAttr('index');
                drawChart();
                $(this).removeClass('active_type');
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'لقد وصلت إلى الحد الأقصى لعدد الأنواع لكل رسم بياني.',
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: false
                });
            }
        });

        drawChart();

        function checkData(val) {
            var data_arr = [];
            var categories_arr = [];
            var typeOfgatig = 'TimeStamp';
            if (lastchoiced == "daily") {
                typeOfgatig = 'time';
            }
            json_data.map(data_json => {
                switch (val) {
                    case "humidity":
                        data_arr.push(data_json.humidity);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "dewpoint_c":
                        data_arr.push(data_json.dewpoint_c);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "Temperature_c":
                        data_arr.push(data_json.Temperature_c);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "Temperature_f":
                        data_arr.push(data_json.Temperature_f);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "co2":
                        data_arr.push(data_json.co2);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "VOC EtOH":
                        data_arr.push(data_json.voc_EtOH);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "VOC Isobutylene":
                        data_arr.push(data_json.voc_Isobutylene);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "PM2.5":
                        data_arr.push(data_json.pm2_5);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "aq":
                        val = "AQ";
                        data_arr.push(data_json.aq);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "ch2o":
                        data_arr.push(data_json.ch2o);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "dewpoint_f":
                        data_arr.push(data_json.dewpoint_f);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pc0_3":
                        data_arr.push(data_json.pc0_3);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pc1":
                        data_arr.push(data_json.pc1);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pc2_5":
                        data_arr.push(data_json.pc2_5);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pc5":
                        data_arr.push(data_json.pc5);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pc10":
                        data_arr.push(data_json.pc10);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pm":
                        data_arr.push(data_json.pm);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pm1":
                        data_arr.push(data_json.pm1);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pm2_5":
                        data_arr.push(data_json.pm2_5);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "pm10":
                        data_arr.push(data_json.pm10);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    case "Pressure":
                        data_arr.push(data_json.Pressure);
                        categories_arr.push(data_json[typeOfgatig]);
                        break;
                    default:
                        console.log(val);
                }
            });

            return {
                categories_arr: categories_arr,
                data_arr: data_arr,
                val: val
            };
        }


        function generatecolor() {
            const randomColor = Math.floor(Math.random() * 16777215).toString(16);
            return "#" + randomColor;
        }


        function drawChart() {
            var vals = selected_types;
            const series = [];
            const cotigories = [];
            var i;
            for (i = 0; i < vals.length; i++) {
                var returned = checkData(vals[i]);
                if (cotigories.length <= 0) {
                    cotigories.push(returned.categories_arr);
                }
                console.log('-* categories_arr *-');
                console.log(returned.categories_arr);
                console.log(returned.data_arr);
                series.push({
                    name: returned.val.replace('_', ' '),
                    data: [{
                        x: returned.categories_arr,
                        y: returned.data_arr
                    }],
                });
                //name: val.replace('_',' '),
                //data: data_arr,
            }
            chart.updateSeries(series);
            var colors_arr = [];
            var i;
            for (i = 0; i < series.length; i++) {
                colors_arr.push(generatecolor());
            }
            console.log(series);
            chart.updateOptions({
                /*xaxis: {
                  categories: cotigories,
                },*/
                colors: colors_arr,
            });
        }
    </script>

</html>