<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
     <link href="<?php echo base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
     <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
     <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
     <link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
     <link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
     <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

     <style>
          .control {
               margin: 10px auto;
          }

          .control i {
               margin: 4px;
               font-size: 16px;
               margin-left: -1px;
          }


          .bx.bxs-trash-alt {
               font-size: 24px;
               color: #e8625b;
               margin-left: 9px;
               cursor: pointer;
          }
     </style>
     <div class="main-content">
          <div class="page-content">
               <div class="row">
                    <div class="col-xl-12">
                         <div class="">
                              <div class="card-body">
                                   <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                                        الملف الشخصي <?php echo $sessiondata['f_name'] ?>
                                   </h4>
                                   <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                        <span id="Toast"> تحديث الملف الشخصي </span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>

                                   </div>
                                   <div class="control col-md-12">
                                        <button type="button" form_target="Profile" class="btn btn-primary w-md contr_btn">
                                             <i class="uil uil-user"></i>الملف الشخصي
                                        </button>
                                        <!-- <button type="button" form_target="Permitions" class="btn w-md contr_btn">
                                             <i class="uil uil-plus"></i>Permitions
                                        </button> -->
                                   </div>
                                   <div class="col-md-12 formcontainer" id="Profile">
                                        <div class="row card">
                                             <?php
                                             $id = $sessiondata['admin_id'];
                                             $schoolData = $this->db->query("SELECT * FROM l1_co_department 
                                   WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array() ?>
                                             <?php foreach ($schoolData as $data) { ?>
                                                  <form class="needs-validation InputForm card-body" novalidate style="margin-bottom: 27px;" id="UpdateSchool">
                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                      <label for="validationCustom01">الإسم بالعربي</label>
                                                                      <input type="text" class="form-control" id="validationCustom01" placeholder="الإسم بالعربي" value="<?php echo $data['Dept_Name_AR'] ?>" name="Dept_Name_AR" required>
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                      <label for="validationCustom02"> الإسم بالإنجليزي</label>
                                                                      <input type="text" class="form-control" id="validationCustom02" placeholder="الإسم بالإنجليزي" name="Dept_Name_EN" value="<?php echo $data['Dept_Name_EN'] ?>" required>
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                      <label for="validationCustom01">اسم المدير بالعربي</label>
                                                                      <input type="text" class="form-control" id="validationCustom01" placeholder="اسم المدير بالعربي" value="<?php echo $data['Manager_AR'] ?>" name="Manager_AR" required>
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                      <label for="validationCustom02">اسم المدير بالانجليزي</label>
                                                                      <input type="text" class="form-control" id="validationCustom02" placeholder="اسم المدير بالانجليزي" name="Manager_EN" value="<?php echo $data['Manager_EN'] ?>" required>
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                      <label for="validationCustom01">رقم الهاتف</label>
                                                                      <input type="text" class="form-control" id="validationCustom01" placeholder="رقم الهاتف" value="<?php echo $data['Phone'] ?>" name="Phone" required>
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                      <label for="validationCustom02">الإيميل</label>
                                                                      <input type="text" class="form-control" id="validationCustom02" placeholder="الإيميل" name="Email" value="<?php echo $data['Email'] ?>" required="">
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>


                                                       <div class="row">
                                                            <div class="col-md-6">
                                                                 <?php $citiesarray = $this->db->query('SELECT * FROM `r_cities` ORDER BY `Name_EN` ASC')->result_array();     ?>
                                                                 <label> المدينة</label>
                                                                 <select name="city" class="custom-select">
                                                                      <option value="6" class="option"> Doha </option>
                                                                      <?php foreach ($citiesarray as $cities) { ?>
                                                                           <option value="<?php echo $cities['Id']; ?>" class="option">
                                                                                <?php echo $cities['Name_EN']; ?>
                                                                           </option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                 <label>النوع</label>
                                                                 <select name="Type" class="custom-select">
                                                                      <option value="Privat" class="option">خصوصي</option>
                                                                      <option value="Government" class="option">حكومي</option>
                                                                 </select>
                                                            </div>

                                                       </div>
                                                       <div class="row">
                                                            <div class="col-md-6" style="display: grid;align-items: center;">
                                                                 <div class="form-group">
                                                                      <label>إسم المستخدم</label>
                                                                      <input type="text" class="form-control" id="validationCustom02" value="<?php echo $data['Username'] ?>" placeholder=" نعتذر لايمكن تغيير إسم المستخدم " data-toggle="tooltip" data-placement="top" title="" data-original-title=" نعتذر لايمكن تغيير إسم المستخدم " readonly>
                                                                      <div class="valid-feedback">
                                                                           جيد
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-6" style="display: grid;align-items: center;">
                                                                 <div class="form-group">
                                                                      <label> رمز تعريف الفرع : </label>
                                                                      <input type="text" class="form-control" name="DepartmentId" value="<?= $data['DepartmentId'] ?>" placeholder="Department Id">
                                                                      <div class="valid-feedback">
                                                                           looks good
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <input type="hidden" name="ID" value="<?php echo $data['Id']; ?>">
                                                       <button class="btn btn-primary" type="Submit">تعديل</button>
                                                       <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                                  </form>
                                             <?php } ?>
                                        </div>
                                   </div>
                                   <div class="col-md-12 formcontainer" id="Permitions">
                                        <div class="row card">
                                             <form class="needs-validation InputForm card-body" novalidate style="margin-bottom: 27px;" id="addpermition">
                                                  <div class="row">
                                                       <div class="col-lg-12">
                                                            <div class="form-group">
                                                                 <div class="form-group mb-2">
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-12 mb-3">
                                                            <?php
                                                            $Patients = $this->db->query("SELECT * FROM l2_patient
                              WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND Perm = 1 ")->result_array(); ?>
                                                            <div class="row">
                                                                 <div class="col-lg-6">
                                                                      <label for="">Select User</label>
                                                                      <select class="form-control select2" name="selectedPerm">
                                                                           <?php
                                                                           $stafflist = $this->db->query("SELECT * FROM l2_patient
     WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND Perm = 0 ")->result_array(); ?>
                                                                           <?php if (!empty($stafflist)) { ?>
                                                                                <?php foreach ($stafflist as $staff) { ?>
                                                                                     <option value="<?php echo $staff['Id']; ?>">
                                                                                          <?php echo $staff['F_name_EN'] . ' ' . $staff['L_name_EN']; ?></option>
                                                                                <?php } ?>
                                                                           <?php } ?>
                                                                      </select>
                                                                 </div>
                                                                 <div class="col-lg-6">
                                                                      <label> Users Permitions : </label>
                                                                      <table class="table mb-0">
                                                                           <thead>
                                                                                <tr>
                                                                                     <th>#</th>
                                                                                     <th>First Name</th>
                                                                                     <th>Last Name</th>
                                                                                     <th>Action</th>
                                                                                </tr>
                                                                           </thead>
                                                                           <tbody>
                                                                                <?php foreach ($Patients as $patient) { ?>
                                                                                     <tr id="PERM<?php echo $patient['Id']; ?>">
                                                                                          <th scope="row"><?php echo $patient['Id'] ?></th>
                                                                                          <td><?php echo $patient['F_name_EN'] ?></td>
                                                                                          <td><?php echo $patient['L_name_EN'] ?></td>
                                                                                          <td>
                                                                                               <i class="bx bxs-trash-alt delet" theId="<?php echo $patient['Id'];  ?>" TypeOfuser="Stuff"></i>
                                                                                          </td>
                                                                                     </tr>
                                                                                <?php } ?>
                                                                           </tbody>
                                                                      </table>
                                                                 </div>

                                                            </div>
                                                       </div>
                                                  </div>
                                                  <button class="btn btn-primary" type="Submit">Submit form</button>
                                                  <button type="button" class="btn btn-light" id="back">Cancel</button>
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- end card -->
          </div>
     </div>
     </div>
     </div>
     <script src="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/pages/rating-init.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
     <script>
          // ajax sending
          $("#UpdateSchool").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Company_Departments/startUpdatingdepartment',
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

          $("#addpermition").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Departments/startAddPermition',
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


          $('#back').click(function() {
               location.href = "<?php echo base_url() . "index.php / Dashboard "; ?>";
          });

          // Cancel *

          $('#back').click(function() {
               location.href = "<?php echo base_url() . "index.php / Dashboard "; ?>";
          });

          function back() {
               location.href = "<?php echo base_url() . "index.php / Dashboard "; ?>";
          }

          $("input[name='Min'],input[name='Max']").TouchSpin({
               verticalbuttons: true
          }); //Bootstrap-MaxLength



          $(document).ready(function() {

               $("#UnitType").change(function() {
                    var selectedunit = $(this).children("option:selected").val();
                    if (selectedunit == 0) {
                         $('#1').hide();
                         $('#0').show();
                    } else {
                         $('#0').hide();
                         $('#1').show();
                    }

               });


               var prex = '';
               var firstname = '';
               var lastname = '';

               $('#Prefix').change(function() {
                    prex = $(this).children("option:selected").val();
               });

               $('input[name="First_Name_EN"], input[name="Last_Name_EN"]').on("keyup keypress blur", function() {
                    var firstname = $('input[name="First_Name_EN"]').val();
                    var lastname = $('input[name="Last_Name_EN"]').val();
                    var all = prex + " " + firstname + " " + lastname;
                    $('#generatedName').html(all);
               });

          });

          $('.formcontainer').hide();
          $('#Profile').show();

          $('.control button').click(function() {
               $('.control button').removeClass('btn-primary');
               $(this).addClass('btn-primary');
               $('.formcontainer').hide();
               var to = $(this).attr('form_target');
               $('#' + to).show();
          });

          $("#classes").ionRangeSlider({
               skin: "round",
               type: "double",
               grid: true,
               min: 0,
               max: 12,
               from: 0,
               to: 12,
               values: ['KG1', 'KG2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
          });

          $('.delet').each(function() {
               $(this).click(function() {
                    var theId = $(this).attr('theId');
                    var TypeOfuser = $(this).attr('TypeOfuser');
                    console.log(theId);


                    Swal.fire({
                         title: 'Do you want to remove this permission?',
                         showDenyButton: true,
                         showCancelButton: true,
                         confirmButtonText: `نعم, أنا متأكد!`,
                         icon: 'warning',
                    }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                         if (result.isConfirmed) {
                              $.ajax({
                                   type: 'POST',
                                   url: '<?php echo base_url(); ?>AR/Departments/DeletPermition',
                                   data: {
                                        Conid: theId,
                                        TypeOfuser: TypeOfuser,
                                   },
                                   success: function(data) {
                                        Swal.fire(
                                             'success',
                                             data,
                                             'success'
                                        );
                                        $('#PERM' + theId).remove();
                                   },
                                   ajaxError: function() {
                                        Swal.fire(
                                             'error',
                                             'oops!! لدينا خطأ',
                                             'error'
                                        )
                                   }
                              });
                         }
                    })


               });
          });
     </script>

</body>

</html>