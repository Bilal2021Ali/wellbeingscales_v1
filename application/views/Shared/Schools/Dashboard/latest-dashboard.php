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
        <div class="rightbar-title px-3 py-4"><a href="javascript:void(0);" class="right-bar-toggle float-right"> <i
                        class="mdi mdi-close noti-icon"></i> </a> <h5 class="m-0">Teachers List</h5>
        </div>
        <hr class="mt-0"/>
        <h6 class="text-center mb-0"><?= __("connected_teachers") ?></h6>
        <div class="p-4" id="TeachersCon"><?= __("wait_please") ?></div>
    </div>
</div>

<div class="main-content">
    <div class="page-content">
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"><?= __("users_counters") ?></h4>
        <div class="row">
            <?php foreach ($cards as $card) { ?>
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card"
                         style="background: url('<?= base_url("assets/images/schoolDashboard/" . $card['bg']); ?>');background-position: center;background-repeat: no-repeat;background-size: cover;border-color: <?= $card['border'] ?>">
                        <div class="card-body">
                            <div class="float-right mt-2"><img
                                        src="<?= base_url(); ?>assets/images/schoolDashboard/icons/<?= $card['icons'] ?>"
                                        alt="<?= $card['Title'] ?>"></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span
                                            data-plugin="counterup"> <?= $card['Data']['allCounter'] ?? '--' ?> </span>
                                </h4>
                                <p class="mb-0"> <?= $card['Title'] ?> </p>
                            </div>
                            <p class="mt-3 mb-0"><span
                                        class="mr-1"><span><?= $card['Data']['LastAdded'] ?? '--/--/--' ?> </span><br>
                            </p>
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
                            <h3 class="card-title"><?= __("counters_and_percentage") ?></h3>
                            <div id="userschart" class="apex-charts"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= __("genders") ?></h3>
                            <div id="genders_bars"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    chart: {
                        height: 350,
                        type: 'pie',
                    },
                    series: [<?= sizeof($counters['staff']) ?>, <?= sizeof($counters['teachers']) ?>, <?= sizeof($counters['students']) ?>, <?= sizeof($counters['parents']) ?>],
                    labels: ["<?= __("staff") ?>", "<?= __("teachers") ?>", "<?= __("students") ?>", "<?= __("parents") ?>"],
                    colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1"],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        verticalAlign: 'middle',
                        floating: false,
                        fontSize: '18px',
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
                    document.querySelector("#userschart"),
                    options
                );
                chart.render();


                var options = {
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    tooltip: {
                        x: {
                            show: false
                        },
                        y: {
                            show: false
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
                        name: '<?= __("males") ?>',
                        data: [<?= $counters['gendersCounters']['M'] ?>]
                    }, {
                        name: '<?= __("females") ?>',
                        data: [<?= $counters['gendersCounters']['F'] ?>]
                    }
                    ],
                    colors: ['#0070c0', '#ff4da6'],
                    xaxis: {
                        categories: ["<?= __("male") ?>", "<?= __("female") ?>"],
                        fillColor: ['#EB8C87', '#5b9cd6'],
                        legend: {
                            show: true,
                            position: 'bottom',
                            horizontalAlign: 'center',
                            verticalAlign: 'middle',
                            floating: true,
                            fontSize: '16px',
                            offsetX: 0
                        },
                    }
                }
                var chart = new ApexCharts(
                    document.querySelector("#genders_bars"),
                    options
                );
                chart.render();
            </script>
        <?php } ?>
        <?php if (isset($permissions['users_marital_status']) && $permissions['users_marital_status'] == '1') { ?>
            <script>
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
                        data: [<?= $counters['gendersCounters']['M'] ?>]
                    }, {
                        name: '',
                        data: [<?= $counters['gendersCounters']['F'] ?>]
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
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"><?= __("well_being") ?></h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= __("well_being") ?></h3>
                            <div id="wellbeing_counters"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= __("user_type") ?></h3>
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
                            categories: ["<?= __("published_surveys") ?>", "<?= __("expired_surveys") ?>", "<?= __("completed_surveys") ?>", "<?= __("categories") ?>"]
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
                            categories: ["<?= __("staff") ?>", "<?= __("teachers") ?>", "<?= __("students") ?>", "<?= __("parents") ?>"]
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
                <?= __("speak_out") ?> </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= __("speak_out") ?> </h3>
                            <div id="chart-speak-out-f"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= __("speak_out_priority") ?></h3>
                            <div id="chart-speak-out-l"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    series: [{
                        name: "",
                        data: [<?= sizeof($speakout['pending']) + sizeof($speakout['seen']) ?>, <?= sizeof($speakout['approved']) + sizeof($speakout['resolved']) ?>]
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
                        categories: ['<?= __("pending") ?>', '<?= __("resolved") ?>']
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
                        data: [<?= sizeof($speakout['average']) ?>, <?= sizeof($speakout['urgent']) ?>, <?= sizeof($speakout['high']) + sizeof($speakout['highest']) ?>,]
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
                        categories: ['<?= __("average") ?>', '<?= __("urgent") ?>', '<?= __("high") ?>']
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
        <?php } ?>
        <?php if (isset($permissions['users_daily_temperature']) && $permissions['users_daily_temperature'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"> <?= __("daily_temperature") ?> </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= __("daily_temperature") ?></h3>
                            <div id="daily-temprature-1" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= __("daily_temperature") ?></h3>
                            <div id="daily-temprature-2" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <?php foreach ($templevels as $ttype => $s) { ?>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center"><?= __($ttype . "_temperature") ?></h3>
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
                            categories: ["<?= __("low_temperature") ?>", "<?= __("normal_temperature") ?>", "<?= __("moderate_temperature") ?>", "<?= __("high_temperature") ?>"]
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
                        labels: ["<?= __("low_temperature") ?>", "<?= __("normal_temperature") ?>", "<?= __("moderate_temperature") ?>", "<?= __("high_temperature") ?>"],
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
                            categories: ["<?= __("teacher") ?>", "<?= __("staff") ?>", "<?= __("student") ?>"]
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
        <?php } ?>
        <?php if (isset($permissions['users_daily_labtests']) && $permissions['users_daily_labtests'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"> <?= __("lab_test_counters") ?>
                <span class="float-right"><a
                            href="<?= base_url($language . "/schools/all-labtests-results") ?>"
                            target="_blank" class="text-white"
                            rel="noopener noreferrer"><?= __("show_more") ?></a></span></h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= __("daily_lab_test") ?></h3>
                            <div id="labtests-bar-charts" class="labtest-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= __("lab_test") ?></h3>
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
                    series: [
                        {
                            name: '<?= __("negative") ?>',
                            data: [<?= array_sum(array_map(function ($test) use ($labtests) {
                                return $labtests[$test->Test_Desc]['negative'];
                            }, $tests)) ?>]
                        },
                        {
                            name: '<?= __("positive") ?>',
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
                        categories: ["<?= __("negative") ?>", "<?= __("positive") ?>"]
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
                    labels: ["<?= __("negative") ?>", "<?= __("positive") ?>"],
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
        <?php } ?>
        <?php if (isset($permissions['users_home_quarantine']) && $permissions['users_home_quarantine'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
                <?= __("home_quarantine_and_quarantine") ?>
                <span class="float-right">
                    <a class="text-white" href="<?= base_url($language . "/schools/labtestall") ?>"
                       rel="noopener noreferrer"><?= __("more_details") ?></a>
                </span>
            </h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= __("counters_home_quarantine_and_quarantine") ?></h3>
                            <div class="labtest-chart" id="counters-home-quarntine"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= __("percentage_home_quarantine_and_quarantine") ?></h3>
                            <div class="labtest-chart" id="percentage-home-quarntine"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var options = {
                    series: [{
                        name: "<?= __("home_quarantine") ?>",
                        data: [<?= $temperature['staff']['home'] ?>, <?= $temperature['teacher']['home'] ?>, <?= $temperature['student']['home'] ?>]
                    }, {
                        name: "<?= __("quarantine") ?>",
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
                        categories: ["<?= __("staff") ?>", "<?= __("teachers") ?>", "<?= __("students") ?>"],
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
                    labels: ["<?= __("home_quarantine") ?>", "<?= __("quarantine") ?>"],
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
        <?php if (isset($permissions['users_classes_counters']) && $permissions['users_classes_counters'] == '1') { ?>
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"> <?= __("attendance_counter") ?>
                <span class="float-right"><a class="text-white"
                                             href="<?= base_url($language . "/schools/students-classes") ?>"
                                             target="_blank"
                                             rel="noopener noreferrer"><?= __("show_more") ?></a></span></h4>
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
                        categories: ["<?= __("number_of_students_present") ?>", "<?= __("number_of_students_absent") ?>"],
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
                    labels: ["<?= __("total_students") ?>", "<?= __("total_absent_today") ?>"],
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
        <?php } ?>
        <!-- Actions -->
        <div class="col-xl-12">
            <div class="row">
                <?php if (isset($permissions['users_stay_home']) && $permissions['users_stay_home'] == '1') { ?>
                    <div class="col-xl-6">
                        <h4 class="card-title"
                            style="background: #33A2FF; padding: 10px;color: #FFFFFF;border-radius: 4px;"><?= __("stay_home_data") ?> <?= __("table_for_all_tests") ?></h4>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                 data-toggle="dropdown" aria-haspopup="true"
                                                                 aria-expanded="false"> <span
                                                        class="text-muted"><b><?= __("select_test") ?></b><i
                                                            class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                            <div class="dropdown-menu" style="z-index: 100001;">
                                                <li class="dropdown-item"
                                                    onclick="Tempratur_List('#simpl_home_list','#New_home_List');">
                                                    <?= __("temperature") ?>
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
                                            style="width: 25px;margin: auto 5px;"> <?= __("stay_home") ?>(<span
                                            id="STAYHOMESHOWTESTNAME"><?= __("temperature") ?></span>) <font
                                            color=#e13e2b><?= __("staff_teacher_and_student") ?></font></h4>
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
                                                $Teachername = $Teacher['F_name_' . $language] . ' ' . $Teacher['L_name_' . $language];
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
                                                <th> <?= __("img") ?></th>
                                                <th> <?= __("name") ?></th>
                                                <th> <?= __("date_time") ?></th>
                                                <th> <?= __("result") ?></th>
                                                <th> <?= __("risk") ?></th>
                                                <th> <?= __("days") ?></th>
                                                <th> <?= __("action") ?></th>
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
                                                                echo __("today");
                                                            } elseif ($finalDate > 2) {
                                                                echo $finalDate . " " . __("days");
                                                            } else {
                                                                echo $finalDate . " " . __("day");
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
                            style="background: #FF0000; padding: 10px;color: #FFFFFF;border-radius: 4px;"><?= __("quarantine") ?> <?= __("quarantine_data_table") ?></h4>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                 data-toggle="dropdown" aria-haspopup="true"
                                                                 aria-expanded="false"> <span
                                                        class="text-muted"><b><?= __("select_test") ?></b><i
                                                            class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                            <style>
                                                .dropdown-menu * {
                                                    cursor: pointer;
                                                }
                                            </style>
                                            <div class="dropdown-menu" style="z-index: 100001;">
                                                <li class="dropdown-item"
                                                    onclick="Tempratur_List('#simpl_quarantin_list','.New_quarantin_List');">
                                                    <?= __("temperature") ?>
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
                                            style="width: 25px;margin: auto 5px;"> <?= __("quarantine") ?> (<span
                                            id="STAYQuarantineNOSHOWTESTNAME"><?= __("temperature") ?></span>)<font
                                            color=#e13e2b><?= __("staff_teacher_and_student") ?></font></h4>
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
                                            $Teachername = $Teacher['F_name_' . $language] . ' ' . $Teacher['L_name_' . $language];
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
                                            <th> <?= __("img") ?></th>
                                            <th> <?= __("name") ?></th>
                                            <th> <?= __("date_time") ?></th>
                                            <th> <?= __("result") ?></th>
                                            <th> <?= __("risk") ?></th>
                                            <th> <?= __("days") ?></th>
                                            <th> <?= __("action") ?></th>
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
                                                            echo __("today");
                                                        } elseif ($finalDate > 2) {
                                                            echo $finalDate . " " . __("days");
                                                        } else {
                                                            echo $finalDate . " " . __("day");
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
            <script>
                $("#uploadPdf").on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url($language . "/Ajax/UploadSiteReport"); ?>',
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
                            $('.alert.alert-info').html("<?= __("we_have_an_error") ?>");
                        }
                    });
                });
            </script>
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
                url: '<?= base_url($language . "/schools/ChartofTempForStaff"); ?>',
                beforeSend: function () {
                    $('#drawChart').html('');
                    $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only"><?= __("loading") ?>...</span></div>');
                },
                success: function (data) {
                    $('#drawChart').removeAttr('disabled', '');
                    $('#drawChart').html(data);
                },
                ajaxError: function () {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("<?= __("we_have_an_error") ?>");
                }
            });
        }

        function GetTeacherChart() {
            $('#SelectTheClassCard').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url($language . "/schools/ChartofTempForTeacher"); ?>',
                beforeSend: function () {
                    $('#drawChart').html('');
                    $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only"><?= __("loading") ?>...</span></div>');
                },
                success: function (data) {
                    $('#drawChart').removeAttr('disabled', '');
                    $('#drawChart').html(data);
                },
                ajaxError: function () {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("<?= __("we_have_an_error") ?>");
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
                url: '<?= base_url($language . "/Schools/ChartTempOfClass"); ?>',
                data: {
                    NumberOfClass: selectedclass,
                },
                beforeSend: function () {
                    // setting a timeout
                    $("#drawChart").html('<?= __("wait_please") ?>.....');
                },
                success: function (data) {
                    $('#drawChart').html("");
                    $('#drawChart').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        '<?= __("error") ?>',
                        '<?= __("we_have_an_error") ?>',
                        'error'
                    )
                }
            });
        });

        function Get_plus_minus_students(type) {
            $('#ResultsTableStudents').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url($language . "/ajax/GetClassesList"); ?>',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('.New_Select').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        '<?= __("error") ?>',
                        '<?= __("we_have_an_error") ?>',
                        'error'
                    );
                }
            });
            $('.classes_temp').hide();
        }

        function ConnectedWithClass(className) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url($language . "/schools/ListConnectedTeachers"); ?>',
                data: {
                    class: className,
                },
                beforeSend: function () {
                    $('#TeachersCon').html('');
                    $('#TeachersCon').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only"><?= __("loading") ?>...</span></div>');
                },
                success: function (data) {
                    $('#TeachersCon').removeAttr('disabled', '');
                    $('#TeachersCon').html(data);
                },
                ajaxError: function () {
                    $('#TeachersCon').css('background-color', '#DB0404');
                    $('#TeachersCon').html("<?= __("we_have_an_error") ?>");
                }
            });
        }

        function GetTheStudentsResultsForClass(className) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url($language . "/schools/ListResultsOfDtudents"); ?>',
                data: {
                    class: className,
                },
                beforeSend: function () {
                    $('#ResultsTableStudents').html('');
                    $('#ResultsTableStudents').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only"><?= __("loading") ?>...</span></div>');
                },
                success: function (data) {
                    $('#ResultsTableStudents').removeAttr('disabled', '');
                    $('#ResultsTableStudents').html(data);
                },
                ajaxError: function () {
                    $('#ResultsTableStudents').css('background-color', '#DB0404');
                    $('#ResultsTableStudents').html("<?= __("we_have_an_error") ?>");
                }
            });
        }

        function staff_labTests(type) {
            $('#STAFFSNOSHOWTESTNAME').html(type);
            $('#simpl_staff_list').slideUp();
            $.ajax({
                type: 'POST',
                url: '<?= base_url($language . "/ajax/Get_Staffs_List"); ?>',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('#New_Staff_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        '<?= __("error") ?>',
                        '<?= __("we_have_an_error") ?>',
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
                url: '<?= base_url($language . " / ajax / Get_Teachers_List"); ?>',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('#New_Teacher_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        '<?= __("error") ?>',
                        '<?= __("we_have_an_error") ?>',
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
                url: '<?= base_url($language . "/ajax/Get_home_List"); ?>',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('#New_home_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        '<?= __("error") ?>',
                        '<?= __("we_have_an_error") ?>',
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
                url: '<?= base_url($language . "/ajax/Get_Quaranrine_List"); ?>',
                data: {
                    TestDesc: type,
                },
                success: function (data) {
                    $('.New_quarantin_List').html(data);
                },
                ajaxError: function () {
                    Swal.fire(
                        '<?= __("error") ?>',
                        '<?= __("we_have_an_error") ?>',
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
                        url: '<?= base_url($language . "/Schools/ApplyActionOnMember"); ?>',
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
                                '<?= __("error") ?>',
                                '<?= __("we_have_an_error") ?>',
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
                        url: '<?= base_url($language . "/Schools/ApplyActionOnMember"); ?>',
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
                                '<?= __("error") ?>',
                                '<?= __("we_have_an_error") ?>',
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
        $language = $ci::LANGUAGE;

        $Symps_array = explode(';', $symps);
        $sz = sizeof($Symps_array);
        //print_r($Symps_array);
        if ($sz > 1) {
            foreach ($Symps_array as $sympsArr) {
                //print_r($sympsArr);
                //echo sizeof($Symps_array);
                $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                foreach ($SempName as $name) {
                    echo $name['symptoms_' . $language] . ",";
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
                      style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"><?= __("high") ?></span>
            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;"><?= __("moderate") ?></span>
            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;"><?= __("no-risk") ?></span>
            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;"><?= __("low") ?></span>
            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #272727;color: #fff;"><?= __("error") ?></span>
            <?php } ?></td>
        <?php
    }

    function StayHomeOf($type)
    {
        $ci = &get_instance();
        $language = $ci::LANGUAGE;

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
            $Teachername = $Teacher['F_name_' . $language] . ' ' . $Teacher['L_name_' . $language];
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
        $language = $ci::LANGUAGE;

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
            $Teachername = $Teacher['F_name_' . $language] . ' ' . $Teacher['L_name_' . $language];
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
                        echo __("today");
                    } elseif ($finalDate > 2) {
                        echo $finalDate . " " . __("days");
                    } else {
                        echo $finalDate . " " . __("day");
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
        $language = $ci::LANGUAGE;

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
    $language = $ci::LANGUAGE;

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
                          style="width: 100%;background-color: #00ab00;color: #ffffff;"><?= __("negative") ?> (-)</span>
                </td>
            <?php } else { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #ff2e00;color: #d2d2d2;"><?= __("positive") ?> (+)</span>
                </td>
            <?php } ?>
        <?php } else { ?>
            <?php if ($siteResult['Result'] == '0') { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #008700;color: #ffffff;"><?= __("negative") ?> (-)</span>
                </td>
            <?php } else { ?>
                <td><span class="badge font-size-12"
                          style="width: 100%;background-color: #B82100;color: #d2d2d2;"><?= __("positive") ?> (+)</span>
                </td>
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