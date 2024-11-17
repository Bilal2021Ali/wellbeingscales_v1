<div id="dashboard-choices-chart"></div>
<button id="pdf-download-btn"><?= __("download-as-pdf") ?></button>

<script>
    var choices = <?= json_encode($choices) ?>;

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
            data: [<?= implode(",", $results) ?>]
        }],
        colors: ["#4472c4"],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: choices.map(choice => choice.name),
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return parseInt(val);
                },
                title: {
                    formatter: function () {
                        return "<?= __("results") ?>: ";
                    },
                },
            }
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#dashboard-choices-chart"),
        options
    );

    // PDF download event listener
    document.querySelector("#pdf-download-btn").addEventListener("click", function () {
        chart.downloadPDF();
    });

    chart.render();
</script>
