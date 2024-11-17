<?php
$city_ids = array_column($departments, 'Citys');

// Query for all cities
$cities = empty($city_ids) ? [] : $this->db->query("SELECT `id`, `Name_EN` FROM `r_cities` WHERE `id` IN (" . implode(',', $city_ids) . ")")->result_array();
$city_names = array_column($cities, 'Name_EN', 'id');

?>
<table id="visi_table"
       class="table table-striped Table_Data table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th>#</th>
        <th>Img</th>
        <th>Arabic Title</th>
        <th>English Title</th>
        <th>Type</th>
        <th>User Name</th>
        <th>City</th>
        <th>Edit</th>
        <?php if (!isset($disableStatusControl)) { ?>
            <th class="actions">Status</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($departments as $sn => $department) { ?>
        <tr>
            <th scope="row"><?= $sn + 1; ?></th>
            <td>
                <?php if (!empty($department['Link'])) { ?>
                <img src="<?= base_url(); ?>uploads/avatars/<?= $department['Link'] ?>"
                     class="avatar-xs rounded-circle "
                     alt="<?= $department['Dept_Name_EN'] ?>">
            </td>
            <?php } else { ?>
                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                     class="avatar-xs rounded-circle "
                     alt="<?= $department['Dept_Name_EN'] ?>"></td>
            <?php } ?>
            </td>
            <td><?= $department['Dept_Name_AR']; ?></td>
            <td><?= $department['Dept_Name_EN']; ?></td>
            <td><?= $department['Type_Of_Dept']; ?></td>
            <td><?= $department['Username']; ?></td>
            <td><?= ($city_names[$department['Citys']] ?? '') ?></td>
            <td>
                <a href="<?= base_url() ?>EN/DashboardSystem/UpdateDepartmentData/<?= $department['Dept_Id']; ?>">
                    <i class="uil-pen" style="font-size: 25px;" title="Edit"></i>
                </a>
            </td>
            <?php if (!isset($disableStatusControl)) { ?>
                <td>
                    <label class="switch">
                        <input type="checkbox"
                               data-user-id="<?= $department['Dept_Id']; ?>" <?= $department['status'] == 1 ? "checked" : "" ?>>
                        <span class="slider round"></span></label>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>