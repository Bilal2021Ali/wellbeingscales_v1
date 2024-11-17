<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management</title>
</head>
<style>
    .actions {
        text-align: center;
    }

    .actions .uil {
        margin-left: 10px;
    }

    .AddDriver {
        color: #0eacd8;
    }

    .ShowDrivers {
        color: #98c110;
    }

    .actions .uil,
    .uil-compress,
    .teachers_table .uil-plus {
        cursor: pointer;
        font-size: 25px;
    }

    .uil-plus.addDriver {
        font-size: 25px;
        color: #f1734f;
    }

    .deleteDriver,
    .deleteStaff .deleteStudents {
        cursor: pointer;
        font-size: 25px;
        color: red;
    }

    .coustom-modal {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 10080;
        width: 70%;
        max-height: 80%;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        transform: scale(0) translate(-50%, -50%);
        transition: 1s all;
    }

    .coustom-modal.show {
        transition: 1s all;
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 2px 12px rgb(15 34 58 / 12%);
    }

    .backdrop.show {
        position: absolute;
        background-color: rgb(15 34 58 / 50%);
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        display: block;
        z-index: 10000;
    }

    .swal2-container {
        z-index: 99999;
    }

    #modal-1 {
        overflow: auto;
    }
</style>

<body>
<div class="backdrop"></div>
<section id="modal-1" class="coustom-modal">
    <h3><span id="modaltITLE">List of Teachers</span><i class="uil uil-compress float-right"></i></h3>
    <hr>
    <div class="rel_teachers_list">
        <table class="table teachers_table">
            <thead>
            <th>#</th>
            <th>Name</th>
            <th class="place_th">Class</th>
            <th class="text-center">Select</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</section>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <br>
                    <div class="row image_container">
                        <img src="<?php echo base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            CH P013: Vehicle Management | Add Teachers and Students to Vehicles</h4>
        <div class="card w-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-4">
                            <table class="table w-100 cars">
                                <thead>
                                <th>#</th>
                                <th>Vehicle ID</th>
                                <th>Vehicle Type</th>
                                <th>Company</th>
                                <th>Country</th>
                                <th>Model</th>
                                <th>Color</th>
                                <th class="text-center">Teacher’s Action</th>
                                <th class="text-center">Student’s Action</th>
                                <th class="text-center">Staff’s Action</th>
                                </thead>
                                <tbody>
                                <?php foreach ($vehicles as $key => $vehicle) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $vehicle['No_vehicle'] ?></td>
                                        <td><?= $vehicle['type_vehicle'] ?? "This type is no longer available" ?></td>
                                        <td><?= $vehicle['Company_vehicle'] ?></td>
                                        <td><?= $vehicle['Country_vehicle'] ?></td>
                                        <td><?= $vehicle['Model_vehicle'] ?></td>
                                        <td><?= $vehicle['Color_vehicle'] ?></td>
                                        <td class="actions">
                                            <i class="uil uil-user-plus AddDriver"
                                               data-car-key="<?= $vehicle['Id']; ?>"></i>
                                            <i class="uil uil-constructor ShowDrivers"
                                               data-car-key="<?= $vehicle['Id']; ?>"></i>
                                        </td>
                                        <td class="actions">
                                            <i class="uil uil-chat-bubble-user Addstudents"
                                               data-car-key="<?= $vehicle['Id']; ?>"></i>
                                            <i class="uil uil-notes ShowStudents"
                                               data-car-key="<?= $vehicle['Id']; ?>"></i>
                                        </td>
                                        <td class="actions">
                                            <i class="uil uil-chat-bubble-user Addstaff"
                                               data-car-key="<?= $vehicle['Id']; ?>"></i>
                                            <i class="uil uil-notes ShowStaff"
                                               data-car-key="<?= $vehicle['Id']; ?>"></i>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    // global
    var car_id = "";
    var teacher = "";
    $('.cars').DataTable();
    $('.cars').on('click', '.AddDriver', function () {
        $('.place_th').html('Class');
        $('.coustom-modal , .backdrop').addClass('show');
        $('#modaltITLE').html('List of Teachers');
        car_id = $(this).attr('data-car-key');
        $('.teachers_table tbody').html("Please wait...");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_list',
            data: {
                car_key: car_id,
            },
            cache: false,
            success: function (data) {
                $('.teachers_table tbody').html("");
                if (data.length > 0) {
                    data.forEach((teacher, i) => {
                        var append_data = '<tr>';
                        append_data += "<td>" + (i + 1) + "</td>";
                        append_data += "<td>" + teacher.teachername + "</td>";
                        append_data += "<td>not found</td>";
                        append_data += '<td class="text-center"><i data-teacher-key="' + teacher.Id + '" class="uil uil-plus addDriver"></i></td>';
                        append_data += '</tr>';
                        $('.teachers_table tbody').append(append_data);
                    });
                } else {
                    console.log(data.length);
                    var append_data = '<tr><td colspan="4" class="text-center">Sorry no teachers found</td></tr>';
                    $('.teachers_table tbody').html(append_data);
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    $('.cars').on('click', '.Addstudents', function () {
        $('.place_th').html('Class');
        $('.coustom-modal , .backdrop').addClass('show');
        $('#modaltITLE').html('List of Students');
        car_id = $(this).attr('data-car-key');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_students_control',
            data: {
                car_key: car_id,
            },
            cache: false,
            success: function (data) {
                $('.teachers_table tbody').html("");

                if (data.length > 0) {
                    data.forEach((student, i) => {
                        var append_data = '<tr>';
                        append_data += "<td>" + (i + 1) + "</td>";
                        append_data += "<td>" + student.student_id + "</td>";
                        append_data += "<td>not found</td>";
                        append_data += '<td class="text-center"><i data-student-key="' + student.Id + '" class="uil uil-plus add_new_student"></i></td>';
                        append_data += '</tr>';
                        $('.teachers_table tbody').append(append_data);
                    });
                } else {
                    console.log(data.length);
                    var append_data = '<tr><td colspan="4" class="text-center">Sorry, no available student found.</td></tr>';
                    $('.teachers_table tbody').html(append_data);
                }
                $('.teachers_table').DataTable()

            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });


    $('.cars').on('click', '.Addstaff', function () {
        $('.place_th').html('Position');
        $('.coustom-modal , .backdrop').addClass('show');
        $('#modaltITLE').html('List of Staff');
        car_id = $(this).attr('data-car-key');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_staff_control',
            data: {
                car_key: car_id,
            },
            cache: false,
            success: function (data) {
                $('.teachers_table tbody').html("");

                if (data.length > 0) {
                    data.forEach((staff, i) => {
                        var append_data = '<tr>';
                        append_data += "<td>" + (i + 1) + "</td>";
                        append_data += "<td>" + staff.staff_name + "</td>";
                        append_data += "<td>" + staff.position + "</td>";
                        append_data += '<td class="text-center"><i data-staff-key="' + staff.Id + '" class="uil uil-plus add_as_staff"></i></td>';
                        append_data += '</tr>';
                        $('.teachers_table tbody').append(append_data);
                    });
                } else {
                    console.log(data.length);
                    var append_data = '<tr><td colspan="4" class="text-center">Sorry, no available student found.</td></tr>';
                    $('.teachers_table tbody').html(append_data);
                }
                $('.teachers_table').DataTable()

            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    // show drivers
    $('.cars').on('click', '.ShowDrivers', function () {
        $('.place_th').html('Class');
        $('.coustom-modal , .backdrop').addClass('show');
        $('#modaltITLE').html('List of Teachers');
        car_id = $(this).attr('data-car-key');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_list',
            data: {
                teachers_of_car: car_id,
            },
            cache: false,
            success: function (data) {
                $('.teachers_table tbody').html("");

                if (data.length > 0) {
                    data.forEach((teacher, i) => {
                        var append_data = '<tr>';
                        append_data += "<td>" + (i + 1) + "</td>";
                        append_data += "<td>" + teacher.teachername + "</td>";
                        append_data += "<td>not found</td>";
                        append_data += '<td class="text-center"><i data-connect-key="' + teacher.connect_id + '" class="uil uil-trash deleteDriver"></i></td>';
                        append_data += '</tr>';
                        $('.teachers_table tbody').append(append_data);
                    });
                } else {
                    console.log(data.length);
                    var append_data = '<tr><td colspan="4" class="text-center">Sorry, no available teachers found.</td></tr>';
                    $('.teachers_table tbody').html(append_data);
                }
                $('.teachers_table').DataTable()

            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    // show students
    $('.cars').on('click', '.ShowStudents', function () {
        $('.place_th').html('Class');
        $('.coustom-modal , .backdrop').addClass('show');
        $('#modaltITLE').html('List of Students');
        car_id = $(this).attr('data-car-key');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_students_control',
            data: {
                students_of_car: car_id,
            },
            cache: false,
            success: function (data) {
                $('.teachers_table tbody').html("");
                if (data.length > 0) {
                    data.forEach((teacher, i) => {
                        var append_data = '<tr>';
                        append_data += "<td>" + (i + 1) + "</td>";
                        append_data += "<td>" + teacher.teachername + "</td>";
                        append_data += "<td>not found</td>";
                        append_data += '<td class="text-center"><i data-connect-key="' + teacher.connect_id + '" class="uil uil-trash deleteStudents"></i></td>';
                        append_data += '</tr>';
                        $('.teachers_table tbody').append(append_data);
                    });
                } else {
                    console.log(data.length);
                    var append_data = '<tr><td colspan="4" class="text-center">Sorry, no available student found.</td></tr>';
                    $('.teachers_table tbody').html(append_data);
                }
                $('.teachers_table').DataTable()

            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    // show staff 
    $('.cars').on('click', '.ShowStaff', function () {
        $('.place_th').html('Position');
        $('.coustom-modal , .backdrop').addClass('show');
        $('#modaltITLE').html('List of Staff');
        car_id = $(this).attr('data-car-key');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_staff_control',
            data: {
                staffs_of_car: car_id,
            },
            cache: false,
            success: function (data) {
                $('.teachers_table tbody').html("");
                if (data.length > 0) {
                    data.forEach((staff, i) => {
                        var append_data = '<tr>';
                        append_data += "<td>" + (i + 1) + "</td>";
                        append_data += "<td>" + staff.staff_name + "</td>";
                        append_data += "<td>" + staff.position + "</td>";
                        append_data += '<td class="text-center"><i data-connect-key="' + staff.connect_id + '" class="uil uil-trash deleteStaff"></i></td>';
                        append_data += '</tr>';
                        $('.teachers_table tbody').append(append_data);
                    });
                } else {
                    console.log(data.length);
                    var append_data = '<tr><td colspan="4" class="text-center">Sorry, no available staff found.</td></tr>';
                    $('.teachers_table tbody').html(append_data);
                }
                $('.teachers_table').DataTable();
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    $('body').on('click', '.backdrop.show , .coustom-modal .uil-compress', function () {
        $('.coustom-modal , .backdrop').removeClass('show');
    });

    $('.teachers_table').on('click', '.uil-plus:not(.add_new_student,.add_as_staff)', function () {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_list',
            data: {
                car: car_id,
                teacher: $(this).attr('data-teacher-key')
            },
            cache: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire(
                        'success',
                        'The teacher is connected successfully.',
                        'success'
                    );
                    setTimeout(() => {
                        $('.coustom-modal , .backdrop').removeClass('show');
                    }, 800);
                } else {
                    console.log({data});
                    Swal.fire(
                        'error',
                        'The teacher is already connected.',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    $('.teachers_table').on('click', '.add_new_student', function () {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_students_control',
            data: {
                student_key: $(this).attr("data-student-key"),
                car_id: car_id
            },
            cache: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire(
                        'success',
                        'The student is connected successfully.',
                        'success'
                    );
                    setTimeout(() => {
                        $('.coustom-modal , .backdrop').removeClass('show');
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'The student is already connected.',
                        'error'
                    );
                }

            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });


    $('.teachers_table').on('click', '.add_as_staff', function () {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_staff_control',
            data: {
                staff_key: $(this).attr("data-staff-key"),
                car_id: car_id
            },
            cache: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire(
                        'success',
                        'The staff is connected successfully.',
                        'success'
                    );
                    setTimeout(() => {
                        $('.coustom-modal , .backdrop').removeClass('show');
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'The staff is already connected.',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    $('.teachers_table').on('click', '.deleteDriver', function () {
        $.ajax({
            type: 'DELETE',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_list',
            data: {
                connect_id: $(this).attr('data-connect-key')
            },
            cache: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire(
                        'success',
                        'The teacher was deleted successfully.',
                        'success'
                    );
                    setTimeout(() => {
                        $('.coustom-modal , .backdrop').removeClass('show');
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'sorry we have an error',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    $('.teachers_table').on('click', '.deleteStudents', function () {
        $.ajax({
            type: 'DELETE',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_students_control',
            data: {
                connect_id: $(this).attr('data-connect-key')
            },
            cache: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire(
                        'success',
                        'The student was deleted successfully.',
                        'success'
                    );
                    setTimeout(() => {
                        $('.coustom-modal , .backdrop').removeClass('show');
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'sorry we have an error',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });

    $('.teachers_table').on('click', '.deleteStaff', function () {
        $.ajax({
            type: 'DELETE',
            url: '<?php echo base_url(); ?>EN/schools/Vehicles_staff_control',
            data: {
                connect_id: $(this).attr('data-connect-key')
            },
            cache: false,
            success: function (data) {
                if (data == "ok") {
                    Swal.fire(
                        'success',
                        'The staff was deleted successfully.',
                        'success'
                    );
                    setTimeout(() => {
                        $('.coustom-modal , .backdrop').removeClass('show');
                    }, 800);
                } else {
                    Swal.fire(
                        'error',
                        'sorry we have an error',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have an error',
                    'error'
                )
            }
        });
    });
</script>

</html>