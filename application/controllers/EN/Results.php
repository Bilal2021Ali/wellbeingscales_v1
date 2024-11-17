<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Results extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('session');

    $sessiondata = $this->session->userdata('admin_details');
    if (!isset($sessiondata)) {
      redirect('users');
      exit();
    }
  }

  public function index()
  {
    $sessiondata = $this->session->userdata('admin_details');
    $data['sessiondata'] = $sessiondata;
    $data['page_title'] = " Qlick Health | Enter Result ";
    $data['hasntnav'] = true;
    $dashlink = "";
    if ($this->uri->segment(3) && $this->uri->segment(3) == "Student" && $this->uri->segment(4)) {
      $data['userId'] = $this->uri->segment(4);
      $data['Type'] = "Student";
      $data['Student'] = "Student";
    } else {
      if (isset($sessiondata['admin_id']) && isset($sessiondata['type'])) {
        $data['userId'] = $sessiondata['admin_id'];
        $data['Type'] = $sessiondata['type'];
      } else {
        redirect("Users");
      }
    }

    if ($sessiondata['level'] == 2 || $sessiondata['level'] == 3) {
      if ($sessiondata['type'] = 'Ministry' || $sessiondata['type'] = 'Company') {
        $dashlink = base_url() . "EN/DashboardSystem";
      } else if ($sessiondata['type'] = 'Patient') {
        $dashlink = base_url() . "EN/Departments_Permition";
      } else if ($sessiondata['type'] = 'Satff' || $sessiondata['type'] = 'Teacher') {
        $dashlink = base_url() . "EN/School_Permition";
      } else {
        $dashlink = base_url();
      }
      $data['dashlink'] = $dashlink;
      $this->load->view("inc/header", $data);
      $this->load->view("addResult");
      $this->load->view("inc/footer");
    } else {
      $this->load->view("Global/YouCantEnter");
    }
  }

  public function Select_Child()
  {
    $sessiondata = $this->session->userdata('admin_details');
    $data['sessiondata'] = $sessiondata;
    $data['page_title'] = " Qlick Health | Enter Result ";
    $data['hasntnav'] = true;
    if ($sessiondata['level'] == 2 && $sessiondata['type'] == "Parent") {
      $this->load->view("inc/header", $data);
      $this->load->view("Parent/Select_Child");
      $this->load->view("inc/footer");
    }
  }


  public function StartAddResults()
  {
    $sessiondata = $this->session->userdata('admin_details');
    $symptoms = $this->input->post("symptoms");
    $Templatur = $this->input->post("Temp");
    $time_HS = date('H:i:s');
    if (is_array($symptoms)) {
      $symptomsVal = "";
      foreach ($symptoms as $symptom) {
        $symptomsVal .= $symptom . ";";
      }
    } else {
      $symptomsVal = $symptoms;
    }
    $User_Id = $sessiondata['admin_id'];
    $type = $sessiondata['type'];
    $today = date("Y-m-d");
    $time = date("Y-m-d");
    if ($this->db->query("INSERT INTO `l2_co_gateway_result` (`UserId`, `UserType`, `Result`, `Symptoms`, `Created`,`Time`) VALUES ('" . $User_Id . "', '" . $type . "', '" . $Templatur . "', '" . $symptomsVal . "', '" . date('Y-m-d') . "','" . $time_HS . "');")) {
?>
      <script>
        Swal.fire({
          title: 'Success!',
          text: ' Successfuly Inserted !! ',
          icon: 'success',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
    <?php } else { ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
    <?php
    }
  }


  public function StartAddResultsForstudent()
  {
    $sessiondata = $this->session->userdata('admin_details');
    $symptoms = $this->input->post("symptoms");
    $Templatur = $this->input->post("Temp");
    $time_HS = date('H:i:s');
    if (is_array($symptoms)) {
      $symptomsVal = "";
      foreach ($symptoms as $symptom) {
        $symptomsVal .= $symptom . ";";
      }
    } else {
      $symptomsVal = $symptoms;
    }
    $User_Id = $this->input->post("Stud_Id");
    $type = "Student";
    print_r($sessiondata);
    $today = date("Y-m-d");
    if ($this->db->query("INSERT INTO `l2_gateway_result` (`UserId`, `UserType`, `Added_By`, `Result`, `Symptoms`, `Created`, `Time`) VALUES ('" . $User_Id . "', '" . $type . "','" . $sessiondata['username'] . "' , '" . $Templatur . "', 
          '" . $symptomsVal . "', '" . date('Y-m-d') . "','" . $time_HS . "');")) {
    ?>
      <script>
        Swal.fire({
          title: 'Success!',
          text: ' Successfuly Inserted',
          icon: 'success',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
    <?php } else { ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
    <?php
    }
  }


  public function AddResultForStaff()
  {
    $id = $this->input->post("UserId");
    $testtype = $this->input->post("Test_type");
    $Templatur = $this->input->post("Temp");
    $time_HS = date('H:i:s');
    $Date = date('Y-m-d');
    if ($this->db->query("INSERT INTO `l2_gateway_result` (`UserId`, `UserType`, `Result`, `Device_Test` ,`Created`,`Time`) 
        VALUES ( '" . $id . "', 'Staff' , '" . $Templatur . "', '" . $testtype . "' ,'" . $Date . "','" . $time_HS . "');")) {
      //$this->db2_first_action($id,'Staff');
    ?>
      <script>
        $("#TrStafffId<?= $id; ?>").addClass("AddedSuccess");
        $("#TrStafffId<?= $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
        setTimeout(function() {
          $("#TrStafffId<?= $id; ?>").slideUp();
        }, 1000);
      </script>
    <?php } else { ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
      <?php
    }
  }

  /*public function db2_first_action(){
		  $this->load->model('Test_db2');	   
		  $this->Test_db2->sync_two_databases();	   
}*/

  public function AddCovidResult()
  {
    $id = $this->input->post("UserId");
    $Usertype = $this->input->post("Test_type");
    $Templatur = $this->input->post("Temp");
    $Device_Id = $this->input->post("Device");
    $Device_batch = $this->input->post("Batch");
    $test = $this->input->post("Test");
    //$Test_Description = $Device_array['2'];

    //print_r($Device_array);
    $time_HS = date('H:i:s');
    $date = date("Y-m-d");
    if (!empty($Device_Id)) {
      if ($this->db->query("INSERT INTO `l2_labtests` (`UserId`, `UserType`, `Result`, `Device_Test` , 
            `Device_Batch` , `Test_Description` ,`Created`,`Time`) 
            VALUES ( '" . $id . "', '" . $Usertype . "' , '" . $Templatur . "' , '" . $Device_Id . "' , '" . $Device_batch . "' , 
            '" . $test . "' ,'" . $date . "','" . $time_HS . "');")) {
      ?>
        <script>
          $("#<?= $Usertype . '_' . $id; ?>").addClass("AddedSuccess");
          $("#<?= $Usertype . '_' . $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function() {
            $("#<?= $Usertype . '_' . $id; ?>").slideUp();
          }, 1000);
        </script>
      <?php } else { ?>
        <script>
          Swal.fire({
            title: 'Error!',
            text: 'Ooops! An error was encountered.',
            icon: 'error',
            confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function() {
            location.reload();
          }, 1500);
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
      <?php
    }
  }

  public function AddCovidResult_Co()
  {
    $id = $this->input->post("UserId");
    $Usertype = $this->input->post("Test_type");
    $Templatur = $this->input->post("Temp");
    $Device_Id = $this->input->post("Device");
    $Device_batch = $this->input->post("Batch");
    $test = $this->input->post("Test");
    //$Test_Description = $Device_array['2'];
    //print_r($Device_array);
    $time_HS = date('H:i:s');
    if (!empty($Device_Id)) {
      if ($this->db->query("INSERT INTO `l2_co_labtests` (`UserId`, `UserType`, `Result`, `Device_Test` , 
            `Device_Batch` , `Test_Description` ,`Created`,`Time`) 
            VALUES ( '" . $id . "', '" . $Usertype . "' , '" . $Templatur . "' , '" . $Device_Id . "' , '" . $Device_batch . "' , 
            '" . $test . "' ,'" . date('Y-m-d') . "','" . $time_HS . "');")) {
      ?>
        <script>
          $("#<?= str_replace(" ", "__", $Usertype) . '_' . $id; ?>").addClass("AddedSuccess");
          $("#<?= str_replace(" ", "__", $Usertype) . '_' . $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function() {
            $("#<?= str_replace(" ", "__", $Usertype) . '_' . $id; ?>").slideUp();
          }, 1000);
        </script>
      <?php } else { ?>
        <script>
          Swal.fire({
            title: 'Error!',
            text: 'Ooops! An error was encountered.',
            icon: 'error',
            confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function() {
            location.reload();
          }, 1500);
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
    <?php
    }
  }


  public function AddResultForTeacher()
  {
    $id = $this->input->post("UserId");
    $Templatur = $this->input->post("Temp");
    $time_HS = date('H:i:s');
    $Date = date('Y-m-d');
    $dev_type = $this->input->post("Test_type");
    if ($this->db->query("INSERT INTO `l2_gateway_result` (`UserId`, `UserType`, `Result`, `Device_Test` , `Created`,`Time`) 
        VALUES ( '" . $id . "', 'Teacher' , '" . $Templatur . "', '" . $dev_type . "' ,'" . $Date . "','" . $time_HS . "');")) {
    ?>
      <script>
        $("#TrTeacherId<?= $id; ?>").addClass("AddedSuccess");
        $("#TrTeacherId<?= $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
        setTimeout(function() {
          $("#TrTeacherId<?= $id; ?>").slideUp();
        }, 1000);
      </script>
    <?php } else { ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
    <?php
    }
  }

  public function AddResultForStudent()
  {
    $id = $this->input->post("UserId");
    $Templatur = $this->input->post("Temp");
    $DevType = $this->input->post("ST_Type");
    $time_HS = date('H:i:s');
    $Date = date('Y-m-d');
    if ($this->db->query("INSERT INTO `l2_gateway_result` (`UserId`, `UserType`, `Result`, `Device_Test`,`Created`,`Time`) 
        VALUES ( '" . $id . "', 'Student' , '" . $Templatur . "', '" . $DevType . "' ,'" . $Date . "','" . $time_HS . "');")) {
    ?>
      <script>
        $("#TrStudId<?= $id; ?>").addClass("AddedSuccess");
        $("#TrStudId<?= $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
        setTimeout(function() {
          $("#TrStudId<?= $id; ?>").slideUp();
        }, 1000);
      </script>
    <?php } else { ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Ooops! An error was encountered.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
      <?php
    }
  }

  public function AddResultForPatients()
  {
    if ($this->input->post("UserId") && $this->input->post("Temp") && $this->input->post("prefix")) {
      $id = $this->input->post("UserId");
      $Templatur = $this->input->post("Temp");
      $prefx = $this->input->post("prefix");
      $time = date('H:i:s');
      if ($this->db->query("INSERT INTO `l2_co_gateway_result` (`UserId`, `UserType`, `Result`, `Created`,`Time`) 
          VALUES ( '" . $id . "', '" . $prefx . "' , '" . $Templatur . "', '" . date('Y-m-d') . "','" . $time . "');")) {
      ?>
        <script>
          Swal.fire({
            title: 'Success!',
            text: ' Successfuly Inserted !! ',
            icon: 'success',
            confirmButtonColor: '#5b8ce8',
            timer: 1000,
          });

          $('#TrId<?= $id; ?>').remove();
        </script>
      <?php } else { ?>
        <script>
          Swal.fire({
            title: 'Error!',
            text: 'Ooops! An error was encountered.',
            icon: 'error',
            confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function() {
            location.reload();
          }, 1500);
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Kindly enter data.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
      <?php
    }
  }
  public function AddResultForCoPatients()
  {
    if ($this->input->post("UserId") && $this->input->post("Temp") && $this->input->post("prefix")) {
      $id = $this->input->post("UserId");
      $Templatur = $this->input->post("Temp");
      $prefx = $this->input->post("prefix");
      $time = date('H:i:s');
      if ($this->db->query("INSERT INTO `l2_co_gateway_result` (`UserId`, `UserType`, `Result`, `Created`,`Time`) 
            VALUES ( '" . $id . "', '" . $prefx . "' , '" . $Templatur . "', '" . date('Y-m-d') . "','" . $time . "');")) {
      ?>
        <script>
          $('#TrId<?= $id; ?>').remove();
        </script>
      <?php } else { ?>
        <script>
          Swal.fire({
            title: 'Error!',
            text: 'Ooops! An error was encountered.',
            icon: 'error',
            confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function() {
            location.reload();
          }, 1500);
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        Swal.fire({
          title: 'Error!',
          text: 'Kindly enter data.',
          icon: 'error',
          confirmButtonColor: '#5b8ce8',
        });
        setTimeout(function() {
          location.reload();
        }, 1500);
      </script>
      <?php
    }
  }


  public function SelectByPrefix_co()
  {
    if ($this->input->post("Pref")) {
      $sessiondata = $this->session->userdata('admin_details');
      $pef = $this->input->post("Pref");
      $Added_By = $sessiondata['admin_id'];
      if ($pef == "ref") {
        //co_machine
        $list = $this->db->query(" SELECT * FROM `co_machine`
            JOIN 
            WHERE `Added_By` = '" . $Added_By . "' ")->result_array();
        if (empty($list)) {
      ?>
          <div class="card-body">
            <div class="card-title text-center"> sorry we don't have any data to show </div>
          </div>
        <?php  } else { ?>
          <div class="card-body">
            <div class="card-title text-center"> users list
              <hr>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th> Img </th>
                  <th> Name </th>
                  <th> Type </th>
                  <th> Add </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($list as $sn => $refg) { ?>
                  <tr id="TrId<?= $refg['Id']; ?>">
                    <th scope="row"> <?= $sn + 1; ?>
                    </th>
                    <td><?= $refg['name'] ?></td>
                    <td><?= $refg['type']; ?></td>
                    <td>
                      <form class="AddResultPatient">
                        <input type="number" class="form-control form-control-sm" placeholder=" أدخل النتيجة" name="Temp" value="37">
                        <input type="hidden" value="<?= $refg['Id']; ?>" name="UserId">
                        <input type="hidden" value="<?= $pef; ?>" name="prefix">
                      </form>
                    </td>
                  </tr>
                <?php  } ?>
              </tbody>
            </table>
            <script>
              $(".AddResultPatient").on('focusout', function(e) {
                e.preventDefault();
                $.ajax({
                  type: 'POST',
                  url: '<?= base_url(); ?>AR/Results/AddResultForCoPatients',
                  data: new FormData(this),
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function(data) {
                    $('.JHZLNS').html(data);
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
          </div>
        <?php
        }
      } else {
        $list = $this->db->query("SELECT * FROM `l2_co_patient` WHERE `UserType` = '" . $pef . "'
        AND Added_By = '" . $Added_By . "' ")->result_array();
        if (empty($list)) {
        ?>
          <div class="card-body">
            <div class="card-title text-center"> sorry no data found </div>
          </div>
        <?php } else { ?>
          <div class="card-body">
            <div class="card-title text-center"> Users list
              <hr>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th> Img </th>
                  <th> Name </th>
                  <th> National ID </th>
                  <th> Usertype </th>
                  <th> Add </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sn = 0;
                foreach ($list as $admin) {
                  $sn++;
                ?>
                  <tr id="TrId<?= $admin['Id']; ?>">
                    <td style="width: 20px;"><?php
                                              $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                            WHERE `For_User` = '" . $admin['Id'] . "' AND `Type_Of_User` = '" . $admin["UserType"] . "' LIMIT 1 ")->result_array();
                                              ?>
                      <?php if (empty($avatar)) {  ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                      <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                      <?php } ?>
                    </td>
                    <td><?= $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                    <td><?= $admin['National_Id']; ?></td>
                    <td><?= $admin['UserType']; ?></td>
                    <td>
                      <form class="AddResultPatient">
                        <input type="number" class="form-control form-control-sm" placeholder=" أدخل النتيجة" name="Temp" value="37">
                        <input type="hidden" value="<?= $admin['Id']; ?>" name="UserId">
                        <input type="hidden" value="<?= $pef; ?>" name="prefix">
                      </form>
                    </td>
                  </tr>
                <?php  } ?>
              </tbody>
            </table>
            <script>
              $(".AddResultPatient").on('focusout', function(e) {
                e.preventDefault();
                $.ajax({
                  type: 'POST',
                  url: '<?= base_url(); ?>AR/Results/AddResultForCoPatients',
                  data: new FormData(this),
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function(data) {
                    $('.JHZLNS').html(data);
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
          </div>
    <?php
        }
      }
    }
  }


  public function Batch_Counter()
  {
    $devicedata = $this->input->post("Device");
    $Device_array = explode('@', $devicedata);
    $Device_batch = $Device_array['1'];
    $count = $this->db->query("SELECT * FROM `l2_labtests` WHERE Device_Batch = '" . $Device_batch . "' ")->num_rows();
    echo $count;
  }

  public function GetTotalIn_all($from, $To)
  {
    /*$from = 37.6;
   $To = 40.1;
   $In = 'School';*/
    $counter = 0;
    //$this->load->library( 'session' ); 
    $sessiondata = $this->session->userdata('admin_details');
    $today = date("Y-m-d");
    $list = array();
    $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];
      $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
   AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
      // AND `Result` > ".$from." AND `Result` < ".$To."
      foreach ($getResults as $results) {
        if ($results['Result'] >= $from && $results['Result'] <= $To) {
          $counter++;
        }
      }
    }
    $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'
   ")->result_array();
    foreach ($OurTeachers as $Teacher) {
      $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
      $T_ID = $Teacher['Id'];
      $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
   AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
      foreach ($getResultsT as $results) {
        if ($results['Result'] >= $from && $results['Result'] <= $To) {
          $counter++;
        }
      }
    }
    $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($OurStudents as $Student_çJDJD) {
      $getResults_Student = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Student_çJDJD['Id'] . "'
   AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
      foreach ($getResults_Student as $results) {
        if ($results['Result'] >= $from && $results['Result'] <= $To) {
          $counter++;
        }
      }
    }
    //echo $counter;
    return ($counter);
  }

  private function GetTotalIn($from, $To, $In = null)
  {
    $sessiondata = $this->session->userdata('admin_details');
    $counter = 0;
    $today = date("Y-m-d");
    $inCond = $In == null ? "" : " AND `Action` = '" . $In . "'";

    $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE 
      `Added_By` = '" . $sessiondata['admin_id'] . "' $inCond ")->result_array();
    $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE
      `Added_By` = '" . $sessiondata['admin_id'] . "' $inCond ")->result_array();
    $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE
      `Added_By` = '" . $sessiondata['admin_id'] . "' $inCond ")->result_array();

    if (!empty($Ourstaffs)) {
      $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN (" . implode(",", array_column($Ourstaffs, "Id")) . ")
          AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
      foreach ($getResults as $results) {
        if ($results['Result'] >= $from && $results['Result'] <= $To) {
          $counter++;
        }
      }
    }

    if (!empty($OurTeachers)) {
      $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN (" . implode(",", array_column($OurTeachers, "Id")) . ")
          AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
      foreach ($getResultsT as $results) {
        if ($results['Result'] >= $from && $results['Result'] <= $To) {
          $counter++;
        }
      }
    }

    if (!empty($OurStudents)) {
      $getResultsS = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN (" . implode(",", array_column($OurStudents, "Id")) . ")
          AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1")->result_array();
      foreach ($getResultsS as $results) {
        if ($results['Result'] >= $from && $results['Result'] <= $To) {
          $counter++;
        }
      }
    }

    return ($counter);
  }

  public function GetResultsCounterFor()
  {
    $type = $this->input->post('TeatsType');
    if (strtolower($type) == 'all') {
      $data['tempr']['NORMAL'] = $this->GetTotalIn(36.3, 37.5, null);
      $data['tempr']['LOW'] = $this->GetTotalIn(0, 36.2, null);
      $data['tempr']['LOW_In_Home'] = $this->GetTotalIn(0, 36.2, 'Home');
      $data['tempr']['LOW_In_Quern'] = $this->GetTotalIn(0, 36.2, 'Quarantine');
      $data['tempr']['LOW_In_School'] = $this->GetTotalIn(0, 36.2, 'School');
      $data['tempr']['MODERATE'] = $this->GetTotalIn(37.6, 38.4, null);
      $data['tempr']['MODERATE_In_Home'] = $this->GetTotalIn(37.6, 38.4, 'Home');
      $data['tempr']['MODERATE_In_Quern'] = $this->GetTotalIn(37.6, 38.4, 'Quarantine');
      $data['tempr']['MODERATE_In_School'] = $this->GetTotalIn(37.6, 38.4, 'School');
      $data['tempr']['HIGH'] = $this->GetTotalIn(38.5, 45, null);
      $data['tempr']['HIGH_In_Home'] = $this->GetTotalIn(38.5, 45, 'Home');
      $data['tempr']['HIGH_In_Quern'] = $this->GetTotalIn(38.5, 45, 'Quarantine');
      $data['tempr']['HIGH_In_School'] = $this->GetTotalIn(38.5, 45, 'School');
      $this->load->view("EN/schools/inc/temprature-results", $data);
      $list_Tests = $this->db->query("SELECT * FROM `r_testcode`")->result_array();
      foreach ($list_Tests as $test) {
        $this->testsresults($test['Test_Desc']);
      }
    } else {
      $this->testsresults($type);
    }
  }

  private function testsresults($type)
  {
    ?>
    <div class="col-xl-12">
      <div class="card-body" style="border-radius: 5px;border: 3px solid #0eacd8;padding: 9px;">
        <h4 class="card-title"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Lab_Counter.png" style="width: 25px;margin: auto 5px;">
          <?= $type; ?>
        </h4>
      </div>
    </div>
    <div class="col-md-4 col-xl-4 text-center">
      <div class="card notStatic">
        <div class="card-body" style="padding: 5px;">
          <div class="card-body badge-soft-danger" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #f57d6a;">
            <div>
              <div class="row">
                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/positive.png" alt="Temperature" style="width: 70px;margin-top: 5px;"> </div>
                <div class="col-xl-8">
                  <p class="mb-0 badge badge-danger font-size-12" style="width: 103px;">Positive (+)</p>
                  <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home
                    <?= $this->GetTotal('1', $type, 'Home') ?>
                  </span> <span class="badge font-size-12" style="width: 104px;background-color: #ff0000;color: #fff;margin: 5px auto;display: block;">Quarantine
                    <?= $this->GetTotal('1', $type, 'Quarantine') ?>
                  </span> <span class="badge font-size-12" style="width: 104px;background-color: #34c38f;color: #fff;margin: 5px auto;display: block;">No Action
                    <?= $this->GetTotal('1', $type, 'School') ?>
                  </span>
                </div>
                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                  <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $this->GetTotal('1', $type) ?>
                    </span> </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xl-4 text-center">
      <div class="card notStatic">
        <div class="card-body" style="padding: 5px;box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);">
          <div class="card-body badge-soft-success" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #34ccc7;">
            <div>
              <div class="row">
                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/negative.png" alt="Temperature" style="width: 70px;margin-top: 5px;"> </div>
                <div class="col-xl-8">
                  <p class="mb-0 badge badge-success font-size-12" style="width: 103px;">Negative (-)</p>
                  <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home
                    <?= $this->GetTotal('0', $type, 'Home') ?>
                  </span> <span class="badge font-size-12" style="width: 104px;background-color: #ff0000;color: #fff;margin: 5px auto;display: block;">Quarantine
                    <?= $this->GetTotal('0', $type, 'Quarantine') ?>
                  </span> <span class="badge font-size-12" style="width: 104px;background-color: #34c38f;color: #fff;margin: 5px auto;display: block;">No Action
                    <?= $this->GetTotal('0', $type, 'School') ?>
                  </span>
                </div>
                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                  <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $this->GetTotal('0', $type) ?>
                    </span> </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xl-4 text-center">
      <div class="card notStatic">
        <div class="card-body" style="padding: 5px">
          <div class="card-body badge-soft-info" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #50a5f1;">
            <div class="row">
              <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/pandemic-128.png" alt="Temperature" style="width: 50px;margin-top: 5px;"> </div>
              <div class="col-xl-8">
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                    <?= $this->GetTotal_Not($type); ?>
                  </span> </h4>
                <p class="mb-0 badge badge-info font-size-12" style="width: 103px;">No Test</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }

  private function GetTotal($where, $type, $action = "")
  {
    $counter = 0;
    //$this->load->library( 'session' ); 
    $sessiondata = $this->session->userdata('admin_details');
    $today = date("Y-m-d");
    $list = array();
    $cond = $type == "all" ? "" : " AND `Test_Description` = '" . $type . "' ";

    $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];

      if (!empty($action)) {
        $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
        AND Created = '" . $today . "' AND UserType = 'Staff' AND `Result` = '" . $where . "' $cond AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      } else {
        $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
        AND Created = '" . $today . "' AND UserType = 'Staff' AND `Result` = '" . $where . "' $cond ORDER BY `Id` DESC LIMIT 1")->result_array();
      }

      foreach ($getResults as $results) {
        $counter++;
      }
    }

    $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($OurTeachers as $Teacher) {
      $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
      $T_ID = $Teacher['Id'];
      if (!empty($action)) {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Result` = '" . $where . "' $cond  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      } else {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Result` = '" . $where . "' $cond ORDER BY `Id` DESC LIMIT 1")->result_array();
      }
      foreach ($getResultsT as $results) {
        $counter++;
      }
    }

    $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($OurStudents as $Student) {
      if (!empty($action)) {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student'  AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "'  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      } else {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student'  AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      }
      foreach ($getResultsT as $results) {
        $counter++;
      }
    }

    return ($counter);
  }

  private function GetTotal_Not($type, $action = "")
  {
    $counter = 0;
    //$this->load->library( 'session' ); 
    $sessiondata = $this->session->userdata('admin_details');
    $today = date("Y-m-d");
    $list = array();

    $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];

      if (!empty($action)) {
        $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Staff' AND `Test_Description` = '" . $type . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
      } else {
        $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Staff' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      }
      if (empty($getResults)) {
        $counter++;
      }
    }

    $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($OurTeachers as $Teacher) {
      $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
      $T_ID = $Teacher['Id'];
      if (!empty($action)) {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Test_Description` = '" . $type . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
      } else {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      }
      if (empty($getResultsT)) {
        $counter++;
      }
    }

    $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    foreach ($OurStudents as $Student) {
      if (!empty($action)) {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student'  AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      } else {
        $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
      }
      if (empty($getResultsT)) {
        $counter++;
      }
    }

    return ($counter);
  }


  private function data_of_dept_co($sessiondata, $device)
  {
    $ci = &get_instance();
    $list = array();
    $today = date("Y-m-d");

    $Ourstaffs = $ci->db->query("SELECT * FROM l2_co_patient 
WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();

    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];
      $Position_Staff = $staff['Position'];
      $type = $staff['UserType'];

      $lastresult = $ci->db->query(" SELECT * FROM l2_co_gateway_result  WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` = '" . $device . "' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
      $first_result = $ci->db->query("SELECT * FROM l2_co_gateway_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` = '" . $device . "' ORDER BY `Id` ASC LIMIT 1 ")->result_array();


      if (!empty($lastresult) && !empty($first_result)) {
        $list[] = array(
          "Username" => $staffname, "Id" => $ID, "LastResult" => $lastresult[0]['Result'], "FirstResult" => $first_result[0]['Result'],
          'position' => $Position_Staff, "first_result_Creat" => $first_result[0]['Created'], "first_result_time" => $first_result[0]['Time'],
          "last_result_Creat" => $lastresult[0]['Created'], "last_result_time" => $lastresult[0]['Time'], 'usertype' => $staff['UserType']
        );
      }
    }

    return ($list);
  }


  private function data_of_user($type, $sessiondata, $device, $dates = ["from" => "", "to" => ""])
  {
    $ci = &get_instance();
    $list = array();
    $today = date("Y-m-d");

    if ($type == "Staff") {
      $Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    } elseif ($type == "Teacher") {
      $Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    } elseif ($type == "Student") {
      $Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
    }

    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];
      $Position_Staff = $type;
      $datecond = "";
      if ((!isset($dates["from"]) || empty($dates["from"])) && (!isset($dates["to"]) || empty($dates["to"]))) {
        $datecond = "AND Created = '" . $today . "'";
      }

      if (isset($dates["from"]) && !empty($dates["from"])) {
        $datecond = "AND Created >= '" . $today . "'";
      }

      if (isset($dates["to"]) && !empty($dates["to"])) {
        $datecond .= "AND Created <= '" . $today . "'";
      }

      $sql = " SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "'
      $datecond AND UserType = '" . $type . "' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' AND `Device` = '" . $device . "' 
      ORDER BY `Id` DESC LIMIT 1 ";

      $result = $ci->db->query($sql)->result_array();

      //foreach($getResults as $results){
      //$creat = $results['Created'].' '.$results['Time'];

      if (!empty($result)) {
        $list[] = array(
          "Username" => $staffname, "Id" => $ID, "LastResult" => $result[0]['Result_out'], "FirstResult" => $result[0]['Result'],
          'position' => $Position_Staff, "first_result_Creat" => $result[0]['Created'], "first_result_time" => $result[0]['Time'],
          "last_result_Creat" => $result[0]['Date_out'], "last_result_time" => $result[0]['Time_out']
        );
      }

      //} 
    }
    return ($list);
  }


  private function data_of_user_by_id($type, $sessiondata, $id, $dates = ["from" => "", "to" => ""])
  {
    $ci = &get_instance();
    $list = array();
    $today = date("Y-m-d");

    if ($type == "Staff") {
      $Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE
            `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();
    } elseif ($type == "Teacher") {
      $Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();
    } elseif ($type == "Student") {
      $Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
            `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();
    } else {
      $Ourstaffs = array();
    }

    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];
      $Position_Staff = $staff['Position'];

      $datecond = "";
      if ((!isset($dates["from"]) || empty($dates["from"])) && (!isset($dates["to"]) || empty($dates["to"]))) {
        $datecond = "AND Created = '" . $today . "'";
      }

      if (isset($dates["from"]) && !empty($dates["from"])) {
        $datecond = "AND Created >= '" . $today . "'";
      }

      if (isset($dates["to"]) && !empty($dates["to"])) {
        $datecond = "AND Created <= '" . $today . "'";
      }

      $results = $ci->db->query(" SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "' 
            $datecond AND UserType = '" . $type . "' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' 
            AND `Device` != '' ORDER BY `Id` DESC ")->result_array();
      $our_devices = $this->db->query(" SELECT * FROM `l2_devices` ")->result_array();
      if (!empty($results)) {
        foreach ($results as $reslt) {
          $deviceData = $this->db->query(" SELECT * FROM `l2_devices` WHERE `D_Id` = '" . $reslt['Device'] . "' ")->result_array();
          $Device_desc = "---";
          $Site = "---";
          if (!empty($deviceData)) {
            $Device_desc = $deviceData[0]['Description'];
            $Site = $deviceData[0]['Site'];
          }

          $list[] = array(
            "Username" => $staffname, "Id" => $ID, "LastResult" => $reslt['Result'], "FirstResult" => $reslt['Result'],
            "position" => $Position_Staff, "first_result_Creat" => $reslt['Created'], "first_result_time" => $reslt['Time'],
            "last_result_Creat" => $reslt['Date_out'], "last_result_time" => $reslt['Time_out'], "Device_desc" => $Device_desc,
            "Site" => $Site
          );
        }
      }
    }
    return ($list);
  }

  private function data_of_user_by_id_for_co($type, $sessiondata, $id)
  {
    $ci = &get_instance();
    $list = array();
    $today = date("Y-m-d");

    $Ourstaffs = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE
        `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();


    foreach ($Ourstaffs as $staff) {
      $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
      $ID = $staff['Id'];
      $Position_Staff = $staff['Position'];

      $lastresult = $ci->db->query(" SELECT * FROM l2_co_history_result WHERE `UserId` = '" . $staff['Id'] . "' 
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` != '' ORDER BY `Id` DESC ")->result_array();
      $first_result = $ci->db->query("SELECT * FROM l2_co_history_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` != '' ORDER BY `Id` ASC  ")->result_array();


      //foreach($getResults as $results){
      //$creat = $results['Created'].' '.$results['Time'];

      $our_devices = $this->db->query(" SELECT * FROM `l2_co_devices` ")->result_array();

      if (!empty($lastresult) && !empty($first_result)) {
        foreach ($lastresult as $reslt) {
          $deviceData = $this->db->query(" SELECT * FROM `l2_co_devices` WHERE `D_Id` = '" . $reslt['Device'] . "' ")->result_array();

          $Device_desc = "";
          $Site = "";

          if (!empty($deviceData)) {
            $Device_desc = $deviceData[0]['Description'];
            $Site = $deviceData[0]['Site'];
          }

          $list[] = array(
            "Username" => $staffname, "Id" => $ID, "LastResult" => $reslt['Result'], "FirstResult" => $first_result[0]['Result'],
            "position" => $Position_Staff, "first_result_Creat" => $first_result[0]['Created'], "first_result_time" => $first_result[0]['Time'],
            "last_result_Creat" => $reslt['Created'], "last_result_time" => $reslt['Time'], "Device_desc" => $Device_desc,
            "Site" => $Site, "UserType" => $type
          );
        }
        /*
echo sizeof($lastresult);
	print_r($lastresult);
*/
      }

      //} 
    }
    return ($list);
  }

  private function symps($symps)
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

  public function boxes_Colors($result, $risk = "")
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

      <?php } ?>
    </td>
    <?php if (empty($risk)) { ?>
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
    <?php  } ?>
    <?php
  }


  public function getResultsbyDevice()
  {
    $this->load->library('session');
    $sessiondata = $this->session->userdata('admin_details');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('type', 'type', 'trim|required');
    if ($this->form_validation->run()) {
      $this->load->model('schools/sv_school_reports'); // loading the model

      $device = $this->input->post("type");
      $Staff_list = $this->data_of_user("Staff", $sessiondata, $device, ["from" => $this->input->post("from") ?? "", "to" =>  $this->input->post("to") ?? ""]);
      $Student_list = $this->data_of_user("Student", $sessiondata, $device, ["from" => $this->input->post("from") ?? "", "to" =>  $this->input->post("to") ?? ""]);
      $Teacher_list = $this->data_of_user("Teacher", $sessiondata, $device, ["from" => $this->input->post("from") ?? "", "to" =>  $this->input->post("to") ?? ""]);

    ?>
      <div class="col-12">
        <div class="control_results col-md-12" style="padding-bottom: 15px;">
          <button type="button" form_target="Staff_list_results" class="btn btn-primary w-md contr_btn"> <i class="uil uil-list"></i>Staff </button>
          <button type="button" form_target="Teachers_list_results" class="btn w-md contr_btn"> <i class="uil uil-list"></i>Teacher </button>
          <button type="button" form_target="Studnts_list_results" class="btn w-md contr_btn"> <i class="uil uil-list"></i>Student </button>
        </div>
        <!-- end control -->

        <div class="row formcontainer_results" id="Staff_list_results">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"> Staff </h4>
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <?php $title_in = "Time in" ?>
                    <?php $title_out = "Time out" ?>
                    <tr>
                      <th> Img </th>
                      <th> Name </th>
                      <th> First Result </th>
                      <th> Last Result </th>
                      <th> <?= $title_in; ?>
                      </th>
                      <th> <?= $title_out ?>
                      </th>
                      <th> Total </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($Staff_list as $staffsRes) { ?>
                      <tr>
                        <td style="width: 20px;"><?php
                                                  $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                    WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                  ?>
                          <?php if (empty($avatar)) {  ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                          <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                          <?php } ?>
                        </td>
                        <td>
                          <h6 class="font-size-15 mb-1 font-weight-normal">
                            <?= $staffsRes['Username']; ?>
                          </h6>
                          <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                            <?= $staffsRes['position']; ?>
                          </p>
                        </td>
                        <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                        <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                        <td><?= $staffsRes['first_result_time'] ?></td>
                        <td><?= $staffsRes['last_result_time'] ?></td>
                        <td><?php
                            $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                            ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row formcontainer_results" id="Studnts_list_results">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"> Students </h4>
                <div class="students_button"></div>
                <table id="Students_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                      <th> Img </th>
                      <th> Name </th>
                      <th> First Result </th>
                      <th> Last Result </th>
                      <th> <?= $title_in; ?>
                      </th>
                      <th> <?= $title_out ?>
                      </th>
                      <th> Total </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($Student_list as $studentResults) { ?>
                      <tr>
                        <td style="width: 20px;"><?php
                                                  $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $studentResults['Id'] . "' AND
											 `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                                  ?>
                          <?php if (empty($avatar)) {  ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                          <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                          <?php } ?>
                        </td>
                        <td>
                          <h6 class="font-size-15 mb-1 font-weight-normal">
                            <?= $studentResults['Username']; ?>
                          </h6>
                          <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                            <?= $studentResults['position']; ?>
                          </p>
                        </td>
                        <?php $this->boxes_Colors($studentResults['FirstResult'], "Show"); ?>
                        <?php $this->boxes_Colors($studentResults['LastResult'], "Show"); ?>
                        <td><?= $studentResults['first_result_time'] ?></td>
                        <td><?= $studentResults['last_result_time'] ?></td>
                        <td><?php
                            $this->between($studentResults['first_result_time'], $studentResults['last_result_time']);
                            ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row formcontainer_results" id="Teachers_list_results">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"> Teachers </h4>
                <table id="Teacher_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                      <th> Img </th>
                      <th> Name </th>
                      <th> First Result </th>
                      <th> Last Result </th>
                      <th> <?= $title_in; ?>
                      </th>
                      <th> <?= $title_out ?>
                      </th>
                      <th> Total </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($Teacher_list as $TeacherResults) { ?>
                      <tr>
                        <td style="width: 20px;"><?php
                                                  $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $TeacherResults['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                                  ?>
                          <?php if (empty($avatar)) {  ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                          <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                          <?php } ?>
                        </td>
                        <td>
                          <h6 class="font-size-15 mb-1 font-weight-normal">
                            <?= $TeacherResults['Username']; ?>
                          </h6>
                          <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                            <?= $TeacherResults['position']; ?>
                          </p>
                        </td>
                        <?php $this->boxes_Colors($TeacherResults['FirstResult'], "Show"); ?>
                        <?php $this->boxes_Colors($TeacherResults['LastResult'], "Show"); ?>
                        <td><?= $TeacherResults['first_result_time'] ?></td>
                        <td><?= $TeacherResults['last_result_time'] ?></td>
                        <td><?php
                            $this->between($TeacherResults['first_result_time'], $TeacherResults['last_result_time']);
                            ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <script>
        $('#Teachers_list_results').hide();
        $('#Studnts_list_results').hide();

        $('#Staff_list_results').show();

        $('.control_results button').click(function() {
          $('.control_results button').removeClass('btn-primary');
          $(this).addClass('btn-primary');
          $('.formcontainer_results').hide();
          var to = $(this).attr('form_target');
          $('#' + to).show();
        });
      </script>
    <?php
    } else {
    ?>
      <script>
        Swal.fire({
          title: ' Sorry.',
          text: 'Error was found. Please try again later.',
          icon: 'error'
        });
      </script>
    <?php
    }
  }


  public function getResultsbyDevice_co()
  {
    $this->load->library('session');
    $sessiondata = $this->session->userdata('admin_details');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('type', 'type', 'trim|required');
    if ($this->form_validation->run()) {
      $device = $this->input->post("type");
      $Staff_list = $this->data_of_dept_co($sessiondata, $device);
    ?>
      <div class="container">
        <div class="row formcontainer_results" id="Staff_list_results">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">

                <h4 class="card-title"> Results: </h4>
                <table id="data_results" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">

                  <thead>
                    <?php $title_in = "Time in" ?>
                    <?php $title_out = "Time out" ?>
                    <tr>
                      <th> Img </th>
                      <th> Name </th>
                      <th> First Result </th>
                      <th> Last Result </th>
                      <th> <?= $title_in; ?>
                      </th>
                      <th> <?= $title_out ?>
                      </th>
                      <th> Total </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($Staff_list as $staffsRes) { ?>
                      <tr>
                        <td style="width: 20px;"><?php
                                                  $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                                                    WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = '" . $staffsRes['usertype'] . "' LIMIT 1 ")->result_array();
                                                  ?>
                          <?php if (empty($avatar)) {  ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                          <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                          <?php } ?>
                        </td>
                        <td>
                          <h6 class="font-size-15 mb-1 font-weight-normal">
                            <?= $staffsRes['Username']; ?>
                          </h6>
                          <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                            <?= $staffsRes['position']; ?>
                          </p>
                        </td>
                        <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                        <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                        <td><?= $staffsRes['first_result_time'] ?></td>
                        <td><?= $staffsRes['last_result_time'] ?></td>
                        <td><?php
                            $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                            ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <script>
        var table_st = $('#data_results').DataTable({
          lengthChange: false,
          buttons: ['copy', 'excel', 'pdf', 'colvis'],
        });
        table_st.buttons().container().appendTo('#data_results_wrapper .col-md-6:eq(0)');

        $('#Teachers_list_results').hide();
        $('#Studnts_list_results').hide();

        $('#Staff_list_results').show();

        $('.control_results button').click(function() {
          $('.control_results button').removeClass('btn-primary');
          $(this).addClass('btn-primary');
          $('.formcontainer_results').hide();
          var to = $(this).attr('form_target');
          $('#' + to).show();
        });
      </script>
    <?php
    } else {
    ?>
      <script>
        Swal.fire({
          title: ' Sorry.',
          text: 'Error was found. Please try again later.',
          icon: 'error'
        });
      </script>
      <?php
    }
  }

  public function getResultsbyuser()
  {
    $this->load->library('session');
    $sessiondata = $this->session->userdata('admin_details');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('userid', 'userid', 'trim|required');
    $this->form_validation->set_rules('usertype', 'usertype', 'trim|required');
    if ($this->form_validation->run()) {
      $id = $this->input->post("userid");
      $type = $this->input->post("usertype");
      $userdata = $this->data_of_user_by_id($type, $sessiondata, $id, ["from" => $this->input->post("from") ?? "", "to" =>  $this->input->post("to") ?? ""]); // get data
      if (!empty($userdata)) {
      ?>
        <div class="container">

          <!-- end !-->
          <div class="row formcontainer">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Results:</h4>
                  <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                        <th> Img </th>
                        <th> Name </th>
                        <th> First Result </th>
                        <th> Last Result </th>
                        <th> Time in </th>
                        <th> Time out </th>
                        <th> Total </th>
                        <th> Site </th>
                        <th> Device Desc </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($userdata as $staffsRes) { ?>
                        <tr>
                          <td style="width: 20px;"><?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                        WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                    ?>
                            <?php if (empty($avatar)) {  ?>
                              <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                              <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                          </td>
                          <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal">
                              <?= $staffsRes['Username']; ?>
                            </h6>
                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                              <?= $staffsRes['position']; ?>
                            </p>
                          </td>
                          <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                          <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                          <td><?= $staffsRes['first_result_time'] ?></td>
                          <td><?= $staffsRes['last_result_time'] ?></td>
                          <td><?php
                              $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                              ?></td>
                          <td><?= $staffsRes['Site']; ?></td>
                          <td><?= $staffsRes['Device_desc']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      <?php
      } else {
      ?>
        <script>
          Swal.fire({
            title: ' Sorry.',
            text: ' No data was found for this user. Please try again later. ',
            icon: 'error'
          });
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        Swal.fire({
          title: ' Sorry.',
          text: 'Error was found. Please try again later.',
          icon: 'error'
        });
      </script>
      <?php
    }
  }

  public function getResultsbyname_co()
  {
    $this->load->library('session');
    $sessiondata = $this->session->userdata('admin_details');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'name', 'trim|required');
    if ($this->form_validation->run()) {
      $name = $this->input->post("name");
      $name_tree = explode(" ", $name);
      if (sizeof($name_tree) >= 3) {

        $user_q = $this->db->query(" SELECT Id,UserType FROM `l2_co_patient` WHERE 
		  `F_name_EN` = '" . $name_tree[0] . "' AND `M_name_EN` = '" . $name_tree[1] . "'
		   AND `L_name_EN` = '" . $name_tree[2] . "' LIMIT 1 ")->result_array();
        if (!empty($user_q)) {
          $usertype = $user_q[0]['UserType'];
        }
      }

      if (isset($usertype) && !empty($user_q)) {
        $id = $user_q[0]['Id'];
        $userdata = $this->data_of_user_by_id_for_co($usertype, $sessiondata, $id);
      }
      if (!empty($user_q)) {
      ?>
        <div class="container">

          <!-- end control -->
          <div class="row formcontainer">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Data For:
                    <?= $name; ?>
                  </h4>
                  <table id="datatable_results" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                        <th> Img </th>
                        <th> Name </th>
                        <th> First Result </th>
                        <th> Last Result </th>
                        <th> Time in </th>
                        <th> Time out </th>
                        <th> Total </th>
                        <th> Site </th>
                        <th> Device Desc </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($userdata as $staffsRes) { ?>
                        <tr>
                          <td style="width: 20px;"><?php

                                                    $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                                                        WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = '" . $staffsRes['UserType'] . "' LIMIT 1 ")->result_array();
                                                    ?>
                            <?php if (empty($avatar)) {  ?>
                              <img src="<?= base_url(); ?>uploads/co_avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                              <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                          </td>
                          <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal">
                              <?= $staffsRes['Username']; ?>
                            </h6>
                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                              <?= $staffsRes['position']; ?>
                            </p>
                          </td>
                          <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                          <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                          <td><?= $staffsRes['first_result_time'] ?></td>
                          <td><?= $staffsRes['last_result_time'] ?></td>
                          <td><?php
                              $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                              ?></td>
                          <td><?= $staffsRes['Site']; ?></td>
                          <td><?= $staffsRes['Device_desc']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <script>
          var table_st = $('#datatable_results').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis']
          });
          table_st.buttons().container().appendTo('#datatable_results_wrapper .col-md-6:eq(0)');
        </script>
      <?php
      } else {
      ?>
        <script>
          Swal.fire({
            title: ' Sorry.',
            text: ' No data was found for this user. Please try again later. ',
            icon: 'error'
          });
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        Swal.fire({
          title: ' Sorry.',
          text: 'Error was found. Please try again later.',
          icon: 'error'
        });
      </script>
<?php
    }
  }

  private function between($f_result_date, $l_result_date)
  {
    // Declare and define two dates 
    $date1 = strtotime($f_result_date);
    $date2 = strtotime($l_result_date);

    // Formulate the Difference between two dates 
    $diff = abs($date2 - $date1);


    // To get the year divide the resultant date into 
    // total seconds in a year (365*60*60*24) 
    $years = floor($diff / (365 * 60 * 60 * 24));


    // To get the month, subtract it with years and 
    // divide the resultant date into 
    // total seconds in a month (30*60*60*24) 
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) /
      (30 * 60 * 60 * 24));


    // To get the day, subtract it with years and 
    // months and divide the resultant date into 
    // total seconds in a days (60*60*24) 
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
      $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


    // To get the hour, subtract it with years, 
    // months & seconds and divide the resultant 
    // date into total seconds in a hours (60*60) 
    $hours = floor(($diff - $years * 365 * 60 * 60 * 24 -
      $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) /
      (60 * 60));


    // To get the minutes, subtract it with years, 
    // months, seconds and hours and divide the 
    // resultant date into total seconds i.e. 60 
    $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 -
      $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 -
      $hours * 60 * 60) / 60);


    // To get the minutes, subtract it with years, 
    // months, seconds, hours and minutes 
    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 -
      $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 -
      $hours * 60 * 60 - $minutes * 60));

    // Print the result 
    /*if($hours !== 0){
	 //echo date("HH:", strtotime($hours));  
	 echo $hours." hour(s), ";
}
	
if($minutes !== 0){
	echo $minutes." second(s) ";
}*/

    $alltime = $hours . ':' . $minutes;
    echo date("H:i", strtotime($alltime));
    /*printf("%d years, %d months, %d days, %d hours, "
	. "%d minutes, %d seconds", $years, $months, 
			$days, $hours, $minutes, $seconds); */
  }
}
