<div id="students-class-chart"></div>

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
                data: [<?= $students ?>, <?= $classes ?>, <?= $locationsCounter ?>]
            },
        ],
        colors: ['#007aba'],
        xaxis: {
            categories: ['<?= __("students") ?>', '<?= __("classes") ?>', '<?= __("locations") ?>'],
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
        document.querySelector("#students-class-chart"),
        options
    );
    chart.render();
</script>
