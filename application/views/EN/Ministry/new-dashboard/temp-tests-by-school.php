<?php $schools = $this->db->where("Added_By", $sessiondata['admin_id'])->get('l1_school')->result_array(); ?>
<div class="col-12">
    <div class="row">
        <?php foreach ($schools as $k => $school) { ?>
            <?php $SchoolResults = $this->Ministry_Functions->tempresults(['perSchool' => $school['Id']]); ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="schoolstemptests-<?= $school['Id'] ?>-lines"></div>
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
                                colors: ["#5b9bd5" , "#ed7d31" , "#78b151" , "#ff0000"],
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    width: [3, 4, 3],
                                    curve: 'straight',
                                    dashArray: [0, 8, 5]
                                },
                                series: [
                                    <?php foreach (['low', 'normal', 'moderate', 'high'] as $k => $type) { ?>
                                    {
                                        name: "<?= ucfirst($type) ?>",
                                        data: [<?= $SchoolResults[strtoupper($type)] ?? 0 ?>]
                                    },
                                    <?php } ?>
                                ],
                                title: {
                                    text: '<?= ucfirst($school['School_Name_EN']); ?>',
                                    align: 'center'
                                },
                                markers: {
                                    size: 0,
                                    hover: {
                                        sizeOffset: 6
                                    }
                                },
                                xaxis: {
                                    categories: ['Low Temperature', 'Normal Temperature', 'Moderate Temperature', 'High Temperature']
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
                                document.querySelector("#schoolstemptests-<?= $school['Id'] ?>-lines"),
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