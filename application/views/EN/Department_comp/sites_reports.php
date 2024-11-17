<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>
<?php 
$today = date("Y-m-d");	
$list_Tests = $this->db->query("SELECT * FROM `r_testcode`")->result_array();
?>
<body>
<style>
	.uil-file-alt{
		color: #34c38f;
	}	
	
	.uil-desktop-slash{
		color: #f46a6a;
	}
	
</style>
	  
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
              <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
				  Report on the Results of Laboratory Tests for Sites in  - <?php echo $sessiondata['f_name'] ?>
			  </h4>
          <div class="row">
			  <div class="col-lg-12">
				<div class="card">
				  <div class="card-body">
					<table class="table table_sites" id="sites_table">
					  <thead>
						<tr>
						  <th>Site Name</th>
						  <th>Site Description</th>
						  <th>Date &amp; Time </th>
						  <th> Batch Number </th>
						  <th> Test Type </th>
						  <th> Result </th>
						  <th> Actions </th>
						</tr>
					  </thead>
					  <tbody>
						<?php GetListOfSites($list_Tests); ?>
					  </tbody>
					</table>
				  </div>
				</div>
			  </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<?php 
    
function GetListOfSites($list_Tests){
    $ci =& get_instance();
    $ci->load->library( 'session' ); 
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');      
    $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_co_site` WHERE 
    `Added_By` = '".$sessiondata['admin_id']."' ORDER BY `Site_Code` ASC ")->result_array();
    foreach($list_Tests as $test){ 
		get_site_of_test($sitesForThisUser,$test['Test_Desc']);
	}
    //print_r($sitesForThisUser);
}    

	
function get_site_of_test($sitesForThisUser,$testType){
    $ci =& get_instance();
    $ci->load->library( 'session' ); 
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');      
	foreach($sitesForThisUser as $site){
    $name = $site['Description']; 
    $site_name = $site['Site_Code']; 
    $ID = $site['Id'];
    $getResults = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '".$site['Id']."'
    AND UserType = 'Site' AND  `Test_Description` = '".$testType."'  ORDER BY `Id` DESC ")->result_array(); 
    //print_r($getResults);
    foreach($getResults as $T_results){
    $lastReads = $ci->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '".$site['Id']."'
    AND UserType = 'Site' AND `Test_Description` = '".$testType."' ORDER BY `Id` DESC ")->result_array();  
	//if(!empty($lastRead)){
    $lastRead = $lastReads[0]['Result'];
    $lastReadDate = $lastReads[0]['Created'].'<br>'.$lastReads[0]['Time'];
    $listSites[] = array( "name" => $name, "Id" => $ID,
    "Testtype" => $T_results[ 'Test_Description' ],
    "Device_ID" =>  $T_results[ 'Test_Description' ], "Batch" => $T_results['Device_Batch'],                   
    "Result" => $T_results[ 'Result' ], "Creat" => $T_results[ 'Created' ],
    "LastRead" => $lastRead,"LastReadDate" => $lastReadDate , "Action" => $T_results['Action'] , "SiteName" => $site_name,  
	"RepLink" => $T_results['Report_link']					 
    );    
	//}	
 	}
    }
    ///print_r($listSites);
    foreach($listSites as $siteResult){ ?>
    <tr>
    <td><?php echo $siteResult['name'] ?></td> 
    <td><?php echo $siteResult['SiteName'] ?></td> 
    <td><?php echo $siteResult['LastReadDate'] ?></td>  
    <td><?php echo $siteResult['Batch'] ?></td> 
    <td><?php echo $siteResult['Testtype'] ?></td>    
    <?php if($siteResult['Action'] == "School"){ ?>         
    <?php if($siteResult['Result'] == '0'){ ?>
    <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
    <?php }else{ ?> 
    <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">Positive (+)</span></td>
    <?php } ?>
    <?php }else{ ?>
    <?php if($siteResult['Result'] == '0'){ ?>
    <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">Negative (-)</span></td>
    <?php }else{ ?> 
    <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">Positive (+)</span></td>
    <?php } ?>
    <?php } ?>
	<td class="text-center">
		<?php if(!empty($siteResult['RepLink'])){  ?>
		<a href="<?php echo base_url()."uploads/sites_reports/".$siteResult['RepLink'] ?>" target="new">
		<i class="uil uil-file-alt font-size-18" data-toggle="tooltip" data-placement="top" title="" data-original-title="Report pdf"></i>
		</a>
		<?php }else{ ?>
		<i class="uil uil-desktop-slash font-size-18" data-toggle="tooltip" data-placement="top" data-original-title="No Reports"></i>
		<?php } ?>
	</td>	
    </tr>
    <?php
  }
}
		
?>	
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
  var table_st = $('#sites_table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis']
  });
  table_st.buttons().container().appendTo('#sites_table_wrapper .col-md-6:eq(0)');
	
</script>
</html>