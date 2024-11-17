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
	
	.uil-trash {
		cursor: pointer;
		color: #C02326;
	}	
     
</style>

<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<?php

$supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`AR_UserType`
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
AND `l2_co_patient`.`Added_By` = '".$sessiondata['admin_id']."'")->result_array();
	
?>
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     
<body class="light menu_light logo-white theme-white">
               <section class="content">
  <div class="main-content">
     <div class="page-content">
               
<div class="container-fluid" style="overflow: auto;">
 <div class="page-title-right">
       <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
						           قائمة مستخدمي النظام حسب النوع -    <?php echo $sessiondata['f_name'] ?>
							</h4>
 </div>
 <div class="row">
<div class="col-xl-12">
     <div class="card">
<div class="card-body">
     <label for="SelectFromClass">إختر نوع المستخدمين</label>
     <select name="UserType" class="form-control" id="UserType">
          <option value="">إختر النوع</option>
      <?php foreach($supported_types as $pref): ?>
        <option value="<?php echo $pref['UserType']; ?>">
        <?php echo $pref['AR_UserType']; ?>
       </option>
        <?php endforeach ?>
     </select>
</div>     
</div>     
 </div>   
<div class="col-xl-12">
     <div class="card">
          <div class="card-body">
               <div id="hereGetedUsers">
                    <h4 class="card-title mb-4">إختر نوع المستخدمين</h4>
               </div>
          </div>
     </div>
     <!--end card-->
</div>
</div>     
<div class="" >   
<div class="card">
     <div class="card-body" style="overflow: auto;">
<table class="table" id="table">
     <thead>
          <tr>
               <th> # </th>
               <th> الصورة </th>
               <th> الإسم </th>
               <th> رقم التعريف الوطني </th>
               <th> الجنسية </th>
               <th> نوع المستخدم </th>
               <th> تعديل </th>
          </tr>
     </thead>
     <tbody>
    <?php 
	$sn = 0;
	foreach($listofaStaffs as $admin){ 
	$sn++;	 
	?>
			  <tr id="User_<?php echo $admin['Id'] ?>">
				   <th scope="row"><?php echo $sn;?></th>
				   <td>
					  <?php  if(empty($admin['Link'])){  ?> 
					<img src="https://ui-avatars.com/api/?name=<?php echo $admin['F_name_EN'].'+'.$admin['L_name_EN'] ?>&background=random"
					alt="" class="avatar-xs rounded-circle">
					   <?php  }else{  ?>
					<img src="<?php echo base_url() ?>uploads/co_avatars/<?php  echo $admin['Link']  ?>"
					alt="<?php echo $admin['F_name_EN'].' '.$admin['L_name_EN'] ?>" class="avatar-xs rounded-circle">
					   <?php  } ?>
				   </td>
				   <td><?php echo $admin['F_name_AR'].' '.$admin['L_name_AR'];?></td>
				   <td><?php echo $admin['National_Id'];?></td>
				   <td><?php echo $admin['Nationality'];?></td>
				   <?php $userTranslate = $this->db->query("SELECT `AR_UserType` FROM `r_usertype` 
				   WHERE UserType = '".$admin['UserType']."' ")->result_array(); ?>
				   <?php if(!empty($userTranslate)){ ?>
				   <td><?php echo $userTranslate[0]['AR_UserType']; ?></td>
				   <?php }else{ ?>
				   <td>  غير معروف </td>
				   <?php } ?>
				   <td>
				   <a href="<?php echo base_url() ?>AR/Company_Departments/UpdatePatientData/<?php echo $admin['User_Id']; ?>">
				   <i class="uil-pen" style="font-size: 25px;" title="تعديل"></i>
				   </a>
				   <a href="<?php echo base_url() ?>AR/Company_Departments/UpdatePatientData/<?php echo $admin['User_Id']; ?>">
				   <i class="mdi mdi-card-bulleted" style="font-size: 25px;" title="تعديل"></i>
				   </a>
           <a href="<?php echo base_url(); ?>AR/Company_Departments/user_permissions/<?php echo $admin['User_Id']; ?>">
						   <i class="uil uil-keyhole-circle" style="font-size: 25px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="الصلاحيات"></i>
						</a>
					<i class="uil-trash" style="font-size: 25px;"
					onClick="DeleteUser(<?php echo $admin['User_Id'] ?>,'<?php echo $admin['F_name_AR'].' '.$admin['L_name_AR'];?>','<?php echo $admin['National_Id']  ?>','<?php echo $admin['UserType'] ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ></i>
				   </td>
			  </tr>
          <?php  } ?>

     </tbody>
</table>
     </div>
</div>  
</div> 
     
</table>
</div>
     </div>
          </div>  
                    </div>

               </section>
<script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
     
  var table_st = $('#table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis'],
  });
  table_st.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
	
$('input[type="checkbox"]').each(function(){
$(this).change(function(){
 var theAdminId = $(this).attr('theAdminId');
 console.log(theAdminId);
 console.log(this.checked);    
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Company_Departments/changeSchoolstatus',
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
     
$("#UserType").change(function(){
var selectedclass = $(this).children("option:selected").val();
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Company_Departments/ChartTempOfUsers',
     data: {
       UserType : selectedclass,    
     },
     beforeSend: function() {
     // setting a timeout
     $("#hereGetedUsers").html('Please Wait.....');
     }, 
     success: function (data) {
          $('#hereGetedUsers').html("");
          $('#hereGetedUsers').html(data);
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
     
function DeleteUser(id,name,national_id,usertype){
Swal.fire({
  title:  " هل متأكد من حذف "+name ,
  showCancelButton: true,
  confirmButtonText: `نعم`,
  cancelButtonText: `إلغاء`,
  icon: 'warning',     
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Company_Departments/DeleteUser',
     data: {
      userid: id,
      national_id: national_id,
      user_type: usertype,
     },
     success: function (data) {
     Swal.fire(
     'success',
     data,
     'success'
     );
     $('#User_'+id).fadeOut();
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! لدينا خطأ',
     'error'
     )
     }
     });
  }
});
}
</script>     
     
</body>

</html>