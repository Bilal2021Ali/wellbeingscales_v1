<?php

use Enums\Incidents\IncidentStatus;

?>
<div id="status-chart"></div>

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
                    collect(IncidentStatus::cases())->map(fn(IncidentStatus $status) => $statuses[$status->value] ?? 0)->toArray()
                ) ?>]
            },
        ],
        colors: ['#ffd500'],
        xaxis: {
            categories: [<?= implode(",", collect(IncidentStatus::cases())->map(fn(IncidentStatus $status) => '"' . $status->text() . '"')->toArray()) ?>],
        },
        yaxis: {
            title: {
                text: '<?= __("reports") ?>'
            }
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
        document.querySelector("#status-chart"),
        options
    );

    chart.render();
</script>
