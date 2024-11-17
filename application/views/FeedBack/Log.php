<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/bootstrap.min.css">	
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/typography.css">	
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/typography.css">	
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/style.css">	
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/responsive.css">	
</head>

<body>
        <section class="sign-in-page">
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col-sm-12 align-self-center">
                        <div class="sign-in-from bg-white">
                            <h1 class="mb-0 response">Sign in</h1>
                            <p>Enter your email address and password to access admin panel.</p>
                            <form class="mt-4" id="loginform">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control mb-0" id="exampleInputEmail1"
										   placeholder="Enter email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control mb-0" id="exampleInputPassword1" 
										   placeholder="Password" name="password">
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="Submit" class="btn btn-primary float-right">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</body>
<script src="<?php echo base_url()?>/assets/js/jquery-3.3.1.min.js"></script>     
<script>
$("#loginform").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>FeedBack/startlogin',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
			  $('.response').html("please wait ..")
          },
          success: function (data) {
			  $('.response').html(data)
          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});
        
</script>	
</html>