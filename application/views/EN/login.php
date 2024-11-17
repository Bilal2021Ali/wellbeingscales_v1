<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Choose Language | إختر اللغة</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
	  
<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/css/app.min.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

																				
																				
																																																											
			  
<style>
.product-box {
    background: #fff;
}
.ar {
    font-family: 'Almarai', sans-serif;
}
.en {
    font-family: 'Roboto', sans-serif;
}
            .mapouter {
                position: relative;
                text-align: right;
                height: 100%;
                width: 100%;
            }

            .gmap_canvas {
                overflow: hidden;
                background: none !important;
                height: 100%;
                width: 100%;
            }

            .account-pages {
                padding-top: 50px;
            }

            .mt-5,
            .my-5 {
                margin-top: 0px !important;
            }

            .outer {
                position: absolute;
                top: 0px;
                left: 0px;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.55);
            }
	</style>		
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var viewportWidth = document.documentElement.clientWidth;
    if (viewportWidth <= 1024) {
        document.documentElement.style.fontSize = "80%";
    } else if (viewportWidth <= 1280) {
        document.documentElement.style.fontSize = "90%";
    } else {
        document.documentElement.style.fontSize = "100%";
    }
});
</script>		 
</head>
<body class="authentication-bg">
<div class="mapouter" style="position: absolute; z-index: 0;">
    <div class="gmap_canvas">
        <iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=qatar&t=&z=7&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </div>
</div>
        <div class="account-pages my-5  pt-sm-5">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <img src="<?= base_url(); ?>assets/images/qlick-health-logo.png" alt="" width="100%" class="logo logo-dark">

                                    <div class="alert alert-primary alert-dismissible fade show" id="statusbox" role="alert">
                                        Sign in to continue to QlickHealth
                                    </div>

                                    
                                    <?php $this->load->view("EN/widgets/date-time.php", ["center" => true]); ?>
                                    <p class="text-muted">Welcome!</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="" id="loginform">

                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="userpassword" placeholder="Password" name="password">
                                        </div>

                                        <div class="mt-3 text-right">
                                            <button class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-2" type="Submit"> Login </button>
                                            <div class="float-left">
                                                <a href="<?= base_url() ?>EN/Users/ForgetPassword" class="text-muted">
                                                   <p class="text-muted"><span style="color: #0eacd8; font-weight: bold;">Forgot Password?</span>.</p>
													
                                                </a>
                                            </div>
                                        </div>

                                    </form>
									
                                </div>

								<div class="card-body p-4">
									<hr>
              <p class="text-muted">Thank you for choosing <span style="color: #0eacd8; font-weight: bold;">QlickHealth</span>. We are confident that you will find our platform an essential tool for managing your business and wellness.</p>
			  <p class="text-muted">Your data is safe with us. We will never share or sell your personal information to third parties. <br><a href="<?=base_url('assets/policy/privacy-policy.html')?>"><span style="color: #0eacd8; font-weight: bold;">Privacy Policy Statement</span></a>.</p>
            </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <p>© 2023 qlickHealth</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    
    <script src="<?= base_url() ?>/assets/js/jquery-3.3.1.min.js"></script>
    <script>
        $("#loginform").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>index.php/EN/Users/startlogin',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#statusbox').css('display', 'block');
                    $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>');
                },
                success: function(data) {
                    $('#statusbox').html(data);

                },
                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });
    </script>
</body>
</html>