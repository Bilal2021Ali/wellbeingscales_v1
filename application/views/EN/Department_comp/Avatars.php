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

    .sync {
        cursor: pointer;
    }

</style>
<?php

$supported_types = $this->db->query("SELECT `r_usertype`.`Id` , `r_usertype`.`UserType`
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
AND `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "' GROUP BY `r_usertype`.`Id` ")->result_array();

?>
<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body>
    <div class="main-content">
        <div class="page-content">

            <div class="row">
                <div class="col-12">
                    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                        List of System Users Pictures in <?= $sessiondata['f_name'] ?>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <i class="bx bx-rotate-left sync" data-toggle="tooltip" data-placement="top" title="" data-original-title="Click here to start the syncing process for the photos"></i>
                                    <label>Select User Type</label>
                                    <select class="custom-select" id="SelectUserType" name="Prefix">
                                        <option value=""> List </option>
                                        <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
                                        <?php foreach ($supported_types as $pref) : ?>
                                            <option value="<?= $pref['Id']; ?>">
                                                <?= $pref['UserType']; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table_container">
                            <h4> Please Select Type of User </h4>
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
<script>
    $("table").DataTable();

    $("#SelectUserType").change(function() {
        var selectedclass = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Company_Departments/ChangeAvatarList',
            data: {
                usertype: selectedclass,
            },
            beforeSend: function() {
                // setting a timeout
                $(".table_container").html('please wait...');
            },
            success: function(data) {
                $('.table_container').html(data);
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

    $('.sync').click(function() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Ajax/sync',
            beforeSend: function() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Synchronization is starting. Please wait for a few minutes.',
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
                    'oops!! we have a error',
                    'error'
                )
            }
        });
    });
</script>

</html>