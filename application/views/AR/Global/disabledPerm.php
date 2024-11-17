<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<style>
*{
	font-family: 'Almarai', sans-serif;
}	
</style>	
<link rel="preconnect" href="https:/fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/app-rtl.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/app.min.css" id="app-rtl-style" rel="stylesheet">
<script src="<?php echo base_url();?>assets/libs/jquery/jquery.min.js"></script>
<body class="authentication-bg">
<div class="my-5 pt-sm-5">
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<div class="text-center">
					<div>
						<div class="row justify-content-center">
							<div class="col-sm-4">
								<div class="error-img">
						<img src="<?php echo base_url() ?>assets/images/has_not_permission.svg" alt="" class="img-fluid mx-auto d-block">
								</div>
							</div>
						</div>
					</div>
					<h4 class="text-uppercase mt-4">نعتذر</h4>
					<p class="text-muted">
						نأسف ، حسابك لا يدعم هذه الميزة حاليا ، إذا تم توفيرها لك ، فسنبلغك بذلك
					</p>
					<div class="mt-5">
			<a class="btn btn-primary waves-effect waves-light" href="<?php echo base_url($to) ?>">
					العودة إلى لوحة المراقبة
			</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</body>
</html>