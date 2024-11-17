<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<style>
    .input-daterange .form-control {
        border-radius: 5px !important;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><?= $course['Courses_Title'] ?></h3>
                <hr>
                <form id="publish-course" class="row">
                    <div class="mb-2 input-daterange input-group" data-date-format="yyyy-mm-dd"
                         data-date-autoclose="true" data-provide="datepicker">
                        <div class="col-lg-6">
                            <label><?= $this->lang->line('start-date') ?>:</label>
                            <input type="text" class="form-control" value="<?= $form['start'] ?>" name="start"
                                   autocomplete="off"
                                   placeholder="<?= $this->lang->line('start-date') ?>"/>
                        </div>
                        <div class="col-lg-6">
                            <label><?= $this->lang->line('end-date') ?> :</label>
                            <input type="text" class="form-control" value="<?= $form['end'] ?>" name="end"
                                   autocomplete="off"
                                   placeholder="<?= $this->lang->line('start-date') ?>"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label><?= $this->lang->line('available-to') ?> :</label>
                        <select class="form-control" name="available-to">
                            <?php foreach ($schoolsTypes as $id => $type) { ?>
                                <option <?= $form['available-to'] == $id ? "selected" : "" ?>
                                    value="<?= $id ?>"><?= $type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label><?= $this->lang->line('status') ?> :</label>
                        <select class="form-control" name="status">
                            <option <?= $form['status'] == 1 ? "selected" : "" ?>
                                value="1"><?= $this->lang->line('enabled') ?></option>
                            <option <?= $form['status'] == 0 ? "selected" : "" ?>
                                value="0"><?= $this->lang->line('disabled') ?></option>
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <label><?= $this->lang->line('guidance-notes') ?> :</label>
                        <textarea class="form-control" name="notes"
                                  placeholder="<?= $this->lang->line("any-message") ?>"><?= $form['guidance-notes'] ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success w-100 mt-1">
                            <?= $this->lang->line("publish") ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<script>
    $("#publish-course").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#publish-course button[type="Submit"]').attr('disabled', '').html('...');
            },
            success: function (data) {
                if (data.status === "error") {
                    toastr["error"](data.message);
                } else {
                    toastr["success"](data.message);
                    setTimeout(() => {
                        location.href = "<?= base_url("" . $activeLanguage . "/DashboardSystem/courses-category/" . $course['Category_Id']) ?>"
                    }, 200);
                }
                $('#publish-course button[type="Submit"]').removeAttr('disabled', '').html('<?= $this->lang->line("publish") ?>');
            },
            ajaxError: function () {
                toastr["success"]("<?= $this->lang->line("general-error") ?>");
            }
        });
    });
</script>