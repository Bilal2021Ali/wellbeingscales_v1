<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array(); 
     
$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();     
         
?>
<body>
     <div class="main-content">
          <div class="page-content">
               <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                         <div class="card-body">
                              <label>Select The Type :</label>
                           <select class="custom-select" id="List">
                                <option value="Staffs">Staff List</option>
                                <option value="Techers">Staff Techers</option>
                           </select>
                         </div>
                    </div>
                    </div>
                    <div class="col-lg-12" id="Staffs">
                         <div class="card">
                              <div class="card-body">
                                   <div class="card-title text-center">List of Staff:
                                        <hr>
                                   </div>
                                   <table class="table">
                                        <thead>
                                             <tr>
                                                  <th> # </th>
                                                  <th> Name </th>
                                                  <th> National ID </th>
                                                  <th> Enter </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach($listofaStaffs as $admin){ ?>
                                             <tr id="TrStafffId<?php echo $admin['Id']; ?>">
                                                  <th scope="row">
                                                       <?php echo $admin['Id'];?>
                                                  </th>
                                                  <td>
                                   <?php echo $admin['F_name_AR'].' '.$admin['M_name_AR'].' '.$admin['L_name_AR'];?>
                                                  </td>
                                                  <td><?php echo $admin['National_Id'];?></td>
                                                  <td>
                                                  <form class="AddResultStaff">   
                                                  <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37" >   
                                                  <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId" >     
                                                  </form>     
                                                  </td>
                                             </tr>
                                             <?php  } ?>

                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
                    <div class="col-lg-12" id="Techers">
                         <div class="card">
                              <div class="card-body">
                                   <div class="card-title text-center">The List If Techers :
                                        <hr>
                                   </div>
                                   <table class="table">
                                        <thead>
                                             <tr>
                                                  <th> # </th>
                                                  <th> Name </th>
                                                  <th> National ID </th>
                                                  <th> Enter </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach($listofteachers as $admin){ ?>
                                             <tr id="TrStafffId<?php echo $admin['Id']; ?>">
                                                  <th scope="row">
                                                       <?php echo $admin['Id'];?>
                                                  </th>
                                                  <td>
                                   <?php echo $admin['F_name_AR'].' '.$admin['M_name_AR'].' '.$admin['L_name_AR'];?>
                                                  </td>
                                                  <td><?php echo $admin['National_Id'];?></td>
                                                  <td>
                                                  <form class="AddResultTeachers">   
                                                  <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37" >   
                                                  <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId" >     
                                                  </form>     
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
<script>
     
$(".AddResultStaff").on('submit', function (e) {
e.preventDefault();
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Results/AddResultForStaff',
     data: new FormData(this),
     contentType: false,
     cache: false,
     processData: false,
     success: function (data) {
          $('.JHZLNS').html(data);
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
     
$(".AddResultTeachers").on('submit', function (e) {
e.preventDefault();
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Results/AddResultForTeacher',
     data: new FormData(this),
     contentType: false,
     cache: false,
     processData: false,
     success: function (data) {
          $('.JHZLNS').html(data);
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

$("#Staffs,#Techers").slideUp();
     
 $(document).ready(function(){
    $("#List").change(function(){
     var selectedunit = $(this).children("option:selected").val();
         if(selectedunit == "Staffs"){
              $('#Staffs').slideDown();
              $('#Techers').slideUp();
         }else{
              $('#Techers').slideDown();
              $('#Staffs').slideUp();
         }
         
    });

});  
    
</script>

</html>