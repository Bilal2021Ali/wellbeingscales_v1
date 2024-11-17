<!doctype html>
<html>
<head>
<meta charset="utf-8">
     <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
</head>

<body>
<div class="main-content">     

     <div class="page-content"> 
     				<div class="col-12">
    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
						           الملف الشخصي -       <?php echo $sessiondata['f_name'] ?>
							</h4>
				</div>
          <div class="container-fluid">
 <div class="card">
                                        <a class="text-dark">
                                        
                                            <div class="p-4">
                                                <div class="media align-items-center">
                                                    <div class="mr-3">
                                                        <i class="uil uil-receipt text-primary h2"></i>
                                                    </div>
                                                    
                                                    <div class="media-body overflow-hidden">
                                                        <h5 class="font-size-16 mb-1"><?php echo $sessiondata['f_name'] ?></h5>
                                                        <p class="text-muted text-truncate mb-0" id="StatusBox">تعديل المعلومات</p>
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
                                                                    <label for="billing-name">الإسم بالعربي</label>
                                                                    <input type="text" class="form-control"
																    placeholder="الإسم بالعربي"
                                                                    value="<?php echo $data['AR_Title']; ?>" name="AR_Title">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name">الإسم بالإنجليزي</label>
                                                                    <input type="text" class="form-control" 
																	placeholder="الإسم بالإنجليزي"
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
                                                                    <input type="text" class="form-control" placeholder="إسم المستخدم لا يمكن تغييره" value="<?php echo $data['Username'] ?>" 
																    data-toggle="tooltip" data-placement="top" title="" 
																    data-original-title=" نعتذر لايمكن تغيير إسم المستخدم " readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-0">
                                                                    <label for="zip-code">المدير</label>
                                                                    <input type="text" class="form-control" name="Manager" placeholder="المدير" value="<?php echo $data['Manager']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <input type="hidden" name="Send" value="Send">  
                                    <div class="row my-4">
                                    <div class="col">
                                        <a href="<?php echo base_url(); ?>AR/Company" class="btn btn-link text-muted">
                                            <i class="uil uil-arrow-left mr-1"></i> إلغاء </a>
                                    </div> <!-- end col -->
                                    <div class="col">
                                        <div class="text-sm-right mt-2 mt-sm-0">
               <a href="<?php echo base_url() ?>AR/users/MyProfile"><button class="btn" name="Send" type="button">
                    <i class="uil uil-user mr-1"></i>المزيد من الخيارات</button></a>
               <button class="btn btn-success" name="Send" type="Submit">
                    <i class="uil uil-save mr-1"></i> إحفظ </button>
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
          url: '<?php echo base_url(); ?>AR/Company/UpdateMinstry_profile',
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