<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
    <link href="<?php echo base_url() ?>assets/libsArea/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
    <link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css" />
    </head>
    <style>
        .image_container img {
            margin: auto;
            width: 100%;
            max-width: 800px; 
        }
    </style>
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
            </div>
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">AI 038: CLIMATES</h4>
            <div class="row">
                <?php foreach ($links as $link) { ?>
                    <div class="col-md-4">
                        <div class="card card-body">
                            <h3 class="card-title mt-0"><?= $link['name'] ?></h3>
                            <p class="card-text"><?= $link['desc'] ?></p>
                            <a href="<?= $link['link']; ?>" class="btn btn-warning waves-effect waves-light">Generate</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>