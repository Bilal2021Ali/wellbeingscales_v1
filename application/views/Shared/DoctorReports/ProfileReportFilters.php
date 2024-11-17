<?php
/**
 * @var array $tests
 * @var array $classes
 * @var array $grades
 * @var array $schools
 * @var bool $isMinistry
 * @var array $profiles
 */

$layout = $isMinistry ? 'col-lg-6 col-sm-12' : 'col-lg-4 col-sm-12';
$secondaryRow = $isMinistry ? 'col-lg-6 col-sm-12' : 'col-lg-6 col-sm-12';
?>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"
      type="text/css"/>

<div class="row">
    <?php if ($isMinistry) { ?>
        <div class="<?= $layout ?>">
            <label class="mb-0"><?= __('schools') ?></label>
            <select class="select2 form-control" name="schools[]" multiple data-placeholder="<?= __('select') ?>">
                <?php foreach ($schools as $school) { ?>
                    <option value="<?= $school['Id'] ?>"><?= $school['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

    <div class="<?= $layout ?>">
        <label class="mb-0"><?= __('profiles') ?></label>
        <select class="select2 form-control" name="profiles[]" multiple data-placeholder="<?= __('select') ?>">
            <?php foreach ($profiles as $profile) { ?>
                <option value="<?= $profile ?>"><?= $profile ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="<?= $layout ?>">
        <label class="mb-0"><?= __('test') ?></label>
        <select class="select2 form-control" name="test" data-placeholder="<?= __('select') ?>">
            <option value="all"><?= __("all") ?></option>
            <?php foreach ($tests as $test) { ?>
                <option value="<?= $test ?>"><?= $test ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="<?= $layout ?>">
        <label class="mb-0"><?= __('gender') ?></label>
        <select class="select2 form-control" name="genders[]" multiple data-placeholder="<?= __('select') ?>">
            <option value="male"><?= __('male') ?></option>
            <option value="female"><?= __('female') ?></option>
        </select>
    </div>

    <div class="<?= $secondaryRow ?>">
        <label class="mb-0"><?= __('class name') ?></label>
        <select class="select2 form-control" name="classes[]" multiple data-placeholder="<?= __('select') ?>">
            <?php foreach ($classes as $class) { ?>
                <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="<?= $secondaryRow ?>">
        <label class="mb-0"><?= __('grades') ?></label>
        <select class="select2 form-control" name="grades[]" multiple data-placeholder="<?= __('select') ?>">
            <?php foreach ($grades as $grade) { ?>
                <option value="<?= $grade['value'] ?>"><?= $grade['name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-12 mt-2">
        <label class="mb-0"><?= __('date range') ?></label>
        <div class="input-daterange input-group" id="dateRangeFilter" data-date-format="yyyy-mm-dd"
             data-date-autoclose="true" data-provide="datepicker" data-date-container='#dateRangeFilter'>
            <input type="text" class="form-control" autocomplete="off" name="start" placeholder="<?= __('from') ?>"/>
            <input type="text" class="form-control" autocomplete="off" name="end" placeholder="<?= __('to') ?>"/>
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary w-100 mt-2" type="button">
            <?= __('filter') ?>
        </button>
    </div>

</div>

<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script>
    $('.select2').select2();
</script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
