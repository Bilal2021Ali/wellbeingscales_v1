<!doctype html>
<html lang="en">
<head>
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>     
</head>
     
<body class="light menu_light logo-white theme-white" cz-shortcut-listen="true">
<div class="mapouter" style="display: block;z-index: 0;position: absolute;">
     <div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=qatar&t=&z=7&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
     </div>
     <style>
          .mapouter {
               position: relative;
               text-align: right;
               height: 100%;
               width: 100%;
          }
          
          .gmap_canvas {
               overflow: hidden;
               background: none!important;
               height: 100%;
               width: 100%;
          }
          .account-pages {
	          padding-top: 50px;
          }                    
          .mt-5, .my-5{
               margin-top: 0px !important;
          }
          .outer{
               position: absolute;
               top: 0px;
               left: 0px;
               width: 100%;
               height: 100%;
               background: rgba(0,0,0,0.55);
          }
          
     </style>
</div> 
<div class="outer"></div>     
     <body class="authentication-bg">

        <div class="account-pages">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                           
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
<img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" width="100%" class="logo logo-dark">

                                    <h5 class="text-primary">Welcome</h5>
                                    <p class="text-muted" id="statusbox"> Enter Your Email</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="EmailCheck">
                                        <div class="form-group" id="usernameForm">
                                            <label for="userpassword">Enter Your User name</label>
                                            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                                        </div>
                                        <div class="mt-3 text-right">
               <button  class="btn btn-primary w-sm waves-effect waves-light" type="Submit">Log In</button>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                             <p>© 2022 V2.0 Track Qlickhealth</p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
</body>
<script src="<?php echo base_url()?>/assets/js/jquery-3.3.1.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script>

$("#EmailCheck").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/users/checkemail',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
               $('#statusbox').css('display','block');
               $('#statusbox').html('please wait !!');
               $('button').html('please wait...');
               $('button').attr('disabled','');
          },
          success: function (data) {
               $('#statusbox').html(data);
               $('button').html('submit');
               $('button').removeAttr('disabled');
          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});
     

     
<?php 
     
  /* $expFormat = mktime(
   date("H"), date("i"), date("s"), date("M") ,date("d")+1, date("Y")
   );
   $expDate = date("Y-m-d H:i:s",$expFormat);
   $key = md5(2418*2+$email);
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $key = $key . $addKey;
   // Insert Temp Table
   mysqli_query($con,
   "INSERT INTO `password_reset_tbl` (`email`, `key`, `expDate`)
   VALUES ('".$email."', '".$key."', '".$expDate."');");*/
      
?>     
     
</script>
</html>