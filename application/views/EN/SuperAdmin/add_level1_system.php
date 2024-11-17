<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
<body class="light menu_light logo-white theme-white">
<div class="outer"></div>
<style>
          .Ver, .Not {
               font-size: 14px;
               border-radius: 5px;
               width: 50%;
               display: block;
               text-align: center;
               color: #fff;
               height: 50%;
               line-height: 5px;
               font-style: normal;
               font-weight: bold;
               margin-top: 5px;
          }
          .Ver {
               background: green;
          }
          .Not {
               background: red;
          }
     </style>
<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
<style>
          .InfosCards h4, .InfosCards p {
               color: #fff;
          }
          .InfosCards .card-body {
               border-radius: 5px;
          }
     </style>
<div class="main-content">
  <div class="page-content">
        <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;"> 0001: Counter System </h4>
    <div class="row">
      <div class="col-md-6 col-xl-4 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #097390;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/oefgcounter.png" alt="schools" width="100px"> </div>
            <div>
              <?php
              $all = $this->db->query( "SELECT * FROM `l0_organization` " )->num_rows();
              $lasts = $this->db->query( "SELECT * FROM `l0_organization`
											 ORDER BY Id DESC LIMIT 1 " )->result_array();
              ?>
              <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                <?= $all ?>
                </span></h4>
              <p class="mb-0">Total Organizations</p>
            </div>
            <?php if (!empty($lasts)) { ?>
            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
              <?php foreach ($lasts as $last) { ?>
              <?= $last['Created'] ?>
              </span><br>
              Last Registered Organization </p>
            <?php } ?>
            <?php } else { ?>
            <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
              Last Registered Organization </p>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-6 col-xl-4 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #0b86a8;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/orgministry.png" alt="schools" width="100px"> </div>
            <div>
              <?php
              $all_ministry = $this->db->query( "SELECT * FROM `l0_organization`
                                             WHERE VX = '1' " )->num_rows();
              $lastminED = $this->db->query( "SELECT * FROM `l0_organization` WHERE VX = '1' ORDER BY Id DESC LIMIT 1 " )->result_array();
              ?>
              <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                <?= $all_ministry ?>
                </span> </h4>
              <p class="mb-0">Total Ministries of Education</p>
            </div>
            <?php if (!empty($lastminED)) { ?>
            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
              <?php foreach ($lastminED as $last) { ?>
              <?= $last['Created'] ?>
              </span><br>
              Last Registered Ministry of Education
              <?php
              }
              } else {
                  ?>
            <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
              Last Registered Ministry of Education </p>
            <?php } ?>
            </p>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-6 col-xl-4 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #0c99c0;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/countercompany.png" alt="" width="100px"> </div>
            <div>
              <?php
              $all_ministry = $this->db->query( "SELECT * FROM `l0_organization`
                                             WHERE VX = '3' " )->num_rows();
              $lastminED = $this->db->query( "SELECT * FROM `l0_organization` WHERE VX = '3' ORDER BY Id DESC LIMIT 1 " )->result_array();
              ?>
              <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                <?= $all_ministry ?>
                </span> </h4>
              <p class="mb-0">Total Companies</p>
            </div>
            <?php if (!empty($lastminED)) { ?>
            <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
              <?php foreach ($lastminED as $last) { ?>
              <?= $last['Created'] ?>
              </span><br>
              Last Registered Company
              <?php } ?>
            </p>
            <?php } else { ?>
            <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
              Last Registered Company </p>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- end col--> 
    </div>
    <!-- end row-->
    <div class="row">
      <div class="col-xl-6">
        <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;"> 0002: Add New Organization </h4>
        <div class="card">
          <div class="card-body">
            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert"> <span id="Toast"></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
            </div>
            <form class="needs-validation InputForm" novalidate="" style="margin-bottom: 27px;" id="addSysteme">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
					<h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">English Name</h4>
                    <input type="text" class="form-control" id="validationCustom02" placeholder="English Name" name="English_Title" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
<h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Arabic Name</h4>
                    <input type="text" class="form-control" id="validationCustom01" placeholder="Arabic Name" name="Arabic_Title" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
              </div>
              <input type="hidden" value="1" id="VX" name="VX">
              <div class="row">
                <?php
                $contriesarray = $this->db->query( 'SELECT * FROM `r_countries` ORDER BY `r_countries`.`name` ASC' )->result_array();
                $defaultcountry = $this->db->query( 'SELECT `region` FROM `region` ORDER BY `id` ASC LIMIT 1' )->result_array();
                $reg = $defaultcountry[ 0 ][ 'region' ];
                $truid = substr( $reg, 8, 11 ); // 11
                $countryname = $this->db->query( "SELECT `name` FROM `r_countries` WHERE 
											`id` = '" . $truid . "' ORDER BY `id` ASC LIMIT 1" )->result_array();
                ?>
                <div class="col-md-6" style="margin-bottom: 10px">
				<br>	 
				<h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Country</h4>
 
                <select class="custom-select" name="cousntrie">
                <option value="<?php echo $truid; ?>"> <?php echo $countryname[0]['name'] ?> </option>
				<?php foreach($contriesarray as $contries){ ?>  
                <option value="<?php echo $contries['id']; ?>" class="option" ><?php echo $contries['name']; ?></option>
				<?php } ?>  
                </select>
                </div>  
				<br>
                <?php $styles = $this->db->query("SELECT * FROM `r_style` ")->result_array();  ?>
                <div class="col-md-6" style="margin-bottom: 10px"> <br>
				<h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Type</h4>
                  <select class="custom-select" name="style_id">
                    <?php foreach ($styles as $style) { ?>
                    <option value="<?= $style['Id']; ?>">
                    <?= $style['style_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
			  <br>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
				  	<h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">Email</h4>
                    <input type="email" class="form-control" id="validationCustom02" placeholder="Email" name="Email" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <h4 class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;">User Name</h4>
                    <input type="text" class="form-control" id="validationCustom02" placeholder="User Name" name="Username" required="">
                    <div class="valid-feedback"> Looks good! </div>
                  </div>
                </div>
              </div>
			  <br>
              <button class="btn btn-info" type="Submit" id="sendingbutton">Add</button>
              <button type="button" class="btn btn-warning" id="back">Cancel</button>
            </form>
          </div>
        </div>
        <!-- end card --> 
      </div>
      <div class="col-xl-6">
        <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;"> 0003: Last Added organizations<br>
        </h4>
		
        <div class="card">
		
          <div class="card-body" style="height: 600px;overflow: auto;">
		  <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert"> <span id="Toast"></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
            </div>
            <table class="table mb-0">
			
              <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                <tr>
				  <th id="test" class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" >No</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" >User Name</th>
				  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" >Account Type</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" >System Type</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" >Country</th>
                  <th class="card-title" style="background: #add138; padding: 10px;color: #0c637b;border-radius: 4px;" >Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($listofadmins as $adminData) { ?>
                <tr>
                  <th scope="row"><?= $adminData['Id'] ?></th>
                  <td><?= $adminData['Username'] ?></td>
				  <td><?php
                  $stylename = $this->db->query( "SELECT * FROM `r_style` 
                                                       WHERE id = '" . $adminData[ 'Style_type_id' ] . "' ORDER BY `r_style`.`style_name` ASC" )->result_array();
                  foreach ( $stylename as $stylename2 ) {
                      echo $stylename2[ 'style_name' ];
                  }
                  ?></td>
                  <td><?php
                  if ( $adminData[ 'Company_Type' ] == '1' ) {
                      echo "Ministry";
                  } elseif ( $adminData[ 'Company_Type' ] == '2' ) {
                      echo "Company";
                  } elseif ( $adminData[ 'Company_Type' ] == '3' ) {
                      echo "Hyprid";
                  }
                  ?></td>
                  <td><?php
                  $contriesarray = $this->db->query( "SELECT * FROM `r_countries` 
                                                       WHERE id = '" . $adminData[ 'CountryID' ] . "' ORDER BY `r_countries`.`name` ASC" )->result_array();
                  foreach ( $contriesarray as $contrie ) {
                      echo $contrie[ 'name' ];
                  }
                  ?></td>
                  <?php
                  if ( $adminData[ 'verify' ] == 1 ) {
                      $classname = 'Ver';
                  } else {
                      $classname = 'Not';
                  }
                  ?>
                  <td class="<?= $classname; ?>"><?php if (!empty($adminData['Manager']) && !empty($adminData['Tel'])) { ?>
                    <i class="uil-check" style="font-size: 20px;font-style: normal;"></i>
                    <?php } else { ?>
                    <i class="" style="font-size: 14px;font-style: normal;">X</i>
                    <?php } ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- end card --> 
      </div>
    </div>
    <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 002: Protected by QlickHealth</h4>
  </div>
</div>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script> 
<script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script> 
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script> 
<script>
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
          //style_id
          $("#addSysteme").on('submit', function(e) {
               e.preventDefault();
               $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/Dashboard/startAddingSystem',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                         $('#statusbox').css('display', 'block');
                         $('#statusbox').html('<p style="width: 100%;margin: 0px;"> Please wait !!</p>')
                         $('#sendingbutton').attr('disabled', 'disabled');
                         $('#sendingbutton').addClass('mat-button-disabled');
                         $('#sendingbutton').html('Please wait !!');
                    },
                    success: function(data) {
                         $('#Toast').html(data);
                         $('#sendingbutton').removeAttr('disabled');
                         $('#sendingbutton').html('Add');
                         $('#statusbox').html(data);
                    },
                    ajaxError: function() {
                         $('.alert.alert-info').css('background-color', '#DB0404');
                         $('.alert.alert-info').html("Ooops! Error was found.");
                    }
               });
          });
          $('#back').click(function() {
               location.href = "<?= base_url() . "EN/Dashboard"; ?>";
          });
          $('#back').click(function() {
               location.href = "<?= base_url() . "EN/Dashboard"; ?>";
          });
          function back() {
               location.href = "<?= base_url() . "EN/Dashboard"; ?>";
          }
          $('#test').click(function() {
               //for tests
          });
     </script>
</body>
</html>