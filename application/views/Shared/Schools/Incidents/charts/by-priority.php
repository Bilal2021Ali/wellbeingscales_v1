<?php
/**
 * @var Collection<IncidentPriorityDTO> $prioritiesList
 * @var Collection $priorities
 */

use DTOs\Incidents\IncidentPriorityDTO;
use Illuminate\Support\Collection;

?>
<div id="priority-chart"></div>

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
                data: [<?= $prioritiesList->map(fn(IncidentPriorityDTO $priority) => $priorities[$priority->value] ?? 0)->implode(',')?>]
            },
        ],
        colors: ['#f38f00'],
        xaxis: {
            categories: [<?= $prioritiesList->map(fn(IncidentPriorityDTO $priority) => '"' . $priority->text() . '"')->implode(',') ?>],
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
        document.querySelector("#priority-chart"),
        options
    );

    chart.render();
</script>
