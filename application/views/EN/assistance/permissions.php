<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<div class="main-content">
    <div class="page-content">
        <div class="card">
            <form class="card-body permissions-form">
                <button class="btn btn-primary float-right" width="100px" type="submit">
                    <i class="uil uil-save"></i> | save
                </button>
                <div class="row">
                    <?php foreach ($permissions as $key => $permission) { ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       name="<?= $key ?>" <?= in_array($key, $account['permissions']) ? 'checked' : '' ?>
                                       class="custom-control-input"
                                       id="permission-<?= $key ?>">
                                <label class="custom-control-label"
                                       for="permission-<?= $key ?>"><?= ucwords($permission) ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('form.permissions-form').on('submit', function (e) {
        e.preventDefault();
        const sBtn = $('.permissions-form button[type="submit"]');
        sBtn.attr('disabled', 'true').html('Please wait...');
        $.ajax({
            type: "POST",
            url: "<?= current_url() ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                sBtn.removeAttr('disabled').html('Save Changes');
                if (response.status === "ok") {
                    command: toastr['success']('The Permissions has been saved successfully.');
                } else {
                    command: toastr['error'](response.message);
                }
            }
        });
    });
</script>