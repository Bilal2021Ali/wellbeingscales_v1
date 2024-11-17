<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array(); 
     
$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();     
   
$supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`AR_UserType`
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
AND `l2_co_patient`.`Added_By` = '".$sessiondata['admin_id']."'")->result_array();	
	
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" 
	  type="text/css" />
<style>
     .spinner-border{
          margin: auto !important;
     } 
     #SetList{
          padding: 10px;
     }
</style>
        <!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" 
type="text/css" />
<body>
     <div class="main-content">
          <div class="page-content">
			  <div class="row">
				<div class="col-12">
    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
						           إضافة درجات الحرارة إلى المستخدمين في نظام      <?php echo $sessiondata['f_name'] ?>
							</h4>
				</div>
			  </div>
			  
               <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                         <div class="card-body">
                         <label>إختر نوع المستخدمين</label>
                         <select class="custom-select" id="Prefix" name="Prefix">
							  <option>قائمة</option>
                              <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
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
										<h4 class="card-title mb-4"> الرجاء إختيار نوع المستخدم </h4>
								   </div>
							  </div>
						 </div>
						 <!--end card-->
					</div>
                    <div class="col-lg-12">
                         <div class="card" id="SetList">
                              <h4>من فضلك إختر نوع مستخدم</h4>
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
<script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script>
$("table").DataTable();     
     
 $(document).ready(function(){
    $("#Prefix").change(function(){
     var selected = $(this).children("option:selected").val();
     if(selected !== ""){
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Results/SelectByPrefix_co',
     data: {
          Pref:selected,
     },
     beforeSend: function() {
        // setting a timeout
     $('#SetList').html('<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">الرجاء الإنتظار</span></div>');
     },
     success: function (data) {
         $('#SetList').html(data);
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'نعتذر لدينا مشكلة',
     'error'
     )
     }
     });
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>AR/Company_Departments/ChartTempOfUsers',
     data: {
       UserType : selected,    
     },
     beforeSend: function() {
     // setting a timeout
     $("#hereGetedUsers").html('جاري التحميل');
     }, 
     success: function (data) {
          $('#hereGetedUsers').html("");
          $('#hereGetedUsers').html(data);
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'نعتذر لدينا مشكلة',
     'error'
     )
     }
     });
		 
     }else{
         $('#SetList').html("إختر نوع المستخدم من فضلك");
     }    
    });
      
});  
    
</script>

</html>