<?php $tests = $this->db->get('r_testcode')->result_array(); ?>
<?php
function GenerateCounterBySchool($results) {
    $counters = [];
    foreach ($results as $result) {
        if (isset($counters[$result['School']])) {
            $counters[$result['School']]['result'] += $result['result'];
        } else {
            $counters[$result['School']]['result'] = $result['result'];
        }
        $counters[$result['School']]['name'] = '"' . $result['SchoolName'] . '"';

        return $counters;
    }

}
?>
<div class="col-12">
    <div class="row">
        <?php foreach ($tests as $test) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="bytest-labtest-<?= $test['Id'] ?>"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    <?php foreach ($tests as $test) {  
    $labresults = $this->Ministry_Functions->LabResults(['test' => $test['Test_Desc']]);
    $counters['all'] = GenerateCounterBySchool($labresults['all']) ?? [];
    $counters['negative'] = GenerateCounterBySchool($labresults['Negative']) ?? [];
    $counters['positive'] = GenerateCounterBySchool($labresults['Positive']) ?? [];?>


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
            data: [<?= implode(',', array_column($counters['all'], "result")) ?>]
        }, {
            name: " Negative ",
            data: [<?= implode(',', array_column($counters['negative'], "result")) ?>]
        }, {
            name: " Positive ",
            data: [<?= implode(',', array_column($counters['positive'], "result")) ?>]
        }],
        title: {
            text: '<?= $test['Test_Desc'] ?>',
            align: 'center'
        },
        markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: [<?= implode(',', array_column($counters['all'], "name")) ?>]
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
        document.querySelector("#bytest-labtest-<?= $test['Id'] ?>"),
        options
    );

    chart.render();
    <?php } ?>
</script>