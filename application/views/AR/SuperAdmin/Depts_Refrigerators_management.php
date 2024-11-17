<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>
<style>
    .connected {
        text-align: center;
    }
</style>
<?php
print_r($depts);
?>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <?php foreach ($depts as $dept) {  ?>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="clearfix"></div>
                                    <div class="mb-4">
                                        <img src="<?php echo base_url() ?>uploads/avatars/<?php echo empty($dept['Dept_puc']) ? "default_avatar.jpg" : $dept['Dept_puc'];  ?>" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?php echo $dept['Dept_name']  ?></a></h5>
                                    <p class="text-muted mb-2"><a href="mailto:<?php echo $dept['dept_email']  ?>"><?php echo $dept['dept_email']  ?></a></p>
                                    <p class="test-muted mb-2">Refrigerators counter : <span data-plugin="counterup"><?php echo $dept['refs_counter']; ?></span></p>
                                </div>

                                <div class="btn-group" role="group">
                                    <a href="<?php echo base_url() ?>EN/Dashboard/Manage_depts_Refrigerators/<?php echo $dept['dept_id']  ?>" class="btn btn-outline-light text-truncate">
                                        Manage Connects
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php  }  ?>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
    <script>
        $('.table').DataTable();
    </script>
</body>

</html>