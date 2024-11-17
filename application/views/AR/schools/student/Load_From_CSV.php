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
	
	h6 {
		padding: 5px;
	}
	
	.uploadtype {
		background: #F00004;
		color: #fff;
		padding: 10px;
		border-radius: 6px;
		text-align: center;
		margin-bottom: 10px;
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
															<h4 class="card-title">How to upload your data:</h4>
															<p class="card-title-desc"> Read the steps below.</p>
															<div id="accordion" class="custom-accordion">
																<div class="card mb-0 shadow-none">
																	<a href="#collapseThree" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
<div class="card-header" id="headingThree">
<h6 class="m-0">
<strong>For Students</strong><i class="mdi mdi-chevron-up float-right accor-down-icon"></i></h6></div></a>
<div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
<div class="card-body">
<h6 style="background-color:yellow"> <b>Students Steps</b></h6> 
1- Download the <a href="<?php echo base_url(); ?>uploads/Csv/student_template.xlsx" onClick="DownloadStart();">Students Excell Template</a> 
2- Please save the file to your hard drive.<br>
                                            3- Open the downloaded file and load it immediately using the specified program.<br>
                                            4- Fill your data inside the Excel Template following the sample data format.<br>
                                            5- Save the Excel Template as an "SCV" file after you have inserted the data.<br>
                                            6- Import the "CSV" file. <br>
                                            7- Upload your file. <br>
                                            <strong>Please wait until the upload is completed.</strong><br>
                                            <h6 style="background-color:yellow"> All <?= $userType ?> All teachers must include their National IDs. Note that you cannot modify or edit later.</h6> <br>
                                            <strong>Do not worry about duplicated data. We will remove the copied file based on the National ID data collected.</strong><br>
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

															<h4 class="card-title uploadtype"> Upload <strong>Students</strong> CSV File </h4>
															<!-- Tab panes -->
																	<div class="wrapper StudentUpload">
																		<div class="file_upload_list">
																			<i class="display-4 text-muted uil uil-cloud-upload"></i>
																			<h3 class="StatusBoxStudent">
																				 Please Select Students CSV File  </h3>
																			<div id="exportinStudent"></div>
																			<div class="progress mb-4">
																			<div class="progress-bar Studentprogress" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>
																		</div>
																		<form id="Student" name="Student" >
																		<div class="choose_file">
																			<label for="choose_file">
																				<input type="file" id="choose_file" 
																					   name="csvFileStudent" accept=".csv" >
																				<span>choose file</span>
																			</label>
																		</div>
																			<button type="Submit" 
																			class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 
																			StatusbtnStudent">
																				Start Uploading CSV file!
																			</button>
																		</form>	
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
$('#choose_file').change(function(){
	var val = $('#choose_file').val();
	if(val !== ""){
	$('#choose_file').attr('readonly','');
	$('.choose_file span').html('The File Choosed Click Submit !');
	}
});	

function DownloadStart(){
     Swal.fire(
     'Success',
     ' The Download Started ',
     'info'
     )
}	
	

$( "#Student" ).on( 'submit', function ( e ) {
   e.preventDefault();
   $.ajax( {
		type: 'POST',
		url: '<?php echo base_url(); ?>AR/Ajax/uploadStudentCsv',
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