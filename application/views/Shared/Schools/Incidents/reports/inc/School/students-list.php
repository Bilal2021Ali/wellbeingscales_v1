<?php
/**
 * @var array $students
 */
?>
<div class="card-body">
    <label><?= __("select_student") ?></label>
    <select class="form-control select-student">
        <option value="" disabled selected><?= __("select_student") ?></option>
        <?php foreach ($students as $student) { ?>
            <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
        <?php } ?>
    </select>
</div>