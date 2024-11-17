<?php

/**
 * @var callable $chart
 */
?>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<div class="main-content">
    <div class="page-content">

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= __("total") ?></h3>
                        <?php $chart("totals"); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= __("incident_priority") ?></h3>
                        <?php $chart("by-priority"); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= __("incident_status") ?></h3>
                        <?php $chart("by-status"); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= __("incident_location") ?></h3>
                        <?php $chart("by-location"); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center"><?= __("incidents_per_month") ?></h3>
                        <?php $chart("by-month"); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>