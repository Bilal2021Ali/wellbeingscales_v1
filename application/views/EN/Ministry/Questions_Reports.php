<div class="main-content">
    <div class="page-content">
        <?php foreach ($types as $type) { ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"> <?= ucfirst($type['name']) ?> : </h3>
                        <div id="<?= $type['name'] ?>_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<script>
    //  line chart datalabel
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
    <?php foreach($types as $type){ ?>
    var options = {
        chart: {
            height: 380,
            type: 'bar',
            zoom: {
                enabled: true
            },
            toolbar: {
                show: true,
            }
        },
        colors: colors,
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff', '#fff']
            },
        },
        series: [
            <?php foreach ($quastions_all_data as $quastion) {
                $counts = array(); ?>
                <?php foreach ($get_choices as $used_choice) { ?>
                <?php   $use_count = $this->db->query(" SELECT `sv_st1_answers_values`.`Id` FROM `sv_st1_answers_values` 
                        JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                        AND `sv_st1_answers`.`user_type` = '".$type['code']."'
                        WHERE `question_id` = '" . $quastion['q_id'] . "'
                        AND `choice_id` = '" . $used_choice['Id'] . "' ")->num_rows(); 
                    $counts[] = $use_count;
                } ?> {
                    name: "<?= $quastion["en_title"]; ?>",
                    data: [<?= implode(',', $counts) ?>]
                },
            <?php } ?>
        ],
        title: {
            text: 'Page Statistics',
            align: 'left'
        },
        markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: [<?= implode(',', $used_choices) ?>],
        },
        tooltip: {
            y: [{
                title: {
                    formatter: function(val) {
                        return val + " (mins)"
                    }
                }
            }, {
                title: {
                    formatter: function(val) {
                        return val;
                    }
                }
            }]
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    }

    var chart = new ApexCharts(document.querySelector("#<?= $type['name'] ?>_chart"), options);
    chart.render();
    <?php } ?>
</script>