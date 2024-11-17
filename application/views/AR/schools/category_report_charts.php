<!DOCTYPE html>
<html lang="arabic">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>

</head>
<?php
$levels = array();
$accepted_foreach = array();
$simple_levels_names_arr = array();
foreach ($avalaible_types_of_classes as $cl_id => $class) {
    $levels[$class['name_ar']] = 0;
    $simple_levels_names_arr[] = $class['name_ar'];
    $accepted_foreach[$class['name_ar']] = explode(";", $class['Classes']);
}
foreach ($students_completed_surveys as $key => $students) {
    foreach ($levels as $key => $level) {
        if (in_array($students['Student_class'], $accepted_foreach[$key])) {
            $levels[$key] = $levels[$key] + 1;
        }
    }
}
$lables_arr = array_map(function ($name) {
    return "'" . $name . "'";
}, $simple_levels_names_arr);
?>

<body>
<div class="main-content">
    <div class="page-content">
        <div class="row">

            <!--                <div class="col-12">-->
            <!--					<h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CATD 001: حسب الجنس</h4>-->
            <!--                    <div class="card">-->
            <!--                        <div class="card-body">-->
            <!--                            <h3 class="text-center ">مجموع المشاركين في الإستبيان - حسب الجنس</h3>-->
            <!--                            <div id="genders_charts" ></div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="col-12">-->
            <!--                    <br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 065 الإستبيانات حسب المستويات</h4>-->
            <!--                    <div class="card">-->
            <!--                        <div class="card-body">-->
            <!--                            <h3 class="text-center ">الرسم البياني حسب المراحل التعليمية</h3>-->
            <!--                            <canvas id="students_classes" height="120"></canvas>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <div class="col-12">
                <br><h4 class="card-title"
                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    CATD 002: حسب نوع المستخدمين</h4>
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center ">مجموع المشاركين في الإستبيان - حسب نوع المستخدمين</h3>
                        <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                <!--					 <br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CATD 003: الرسم البياني - حسب الجنس لجميع الإستبيانات التي تم نشرها </h4>-->
            </div>

            <?php

            foreach ($surveys as $key => $survey) {

                $this->load->view('AR/schools/inc/answers_counter_chart_generater', [
                    'counter' => $key,
                    'data' => $survey
                ]);
            }
            ?>

        </div>
    </div>
</div>
</body>
<script src="<?= base_url("assets/libs/chart.js/Chart.bundle.min.js") ?>"></script>

</html>
<script>
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
    var genders_chart_options = {
        chart: {
            type: "bar",
            height: 160,
            stacked: true,
            stackType: "100%",
            toolbar: {
                show: false
            }
        },
        series: [{
            name: "الذكور ",
            data: [<?php echo $surveys_for_males; ?>]
        },
            {
                name: "الإناث ",
                data: [<?php echo $surveys_for_females; ?>]
            }
        ],
        plotOptions: {
            bar: {
                horizontal: true
            }
        },
        dataLabels: {
            dropShadow: {
                enabled: true
            },
            formatter: function (val) {
                return val ? val.toFixed(1) + '%' : ''
            }
        },
        stroke: {
            width: 0
        },
        grid: {
            show: false,
            padding: {
                top: 0,
                bottom: 0,
                right: 0,
                left: 0
            }
        },
        xaxis: {
            categories: [""],
            labels: {
                show: false
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            opacity: 1,
            type: "gradient",
            gradient: {
                shade: "dark",
                type: "vertical",
                shadeIntensity: 0.35,
                gradientToColors: undefined,
                inverseColors: false,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [90, 0, 100]
            }
        },

        legend: {
            position: "bottom",
            horizontalAlign: "center"
        }
    };

    var genders_chart = new ApexCharts(document.querySelector("#genders_charts"), genders_chart_options);
    genders_chart.render();

    // chart js
    //var ctx = document.getElementById('students_classes');
    //var myChart = new Chart(ctx, {
    //    type: 'doughnut',
    //    data: {
    //        labels: [<?php //= implode(',' , $lables_arr) ?>//],
    //        datasets: [{
    //            label: 'مستويات المدرسة',
    //            data: [<?php //= implode(',' , $levels) ?>//],
    //            backgroundColor: [
    //                'rgba(255, 99, 132, 1)',
    //                'rgba(54, 162, 235, 1)',
    //                'rgba(255, 206, 86, 1)',
    //                'rgba(75, 192, 192, 1)',
    //                'rgba(153, 102, 255, 1)',
    //                'rgba(255, 159, 64, 1)'
    //            ],
    //            borderColor: [
    //                'rgba(255, 99, 132, 1)',
    //                'rgba(54, 162, 235, 1)',
    //                'rgba(255, 206, 86, 1)',
    //                'rgba(75, 192, 192, 1)',
    //                'rgba(153, 102, 255, 1)',
    //                'rgba(255, 159, 64, 1)'
    //            ],
    //            borderWidth: 1
    //        }]
    //    },
    //    options: {
    //        scales: {
    //            y: {
    //                beginAtZero: true
    //            }
    //        }
    //    }
    //});

    var options = {
        chart: {
            height: 210,
            type: "bar"
        },
        toolbar: {
            show: true,
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val;
            },
            offsetY: -25,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        series: [{
            name: 'الموظفين',
            data: [<?= sizeof($Staffs) ?>]
        },
            {
                name: 'المعلمين',
                data: [<?= sizeof($Teachers) ?>]
            },
            {
                name: 'الطلاب',
                data: [<?= sizeof($Students) ?>]
            },
            {
                name: 'أولياء الأمور',
                data: [<?= sizeof($Parents) ?>]
            },
        ],
        labels: ["الموظفين", "المعلمين", "الطلاب", "أولياء الأمور"],
        colors: ["#5b73e8", "#34c38f", "#50a5f1", "#f1b44c"]
    };
    (chart = new ApexCharts(document.querySelector("#radial_chart"), options)).render();
</script>