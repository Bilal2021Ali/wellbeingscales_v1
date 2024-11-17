<!doctype html>
<html lang="en">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<style>
    .firstCard * {
        color: #fff;
    }

    .firstCard.card-body {
        border-radius: 5px
    }

    .firstCard .uil-arrow-right {
        margin-left: 10px;
        transition: 0.2s all;
    }

    img.ic_img {
        width: 60px;
        margin-bottom: 20px;
    }

    .ontypecard .card-body * {
        color: #fff;
        cursor: default;
    }

    .ontypecard .card-body {
        border-radius: 5px;
    }

    .img-responsive.w-100.p-1 {
        max-width: 200px;
		}

    .cardsoflinks .firstCard img {
        width: 100px;
        float: left;
        position: absolute;
        top: -11px;
        left: -13px;
    }

    .InfosCards .card {
        border: 6px solid;
    }

    .set-in-action {
        cursor: pointer;
    }

    #userschart, .labtest-chart {
        min-height: 350px !important;
    }
</style>
<?php
function calculate($part, $total)
{
    $x = $part;
    $y = $total;
    if ($x > 0 && $y > 0) {
        $percent = $x / $y;
        $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
    } else {
        $percent_friendly = 0;
    }
    return $percent_friendly;
}

?>
<div class="rightbar-overlay"></div>
<div class="right-bar" style="z-index: 100000;">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4"><a href="javascript:void(0);" class="right-bar-toggle float-right"> <i class="mdi mdi-close noti-icon"></i> </a> <h5 class="m-0">Teachers List</h5>
        </div>
        <hr class="mt-0"/>
        <h6 class="text-center mb-0"> Cantacted Teachers </h6>
        <div class="p-4" id="TeachersCon"> Wait Please...</div>
    </div>
</div>

<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">Users Counters </h4>
        <div class="row">
            <?php foreach ($cards as $card) { ?>
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card" style="background: url('<?= base_url("assets/images/schoolDashboard/" . $card['bg']); ?>');background-position: center;background-repeat: no-repeat;background-size: cover;border-color: <?= $card['border'] ?>">
                        <div class="card-body">
                            <div class="float-right mt-2"><img src="<?= base_url(); ?>assets/images/schoolDashboard/icons/<?= $card['icons'] ?>" alt="<?= $card['Title'] ?>"></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"> <?= $card['Data']['allCounter'] ?? '--' ?> </span></h4>
                                <p class="mb-0"> <?= $card['Title'] ?> </p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1"><span><?= $card['Data']['LastAdded'] ?? '--/--/--' ?> </span><br> </p>
                            <p class="text-white"> <?= $card['last_title'] ?> </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if (isset($permissions['users_counters']) && $permissions['users_counters'] == '1') { ?>

<div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Counters and Percentage</h3>
                            <div id="userschart" class="apex-charts"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Genders</h3>
                            <div id="genders_bars"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_marital_status']) && $permissions['users_marital_status'] == '1') { ?>
            <script>
                var options = {

                    chart: {

                        type: 'bar',
                        height: 350,
                    },
                    plotOptions: {
                        bar: {
                            barHeight: '100%',
                            distributed: true,
                            horizontal: true,
                            dataLabels: {
                                position: 'bottom'
                            },
                        }
                    },
                    colors: ['#EB8C87', '#5b9cd6'],
                    dataLabels: {
                        formatter: function (val, opt) {
                            return val
                        },
                        offsetX: 0,
                        enabledOnSeries: undefined,
                        textAnchor: 'end',
                        distributed: false,
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            colors: undefined
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 50,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 0.45
                        }
                    },
                    series: [{
                        name: "",
                        data: [<?= implode(",", array_map(function ($s) use ($counters) {
                                return sizeof(
                                    $counters["martialCounters"][$s["Id"]] ?? []
                                );
                            }, $martial_statuses)
                        ) ?>]
                    }],
                    grid: {
                        borderColor: '#f1f1f1',
                    },
                    xaxis: {
                        categories: [<?= implode(
                            ",",
                            array_map(function ($s) {
                                return '"' . $s["name"] . '"';
                            }, $martial_statuses)
                        ) ?>]
                    }
                }
                var chart = new ApexCharts(
                    document.querySelector("#martial_statuses_bars"),
                    options
                );
                chart.render();
                var options = {
                    chart: {
                        height: 350,
                        type: 'bar',
                        toolbar: {
                            show: true,
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        formatter: function (val, opt) {
                            return val
                        },
                        offsetX: 0,
                        enabledOnSeries: undefined,
                        textAnchor: 'end',
                        distributed: false,
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            colors: undefined
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 4,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 0.45
                        }
                    },

                    series: [{
                        name: '',
                        data: [<?= sizeof($counters['gendersCounters']['M'] ?? []) ?>]
                    }, {
                        name: '',
                        data: [<?= sizeof($counters['gendersCounters']['F'] ?? []) ?>]
                    }
                    ],
                    colors: ['#0070c0', '#ff4da6'],
                    xaxis: {

                        legend: {
                            show: true,
                            position: 'end',
                            horizontalAlign: 'center',
                            verticalAlign: 'middle',
                            floating: true,
                            fontSize: '16px',
                            offsetX: 0
                        },
                    }
                }
            </script>
        <?php } ?>
        <?php if (isset($permissions['users_wellbeing']) && $permissions['users_wellbeing'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                Well-being </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Well-being</h3>
                            <div id="wellbeing_counters"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">User Type</h3>
                            <div id="wellbeing_userscounters"></div>
                        </div>
                    </div>
                </div>
                <script>
                    var options = {
                        series: [{
                            name: "",
                            data: [<?= sizeof($our_surveys); ?>, <?= sizeof($expired_surveys) ?>, <?= sizeof($completed_surveys) ?>, <?= sizeof($used_categorys) ?>]
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                    position: 'bottom'
                                },
                            }
                        },
                        colors: ['#32bf72', '#ff3b3b', '#0070c0', '#ffc000'],
                        dataLabels: {
                            formatter: function (val, opt) {
                                return val
                            },
                            offsetX: 0,
                            enabledOnSeries: undefined,
                            textAnchor: 'end',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,
                            style: {
                                fontSize: '20px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 'bold',
                                colors: undefined
                            },
                            background: {
                                enabled: true,
                                foreColor: '#fff',
                                padding: 4,
                                borderRadius: 2,
                                borderWidth: 1,
                                borderColor: '#fff',
                                opacity: 0.9,
                                dropShadow: {
                                    enabled: false,
                                    top: 1,
                                    left: 1,
                                    blur: 1,
                                    color: '#000',
                                    opacity: 0.45
                                }
                            },
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: ["Published Surveys", "Expired Surveys", "Completed Surveys", "Categories"]
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                show: false
                            }
                        }
                    };
                    var chart = new ApexCharts(
                        document.querySelector("#wellbeing_counters"),
                        options)
                    ;
                    chart.render();
                    var options = {
                        series: [{
                            name: "",
                            data: [<?= ($userscounters['staff']); ?>, <?= ($userscounters['teachers']) ?>, <?= ($userscounters['students']) ?>, <?= ($userscounters['parents']) ?>]
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                    position: 'bottom'
                                },
                            }
                        },
                        colors: ['#32bf72', '#ff3b3b', '#0070c0', '#ffc000'],
                        dataLabels: {
                            textAnchor: 'end',
                            formatter: function (val, opt) {
                                return val
                            },
                            offsetX: 0,
                            enabledOnSeries: undefined,
                            textAnchor: 'end',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,
                            style: {
                                fontSize: '20px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 'bold',
                                colors: undefined
                            },
                            background: {
                                enabled: true,
                                foreColor: '#fff',
                                padding: 4,
                                borderRadius: 2,
                                borderWidth: 1,
                                borderColor: '#fff',
                                opacity: 0.9,
                                dropShadow: {
                                    enabled: false,
                                    top: 1,
                                    left: 1,
                                    blur: 1,
                                    color: '#000',
                                    opacity: 0.45
                                }
                            },
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: ["Staff", "Teachers", "Students", "Parents"]
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                show: false
                            }
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#wellbeing_userscounters"), options);
                    chart.render();
                </script>
            </div>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_speak_out']) && $permissions['users_speak_out'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                Speak Out </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Speak Out </h3>
                            <div id="chart-speak-out-f"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Speak Out Priority</h3>
                            <div id="chart-speak-out-l"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    series: [{
                        name: "",
                        data: [<?= sizeof($speakout['pending']) ?>, <?= sizeof($speakout['approved']) ?>, <?= sizeof($speakout['resolved']) ?>, <?= sizeof($speakout['seen']) ?>,]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                    },
                    plotOptions: {
                        bar: {
                            barHeight: '100%',
                            distributed: true,
                            horizontal: true,
                            dataLabels: {
                                position: 'bottom'
                            },
                        }
                    },
                    colors: ['#ff4848', '#00b050', '#0070c0', '#ffc000'],
                    dataLabels: {
                        textAnchor: 'end',
                        formatter: function (val, opt) {
                            return val
                        },
                        offsetX: 0,
                        enabledOnSeries: undefined,
                        textAnchor: 'end',
                        distributed: false,
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            colors: undefined
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 4,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 0.45
                        }
                    },
                    stroke: {
                        width: 1,
                        colors: ['#fff']
                    },
                    xaxis: {
                        categories: ['Pending', 'Approved', 'Resolved', 'Seen']
                    },
                    tooltip: {
                        x: {
                            show: false
                        },
                        y: {
                            show: false
                        }
                    }
                };
                var chart = new ApexCharts(
                    document.querySelector("#chart-speak-out-f"),
                    options
                );
                chart.render();
                var options = {
                    series: [{
                        name: "",
                        data: [<?= sizeof($speakout['average']) ?>, <?= sizeof($speakout['urgent']) ?>, <?= sizeof($speakout['high']) ?>, <?= sizeof($speakout['highest']) ?>,]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                    },
                    plotOptions: {
                        bar: {
                            barHeight: '100%',
                            distributed: true,
                            horizontal: true,
                            dataLabels: {
                                position: 'bottom'
                            },
                        }
                    },
                    colors: ['#0070c0', '#00b050', '#ffc412', '#ff0000'],
                    dataLabels: {
                        textAnchor: 'end',
                        formatter: function (val, opt) {
                            return val
                        },
                        offsetX: 0,
                        enabledOnSeries: undefined,
                        textAnchor: 'end',
                        distributed: false,
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            colors: undefined
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 4,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 0.45
                        }
                    },
                    stroke: {
                        width: 1,
                        colors: ['#fff']
                    },
                    xaxis: {
                        categories: ['Average', 'Urgent', 'High', 'Highest']
                    },
                    tooltip: {
                        x: {
                            show: false
                        },
                        y: {
                            show: false
                        }
                    }
                };
                var chart = new ApexCharts(
                    document.querySelector("#chart-speak-out-l"),
                    options
                );
                chart.render();
            </script>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_daily_temperature']) && $permissions['users_daily_temperature'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                Daily Temperature </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Daily Temperature</h3>
                            <div id="daily-temprature-1" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Daily Temperature</h3>
                            <div id="daily-temprature-2" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <?php foreach ($templevels as $ttype => $s) { ?>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center">
                                    <?= ucfirst($ttype) ?>
                                    Temperature</h3>
                                <div id="temps-counter-<?= $ttype ?>"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <script>
                    var options = {
                        series: [{
                            name: "",
                            data: [<?= $temperature['low'] ?>, <?= $temperature['normal'] ?>, <?= $temperature['moderate'] ?>, <?= $temperature['high'] ?>]
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                    position: 'bottom'
                                },
                            }
                        },
                        colors: ['#0070c0', '#00b050', '#ffc412', '#ff0000'],
                        dataLabels: {
                            textAnchor: 'end',
                            formatter: function (val, opt) {
                                return val
                            },
                            offsetX: 0,
                            enabledOnSeries: undefined,
                            textAnchor: 'end',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,
                            style: {
                                fontSize: '20px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 'bold',
                                colors: undefined
                            },
                            background: {
                                enabled: true,
                                foreColor: '#fff',
                                padding: 4,
                                borderRadius: 2,
                                borderWidth: 1,
                                borderColor: '#fff',
                                opacity: 0.9,
                                dropShadow: {
                                    enabled: false,
                                    top: 1,
                                    left: 1,
                                    blur: 1,
                                    color: '#000',
                                    opacity: 0.45
                                }
                            },
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: ["Low Temperature", "Normal Temperature", "Moderate Temperature", "High Temperature"]
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                show: false
                            }
                        }
                    };
                    var chart = new ApexCharts(
                        document.querySelector("#daily-temprature-1"),
                        options
                    );
                    chart.render();
                    var options = {
                        chart: {
                            height: 350,
                            type: 'pie',
                        },
                        series: [<?= $temperature['low'] ?>, <?= $temperature['normal'] ?>, <?= $temperature['moderate'] ?>, <?= $temperature['high'] ?>],
                        labels: ["Low Temperature", "Normal Temperature", "Moderate Temperature", "High Temperature"],
                        colors: ['#07aae2', '#528233', '#fcbf00', '#f70300'],
                        legend: {
                            show: true,
                            position: 'bottom',
                            horizontalAlign: 'center',
                            verticalAlign: 'middle',
                            floating: false,
                            fontSize: '14px',
                            offsetX: 0
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: {
                                    height: 240
                                },
                                legend: {
                                    show: false
                                },
                            }
                        }]
                    }
                    var chart = new ApexCharts(
                        document.querySelector("#daily-temprature-2"),
                        options
                    );
                    chart.render();
                    <?php foreach ($templevels as $ttype => $t) { ?>
                    var options = {
                        chart: {
                            height: 200,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [{
                            name: '',
                            data: [<?= $temperature['teacher'][$ttype] ?>, <?= $temperature['staff'][$ttype] ?>, <?= $temperature['student'][$ttype] ?>]
                        }],
                        colors: ['<?= $t['color'] ?>'],
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        xaxis: {
                            categories: ["Teacher", "Staff", "Student"]
                        }
                    }
                    var chart = new ApexCharts(
                        document.querySelector("#temps-counter-<?= $ttype ?>"),
                        options
                    );
                    chart.render();
                    <?php } ?>
                </script>
            </div>
            <?php /*?> <div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_daily_labtests']) && $permissions['users_daily_labtests'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                Lab Test Counters <span class="float-right"><a
                            href="<?= base_url("EN/schools/all-labtests-results") ?>"
                            target="_blank" class="text-white"
                            rel="noopener noreferrer">Show More</a></span></h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Daily Lab Test</h3>
                            <div id="labtests-bar-charts" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Lab Test</h3>
                            <div id="labtests-pie-charts" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    chart: {
                        height: 350,
                        type: 'bar',
                        toolbar: {
                            show: false,
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        enabled: true,
                    },
                    series: [{
                        name: 'Negative',
                        data: [<?= array_sum(array_map(function ($test) use ($labtests) {
                            return $labtests[$test->Test_Desc]['negative'];
                        }, $tests)) ?>]
                    },
                        {
                            name: 'Positive',
                            data: [<?= array_sum(array_map(function ($test) use ($labtests) {
                                return $labtests[$test->Test_Desc]['positive'];
                            }, $tests)) ?>]
                        }
                    ],
                    colors: ['#32bf72', '#ff3b3b'],
                    grid: {
                        borderColor: '#f1f1f1',
                    },
                    xaxis: {
                        categories: ["Negative", "Positive"]
                    },
                    tooltip: {
                        x: {
                            show: false
                        },
                        y: {
                            show: false
                        }
                    }
                }
                var chart = new ApexCharts(
                    document.querySelector("#labtests-bar-charts"),
                    options
                );
                chart.render();
                var options = {
                    chart: {
                        height: 350,
                        type: 'pie',
                    },
                    series: [<?= array_sum(array_map(function ($test) use ($labtests) {
                        return $labtests[$test->Test_Desc]['negative'];
                    }, $tests)) ?>, <?= array_sum(array_map(function ($test) use ($labtests) {
                        return $labtests[$test->Test_Desc]['positive'];
                    }, $tests)) ?>],
                    labels: ["Negative", "Positive"],
                    colors: ['#32bf72', '#ff3b3b'],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        verticalAlign: 'middle',
                        floating: false,
                        fontSize: '14px',
                        offsetX: 0
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: false
                            },
                        }
                    }]
                }
                var chart = new ApexCharts(
                    document.querySelector("#labtests-pie-charts"),
                    options
                );
                chart.render();
            </script>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_home_quarantine']) && $permissions['users_home_quarantine'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                Home Quarantine and Quarantine
                <span class="float-right">
                    <a class="text-white" href="<?= base_url("EN/schools/labtestall") ?>"
                       rel="noopener noreferrer">More Details</a>
                </span>
            </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Counters Home Quarantine and Quarantine</h3>
                            <div class="labtest-chart" id="counters-home-quarntine"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Percentage Home Quarantine and Quarantine</h3>
                            <div class="labtest-chart" id="percentage-home-quarntine"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    series: [{
                        name: "Home Quarntine",
                        data: [<?= $temperature['staff']['home'] ?>, <?= $temperature['teacher']['home'] ?>, <?= $temperature['student']['home'] ?>]
                    }, {
                        name: "Quarntine",
                        data: [<?= $temperature['staff']['quarantine'] ?>, <?= $temperature['teacher']['quarantine'] ?>, <?= $temperature['student']['quarantine'] ?>]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            dataLabels: {
                                enabled: true,
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'end',
                        formatter: function (val, opt) {
                            return val
                        },
                        offsetX: 0,
                        enabledOnSeries: undefined,
                        textAnchor: 'end',
                        distributed: false,
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            colors: undefined
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 4,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 0.45
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    },
                    xaxis: {
                        categories: ["Staff", "Teachers", "Students"],
                    },
                };
                var chart = new ApexCharts(document.querySelector("#counters-home-quarntine"), options);
                chart.render();
                var options = {
                    chart: {
                        height: 350,
                        type: 'pie',
                    },
                    series: [<?= $temperature['staff']['home'] + $temperature['teacher']['home'] + $temperature['student']['home'] ?>, <?= $temperature['staff']['quarantine'] + $temperature['teacher']['quarantine'] + $temperature['student']['quarantine'] ?>],
                    labels: ["Home", "Quarntine"],
                    colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1"],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        verticalAlign: 'middle',
                        floating: false,
                        fontSize: '14px',
                        offsetX: 0
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: false
                            },
                        }
                    }]
                }
                var chart = new ApexCharts(
                    document.querySelector("#percentage-home-quarntine"),
                    options
                );
                chart.render();
            </script>

        <?php } ?>
        <?php if (isset($permissions['users_temperature_diagram']) && $permissions['users_temperature_diagram'] == '1') { ?>
            <?php /*?><div class="row">
    <div class="col-xl-12"><br>
      <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> Daily Temperature Diagram for Staff, Teachers, and Students</h4>
      <div class="card">
        <div class="card-body">
          <div class="float-right">
            <div class="dropdown"><a class="dropdown-toggle text-reset" href="#"
                                                         id="dropdownMenuButton5" data-toggle="dropdown"
                                                         aria-haspopup="true"
                                                         aria-expanded="false"> <span class="text-muted"> <b>Select User Type(Staff, Teachers, and Students)</b></font> <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                <li class="dropdown-item" onClick="GetStaffChart();">Staff</li>
                <li class="dropdown-item" onClick="GetTeacherChart();">Teacher</li>
                <li class="dropdown-item" onClick="GetStudentChart();">Student</li>
              </div>
            </div>
          </div>
          <div id="SelectTheClassCard" class="mb-2">
            <label for="SelectFromClass">Select Class</label>
            <?php if (!empty($active_classes)) { ?>
            <select name="StudentClass" class="form-control" id="SelectFromClass">
              <option value="">Please Select a Class</option>
              <?php foreach ($active_classes as $class) { ?>
              <option value="<?= $class['Id'] ?>">
              <?= $class['Class']; ?>
              </option>
              <?php } ?>
            </select>
            <?php } else { ?>
            <p>You do not have any class registered yet. Please edit school <a
                                                href="<?= base_url(); ?>EN/schools/Profile">Profile</a></p>
            <?php } ?>
          </div>
          <h4 class="card-title"><img
                                        src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png"
                                        style="width: 25px;margin: auto 5px;"> Daily Temperature Diagram
            <?= $today; ?>
            <font color=#e13e2b>(Staff, Teacher, and Student)</font></h4>
          <div id="drawChart"><img src="<?= base_url(); ?>assets/images/Back1.png" width="100%"
                                                     style="padding-top: 20px; padding-bottom: 10px;"></div>
        </div>
      </div>
    </div>
  </div><?php */ ?>
            <?php /*?> <div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_classes_counters']) && $permissions['users_classes_counters'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                Attendance Counter <span class="float-right"><a class="text-white"
                                                                href="<?= base_url("EN/schools/students-classes") ?>"
                                                                target="_blank"
                                                                rel="noopener noreferrer">Show More</a></span></h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="classes-counters-bar" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="classes-counters-pie" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    series: [{
                        name: "",
                        data: [<?= $userscounters['students'] ?>, <?= $ClassesResultsDefault['appsent'] ?>]
                    }],
                    colors: ["#5b9bd5", "#ffc000"],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            dataLabels: {
                                enabled: true,
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'end',
                        formatter: function (val, opt) {
                            return val
                        },
                        offsetX: 0,
                        enabledOnSeries: undefined,
                        textAnchor: 'end',
                        distributed: false,
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            colors: undefined
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            padding: 4,
                            borderRadius: 2,
                            borderWidth: 1,
                            borderColor: '#fff',
                            opacity: 0.9,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 0.45
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    },
                    xaxis: {
                        categories: ["Number of students present", "Number of students absent"],
                    },
                };
                var chart = new ApexCharts(document.querySelector("#classes-counters-bar"), options);
                chart.render();
                var options = {
                    chart: {
                        height: 350,
                        type: 'pie',
                    },
                    series: [<?= $userscounters['students'] ?>, <?= $ClassesResultsDefault['appsent'] ?>],
                    labels: ["Total Students", "Total Absent Today"],
                    colors: ["#5b9bd5", "#ffc000"],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        verticalAlign: 'middle',
                        floating: false,
                        fontSize: '14px',
                        offsetX: 0
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: false
                            },
                        }
                    }]
                }
                var chart = new ApexCharts(
                    document.querySelector("#classes-counters-pie"),
                    options
                );
                chart.render();
            </script>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_classes_counters']) && $permissions['users_daily_data_table_student'] == '1') { ?>
            <!-- Students -->
            <?php /*?><h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"> Daily Data Table for All Tests-Students</h4><?php */ ?>
            <?php /*?><div class="row">
    <div class="col-xl-12"><br>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4" id="Titel">
            <div class="float-right">
              <div class="dropdown"><a class=" dropdown-toggle" href="#" data-toggle="dropdown"
                                                             aria-haspopup="true" aria-expanded="false"> <span
                                                    class="text-muted">Select Test<i
                                                        class="mdi mdi-chevron-down ml-1"></i></span> </a>
                <style>
                                            .dropdown-menu * {
                                                cursor: pointer;
                                            }
                                        </style>
                <div class="dropdown-menu" style="z-index: 100001;position: relative;">
                  <li class="dropdown-item" onClick="Tempratur_students();">Temperature</li>
                  <?php foreach ($tests as $test) { ?>
                  <li class="dropdown-item"
                                                    onClick="Get_plus_minus_students('<?= $test->Test_Desc; ?>');">
                    <?= $test->Test_Desc; ?>
                  </li>
                  <?php } ?>
                </div>
              </div>
            </div>
          </h4>
          <div class="float-right" style="z-index: 10000;position: relative;">
            <div class="dropdown classes_temp"><a class="dropdown-toggle" href="#"
                                                                      data-toggle="dropdown" aria-haspopup="true"
                                                                      aria-expanded="false"> <span
                                                class="text-muted"> </span><b>Select Class</b> <i
                                                class="mdi mdi-chevron-down ml-1"></i></span> </a>
              <style>
                                        .dropdown-menu * {
                                            cursor: pointer;
                                        }
                                    </style>
              <div class="dropdown-menu">
                <?php if (!empty($active_classes)) { ?>
                <?php foreach ($active_classes as $class) { ?>
                <li class="dropdown-item"
                                                    onClick="GetTheStudentsResultsForClass(<?= $class['Id'] ?>)">
                  <?= $class['Class']; ?>
                </li>
                <?php } ?>
                <?php } else { ?>
                <li class="dropdown-item"> No Class found for this school</li>
                <?php } ?>
              </div>
            </div>
          </div>
          <h4 class="card-title mb-4"><img
                                        src="<?= base_url("assets/images/icons/png_icons/Dashboard_students.png"); ?>"
                                        style="width: 25px;margin: auto 5px;"> Daily List of Tests
            <?= $today; ?>
            <font color=#e13e2b>(Students) </font></h4>
          </br>
          <div class="New_Select" style="margin-top: -40px;"></div>
          <div class="New_Data"></div>
          <div data-simplebar>
            <div id="ResultsTableStudents" style="text-align: center;"><img
                                            src="<?= base_url(); ?>assets/images/Back2.png" width="100%"
                                            style="padding-top: 20px; padding-bottom: 20px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <!-- Staff -->
        <?php if (isset($permissions['users_classes_counters']) && $permissions['users_daily_data_table_staff'] == '1') { ?>
            <?php /*?><div class="col-xl-12"><br>
    <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> Daily Data Table for All Tests-Staff</h4>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">
          <div class="float-right">
            <div class="dropdown"><a class=" dropdown-toggle" href="#" data-toggle="dropdown"
                                                         aria-haspopup="true" aria-expanded="false"> <span
                                                class="text-muted"><b>Select Test</b><i
                                                    class="mdi mdi-chevron-down ml-1"></i></span> </a>
              <style>
                                        .dropdown-menu * {
                                            cursor: pointer;
                                        }
                                    </style>
              <div class="dropdown-menu" style="z-index: 100001;position: relative;">
                <li class="dropdown-item"
                                            onclick="Tempratur_List('#simpl_staff_list','#New_Staff_List');">Temperature </li>
                <?php foreach ($tests as $test) { ?>
                <li class="dropdown-item"
                                                onClick="staff_labTests('<?= $test->Test_Desc; ?>');">
                  <?= $test->Test_Desc; ?>
                </li>
                <?php } ?>
              </div>
            </div>
          </div>
        </h4>
        <h4 class="card-title mb-4"><img
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png"
                                    style="width: 25px;margin: auto 5px;"> Daily List of Tests
          <?= $today; ?>
          <font color=#e13e2b>(Staff) </font></h4>
        (<span id="STAFFSNOSHOWTESTNAME">Temperature</span>)
        </h4>
        <div data-simplebar style="overflow: auto;">
          <div id="simpl_staff_list">
            <table class="table ch004results table-borderless table-centered table-nowrap table_sites ">
              <thead>
              <th> #</th>
                <th> Img</th>
                <th> Name</th>
                <th> Date &amp; Time</th>
                <th> Result</th>
                <th> Risk</th>
                <th> Symptoms</th>
                <th> Status</th>
                <th> Action</th>
                </thead>
              <tbody>
              <style>
                                        .badge {
                                            text-align: center;
                                        }
                                        .Td-Results {
                                            color: #FFFFFF;
                                        }
                                    </style>
              <?php foreach ($temprature['staff'] as $sn => $result) { ?>
              <tr>
                <td><?= $sn + 1 ?></td>
                <td style="width: 20px;"><?php if (empty($result['avatar'])) { ?>
                  <img src="<?= base_url("uploads/avatars/default_avatar.jpg"); ?>"
                                                         class="avatar-xs rounded-circle " alt="...">
                  <?php } else { ?>
                  <img src="<?= base_url("uploads/avatars/" . $result['avatar']); ?>"
                                                         class="avatar-xs rounded-circle " alt="...">
                  <?php } ?></td>
                <td><h6 class="font-size-15 mb-1 font-weight-normal">
                    <?= $result['Name']; ?>
                  </h6>
                  <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                    <?= ($result['Position'] ?? '--') . ", " . $result['Action']; ?>
                  </p></td>
                <td><?= $result['Result_Date']; ?></td>
                <?php boxes_Colors($result['Result']); ?>
                <td><?php symps($result['Symptoms']); ?></td>
                <td><?php if (strtolower($result['Action']) == "home") { ?>
                  <p class="font-size-13 mb-0 text-primary"> <b>
                    <?= ucfirst($result['Action']) ?>
                    </b> </p>
                  <?php } elseif (strtolower($result['Action']) == "quarantine") { ?>
                  <p class="font-size-13 mb-0 text-danger"> <b>
                    <?= ucfirst($result['Action']) ?>
                    </b> </p>
                  <?php } else { ?>
                  <p class="font-size-13 mb-0 text-success">
                    <?= ucfirst($result['Action']) ?>
                  </p>
                  <?php } ?></td>
                <td><a class="px-3 text-primary set-in-action"
                                                   data-id="<?= $result['Id'] ?>" data-type="Staff"
                                                   data-change-to="Home" data-toggle="tooltip" data-placement="top"
                                                   title="" data-original-title="Stay Home" theid="23"> <img src="<?= base_url('assets/images/icons/Home.png'); ?>" alt=""
                                                         width="20px"> </a> <a class="text-danger set-in-action" data-toggle="tooltip"
                                                   data-id="<?= $result['Id'] ?>" data-type="Staff"
                                                   data-change-to="Quarantine" data-placement="top" title="Quarantine"
                                                   theid="23"> <img src="<?= base_url('assets/images/icons/quarntine.jpg'); ?>"
                                                         alt="" width="20px"> </a></td>
              </tr>
              <?php } ?>
              </tbody>
              
            </table>
          </div>
          <div id="New_Staff_List"></div>
        </div>
      </div>
    </div>
  </div><?php */ ?>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_classes_counters']) && $permissions['users_daily_data_table_teacher'] == '1') { ?>
            <!-- Teacher -->
            <?php /*?><div class="col-xl-12"><br>
    <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> Daily Data Table for All Tests-Teachers</h4>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">
          <div class="float-right">
            <div class="dropdown"><a class=" dropdown-toggle" href="#" data-toggle="dropdown"
                                                         aria-haspopup="true" aria-expanded="false"> <span
                                                class="text-muted"><b>Select Test</b><i
                                                    class="mdi mdi-chevron-down ml-1"></i></span> </a>
              <style>
                                        .dropdown-menu * {
                                            cursor: pointer;
                                        }
                                    </style>
              <div class="dropdown-menu" style="z-index: 100001;position: relative;">
                <li class="dropdown-item"
                                            onclick="Tempratur_List('#simpl_Teacher_list','#New_Teacher_List');"> Temperature </li>
                <?php foreach ($tests as $test) { ?>
                <li class="dropdown-item"
                                                onClick="Teacher_labTests('<?= $test->Test_Desc ?>');">
                  <?= $test->Test_Desc; ?>
                </li>
                <?php } ?>
              </div>
            </div>
          </div>
        </h4>
        <h4 class="card-title mb-4"><img
                                    src="<?= base_url("assets/images/icons/png_icons/Temp_Counter.png"); ?>"
                                    style="width: 25px;margin: auto 5px;"> Daily List of Tests
          <?= $today; ?>
          <font color=#e13e2b>(Teachers) </font></h4>
        (<span id="TEACHERSSNOSHOWTESTNAME">Temperature</span>)
        </h4>
        <div data-simplebar style="overflow: auto;">
          <div id="simpl_Teacher_list">
            <table class="table table-borderless table-centered table-nowrap table_sites ">
              <thead>
              <th>#</th>
                <th> Img</th>
                <th> Name</th>
                <th> Date &amp; Time</th>
                <th> Result</th>
                <th> Risk</th>
                <th> Symptoms</th>
                <th> Status</th>
                <th> Action</th>
                </thead>
              <tbody>
              <style>
                                        .badge {
                                            text-align: center;
                                        }
                                    </style>
              <?php foreach ($temprature['teachers'] as $sn => $result) { ?>
              <tr data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="<?= $result['Action']; ?>">
                <td><?= $sn + 1 ?></td>
                <td style="width: 20px;"><?php if (empty($result['avatar'])) { ?>
                  <img src="<?= base_url("uploads/avatars/default_avatar.jpg"); ?>"
                                                         class="avatar-xs rounded-circle " alt="...">
                  <?php } else { ?>
                  <img src="<?= base_url("uploads/avatars/" . $result['avatar']); ?>"
                                                         class="avatar-xs rounded-circle " alt="...">
                  <?php } ?></td>
                <td><h6 class="font-size-15 mb-1 font-weight-normal">
                    <?= $result['Name']; ?>
                  </h6>
                  <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                    <?= $result['classes'] ?>
                  </p></td>
                <td><?= $result['Result_Date']; ?></td>
                <?php boxes_Colors($result['Result']); ?>
                <td><?php symps($result['Symptoms']); ?></td>
                <td><?php if (strtolower($result['Action']) == "home") { ?>
                  <p class="font-size-13 mb-0 text-primary"><b>
                    <?= ucfirst($result['Action']) ?>
                    </b></p>
                  <?php } elseif (strtolower($result['Action']) == "quarantine") { ?>
                  <p class="font-size-13 mb-0 text-danger"><b>
                    <?= ucfirst($result['Action']) ?>
                    </b></p>
                  <?php } else { ?>
                  <p class="font-size-13 mb-0 text-success">
                    <?= ucfirst($result['Action']) ?>
                  </p>
                  <?php } ?></td>
                <td><a href="javascript:void(0);" class="px-3 text-primary"
                                                   onClick="setmemberInAction(<?= $result['Id'] ?>,'Teacher','Home');"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Stay Home" theid="23"> <img
                                                            src="<?= base_url(); ?>assets/images/icons/Home.png" alt=""
                                                            width="20px"> </a> <a href="javascript:void(0);"
                                                                                  class="text-danger"
                                                                                  data-toggle="tooltip"
                                                                                  onClick="setmemberInAction(<?= $result['Id'] ?>,'Teacher','Quarantine',);"
                                                                                  data-placement="top"
                                                                                  title="Quarantine" theid="23"> <img
                                                            src="<?= base_url(); ?>assets/images/icons/quarntine.jpg"
                                                            alt="" width="20px"> </a></td>
              </tr>
              <?php } ?>
              </tbody>
              
            </table>
          </div>
          <div id="New_Teacher_List"></div>
        </div>
      </div>
    </div>
  </div><?php */ ?>
            <?php /*?> <div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <!-- Actions -->
        <div class="col-xl-12">
            <div class="row">
                <?php if (isset($permissions['users_stay_home']) && $permissions['users_stay_home'] == '1') { ?>
                    <div class="col-xl-6">
                        <h4 class="card-title"
                            style="background: #33A2FF; padding: 10px;color: #FFFFFF;border-radius: 4px;">Stay Home Data
                            Table for All Tests - (Staff, Teacher, and Student)</h4>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                 data-toggle="dropdown" aria-haspopup="true"
                                                                 aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i
                                                            class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                            <div class="dropdown-menu" style="z-index: 100001;">
                                                <li class="dropdown-item"
                                                    onclick="Tempratur_List('#simpl_home_list','#New_home_List');">
                                                    Temperature
                                                </li>
                                                <?php foreach ($tests as $test) { ?>
                                                    <li class="dropdown-item"
                                                        onClick="home_labTests('<?= $test->Test_Desc; ?>');">
                                                        <?= $test->Test_Desc; ?>
                                                    </li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </h4>
                                <h4 class="card-title mb-4"><img
                                            src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png"
                                            style="width: 25px;margin: auto 5px;"> Stay Home(<span
                                            id="STAYHOMESHOWTESTNAME">Temperature</span>) <font color=#e13e2b>(Staff,
                                        Teacher, and Student)</font></h4>
                                <div data-simplebar style="height: 350px;overflow: auto;">
                                    <?php if ($temperatureandlabs) { ?>
                                        <div id="simpl_home_list">
                                            <?php
                                            $listTeachers = array();
                                            $today = date("Y-m-d");
                                            $OurStudens = $this->db->query(" SELECT `l2_student`.* , `r_levels`.`Class` AS StudentClass 
                                                          FROM `l2_student`
                                                          JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                                                          WHERE Added_By = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                                            foreach ($OurStudens as $Teacher) {
                                                $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
                                                $ID = $Teacher['Id'];
                                                $Position = $Teacher['Position'];
                                                $getResults_Teacheer = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                              AND UserType = 'Student'  AND `Action` = 'Home' ORDER BY `Time` DESC LIMIT 1")->result_array();
                                                foreach ($getResults_Teacheer as $T_results) {
                                                    $lastReads = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                                  AND UserType = 'Student'  ORDER BY `Time` DESC LIMIT 1")->result_array();
                                                    $lastRead = $lastReads[0]['Result'];
                                                    $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                                                    $listTeachers[] = array(
                                                        "Username" => $Teachername, "Id" => $ID,
                                                        "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                                                        "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                                                        "Class_OfSt" => $Teacher['StudentClass'], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                                                    );
                                                }
                                            }
                                            ?>
                                            <table class="table table-borderless table-centered table-nowrap table_sites ">
                                                <thead>
                                                <th> Img</th>
                                                <th> Name</th>
                                                <th> Date &amp; Time</th>
                                                <th> Result</th>
                                                <th> Risk</th>
                                                <th> Days</th>
                                                <th> Action</th>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($listTeachers as $sn => $TeacherRes) { ?>
                                                    <tr>
                                                        <td style="width: 20px;"><?php
                                                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                                              WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                                            ?>
                                                            <?php if (empty($avatar)) { ?>
                                                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                                                     class="avatar-xs rounded-circle " alt="...">
                                                            <?php } else { ?>
                                                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                                                     class="avatar-xs rounded-circle " alt="...">
                                                            <?php } ?></td>
                                                        <td><h6 class="mb-1 font-weight-normal"
                                                                style="font-size: 15px;">
                                                                <?= $TeacherRes['Username']; ?>
                                                            </h6>
                                                            <p class="text-muted font-size-13 mb-0"><i
                                                                        class="mdi mdi-user"></i>
                                                                <?= $TeacherRes['Class_OfSt']; ?>
                                                            </p></td>
                                                        <td style="font-size: 12px;"><?= $TeacherRes['LastReadDate']; ?></td>
                                                        <?php boxes_Colors($TeacherRes['LastRead']); ?>
                                                        <td><?php
                                                            $from_craet = $TeacherRes['Creat'];
                                                            $finalDate = dateDiffInDays($from_craet, $today);
                                                            if ($finalDate == 0) {
                                                                echo "Today";
                                                            } elseif ($finalDate > 2) {
                                                                echo $finalDate . " Days";
                                                            } else {
                                                                echo $finalDate . " Day";
                                                            }
                                                            ?></td>
                                                        <td class="out"><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png"
                                                                    onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'Student','School');"
                                                                    width="14px" data-toggle="tooltip"
                                                                    data-placement="top" title=""
                                                                    data-original-title="Exit"></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php StayHomeOf('Teacher'); ?>
                                                <?php StayHomeOf('Staff'); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div id="simpl_home_list"></div>
                                    <?php } ?>
                                    <!-- end simpl_home_list  -->
                                    <div id="New_home_List"></div>
                                </div>
                                <!-- data-sidebar-->
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div>
                <?php } else { ?>
                <?php } ?>
                <?php if (isset($permissions['users_quarantine']) && $permissions['users_quarantine'] == '1') { ?>
                    <div class="col-xl-6">
                        <h4 class="card-title"
                            style="background: #FF0000; padding: 10px;color: #FFFFFF;border-radius: 4px;">Quarantine
                            Data Table for All Tests - (Staff, Teacher, and Student)</h4>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                 data-toggle="dropdown" aria-haspopup="true"
                                                                 aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i
                                                            class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                            <style>
                                                .dropdown-menu * {
                                                    cursor: pointer;
                                                }
                                            </style>
                                            <div class="dropdown-menu" style="z-index: 100001;">
                                                <li class="dropdown-item"
                                                    onclick="Tempratur_List('#simpl_quarantin_list','.New_quarantin_List');">
                                                    Temperature
                                                </li>
                                                <?php foreach ($tests as $test) { ?>
                                                    <li class="dropdown-item"
                                                        onClick="quarntine_labTests('<?= $test->Test_Desc; ?>');">
                                                        <?= $test->Test_Desc; ?>
                                                    </li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </h4>
                                <h4 class="card-title mb-4"><img
                                            src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png"
                                            style="width: 25px;margin: auto 5px;"> Quarantine (<span
                                            id="STAYQuarantineNOSHOWTESTNAME">Temperature</span>)<font color=#e13e2b>
                                        (Staff, Teacher, and Student)</font></h4>
                                <div data-simplebar style="height: 350px;overflow: auto;">
                                    <div id="simpl_quarantin_list">
                                        <?php
                                        $today = date("Y-m-d");
                                        $listTeachers = array();
                                        $OurTeachers = $this->db->query(" SELECT `l2_student`.* , `r_levels`.`Class` AS StudentClass 
                                                                FROM `l2_student`
                                                                JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                                                                WHERE Added_By = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                                        foreach ($OurTeachers as $Teacher) {
                                            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
                                            $ID = $Teacher['Id'];
                                            $Position = $Teacher['Position'];
                                            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                                    AND UserType = 'Student' AND `Action` = 'Quarantine' ORDER BY `Time` DESC LIMIT 1")->result_array();
                                            foreach ($getResults_Teacheer as $T_results) {
                                                $lastReads = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                                        AND UserType = 'Student' ORDER BY `Time` DESC LIMIT 1")->result_array();
                                                $lastRead = $lastReads[0]['Result'];
                                                $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
                                                $listTeachers[] = array(
                                                    "Username" => $Teachername, "Id" => $ID, "TestId" => $T_results['Id'],
                                                    "Testtype" => $T_results['Device_Test'], "Result" => $T_results['Result'],
                                                    "Creat" => $T_results['Result_Date'], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
                                                    "Class_OfSt_q" => $Teacher['StudentClass']
                                                );
                                            }
                                        }
                                        ?>
                                        <table class="table table-borderless table-centered table-nowrap table_sites ">
                                            <thead>
                                            <th> Img</th>
                                            <th> Name</th>
                                            <th> Date &amp; Time</th>
                                            <th> Result</th>
                                            <th> Risk</th>
                                            <th> Days</th>
                                            <th> Action</th>
                                            </thead>
                                            <tbody>
                                            <style>
                                                .badge {
                                                    text-align: center;
                                                }
                                            </style>
                                            <?php foreach ($listTeachers as $sn => $TeacherRes) { ?>
                                                <tr>
                                                    <td style="width: 20px;"><?php $avatar = $this->db->query("SELECT * FROM `l2_avatars` WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array(); ?>
                                                        <?php if (empty($avatar)) { ?>
                                                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                                                 class="avatar-xs rounded-circle " alt="...">
                                                        <?php } else { ?>
                                                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                                                 class="avatar-xs rounded-circle " alt="...">
                                                        <?php } ?></td>
                                                    <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
                                                            <?= $TeacherRes['Username']; ?>
                                                        </h6>
                                                        <p class="text-muted font-size-13 mb-0"><i
                                                                    class="mdi mdi-user"></i>
                                                            <?= $TeacherRes['Class_OfSt_q']; ?>
                                                        </p></td>
                                                    <td style="font-size: 12px;"><?= $TeacherRes['LastReadDate']; ?></td>
                                                    <?php boxes_Colors($TeacherRes['LastRead']); ?>
                                                    <td><?php
                                                        $from_craet = $TeacherRes['Creat'];
                                                        //echo $from_craet;
                                                        //$toTime = $today-$from_craet;
                                                        $finalDate = dateDiffInDays($from_craet, $today);
                                                        if ($finalDate == 0) {
                                                            echo "Today";
                                                        } elseif ($finalDate > 2) {
                                                            echo $finalDate . " Days";
                                                        } else {
                                                            echo $finalDate . " Day";
                                                        }
                                                        ?></td>
                                                    <td class="out"><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png"
                                                                onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'Student','School');"
                                                                width="14px" data-toggle="tooltip" data-placement="top"
                                                                title="" data-original-title="Exit"></td>
                                                </tr>
                                            <?php } ?>
                                            <?php StayHomeOfQuarantin('Teacher'); ?>
                                            <?php StayHomeOfQuarantin('Staff'); ?>
                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="New_quarantin_List"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-xl-6"></div>
                <?php } ?>
            </div>
        </div>
        <!-- CH - 10 -->
        <?php if (isset($permissions['users_tests_sites']) && $permissions['users_tests_sites'] == '1') { ?>
            <?php /*?><div class="col-lg-12"><br>
    <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> Daily Table for All Tests-Sites</h4>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4"><img src="<?= base_url("assets/images/icons/png_icons/pin.png"); ?>"
                                                         style="width: 25px;margin: auto 5px;">Daily List of Tests
          <?= $today; ?>
          <font color=#e13e2b> (Sites)</font></h4>
        <table class="table table_sites">
          <thead>
            <tr>
              <th>#</th>
              <th>Site Name</th>
              <th>Site Desc</th>
              <th>Date &amp; Time</th>
              <th>Batch No</th>
              <th>Test Type</th>
              <th>Result</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="withCounter">
            <?php GetListOfSites(json_decode(json_encode($tests), true)); ?>
          </tbody>
        </table>
      </div>
    </div>
    <style>
                    * {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    .title {
                        background: #f3f4f8;
                        padding: 15px;
                        font-size: 18px;
                        text-align: center;
                        text-transform: uppercase;
                        letter-spacing: 3px;
                    }
                    .file_upload_list li .file_item {
                        display: flex;
                        border-bottom: 1px solid #f3f4f8;
                        padding: 15px 20px;
                    }
                    .file_item .format {
                        background: #8178d3;
                        border-radius: 10px;
                        width: 45px;
                        height: 40px;
                        line-height: 40px;
                        color: #fff;
                        text-align: center;
                        font-size: 12px;
                        margin-right: 15px;
                    }
                    .file_item .file_progress {
                        width: calc(100% - 60px);
                        font-size: 14px;
                    }
                    .file_item .file_info,
                    .file_item .file_size_wrap {
                        display: flex;
                        align-items: center;
                    }
                    .file_item .file_info {
                        justify-content: space-between;
                    }
                    .file_item .file_progress .progress {
                        width: 100%;
                        height: 4px;
                        background: #efefef;
                        overflow: hidden;
                        border-radius: 5px;
                        margin-top: 8px;
                        position: relative;
                    }
                    .file_item .file_progress .progress .inner_progress {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: #58e380;
                    }
                    .file_item .file_size_wrap .file_size {
                        margin-right: 15px;
                    }
                    .file_item .file_size_wrap .file_close {
                        border: 1px solid #8178d3;
                        color: #8178d3;
                        width: 20px;
                        height: 20px;
                        line-height: 18px;
                        text-align: center;
                        border-radius: 50%;
                        font-size: 10px;
                        font-weight: bold;
                        cursor: pointer;
                    }
                    .file_item .file_size_wrap .file_close:hover {
                        background: #8178d3;
                        color: #fff;
                    }
                    .choose_file label {
                        display: block;
                        border: 2px dashed #8178d3;
                        padding: 15px;
                        width: calc(100% - 20px);
                        margin: 10px;
                        text-align: center;
                        cursor: pointer;
                    }
                    .choose_file #choose_file {
                        outline: none;
                        opacity: 0;
                        width: 0;
                    }
                    .choose_file span {
                        font-size: 14px;
                        color: #8178d3;
                    }
                    .choose_file label:hover span {
                        text-decoration: underline;
                    }
                    .file_upload_list {
                        text-align: center;
                    }
                    .card {
                        border: 0px;
                    }
                    .progress {
                        margin-top: 10px;
                    }
                    h6 {
                        padding: 5px;
                    }
                </style>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel"> Upload Report PDF </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="theform">
              <div class="file_upload_list"><i
                                                class="display-4 text-muted uil uil-cloud-upload"></i></div>
              <form id="uploadPdf" name="Pdf_site">
                <div class="choose_file">
                  <label for="choose_file">
                    <input type="file" id="choose_file" name="csvFileStaff" accept=".pdf">
                    <input type="hidden" id="site_result_id" name="site_result_id">
                    <span> Select PDF File </span> </label>
                </div>
                <button type="Submit"
                                                class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 StatusbtnStaff"> Start Upload </button>
              </form>
            </div>
            <div class="StatusBoxStaff"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancel </button>
          </div>
        </div>
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
    <!-- /.modal --> 
  </div><?php */ ?>
            <script>
                $("#uploadPdf").on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Ajax/UploadSiteReport',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $('.theform').fadeOut();
                            $('.StatusBoxStaff').html(data);
                            $('.StatusbtnStaff').removeAttr('disabled');
                            $('.StatusbtnStaff').html('Upload report');
                        },
                        beforeSend: function () {
                            $('.StatusbtnStaff').attr('disabled', '');
                            $('.StatusbtnStaff').html('Please wait');
                        },
                        ajaxError: function () {
                            $('.alert.alert-info').css('background-color', '#DB0404');
                            $('.alert.alert-info').html("Ooops! Error was found.");
                        }
                    });
                });
            </script>
            <!-- CH - 11 -->
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_sterilization']) && $permissions['users_sterilization'] == '1') { ?>
            <?php /*?><div class="col-lg-12"><br>
    <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> Data Table for All Closed Sites (Sterilization) Today</h4>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/icons/png_icons/pin.png"
                                                         style="width: 25px;margin: auto 5px;"> Lab Test List of Sites <font color=#e13e2b> (Closed Sites for Sterilization Today
          <?= $today ?>
          )</font></h4>
        </h4>
        <table class="table table_sites">
          <thead>
            <tr>
              <th>#</th>
              <th>Site Name</th>
              <th>Site Desc</th>
              <th>Date &amp; Time</th>
              <th>Batch No</th>
              <th>Test Type</th>
              <th>Result</th>
              <th>Report</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="withCounter">
            <?php GetListOfSites_InCleaning(json_decode(json_encode($tests), true), $today); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div><?php */ ?>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <?php if (isset($permissions['users_sterilization_history']) && $permissions['users_sterilization_history'] == '1') { ?>
            <?php /*?><div class="col-lg-12"><br>
    <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> Data Table for All Closed Sites (Sterilization) History</h4>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/icons/png_icons/pin.png"
                                                         style="width: 25px;margin: auto 5px;"> Lab Test List of Sites <font color=#e13e2b> (Closed Sites for Sterilization)</font></h4>
        <table class="table table_sites">
          <thead>
            <tr>
              <th>#</th>
              <th>Site Name</th>
              <th>Site Desc</th>
              <th>Date &amp; Time</th>
              <th>Batch No</th>
              <th>Test Type</th>
              <th>Result</th>
              <th>Report</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="withCounter">
            <?php GetListOfSites_InCleaning(json_decode(json_encode($tests), true)); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div><?php */ ?>
            <?php /*?><div class="card">
    <div class="card-body text-center"><img src="<?= base_url("assets/images/Schooldashboard.png") ?>"
                                                        height="120" alt="" srcset=""></div>
  </div><?php */ ?>
        <?php } ?>
        <div id="return"></div>
    </div>
    <script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>
    <script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
    <script>
        $("table").DataTable();
        $(function () {
            $(".knob").knob();
            $('.knob').each(function () {
                const $this = $(this);
                const value = $this.val();
                $(this).val(value);
            });
        });

        function GetStaffChart() {
            $('#SelectTheClassCard').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/schools/ChartofTempForStaff',
                beforeSend: function () {
                    $('#drawChart').html('');
                    $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
                },
                success: function (data) {
                    $('#drawChart').removeAttr('disabled', '');
                    $('#drawChart').html(data);
                },
                ajaxError: function () {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        }

        function GetTeacherChart() {
            $('#SelectTheClassCard').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/schools/ChartofTempForTeacher',
                beforeSend: function () {
                    $('#drawChart').html('');
                    $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
                },
                success: function (data) {
                    $('#drawChart').removeAttr('disabled', '');
                    $('#drawChart').html(data);
                },
                ajaxError: function () {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        }

        function GetStudentChart() {
            $('#drawChart').html("");
            $('#SelectTheClassCard').slideDown();
        }

        $("#SelectFromClass").change(function () {
            var selectedclass = $(this).children("option:selected").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Schools/ChartTempOfClass',
                data: {
                    NumberOfClass: selectedclass,
                },
                beforeSend: function () {
                    // setting a timeout
                    $("#drawChart").html('Please Wait.....');
                },
                success: function (data) {
                    $('#drawChart').html("");
                    $('#drawChart').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    )
                }
            });
        });

        function Get_plus_minus_students(type) {
            $('#ResultsTableStudents').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/ajax/GetClassesList',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('.New_Select').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
            $('.classes_temp').hide();
        }

        function ConnectedWithClass(className) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/schools/ListConnectedTeachers',
                data: {
                    class: className,
                },
                beforeSend: function () {
                    $('#TeachersCon').html('');
                    $('#TeachersCon').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
                },
                success: function (data) {
                    $('#TeachersCon').removeAttr('disabled', '');
                    $('#TeachersCon').html(data);
                },
                ajaxError: function () {
                    $('#TeachersCon').css('background-color', '#DB0404');
                    $('#TeachersCon').html("Ooops! Error was found.");
                }
            });
        }

        function GetTheStudentsResultsForClass(className) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/schools/ListResultsOfDtudents',
                data: {
                    class: className,
                },
                beforeSend: function () {
                    $('#ResultsTableStudents').html('');
                    $('#ResultsTableStudents').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
                },
                success: function (data) {
                    $('#ResultsTableStudents').removeAttr('disabled', '');
                    $('#ResultsTableStudents').html(data);
                },
                ajaxError: function () {
                    $('#ResultsTableStudents').css('background-color', '#DB0404');
                    $('#ResultsTableStudents').html("Ooops! Error was found.");
                }
            });
        }

        function staff_labTests(type) {
            $('#STAFFSNOSHOWTESTNAME').html(type);
            $('#simpl_staff_list').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/ajax/Get_Staffs_List',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('#New_Staff_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
            //$('.classes_temp').hide();
        }

        function Tempratur_List(id, emp) {
            if (id == '#simpl_home_list' && emp == '#New_home_List') {
                $('#STAYHOMESHOWTESTNAME').html('TEMPERATURE ');
            } else if (id == '#simpl_quarantin_list' && emp == '.New_quarantin_List') {
                $('#STAYQuarantineNOSHOWTESTNAME').html('TEMPERATURE ');
            } else if (id == '#simpl_staff_list' && emp == '#New_Staff_List') {
                $('#STAFFSNOSHOWTESTNAME').html('TEMPERATURE ');
            } else if (id == '#simpl_Teacher_list' && emp == '#New_Teacher_List') {
                $('#TEACHERSSNOSHOWTESTNAME').html('TEMPERATURE ');
            }
            $(id).slideDown();
            $(emp).html('');
        }

        function Teacher_labTests(type) {
            $('#TEACHERSSNOSHOWTESTNAME').html(type);
            $('#simpl_Teacher_list').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/ajax/Get_Teachers_List',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('#New_Teacher_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
            //$('.classes_temp').hide();
        }

        function home_labTests(type) {
            $('#STAYHOMESHOWTESTNAME').html(type);
            $('#simpl_home_list').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/ajax/Get_home_List',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('#New_home_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
            //$('.classes_temp').hide();
        }

        function quarntine_labTests(type) {
            $('#STAYQuarantineNOSHOWTESTNAME').html(type);
            $('#simpl_quarantin_list').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/ajax/Get_Quaranrine_List',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('.New_quarantin_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    );
                }
            });
            //$('.classes_temp').hide();
        }

        function RemoveThisMemberFrom(id, usertype, action) {
            var theId = id;
            console.log(theId);
            Swal.fire({
                title: ' Are you sure you want to do this action?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Yes, I am sure!`,
                icon: 'warning',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Schools/ApplyActionOnMember',
                        data: {
                            S_Id: theId,
                            Action: action,
                            UserType: usertype,
                        },
                        success: function (data) {
                            $('#return').html(data);
                        },
                        ajaxError: function () {
                            Swal.fire(
                                'error',
                                'oops!! we have a error',
                                'error'
                            )
                        }
                    });
                }
            });
        }

        $(".ch004results").on("click", ".set-in-action", function () {
            const data = {
                id: $(this).data("id"),
                type: $(this).data("type"),
                to: $(this).data("change-to"),
            };
            setmemberInAction(data.id, data.type, data.to);
        });

        function setmemberInAction(id, usertype, action) {
            var theId = id;
            Swal.fire({
                title: 'Are you sure you want to do this action?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Yes, I am sure!`,
                icon: 'warning',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Schools/ApplyActionOnMember',
                        data: {
                            S_Id: theId,
                            Action: action,
                            UserType: usertype,
                        },
                        success: function (data) {
                            $('#return').html(data);
                        },
                        ajaxError: function () {
                            Swal.fire(
                                'error',
                                'oops!! we have a error',
                                'error'
                            )
                        }
                    });
                }
            });
        }
    </script>
    <?php
    function symps($symps)
    {
        $ci = &get_instance();
        $Symps_array = explode(';', $symps);
        $sz = sizeof($Symps_array);
        //print_r($Symps_array);
        if ($sz > 1) {
            foreach ($Symps_array as $sympsArr) {
                //print_r($sympsArr);
                //echo sizeof($Symps_array);
                $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                foreach ($SempName as $name) {
                    echo $name['symptoms_EN'] . ",";
                }
            }
        } else {
            echo "No Symptoms Found ";
        }
    }

    function boxes_Colors($result)
    {
        ?>
        <style>
            .Td-Results_font span {
                font-size: 20px !important;
                padding: 6px;
            }

            .Td-Results .badge {
                padding: 6px;
            }
        </style>
        <td class="Td-Results_font"><?php if ($result >= 38.501 && $result <= 45.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;">
  <?= $result; ?>
  </span>
                <!-- Hight -->

            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;">
  <?= $result; ?>
  </span>
                <!-- Low -->

            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;">
  <?= $result; ?>
  </span>
                <!-- No Risk -->

            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;">
  <?= $result; ?>
  </span>
                <!-- Moderate -->

            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;">
  <?= $result; ?>
  </span>
                <!-- Error -->

            <?php } ?></td>
        <td class="Td-Results"><?php if ($result >= 38.500 && $result <= 45.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">High</span>
            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">Moderate</span>
            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">No Risk</span>
            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;">Low</span>
            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">Error</span>
            <?php } ?></td>
        <?php
    }

    function StayHomeOf($type)
    {
        $ci = &get_instance();
        $count_home = 0;
        $ci->load->library('session');
        $sessiondata = $ci->session->userdata('admin_details');
        if ($type == "Teacher") {
            $ours = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Home'")->result_array();
        } else {
            $ours = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Home'")->result_array();
        }
        $listTeachers = array();
        $today = date("Y-m-d");
        foreach ($ours as $Teacher) {
            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
            $ID = $Teacher['Id'];
            if ($type == "Teacher") {
                $Position = $ci->schoolHelper->getTeacherPosition($Teacher['Position']);
            } else {
                $Position = $ci->schoolHelper->getStaffPosition($Teacher['Position']);
            }
            $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
        AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
                $listTeachers[] = array(
                    "Username" => $Teachername, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                    "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                    "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
                );
            }
        }
        ?>
        <style>
            .badge {
                text-align: center;
            }
        </style>
        <?php
        $count_home += sizeof($listTeachers);
        foreach ($listTeachers as $TeacherRes) {
            ?>
            <tr>
                <td style="width: 20px;"><?php
                    $avatar = $ci->db->query("SELECT * FROM `l2_avatars`
            WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                    ?>
                    <?php if (empty($avatar)) { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } ?></td>
                <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
                        <?= $TeacherRes['Username']; ?>
                    </h6>
                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                        <?= $TeacherRes['Class_OfSt']; ?>
                    </p></td>
                <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
                <?php boxes_Colors($TeacherRes['LastRead']); ?>
                <td><?php
                    $from_craet = $TeacherRes['Creat'];
                    //echo $from_craet;
                    //$toTime = $today-$from_craet;
                    $date_exp = explode(" ", $from_craet)[0];
                    $finalDate = dateDiffInDays($date_exp, $today);
                    if ($finalDate == 0) {
                        echo "Today";
                    } elseif ($finalDate > 2) {
                        echo $finalDate . " Days";
                    } else {
                        echo $finalDate . " Day";
                    }
                    ?></td>
                <td class="out"><img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png"
                                     onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'<?= $type ?>','School');"
                                     width="14px" data-toggle="tooltip" data-placement="top" title=""
                                     data-original-title="Exit"></td>
            </tr>
            <?php
        }
    }

    function StayHomeOfQuarantin($type)
    {
        $ci = &get_instance();
        $count = 0;
        $ci->load->library('session');
        $sessiondata = $ci->session->userdata('admin_details');
        if ($type == "Teacher") {
            $ours = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Quarantine' ")->result_array();
        } else {
            $ours = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Quarantine'  ")->result_array();
        }
        $listTeachers = array();
        $today = date("Y-m-d");
        foreach ($ours as $Teacher) {
            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
            $ID = $Teacher['Id'];
            if ($type == "Teacher") {
                $Position = $ci->schoolHelper->getTeacherPosition($Teacher['Position']);
            } else {
                $Position = $ci->schoolHelper->getStaffPosition($Teacher['Position']);
            }
            $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
        AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
            foreach ($getResults_Teacheer as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listTeachers[] = array(
                    "Username" => $Teachername, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                    "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                    "Class_OfSt" => $Position,
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                );
            }
        }
        ?>
        <style>
            .badge {
                text-align: center;
            }
        </style>
        <?php
        foreach ($listTeachers as $TeacherRes) {
            ?>
            <?php //print_r($TeacherRes);
            ?>
            <tr>
                <td style="width: 20px;"><?php
                    $avatar = $ci->db->query("SELECT * FROM `l2_avatars`
            WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                    ?>
                    <?php if (empty($avatar)) { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                             class="avatar-xs rounded-circle " alt="...">
                    <?php } ?></td>
                <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
                        <?= $TeacherRes['Username']; ?>
                    </h6>
                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                        <?= $TeacherRes['Class_OfSt']; ?>
                    </p></td>
                <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
                <?php boxes_Colors($TeacherRes['LastRead']); ?>
                <td><?php
                    $from_craet = $TeacherRes['Creat'];
                    //echo $from_craet;
                    //$toTime = $today-$from_craet;
                    $date_exp = explode(" ", $from_craet)[0];
                    $finalDate = dateDiffInDays($date_exp, $today);
                    if ($finalDate == 0) {
                        echo "Today";
                    } elseif ($finalDate > 2) {
                        echo $finalDate . " Days";
                    } else {
                        echo $finalDate . " Day";
                    }
                    ?></td>
                <td class="out"><img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png"
                                     onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'<?= $type ?>','School');"
                                     width="14px" data-toggle="tooltip" data-placement="top" title=""
                                     data-original-title="Exit"></td>
            </tr>
            <?php
        }
    }

    function dateDiffInDays($date1, $date2)
    {
        // Calculating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }

    function GetListOfSites($list_Tests)
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $today = date("Y-m-d");
        $listSites = array();
        $sessiondata = $ci->session->userdata('admin_details');
        $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Site_Code` ASC ")->result_array();
        foreach ($list_Tests as $test) {
            get_site_of_test($sitesForThisUser, $test['Test_Desc']);
        }
        //print_r($sitesForThisUser);
    }

    function get_site_of_test($sitesForThisUser, $testType)
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $today = date("Y-m-d");
        $listSites = array();
        $sessiondata = $ci->session->userdata('admin_details');
        foreach ($sitesForThisUser as $site) {
            $name = $site['Description'];
            $site_name = $site['Site_Code'];
            $ID = $site['Id'];
            $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND 
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
            //print_r($getResults);
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                    "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
                );
                //}
            }
        }
        ///print_r($listSites);
        foreach ($listSites as $siteResult) {
            ?>
            <tr>
                <td>--</td>
                <td><?= $siteResult['name'] ?></td>
                <td><?= $siteResult['SiteName'] ?></td>
                <td><?= $siteResult['LastReadDate'] ?></td>
                <td><?= $siteResult['Batch'] ?></td>
                <td><?= $siteResult['Testtype'] ?></td>
                <?php if ($siteResult['Action'] == "School") { ?>
                    <?php if ($siteResult['Result'] == '0') { ?>
                        <td><span class="badge font-size-12"
                                  style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
                    <?php } else { ?>
                        <td><span class="badge font-size-12"
                                  style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">Positive (+)</span></td>
                    <?php } ?>
                <?php } else { ?>
                    <?php if ($siteResult['Result'] == '0') { ?>
                        <td><span class="badge font-size-12"
                                  style="width: 100%;background-color: #047B04;color: #ffffff;">Negative (-)</span></td>
                    <?php } else { ?>
                        <td><span class="badge font-size-12"
                                  style="width: 100%;background-color: #BC2200;color: #FFFFFF;">Positive (+)</span></td>
                    <?php } ?>
                <?php } ?>
                <td><?php if ($siteResult['Action'] == "School") { ?>
                        <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px"
                             onClick="SET_SiteInAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;"
                             data-toggle="tooltip" data-placement="top" data-original-title="Close for decontamination">
                    <?php } ?></td>
            </tr>
            <?php
        }
    }

    function GetListOfSites_InCleaning($list_Tests, $date = null)
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $today = date("Y-m-d");
        $listSites = array();
        $sessiondata = $ci->session->userdata('admin_details');
        $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Site_Code` ASC ")->result_array();
        $oftoday = $date == null ? false : true;
        foreach ($list_Tests as $test) {
            get_site_of_test_In($sitesForThisUser, $test['Test_Desc'], 'Cleaning', $oftoday);
        }
    }

    function get_site_of_test_In($sitesForThisUser, $testType, $action, $date = false) {
    $ci = &get_instance();
    $ci->load->library('session');
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');
    if (!$date) {
        foreach ($sitesForThisUser as $site) {
            $name = $site['Description'];
            $site_name = $site['Site_Code'];
            $ID = $site['Id'];
            $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
            AND UserType = 'Site' AND `Action` = '" . $action . "' AND
            `Test_Description` = '" . $testType . "' AND `Created` >= '" . date("Y-m-d", strtotime("-7 days")) . "' AND `Created` <= '" . $today . "'
            ORDER BY `Id` DESC  ")->result_array();
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
                AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' AND `Action` = 'Cleaning' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                    "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
                );
                //}
            }
        }
    } else {
        foreach ($sitesForThisUser as $site) {
            $name = $site['Description'];
            $site_name = $site['Site_Code'];
            $ID = $site['Id'];
            $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
            AND UserType = 'Site' AND `Action` = '" . $action . "' AND
            `Test_Description` = '" . $testType . "' AND Created = '" . $today . "'  ORDER BY `Id` DESC ")->result_array();
            //print_r($getResults);
            foreach ($getResults as $T_results) {
                $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
                AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[0]['Result'];
                $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
                    "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
                    "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
                );
                //}
            }
        }
    }
    ///print_r($listSites);
    foreach ($listSites

    as $siteResult) {
    ?>
    <tr>
        <td>--</td>
        <td><?= $siteResult['name'] ?></td>
        <td><?= $siteResult['SiteName'] ?></td>
        <td><?= $siteResult['LastReadDate'] ?></td>
        <td><?= $siteResult['Batch'] ?></td>
        <td><?= $siteResult['Testtype'] ?></td>
        <?php if ($siteResult['Action'] == "School") { ?>
            <?php if ($siteResult['Result'] == '0') { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
            <?php } else { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #ff2e00;color: #d2d2d2;">Positive (+)</span></td>
            <?php } ?>
        <?php } else { ?>
            <?php if ($siteResult['Result'] == '0') { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #008700;color: #ffffff;">Negative (-)</span></td>
            <?php } else { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #B82100;color: #d2d2d2;">Positive (+)</span></td>
            <?php } ?>
        <?php } ?>
        <td><i class="uil uil-file" data-toggle="modal" data-target="#myModal"
               style="font-size: 19px;color: #2eb6ef;cursor: pointer;"
               onClick="UploadTheReportPdf(<?= $siteResult['TestId'] ?>);"></i></td>
        <td><?php if ($siteResult['Action'] == "School") { ?>
                <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px"
                     onClick="SET_SiteInAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;"
                     data-toggle="tooltip" data-placement="top" data-original-title="Close For Sterilization">
            <?php } else { ?>
                <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" alt="Remove" width="20px"
                     onclick="Remove_SiteFromAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;"
                     data-toggle="tooltip" data-placement="top" data-original-title="Sterilization  Done !">
            <?php } ?></td>
    </tr>
<?php
}
}
?>