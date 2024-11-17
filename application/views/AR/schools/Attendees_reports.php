<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<link href="<?= base_url('assets/libs/select2/css/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .btn-rounded {
        padding: 5px 11px;
    }

    .nav-link {
        cursor: pointer;
    }

    .topcards .card {
        width: 19%;
        margin-right: 10px;
        background-size: cover !important;
        color: #fff;
        border: 0px;
        padding: 10px 0px;
    }

    .topcards .card:first-of-type {
        margin-left: 5px;
    }

    .topcards .card:last-of-type {
        margin-right: 0px;
    }

    .results .card {
        border-radius: 20%;
        box-shadow: 0px 4px 3px 1px rgb(0 0 0 / 10%);
        border: 0px;
        background-color: hsl(40deg 23% 97%);
    }

    .card .col-6.text-right {
        padding: 0px;
    }

    .avatar-lg {
        border: 1px solid #0eacd8;
    }

    .link,
    .staffs {
        font-weight: bold;
        cursor: pointer;
        color: #000;
        text-decoration: underline;
    }

    .modal-body {
        max-height: 330px;
        overflow: auto;
    }
</style>
<div class='main-content'>

    <div class='page-content'>
        <br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 046: الحضور حسب السيارة</h4>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?= current_url(); ?>" class="row">
                        <div class="col-lg-6">
                            <label for="">التاريخ </label>
                            <input type="text" class="form-control text-center" name="attendees_date" value="<?= $attendees_date; ?>" placeholder="Date" data-date-format="yyyy-mm-dd" data-provide="datepicker">
                        </div>
                        <div class="col-lg-6">
							<label class="form-label">اختر السيارة:</label>
							<select class="form-control select2" name="vichelid">
								<?php foreach ($Vehicles as $Vehicle) { ?>
									<?php 
										// Determine font color based on absence of related data
										$fontColor = ($Vehicle['driver_count'] == 0 && $Vehicle['helper_count'] == 0) ? 'red' : 'black';
									?>
									<option value="<?= $Vehicle['Id'] ?>" style="color: <?= $fontColor ?>" <?= $Vehicle['Id'] == $activevichel ? "selected" : ""; ?>>
										<?= $Vehicle['No_vehicle'] ?>
									</option>
								<?php } ?>
							</select>
						</div>
                        <div class="col-12">
                            <button class="btn btn-outline-success waves-effect waves-light mt-1 w-100" type="submit">تحديث المعلومات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if (!empty($data)) { ?>
            <div class="container">
                <div class="modal fade busTeachers" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 1px solid rgb(0 0 0 / 9%);">
                                <h5 class="modal-title">سائق الباص</h5>
                                <span type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> إغلاق </span>
                            </div>
                            <div class="modal-body Drivers"></div>
                        </div>
                    </div>
                </div>
                <div class="modal fade SubervisorsList" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 1px solid rgb(0 0 0 / 9%);">
                                <h5 class="modal-title">مشرف</h5>
                                <span type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> إغلاق </span>
                            </div>
                            <div class="modal-body Subervisors"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="row">
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mr-2">ح</button>
                                    حاضر
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light mr-2">غ</button>
                                    غائب
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-warning btn-rounded waves-effect waves-light mr-2">م</button>
                                    متأخر
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="row topcards">
                        <div class="card col-xs-6" style="background: url(<?= base_url("assets/images/attendees/01.png"); ?>);">
                            <div class="card-body row">
                                <div class="col-6 text-right">
                                    <img src="<?= base_url("assets/images/attendees/Bus.png"); ?>" class="img-responsive w-100" alt="" srcset="">
                                </div>
                                <div class="col-6 text-left">
                                    رقم الحافلة: <br>
                                    (<?= $Vehicle_data[0]['No_vehicle'] ?? "--" ?>)
                                </div>
                            </div>
                        </div>
                        <div class="card" style="background: url(<?= base_url("assets/images/attendees/02.png"); ?>);">
                            <div class="card-body row">
                                <div class="col-6 text-right">
                                    <img src="<?= base_url("assets/images/attendees/Driver.png"); ?>" class="img-responsive w-100" alt="" srcset="">
                                </div>
                                <div class="col-6 text-left">
                                    --
                                </div>
                            </div>
                        </div>
                        <div class="card" style="background: url(<?= base_url("assets/images/attendees/03.png"); ?>);">
                            <div class="card-body row">
                                <div class="col-6 text-right">
                                    <img src="<?= base_url("assets/images/attendees/Subervisor.png"); ?>" class="img-responsive w-100" alt="" srcset="">
                                </div>
                                <div class="col-6 text-left">
                                    مشرف
                                    --
                                </div>
                            </div>
                        </div>
                        <div class="card" style="background: url(<?= base_url("assets/images/attendees/04.png"); ?>);">
                            <div class="card-body row">
                                <div class="col-6 text-right">
                                    <img src="<?= base_url("assets/images/attendees/Students.png"); ?>" class="img-responsive w-100" alt="" srcset="">
                                </div>
                                <div class="col-6 text-left">
                                    حاضر:
                                    <span id="presentCounter">0</span>/<?= $countall; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="background: url(<?= base_url("assets/images/attendees/05.png"); ?>);">
                            <div class="card-body row">
                                <div class="col-6 text-right">
                                    <img src="<?= base_url("assets/images/attendees/Students.png"); ?>" class="img-responsive w-100" alt="" srcset="">
                                </div>
                                <div class="col-6 text-left">
                                    غائب:
                                    <span id="absentCounter">0</span>/<?= $countall; ?>
                                    متأخر:
                                    --/<?= $countall; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card results">
                    <div class="card-body">
                        <h4 class="card-title">بيانات عن : <?= $attendees_date ?></h4>
                        <hr>
                        <div class="tab-content p-3 text-muted">
                            <div class="row">
                                <?php foreach ($data['Student'] as $student) { ?>
                                    <div class="col-xl-3 col-sm-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <img src="<?= base_url("uploads/avatars/" . ($student['avatar'] ?? "default_avatar.jpg")); ?>" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                                </div>
                                                <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $student['username'] ?></a></h5>
                                                <hr>
                                                <?php if ($student['Attendees_status'] == "present") { ?>
                                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-user-id="<?= $student['userid'] ?>" data-user-device="<?= $student['Device'] ?>" data-user-type="Student">ح</button>
                                                    <button type="button" class="btn btn-outline-danger btn-rounded waves-effect waves-light" data-user-id="<?= $student['userid'] ?>" data-user-device="<?= $student['Device'] ?>" data-user-type="Student">غ</button>
                                                    <button type="button" class="btn btn-outline-warning btn-rounded waves-effect waves-light" data-user-id="<?= $student['userid'] ?>" data-user-device="<?= $student['Device'] ?>" data-user-type="Student">م</button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-outline-success btn-rounded waves-effect waves-light" data-user-id="<?= $student['userid'] ?>" data-user-device="<?= $student['Device'] ?>" data-user-type="Student">ح</button>
                                                    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-user-id="<?= $student['userid'] ?>" data-user-device="<?= $student['Device'] ?>" data-user-type="Student">غ</button>
                                                    <button type="button" class="btn btn-outline-warning btn-rounded waves-effect waves-light" data-user-id="<?= $student['userid'] ?>" data-user-device="<?= $student['Device'] ?>" data-user-type="Student">م</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js') ?>"></script>
<script>
    $('.nav a').unbind('click');
    $(".select2").select2();
    $('.nav-link').click(function() {
        $(".nav-link").removeClass('active');
        $(".tab-pane").removeClass('active');
        var linkTab = $(this).attr('href');
        $(this).addClass('active');
        $(linkTab).addClass('active');
    });

    $('.btn-outline-success').click(function() {
        var userid = $(this).attr('data-user-id');
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: "<?= base_url("AR/schools/attendees_actions/present") ?>",
            data: {
                userId: userid,
                device: "<?= $Vehicle_data[0]['watch_mac'] ?>"
            },
            success: function(response) {
                if (response == "ok") {
                    // console.log($($this).parent(".card-body").children().first('.btn-outline-warning').addClass('btn-warning').html());
                    console.log("Done");
                    // notification
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
                    Command: toastr["success"]("Status updated successfully")
                } else {
                    console.log("error");
                    // notification
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
                    Command: toastr["error"]("Sorry we have an error !! Please try again later")
                }
            }
        });
    });

    $('.btn-outline-warning').click(function() {
        var userid = $(this).attr('data-user-id');
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: "<?= base_url("AR/schools/attendees_actions/absent") ?>",
            data: {
                userId: userid,
                device: "<?= $Vehicle_data[0]['watch_mac'] ?>"
            },
            success: function(response) {
                if (response == "ok") {
                    // console.log($($this).parent(".card-body").children().first('.btn-outline-warning').addClass('btn-warning').html());
                    console.log("Done");
                    // notification
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
                    Command: toastr["success"]("Status updated successfully")
                } else {
                    console.log("error");
                    // notification
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
                    Command: toastr["error"]("Sorry we have an error !! Please try again later")
                }
            }
        });
    });

    $('.btn-outline-danger').click(function() {
        var userid = $(this).attr('data-user-id');
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: "<?= base_url("AR/schools/attendees_actions/danger") ?>",
            data: {
                userId: userid,
                device: "<?= $Vehicle_data[0]['watch_mac'] ?>"
            },
            success: function(response) {
                if (response == "ok") {
                    // console.log($($this).parent(".card-body").children().first('.btn-outline-warning').addClass('btn-warning').html());
                    console.log("Done");
                    // notification
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
                    Command: toastr["success"]("Status updated successfully")
                } else {
                    console.log("error");
                    // notification
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
                    Command: toastr["error"]("Sorry we have an error !! Please try again later")
                }
            }
        });
    });

    $('.link').click(function() {
        var cardId = $(this).attr('data-card-id');
        var ActiveDriver = $(this).attr('data-active-driver');
        $.ajax({
            type: "post",
            url: "<?= base_url("AR/schools/Vehicles_list") ?>",
            data: {
                teachers_of_car: cardId,
            },
            success: function(response) {
                $('.Drivers').html("");
                response.forEach(teacher => {
                    var newHtml = '<div class="card col-12">';
                    newHtml += '<div class="card-body">';
                    newHtml += '<div class="row">';
                    newHtml += '<div class="col-2" style="border-right: rgb(152 152 152 / 39%) solid 1px;">';
                    if (teacher.avatar !== null) {
                        newHtml += '<img class="card-img-top img-fluid" src=<?= base_url(); ?>uploads/avatars/' + teacher.avatar + '" class="avatar-sm rounded-circle img-thumbnail hoverZoomLink" alt="">';
                    } else {
                        newHtml += '<img class="card-img-top img-fluid" src=<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-sm rounded-circle img-thumbnail hoverZoomLink" alt="">';
                    }
                    newHtml += '</div>';
                    newHtml += '<div class="col-8">';
                    newHtml += '<h3 class="card-title">' + teacher.teachername + '</h3>';
                    newHtml += '<p>since ' + teacher.since + '</p>';
                    newHtml += '</div>';
                    newHtml += '</div>';
                    newHtml += '</div>';
                    newHtml += '</div>';
                    $('.Drivers').append(newHtml);
                });
            }
        });
    });

    // SubervisorsList
    $('.staffs').click(function() {
        var cardId = $(this).attr('data-card-id');
        var ActiveDriver = $(this).attr('data-active-driver');
        $.ajax({
            type: "post",
            url: "<?= base_url("AR/schools/Vehicles_staff_control") ?>",
            data: {
                staffs_of_car: cardId,
            },
            success: function(response) {
                $('.Subervisors').html("");
                response.forEach(staff => {
                    var newHtml = '<div class="card col-12">';
                    newHtml += '<div class="card-body">';
                    newHtml += '<div class="row">';
                    newHtml += '<div class="col-2" style="border-right: rgb(152 152 152 / 39%) solid 1px;">';
                    if (staff.avatar !== null) {
                        newHtml += '<img class="card-img-top img-fluid" src=<?= base_url(); ?>uploads/avatars/' + staff.avatar + '" class="avatar-sm rounded-circle img-thumbnail hoverZoomLink" alt="">';
                    } else {
                        newHtml += '<img class="card-img-top img-fluid" src=<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-sm rounded-circle img-thumbnail hoverZoomLink" alt="">';
                    }
                    newHtml += '</div>';
                    newHtml += '<div class="col-8">';
                    newHtml += '<h3 class="card-title">' + staff.staff_name + '</h3>';
                    newHtml += '<p>since ' + staff.since + '</p>';
                    newHtml += '</div>';
                    newHtml += '</div>';
                    newHtml += '</div>';
                    newHtml += '</div>';
                    $('.Subervisors').append(newHtml);
                });
            }
        });
    });
    $('#presentCounter').html(($('.btn-success').length) - 1);
    $('#absentCounter').html(($('.btn-danger').length) - 1);
</script>