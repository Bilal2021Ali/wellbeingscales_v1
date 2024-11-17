<!doctype html>
<html lang="en">
   
<body class="light menu_light logo-white theme-white">
               <!---->
<style>
     .InfosCards h4,.InfosCards p{
          color: #fff;
     } 
     .InfosCards .card-body{
          border-radius: 5px;
     }
</style>
<div class="main-content">
                <div class="page-content">
						<h4 class="card-title" style="background: #800080; padding: 10px;color: #ffffff;border-radius: 4px;">SU 001: Super Admin Dashboard</h4>
		<h4 class="card-title" style="background: #008C76FF; padding: 10px;color: #ffffff;border-radius: 4px;">
		0001: Ministry of Education and Companies Counter System<br> 
		</h4>
                    <div class="container-fluid">
                        <!-- start page title -->

                        <!-- end page title -->

                        <div class="row">
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #93385FFF;">
                                        <div class="float-right mt-2">
                         				<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/team.png" 
										alt="schools" width="50px">  
										</div>
                                        <div>
                                             <?php 
                                             $all = $this->db->query("SELECT * FROM `l0_organization` ")->num_rows(); 
                                             $lasts = $this->db->query("SELECT * FROM `l0_organization` ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             
                                             ?>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                            <p class="mb-0">Total Organizations</p>
                                        </div>
										<?php if(!empty($lasts)){ ?>
                                        <?php foreach($lasts as $last){ ?>                                        
										<p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Registered Organization
                                        <?php } ?></p>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0">
											<span class="mr-1" style="color: #e1da6a;">
												--/--/--
											</span><br>
                                            Last Registered Organization
										</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #9F6B99FF;">
                                        <div class="float-right mt-2">
                         				<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/ministry_counter.png" 
										alt="schools" width="50px">  
										</div>
                                        <div>
                                             <?php 
                                             $all_ministry = $this->db->query("SELECT * FROM `l0_organization`
                                             WHERE VX = '1' ")->num_rows(); 
                                             $lastminED = $this->db->query("SELECT * FROM `l0_organization` WHERE VX = '1' ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             
                                             ?>
                                            <h4 class="mb-1 mt-1">
                                                 <span data-plugin="counterup"><?php echo $all_ministry ?></span>
                                             </h4>
                                            <p class="mb-0">Ministry of Education</p>
                                        </div>
										<?php if(!empty($lastminED)){ ?>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($lastminED as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Ministry of Education
                                        <?php } ?>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0">
										<span class="mr-1" style="color: #e1da6a;">
											--/--/--
										</span><br>
                                         Last Ministry of Education 
										</p>
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #4F3466FF;">
                                        <div class="float-right mt-2">
                         				<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/minidtry_counter_super_admin.png" 
										alt="schools" width="50px"></div>
                                        <div>
                                             <?php 
                                             $all_ministry = $this->db->query("SELECT * FROM `l0_organization`
                                             WHERE VX = '2' ")->num_rows(); 
                                             $lastminED = $this->db->query("SELECT * FROM `l0_organization` WHERE VX = '2'
											 ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             ?>
                                             <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?php echo $all_ministry ?></span></h4>
                                             <p class="mb-0">Ministry</p></div>
                                        	 <?php if(!empty($lastminED)){ ?>
											 
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($lastminED as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Registered Ministry                                      
										</p>
                                        <?php } ?>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0">
										<span class="mr-1" style="color: #e1da6a;">
											--/--/--
										</span><br>
                                         Last Registered Ministry                                      
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-6 col-xl-3 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #301728FF;">
                                        <div class="float-right mt-2">
                         				<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/company_counter.png" 
										alt="schools" width="50px">  
                                        </div>
                                        <div>
                                             <?php 
                                             $all_ministry = $this->db->query("SELECT * FROM `l0_organization`
                                             WHERE VX = '3' ")->num_rows(); 
                                             $lastminED = $this->db->query("SELECT * FROM `l0_organization` WHERE VX = '3' 
											 ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             ?>
                                            <h4 class="mb-1 mt-1">
                                                 <span data-plugin="counterup"><?php echo $all_ministry ?></span>
                                             </h4>
                                            <p class="mb-0">Company</p></p>
                                        </div>
										<?php if(!empty($lastminED)){ ?>
										<p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($lastminED as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Registered Company 
                                        <?php } ?>
                                        <?php }else{ ?>
                                        <p class="mt-3 mb-0">
										<span class="mr-1" style="color: #e1da6a;">
											--/--/--
										</span><br>
                                         Last Registered Company
										</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> <!-- end col-->
							
                        </div> <!-- end row-->
								<h4 class="card-title" style="background: #008C76FF; padding: 10px;color: #ffffff;border-radius: 4px;">
		0002: Ministry of Education and Companies Temperature Counter System <br>
		</h4>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-right">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span class="font-weight-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ml-1"></i></span>
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                    <a class="dropdown-item" href="#">Monthly</a>
                                                    <a class="dropdown-item" href="#">Yearly</a>
                                                    <a class="dropdown-item" href="#">Weekly</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-4">Temperature Monitor</h4>
                                                 
<?php
$today = date("Y-m-d");
$schoolsList = $this->db->query("SELECT * FROM `l1_school` ORDER BY `Created` DESC")->result_array();
$studentsCount = array();
$allresuls = 0;                                         
foreach($schoolsList as $school){
     $resul_count = 0;
     $count = $this->db->query("SELECT * FROM l2_student WHERE Added_By = '".$school['Id']."' ")->num_rows();
     $StudentForThisSchool = $this->db->query("SELECT * FROM l2_student
     WHERE Added_By = '".$school['Id']."' ")->result_array();
     foreach($StudentForThisSchool as $_student){
     $stud_id = $_student['Id'];
     $Issetresult = $this->db->query("SELECT * FROM `l2_result` 
     WHERE `UserId` = '".$stud_id."' AND `Created` = '".$today."' LIMIT 1 ")->result_array();
     foreach($Issetresult as $result){
          $resul_count++;
          $allresuls++;
     }     
     }// end foreach for students result
     if($count > 0){
     $studentsCount[] = array("SchoolId" => $school['Id'] ,"name" => $school['Username'] , 
                              "Count" => $count , "Results" => $resul_count );
     }
   //print_r($studentsCount);
} // end foreach from schools    
    
?>
                                        <div class="mt-1">
                                            <ul class="list-inline main-chart mb-0">
                                                 <?php 
                                                 $schoolscounter = $this->db->query("SELECT * FROM `l1_school`
												 ORDER BY `Created` DESC")->num_rows();                                          
												 $studentsCounter = $this->db->query("SELECT * FROM `l2_student`")->num_rows();
 ?>
                                                <li class="list-inline-item chart-border-left mr-0 border-0">
                                                    <h3 class="text-primary"><span data-plugin="counterup">
                                                  <?php echo $schoolscounter ?></span><span class="text-muted d-inline-block font-size-15 ml-3"> Number of Schools </span></h3>
                                                </li>
                                                <li class="list-inline-item chart-border-left mr-0 border-0">
                                                <h3 class="text-primary"><span data-plugin="counterup">
                                                  <?php echo $studentsCounter ?></span><span class="text-muted d-inline-block font-size-15 ml-3"> Number of Students </span></h3>
                                                </li>
                                                <li class="list-inline-item chart-border-left mr-0 border-0">
                                                <h3 class="text-primary"><span data-plugin="counterup">
                                                  <?php echo $allresuls ?></span><span class="text-muted d-inline-block font-size-15 ml-3"> Number Tested  Students </span></h3>
                                                </li>

                                                <li class="list-inline-item chart-border-left mr-0">
													<?php /*if(!empty($allresuls) && !empty($studentsCounter)){ ?>
                                                    <h3>
              											 <span data-plugin=""><?php $pers = $allresuls/$studentsCounter;
                                                         //echo $allresuls;
                                                         echo number_format((float)$pers, 2, '.', '');
                                                         ?></span>%<span class="text-muted d-inline-block font-size-15 ml-3">Conversation Ratio</span>
													</h3>
													<?php }*/ ?>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-3">
                                            <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div> <!-- end row-->

<?php /*?>                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-right">
                                            <div class="dropdown">
                                                <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted">All Members<i class="mdi mdi-chevron-down ml-1"></i></span>
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <a class="dropdown-item" href="#">Locations</a>
                                                    <a class="dropdown-item" href="#">Revenue</a>
                                                    <a class="dropdown-item" href="#">Join Date</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-4">Top Users</h4>

                                        <div data-simplebar style="max-height: 336px;">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-centered table-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 20px;"><img src="assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Glenn Holden</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Nevada</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-danger font-size-12">Cancel</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$250.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="assets/images/users/avatar-5.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Lolita Hamill</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Texas</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-success font-size-12">Success</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$110.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="assets/images/users/avatar-6.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Robert Mercer</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-info font-size-12">Active</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$420.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="assets/images/users/avatar-7.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Marie Kim</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Montana</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-warning font-size-12">Pending</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="assets/images/users/avatar-8.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Sonya Henshaw</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Colorado</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-info font-size-12">Active</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="assets/images/users/avatar-2.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Marie Kim</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Australia</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-success font-size-12">Success</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="assets/images/users/avatar-1.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                            <td>
                                                                <h6 class="font-size-15 mb-1 font-weight-normal">Sonya Henshaw</h6>
                                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> India</p>
                                                            </td>
                                                            <td><span class="badge badge-soft-danger font-size-12">Cancel</span></td>
                                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> <!-- enbd table-responsive-->
                                        </div> <!-- data-sidebar-->
                                    </div><!-- end card-body-->
                                </div> <!-- end card-->
                            </div><!-- end col -->

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-right">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" id="dropdownMenuButton3"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted">Recent<i class="mdi mdi-chevron-down ml-1"></i></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton3">
                                                    <a class="dropdown-item" href="#">Recent</a>
                                                    <a class="dropdown-item" href="#">By Users</a>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title mb-4">Recent Activity</h4>

                                        <ol class="activity-feed mb-0 pl-2" data-simplebar style="max-height: 336px;">
                                            <li class="feed-item">
                                                <div class="feed-item-list">
                                                    <p class="text-muted mb-1 font-size-13">Today<small class="d-inline-block ml-1">12:20 pm</small></p>
                                                    <p class="mt-0 mb-0">Andrei Coman magna sed porta finibus, risus
                                                        posted a new article: <span class="text-primary">Forget UX
                                                            Rowland</span></p>
                                                </div>
                                            </li>
                                            <li class="feed-item">
                                                <p class="text-muted mb-1 font-size-13">22 Jul, 2020 <small class="d-inline-block ml-1">12:36 pm</small></p>
                                                <p class="mt-0 mb-0">Andrei Coman posted a new article: <span
                                                        class="text-primary">Designer Alex</span></p>
                                            </li>
                                            <li class="feed-item">
                                                <p class="text-muted mb-1 font-size-13">18 Jul, 2020 <small class="d-inline-block ml-1">07:56 am</small></p>
                                                <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                                    Commented <span class="text-primary"> Developer Moreno</span></p>
                                            </li>
                                            <li class="feed-item">
                                                <p class="text-muted mb-1 font-size-13">10 Jul, 2020 <small class="d-inline-block ml-1">08:42 pm</small></p>
                                                <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                                                        class="text-primary">UX Murphy</span></p>
                                            </li>

                                            <li class="feed-item">
                                                <p class="text-muted mb-1 font-size-13">23 Jun, 2020 <small class="d-inline-block ml-1">12:22 am</small></p>
                                                <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                                    Commented <span class="text-primary"> Developer Moreno</span></p>
                                            </li>
                                            <li class="feed-item pb-1">
                                                <p class="text-muted mb-1 font-size-13">20 Jun, 2020 <small class="d-inline-block ml-1">09:48 pm</small></p>
                                                <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                                                        class="text-primary">UX Murphy</span></p>
                                            </li>

                                        </ol>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="float-right">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" id="dropdownMenuButton4"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted">Monthly<i class="mdi mdi-chevron-down ml-1"></i></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton4">
                                                    <a class="dropdown-item" href="#">Yearly</a>
                                                    <a class="dropdown-item" href="#">Monthly</a>
                                                    <a class="dropdown-item" href="#">Weekly</a>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title">Social Source</h4>

                                        <div class="text-center">
                                            <div class="avatar-sm mx-auto mb-4">
                                                <span class="avatar-title rounded-circle bg-soft-primary font-size-24">
                                                        <i class="mdi mdi-facebook text-primary"></i>
                                                    </span>
                                            </div>
                                            <p class="font-16 text-muted mb-2"></p>
                                            <h5><a href="#" class="text-dark">Facebook - <span class="text-muted font-16">125 sales</span> </a></h5>
                                            <p class="text-muted">Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus tincidunt.</p>
                                            <a href="#" class="text-reset font-16">Learn more <i class="mdi mdi-chevron-right"></i></a>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-4">
                                                <div class="social-source text-center mt-3">
                                                    <div class="avatar-xs mx-auto mb-3">
                                                        <span class="avatar-title rounded-circle bg-primary font-size-16">
                                                                <i class="mdi mdi-facebook text-white"></i>
                                                            </span>
                                                    </div>
                                                    <h5 class="font-size-15">Facebook</h5>
                                                    <p class="text-muted mb-0">125 sales</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="social-source text-center mt-3">
                                                    <div class="avatar-xs mx-auto mb-3">
                                                        <span class="avatar-title rounded-circle bg-info font-size-16">
                                                                <i class="mdi mdi-twitter text-white"></i>
                                                            </span>
                                                    </div>
                                                    <h5 class="font-size-15">Twitter</h5>
                                                    <p class="text-muted mb-0">112 sales</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="social-source text-center mt-3">
                                                    <div class="avatar-xs mx-auto mb-3">
                                                        <span class="avatar-title rounded-circle bg-pink font-size-16">
                                                                <i class="mdi mdi-instagram text-white"></i>
                                                            </span>
                                                    </div>
                                                    <h5 class="font-size-15">Instagram</h5>
                                                    <p class="text-muted mb-0">104 sales</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 text-center">
                                            <a href="#" class="text-primary font-size-14 font-weight-medium">View All Sources <i class="mdi mdi-chevron-right"></i></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
<?php                         <!-- end row -->


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transaction</h4>
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Order ID</th>
                                                        <th>Billing Name</th>
                                                        <th>Date</th>
                                                        <th>Total</th>
                                                        <th>Payment Status</th>
                                                        <th>Payment Method</th>
                                                        <th>View Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                                <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#MB2540</a> </td>
                                                        <td>Neal Matthews</td>
                                                        <td>
                                                            07 Oct, 2019
                                                        </td>
                                                        <td>
                                                            $400
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                        </td>
                                                        <td>
                                                            <i class="fab fa-cc-mastercard mr-1"></i> Mastercard
                                                        </td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                                <label class="custom-control-label" for="customCheck3">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#MB2541</a> </td>
                                                        <td>Jamal Burnett</td>
                                                        <td>
                                                            07 Oct, 2019
                                                        </td>
                                                        <td>
                                                            $380
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-danger font-size-12">Chargeback</span>
                                                        </td>
                                                        <td>
                                                            <i class="fab fa-cc-visa mr-1"></i> Visa
                                                        </td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                                <label class="custom-control-label" for="customCheck4">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#MB2542</a> </td>
                                                        <td>Juan Mitchell</td>
                                                        <td>
                                                            06 Oct, 2019
                                                        </td>
                                                        <td>
                                                            $384
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                        </td>
                                                        <td>
                                                            <i class="fab fa-cc-paypal mr-1"></i> Paypal
                                                        </td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                                <label class="custom-control-label" for="customCheck5">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#MB2543</a> </td>
                                                        <td>Barry Dick</td>
                                                        <td>
                                                            05 Oct, 2019
                                                        </td>
                                                        <td>
                                                            $412
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                        </td>
                                                        <td>
                                                            <i class="fab fa-cc-mastercard mr-1"></i> Mastercard
                                                        </td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                                <label class="custom-control-label" for="customCheck6">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#MB2544</a> </td>
                                                        <td>Ronald Taylor</td>
                                                        <td>
                                                            04 Oct, 2019
                                                        </td>
                                                        <td>
                                                            $404
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-warning font-size-12">Refund</span>
                                                        </td>
                                                        <td>
                                                            <i class="fab fa-cc-visa mr-1"></i> Visa
                                                        </td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck7">
                                                                <label class="custom-control-label" for="customCheck7">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#MB2545</a> </td>
                                                        <td>Jacob Hunter</td>
                                                        <td>
                                                            04 Oct, 2019
                                                        </td>
                                                        <td>
                                                            $392
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                        </td>
                                                        <td>
                                                            <i class="fab fa-cc-paypal mr-1"></i> Paypal
                                                        </td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
*/ ?>
 			<h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 001: Protected by QlickHealth</h4>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

            </div>     
</body>
<!-- 
apexcharts 

sales-analytics-chart

-->
<script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script>

     
options = {
     chart: {
          height: 339,
          type: "line",
          stacked: !1,
          toolbar: {
               show: !1
          }
     },
     stroke: {
          width: [0, 2, 4],
          curve: "smooth"
     },
     plotOptions: {
          bar: {
               columnWidth: "30%"
          }
     },
     colors: ["#5b73e8", "#f1b44c"],
     series: [{
          name: "School",
          type: "column",
          data: [<?php foreach($studentsCount as $count){  echo $count['Count'].',';  } ?>]
         
     }, {
          name: "Total Tested  Students",
          type: "line",
          data: [<?php foreach($studentsCount as $countResult ){ echo $countResult['Results'].',';  } ?>]
     }],
     fill: {
          //opacity: [.85, .25, 1],
          gradient: {
               inverseColors: !1,
               shade: "light",
               type: "vertical",
               opacityFrom: .85,
               opacityTo: .55,
               stops: [0, 100, 100, 100]
          }
     },
     labels: [<?php foreach($studentsCount as $schoolName){ echo '"'.$schoolName['name'].'",'; } ?>],
     markers: {
          size: 0
     },
     yaxis: {
          title: {
               text: "Points"
          }
     },
     tooltip: {
          shared: !0,
          intersect: !1,
          y: {
               formatter: function (e) {
                    return void 0 !== e ? e.toFixed(0) : e
               }
          }
     },
     grid: {
          borderColor: "#f1f1f1"
     }, 
     labels: {
               show: !1,
               formatter: function (e) {
                    return e
               }
          },
};
(chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options)).render();     
     
     
var myoptions = {
          series: [{
               data: [25, 66, 41, 89, 63, 25, 44, 20, 36, 40, 54]
          }],
          fill: {
               colors: ["#FFF56B"]
          },
          chart: {
               type: "bar",
               width: 70,
               height: 40,
               sparkline: {
                    enabled: !0
               }
          },
          plotOptions: {
               bar: {
                    columnWidth: "50%"
               }
          },
          labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
          xaxis: {
               crosshairs: {
                    width: 1
               }
          },
          tooltip: {
               fixed: {
                    enabled: !1
               },
               x: {
                    show: !1
               },
               y: {
                    title: {
                         formatter: function (e) {
                              return ""
                         }
                    }
               },
               marker: {
                    show: !1
               }
          }
     }

chart1 = new ApexCharts(document.querySelector("#CharTTest1"), myoptions);
chart1.render();
var options = {
          fill: {
               colors: ["#34c38f"]
          },
          series: [70],
          chart: {
               type: "radialBar",
               width: 45,
               height: 45,
               sparkline: {
                    enabled: !0
               }
          },
          dataLabels: {
               enabled: !1
          },
          plotOptions: {
               radialBar: {
                    hollow: {
                         margin: 0,
                         size: "60%"
                    },
                    track: {
                         margin: 0
                    },
                    dataLabels: {
                         show: !1
                    }
               }
          }
     }       
                    
</script>
</html>