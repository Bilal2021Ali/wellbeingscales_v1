<?php
/**
 * @var IncidentsDTO $incident
 * @var string $activeLanguage
 * @var callable<string> $section
 */

use DTOs\IncidentsDTO;

?>
<style>
    .br {
        border-right: 1px solid #8ccaff;
    }
</style>
<div class="mb-1 shadow-none">
    <div class="row">
        <div class="col-md-4 col-sm-12 p-2 br">
            <div class="col-12">
                <h3 class="card-title text-muted"><?= __("students") ?> :</h3>
                <?php $this->load->view("Shared/Schools/Incidents/inc/students-involved-full-data", ['students' => $incident->students]) ?>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 p-2 br">
            <h3 class="card-title text-muted mb-2"><?= __("details") ?> :</h3>

            <?= $section('location', 'site_name') ?>
            <?= $section('date_of_incident', 'date_of_incident') ?>
            <?= $section('reported_by', 'reported_by') ?>
            <?= $section('witnesses_names') ?>
            <?= $section('supervisor_attention') ?>
            <?= $section('parents_contacted') ?>
        </div>


        <div class="col-md-4 col-sm-12 p-2">
            <?= $section('potential_consequences') ?>
            <?= $section('preventive_measures') ?>
            <?= $section('incident_notes') ?>
            <?= $section('disciplinary_actions') ?>
            <?= $section('description') ?>
            <?= $section('followup_actions', null,) ?>
            <?= $section('is_there_a_need_for_followup_actions', null, $incident->should_take_followup_actions()?->text() ?? __("unknown")) ?>
            <?= $section('medical_attention') ?>
        </div>

    </div>
</div>
