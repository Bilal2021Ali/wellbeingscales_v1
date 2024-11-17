<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- 
		Responsive datatable examples
		id="datatables_buttons_info"
		-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.badge {
    text-align: center;
}
.Td-Results {
    color: #FFFFFF;
}
/*
Theme Name: jqueryui-com
Template: jquery
*/

a, .title {
    color: #b24926;
}
#content a:hover {
    color: #333;
}
#banner-secondary p.intro {
    padding: 0;
    float: left;
    width: 50%;
}
#banner-secondary .download-box {
    border: 1px solid #aaa;
    background: #333;
    background: -webkit-linear-gradient(left, #333 0%, #444 100%);
    background: linear-gradient(to right, #333 0%, #444 100%);
    float: right;
    width: 40%;
    text-align: center;
    font-size: 20px;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.8);
}
#banner-secondary .download-box h2 {
    color: #71d1ff;
    font-size: 26px;
}
#banner-secondary .download-box .button {
    float: none;
    display: block;
    margin-top: 15px;
}
#banner-secondary .download-box p {
    margin: 15px 0 5px;
}
#banner-secondary .download-option {
    width: 45%;
    float: left;
    font-size: 16px;
}
#banner-secondary .download-legacy {
    float: right;
}
#banner-secondary .download-option span {
    display: block;
    font-size: 14px;
    color: #71d1ff;
}
#content .dev-links {
    float: right;
    width: 30%;
    margin: -15px -25px .5em 1em;
    padding: 1em;
    border: 1px solid #666;
    border-width: 0 0 1px 1px;
    border-radius: 0 0 0 5px;
    box-shadow: -2px 2px 10px -2px #666;
}
#content .dev-links ul {
    margin: 0;
}
#content .dev-links li {
    padding: 0;
    margin: .25em 0 .25em 1em;
    background-image: none;
}
.demo-list {
    float: right;
    width: 25%;
}
.demo-list h2 {
    font-weight: normal;
    margin-bottom: 0;
}
#content .demo-list ul {
    width: 100%;
    border-top: 1px solid #ccc;
    margin: 0;
}
#content .demo-list li {
    border-bottom: 1px solid #ccc;
    margin: 0;
    padding: 0;
    background: #eee;
}
#content .demo-list .active {
    background: #fff;
}
#content .demo-list a {
    text-decoration: none;
    display: block;
    font-weight: bold;
    font-size: 13px;
    color: #3f3f3f;
    text-shadow: 1px 1px #fff;
    padding: 2% 4%;
}
.demo-frame {
    width: 70%;
    height: 420px;
}
.view-source a {
    cursor: pointer;
}
.view-source>div {
    overflow: hidden;
    display: none;
}

@media all and (max-width: 600px) {
#banner-secondary p.intro, #banner-secondary .download-box {
    float: none;
    width: auto;
}
#banner-secondary .download-box {
    overflow: auto;
}
}

@media only screen and (max-width: 480px) {
#content .dev-links {
    width: 55%;
    margin: -15px -29px .5em 1em;
    overflow: hidden;
}
}
</style>
<style>
    .ui-widget.ui-widget-content {
      max-height: 150px;
      overflow-y: auto;
      overflow-x: hidden;
    }
  </style>
</head>
<?php

$ours = $this->db->query( "SELECT 
`Dept_Name_EN`,`Id` FROM `l1_co_department` 
WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "' ORDER BY `Id` DESC " )->result_array();

$staffs_of_this_school = $this->db->query( "SELECT * FROM `l2_co_patient` 
WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "'" )->result_array();

?>

<body>
<!-- Begin page --> 
<!-- ============================================================== --> 
<!-- Start right Content here --> 
<!-- ============================================================== -->
<div class="main-content">
  <div class="page-content">
<h4 class="card-title" style="background: #0eacd8;padding: 10px;color: #f5f6f8;border-radius: 4px;"> CO014: User Attendance and Departure </h4>
    <div class="container-fluid">
      <?php

      function symps( $symps ) {
          $ci = & get_instance();
          $Symps_array = explode( ';', $symps );
          $sz = sizeof( $Symps_array );
          //print_r($Symps_array);  
          if ( $sz > 1 ) {
              foreach ( $Symps_array as $sympsArr ) {
                  //print_r($sympsArr);
                  //echo sizeof($Symps_array);
                  $SempName = $ci->db->query( "SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'" )->result_array();
                  foreach ( $SempName as $name ) {
                      echo $name[ 'symptoms_EN' ] . ",";
                  }
              }
          } else {
              echo " No symptoms ";
          }
      }
      $devices = array();
      foreach ( $ours as $dept ) {
          $justDevace = $this->db->query( "SELECT * FROM l2_co_devices 
	  WHERE Added_By = '" . $dept[ 'Id' ] . "' " )->result_array();
          if ( !empty( $justDevace ) ) {
              $devices[] = $justDevace;
          }
      }
      ?>
	  
      <div class="control col-md-12" style="padding: 10px;">
        <button type="button" form_target="searchbydevice" class="btn btn-primary w-md contr_btn"> <i class="uil uil-search"></i> Search by device </button>
        <button type="button" form_target="searchbyname"   class="btn w-md contr_btn"> <i class="uil uil-search"></i> Search by name </button>
      </div>
	  
      <div class="formcontainer" id="searchbydevice">
        <div class="col-lg-12">
		
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-xl-12">
                  <label>Select Device</label>
                  <select class="custom-select" id="devices">
                    <option value="">Selecte Device</option>
                    <?php if (!empty($devices)) { ?>
                    <?php foreach ($devices as $device) { ?>
                    <option value="<?php echo $device[0]['D_Id']; ?>"> <?php echo $device[0]['Site'] . " - " . $device[0]['Description']; ?> </option>
                    <?php } ?>
                    <?php } else { ?>
                    <option value="">There Is No Devices</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
       
		  </div>
        </div>
        <!-- class="container"  -->
        <div id="hereGetedStudents"> </div>
      </div>
      <div class="formcontainer" id="searchbyname">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <label for="name"> Write User Name</label>
                  <input type="text" placeholder="Start writing the name " id="name" class="form-control">
                </div>
                <div class="col-lg-4" style="padding-top: 30px;">
                  <button type="button" onClick="GetDataForUser()" style="width: 100%;" class="btn btn-outline-primary waves-effect waves-light">Search</button>
                </div>
              </div>
            </div>
          </div>
          <div id="getedData"> </div>
        </div>
      </div>
      <!-- container-fluid --> 
    </div>
    <!-- End Page-content --> 
  </div>
  <!-- end main content--> 
  
</div>
<!-- END layout-wrapper --> 
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script> 
<!-- Required datatable js --> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> 
<!-- Responsive examples --> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script> 
<!-- Datatable init js --> 
<script src="<?php echo base_url(); ?>assets/js/app.js"></script> 
<script>
    $(document).ready(function() {

      $('.formcontainer').hide();
      $('#searchbydevice').show();

      $('.control button').click(function() {
        $('.control button').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $('.formcontainer').hide();
        var to = $(this).attr('form_target');
        $('#' + to).show();
      });

      $("#devices").change(function() {
        var deviceinfo = $(this).children("option:selected").val();
        if (deviceinfo !== "") {
          getdatafordevice(deviceinfo);
        }
      });

      function getdatafordevice(type) {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Results/getResultsbyDevice_co',
          data: {
            type: type,
          },
          beforeSend: function() {
            // setting a timeout
            $("#hereGetedStudents").html('Please Wait..');
          },
          success: function(data) {
            $('#hereGetedStudents').html(data);
          },
          ajaxError: function() {
            Swal.fire(
              'error',
              'oops!! we have a error',
              'error'
            )
          }
        });
      }


    });

    function GetDataForUser() {
      var name = $('#name').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>EN/Results_company/getResultsbyname_co',
        data: {
          name: name,
        },
        beforeSend: function() {
          // setting a timeout
          $("#getedData").html('Please Wait..');
        },
        success: function(data) {
          $('#getedData').html(data);
        },
        ajaxError: function() {
          Swal.fire(
            'error',
            'oops!! we have a error',
            'error'
          )
        }
      });
    }
  </script>
</body>
<script>
  $(function() {
    var availableTags = [
      <?php
      foreach ($ours as $dept) {
        $members_forthisschool = $this->db->query("SELECT * FROM `l2_co_patient`
		WHERE Added_By = '" . $dept['Id'] . "'")->result_array();
        foreach ($members_forthisschool as $stafff) {
      ?> "<?php echo $stafff['F_name_EN'] . " " . $stafff['M_name_EN'] . " " . $stafff['L_name_EN']; ?>",
        <?php } ?>
      <?php } ?>
    ];
    $("#name").autocomplete({
      source: availableTags
    });
  });
</script>
<?php

function boxes_Colors( $result ) {
    ?>

<style>
    .Td-Results_font span {
      font-size: 20px !important;
      padding: 6px;
    }

    .Td-Results .badge {
      padding: 6px;
    }
  </style>
<td class="Td-Results_font"><?php if ($result >= 38.500 && $result <= 45.500) { ?>
  <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;">
  <?= $result; ?>
  </span>
  <!-- Hight -->
  
  <?php } elseif ($result <= 36.200) { ?>
  <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;">
  <?= $result; ?>
  </span>
  <!-- Low -->
  
  <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
  <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;">
  <?= $result; ?>
  </span>
  <!-- No Risk -->
  
  <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
  <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;">
  <?= $result; ?>
  </span>
  <!-- Moderate -->
  
  <?php } elseif ($result >= 45.501) { ?>
  <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;">
  <?= $result; ?>
  </span>
  <!-- Error -->
  
  <?php } ?></td>
<td class="Td-Results"><?php if ($result >= 38.500 && $result <= 45.500) { ?>
  <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">High</span>
  <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
  <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">Moderate</span>
  <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
  <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">No Risk</span>
  <?php } elseif ($result <= 36.200) { ?>
  <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;">Low</span>
  <?php } elseif ($result >= 45.501) { ?>
  <span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">Error</span>
  <?php } ?></td>
<?php
}

?>
</html>