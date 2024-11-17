
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
<title> Sorry You Cant Enter To This Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />
<!-- App favicon -->
<link rel="shortcut icon" href="/assets/images/favicon.ico">
        <!-- Light layout Bootstrap Css -->
<link href="<?php echo base_url(); ?>assets/css/bootstrap-dark.min.css" id="bootstrap-dark-style" disabled="disabled" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo base_url(); ?>assets/css/app-dark.min.css" id="app-dark-style" disabled="disabled" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/app-rtl.min.css" id="app-rtl-style" disabled="disabled" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="my-5 pt-sm-5">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="error-img">
                                            <img src="<?php echo base_url(); ?>assets/images/404-error.png" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <?php if(isset($Title)){ ?>    
                            <h4 class="text-uppercase mt-4"><?php echo $Title; ?></h4>
                             <?php }else{ ?>
                            <h4 class="text-uppercase mt-4">Sorry</h4>
                             <?php }?>
                             <?php if(isset($Desc)){ ?>
                            <p class="text-muted"><?php echo $Desc; ?></p>
                             <?php }else{ ?>   
                            <p class="text-muted">You cannot use these links. This is just a preview.</p>
                             <?php } ?> 
                             <?php if(isset($Link)){ ?>
                            <div class="mt-5">
                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo base_url()."".$Link; ?>">Back</a>
                            </div>
                             <?php }else{ ?>
                            <div class="mt-5">
                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo base_url(); ?>">Back to Dashboard</a>
                            </div>
                             <?php } ?>
                        </div>
                         
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>ssets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>

    </body>
</html>
