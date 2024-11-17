<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- DataTables -->
        <link href="<?php echo base_url() ?>aassets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>aassets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="<?php echo base_url() ?>aassets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url() ?>aassets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url() ?>aassets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url() ?>aassets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
         <link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
     .delet{
          cursor: pointer;
     }     
     
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
     
</style>
    </head>
<style>
     .InfosCards h4,.InfosCards p{
          color: #fff;
     } 
     .InfosCards .card-body{
          border-radius: 5px;
     }
</style>
    
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
                                             $all = $this->db->query("SELECT * FROM `l0_organization` ")->num_rows(); 
                                             $all_min_max = $this->db->query("SELECT * FROM `l0_tests` ")->num_rows();
                                             $all_signels = $this->db->query("SELECT * FROM `l0_systemtwithtest` ")->num_rows();
                                             ?>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                            <p class="mb-0">Total Organizations</p>
                                        </div>
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
                                            <p class="mb-0"> Total Tests</p>
                                        </div>
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
                                            <p class="mb-0"> Total Connected Tests </p>
                                        </div>
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
                                            <li class="breadcrumb-item active">Connected</li>
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
        
                                        <h4 class="card-title"> Manage Organization With Tests </h4>
                                        <table id="datatable" class="table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                             <tr>
                                              <th>Id</th>
                                              <th> System </th>
                                              <th>Test</th>
                                              <th> Date Created </th>
                                              <th class="actions"  style="text-align: center;" >Actions</th>
                                             </tr>
                                            </thead>
                                                <tbody>
<?php  $entredSES = $this->db->query("SELECT * FROM l0_systemtwithtest ORDER BY `Id` DESC ")->result_array();   ?>        
                                                  <?php foreach($entredSES as $data){ ?>   
                                                    <tr id="<?php echo $data['Id']; ?>">
                                                       <th><?php echo $data['Id']; ?></th>  
                                                        <td scope="row">
                                                       <?php 
          $getname = $this->db->query("SELECT * FROM l0_organization WHERE id = '".$data['SystemId']."' ")->result_array();
          foreach($getname as $sesname){
               echo $sesname['EN_Title'];
          }
                                                            ?>
                                                       </td>
                                                        <td scope="row">
                                                       <?php 
          $getcode = $this->db->query("SELECT * FROM l0_tests WHERE id = '".$data['TestId']."' ")->result_array();
          foreach($getcode as $code){
          $TestCodes = $this->db->query("SELECT * FROM r_testcode WHERE Id = '".$data['TestId']."' ")->result_array();
               foreach($TestCodes as $codes){
                    echo $codes['CPT_Code'];
               }
          }
                                                            ?>
                                                       </td>
                                                         <td>
                                                       <?php echo $data['Created']; ?>  
                                                       </td>
                                                         <td style="text-align: center;">
                                                           <i class=" bx bxs-trash-alt delet" theId="<?php echo $data['Id'];  ?>"></i>
                                                         </td>
                                                         
                                                    </tr>
                                                     <?php } ?>
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
<script>
     
$('.delet').each(function(){
$(this).click(function(){
 var theId = $(this).attr('theId');
 console.log(theId);
 

Swal.fire({
  title: 'Do you want to save the changes?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: `Yes, I am sure!`,
  icon: 'warning',     
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Dashboard/DeletConnect',
     data: {
      Conid: theId,
     },
     success: function (data) {
     Swal.fire(
     'success',
     data,
     'success'
     );
     $('#'+theId).remove();
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! we have a error',
     'error'
     )
     }
     });
  }
})    
     
     
});     
});      
     
</script>
        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>
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
     'oops!! we have a error',
     'error'
     )
     }
     });
     
});     
});  

  //modify buttons style
  $.fn.editableform.buttons = '<button type="Submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button>' + '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light"><i class="mdi mdi-close"></i></button>'; //inline

  $('#inline-username').editable({
    type: 'text',
    pk: 1,
    name: 'username',
    title: 'Enter username',
    mode: 'inline',
    inputclass: 'form-control-sm',
    url: '/post' 
  });
     
     
  

     
     
</script> 
       
     </body>
</html>
