<!doctype html>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="preconnect" href="https:/fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
	<link href="<?php echo base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
</head>
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

	.delete_question {
		font-size: 23px;
		color: #fd0000;
		cursor: pointer;
		float: right;
		margin-bottom: 20px;
	}

	.questions {
		font-size: 23px;
		color: #3c40c6;
		cursor: pointer;
	}

	.modal.fade .modal-dialog {
		-webkit-transform: translate(0, 0);
		transform: translate(0, 0);
	}

	.zoom-in {
		transform: scale(0) !important;
		opacity: 0;
		-webkit-transition: 0.5s all 0s;
		-moz-transition: 0.5s all 0s;
		-ms-transition: 0.5s all 0s;
		-o-transition: 0.5s all 0s;
		transition: 0.5s all 0s;
		display: block !important;
	}

	.zoom-in.show {
		opacity: 1;
		transform: scale(1) !important;
		transform: none;
	}

	.ADD {
		color: green;
		cursor: pointer;
		font-size: 20px;
	}

	.add_q_btn {
		transition: 0.2s all;
	}
</style>
<body>
<div class="main-content">
  <div class="page-content">
	   <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 007: Refrigerator Management</h4>
		<div class="card">
			<div class="card-body">
                <p>Connect Full Department's Refrigerators <a href="<?php echo base_url() ?>EN/Dashboard/Manage_depts_Refrigerators">Here</a></p>
			    <div class="table-responsive mb-0" data-pattern="priority-columns">
					<table class="table">
				  <thead>
					<th> # </th>
					<th> MAC Address </th>
					<th> Type </th>
					<th> Site </th>
					<th> Date &amp; Time </th>
					<th> Department </th>
					<th> Company </th>
					<th> Action </th>
				  </thead>
				  <tbody>
					<?php   foreach($Refrigerators as $key=>$Refrigerator){ ?>
					<tr>
					  <td><?php  echo $key+1  ?></td>
					  <td><?php  echo $Refrigerator['mac_adress']  ?></td>
					  <td>
					  <?php
						  echo $Refrigerator[ 'device_name' ] . '(' . $Refrigerator[ 'min_temp' ] . ' / ' . $Refrigerator[ 'max_temp' ] . ')';
					  ?>
					  </td>
					  <td><?php  echo $Refrigerator['The_Site_Name']  ?></td>
					  <td><?php  echo $Refrigerator['Added_in']  ?></td>
					  <td><?php  echo $Refrigerator['Dept_name']  ?></td>
					  <td><?php  echo $Refrigerator['Comp_name']  ?></td>
					  <td class="connected">
						  <a href="<?php echo base_url() ?>EN/Dashboard/Refrigerator_connect_management/comp_dept/<?php echo $Refrigerator['ref_id'] ?>" 
							 data-toggle="tooltip"
							 data-placement="top" data-original-title="Connected systems">
							  <i class="uil uil-link"></i>
						  </a>
					  </td>
					</tr>
					<?php   }  ?>
				  </tbody>
				</table>
				</div>  
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
$('.table').DataTable();
</script>	
</body>
</html>