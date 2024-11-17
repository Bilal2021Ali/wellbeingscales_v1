<!doctype html>
<html lang="en">

<head>
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
	<link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<style>
		.slidecontainer {
			width: 100%;
			/* Width of the outside container */
		}

		/* The slider itself */
		.slider {
			-webkit-appearance: none;
			/* Override default CSS styles */
			appearance: none;
			width: 100%;
			/* Full-width */
			height: 25px;
			/* Specified height */
			background: #d3d3d3;
			/* Grey background */
			outline: none;
			/* Remove outline */
			opacity: 0.7;
			/* Set transparency (for mouse-over effects on hover) */
			-webkit-transition: .2s;
			/* 0.2 seconds transition on hover */
			transition: opacity .2s;
		}

		/* Mouse-over effects */
		.slider:hover {
			opacity: 1;
			/* Fully shown on mouse-over */
		}

		/* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
		.slider::-webkit-slider-thumb {
			-webkit-appearance: none;
			/* Override default look */
			appearance: none;
			width: 25px;
			/* Set a specific slider handle width */
			height: 25px;
			/* Slider handle height */
			background: #4CAF50;
			/* Green background */
			cursor: pointer;
			/* Cursor on hover */
		}

		.slider::-moz-range-thumb {
			width: 25px;
			/* Set a specific slider handle width */
			height: 25px;
			/* Slider handle height */
			background: #4CAF50;
			/* Green background */
			cursor: pointer;
			/* Cursor on hover */
		}
	</style>
</head>

<body class="light menu_light logo-white theme-white">

	<?php
	$idd = $sessiondata['admin_id'];
	$admindata = $this->db->query("SELECT * FROM `l0_organization` WHERE `Id` = '" . $idd . "' ")->result_array();
	$country = $admindata[0]['CountryID'];

	?>
	<style>
		.Ver i {
			background: #019C00;
			color: #fff;
			text-align: center;
			font-size: 20px;
			display: grid;
			height: 20px;
			border-radius: 13px;
			font-style: normal;
			font-weight: bold;
			line-height: 19px;
		}

		.Not i {
			background: #F8002E;
			color: #fff;
			text-align: center;
			font-size: 20px;
			display: grid;
			height: 20px;
			border-radius: 13px;
			font-size: 14px;
			font-style: normal;
			font-weight: bold;
			line-height: 19px;
		}

		.InfosCards h4,
		.InfosCards p {
			color: #fff;
		}

		.InfosCards .card-body {
			border-radius: 5px;
		}

		.tab-pane h6 {
			padding-bottom: 10px;
			color: #fff;
			border-radius: 5px;
			padding-top: 10px;
		}
	</style>

	<div class="main-content">
		<div class="page-content">
		<h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO018: ADD Department - <?= $sessiondata['f_name']; ?> </h4>
		
			<div class="row">
				
				<div class="col-md-6 col-xl-3 InfosCards">
					<div class="card">
						<div class="card-body" style="background-color: #605091;">
							<div class="float-right mt-2">
								<img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px">
							</div>
							<div>
								<?php
								$all_ministry = $this->db->query("SELECT * FROM `l1_co_department`
				 WHERE Added_By = $idd ")->num_rows();
								$lastminED = $this->db->query("SELECT * FROM `l1_co_department`
				 WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
								?>
								<h4 class="mb-1 mt-1">
									<span data-plugin="counterup"><?= $all_ministry ?></span>
								</h4>
								<p class="mb-0">Total Department</p>
							</div>
							<p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
									<?php if (!empty($lastminED)) { ?>
										<?php foreach ($lastminED as $last) { ?>
											<?= $last['Created'] ?></span><br>
								Last Added division/branch
							<?php } ?>
						<?php } else { ?>
							<?= "--/--/--" ?></span><br>
							Last Added division/branch
						<?php } ?>
							</p>
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #262232;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $ours = $this->db->query(" SELECT * FROM `l1_co_department`
			  WHERE `Added_By` = '" . $idd . "' ")->result_array();
                                    $studentscounter = 0;
                                    $lastaddeds = array();
                                    foreach ($ours as $dept) {
                                        $patient = $this->db->query(" SELECT Created FROM 
				  `l2_co_patient` WHERE `Added_By` = '" . $dept['Id'] . "' ORDER BY `Id` DESC ")->result_array();
                                        if (!empty($patient)) {
                                            $studentscounter += sizeof($patient);
                                            $lastaddeds[] = $patient[0]['Created'];
                                        }
                                    }
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                                            <?= $studentscounter;  ?>
                                        </span> </h4>
                                    <p class="mb-0">User Counter</p>
                                </div>
                                <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php
                                        //print_r($test);
                                        if (!empty($lastaddeds)) {
                                            $last = sizeof($lastaddeds);
                                        ?>
                                            <?= $lastaddeds[$last - 1]; ?></span><br>
                                    Last added user
                                <?php } else { ?>
                                    <?= "--/--/--"; ?></span><br>
                                    Last added user
                                <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div><!-- end col -->
				<div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #262232;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools"> </div>
                                <div>
                                    <?php
                                    $allDev = 0;
                                    $ListOfThis = array();
                                    $All_added_schools = $this->db->query("SELECT * FROM `l1_co_department`
               WHERE `Added_By` = $idd ")->result_array();
                                    foreach ($All_added_schools as $school) {
                                        $devicesforThis = $this->db->query("SELECT * FROM `l2_co_devices`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($devicesforThis as $dvices) {
                                            $allDev++;
                                            $ListOfThis[] = $dvices["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    $lasts = $this->db->query("SELECT * FROM `l1_co_department`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                                    ?>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $allDev ?></span></h4>
                                    <p class="mb-0">Device Counter</p>
                                </div>
                                <?php if (!empty($ListOfThis)) { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= $ListOfThis[0]; ?></span><br>
                                        Last registered device </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered device </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div><!-- end col -->
				<div class="col-md-6 col-xl-3 InfosCards">
                        <div class="card">
                            <div class="card-body" style="background-color: #450202;">
                                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/countersites.png" alt="Test" width="50px"> </div>
                                <div>
                                    <?php
                                    $allSites = 0;
                                    $ListOfSitesforThis = array();
                                    /*$All_added_schools = $this->db->query("SELECT * FROM `l1_school`
              WHERE `Added_By` = $idd ")->result_array();*/
                                    foreach ($All_added_schools as $school) {
                                        $SitesforThis = $this->db->query("SELECT * FROM `l2_co_site`
                    WHERE Added_by = '" . $school['Id'] . "' ORDER BY Created DESC ")->result_array();
                                        foreach ($SitesforThis as $Sites) {
                                            $allSites++;
                                            $ListOfSitesforThis[] = $Sites["Created"];
                                        }
                                        //$Last_Created = end($ListOfThis[]);
                                    }
                                    ?>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?= $allSites ?></span> </h4>
                                    <p class="mb-0">Site Counter</p>
                                </div>
                                <?php if (!empty($ListOfSitesforThis)) { ?>
                                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> <?= $ListOfSitesforThis[0] ?> </span><br>
                                        Last registered site </p>
                                <?php } else { ?>
                                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;"> <?= "--/--/--" ?></span><br>
                                        Last registered site </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div><!-- end col-->

			</div> <!-- end row-->
			<div class="row">
				<div class="col-xl-6">
				<h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO019: Add New</h4>
					<div class="card">
						<div class="card-body">
							<div id="Toast"></div>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-selected="true">
										<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
										<span class="d-none d-sm-block">Section</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#profile1" role="tab" aria-selected="false">
										<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
										<span class="d-none d-sm-block">Branch</span>
									</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content p-3 text-muted">
								<div class="tab-pane active" id="home1" role="tabpanel">
									<h6 class="text-center" style="background: #0eacd8;">Add New</h6>
									<form class="needs-validation InputForm" style="margin-bottom: 27px;" id="addDepartment">
										<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom02">Department English Name:</label>
													<input type="text" class="form-control" placeholder="Department English Name" name="English_Title" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom01">Department Arabic Name:</label>
													<input type="text" class="form-control" id="validationCustom01" placeholder="Department Arabic Name" name="Arabic_Title" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											   <div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom02">Manager English Name:</label>
													<input type="text" class="form-control" placeholder="Manager English Name" name="Manager_EN" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom01">Manager Arabic Name:</label>
													<input type="text" class="form-control" id="validationCustom01" placeholder="Manager Arabic Name" name="Manager_AR" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom01">Phone:</label>
													<input type="text" class="form-control" id="validationCustom01" placeholder="Phone" name="Phone" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom02">Email:</label>
													<input type="text" class="form-control" placeholder="Email" name="Email" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<div class="form-group mb-4">
													<label class="control-label">Country:</label>
													<select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="countries">
														<?php
														$list = $this->db->query("SELECT * FROM `r_countries` 
														ORDER BY `name` ASC")->result_array();
														foreach ($list as $site) { ?>
															<option value="<?= $site['id'];  ?>">
																<?= $site['name']; ?>
															</option>
														<?php  } ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<div class="cities"></div>
											</div>
										</div>
										<?php $positions = $this->db->query("SELECT * FROM `r_positions_gm` ORDER BY `Position` DESC ")->result_array(); ?>
										<div class="row">
											<div class="col-md-6">
												<label>Type</label>
												<select name="Type" class="custom-select">
													<option value="Government" class="option">Government</option>
													<option value="Private" class="option">Private</option>
												</select>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Manager Position:</label>
													<select name="position" class="custom-select">
														<?php foreach ($positions as $position) { ?>
															<option value="<?= $position['Id'] ?>" class="option"><?= $position['Position'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6" style="display: grid;align-items: center;">
												<div class="form-group">
													<label>User Name:</label>
													<input type="text" class="form-control" placeholder="User Name" name="Username" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6" style="display: grid;align-items: center;">
												<div class="form-group">
													<label>Department ID: </label>
													<input type="text" class="form-control" placeholder="Department ID" name="DepartmentId" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
										</div>

										<button class="btn btn-primary" type="Submit" id="sendingbutton"> Add </button>
										<button type="button" class="btn btn-light" id="back">Cancel</button>
									</form>
								</div>
								<div class="tab-pane" id="profile1" role="tabpanel">
									<h6 class="text-center" style="background: #add138;">Add New</h6>
									<form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;" id="addBranch">
										<div class="row">
																					<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom02">Branch English Name:</label>
													<input type="text" class="form-control" placeholder="Branch English Name" name="English_Title" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom01">Branch Arabic Name:</label>
													<input type="text" class="form-control" id="validationCustom01" placeholder="Branch Arabic Name" name="Arabic_Title" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>

										</div>

										<div class="row">
																					<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom02">Manager English Name:</label>
													<input type="text" class="form-control" placeholder="Manager English Name" name="Manager_EN" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom01">Manager Arabic Name:</label>
													<input type="text" class="form-control" id="validationCustom01" placeholder="Manager Arabic Name" name="Manager_AR" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom01">Phone: </label>
													<input type="text" class="form-control" id="validationCustom01" placeholder="Phone" name="Phone" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="validationCustom02">Email:</label>
													<input type="text" class="form-control" placeholder="Email" name="Email" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<div class="form-group mb-4">
													<label class="control-label">Country: </label>
													<select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="countries_branch">
														<?php
														$list = $this->db->query("SELECT * FROM `r_countries` 
														 ORDER BY `name` ASC")->result_array();
														foreach ($list as $site) { ?>
															<option value="<?php
																			echo $site['id'];  ?>">
																<?= $site['name']; ?>
															</option>
														<?php  } ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<div class="cities_branch"></div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<label>Type:</label>
												<select name="Type" class="custom-select">
													<option value="Government" class="option">Government</option>
													<option value="Private" class="option">Private</option>
												</select>
											</div>
<div class="col-md-6">
												<div class="form-group">
													<label> Manager Position: </label>
													<select name="position" class="custom-select">
														<?php foreach ($positions as $position) { ?>
															<option value="<?= $position['Id'] ?>" class="option"><?= $position['Position'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<?php
										$positions = $this->db->query("SELECT * FROM `r_positions_gm` 
														ORDER BY `Position` DESC ")->result_array();
										?>
										<div class="row">
											
											<div class="col-md-6" style="display: grid;align-items: center;">
												<div class="form-group">
													<label>User Name:</label>
													<input type="text" class="form-control" placeholder="User Name" name="Username" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
																						<div class="col-md-6" style="display: grid;align-items: center;">
												<div class="form-group">
													<label>Department ID: </label>
													<input type="text" class="form-control" placeholder="Department ID" name="DepartmentId" required>
													<div class="valid-feedback">
														Looks good
													</div>
												</div>
											</div>
										</div>

										<button class="btn btn-primary" type="Submit" id="sendingbutton">
											Add
										</button>
										<button type="button" class="btn btn-light" id="back">Cancel</button>
									</form>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="col-xl-6">
				<h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO020: List of Latest Branches and Departments</h4>
					<div class="card">
						<div class="card-body" style="height: 735px;">
							<table class="table mb-0">
								<?php $listofadmins = $this->db->query("SELECT * FROM `l1_co_department` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array(); ?>
								<thead  style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
									<tr>
										<th id="test"> # </th>
										<th style="width: 40%;">Name</th>
										<th>Country and City</th>
										<th>Type</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sn = 0;
									foreach ($listofadmins as $adminData) {
										$sn++;
									?>
										<tr>
											<th scope="row">
												<?= $sn; ?>
											</th>
											<td>
												<?= $adminData['Dept_Name_EN'] ?>
												<p class="text-muted font-size-13 mb-0"><?= $adminData['Father']; ?></p>
											</td>
											<td>
												<?php
												$contriesarray = $this->db->query("SELECT * FROM `r_cities` 
								   WHERE id = '" . $adminData['Citys'] . "'
								   ORDER BY `Name_EN` ASC LIMIT 1")->result_array();
												$ccountery = $this->db->query("SELECT * FROM `r_countries` 
								   WHERE id = '" . $adminData['Country'] . "'
								   ORDER BY `name` ASC LIMIT 1")->result_array();
												?>
												<h6 class="font-size-15 mb-1 font-weight-normal">
													<?php
													if (!empty($ccountery)) {
														echo $ccountery[0]['name'];
													} else {
														echo "--";
													}
													?>
												</h6>
												<p class="text-muted font-size-13 mb-0">
													<?php
													if (!empty($contriesarray)) {
														echo $contriesarray[0]['Name_EN'];
													} else {
														echo "---";
													}
													?>
												</p>
											</td>
											<td><?= $adminData['Dept_Type']; ?></td>
											<?php
											if ($adminData['verify'] == 1) {
												$classname = 'Ver';
											} else {
												$classname = 'Not';
											}
											?>
											<td class="<?= $classname; ?>">
												<?php if (!empty($adminData['Manager']) && !empty($adminData['Phone'])) { ?>
													<i class="uil-check" style="font-size: 20px;"></i>
												<?php } else { ?>
													<i class="" style="font-size: 14px;">X</i>
												<?php } ?>
											</td>
										</tr>
									<?php }
									?>
								</tbody>
							</table>

						</div>
					</div>
					<!-- end card -->
				</div>
			</div>
		</div>

	</div>
	</div>
	</div>
	</div>

	<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/rating-init.js"></script>
	<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
	<script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
	<script>
		$("#addDepartment").on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>EN/Company/startAddingDep',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('#sendingbutton').attr('disabled', '');
					$('#sendingbutton').html('wait please');
				},
				success: function(data) {
					$('#sendingbutton').removeAttr('disabled', '');
					$('#sendingbutton').html('try again');
					$('#Toast').css('display', 'block');
					$('#Toast').html(data);
				},
				ajaxError: function() {
					$('#Toast').css('background-color', '#B40000');
					$('#Toast').html("Ooops! Error was found.");
				}
			});
		});

		$("#addBranch").on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>EN/Company/startAddingBr',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('#sendingbutton').attr('disabled', '');
					$('#sendingbutton').html('wait please');
				},
				success: function(data) {
					$('#sendingbutton').removeAttr('disabled');
					$('#sendingbutton').html('try again');
					$('#Toast').css('display', 'block');
					$('#Toast').html(data);
				},
				ajaxError: function() {
					$('#Toast').css('background-color', '#B40000');
					$('#Toast').html("Ooops! Error was found.");
				}
			});
		});


		$('select[name="countries"]').change(function() {
			var countryId = $(this).val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>EN/Ajax/getThisCountrycities',
				data: {
					id: countryId,
				},
				beforeSend: function() {
					$('.cities').html('Loading...');
				},
				success: function(data) {
					$('.cities').html(data);
				},
				ajaxError: function() {
					$('.cities').css('background-color', '#B40000');
					$('.cities').html("Ooops! Error was found.");
				}
			});
		});

		$('select[name="countries_branch"]').change(function() {
			var countryId = $(this).val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>EN/Ajax/getThisCountrycities',
				data: {
					id: countryId,
				},
				beforeSend: function() {
					$('.cities_branch').html('Loading...');
				},
				success: function(data) {
					$('.cities_branch').html(data);
				},
				ajaxError: function() {
					$('.cities_branch').css('background-color', '#B40000');
					$('.cities_branch').html("Ooops! Error was found.");
				}
			});
		});


		// Cancel *

		$('#back').click(function() {
			location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
		});

		function back() {
			location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
		}


		$('#test').click(function() {
			Swal.fire({
				title: 'Success!',
				text: 'The data were inserted successfully. The email will be sent to ',
				icon: 'success',
				confirmButtonColor: '#5b8ce8',
			});
		});
	</script>
</body>

</html>