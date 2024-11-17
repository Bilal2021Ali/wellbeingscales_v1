<div id="results_by_opening_status" class="apex-charts" dir="ltr"></div>
<script>
    var results_by_opening_status_options = {
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
        series: [
            {
                name: "<?= __("open") ?>",
                data: [<?= $results['open'] ?>]
            },
            {
                name: "<?= __("closed") ?>",
                data: [<?= $results['closed'] ?>]
            }
        ],
        colors: ['#8cff00', '#ff2600'],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: ['<?= __("open") ?>', '<?= __("closed") ?>'],
        }
    }

    var chart_by_gender = new ApexCharts(
        document.querySelector("#results_by_opening_status"),
        results_by_opening_status_options
    );

    chart_by_gender.render();
</script>