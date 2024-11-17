<link rel="stylesheet" type="text/css" href="<?= base_url('assets/libs/toastr/build/toastr.min.css') ?>">

<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 005: Add material study for teachers</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" class="col-md-12">
                        <form id="addPosition" class="custom-validation">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="n_en">Name EN :</label>
                                            <input type="text" class="form-control" data-parsley-minlength="3" data-parsley-maxlength="200" id="n_en" placeholder="Please Enter The EN name..." name="name_en" required="">
                                            <div class="valid-feedback"> Looks good! </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="n_ar">Name AR :</label>
                                            <input type="text" class="form-control" data-parsley-minlength="3" data-parsley-maxlength="200" id="n_ar" placeholder="Please Enter The AR name..." name="name_ar" required="">
                                            <div class="valid-feedback"> Looks good! </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 10px;">
                                    <button class="btn btn-primary" type="Submit">Submit form</button>
                                    <a href="<?= base_url('EN/Dashboard/') ?>"><button type="button" class="btn btn-light">Cancel</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/parsleyjs/parsley.min.js"); ?>"></script>
<script src="<?= base_url("assets/js/pages/form-validation.init.js"); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js"); ?>"></script>
<script>
    $('.custom-validation').parsley();
    $("#addPosition").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url("EN/Dashboard/add_material_study"); ?>',
            data: new FormData(this),
            contentType: false, //and this
            processData: false, //add this
            success: function(data) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 8000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                Command: toastr[data.status](data.message);
                if (data.status == "success") {
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });
</script>