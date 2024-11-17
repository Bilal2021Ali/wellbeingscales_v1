tbl_testcodes<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

        <!-- DataTables -->
        <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />   
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
  background-color: #CB0002;
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
     
.bx.bxs-trash-alt{
  font-size: 24px;
  color: #e8625b;
  margin-left: 9px; 
}  
     
     .delet{
          cursor: pointer;
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
        <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     

    </head>

    
    <body>

    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 col-xl-4 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #144882;">
                                        <div class="float-right mt-2">
                                            <div id="CharTTest1"></div>
                                        </div>
                                        <div>
                                             <?php 
                                             $all = $this->db->query("SELECT * FROM `l0_tests` 
                                             WHERE Ch = '1' OR Ch = '0'")->num_rows(); 
                                             $all_min_max = $this->db->query("SELECT * FROM `l0_tests` 
                                             WHERE Ch = '1' ")->num_rows();
                                             $all_signels = $this->db->query("SELECT * FROM `l0_tests` 
                                             WHERE Ch = '0' ")->num_rows();
                                             
                                             $last_Tests = $this->db->query("SELECT * FROM `l0_tests` 
                                             WHERE Ch = '1' OR Ch = '0' LIMIT 1")->result_array();
                                             $last_signels = $this->db->query("SELECT * FROM `l0_tests` 
                                             WHERE Ch = '0' LIMIT 1")->result_array();
                                             $last_min_max = $this->db->query("SELECT * FROM `l0_tests` 
                                             WHERE Ch = '1' LIMIT 1")->result_array();
                                             
                                             ?>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                            <p class="mb-0">Total Tests</p>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($last_Tests as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Added Test
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-4 col-xl-4 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #0164a8;">
                                        <div class="float-right mt-2">
                                            <div id="orders-chart"></div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">
                                                 <span data-plugin="counterup"><?php echo $all_min_max ?></span>
                                             </h4>
                                            <p class="mb-0"> Total Min/Max Tests</p>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($last_min_max as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last Added Min/Max Test
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-4 col-xl-4 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #6f42c1;">
                                        <div class="float-right mt-2">
                                            <div id="customers-chart"></div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">
                                                 <span data-plugin="counterup"><?php echo $all_signels ?></span>
                                             </h4>
                                            <p class="mb-0"> Total -/+ Tests </p>
                                        </div>
                                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                                        <?php foreach($last_signels as $last){ ?>     
                                        <?php echo $last['Created'] ?></span><br>
                                         Last  Added -/+ Test
                                        <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Test</a></li>
                                            <li class="breadcrumb-item active">List</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Test List</h4>
                                        <table id="datatable" class="table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                             <tr>
                                              <th>Id</th>
                                              <th> Description EN </th>
                                              <th> Description AR </th>
                                              <th>Test code</th>
                                              <th>Type </th>
                                              <th>From</th>
                                              <th>To</th>
                                              <th class="actions">Actions</th>
                                             </tr>
                                            </thead>
     <tbody>
          <?php foreach($listofadmins as $admin){ ?>
               <tr id="<?php echo $admin['Id']; ?>">
               <th scope="row"><?php echo $admin['Id'];?></th>
               <td><?php echo $admin['TestName_EN'];?></td>
               <td><?php echo $admin['TestName_AR'];?></td>
          <?php $codes = $this->db->query("SELECT * FROM r_testcode 
          WHERE Id = '".$admin['TestCode']."' ")->result_array(); ?>   
               <?php foreach($codes as $code){ ?>     
               <td title="<?php echo $code['Test_Desc'] ?>"><?php echo $code['CPT_Code'];?></td>
               <?php } ?>     
               <?php
               if($admin['Ch'] == 1){
                   $type = 'From/To'; 
               }else{
                   $type = 'Signals'; 
               }     
               ?> 
               <td><?php echo $type;?></td>
               <td><?php echo $admin['TestMin'].' '.$admin['MinUnit'];?></td>
               <td><?php echo $admin['TestMax'].' '.$admin['MaxUnit'];?></td>
               <td><a href="<?php echo base_url() ?>EN/Dashboard/UpdateTestData/<?php echo $admin['Id']; ?>">
               <i class="uil-pen" style="font-size: 25px;" title="Edit"></i></a>
               <i class="delet bx bxs-trash-alt" TestId="<?php echo $admin['Id']; ?>" ></i></td>
          </tr>
          <?php  } ?>
     </tbody>
        
                                        </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT 
        <script src="<?php echo base_url(); ?>assets/libs/waypoints/waypoints.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <!-- Required datatable js
        <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Responsive examples
        <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- Datatable init js
        <script src="<?php echo base_url() ?>assets/js/pages/datatables.init.js"></script>

-->
        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/pages/dashboard.init.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script>
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
     
$('input[type="checkbox"]').each(function(){
$(this).change(function(){
 var theAdminId = $(this).attr('theAdminId');
 console.log(theAdminId);
 console.log(this.checked);    
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Dashboard/changestatus',
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

  //modify buttons style
 /* $.fn.editableform.buttons = '<button type="Submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button>' + '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light"><i class="mdi mdi-close"></i></button>'; //inline

  $('#inline-username').editable({
    type: 'text',
    pk: 1,
    name: 'username',
    title: 'Enter username',
    mode: 'inline',
    inputclass: 'form-control-sm',
    url: '/post' 
  });*/
     
$('.delet').each(function(){
$(this).click(function(){
     
  
Swal.fire({
  title: 'Do you want to save the changes?',
  icon: 'warning',     
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: `Save`,
  denyButtonText: `Don't save`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
     var ID = $(this).attr('TestId');     
   $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Dashboard/DeletTest',
     data: {
      ID: ID,
     },
     success: function (data) {
     Swal.fire(
     'success',
     data,
     'success'
     );
     $('#'+ID).remove();     
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! لدينا خطأ',
     'error'
     )
     }
     });
  }else{
       console.log("Error");
  }
     
});
     
});     
});     
     
     
</script> 
       
     </body>
</html>
