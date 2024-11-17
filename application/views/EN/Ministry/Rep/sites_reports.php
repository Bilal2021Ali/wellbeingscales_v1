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
	
		   .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px; 
		} 
</style>
	  
<div class="main-content">
  <div class="page-content">
  	 	 	 <div class="row">
								<div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div>
  
    <div class="container-fluid">
	
      <div class="row">
	  
        <div class="col-12">
		 <br>
	      <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 020 - Site Reports </h4>
         
          <div class="row">
			  <div class="col-lg-12">
				<div class="card">
				  <div class="card-body">
					<table class="table table_sites" id="sites_table">
					  <thead>
						<tr>
						  <th class="text-center"> School ID </th>
						  <th> School Name </th>
						  <th> Site Name  </th>
						  <th> Site Description </th>
						  <th> Date &amp; Time  </th>
						  <th> Batch No  </th>
						  <th> Test Type </th>
						  <th class="text-center"> Result</th>
						  <th class="text-center"> Report </th>
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
	$sitesForThisUser = $ci->db->select('l1_school.School_Name_EN,l2_site.*')
	->from('l1_school')
	->join("l2_site","l2_site.Added_By = l1_school.Id AND l1_school.Added_By = 
	'".$sessiondata['admin_id']."' ")
	->get()->result_array();

	get_site_of_test($sitesForThisUser);

}    

	
function get_site_of_test($sitesForThisUser){
    $ci =& get_instance();
    $ci->load->library( 'session' );
    $today = date("Y-m-d");
    $listSites = array();
    $sessiondata = $ci->session->userdata('admin_details');      
	foreach($sitesForThisUser as $site){
	$school_name = $site['School_Name_EN'];
    $name = $site['Description']; 
    $site_name = $site['Site_Code']; 
    $ID = $site['Id'];
    $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '".$site['Id']."'
    AND UserType = 'Site'  ORDER BY `Id` DESC ")->result_array(); 
    //print_r($getResults);
    foreach($getResults as $T_results){
    $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '".$site['Id']."'
    AND UserType = 'Site' ORDER BY `Id` DESC ")->result_array();  
	//if(!empty($lastRead)){
    $lastRead = $lastReads[0]['Result'];
    $lastReadDate = $lastReads[0]['Created'].'<br>'.$lastReads[0]['Time'];
    $listSites[] = array( "name" => $name, "Id" => $ID,
    "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Test_Description' ],
    "Device_ID" =>  $T_results[ 'Test_Description' ], "Batch" => $T_results['Device_Batch'],                   
    "Result" => $T_results[ 'Result' ], "Creat" => $T_results[ 'Created' ],
    "LastRead" => $lastRead,"LastReadDate" => $lastReadDate , "Action" => $T_results['Action'] , "SiteName" => $site_name,  
	"RepLink" => $T_results['Report_link'] , "School_name" => $school_name,			 
    );    
	//}	
 	}
    }
    ///print_r($listSites);
    foreach($listSites as $siteResult){ ?>

    <tr>
	<td class="text-center"><?php echo $siteResult['Id'] ?></td>
	<td><?php echo $siteResult['School_name'] ?></td>
    <td><?php echo $siteResult['name'] ?></td> 
    <td><?php echo $siteResult['SiteName'] ?></td> 
    <td><?php echo $siteResult['LastReadDate'] ?></td>  
    <td><?php echo $siteResult['Batch'] ?></td> 
    <td><?php echo $siteResult['Testtype'] ?></td>    
    <?php if($siteResult['Action'] == "School"){ ?>         
    <?php if($siteResult['Result'] == '0'){ ?>
    <td class="text-center"> <span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
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
		<i class="uil uil-file-alt font-size-18" data-toggle="tooltip" data-placement="top" title="" data-original-title="report PDF"></i>
		</a>
		<?php }else{ ?>
		<i class="uil uil-desktop-slash font-size-18" data-toggle="tooltip" data-placement="top" 
	    data-original-title="There is no report."></i>
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