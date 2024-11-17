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
			  <h4 class="card-title" style="background: #07bff3;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 040 تعديل بيانات الموقع </h4>
               <div class="row">
				   
                    <div class="col-xl-12">
                         <div class="">
                              <div class="card-body">
                                   <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                        <span id="Toast">يرجى تحديث المعلومات الخاصة بالموقع</span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                </button>
                                   
                                   </div>
                                   <div class="col-md-12 formcontainer" id="staff">
                                        <div class="row">
                                             <?php foreach($sitesdata as $siteData){ ?>
                                             <form class="needs-validation InputForm col-md-12" novalidate="" style="margin-bottom: 27px;" id="UpdateSiteData">
                                                  <div class="card" style="width: 100%;">
                                                       <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                        <label class="control-label">نوع الموقع |  غير مسموح بالتعديل</label> 
               <?php 
               $Site_name = $siteData['Site_Code'];                                
               $sitecodes = $this->db->query("SELECT * FROM `r_sites` WHERE Site_Name = '".$Site_name."'
               ORDER BY `Site_Code` DESC LIMIT 1")->result_array(); 
               foreach($sitecodes as $code){ ?>
              <input type="text" value="<?php echo $code['Site_Code']." - ".$Site_name; ?>" readonly class="form-control" >              
               <?php   }  ?>
                                                             </div>
                                                            </div>
                                                             
                                                            <div class="col-lg-6">
                                                                 
                                                                <div class="form-group mb-4">
                                                                    <label for="billing-name">وصف الموقع</label>
                                                                    <input type="text" class="form-control" placeholder="Description" name="Description" 
                                                                    value="<?php echo $siteData['Description']; ?> ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                       </div>
                                                  </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $siteData['Id']; ?>" name="AZF_UFGFDX">
                                        <div style="margin-top: 10px;">
                                        <button class="btn btn-primary" id="StudentSub" type="Submit">حفظ</button>
                                        <button  type="button" class="btn btn-light" id="back">إلغاء</button>
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
          $( "#UpdateSiteData" ).on( 'submit', function ( e ) {
               e.preventDefault();
               $.ajax( {
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/schools/StartUpdateSite',
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
               location.href = "<?php echo base_url()."AR/schools "; ?>";
          } );

          // Cancel *

          $( '#back' ).click( function () {
               location.href = "<?php echo base_url()."AR/schools "; ?>";
          } );

          function back() {
               location.href = "<?php echo base_url()."AR/schools "; ?>";
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

               $( 'input[name="First_Name_AR"], input[name="Last_Name_AR"]' ).on( "keyup keypress blur", function () {
                    var firstname = $( 'input[name="First_Name_AR"]' ).val();
                    var lastname = $( 'input[name="Last_Name_AR"]' ).val();
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