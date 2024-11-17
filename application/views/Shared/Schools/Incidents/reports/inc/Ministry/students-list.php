<?php
/**
 * @var array $schools
 */
?>
<div class="card-body">
    <label><?= __("select_student") ?></label>
    <select class="form-control select-student">
        <option value="" disabled selected><?= __("select_student") ?></option>
        <?php foreach ($schools as $school) { ?>
            <optgroup label="<?= $school['schoolName'] ?>">
                <?php foreach ($school['students'] as $student) { ?>
                    <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
                <?php } ?>
            </optgroup>
        <?php } ?>
    </select>
</div>