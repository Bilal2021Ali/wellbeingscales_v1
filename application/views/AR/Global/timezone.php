<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/libs/toastr/build/toastr.min.css') ?>">

<div class="account-pages my-5  pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <form class="card-body p-4 text-center updateTimeZone">
                        <h5 class="text-primary"> Update Your Time Zone </h5>
                        <p class="mb-5"><small>Please fill the inputs bellow , you can also let it empty if you want to !</small></p>
                        <label class="float-left">Time Zone H :</label>
                        <input class="form-control mb-2" name="h" value="<?= $dafault->zone_time_h ?>" type="number">
                        <label class="float-left">Time Zone M :</label>
                        <input class="form-control" name="M" value="<?= $dafault->zone_time_m ?>" type="number">
                        <button class="btn btn-primary mt-2 w-100" type="submit">Save</button>
                        <a href="<?= base_url('EN/') . $homescreen ?>" class="btn btn-white w-100">back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/sweetalert2/sweetalert2.min.js"); ?>"></script>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $("form.card-body.updateTimeZone").on('submit', function(e) {
        $('button[type="submit"]').attr('disabled', '');
        $('button[type="submit"]').html('Loading...');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').html('Save');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'Done !',
                        text: 'The data was updated successfully.',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.href = "<?= base_url('EN/') . $homescreen ?>";
                    }, 1000);
                } else {
                    Command: toastr["error"]("We have an error : " + response.message)
                }
            }
        });
    });
</script>