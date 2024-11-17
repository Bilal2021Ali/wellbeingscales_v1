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
        left: 50%;
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
            </div>	<br>
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH P014: Upload (Students, Teachers, Staff)</h4>
            <div class="container-fluid">
                <div class="col-lg-8 offset-lg-1 centered">
                    <a href="<?= base_url("EN/schools/LoadFromCsv/teachers"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--cyan);">
                                <img src="<?= base_url("assets/images/icons/teachers.png") ?>" alt="">
                                <h4 class="text-white">Teachers <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url("EN/schools/LoadFromCsv/staff"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--red);">
                                <img src="<?= base_url("assets/images/icons/Staffs.png") ?>" alt="">
                                <h4 class="text-white">Staff <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url("EN/schools/LoadFromCsv/students"); ?>">
                        <div class="card">
                            <div class="card-body firstCard text-center border-ronded" style="background: var(--purple);">
                                <img src="<?= base_url("assets/images/icons/Students.png") ?>" alt="">
                                <h4 class="text-white">Students <i class="uil uil-arrow-right"></i></h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>