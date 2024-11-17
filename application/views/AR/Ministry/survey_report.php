<!-- this file for specific reports -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
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

<body>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    068 تقرير الاستبيانات</h4>
            </div>
            <div class="col-lg-4">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    069 النشاط الأخير</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="float-right">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="dropdownMenuButton3" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted">الجميع<i class="mdi mdi-chevron-down ml-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton3">
                                    <a class="dropdown-item" onclick="show_type_of('all')">الجميع</a>
                                    <a class="dropdown-item" onclick="show_type_of('Teachers')">المعلمين</a>
                                    <a class="dropdown-item" onclick="show_type_of('Students')">الطلاب</a>
                                    <a class="dropdown-item" onclick="show_type_of('Staffs')">الموظفين</a>
                                    <a class="dropdown-item" onclick="show_type_of('Parents')">أولياء الأمور</a>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title mb-4">النشاط الأخير</h4>
                        <div class="w-100 " data-simplebar style="height: 386px;">
                            <ol class="activity-feed mb-0 pl-2 all active">
                                <?php foreach ($users_passed_survey as $user_passed) { ?>
                                    <li class="feed-item">
                                        <p class="text-muted mb-1 font-size-13"><?= $user_passed['U_Name'] ?><small
                                                    class="d-inline-block ml-1"><?= $user_passed['Finished_at']; ?></small>
                                        </p>
                                        <p class="mt-0 mb-0">نوع المستخدم: <?= $user_passed['UserType'] ?> </p>
                                        <p class="mt-0 mb-0">وقت الانتهاء: <?= $user_passed['Finish_time'] ?> </p>
                                    </li>
                                <?php } ?>
                            </ol>

                            <ol class="activity-feed mb-0 pl-2 staffs">
                                <?php foreach ($Staffs as $user_passed) { ?>
                                    <li class="feed-item">
                                        <p class="text-muted mb-1 font-size-13"><?= $user_passed['U_Name'] ?><small
                                                    class="d-inline-block ml-1"><?= $user_passed['Finished_at']; ?></small>
                                        </p>
                                        <p class="mt-0 mb-0">نوع المستخدم:<?= $user_passed['UserType'] ?> </p>
                                        <p class="mt-0 mb-0">وقت الإنتهاء: <?= $user_passed['Finish_time'] ?> </p>
                                    </li>
                                <?php } ?>
                            </ol>

                            <ol class="activity-feed mb-0 pl-2 teachers">
                                <?php foreach ($Teachers as $user_passed) { ?>
                                    <li class="feed-item">
                                        <p class="text-muted mb-1 font-size-13"><?= $user_passed['U_Name'] ?><small
                                                    class="d-inline-block ml-1"><?= $user_passed['Finished_at']; ?></small>
                                        </p>
                                        <p class="mt-0 mb-0">نوع المستخدم: <?= $user_passed['UserType'] ?> </p>
                                        <p class="mt-0 mb-0">وقت الانتهاء: <?= $user_passed['Finish_time'] ?> </p>
                                    </li>
                                <?php } ?>
                            </ol>

                            <ol class="activity-feed mb-0 pl-2 Students">
                                <?php foreach ($Students as $user_passed) { ?>
                                    <li class="feed-item">
                                        <p class="text-muted mb-1 font-size-13"><?= $user_passed['U_Name'] ?><small
                                                    class="d-inline-block ml-1"><?= $user_passed['Finished_at']; ?></small>
                                        </p>
                                        <p class="mt-0 mb-0">نوع المستخدم:<?= $user_passed['UserType'] ?> </p>
                                        <p class="mt-0 mb-0">وقت الانتهاء: <?= $user_passed['Finish_time'] ?> </p>
                                    </li>
                                <?php } ?>
                            </ol>

                            <ol class="activity-feed mb-0 pl-2 Parents">
                                <?php foreach ($Parents as $user_passed) { ?>
                                    <li class="feed-item">
                                        <p class="text-muted mb-1 font-size-13"><?= $user_passed['U_Name'] ?><small
                                                    class="d-inline-block ml-1"><?= $user_passed['Finished_at']; ?></small>
                                        </p>
                                        <p class="mt-0 mb-0">نوع المستخدم: <?= $user_passed['UserType'] ?> </p>
                                        <p class="mt-0 mb-0">وقت الانتهاء: <?= $user_passed['Finish_time'] ?> </p>
                                    </li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </div>
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    070 عرض مباشر أكثر تفصيلاً</h4>
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <p class="text-white font-size-18">عرض التقارير <b>as live view</b> لتتبع أفضل <i
                                            class="mdi mdi-arrow-right"></i></p>
                                <div class="mt-4">
                                    <a href="<?= base_url("AR/DashboardSystem/survey_report_view/" . $serv_id); ?>"
                                       class="btn btn-success waves-effect waves-light">التفاصيل</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mt-4 mt-sm-0">
                                    <img src="<?= base_url(); ?>assets/images/setup-analytics-amico.svg"
                                         class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
            <div class="col-lg-4">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    071 الاستطلاعات</h4>
                <div class="card">
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item text-center active">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                            <i class="uil uil-user"></i>
                                        </div>
                                    </div>
                                    <h1 class="text-muted mb-0"><?= sizeof($users_passed_survey); ?></h1>
                                    <p class="text-muted">عداد المستجيبين للمستخدمين</p>
                                </div>
                                <div class="carousel-item text-center">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                            <i class="uil uil-user"></i>
                                        </div>
                                    </div>
                                    <h1 class="text-muted mb-0"><?= sizeof($Staffs); ?></h1>
                                    <p class="text-muted">عداد المستجيبين للموظفين</p>
                                </div>
                                <div class="carousel-item text-center">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                            <i class="uil uil-user"></i>
                                        </div>
                                    </div>
                                    <h1 class="text-muted mb-0"><?= sizeof($Teachers); ?></h1>
                                    <p class="text-muted">عداد المستجيبين المعلمين</p>
                                </div>
                                <div class="carousel-item text-center">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                            <i class="uil uil-user"></i>
                                        </div>
                                    </div>
                                    <h1 class="text-muted mb-0"><?= sizeof($Students); ?></h1>
                                    <p class="text-muted">عداد الطلاب المستجيبين</p>
                                </div>
                                <div class="carousel-item text-center">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                            <i class="uil uil-user"></i>
                                        </div>
                                    </div>
                                    <h1 class="text-muted mb-0"><?= sizeof($Parents); ?></h1>
                                    <p class="text-muted">عداد المستجيبين لأولياء الأمور</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    072 النسبة المئوية حسب استجابة الاستبيانات</h4>
                <div class="card" id="donut_chart_card">
                    <div class="card-body" style="height: 460px;display: grid;">
                        <h4 class="card-title mb-4">النسبة المئوية للاختيارات<i class="uil uil-download-alt float-right"
                                                                                onclick="savechart('donut_chart_card')"></i>
                        </h4>
                        <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    073 مخططات نوع المستخدم</h4>
                <div class="card" id="radial_chart_card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">مخططات نوع المستخدم <i class="uil uil-download-alt float-right"
                                                                           onclick="savechart('radial_chart_card')"></i>
                        </h4>
                        <!-- <div id="radial_chart" class="apex-charts" dir="ltr"></div> -->
                        <canvas id="radial_chart"></canvas>
                    </div>
                </div>
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    074 النسبة المئوية حسب الجنس</h4>
                <div class="card" id="genders_chart_card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">>النسبة المئوية حسب الجنس <i
                                    class="uil uil-download-alt float-right"
                                    onclick="savechart('genders_chart_card')"></i></h4>
                        <div id="genders_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $all_count_public = 0; ?>
        <div class="row">
            <div class="col-lg-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    075 جدول تقارير الأسئلة</h4>
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                            <th>#</th>
                            <th>السؤال</th>
                            <?php foreach ($used_choices as $used_choice) { ?>
                                <th><?= $used_choice['choices_en'] ?></th>
                            <?php } ?>
                            <th> الأكثر اختيار</th>
                            </thead>
                            <tbody>
                            <?php foreach ($quastions as $sn => $quastion) { ?>
                                <?php $results_array = array(); ?>
                                <tr>
                                    <td><?= $sn + 1 ?></td>
                                    <td data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="<?= $quastion['ar_title'] ?>" class="text-truncate"
                                        style="max-width: 100px;"><?= $quastion['ar_title'] ?></td>
                                    <?php
                                    foreach ($used_choices as $key => $used_choice) {
                                        $use_count = sizeof(array_column($users_passed_survey, 'answerkey')) > 0 ? $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $quastion['q_id'] . "' AND `choice_id` = '" . $used_choice['Id'] . "' AND `answers_data_id` IN (" . implode(',', array_column($users_passed_survey, 'answerkey')) . ") ")->num_rows() : 0;
                                        $all_count = sizeof(array_column($users_passed_survey, 'answerkey')) > 0 ? $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $quastion['q_id'] . "' AND `answers_data_id` IN (" . implode(',', array_column($users_passed_survey, 'answerkey')) . ") ")->num_rows() : 0;
                                        $all_count_public += $all_count;
                                        for ($i = 0; $i < sizeof($used_choices); $i++) {
                                            $old_count = $choice_arr[$i]["counter"];
                                            if ($choice_arr[$i][0] == $used_choice['choices_ar']) {
                                                $choice_arr[$i]['counter'] += $use_count;
                                            }
                                        }
                                        $results_array[] = array("key" => $key, "used_choice" => $used_choice['choices_ar'], "using_count" => $use_count, "using_perc" => calc_perc($use_count, $all_count));
                                        ?>
                                        <td><?= $use_count; ?> <span data-toggle="tooltip" data-placement="top" title=""
                                                                     data-original-title="Frequency/Percentage">( <?= calc_perc($use_count, $all_count); ?> % ) </span>
                                        </td>
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
                                <th>اختيرت <?= $val ?> مرة</th>
                            <?php } ?>
                            <th> الاكثر اختيار</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH
                    076 الإجابات </h4>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">الإجابات</h4>
                        <div id="column_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                <!--end card-->
                <a href="" id="btn-Convert-Html2Image">التفاصيل</a>
            </div>
        </div>
    </div>


</body>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"); ?>"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<script src="<?= base_url("assets/js/html2canvas.js") ?>"></script>
<script src="<?= base_url("assets/libs/chart.js/Chart.bundle.min.js") ?>"></script>

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
    $('.activity-feed').each(function () {
        if ($(this).hasClass('active')) {
            $(this).slideDown();
        } else {
            $(this).slideUp();
        }
    });

    function show_type_of(type) {
        $('.activity-feed').slideUp();
        $('.' + type).slideDown();
    }

    function savechart(id) {
        var element = $("#" + id); // global variable
        var getCanvas; // global variable
        // Now browser starts downloading it instead of just showing it
        html2canvas($("#" + id)[0], {
            dpi: 192,
        }).then(function (canvas) {
            $("#btn-Convert-Html2Image").attr("download", Math.random(10000, 88888) + ".png").attr("href", canvas.toDataURL("image/png"));
            document.getElementById("btn-Convert-Html2Image").click();
        });
    }


    var btns = $('.table').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    btns.buttons().container().appendTo('#DataTables_Table_0_wrapper .col-md-6:eq(0)');
    // var rdoptions = {
    //     chart: {
    //         height: 210,
    //         type: "radialBar"
    //     },
    //     toolbar: {
    //         show: true,
    //     },
    //     plotOptions: {
    //         radialBar: {
    //             dataLabels: {
    //                 name: {
    //                     fontSize: "22px"
    //                 },
    //                 value: {
    //                     fontSize: "16px"
    //                 },
    //                 total: {
    //                     show: !0,
    //                     label: "Total",
    //                     formatter: function(e) {
    //                         return <?= sizeof($users_passed_survey); ?>
    //                     }
    //                 }
    //             }
    //         }
    //     },
    //     series: [<?= calc_perc(sizeof($Staffs), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Teachers), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Students), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Parents), sizeof($users_passed_survey)); ?>],
    //     labels: ["Staff", "Teachers", "Students", "Parents"],
    //     colors: ["#5b73e8", "#34c38f", "#50a5f1", "#f1b44c"]
    // };
    // (chart = new ApexCharts(document.querySelector("#radial_chart"), rdoptions)).render();

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
                        JOIN `sv_st1_answers` ON `sv_st1_answers_values`.`answers_data_id` = `sv_st1_answers`.`Id`
                        WHERE `choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`Id` IN (SELECT sv_st1_answers.Id FROM `sv_school_published_surveys`
                        JOIN `sv_st1_answers` ON `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id`
                        WHERE `sv_school_published_surveys`.`Serv_id` = '" . $serv_id . "' AND `sv_st1_answers`.`user_type` = '" . $type . "' ) ")->num_rows();
                // echo $this->db->last_query();
                $data[] = $use_count;
            }
            ?> {
                name: "<?= $choice['choices_ar'] ?>",
                data: [<?= implode(",", $data) ?>]
            },
            <?php } ?>
        ],
        colors: colors,
        xaxis: {
            categories: ["موظفين", "معلمين", "الطلاب", "أولياء امور"]
        },
        yaxis: {
            title: {
                text: "مرة"
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
                formatter: function (e) {
                    return e + " مرة";
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

        series: [<?= $used_coices_values; ?>],
        toolbar: {
            show: true,
        },
        labels: [<?= $used_coices_labes; ?>],
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

    var perc_genders_options = {
        chart: {
            height: 320,
            type: "donut"
        },
        series: [<?= $males_count ?>, <?= $females_count; ?>],
        labels: ["الذكور", "الإناث"],
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
    const DATA_COUNT = 4;
    const CHART_COLORS = ["#5b73e8", "#34c38f", "#50a5f1", "#f1b44c"];
    const NUMBER_CFG = {
        count: DATA_COUNT,
        min: 1,
        max: 100
    };
    // series: [<?= calc_perc(sizeof($Staffs), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Teachers), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Students), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Parents), sizeof($users_passed_survey)); ?>],
    //     labels: ["Staff", "Teachers", "Students", "Parents"],
    //     colors: ["#5b73e8", "#34c38f", "#50a5f1", "#f1b44c"]
    const usersdata = [{
        label: 'Staff',
        data: <?= calc_perc(sizeof($Staffs), sizeof($users_passed_survey)); ?>,
        backgroundColor: "#5b73e8",
    },
        {
            label: 'Teachers',
            data: <?= calc_perc(sizeof($Teachers), sizeof($users_passed_survey)); ?>,
            backgroundColor: "#34c38f",
        },
        {
            label: 'Students',
            data: <?= calc_perc(sizeof($Students), sizeof($users_passed_survey)); ?>,
            backgroundColor: "#50a5f1",
        },
        {
            label: 'Parents',
            data: <?= calc_perc(sizeof($Parents), sizeof($users_passed_survey)); ?>,
            backgroundColor: "#f1b44c",
        },
    ];
    console.log(usersdata);
    const config = {
        type: 'doughnut',
        data: {
            labels: [
                "الموظفين",
                "المعلمين",
                "الطلاب",
                "أولياء الأمور",
            ],
            datasets: [{
                data: [<?= calc_perc(sizeof($Staffs), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Teachers), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Students), sizeof($users_passed_survey)); ?>, <?= calc_perc(sizeof($Parents), sizeof($users_passed_survey)); ?>],
                backgroundColor: [
                    "#5b73e8",
                    "#34c38f",
                    "#50a5f1",
                    "#f1b44c",
                ],
                hoverBorderColor: "#fff"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'User Type Charts'
                }
            },
            tooltips: {
                enabled: true,
                mode: 'single',
                callbacks: {
                    label: function (tooltipItems, data) {
                        return data.datasets[0].data[tooltipItems.index] + '%';
                    }
                }
            }
        },
    };
    // radial_chart
    const ctx = $("#radial_chart");
    new Chart(ctx, config);
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