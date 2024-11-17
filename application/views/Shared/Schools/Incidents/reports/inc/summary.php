<?php

use Enums\Incidents\IncidentStatus;

/**
 * @var array $counters
 * @var array $incidents
 */
?>
<style>
    .counter {
        font-size: 1.6rem;
        font-weight: bold;
    }
</style>
<div class="row">
    <?php foreach (IncidentStatus::cases() as $status) { ?>
        <div class="col-md-3">
            <div class="card" style="<?= $status->backgroundStyle() ?>">
                <div class="card-body">
                    <h4 class="mb-1 mt-1 text-white"><?= $status->text() ?></h4>
                    <p data-plugin="counterup" class="counter mb-0 text-white"><?= $counters[$status->value] ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="card">
    <div class="card-body">
        <?php $this->load->view("Shared/Schools/Incidents/inc/list", ['disableActions' => true, 'incidents' => $incidents]); ?>
    </div>
</div>