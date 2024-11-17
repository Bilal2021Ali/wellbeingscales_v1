<div class="page-title-right">
    <button class="btn btn-success sub-account-add">
        <i class="uil uil-plus"></i> | Add
    </button>
</div>

<div id="subAccountForm" class="modal fade zoom-in" tabindex="-1" role="dialog" aria-labelledby="subAccountFormLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subAccountFormLabel">sub account</h5>
                <button type="button" class="btn-close btn-rounded text-danger btn" data-dismiss="modal"
                        aria-label="Close">
                    <i class="uil uil-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="loading_data">
                    <div class="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <label type="button" class="btn btn-outline-dark w-100" for="avatar-image">
                    إختر صورة شخصية
                </label>
                <input type="file" accept="image/*" id="avatar-image" class="form-control mb-2 hidden"
                       name="avatar"/>

                <label>Name:</label>
                <input type="text" class="form-control mb-2" name="name" placeholder="Name"/>

                <label>username (must be unique):</label>
                <input type="text" class="form-control mb-2" name="username" placeholder="username"/>

                <label>Role:</label>
                <textarea class="form-control mb-2" name="role" placeholder="Account Role/Description"></textarea>

                <input type="hidden" name="_activeAccount">
                <p class="mt-4 mb-0 default-password-hint"><i class="uil uil-info-circle"></i> | The Default Password
                    Would
                    Be : <?= $password ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(".sub-account-add").click(function () {
        $(".loading_data").removeClass('active');
        $('#subAccountForm input[name="name"]').val("");
        $('#subAccountForm input[name="username"]').val("");
        $('#subAccountForm textarea[name="role"]').val("");
        $('#subAccountForm input[name="_activeAccount"]').val("");
        $('#subAccountForm .default-password-hint').slideDown();
        $("#subAccountForm").modal('show');
    });

    $('#subAccountForm form.modal-content').on('submit', function (e) {
        e.preventDefault();
        const sBtn = $('#subAccountForm button[type="submit"]');
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
                    command: toastr['success']('The account has been saved successfully.');
                    $("#subAccountForm").modal('hide');
                    setTimeout(() => {
                        if (response.key == null) {
                            return;
                        }
                        location.href = "<?= base_url('AR/schools/assistance-account/') ?>" + response.key + "/permissions";
                    }, 600);
                } else {
                    command: toastr['error'](response.message);
                }
            }
        });
    });
</script>