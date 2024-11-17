<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />     
	
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

*{
	font-family: 'Montserrat', sans-serif;
	list-style: none;
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

.title{
	background: #f3f4f8;
	padding: 15px;
	font-size: 18px;
	text-align: center;
	text-transform: uppercase;
	letter-spacing: 3px;
}
.file_upload_list li .file_item{
	display: flex;
	border-bottom: 1px solid #f3f4f8;
    padding: 15px 20px;
}
.file_item .format{
	background: #8178d3;	border-radius: 10px;
	width: 45px;
	height: 40px;
	line-height: 40px;
	color: #fff;
	text-align: center;
	font-size: 12px;
	margin-right: 15px;
}

.file_item .file_progress{
	width: calc(100% - 60px);
	font-size: 14px;
}

.file_item .file_info,
.file_item .file_size_wrap{
	display: flex;
	align-items: center;
}
.file_item .file_info{
	justify-content: space-between;
}
.file_item .file_progress .progress{
	width: 100%;
	height: 4px;
	background: #efefef;
	overflow: hidden;
	border-radius: 5px;
	margin-top: 8px;
	position: relative;
}

.file_item .file_progress .progress .inner_progress{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: #58e380;
}
.file_item .file_size_wrap .file_size{
	margin-right: 15px;
}
.file_item .file_size_wrap .file_close{
	border: 1px solid #8178d3;
	color: #8178d3;
	width: 20px;
	height: 20px;
	line-height: 18px;
	text-align: center;
	border-radius: 50%;
	font-size: 10px;
	font-weight: bold;
	cursor: pointer;
}

.file_item .file_size_wrap .file_close:hover{
	background: #8178d3;
	color: #fff;
}

.choose_file label{
	display: block;
	border: 2px dashed #8178d3;
	padding: 15px;
	width: calc(100% - 20px);
	margin: 10px;
	text-align: center;
	cursor: pointer;
}
.choose_file #choose_file{
	outline: none;
	opacity: 0;
    width: 0;
}
.choose_file span{
	font-size: 14px;
	color: #8178d3;
}

.choose_file label:hover span{
	text-decoration: underline;
}	
	
</style>
<style>
	.file_upload_list{
		text-align: center;
	}
	.card{
		border: 0px;
	}
	
	.progress {
		margin-top: 10px;
	}
	
</style>	
<body>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid"> 
				<div class="row">
					<div class="col-xl-6">
													<div class="card">
														<div class="card-body">

															<h4 class="card-title">a few steps :</h4>
															<p class="card-title-desc"> Read the steps below. </p>


															<div id="accordion" class="custom-accordion">
																<div class="card mb-1 shadow-none">
																	<a href="#collapseOne" class="text-dark collapsed" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
																		<div class="card-header" id="headingOne">
																			<h6 class="m-0">
																				For Staff
																				<i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
																			</h6>
																		</div>
																	</a>

																	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="">
																		<div class="card-body">
														    1 - download the template from
															<a href="<?php echo base_url(); ?>uploads/Csv/staff_template.xlsx" onClick="DownloadStart();">here</a> 
															<br>
															2 - Edit the file with your data
															<br>
															3 - save the file as "CSV" file 
															<br>
															4 - import the "CSV" file in the page and wait it to end the export !
															<br>
															<strong>Notes :</strong> 
															<br>if you have Duplicated entry Dont worry we delete the Duplicate.
																		</div>
																	</div>
																</div>
																<div class="card mb-1 shadow-none">
																	<a href="#collapseTwo" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
																		<div class="card-header" id="headingTwo">
																			<h6 class="m-0">
																				For Teacher
																				<i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
																			</h6>
																		</div>
																	</a>
																	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="">
																		<div class="card-body">
														    1 - download the template from
															<a href="<?php echo base_url(); ?>uploads/Csv/teacher_template.xlsx" onClick="DownloadStart();">here</a> 
															<br>
															2 - Edit the file with your data
															<br>
															3 - save the file as "CSV" file 
															<br>
															4 - import the "CSV" file in the page and wait it to end the export !
															<br>
															<strong>Notes :</strong> 
															<br>if you have Duplicated entry Dont worry we delete the Duplicate.
																		</div>
																	</div>
																</div>
																<div class="card mb-0 shadow-none">
																	<a href="#collapseThree" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
																		<div class="card-header" id="headingThree">
																			<h6 class="m-0">
																				For Students
																				<i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
																			</h6>
																		</div>
																	</a>
																	<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
																		<div class="card-body">
														    1 - download the template from
															<a href="<?php echo base_url(); ?>uploads/Csv/student_template.xlsx" onClick="DownloadStart();">here</a> 
															<br>
															2 - Edit the file with your data
															<br>
															3 - save the file as "CSV" file 
															<br>
															4 - import the "CSV" file in the page and wait it to end the export !
															<br>
															<strong>Notes :</strong> 
															<br>if you have Duplicated entry Dont worry we delete the Duplicate.
																		</div>
																	</div>
																</div>
															</div>

														</div>
													</div>
												</div>     			
					<div class="col-xl-6">
													<div class="card">
														<div class="card-body">

															<h4 class="card-title"> Upload The Csv </h4>
															<!-- Nav tabs -->
															<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
																<li class="nav-item">
																	<a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
																		<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
																		<span class="d-none d-sm-block">Staff</span> 
																	</a>
																</li>
																<li class="nav-item">
																	<a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
																		<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
																		<span class="d-none d-sm-block">Teacher</span> 
																	</a>
																</li>
																<li class="nav-item">
																	<a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
																		<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
																		<span class="d-none d-sm-block">Students</span>   
																	</a>
																</li>
															</ul>

															<!-- Tab panes -->
															<div class="tab-content p-3 text-muted">
																<div class="tab-pane active" id="home1" role="tabpanel">
																	<div class="wrapper staffUpload">
																		<div class="file_upload_list">
																			<i class="display-4 text-muted uil uil-cloud-upload"></i>
																			<h3 class="StatusBoxStaff"> Please Select a "Csv" File .. </h3>
																			<div id="exportinSatff"></div>
																			<div class="progress mb-4">
																			<div class="progress-bar Staffprogress" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>
																		</div>
																		<form id="Staff" name="Staff" onSubmit="Validation();" >
																		<div class="choose_file">
																			<label for="choose_file">
																				<input type="file" id="choose_file" name="csvFileStaff"  >
																				<span>Choose Files</span>
																			</label>
																		</div>
																			<button type="Submit" 
																			class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 
																			StatusbtnStaff">
																				Start Upload !
																			</button>
																		</form>	
																	</div>
																</div>
																<div class="tab-pane" id="profile1" role="tabpanel">
																	<div class="wrapper TeacherUpload">
																		<div class="file_upload_list">
																			<i class="display-4 text-muted uil uil-cloud-upload"></i>
																			<h3 class="StatusBoxTeacher">
																				Please Select a "Csv" File .. </h3>
																			<div id="exportinTeacher"></div>
																			<div class="progress mb-4">
																			<div class="progress-bar Teacherprogress" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>
																		</div>
																		<form id="Teacher" name="Teacher" onSubmit="Validation();" >
																		<div class="choose_file">
																			<label for="choose_file">
																				<input type="file" id="choose_file" name="csvFileTeacher"  >
																				<span>Choose Files</span>
																			</label>
																		</div>
																			<button type="Submit" 
																			class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 
																			StatusbtnTeacher">
																				Start Upload !
																			</button>
																		</form>	
																	</div>
																</div>
																<div class="tab-pane" id="messages1" role="tabpanel">
																	<div class="wrapper StudentUpload">
																		<div class="file_upload_list">
																			<i class="display-4 text-muted uil uil-cloud-upload"></i>
																			<h3 class="StatusBoxStudent">
																				Please Select a "Csv" File .. </h3>
																			<div id="exportinStudent"></div>
																			<div class="progress mb-4">
																			<div class="progress-bar Studentprogress" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>
																		</div>
																		<form id="Student" name="Student" onSubmit="Validation();" >
																		<div class="choose_file">
																			<label for="choose_file">
																				<input type="file" id="choose_file" name="csvFileStudent"  >
																				<span>Choose Files</span>
																			</label>
																		</div>
																			<button type="Submit" 
																			class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 
																			StatusbtnStudent">
																				Start Upload !
																			</button>
																		</form>	
																	</div>
																</div>
															</div>

														</div>
													</div>
												</div>	
				</div>
     </div>
    <!-- container-fluid --> 
  </div>
  <!-- End Page-content --> 
  
</div>
	</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <!-- Required datatable js -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>	
<script>
var csvFile = document.forms['Staff']['csvFileStaff'];	
function Validation(){
	if(csvFile != ""){
	   
	}else{
     Swal.fire(
     'error',
     ' Sorry. No File Uploaded ',
     'error'
     )
	}
}
	
function DownloadStart(){
     Swal.fire(
     'Success',
     ' The Download Started ',
     'info'
     )
}	
	

$( "#Staff" ).on( 'submit', function ( e ) {
   e.preventDefault();
   $.ajax( {
		type: 'POST',
		url: '<?php echo base_url(); ?>EN/Ajax/uploadStaffCsv',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		success: function ( data ) {
			 $( '.StatusBoxStaff' ).html( data );
			 $( '.StatusbtnStaff' ).removeAttr('disabled');
			 $( '.StatusbtnStaff' ).html('Submit !');
		},
		beforeSend : function(){
			 $( '.StatusbtnStaff' ).attr('disabled','');
			 $( '.StatusbtnStaff' ).html('Please wait.');
			 $( '.StatusBoxStaff' ).html('Please wait.');
		},
		ajaxError: function () {
			 $( '.alert.alert-info' ).css( 'background-color', '#DB0404' );
			 $( '.alert.alert-info' ).html( "Ooops! Error was found." );
		}
   } );
} );
$( "#Teacher" ).on( 'submit', function ( e ) {
   e.preventDefault();
   $.ajax( {
		type: 'POST',
		url: '<?php echo base_url(); ?>EN/Ajax/uploadTeacherCsv',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		success: function ( data ) {
			 $( '.StatusBoxTeacher' ).html( data );
			 $( '.StatusbtnTeacher' ).removeAttr('disabled');
			 $( '.StatusbtnTeacher' ).html('Submit !');
		},
		beforeSend : function(){
			 $( '.StatusbtnTeacher' ).attr('disabled','');
			 $( '.StatusbtnTeacher' ).html('Please wait.');
			 $( '.StatusBoxTeacher' ).html('Please wait.');
		},
		ajaxError: function () {
			 $( '.StatusBoxTeacher' ).css( 'background-color', '#DB0404' );
			 $( '.StatusBoxTeacher' ).html( "Ooops! Error was found." );
		}
   } );
} );
$( "#Student" ).on( 'submit', function ( e ) {
   e.preventDefault();
   $.ajax( {
		type: 'POST',
		url: '<?php echo base_url(); ?>EN/Ajax/uploadStudentCsv',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		success: function ( data ) {
			 $( '.StatusBoxStudent' ).html( data );
			 $( '.StatusbtnStudent' ).removeAttr('disabled');
			 $( '.StatusbtnStudent' ).html('Submit !');
		},
		beforeSend : function(){
			 $( '.StatusbtnStudent' ).attr('disabled','');
			 $( '.StatusbtnStudent' ).html('Please wait.');
			 $( '.StatusBoxStudent' ).html('Please wait.');
		},
		ajaxError: function () {
			 $( '.StatusBoxStudent' ).css( 'background-color', '#DB0404' );
			 $( '.StatusBoxStudent' ).html( "Ooops! Error was found." );
		}
   } );
} );
	
</script>	
</html>