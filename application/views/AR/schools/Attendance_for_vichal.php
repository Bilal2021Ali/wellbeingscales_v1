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
	    <br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> REP 046: تقرير حضور وانصراف جميع المركبات خلال فترة زمنية</h4>
        <div class="row">
            <div class="col-12">
                <div class="card notstatic">
                    <div class="card-body">
                        <div class="col-lg-12 offset-lg-2">
                           
                            <form class="mb-3 needs-validation" action="" method="post">
                                 <label>البحث خلال فترة زمنية:</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" value="<?= $from ?? "" ?>" required name="start" placeholder="من تاريخ" autocomplete="off" />
                                    <input type="text" class="form-control" value="<?= $to ?? "" ?>"  required name="end" placeholder="إلى تاريخ" autocomplete="off" />
                                </div>
                                <button type="Submit" class="btn btn-outline-success waves-effect waves-light btn-block mt-2">البحث</button>
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
                        <h5 class="modal-title mt-0" id="modaltITLE">عرض</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="rel_teachers_list">
                            <table class="table teachers_table">
                                <thead>
                                    <th>#</th>
                                    <th>الأسم</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light">حفظ</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php if (isset($list)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="card notstatic">
                        <div class="card-body">
                            <h3 class="card-title mb-2"> من <?= $from ?> , إلى : <?= $to ?></h3>
                            <table class="table mt-5 cars" id="datatable-buttons">
                                <thead>
                                    <th>#</th>
                                    <th>رقم المركبة</th>
                                    <th>وقت الدخول</th>
                                    <th>وقت الخروج</th>
                                    <th>جهاز الدخول</th>
                                    <th>جهاز الخروج</th>
                                    <th>حالة المركبة</th>
                                    <th>الإجرائات</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $key => $data) { ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $data['No_vehicle'] ?></td>
                                            <td><?= $data['Time_first'] ?></td>
                                            <td><?= $data['Time_last'] ?></td>
                                            <td><?= $data['Device_first'] ?></td>
                                            <td><?= $data['Device_last'] ?></td>
                                            <td><?= $data['Action'] ?></td>
                                            <td class="actions">
                                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Teachers of this car"><i class="uil uil-constructor ShowDrivers" data-toggle="modal" data-target="#myModal" data-car-key="<?= $data['V_Id']; ?>"></i></span>
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
    //$('.table').DataTable();
    $(document).ready(function() {
        //Buttons examples
        var table = $('.dtatables').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        });
        table.buttons().container()
            .appendTo('#DataTables_Table_0_wrapper .row:eq(0) .col-md-6:eq(0)');
        $(".dataTables_length select").addClass('form-select form-select-sm');
    });
    <?php if (isset($list)) { ?>
        $('.cars').on('click', '.ShowDrivers', function() {
            $('.coustom-modal , .backdrop').addClass('show');
            $('#modaltITLE').html('Drivers list');
            car_id = $(this).attr('data-car-key');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/schools/Vehicles_list',
                data: {
                    teachers_of_car: car_id,
                },
                cache: false,
                success: function(data) {
                    $('.teachers_table tbody').html('');
                    if (data.length > 0) {
                        data.forEach((teacher, i) => {
                            var append_data = '<tr>';
                            append_data += "<td>" + (i + 1) + "</td>";
                            append_data += "<td>" + teacher.teachername + "</td>";
                            append_data += '</tr>';
                            $('.teachers_table tbody').append(append_data);
                        });
                    } else {
                        console.log(data.length);
                        var append_data = '<tr><td colspan="4" class="text-center">Sorry no teachers found</td></tr>';
                        $('.teachers_table tbody').html(append_data);
                    }
                    $('.teachers_table').DataTable()
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ',
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
                url: '<?php echo base_url(); ?>AR/schools/Vehicles_students_controle',
                data: {
                    students_of_car: car_id,
                },
                cache: false,
                success: function(data) {
                    $('.teachers_table tbody').html('');
                    if (data.length > 0) {
                        data.forEach((teacher, i) => {
                            var append_data = '<tr>';
                            append_data += "<td>" + (i + 1) + "</td>";
                            append_data += "<td>" + teacher.teachername + "</td>";
                            append_data += '</tr>';
                            $('.teachers_table tbody').append(append_data);
                        });
                    } else {
                        console.log(data.length);
                        var append_data = '<tr><td colspan="4" class="text-center">عذرا ، لم يتم العثور على أي طالب.</td></tr>';
                        $('.teachers_table tbody').html(append_data);
                    }
                    $('.teachers_table').DataTable()
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! لدينا خطأ',
                        'error'
                    )
                }
            });
        });
    <?php } ?>
</script>