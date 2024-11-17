<?php $schools = $this->db->where("Added_By", $sessiondata['admin_id'])->get('l1_school')->result_array(); ?>
<?php foreach ($schools as $school) { ?>
    <?php
    $quarantine = $this->Ministry_Functions->UsersInAction("Quarantine", ['school' => $school['Id']]);
    $home = $this->Ministry_Functions->UsersInAction("Home");

    $QuarantineSum = sizeof($quarantine['staff'] ?? []) + sizeof($quarantine['teachers'] ?? []) + sizeof($quarantine['students'] ?? []);
    $HomeSum = sizeof($home['staff'] ?? []) + sizeof($home['teachers'] ?? []) + sizeof($home['students'] ?? []);
    ?>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= $school['School_Name_AR'] ?></h3>
                        <div id="ResultsbyAction-school-<?= $school['Id'] ?>-bars"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= $school['School_Name_AR'] ?></h3>
                        <div id="ResultsbyAction-school-<?= $school['Id'] ?>-pie"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var options = {
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
                    name: "Results",
                    data: [<?= $QuarantineSum ?>, <?= $HomeSum ?>]
                }
            ],
            colors: ['#34c38f'],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {
                categories: ['الموظفين' , 'المدرسون', 'الطلاب'],
            }
        }

        var chart = new ApexCharts(document.querySelector("#ResultsbyAction-school-<?= $school['Id'] ?>-bars"), options);
        chart.render();

        var options = {
            chart: {
                height: 350,
                type: 'pie',
            },
            data: [<?= $QuarantineSum ?>, <?= $HomeSum ?>],
            labels: ["الحجر الصحي", "الحجر المنزلي"],
            colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#f46a6a"],
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
            document.querySelector("#ResultsbyAction-school-<?= $school['Id'] ?>-pie"),
            options
        );

        chart.render();
    </script>
<?php } ?>