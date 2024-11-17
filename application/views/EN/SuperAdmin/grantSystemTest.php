<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<body class="light menu_light logo-white theme-white">
<div class="outer"></div>  
<style>
     
.Ver ,.Not {
	font-size: 14px;
	border-radius: 5px;
	width: 100%;
	display: block;
	text-align: center;
	color: #fff;
	height: 30px;
	line-height: 5px;
	font-style: normal;
	font-weight: bold;
     margin-top: 5px;
}  
 
.Ver {     
	background: green;
}
.Not {     
	background: red;
}
         
</style>         
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />   
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
                                             $all_signels = $this->db->query("SELECT * FROM 
                                             `l0_systemtwithtest` ")->num_rows();
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

<div class="row">  
     
<div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #212121;border-radius: 4px;"> Give Test Permition To  </h4>
                                         <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                                <span id="Toast">Please Select The Organization and The Test</span> 
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                </button>
                                            </div>
          <form class="needs-validation InputForm" novalidate=""  style="margin-bottom: 27px;" id="LinkSy">
                                             
                                            <div class="row" >
<?php $AdminsArray = $this->db->query('SELECT * FROM `l0_organization` ORDER BY `Id` DESC')->result_array();   ?>
                                           <div class="col-md-12" style="margin-bottom: 10px">
                                        <label> Organization </label>   
                                                <select class="custom-select" id="System" name="System">
                                                      <option value="System" >System</option>
                                                      <?php foreach($AdminsArray as $Array){ ?>  
                                                      <option value="<?php echo $Array['Id']; ?>" class="option" >
                                                      <?php echo $Array['EN_Title']; ?>
                                                      </option>
                                                      <?php } ?>  
                                                </select>
                                            </div>                                                
                                            </div>
                                             
                                            <div class="row"  >
<?php $TestsArray = $this->db->query(' SELECT * FROM `l0_tests` ')->result_array();   ?>
                                           <div class="col-md-12" style="margin-bottom: 10px">
                                        <label>Select Test </label> 
                                             <div id="Tests">
                                             <select class="custom-select" name="Test">
                              <?php foreach($TestsArray as $tests):  ?>
                                   <option value="<?php echo $tests['Id'] ?>">
                                        <?php echo $tests['TestName_EN']; ?>
                                   </option> 
                              <?php endforeach;  ?>
                                             </select>     
                                             </div>   
                                            </div>     
                                            </div>
                                             
 
                                            <button class="btn btn-primary" type="Submit">Submit form</button>
                                             <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </form>
                                            
                                         
                                </div>
                                <!-- end card -->
                            </div>
</div>
     
 <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body" style="height: 354px;">
                                        <h4 class="card-title">List of the Last Organization</h4>
                                        <table class="table mb-0">
                                                <thead  style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Organization Name</th>
                                                        <th>Test Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
<?php  $entredSES = $this->db->query("SELECT * FROM l0_systemtwithtest ORDER BY `Id` DESC LIMIT 5 ")->result_array();   ?>        
                                                  <?php foreach($entredSES as $data){ ?>   
                                                    <tr>
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
          $getTests = $this->db->query("SELECT * FROM l0_tests WHERE id = '".$data['TestId']."' ")->result_array();
          foreach($getTests as $getTest){
               echo $getTest['TestName_EN'];
          }
                                                            ?>
                                                       </td>
                                                    </tr>
                                                     <?php } ?>
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
    
     
</div>     
</div> 
 <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>     
        <script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/pages/dashboard.init.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
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
chart1 = new ApexCharts(document.querySelector("#CharTTest2"), myoptions);
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
       
     
$("#LinkSy").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Dashboard/StartLink',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#Toast').html(data);

          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});
   
$('#back').click(function(){
     location.href = "<?php echo base_url()."Dashboard"; ?>";
});     
     
// Cancel *
     
$('#back').click(function(){
     location.href = "<?php echo base_url()."Dashboard"; ?>";
});     
     
function back(){
     location.href = "<?php echo base_url()."Dashboard"; ?>";
}     

$(document).ready(function(){

  /*  $("#System").change(function(){
     var selected = $(this).children("option:selected").val();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Dashboard/getTests',
          data: {id : selected },
          beforeSend: function () {
               $('#Tests').html('<div class="spinner-border text-dark m-1" role="status"><span class="sr-only">'+'Loading...</span></div>');
          },
          success: function (data) {
               $('#Tests').html(data);

          },
          ajaxError: function(){
               location.reload();
          }
     });
    });*/
});     
     
     
     
</script>
               
</body>

</html>