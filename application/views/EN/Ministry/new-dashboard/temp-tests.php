<?php
$tempresults = $this->Ministry_Functions->tempresults();
?>
<div class="col-12">
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Daily Temperature</h3>
                    <div id="temptests-bars"></div>
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
                                enabled: false
                            },
                            series: [{
                                data: [<?= $tempresults['LOW'] ?>, <?= $tempresults['NORMAL'] ?>, <?= $tempresults['MODERATE'] ?>, <?= $tempresults['HIGH'] ?>]
                            }],
                            colors: ['#34c38f'],
                            grid: {
                                borderColor: '#f1f1f1',
                            },
                            xaxis: {
                                categories: ['Low Temperature', 'Normal Temperature', 'Moderate Temperature', 'High Temperature'],
                            }
                        }

                        var chart = new ApexCharts(
                            document.querySelector("#temptests-bars"),
                            options
                        );

                        chart.render();
                    </script>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Daily Temperature</h3>
                    <div id="temptests-pie"></div>
                    <script>
                        var options = {
                            chart: {
                                height: 350,
                                type: 'pie',
                            },
                            data: [<?= $tempresults['LOW'] ?>, <?= $tempresults['NORMAL'] ?>, <?= $tempresults['MODERATE'] ?>, <?= $tempresults['HIGH'] ?>],
                            labels: ['Low Temperature', 'Normal Temperature', 'Moderate Temperature', 'High Temperature'],
                            colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#f46a6a"],
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
                            document.querySelector("#temptests-pie"),
                            options
                        );

                        chart.render();
                    </script>
                </div>
            </div>
        </div>
        <?php foreach (['low', 'normal', 'moderate', 'high'] as $type) { ?>
            <div class="col-lg-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= ucfirst($type) ?> Temperature</h3>
                        <div id="temptests-<?= $type ?>-bar"></div>
                        <script>
                            var Chart_Options = {
                                chart: {
                                    height: 350,
                                    type: "bar",
                                    toolbar: {
                                        show: !1
                                    }
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: !1,
                                        columnWidth: "45%",
                                        endingShape: "rounded"
                                    }
                                },
                                dataLabels: {
                                    enabled: !0,
                                    formatter: function (e) {
                                        return e
                                    },
                                    offsetY: -20,
                                    style: {
                                        fontSize: "12px",
                                        colors: ["#FFFFFF"]
                                    }
                                },
                                stroke: {
                                    show: !0,
                                    width: 2,
                                    colors: ["transparent"]
                                },
                                series: [{
                                    name: "Teachers",
                                    data: [<?= $this->Ministry_Functions->tempresults(['UserType' => "Teacher", "only" => $type])[strtoupper($type)] ?? 0 ?>]
                                }, {
                                    name: "Staff",
                                    data: [<?= $this->Ministry_Functions->tempresults(['UserType' => "Teacher", "only" => $type])[strtoupper($type)] ?? 0 ?>]
                                }, {
                                    name: "Students",
                                    data: [<?= $this->Ministry_Functions->tempresults(['UserType' => "Teacher", "only" => $type])[strtoupper($type)] ?? 0 ?>]
                                }],
                                colors: ["#5b73e8", "#34c38f", "#C3343C"],
                                xaxis: {
                                    categories: ["Teachers", "Staff", "Students"]
                                },
                                yaxis: {
                                    title: {
                                        text: "all tests"
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
                                            if (e >= 1000) {
                                                var th = e.slice(0, 1);
                                                return th + "thousnd"
                                            } else {
                                                return e
                                            }
                                        }
                                    }
                                }
                            };
                            chart = new ApexCharts(document.querySelector("#temptests-<?= $type ?>-bar"), Chart_Options);
                            chart.render();
                        </script>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>