<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<body class="light menu_light logo-white theme-white">
<link href="<?php echo base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />     
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />   

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

<div class="main-content">
<div class="page-content">
<div class="row">   
<div class="col-xl-6">
                                                <tbody>
                                                  
                                                  <?php /* foreach($listofTests as $TestData){ ?>   
                                                    <tr>
                                                       <th scope="row"><?php echo $TestData['Id'] ?></th>
                                                       <td><?php echo $TestData['TestName_EN'] ?></td>
                                                       <td><?php echo $TestData['TestCode'] ?></td>  
                                                       <td><?php echo $TestData['TestMin'].' '.$TestData['MinUnit'] ?></td>
                                                       <td><?php echo $TestData['TestMax'].' '.$TestData['MaxUnit'] ?></td>
                                                     </tr>
                                                     <?php } */ ?>
                                                </tbody>
     
     <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="background: #61D80D;padding: 10px;color: #1E1E1E;border-radius: 4px;">Update Test Infos</h4>
                                         <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                                <span id="Toast">Please Enter New Test Information</span> 
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                </button>
                                            </div>
                                         <?php foreach($TestData as $test){  ?>
                                        <form class="needs-validation InputForm" novalidate=""  style="margin-bottom: 27px;" id="AddTest">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">Arabic Test Title</label>
                                                        <input type="text" class="form-control" id="validationCustom01" placeholder="Arabic Title" name="Arabic_Title"
                                                        value="<?php echo $test['TestName_AR'] ?>" required="">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom02">English Test Title</label>
                                                        <input type="text" class="form-control" id="validationCustom02" placeholder="English Title" name="English_Title" 
                                                        value="<?php echo $test['TestName_EN'] ?>"  required="">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>   
                                            </div>
                                             
                                                  <div class="form-group">
                                                        <label for="validationCustom02">Write Test Code </label>
                                                        <input type="text" class="form-control" id="validationCustom02" placeholder="Write Test Code" name="TestCode" 
                                                        value="<?php echo $test['TestCode'] ?>" required="">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
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
                                                <input id="demo_vertical" type="text"
                                                value="<?php echo $test['TestMin'] ?>"  name="Min">
                                            </div>
                                        </div>  
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Max Range  :</label>
                                                <input id="demo_vertical" type="text"
                                                value="<?php echo $test['TestMax'] ?>" name="Max">
                                            </div>
                                        </div>                                          
                                             
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Min Unit :</label>
                                             <input type="text" class="form-control" id="validationCustom02" 
                                             placeholder="Min Unit" name="MinUnit" value="<?php echo $test['MaxUnit'] ?>" >
                                            </div>
                                        </div>  
                                             
                                        <div class="col-md-6">   
                                             <div class="form-group">
                                                <label class="control-label">Max Unit  :</label>
                                   <input type="text" class="form-control" id="validationCustom02" 
                                   placeholder="Max Unit" name="MaxUnit" value="<?php echo $test['MinUnit'] ?>" >
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
 
                                             <input type="hidden" value="<?php echo $test['Id']; ?>" name="ID" >
                                            <button class="btn btn-primary" type="Submit">Submit form</button>
                                             <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </form>
                                         <?php } ?>
                                         
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
                                        <h4 class="card-title">List of the Last Inseted Tests</h4>
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
<?php $listofTests = $this->db->query("SELECT * FROM `tbltests` ")->result_array(); ?>                                                     
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
<script>
       
     
$("#AddTest").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/Dashboard/StartUpdateTestData',
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