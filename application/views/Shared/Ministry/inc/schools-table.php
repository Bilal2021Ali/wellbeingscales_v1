<?php
// Collect all country and city IDs
$country_ids = array_column($schools, 'Country');
$city_ids = array_column($schools, 'Citys');

// Query for all countries
$countries = empty($country_ids) ? [] : $this->db->query("SELECT `id`, `name` FROM `r_countries` WHERE `id` IN (" . implode(',', $country_ids) . ")")->result_array();
$country_names = array_column($countries, 'name', 'id');

// Query for all cities
$cities = empty($city_ids) ? [] : $this->db->query("SELECT `id`, `Name_EN` FROM `r_cities` WHERE `id` IN (" . implode(',', $city_ids) . ")")->result_array();
$city_names = array_column($cities, 'Name_' . strtoupper($activeLanguage), 'id');

?>
<style>
    .switch.disabled {
        cursor: default;
        opacity: 0.3;
    }

    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<table id="visi_table" class="table Table_Data table-striped table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th>#</th>
        <th><?= __("school_english_name") ?></th>
        <th><?= __("school_arabic_name") ?></th>
        <th><?= __("user_name") ?></th>
        <th><?= __("school_type") ?></th>
        <th><?= __("country_and_city") ?></th>
        <th><?= __("edit") ?></th>
        <th><?= __("permissions") ?></th>
        <?php if (!isset($disableStatusControl)) { ?>
            <th class="actions"><?= __("status") ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($schools as $sn => $school) { ?>
        <tr>
            <th scope="row"><?= $sn + 1; ?></th>
            <td><?= $school['School_Name_EN']; ?></td>
            <td><?= $school['School_Name_AR']; ?></td>
            <td><?= $school['Username']; ?></td>
            <td><?= $school['Type_Of_School']; ?></td>
            <td><?= ($country_names[$school['Country']] ?? '') . ", " . ($city_names[$school['Citys']] ?? '') ?></td>
            <td>
                <a href="<?= base_url($activeLanguage . "/DashboardSystem/UpdateSchoolData/" . $school['Id']) ?>">
                    <i class="uil-pen" style="font-size: 25px;"></i></a>
            </td>
            <?php
            if ($school['status'] == 1) {
                $cheked = 'checked';
            } else {
                $cheked = '';
            }
            ?>
            <td class="text-center">
                <a href="<?= base_url($activeLanguage . "/DashboardSystem/permissions/school/" . $school['Id']) ?>">
                    <i class="uil uil-keyhole-circle" style="font-size: 25px;"
                       data-toggle="tooltip" data-placement="top" title=""
                       data-original-title="<?= __("permissions") ?>"></i>
                </a>
            </td>
            <?php if (!isset($disableStatusControl)) { ?>
                <td>
                    <label class="switch">
                        <input type="checkbox" theAdminId="<?= $school['Id']; ?>" id="status" <?= $cheked; ?>>
                        <span class="slider round"></span>
                    </label>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    $("table").on("change", 'input[type="checkbox"]', function () {
        var theAdminId = $(this).attr('theAdminId');
        console.log(theAdminId);
        console.log(this.checked);
        $.ajax({
            type: 'POST',
            url: '<?= base_url($activeLanguage . "/DashboardSystem/changeSchoolstatus"); ?>,
            data: {
                adminid: theAdminId,
            },
            success: function (data) {
                Swal.fire(
                    '<?= __("updated_successfully") ?>',
                    data,
                    'success'
                )
            },
            ajaxError: function () {
                Swal.fire(
                    '<?= __("error") ?>',
                    '<?= __("oops_error") ?>',
                    'error'
                )
            }
        });
    });
</script>
