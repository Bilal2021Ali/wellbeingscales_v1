<?php

use DTOs\Incidents\IncidentCategoryDTO;
use Enums\Incidents\IncidentStatus;

/**
 * @var string $activeLanguage
 * @var array<IncidentCategoryDTO> $categories
 */
?>

<div class="row">

    <div class="col-md-6 col-sm-12">
        <label><?= __("schools") ?></label>
        <select multiple class="select-2 form-control" id="schools">
            <?php foreach ($this->sv_ministry_reports->our_schools() as $school) { ?>
                <option value="<?= $school['Id'] ?>"><?= $school['School_Name_' . $activeLanguage] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-6 col-sm-12">
        <label><?= __("status") ?></label>
        <select multiple class="select-2 form-control" id="incident-status">
            <?php foreach (IncidentStatus::cases() as $status) { ?>
                <option class="bg-<?= $status->color() ?>"
                        value="<?= $status->value ?>"><?= $status->text() ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-6 col-sm-12">
        <label class="mt-2"><?= __("category") ?></label>
        <select multiple class="select-2 form-control" id="category">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category->value ?>"><?= $category->text() ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-6 col-sm-12">
        <label class="mt-2"><?= __("location") ?></label>
        <select multiple class="select-2 form-control" id="location">
            <?php foreach ($locations as $location) { ?>
                <option value="<?= $location['Id'] ?>"><?= $location['name'] ?></option>
            <?php } ?>
        </select>
    </div>

</div>