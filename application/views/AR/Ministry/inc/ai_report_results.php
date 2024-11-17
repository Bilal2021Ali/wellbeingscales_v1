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
                                        ?>
                                        <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$i] . "' AND l2_student.Added_By = '" . $school['Id'] . "'  ")->num_rows(); ?>
                                        <?php $secondChart['students'][$test] = ["Positive" => ($secondChart['students'][$test]["Positive"] ?? 0) + $Positive, "Negative" => ($secondChart['students'][$test]["Negative"] ?? 0) + $Negative, "both" => ($secondChart['students'][$test]["both"] ?? 0) + ($Positive + $Negative)]; ?>
                                        <?php $positives += $Positive;
                                        $nigatives += $Negative; ?>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                            <span class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                            <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $studentsresults[] = ['value' => calc_perc($positives, ($positives + $nigatives)), "name" => $student['class']];
                                ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <h3 class="card-title text-center w-100">Staff: </h3>
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
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $school['Id'] . "' ")->num_rows(); ?>
                                        <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $school['Id'] . "' ")->num_rows(); ?>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                            <span class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                            <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                        </td>
                                    <?php } ?>
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
                            <?php $t_positives = 0;
                            $t_nigatives = 0;  ?>
                            <tbody>
                                <tr>
                                    <td>Results</td>
                                    <?php foreach ($tests as $t => $test) { ?>
                                        <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$t] . "' AND l2_teacher.Added_By = '" . $school['Id'] . "' ")->num_rows(); ?>
                                        <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($start)) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($end)) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$t] . "' AND l2_teacher.Added_By = '" . $school['Id'] . "' ")->num_rows(); ?>
                                        <?php $secondChart['teachers'][$test] = ["Positive" =>  $Positive, "Negative" => $Negative, "both" => $Positive + $Negative]; ?>
                                        <?php $t_positives += $Positive;
                                        $t_nigatives += $Negative; ?>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                            <span class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                            <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                        </td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
?>