<?php $schools = $this->db->where("Added_By", $sessiondata['admin_id'])->get('l1_school')->result_array(); ?>
<div class="col-12">
    <div class="row">
        <?php foreach ($schools as $k => $school) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="byschool-labtest-<?= $school['Id'] ?>"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    <?php foreach ($schools as $school) { ?>
    <?php
    $labresults = $this->Ministry_Functions->LabResults(['perSchool' => $school['Id']]); ?>

    var options = {
        chart: {
            height: 380,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false,
            }
        },
        colors: ['#5b73e8', '#f1b44c', '#34c38f'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [3, 4, 3],
            curve: 'straight',
            dashArray: [0, 8, 5]
        },
        series: [{
            name: " All ",
            data: [<?= implode(',', array_column($labresults['all'], "result")) ?>]
        }, {
            name: " Negative ",
            data: [<?= implode(',', array_column($labresults['Negative'], "result")) ?>]
        }, {
            name: " Positive ",
            data: [<?= implode(',', array_column($labresults['Positive'], "result")) ?>]
        }],
        title: {
            text: '<?= $school['School_Name_EN'] ?>',
            align: 'center'
        },
        markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: [<?= implode(',', array_column($labresults['all'], "name")) ?>]
        },
        tooltip: {
            y: [{
                title: {
                    formatter: function (val) {
                        return val
                    }
                }
            }, {
                title: {
                    formatter: function (val) {
                        return val
                    }
                }
            }, {
                title: {
                    formatter: function (val) {
                        return val;
                    }
                }
            }]
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#byschool-labtest-<?= $school['Id'] ?>"),
        options
    );

    chart.render();
    <?php } ?>
</script>