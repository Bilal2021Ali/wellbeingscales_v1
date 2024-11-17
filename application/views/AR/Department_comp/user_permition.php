<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
</head>
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
  background-color: #A2A2A2;
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
  background-color: #27AD00;
}

input:focus + .slider {
  box-shadow: 0 0 1px #27AD00;
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
     
</style>
<style>
.card {
    border: 0px;
}
.notfOUND img {
    width: 500px;
    max-width: 100%;
}
.userData, .userData div {
    height: 90%;
}
.__userData .center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: auto;
}
.table-nowrap th, .table-nowrap td {
    border: 0px;
}
	
.td_Icon {
	font-size: 35px;
}

.hr {
	border-top: 1px solid #eee;
}	
	
</style>
<body>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <?php //print_r($user_data);  ?>
      <?php
      if ( !empty( $user_data ) ) {
        $user = $user_data[ 0 ];
        ?>
      <div class="row userData">
        <div class="col-lg-6 justify-content-center">
          <div class="card">
            <div class="card-body __userData">
              <h3>الصلاحيات</h3>
              <div class="center">
                <div class="table-responsive">
                  <table class="table table-nowrap table-centered">
                    <tbody>
                      <tr>
					    <td class="td_Icon">
							<i class="uil uil-cloud-wind"></i>  
					    </td>
                        <td>
							<h5 class="font-size-16 mb-1">جودة البيئة</h5>
							<p class="text-muted mb-2">الوصول للوحة المراقبة الخاصة بجودة البيئة</p>
                        </td>
                        <td>
							<label class="switch">
								<input type="checkbox" Perm="see_air_quality" 
							     class="give_permission" <?php echo $user['see_air_quality'] ? 'checked' : "" ?>>
								<span class="slider round"></span> 
							</label>
					    </td>
                      </tr>
                      <tr class="hr">
					    <td class="td_Icon">
							<i class="uil uil-processor"></i>  
					    </td>
                        <td>
							<h5 class="font-size-16 mb-1">الوسيط الحراري</h5>
							<p class="text-muted mb-2">عرص نتائج أجهزة الوسيط الحراري</p>
                        </td>
                        <td>
							<label class="switch">
								<input type="checkbox" Perm="see_refrigerator" 
							     class="give_permission" <?php echo $user['see_refrigerator'] ? 'checked' : "" ?>>
								<span class="slider round"></span> 
							</label>
					    </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
        $avater = "";
        $avater_get = $this->db->query(" SELECT `Link` FROM `l2_co_avatars`  WHERE `For_User` = '".$user_id."' AND `Type_Of_User` = '".$user['UserType']."' ")->result_array();
        if(!empty($avater_get)){
            $avater = $avater_get[0]['Link'];
        } 
         ?>
        <div class="col-lg-6 justify-content-center">
          <div class="card ">
            <div class="card-body text-center __userData">
              <div class="center">
               <img src="<?php echo base_url()."uploads/avatars/".($avater !== "" ? $avater : 'default_avatar.jpg' ); ?>" alt=""
				class="rounded-circle img-thumbnail avatar-lg">
                <h3 class="text-primary">
                  <?php  echo $user['F_name_AR'].' '.$user['L_name_AR']  ?>
                </h3>
                <h5><?php echo $user['UserType']  ?></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      //End seted user_data 
      } else {
        ?>
      <div class="row notfOUND">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body"> <img src="<?php echo base_url() ?>assets/images/notFoundPermition.svg" alt="">
              <div class="col-lg-12">
                <h3 class="mt-4">لم نجد أي معلومات عن هذا المستخدم</h3>
                <button class="btn btn-primary btn-rounded waves-effect waves-light">رجوع</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php }  ?>
    </div>
  </div>
</div>
</body>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>	
<script>
	
	$('.give_permission').each(function(){
		$(this).change(function(){
			var perm = $(this).attr('Perm');
			var status = $(this).val();
			changeThePermission(perm);
		});
	});
	
	function changeThePermission(perm){
      $.ajax({
          type: 'POST',
		  data : {
			  permType : perm,
			  User : '<?php  echo $user_id  ?>',
		  } ,
          url: '<?php echo base_url(); ?>AR/Company_Departments/Permissions_user_edit',
          success: function (data) {
              if(data == "ok"){
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 300,
                    "timeOut": 3000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "slideDown",
                    "hideMethod": "fadeOut"
                }
                Command: toastr["success"]('تم تحديث الصلاحية بنجاح', "تمت العملية بنجاح")
              }else{
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 300,
                    "timeOut": 3000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "slideDown",
                    "hideMethod": "fadeOut"
                }
                Command: toastr["error"]('نعتذر لدينا مشكلة في معالجة طلبك حاليا', "نعتذر")
              }
		  }
	  });
	}
	
</script>	
</html>