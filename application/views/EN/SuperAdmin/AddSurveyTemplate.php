<!doctype html>
<html  lang="en">
<head>
<meta charset="utf-8">
 <link rel="preconnect" href="https:/fonts.gstatic.com">
 <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
 <link href="<?php echo base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/css/autoFill.bootstrap4.min.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo base_url() ?>assets/libs/datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />	
</head>
<body>
<style>

 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #CB0002;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}      

.floating_action_btn {
    position: fixed !important;
    bottom: 70px;
    right: 10px;
    border: 0px;
    width: 50px;
    height: 50px;
    background: #fff;
    border-radius: 100%;
    z-index: 1000;
    -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
}
	
.odd {
    background: #ffeaf1 !important;
}	
	
.arabic {
	font-family: 'Almarai', sans-serif;
}

	
	.delete {
		font-size: 23px;
		color: #fd0000;
		cursor: pointer;
	}	
	
</style>	
<style>
.edit_inp {
    background: transparent;
    border: 0px;
    outline: none;
}
</style>	
<?php   
$count    = $this->db->query("SELECT id FROM `sv_sets` ORDER BY id DESC ")->num_rows();
if(!empty(!$count)){
	$code = "Set-".((100+$count)+1);
}else{
	$code = "Set-100";
}
?>	
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
	<div class="main-content">
		<div class="page-content">
				   <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 010: Survey Titles Management</h4>
				   <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
		0001:Survey Management: The titles can be edited<br>
		0002: Surveys can be enabled and disabled<br>

		</h4>
		   <button type="button" class="floating_action_btn waves-effect waves-light" data-toggle="modal" 
		    data-target="#myModal"><i class="uil uil-plus"></i></button>

			<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<table id="table" class="table table-editable table-nowrap">
							<thead>
								<th>#</th>
								<th>Code</th>
								<th>Survey Title EN</th>
								<th>Survey Title AR</th>
								<th>Date</th>
								<th>Status</th>
								<th class="text-center">Action</th>
							</thead>
							<tbody>
								<?php  $sn = 0 ; foreach($sets as $set): $sn++; ?>
								<tr id="set_<?php  echo $set['Id']  ?>" class="animate__animated ">
									<td><?php  echo $sn;  ?></td>
									<td><?php  echo $set['code'];  ?></td>
									<td>
										<input type="text" value="<?php  echo $set['title_en'];  ?>" class="edit_inp title_en"
									    id="<?php echo md5($set['Id']."1") ?>" onkeyup="update_data(<?php echo $set['Id']; ?>,'<?php echo md5($set['Id']."1") ?>','<?php echo "en"; ?>')">
									</td>
									<td class="arabic">
										<input type="text" value="<?php  echo $set['title_ar'];  ?>" class="edit_inp title_ar"
									    id="<?php echo md5($set['Id']."2"); ?>" onkeyup="update_data(<?php echo $set['Id']; ?>,'<?php echo md5($set['Id']."2") ?>','<?php echo "ar"; ?>')"> 
									</td>
									<td><?php  echo $set['TimeStamp']  ?></td>
                                    <td>
										<label class="switch">
											<input  type="checkbox" onchange="update_status(<?php  echo $set['Id']  ?>)"
											name="ischecked" <?php  echo $set['status'] == 1 ? 'checked' : "";  ?>>
											<span class="slider round"></span> 
										</label>
									</td>
									<td class="text-center">
										<i class="uil uil-trash delete" onclick="dalete_set(<?php echo $set['Id'] ?>)" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Forever"></i>
									</td>
									</tr>					
								<?php  endforeach;  ?>
							</tbody>					
						</table>
					</div>				
				</div>
			</div>
			<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title mt-0" id="myModalLabel">Survey Title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
								<div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
									<div class="card-body">
							<div class="alert alert-success alert-dismissible fade show code" role="alert" style="display: none;">
								<i class="uil uil-check mr-2"></i>
								 you data Added Successfully ( code is: <?php  echo $code;  ?> )
							</div>	
										<div id="StatusBox"></div>
										<form id="ADDset">
											<div class="row">
												<div class="col-lg-12 ">
													<div class="form-group">
														<label for="Title_EN">Survey Title EN:</label>
														<input type="text" class="form-control" placeholder="Survey Title EN"
															   id="Title_EN" name="en_title">	
													</div>
												</div>
												<div class="col-lg-12 ">
													<div class="form-group">
														<label for="Title_AR">Survey Title AR:</label>
														<input type="text" class="form-control" placeholder="Survey Title AR"
															   id="Title_AR"  name="ar_title">	
													</div>
												</div>
											</div>
											<div class="mt-1">
											  <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
											<button type="button" class="btn btn-light waves-effect" 
													data-dismiss="modal">Close</button>
											</div>
										</form>
									</div>
								</div>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
		 </div>
		</div>
	</div>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
<script>
$('#table').DataTable();
$('input').each(function(){
	$(this).on('keypress keydown keyup',function(){
		if($('input[name="en_title"]').val().length > 0 && $('input[name="ar_title"]').val().length){
			$('.code').slideDown();
		}else{
			$('.code').slideUp();
		} 
	});
});	
	

function update_data(id,val_id,title_type) {
	const val = $('#' + val_id).val();
	$.ajax({
		type: 'PUT',
		url: '<?php echo base_url(); ?>EN/Dashboard/changeset',
		data: {
		set_id     : id,
		title_type : title_type,
		val        : val,
		},
		success: function (data) {
		if(data !== 'ok'){
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": 300,
				"hideDuration": 300,
				"timeOut": 5000,
				"extendedTimeOut": 1000,
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
			Command: toastr["error"]("Sorry. we have a probleme in updating this value !");
		}
		},
		ajaxError: function(){
			Swal.fire(
			'error',
			'oops!! we have a error',
			'error'
			);
	}
	});  
}

function dalete_set(Id) {
	Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mt-2',
        cancelButtonClass: 'btn btn-danger ml-2 mt-2',
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
		  //DELETE 	
		 $.ajax({
			 type: 'DELETE',
			 url: '<?php echo base_url(); ?>EN/Dashboard/changeset',
			 data: {
			  set_id : Id,
			 },
			 success: function (data) {
				 if(data === "ok"){
				  Swal.fire({
					title: 'Deleted!',
					text: 'Your set has been deleted.',
					icon: 'success'
				  }).then(function (result) {
				  		$('#set_' + Id ).addClass('animate__flipOutX'); 
					setTimeout(function(){
				  		$('#set_' + Id ).remove(); 
					},800);  
				  });
				 }else{
					 Swal.fire(
					 'error',
					 'Oops! We have an unexpected error.',
					 'error'
					 );
				 }
			 },
			 ajaxError: function(){
				 Swal.fire(
				 'error',
				 'oops!! we have a error',
				 'error'
				 );
			 }
			 });          
        }
      });		
}


function update_status(Id) {
	$.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Dashboard/changeset',
     data: {
      set_id : Id,
     },
     success: function (data) {
		 if(data === "ok"){
			toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": 300,
			  "hideDuration": 300,
			  "timeOut": 5000,
			  "extendedTimeOut": 1000,
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}
			Command: toastr["success"]("the set status updated!​");
			 console.log(status);
		 }else{
			 Swal.fire(
			 'error',
			 'Oops! We have an unexpected error.',
			 'error'
			 );
		 }
     },
     ajaxError: function(){
		 Swal.fire(
		 'error',
		 'oops!! we have a error',
		 'error'
		 );
     }
   });
}
	
$("#ADDset").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Dashboard/startAddNewSet',
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#StatusBox').html(data);
          },
          ajaxError: function(){
               $('#StatusBox').css('background-color','#B40000');
               $('#StatusBox').html("Ooops! Error was found.");
          }
     });
});
</script>	
	
</body>
</html>