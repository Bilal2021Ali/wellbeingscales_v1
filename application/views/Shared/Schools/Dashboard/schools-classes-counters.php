<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>

<div class="main-content">
    <div class="page-content">
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"> <?= __("classes_absent_daily_counters") ?> </h4>
        <div class="row">
            <?php foreach ($ClassesResults as $key => $result) { ?>
                <div class="col-lg-4">
                    <div class="card" style="height: 380px;">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?= $result['className'] ?></h3>
                            <div id="ClassesResults-<?= $key ?>"></div>
                        </div>
                    </div>
                </div>
                <script>
                    var options = {
                        chart: {
                            height: 350,
                            type: 'pie',
                        },
                        series: [<?= $result['students'] ?>, <?= $result['appsent'] ?>],
                        labels: ["<?= __("total_students") ?>", "<?=  __("total_absent_today") ?>"],
                        colors: ["#5b9bd5", "#ffc000"],
                        legend: {
                            show: true,
                            position: 'bottom',
                            horizontalAlign: 'center',
                            verticalAlign: 'middle',
                            floating: false,
                            fontSize: '14px',
                            offsetX: 0
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: {
                                    height: 240
                                },
                                legend: {
                                    show: false
                                },
                            }
                        }]

                    }

                    var chart = new ApexCharts(
                        document.querySelector("#ClassesResults-<?= $key ?>"),
                        options
                    );

                    chart.render();
                </script>
            <?php } ?>
        </div>
    </div>
</div>