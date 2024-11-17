<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
	
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_patient WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array(); 
     
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
     .AddedSuccess{
          background-color: #007709;
          text-align: center;
          transition: 0.5s all;
          color: #fff;
          width: 100%;
     }     

.btn-covid{
    border-radius: 100%;
    width: 30px;
    height: 30px;
    text-align: center;
    margin-left: 10px;
}

.btn-covid i{
     margin-left: -5px;
}



.COUNTER_USED {
    text-align: center;
    display: grid;
    align-items: center;
}

</style>
        <!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<body>
     <div class="main-content">
          <div class="page-content">
               <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                         <div class="card-body">
                         <div class="row">
                         <div class="col-xl-6">
                         <label>Select Device :</label>
                           <select class="custom-select" name="Test_device" id="Test_device">
                           <?php 
                            $Devices = $this->db->query(" SELECT * FROM l2_devices WHERE
                            `Added_by` = '".$sessiondata['admin_id']."'  ORDER BY `Id` DESC ")->result_array(); 
                            ?>
                           <?php foreach($Devices as $device): ?>
                                <option value="<?php echo $device['D_Id']; ?>"><?php echo $device['D_Id']; ?></option>
                           <?php endforeach; ?>   
                           </select>
                         </div>    
                         <div class="col-xl-6">
                         <label>Select Test :</label>
                           <select class="custom-select" name="Test_Id" id="Test_Id">
                           <?php 
                            $TestsCodes = $this->db->query(" SELECT * FROM r_testcode ")->result_array(); 
                            ?>
                           <?php foreach($TestsCodes as $testCode): ?>
                                <option value="<?php echo $testCode['Test_Desc']; ?>"><?php echo $testCode['Test_Desc']; ?></option>
                           <?php endforeach; ?>   
                           </select>
                         </div>                          <?php /* <div class="col-xl-5" style="margin-bottom: 10px;">
                           <label style="float: left;">Select Test type</label>
                           <select class="form-control" name="Test_device" id="Test_device">
                           <?php $Devices = $this->db->query(" SELECT * FROM l2_devices WHERE `Added_by` = '".$sessiondata['admin_id']."'  ORDER BY `Id` DESC ")->result_array(); ?>
                           <?php foreach($Devices as $device): ?>
                           <?php $d_id =  $device['D_Id']; ?>
                           <optgroup label="<?php echo $d_id; ?>"></optgroup> 
                           <?php $device_batches = $this->db->query(" SELECT * FROM l2_batches WHERE `For_Device` = '".$device['Id']."' AND `Status` = '0' ORDER BY `Id` DESC ")->result_array(); ?>
                           <?php foreach($device_batches as $batch){ ?>
                              <option value="<?php echo $d_id.'@'.$batch['Batch_Id'].'@'.$batch['Device_Type']; ?>"><?php echo $d_id.' - '.$batch['Batch_Id'].' - '.$batch['Device_Type']; ?></option>
                           <?php } ?>  
                           <?php endforeach; ?>   
                           </select>
                         </div>
                         <div class="COUNTER_USED col-xl-1"></div> */ ?>
                         </div> 
                         </div>
                    </div>
                    </div>
                    <div class="col-lg-12" id="Staffs">
                         <div class="card">
                              <div class="card-body">
                                   <table class="table">
                                        <thead>
                                             <tr>
                                                  <th> # </th>
                                                  <th> Name </th>
                                                  <th> National ID </th>
                                                  <th> Select </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach($listofaStaffs as $admin){ ?>
                                             <tr id="<?php echo $admin['UserType'].'_'.$admin['Id']; ?>">
                                                  <th scope="row">
                                                       <?php echo $admin['Id']; ?>
                                                  </th>
                                                  <td>
                                   <?php echo $admin['F_name_EN'].' '.$admin['M_name_EN'].' '.$admin['L_name_EN'];?>
                                                  </td>
                                                  <td><?php echo $admin['National_Id'];?></td>
                                                  <td>
                                                  <div style="display: flex;">     
                                                  <input id="9K3Lt8Gw<?php echo $admin['Id'] ?>JXNHkS7Q" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">      
                                        <button class="btn btn-danger waves-effect waves-light btn-covid" 
										onClick="addCovidTest(<?php echo $admin['Id']; ?>,'<?php echo $admin['UserType']; ?>','Pos');" 
										style="margin-left: 10px;" >
                                                  <i class="uil uil-plus"></i> 
                                                  </button>
									  <button class="btn btn-success waves-effect waves-light btn-covid" 
									  onClick="addCovidTest(<?php echo $admin['Id']; ?>,'<?php echo $admin['UserType']; ?>','Nigative');"
									  style="margin-left: 10px;" >
                                                  <i class="uil uil-minus"></i> 
                                                  </button>
                                                  </div> 
                                                  </td>
                                             </tr>
                                             <?php  } ?>

                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
              </div>
               <div class="JHZLNS"></div>
          </div>
     </div>

</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
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
    try{
$("table").DataTable();
    }catch(err){
        null;
    }
    
var batch = "";

    
function addCovidTest(id,user_type,val){
         var batch = $("#9K3Lt8Gw"+id+"JXNHkS7Q").val();
    // var test = par.child('input').val();
     console.log("THEST Var Is   "+batch);
     var TestDev =  $('#Test_device').children("option:selected").val();
     var Test_id =  $('#Test_Id').children("option:selected").val();
     //console.log("THEST DEV"+TestDev);
     //alert('Test'+id+' '+user_type+' '+val);
     var result;
     if(val == 'Pos'){
          result = 1;
     }else{
          result = 0;
     }
    if(batch !== ""){
  $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Results/AddCovidResult',
     data: {
          UserId : id,
          Test_type : user_type,
          Temp : result,
          Device : TestDev,
          Batch : batch,
          Test : Test_id,
     },
     success: function (data) {
          $('.JHZLNS').html(data);
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! we have a error',
     'error'
     )
     }
     });
    }else{
        Swal.fire({position:"top-end",icon:"error",title:"Sorry, you need to enter the batch. ",showConfirmButton:!1,timer:1500})    
    }

}

/*
setInterval(() => {
     var TestDev =  $('#Test_device').children("option:selected").val();
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Results/Batch_Counter',
     data: {
          Device : TestDev,
     },
     success: function (data) {
          $('.COUNTER_USED').html(data);
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! we have a error',
     'error'
     )
     }
     });  
}, 1000);*/

 $(document).ready(function(){

    $("#SelectFromClass").change(function(){
     var selectedclass = $(this).children("option:selected").val();
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Schools/ListOfStudentByClassCovid',
          data: {
            NumberOfClass : selectedclass,    
          },
          beforeSend: function() {
          // setting a timeout
          $("#hereGetedStudents").html('Please Wait.....');
          }, 
          success: function (data) {
               $('#hereGetedStudents').html(data);
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
$('input[type="number"]').attr("max","40");
$('input[type="number"]').attr("min","30");
     
</script>
</html>