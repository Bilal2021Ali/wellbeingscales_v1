<?php

/**
 * @var array<IncidentsDTO> $incidents
 * @var callable $incidentsAction
 * @var bool $isMinistry
 */

use DTOs\IncidentsDTO;

$activateActions = !(isset($disableActions) && $disableActions);
$tableRunTimeId = uniqid("table-");
?>
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">
<?php if ($activateActions) { ?>
    <link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
    <script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<?php } ?>
<style>
    .status-indicator {
        width: 0.6rem;
        height: 0.6rem;
        border-radius: 50%;
        display: inline-block;
    }

    .loading-container {
        height: 250px;
        display: grid;
        width: 100%;
        align-items: center;
        justify-items: center;
    }

    .datepicker.dropdown-menu {
        z-index: 10000 !important;
    }

    .table {
        display: table;
    }
</style>

<div class="modal fade actions-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body overflow-auto">

            </div>
        </div>
    </div>
</div>
<div class="overflow-auto">
    <table class="table actions-table table-bordered w-100 <?= $tableRunTimeId ?>">
        <thead>
        <th>#</th>
        <?php if ($isMinistry) { ?>
            <th><?= __("school_name") ?></th>
        <?php } ?>
        <th><?= __("students_names") ?></th>
        <th><?= __("incident") ?></th>
        <th><?= __("created_at") ?></th>
        <?php if ($activateActions) { ?>
            <th><?= __("action") ?></th>
        <?php } ?>
        <th><?= __("status") ?></th>
        <th><?= __("category") ?></th>
        <th><?= __("location") ?></th>
        <th><?= __("priority") ?></th>
        <th><?= __("incident_history") ?></th>
        </thead>
        <tbody>
        <?php foreach ($incidents as $key => $incident) { ?>
            <?php $category = $incident->category(); ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <?php if ($isMinistry) { ?>
                    <td><?= $incident->school_name ?></td>
                <?php } ?>
                <td>
                    <?php $this->load->view('Shared/Schools/Incidents/inc/students-involved', ['students' => $incident->students]); ?>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary w-100 action"
                            data-target="<?= $incidentsAction('view/' . $incident->id) ?>"
                            data-toggle="modal">
                        <?= __('view') ?>
                    </button>
                </td>
                <td><?= $incident->createdDay() ?></td>
                <?php if ($activateActions) { ?>
                    <td>
                        <button class="btn btn-sm btn-outline-warning w-100 action"
                                data-target="<?= $incidentsAction('action/' . $incident->id) ?>">
                            <?= __('action') ?>
                        </button>
                    </td>
                <?php } ?>
                <td>
                    <div class="align-items-center d-flex">
                        <div class="status-indicator bg-<?= $incident->status()->color() ?> m-1"
                             role="status"></div>
                        <p class="mb-0"><?= $incident->status()->text() ?></p>
                    </div>
                </td>
                <td style="<?= $category->label()->toStyle() ?>" class="text-center">
                    <?= $category->text() ?>
                </td>
                <td><?= $incident->site_name ?></td>
                <td style="<?= $incident->priority()->label()->toStyle() ?>" class="text-center">
                    <?= $incident->priority()->text() ?>
                </td>
                <td>
                    <?= $incident->incidentHistory() ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var loadingDiv = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only"><?= __("loading") ?>...</span> </div></div>`;

    $('.<?= $tableRunTimeId ?>').DataTable();
    var modal = $(".actions-modal");
    var modalContent = $(".actions-modal .modal-body");

    $(".actions-table").on("click", ".action", function () {
        modal.modal("show");
        modalContent.html(loadingDiv);
        $.ajax({
            type: 'GET',
            url: $(this).data("target"),
            contentType: false,
            cache: false,
            processData: false,
            success: function (content) {
                modalContent.html(content);
            },
            error: function () {
                modalContent.html(`<div class="alert alert-danger text-center w-100"><?= __("oops_error") ?></div>`);
            }
        });
    });

    document.addEventListener('incidentSavedSuccessfully', function () {
        modal.modal("hide");
        location.reload();
    });
</script>