<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />

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
</style>
<style>
    .showInPageCard {
        position: fixed;
        left: 10px;
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

    .bx-rotate-left {
        font-size: 25px;
        float: left;
        cursor: pointer;

    }

    .custom-select {
        margin-top: 10px;
    }

    .sync {
        transition: 0.5s all;
        transform: rotate(0deg);
    }

    .sync_start {
        color: #007635;
        -webkit-animation-name: ease-in-outAnimation;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: ease-in-out;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-play-state: running;
        /* Mozilla */
        -moz-animation-name: ease-in-outAnimation;
        -moz-animation-duration: 1s;
        -moz-animation-timing-function: ease-in-out;
        -moz-animation-iteration-count: infinite;
        -moz-animation-play-state: running;
        /* Standard syntax */
        animation-name: ease-in-outAnimation;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-play-state: running;
    }


    /* Chrome, Safari */
    @-webkit-keyframes ease-in-outAnimation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
    }

    /* Firefox */
    @-moz-keyframes ease-in-outAnimation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
    }

    /* Standard syntax */
    @keyframes ease-in-outAnimation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
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
                                <div class="col-xl-12">
                                    <i class="bx bx-rotate-left sync" data-toggle="tooltip" data-placement="top" title="" data-original-title="إضغط لبدأ عملية المزامنة للصور"></i>
                                    <label>إختر نوع المستخدمين :</label>
                                    <select class="custom-select" id="List">
                                        <option value="Staffs" selected=""> الموظفين </option>
                                        <option value="Techers">المعلمين</option>
                                        <option value="Students">الطلاب</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" id="Staffs">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> الإسم </th>
                                        <th> رقم التعريف الوطني</th>
                                        <th> إرفع </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofaStaffs as $admin) { ?>
                                        <tr id="TrStafffId<?php echo $admin['Id']; ?>">
                                            <th scope="row" class="Avatar" style="text-align: center;">
                                                <?php
                                                $avatar_teach = $this->db->query("SELECT * FROM `l2_avatars`
     WHERE `For_User` = '" . $admin['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                ?>
                                                <?php if (empty($avatar_teach)) {  ?>
                                                    <a href="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="image-popup-no-margins">
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar_teach[0]['Link']; ?>" class="image-popup-no-margins">
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar_teach[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    </a>
                                                <?php } ?>
                                            </th>
                                            <td>
                                                <?php echo $admin['F_name_AR'] . ' ' . $admin['M_name_AR'] . ' ' . $admin['L_name_AR']; ?>
                                            </td>
                                            <td>
                                                <?php echo $admin['National_Id']; ?>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>AR/Schools/ChangeMemberAvatar/Staff/<?php echo $admin['Id']; ?>/<?php echo $admin['National_Id'] ?>">
                                                    <i class="uil uil-upload"></i>
                                                </a>
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
                            <div class="card-title text-center">قائمة المعلمين
                                <hr>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> الإسم </th>
                                        <th> رقم التعريف الوطني</th>
                                        <th> إرفع </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofteachers as $admin_Teacher) { ?>
                                        <tr id="TrStafffId<?php echo $admin_Teacher['Id']; ?>">
                                            <th scope="row" class="Avatar" style="text-align: center;">
                                                <?php
                                                $avatar_teach = $this->db->query("SELECT * FROM `l2_avatars`
     WHERE `For_User` = '" . $admin_Teacher['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                                ?>
                                                <?php if (empty($avatar_teach)) {  ?>
                                                    <a href="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="image-popup-no-margins">
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar_teach[0]['Link']; ?>" class="image-popup-no-margins">
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar_teach[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    </a>
                                                <?php } ?>
                                            </th>
                                            <td>
                                                <?php echo $admin_Teacher['F_name_AR'] . ' ' . $admin_Teacher['M_name_AR'] . ' ' . $admin_Teacher['L_name_AR']; ?>
                                            </td>
                                            <td>
                                                <?php echo $admin_Teacher['National_Id']; ?>
                                            </td>

                                            <td>
                                                <a href="<?php echo base_url(); ?>AR/Schools/ChangeMemberAvatar/Teacher/<?php echo $admin_Teacher['Id']; ?>/<?php echo $admin_Teacher['National_Id'] ?>">
                                                    <i class="uil uil-user"></i>
                                                </a>
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
                            <div class="card-title text-center">قائمة الطلاب :
                                <div class="">
                                    <div class="card-body">
                                        <label for="SelectFromClass">إختر مستوى</label>
                                        <select name="StudentClass" class="form-control" id="SelectFromClass">
                                            <?php
                                            $classes = $this->schoolHelper->school_classes($sessiondata['admin_id']);
                                            if (!empty($classes)) { ?> 
                                            <option>من فضلك إختر مستوى</option>
                                                <?php foreach($classes as $class){ ?>
                                                    <option value="<?= $class['Id']  ?>"><?= $class['Class']; ?></option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">لا توجد ليكم أي مستويات الرجاء إضافتها من الملف الشخصي</option>
                                            <?php }  ?>
                                        </select>
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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="opacity: 1;color: #fff;float:left;">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="mt-0 mb-4 text-white"><i class="uil uil-camera mr-3"></i> يمكنك فتح هذه القائمة في صفحة منفصلة </h5>
                        <a href="<?php echo base_url(); ?>AR/Schools/SchowStudentsFromClass" id="Students_Link"><button type="button" class="btn btn-light waves-effect">إفتح في صفحة منفصلة</button></a>
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
<!-- Magnific Popup-->
<script src="<?php echo base_url(); ?>assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- lightbox init js-->
<script src="<?php echo base_url(); ?>assets/js/pages/lightbox.init.js"></script>

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
<script src="<?php echo base_url(); ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/toastr.init.js"></script>

<script>
    $("table").DataTable({
        language: {
            url: '<?php echo base_url(); ?>assets/js/arabic_datatable.json'
        }
    });

    $("#Techers,#Students").slideUp();
    $(document).ready(function() {

        var Test_type = "Thermometer";
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
            $('.showInPageCard ').removeClass('hide-card');
            var selectedclass = $(this).children("option:selected").val();
            var href = "<?php echo base_url() ?>AR/Schools/Class_Avatars/" + selectedclass;
            $('#Students_Link').attr('href', href);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Schools/ListStudentsChangeAvatar',
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

        $('.sync').click(function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Ajax/sync',
                beforeSend: function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'بدأت عملية المزامنة , الرجاء الإنتظار بضع دقائق',
                        showConfirmButton: false,
                        timer: 2500,
                        backdrop: false,
                    });
                    $('.sync').addClass('sync_start');
                },
                success: function(data) {
                    $('.sync').removeClass('sync_start');
                    Swal.fire({
                        icon: 'success',
                        text: data,
                    });
                    setTimeout(function() {
                        //location.reload();
                    }, 2000);
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
</script>

</html>