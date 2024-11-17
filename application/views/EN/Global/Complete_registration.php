<!doctype html>
<html lang="en">

     
<body class="light menu_light logo-white theme-white" cz-shortcut-listen="true">
 <body class="authentication-bg">

        <div class="home-btn d-none d-sm-block">
            <a href="/" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
        </div>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <a href="/" class="mb-5 d-block auth-logo">
                                <img src="assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark">
                                <img src="assets/images/logo-light.png" alt="" height="22" class="logo logo-light">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                           
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">

                                     <div class="alert alert-primary alert-dismissible fade show" id="statusbox" role="alert">
                                          Please Complete The Form
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                   </div>
                                     
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to QlickHealth</p>
                                </div>
                                <div class="p-2 mt-4">
                              <?php foreach($adminData as $Data){ ?>
                                    <form action="" id="loginform">
                                         
                                 <?php if(empty($Data['Manager'])){ ?>

                                        <div class="form-group">
                                            <label for="username">Manager</label>
                                            <input type="text" class="form-control" id="Manager" placeholder="Enter username" name="Manager">
                                        </div>
                                    <?php } ?>
                                         
                                 <?php if(empty($Data['Tel'])){ ?>

                                        <div class="form-group">
                                            <label for="username">Phone</label>
                                            <input type="text" class="form-control" id="Phone" placeholder="Enter username" name="Phone">
                                        </div>
                                    <?php } ?>
                                         
                                    </form>
                              <?php } ?>       
                                </div>
            
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <p>© 2022 V2.0 Track Qlickhealth <i class="mdi mdi-heart text-danger"></i> by Qlickhealth</p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
</body>
<script src="<?php echo base_url()?>/assets/js/jquery-3.3.1.min.js"></script>     
<script>

$("#loginform").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Users/startlogin',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
               $('#statusbox').css('display','block');
               $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>');
          },
          success: function (data) {
               $('#statusbox').html(data);

          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});
        
     
     
</script>
</html>