<style>
    .actions .uil,
    .uil-compress,
    .teachers_table .uil-plus {
        cursor: pointer;
        font-size: 25px;
    }

    .actions .uil {
        margin-left: 10px;
    }

    .ShowDrivers {
        color: #98c110;
    }

    .deleteDriver,
    .deleteStudents {
        cursor: pointer;
        font-size: 25px;
        color: red;
    }
.actions {}
    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css") ?>">
<link href="<?= base_url("assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
<div class="main-content">
    <div class="page-content">

		<br>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">REP 046: Vehicle Attendance</h4>

        <div class="row">
            <div class="col-lg-12">
                <div class="card notstatic">
                    <div class="card-body">
                        <div class="col-lg-12">

                            <form class="mb-3 needs-validation" action="" method="post">
                                <label class="form-label">Date Range</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" value="<?= $from ?? "" ?>" required name="start" placeholder="Start Date" autocomplete="off" />
                                    <input type="text" class="form-control" value="<?= $to ?? "" ?>" required name="end" placeholder="End Date" autocomplete="off" />
                                </div>
                                <button type="Submit" class="btn btn-outline-success waves-effect waves-light btn-block mt-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- sample modal content -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modaltITLE">List:</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> 
							</button>
                    <div class="modal-body">
                        <div class="rel_teachers_list">
                            <table class="table teachers_table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Attendees Status</th>
                                    <th>Date</th>
                                    <th>Result</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <?php if (isset($list)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="card notstatic">
                        <div class="card-body">
                            <h3 class="card-title mb-2"> From <?= $from ?> , To : <?= $to ?></h3>
                            <div class="table-responsive">
                                <table class="table mt-5 cars" id="datatable-buttons">
                                    <thead>
                                        <th>#</th>
                                        <th>Vehicle Number</th>
                                        <th>First Result</th>
                                        <th>First Humidity</th>
                                        <th>Last Result</th>
                                        <th>Last Humidity</th>
                                        <th>Time in</th>
                                        <th>Time out</th>
                                        <th>First Device</th>
                                        <th>Last Device</th>
                                        <th>Vehicle Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list as $key => $data) { ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $data['No_vehicle'] ?></td>
                                                <td><?= $data['Result_first'] ?? "--" ?></td>
                                                <td><?= $data['humidity_first'] ?? "--" ?></td>
                                                <td><?= $data['Result_last'] ?? "--" ?></td>
                                                <td><?= $data['humidity_last'] ?? "--" ?></td>
                                                <td><?= $data['Time_first'] ?></td>
                                                <td><?= $data['Time_last'] ?></td>
                                                <td><?= $data['Device_first'] ?></td>
                                                <td><?= $data['Device_last'] ?></td>
                                                <td><?= $data['Action'] ?></td>
                                                <td class="actions">
                                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Teachers of this car"><i class="uil uil-constructor ShowDrivers" data-toggle="modal" data-target="#myModal" data-car-key="<?= $data['V_Id']; ?>"></i></span>
                                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Staff of this car"><i class="uil uil-constructor ShowHelpers" data-toggle="modal" data-target="#myModal" data-car-key="<?= $data['V_Id']; ?>"></i></span>
                                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Students of this car"><i class="uil uil-notes ShowStudents" data-toggle="modal" data-target="#myModal" data-car-key="<?= $data['V_Id']; ?>"></i></span>
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
        <?php }  ?>
    </div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script>
    var table = $('.teachers_table').DataTable();
    //$('.table').DataTable();
    $(document).ready(function() {
        //Buttons examples
        var table = $('.dtatables').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        });

        table.buttons().container().appendTo('#DataTables_Table_0_wrapper .row:eq(0) .col-md-6:eq(0)');
        $(".dataTables_length select").addClass('form-select form-select-sm');
    });

    <?php if (isset($list)) { ?>
        $('.cars').on('click', '.ShowDrivers', function() {
            $('.coustom-modal , .backdrop').addClass('show');
            $('#modaltITLE').html('Drivers list');
            car_id = $(this).attr('data-car-key');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/schools/Vehicle_results',
                data: {
                    user_type: 'teacher',
                    car_id: car_id,
                    from_date: $('input[name="start"]').val(),
                    to_date: $('input[name="end"]').val(),
                },
                cache: false,
                success: function(data) {
                    if (data.status == "ok") {
                        table.clear();
                        // $('.teachers_table').empty();
                        $('.teachers_table tbody').html('');
                        if (data.results.length > 0) {
                            data.results.forEach((user, i) => {
                                var append_data = '<tr>';
                                append_data += "<td>" + (i + 1) + "</td>";
                                append_data += "<td>" + user.username + "</td>";
                                if (user.Attendees_status == "present") {
                                    append_data += "<td class='text-center'>" + '<span class="badge bg-success p-2 text-white">Present</span>' + "</td>";
                                } else {
                                    append_data += "<td class='text-center'>" + '<span class="badge bg-danger p-2 text-white">Absent</span>' + "</td>";
                                }
                                append_data += "<td>" + (user.date !== null ? user.date : "----/--/--") + "</td>";
                                append_data += "<td>" + (user.Result !== null ? user.Result : "--") + "</td>";
                                append_data += '</tr>';
                                $('.teachers_table tbody').append(append_data);
                                console.log(append_data);
                            });
                        } else {
                            console.log(data.length);
                            var append_data = '<tr><td colspan="5" class="text-center">Sorry no Data found</td></tr>';
                            $('.teachers_table tbody').html(append_data);
                        }
                        $('.teachers_table').DataTable();
                    }
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    )
                }
            });
        });

        $('.cars').on('click', '.ShowHelpers', function() {
            $('.coustom-modal , .backdrop').addClass('show');
            $('#modaltITLE').html('Helpers list');
            car_id = $(this).attr('data-car-key');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/schools/Vehicle_results',
                data: {
                    user_type: 'staff',
                    car_id: car_id,
                    from_date: $('input[name="start"]').val(),
                    to_date: $('input[name="end"]').val(),
                },
                cache: false,
                success: function(data) {
                    if (data.status == "ok") {
                        table.clear();
                        // $('.teachers_table').empty();
                        $('.teachers_table tbody').html('');
                        if (data.results.length > 0) {
                            data.results.forEach((user, i) => {
                                var append_data = '<tr>';
                                append_data += "<td>" + (i + 1) + "</td>";
                                append_data += "<td>" + user.username + "</td>";
                                if (user.Attendees_status == "present") {
                                    append_data += "<td class='text-center'>" + '<span class="badge bg-success p-2 text-white">Present</span>' + "</td>";
                                } else {
                                    append_data += "<td class='text-center'>" + '<span class="badge bg-danger p-2 text-white">Absent</span>' + "</td>";
                                }
                                append_data += "<td>" + (user.date !== null ? user.date : "----/--/--") + "</td>";
                                append_data += "<td>" + (user.Result !== null ? user.Result : "--") + "</td>";
                                append_data += '</tr>';
                                $('.teachers_table tbody').append(append_data);
                                console.log(append_data);
                            });
                        } else {
                            console.log(data.length);
                            var append_data = '<tr><td colspan="5" class="text-center">Sorry no Data found</td></tr>';
                            $('.teachers_table tbody').html(append_data);
                        }
                        $('.teachers_table').DataTable();
                    }
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    )
                }
            });
        });

        $('.cars').on('click', '.ShowStudents', function() {
            $('.coustom-modal , .backdrop').addClass('show');
            $('#modaltITLE').html('List of Students');
            car_id = $(this).attr('data-car-key');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/schools/Vehicle_results',
                data: {
                    user_type: 'Student',
                    car_id: car_id,
                    from_date: $('input[name="start"]').val(),
                    to_date: $('input[name="end"]').val(),
                },
                cache: false,
                success: function(data) {
                    if (data.status == "ok") {
                        table.clear();
                        // $('.teachers_table').empty();
                        $('.teachers_table tbody').html('');
                        if (data.results.length > 0) {
                            data.results.forEach((user, i) => {
                                var append_data = '<tr>';
                                append_data += "<td>" + (i + 1) + "</td>";
                                append_data += "<td>" + user.username + "</td>";
                                if (user.Attendees_status == "present") {
                                    append_data += "<td class='text-center'>" + '<span class="badge bg-success p-2 text-white">Present</span>' + "</td>";
                                } else {
                                    append_data += "<td class='text-center'>" + '<span class="badge bg-danger p-2 text-white">Absent</span>' + "</td>";
                                }
                                append_data += "<td>" + (user.date !== null ? user.date : "----/--/--") + "</td>";
                                append_data += "<td>" + (user.Result !== null ? user.Result : "--") + "</td>";
                                append_data += '</tr>';
                                $('.teachers_table tbody').append(append_data);
                                console.log(append_data);
                            });
                        } else {
                            console.log(data.length);
                            var append_data = '<tr><td colspan="5" class="text-center">Sorry no Data found</td></tr>';
                            $('.teachers_table tbody').html(append_data);
                        }
                        $('.teachers_table').DataTable();
                    }
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    )
                }
            });
        });
    <?php } ?>
</script>