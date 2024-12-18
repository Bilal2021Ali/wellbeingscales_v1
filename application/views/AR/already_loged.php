<!doctype html>
<html lang="en">

     
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
	 <style>

			.check_mark {
			  width: 80px;
			  height: 130px;
			  margin: 0 auto;
			}

			button {
			  cursor: pointer;
			  margin-left: 15px;
			}

			.hide{
			  display:none;
			}

			.sa-icon {
			  width: 80px;
			  height: 80px;
			  border: 4px solid gray;
			  -webkit-border-radius: 40px;
			  border-radius: 40px;
			  border-radius: 50%;
			  margin: 20px auto;
			  padding: 0;
			  position: relative;
			  box-sizing: content-box;
			}

			.sa-icon.sa-success {
			  border-color: #4CAF50;
			}

			.sa-icon.sa-success::before, .sa-icon.sa-success::after {
			  content: '';
			  -webkit-border-radius: 40px;
			  border-radius: 40px;
			  border-radius: 50%;
			  position: absolute;
			  width: 60px;
			  height: 120px;
			  background: white;
			  -webkit-transform: rotate(45deg);
			  transform: rotate(45deg);
			}

			.sa-icon.sa-success::before {
			  -webkit-border-radius: 120px 0 0 120px;
			  border-radius: 120px 0 0 120px;
			  top: -7px;
			  left: -33px;
			  -webkit-transform: rotate(-45deg);
			  transform: rotate(-45deg);
			  -webkit-transform-origin: 60px 60px;
			  transform-origin: 60px 60px;
			}

			.sa-icon.sa-success::after {
			  -webkit-border-radius: 0 120px 120px 0;
			  border-radius: 0 120px 120px 0;
			  top: -11px;
			  left: 30px;
			  -webkit-transform: rotate(-45deg);
			  transform: rotate(-45deg);
			  -webkit-transform-origin: 0px 60px;
			  transform-origin: 0px 60px;
			}

			.sa-icon.sa-success .sa-placeholder {
			  width: 80px;
			  height: 80px;
			  border: 4px solid rgba(76, 175, 80, .5);
			  -webkit-border-radius: 40px;
			  border-radius: 40px;
			  border-radius: 50%;
			  box-sizing: content-box;
			  position: absolute;
			  left: -4px;
			  top: -4px;
			  z-index: 2;
			}

			.sa-icon.sa-success .sa-fix {
			  width: 5px;
			  height: 90px;
			  background-color: white;
			  position: absolute;
			  left: 28px;
			  top: 8px;
			  z-index: 1;
			  -webkit-transform: rotate(-45deg);
			  transform: rotate(-45deg);
			}

			.sa-icon.sa-success.animate::after {
			  -webkit-animation: rotatePlaceholder 4.25s ease-in;
			  animation: rotatePlaceholder 4.25s ease-in;
			}

			.sa-icon.sa-success {
			  border-color: transparent\9;
			}
			.sa-icon.sa-success .sa-line.sa-tip {
			  -ms-transform: rotate(45deg) \9;
			}
			.sa-icon.sa-success .sa-line.sa-long {
			  -ms-transform: rotate(-45deg) \9;
			}

			.animateSuccessTip {
			  -webkit-animation: animateSuccessTip 0.75s;
			  animation: animateSuccessTip 0.75s;
			}

			.animateSuccessLong {
			  -webkit-animation: animateSuccessLong 0.75s;
			  animation: animateSuccessLong 0.75s;
			}

			@-webkit-keyframes animateSuccessLong {
			  0% {
				width: 0;
				right: 46px;
				top: 54px;
			  }
			  65% {
				width: 0;
				right: 46px;
				top: 54px;
			  }
			  84% {
				width: 55px;
				right: 0px;
				top: 35px;
			  }
			  100% {
				width: 47px;
				right: 8px;
				top: 38px;
			  }
			}
			@-webkit-keyframes animateSuccessTip {
			  0% {
				width: 0;
				left: 1px;
				top: 19px;
			  }
			  54% {
				width: 0;
				left: 1px;
				top: 19px;
			  }
			  70% {
				width: 50px;
				left: -8px;
				top: 37px;
			  }
			  84% {
				width: 17px;
				left: 21px;
				top: 48px;
			  }
			  100% {
				width: 25px;
				left: 14px;
				top: 45px;
			  }
			}
			@keyframes animateSuccessTip {
			  0% {
				width: 0;
				left: 1px;
				top: 19px;
			  }
			  54% {
				width: 0;
				left: 1px;
				top: 19px;
			  }
			  70% {
				width: 50px;
				left: -8px;
				top: 37px;
			  }
			  84% {
				width: 17px;
				left: 21px;
				top: 48px;
			  }
			  100% {
				width: 25px;
				left: 14px;
				top: 45px;
			  }
			}

			@keyframes animateSuccessLong {
			  0% {
				width: 0;
				right: 46px;
				top: 54px;
			  }
			  65% {
				width: 0;
				right: 46px;
				top: 54px;
			  }
			  84% {
				width: 55px;
				right: 0px;
				top: 35px;
			  }
			  100% {
				width: 47px;
				right: 8px;
				top: 38px;
			  }
			}

			.sa-icon.sa-success .sa-line {
			  height: 5px;
			  background-color: #4CAF50;
			  display: block;
			  border-radius: 2px;
			  position: absolute;
			  z-index: 2;
			}

			.sa-icon.sa-success .sa-line.sa-tip {
			  width: 25px;
			  left: 14px;
			  top: 46px;
			  -webkit-transform: rotate(45deg);
			  transform: rotate(45deg);
			}

			.sa-icon.sa-success .sa-line.sa-long {
			  width: 47px;
			  right: 8px;
			  top: 38px;
			  -webkit-transform: rotate(-45deg);
			  transform: rotate(-45deg);
			}

			@-webkit-keyframes rotatePlaceholder {
			  0% {
				transform: rotate(-45deg);
				-webkit-transform: rotate(-45deg);
			  }
			  5% {
				transform: rotate(-45deg);
				-webkit-transform: rotate(-45deg);
			  }
			  12% {
				transform: rotate(-405deg);
				-webkit-transform: rotate(-405deg);
			  }
			  100% {
				transform: rotate(-405deg);
				-webkit-transform: rotate(-405deg);
			  }
			}
			@keyframes rotatePlaceholder {
			  0% {
				transform: rotate(-45deg);
				-webkit-transform: rotate(-45deg);
			  }
			  5% {
				transform: rotate(-45deg);
				-webkit-transform: rotate(-45deg);
			  }
			  12% {
				transform: rotate(-405deg);
				-webkit-transform: rotate(-405deg);
			  }
			  100% {
				transform: rotate(-405deg);
				-webkit-transform: rotate(-405deg);
			  }
			}</style>

	</div> 
<div class="outer"></div>     
     <body class="authentication-bg">

        <div class="account-pages">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card" style="border: 0px;height: 80vh;display: grid;align-items: center">
                            <div class="card-body p-4 text-center"> 
                                <div class="p-2 mt-4">
									<div class="check_mark">
									  <div class="sa-icon sa-success animate">
										<span class="sa-line sa-tip animateSuccessTip"></span>
										<span class="sa-line sa-long animateSuccessLong"></span>
										<div class="sa-placeholder"></div>
										<div class="sa-fix"></div>
									  </div>
									</div>				
									<h5 class="mb-3">You already logged as: <?=$sessiondata['username']?></h5>
									<button class="btn btn-primary btn-block goback m-0 mt-2"> Back </button>
									<a href="<?php echo base_url()."EN/Users/logout"; ?>" class="btn btn-light btn-sm btn-block waves-effect waves-light" style="display: block">Log out</a>
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
<script>
$('.goback').click(function(){
	history.back();
});
</script>
</html>