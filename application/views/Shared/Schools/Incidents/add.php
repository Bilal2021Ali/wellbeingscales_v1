<?php

use Carbon\Carbon;

/**
 * @var array $students
 * @var callable<string> $incidentsAction
 * @var array $incidents
 */

?>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>

<style>
    .btn-info, .btn-danger, .btn-success {
        color: #fff;
    }

    .swal2-html-container p {
        text-align: left;
        margin-bottom: 0.3rem;
    }

    .event-date {
        width: fit-content;
    }

    <?php if ($activeLanguage === "AR") { ?>
    .verti-timeline .event-list {
        border-left: none !important;
        padding: 0px 30px 30px 0px !important;
    }

    <?php } ?>
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <?php $this->load->view('Shared/Schools/Incidents/inc/form'); ?>
                    </div>
                </div>


                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= __("activity_log") ?> <span
                                        class="float-right text-muted"><?= __("show_last_incidents", ['count' => 10]) ?></span>
                            </h3>
                            <hr>
                            <ul class="verti-timeline list-unstyled">
                                <?php foreach ($incidents as $incident) { ?>
                                    <li class="event-list">
                                        <div class="event-date text-primary"><?= Carbon::parse($incident['created_at'])->format("d/m/y") ?></div>
                                        <div class="d-flex">
                                            <?php $this->load->view('Shared/Schools/Incidents/inc/students-involved', ['students' => $incident['students']]); ?>
                                            <div class="ml-2">
                                                <a href="<?= $incidentsAction('actions?open=' . $incident['id']) ?>"
                                                   class="mb-0 d-block"><?= __('details') ?></a>
                                                <span class="text-muted"><?= Carbon::parse($incident['created_at'])->format("H:i A") ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('incidentSavedSuccessfully', function () {
        location.reload();
    });
</script>
