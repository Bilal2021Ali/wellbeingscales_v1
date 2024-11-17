<!doctype html>
<html lang="en">

<head>
     <meta charset="utf-8" />
     <title>Datatables | Minible - Responsive Bootstrap 4 Admin Dashboard</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
     <meta content="Themesbrand" name="author" />
     <!-- App favicon -->
     <link rel="shortcut icon" href="assets/images/favicon.ico">

     <!-- DataTables -->
     <link href="<?php echo base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
     <link href="<?php echo base_url() ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

     <!-- Responsive datatable examples -->
     <link href="<?php echo base_url() ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

     <!-- Bootstrap Css -->
     <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
     <!-- Icons Css -->
     <link href="<?php echo base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
     <!-- App Css-->
     <link href="<?php echo base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
     <link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
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
               background-color: #CB0002;
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
     <style>
          .InfosCards h4,
          .InfosCards p {
               color: #fff;
          }

          .InfosCards .card-body {
               border-radius: 5px;
          }

          .disabled a {
               color: #727272;
               pointer-events: none;
          }
     </style>
</head>


<body>

     <!-- <body data-layout="horizontal" data-topbar="colored"> -->

     <!-- Begin page -->
     <div id="layout-wrapper">
          <!-- ============================================================== -->
          <!-- Start right Content here -->
          <!-- ============================================================== -->
          <div class="main-content">

               <div class="page-content">
                    <h4 class="card-title" style="background: #800080; padding: 10px;color: #ffffff;border-radius: 4px;">SU 003: LIST OF ORGANIZATIONS AND COMPANY SYSTEMS</h4>
                    <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
                         0001: Enable/ Disable (Ministry of Education and Companies) in System<br>
                         0002: Set Permissions for Created Systems<br>
                         0003: Edit (Ministry of Education and Companies) in System<br>
                    </h4>
                    <div class="container-fluid">
                         <div class="row">
                              <div class="col-md-4 col-xl-4 InfosCards">
                                   <div class="card">
                                        <div class="card-body" style="background-color: #567572FF;">
                                             <div class="float-right mt-2">
                                                  <div id="CharTTest1"></div>
                                             </div>
                                             <div>
                                                  <?php
                                                  $allEn = $this->db->query("SELECT * FROM `l0_organization` 
                                             WHERE  `status` = '1' ")->num_rows();
                                                  $allDe = $this->db->query("SELECT * FROM `l0_organization` 
                                             WHERE  `status` = '0' ")->num_rows();
                                                  $all_not_in_qatar = $this->db->query("SELECT * FROM `l0_organization` 
                                             WHERE  `CountryID` != '173' ")->num_rows();
                                                  ?>
                                                  <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $allEn ?></span></h4>
                                                  <p class="mb-0">Total Organizations <br> Enabled</p>
                                             </div>
                                        </div>
                                   </div>
                              </div> <!-- end col-->
                              <div class="col-md-4 col-xl-4 InfosCards">
                                   <div class="card">
                                        <div class="card-body" style="background-color: #964F4CFF;">
                                             <div class="float-right mt-2">
                                                  <div id="CharTTest2"></div>
                                             </div>
                                             <div>
                                                  <h4 class="mb-1 mt-1">
                                                       <span data-plugin="counterup"><?php echo $allDe ?></span>
                                                  </h4>
                                                  <p class="mb-0">Total Organizations<br> Disabled </p>
                                             </div>
                                        </div>
                                   </div>
                              </div> <!-- end col-->
                              <div class="col-md-4 col-xl-4 InfosCards">
                                   <div class="card">
                                        <div class="card-body" style="background-color: #696667FF;">
                                             <div class="float-right mt-2">
                                                  <div id="customers-chart"></div>
                                             </div>
                                             <div>
                                                  <h4 class="mb-1 mt-1">
                                                       <span data-plugin="counterup"><?php echo $all_not_in_qatar ?></span>
                                                  </h4>
                                                  <p class="mb-0">Total Organizations<br> Not in Qatar</p>
                                             </div>
                                        </div>
                                   </div>
                              </div> <!-- end col-->
                         </div> <!-- end row-->
                         <!-- start page title -->
                         <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;">
                              0003: Managing of Organizations<br>
                         </h4>
                         <!-- end page title -->

                         <div class="row">

                              <div class="col-12">

                                   <div class="card">
                                        <div class="card-body">

                                             <h4 class="card-title">LIST OF ORGANIZATIONS </h4>
                                             <div class="table-responsive">
                                             <table id="datatable" class="table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                  <thead>
                                                       <tr>
                                                            <th>#</th>
                                                            <th>Type</th>
                                                            <th>User Name</th>
                                                            <th>Name EN</th>
                                                            <th>Name AR </th>
                                                            <th>Country </th>
                                                            <th>Actions</th>
                                                            <th class="actions">Status</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php foreach ($listofadmins as $admin) {
                                                            if ($admin['Type'] == "Ministry") {
                                                                 $classname = "MinistryCol";
                                                            } else {
                                                                 $classname = "CompanyCol";
                                                            }

                                                            if ($admin['status'] == 1) {
                                                                 $cheked = 'checked';
                                                                 $dis = '';
                                                            } else {
                                                                 $cheked = '';
                                                                 $dis = 'disabled';
                                                            }
                                                       ?>
                                                            <tr class="<?php echo $classname; ?>" id="ad_id<?php echo $admin['Id']  ?>">
                                                                 <th scope="row"><?php echo $admin['Id']; ?></th>
                                                                 <td><?php echo $admin['Type']; ?></td>
                                                                 <td><?php echo $admin['Username']; ?></td>
                                                                 <td><?php echo $admin['EN_Title']; ?></td>
                                                                 <td><?php echo $admin['AR_Title']; ?></td>
                                                                 <td>
                                                                      <?php
                                                                      $contriesarray = $this->db->query("SELECT * FROM `r_countries` 
				   WHERE id = '" . $admin['CountryID'] . "' ORDER BY `name` ASC")->result_array();
                                                                      foreach ($contriesarray as $contrie) {
                                                                           echo $contrie['name'];
                                                                      }
                                                                      ?>
                                                                 </td>
                                                                 <td class="<?php echo $dis;  ?>">
                                                                      <a href="<?php echo base_url() ?>EN/Dashboard/UpdateSystemData/<?php echo $admin['Id']; ?>">
                                                                           <i class="uil-pen" style="font-size: 25px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i>
                                                                      </a>
                                                                      <a href="<?php echo base_url() ?>EN/Dashboard/permissions/<?php echo $admin['Id']; ?>">
                                                                           <i class="uil uil-keyhole-circle" style="font-size: 25px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Permissions"></i>
                                                                      </a>
                                                                 </td>
                                                                 <td>
                                                                      <label class="switch">
                                                                           <input type="checkbox" theAdminId="<?php echo $admin['Id']; ?>" id="status" name="ischecked" <?php echo $cheked; ?>>
                                                                           <span class="slider round"></span>
                                                                      </label>
                                                                 </td>
                                                            </tr>
                                                       <?php  } ?>
                                                  </tbody>

                                             </table>
                                             </div>

                                        </div>
                                   </div>
                              </div> <!-- end col -->
                         </div>
                         <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 003: Protected by QlickHealth</h4>
                    </div> <!-- end row -->


               </div> <!-- container-fluid -->
          </div>
          <!-- End Page-content -->


          <footer class="footer">
               <div class="container-fluid">
                    <div class="row">
                         <div class="col-sm-6">
                              <script>
                                   document.write(new Date().getFullYear())
                              </script>
                         </div>
                         <div class="col-sm-6">
                              <div class="text-sm-right d-none d-sm-block">
                                   <a href="<?php echo base_url(); ?>" target="_blank" class="text-reset">© 2022 V2.0 Track Qlickhealth</a>
                              </div>
                         </div>
                    </div>
               </div>
          </footer>
     </div>
     <!-- end main content-->

     </div>
     <!-- JAVASCRIPT -->
     <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
     <!-- Required datatable js -->
     <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
     <!-- Responsive examples
        <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"> -->
     </script>
     <!-- Datatable init js -->
     <script src="<?php echo base_url() ?>assets/js/pages/datatables.init.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/pages/dashboard.init.js"></script>
     <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
     <script>
          $(".disabled a").attr('disabled', '');

          var myoptions = {
               series: [{
                    data: [25, 66, 41, 89, 63, 25, 44, 20, 36, 40, 54]
               }],
               fill: {
                    colors: ["#FFF56B"]
               },
               chart: {
                    type: "bar",
                    width: 70,
                    height: 40,
                    sparkline: {
                         enabled: !0
                    }
               },
               plotOptions: {
                    bar: {
                         columnWidth: "50%"
                    }
               },
               labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
               xaxis: {
                    crosshairs: {
                         width: 1
                    }
               },
               tooltip: {
                    fixed: {
                         enabled: !1
                    },
                    x: {
                         show: !1
                    },
                    y: {
                         title: {
                              formatter: function(e) {
                                   return ""
                              }
                         }
                    },
                    marker: {
                         show: !1
                    }
               }
          }

          chart1 = new ApexCharts(document.querySelector("#CharTTest1"), myoptions);
          chart1.render();
          var options = {
               fill: {
                    colors: ["#34c38f"]
               },
               series: [70],
               chart: {
                    type: "radialBar",
                    width: 45,
                    height: 45,
                    sparkline: {
                         enabled: !0
                    }
               },
               dataLabels: {
                    enabled: !1
               },
               plotOptions: {
                    radialBar: {
                         hollow: {
                              margin: 0,
                              size: "60%"
                         },
                         track: {
                              margin: 0
                         },
                         dataLabels: {
                              show: !1
                         }
                    }
               }
          }
          chart1 = new ApexCharts(document.querySelector("#CharTTest2"), myoptions);
          chart1.render();
          var options = {
               fill: {
                    colors: ["#34c38f"]
               },
               series: [70],
               chart: {
                    type: "radialBar",
                    width: 45,
                    height: 45,
                    sparkline: {
                         enabled: !0
                    }
               },
               dataLabels: {
                    enabled: !1
               },
               plotOptions: {
                    radialBar: {
                         hollow: {
                              margin: 0,
                              size: "60%"
                         },
                         track: {
                              margin: 0
                         },
                         dataLabels: {
                              show: !1
                         }
                    }
               }
          }


          $('input[type="checkbox"]').each(function() {
               $(this).change(function() {
                    var theAdminId = $(this).attr('theAdminId');
                    if (this.checked == true) {
                         $('#ad_id' + theAdminId).children('td').removeClass('disabled');
                    } else {
                         $('#ad_id' + theAdminId).children('td').addClass('disabled');
                         //$(".disabled a").attr('disabled' , '');	
                    }
                    console.log(theAdminId);
                    console.log("------------------");
                    console.log(this.checked);
                    $.ajax({
                         type: 'POST',
                         url: '<?php echo base_url(); ?>EN/Dashboard/changestatus',
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
                                   'oops!! لدينا خطأ',
                                   'error'
                              )
                         }
                    });

               });
          });
     </script>

</body>

</html>