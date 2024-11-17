<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
     <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
</head>

<body>
<style>
	
		       	 
	   .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px; 
		} 
		  
     </style>		
	
<div class="main-content">     
     <div class="page-content"> 
	 	 			<div class="row">
					<div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div>
          <div class="container-fluid"><br>
		   <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> MOE 008 - بيانات النظام التعليمي</h4>
 <div class="card">
                                        <a class="text-dark">
                                            <div class="p-4">
                                                <div class="media align-items-center">
                                                    <div class="mr-3">
                                                        <i class="uil uil-receipt text-primary h2"></i>
                                                    </div>
                                                    <div class="media-body overflow-hidden">
                                                        <h5 class="font-size-16 mb-1">المستوى الرئيسي للنظام التعليمي</h5>
                                                        <p class="text-muted text-truncate mb-0" id="StatusBox">تعديل بيانات النظام التعليمي</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                              <?php
                              $Id = $sessiondata['admin_id'];
                              $profileData = $this->db->query("SELECT * FROM l0_organization WHERE Id = '".$Id."'")->result_array();
                              foreach($profileData as $data){
                              ?>
                                        <div class="collapse show">
                                            <div class="p-4 border-top">
                                                <form id="Minstry_profile">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name">العنوان بالعربية</label>
                                                                    <input type="text" class="form-control" placeholder="العنوان بالعربية"
                                                                    value="<?php echo $data['AR_Title']; ?>" name="AR_Title">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name">العنوان بالإنجليزية</label>
                                                                    <input type="text" class="form-control" placeholder="العنوان بالإنجليزية"
                                                                    value="<?php echo $data['EN_Title']; ?>" name="EN_Title">
                                                                </div>
                                                            </div>
                                                             
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-phone">رقم الهاتف</label>
                                                                    <input type="text" class="form-control" placeholder="رقم الهاتف" name="Phone"
                                                                    value="<?php echo $data['Tel']; ?>" >
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4 mb-lg-0">
                                                                    <label for="billing-city">إسم المستخدم</label>
                                                                    <input type="text" class="form-control" placeholder="إسم المستخدم" value="<?php echo $data['Username'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-0">
                                                                    <label for="zip-code">اسم المدير بالانجليزي</label>
                                                                    <input type="text" class="form-control"
																    placeholder="المدير" name="Manager" 
																    value="<?php echo $data['Manager']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <input type="hidden" name="Send" value="Send">  
                                    <div class="row my-4">
                                    <div class="col">
                                        <a href="<?php echo base_url(); ?>AR/DashboardSystem" class="btn btn-link text-muted">
                                            <i class="uil uil-arrow-left mr-1"></i> إلغاء </a>
                                    </div> <!-- end col -->
                                    <div class="col">
                                        <div class="text-sm-right mt-2 mt-sm-0">
               <a href="<?php echo base_url() ?>AR/users/MyProfile"><button class="btn" name="Send" type="button">
                    <i class="uil uil-user mr-1"></i> المزيد من الخيارات  </button></a>
               <button class="btn btn-success" name="Send" type="Submit">
                    <i class="uil uil-save mr-1"></i> حفظ </button>
                                        </div>
                                    </div> <!-- end col -->
                                </div>            
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                               <?php } ?>
          </div> 
          </div> 
     </div> 
</div>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
</body>
     
<script>
               
$("#Minstry_profile").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/DashboardSystem/UpdateMinstry_profile',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#StatusBox').html(data);

          },
          ajaxError: function(){
               $('#StatusBox').css('background-color','#B40000');
               $('#StatusBox').html("Ooops! Error was found.");
          }
     });
});
</script>    
</html>