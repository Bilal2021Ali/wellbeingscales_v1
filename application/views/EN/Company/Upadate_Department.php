<!doctype html>
<html lang="en">

<head>
     <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
     <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
     <link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
     <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
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
     </style>

     <div class="main-content">
          <div class="page-content">
		  <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO023: Update Information </h4>
               <div class="row">
			   
                    <div class="col-xl-6">
<h4 class="card-title" style="background: #add138;padding: 10px;color: #202124;border-radius: 4px;"> CO024: Update </h4>
                         <div class="card">
                              <div class="card-body">
                                   <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                        <span id="Toast">Check the information</span>
                                   </div>

                                   <?php foreach ($DepartmentData as $data) { ?>
                                        <form class="needs-validation InputForm" novalidate="" style="margin-bottom: 27px;" id="UpdateDepartment">
                                             <hr style="border-width: 3px;border-top-color: #219824;margin: 30px auto;">
                                             <div class="row">
											                                                   <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom02">Department English Name:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="Department English Name" name="English_Title" required="" value="<?= $data['Dept_Name_EN']; ?>">
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom01">Department Arabic Name:</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Department Arabic Name" name="Arabic_Title" required="" value="<?= $data['Dept_Name_AR']; ?>">
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
                                                  </div>

                                             </div>

                                             <div class="row">
											 <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom02">Manager English Name:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="Manager English Name" name="Manager_EN" value="<?= $data['Manager_EN']; ?>" required="">
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom01">Manager Arabic Name:</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Manager Arabic Name" name="Manager_AR" value="<?= $data['Manager_AR']; ?>" required="">
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
                                                  </div>
                                                  
                                             </div>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       
                                                            <label class="control-label">Country:</label>
                                                            <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="countries">
                                                                 <?php
                                                                 $list = $this->db->query("SELECT * FROM `r_countries` 
                                                                 ORDER BY `name` ASC")->result_array();
                                                                 foreach ($list as $site) {
                                                                 ?>
                                                                      <option value="<?= $site['id'];  ?>" <?= $site['id'] == $data['Country'] ? 'selected' : ''  ?>> <?= $site['name']; ?> </option>
                                                                 <?php  } ?>
                                                            </select>
                                                       
                                                  </div>
												  <div class="col-md-6">
												  
                                                       <div class="cities"></div>
                                                  
												  </div>
                                             </div>
                                             <div class="row">
                                                  
                                             </div>

                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom01">Phone:</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Phone" value="<?= $data['Phone']; ?>" name="Phone" required="">
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom02">Email:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="Email" name="Email" value="<?= $data['Email']; ?>" required="">
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
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
                                                  <?php $positions = $this->db->query("SELECT * FROM `r_positions_gm` ORDER BY `Position` DESC ")->result_array(); ?>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label>Manager Position:</label>
                                                            <select name="position" class="custom-select">
                                                                 <?php foreach ($positions as $position) { ?>
                                                                      <option value="<?= $position['Id'] ?>" <?= $position['Id'] == $data['Position'] ? 'selected' : '' ?> class="option"><?= $position['Position'] ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col-md-6" style="display: grid;align-items: center;">
                                                       <div class="form-group">
                                                            <label>Username:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" value="<?= $data['Username']; ?>" placeholder="We apologize. The username cannot be changed. " data-toggle="tooltip" data-placement="top" title="" data-original-title="Sorry You Can't Change The Username " readonly>
                                                            <div class="valid-feedback">
                                                                 Looks Good !
                                                            </div>
                                                       </div>
                                                  </div>
												  
												  <div class="col-md-6" style="display: grid;align-items: center;">
												        <div class="form-group">
													        <label>Department ID: </label>
															<input type="text" class="form-control" id="validationCustom02" value="<?= $data['DepartmentId']; ?>" placeholder="We apologize. The username cannot be changed. " data-toggle="tooltip" data-placement="top" title="" data-original-title="Sorry You Can't Change Department ID " readonly>
															<div class="valid-feedback">
																Looks good
													</div>
												</div>
											</div>
												  
												  
                                             </div>
                                             <input type="hidden" value="<?= $data['Id'] ?>" name="ID">
                                             <button class="btn btn-primary" type="Submit">Update</button>
                                             <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </form>
                                   <?php } ?>
                              </div>
                         </div>

                    </div>
                    <div class="col-xl-6">
					<h4 class="card-title" style="background: #add138;padding: 10px;color: #202124;border-radius: 4px;"> CO025: List of last added departments </h4>
                         <div class="card">
                              <div class="card-body" style="height: 643px;">
                                   
                                   <table class="table mb-0">
                                        <?php $listofadmins = $this->db->query("SELECT * FROM `l1_co_department` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array(); ?>
                                        <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                             <tr>
                                                  <th>#</th>
                                                  <th style="width: 40%;">Name</th>
                                                  <th>Country</th>
                                                  <th>Status</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach ($listofadmins as $adminData) { ?>
                                                  <tr>
                                                       <th scope="row">
                                                            <?= $adminData['Id'] ?>
                                                       </th>
                                                       <td>
                                                            <?= $adminData['Dept_Name_EN'] ?>
                                                       </td>

                                                       <td>
                                                            <?php
                                                            $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
								   WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                                            foreach ($contriesarray as $contrie) {
                                                                 echo $contrie['Name_EN'];
                                                            }
                                                            ?>
                                                       </td>
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
     <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
     <script>
          $('table').DataTable();
          $("#UpdateDepartment").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/Company/startUpdatingDepart',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                         $('#Toast').css('display', 'block');
                         $('#Toast').html(data);

                    },
                    ajaxError: function() {
                         $('.alert.alert-info').css('background-color', '#DB0404');
                         $('.alert.alert-info').html("Ooops! Error was found.");
                    }
               });
          });

          const getCities = (countryId, activeCity = null) => {
               $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/Ajax/getThisCountrycities' + (activeCity != null ? '/' + activeCity : ''),
                    data: {
                         id: countryId,
                    },
                    beforeSend: function() {
                         $('.cities').html('Please Wait..');
                    },
                    success: function(data) {
                         $('.cities').html(data);
                    },
                    ajaxError: function() {
                         $('.cities').css('background-color', '#B40000');
                         $('.cities').html("Ooops! Error was found.");
                    }
               });
          }
          getCities(<?= $DepartmentData[0]['Country'] ?>, <?= $DepartmentData[0]['Citys'] ?>);

          function sendbyemail() {
               $('.myModal').addClass('myModalActive');
               $('.outer').css('display', 'block');
          }


          // Cancel *
          $('select[name="countries"]').change(function() {
               var countryId = $(this).val();
               getCities(countryId);
          });


          $('#back').click(function() {
               location.href = "<?= base_url() . "EN/Company/DepartmentsList"; ?>";
          });

          function back() {
               location.href = "<?= base_url() . "EN/Company/DepartmentsList"; ?>";
          }
     </script>
     <script src="<?= base_url(); ?>assets/js/pages/range-sliders.init.js"></script><!-- Ion Range Slider-->
     <script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
     <!-- Range slider init js-->
</body>

</html>