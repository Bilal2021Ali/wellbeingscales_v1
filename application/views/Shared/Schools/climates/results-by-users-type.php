<div class="table-responsive mb-0" data-pattern="priority-columns">
    <table id="<?= $type ?>-list" class="table dt-responsive nowrap">
        <thead>
        <th>ID</th>
        <th>name</th>
        <th>avatar</th>
        <th><?= $label ?></th>
        <th>Result</th>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $user) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td>
                    <img alt="" src="<?= $user['avatar'] ?? base_url("uploads/avatars/default_avatar.jpg") ?>"
                         class="rounded-circle header-profile-user">
                </td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['extraData'] ?></td>
                <td style="width :140px">
                    <div class="progress w-100">
                        <div class="progress-bar progress-bar-striped bg-<?= $user['barColor'] ?>" role="progressbar"
                             style="width: <?= $user['result'] ?>%" aria-valuenow="<?= $user['result'] ?>"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $("#<?= $type ?>-list").DataTable();
</script>