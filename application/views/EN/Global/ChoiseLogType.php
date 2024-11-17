
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
<title>Files.Maintenance Page | Minible - Responsive Bootstrap 4 Admin Dashboard</title>
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
<style>
		
	.maintenance-box:hover{
		transform: scale(1.02);
		transition: 0.5s all;
		cursor: pointer;
	}	
	
	
.toast_data {
    width: 210px;
    background: #0000007a;
    color: #fff;
    text-align: center;
    position: absolute;
    padding: 10px;
    border-radius: 5px;
    bottom: -60px;
    margin: auto;
    left: 43%;
	transition: 0.5s all;
}
	
.toast_data_Show{
    bottom: 10px;
}	
	
</style>
		
    </head>

    <body class="authentication-bg">
<div id="preloader" style="display: none;">
	<div id="status" style="display: none;">
		<div class="spinner">
			<i class="uil-shutter-alt spin-icon"></i>
		</div>
	</div>
</div>
        <div class="home-btn d-none d-sm-block">
            <a href="<?php echo base_url(); ?>EN/Users" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
        </div>
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="home-wrapper">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-sm-5">
                                    <div class="maintenance-img">
                                        <img src="<?php echo base_url(); ?>assets/images/complet_reg.png" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                            <h3>We Found Two Types of Login You Can Use !!</h3>
                            <p>Please check Whats The Best Way For You ?</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mt-4 maintenance-box" onClick="Log_as('<?php echo $Secondtype; ?>')">
                                        <div class="card-body p-4">
                                            <div class="avatar-sm mx-auto mb-4">
                                                <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                                    <i class="uil uil-cloud-wifi"></i>
                                                </div>
                                            </div>
                                            <h5 class="font-size-15 text-uppercase">Login as a 
											<strong><?php echo $Secondtype; ?></strong></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mt-4 maintenance-box" onClick="Log_as('Parent')">
                                        <div class="card-body p-4">
                                            <div class="avatar-sm mx-auto mb-4">
                                                <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-20">
                                                    <i class="uil uil-envelope-alt"></i>
                                                </div>
                                            </div>
                                            <h5 class="font-size-15 text-uppercase">
                                                Login as a <strong>Parent</strong>
											</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
				<div class="toast_data"></div>
            </div>
            <!-- end container -->
        </div>

        <!-- JAVASCRIPT -->
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <!-- owl.carousel js -->
        <script src="<?php echo base_url(); ?>assets/libs/owl.carousel/owl.carousel.min.js"></script>
        <!-- init js -->
        <script src="<?php echo base_url(); ?>assets/js/pages/auth-carousel.init.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script>
 function Log_as(as){
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Users/ChekLogInType',
          data: {
			  Type : as,
			  Name : "<?php echo $name; ?>",
		  },
          beforeSend: function () {
               $('#preloader').show();
          },
          success: function (data) {
			   $('.toast_data').addClass('toast_data_Show');
               $('.toast_data').html(data);
			   
          },
          ajaxError: function(){
			   $('.toast_data').addClass('Stoast_data_show_Error');
			   $('.toast_data').html('Oops ! We Have Error !!');
			  
          }
     });
 }		
</script>
    </body>
</html>
