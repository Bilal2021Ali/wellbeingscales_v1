<!doctype html>
<html>

<head>
     <meta charset="utf-8">
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

</head>
<style>
     .select2-container--default .select2-selection--single {
          height: 37px;
          padding-top: 3px;
     }    
     .select2-container--default .select2-selection--single .select2-selection__arrow{
              height: 35px;
              width: 31px;
     }
</style>
<style>
     .InfosCards h4,.InfosCards p{
          color: #fff;
     } 
     .InfosCards .card-body{
          border-radius: 5px;
     }
</style>
<body>
     <div class="main-content">
          <div class="page-content">
	 <div class="row">
	                             <div class="col-md-4 col-xl-4 InfosCards">
                            <div class="card">
							
                                   <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                    <div class="card-body" style="background-color: #022326;">
                                        <div class="float-right mt-2">
                                           <!-- <div id="CharTTest1"></div>-->
                             <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px">     
                                        </div>
                                        <div>
                                             <?php
                                             $idd = $sessiondata['admin_id'];
                    $all = $this->db->query("SELECT * FROM `l2_devices` WHERE `Added_By` = $idd 
                    AND `UserType` = 'school' ")->num_rows(); 
                    $lasts = $this->db->query("SELECT * FROM `l2_devices`  WHERE `Added_By` = $idd AND `UserType` = 'school' ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             ?>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                            <p class="mb-0">Total Of Devices</p>
                                        </div>
                                        <?php if(!empty($lasts)){ ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($lasts as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Registered Device
                                        </p>
                                        <?php } ?>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php echo "--/--/--" ?></span><br>
                                         Last Registered Device
                                        </p>
                                        <?php } ?>
                                    </div>
                                 </div> 
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-4 col-xl-4 InfosCards">
                              <div class="card">
                              <div class="card-body" style="background-color: #ff26be;padding: 5px">
                                   <div class="card-body" style="background-color: #2e001f;">
                                        <div class="float-right mt-2">
                             <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Devices_Icons.png" 
                              alt="schools" width="50px">     
                                        </div>
                                        <div>
                                             <?php 
               $allDevices = 0;
               $ListOfThisDevice;                              
               $All_added_Devices = $this->db->query("SELECT * FROM `l2_devices`
               WHERE `Added_By` = $idd AND `Comments` = 'Thermometer' AND `UserType` = 'school' ")->result_array(); 
               foreach($All_added_Devices as $DevCr ){
                    $allDevices++;
                    $ListOfThisDevice[] = $DevCr["Created"];
               }
                                        ?>
                         <h4 class="mb-1 mt-1">
                         <span data-plugin="counterup"><?php echo $allDevices ?></span>
                         </h4>
                         <p class="mb-0">Total of Thermometers</p>
                                        </div>
                                        <?php if(!empty($ListOfThisDevice)){ ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
                                        <?php echo $ListOfThisDevice[0] ?></span><br>
                                         Last registered thermometer
                                        </p>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0">
                                        <span class="mr-1" style="color: #FFFFFF;">
                                        <?php echo "--/--/--"; ?>
                                        </span><br>
                                        Last registered thermometer
                                        </p>
                                        <?php } ?>
                                    </div>
                              </div>
                              </div>
                            </div> <!-- end col-->
                            <div class="col-md-4 col-xl-4 InfosCards">
                              <div class="card">
                              <div class="card-body" style="background-color: #ff26be;padding: 5px">
                                   <div class="card-body" style="background-color: #2e001f;">
                                        <div class="float-right mt-2">
                             <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Lab_Devices_Icons.png" 
                              alt="schools" width="50px">     
                                        </div>
                                        <div>
               <?php 
               $allDevices = 0;
               $ListOfThisDevice;                              
               $All_added_Devices_lab = $this->db->query("SELECT * FROM `l2_devices`
               WHERE `Added_By` = $idd AND `Comments` = 'Lab' AND `UserType` = 'school' ")->result_array(); 
               foreach($All_added_Devices_lab as $DevCr ){
                    $allDevices++;
                    $ListOfThisDevicelab[] = $DevCr["Created"];
               }
               ?>
                         <h4 class="mb-1 mt-1">
                         <span data-plugin="counterup"><?php echo $allDevices ?></span>
                         </h4>
                         <p class="mb-0">Total of Labs</p>
                                        </div>
                                        <?php if(!empty($ListOfThisDevicelab)){ ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
                                        <?php echo $ListOfThisDevicelab[0] ?></span><br>
                                         Last Added Lab
                                        </p>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0">
                                        <span class="mr-1" style="color: #FFFFFF;">
                                        <?php echo "--/--/--"; ?>
                                        </span><br>
                                        Last Added Lab
                                        </p>
                                        <?php } ?>
                                    </div>
                              </div>
                              </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
<div class="row">
<div class="col-xl-8">
                                <div class="custom-accordion">
                                    <div class="card">
                                        <a href="#checkout-billinginfo-collapse" class="text-dark" data-toggle="collapse">
                                            <div class="p-4">
                                                
                                                <div class="media align-items-center">
                                                    <div class="mr-3">
                                                        <i class="uil uil-receipt text-primary h2"></i>
                                                    </div>
                                                    <div class="media-body overflow-hidden">
                                                        <h5 class="font-size-16 mb-1">Add Device</h5>
                                                        <p class="text-muted text-truncate mb-0"></p>
                                                        <h3 id="Statusbox"></h3>
                                                    </div>
                                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                                </div>
                                                
                                            </div>
                                        </a>
                                   <form id="AddDevice">
                                   <div id="checkout-billinginfo-collapse" class="collapse show">
                                            <div class="p-4 border-top">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="billing-name">Device Id</label>
                                                                    <input type="text" class="form-control" placeholder="Device ID" name="Device_Id">
                                                                </div>
                                                                 <span>
                                                                 <strong>Note:</strong> <br>
                                                                 Devices ID Global and unique like MAC Address
                                                                 </span>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name">Type : </label>
                                                                    <!--<input type="text" class="form-control" placeholder="Comments" name="Comments">-->
                                                                     <select name="Comments" class="form-control custom-select">
                                                                          <option value="Lab">Lab</option>
                                                                          <option value="Thermometer">Thermometer</option>
                                                                          <option value="Gateway">Gateway</option>
                                                                     </select>
                                                                </div>
                                                            </div>
                                                        </div>
														
                                                        <div class="row" style="padding-top: 10px;">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name"> Site : </label>
																<?php 
																$r_sites = $this->db->query(" SELECT * FROM `r_sites` ")->result_array();
																?>
                                                                     <select name="Site" class="form-control custom-select">
																		 <?php foreach($r_sites as $site){ ?>
                                                                          <option value="<?php echo $site["Site_Name"] ?>">
																			  <?php echo $site["Site_Name"] ?>
																		  </option>
																		 <?php } ?>
                                                                     </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name"> Description : </label>
                                                                    <input type="text" class="form-control" placeholder="Description" name="Description">
                                                                </div>
                                                            </div>
                                                        </div>
														
                                                    </div>
                                            </div>
                                        
                              <div class="row" style="padding: 10px;">
                                    <div class="col">
                                        <a href="<?php echo base_url(); ?>EN/schools/" class="btn btn-link text-muted">
                                            <i class="uil uil-arrow-left mr-1"></i> Cancel </a>
                                    </div> <!-- end col -->
                                    <div class="col">
                                        <div class="text-sm-right mt-2 mt-sm-0">
                                            <button type="reset" class="btn">
                                                <i class="uil uil-reload mr-1"></i> reset 
                                             </button>
                                            <button type="Submit" class="btn btn-success">
                                                <i class="uil uil-save mr-1"></i> Procced 
                                             </button>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                              
                              </div>
                                   </form>
                                    </div>

                               <?php /*  <div class="card">
                                        <a href="#checkout-shippinginfo-collapse" class="collapsed text-dark" data-toggle="collapse">
                                            <div class="p-4">
                                                
                                                <div class="media align-items-center">
                                                    <div class="mr-3">
                                                        <i class="uil uil-circuit text-primary h2"></i>
                                                    </div>
                                                    <div class="media-body overflow-hidden">
                                                        <h5 class="font-size-16 mb-1"> Add Batch </h5>
                                                    </div>
                                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                                </div>
                                                
                                            </div>
                                        </a>
                                        <form id="AddBatch">
                                        <div id="checkout-shippinginfo-collapse" class="collapse">
                                            <div class="p-4 border-top">
                                        <?php 
                                        $list = $this->db->query("SELECT * FROM l2_devices 
          WHERE Added_By = '".$sessiondata['admin_id']."' AND `UserType` = 'school' ")->result_array();
                                        ?>

                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                        <label class="control-label">Select Device</label>
                                                        <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="ForDevice">
                                                            <?php foreach($list as $device){ ?> 
                                                            <option value="<?php echo $device['Id']; ?>">
                                                                 <?php echo $device['D_Id']; ?>
                                                             </option>
                                                             <?php  } ?>
                                                       </select>
                                                             </div>
                                                            </div>
                                                          
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name">Batch</label>
                                                                    <input type="text" class="form-control" placeholder="Batch Number" name="Batch">
                                                                </div>
                                                            </div>

                                                        <?php  $Tests = $this->db->query("SELECT * FROM r_testcode ")->result_array();  ?>
                                                        <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                        <label class="control-label">Select Test</label>
                                                        <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="DeviceType">
                                                            <?php foreach($Tests as $Test){ ?> 
                                                            <option value="<?php echo $Test['Test_Desc']; ?>">
                                                                 <?php echo $Test['Test_Desc']; ?>
                                                             </option>
                                                             <?php  } ?>
                                                       </select>
                                                             </div>
                                                            </div>

                                                        </div>
                                                 
                              <div class="row" style="padding: 10px;">
                                    <div class="col">
                                        <a href="<?php echo base_url(); ?>EN/schools/" class="btn btn-link text-muted">
                                            <i class="uil uil-arrow-left mr-1"></i> Cancel </a>
                                    </div> <!-- end col -->
                                    <div class="col">
                                        <div class="text-sm-right mt-2 mt-sm-0">
                                            <button type="reset" class="btn">
                                                <i class="uil uil-reload mr-1"></i> reset 
                                             </button>
                                            <button type="Submit" class="btn btn-success">
                                                <i class="uil uil-save mr-1"></i> Procced 
                                             </button>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>  */  ?>                         
                                </div>

                                <div class="row my-4">
                                    <div class="col">
               <a href="<?php echo base_url(); ?>EN/schools/" class="btn btn-link text-muted">
               <i class="uil uil-arrow-left mr-1"></i> Back  
               </a>
                                    </div> <!-- end col --> 
                                </div> <!-- end row-->
                            </div>
<div class="col-xl-4">
<div class="card">
<div class="card-body">
		<div class="p-3 bg-light mb-4">
     <?php 
          $alldev = $this->db->query("SELECT * FROM l2_devices 
          WHERE Added_By = '".$sessiondata['admin_id']."' AND `UserType` = 'school' ")->result_array();
          $alldev_lab = $this->db->query("SELECT * FROM l2_devices 
          WHERE Added_By = '".$sessiondata['admin_id']."' AND `UserType` = 'school' AND `Comments` = 'Lab' ")->result_array();
			
          $alldev_Thermometer = $this->db->query("SELECT * FROM l2_devices 
          WHERE Added_By = '".$sessiondata['admin_id']."' AND `UserType` = 'school' AND `Comments` = 'Thermometer' ")->result_array();
			
          $alldev_Gateway = $this->db->query("SELECT * FROM l2_devices 
          WHERE Added_By = '".$sessiondata['admin_id']."' AND `UserType` = 'school' AND `Comments` = 'Gateway' ")->result_array();
			
			?>     
			<h5 class="font-size-16 mb-0">List Of Devices
			  <span class="float-right ml-2">
			    <a href="<?php echo base_url(); ?>EN/schools/ListofDevices">
			      <?php echo sizeof($alldev); ?>
			     </a>
		      </span>
			</h5>
       </div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-selected="true">
				<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
				<span class="d-none d-sm-block">Lab</span> 
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#profile1" role="tab" aria-selected="false">
				<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
				<span class="d-none d-sm-block">Thermometer</span> 
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#messages1" role="tab" aria-selected="false">
				<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
				<span class="d-none d-sm-block">Gateway</span>   
			</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content p-3 text-muted">
		<div class="tab-pane active" id="home1" role="tabpanel">
		 <?php foreach($alldev_lab as $device): ?>     
			 <div class="btn-group mt-2 mr-1" style="width: 100%;">
				<button type="button" class="btn btn-secondary waves-effect waves-light">
				   <?php echo $device['D_Id']; ?>
				</button>
			</div> 
         <?php endforeach; ?>  		
		</div>
		<div class="tab-pane" id="profile1" role="tabpanel">
		 <?php foreach($alldev_Thermometer as $device): ?>     
			 <div class="btn-group mt-2 mr-1" style="width: 100%;">
				<button type="button" class="btn btn-secondary waves-effect waves-light">
				   <?php echo $device['D_Id']; ?>
				</button>
			</div> 
         <?php endforeach; ?>  		
		</div>
		<div class="tab-pane" id="messages1" role="tabpanel">
		 <?php foreach($alldev_Gateway as $device): ?>     
			 <div class="btn-group mt-2 mr-1" style="width: 100%;">
				<button type="button" class="btn btn-secondary waves-effect waves-light">
				   <?php echo $device['D_Id']; ?>
				</button>
			</div> 
         <?php endforeach; ?>  		
		</div>
	</div>

</div>
</div>
                            </div>
</div>          
          </div>
     </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script>

<script>
$("#AddDevice").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/schools/startAddDevice',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#Statusbox').html(data);

          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});     
     
$("#AddBatch").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/schools/startAddBatch',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#Statusbox').html(data);

          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});    
     
</script>
</html>