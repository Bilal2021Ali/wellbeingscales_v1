<div class="main-content">
    <div class="page-content">

        <div class="modal fade showthedesc" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= __("student-complaint") ?>:</h5>
                        <button type="button" class="btn btn-light btn-rounded waves-effect" data-dismiss="modal"
                                aria-label="Close">x
                        </button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <br>
        <?php $this->load->view("Shared/Education/speak-out-list") ?>
    </div>
</div>

<script>
    $('.table').DataTable();

    $(".table").on('click', ".readmore", function () {
        var id = $(this).attr('data-report-id');
        var language = $(this).attr('data-lang');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                id: id,
                for: "description",
                lang: language
            },
            success: function (response) {
                if (response.status == "ok") {
                    $('.showthedesc .modal-body').html('<p>' + response.description + '</p>');
                }
            }
        });
    });


    $(".table").on('click', ".closereport", function () {
        var id = $(this).attr('data-id');
        var $this = $(this);
        Swal.fire({
            title: 'Are you sure you want to close the complaint?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Yes`,
            cancelButtonText: `No`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= current_url(); ?>",
                    data: {
                        id: id,
                        for: "close",
                    },
                    success: function (response) {
                        if (response.status == "ok") {
                            $($this).attr('disabled', "");
                            $('.status-box-' + id).html("Approved");
                            $('.status-box-' + id).addClass("bg-success");
                            Swal.fire({
                                title: 'Success!',
                                text: 'Report has been closed successfully',
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            Swal.fire({
                                title: 'sorry!',
                                text: 'we have unexpected errors',
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    });
</script>