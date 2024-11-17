<?php
$labresults =  $this->Ministry_Functions->LabResults();
$today = date("Y-m-d");
?>
<div class="col-xl-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="position: relative;min-height: 490px;">
                <div class="card-body">
                    <h4 class="card-title mb-4">Lab Test Results Counter: <?= $today; ?></h4>
                    <div id="chart"></div>
                    <div class="col-lg-12 text-center">
                        <p>(Students - Staff - Teachers)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            name: "    All   ",
            data: [<?= implode(',', array_column($labresults['all'], "result")) ?>]
        }, {
            name: "   Negative      ",
            data: [<?= implode(',', array_column($labresults['Negative'], "result")) ?>]
        }, {
            name: "    Positive   ",
            data: [<?= implode(',', array_column($labresults['Positive'], "result")) ?>]
        }],
        colors: ["#5b73e8", "#34c38f", "#C3343C"],
        xaxis: {
            categories: [<?= implode(',', array_column($labresults['all'], "Test")) ?>]
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
    chart = new ApexCharts(document.querySelector("#chart"), Chart_Options);
    chart.render();

</script>