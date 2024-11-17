<?php
/**
 * @var array $schools
 * @var string $language
 */
?>
<style>
    .action {
        font-size: 1.5rem;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= __("school_name") ?></th>
                        <th><?= __("refrigerators") ?></th>
                        <th><?= __("actions") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($schools as $key => $school) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $school['name'] ?></td>
                            <td><?= $school['refrigerator_count'] ?></td>
                            <td class="text-center">
                                <a class="text-success action"
                                   href="<?= base_url($language . "/DashboardSystem/school-refrigerator-results/" . $school['id']) ?>">
                                    <i class="uil uil-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.table').DataTable();
    });
</script>
