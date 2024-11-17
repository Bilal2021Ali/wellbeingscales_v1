<div id="classes_reports"></div>
<button id="pdf-download-btn"><?= __("download-as-pdf") ?></button>

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
            <?php foreach ($classes as $class) { ?>
            {
                name: '<?= $class["Class"] ?>',
                data: [<?= implode(",", $speakOut->getResultsBasedOnClass($class['Id'], $classes, $filters)) ?>]
            },
            <?php } ?>],
        colors: <?= json_encode($colors) ?>,
        xaxis: {
            categories: [<?= implode(",", $classesNames) ?>],
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
        document.querySelector("#classes_reports"),
        options
    );

    // PDF download event listener
    document.querySelector("#pdf-download-btn").addEventListener("click", function () {
        chart.downloadPDF();
    });

    chart.render();
</script>
