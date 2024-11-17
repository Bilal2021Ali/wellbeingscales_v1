<!doctype html>
<style>
     
 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}      
     
</style>

<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<body class="light menu_light logo-white theme-white">
     <app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
          <!---->
          <app-main _nghost-pjk-c134="" class="ng-star-inserted">
               <section class="content">
                    
  <div class="main-content">
     <div class="page-content">
          
<div class="row">
                            <div class="col-md-6 col-xl-6 InfosCards">
                                <div class="card">
                              <div class="card-body" style="background-color: #3df0f0;padding: 5px">
                                    <div class="card-body" style="background-color: #022326;">
                         <div class="float-right mt-2">
                                           <!-- <div id="CharTTest1"></div>-->
                         <img src="<?php echo base_url(); ?>assets/images/icons/D100.png" alt="schools" width="50px"></i>     
                         </div>
                                        <div>
                                             <?php
                     $idd = $sessiondata['admin_id'];
                    $allResurs = $this->db->query("SELECT * FROM `r_sites`")->num_rows(); 
                    $lastsresurs = $this->db->query("SELECT * FROM `r_sites` ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             ?>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allResurs ?></span></h4>
                                            <p class="mb-0">Number of Sites </p>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($lastsresurs as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Registered Site
                                        <?php } ?>
                                        </p>
                                    </div>
                                 </div> 
                                </div>
                            </div> 
               <!-- Teachers  -->
                            <div class="col-md-6 col-xl-6 InfosCards">
                                <div class="card">
                              <div class="card-body" style="background-color: #ff26be;padding: 5px">
                                    <div class="card-body" style="background-color: #2e001f;">
                                        <div class="float-right mt-2">
                         <img src="<?php echo base_url(); ?>assets/images/icons/D300.png" alt="department" width="50px">    
                                        </div>
                                        <div>
                                             <?php 
                    $allarea = $this->db->query("SELECT * FROM `l2_dept_site` WHERE `Added_By` = '".$idd."' ")->num_rows(); 
                    $lastsareas = $this->db->query("SELECT * FROM `l2_dept_site`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                                             ?>
                                            <h4 class="mb-1 mt-1">
                         <span data-plugin="counterup"><?php echo $allarea ?></span>
                                             </h4>
                                            <p class="mb-0">Total of Areas</p>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($lastsareas as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Registered Areas
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div> <!-- end row-->
       
<div class="container-fluid" style="overflow: auto;">
 <div class="page-title-right">
     <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="javascript: void(0);">Sites</a></li>
         <li class="breadcrumb-item active">List</li>
     </ol>
 </div>
     
<div class="card"> 
     <div class="card-body">
<table class="table">
     <thead>
          <tr>
               <th> # </th>
               <th> Name </th>
               <th> Description </th>
               <th> Edit </th>
          </tr>
     </thead>
     <tbody>
          <?php foreach($listofaStaffs as $admin){ ?>
          <tr>
               <th scope="row"><?php echo $admin['Id'];?></th>
               <?php 
               $Site_name = $admin['Site_Code'];                                
               $sitecodes = $this->db->query("SELECT * FROM `r_sites` WHERE Site_Name = '".$Site_name."'
               ORDER BY `Site_Code` DESC LIMIT 1")->result_array(); 
               foreach($sitecodes as $code){ ?>
               <td><?php echo $code['Site_Code']." - ".$Site_name; ?></td>
               <?php   }  ?>
               <td><?php echo $admin['Description'];?></td>
               <td>
               <a href="<?php echo base_url() ?>AR/Departments/UpdateSite/<?php echo $admin['Id']; ?>">
               <i class="uil-pen" style="font-size: 25px;" title="Edit"></i>
               </a>
               </td>
          </tr>
          <?php  } ?>

     </tbody>
</table>
     </div>
</div>  
</table>
</div>
     </div>
          </div>  
                    </div>

               </section>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script>
$("table").DataTable();     
$('input[type="checkbox"]').each(function(){
$(this).change(function(){
 var theAdminId = $(this).attr('theAdminId');
 console.log(theAdminId);
 console.log(this.checked);    
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/DashboardSystem/changeSchoolstatus',
     data: {
      adminid: theAdminId,
     },
     success: function (data) {
     Swal.fire(
     'success',
     data,
     'success'
     )
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! لدينا خطأ',
     'error'
     )
     }
     });
     
});     
});     
     
<?php if($this->session->flashdata('email_sended')){ ?>
try{          
setTimeout(function(){
  $('.alert.alert-success').addClass('alert-hide') 
  $('.container-fluid').css('margin-top','0px')
},3000);
    }catch(err){
         
    }     
<?php } ?>   
     
/*$('.show-details-btn').on('click', function(e) {
	e.preventDefault();
	$(this).closest('tr').next().toggleClass('open');
	$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
});
     *//*
var pagenumber = 1;
var lhsab = (1-1)*20;
$('.serchable').each(function(){
var id =  $(this).attr('id');     
if(id < lhsab && id > lhsab ){
     console.log('yes i need to hide my id is = '+id);
}else{
     console.log('natha id = '+id);
}
}); */ 
     
     
     
     
</script>

     
     
</body>

</html>