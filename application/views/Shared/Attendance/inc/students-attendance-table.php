<?php
/**
 * @var array<AttendanceByStudentDTO> $results
 * @var bool $isMinistry
 */

use App\DTOs\Attendance\AttendanceByStudentDTO;

?>
<table class="table overflow-auto" id="students-table">
    <thead>
    <tr>
        <th>#</th>
        <?php if ($isMinistry) { ?>
            <th><?= __('school name') ?></th>
        <?php } ?>
        <th><?= __('student name') ?></th>
        <th><?= __('class') ?></th>
        <th><?= __('grade') ?></th>
        <th><?= __('gender') ?></th>
        <th><?= __('bus name') ?></th>
        <th><?= __('time in am') ?></th>
        <th><?= __('time out am') ?></th>
        <th><?= __('trip time am') ?></th>
        <th><?= __('time in pm') ?></th>
        <th><?= __('time out pm') ?></th>
        <th><?= __('trip time pm') ?></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($results as $key => $result) { ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <?php if ($isMinistry) { ?>
                <td><?= $result->school_name ?></td>
            <?php } ?>
            <td><?= $result->student_name ?></td>
            <td><?= $result->class ?></td>
            <td><?= $result->grade ?></td>
            <td><?= $result->gender ?></td>
            <td><?= $result->bus_name ?></td>
            <td><?= $result->getTimeInAm() ?></td>
            <td><?= $result->getTimeOutAm() ?></td>
            <td><?= $result->getTripTimeAm() ?></td>
            <td><?= $result->getTimeInPm() ?></td>
            <td><?= $result->getTimeOutPm() ?></td>
            <td><?= $result->getTrimTimePm() ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<script>
    var table_st = $('#students-table').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });
    table_st.buttons().container().appendTo('#students-table_wrapper .col-md-6:eq(0)');
</script>
