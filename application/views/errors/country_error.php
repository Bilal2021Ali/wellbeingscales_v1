<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.css'); ?>" rel="stylesheet">
    <title>Error</title>
</head>
<body class="authentication-bg">

<div class="my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="home-wrapper">
                    <a href="/" class="mb-5 d-block auth-logo">
                        <img src="<?= base_url("assets/images/settings/logos/") . $logo; ?>" alt="" height="22"
                             class="logo logo-light">
                    </a>

                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-5">
                            <div class="maintenance-img">
                                <img src="<?= $image ?>" alt=""
                                     class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <h3 class="mt-5"><?= $title ?></h3>
                    <p><?= $content ?></p>

                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</div>

<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/assets/libs/node-waves/waves.min.js"></script>
<script src="/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<!-- owl.carousel js -->
<script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>
<!-- init js -->
<script src="assets/js/pages/auth-carousel.init.js"></script>

<script src="assets/js/app.js"></script>


<div at-magnifier-wrapper="">
    <div class="at-theme-light">
        <div class="at-base notranslate" translate="no">
            <div class="EuwGd" style="top: 0px; left: 0px;"></div>
        </div>
    </div>
</div>
</body>
</html>