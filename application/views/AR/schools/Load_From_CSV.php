<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 40%;
        transform: translate(-50%, -50%);
    }

    .centered .card {
        border: 0px;
        border-radius: 20px;
    }

    .centered .card img {
        width: 100px;
        float: left;
        position: absolute;
        top: -11px;
        left: 7px;
    }

    .card-body.border-ronded {
        border-radius: 6px;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="col-lg-8 centered">
                    <a href="<?= base_url("AR/schools/LoadFromCsv/teachers"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--cyan);">
                                <img src="<?= base_url("assets/images/icons/teachers.png") ?>" alt="">
                                <h4 class="text-white"> المعلمين <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url("AR/schools/LoadFromCsv/staff"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--red);">
                                <img src="<?= base_url("assets/images/icons/Staffs.png") ?>" alt="">
                                <h4 class="text-white"> الموظفين <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url("AR/schools/LoadFromCsv/students"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--purple);">
                                <img src="<?= base_url("assets/images/icons/Students.png") ?>" alt="">
                                <h4 class="text-white"> الطلاب <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
</body>

</html>