<div id="dashboard-chart<?= $isLine ? "-line" : "" ?>"></div>
<button id="pdf-download-btn"><?= __("download-as-pdf") ?></button>

<script>
    var categories = <?= json_encode($categories) ?>;
    var options = {
        chart: {
            height: 350,
            type: <?= $isLine ? "'line'" : "'bar'" ?>,
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
        <?php if ($isLine){ ?>
        stroke: {
            width: [3, 3],
            curve: 'smooth'
        },
        <?php } else { ?>
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        <?php } ?>
        series: [
            <?php foreach ($categories as $category) { ?>
            {
                name: '<?= $category["name"] ?>',
                data: [<?= implode(",", $speakOut->getResultsBasedOnCategory($category['id'], $filters)) ?>]
            },
            <?php } ?>],
        colors: <?= json_encode($colors) ?>,
        xaxis: {
            categories: [<?= implode(",", $months) ?>],
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
        document.querySelector("#dashboard-chart<?= $isLine ? "-line" : "" ?>"),
        options
    );

    // PDF download event listener
    document.querySelector("#pdf-download-btn").addEventListener("click", function () {
        chart.downloadPDF();
    });

    chart.render();
</script>
