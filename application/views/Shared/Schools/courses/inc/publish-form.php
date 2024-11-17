<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<?php
$class = isset($full) ? "col-12" : "col-lg-6 col-md-6";
?>
<style>
    .s-all {
        margin-top: -9px;
    }
</style>
<div class="<?= $class ?> col-sm-12 form-group">
    <label><?= $this->lang->line('user-type') ?> :</label>
    <span class="float-right text-primary btn s-all"
          data-target-select="types[]"><?= $this->lang->line('select-all') ?></span>
    <select class="form-control select2 select2-multiple" multiple name="types[]">
        <?php foreach ($types as $type) { ?>
            <option
                value="<?= $type['Id'] ?>" <?= in_array($type['Id'], $course['users-types']) ? "selected" : "" ?>><?= $type[$isEn ? 'UserType' : 'AR_UserType'] ?></option>
        <?php } ?>
    </select>
</div>
<div class="<?= $class ?> col-sm-12 form-group">
    <label><?= $this->lang->line('class-level') ?> :</label>
    <span class="float-right text-primary btn s-all"
          data-target-select="levels[]"><?= $this->lang->line('select-all') ?></span>
    <select class="form-control select2 select2-multiple" multiple name="levels[]">
        <?php foreach ($levels as $level) { ?>
            <option
                value="<?= $level['Id'] ?>" <?= in_array($level['Id'], $course['levels']) ? "selected" : "" ?>><?= $level[$isEn ? 'Class' : 'Class_ar'] ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-12 col-sm-12 form-group">
    <label><?= $this->lang->line('user-gender') ?> :</label>
    <span class="float-right text-primary btn s-all"
          data-target-select="genders[]"><?= $this->lang->line('select-all') ?></span>
    <select class="form-control select2 select2-multiple" multiple name="genders[]">
        <?php foreach ($genders as $gender) { ?>
            <option
                value="<?= $gender['id'] ?>" <?= in_array($gender['id'], $course['genders']) ? "selected" : "" ?>><?= $gender['Gender_Type'] ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-12">
    <button type="submit" class="btn btn-success w-100 mt-1">
        <?= $this->lang->line('Publish') ?>
    </button>
</div>
<script>
    $('.select2').select2({
        closeOnSelect: false,
        allowClear: true
    });

    $('.s-all').click(function () {
        var target = $(this).attr('data-target-select');
        $('select[name="' + target + '"] option').attr('selected', '');
        var selectedItems = [];
        var allOptions = $('select[name="' + target + '"]');
        allOptions.each(function () {
            selectedItems.push($(this).val());
        });
        $('select[name="' + target + '"]').select2("val", selectedItems);
    });
</script>
