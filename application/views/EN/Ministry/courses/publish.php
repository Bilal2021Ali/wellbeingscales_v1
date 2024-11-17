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
                            <label>Start Date :</label>
                            <input type="text" class="form-control" value="<?= $form['start'] ?>" name="start"
                                   autocomplete="off"
                                   placeholder="Start Date"/>
                        </div>
                        <div class="col-lg-6">
                            <label>End Date :</label>
                            <input type="text" class="form-control" value="<?= $form['end'] ?>" name="end"
                                   autocomplete="off"
                                   placeholder="End Date"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>Available To :</label>
                        <select class="form-control" name="available-to">
                            <?php foreach ($schoolsTypes as $id => $type) { ?>
                                <option <?= $form['available-to'] == $id ? "selected" : "" ?>
                                    value="<?= $id ?>"><?= $type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Status :</label>
                        <select class="form-control" name="status">
                            <option <?= $form['status'] == 1 ? "selected" : "" ?> value="1">Enabled</option>
                            <option <?= $form['status'] == 0 ? "selected" : "" ?> value="0">Disabled</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <label>Guidance Notes :</label>
                        <textarea class="form-control" name="notes"
                                  placeholder="any message..."><?= $form['guidance-notes'] ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success w-100 mt-1">
                            Publish
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
                $('#publish-course button[type="Submit"]').attr('disabled', '').html('Saving...');
            },
            success: function (data) {
                if (data.status === "error") {
                    toastr["error"](data.message);
                } else {
                    toastr["success"](data.message);
                    setTimeout(() => {
                        location.href = "<?= base_url("EN/DashboardSystem/course/" . $course['Id']) ?>"
                    }, 200);
                }
                $('#publish-course button[type="Submit"]').removeAttr('disabled', '').html('Save');
            },
            ajaxError: function () {
                toastr["success"]("Sorry We had An Error");
            }
        });
    });
</script>