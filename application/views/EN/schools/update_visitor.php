<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .alert p {
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <form id="add_visitor" class="card">
                        <div class="card-body">
                            <div class="alert alert-success" role="alert" style="display: none;"></div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name"> name </label>
                                        <input type="text" class="form-control" placeholder="name" id="name" name="Name" value="<?php echo isset($user_data[0]) ? $user_data[0]['full_name'] : "" ?>">
                                        <div class="valid-feedback">
                                            looks good
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="National_Id"> National Id </label>
                                        <input type="text" class="form-control" placeholder="National Id" id="National_Id" name="National_Id" value="<?php echo isset($user_data[0]) ? $user_data[0]['National_Id'] : "" ?>">
                                        <div class="valid-feedback">
                                            looks good
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="DOP"> Date of birth </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" name="DOP" id="DOP" value="<?php echo isset($user_data[0]) ? $user_data[0]['DOP'] : "" ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2">
                                <button class="btn btn-primary btn-lg waves-effect waves-light" type="Submit"><?php echo isset($user_data[0]) ? "update" : "add" ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
    $("#add_visitor").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/update_visitor<?php echo isset($user_data[0]) ? '?visitor_key=' . $user_data[0]['user_id']  : "" ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.alert').slideDown();
                $('.alert').html('Please wait....');
                $('.btn[type="Submit"]').attr('disabled', '');
                $('.btn[type="Submit"]').html("please wait ....");
            },
            success: function(data) {
                if (data == 'ok') {
                    $('.alert').html('success !!');
                    $('.btn[type="Submit"]').removeAttr('disabled');
                    $('.btn[type="Submit"]').html("<?php echo isset($user_data[0]) ? "update" : "add" ?>");
                    setTimeout(() => {
                        location.href = "<?php echo base_url("EN/schools/visitor_report"); ?>";
                    }, 800);
                } else {
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.alert').html(data);
                    $('.btn[type="Submit"]').removeAttr('disabled');
                    $('.btn[type="Submit"]').html("<?php echo isset($user_data[0]) ? "update" : "add" ?>");
                }
            },
            ajaxError: function() {
                $('.alert').html("Ooops! Error was found.");
            }
        });
    });
</script>

</html>