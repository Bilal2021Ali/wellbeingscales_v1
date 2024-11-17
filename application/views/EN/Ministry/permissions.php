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
                                <h5 class="rounded p-3 mb-2 bg-danger text-white">School Permissions <span
                                            class="float-right">STATUS</span>
                                </h5>

                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-centered">
                                            <tbody>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success rounded text-white">Load from
                                                        CSV</h5>

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
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Users
                                                        counters</h5>

                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_counters"
                                                               class="give_permission" <?= $user['users_counters'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Wellbeing</h5>

                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_wellbeing"
                                                               class="give_permission" <?= $user['users_wellbeing'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <?php /*?><tr class="hr">
                                                        <td class="td_Icon">
                                                            <i class="uil uil-clipboard-alt"></i>
                                                        </td>
                                                        <td>
                                                            <h5 class="rounded p-3 mb-2 bg-success text-white">Dashboard - Wellbeing User Type</h5>
                                                            
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" Perm="users_wellbeing_type" class="give_permission" <?= $user['users_wellbeing_type'] ? 'checked' : "" ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr><?php */ ?>
                                            <?php /*?><tr class="hr">
                                                        <td class="td_Icon">
                                                            <i class="uil uil-clipboard-alt"></i>
                                                        </td>
                                                        <td>
                                                            <h5 class="rounded p-3 mb-2 bg-primary text-white">Dashboard - Climate</h5>
                                                            
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" Perm="users_climate" class="give_permission" <?= $user['users_climate'] ? 'checked' : "" ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr><?php */ ?>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Speak out</h5>

                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_speak_out"
                                                               class="give_permission" <?= $user['users_speak_out'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Daily temperature
                                                        counter</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_daily_temperature"
                                                               class="give_permission" <?= $user['users_daily_temperature'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Daily lab
                                                        tests</h5>

                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_daily_labtests"
                                                               class="give_permission" <?= $user['users_daily_labtests'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Home quarantine
                                                        and quarantine counter</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_home_quarantine"
                                                               class="give_permission" <?= $user['users_home_quarantine'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Daily temperature
                                                        diagram</h5>

                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_temperature_diagram"
                                                               class="give_permission" <?= $user['users_temperature_diagram'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">School, classes
                                                        absent counters</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_classes_counters"
                                                               class="give_permission" <?= $user['users_classes_counters'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Daily datatable
                                                        for test Students</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_daily_data_table_student"
                                                               class="give_permission" <?= $user['users_daily_data_table_student'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Daily datatable
                                                        for test Staff</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_daily_data_table_staff"
                                                               class="give_permission" <?= $user['users_daily_data_table_staff'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Daily datatable
                                                        for test teachers</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_daily_data_table_teacher"
                                                               class="give_permission" <?= $user['users_daily_data_table_teacher'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Stay home
                                                        datatable for tests</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_stay_home"
                                                               class="give_permission" <?= $user['users_stay_home'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Quarantine
                                                        datatable for tests</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_quarantine"
                                                               class="give_permission" <?= $user['users_quarantine'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Daily datatable
                                                        for test Sites</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_tests_sites"
                                                               class="give_permission" <?= $user['users_tests_sites'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Closed sites
                                                        (Sterilization) Today</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_sterilization"
                                                               class="give_permission" <?= $user['users_sterilization'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">Closed Sites
                                                        (Sterilization) History</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="users_sterilization_history"
                                                               class="give_permission" <?= $user['users_sterilization_history'] ? 'checked' : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr class="hr">
                                                <td class="td_Icon">
                                                    <i class="uil uil-clipboard-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">QM community</h5>
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
                                                    <i class="uil uil-bolt-alt"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-success text-white">Incidents</h5>
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
                                                    <i class="uil uil-user-exclamation"></i>
                                                </td>
                                                <td>
                                                    <h5 class="rounded p-3 mb-2 bg-primary text-white">ATTENDANCE</h5>
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" Perm="attendance"
                                                               class="give_permission" <?= $user['attendance'] ? 'checked' : "" ?>>
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
                    </div>
                    <div class="col-lg-6 justify-content-center">
                        <div class="card ">

                            <div class="card-body text-center __userData" style="display: grid;align-items: center;">
                                <h5 class="rounded p-3 mb-2 bg-danger text-white"><?= $user['School_Name_EN'] ?></h5>
                                <div class="" style="height: auto;"><img
                                            src="<?= base_url() . "uploads/avatars/" . $user['Link'] ?>" alt=""
                                            class="rounded-circle img-thumbnail avatar-lg">
                                    <h3 class="text-primary">
                                        <?= $user['School_Name_EN'] ?>
                                    </h3>
                                    <h5><?= ucfirst($User_type) ?></h5>
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
                                    <h3 class="mt-4">No data found for this user</h3>
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
                user_type: '<?= $User_type ?>'
            },
            url: '<?= base_url(); ?>EN/DashboardSystem/permissions',
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
                toastr["success"](data, "success")
            }
        });
    }
</script>

</html>