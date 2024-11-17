<?php
/**
 * @var Collection<DoctorReportDTO> $results
 * @var bool $isMinistry
 */

use DTOs\DoctorReportDTO;
use Illuminate\Support\Collection;

$tableRunTimeId = uniqid("table-");
?>
<div class="overflow-auto">
    <table class="table actions-table table-bordered w-100" id="<?= $tableRunTimeId ?>">
        <thead>
        <th>#</th>
        <?php if ($isMinistry) { ?>
            <th><?= __("school name") ?></th>
        <?php } ?>
        <th><?= __("student name") ?></th>
        <th><?= __("profile title") ?></th>
        <th><?= __("test title") ?></th>
        <th><?= __("result") ?></th>
        <th><?= __("order date") ?></th>
        <th><?= __("order time") ?></th>
        <th><?= __("national id") ?></th>
        <th><?= __("gender") ?></th>
        <th><?= __("birthday / age") ?></th>
        <th><?= __("class") ?></th>
        <th><?= __("grade") ?></th>
        </thead>
        <tbody>
        <?php foreach ($results as $key => $result) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <?php if ($isMinistry) { ?>
                    <td><?= $result->school_name ?></td>
                <?php } ?>
                <td><?= $result->student_name ?></td>
                <td><?= $result->profile_title ?></td>
                <td><?= $result->test_title ?></td>
                <td>
                    <div class="badge" style="<?= $result->getFlag()->getLabel() ?>">
                        <?= $result->result ?>
                    </div>
                </td>
                <td><?= $result->getOrderDate() ?></td>
                <td><?= $result->getOrderTime() ?></td>
                <td><?= $result->national_id ?></td>
                <td><?= $result->gender ?></td>
                <td><?= $result->getBirthday() ?> / <?= $result->getAge() ?></td>
                <td><?= $result->class_name ?></td>
                <td><?= $result->grade_name ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var table_st = $('#<?= $tableRunTimeId ?>').DataTable({
        lengthChange: false,
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<?= __('export pdf') ?>',
                orientation: 'landscape',
                pageSize: 'A3',
                customize: function (doc) {
                    const colCount = [];
                    $('#<?= $tableRunTimeId ?>').find('tbody tr:first-child td').each(function (index) {
                        if ($(this).attr('colspan')) {
                            for (let i = 1; i <= $(this).attr('colspan'); i++) {
                                colCount.push('*');
                            }
                        } else {
                            colCount.push(index === 0 ? '5%' : '*');
                        }
                    });
                    doc.content[1].table.widths = colCount;
                    doc.styles.tableBodyOdd.alignment = 'center';
                    doc.styles.tableBodyEven.alignment = 'center';
                }
            },
            {
                extend: 'excelHtml5',
                text: "<?= __('export excel') ?>"
            }
        ]
    });
    table_st.buttons().container().appendTo('#<?= $tableRunTimeId ?>_wrapper .col-md-6:eq(0)');
</script>