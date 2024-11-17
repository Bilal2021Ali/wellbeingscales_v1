<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <style>
        .footer {
            width: 100%;
            left: 0px !important;
        }
    </style>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card notstatic">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome "<?= $user_data['name_en'] ?? $sessiondata['username']; ?>" !</h5>
                                <p class="text-muted">Please provide the following pieces of information to use your account.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <div class="alert alert-danger" role="alert" style="display: none;"></div>
                                <form id="Register">
                                    <div class="form-group">
                                        <label for="name_en">Name EN</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" value="<?= $user_data['name_en'] ?? ""; ?>" placeholder="Name EN" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="name_ar">Name AR</label>
                                        <input type="text" class="form-control" id="name_ar" name="name_ar" value="<?= $user_data['name_ar'] ?? ""; ?>" placeholder="Name AR" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="DOP">Date of Birth</label>
                                        <input type="text" id="DOP" name="DOP" class="form-control" value="<?= $user_data['DOP'] ?? ""; ?>" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Date of birth">
                                    </div>
                                    <?php if(isset($user_data)) { ?>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="M" <?= $user_data['gender'] == 'M' ? 'selected' : ''  ?> >Male</option>
                                                <option value="F" <?= $user_data['gender'] == 'F' ? 'selected' : ''  ?> >Female</option>
                                            </select>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>
                                    <?php } ?>
                                    <!-- 2021-02-01 -->
                                    <div class="mt-3 text-right">
                                        <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
    <script>
        $("#Register").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo current_url(); ?>',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.alert').slideUp();
                    $('button').attr('disabled', '');
                    $('button').html("Please wait...");
                },
                success: function(data) {
                    if (data !== "ok") {
                        $('.alert').slideDown();
                        $('.alert').html(data);
                        $('button').removeAttr('disabled', '');
                        $('button').html("Save");
                    } else {
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('.alert').html('success , Thank you for your time.');
                        location.href = "<?php echo base_url("EN/Parents"); ?>";
                    }
                },
                ajaxError: function() {
                    $('.alert').css('background-color', '#DB0404');
                    $('.alert').html("Ooops! Error was found.");
                }
            });
        });
    </script>
</body>

</html>