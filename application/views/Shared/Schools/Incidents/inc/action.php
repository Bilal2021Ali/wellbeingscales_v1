<?php
/**
 * @var IncidentsDTO $incident
 * @var StudentDTO $student
 * @var string $activeLanguage
 * @var array $sites
 * @var array<IncidentPriorityDTO> $priorities
 * @var array<IncidentCategoryDTO> $categories
 * @var callable<string> $incidentsAction
 */

use DTOs\Incidents\IncidentCategoryDTO;
use DTOs\Incidents\IncidentPriorityDTO;
use DTOs\IncidentsDTO;
use DTOs\StudentDTO;

?>
<style>
    .br {
        border-right: 1px solid #8ccaff;
    }
</style>
<div class="row">
    <div class="col-md-4 col-sm-12 p-2 br">
        <div class="col-12">
            <h3 class="card-title text-muted"><?= __("students") ?> :</h3>
            <?php $this->load->view("Shared/Schools/Incidents/inc/students-involved-full-data", ['students' => $incident->students]) ?>
        </div>
    </div>
    <div class="col-md-8 col-sm-12 p-2 br">
        <?php $this->load->view('Shared/Schools/Incidents/inc/form', ['showUpdateFields' => true]); ?>
    </div>
</div>
