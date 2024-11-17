<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url() ?>assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
</head>
<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #A2A2A2;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #27AD00;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #27AD00;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<style>
    .card {
        border: 0px;
    }

    .notfOUND img {
        width: 500px;
        max-width: 100%;
    }

    .userData,
    .userData div {
        height: 90%;
    }

    /* .__userData .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: auto;
        } */

    .table-nowrap th,
    .table-nowrap td {
        border: 0px;
    }

    .td_Icon {
        font-size: 35px;
    }

    .hr {
        border-top: 1px solid #eee;
    }

    tr {
        cursor: default;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <?php
                if (!empty($user_data)) {
                    $user = $user_data[0];
                ?>
                    <div class="row userData">
                        <div class="col-lg-6 justify-content-center">
                            <div class="card" data-simplebar="init">
                                <div class="card-body __userData">
                                    <h3>Permissions</h3>
                                    <div class="center">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-centered">
                                                <tbody>
                                                    <tr>
                                                        <td class="td_Icon">
                                                            <i class="uil uil-cloud-wind"></i>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-size-16 mb-1">Air Quality</h5>
                                                            <p class="text-muted mb-2">For Air Quality Dashboard</p>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" Perm="Air_quality" class="give_permission" <?= $user['Air_quality'] ? 'checked' : "" ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr class="hr">
                                                        <td class="td_Icon">
                                                            <i class="uil uil-clipboard-alt"></i>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-size-16 mb-1">Surveys</h5>
                                                            <p class="text-muted mb-2">For Creating and Showing of Results </p>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" Perm="surveys" class="give_permission" <?= $user['surveys'] ? 'checked' : "" ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <?php if ($user['Type']  == "Ministry") :  ?>
                                                        <tr class="hr">
                                                            <td class="td_Icon">
                                                                <i class="uil uil-cloud-upload"></i>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-16 mb-1">Load From CSV</h5>
                                                                <p class="text-muted mb-2">For loading users from CSV files</p>
                                                            </td>
                                                            <td>
                                                                <label class="switch">
                                                                    <input type="checkbox" Perm="LoadFromCsv" class="give_permission" <?= $user['LoadFromCsv'] ? 'checked' : "" ?>>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr class="hr">
                                                            <td class="td_Icon">
                                                                <i class="uil uil-heart-rate"></i>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-16 mb-1">Temperature &amp; Lab tests</h5>
                                                                <p class="text-muted mb-2">To see and enter users Temperature and lab results</p>
                                                            </td>
                                                            <td>
                                                                <label class="switch">
                                                                    <input type="checkbox" Perm="TemperatureAndLab" class="give_permission" <?= $user['TemperatureAndLab'] ? 'checked' : "" ?>>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <?php endif;  ?>
                                                        <tr class="hr">
                                                            <td class="td_Icon">
                                                                <i class="uil uil-grin"></i>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-16 mb-1">Climate Surveys</h5>
                                                                <p class="text-muted mb-2">Creat And Manage Climate surveys</p>
                                                            </td>
                                                            <td>
                                                                <label class="switch">
                                                                    <input type="checkbox" Perm="CLIMATE" class="give_permission" <?= $user['CLIMATE'] ? 'checked' : "" ?>>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    <tr class="hr">
                                                        <td class="td_Icon">
                                                            <i class="uil uil-users-alt"></i>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-size-16 mb-1">Visitors</h5>
                                                            <p class="text-muted mb-2">For Adding and Showing all visitors </p>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" Perm="visitors" class="give_permission" <?= $user['visitors'] ? 'checked' : "" ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <?php if ($user['Type']  == "Ministry") :  ?>
                                                        <tr class="hr">
                                                            <td class="td_Icon">
                                                                <i class="uil uil-car"></i>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-16 mb-1">Vehicles</h5>
                                                                <p class="text-muted mb-2">For School Driving Cars</p>
                                                            </td>
                                                            <td>
                                                                <label class="switch">
                                                                    <input type="checkbox" Perm="cars" class="give_permission" <?= $user['cars'] ? 'checked' : "" ?>>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 justify-content-center">
                            <div class="card ">
                                <div class="card-body text-center __userData" style="display: grid;align-items: center;">
                                    <div class="center" style="height: auto;"> <img src="<?= base_url() . "uploads/avatars/" . $user['Link'] ?>" alt="" class="rounded-circle img-thumbnail avatar-lg">
                                        <h3 class="text-primary">
                                            <?= $user['EN_Title']  ?>
                                        </h3>
                                        <h5><?= $user['Type']  ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    //End seted user_data 
                } else {
                ?>
                    <div class="row notfOUND">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body"> <img src="<?= base_url() ?>assets/images/notFoundPermition.svg" alt="">
                                    <div class="col-lg-12">
                                        <h3 class="mt-4">No data Found For This User</h3>
                                        <button class="btn btn-primary btn-rounded waves-effect waves-light">Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }  ?>
            </div>
        </div>
    </div>
</body>
<script src="<?= base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script>
    $('.give_permission').each(function() {
        $(this).change(function() {
            var perm = $(this).attr('Perm');
            var status = $(this).val();
            changeThePermission(perm);
        });
    });


    function changeThePermission(perm) {
        $.ajax({
            type: 'POST',
            data: {
                permType: perm,
                User: '<?= $User_id  ?>',
                user_type: '<?= $user['Type']  ?>'
            },
            url: '<?= base_url(); ?>EN/Dashboard/Permissions_edite',
            success: function(data) {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 300,
                    "timeOut": 3000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "slideDown",
                    "hideMethod": "fadeOut"
                }
                Command: toastr["success"](data, "success")
            }
        });
    }
</script>

</html>