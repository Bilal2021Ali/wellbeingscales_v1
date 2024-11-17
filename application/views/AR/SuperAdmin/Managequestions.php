<!doctype html>
<html lang="en">

<head>
	<meta charquestion="utf-8">
	<link rel="preconnect" href="https:/fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/css/autoFill.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/libs/datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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

		input:checked+.slider {
			background-color: #2196F3;
		}

		input:focus+.slider {
			box-shadow: 0 0 1px #2196F3;
		}

		input:checked+.slider:before {
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

		.arabic,
		.arabic * {
			font-family: 'Almarai', sans-serif;
		}


		.delete {
			font-size: 23px;
			color: #fd0000;
			cursor: pointer;
		}

		.edit_inp {
			background: transparent;
			border: 0px;
			outline: none;
		}

		.edit_inp:empty {
			caret-color: red;
		}

		.delete_disabled {
			font-size: 24px;
		}

		.page-item.page-link.active *{
			color: #fff;
		}
	</style>
	<?php
	$count = $this->db->query("SELECT Id FROM `sv_questions_library` ORDER BY id DESC LIMIT 1")->result_array();
	if (!empty($count)) {
		$f_count = $count[0]['Id'];
		settype($f_count, 'integer');
		$handr = 100 + $f_count;
		$code = "Question-" . ($handr + 1);
	} else {
		$code = "Question-101";
	}


	?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
	<div class="main-content">
		<div class="page-content">
			<h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 011: Survey Questions Management</h4>
			<h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
				0001: Questions can be edited<br>
				0002: Questions can be enabled and disabled<br>

			</h4>
			<button type="button" class="floating_action_btn waves-effect waves-light" data-toggle="modal" data-target="#myModal"><i class="uil uil-plus"></i></button>

			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<table class="table table-editable table-nowrap">
								<thead>
									<th>#</th>
									<th>Code</th>
									<th>Questions EN</th>
									<th>Questions AR</th>
									<th>Date</th>
									<th>Status</th>
									<th class="text-center">Action</th>
								</thead>
								<tbody>
									<?php $sn = 0;
									foreach ($questions as $question) : $sn++; ?>
										<tr id="question_<?php echo $question['Id']  ?>" class="animate__animated ">
											<td><?php echo $sn;  ?></td>
											<td><?php echo $question['code'];  ?></td>
											<td>
												<input type="text" value="<?php echo $question['en_title'];  ?>" class="edit_inp title_en font-size-15 mb-1 font-weight-normal" id="<?php echo md5($question['Id'] . "1"); ?>" onkeyup="update_data(<?php echo $question['Id']; ?>,'title','en','<?php echo md5($question['Id'] . '1'); ?>')"><br>
												<input type="text" value="<?php echo $question['en_desc'];  ?>" class="edit_inp title_en font-size-13 mb-0 text-muted " onkeyup="update_data(<?php echo $question['Id']; ?>,'desc','en','<?php echo md5($question['Id'] . '2'); ?>')" id="<?php echo md5($question['Id'] . "2"); ?>" val_type="desc" lang="en">
											</td>
											<td class="arabic">
												<input type="text" value="<?php echo $question['ar_title'];  ?>" class="edit_inp title_en font-size-15 mb-1 font-weight-normal" id="<?php echo md5($question['Id'] . "3"); ?>" val_type="title" lang="ar" onkeyup="update_data(<?php echo $question['Id']; ?>,'title','ar','<?php echo md5($question['Id'] . '3'); ?>')"><br>
												<input type="text" value="<?php echo $question['ar_desc'];  ?>" class="edit_inp title_en font-size-13 mb-0 text-muted" id="<?php echo md5($question['Id'] . "4"); ?>" onkeyup="update_data(<?php echo $question['Id']; ?>,'desc','ar','<?php echo md5($question['Id'] . '4'); ?>')">
											</td>
											<td><?php echo $question['TimeStamp']  ?></td>
											<td>
												<label class="switch">
													<input type="checkbox" question_Id="<?php echo $question['Id']  ?>" name="ischecked" <?php echo $question['status'] == 1 ? 'checked' : "";  ?> onchange="update_status(<?php echo $question['Id']  ?>)">
													<span class="slider round"></span>
												</label>
											</td>
											<?php $use_conter = $this->db->query("SELECT Id FROM `sv_st_questions`
									WHERE `question_id` = '" . $question['Id'] . "' ")->num_rows(); ?>
											<td class="text-center">
												<?php if ($use_conter == 0) {  ?>
													<i class="uil uil-trash delete" onclick="delete_q(<?php echo $question['Id']; ?>)" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Forever"></i>
												<?php   } else { ?>
													<i class="uil uil-trash delete_disabled" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="sorry you can't delete this question because it Alredy used <?php echo $use_conter  ?> Time(s) "></i>
												<?php   } ?>
											</td>
										</tr>
									<?php endforeach;  ?>
								</tbody>
							</table>
							<div class="col-12 text-center">
								<?= $links ?>
							</div>
						</div>
					</div>
				</div>
				<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title mt-0" id="myModalLabel"> Add Question</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
									<div class="card-body">
										<div class="alert alert-success alert-dismissible fade show code" role="alert" style="display: none;">
											<i class="uil uil-check mr-2"></i>
											After Adding This The code will be :<br>
											<strong><?php echo $code;  ?> </strong>
										</div>
										<div id="StatusBox"></div>
										<form id="ADDquestion">
											<div class="row">
												<div class="col-lg-12 ">
													<div class="form-group">
														<label for="Title_EN">Title En</label>
														<input type="text" class="form-control" placeholder="Title EN" id="Title_EN" name="en_title">
													</div>
													<div class="form-group">
														<label for="Title_AR">Title AR</label>
														<input type="text" class="form-control" placeholder="Title AR" id="Title_AR" name="ar_title">
													</div>
													<div class="form-group">
														<label for="Desc_En"> Desc En </label>
														<textarea name="Desc_En" cols="30" rows="4" placeholder="Desc EN" class="form-control"></textarea>
													</div>
												</div>
												<?php /* <div class="col-lg-12 ">
													<div class="form-group">
														<label for="Desc_Ar"> Desc  Ar </label>
														<textarea name="Desc_Ar" cols="30" rows="4" placeholder="Desc AR" class="form-control" ></textarea>
													</div>
												</div> */ ?>
											</div>
											<div class="mt-1">
												<button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
												<button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
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
		$('.table').DataTable({
			'paging': false,
		});

		function update_status(Id) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>EN/Dashboard/changequestion',
				data: {
					question_id: Id,
				},
				success: function(data) {
					if (data === "ok") {
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
						Command: toastr["success"]("the question status updated ");
						console.log(status);
					} else {
						Swal.fire(
							'error',
							'Oops! We have an unexpected error.',
							'error'
						);
					}
				},
				ajaxError: function() {
					Swal.fire(
						'error',
						'oops!! لدينا خطأ',
						'error'
					);
				}
			});
		}

		$('input,textarea').each(function() {
			$(this).on('keypress keydown keyup', function() {
				if ($('input[name="en_title"]').val().length > 0 && $('input[name="ar_title"]').val().length && $('textarea[name="Desc_En"]').val().length && $('textarea[name="Desc_Ar"]').val().length) {
					$('.code').slideDown();
				} else {
					$('.code').slideUp();
				}
			});
		});
		/*
$('.edit_inp').each(function(){
	$(this).on('keyup',function(){
		 var id    = $(this).attr('for');
		 var type  = $(this).attr('val_type');
		 var lang  = $(this).attr('lang');
		 var val = $(this).val();
        
	});
});	
	*/
		function update_data(id, type, lang, val_id) {
			const val = $('#' + val_id).val();
			$.ajax({
				type: 'PUT',
				url: '<?php echo base_url(); ?>EN/Dashboard/changequestion',
				data: {
					quastuion_id: id,
					type: type,
					val: val,
					lang: lang,
				},
				success: function(data) {
					if (data !== 'ok') {
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
				ajaxError: function() {
					Swal.fire(
						'error',
						'oops!! لدينا خطأ',
						'error'
					);
				}
			});
		}



		function delete_q(Id) {
			Swal.fire({
				title: 'هل أنت متأكد',
				text: "لن تتمكن من التراجع عن هذا!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'نعم,أحذفها!',
				cancelButtonText: 'No, cancel!',
				confirmButtonClass: 'btn btn-success mt-2',
				cancelButtonClass: 'btn btn-danger ml-2 mt-2',
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					//DELETE 	
					$.ajax({
						type: 'DELETE',
						url: '<?php echo base_url(); ?>EN/Dashboard/changequestion',
						data: {
							question_id: Id,
						},
						success: function(data) {
							if (data === "ok") {
								Swal.fire({
									title: 'Deleted!',
									text: 'Your question has been deleted.',
									icon: 'success'
								}).then(function(result) {
									$('#question_' + Id).addClass('animate__flipOutX');
									setTimeout(function() {
										$('#question_' + Id).remove();
									}, 800);
								});
							} else {
								Swal.fire(
									'error',
									'Oops! We have an unexpected error.',
									'error'
								);
							}
						},
						ajaxError: function() {
							Swal.fire(
								'error',
								'oops!! لدينا خطأ',
								'error'
							);
						}
					});
				}
			});
		}



		$("#ADDquestion").on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>EN/Dashboard/startAddNewquestion',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					$('#StatusBox').html(data);
				},
				ajaxError: function() {
					$('#StatusBox').css('background-color', '#B40000');
					$('#StatusBox').html("Ooops! Error was found.");
				}
			});
		});
	</script>

</body>

</html>