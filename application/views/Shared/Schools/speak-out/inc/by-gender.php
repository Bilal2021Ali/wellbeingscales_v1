<div id="results_by_gender" class="apex-charts" dir="ltr"></div>
<script>
    var results_by_gender_options = {
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
                name: "<?= __("males") ?>",
                data: [<?= $results['m'] ?>]
            },
            {
                name: "<?= __("females") ?>",
                data: [<?= $results['f'] ?>]
            },
        ],
        colors: ['#3a71a2', '#c800ff'],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: ['<?= __("males") ?>', '<?= __("females") ?>'],
        }
    }

    var chart_by_gender = new ApexCharts(
        document.querySelector("#results_by_gender"),
        results_by_gender_options
    );

    chart_by_gender.render();
</script>