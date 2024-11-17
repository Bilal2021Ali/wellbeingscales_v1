<?php $schools = $this->db->where("Added_By", $sessiondata['admin_id'])->get('l1_school')->result_array(); ?>
<?php $colors = ["#5b9bd5" , "#ed7d31" , "#78b151" , "#ff0000"]; ?>
<div class="col-12">
    <div class="row">
        <?php foreach (['low', 'normal', 'moderate', 'high'] as $k => $type) { ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= ucfirst($type) ?> Temperature</h3>
                        <div id="schoolstemptests-<?= $type ?>-bar"></div>
                        <script>
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
                                colors: ['<?= $colors[$k] ?>', 'transparent'], // takes an array which will be repeated on columns
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    width: [3, 4, 3],
                                    curve: 'straight',
                                    dashArray: [0, 8, 5]
                                },
                                series: [
                                    <?php foreach ($schools as $school) { ?>
                                    {
                                        name: "<?= $school['School_Name_EN'] ?>",
                                        data: [<?= $this->Ministry_Functions->tempresults(['perSchool' => $school['Id'], "only" => $type])[strtoupper($type)] ?? 0 ?>]
                                    },
                                    <?php } ?>
                                ],
                                title: {
                                    text: '<?= ucfirst($type); ?>',
                                    align: 'center'
                                },
                                markers: {
                                    size: 0,
                                    hover: {
                                        sizeOffset: 6
                                    }
                                },
                                xaxis: {
                                    categories: [<?= implode(',', array_map(function ($n) { return '"' . $n . '"'; } , array_column($schools , "School_Name_EN"))) ?>]
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
                            }

                            var chart = new ApexCharts(
                                document.querySelector("#schoolstemptests-<?= $type ?>-bar"),
                                options
                            );
                            chart.render();
                        </script>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>