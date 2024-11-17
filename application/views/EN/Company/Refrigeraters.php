<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />
</head>
<style>
	 
td,th{
	text-align: center;
}
	
.Td-Results_font span {
    font-size: 20px !important;
    padding: 6px;
}
.Td-Results .badge {
    padding: 6px;
    animation-iteration-count: infinite;
    animation-direction: alternate;
}
.error {
    -webkit-animation: bgColor_red 1s;
    /* Firefox */
    -moz-animation: bgColor_red 1s;
    /* Standard Syntax */
    animation: bgColor_red 1s;
}
@-webkit-keyframes bgColor_red {
from {
background: #ff2e00;
color: #E1E1E1;
}
to {
background: #FFFFFF;
color: #212121;
}
}
@-moz-keyframes bgColor_red {
from {
background: #ff2e00;
color: #E1E1E1;
}
to {
background: #FFFFFF;
color: #212121;
}
}
@keyframes bgColor_red {
from {
background: #ff2e00;
color: #E1E1E1;
}
to {
background: #FFFFFF;
color: #212121;
}
}
	
.Td-Results_font p{
	font-size: 10px;
	margin-bottom: 0px;
	margin-top: 3px;
}	
	
/* temp classes  */	
	
span.badge.moderate_temp {
    background: #FFEB3B;
}	
	
span.badge.error_temp {
    background: #FF3B3B;
	color: #fff;
}
	
span.badge.good_temp {
    background: #41BD23;
	color: #fff;
}
	
/* hum classes  */	
	
span.badge.error_hum {
    background: #FF3B3B;
}	
	
span.badge.good_hum {
    background: #41BD23;
	color: #fff;
}	
	
span.badge.moderate_hum {
    background: #FFEB3B;
}	

	
.standard {
	font-size: 10px;
	margin-bottom: 0px;
	margin-top: 3px;
}	
	
.standard .good{
	background: #00B40E;
	color: #fff;
	font-size: 20px ;
}	
	
.standard p{
	margin: 0px;
    font-size: 10px;
    margin-top: 5px;
}	
	
</style>
<body>
<div class="main-content">
  <div class="page-content">
  <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO015: Environment Control </h4>

	  <style>
		   .badge{
				text-align: center;
		   }
		  .Td-Results{
			  color: #FFFFFF;
		  }
		  .showmoreinfos h6{
			cursor: pointer;
			color: #003CFC;
		  }

		</style>
      <div class="row formcontainer" id="Staff_list">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"> </h4>
              <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
			  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
				  <thead>
					  <th>Date &amp; Time </th>
					  <th>MAC Address</th>
					  <th>Description</th>
					  <th>Mediator type</th>
					  <th>Temp</th>
					  <th>Humidity</th>
					  <th>Thermal standard</th>
					  <th> Dept </th>
				  </thead>
				  <tbody>
				  <?php foreach($datas as $data ){   ?>	  
					<td><?php  echo $data['Result_date'];  ?></td>
					<td><?php  echo $data['device_mac'];  ?></td>
					<td><?php  echo $data['device_Description'];  ?></td>
					<td><?php  echo $data['device_name'];  ?></td>
				    <?php  temp_boxe_Color($data['Temp'],$data['min'],$data['max']);  ?>
				    <?php  hum_boxe_Color($data['Humidity']);  ?>
					<td class="standard"><span  class="badge good" style="width: 100%;border-radius: 10px;">
						<?php  echo $data['device_type'];  ?><br><p>standard</p></span></td>
					<td><?php  echo $data['Dept_name']  ?></td>   
				  <?php  }  ?>	  
				  </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end col --> 
      </div>
      <!-- end row --> 
    </div>
    <!-- container-fluid --> 
  </div>
  <!-- End Page-content --> 
  
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper --> 
<!-- JAVASCRIPT --> 
<?php  $this->db->query("UPDATE `v0_area_device_permission` 
SET `seen`= '1' WHERE `system_id` = '".$sessiondata['admin_id']."' "); ?>
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
<!-- Datatable init js --> 
<script src="<?php echo base_url(); ?>assets/js/app.js"></script> 
<script>
$(document).ready(function () {
  //$('#Students_table').DataTable(); //Buttons examples

  var table_st = $('#Students_table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis']
  });
  table_st.buttons().container().appendTo('#Students_table_wrapper .col-md-6:eq(0)');
	
  var table_th = $('#Teacher_table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis']
  });
  table_th.buttons().container().appendTo('#Teacher_table_wrapper .col-md-6:eq(0)');
});
	
  $('#Teachers_list').hide();
  $('#Studnts_list').hide();

  $( '#Staffs_list' ).show();
	
  $( '.control button' ).click( function () {
	   $( '.control button' ).removeClass( 'btn-primary' );
	   $( this ).addClass( 'btn-primary' );
	   $( '.formcontainer' ).hide();
	   var to = $( this ).attr( 'form_target' );
	   $( '#' + to ).show();
  } );
	
	
function GetUserData(type,id){
	 //alert(" The UserType :"+type);
	 /*  
						  <div class="row justify-content-center">
                        	<div class="spinner-grow text-info m-1" role="status"> <span class="sr-only">Loading...</span> </div>
								<div class="row col-lg-12">
									<p class="text-center col-xl-12 mt-2">Loading...</p>  
								</div>
						  </div>
	 */
	 var loading = "";
	 loading += '<div class="row justify-content-center">';
	 loading += '<div class="spinner-grow text-info m-1" role="status"><span class="sr-only">Loading...</span></div>';
	 loading += '<div class="row col-lg-12">';
	 loading += '<p class="text-center col-xl-12 mt-2">Loading...</p></div></div>';
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo base_url(); ?>EN/schools/GetTheUserData',
	  data : {
		type : type, 
		id : id, 
	  },     
	  beforeSend : function(){
		   $('.modal-body').html('');
		   $('.modal-body').html(loading);
	  },
	  success: function (data) {
		   $('.modal-body').html(data);
	  },
	  ajaxError: function(){
		   $('.modal-body').css('background-color','#DB0404');
		   $('.modal-body').html("Ooops! Error was found.");
	  }
     });
}	
	
</script>
</body>
<?php
function temp_boxe_Color( $result , $min , $max) {
$ci = & get_instance();
?>
<td class="Td-Results_font">
  <!-- Hight error -->
  <?php if($result > $max){ ?>	
  <span class="badge error_temp"  style="width: 100%;border-radius: 10px;"><?php echo $result; ?><p>(low)</p></span>
 <?php }elseif($result < $min){ ?>	
  <span class="badge moderate_temp" style="width: 100%;border-radius: 10px;"><?php echo $result; ?><p>(Good)</p></span>
 <?php }elseif($result > $min && $result < $max ){ ?>	
  <span class="badge good_temp" style="width: 100%;border-radius: 10px;"><?php echo $result; ?><p>(Red)</p></span>
 <?php } ?>
</td>
<?php
}
?>
<?php
function hum_boxe_Color( $result ) {
$ci = & get_instance();
?>
<td class="Td-Results_font">
  <!-- Hight error -->
  <?php if($result > 65){ ?>	
  <span class="badge error_hum"  style="width: 100%;border-radius: 10px;"><?php echo $result; ?><br><p>(Too Dry)</p></span>
 <?php }elseif($result < 30){ ?>	
  <span class="badge moderate_hum" style="width: 100%;border-radius: 10px;"><?php echo $result; ?><p>(Optimum)</p></span>
 <?php }elseif($result >= 30 && $result <= 65 ){ ?>	
  <span class="badge good_hum" style="width: 100%;border-radius: 10px;"><?php echo $result; ?><p>(Too Mois)</p></span>
 <?php } ?>
</td>
<?php
}
?>
</html>
