<div id="results_by_identity" class="apex-charts" dir="ltr"></div>
<script>
    var results_by_identity_options = {
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
            data: [<?= $results['hidden'] ?>, <?=  $results['known'] ?>]
        }],
        colors: ["#ed7d31"],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: ['<?= __("anonymous") ?>', '<?= __("show-user-name") ?>'],
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

    var chart_by_gender = new ApexCharts(
        document.querySelector("#results_by_identity"),
        results_by_identity_options
    );

    chart_by_gender.render();
</script>