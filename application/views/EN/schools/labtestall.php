<!doctype html>
<html lang="en">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<style>
  .firstCard * {
    color: #fff;
  }
  .firstCard.card-body {
    border-radius: 5px
  }
  .firstCard .uil-arrow-right {
    margin-left: 10px;
    transition: 0.2s all;
  }
  img.ic_img {
    width: 60px;
    margin-bottom: 20px;
  }
  .ontypecard .card-body * {
    color: #fff;
    cursor: default;
  }
  .ontypecard .card-body {
    border-radius: 5px;
  }
  .img-responsive.w-100.p-1 {
    max-width: 200px;
  }
  .cardsoflinks .firstCard img {
    width: 100px;
    float: left;
    position: absolute;
    top: -11px;
    left: -13px;
  }
  .set-in-action {
    cursor: pointer;
  }
  #userschart,
  .labtest-chart {
    min-height: 350px !important;
  }
  
</style>
<?php
function calculate($part, $total)
{
  $x = $part;
  $y = $total;
  if ($x > 0 && $y > 0) {
    $percent = $x / $y;
    $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
  } else {
    $percent_friendly = 0;
  }
  return $percent_friendly;
}
?>
<div class="main-content">
  <div class="page-content">
    
    <?php if (isset($permissions['users_daily_labtests']) && $permissions['users_daily_labtests'] == '1') { ?>
      <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"> CH007 : Daily Lab Test Counters </h4>
	  
      <?php foreach ($tests as $test) { ?>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-xl-12">
                <div class="card-body mb-2" 
				style="border-radius: 5px;border: 3px solid 
				#0eacd8;padding: 9px;">
                  <h4 class="card-title"> <img 
				  src="<?= base_url(); ?>assets/images/icons/png_icons/Lab_Counter.png" 
				  style="width: 25px;margin: auto 5px;">
                    <?= $test->Test_Desc; ?>
                  </h4>
                </div>
              </div>
              <div class="col-md-6 col-xl-6 text-center">
                <div class="card notStatic">
                  <div class="card-body" style="padding: 5px">
                    <div class="labtest-chart" id="labtests-chart-<?= $test->Id ?>-bar"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-6 text-center">
                <div class="card notStatic">
                  <div class="card-body" style="padding: 5px">
                    <div class="labtest-chart" id="labtests-chart-<?= $test->Id ?>-pie"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          var options = {
            chart: {
              height: 350,
              type: 'pie',
            },
            series: [<?= $labtests[$test->Test_Desc]['negative'] ?>, <?= $labtests[$test->Test_Desc]['positive'] ?>],
            labels: ["Negative", "Positive"],
            colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1"],
            legend: {
              show: true,
              position: 'bottom',
              horizontalAlign: 'center',
              verticalAlign: 'middle',
              floating: false,
              fontSize: '14px',
              offsetX: 0
            },
            responsive: [{
              breakpoint: 600,
              options: {
                chart: {
                  height: 240
                },
                legend: {
                  show: false
                },
              }
            }]
          }
          var chart = new ApexCharts(
            document.querySelector("#labtests-chart-<?= $test->Id ?>-pie"),
            options
          );
          chart.render();
          var options = {
            chart: {
              height: 350,
              type: 'bar',
              toolbar: {
                show: false,
              }
            },
            plotOptions: {
              bar: {
                horizontal: true,
              }
            },
            dataLabels: {
              enabled: false
            },
            series: [{
              name: "",
              data: [<?= $labtests[$test->Test_Desc]['negative'] ?>, <?= $labtests[$test->Test_Desc]['positive'] ?>],
            }],
            colors: ['#34c38f'],
            grid: {
              borderColor: '#f1f1f1',
            },
            xaxis: {
              categories: ["Negative", "Positive"]
            }
          }
          var chart = new ApexCharts(
            document.querySelector("#labtests-chart-<?= $test->Id ?>-bar"),
            options
          );
          chart.render();
        </script>
      <?php } ?>
    <?php } ?>
 
    <div id="return"></div>
  </div>
</div>
<script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
<script>
  $("table").DataTable();
  $(function() {
    $(".knob").knob();
    $('.knob').each(function() {
      const $this = $(this);
      const value = $this.val();
      $(this).val(value);
    });
  });
  function GetStaffChart() {
    $('#SelectTheClassCard').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/schools/ChartofTempForStaff',
      beforeSend: function() {
        $('#drawChart').html('');
        $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
      },
      success: function(data) {
        $('#drawChart').removeAttr('disabled', '');
        $('#drawChart').html(data);
      },
      ajaxError: function() {
        $('.alert.alert-info').css('background-color', '#DB0404');
        $('.alert.alert-info').html("Ooops! Error was found.");
      }
    });
  }
  function GetTeacherChart() {
    $('#SelectTheClassCard').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/schools/ChartofTempForTeacher',
      beforeSend: function() {
        $('#drawChart').html('');
        $('#drawChart').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
      },
      success: function(data) {
        $('#drawChart').removeAttr('disabled', '');
        $('#drawChart').html(data);
      },
      ajaxError: function() {
        $('.alert.alert-info').css('background-color', '#DB0404');
        $('.alert.alert-info').html("Ooops! Error was found.");
      }
    });
  }
  function GetStudentChart() {
    $('#drawChart').html("");
    $('#SelectTheClassCard').slideDown();
  }
  $("#SelectFromClass").change(function() {
    var selectedclass = $(this).children("option:selected").val();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/Schools/ChartTempOfClass',
      data: {
        NumberOfClass: selectedclass,
      },
      beforeSend: function() {
        // setting a timeout
        $("#drawChart").html('Please Wait.....');
      },
      success: function(data) {
        $('#drawChart').html("");
        $('#drawChart').html(data);
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
  function Get_plus_minus_students(type) {
    $('#ResultsTableStudents').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/ajax/GetClassesList',
      data: {
        TestDesc: type,
      },
      success: function(data) {
        $('.New_Select').html(data);
      },
      ajaxError: function() {
        Swal.fire(
          'error',
          'oops!! we have a error',
          'error'
        );
      }
    });
    $('.classes_temp').hide();
  }
  function GetTheStudentsResultsForClass(className) {
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/schools/ListResultsOfDtudents',
      data: {
        class: className,
      },
      beforeSend: function() {
        $('#ResultsTableStudents').html('');
        $('#ResultsTableStudents').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
      },
      success: function(data) {
        $('#ResultsTableStudents').removeAttr('disabled', '');
        $('#ResultsTableStudents').html(data);
      },
      ajaxError: function() {
        $('#ResultsTableStudents').css('background-color', '#DB0404');
        $('#ResultsTableStudents').html("Ooops! Error was found.");
      }
    });
  }
  function staff_labTests(type) {
    $('#STAFFSNOSHOWTESTNAME').html(type);
    $('#simpl_staff_list').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/ajax/Get_Staffs_List',
      data: {
        TestDesc: type,
      },
      success: function(data) {
        $('#New_Staff_List').html(data);
      },
      ajaxError: function() {
        Swal.fire(
          'error',
          'oops!! we have a error',
          'error'
        );
      }
    });
    //$('.classes_temp').hide();
  }
  function Tempratur_List(id, emp) {
    if (id == '#simpl_home_list' && emp == '#New_home_List') {
      $('#STAYHOMESHOWTESTNAME').html('TEMPERATURE ');
    } else if (id == '#simpl_quarantin_list' && emp == '.New_quarantin_List') {
      $('#STAYQuarantineNOSHOWTESTNAME').html('TEMPERATURE ');
    } else if (id == '#simpl_staff_list' && emp == '#New_Staff_List') {
      $('#STAFFSNOSHOWTESTNAME').html('TEMPERATURE ');
    } else if (id == '#simpl_Teacher_list' && emp == '#New_Teacher_List') {
      $('#TEACHERSSNOSHOWTESTNAME').html('TEMPERATURE ');
    }
    $(id).slideDown();
    $(emp).html('');
  }
  function Teacher_labTests(type) {
    $('#TEACHERSSNOSHOWTESTNAME').html(type);
    $('#simpl_Teacher_list').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/ajax/Get_Teachers_List',
      data: {
        TestDesc: type,
      },
      success: function(data) {
        $('#New_Teacher_List').html(data);
      },
      ajaxError: function() {
        Swal.fire(
          'error',
          'oops!! we have a error',
          'error'
        );
      }
    });
    //$('.classes_temp').hide();
  }
  function home_labTests(type) {
    $('#STAYHOMESHOWTESTNAME').html(type);
    $('#simpl_home_list').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/ajax/Get_home_List',
      data: {
        TestDesc: type,
      },
      success: function(data) {
        $('#New_home_List').html(data);
      },
      ajaxError: function() {
        Swal.fire(
          'error',
          'oops!! we have a error',
          'error'
        );
      }
    });
    //$('.classes_temp').hide();
  }
  function quarntine_labTests(type) {
    $('#STAYQuarantineNOSHOWTESTNAME').html(type);
    $('#simpl_quarantin_list').slideUp();
    $.ajax({
      type: 'POST',
      url: '<?= base_url(); ?>EN/ajax/Get_Quaranrine_List',
      data: {
        TestDesc: type,
      },
      success: function(data) {
        $('.New_quarantin_List').html(data);
      },
      ajaxError: function() {
        Swal.fire(
          'error',
          'oops!! we have a error',
          'error'
        );
      }
    });
    //$('.classes_temp').hide();
  }
  function RemoveThisMemberFrom(id, usertype, action) {
    var theId = id;
    console.log(theId);
    Swal.fire({
      title: ' Are you sure you want to do this action?',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: `Yes, I am sure!`,
      icon: 'warning',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '<?= base_url(); ?>EN/Schools/ApplyActionOnMember',
          data: {
            S_Id: theId,
            Action: action,
            UserType: usertype,
          },
          success: function(data) {
            $('#return').html(data);
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
  }
  $(".ch004results").on("click", ".set-in-action", function() {
    const data = {
      id: $(this).data("id"),
      type: $(this).data("type"),
      to: $(this).data("change-to"),
    };
    setmemberInAction(data.id, data.type, data.to);
  });
  function setmemberInAction(id, usertype, action) {
    var theId = id;
    Swal.fire({
      title: 'Are you sure you want to do this action?',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: `Yes, I am sure!`,
      icon: 'warning',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '<?= base_url(); ?>EN/Schools/ApplyActionOnMember',
          data: {
            S_Id: theId,
            Action: action,
            UserType: usertype,
          },
          success: function(data) {
            $('#return').html(data);
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
  }
</script>
<?php
function symps($symps)
{
  $ci = &get_instance();
  $Symps_array = explode(';', $symps);
  $sz = sizeof($Symps_array);
  //print_r($Symps_array);  
  if ($sz > 1) {
    foreach ($Symps_array as $sympsArr) {
      //print_r($sympsArr);
      //echo sizeof($Symps_array);
      $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
      foreach ($SempName as $name) {
        echo $name['symptoms_EN'] . ",";
      }
    }
  } else {
    echo "No Symptoms Found ";
  }
}
function boxes_Colors($result)
{
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
  <td class="Td-Results_font"><?php if ($result >= 38.501 && $result <= 45.500) { ?>
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
    <?php } ?>
  </td>
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
    <?php } ?>
  </td>
<?php
}
function StayHomeOf($type)
{
  $ci = &get_instance();
  $count_home = 0;
  $ci->load->library('session');
  $sessiondata = $ci->session->userdata('admin_details');
  if ($type == "Teacher") {
    $ours = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Home'")->result_array();
  } else {
    $ours = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Home'")->result_array();
  }
  $listTeachers = array();
  $today = date("Y-m-d");
  foreach ($ours as $Teacher) {
    $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
    $ID = $Teacher['Id'];
    if ($type == "Teacher") {
      $Position = $ci->schoolHelper->getTeacherPosition($Teacher['Position']);
    } else {
      $Position = $ci->schoolHelper->getStaffPosition($Teacher['Position']);
    }
    $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
        AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
    foreach ($getResults_Teacheer as $T_results) {
      $lastReads = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
      $lastRead = $lastReads[0]['Result'];
      $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
      $listTeachers[] = array(
        "Username" => $Teachername, "Id" => $ID,
        "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
        "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
        "Class_OfSt" => $Position, "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
      );
    }
  }
?>
  <style>
    .badge {
      text-align: center;
    }
  </style>
  <?php
  $count_home += sizeof($listTeachers);
  foreach ($listTeachers as $TeacherRes) {
  ?>
    <tr>
      <td style="width: 20px;"><?php
                                $avatar = $ci->db->query("SELECT * FROM `l2_avatars`
            WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                                ?>
        <?php if (empty($avatar)) {  ?>
          <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
        <?php } else { ?>
          <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
        <?php } ?>
      </td>
      <td>
        <h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
          <?= $TeacherRes['Username']; ?>
        </h6>
        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
          <?= $TeacherRes['Class_OfSt']; ?>
        </p>
      </td>
      <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
      <?php boxes_Colors($TeacherRes['LastRead']); ?>
      <td><?php
          $from_craet = $TeacherRes['Creat'];
          //echo $from_craet;
          //$toTime = $today-$from_craet;
          $date_exp = explode(" ", $from_craet)[0];
          $finalDate = dateDiffInDays($date_exp, $today);
          if ($finalDate == 0) {
            echo "Today";
          } elseif ($finalDate > 2) {
            echo $finalDate . " Days";
          } else {
            echo $finalDate . " Day";
          }
          ?></td>
      <td class="out"><img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'<?= $type ?>','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit"></td>
    </tr>
  <?php
  }
}
function StayHomeOfQuarantin($type)
{
  $ci = &get_instance();
  $count = 0;
  $ci->load->library('session');
  $sessiondata = $ci->session->userdata('admin_details');
  if ($type == "Teacher") {
    $ours = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Quarantine' ")->result_array();
  } else {
    $ours = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  AND `Action` = 'Quarantine'  ")->result_array();
  }
  $listTeachers = array();
  $today = date("Y-m-d");
  foreach ($ours as $Teacher) {
    $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
    $ID = $Teacher['Id'];
    if ($type == "Teacher") {
      $Position = $ci->schoolHelper->getTeacherPosition($Teacher['Position']);
    } else {
      $Position = $ci->schoolHelper->getStaffPosition($Teacher['Position']);
    }
    $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
        AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
    foreach ($getResults_Teacheer as $T_results) {
      $lastReads = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
            AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1")->result_array();
      $lastRead = $lastReads[0]['Result'];
      $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
      $listTeachers[] = array(
        "Username" => $Teachername, "Id" => $ID,
        "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
        "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
        "Class_OfSt" => $Position,
        "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
      );
    }
  }
  ?>
  <style>
    .badge {
      text-align: center;
    }
  </style>
  <?php
  foreach ($listTeachers as $TeacherRes) {
  ?>
    <?php //print_r($TeacherRes); 
    ?>
    <tr>
      <td style="width: 20px;"><?php
                                $avatar = $ci->db->query("SELECT * FROM `l2_avatars`
            WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 ")->result_array();
                                ?>
        <?php if (empty($avatar)) {  ?>
          <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
        <?php } else { ?>
          <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
        <?php } ?>
      </td>
      <td>
        <h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
          <?= $TeacherRes['Username']; ?>
        </h6>
        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
          <?= $TeacherRes['Class_OfSt']; ?>
        </p>
      </td>
      <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
      <?php boxes_Colors($TeacherRes['LastRead']); ?>
      <td><?php
          $from_craet = $TeacherRes['Creat'];
          //echo $from_craet;
          //$toTime = $today-$from_craet;
          $date_exp = explode(" ", $from_craet)[0];
          $finalDate = dateDiffInDays($date_exp, $today);
          if ($finalDate == 0) {
            echo "Today";
          } elseif ($finalDate > 2) {
            echo $finalDate . " Days";
          } else {
            echo $finalDate . " Day";
          }
          ?></td>
      <td class="out"><img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'<?= $type ?>','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit"></td>
    </tr>
  <?php
  }
}
function dateDiffInDays($date1, $date2)
{
  // Calculating the difference in timestamps 
  $diff = strtotime($date2) - strtotime($date1);
  // 1 day = 24 hours 
  // 24 * 60 * 60 = 86400 seconds 
  return abs(round($diff / 86400));
}
function GetListOfSites($list_Tests)
{
  $ci = &get_instance();
  $ci->load->library('session');
  $today = date("Y-m-d");
  $listSites = array();
  $sessiondata = $ci->session->userdata('admin_details');
  $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Site_Code` ASC ")->result_array();
  foreach ($list_Tests as $test) {
    get_site_of_test($sitesForThisUser, $test['Test_Desc']);
  }
  //print_r($sitesForThisUser);
}
function get_site_of_test($sitesForThisUser, $testType)
{
  $ci = &get_instance();
  $ci->load->library('session');
  $today = date("Y-m-d");
  $listSites = array();
  $sessiondata = $ci->session->userdata('admin_details');
  foreach ($sitesForThisUser as $site) {
    $name = $site['Description'];
    $site_name = $site['Site_Code'];
    $ID = $site['Id'];
    $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND 
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC ")->result_array();
    //print_r($getResults);
    foreach ($getResults as $T_results) {
      $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
      //if(!empty($lastRead)){
      $lastRead = $lastReads[0]['Result'];
      $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
      $listSites[] = array(
        "name" => $name, "Id" => $ID,
        "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
        "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
        "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
        "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
      );
      //}	
    }
  }
  ///print_r($listSites);
  foreach ($listSites as $siteResult) {
  ?>
    <tr>
      <td>--</td>
      <td><?= $siteResult['name'] ?></td>
      <td><?= $siteResult['SiteName'] ?></td>
      <td><?= $siteResult['LastReadDate'] ?></td>
      <td><?= $siteResult['Batch'] ?></td>
      <td><?= $siteResult['Testtype'] ?></td>
      <?php if ($siteResult['Action'] == "School") { ?>
        <?php if ($siteResult['Result'] == '0') { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
        <?php } else { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #F4F4F4;">Positive (+)</span></td>
        <?php } ?>
      <?php } else { ?>
        <?php if ($siteResult['Result'] == '0') { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #047B04;color: #ffffff;">Negative (-)</span></td>
        <?php } else { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #BC2200;color: #FFFFFF;">Positive (+)</span></td>
        <?php } ?>
      <?php } ?>
      <td><?php if ($siteResult['Action'] == "School") { ?>
          <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Close for decontamination">
        <?php } ?>
      </td>
    </tr>
  <?php
  }
}
function GetListOfSites_InCleaning($list_Tests, $date = null)
{
  $ci = &get_instance();
  $ci->load->library('session');
  $today = date("Y-m-d");
  $listSites = array();
  $sessiondata = $ci->session->userdata('admin_details');
  $sitesForThisUser = $ci->db->query(" SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Site_Code` ASC ")->result_array();
  $oftoday = $date == null ? false : true;
  foreach ($list_Tests as $test) {
    get_site_of_test_In($sitesForThisUser, $test['Test_Desc'], 'Cleaning', $oftoday);
  }
}
function get_site_of_test_In($sitesForThisUser, $testType, $action, $date = false)
{
  $ci = &get_instance();
  $ci->load->library('session');
  $today = date("Y-m-d");
  $listSites = array();
  $sessiondata = $ci->session->userdata('admin_details');
  if (!$date) {
    foreach ($sitesForThisUser as $site) {
      $name = $site['Description'];
      $site_name = $site['Site_Code'];
      $ID = $site['Id'];
      $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
            AND UserType = 'Site' AND `Action` = '" . $action . "' AND
            `Test_Description` = '" . $testType . "' AND `Created` >= '" . date("Y-m-d", strtotime("-7 days")) . "' AND `Created` <= '" . $today . "'
            ORDER BY `Id` DESC  ")->result_array();
      foreach ($getResults as $T_results) {
        $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
                AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' AND `Action` = 'Cleaning' ORDER BY `Id` DESC ")->result_array();
        //if(!empty($lastRead)){
        $lastRead = $lastReads[0]['Result'];
        $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
        $listSites[] = array(
          "name" => $name, "Id" => $ID,
          "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
          "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
          "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
          "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
        );
        //}	
      }
    }
  } else {
    foreach ($sitesForThisUser as $site) {
      $name = $site['Description'];
      $site_name = $site['Site_Code'];
      $ID = $site['Id'];
      $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
            AND UserType = 'Site' AND `Action` = '" . $action . "' AND
            `Test_Description` = '" . $testType . "' AND Created = '" . $today . "'  ORDER BY `Id` DESC ")->result_array();
      //print_r($getResults);
      foreach ($getResults as $T_results) {
        $lastReads = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $site['Id'] . "'
                AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC ")->result_array();
        //if(!empty($lastRead)){
        $lastRead = $lastReads[0]['Result'];
        $lastReadDate = $lastReads[0]['Created'] . '<br>' . $lastReads[0]['Time'];
        $listSites[] = array(
          "name" => $name, "Id" => $ID,
          "TestId" => $T_results['Id'], "Testtype" => $T_results['Test_Description'],
          "Device_ID" => $T_results['Test_Description'], "Batch" => $T_results['Device_Batch'],
          "Result" => $T_results['Result'], "Creat" => $T_results['Created'],
          "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results['Action'], "SiteName" => $site_name,
        );
        //}	
      }
    }
  }
  ///print_r($listSites);
  foreach ($listSites as $siteResult) {
  ?>
    <tr>
      <td>--</td>
      <td><?= $siteResult['name'] ?></td>
      <td><?= $siteResult['SiteName'] ?></td>
      <td><?= $siteResult['LastReadDate'] ?></td>
      <td><?= $siteResult['Batch'] ?></td>
      <td><?= $siteResult['Testtype'] ?></td>
      <?php if ($siteResult['Action'] == "School") { ?>
        <?php if ($siteResult['Result'] == '0') { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #00ab00;color: #ffffff;">Negative (-)</span></td>
        <?php } else { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #ff2e00;color: #d2d2d2;">Positive (+)</span></td>
        <?php } ?>
      <?php } else { ?>
        <?php if ($siteResult['Result'] == '0') { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #008700;color: #ffffff;">Negative (-)</span></td>
        <?php } else { ?>
          <td><span class="badge font-size-12" style="width: 100%;background-color: #B82100;color: #d2d2d2;">Positive (+)</span></td>
        <?php } ?>
      <?php } ?>
      <td><i class="uil uil-file" data-toggle="modal" data-target="#myModal" style="font-size: 19px;color: #2eb6ef;cursor: pointer;" onClick="UploadTheReportPdf(<?= $siteResult['TestId'] ?>);"></i></td>
      <td><?php if ($siteResult['Action'] == "School") { ?>
          <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="Set in Cleaning" width="20px" onClick="SET_SiteInAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Close For Sterilization">
        <?php } else { ?>
          <img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" alt="Remove" width="20px" onclick="Remove_SiteFromAction(<?= $siteResult['Id']; ?>);" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Sterilization  Done !">
        <?php } ?>
      </td>
    </tr>
<?php
  }
}
?>