<style>
    .progress {
        height: 20px;
        margin: 6px 0;
        overflow: auto;
    }

    .bar-bg {
        background: linear-gradient(90deg, #7358a3 0%, #7dbce3 100%);
        border-bottom: 1px solid #5e5e5e;
        padding: 10px;
        color: #fff;
        overflow: auto;

    }
</style>
<div class="main-content" style="overflow: auto;">
    <div class="page-content" style="overflow: auto;">
        <div class="card" style="overflow: auto;">
            <div class="card-body" style="overflow: auto;">
                <div class="row mb-2 bar-bg" style="overflow: auto;">
                    <div class="col-8 text-center">
                        <b><?= $this->lang->line('current-in-place') ?></b>
                    </div>
                    <div class="col-4 text-center">
                        <b><?= $this->lang->line('priority') ?></b>
                    </div>
                </div>
                <div class="row mb-2" style="border-bottom: 1px solid #5e5e5e;padding-bottom: 10px"
                     style="overflow: auto;">
                    <div class="col-4" style="overflow: auto;">

                    </div>
                    <div class="col-4 text-center d-flex justify-content-between" style="overflow: auto;">
                        <?php foreach ($choices as $choice) { ?>
                            <span><?= $choice[$activeLanguage . '_title'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-4 text-center d-flex justify-content-between" style="overflow: auto;">
                        <?php foreach ($priorities as $priority) { ?>
                            <span><?= $priority[$activeLanguage . '_title'] ?></span>
                        <?php } ?>
                    </div>
                </div>
                <?php foreach ($statistics as $statistic) { ?>
                    <div class="row mb-2" style="overflow: auto;">
                        <div class="col-4" style="overflow: auto;">
                            <p class="mb-1"><?= $statistic[($activeLanguage ?? 'en') . '_title'] ?></p>
                        </div>
                        <div class="col-4" style="overflow: auto;">
                            <div class="progress" style="overflow: auto;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?= $statistic['answers'] ?>%;"
                                     aria-valuenow="<?= $statistic['answers'] ?>"
                                     aria-valuemin="0" aria-valuemax="100"><?= $statistic['answers'] ?>%
                                </div>
                            </div>
                        </div>
                        <div class="col-4" style="overflow: auto;">
                            <div class="progress" style="overflow: auto;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: <?= $statistic['priority'] ?>%;"
                                     aria-valuenow="<?= $statistic['priority'] ?>"
                                     aria-valuemin="0" aria-valuemax="100"><?= $statistic['priority'] ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <hr>
                <canvas class="mt-5" id="radar-chart"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/chart.js/Chart.bundle.min.js') ?>"></script>
<script>
    const generatingTheResults = '<?= $this->lang->line('generating-the-results') ?>';
    <?php $urlArr = explode('/', current_url()); array_pop($urlArr) ?>
    $(".ar_change").attr('href', '<?= implode('/', $urlArr) . '/' . ($activeLanguage == 'en' ? 'ar' : 'en'); ?>');
    const activeLanguage = "<?= $activeLanguage ?? 'en' ?>";
</script>
<script>
    new Chart(document.getElementById("radar-chart"), {
        type: 'radar',
        data: {
            labels: [<?= "'" . implode("','", array_column($statistics, ($activeLanguage ?? 'en') . '_title')) . "'" ?>],
            datasets: [
                {
                    label: "<?= $this->lang->line('current-in-place') ?>",
                    fill: true,
                    backgroundColor: "rgba(179,181,198,0.2)",
                    borderColor: "rgba(179,181,198,1)",
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "rgba(179,181,198,1)",
                    data: [<?= implode(',', array_column($statistics, 'answers')) ?>]
                }, {
                    label: "<?= $this->lang->line('priority') ?>",
                    fill: true,
                    backgroundColor: "rgba(255,99,132,0.2)",
                    borderColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    data: [<?= implode(',', array_column($statistics, 'priority')) ?>]
                }
            ]
        },
        options: {
            title: {
                display: false,
            },
            scale: {
                ticks: {
                    beginAtZero: true,
                    max: <?= max(array_merge(array_column($statistics, 'answers'), array_column($statistics, 'priority'))) ?>
                }
            }
        }
    });
</script>