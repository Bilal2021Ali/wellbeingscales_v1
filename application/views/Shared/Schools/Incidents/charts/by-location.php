<?php

use Enums\Incidents\IncidentStatus;

?>
<div id="location-chart"></div>

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
                data: [<?= implode(",", collect($locations)->map(fn($location) => $location['counter'])->toArray()) ?>]
            },
        ],
        colors: ['#015b89'],
        xaxis: {
            categories: [<?= implode(",", collect($locations)->map(fn($location) => '"' . $location['name'] . '"')->toArray()) ?>],
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
        document.querySelector("#location-chart"),
        options
    );

    chart.render();
</script>
