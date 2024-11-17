<!-- apexcharts init -->
<h4 class="card-title mb-4"> <?= $type ?> Temperature: <?= $today; ?></h4>
<div class="mt-3">
    <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
</div>
<script>
    var options = {
            chart: {
                height: 300,
                type: "line",
                zoom: {
                    enabled: !1
                },
                toolbar: {
                    show: !1
                }
            },
            colors: ["#5b73e8"],
            dataLabels: {
                enabled: !1
            },
            stroke: {
                width: [3, 3],
                curve: "straight"
            },
            series: [{
                name: "Temperature",
                // here data
                data: [<?php foreach ($list as $finalresults) {
                    echo $finalresults['Result'] . ',';
                } ?>]
            }],
            grid: {
                row: {
                    colors: ["transparent", "transparent"],
                    opacity: .2
                },
                borderColor: "#f1f1f1"
            },
            markers: {
                style: "inverted",
                size: 6
            },
            xaxis: {
                categories: [<?php foreach ($list as $names) {
                    echo '"' . $names['Username'] . '",';
                } ?>],
                title: {
                    text: "<?= $type ?> Names"
                }
            },
            yaxis: {
                title: {
                    text: "Temperature"
                },
                min: 32,
                max: 43
            },
            legend: {
                position: "top",
                horizontalAlign: "right",
                floating: !0,
                offsetY: -25,
                offsetX: -5
            },
            labels: {
                show: !1,
                formatter: function (e) {
                    return e + "%"
                }
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        toolbar: {
                            show: !1
                        }
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        },
        chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options);
    chart.render();
</script>
