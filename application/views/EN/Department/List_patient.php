<!doctype html>
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
          background-color: #ccc;
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

     input:checked+.slider {
          background-color: #2196F3;
     }

     input:focus+.slider {
          box-shadow: 0 0 1px #2196F3;
     }

     input:checked+.slider:before {
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

<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body class="light menu_light logo-white theme-white">
     <app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
          <!---->
          <app-main _nghost-pjk-c134="" class="ng-star-inserted">
               <section class="content">

                    <div class="main-content">
                         <div class="page-content">

                              <div class="container-fluid" style="overflow: auto;">
                                   <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                             <li class="breadcrumb-item"><a href="javascript: void(0);">Members</a></li>
                                             <li class="breadcrumb-item active">List</li>
                                        </ol>
                                   </div>
                                   <div class="row">
                                        <div class="col-xl-12">
                                             <div class="card-body">
                                                  <label for="SelectFromClass">Select The User Type :</label>
                                                  <select name="UserType" class="form-control" id="UserType">
                                                       <option value="">Select User type !!</option>
                                                       <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
                                                       <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option value="<?php echo $pref['UserType']; ?>">
                                                                 <?php echo $pref['UserType'] . ' - ' . $pref['Code']; ?>
                                                            </option>
                                                       <?php endforeach ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="col-xl-12">
                                             <div class="card">
                                                  <div class="card-body">
                                                       <div id="hereGetedUsers">
                                                            <h4 class="card-title mb-4"> Select The User Type !!</h4>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!--end card-->
                                        </div>
                                   </div>
                                   <div class="">
                                        <div class="card">
                                             <div class="card-body" style="overflow: auto;">
                                                  <table class="table">
                                                       <thead>
                                                            <tr>
                                                                 <th> # </th>
                                                                 <th> Img </th>
                                                                 <th> Name </th>
                                                                 <th> Username </th>
                                                                 <th> National ID </th>
                                                                 <th> Nationality </th>
                                                                 <th> Edit </th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php foreach ($listofaStaffs as $admin) { ?>
                                                                 <tr>
                                                                      <th scope="row"><?php echo $admin['Id']; ?></th>
                                                                      <td>Img</td>
                                                                      <td><?php echo $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                                                                      <td><?php echo $admin['UserName']; ?></td>
                                                                      <td><?php echo $admin['National_Id']; ?></td>
                                                                      <td><?php echo $admin['Nationality']; ?></td>
                                                                      <td>
                                                                           <a href="<?php echo base_url() ?>EN/Departments/UpdatePatientData/<?php echo $admin['Id']; ?>">
                                                                                <i class="uil-pen" style="font-size: 25px;" title="Edit"></i>
                                                                           </a>
                                                                      </td>
                                                                 </tr>
                                                            <?php  } ?>

                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>

                                   </table>
                              </div>
                         </div>
                    </div>
                    </div>

               </section>
               <!-- Required datatable js -->
               <!-- Responsive examples -->
               <script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
               <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
               <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
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

                    $('input[type="checkbox"]').each(function() {
                         $(this).change(function() {
                              var theAdminId = $(this).attr('theAdminId');
                              console.log(theAdminId);
                              console.log(this.checked);
                              $.ajax({
                                   type: 'POST',
                                   url: '<?php echo base_url(); ?>EN/DashboardSystem/changeSchoolstatus',
                                   data: {
                                        adminid: theAdminId,
                                   },
                                   success: function(data) {
                                        Swal.fire(
                                             'success',
                                             data,
                                             'success'
                                        )
                                   },
                                   ajaxError: function() {
                                        Swal.fire(
                                             'error',
                                             'oops!! we have a error',
                                             'error'
                                        )
                                   }
                              });

                         });
                    });

                    <?php if ($this->session->flashdata('email_sended')) { ?>
                         try {
                              setTimeout(function() {
                                   $('.alert.alert-success').addClass('alert-hide')
                                   $('.container-fluid').css('margin-top', '0px')
                              }, 3000);
                         } catch (err) {

                         }
                    <?php } ?>

                    /*$('.show-details-btn').on('click', function(e) {
                    	e.preventDefault();
                    	$(this).closest('tr').next().toggleClass('open');
                    	$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
                    });
                         */
                    /*
                    var pagenumber = 1;
                    var lhsab = (1-1)*20;
                    $('.serchable').each(function(){
                    var id =  $(this).attr('id');     
                    if(id < lhsab && id > lhsab ){
                         console.log('yes i need to hide my id is = '+id);
                    }else{
                         console.log('natha id = '+id);
                    }
                    }); 
                    */

                    $("#UserType").change(function() {
                         var selectedclass = $(this).children("option:selected").val();
                         $.ajax({
                              type: 'POST',
                              url: '<?php echo base_url(); ?>EN/Departments/ChartTempOfUsers',
                              data: {
                                   UserType: selectedclass,
                              },
                              beforeSend: function() {
                                   // setting a timeout
                                   $("#hereGetedUsers").html('Please Wait.....');
                              },
                              success: function(data) {
                                   $('#hereGetedUsers').html("");
                                   $('#hereGetedUsers').html(data);
                              },
                              ajaxError: function() {
                                   Swal.fire(
                                        'error',
                                        'oops!! we have a error',
                                        'error'
                                   )
                              }
                         });
                    });
               </script>



</body>

</html>