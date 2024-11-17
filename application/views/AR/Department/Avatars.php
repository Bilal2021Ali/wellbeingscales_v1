<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />

<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array(); 
     
$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();     
         
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" 
rel="stylesheet" type="text/css" />
<style>
     .AddedSuccess{
          background-color: #007709;
          text-align: center;
          transition: 0.5s all;
          color: #fff;
          width: 100%;
     }     
</style>
<style>
     .showInPageCard{
          position: fixed;
          right: 10px;
          bottom: 10px;
          z-index: 1000;
          transition: 0.5s all;
     }
     .hide-card{
          bottom: -200px;
     }

     .showInPageCard .card {
               -webkit-box-shadow: 3px 3px 5px 6px #ccc;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
               -moz-box-shadow:    3px 3px 5px 6px #ccc;  /* Firefox 3.5 - 3.6 */
                box-shadow:         3px 3px 5px 6px #ccc;  /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
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
                         <div class="col-xl-12">
							  <label>UserType</label>
							  <select class="custom-select" id="SelectUserType" name="Prefix">
								   <option value="">Select Type...</option>
								   <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
								   <?php foreach($tbl_prefix as $pref): ?>
								   <option value="<?php echo $pref['UserType']; ?>">
							  <?php echo $pref['UserType'].' - '.$pref['Code']; ?>
								   </option>
								   <?php endforeach ?>
							  </select>
                         </div>
                         </div> 
                         </div>
                    </div>
                    </div>

                    <div class="col-lg-12">
                         <div class="card">
                              <div class="card-body table_container">
								  <h4>Please Select User Type</h4>
                              </div>
                         </div>
                    </div>
               </div>
              <div class="col-lg-4 showInPageCard hide-card"  > 
               <div class="card bg-primary text-white-50" style="border: 0px;">
                                    <div class="card-body">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="opacity: 1;color: #fff;">
                                             <span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="mt-0 mb-4 text-white">
											<i class="uil uil-camera mr-3"></i> 
											You Can Open This In New Page !!
										</h5>
                                        <a href="<?php echo base_url(); ?>AR/Schools/SchowStudentsFromClass" id="Students_Link"><button type="button" class="btn btn-light waves-effect"  >Go To The Page !!</button></a> 
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
<!-- Magnific Popup-->
<script src="<?php echo base_url(); ?>assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- lightbox init js-->
<script src="<?php echo base_url(); ?>assets/js/pages/lightbox.init.js"></script>

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

    $('.close').click(function(){
      $('.showInPageCard ').addClass('hide-card');
    });

      $("#SelectUserType").change(function(){
	  console.log('Test');	  
      $('.showInPageCard ').removeClass('hide-card');        
      var selectedclass = $(this).children("option:selected").val();
      var href = "<?php echo base_url() ?>AR/Schools/Class_Avatars/"+selectedclass;
      $('#Students_Link').attr('href',href);
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/Departments/ChangeAvatarList',
          data: {
            usertype : selectedclass,    
          },
          beforeSend: function() {
          // setting a timeout
          $(".table_container").html('Please Wait.....');
          }, 
          success: function (data) {
               $('.table_container').html(data);
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
     
</script>
</html>