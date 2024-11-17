<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js" xmlns=""></script>

<div class="main-content">
    <div class="page-content">
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
            الفحوصات الطبية
            <span class="float-right">
                <a href="<?= base_url("EN/schools/labtestall") ?>" target="_blank" class="text-white" rel="noopener noreferrer">
                    إعرض المزيد
                </a>
            </span>
        </h4>
        <div class="card">
            <div class="card-body">
                <div id="labtests-bar-charts"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var options = {
        chart: {
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
            enabled: true,
        },
        series: [{
            name: 'سلبي',
            data: [<?= implode(",", array_map(function ($test) use ($labtests) {
                return $labtests[$test->Test_Desc]['negative'];
            }, $tests)) ?>]
        },
            {
                name: 'إيجابي',
                data: [<?= implode(",", array_map(function ($test) use ($labtests) {
                    return $labtests[$test->Test_Desc]['positive'];
                }, $tests)) ?>]
            }
        ],
        colors: ['#32bf72', '#ff3b3b'],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(",", array_map(function ($test) {
                return '"' . $test->Test_Desc . '"';
            }, $tests)) ?>]
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#labtests-bar-charts"),
        options
    );
    chart.render();
</script>