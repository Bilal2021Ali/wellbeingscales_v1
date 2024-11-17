<?php

use Enums\Incidents\IncidentStatus;

?>
<div id="months-chart"></div>

<script>
    var options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [
            {
                name: '<?= __("total") ?>',
                data: [<?= implode(",",
                    collect(months_names($activeLanguage))->map(fn($month, $key) => $months[$key + 1] ?? 0)->toArray()
                ) ?>]
            },
        ],
        colors: ['#f38f00'],
        xaxis: {
            categories: [<?= implode(",", collect(months_three_letters_names($activeLanguage))->map(fn($month) => '"' . $month . '"')->toArray()) ?>],
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1

        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " "
                }
            }
        }
    };

    var chart = new ApexCharts(
        document.querySelector("#months-chart"),
        options
    );

    chart.render();
</script>
