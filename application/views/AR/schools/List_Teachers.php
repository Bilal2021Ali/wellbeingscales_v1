<!doctype html>
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
        background-color: #ccc;
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
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
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

    .change-attendance-status {
        width: 25px;
        height: 25px;
        margin-bottom: 6px;
    }
</style>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
      rel="stylesheet" type="text/css"/>
<style>
    .uil-trash {
        color: #DB0002;
        cursor: pointer;
    }

    .uil-credit-card {
        color: rgba(2, 110, 17, 1.00);
    }
</style>
<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
      rel="stylesheet" type="text/css"/>

<body class="light menu_light logo-white theme-white">
<app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
    <!---->
    <app-main _nghost-pjk-c134="" class="ng-star-inserted">
        <section class="content">

            <div class="main-content">
                <div class="page-content">
                    <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                        CH 032 الرسم البياني - درجات حرارة المعلمين اليومية</h4>
                    <div class="row">
                        <div class="col-md-6 col-xl-4 InfosCards">
                            <div class="card">
                                <div class="card-body" style="background-color: #2a3143;">
                                    <div class="float-right mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png"
                                                alt="schools" width="64px"></div>
                                    <div>
                                        <?php
                                        $allStaff = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                        $lastsStaff = $this->db->query("SELECT * FROM `l2_staff` ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                                                    <?= $allStaff ?>
                                                </span></h4>
                                        <p class="mb-0">مجموع الموظفين</p>
                                    </div>
                                    <?php if (!empty($lastsStaff)) { ?>
                                        <?php foreach ($lastsStaff as $lastStaff) { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                        <?= $lastStaff['TimeStamp'] ?>
                                                    </span><br>
                                            آخر موظف تم إضافته
                                        <?php } ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1"
                                                                   style="color: #e1da6a;"> --/--/-- </span><br>
                                            آخر موظف تم إضافته</p>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                        <!-- end col-->
                        <div class="col-md-6 col-xl-4 InfosCards">
                            <div class="card">
                                <div class="card-body" style="background-color: #8a1327;">
                                    <div class="float-right mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/teachers.png"
                                                alt="schools" width="64px"></div>
                                    <div>
                                        <?php
                                        $all_Teachers = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                        $lasTeachers = $this->db->query("SELECT * FROM `l2_teacher` ORDER BY Id DESC LIMIT 1 ")->result_array();
                                        ?>
                                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                                                    <?= $all_Teachers ?>
                                                </span></h4>
                                        <p class="mb-0">مجموع المعلمين </p>
                                        </p>
                                    </div>
                                    <?php if (!empty($lasTeachers)) { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach ($lasTeachers as $Teacher) { ?>
                                            <?= $Teacher['TimeStamp'] ?>
                                            </span><br>
                                            آخر معلم تم إضافته
                                        <?php } ?>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1"
                                                                   style="color: #e1da6a;"> --/--/-- </span><br>
                                            آخر معلم تم إضافته</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-md-6 col-xl-4 InfosCards">
                            <div class="card">
                                <div class="card-body" style="background-color: #123360;">
                                    <div class="float-right mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/Students.png"
                                                alt="schools" width="64px"></div>
                                    <div>
                                        <?php
                                        $allStudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                        $lastsStudents = $this->db->query("SELECT * FROM `l2_student` ORDER BY Id DESC LIMIT 1 ")->result_array();

                                        ?>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                                                    <?= $allStudents ?>
                                                </span></h4>
                                        <p class="mb-0">مجموع الطلاب</p>
                                    </div>
                                    <?php if (!empty($lastsStudents)) { ?>
                                        <?php foreach ($lastsStudents as $lastStudents) { ?>
                                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                                        <?= $lastStudents['TimeStamp'] ?>
                                                    </span><br>
                                            آخر طالب تم إضافته
                                        <?php } ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="mt-3 mb-0"><span class="mr-1"
                                                                   style="color: #e1da6a;"> --/--/-- </span><br>
                                            آخر طالب تم إضافته</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end col-->

                    </div>
                    <br>
                    <h4 class="card-title"
                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        CH 033 تعديل بيانات المعلمين - بطاقة QR</h4>
                    <div class="container-fluid" style="overflow: auto;">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">المعلمين</a></li>
                                <li class="breadcrumb-item active">قائمة</li>
                                <a href="<?php echo base_url(); ?>AR/Schools/infos_Card/AllTeachers"
                                   style="position: absolute;right: 10px;"> عرض قائمة جميع المعلمين <i
                                            class="uil-arrow-up-right"></i> </a>
                            </ol>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> الصورة</th>
                                        <th> الاسم</th>
                                        <th> الرقم الوطني</th>
                                        <th> رقم الهاتف</th>
                                        <th> الجنسية</th>
                                        <th> التخصص</th>
                                        <th> الحالة</th>
                                        <th> تحديث</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sn = 0;
                                    foreach ($Teachers as $admin) {
                                        $sn++;
                                        ?>
                                        <tr id="User_<?php echo $admin['Id'] ?>">
                                            <th scope="row"><?php echo $sn; ?></th>
                                            <?php
                                            $avatars = $this->db->query("SELECT * FROM `l2_avatars` 
                                                    WHERE `For_User` = '" . $admin["Id"] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                            if (!empty($avatars)) {
                                                foreach ($avatars as $avatar) {
                                                    ?>
                                                    <td><img class="rounded-circle img-thumbnail avatar-sm"
                                                             src="<?php echo base_url() . "uploads/avatars/" . $avatar['Link']; ?>"
                                                             alt="Not Found"></td>
                                                <?php }
                                            } else { ?>
                                                <td><img class="rounded-circle img-thumbnail avatar-sm"
                                                         src="<?php echo base_url() . "uploads/avatars/default_avatar.jpg"; ?>"
                                                         alt="Not Found"></td>
                                            <?php } ?>
                                            <td><?= $admin['F_name_AR'] . ' ' . $admin['L_name_AR']; ?></td>
                                            <td><?= $admin['National_Id']; ?></td>
                                            <td><?= $admin['Phone']; ?></td>
                                            <td><?= $admin['Nationality']; ?></td>
                                            <td><?= $admin['Position_name'] ?? "--"; ?></td>
                                            <td>
                                                <input type="checkbox" class="user-status" id="user-<?= $sn ?>"
                                                       data-key="<?= $admin["Id"] ?>"
                                                       switch="success" <?= $admin['status'] == 1 ? "checked" : "" ?>>
                                                <label for="user-<?= $sn ?>" data-on-label=""
                                                       data-off-label=""></label>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url() ?>AR/schools/UpdateTeacher/<?php echo $admin['Id']; ?>">
                                                    <i class="uil-pen" style="font-size: 25px;" data-toggle="tooltip"
                                                       data-placement="top" title="تعديل"></i> </a>
                                                <a href="<?php echo base_url() ?>AR/schools/infos_Card/Teacher/<?php echo $admin['Id']; ?>">
                                                    <i class="uil-credit-card" style="font-size: 25px;"
                                                       data-toggle="tooltip" data-placement="top" title="بطاقة"></i>
                                                </a>
                                                <i class="uil-trash" style="font-size: 25px;"
                                                   onClick="DeleteUser(<?php echo $admin['Id'] ?>,'<?php echo $admin['F_name_AR'] . ' ' . $admin['L_name_AR']; ?>','<?php echo $admin['National_Id'] ?>')"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="حذف"></i>
                                                <?php if ($attendance_permissions) { ?>
                                                    <span class="my-2">|</span>
                                                    <button data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="<?= $admin["AbsenceRecord"] > 0 ? "سجله كحاضر" : "سجله كغائب" ?>"
                                                            data-id="<?= $admin['Id'] ?>"
                                                            class="btn btn-<?= $admin["AbsenceRecord"] > 0 ? "success" : "danger" ?> btn-rounded waves-effect waves-light p-0 change-attendance-status">
                                                        <i class="uil uil-times"></i>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
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
        <?php $this->load->view("EN/schools/inc/list-status-change-script", ['type' => 'teachers']); ?>
        <script>
            $("table").DataTable();

            function DeleteUser(id, name, national_id) {
                Swal.fire({
                    title: " هل أنت متأكد أنك تريد حذف " + name,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `نعم`,
                    cancelButtonText: `إلغاء`,
                    icon: 'warning',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>AR/Schools/DeleteUser',
                            data: {
                                userid: id,
                                userType: 'Teacher',
                                national_id: national_id,
                            },
                            success: function (data) {
                                Swal.fire(
                                    'success',
                                    data,
                                    'success'
                                );
                                $('#User_' + id).fadeOut();
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! لدينا خطأ',
                                    'error'
                                )
                            }
                        });
                    }
                })
            }

            $(".table").on("click", ".change-attendance-status", function () {
                const $this = $(this);
                console.log($this);
                $($this).attr("disabled", "");
                const key = $(this).attr("data-id");
                $.ajax({
                    type: "POST",
                    url: "<?= base_url("EN/Ajax/absence-control")  ?>",
                    data: {
                        userid: key,
                        usertype: "teacher"
                    },
                    success: function (response) {
                        $($this).removeAttr("disabled");
                        if (response.status == "ok") {
                            $($this).removeClass("btn-danger btn-success");
                            $($this).addClass(response.to == "absent" ? "btn-success" : "btn-danger");
                            $($this).attr("data-original-title", response.to == "absent" ? "سجله كحاضر" : "سجله كغائب");
                        } else {
                            Swal.fire(
                                'error',
                                response.message,
                                'error'
                            )
                        }
                    }
                });
            });

            table.on('draw', function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
</body>

</html>