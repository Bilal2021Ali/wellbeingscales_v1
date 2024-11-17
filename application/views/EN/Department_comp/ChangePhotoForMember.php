<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />

<style>
     .changePic {
          width: 60px;
          height: 60px;
          background: rgba(0, 0, 0, 0.61);
          color: #fff;
          display: grid;
          position: relative;
          border-radius: 100%;
          font-size: 24px;
          margin: auto;
          text-align: center;
          top: -76px;
          left: 0px;
          padding: 10px;
          transform: scale(0);
          transition: 0.4s all;
     }

     .changePic i {
          margin-top: 8px;
     }

     .transform {
          transform: scale(1);
     }

     .amsify-select-close {
          border: 0px solid #570001;
          background: rgba(208, 0, 3, 1.00);
          color: #fff;
          border-radius: 2px;
          border-bottom: 5px solid #a70303;
     }

     .amsify-select-clear {
          border: 0px solid #004D57;
          background: rgba(0, 178, 208, 1.00);
          color: #fff;
          border-radius: 2px;
          border-bottom: 5px solid #007CCB;
     }
</style>
<style>
     .AddedSuccess {
          background-color: #007709;
          text-align: center;
          transition: 0.5s all;
          color: #fff;
          width: 100%;
     }

     .showInPageCard {
          position: fixed;
          right: 10px;
          bottom: 10px;
          z-index: 1000;
          transition: 0.5s all;
     }

     .hide-card {
          bottom: -200px;
     }

     .showInPageCard .card {
          -webkit-box-shadow: 3px 3px 5px 6px #ccc;
          /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
          -moz-box-shadow: 3px 3px 5px 6px #ccc;
          /* Firefox 3.5 - 3.6 */
          box-shadow: 3px 3px 5px 6px #ccc;
          /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
     }
</style>

<body class="authentication-bg">
     <style>
          .file_upload_list {
               text-align: center;
          }

          .card {
               border: 0px;
          }

          .progress {
               margin-top: 10px;
          }

          h6 {
               padding: 5px;
          }
     </style>
     <style>
          * {
               list-style: none;
               margin: 0;
               padding: 0;
               box-sizing: border-box;
          }

          .title {
               background: #f3f4f8;
               padding: 15px;
               font-size: 18px;
               text-align: center;
               text-transform: uppercase;
               letter-spacing: 3px;
          }

          .file_upload_list li .file_item {
               display: flex;
               border-bottom: 1px solid #f3f4f8;
               padding: 15px 20px;
          }

          .file_item .format {
               background: #8178d3;
               border-radius: 10px;
               width: 45px;
               height: 40px;
               line-height: 40px;
               color: #fff;
               text-align: center;
               font-size: 12px;
               margin-right: 15px;
          }

          .file_item .file_progress {
               width: calc(100% - 60px);
               font-size: 14px;
          }

          .file_item .file_info,
          .file_item .file_size_wrap {
               display: flex;
               align-items: center;
          }

          .file_item .file_info {
               justify-content: space-between;
          }

          .file_item .file_progress .progress {
               width: 100%;
               height: 4px;
               background: #efefef;
               overflow: hidden;
               border-radius: 5px;
               margin-top: 8px;
               position: relative;
          }

          .file_item .file_progress .progress .inner_progress {
               position: absolute;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               background: #58e380;
          }

          .file_item .file_size_wrap .file_size {
               margin-right: 15px;
          }

          .file_item .file_size_wrap .file_close {
               border: 1px solid #8178d3;
               color: #8178d3;
               width: 20px;
               height: 20px;
               line-height: 18px;
               text-align: center;
               border-radius: 50%;
               font-size: 10px;
               font-weight: bold;
               cursor: pointer;
          }

          .file_item .file_size_wrap .file_close:hover {
               background: #8178d3;
               color: #fff;
          }

          .choose_file label {
               display: block;
               border: 2px dashed #8178d3;
               padding: 15px;
               width: calc(100% - 20px);
               margin: 10px;
               text-align: center;
               cursor: pointer;
          }

          .choose_file #choose_file {
               outline: none;
               opacity: 0;
               width: 0;
          }

          .choose_file span {
               font-size: 14px;
               color: #8178d3;
          }

          .choose_file label:hover span {
               text-decoration: underline;
          }
     </style>
     <div class="home-btn d-none d-sm-block">
          <?php
          $link = "";
          if ($sessiondata['type'] == 'super') {
               $link = "Dashboard";
          } elseif ($sessiondata['type'] == 'Ministry' || $sessiondata['type'] == 'Company') {
               $link = "dashboardSystem";
          } elseif ($sessiondata['type'] == 'school') {
               $link = "EN/schools";
          } elseif ($sessiondata['type'] == 'department') {
               $link = "Departments";
          } elseif ($sessiondata['type'] == 'Teacher') {
               $link = "results";
          } elseif ($sessiondata['type'] == 'Staff') {
               $link = "School_Permition";
          } elseif ($sessiondata['type'] == 'Patient') {
               $link = "Departments_Permition";
          } elseif ($sessiondata['type'] == 'Parent') {
               $link = "Results/Select_Child";
          }
          ?>
          <a href="<?php echo base_url() . $link; ?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
     </div>
     <div class="account-pages my-5  pt-sm-5">
          <div class="container">
               <div class="row justify-content-center">

                    <div class="col-md-8 col-lg-6 col-xl-5">
                         <div>
                              <a href="<?php echo base_url(); ?>" class="mb-5 d-block auth-logo">
                                   <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" height="50" class="logo logo-dark">
                                   <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" height="50" class="logo logo-light">
                              </a>
                              <div class="card">
                                   <div class="card-body p-4">
                                        <div class="p-2 mt-4" id="DropZon">
                                             <div class="user-thumb text-center mb-4">
                                                  <?php
                                                  $avatarlist = $this->db->query("SELECT * FROM 
                                                  `l2_co_avatars` WHERE For_User = '" . $user_id . "' 
                                                  AND Type_Of_User = '" . $user_type . "' LIMIT 1 ")->result_array();
                                                  if (!empty($avatarlist)) {
                                                       foreach ($avatarlist as $avatar) {
                                                  ?>
                                                            <img src="<?php echo base_url() . "uploads/co_avatars/" . $avatar['Link']; ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                                            <div class="changePic">
                                                                 <i class="uil uil-camera"></i>
                                                            </div>
                                                       <?php }
                                                  } else { ?>
                                                       <img src="<?php echo base_url() . "uploads/co_avatars/default_avatar.jpg" ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                                       <div class="changePic">
                                                            <i class="uil uil-camera"></i>
                                                       </div>
                                                  <?php } ?>
                                                  <h6 class="text-primary" style="position: relative;top: -33px;" id="Toast"> WELCOME </h6>
                                                  <h5 class="font-size-15 mt-3" style="position: relative;top: -42px;margin: 0px;">
                                                       The allowed files are: (-png.-jpg.-gif)
                                                  </h5>
                                             </div>
                                             <form id="AddPhoto" style="margin-top: -50px;">
                                                  <div class="choose_file">
                                                       <label for="choose_file">
                                                            <input type="file" name="file">
                                                            <span>Choose Image</span>
                                                       </label>
                                                  </div>
                                                  <div class="mt-3 text-right">
                                                       <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit" id="sub"> Update </button>
                                                  </div>
                                                  <input type="hidden" value="<?php echo $user_type; ?>" name="User_Type">
                                                  <input type="hidden" value="<?php echo $user_id ?>" name="user_id">
                                                  <input type="hidden" value="<?php echo $nationalid ?>" name="nationalid">
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- end row -->
          </div>
          <!-- end container -->
     </div>
     <!-- JAVASCRIPT -->
     <?php /* <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script> */ ?>

     <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
     <!-- Plugins js -->
     <script src="<?php echo base_url(); ?>assets/libs/dropzone/min/dropzone.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/app.js"></script>

     <script>
          $("#AddPhoto").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Users/UpladeImgsForMember_Co',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                         $('#Toast').html(data);
                         $('#sub').removeAttr('disabled');
                         $('#sub').html('update');
                    },
                    beforeSend: function() {
                         $('#sub').attr('disabled', '');
                         $('#sub').html('Please wait...');
                    },
                    ajaxError: function() {
                         $('#Toast').css('background-color', '#DB0404');
                         $('#Toast').html("Ooops! Error was found.");
                    }
               });
          });
     </script>
</body>