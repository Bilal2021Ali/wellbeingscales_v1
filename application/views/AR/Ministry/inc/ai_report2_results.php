<style>
    .warning-darken {
        color: #ff9900;
    }
</style>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <?php foreach ($schools as $key => $school) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= $key == 0 ? "active" : "" ?>" data-toggle="tab" href="#school_<?= $key ?>" role="tab">
                        <span class="d-block d-sm-none"><?= $key + 1 ?></span>
                        <span class="d-none d-sm-block"><?= $school['School_Name_EN'] ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <div class="tab-content p-3 text-muted">
            <?php foreach ($schools as $key => $school) { ?>
                <?php $results = array("students" => [], "staff" => [], "teachers" => []);  ?>
                <?php $counter = array("students" => [], "staff" => [], "teachers" => []);  ?>
                <div class="tab-pane <?= $key == 0 ? "active" : "" ?>" id="school_<?= $key ?>" role="tabpanel">
                    <h3 class="card-title text-center w-100">Students : </h3>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Class name</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->select("`r_levels`.`Class` AS class , `r_levels`.`Id` AS Class_key ");
                            $this->db->from('l2_labtests');
                            $this->db->join('l2_student', 'l2_student.Id = l2_labtests.UserId');
                            $this->db->join('r_levels', 'r_levels.Id = l2_student.Class');
                            $this->db->where('l2_labtests.UserType', 'Student');
                            $this->db->where('l2_labtests.Created >=', date('Y-m-d', strtotime($start)));
                            $this->db->where('l2_labtests.Created <=', date('Y-m-d', strtotime($end)));
                            $this->db->where('l2_student.Added_By', $school['Id']);
                            $this->db->where_in('l2_labtests.Test_Description', $inputtests);
                            $this->db->where_in('l2_student.Class', $classes);
                            $this->db->group_by('l2_student.Class');
                            $students = $this->db->get()->result_array();
                            foreach ($students as $i => $student) {
                                $positives = 0;
                                $nigatives = 0; ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $student['class'] ?></td>
                                    <?php foreach ($tests as $i => $test) { ?>
                                        <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$i] . "' AND l2_student.Added_By = '" . $school['Id'] . "' ")->num_rows();
                                        $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$i] . "' AND l2_student.Added_By = '" . $school['Id'] . "'  ")->num_rows(); ?>
                                        <td class="text-center <?= className(calc_perc($Positive, ($Positive + $Negative))) ?>">
                                            <?= calc_perc($Positive, ($Positive + $Negative)); ?>%
                                        </td>
                                        <?php $counter["students"][$test] = array("positive"  => ($results["students"][$test]["positive"] ?? 0 + $Positive), "negative" => ($results["students"][$test]["negative"] ?? 0 + $Negative)) ?>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <?php foreach ($counter["students"] as $resultCount) {
                                $results["students"][] = calc_perc($resultCount['positive'], ($resultCount['positive'] + $resultCount['negative']));
                            } ?>
                        </tbody>
                    </table>
                    <h3 class="card-title text-center w-100">staff : </h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <?php foreach ($inputtests as $test) { ?>
                                    <th><?= $test ?></th>
                                <?php } ?>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Results</td>
                                    <?php foreach ($tests as $key => $test) { ?>
                                        <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $school['Id'] . "' ")->num_rows();
                                        $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $school['Id'] . "' ")->num_rows(); ?>
                                        <td class="text-center <?= className(calc_perc($Positive, ($Positive + $Negative))) ?>">
                                            <?= calc_perc($Positive, ($Positive + $Negative)); ?>%
                                        </td>
                                        <?php $counter["staff"][$test] = array("positive"  => ($results["staff"][$test]["positive"] ?? 0 + $Positive), "negative" => ($results["staff"][$test]["negative"] ?? 0 + $Negative)) ?>
                                    <?php } ?>
                                    <?php foreach ($counter["staff"] as $resultCount) {
                                        $results["staff"][] = calc_perc($resultCount['positive'], ($resultCount['positive'] + $resultCount['negative']));
                                    } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="card-title text-center w-100">Teachers : </h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <?php foreach ($inputtests as $test) { ?>
                                    <th><?= $test ?></th>
                                <?php } ?>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Results</td>
                                    <?php foreach ($tests as $t => $test) { ?>
                                        <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$t] . "' AND l2_teacher.Added_By = '" . $school['Id'] . "' ")->num_rows();
                                        $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$t] . "' AND l2_teacher.Added_By = '" . $school['Id'] . "' ")->num_rows(); ?>
                                        <td class="text-center <?= className(calc_perc($Positive, ($Positive + $Negative))) ?>">
                                            <?= calc_perc($Positive, ($Positive + $Negative)); ?>%
                                        </td>
                                        <?php $counter["teachers"][$test] = array("positive"  => ($results["teachers"][$test]["positive"] ?? 0 + $Positive), "negative" => ($results["teachers"][$test]["negative"] ?? 0 + $Negative)) ?>
                                    <?php } ?>
                                    <?php foreach ($counter["teachers"] as $resultCount) {
                                        $results["teachers"][] = calc_perc($resultCount['positive'], ($resultCount['positive'] + $resultCount['negative']));
                                    } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="chartsSchool_<?= $school['Id'] ?>" class="apex-charts" dir="ltr"></div>
                    <script>
                        var options = {
                            chart: {
                                height: 480,
                                type: 'line',
                                zoom: {
                                    enabled: false
                                },
                                toolbar: {
                                    show: false
                                }
                            },
                            colors: ['#5b73e8', '#f1b44c'],
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                width: [3, 3],
                                curve: 'straight'
                            },
                            series: [{
                                name: "students",
                                data: [<?= implode(',', $results['students']) ?>]
                            }, {
                                name: "teachers",
                                data: [<?= implode(',', $results['teachers']) ?>]
                            }, {
                                name: "staff",
                                data: [<?= implode(',', $results['staff']) ?>]
                            }],
                            title: {
                                text: 'Average High & Low Temperature',
                                align: 'left'
                            },
                            grid: {
                                row: {
                                    colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                                    opacity: 0.2
                                },
                                borderColor: '#f1f1f1'
                            },
                            markers: {
                                style: 'inverted',
                                size: 6
                            },
                            xaxis: {
                                categories: [<?= implode(',', $tests_string) ?>],
                                title: {
                                    text: 'Month'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Temperature'
                                },
                                min: 5,
                                max: 100
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'right',
                                floating: true,
                                offsetY: -25,
                                offsetX: -5
                            },
                            responsive: [{
                                breakpoint: 600,
                                options: {
                                    chart: {
                                        toolbar: {
                                            show: false
                                        }
                                    },
                                    legend: {
                                        show: false
                                    },
                                }
                            }]
                        }

                        var chart = new ApexCharts(
                            document.querySelector("#chartsSchool_<?= $school['Id'] ?>"),
                            options
                        );

                        chart.render();
                    </script>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });
</script>
<?php
function calc_perc($perc, $all)
{
    $x = $perc;
    $y = $all;
    if ($x > 0 && $y > 0) {
        $percent = $x / $y;
        $percent_friendly = number_format($percent * 100);
    } else {
        $percent_friendly = 0;
    }
    return $percent_friendly;
}

function className($perc)
{
    if ($perc < 25) {
        $class  = "success";
    } elseif ($perc > 25 && $perc < 50) {
        $class  = "warning";
    } elseif ($perc > 50 && $perc < 75) {
        $class  = "warning-darken";
    } else {
        $class  = "danger";
    }

    return "text-" . $class;
}

?>