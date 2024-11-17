<?php

/**
 * @var array $locations
 * @var array<IncidentCategoryDTO> $categories
 * */

use DTOs\Incidents\IncidentCategoryDTO;
use Enums\Incidents\IncidentStatus;

?>

<div class="row">

    <div class="col-md-4 col-sm-12">
        <label><?= __("status") ?></label>
        <select multiple class="select-2 form-control" id="incident-status">
            <?php foreach (IncidentStatus::cases() as $status) { ?>
                <option class="bg-<?= $status->color() ?>"
                        value="<?= $status->value ?>"><?= $status->text() ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-4 col-sm-12">
        <label><?= __("category") ?></label>
        <select multiple class="select-2 form-control" id="category">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category->value ?>"><?= $category->text() ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-4 col-sm-12">
        <label><?= __("location") ?></label>
        <select multiple class="select-2 form-control" id="location">
            <?php foreach ($locations as $location) { ?>
                <option value="<?= $location['Id'] ?>"><?= $location['name'] ?></option>
            <?php } ?>
        </select>
    </div>

</div>