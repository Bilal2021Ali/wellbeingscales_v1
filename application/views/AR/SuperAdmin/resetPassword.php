
<!doctype html>
<html lang="en">

    <body class="authentication-bg">

        <div class="home-btn d-none d-sm-block">
            <a href="<?php echo base_url(); ?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
        </div>
        <div class="account-pages my-5  pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div>
                            
                            <a href="<?php echo base_url(); ?>" class="mb-5 d-block auth-logo">
                                <img src="<?php echo base_url(); ?>assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark">
                                <img src="<?php echo base_url(); ?>assets/images/logo-light.png" alt="" height="22" class="logo logo-light">
                            </a>
                            <div class="card">
                                <div class="card-body p-4"> 
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Reset Password</h5>
                                        <p class="text-muted">Reset Password with Minible.</p>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <?php if($show == "error"){ ?>
                                         <p>The link is invalid/expired. Either you did not Follow the correct link
                                        from the email, or you have already used the key in which case it is 
                                        desactivated</p>
                                         <a href="<?php echo base_url(); ?>"><button type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Back To Login Page</button></a>
                                         <?php }else{ ?>
                                          <?php print_r($array);
                                         foreach($array as $row){ 
                                            $expDate = $row['expDate'];
                                            $curDate = date("Y-m-d H:i:s");
                                            if ($expDate >= $curDate){ ?>
                                         <form>
                                            <div class="form-group showandhide">
                                                <label for="pass1">New Password</label>
                                                <input type="text" class="form-control" id="pass1" placeholder="Enter New Password">
                                            </div>
                                              
                                            <div class="form-group">
                                                <label for="pass2">New Password</label>
                                             <div class="input-group mb-2 mr-sm-3 showandhide">
                                                <input type="text" class="form-control" id="pass2" placeholder="Enter New Password Again">
                                             <div class="input-group-prepend showbutton">
                                                    <div class="input-group-text"><i class="uil uil-eye"></i></div>
                                                  </div>    
                                             </div>    
                                            </div>
                                            
                                            <div class="mt-3 text-right">
                                                <button class="btn btn-primary w-sm waves-effect waves-light" type="Submit">Reset</button>
                                            </div>
                
    
                                            <div class="mt-4 text-center">
                                                <p class="mb-0">Remember It ? <a href="auth-login" class="font-weight-medium text-primary"> Signin </a></p>
                                            </div>
                                        </form>
                                        <?php }else{ ?>
                                        <h2>Link expired</h2>
                                        <p>The link is expired. You are trying to use the expired link which 
                                        as valid only 24 hours (1 days after request).<br /><br /></p> 
                                         <a href="<?php echo base_url(); ?>"><button type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Back To Login Page</button></a>
                                        <?php } 
                                         } ?>
                                         <?php } ?>
                                    </div>
                
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <p>© 2022 qlickHealth. Crafted with <i class="mdi mdi-heart text-danger"></i> by Qlickhealth</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>

        <!-- JAVASCRIPT -->

    </body>
<script src="<?php echo base_url()?>/assets/js/jquery-3.3.1.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script>
     
$('.showbutton').click(function(){
   if($(this).parent('.showandhide').children('input').attr('type') == "password"){
   $(this).parent('.showandhide').children('input').attr('type','text');        
   }else{
   $(this).parent('.showandhide').children('input').attr('type','password');
   }
});     
</script>     
     
</html>
