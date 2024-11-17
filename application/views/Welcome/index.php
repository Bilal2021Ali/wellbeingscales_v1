<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Choose Language | إختر اللغة</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
	  
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/app.min.css">
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
.mt-5, .my-5 {
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
@media (max-width: 767px) {
  /* styles for mobile devices */
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
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">
          <div class="card-body p-4">
            <div class="text-center mt-2"> <img class="logo" src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png"> </div>
            <div class="row">
              <?php foreach ($links as $link) { ?>
              <div class="col-lg-6">
                <div class="product-box" style="padding-bottom: 16px;">
                  <div class="product-img pt-4 px-4"> <img src="<?= base_url("assets/images/" . $link["img"]); ?>" alt="" class="img-fluid mx-auto d-block"> </div>
                  <div class="text-center product-content p-4">
                    <h5 class="mt-3 mb-0"><span class="text-muted mr-2 ar">
                      <?= $link["title"] ?>
                      </span></h5>
                    <ul class="list-inline mb-0 text-muted product-color">
                      <a href="<?= base_url("" . $link["link"] . "/Users"); ?>" class="btn btn-primary btn-rounded waves-effect waves-light">
                      <?= $link["action"] ?>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="card-body p-4">
              <p class="text-muted">Thank you for choosing <span style="color: #0eacd8; font-weight: bold;">QlickHealth</span>. We are confident that you will find our platform an essential tool for managing your business and wellness.</p>
			  <p class="text-muted">Your data is safe with us. We will never share or sell your personal information to third parties. <br><a href="<?=base_url('assets/policy/privacy-policy.html')?>"><span style="color: #0eacd8; font-weight: bold;">Privacy Policy Statement</span></a><br><a href="<?=base_url('/testtrack/EN/Users')?>"><span style="color: #0eacd8; font-weight: bold;">Development Server</span></a>.</p>
			  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?= base_url() ?>/assets/js/jquery-3.3.1.min.js"></script>

<script>
	<script>
    function checkCookie() {
        var lang = getCookie("lang");
        if (lang) {
            if (lang == "EN") {
                window.stop();
                goToEnglish();
            } else if (lang == "AR") {
                window.stop();
                goToArabic();
            }
        }
    }
    checkCookie();
</script>
	</body>   
</html>