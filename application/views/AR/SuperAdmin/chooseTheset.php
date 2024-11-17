<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?php echo base_url() ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-content">
	<div class="page-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<label class="control-label">Single Select</label>
							<select class="form-control select2">
								<?php  foreach($sets as $set){  ?>
								<option value="<?php  echo $set['Id']  ?>"><?php  echo $set['title_en'];  ?></option>
								<?php  }  ?>
							</select>	
						</div>
						<button type="button" class="btn btn-primary waves-effect waves-light go">
							go <i class="uil uil-arrow-right ml-2"></i> 
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>	
</body>
<script src="<?php echo base_url() ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/pages/form-advanced.init.js"></script>
<script>
	$('.go').click(function(){
		const selected = $('.select2').children("option:selected").val();
		console.log(selected);
		location.href = "<?php echo  base_url("EN/Dashboard/Addquestion/")  ?>"+selected;
	});
</script>	
</html>