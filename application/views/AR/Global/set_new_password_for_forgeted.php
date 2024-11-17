<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update password</title>
<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/icons.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
.seePassword {
	font-size: 22px;
	float: right;
	margin-top: -36px;
	margin-right: 5px;
	z-index: 1000000000;
	position: relative;
	cursor: pointer;
}

.loding {
    width: 100%;
    height: 100%;
    position: absolute;
    display: grid;
    align-items: center;
    align-content: center;
    background: #fff;
    z-index: 1000000000000;
    top: 0px;
}

.loding .spinner-border {
	position: absolute;
    left: 43%;
    font-size: 19px;
}
	
	
</style>
<body class="authentication-bg">
<div class="account-pages pt-sm-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div> <a href="/" class="mb-5 d-block auth-logo"> <img src="assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark"> <img src="assets/images/logo-light.png" alt="" height="22" class="logo logo-light"> </a>
          <div class="card">
            <div class="card-body p-4">
              <div class="loding">
                <div class="spinner-border text-warning m-1" role="status">
                  <span class="sr-only">تحميل.</span>
                </div>
              </div>
              <div class="text-center mt-2">
<img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" width="100%" class="logo logo-dark">
                <h5 class="text-primary">إعادة تعيين كلمة المرور</h5>
                <p class="text-muted"> أدخل كلمة المرور الجديدة </p>
              </div>
              <div class="p-2 mt-4">
                <form id="set" class="custom-validation" >
                  <div class="form-group">
                    <label for="userpassword1">أدخل كلمة المرور الجديدة</label>
                    <input type="password" class="form-control" id="userpassword1" placeholder="Enter password"
				    required maxlength="16" minlength="6" name="pass_1">
				    <i class="uil uil-eye-slash seePassword"></i>
                  </div>
                  <div class="form-group">
                    <label for="userpassword2">أعد كتابة كلمة المرور الجديدة</label>
                    <input type="password" class="form-control" id="userpassword2" placeholder="Enter password" required
				     data-parsley-equalto="#userpassword1" maxlength="16" minlength="6" name="pass_2">
				    <i class="uil uil-eye-slash seePassword"></i>
                  </div>
				  <input type="hidden" name="log_id" value="<?php  echo $log_id;  ?>">
                  <div class="mt-3 text-right">
                    <button class="btn btn-primary btn-lg btn-block waves-effect waves-light" type="Submit">تحديث</button>
                  </div>
                  <div class="mt-4 text-center">
                    <p class="mb-0">هل تذكر كلمة المرور الخاصة بك انتقل إلى
						<a href="<?php echo base_url() ?>AR/users/" class="font-weight-medium text-primary"> تسجيل الدخول </a>
				    </p>
                  </div>
                </form>
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
          url: '<?php echo base_url(); ?>AR/users/startupdating_thepassword',
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
				text: 'تم تحديث كلمة المرور بنجاح !! يمكنك الذهاب لتسجيل الدخول',
				icon: 'success',
				confirmButtonColor: '#5b8ce8'
			  }).then(function (result) {
				  location.href = "<?php echo base_url() ?>AR/users/";
			  });
		    }else{
			  Swal.fire({
				title: "Sorry !",
				text: 'يرجى التحقق من المدخلات.',
				icon: 'error',
				confirmButtonColor: '#5b8ce8'
			  });
			}  
          },
          ajaxError: function(){
			  Swal.fire({
				title: "Sorry !",
				text: 'لدينا مشكلة في هذا الطلب',
				icon: 'error',
				confirmButtonColor: '#5b8ce8'
			  })
		  }
	  })
  })
</script>
</html>