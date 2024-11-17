<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/bootstrap.min.css">
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/typography.css">
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/typography.css">
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/style.css">
<link rel="stylesheet" href="https://iqonic.design/themes/metorik/html/css/responsive.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/libs/magnific-popup/magnific-popup.css">
<link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet">

</head>
<style>
img {
	width: 100%;
    height: 210px;
}
	
.uil.uil-check{
	font-size: 23px;
}	
	
.btn-success {
	padding: 0px;
	width: 50px;
}

.container {
	padding-top: 20px;
}
	
</style>
<body>
<div class="container">
	<div class="col-md-12">
	<div class="iq-product-layout-grid">
	<div id="hits">
	  <div class="ais-Hits iq-product">
		<ul class="ais-Hits-list iq-product-list">
		<?php  foreach($FeedsList as $Feed){   ?>
		  <li key="0" class="ais-Hits-item iq-product-item iq-card" id="<?php  echo $Feed['Id']  ?>">
			<div class="text-center">
			  <div class="h-56 d-flex align-items-center justify-content-center bg-white iq-border-radius-15">
				 <a href="<?php echo base_url() ?>uploads/feedBack/<?php  echo $Feed['img_txt'].".png"  ?>" target="_blank">
			 <img class="image-popup-no-margins" src="<?php echo base_url() ?>uploads/feedBack/<?php  echo $Feed['img_txt'].".png"  ?>" align="left" alt="">
				  </a> 
			  </div>
			  <div class="card-body">
				<div class="text-justify">
					<a href="<?php  echo $Feed['page_url'];  ?>" target="_blank"><p>
						<?php 
						$pageName = explode("/",$Feed['page_url']);						
						echo $pageName[(sizeof($pageName))-2]." -- ".$pageName[(sizeof($pageName))-1]; 
						?>
						</p>
					</a> 
				  <p class="font-size-12 mb-0"> <?php  echo $Feed['feedback_desc'];  ?></p>
				</div>
				<div class="iq-product-action my-2">
				  <button type="button" class="btn btn-success rounded-pill mb-3" onClick="Done(<?php  echo $Feed['Id']  ?>)">
					  <i class="uil uil-check"></i>
				  </button>
				  <p class="font-size-16 font-weight-bold float-right"><?php  echo $Feed['TimeStamp']  ?></p>
					<pre>
					<?php  echo $Feed['session_data'];  ?>
					</pre>
				</div>
			  </div>
			</div>
		  </li>
		<?php  }  ?>	
		</ul>
	  </div>
	</div>
	</div>
	</div>
</div>
</body>
<!-- Magnific Popup-->
<script src="<?php echo base_url() ?>assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- lightbox init js-->
<script src="<?php echo base_url() ?>assets/js/pages/lightbox.init.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-3.3.1.min.js"></script>
<script>
	function Done(id){
		  $.ajax({
			 type: 'POST',
			 url: '<?php echo base_url(); ?>FeedBack/Done',
			 data: {
				  id : id,
			 },
			 success: function (data) {
				  $('#' + id).hide();
			 },
			 ajaxError: function(){
			 Swal.fire(
			 'error',
			 'oops!! we have a error',
			 'error'
			 )
			 }
		 });
	}
</script>	
</html>