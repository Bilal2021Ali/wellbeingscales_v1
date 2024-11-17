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
	   <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;">SU 007: Refrigerator Management</h4>
	   <div class="row">
      <div class="col-md-6 col-xl-4 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #097390;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Refrigerator.png" alt="schools" width="100px"> </div>
            <div>
              <?php
              $all = $this->db->query( "SELECT * FROM `refrigerator_area` " )->num_rows();
              $lasts = $this->db->query( "SELECT * FROM `refrigerator_area`
											 ORDER BY Id DESC LIMIT 1 " )->result_array();
              ?>
              <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                <?= $all ?>
                </span></h4>
              <p class="mb-0">Total Refrigerators</p>
            </div>
            <?php if (!empty($lasts)) { ?>
            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
              <?php foreach ($lasts as $last) { ?>
              <?= $last['TimeStamp'] ?>
              </span><br>
              Last Registered Refrigerator </p>
            <?php } ?>
            <?php } else { ?>
            <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
              Last Registered Refrigerator </p>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-6 col-xl-4 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #0b86a8;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Refrigerator.png" alt="schools" width="100px"> </div>
            <div>
              <?php
              $all_ministry = $this->db->query( "SELECT * FROM `refrigerator_area` WHERE user_type = 'school' " )->num_rows();
              $lastminED = $this->db->query( "SELECT * FROM `refrigerator_area` WHERE user_type = 'school' ORDER BY Id DESC LIMIT 1 " )->result_array();
              ?>
              <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                <?= $all_ministry ?>
                </span> </h4>
              <p class="mb-0">Total Refrigerators in Ministries</p>
            </div>
            <?php if (!empty($lastminED)) { ?>
            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
              <?php foreach ($lastminED as $last) { ?>
              <?= $last['TimeStamp'] ?>
              </span><br>
              Last Registered Refrigerator
              <?php
              }
              } else {
                  ?>
            <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
              Last Registered Refrigerator </p>
            <?php } ?>
            </p>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-6 col-xl-4 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #0c99c0;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Refrigerator.png" alt="" width="100px"> </div>
            <div>
              <?php
              $all_ministry = $this->db->query( "SELECT * FROM `refrigerator_area` WHERE user_type = 'company_department' " )->num_rows();
              $lastminED = $this->db->query( "SELECT * FROM `refrigerator_area` WHERE user_type = 'company_department' ORDER BY Id DESC LIMIT 1 " )->result_array();
              ?>
              <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                <?= $all_ministry ?>
                </span> </h4>
              <p class="mb-0">Total Refrigerators in Companies</p>
            </div>
            <?php if (!empty($lastminED)) { ?>
            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
              <?php foreach ($lastminED as $last) { ?>
              <?= $last['TimeStamp'] ?>
              </span><br>
              Last Registered Refrigerator
              <?php } ?>
            </p>
            <?php } else { ?>
            <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
              Last Registered Refrigerator </p>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- end col--> 
    </div>
		<div class="card">
			<div class="card-body">
                <p>Connect Full Department's Refrigerators <a href="<?php echo base_url() ?>EN/Dashboard/Manage_depts_Refrigerators">here</a></p>
			    <div class="table-responsive mb-0" data-pattern="priority-columns">
					<table class="table">
				  <thead>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > # </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > MAC address </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > Refrigerator type </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > Site </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > Date &amp; Time </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > Department </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > Company </th>
					<th class="card-title" style="background: #0eacd8; padding: 10px;color: #FFFFFF;border-radius: 4px;" > Action </th>
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