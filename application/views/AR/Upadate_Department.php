<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?php echo base_url()  ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<style>
.slidecontainer {
    width: 100%;/* Width of the outside container */
}
/* The slider itself */
.slider {
    -webkit-appearance: none;
    /* Override default CSS styles */
    appearance: none;
    width: 100%;
    /* Full-width */
    height: 25px;
    /* Specified height */
    background: #d3d3d3;
    /* Grey background */
    outline: none;
    /* Remove outline */
    opacity: 0.7;
    /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s;
    /* 0.2 seconds transition on hover */
    transition: opacity .2s;
}
/* Mouse-over effects */
.slider:hover {
    opacity: 1;/* Fully shown on mouse-over */
}

          /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
          .slider::-webkit-slider-thumb {
-webkit-appearance: none;
               /* Override default look */
               appearance: none;
width: 25px;
               /* Set a specific slider handle width */
               height: 25px;
               /* Slider handle height */
               background: #4CAF50;
               /* Green background */
               cursor: pointer;
/* Cursor on hover */
}
.slider::-moz-range-thumb {
width: 25px;
               /* Set a specific slider handle width */
               height: 25px;
               /* Slider handle height */
               background: #4CAF50;
               /* Green background */
               cursor: pointer;
/* Cursor on hover */
}
</style>
</head>
<body class="light menu_light logo-white theme-white">
<style>
     .Ver i{
     background: #019C00;
     color: #fff;
	text-align: center;
	font-size: 20px;
	display: grid;
	height: 20px;
	border-radius: 13px;
     font-style: normal;
     font-weight: bold;
     line-height: 19px;
     }  
     
.Not i {
	background: #F8002E;
	color: #fff;
	text-align: center;
	font-size: 20px;
	display: grid;
	height: 20px;
	border-radius: 13px;
     font-size: 14px;
     font-style: normal;
     font-weight: bold;
     line-height: 19px;
}     
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
        <div class="card"> <br>
          <div class="row image_container"> <img src="<?php echo base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools"> </div>
          <br>
        </div>
      </div>
    </div>
    <div class="col-xl-12"><br>
      <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 015 - تعديل بيانات القسم </h4>
      <div class="card">
        <div class="card-body">
        <h4 class="card-title" id="title">تعديل بيانات القسم</h4>
        <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert"> <span id="Toast"></span> </div>
        <?php foreach($DepartmentData as $data){ ?>
        <form class="needs-validation InputForm" novalidate=""  style="margin-bottom: 27px;" id="UpdateDepartment">
          <hr style="border-width: 3px;border-top-color: #219824;margin: 30px auto;">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="validationCustom01">اسم القسم بالعربي</label>
                <input type="text" class="form-control" id="validationCustom01" placeholder="اسم القسم بالعربي" name="Arabic_Title" required="" value="<?php echo $data['Dept_Name_AR']; ?>">
                <div class="valid-feedback">جيد </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="validationCustom02">اسم القسم بالانجليزي</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="اسم القسم بالانجليزي" name="English_Title" required="" value="<?php echo $data['Dept_Name_EN']; ?>">
                <div class="valid-feedback">جيد </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="validationCustom01">اسم المدير بالعربي</label>
                <input type="text" class="form-control" id="validationCustom01" placeholder="اسم المدير بالعربي" name="Manager_AR" required="">
                <div class="valid-feedback" value="<?php echo $data['Manager_AR']; ?>"> جيد </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="validationCustom02">اسم المدير بالانجليزي</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="اسم المدير بالانجليزي" name="Manager_EN" value="<?php echo $data['Manager_EN']; ?>" required="">
                <div class="valid-feedback"> جيد </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="validationCustom01">رقم الهاتف</label>
                <input type="text" class="form-control" id="validationCustom01" placeholder="رقم الهاتف"
                                                       value="<?php echo $data['Phone']; ?>" name="Phone" required="">
                <div class="valid-feedback"> جيد </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="validationCustom02">الايميل</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="الايميل" name="Email"
                                                         value="<?php echo $data['Email']; ?>" required="">
                <div class="valid-feedback"> جيد </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
			  <div class="form-group mb-4">					 
              <label class="control-label">Country</label>
              <select class="custom-select" name="Country">
                <?php
                $list = $this->db->query( "SELECT * FROM `r_countries` ORDER BY `name` ASC" )->result_array();
                foreach ( $list as $site ) {
                    ?>
                <option <?= $site['id'] == $data['Country'] ? "selected" : "" ?> value="<?= $site['id'];  ?>">
                <?= $site['name']; ?>
                </option>
                <?php  } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <?php $citiesarray = $this->db->query('SELECT * FROM `r_cities` ORDER BY `Name_EN` ASC')->result_array();     ?>
            <label>اختر المدينة </label>
            <select name="city" class="custom-select">
              <option value="6" class="option" > Doha </option>
              <?php foreach($citiesarray as $cities){ ?>
              <option <?= $data['Citys'] == $cities['Id'] ? "selected" : "" ?> value="<?= $cities['Id']; ?>" class="option">
                  <?= $cities['Name_EN']; ?>
                  </option>   
              <?php } ?>
            </select>
          </div>
          <div class="col-md-6">
            <label>نوع القسم</label>
            <select name="Type" class="custom-select">
              <option value="Government" class="option" >حكومي</option>
              <option value="Private" class="option" >خاص</option>
            </select>
          </div>
          <div class="col-md-6" style="display: grid;align-items: center;">
            <div class="form-group">
              <label>اسم المستخدم</label>
              <input type="text" class="form-control" id="validationCustom02" value="<?php echo $data['Username']; ?>" placeholder="اسم المستخدم" name="Username" required="">
              <div class="valid-feedback"> جيد! </div>
            </div>
          </div>
          </div>
          <input type="hidden" value="<?php echo $data['Id'] ?>" name="ID">
          <button class="btn btn-primary" type="Submit">حفظ التعديلات</button>
          <button type="button" class="btn btn-light" id="back">إلغاء</button>
        </form>
        <?php } ?>
      </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel">العنوان</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
          </div>
          <div class="modal-body">
            <form id="sendToemail">
              <div id="statusbox" class="alert alert-primary" role="alert"> الرجاء كتابة بريد إلكتروني لإرسال المعلومات </div>
              <input type="hidden" class="staticinput" id="getedusername" name="getedusername">
              <div class="form-group">
                <label for="validationCustom02">الإيميل:</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="Email" name="sendToEmail" required="">
                <div class="valid-feedback"> جيد </div>
              </div>
              <button type="Submit" style="width: 100%;" class="btn btn-primary w-lg waves-effect waves-light" id="sendingbutton">إرسال بالايميل</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
  </div>
</div>
<div class="row"> 
  <!-- end card -->
  <div class="col-xl-6"> <br>
    <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 016 - قائمة المدارس </h4>
    <div class="card">
      <div class="card-body" style="height: 600px;">
        <h4 class="card-title">قائمة المدارس </h4>
        <table class="table mb-0">
          <?php
          $listofadmins = $this->db->query( "SELECT * FROM `l1_school` WHERE
     Added_By = '" . $sessiondata[ 'admin_id' ] . "' LIMIT 9 " )->result_array();
          ?>
          <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
            <tr>
              <th>#</th>
              <th style="width: 40%;">اسم المدرسة</th>
              <th>المدينة</th>
              <th>الحالة</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($listofadmins as $adminData){ ?>
            <tr>
              <th scope="row"> <?php echo $adminData['Id'] ?> </th>
              <td><?php echo $adminData['School_Name_AR'] ?></td>
              <td><?php
              $contriesarray = $this->db->query( "SELECT * FROM `r_cities` 
                                                       WHERE id = '" . $adminData[ 'Citys' ] . "' ORDER BY `Name_EN` ASC" )->result_array();
              foreach ( $contriesarray as $contrie ) {
                  echo $contrie[ 'Name_EN' ];
              }
              ?></td>
              <?php
              if ( $adminData[ 'verify' ] == 1 ) {
                  $classname = 'Ver';
              } else {
                  $classname = 'Not';
              }
              ?>
              <td class="<?php echo $classname; ?>"><?php if(!empty($adminData['Manager']) && !empty($adminData['Tel'] )){ ?>
                <i class="uil-check" style="font-size: 20px;"></i>
                <?php }else{ ?>
                <i class="" style="font-size: 14px;">X</i>
                <?php } ?></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- end card --> 
  </div>
  <div class="col-xl-6"> <br>
    <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 017 - قائمة الأقسام </h4>
    <div class="card">
      <div class="card-body" style="height: 600px;">
        <h4 class="card-title"> قائمة الأقسام</h4>
        <table class="table mb-0">
          <?php
          $listofadmins = $this->db->query( "SELECT * FROM `l1_department` WHERE
     Added_By = '" . $sessiondata[ 'admin_id' ] . "' LIMIT 9 " )->result_array();
          ?>
          <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
            <tr>
              <th>#</th>
              <th style="width: 40%;">اسم القسم</th>
              <th>المدينة</th>
              <th>الحالة</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($listofadmins as $adminData){ ?>
            <tr>
              <th scope="row"> <?php echo $adminData['Id'] ?> </th>
              <td><?php echo $adminData['Dept_Name_AR'] ?></td>
              <td><?php
              $contriesarray = $this->db->query( "SELECT * FROM `r_cities` 
                                                       WHERE id = '" . $adminData[ 'Citys' ] . "' ORDER BY `Name_EN` ASC" )->result_array();
              foreach ( $contriesarray as $contrie ) {
                  echo $contrie[ 'Name_EN' ];
              }
              ?></td>
              <?php
              if ( $adminData[ 'verify' ] == 1 ) {
                  $classname = 'Ver';
              } else {
                  $classname = 'Not';
              }
              ?>
              <td class="<?php echo $classname; ?>"><?php if(!empty($adminData['Manager']) && !empty($adminData['Phone'] )){ ?>
                <i class="uil-check" style="font-size: 20px;"></i>
                <?php }else{ ?>
                <i class="" style="font-size: 14px;">X</i>
                <?php } ?></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- end card --> 
  </div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script> 
<script>     
 $('table').DataTable();    
$("#UpdateDepartment").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/DashboardSystem/startUpdatingDepart',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#Toast').css('display','block');
               $('#Toast').html(data);

          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});
    
function sendbyemail(){
   $('.myModal').addClass('myModalActive');  
   $('.outer').css('display','block');  
 }
    
     
$("#sendToemail").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/DashboardSystem/SendUpdatedInfosEmail',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
               $('#statusbox').css('display','block');
               $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>')
               $('#sendingbutton').attr('disabled','disabled');
               $('#sendingbutton').html('أرجو الإنتظار !!');
          },
          success: function (data) {
               $('#statusbox').css('display','block');
               $('#statusbox').html(data);

          },
          ajaxError: function(){
               $('#statusbox').css('background-color','#DB0404');
               $('#statusbox').html("عندنا خطأ !!");
          }
     });
});
     
     
// Cancel *
     
     
$('#back').click(function(){
     location.href = "<?php echo base_url()."AR/DashboardSystem/DepartmentsList"; ?>";
});     
     
function back(){
     location.href = "<?php echo base_url()."AR/DashboardSystem/DepartmentsList"; ?>";
}     
     
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
  output.innerHTML = this.value;
}      
</script> 
<script src="<?php echo base_url(); ?>assets/js/pages/range-sliders.init.js"></script><!-- Ion Range Slider--> 
<script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script> 
<!-- Range slider init js--> 
<script>
     
  $("#clases").ionRangeSlider({
    skin: "round",
    type: "double",
    grid: true,
    min: 0,
    max: 12,
    from: 0,
    to: 12,
    values:['KG1','KG2','1','2','3','4','5','6','7','8','9','10','11','12'] ,       
  });

</script>
</body>
</html>