<!doctype html>
<html lang="en">

<head>
     <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
     <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
     <link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
     <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
     <style>
          .slidecontainer {
               width: 100%;
               /* Width of the outside container */
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
               opacity: 1;
               /* Fully shown on mouse-over */
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
          .Ver i {
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
                         <div class="card">
                              <br>
                              <div class="row image_container">
                                   <img src="<?= base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools">
                              </div>
                              <br>
                         </div>
                    </div>
               </div>
               <div class="row">

                    <div class="col-xl-12">
                         <br>
                         <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 015 - تحديث الملف التعريفي للمدرسة </h4>
                         <div class="card">
                              <div class="card-body">

                                   <h4 class="card-title" id="title">تحديث الملف التعريفي للمدرسة</h4>
                                   <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                        <span id="Toast">تحقق من المعلومات</span>
                                   </div>
                                   <?php foreach ($schoolData as $data) { ?>
                                        <form class="needs-validation InputForm" novalidate="" style="margin-bottom: 27px;" id="UpdateSchool">
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom01">اسم المدرسة بالعربي:</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="اسم المدرسة بالعربي" value="<?= $data['School_Name_AR'] ?>" name="Arabic_Title" required="">
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom02">اسم المدرسة بالانجليزي:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="اسم المدرسة بالانجليزي" name="English_Title" value="<?= $data['School_Name_EN'] ?>" required="">
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom01">اسم المدير بالعربي:</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="اسم المدير بالعربي" value="<?= $data['Manager_AR'] ?>" name="Manager_AR" required="">
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom02">اسم المدير بالانجليزي:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="اسم المدير بالانجليزي" name="Manager_EN" value="<?= $data['Manager_EN'] ?>" required="">
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom01">الهاتف:</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="الهاتف" value="<?= $data['Phone'] ?>" name="Phone" required="">
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label for="validationCustom02">البريد الإلكتروني:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="البريد الإلكتروني" name="Email" value="<?= $data['Email'] ?>" required="">
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group mb-4">
                                                            <label class="control-label">الدولة:</label>
                                                            <select style="width: 100%;display: block;height: 50px;" class="form-control" name=" الدولة بالانجليزي">
                                                                 <?php
                                                                 $corrent = $this->db->query("SELECT `name` FROM `r_countries` 
													WHERE id = '" . $data['Country'] . "' ")->result_array();
                                                                 ?>
                                                                 <option value="<?= $data['Country'] ?>"><?= $corrent[0]['name']; ?></option>
                                                                 <?php
                                                                 $list = $this->db->query("SELECT * FROM `r_countries` 
                                                                      ORDER BY `name` ASC")->result_array();
                                                                 foreach ($list as $site) {
                                                                 ?>
                                                                      <option value="<?= $site['id'];  ?>"> <?= $site['name']; ?> </option>
                                                                 <?php  } ?>
                                                            </select>
                                                       </div>
                                                  </div>

                                                  <div class="col-md-6 cities">
                                                       <label class="control-label">المدينة: </label>
                                                       <select style="width: 100%;display: block;height: 50px;" class="form-control" name="المدينة بالانجليزي">
                                                            <?php
                                                            $ceties = $this->db->query("SELECT * FROM `r_cities`  
                                                            WHERE `Country_Id` = '" . $data['Country'] . "'
                                                            ORDER BY `Name_EN` ASC")->result_array();
                                                            foreach ($ceties as $city) {
                                                            ?>
                                                                 <option <?= $data['Citys'] == $city['Id'] ? "selected" : "" ?> value="<?= $city['Id']; ?>"><?= $city['Name_EN']; ?> </option>
                                                            <?php  } ?>
                                                       </select>
                                                  </div>
                                             </div>

                                             <div class="row">

                                                  <div class="col-md-4">
                                                       <label>نوع المدرسة:</label>
                                                       <select name="Type" class="custom-select">
                                                            <option <?= $data['Type_Of_School'] == "Government" ? 'selected' : '' ?> value="Government" class="option">حكومية</option>
                                                            <option <?= $data['Type_Of_School'] == "Private" ? 'selected' : '' ?> value="Private" class="option">خاصة</option>
                                                            <option <?= $data['Type_Of_School'] == "Community" ? 'selected' : '' ?> value="Community" class="option">مجتمعية</option>
                                                       </select>
                                                  </div>

                                                  <div class="col-md-4">
                                                       <label>صنف المدرسة:</label>
                                                       <select name="School_Gender" class="custom-select">
                                                            <option <?= $data['Gender'] == "Male" ? 'selected' : '' ?> value="Male" class="option">للذكور</option>
                                                            <option <?= $data['Gender'] == "Female" ? 'selected' : '' ?> value="Female" class="option">للإناث</option>
                                                            <option <?= $data['Gender'] == "mix" ? 'selected' : '' ?> value="mix" class="option">للذكور & للإناث</option>
                                                       </select>
                                                  </div>
                                                  <div class="col-md-4" style="display: grid;align-items: center;">
                                                       <div class="form-group">
                                                            <label>اسم المستخدم:</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="لايمكن التعديل هنا" required="" value="<?= $data['Username'] ?>" placeholder="				" data-toggle="tooltip" data-placement="top" title="" data-original-title="We apologize for this inconvenience. Your account has been disabled by the Admin." readonly>
                                                            <div class="valid-feedback">
                                                                 جيد!
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <input type="hidden" name="ID" value="<?= $data['Id']; ?>">
                                             <button class="btn btn-primary" type="Submit">تحديث</button>
                                             <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                        </form>
                                   <?php } ?>
                              </div>
                         </div>
                    </div>
               </div>


               <div class="row">
                    <!-- end card -->
                    <div class="col-xl-6">
                         <br>
                         <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 016 - قائمة المدارس </h4>
                         <div class="card">
                              <div class="card-body" style="height: 600px;">
                                   <h4 class="card-title">آخر المدارس التي تم إضافتها</h4>
                                   <table class="table mb-0">
                                        <?php $listofadmins = $this->db->query("SELECT * FROM `l1_school` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array();
                                        $s_num = 0;
                                        ?>
                                        <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                             <tr>
                                                  <th>#</th>
                                                  <th style="width: 40%;">اسم المدرسة بالعربي</th>
                                                  <th>المدينة</th>
                                                  <th>الحالة</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach ($listofadmins as $adminData) {
                                                  $s_num++;
                                             ?>
                                                  <tr>
                                                       <th scope="row">
                                                            <?= $s_num; ?>
                                                       </th>
                                                       <td>
                                                            <?= $adminData['School_Name_AR'] ?>
                                                       </td>

                                                       <td>
                                                            <?php
                                                            $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                       WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                                            foreach ($contriesarray as $contrie) {
                                                                 echo $contrie['Name_EN'];
                                                            }
                                                            ?>
                                                       </td>
                                                       <?php
                                                       if ($adminData['verify'] == 1) {
                                                            $classname = 'Ver';
                                                       } else {
                                                            $classname = 'Not';
                                                       }
                                                       ?>
                                                       <td class="<?= $classname; ?>">
                                                            <?php if (!empty($adminData['Manager']) && !empty($adminData['Tel'])) { ?>
                                                                 <i class="uil-check" style="font-size: 20px;"></i>
                                                            <?php } else { ?>
                                                                 <i class="" style="font-size: 14px;">X</i>
                                                            <?php } ?>
                                                       </td>
                                                  </tr>
                                             <?php }
                                             ?>
                                        </tbody>
                                   </table>

                              </div>
                         </div>
                         <!-- end card -->
                    </div>

                    <div class="col-xl-6">
                         <br>
                         <h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 017 - قائمة الإدارات </h4>
                         <div class="card">
                              <div class="card-body" style="height: 600px;">
                                   <h4 class="card-title">آخر الإدارات التي تم إضافتها</h4>
                                   <table class="table mb-0">
                                        <?php $listofadmins = $this->db->query("SELECT * FROM `l1_department` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array();
                                        $s_num = 0;
                                        ?>
                                        <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                             <tr>
                                                  <th>#</th>
                                                  <th style="width: 40%;">إسم الإدارة</th>
                                                  <th>المدينة</th>
                                                  <th>الحالة</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach ($listofadmins as $adminData) {
                                                  $s_num++;
                                             ?>
                                                  <tr>
                                                       <th scope="row">
                                                            <?= $s_num; ?>
                                                       </th>
                                                       <td>
                                                            <?= $adminData['Dept_Name_AR'] ?>
                                                       </td>

                                                       <td>
                                                            <?php
                                                            $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                       WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                                            foreach ($contriesarray as $contrie) {
                                                                 echo $contrie['Name_EN'];
                                                            }
                                                            ?>
                                                       </td>
                                                       <?php
                                                       if ($adminData['verify'] == 1) {
                                                            $classname = 'Ver';
                                                       } else {
                                                            $classname = 'Not';
                                                       }
                                                       ?>
                                                       <td class="<?= $classname; ?>">
                                                            <?php if (!empty($adminData['Manager']) && !empty($adminData['Phone'])) { ?>
                                                                 <i class="uil-check" style="font-size: 20px;"></i>
                                                            <?php } else { ?>
                                                                 <i class="" style="font-size: 14px;">X</i>
                                                            <?php } ?>
                                                       </td>
                                                  </tr>
                                             <?php }
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

     <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
     <script>
          $("#UpdateSchool").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>AR/DashboardSystem/startUpdatingSchool',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                         $('#Toast').css('display', 'block');
                         $('#Toast').html(data);

                    },
                    ajaxError: function() {
                         $('.alert.alert-info').css('background-color', '#DB0404');
                         $('.alert.alert-info').html("Ooops! Error was found.");
                    }
               });
          });

          function sendbyemail() {
               $('.myModal').addClass('myModalActive');
               $('.outer').css('display', 'block');
          }


          $("#sendToemail").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>AR/DashboardSystem/SendUpdatedInfosEmail',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                         $('#statusbox').css('display', 'block');
                         $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>')
                         $('#sendingbutton').attr('disabled', 'disabled');
                         $('#sendingbutton').html('please wait !!');
                    },
                    success: function(data) {
                         $('#statusbox').css('display', 'block');
                         $('#statusbox').html(data);

                    },
                    ajaxError: function() {
                         $('#statusbox').css('background-color', '#DB0404');
                         $('#statusbox').html("Ooops! Error was found.");
                    }
               });
          });


          // Cancel *

          $('#back').click(function() {
               location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
          });

          function back() {
               location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
          }

          var slider = document.getElementById("myRange");
          var output = document.getElementById("demo");
          output.innerHTML = slider.value; // Display the default slider value

          // Update the current slider value (each time you drag the slider handle)
          slider.oninput = function() {
               output.innerHTML = this.value;
          }
     </script>
     <script src="<?= base_url(); ?>assets/js/pages/range-sliders.init.js"></script><!-- Ion Range Slider-->
     <script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
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
               values: ['KG1', 'KG2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
          });


          $(document).ready(function() {

               $("#addingType").change(function() {
                    var selectedunit = $(this).children("option:selected").val();
                    if (selectedunit == 'School') {
                         $('#addSchool').show();
                         $('#addDepartment').hide();
                         $('#title').html("Add New School");
                    } else if (selectedunit == 'Department') {
                         $('#addSchool').hide();
                         $('#addDepartment').show();
                         $('#title').html("Add New Department");
                    } else {
                         $('#addSchool').hide();
                         $('#addDepartment').hide();
                         $('#title').html("Add");
                    }

               });

          });

          $('select[name="Country"]').change(function() {
               var countryId = $(this).val();
               $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>AR/Ajax/getThisCountrycities',
                    data: {
                         id: countryId,
                    },
                    beforeSend: function() {
                         $('.cities').html('Please Wait..');
                    },
                    success: function(data) {
                         $('.cities').html(data);
                    },
                    ajaxError: function() {
                         $('.cities').css('background-color', '#B40000');
                         $('.cities').html("Ooops! Error was found.");
                    }
               });
          });
     </script>
</body>

</html>