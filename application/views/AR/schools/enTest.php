<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

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
</style>

<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <label>Select Type of Members :</label>
                                    <select class="custom-select" id="List">
                                        <option value="Staffs">Staff</option>
                                        <option value="Techers">Techers</option>
                                        <option value="Students">Students</option>
                                    </select>
                                </div>
                                <div class="col-xl-6" style="margin-bottom: 10px;">
                                    <label style="float: left;">Select Test type</label>
                                    <select class="form-control" name="Test_type" id="Test_type">
                                        <option value="Temperature">Temperature</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Staffs">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">List of Staff:</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Name </th>
                                        <th> National ID </th>
                                        <th> Enter </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofaStaffs as $admin) { ?>
                                        <tr id="TrStafffId<?php echo $admin['Id']; ?>">
                                            <th scope="row">
                                                <?php echo $admin['Id']; ?>
                                            </th>
                                            <td>
                                                <?php echo $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?>
                                            </td>
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
                            <div class="card-title text-center">The List of Teachers :
                                <hr>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Name </th>
                                        <th> National ID </th>
                                        <th> Enter </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofteachers as $admin) { ?>
                                        <tr id="TrTeacherId<?php echo $admin['Id']; ?>">
                                            <th scope="row">
                                                <?php echo $admin['Id']; ?>
                                            </th>
                                            <td>
                                                <?php echo $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?>
                                            </td>
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
                            <div class="card-title text-center">The List of Students :</div>
                            <div class="">
                                <div class="card-body">
                                    <label for="SelectFromClass">Select The Class :</label>
                                    <?php $classes = $this->schoolHelper->school_classes($sessiondata['admin_id']) ?>
                                    <?php if (!empty($classes)) { ?>
                                        <select name="StudentClass" class="form-control select2" id="">
                                            <?php foreach ($classes as $class) { ?>
                                                <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } else { ?>
                                        <p>You do not have any class registered yet. Please edit school<a href="<?php echo base_url() ?>AR/schools/Profile">Profile</a> </p>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div id="hereGetedStudents">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 showInPageCard hide-card">
            <div class="card bg-primary text-white-50" style="border: 0px;">
                <div class="card-body">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="opacity: 1;color: #fff;">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h5 class="mt-0 mb-4 text-white"><i class="uil uil-users-alt mr-3"></i> Primary Card</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="<?php echo base_url(); ?>AR/Schools/SchowStudentsFromClass" id="Students_Link"><button type="button" class="btn btn-light waves-effect">Go To The Page !!</button></a>
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
<script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script>
    $("table").DataTable();


    $(".AddResultStaff").on('focusout', function(e) {
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

    $(".AddResultTeachers").on('focusout', function(e) {
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
            $('.showInPageCard ').removeClass('hide-card');
            var href = "<?php echo base_url() ?>AR/Schools/SchowStudentsFromClass/" + selectedclass;
            $('#Students_Link').attr('href', href);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Schools/ListOfStudentByClass',
                data: {
                    NumberOfClass: selectedclass,
                    Test_type: Test_type,
                },
                beforeSend: function() {
                    // setting a timeout
                    $("#hereGetedStudents").html('Please Wait.....');
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