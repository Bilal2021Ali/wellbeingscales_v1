<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
    .card {
        border: 0px;
    }

    td,
    th {
        text-align: center;
    }

    .uil-download-alt {
        cursor: pointer;
    }

    #btn-Convert-Html2Image {
        display: none;
    }

    .rotateChart {
        cursor: pointer;
        font-size: 20px;
    }
</style>
<!-- this is the specific type of  : survey_reports page -->

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;margin-top: -30px;">CHDD 001 التقرير التفصيلي للإستبيان</h4>
                </div>
                <div class="col-lg-4">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHDD 002 آخر المشاركين في الإستبيان</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted"><?= $type_of_user_name ?> </span>
                                    </a>
                                </div>
                            </div>

                            <h4 class="card-title mb-4"> آخر المشاركين في الإستبيان</h4>
                            <div class="w-100 " data-simplebar style="height: 386px;">
                                <ol class="activity-feed mb-0 pl-2 all active">
                                    <?php foreach ($reportdata as $user_passed) { ?>
                                        <li class="feed-item">
                                            <p class="text-muted mb-1 font-size-13"><?php echo $user_passed['U_Name'] ?><small class="d-inline-block ml-1"><?= $user_passed['Finished_at']; ?></small></p>
                                            <p class="mt-0 mb-0">فئة المستخدمين: <?php echo $user_passed['UserType'] ?> </p>
                                            <p class="mt-0 mb-0">زمن إنهاء الإستبيان: <?php echo $user_passed['Finish_time'] ?> </p>
                                        </li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHDD 003 تفاصيل الإستبيان</h4>
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-8">
                                    <p class="text-white font-size-18"><b>تفاصيل الإستبيان</b><i class="mdi mdi-arrow-right"></i></p>
                                    <div class="mt-4">
                                        <a href="<?php echo base_url("AR/schools/survey_report_view/" . $serv_id); ?>" class="btn btn-success waves-effect waves-light">التفاصيل>></a>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mt-4 mt-sm-0">
                                        <img src="<?php echo base_url(); ?>assets/images/setup-analytics-amico.svg" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
                <div class="col-lg-4">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHDD 003 عدد المشاركين في الإستبيان</h4>
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-4">
                                <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                    <i class="uil uil-user"></i>
                                </div>
                            </div>
                            <h1 class="text-muted mb-0"><?php echo sizeof($reportdata); ?></h1>
                            <p class="font-size-15 text-uppercase">"<?= $type_of_user_name ?> المشاركين في الإستبيان</p>
                        </div>
                    </div>
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHD 074 PERCENTAGE OF SURVEY RESPONSES</h4>
                    <div class="card" id="donut_chart_card">
                        <div class="card-body" style="height: 460px;display: grid;">
                            <h4 class="card-title mb-4">PERCENTAGE OF SURVEY RESPONSES<i class="uil uil-download-alt float-right" onclick="savechart('donut_chart_card')"></i></h4>
                            <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHD 073 USERS CHART</h4>
                    <div class="card" id="radial_chart_card">
                        <?php if ($type_of_user == "Students") { ?>
                            <div class="card-body">
                                <h4 class="card-title mb-4">USERS CHART <i class="uil uil-download-alt float-right" onclick="savechart('radial_chart_card')"></i></h4>
                                <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        <?php } else { ?>
                            <div class="card-body text-center">
                                <img src="<?= base_url('assets/images/profile_studnt.png') ?>" class="w-100" alt="">

                            </div>
                        <?php } ?>
                    </div>
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHD 076 PERCENTAGE OF GENDER</h4>
                    <div class="card" id="genders_chart_card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">PERCENTAGE OF GENDER<i class="uil uil-download-alt float-right" onclick="savechart('genders_chart_card')"></i></h4>
                            <div id="genders_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                    <!--end card-->
                </div> <!-- end col -->
            </div>
            <?php $all_count_public = 0; ?>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHD 077 تقرير الأسئلة</h4>
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th> السؤال </th>
                                    <?php foreach ($used_choices as $used_choice) { ?>
                                        <th><?= $used_choice['choices_ar'] ?></th>
                                    <?php } ?>
                                    <th> الأكثر اختيارًا </th>
                                </thead>
                                <tbody>
                                    <?php foreach ($quastions as $sn => $quastion) { ?>
                                        <?php $results_array = array(); ?>
                                        <tr>
                                            <td><?php echo $sn + 1 ?></td>
                                            <td data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $quastion['ar_title'] ?>" class="text-truncate" style="max-width: 100px;"><?= $quastion['ar_title'] ?></td>
                                            <?php foreach ($used_choices as $key => $used_choice) {
                                                $use_count = $this->db->query(" SELECT `sv_st1_answers_values`.`Id` FROM `sv_st1_answers_values` 
                                                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` =  `sv_st1_answers_values`.`answers_data_id` AND `sv_st1_answers`.`user_type` = '" . $user_code . "'
                                                WHERE `question_id` = '" . $quastion['Id'] . "' AND `choice_id` = '" . $used_choice['Id'] . "' AND `answers_data_id` IN (". implode(',' ,  array_column($users_passed_survey , 'answerKey') ).")")->num_rows();
                                                $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $quastion['Id'] . "'  ")->num_rows();
                                                $all_count_public += $all_count;
                                                for ($i = 0; $i < sizeof($used_choices); $i++) {
                                                    $old_count =  $choice_arr[$i]["counter"];
                                                    if ($choice_arr[$i][0] == $used_choice['choices_ar']) {
                                                        $choice_arr[$i]['counter'] += $use_count;
                                                    }
                                                }
                                                $results_array[] = array("key" => $key, "used_choice" => $used_choice['choices_ar'], "using_count" => $use_count, "using_perc" => calc_perc($use_count, $all_count));
                                            ?>
                                                <td><?php echo $use_count; ?> <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Frequency/Percentage">( <?= calc_perc($use_count, $all_count); ?> % ) </span></td>
                                            <?php } ?>
                                            <td><?php showTheMustUsed($results_array); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <?php
                                $names = array_column($choice_arr, 0);
                                $vals = array_column($choice_arr, "counter");
                                $new_arr = array_map(function ($name) {
                                    return "'" . $name . "'";
                                }, $names);
                                $vals_arr = array();
                                foreach ($vals as $key => $value) {
                                    $vals_arr[] = $value;
                                }
                                $used_coices_labes = implode(',', $new_arr);
                                $used_coices_values = implode(',', $vals_arr);
                                ?>
                                <tfoot>
                                    <th>#</th>
                                    <th>السؤال</th>
                                    <?php foreach ($vals as $val) { ?>
                                        <th>تم إختيارها <?= $val ?> مرات</th>
                                    <?php } ?>
                                    <th> الأكثر اختيارًا </th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHD 078 ANSWERS CHART</h4>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">ANSWERS COUNTERS</h4>
                            <div id="column_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                    <!--end card-->
                    <a href="" id="btn-Convert-Html2Image">Click here</a>
                </div>
                <div class="col-xl-12">
                    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHD 079 AGE CHART</h4>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">مبيان الأعمار</h4>
                            <div id="ageschart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                    <!--end card-->
                    <a href="" id="btn-Convert-Html2Image">Click here</a>
                </div>
            </div>
        </div>
        <pre>

        </pre>

</body>
<script src="<?php echo base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"); ?>"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<script src="<?php echo base_url("assets/js/html2canvas.js") ?>"></script>
<?php
function showTheMustUsed($results_array)
{
    $final_result = array();
    $last_one = 00;
    foreach ($results_array as $key => $result) {
        if ($result['using_count'] >= $last_one && $result['using_count'] !== 00) {
            // echo "last id =".$last_one.' and hadak is'.$result['using_count'] ;
            $final_result[] = $result["used_choice"] . ' (' . $result['using_perc'] . '% )';
            $last_one = $result['using_count'];
        }
    }
    echo empty(implode(', ', $final_result)) ? "--" : implode(', ', $final_result);
}
?>
<script>
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];

    function savechart(id) {
        var element = $("#" + id); // global variable
        var getCanvas; // global variable
        // Now browser starts downloading it instead of just showing it
        html2canvas($("#" + id)[0], {
            dpi: 192,
        }).then(function(canvas) {
            $("#btn-Convert-Html2Image").attr("download", Math.random(10000, 88888) + ".png").attr("href", canvas.toDataURL("image/png"));
            document.getElementById("btn-Convert-Html2Image").click();
        });
    }


    var btns = $('.table').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#DataTables_Table_0_wrapper .col-md-6:eq(0)');

    options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: true,
            }
        },
        plotOptions: {
            bar: {
                horizontal: 0,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff', "#fff"]
            }
        },
        stroke: {
            show: !1,
            width: 2,
            colors: ["transparent"]
        },
        series: [
            <?php
            foreach ($used_choices as $choice) {
                $data = array();
                foreach ($users_types as $type) {
                    $use_count = $this->db->query(" SELECT `sv_st1_answers_values`.`Id` FROM `sv_st1_answers_values` 
                        JOIN `sv_st1_answers` ON `sv_st1_answers_values`.`answers_data_id` = `sv_st1_answers`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "'
                        WHERE `choice_id` = '" . $choice['Id'] . "' ")->num_rows();
                    $data[] = $use_count;
                }
            ?> {
                    name: "<?php echo $choice['choices_ar'] ?>",
                    data: [<?php echo implode(",", $data) ?>]
                },
            <?php } ?>
        ],
        colors: colors,
        xaxis: {
            categories: ["<?= $type_of_user_name  ?>"]
        },
        yaxis: {
            title: {
                text: "Total"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(e) {
                    return e + " مرات";
                }
            }
        }
    };
    (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render();

    var perc_choices_options = {
        chart: {
            height: 320,
            type: "donut"
        },

        series: [<?php echo $used_coices_values; ?>],
        toolbar: {
            show: true,
        },
        labels: [<?php echo $used_coices_labes; ?>],
        colors: colors,
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: !1
                }
            }
        }]
    };
    (chart = new ApexCharts(document.querySelector("#donut_chart"), perc_choices_options)).render();

    <?php if ($type_of_user == "Students") { ?>
        var by_classes_options = {
            chart: {
                height: 320,
                type: "donut"
            },

            series: [<?php echo implode(',', $levels); ?>],
            toolbar: {
                show: true,
            },
            labels: [<?php echo implode(',', $lables_arr); ?>],
            colors: colors,
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        };
        (chart = new ApexCharts(document.querySelector("#radial_chart"), by_classes_options)).render();

    <?php } ?>
    var agesoptions = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: true,
            }
        },
        plotOptions: {
            bar: {
                horizontal: 0,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff', "#fff"]
            }
        },
        stroke: {
            show: !1,
            width: 2,
            colors: ["transparent"]
        },
        series: [
            <?php foreach ($ages as $key => $age) { ?> {
                    name: "<?php echo $key ?> years",
                    data: [<?php echo $age ?>]
                },
            <?php } ?>
        ],
        colors: colors,
        xaxis: {
            categories: ["<?= $type_of_user_name  ?>"]
        },
        yaxis: {
            title: {
                text: "Total"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(e) {
                    return e + "  user(s)";
                }
            }
        }
    };
    (chart = new ApexCharts(document.querySelector("#ageschart"), agesoptions)).render();

    var perc_genders_options = {
        chart: {
            height: 320,
            type: "donut"
        },
        series: [<?php echo $males_count ?>, <?php echo $females_count; ?>],
        labels: ["ذكور", "إناث"],
        colors: ["#0fbcf9", "#ef5777"],
        legend: {
            show: true,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: true
                }
            }
        }]
    };
    (chart = new ApexCharts(document.querySelector("#genders_chart"), perc_genders_options)).render();
</script>
<?php

function calc_perc($perc, $all)
{
    $x = $perc;
    $y = $all;
    if ($x > 0 && $y > 0) {
        $percent = $x / $y;
        $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
    } else {
        $percent_friendly = 0; // change 2 to # of decimals
    }
    return $percent_friendly;
}
?>

</html>