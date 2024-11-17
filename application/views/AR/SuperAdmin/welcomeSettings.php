<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <span class="uil uil-plus btn btn-success float-right add"> ADD</span>
        <div class="row">
            <?php foreach ($links as $link) { ?>
                <div class="col-lg-4 link-<?= $link['id'] ?>">
                    <div class="product-box bg-white" style="padding-bottom: 10px;">
                        <i class="uil uil-trash m-2 text-danger delete" data-link-key="<?= $link['id'] ?>"></i>
                        <div class="product-img pt-4 px-4">
                            <img src="<?= base_url("assets/images/" . $link["img"]); ?>" alt="" class="img-fluid mx-auto d-block">
                        </div>
                        <div class="text-center product-content p-4">
                            <h5 class="mt-3 mb-0"><span class="text-muted mr-2 ar"><?= $link["title"] ?></span></h5>
                            <ul class="list-inline mb-0 text-muted product-color">
                                <a href="<?= base_url("" . $link["link"] . "/Users"); ?>" class="btn btn-primary btn-rounded waves-effect waves-light"><?= $link["action"] ?></a>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnew" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="addnew">Add a new one :</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Title : </label>
                <input type="text" name="title" placeholder="..." class="form-control">
                <label for="thumb_img" class="w-100 btn btn-primary mt-2">
                    Select an image
                    <input id="thumb_img" name="img" type="file" accept="image/*" hidden>
                </label>
                <label>Language : </label>
                <input type="text" name="language" placeholder="The language code (E.g : en)" class="form-control">
                <label>Action : </label>
                <input type="text" name="action" placeholder="The Text on the button" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
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
    $('.add').click(() => {
        $('#addnew').modal('toggle');
    });
    $("#addnew form").on('submit', function(e) {
        e.preventDefault();
        $("#addnew form button[type='submit']").attr('disabled', 'disabled');
        $("#addnew form button[type='submit']").html('Please wait...');
        $.ajax({
            type: "POST",
            url: "<?= current_url() ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $("#addnew form button[type='submit']").removeAttr('disabled');
                $("#addnew form button[type='submit']").html('Save');
                if (response.status == "ok") {
                    Command: toastr["success"]("The data has been saved successfully")
                    $('#addnew').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 600);
                }
                else {
                    Command: toastr["error"]("Please check your inputs and try again");
                }
            }
        });
    });
    $('.row').on('click', '.delete', function(e) {
        var key = $(this).attr("data-link-key");
        Swal.fire({
            title: 'هل أنت متأكد',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `نعم`,
            cancelButtonText: `إلغاء`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url() ?>/" + key,
                    success: function(response) {
                        if (response.status == "ok") {
                            Command: toastr["success"]("The data has been deleted successfully")
                            $('.link-' + key).remove();
                        }else{
                            Command: toastr["error"]("Sorry we have unexpected error. Please try again later.");
                        }
                    }
                });
            }
        })
    });
</script>