<link rel="stylesheet" type="text/css" href="<?= base_url('assets/libs/toastr/build/toastr.min.css'); ?>">
<style>
    .loading {
        position: absolute;
        display: flex;
        align-items: center;
        width: 100%;
        height: 100%;
        text-align: center;
        background: #fff;
        z-index: 1000;
    }
</style>
<div class="main-content">
    <div class="page-content">
	<br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CO026: Library messages system </h4>
        <div class="col-xl-6 ">
            <form class="card needs-validation" novalidate>
                <div class="loading">
                    <div class="spinner-border text-info m-auto" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
				
                <div class="card-body">
                    <h3 class="card-title mb-2">Add a New Message : r_messages</h3>
                    <p>Add a new message to your library​</p>
                    <hr>
                    <div>
                        <label for="validationTooltip01">Message EN:</label>
                        <textarea name="messageen" id="validationTooltip01" data-parsley-min="6" data-parsley-max="1000" class="form-control mb-3" required placeholder="Messsage EN"></textarea>
                        <div class="valid-tooltip">Looks good!</div>
                    </div>
                    <div>
                        <label for="validationTooltip02">Message AR:</label>
                        <textarea name="messagear" id="validationTooltip02" data-parsley-min="6" data-parsley-max="1000" class="form-control" required placeholder="Messsage AR"></textarea>
                        <div class="valid-tooltip">Looks good!</div>
                    </div>
                    <label class="mt-2">Status:</label>
                    <select name="status" class="form-control">
                        <option value="0">Private</option>
                        <option value="1">Public</option>
                    </select>
                    <button type="submit" class="btn btn-primary waves-effect waves-light w-100 mt-2">
                        Add <i class="uil uil-users ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/parsleyjs/parsley.min.js') ?>"></script>
<script src="<?= base_url('assets/js/pages/form-validation.init.js') ?>"></script>
<script src="<?= base_url('assets/libs/toastr/build/toastr.min.js') ?>"></script>
<script>
    $('.loading').hide();
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
    $('form').submit(function (e) {   
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/ajax/SaveMessage"); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('.loading').hide();
                if (response.status == "ok") {
                    Command: toastr["success"]("Message Saved Successfully");
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }else{
                    Command: toastr["error"](response.message)
                }
            }
        });
    });
</script>