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
                <form id="publish-course" class="row">
                    <?php $this->load->view("Shared/Schools/courses/inc/publish-form") ?>
                </form>
            </div>
        </div>
    </div>
</div>
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
                    toastr["success"]("Saved Successfully");
                    setTimeout(() => {
                        location.href = "<?= base_url("" . $activeLanguage . "/schools/courses") ?>"
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