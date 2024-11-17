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

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
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

    .uil-trash {
        cursor: pointer;
        color: #C02326;
    }
</style>

<html lang="en">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<?php

$supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`AR_UserType` 
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` AND `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "' " )->result_array();

?>
<link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body class="light menu_light logo-white theme-white">
    <section class="content">
        <div class="main-content">
            <div class="page-content">

                <div class="container-fluid" style="overflow: auto;">
                    <div class="page-title-right">
                        <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                            List of System Users by Type - <?= $sessiondata['f_name'] ?>
                        </h4>
                    </div>
                    <?php if (!isset($dontshowchart)) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="SelectFromClass">Choose Type of Users</label>
                                        <select name="UserType" class="form-control" id="UserType">
                                            <option value="">Choose Type </option>
                                            <?php foreach ($supported_types as $pref) : ?>
                                                <option value="<?= $pref['UserType']; ?>">
                                                    <?= $pref['UserType']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="hereGetedUsers">
                                            <h4 class="card-title mb-4">Choose Type of Users</h4>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->
                            </div>
                        </div>
                    <?php } ?>
                    <div class="">
                        <div class="card">
                            <div class="card-body" style="overflow: auto;">
                                <a class="font-bold mb-4 float-right d-block w-100" href="<?= base_url('EN/Company-Departments/card') ?>"><i class="uil uil-angle-double-right"></i> Show All The Users Cards</a>
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Img </th>
                                            <th> Name </th>
                                            <th> National ID </th>
                                            <th> Nationality </th>
                                            <th> User Type </th>
                                            <th> Edit </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listofaStaffs as $sn => $admin) { ?>
                                            <tr id="User_<?= $admin['Id'] ?> ">
                                                <th scope="row"><?= $sn + 1; ?></th>
                                                <td>
                                                    <?php if (empty($admin['Link'])) {  ?>
                                                        <img src="https://ui-avatars.com/api/?name=<?= $admin['F_name_EN'] . '+' . $admin['L_name_EN'] ?>&background=random" alt="" class="avatar-xs rounded-circle">
                                                    <?php  } else {  ?>
                                                        <img src="<?= base_url() ?>uploads/co_avatars/<?= $admin['Link']  ?>" alt="<?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN'] ?>" class="avatar-xs rounded-circle">
                                                    <?php  } ?>
                                                </td>
                                                <td><?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                                                <td><?= $admin['National_Id']; ?> </td>
                                                <td><?= $admin['Nationality']; ?></td>
                                                <?php $userTranslate = $this->db->query("SELECT `UserType` FROM `r_usertype` 
                                                WHERE UserType = '" . $admin['UserType']  . "' " )->result_array(); ?>
                                                <?php if (!empty($userTranslate)) { ?>
                                                    <td><?= $userTranslate[0]['UserType']; ?></td>
                                                <?php } else { ?>
                                                    <td> UnKnown </td>
                                                <?php } ?>
                                                <td>
                                                    <a href="<?= base_url() ?>EN/Company-Departments/UpdatePatientData/<?= $admin['User_Id']; ?>">
                                                        <i class="uil-pen" style="font-size: 25px;" title="edit"></i>
                                                    </a>
                                                    <a href="<?= base_url() ?>EN/Company-Departments/card/<?= $admin['User_Id']; ?>">
                                                        <i class="mdi mdi-card-bulleted" style="font-size: 25px;" title="Edit"></i>
                                                    </a>
                                                    <a href="<?= base_url(); ?>EN/Company-Departments/user_permissions/<?= $admin['User_Id']; ?>">
                                                        <i class="uil uil-keyhole-circle" style="font-size: 25px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Permissions"></i>
                                                    </a>
                                                    <i class="uil-trash" style="font-size: 25px;" onClick="DeleteUser(<?= $admin['User_Id'] ?>,'<?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?>','<?= $admin['National_Id']  ?>','<?= $admin['UserType'] ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    </table>
                </div>
            </div>
        </div>
        </div>

    </section>
    <script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script>
        var table_st = $('#table').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
        });
        table_st.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

        $('input[type="checkbox"]').each(function() {
            $(this).change(function() {
                var theAdminId = $(this).attr('theAdminId');
                console.log(theAdminId);
                console.log(this.checked);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/Company_Departments/changeSchoolstatus',
                    data: {
                        adminid: theAdminId,
                    },
                    success: function(data) {
                        Swal.fire(
                            'success',
                            data,
                            'success'
                        )
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
        });

        <?php if ($this->session->flashdata('email_sended')) { ?>
            try {
                setTimeout(function() {
                    $('.alert.alert-success').addClass('alert-hide')
                    $('.container-fluid').css('margin-top', '0px')
                }, 3000);
            } catch (err) {

            }
        <?php } ?>

        $("#UserType").change(function() {
            var selectedclass = $(this).children("option:selected").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Company_Departments/ChartTempOfUsers',
                data: {
                    UserType: selectedclass,
                },
                beforeSend: function() {
                    // setting a timeout
                    $("#hereGetedUsers").html('Please Wait.....');
                },
                success: function(data) {
                    $('#hereGetedUsers').html("");
                    $('#hereGetedUsers').html(data);
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

        function DeleteUser(id, name, national_id, usertype) {
            Swal.fire({
                title: " Are you sure you want to delete " + name,
                showCancelButton: true,
                confirmButtonText: `Yes`,
                cancelButtonText: `Cancel`,
                icon: 'warning',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url(); ?>EN/Company_Departments/DeleteUser',
                        data: {
                            userid: id,
                            national_id: national_id,
                            user_type: usertype,
                        },
                        success: function(data) {
                            Swal.fire(
                                'success',
                                data,
                                'success'
                            );
                            $('#User_' + id).fadeOut();
                        },
                        ajaxError: function() {
                            Swal.fire(
                                'error',
                                'oops!! we have a error',
                                'error'
                            )
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>