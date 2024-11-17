<!doctype html>
<html lang="en">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<body class="light menu_light logo-white theme-white">
<div class="rightbar-overlay"></div>
<div class="right-bar" style="z-index: 100000;">
  <div data-simplebar class="h-100">
    <div class="rightbar-title px-3 py-4"> <a href="javascript:void(0);" class="right-bar-toggle float-right"> <i class="mdi mdi-close noti-icon"></i> </a>
      <h5 class="m-0">Teachers List</h5>
    </div>
    <hr class="mt-0" />
    <h6 class="text-center mb-0"> Cantacted Teachers </h6>
    <div class="p-4" id="TeachersCon"> Wait Please... </div>
  </div>
</div>
<style>
        .spinner-border {
            margin: auto !important;
        }
        #SelectTheClassCard {
            display: none;
        }
        #freepik_stories-empty {
            width: 100%;
            max-width: 300px;
            margin: auto;
        }
        #drawChart {
            text-align: center;
            padding: 60px;
        }
        .badge {
            text-transform: capitalize;
            padding: 5px;
        }
        .notStatic {
            margin-top: 12px;
        }
        .notStatic .card-body {
            padding-top: 0px !important;
        }
        .notStatic .card-body .col-xl-9,
        .notStatic .card-body .col-xl-8 {
            padding-top: 8px;
        }
        .notStatic .card-body .badge {
            color: #fff;
        }
        th {
            font-size: 13px;
        }
        .card.notStatic span {
            border-radius: 10px;
            font-size: 29px;
            margin-left: -21px;
        }
        .More {
            border: 1px solid #000;
            padding: 1px 11px;
            border-radius: 3px;
            margin-left: -14px;
            background: rgba(255, 255, 255, 0.80);
            cursor: pointer;
        }
        .out {
            font-size: 23px;
            color: #a90000;
            cursor: pointer;
            text-align: center;
        }
        .image_container img {
            margin: auto;
            width: 100%;
            max-width: 800px;
        }
        .InfosCards .card {
            border: 6px solid;
        }
        .InfosCards h4 {
            font-size: 30px;
            color: white !important;
        }
        .InfosCards p {
            font-size: 15px;
            color: white;
        }
        
        #simpl_home_list,
        #simpl_quarantin_list {
            padding-bottom: 50px !important;
        }
    </style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card"> <br>
            <div class="row image_container"> <img src="<?= base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools"> </div>
            <br>
          </div>
        </div>
      </div>
      <?php
      $parent = $this->db->query( "SELECT Added_By FROM `l1_school` 
				WHERE Id = '" . $sessiondata[ 'admin_id' ] . "' ORDER BY `Id` DESC" )->result_array();
      $parentId = $parent[ 0 ][ 'Added_By' ];
      $parent_Infos = $this->db->query( "SELECT * FROM `l0_organization` 
                WHERE Id = '" . $parentId . "' ORDER BY `Id` DESC LIMIT 1" )->result_array();
//      $parent_name = $parent_Infos[ 0 ][ 'Username' ];
// Check if the array and the key exist before accessing it
		if (!empty($parent_Infos) && isset($parent_Infos[0]) && isset($parent_Infos[0]['Username'])) {
			$parent_name = $parent_Infos[0]['Username'];
		} else {
			// Handle the case where the key does not exist or the array is empty
			$parent_name = 'Default Name'; // You can provide a default value or handle it according to your logic
		}

      $classes = $this->schoolHelper->school_classes( $sessiondata[ 'admin_id' ] ); // return classes array
      $active_classes = $this->schoolHelper->getActiveSchoolClassesByStudents();
      $today = date( "Y-m-d" );
      ?>
      <br>
      <?php /*?>
<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH P001: School Dashboard</h4>
<div class="row">
    <?php foreach ($cards as $card) { ?>
    <div class="col-md-6 col-xl-3 InfosCards">
        <div class="card" style="background: url('<?= base_url("assets/images/schoolDashboard/" . $card['bg']); ?>');background-position: center;background-repeat: no-repeat;background-size: cover;border-color: <?= $card['border'] ?>">
            <div class="card-body">
                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/schoolDashboard/icons/<?= $card['icons'] ?>" alt="<?= $card['Title'] ?>"> </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                            <?= $card['Data']['allCounter'] ?? '--' ?>
                        </span></h4>
                    <p class="mb-0">
                        <?= $card['Title'] ?>
                    </p>
                </div>
                <p class="mt-3 mb-0"><span class="mr-1"><span>
                            <?= $card['Data']['LastAdded'] ?? '--/--/--' ?>
                        </span><br>
                </p>
                <p class="text-white">
                    <?= $card['last_title'] ?>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
      <?php */?>
      <!-- end row-->
      
      <?php if ($temperatureandlabs) { ?>
      <?php /*?>
<div class="row">
    <?php
    $schoolsList = $this->db->query( "SELECT * FROM `l1_school` ORDER BY `Created` DESC" )->result_array();
    $studentsCount = array();
    $allresuls = 0;
    foreach ( $schoolsList as $school ) {
        $resul_count = 0;
        $count = $this->db->query( "SELECT * FROM l2_student WHERE Added_By = '" . $school[ 'Id' ] . "' " )->num_rows();
        $StudentForThisSchool = $this->db->query( "SELECT * FROM l2_student
                        WHERE Added_By = '" . $school[ 'Id' ] . "' " )->result_array();
        foreach ( $StudentForThisSchool as $_student ) {
            $stud_id = $_student[ 'Id' ];
            $Issetresult = $this->db->query( "SELECT * FROM `l2_result` 
                            WHERE `UserId` = '" . $stud_id . "' AND `Created` = '" . $today . "' ORDER BY `Time` DESC LIMIT 1 " )->result_array();
            foreach ( $Issetresult as $result ) {
                $resul_count++;
                $allresuls++;
            }
        }
        if ( $count > 0 ) {
            $studentsCount[] = array(
                "SchoolId" => $school[ 'Id' ], "name" => $school[ 'Username' ],
                "Count" => $count, "Results" => $resul_count
            );
        }
    }
    ?>
    <div class="col-xl-12"><br>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 002: Daily Temperature Diagram for Staff, Teachers, and Students</h4>
        <div class="card">
            <div class="card-body">
                <div class="float-right">
                    <div class="dropdown"> <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"><b>Select User Type(Staff, Teachers, and Students)</b></font><i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                            <li class="dropdown-item" onClick="GetStaffChart();">Staff</li>
                            <li class="dropdown-item" onClick="GetTeacherChart();">Teacher</li>
                            <li class="dropdown-item" onClick="GetStudentChart();">Student</li>
                        </div>
                    </div>
                </div>
                <div id="SelectTheClassCard" class="mb-2">
                    <label for="SelectFromClass">Select Class</label>
                    <?php if (!empty($active_classes)) { ?>
                    <select name="StudentClass" class="form-control" id="SelectFromClass">
                        <option value="">Please Select a Class</option>
                        <?php foreach ($active_classes as $class) { ?>
                        <option value="<?= $class['Id']  ?>">
                            <?= $class['Class']; ?>
                        </option>
                        <?php } ?>
                    </select>
                    <?php } else { ?>
                    <p>You do not have any class registered yet. Please edit school <a href="<?= base_url(); ?>EN/schools/Profile">Profile</a> </p>
                    <?php } ?>
                </div>
                <h4 class="card-title"><img src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Daily Temperature Diagram
                    <?= $today; ?>
                    <font color=#e13e2b>(Staff, Teacher, and Student)</font>
                </h4>
                <div id="drawChart"> <img src="<?= base_url(); ?>assets/images/Back1.png" width="100%" style="padding-top: 20px; padding-bottom: 10px;"> </div>
            </div>
        </div>
    </div>
</div>
      <?php */?>
      <!-- end row-->
      
      <?php } ?>
      <?php if ($temperatureandlabs) { ?>
		
      <div class="row">
        <div class="col-xl-12"> <br>
          <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">Checklist of System</h4>
          
          <!-- end row-->
          
          <?php } ?>
          <?php if ($temperatureandlabs) { ?>
          <?php /*?>
<div class="row">
    <div class="col-xl-12"> <br>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 004: Daily Data Table for All Tests-Students</h4>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4" id="Titel">
                    <div class="float-right">
                        <div class="dropdown"> <a class=" dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">Select Test<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                            <style>
                                .dropdown-menu * {
                                    cursor: pointer;
                                }
                            </style>
                            <div class="dropdown-menu" style="z-index: 100001;position: relative;">
                                <?php if ($temperatureandlabs) { ?>
                                <li class="dropdown-item" onClick="Tempratur_students();">Temperature</li>
                                <?php } ?>
                                <?php foreach ($list_Tests as $test) { ?>
                                <li class="dropdown-item" onClick="Get_plus_minus_students('<?= $test['Test_Desc']; ?>');">
                                    <?= $test['Test_Desc']; ?>
                                </li>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </h4>
                <?php if ($temperatureandlabs) { ?>
                <div class="float-right" style="z-index: 10000;position: relative;">
                    <div class="dropdown classes_temp"> <a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"> </span><b>Select Class</b> <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                        <style>
                            .dropdown-menu * {
                                cursor: pointer;
                            }
                        </style>
                        <div class="dropdown-menu">
                            <?php if (!empty($active_classes)) { ?>
                            <?php foreach ($active_classes as $class) { ?>
                            <li class="dropdown-item" onClick="GetTheStudentsResultsForClass(<?= $class['Id'] ?>)">
                                <?= $class['Class']; ?>
                            </li>
                            <?php } ?>
                            <?php } else { ?>
                            <li class="dropdown-item"> No Class found for this school</li>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/icons/png_icons/Dashboard_students.png" style="width: 25px;margin: auto 5px;"> Daily List of Tests
                    <?= $today; ?>
                    <font color=#e13e2b>(Students) </font>
                </h4>
                </br>
                <div class="New_Select" style="margin-top: -40px;"></div>
                <div class="New_Data"></div>
                <div data-simplebar>
                    <div id="ResultsTableStudents" style="text-align: center;"> <img src="<?= base_url(); ?>assets/images/Back2.png" width="100%" style="padding-top: 20px; padding-bottom: 20px;"> </div>
                </div>
            </div>
        </div><?php */?>
        </div>
      </div>
      <!-- end row-->
      
      <?php } ?>
      <div class="row">
        <?php if ($temperatureandlabs) { ?>
        <?php /*?><div class="col-xl-12"><br>
          <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 005: Daily Data Table for All Tests-Staff</h4>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4">
                <div class="float-right">
                  <div class="dropdown"> <a class=" dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                    <style>
                                                            .dropdown-menu * {
                                                                cursor: pointer;
                                                            }
                                                        </style>
                    <div class="dropdown-menu" style="z-index: 100001;position: relative;">
                      <?php if ($temperatureandlabs) { ?>
                      <li class="dropdown-item" onclick="Tempratur_List('#simpl_staff_list','#New_Staff_List');">Temperature</li>
                      <?php } ?>
                      <?php foreach ($list_Tests as $test) { ?>
                      <li class="dropdown-item" onClick="staff_labTests('<?= $test['Test_Desc']; ?>');">
                        <?= $test['Test_Desc']; ?>
                      </li>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </h4>
              <h4 class="card-title mb-4"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Daily List of Tests
                <?= $today; ?>
                <font color=#e13e2b>(Staff) </font> </h4>
              (<span id="STAFFSNOSHOWTESTNAME">Temperature</span>)
              </h4>
              <div data-simplebar style="overflow: auto;">
                <?php if ($temperatureandlabs) { ?>
                <div id="simpl_staff_list">
                  <?php
                  // AND Result_Date = '" . $today . "' AND UserType = 'Staff' 
                  $list = array();
                  $today = date( "Y-m-d" );
                  $Ourstaffs = $this->db->query( "SELECT l2_staff.* , `r_positions_sch`.`Position` AS Position
                                                        FROM l2_staff 
                                                        LEFT JOIN `r_positions_sch` ON `r_positions_sch`.`Id` = `l2_staff`.`Position`
                                                        WHERE `l2_staff`.`Added_By` = '" . $sessiondata[ 'admin_id' ] . "' " )->result_array();
                  foreach ( $Ourstaffs as $staff ) {
                      $staffname = $staff[ 'F_name_EN' ] . ' ' . $staff[ 'L_name_EN' ];
                      $ID = $staff[ 'Id' ];
                      $Position_Staff = $staff[ 'Position' ] ?? "--";
                      $Action = $staff[ 'Action' ];
                      $getResults = $this->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $staff[ 'Id' ] . "'
                                                            ORDER BY `Time` DESC LIMIT 1" )->result_array();
                      foreach ( $getResults as $results ) {
                          $list[] = array(
                              "Username" => $staffname, "Id" => $ID, "TestId" => $results[ 'Id' ], "Testtype" => $results[ 'Device_Test' ],
                              "Result" => $results[ 'Result' ], "Creat" => $results[ 'Result_Date' ] . " " . $results[ 'Time' ], 'position' => $Position_Staff,
                              "symps" => $results[ 'Symptoms' ], "Action" => $Action
                          );
                      }
                  }
                  ?>
                  <table class="table ch004results table-borderless table-centered table-nowrap table_sites ">
                    <thead>
                    <th> # </th>
                      <th> Img </th>
                      <th> Name </th>
                      <th> Date &amp; Time </th>
                      <th> Result </th>
                      <th> Risk </th>
                      <th> Symptoms </th>
                      <th> Status </th>
                      <th> Action </th>
                      </thead>
                    <tbody>
                    <style>
                                                                    .badge {
                                                                        text-align: center;
                                                                    }
                                                                    .Td-Results {
                                                                        color: #FFFFFF;
                                                                    }
                                                                </style>
                    <?php foreach ($list as $count => $staffsRes) { ?>
                    <tr>
                      <td><?= $count + 1 ?></td>
                      <td style="width: 20px;"><?php
                      $avatar = $this->db->query( "SELECT * FROM `l2_avatars`
                                                                            WHERE `For_User` = '" . $staffsRes[ 'Id' ] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 " )->result_array();
                      ?>
                        <?php if (empty($avatar)) {  ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                        <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                        <?php } ?></td>
                      <td><h6 class="font-size-15 mb-1 font-weight-normal">
                          <?= $staffsRes['Username']; ?>
                        </h6>
                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                          <?= $staffsRes['position'] . ", " . $staffsRes['Action']; ?>
                        </p></td>
                      <td><?= $staffsRes['Creat']; ?></td>
                      <?php boxes_Colors($staffsRes['Result']); ?>
                      <td><?php symps($staffsRes['symps']); ?></td>
                      <td><?php if (strtolower($staffsRes['Action']) == "home") { ?>
                        <p class="font-size-13 mb-0 text-primary"><b>
                          <?= ucfirst($staffsRes['Action']) ?>
                          </b></p>
                        <?php  } elseif (strtolower($staffsRes['Action']) == "quarantine") { ?>
                        <p class="font-size-13 mb-0 text-danger"><b>
                          <?= ucfirst($staffsRes['Action']) ?>
                          </b></p>
                        <?php } else { ?>
                        <p class="font-size-13 mb-0 text-success">
                          <?= ucfirst($staffsRes['Action']) ?>
                        </p>
                        <?php } ?></td>
                      <td><a class="px-3 text-primary set-in-action" data-id="<?= $staffsRes['Id'] ?>" data-type="Staff" data-change-to="Home" data-toggle="tooltip" data-placement="top" title="" data-original-title="Stay Home" theid="23"> <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px"> </a> <a class="text-danger set-in-action" data-toggle="tooltip" data-id="<?= $staffsRes['Id'] ?>" data-type="Staff" data-change-to="Quarantine" data-placement="top" title="Quarantine" theid="23"> <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px"> </a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    
                  </table>
                </div>
                <?php } else { ?>
                <div id="simpl_staff_list">
                  <?php $this->permissions->accessdenied(); ?>
                </div>
                <?php } ?>
                <div id="New_Staff_List"></div>
              </div>
            </div>
          </div>
        </div><?php */?>
		   <!-- end row-->
		  
		  
        <?php } ?>
        <?php if ($temperatureandlabs) { ?>
        <?php /*?><div class="col-xl-12"><br>
          <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 006: Daily Data Table for All Tests-Teachers</h4>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4">
                <div class="float-right">
                  <div class="dropdown"> <a class=" dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                    <style>
                                                            .dropdown-menu * {
                                                                cursor: pointer;
                                                            }
                                                        </style>
                    <div class="dropdown-menu" style="z-index: 100001;position: relative;">
                      <?php if ($temperatureandlabs) { ?>
                      <li class="dropdown-item" onclick="Tempratur_List('#simpl_Teacher_list','#New_Teacher_List');">Temperature</li>
                      <?php } ?>
                      <?php foreach ($list_Tests as $test) { ?>
                      <li class="dropdown-item" onClick="Teacher_labTests('<?= $test['Test_Desc']; ?>');">
                        <?= $test['Test_Desc']; ?>
                      </li>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </h4>
              <h4 class="card-title mb-4"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Daily List of Tests
                <?= $today; ?>
                <font color=#e13e2b>(Teachers) </font> </h4>
              (<span id="TEACHERSSNOSHOWTESTNAME">Temperature</span>)
              </h4>
              <div data-simplebar style="overflow: auto;">
                <?php if ($temperatureandlabs) { ?>
                <div id="simpl_Teacher_list">
                  <?php
                  $listTeachers = array();
                  $OurTeachers = $this->db->query( "SELECT * FROM l2_teacher
                                                        WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "' " )->result_array();
                  foreach ( $OurTeachers as $Teacher ) {
                      $Teachername = $Teacher[ 'F_name_EN' ] . ' ' . $Teacher[ 'L_name_EN' ];
                      $ID = $Teacher[ 'Id' ];
                      $Position = $Teacher[ 'Position' ];
                      $classes = implode( ' ,', array_column( $this->schoolHelper->teacherClasses( $ID ), "class" ) );
                      $Action = $Teacher[ 'Action' ];
                      $getResults_Teacheer = $this->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
                                                            AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Time` DESC LIMIT 1" )->result_array();
                      foreach ( $getResults_Teacheer as $T_results ) {
                          $listTeachers[] = array(
                              "Username" => $Teachername, "Id" => $ID, "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Device_Test' ],
                              "Result" => $T_results[ 'Result' ], "Creat" => $T_results[ 'Result_Date' ] . " " . $T_results[ 'Time' ], "Position" => $Position,
                              "Class" => $classes, "symps" => $T_results[ 'Symptoms' ], "Action" => $Action
                          );
                      }
                  }
                  ?>
                  <table class="table table-borderless table-centered table-nowrap table_sites ">
                    <thead>
                    <th>#</th>
                      <th> Img </th>
                      <th> Name </th>
                      <th> Date &amp; Time </th>
                      <th> Result </th>
                      <th> Risk </th>
                      <th> Symptoms </th>
                      <th> Status </th>
                      <th> Action </th>
                      </thead>
                    <tbody>
                    <style>
                                                                    .badge {
                                                                        text-align: center;
                                                                    }
                                                                </style>
                    <?php foreach ($listTeachers as $sn => $TeacherRes) { ?>
                    <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $TeacherRes['Action']; ?>">
                      <td><?= $sn + 1 ?></td>
                      <td style="width: 20px;"><?php $avatar = $this->db->query("SELECT * FROM `l2_avatars` WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array(); ?>
                        <?php if (empty($avatar)) {  ?>
                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                        <?php } else { ?>
                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                        <?php } ?></td>
                      <td><h6 class="font-size-15 mb-1 font-weight-normal">
                          <?= $TeacherRes['Username']; ?>
                        </h6>
                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                          <?= $this->schoolHelper->teacherClasses($TeacherRes['Id'], true)  ?>
                        </p></td>
                      <td><?= $TeacherRes['Creat']; ?></td>
                      <?php boxes_Colors($TeacherRes['Result']); ?>
                      <td><?php symps($TeacherRes['symps']); ?></td>
                      <td><?php if (strtolower($TeacherRes['Action']) == "home") { ?>
                        <p class="font-size-13 mb-0 text-primary"><b>
                          <?= ucfirst($TeacherRes['Action']) ?>
                          </b></p>
                        <?php  } elseif (strtolower($TeacherRes['Action']) == "quarantine") { ?>
                        <p class="font-size-13 mb-0 text-danger"><b>
                          <?= ucfirst($TeacherRes['Action']) ?>
                          </b></p>
                        <?php } else { ?>
                        <p class="font-size-13 mb-0 text-success">
                          <?= ucfirst($TeacherRes['Action']) ?>
                        </p>
                        <?php } ?></td>
                      <td><a href="javascript:void(0);" class="px-3 text-primary" onClick="setmemberInAction(<?= $TeacherRes['Id'] ?>,'Teacher','Home');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Stay Home" theid="23"> <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px"> </a> <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" onClick="setmemberInAction(<?= $TeacherRes['Id'] ?>,'Teacher','Quarantine',);" data-placement="top" title="Quarantine" theid="23"> <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px"> </a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    
                  </table>
                </div>
                <?php } else { ?>
                <div id="simpl_Teacher_list">
                  <?php $this->permissions->accessdenied(); ?>
                </div>
                <?php } ?>
                <div id="New_Teacher_List"></div>
              </div>
            </div>
          </div>
        </div><?php */?>
		   <!-- end row-->
		  
        <?php } ?>
        <?php if ($temperatureandlabs) { ?>
        <?php /*?><div class="col-xl-12">
          <div class="row">
            <div class="col-xl-6">
              <h4 class="card-title" style="background: #33A2FF; padding: 10px;color: #FFFFFF;border-radius: 4px;">CH 007: Stay Home Data Table for All Tests - (Staff, Teacher, and Student)</h4>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">
                    <div class="float-right">
                      <div class="dropdown"> <a class=" dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                        <div class="dropdown-menu" style="z-index: 100001;">
                          <?php if ($temperatureandlabs) { ?>
                          <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');">Temperature </li>
                          <?php } ?>
                          <?php foreach ($list_Tests as $test) { ?>
                          <li class="dropdown-item" onClick="home_labTests('<?= $test['Test_Desc']; ?>');">
                            <?= $test['Test_Desc']; ?>
                          </li>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </h4>
                  <h4 class="card-title mb-4"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Stay Home(<span id="STAYHOMESHOWTESTNAME">Temperature</span>) <font color=#e13e2b>(Staff, Teacher, and Student)</font> </h4>
                  <div data-simplebar style="height: 350px;overflow: auto;">
                    <?php if ($temperatureandlabs) { ?>
                    <div id="simpl_home_list">
                      <?php
                      $listTeachers = array();
                      $today = date( "Y-m-d" );
                      $OurStudens = $this->db->query( " SELECT `l2_student`.* , `r_levels`.`Class` AS StudentClass 
                                                        FROM `l2_student`
                                                        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                                                        WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "'  " )->result_array();
                      foreach ( $OurStudens as $Teacher ) {
                          $Teachername = $Teacher[ 'F_name_EN' ] . ' ' . $Teacher[ 'L_name_EN' ];
                          $ID = $Teacher[ 'Id' ];
                          $Position = $Teacher[ 'Position' ];
                          $getResults_Teacheer = $this->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
                                                            AND UserType = 'Student'  AND `Action` = 'Home' ORDER BY `Time` DESC LIMIT 1" )->result_array();
                          foreach ( $getResults_Teacheer as $T_results ) {
                              $lastReads = $this->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
                                                                AND UserType = 'Student'  ORDER BY `Time` DESC LIMIT 1" )->result_array();
                              $lastRead = $lastReads[ 0 ][ 'Result' ];
                              $lastReadDate = $lastReads[ 0 ][ 'Created' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
                              $listTeachers[] = array(
                                  "Username" => $Teachername, "Id" => $ID,
                                  "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Device_Test' ],
                                  "Result" => $T_results[ 'Result' ], "Creat" => ( empty( $Teacher[ 'last_change_status_date' ] ) ? "0000-00-00 00:00:00" : $Teacher[ 'last_change_status_date' ] ),
                                  "Class_OfSt" => $Teacher[ 'StudentClass' ], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                              );
                          }
                      }
                      ?>
                      <table class="table table-borderless table-centered table-nowrap table_sites ">
                        <thead>
                        <th> Img </th>
                          <th> Name </th>
                          <th> Date &amp; Time </th>
                          <th> Result </th>
                          <th> Risk </th>
                          <th> Days </th>
                          <th> Action </th>
                          </thead>
                        <tbody>
                          <?php foreach ($listTeachers as $sn => $TeacherRes) { ?>
                          <tr>
                            <td style="width: 20px;"><?php
                            $avatar = $this->db->query( "SELECT * FROM `l2_avatars`
                                                                            WHERE `For_User` = '" . $TeacherRes[ 'Id' ] . "' AND `Type_Of_User` = 'Student' LIMIT 1 " )->result_array();
                            ?>
                              <?php if (empty($avatar)) {  ?>
                              <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                              <?php } else { ?>
                              <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                              <?php } ?></td>
                            <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
                                <?= $TeacherRes['Username']; ?>
                              </h6>
                              <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                <?= $TeacherRes['Class_OfSt']; ?>
                              </p></td>
                            <td style="font-size: 12px;"><?= $TeacherRes['LastReadDate']; ?></td>
                            <?php boxes_Colors($TeacherRes['LastRead']); ?>
                            <td><?php
                            $from_craet = $TeacherRes[ 'Creat' ];
                            $finalDate = dateDiffInDays( $from_craet, $today );
                            if ( $finalDate == 0 ) {
                                echo "Today";
                            } elseif ( $finalDate > 2 ) {
                                echo $finalDate . " Days";
                            } else {
                                echo $finalDate . " Day";
                            }
                            ?></td>
                            <td class="out"><img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'Student','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit"></td>
                          </tr>
                          <?php } ?>
                          <?php StayHomeOf('Teacher'); ?>
                          <?php StayHomeOf('Staff'); ?>
                        </tbody>
                      </table>
                    </div>
                    <?php } else { ?>
                    <div id="simpl_home_list">
                      <?php $this->permissions->accessdenied(); ?>
                    </div>
                    <?php } ?>
                    <!-- end simpl_home_list  -->
                    <div id="New_home_List"></div>
                  </div>
                  <!-- data-sidebar--> 
                </div>
                <!-- end card-body--> 
              </div>
              <!-- end card--> 
            </div>
            <div class="col-xl-6">
              <h4 class="card-title" style="background: #FF0000; padding: 10px;color: #FFFFFF;border-radius: 4px;">CH 008: Quarantine Data Table for All Tests - (Staff, Teacher, and Student)</h4>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">
                    <div class="float-right">
                      <div class="dropdown"> <a class=" dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                        <style>
                                                                    .dropdown-menu * {
                                                                        cursor: pointer;
                                                                    }
                                                                </style>
                        <div class="dropdown-menu" style="z-index: 100001;">
                          <?php if ($temperatureandlabs) { ?>
                          <li class="dropdown-item" onclick="Tempratur_List('#simpl_quarantin_list','.New_quarantin_List');">Temperature</li>
                          <?php } ?>
                          <?php foreach ($list_Tests as $test) { ?>
                          <li class="dropdown-item" onClick="quarntine_labTests('<?= $test['Test_Desc']; ?>');">
                            <?= $test['Test_Desc']; ?>
                          </li>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </h4>
                  <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Quarantine (<span id="STAYQuarantineNOSHOWTESTNAME">Temperature</span>)<font color=#e13e2b> (Staff, Teacher, and Student)</font> </h4>
                  <div data-simplebar style="height: 350px;overflow: auto;">
                    <?php if ($temperatureandlabs) { ?>
                    <div id="simpl_quarantin_list">
                      <?php
                      $today = date( "Y-m-d" );
                      $listTeachers = array();
                      $OurTeachers = $this->db->query( " SELECT `l2_student`.* , `r_levels`.`Class` AS StudentClass 
                                                                FROM `l2_student`
                                                                JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                                                                WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "'  " )->result_array();
                      foreach ( $OurTeachers as $Teacher ) {
                          $Teachername = $Teacher[ 'F_name_EN' ] . ' ' . $Teacher[ 'L_name_EN' ];
                          $ID = $Teacher[ 'Id' ];
                          $Position = $Teacher[ 'Position' ];
                          $getResults_Teacheer = $this->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
                                                                    AND UserType = 'Student' AND `Action` = 'Quarantine' ORDER BY `Time` DESC LIMIT 1" )->result_array();
                          foreach ( $getResults_Teacheer as $T_results ) {
                              $lastReads = $this->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
                                                                        AND UserType = 'Student' ORDER BY `Time` DESC LIMIT 1" )->result_array();
                              $lastRead = $lastReads[ 0 ][ 'Result' ];
                              $lastReadDate = $lastReads[ 0 ][ 'Result_Date' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
                              $listTeachers[] = array(
                                  "Username" => $Teachername, "Id" => $ID, "TestId" => $T_results[ 'Id' ],
                                  "Testtype" => $T_results[ 'Device_Test' ], "Result" => $T_results[ 'Result' ],
                                  "Creat" => $T_results[ 'Result_Date' ], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate,
                                  "Class_OfSt_q" => $Teacher[ 'StudentClass' ]
                              );
                          }
                      }
                      ?>
                      <table class="table table-borderless table-centered table-nowrap table_sites ">
                        <thead>
                        <th> Img</th>
                          <th> Name </th>
                          <th> Date &amp; Time </th>
                          <th> Result </th>
                          <th> Risk </th>
                          <th> Days </th>
                          <th> Action </th>
                          </thead>
                        <tbody>
                        <style>
                                                                            .badge {
                                                                                text-align: center;
                                                                            }
                                                                        </style>
                        <?php foreach ($listTeachers as $sn => $TeacherRes) { ?>
                        <tr>
                          <td style="width: 20px;"><?php $avatar = $this->db->query("SELECT * FROM `l2_avatars` WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array(); ?>
                            <?php if (empty($avatar)) {  ?>
                            <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                            <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                            <?php } ?></td>
                          <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
                              <?= $TeacherRes['Username']; ?>
                            </h6>
                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                              <?= $TeacherRes['Class_OfSt_q']; ?>
                            </p></td>
                          <td style="font-size: 12px;"><?= $TeacherRes['LastReadDate']; ?></td>
                          <?php boxes_Colors($TeacherRes['LastRead']); ?>
                          <td><?php
                          $from_craet = $TeacherRes[ 'Creat' ];
                          //echo $from_craet;
                          //$toTime = $today-$from_craet;
                          $finalDate = dateDiffInDays( $from_craet, $today );
                          if ( $finalDate == 0 ) {
                              echo "Today";
                          } elseif ( $finalDate > 2 ) {
                              echo $finalDate . " Days";
                          } else {
                              echo $finalDate . " Day";
                          }
                          ?></td>
                          <td class="out"><img src="<?= base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?= $TeacherRes['Id']; ?>,'Student','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit"></td>
                        </tr>
                        <?php } ?>
                        <?php StayHomeOfQuarantin('Teacher');  ?>
                        <?php StayHomeOfQuarantin('Staff'); ?>
                        </tbody>
                        
                      </table>
                    </div>
                    <?php  } else {  ?>
                    <div id="simpl_quarantin_list">
                      <?php $this->permissions->accessdenied(); ?>
                    </div>
                    <?php } ?>
                    <div class="New_quarantin_List"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><?php */?>
		   <!-- end row-->
		  
        <?php } ?>
        <?php /*?>
        <?php
        if ( $attendance_permissions ) {
            $this->load->view( 'EN/schools/inc/attendance_dashboard' );
        }
        ?>
        <?php */ ?>
        <?php if ($temperatureandlabs) { ?>
        <?php /*?><div class="col-lg-12"><br>
          <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 010: Daily Table for All Tests-Sites</h4>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;">Daily List of Tests
                <?= $today; ?>
                <font color=#e13e2b> (Sites)</font> </h4>
              <table class="table table_sites">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Site Name</th>
                    <th>Site Desc</th>
                    <th>Date &amp; Time</th>
                    <th>Batch No</th>
                    <th>Test Type</th>
                    <th>Result</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="withCounter">
                  <?php GetListOfSites($list_Tests); ?>
                </tbody>
              </table>
            </div>
          </div>
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
          <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title mt-0" id="myModalLabel"> Upload Report PDF </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                  <div class="theform">
                    <div class="file_upload_list"> <i class="display-4 text-muted uil uil-cloud-upload"></i> </div>
                    <form id="uploadPdf" name="Pdf_site">
                      <div class="choose_file">
                        <label for="choose_file">
                          <input type="file" id="choose_file" name="csvFileStaff" accept=".pdf">
                          <input type="hidden" id="site_result_id" name="site_result_id">
                          <span> Select PDF File </span> </label>
                      </div>
                      <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 StatusbtnStaff"> Start Upload </button>
                    </form>
                  </div>
                  <div class="StatusBoxStaff"> </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancel</button>
                </div>
              </div>
              <!-- /.modal-content --> 
            </div>
            <!-- /.modal-dialog --> 
          </div>
          <!-- /.modal --> 
        </div><?php */?>
		   <!-- end row-->
		  
        <script>
                                    $("#uploadPdf").on('submit', function(e) {
                                        e.preventDefault();
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?= base_url(); ?>EN/Ajax/UploadSiteReport',
                                            data: new FormData(this),
                                            contentType: false,
                                            cache: false,
                                            processData: false,
                                            success: function(data) {
                                                $('.theform').fadeOut();
                                                $('.StatusBoxStaff').html(data);
                                                $('.StatusbtnStaff').removeAttr('disabled');
                                                $('.StatusbtnStaff').html('Upload report');
                                            },
                                            beforeSend: function() {
                                                $('.StatusbtnStaff').attr('disabled', '');
                                                $('.StatusbtnStaff').html('Please wait');
                                            },
                                            ajaxError: function() {
                                                $('.alert.alert-info').css('background-color', '#DB0404');
                                                $('.alert.alert-info').html("Ooops! Error was found.");
                                            }
                                        });
                                    });
                                </script>
        <?php /*?><div class="col-lg-12"><br>
          <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 011: Data Table for All Closed Sites (Sterilization) Today</h4>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;"> Lab Test List of Sites <font color=#e13e2b> (Closed Sites for Sterilization Today
                <?= $today ?>
                )</font> </h4>
              </h4>
              <table class="table table_sites">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Site Name</th>
                    <th>Site Desc</th>
                    <th>Date &amp; Time</th>
                    <th>Batch No</th>
                    <th>Test Type</th>
                    <th>Result</th>
                    <th>Report</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="withCounter">
                  <?php GetListOfSites_InCleaning($list_Tests, $today); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><?php */?>
		   <!-- end row-->
		  
		  
        <?php /*?><div class="col-lg-12"><br>
          <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 012: Data Table for All Closed Sites (Sterilization) History</h4>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4"><img src="<?= base_url(); ?>assets/images/icons/png_icons/pin.png" style="width: 25px;margin: auto 5px;"> Lab Test List of Sites <font color=#e13e2b> (Closed Sites for Sterilization)</font> </h4>
              <table class="table table_sites">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Site Name</th>
                    <th>Site Desc</th>
                    <th>Date &amp; Time</th>
                    <th>Batch No</th>
                    <th>Test Type</th>
                    <th>Result</th>
                    <th>Report</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="withCounter">
                  <?php GetListOfSites_InCleaning($list_Tests); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><?php */?>
		   <!-- end row-->
		  
        <?php } ?>
        <?php /*?>
			<?php $this->load->view('EN/schools/inc/climate_dashboard')  ?><?php */ ?>
        <div class="col-lg-12"><br>
        
          <?php $this->load->view('EN/schools/inc/account_status', ["account_status" => $account_status]); ?>
        </div>
      </div>
      <!-- end col --> 
    </div>
    <!-- container-fluid --> 
  </div>
  <div id="return"></div>
  <!-- End Page-content --> 
</div>
</body>
<!-- apexcharts -->
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
<script>
    $('.withCounter').each(function() {
        var counter = 1;
        $($(this).children('tr')).each(function() {
            var count = counter++;
            $(this).children('td').first().html(count)
        });
    });
    try {
        $(".table_sites").DataTable();
    } catch (err) {
        console.log("Error " + err);
    }
    $('#our_surveys_list').owlCarousel({
        items: 1,
        loop: false,
        margin: 0,
        nav: true,
        navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
        dots: false,
        responsive: {
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            1200: {
                items: 2
            },
        }
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
    function GetTheStaffResults() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/ListResultsOfStaffs',
            beforeSend: function() {
                $('#ResultsTable').html('');
                $('#ResultsTable').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#ResultsTable').removeAttr('disabled', '');
                $('#ResultsTable').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    }
    function GetTheTeacherResults() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/ListResultsOfTeachers',
            beforeSend: function() {
                $('#ResultsTable').html('');
                $('#ResultsTable').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#ResultsTable').removeAttr('disabled', '');
                $('#ResultsTable').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
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
    function ConnectedWithClass(className) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/schools/ListConnectedTeachers',
            data: {
                class: className,
            },
            beforeSend: function() {
                $('#TeachersCon').html('');
                $('#TeachersCon').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div>');
            },
            success: function(data) {
                $('#TeachersCon').removeAttr('disabled', '');
                $('#TeachersCon').html(data);
            },
            ajaxError: function() {
                $('#TeachersCon').css('background-color', '#DB0404');
                $('#TeachersCon').html("Ooops! Error was found.");
            }
        });
    }
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
    function SET_SiteInAction(id) {
        var theId = id;
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
                    url: '<?= base_url(); ?>EN/Ajax/Set_ActiononSite',
                    data: {
                        S_Id: theId,
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
    function Remove_SiteFromAction(id) {
        var theId = id;
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
                    url: '<?= base_url(); ?>EN/Ajax/Remove_ActiononSite',
                    data: {
                        S_Id: theId,
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
    function RemoveThisMemberFrom_lab(id, usertype, action) {
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
                    url: '<?= base_url(); ?>EN/Schools/ApplyLabActionOnMember_lab',
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
    function Get_plus_minus(type) {
        //alert('The '+type);
        $('#TempCounters').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Results/GetResultsCounterFor',
            data: {
                TeatsType: type,
            },
            success: function(data) {
                $('#Plus_Minus').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }
    function Tempratur() {
        $('#Plus_Minus').html('');
        $('#TempCounters').slideDown();
    }
    function Tempratur_students() {
        $('.New_Select').html("");
        $('.New_Data').html("");
        $('#ResultsTableStudents').slideDown();
        $('.classes_temp').show();
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
    //simpl_home_list
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
    $(".ch004results").on("click", ".set-in-action", function() {
        const data = {
            id: $(this).data("id"),
            type: $(this).data("type"),
            to: $(this).data("change-to"),
        };
        setmemberInAction(data.id, data.type, data.to);
    });
</script>
<script>
    function UploadTheReportPdf(testId) {
        $('#site_result_id').val(testId);
        $('.theform').fadeIn();
        $('.StatusBoxStaff').html("");
    }
</script>
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
        echo "No Symptoms Found ";
    }
}
function StayHomeOf( $type ) {
    $ci = & get_instance();
    $count_home = 0;
    $ci->load->library( 'session' );
    $sessiondata = $ci->session->userdata( 'admin_details' );
    if ( $type == "Teacher" ) {
        $ours = $ci->db->query( "SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "'  AND `Action` = 'Home'" )->result_array();
    } else {
        $ours = $ci->db->query( "SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "'  AND `Action` = 'Home'" )->result_array();
    }
    $listTeachers = array();
    $today = date( "Y-m-d" );
    foreach ( $ours as $Teacher ) {
        $Teachername = $Teacher[ 'F_name_EN' ] . ' ' . $Teacher[ 'L_name_EN' ];
        $ID = $Teacher[ 'Id' ];
        if ( $type == "Teacher" ) {
            $Position = $ci->schoolHelper->getTeacherPosition( $Teacher[ 'Position' ] );
        } else {
            $Position = $ci->schoolHelper->getStaffPosition( $Teacher[ 'Position' ] );
        }
        $getResults_Teacheer = $ci->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
        AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1" )->result_array();
        foreach ( $getResults_Teacheer as $T_results ) {
            $lastReads = $ci->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
            AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1" )->result_array();
            $lastRead = $lastReads[ 0 ][ 'Result' ];
            $lastReadDate = $lastReads[ 0 ][ 'Result_Date' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
            $listTeachers[] = array(
                "Username" => $Teachername, "Id" => $ID,
                "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Device_Test' ],
                "Result" => $T_results[ 'Result' ], "Creat" => ( empty( $Teacher[ 'last_change_status_date' ] ) ? "0000-00-00 00:00:00" : $Teacher[ 'last_change_status_date' ] ),
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
$count_home += sizeof( $listTeachers );
foreach ( $listTeachers as $TeacherRes ) {
    ?>
<tr>
  <td style="width: 20px;"><?php
  $avatar = $ci->db->query( "SELECT * FROM `l2_avatars`
            WHERE `For_User` = '" . $TeacherRes[ 'Id' ] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 " )->result_array();
  ?>
    <?php if (empty($avatar)) {  ?>
    <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
    <?php } else { ?>
    <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
    <?php } ?></td>
  <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
      <?= $TeacherRes['Username']; ?>
    </h6>
    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
      <?= $TeacherRes['Class_OfSt']; ?>
    </p></td>
  <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
  <?php boxes_Colors($TeacherRes['LastRead']); ?>
  <td><?php
  $from_craet = $TeacherRes[ 'Creat' ];
  //echo $from_craet;
  //$toTime = $today-$from_craet;
  $date_exp = explode( " ", $from_craet )[ 0 ];
  $finalDate = dateDiffInDays( $date_exp, $today );
  if ( $finalDate == 0 ) {
      echo "Today";
  } elseif ( $finalDate > 2 ) {
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
function dateDiffInDays( $date1, $date2 ) {
    // Calculating the difference in timestamps 
    $diff = strtotime( $date2 ) - strtotime( $date1 );
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs( round( $diff / 86400 ) );
}
function StayHomeOfQuarantin( $type ) {
    $ci = & get_instance();
    $count = 0;
    $ci->load->library( 'session' );
    $sessiondata = $ci->session->userdata( 'admin_details' );
    if ( $type == "Teacher" ) {
        $ours = $ci->db->query( "SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "'  AND `Action` = 'Quarantine' " )->result_array();
    } else {
        $ours = $ci->db->query( "SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "'  AND `Action` = 'Quarantine'  " )->result_array();
    }
    $listTeachers = array();
    $today = date( "Y-m-d" );
    foreach ( $ours as $Teacher ) {
        $Teachername = $Teacher[ 'F_name_EN' ] . ' ' . $Teacher[ 'L_name_EN' ];
        $ID = $Teacher[ 'Id' ];
        if ( $type == "Teacher" ) {
            $Position = $ci->schoolHelper->getTeacherPosition( $Teacher[ 'Position' ] );
        } else {
            $Position = $ci->schoolHelper->getStaffPosition( $Teacher[ 'Position' ] );
        }
        $getResults_Teacheer = $ci->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
        AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1" )->result_array();
        foreach ( $getResults_Teacheer as $T_results ) {
            $lastReads = $ci->db->query( "SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher[ 'Id' ] . "'
            AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1" )->result_array();
            $lastRead = $lastReads[ 0 ][ 'Result' ];
            $lastReadDate = $lastReads[ 0 ][ 'Created' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
            $listTeachers[] = array(
                "Username" => $Teachername, "Id" => $ID,
                "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Device_Test' ],
                "Result" => $T_results[ 'Result' ], "Creat" => ( empty( $Teacher[ 'last_change_status_date' ] ) ? "0000-00-00 00:00:00" : $Teacher[ 'last_change_status_date' ] ),
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
foreach ( $listTeachers as $TeacherRes ) {
    ?>
<?php //print_r($TeacherRes); 
?>
<tr>
  <td style="width: 20px;"><?php
  $avatar = $ci->db->query( "SELECT * FROM `l2_avatars`
            WHERE `For_User` = '" . $TeacherRes[ 'Id' ] . "' AND `Type_Of_User` = '" . $type . "' LIMIT 1 " )->result_array();
  ?>
    <?php if (empty($avatar)) {  ?>
    <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
    <?php } else { ?>
    <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
    <?php } ?></td>
  <td><h6 class="mb-1 font-weight-normal" style="font-size: 15px;">
      <?= $TeacherRes['Username']; ?>
    </h6>
    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
      <?= $TeacherRes['Class_OfSt']; ?>
    </p></td>
  <td style="font-size: 12px;"><?= $TeacherRes['Creat']; ?></td>
  <?php boxes_Colors($TeacherRes['LastRead']); ?>
  <td><?php
  $from_craet = $TeacherRes[ 'Creat' ];
  //echo $from_craet;
  //$toTime = $today-$from_craet;
  $date_exp = explode( " ", $from_craet )[ 0 ];
  $finalDate = dateDiffInDays( $date_exp, $today );
  if ( $finalDate == 0 ) {
      echo "Today";
  } elseif ( $finalDate > 2 ) {
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
function GetListOfSites( $list_Tests ) {
    $ci = & get_instance();
    $ci->load->library( 'session' );
    $today = date( "Y-m-d" );
    $listSites = array();
    $sessiondata = $ci->session->userdata( 'admin_details' );
    $sitesForThisUser = $ci->db->query( " SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata[ 'admin_id' ] . "' ORDER BY `Site_Code` ASC " )->result_array();
    foreach ( $list_Tests as $test ) {
        get_site_of_test( $sitesForThisUser, $test[ 'Test_Desc' ] );
    }
    //print_r($sitesForThisUser);
}
function get_site_of_test( $sitesForThisUser, $testType ) {
    $ci = & get_instance();
    $ci->load->library( 'session' );
    $today = date( "Y-m-d" );
    $listSites = array();
    $sessiondata = $ci->session->userdata( 'admin_details' );
    foreach ( $sitesForThisUser as $site ) {
        $name = $site[ 'Description' ];
        $site_name = $site[ 'Site_Code' ];
        $ID = $site[ 'Id' ];
        $getResults = $ci->db->query( "SELECT * FROM l2_labtests WHERE `UserId` = '" . $site[ 'Id' ] . "'
    AND Created = '" . $today . "' AND UserType = 'Site' AND 
	`Test_Description` = '" . $testType . "'  ORDER BY `Id` DESC " )->result_array();
        //print_r($getResults);
        foreach ( $getResults as $T_results ) {
            $lastReads = $ci->db->query( "SELECT * FROM l2_labtests WHERE `UserId` = '" . $site[ 'Id' ] . "'
    AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC " )->result_array();
            //if(!empty($lastRead)){
            $lastRead = $lastReads[ 0 ][ 'Result' ];
            $lastReadDate = $lastReads[ 0 ][ 'Created' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
            $listSites[] = array(
                "name" => $name, "Id" => $ID,
                "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Test_Description' ],
                "Device_ID" => $T_results[ 'Test_Description' ], "Batch" => $T_results[ 'Device_Batch' ],
                "Result" => $T_results[ 'Result' ], "Creat" => $T_results[ 'Created' ],
                "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results[ 'Action' ], "SiteName" => $site_name,
            );
            //}	
        }
    }
    ///print_r($listSites);
    foreach ( $listSites as $siteResult ) {
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
    <?php } ?></td>
</tr>
<?php
}
}
function get_site_of_test_In( $sitesForThisUser, $testType, $action, $date = false ) {
    $ci = & get_instance();
    $ci->load->library( 'session' );
    $today = date( "Y-m-d" );
    $listSites = array();
    $sessiondata = $ci->session->userdata( 'admin_details' );
    if ( !$date ) {
        foreach ( $sitesForThisUser as $site ) {
            $name = $site[ 'Description' ];
            $site_name = $site[ 'Site_Code' ];
            $ID = $site[ 'Id' ];
            $getResults = $ci->db->query( "SELECT * FROM l2_labtests WHERE `UserId` = '" . $site[ 'Id' ] . "'
            AND UserType = 'Site' AND `Action` = '" . $action . "' AND
            `Test_Description` = '" . $testType . "' AND `Created` >= '" . date( "Y-m-d", strtotime( "-7 days" ) ) . "' AND `Created` <= '" . $today . "'
            ORDER BY `Id` DESC  " )->result_array();
            foreach ( $getResults as $T_results ) {
                $lastReads = $ci->db->query( "SELECT * FROM l2_labtests WHERE `UserId` = '" . $site[ 'Id' ] . "'
                AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' AND `Action` = 'Cleaning' ORDER BY `Id` DESC " )->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[ 0 ][ 'Result' ];
                $lastReadDate = $lastReads[ 0 ][ 'Created' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Test_Description' ],
                    "Device_ID" => $T_results[ 'Test_Description' ], "Batch" => $T_results[ 'Device_Batch' ],
                    "Result" => $T_results[ 'Result' ], "Creat" => $T_results[ 'Created' ],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results[ 'Action' ], "SiteName" => $site_name,
                );
                //}	
            }
        }
    } else {
        foreach ( $sitesForThisUser as $site ) {
            $name = $site[ 'Description' ];
            $site_name = $site[ 'Site_Code' ];
            $ID = $site[ 'Id' ];
            $getResults = $ci->db->query( "SELECT * FROM l2_labtests WHERE `UserId` = '" . $site[ 'Id' ] . "'
            AND UserType = 'Site' AND `Action` = '" . $action . "' AND
            `Test_Description` = '" . $testType . "' AND Created = '" . $today . "'  ORDER BY `Id` DESC " )->result_array();
            //print_r($getResults);
            foreach ( $getResults as $T_results ) {
                $lastReads = $ci->db->query( "SELECT * FROM l2_labtests WHERE `UserId` = '" . $site[ 'Id' ] . "'
                AND UserType = 'Site' AND `Test_Description` = '" . $testType . "' ORDER BY `Id` DESC " )->result_array();
                //if(!empty($lastRead)){
                $lastRead = $lastReads[ 0 ][ 'Result' ];
                $lastReadDate = $lastReads[ 0 ][ 'Created' ] . '<br>' . $lastReads[ 0 ][ 'Time' ];
                $listSites[] = array(
                    "name" => $name, "Id" => $ID,
                    "TestId" => $T_results[ 'Id' ], "Testtype" => $T_results[ 'Test_Description' ],
                    "Device_ID" => $T_results[ 'Test_Description' ], "Batch" => $T_results[ 'Device_Batch' ],
                    "Result" => $T_results[ 'Result' ], "Creat" => $T_results[ 'Created' ],
                    "LastRead" => $lastRead, "LastReadDate" => $lastReadDate, "Action" => $T_results[ 'Action' ], "SiteName" => $site_name,
                );
                //}	
            }
        }
    }
    ///print_r($listSites);
    foreach ( $listSites as $siteResult ) {
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
    <?php } ?></td>
</tr>
<?php
}
}
function GetListOfSites_InCleaning( $list_Tests, $date = null ) {
    $ci = & get_instance();
    $ci->load->library( 'session' );
    $today = date( "Y-m-d" );
    $listSites = array();
    $sessiondata = $ci->session->userdata( 'admin_details' );
    $sitesForThisUser = $ci->db->query( " SELECT * FROM `l2_site` WHERE 
    `Added_By` = '" . $sessiondata[ 'admin_id' ] . "' ORDER BY `Site_Code` ASC " )->result_array();
    $oftoday = $date == null ? false : true;
    foreach ( $list_Tests as $test ) {
        get_site_of_test_In( $sitesForThisUser, $test[ 'Test_Desc' ], 'Cleaning', $oftoday );
    }
}
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