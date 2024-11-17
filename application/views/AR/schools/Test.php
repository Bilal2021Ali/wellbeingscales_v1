<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

$active_classes = $this->schoolHelper->getActiveSchoolClassesByStudents();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
    .AddedSuccess {
        background-color: #007709;
        text-align: center;
        transition: 0.5s all;
        color: #fff;
        width: 100%;
    }

    .showInPageCard {
        position: fixed;
        right: 10px;
        bottom: 10px;
        z-index: 1000;
        transition: 0.5s all;
    }

    .hide-card {
        bottom: -200px;
    }

    .showInPageCard .card {
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        /* Firefox 3.5 - 3.6 */
        box-shadow: 3px 3px 5px 6px #ccc;
        /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
    }
		.image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px; }
</style>

<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
 

<body>
    <div class="main-content">
        <div class="page-content">
		<br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 032: أدخل نتائج درجات الحرارة يدويًا للموظفين والمعلمين والطلاب</h4>			   
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
            <br><h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">.</h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <label>نوع المستخدمين</label>
                                    <select class="custom-select" id="List">
                                        <option value="Staffs">الموظفين</option>
                                        <option value="Techers">المعلمين</option>
                                        <option value="Students">الطلاب</option>
                                    </select>
                                </div>
                                <div class="col-xl-6" style="margin-bottom: 10px;">
                                    <label style="float: rightt;">نوع الفحص</label>
                                    <select class="form-control" name="Test_type" id="Test_type">
                                        <option value="Temperature">درجات الحرارة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Staffs">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">قائمة الموظفين
                                <hr>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> الإسم </th>
                                        <th> الرقم الوطني </th>
                                        <th> إدخال درجة الحرارة </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_id = 0;
                                    foreach ($listofaStaffs as $admin) {
                                        $s_id++;
                                    ?>
                                        <tr id="TrStafffId<?php echo $admin['Id']; ?>">
                                            <th scope="row"> <?php echo $s_id; ?> </th>
                                            <td><?php echo $admin['F_name_AR'] . ' ' . $admin['M_name_AR'] . ' ' . $admin['L_name_AR']; ?></td>
                                            <td><?php echo $admin['National_Id']; ?></td>
                                            <td>
                                                <form class="AddResultStaff">
                                                    <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37">
                                                    <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId">
                                                    <input type="hidden" name="Test_type" class="Test_type">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Techers">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center"> قائمة المعلمين
                                <hr>

                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> الإسم </th>
                                        <th> الرقم الوطني </th>
                                        <th> إدخال درجة الحرارة </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_id = 0;
                                    foreach ($listofteachers as $admin) {
                                        $s_id++;
                                    ?>
                                        <tr id="TrTeacherId<?php echo $admin['Id']; ?>">
                                            <th scope="row"> <?php echo $s_id; ?> </th>
                                            <td><?php echo $admin['F_name_AR'] . ' ' . $admin['M_name_AR'] . ' ' . $admin['L_name_AR']; ?></td>
                                            <td><?php echo $admin['National_Id']; ?></td>
                                            <td>
                                                <form class="AddResultTeachers">
                                                    <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37">
                                                    <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId">
                                                    <input type="hidden" name="Test_type" class="Test_type">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Students">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">قائمة الطلاب
                                <hr>
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <label for="SelectFromClass">المراحل الدراسية </label>
                                    <select name="StudentClass" class="form-control" id="SelectFromClass">
                                        <?php if (!empty($active_classes)) { ?>
                                            <option>الفصل الدراسي</option>
                                            <?php foreach($active_classes as $class) { ?>
                                                <option value="<?= $class['Id']  ?>"><?= $class['Class']; ?> (<?= $class['student_count'] ?> الطلاب) </option>
                                            <?php }  ?>
                                        <?php } else { ?>
                                            <option value="">نعتذر ، لا يوجد طلاب هذه المدرسة. الرجاء إضافة طالب</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div id="hereGetedStudents"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="JHZLNS"></div>
    </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $("table").DataTable();
    $("#Staffs").on('focusout', ".AddResultStaff", function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/Results/AddResultForStaff',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('.JHZLNS').html(data);
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

    $("#Techers").on('focusout', ".AddResultTeachers", function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/Results/AddResultForTeacher',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('.JHZLNS').html(data);
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




    $("#Techers,#Students").slideUp();
    $(document).ready(function() {

        var Test_type = "Temperature";
        $('.Test_type').val(Test_type);
        $("#Test_type").change(function() {
            Test_type = $(this).children("option:selected").val();
            $('.Test_type').val(Test_type);
        });



        $("#List").change(function() {
            var selectedunit = $(this).children("option:selected").val();
            if (selectedunit == "Staffs") {
                $('#Staffs').slideDown();
                $('#Techers').slideUp();
                $('#Students').slideUp();
            } else if (selectedunit == "Techers") {
                $('#Techers').slideDown();
                $('#Staffs').slideUp();
                $('#Students').slideUp();
            } else if (selectedunit == "Students") {
                $('#Students').slideDown();
                $('#Staffs').slideUp();
                $('#Techers').slideUp();
            }

        });

        $('.close').click(function() {
            $('.showInPageCard ').addClass('hide-card');
        });

        $("#SelectFromClass").change(function() {
            var selectedclass = $(this).children("option:selected").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Schools/ListOfStudentByClass',
                data: {
                    NumberOfClass: selectedclass,
                    Test_type: Test_type,
                },
                beforeSend: function() {
                    // setting a timeout
                    $("#hereGetedStudents").html('الرجاء الإنتظار ...');
                },
                success: function(data) {
                    $('#hereGetedStudents').html(data);
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

    });
    $('input[type="number"]').attr("max", "50");
    $('input[type="number"]').attr("min", "30");
</script>

</html>