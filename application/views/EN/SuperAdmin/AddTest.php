<!doctype html>
<html lang="en">
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
<div class="row">   
<div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #1E1E1E;border-radius: 4px;">Add New Test</h4>
                                         <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                                <span id="Toast">Please Insert New Test Information</span> 
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                </button>
                                            </div>
                                        <form class="needs-validation InputForm" novalidate=""  style="margin-bottom: 27px;" id="AddTest">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom02">Test Description EN</label>
                                                        <input type="text" class="form-control" id="validationCustom02" placeholder="Test Description EN" name="English_Title" required="">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>   
                                                 
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">Test Description AR</label>
                                                        <input type="text" class="form-control" id="validationCustom01" placeholder="Test Description AR" name="Arabic_Title" required="">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                                                                  
                                            </div>
                                             
                                                  <div class="form-group">
                                             <label for="validationCustom02"> Test Code </label>
                                                <select class="custom-select" name="TestCode">
          <?php $codes = $this->db->query("SELECT * FROM `r_testcode` ")->result_array();   ?>                                                                <?php foreach($codes as $code){ ?>
                     <option value="<?php echo $code['Id']; ?>">
                          <?php echo $code['CPT_Code']." - ".$code['Test_Desc']; ?>
                    </option>
                                             <?php } ?>        
                                                </select>
                                                       
                                                    </div>
                                            <div class="row" >
                                           <div class="col-md-12" style="margin: 10px 0px;">
                                             <label>Select Unit Type</label>   
                                                <select class="custom-select" id="UnitType" name="UnitType">
                                                    <option value="1">Min/Max</option>
                                                    <option value="0">Signales</option>
                                                </select>
                                            </div>                                                
                                            </div>
                                             
                                        <div class="row" id="1" style="display: flex;"> 
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Min Range  :</label>
                                                <input id="demo_vertical" type="text" value="0" name="Min">
                                            </div>
                                        </div>  
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Max Range  :</label>
                                                <input id="demo_vertical" type="text" value="100" name="Max">
                                            </div>
                                        </div>                                          
                                             
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Min Unit :</label>
                                             <input type="text" class="form-control" id="validationCustom02" placeholder="Min Unit" name="MinUnit" >
                                            </div>
                                        </div>  
                                             
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Max Unit  :</label>
                                   <input type="text" class="form-control" id="validationCustom02" placeholder="Max Unit" name="MaxUnit" >
                                            </div>
                                        </div>  
                                             
                                        </div>   
 
                                        <div class="row" id="0" style="display: none;"> 
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Positive :</label>
                                             <input type="text" class="form-control" id="validationCustom02" value="+" placeholder="Positive" name="Positive" >
                                            </div>
                                        </div>  
                                             
                                    <div class="col-md-6">   
                                   <div class="form-group">
                                        <label class="control-label">Negative  :</label>
                                        <input type="text" class="form-control" id="validationCustom02" placeholder="Negative" name="Negative" value="-" >
                                   </div>
                                   </div>  
                                             
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Unite Positive   :</label>
                                                <input id="demo_vertical" class="form-control" type="text" name="UnitePositive">
                                            </div>
                                        </div> 
                                             
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Unite Negative  :</label>
                                                <input id="demo_vertical" class="form-control" type="text" name="UniteNegative">
                                            </div>
                                        </div>                                          
                                             
                                        </div>   
 
                                      <?php /*  <div class="row" id="0" style="display: none;">
                                   <div class="col-md-6" >       
                                   <div class="custom-control custom-radio mb-3 ">
                                   <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                   <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label></div>   
                                   </div>
                                        </div>   */ ?>  
 
                                             
                                            <button class="btn btn-primary" type="Submit">Submit form</button>
                                             <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </form>
                                         
          <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
<form id="sendToemail">
<div id="statusbox" class="alert alert-primary" role="alert">
     Please Write Email To Send Infos
</div>     
<input type="hidden" class="staticinput" id="getedusername" name="getedusername">     
<input type="hidden" class="staticinput" id="getedpassword" name="getedpassword">     
     
<div class="form-group">
 <label for="validationCustom02">Email  </label>
 <input type="text" class="form-control" id="validationCustom02" placeholder="Email" name="sendToEmail" required="">
 <div class="valid-feedback">
     Looks good!
 </div>
</div>
<button type="Submit" style="width: 100%;" class="btn btn-primary w-lg waves-effect waves-light" id="sendingbutton">SEND THE EMAIL</button>     
</form>     
                                                                 
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>   
                                         
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
<div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body" style="height: 600px;">
                                        <h4 class="card-title">List of Tests</h4>
                                        <table class="table mb-0">
                                                <thead  style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Test Name</th>
                                                        <th style="width: 30%;">Test Code</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
<?php $listofTests = $this->db->query("SELECT * FROM `l0_tests` ")->result_array(); ?>                                                     
                                                  <?php foreach($listofTests as $TestData){ ?>   
                                                    <tr>
                                                       <th scope="row"><?php echo $TestData['Id'] ?></th>
                                                       <td><?php echo $TestData['TestName_EN'] ?></td>
                                                       <td><?php echo $TestData['TestCode'] ?></td>  
                                                       <td><?php echo $TestData['TestMin'].' '.$TestData['MinUnit'] ?></td>
                                                       <td><?php echo $TestData['TestMax'].' '.$TestData['MaxUnit'] ?></td>
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
</div>   
 <script src="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>     
 <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>     
<script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pages/dashboard.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
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
     
$("#AddTest").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Dashboard/StartAddNewTest',
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
     
    $("input[name='Min'],input[name='Max']").TouchSpin({
      verticalbuttons: true
    }); //Bootstrap-MaxLength
     
     
     
$(document).ready(function(){

    $("#UnitType").change(function(){
     var selectedunit = $(this).children("option:selected").val();
         if(selectedunit == 0){
              $('#1').hide();
              $('#0').show();
         }else{
              $('#0').hide();
              $('#1').show();
         }
         
    });

});  
     
</script>
               
</body>

</html>