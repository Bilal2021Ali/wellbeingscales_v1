<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
     <link href="<?php echo base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
     <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
     <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
     <link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css"/>
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
     <link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

</head>
<style>
     .select2-container--default .select2-selection--single {
          height: 37px;
          padding-top: 3px;
     }    
     .select2-container--default .select2-selection--single .select2-selection__arrow{
              height: 35px;
              width: 31px;
     }
</style>
     <div class="outer"></div>
     <style>
          .control {
               margin: 10px auto;
          }
          
          .control i {
               margin: 4px;
               font-size: 16px;
               margin-left: -1px;
          }
     </style>
     <div class="main-content">
          <div class="page-content">
               <div class="row">
                    <div class="col-xl-12">
                         <div class="">
                              <div class="card-body">
                                   <h4 class="card-title" style="background: #B2F306;padding: 10px;color: #1E1E1E;border-radius: 4px;">Update</h4>
                                   <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                        <span id="Toast">Please Update Your Information</span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                </button>
                                   
                                   </div>
                                   <div class="col-md-12 formcontainer" id="staff">
                                        <div class="row">
                                             <?php foreach($StaffData as $stuffdata){ ?>
                                             <form class="needs-validation InputForm col-md-12" novalidate="" style="margin-bottom: 27px;" id="UpdateMemberData">
                                                  <div class="card">
                                                       <div class="card-body">
                                                            <div class="row">
                                                                 <div class="col-md-2" style="margin-bottom: 11px;">
                                                                      <label>UserType</label>
                                                                      <select class="custom-select" id="Prefix" name="Prefix">
                                                                           <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
                                                                           <?php foreach($tbl_prefix as $pref): ?>
                                                                           <option value="<?php echo $pref['UserType']; ?>">
                                                                      <?php echo $pref['UserType'].' - '.$pref['Code']; ?>
                                                                           </option>
                                                                           <?php endforeach ?>
                                                                      </select>
                                                                 </div>
                                                                 <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                                                      <h3 style="margin-top: 30px;color: #5b73e8;" id="generatedName"></h3>
                                                                 </div>
                                                            </div>
                                                            <div class="row" style="padding: 0px;">
                                                                 <div class="col-sm-4">
                                                                      <div class="form-group">
                                                                           <label for="validationCustom02"> First Name EN </label>
                                                                           <input type="text" class="form-control" id="validationCustom02" placeholder="First Name EN" name="First_Name_EN" required=""
                                                                           value="<?php echo $stuffdata['F_name_EN'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-sm-4">
                                                                      <div class="form-group">
                                                                           <label for="validationCustom01">Middle Name EN</label>
                                                                           <input type="text" class="form-control" id="validationCustom01" placeholder="Middle Name EN" name="Middle_Name_EN" required="" 
                                                                           value="<?php echo $stuffdata['M_name_EN'] ?>">
                                                                           <div class="valid-feedback" 
                                                                           >
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-sm-4">
                                                                      <div class="form-group">
                                                                           <label for="validationCustom01">Last Name EN</label>
                                                                           <input type="text" class="form-control" id="validationCustom01" placeholder="Last Name EN" name="Last_Name_EN" required=""
                                                                           value="<?php echo $stuffdata['L_name_EN'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="row">
                                                                 <div class="col-sm-4">
                                                                      <div class="form-group">
                                                                           <label for="validationCustom02">  First Name AR </label>
                                                                           <input type="text" class="form-control" id="validationCustom02" placeholder="First Name AR" name="First_Name_AR" required="" 
                                                                           value="<?php echo $stuffdata['F_name_AR'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-sm-4">
                                                                      <div class="form-group">
                                                                           <label for="validationCustom01">Middle Name AR</label>
                                                                           <input type="text" class="form-control" id="validationCustom01" placeholder="Middle Name AR" name="Middle_Name_AR" required="" 
                                                                           value="<?php echo $stuffdata['M_name_AR'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-sm-4">
                                                                      <div class="form-group">
                                                                           <label for="validationCustom01">Last Name AR</label>
                                                                           <input type="text" class="form-control" id="validationCustom01" placeholder="Last Name AR" name="Last_Name_AR" required="" 
                                                                           value="<?php echo $stuffdata['L_name_AR'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="card">
                                                       <div class="card-body">
                                                            <div class="row">

                                                                 <div class="col-lg-4">
                                                                      <div class="form-group">
                                                                           <label> Date of Birth </label>
                                                                           <div class="input-group">
                                                                                <input type="text" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd-m-yyyy" name="DOP" value="<?php echo $stuffdata['DOP'] ?>">
                                                                                <div class="input-group-append">
                                                                                     <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                                </div>
                                                                           </div>
                                                                           <!-- input-group -->
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-lg-4">
                                                                      <div class="form-group">
                                                                           <label>Phone</label>
                                                                           <div class="input-group">
                                                                 <input type="tel" class="form-control" required placeholder="Phone" name="Phone" value="<?php echo $stuffdata['Phone'] ?>">
                                                                           </div>
                                                                           <!-- input-group -->
                                                                      </div>
                                                                 </div>

                                                                 <div class="col-md-4">
                                                                      <label>Gender</label>
                                                                      <select class="custom-select" name="Gender">
                                                                           <option value="1">Male</option>
                                                                           <option value="0">Female</option>
                                                                      </select>
                                                                 </div>

                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="card">
                                                       <div class="card-body">

                                                            <div class="row">
                                                                 <div class="col-md-6" style="margin-bottom: 11px;">
                                                                      <div class="form-group">
                                                                           <label>National ID</label>
                                                                           <input type="text" class="form-control" id="validationCustom02" placeholder="National Id" name="N_Id" required="" value="<?php echo $stuffdata['National_Id'] ?>" >
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-md-6" style="margin-bottom: 11px;">
                                                                      <div class="form-group">

                                                                           <label>Nationality</label>
                                                                           <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array();   ?>
                                                                           <select class="custom-select" name="Nationality">
                                                                                <option value="Qatar"> Qatar </option>
                                                                                <?php foreach($contriesarray as $contries){ ?>
                                                                                <option value="<?php echo $contries['name']; ?>" class="option">
                                                                                     <?php echo $contries['name']; ?>
                                                                                </option>
                                                                                <?php } ?>
                                                                           </select>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-md-6" style="margin-bottom: 11px;">
                                                                      <div class="form-group">
                                                                           <label> Position </label>
                                                                           <input type="text" class="form-control" id="validationCustom02" placeholder="Position" name="Position" required=""  value="<?php echo $stuffdata['Position'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="col-md-6" style="margin-bottom: 11px;">
                                                                      <div class="form-group">
                                                                           <label> Email </label>
                                                                           <input type="email" class="form-control" id="validationCustom02" placeholder="Email" name="Email" required="" value="<?php echo $stuffdata['Email'] ?>">
                                                                           <div class="valid-feedback">
                                                                                Looks good!
                                                                           </div>
                                                                      </div>
                                                                 </div>
                         <input type="hidden" name="old_NID" value="<?php  echo $stuffdata['National_Id'];  ?>">     
                         <input type="hidden" name="ID" value="<?php  echo $stuffdata['Id'];  ?>">     
                                                            </div>
                                                       </div>
                                                  </div>
                                        </div>

                                        <div style="margin-top: 10px;">
                                             <button class="btn btn-primary" id="staffsub" type="Submit">Submit form</button>
                                             <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </div>
                                                                           </form>
                                             <?php } ?>

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
     <script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
     <script>
          // ajax sending
          $( "#UpdateMemberData" ).on( 'submit', function ( e ) {
               e.preventDefault();
               $.ajax( {
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Departments/UpdatePatient',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function ( data ) {
                         $( '#Toast' ).html( data );
                         $( '#staffsub' ).removeAttr('disabled');
                         $( '#staffsub' ).html('Submit !');
                    },
                    beforeSend : function(){
                         $( '#staffsub' ).attr('disabled','');
                         $( '#staffsub' ).html('Please wait.');
                    },
                    ajaxError: function () {
                         $( '.alert.alert-info' ).css( 'background-color', '#DB0404' );
                         $( '.alert.alert-info' ).html( "Ooops! Error was found." );
                    }
               } );
          } );
          
          $( '#back' ).click( function () {
               location.href = "<?php echo base_url()."index.php / Dashboard "; ?>";
          } );

          // Cancel *

          $( '#back' ).click( function () {
               location.href = "<?php echo base_url()."index.php / Dashboard "; ?>";
          } );

          function back() {
               location.href = "<?php echo base_url()."index.php / Dashboard "; ?>";
          }

          $( "input[name='Min'],input[name='Max']" ).TouchSpin( {
               verticalbuttons: true
          } ); //Bootstrap-MaxLength



          $( document ).ready( function () {

               $( "#UnitType" ).change( function () {
                    var selectedunit = $( this ).children( "option:selected" ).val();
                    if ( selectedunit == 0 ) {
                         $( '#1' ).hide();
                         $( '#0' ).show();
                    } else {
                         $( '#0' ).hide();
                         $( '#1' ).show();
                    }

               } );


               var prex = '';
               var firstname = '';
               var lastname = '';

               $( '#Prefix' ).change( function () {
                    prex = $( this ).children( "option:selected" ).val();
               } );

               $( 'input[name="First_Name_EN"], input[name="Last_Name_EN"]' ).on( "keyup keypress blur", function () {
                    var firstname = $( 'input[name="First_Name_EN"]' ).val();
                    var lastname = $( 'input[name="Last_Name_EN"]' ).val();
                    var all = prex + " " + firstname + " " + lastname;
                    $( '#generatedName' ).html( all );
               } );

          } );

        $("#classes").ionRangeSlider({
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