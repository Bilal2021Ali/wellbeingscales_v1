<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
</head>
<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .centered .card {
        border: 0px;
        border-radius: 20px;
    }

    .centered .card img {
        width: 100px;
        float: left;
        position: absolute;
        top: -11px;
        left: 7px;
    }

    .card-body.border-ronded {
        border-radius: 6px;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="col-lg-8 offset-lg-1 centered">
                    <a href="<?= base_url("EN/schools/add_visitor/" . $id . "/teacher"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--cyan);">
                                <img src="<?= base_url("assets/images/icons/teachers.png") ?>" alt="">
                                <h4 class="text-white">Teachers <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url("EN/schools/add_visitor/" . $id . "/staff"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--red);">
                                <img src="<?= base_url("assets/images/icons/Staffs.png") ?>" alt="">
                                <h4 class="text-white">Staff <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url("EN/schools/add_visitor/" . $id . "/student"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--purple);">
                                <img src="<?= base_url("assets/images/icons/Students.png") ?>" alt="">
                                <h4 class="text-white">Students <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
</body>
<script>
    $("#AddMember").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/startAddStaff',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Success',
                        text: 'Everything looks good. Thank you! ',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    $('#Toast').html(data.message);
                    $('#staffsub').removeAttr('disabled');
                    $('#staffsub').html('Submit !');
                }
            },
            beforeSend: function() {
                $('#staffsub').attr('disabled', '');
                $('#staffsub').html('Please wait.');
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
</script>

</html>