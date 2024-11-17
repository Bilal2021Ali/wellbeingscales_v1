<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" 
	    rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" 
	    rel="stylesheet" type="text/css" />

		<!-- 
		Responsive datatable examples
		id="datatables_buttons_info"
		-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" 
	    rel="stylesheet" type="text/css" />     
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
   .badge{
		text-align: center;
   }
  .Td-Results{
	  color: #FFFFFF;
  }
	
/*
Theme Name: jqueryui-com
Template: jquery
*/

a,
.title {
	color: #b24926;
}

#content a:hover {
	color: #333;
}

#banner-secondary p.intro {
	padding: 0;
	float: left;
	width: 50%;
}

#banner-secondary .download-box {
	border: 1px solid #aaa;
	background: #333;
	background: -webkit-linear-gradient(left, #333 0%, #444 100%);
	background: linear-gradient(to right, #333 0%, #444 100%);
	float: right;
	width: 40%;
	text-align: center;
	font-size: 20px;
	padding: 10px;
	border-radius: 5px;
	box-shadow: 0 0 8px rgba(0, 0, 0, 0.8);
}

#banner-secondary .download-box h2 {
	color: #71d1ff;
	font-size: 26px;
}

#banner-secondary .download-box .button {
	float: none;
	display: block;
	margin-top: 15px;
}

#banner-secondary .download-box p {
	margin: 15px 0 5px;
}

#banner-secondary .download-option {
	width: 45%;
	float: left;
	font-size: 16px;
}

#banner-secondary .download-legacy {
	float: right;
}

#banner-secondary .download-option span {
	display: block;
	font-size: 14px;
	color: #71d1ff;
}

#content .dev-links {
	float: right;
	width: 30%;
	margin: -15px -25px .5em 1em;
	padding: 1em;
	border: 1px solid #666;
	border-width: 0 0 1px 1px;
	border-radius: 0 0 0 5px;
	box-shadow: -2px 2px 10px -2px #666;
}

#content .dev-links ul {
	margin: 0;
}

#content .dev-links li {
	padding: 0;
	margin: .25em 0 .25em 1em;
	background-image: none;
}

.demo-list {
	float: right;
	width: 25%;
}

.demo-list h2 {
	font-weight: normal;
	margin-bottom: 0;
}

#content .demo-list ul {
	width: 100%;
	border-top: 1px solid #ccc;
	margin: 0;
}

#content .demo-list li {
	border-bottom: 1px solid #ccc;
	margin: 0;
	padding: 0;
	background: #eee;
}

#content .demo-list .active {
	background: #fff;
}

#content .demo-list a {
	text-decoration: none;
	display: block;
	font-weight: bold;
	font-size: 13px;
	color: #3f3f3f;
	text-shadow: 1px 1px #fff;
	padding: 2% 4%;
}

.demo-frame {
	width: 70%;
	height: 420px;
}

.view-source a {
	cursor: pointer;
}

.view-source > div {
	overflow: hidden;
	display: none;
}

@media all and (max-width: 600px) {
	#banner-secondary p.intro,
	#banner-secondary .download-box {
		float: none;
		width: auto;
	}

	#banner-secondary .download-box {
		overflow: auto;
	}
}

@media only screen and (max-width: 480px) {
	#content .dev-links {
		width: 55%;
		margin: -15px -29px .5em 1em;
		overflow: hidden;
	}
}	
	
</style>
	
<style>
	.ui-widget.ui-widget-content{
		max-height: 150px;
		overflow-y: auto;
		overflow-x: hidden;
	}		
</style>
		
  </head>
<?php
$staffs_of_this_school = $this->db->query("SELECT * FROM l2_staff WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();	
$teachers_of_this_school = $this->db->query("SELECT * FROM l2_teacher WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();	
$Stuents_of_this_school = $this->db->query("SELECT * FROM l2_student WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();
	
$today = date("Y-m-d");	
	
$ForStaff = $this->db->query("SELECT l2_staff.Id, l2_staff.F_name_EN, l2_staff.L_name_EN , 
l2_attendance_result.Result_first ,l2_attendance_result.Result_last , 
l2_attendance_result.Time_first , l2_attendance_result.Time_last , l2_attendance_result.Device_first , l2_attendance_result.Device_last 
FROM l2_staff
INNER JOIN l2_attendance_result
ON l2_staff.Id=l2_attendance_result.UserId AND l2_attendance_result.UserType = 'Staff'
AND l2_staff.Added_By = '".$sessiondata['admin_id']."' AND l2_attendance_result.Created = '".$today."' ;")->result_array();	
	
$ForTeacher = $this->db->query("SELECT l2_teacher.Id, l2_teacher.F_name_EN, l2_teacher.L_name_EN , 
l2_attendance_result.Result_first ,l2_attendance_result.Result_last , 
l2_attendance_result.Time_first , l2_attendance_result.Time_last , l2_attendance_result.Device_first , l2_attendance_result.Device_last 
FROM l2_teacher
INNER JOIN l2_attendance_result
ON l2_teacher.Id=l2_attendance_result.UserId AND l2_attendance_result.UserType = 'Teacher'
AND l2_teacher.Added_By = '".$sessiondata['admin_id']."' AND l2_attendance_result.Created = '".$today."' ;")->result_array();	
	
?>
	
    <body>
        <!-- Begin page -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

            <div class="page-content">
				<div class="container-fluid">
 <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Example</h4>
                                        <p class="card-title-desc"><?php print_r($just_test);	 ?></p>
        
                                        <div class="table-rep-plugin">
                                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                <table id="tech-companies-1" class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Company</th>
                                                        <th data-priority="1">Username</th>
                                                        <th data-priority="3">First Result</th>
                                                        <th data-priority="1">First Result Time</th>
                                                        <th data-priority="3">Last Result</th>
                                                        <th data-priority="3">Last Result Time</th>
                                                        <th data-priority="6">The Time</th>
                                                        <th data-priority="6">First Device</th>
                                                        <th data-priority="6">Last Device</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														<tr>
                                                        <th><span class="co-name">Google Inc.</span></th>
                                                        <td>597.74</td>
                                                        <td>12:12PM</td>
                                                        <td>14.81 (2.54%)</td>
                                                        <td>582.93</td>
                                                        <td>597.95</td>
                                                        <td>597.73 x 100</td>
                                                        <td>597.91 x 300</td>
                                                        <td>731.10</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
        
                                        </div>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->				</div>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>		
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/libs/admin-resources/rwd-table/rwd-table.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/table-responsive.init.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>


<?php 
function boxes_Colors($result){
	?>
	 <style>
		 .Td-Results_font span{
			 font-size: 20px !important;
			 padding: 6px;
		 }
		 .Td-Results .badge{
			 padding: 6px;
		 }
	 </style>
	
	 <td class="Td-Results_font">
	 	<?php if ($result >= 38.500 && $result <= 45.500 ) { ?> 
	<span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"><?= $result; ?></span>
	<!-- Hight --> 
	<?php } elseif ($result <= 36.200) { ?> 
	<span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"><?= $result; ?></span>
	<!-- Low -->
	<?php } elseif ($result >= 36.201 && $result <= 37.500) { ?> 
	<span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"><?= $result; ?></span>
	<!-- No Risk -->
	<?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
	<span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"><?= $result; ?></span>
	<!-- Moderate -->
	<?php } elseif ($result >= 45.501) { ?>
	<span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"><?= $result; ?></span>
    <!-- Error -->
	<?php } ?>
     </td>
	
	 <td class="Td-Results">
	 <?php if ($result >= 38.500 && $result <= 45.500 ) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">High</span>
    <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">Moderate</span>
    <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">No Risk</span>
    <?php } elseif ($result <= 36.200) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;">Low</span>
    <?php } elseif ($result >= 45.501) { ?>
    <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">Error</span>
    <?php } ?>
     </td>
	
	<?php
}	

?>
</html>
