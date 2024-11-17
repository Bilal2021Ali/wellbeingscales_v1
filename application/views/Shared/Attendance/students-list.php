<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<?php use Types\AttendanceRecord; ?>
<div class="main-content">
    <div class="page-content">
        <?php $this->load->view("Shared/Attendance/inc/counters") ?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("data-for") . " " . date("Y-m-d") ?></h3>
                <hr class="mb-4">
                <div class="row">
                    <?php /** @var array<AttendanceRecord> $results */ ?>
                    <?php foreach ($results as $item) { ?>
                        <?php $this->load->view("Shared/Attendance/inc/result-card", ['result' => $item]); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<?php /*
<script>
    $('.btn-outline-success').click(function () {
        var userId = $(this).data('user-id');
        var device = $(this).data('device');
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/schools/attendees-actions/present") ?>",
            data: {userId, device},
            success: function (response) {
                if (response === "ok") {
                    // console.log($($this).parent(".card-body").children().first('.btn-outline-warning').addClass('btn-warning').html());
                    console.log("Done");
                    // notification
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
                    Command: toastr["success"]("Status updated successfully")
                } else {
                    console.log("error");
                    // notification
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
                    Command: toastr["error"]("Sorry we have an error !! Please try again later")
                }
            }
        });
    });
    $('.btn-outline-danger').click(function () {
        var userId = $(this).data('user-id');
        var device = $(this).data('device');
        Swal.fire({
            title: '<?= $messages[9]['message_en'] ?>',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes`,
            cancelButtonText: `No`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url("EN/schools/attendees-actions/absent") ?>",
                    data: {userId, device},
                    success: function (response) {
                        if (response == "ok") {
                            // console.log($($this).parent(".card-body").children().first('.btn-outline-warning').addClass('btn-warning').html());
                            console.log("Done");
                            // notification
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
                            Command: toastr["success"]("Status updated successfully")
                        } else {
                            console.log("error");
                            // notification
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
                            Command: toastr["error"]("Sorry we have an error !! Please try again later")
                        }
                    }
                });
            }
        });
    });
</script>
 */ ?>