<?php

use DTOs\Incidents\IncidentCategoryDTO;
use DTOs\Incidents\IncidentPriorityDTO;
use DTOs\IncidentsDTO;
use Enums\Incidents\IncidentStatus;
use Enums\Incidents\IncidentsTypes;

/**
 * @var array $students
 * @var array $sites
 * @var callable<string> $incidentsAction
 * @var IncidentsDTO $incident
 * @var bool $showUpdateFields
 * @var array<IncidentPriorityDTO> $priorities
 * @var array<IncidentCategoryDTO> $categories
 */
?>
<link href="<?php echo base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>"
      rel="stylesheet">
<style>
    label:not(:first-of-type) {
        margin-top: 0.7rem;
    }
</style>
<form class="card-body save-incident">
    <div class="w-100 position-relative">
        <h3 class="card-title"><?= __("school_incident_report") ?></h3>
        <p><?= __("incident_information") ?></p>
        <hr>
    </div>

    <label><?= __("location_of_incident") ?></label>
    <select class="form-control select2" name="location_of_incident">
        <?php foreach ($sites as $site) { ?>
            <option <?= selected($site['Id'] === $incident->incident_location) ?>
                    value="<?= $site['Id'] ?>"><?= $site['name'] ?></option>
        <?php } ?>
    </select>

    <label><?= __('date_of_incident') ?></label>
    <input type="text" class="form-control" data-provide="datepicker" name="date_of_incident"
           data-date-format="yyyy-mm-dd" value="<?= $incident->date_of_incident ?? "" ?>"
           placeholder="<?= __('date_of_incident') . "..." ?>">

    <label><?= __("students_involved") ?></label>
    <select class=" form-control select2" name="students[]" multiple>
        <?php foreach ($students as $student) { ?>
            <option <?= selected(in_array($student['id'], $incident->studentsIds())) ?>
                    value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
        <?php } ?>
    </select>

    <label><?= __('reported_by') ?> : (<?= __("name_of_staff") ?>)</label>
    <input type="text" class="form-control" name="reported_by" value="<?= $incident->reported_by ?? "" ?>"
           placeholder="<?= __('reported_by') . "..." ?>">


    <label><?= __("describe_the_incident") ?></label>
    <input type="text" class="form-control" name="description"
           value="<?= $incident->description ?>"
           placeholder="<?= __("description_of_incident") ?>...">

    <div class="w-100 mt-1" id="witnesses_names">
        <label><?= __("witnesses_names") ?></label>
        <input type="text" class="form-control" name="witnesses_names" value="<?= $incident->witnesses_names ?>"
               placeholder="<?= __("witnesses_names") ?>...">
    </div>

    <label><?= __("were_parents_contacted") ?></label>
    <div class="d-flex tabs-container">
        <?php foreach (IncidentsTypes::cases() as $key => $status) { ?>
            <button data-color="<?= $status->color() ?>" value="<?= $status->value ?>"
                    type="button"
                    class="btn w-100 <?= $key === 0 ?: 'ml-1' ?> <?= active($status->value === $incident->parents_contacted) ?> parents waves-effect btn-outline-<?= $status->color() ?>">
                <?= $status->text() ?>
            </button>
        <?php } ?>
    </div>

    <label><?= __("describe_type_of_injury") ?></label>
    <input type="text" class="form-control" name="injuries" value="<?= $incident->injuries ?>"
           placeholder="<?= __("describe_type_of_injury") ?>...">

    <label><?= __("describe_medical_attention_given") ?></label>
    <input type="text" class="form-control" name="medical_attention" value="<?= $incident->witnesses_names ?>"
           placeholder="<?= __("describe_medical_attention_given") ?>...">

    <label><?= __("other_comments") ?></label>
    <input type="text" class="form-control" name="incident_notes" value="<?= $incident->witnesses_names ?>"
           placeholder="<?= __("other_comments") ?>...">

    <label><?= __("upload_evidence") ?></label>
    <input type="file" hidden="" class="d-none" name="images[]" multiple accept="image/*,video/*"
           id="file">
    <label for="file" id="file_select" class="btn btn-outline-primary w-100 mt-0">
        <i class="uil uil-cloud-upload"></i>
    </label>

    <?php if (isset($showUpdateFields) && $showUpdateFields) { ?>
        <label><?= __("disciplinary_actions") ?></label>
        <input type="text" class="form-control" name="disciplinary_actions"
               value="<?= $incident->disciplinary_actions ?>"
               placeholder="<?= __("disciplinary_actions") ?>...">

        <label><?= __("identify_potential_consequences") ?></label>
        <input type="text" class="form-control" name="potential_consequences"
               value="<?= $incident->potential_consequences ?>"
               placeholder="<?= __("identify_potential_consequences") ?>...">

        <label><?= __("suggest_preventive_measures") ?></label>
        <input type="text" class="form-control" name="preventive_measures"
               value="<?= $incident->preventive_measures ?>"
               placeholder="<?= __("suggest_preventive_measures") ?>...">

        <label><?= __("is_there_a_need_for_followup_actions") ?></label>
        <div class="d-flex tabs-container">
            <?php foreach (IncidentsTypes::cases() as $key => $status) { ?>
                <button data-color="<?= $status->color() ?>" value="<?= $status->value ?>"
                        type="button"
                        class="btn w-100 <?= $key === 0 ?: 'ml-1' ?>
                        <?= active($status->value === $incident->should_take_followup_actions) ?> followup-actions waves-effect btn-outline-<?= $status->color() ?>">
                    <?= $status->text() ?>
                </button>
            <?php } ?>
        </div>

        <label><?= __("status") ?></label>
        <select class="form-control" name="status">
            <option <?= selected($incident->status()->value === 0) ?> disabled><?= __('unknown') ?></option>
            <?php foreach (IncidentStatus::cases() as $status) { ?>
                <option class="bg-<?= $status->color() ?>"
                        value="<?= $status->value ?>" <?= $status->isSelected($incident->status()->value) ?>>
                    <?= $status->text() ?>
                </option>
            <?php } ?>
        </select>

        <label><?= __("priority") ?></label>
        <select class="form-control" name="priority">
            <option <?= selected($incident->priority()->value === 0) ?> disabled><?= __('unknown') ?></option>
            <?php foreach ($priorities as $priority) { ?>
                <option value="<?= $priority->value ?>" <?= $priority->isSelected($incident->priority()->value) ?>
                        style="<?= $priority->label() ?>"><?= $priority->text() ?></option>
            <?php } ?>
        </select>

        <label><?= __("category") ?></label>
        <select class="form-control" name="category">
            <option <?= selected($incident->category()->value === 0) ?> disabled><?= __('unknown') ?></option>
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category->value ?>" <?= $category->isSelected($incident->category()->value) ?>
                        style="<?= $category->label() ?>">
                    <?= $category->text() ?>
                </option>
            <?php } ?>
        </select>
    <?php } ?>

    <button class="btn btn-primary w-100 mt-2" type="submit">
        <?= __("save") ?>
    </button>
</form>
<script src="<?php echo base_url('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script>
    var colors = <?= json_encode(array_map(function (IncidentsTypes $status) {
        return $status->color();
    }, IncidentsTypes::cases())) ?>;
    $(".select2").select2();

    $(".tabs-container button").click(function () {
        const siblings = $(this).parent().children();
        const color = $(this).data("color");

        colors.forEach(function (color) {
            siblings.removeClass(`btn-${color}`);
            siblings.removeClass("active");
        });

        $(this).addClass("btn-" + color);
        $(this).addClass("active");

        const target = "#" + $(this).data("toggles");
        if ($(this).data("show")) {
            $(target).show();
        } else {
            $(target).hide();
        }
    });

    $(".save-incident").on('submit', function (e) {
        e.preventDefault();
        const button = $('.new-incident button[type="submit"]');

        const data = new FormData(this);
        data.append("parents", $(".parents.active").attr("value") ?? '');
        <?php if (isset($showUpdateFields) && $showUpdateFields)  { ?>
        data.append("should_take_followup_actions", $(".followup-actions.active").attr("value") ?? '');
        <?php } ?>

        $.ajax({
            type: 'POST',
            url: '<?= $incidentsAction('save' . (!empty($incident->id) ? '/' . $incident->id : '')); ?>',
            data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                button.attr("disabled", "disabled").html("<?= __("please_wait") ?>");
            },
            success: function (data) {
                button.removeAttr("disabled");
                button.html("<?= __("save") ?>");

                if (data.status === "success") {
                    Swal.fire({
                        title: "<?= __("success") ?>",
                        text: data.message,
                        icon: 'success',
                    });
                    setTimeout(function () {
                        document.dispatchEvent(new CustomEvent('incidentSavedSuccessfully'))
                    }, 400);
                    return;
                }

                Swal.fire({
                    title: "<?= __("error") ?>",
                    html: data.message,
                    icon: 'error',
                });
            },
            ajaxError: function () {
                Swal.fire({
                    title: "<?= __("error") ?>",
                    text: '<?= __("oops_error") ?>',
                    icon: 'error',
                    confirmButtonColor: '#283d65'
                });
            },
        });
    });

    $("#file").change(function (e) {
        const files = e.target.files.length;
        if (files < 1) {
            $("#file_select").html('<i class="uil uil-cloud-upload"></i>');
        } else {
            $("#file_select").html('<?= __("selected") ?> : ' + files);
        }
    });
</script>