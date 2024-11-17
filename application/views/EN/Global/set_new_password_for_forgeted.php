<head>
    <meta charset="UTF-8">
    <title>Choose Country Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('<?= base_url("assets/images/bg-01.jpg"); ?>') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Almarai', sans-serif;
        }

        .container {
            /* إزالة خاصية التوسيط العمودي */
            margin-top: 20px;
            /* إضافة مسافة من الأعلى (اختياري) */
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
        }

        .card {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 10px;

            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-body img {
            width: auto;
            height: auto;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .card-body img:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #fff;
            font-size: 1rem;
        }

        .footer-links {
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-control {
            padding: 15px;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        @media (max-width: 767px) {
            .card {
                width: 90%;
            }

            .card-body {
                padding: 20px;
            }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            /* إضافة بعض المسافة من الأسفل */
        }

        .logo {
            max-width: 100%;
            height: auto;
        }
    </style>
<body class="authentication-bg">
<div class="account-pages pt-sm-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        
          <div class="card">
            <div class="card-body p-4">
			
              <div class="loding">
                <div class="spinner-border text-warning m-1" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
              <div class="text-center mt-2">
<img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
                <h5 class="text-primary">Reset Password</h5>
                <p class="text-muted"> Enter your new password </p>
              </div>
              <div class="p-2 mt-4">
                <form id="set" class="custom-validation" >
                  <div class="form-group">
                    <label for="userpassword1">New Password</label>
                    <input type="password" class="form-control" id="userpassword1" placeholder="Enter password"
				    required maxlength="16" minlength="6" name="pass_1">
				    <i class="uil uil-eye-slash seePassword"></i>
                  </div>
                  <div class="form-group">
                    <label for="userpassword2">Rewrite the new Password</label>
                    <input type="password" class="form-control" id="userpassword2" placeholder="Enter password" required
				     data-parsley-equalto="#userpassword1" maxlength="16" minlength="6" name="pass_2">
				    <i class="uil uil-eye-slash seePassword"></i>
                  </div>
				  <input type="hidden" name="log_id" value="<?php  echo $log_id;  ?>">
                  <div class="mt-3 text-right">
                    <button class="btn btn-primary btn-lg btn-block waves-effect waves-light" type="Submit">Update</button>
                  </div>
                  <div class="mt-4 text-center">
                    <p class="mb-0">Did you remember your password go to
						<a href="<?php echo base_url() ?>EN/Users/" class="font-weight-medium text-primary"> Sign In </a>
				    </p>
                  </div>
                </form>
              </div>
			  <div class="text-center mt-2">
                            <hr>
                            <p>Copyright © <span id="currentYear"></span> Wellbeing Scales. All rights reserved.</p>
                        </div>
            </div>
			
          </div>
		  
        </div>
		
      </div>
    </div>
    <!-- end row --> 
  </div>
  <!-- end container --> 
</div>
</body>
<script src="<?php echo base_url() ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/parsleyjs/parsley.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/pages/form-validation.init.js"></script>
<script>
$('.loding').hide();	
$('.seePassword').click(function(){
	if($(this).hasClass('uil-eye')){
	   $(this).removeClass('uil-eye');
	   $(this).addClass('uil-eye-slash');
       $(this).parent().children('input').attr('type','password');
    }else{
	   $(this).removeClass('uil-eye-slash');
	   $(this).addClass('uil-eye');	
	   $(this).parent().children('input').attr('type','text');
	}
});	
//$('.uil-eye-slash').	
$("#set").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Users/startupdating_thepassword',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
			$('.loding').show();	
          },
          success: function (data) {
			$('.loding').hide();
			if(data == "ok"){
			  Swal.fire({
				title: "Done",
				text: 'The password updated successfully !! you can go to login',
				icon: 'success',
				confirmButtonColor: '#5b8ce8'
			  }).then(function (result) {
				  location.href = "<?php echo base_url() ?>EN/Users/";
			  });
		    }else{
			  Swal.fire({
				title: "Sorry !",
				text: 'Kindly check the input.',
				icon: 'error',
				confirmButtonColor: '#5b8ce8'
			  });
			}  
          },
          ajaxError: function(){
			  Swal.fire({
				title: "Sorry !",
				text: 'We have encountered a problem with this request.',
				icon: 'error',
				confirmButtonColor: '#5b8ce8'
			  })
		  }
	  })
  })
</script>
</html>