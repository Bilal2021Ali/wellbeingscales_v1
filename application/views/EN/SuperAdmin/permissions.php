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

    input:checked + .slider {
        background-color: #27AD00;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #27AD00;
    }

    input:checked + .slider:before {
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
        <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;"> 0005:
            Permissions </h4>
        <div class="container-fluid">
            <?php
            if (!empty($user_data)) {
                $user = $user_data[0]; ?>
                <div class="row userData">
                    <div class="col-lg-6 justify-content-center">
                        <div class="card" data-simplebar="init">
                            <div class="card-body __userData">
                                <h4 class="card-title"
                                    style="background: #add138; text-align: center; padding: 10px;color: #ffffff;border-radius: 4px;">
                                    Services </h4>
                                <div class="center">
                                    <table class="table table-nowrap table-centered">
                                        <tbody>
                                        <tr>
                                            <td class="td_Icon">
                                                <i class="uil uil-cloud-wind"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">AIR QUALITY</h5>
                                                <p class="text-muted mb-2">For Air Quality Dashboard</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="Air_quality"
                                                           class="give_permission" <?= $user['Air_quality'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-clipboard-alt"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">SURVEYS</h5>
                                                <p class="text-muted mb-2">For Creating and Showing of Results </p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="surveys"
                                                           class="give_permission" <?= $user['surveys'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-grin"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">CLIMATES</h5>
                                                <p class="text-muted mb-2">For Creating and Managing Climate</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="Claimate"
                                                           class="give_permission" <?= $user['Claimate'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-cloud-upload"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">CSV</h5>
                                                <p class="text-muted mb-2">For Import Users from CSV Files</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="LoadFromCsv"
                                                           class="give_permission" <?= $user['LoadFromCsv'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-heart-rate"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">TEMPERATURES &amp; LAB TESTS</h5>
                                                <p class="text-muted mb-2">For Monitoring and Entering of User <br>Temperature
                                                    and Lab Results</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="TemperatureAndLab"
                                                           class="give_permission" <?= $user['TemperatureAndLab'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-car"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">VEHICLES</h5>
                                                <p class="text-muted mb-2">For School Driving Cars</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="cars"
                                                           class="give_permission" <?= $user['cars'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-user-exclamation"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">ATTENDANCE</h5>
                                                <p class="text-muted mb-2">save attendance records fro users</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="attendance"
                                                           class="give_permission" <?= $user['attendance'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-user-exclamation"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">QM Community</h5>
                                                <p class="text-muted mb-2">Take And Save Community Tests Results</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="qmcommunity"
                                                           class="give_permission" <?= $user['qmcommunity'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-focus-add"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Smart QR</h5>
                                                <p class="text-muted mb-2">Smart Qr Generator</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="smart_qr_code"
                                                           class="give_permission" <?= $user['smart_qr_code'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-home"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Stay Home Counter</h5>
                                                <p class="text-muted mb-2">Results About Stay Home From Schools</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="stay_home_counters"
                                                           class="give_permission" <?= $user['stay_home_counters'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-temperature"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Quarantine Counter</h5>
                                                <p class="text-muted mb-2">Results About Quarantine From Schools</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="quarantine_counters"
                                                           class="give_permission" <?= $user['quarantine_counters'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-temperature"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Speak Out</h5>
                                                <p class="text-muted mb-2">Speak Out Reports</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="speak_out"
                                                           class="give_permission" <?= $user['speak_out'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-bolt-alt"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Incidents</h5>
                                                <p class="text-muted mb-2">Managing Incidents</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="incidents"
                                                           class="give_permission" <?= $user['incidents'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-home"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Dashboard</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="dashboard"
                                                           class="give_permission" <?= $user['dashboard'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-user"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Profile</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="profile"
                                                           class="give_permission" <?= $user['profile'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Adding Schools</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="schoollist"
                                                           class="give_permission" <?= $user['schoollist'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Schools List</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="schoollist"
                                                           class="give_permission" <?= $user['schoollist'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Wellbeing Reports</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="categories"
                                                           class="give_permission" <?= $user['categories'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Site Reports</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="sitereports"
                                                           class="give_permission" <?= $user['sitereports'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Reports</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="aireports"
                                                           class="give_permission" <?= $user['aireports'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Lab Reports</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="labreports"
                                                           class="give_permission" <?= $user['labreports'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Consultants</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="counselor"
                                                           class="give_permission" <?= $user['counselor'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Controllers</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="controllers"
                                                           class="give_permission" <?= $user['controllers'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr class="hr">
                                            <td class="td_Icon">
                                                <i class="uil uil-school"></i>
                                            </td>
                                            <td>
                                                <h5 class="font-size-16 mb-1">Courses</h5>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" Perm="courses"
                                                           class="give_permission" <?= $user['courses'] ? 'checked' : "" ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 justify-content-center">
                        <div class="card ">

                            <div class="card-body text-center __userData" style="display: grid;align-items: center;">
                                <h4 class="card-title"
                                    style="background: #add138; text-align: center; padding: 10px;color: #ffffff;border-radius: 4px;"> <?= $user['EN_Title'] ?> </h4>
                                <div class="center" style="height: auto;"><img
                                            src="<?= base_url() . "uploads/avatars/" . $user['Link'] ?>" alt=""
                                            class="rounded-circle img-thumbnail avatar-lg">
                                    <h3 class="text-primary">
                                        <br>
                                        <?= $user['EN_Title'] ?><br><br>
                                        <?= $user['AR_Title'] ?>
                                    </h3>
                                    <br>
                                    <h4 class="card-title"
                                        style="background: #0eacd8; text-align: center; padding: 10px;color: #ffffff;border-radius: 4px;"> <?= $user['Type'] ?> </h4>
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
                            <div class="card-body"><img src="<?= base_url() ?>assets/images/notFoundPermition.svg"
                                                        alt="">
                                <div class="col-lg-12">
                                    <h3 class="mt-4">No data Found For This User</h3>
                                    <button class="btn btn-primary btn-rounded waves-effect waves-light">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
<script src="<?= base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script>
    $('.give_permission').each(function () {
        $(this).change(function () {
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
            url: '<?= base_url("EN/Dashboard/Permissions-edite"); ?>',
            success: function (data) {
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
                toastr["success"](data, "Success")
            }
        });
    }
</script>

</html>