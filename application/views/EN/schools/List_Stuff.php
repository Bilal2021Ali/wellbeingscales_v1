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
</style>
<html lang="en">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<!-- DataTables -->
<link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
      rel="stylesheet" type="text/css"/>
<style>
    .uil-trash {
        color: #DB0002;
        cursor: pointer;
    }

    .uil-credit-card {
        color: rgba(2, 110, 17, 1.00);
    }

    .change-attendance-status {
        width: 25px;
        height: 25px;
        margin-bottom: 6px;
    }
</style>

<body class="light menu_light logo-white theme-white">
<section class="content">
    <div class="main-content">
        <div class="page-content">
            <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 030
                Staff List</h4>
            <div class="row">
                <div class="col-md-6 col-xl-4 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #2a3143;">
                            <div class="float-right mt-2"><img
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="schools"
                                    width="64px"></div>
                            <div>
                                <?php
                                $allStaff = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                $lastsStaff = $this->db->query("SELECT * FROM `l2_staff` ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                      <?= $allStaff ?>
                    </span></h4>
                                <p class="mb-0">Total Staff</p>
                            </div>
                            <?php if (!empty($lastsStaff)) { ?>
                                <?php foreach ($lastsStaff as $lastStaff) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                        <?= $lastStaff['TimeStamp'] ?>
                      </span><br>
                                    Last Registered Staff
                                <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                                    Last Registered Staff </p>
                            <?php } ?>
                        </div>

                    </div>

                </div>
                <!-- end col-->
                <div class="col-md-6 col-xl-4 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #8a1327;">
                            <div class="float-right mt-2"><img
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/teachers.png" alt="schools"
                                    width="64px"></div>
                            <div>
                                <?php
                                $all_Teachers = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                $lasTeachers = $this->db->query("SELECT * FROM `l2_teacher` ORDER BY Id DESC LIMIT 1 ")->result_array();
                                ?>
                                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $all_Teachers ?>
                    </span></h4>
                                <p class="mb-0">Total Teachers </p>
                                </p>
                            </div>
                            <?php if (!empty($lasTeachers)) { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                <?php foreach ($lasTeachers as $Teachers) { ?>
                                    <?= $Teachers['TimeStamp'] ?>
                                    </span><br>
                                    Last Registered Teacher
                                <?php } ?>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                                    Last Registered Teacher </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-md-6 col-xl-4 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #123360;">
                            <div class="float-right mt-2"><img
                                    src="<?= base_url(); ?>assets/images/icons/png_icons/Students.png" alt="schools"
                                    width="64px"></div>
                            <div>
                                <?php
                                $allStudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                $lastsStudents = $this->db->query("SELECT * FROM `l2_student` ORDER BY Id DESC LIMIT 1 ")->result_array();

                                ?>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                      <?= $allStudents ?>
                    </span></h4>
                                <p class="mb-0">Total Students</p>
                            </div>
                            <?php if (!empty($lastsStudents)) { ?>
                                <?php foreach ($lastsStudents as $lastStudents) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                        <?= $lastStudents['TimeStamp'] ?>
                      </span><br>
                                    Last Registered Student
                                <?php } ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                                    Last Registered Student </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
            </div>
            <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 031
                Edit, Delete, and Print QR Code for Staff</h4>
            <div class="container-fluid" style="overflow: auto;">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                        <li class="breadcrumb-item active">List</li>
                        <a href="<?= base_url(); ?>EN/Schools/infos_Card/AllStaffs"
                           style="position: absolute;right: 10px;"> List of Staff<i class="uil-arrow-up-right"></i> </a>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> Img</th>
                                <th> Name</th>
                                <th> National ID</th>
                                <th> Phone Number</th>
                                <th> Nationality</th>
                                <th> Position</th>
                                <th> Status</th>
                                <th> Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listofaStaffs as $sn => $admin) { ?>
                                <tr id="User_<?= $admin['Id'] ?>">
                                    <th scope="row"><?= $sn + 1; ?></th>
                                    <?php
                                    $avatars = $this->db->query("SELECT * FROM `l2_avatars` 
                      WHERE `For_User` = '" . $admin["Id"] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                    if (!empty($avatars)) {
                                        $avatar = $avatars[0]; ?>
                                        <td><img class="rounded-circle img-thumbnail avatar-sm"
                                                 src="<?= base_url() . "uploads/avatars/" . $avatar['Link']; ?>"
                                                 alt="Not Found"></td>
                                    <?php } else { ?>
                                        <td><img class="rounded-circle img-thumbnail avatar-sm"
                                                 src="<?= base_url() . "uploads/avatars/default_avatar.jpg"; ?>"
                                                 alt="Not Found"></td>
                                    <?php } ?>
                                    <td><?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
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
                                        <a href="<?= base_url() ?>EN/schools/UpdateStaffData/<?= $admin['Id']; ?>">
                                            <i class="uil-pen" style="font-size: 25px;" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Edit"></i> </a>
                                        <a href="<?= base_url() ?>EN/schools/infos_Card/Staff/<?= $admin['Id']; ?>">
                                            <i class="uil-credit-card" style="font-size: 25px;" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Card"></i> </a>
                                        <i class="uil-trash" style="font-size: 25px;"
                                           onClick="DeleteUser(<?= $admin['Id'] ?>,'<?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?>','<?= $admin['National_Id'] ?>')"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="Delete"></i>
                                        <?php if ($attendance_permissions) { ?>

                                            <?php /*?><button data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $admin["AbsenceRecord"] > 0 ? "Mark as Present" : "Mark as Absent" ?>" data-id="<?= $admin['Id'] ?>" class="btn btn-<?= $admin["AbsenceRecord"] > 0 ? "success" : "danger" ?> btn-rounded waves-effect waves-light p-0 change-attendance-status">
                            <i class="uil uil-times"></i>
                          </button><?php */ ?>
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
    </div>
</section>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<?php
// $list = array();
// $today = date("Y-m-d");
// $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
// foreach ($Ourstaffs as $staff) {
//   $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
//   $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
//       AND Result_Date = '" . $today . "' AND UserType = 'Staff'  ORDER BY `Id` DESC LIMIT 1")->result_array();
//   foreach ($getResults as $results) {
//     $list[] = array("Username" => $staffname, "Result" => $results['Result']);
//   }
// }
?>
<?php $this->load->view("EN/schools/inc/list-status-change-script", ['type' => 'staff']); ?>
<!-- apexcharts init -->
<script>
    var options = {
            chart: {
                height: 300,
                type: "line",
                zoom: {
                    enabled: !1
                },
                toolbar: {
                    show: !1
                }
            },
            colors: ["#5b73e8"],
            dataLabels: {
                enabled: !1
            },
            stroke: {
                width: [3, 3],
                curve: "straight"
            },
            series: [{
                name: "Temperature",
                // here data
                data: [<?php foreach ($list as $finalresults) {
                    echo $finalresults['Result'] . ',';
                } ?>]
            }],
            title: {
                text: "Monitor Staff Temperature",
                align: "left"
            },
            grid: {
                row: {
                    colors: ["transparent", "transparent"],
                    opacity: .2
                },
                borderColor: "#f1f1f1"
            },
            markers: {
                style: "inverted",
                size: 6
            },
            xaxis: {
                categories: [<?php foreach ($list as $names) {
                    echo '"' . $names['Username'] . '",';
                } ?>],
                title: {
                    text: "Staff Temperature"
                }
            },
            yaxis: {
                title: {
                    text: "Temperature"
                },
                min: 30,
                max: 40
            },
            legend: {
                position: "top",
                horizontalAlign: "right",
                floating: !0,
                offsetY: -25,
                offsetX: -5
            },
            labels: {
                show: !1,
                formatter: function (e) {
                    return e
                }
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        toolbar: {
                            show: !1
                        }
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        },
        chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options);
    chart.render();
</script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script>
    const table = $("table").DataTable();
</script>
<script>
    function DeleteUser(id, name, national_id) {
        Swal.fire({
            title: " Are you sure you want to delete " + name + "?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/Schools/DeleteUser',
                    data: {
                        userid: id,
                        userType: 'Staff',
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
                            'oops!! we have a error',
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
                usertype: "staff"
            },
            success: function (response) {
                $($this).removeAttr("disabled");
                if (response.status == "ok") {
                    $($this).removeClass("btn-danger btn-success");
                    $($this).addClass(response.to == "absent" ? "btn-success" : "btn-danger");
                    $($this).attr("data-original-title", response.to == "absent" ? "Mark as Present" : "Mark as Absent");
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