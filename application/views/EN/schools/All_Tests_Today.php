<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- Begin page -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
		            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

                <!-- start page title -->
                <?php
                $parent = $this->db->query("SELECT Added_By FROM `l1_school` 
WHERE Id = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC")->result_array();
                $parentId =  $parent[0]['Added_By'];
                $parent_Infos = $this->db->query("SELECT * FROM `l0_organization` 
WHERE Id = '" . $parentId . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $parent_name = $parent_Infos[0]['Username'];
                ?>
				 <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">REP 039: Daily |Temperature and other Tests’ Report</h4>


                <?php

                function data_of_user($type, $sessiondata)
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
                        $Ourstaffs = $ci->db->query(" SELECT `l2_student`.* , `r_levels`.`Class_ar` AS StudentClass 
                        FROM `l2_student`
                        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                        WHERE Added_By = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                    }

                    $class = null;
                    $grade = null;

                    foreach ($Ourstaffs as $staff) {
                        $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                        $ID = $staff['Id'];
                        $Position_Staff = $staff['Position'];
                        if ($type == "Teacher") {
                            $class = $staff['Classes'];
                        } elseif ($type == "Student") {
                            $class = $staff['StudentClass'];
                        }

                        if ($type == "Student") {
                            $grade = $staff['Grades'];
                        }

                        $getResults = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
                        AND Result_Date = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Time` DESC LIMIT 1 ")->result_array();
                        foreach ($getResults as $results) {
                            $creat = $results['Result_Date'] . ' ' . $results['Time'];
                            $list[] = array(
                                "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $creat, 'position' => $Position_Staff, "Symp" => $results['Symptoms'],
                                "Added_By" => $results['Added_By'], "Device" => $results['Device'], "Class" => $class, "grade" => $grade
                            );
                        }
                    }
                    return ($list);
                }

                $Staff_list = data_of_user("Staff", $sessiondata);
                $Student_list = data_of_user("Student", $sessiondata);
                $Teacher_list = data_of_user("Teacher", $sessiondata);

                function symps($symps)
                {
                    $ci = &get_instance();
                    $Symps_array = explode(';', $symps);
                    $sz =  sizeof($Symps_array);
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
                ?>

                <style>
                    .badge {
                        text-align: center;
                    }

                    .Td-Results {
                        color: #FFFFFF;
                    }
                </style>
                <div class="control col-md-12" style="padding-bottom: 15px;">
                    <button type="button" form_target="Staff_list" class="btn btn-primary w-md contr_btn">
                        <i class="uil uil-list"></i>Staff
                    </button>

                    <button type="button" form_target="Teachers_list" class="btn w-md contr_btn">
                        <i class="uil uil-list"></i>Teacher
                    </button>
                    <button type="button" form_target="Studnts_list" class="btn w-md contr_btn">
                        <i class="uil uil-list"></i>Student
                    </button>
                </div>
                <!-- end page title -->
                <div class="row formcontainer" id="Staff_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Staff </h4>
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> Img </th>
                                            <th> Created </th>
                                            <th> Name </th>
                                            <th> Result </th>
                                            <th> Risk </th>
                                            <th> Symptoms </th>
                                            <th> Added By </th>
                                            <th> Device </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($Staff_list as $staffsRes) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $staffsRes['Creat'] ?></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                        <?php echo $staffsRes['position']; ?></p>
                                                </td>
                                                <?php boxes_Colors($staffsRes['Result']); ?>
                                                <td><?php symps($staffsRes['Symp']) ?></td>
                                                <td><?php echo $staffsRes["Added_By"];  ?></td>
                                                <td><?php echo $staffsRes["Device"];  ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div class="row formcontainer" id="Studnts_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
								
                                <h4 class="card-title"> Students </h4>
                                <div class="students_button"></div>
                                <table id="Students_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> Img </th>
                                            <th> Created </th>
                                            <th> Name </th>
                                            <th> Result </th>
                                            <th> Risk </th>
                                            <th> Symptoms </th>
                                            <th> Added By </th>
                                            <th> Device </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($Student_list as $studentResults) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $studentResults['Id'] . "' AND
											 `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $studentResults['Creat'] ?></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal">
                                                        <?php echo $studentResults['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                        <?= $studentResults['Class'] . ", " . $studentResults['grade']; ?>
                                                    </p>
                                                </td>
                                                <?php boxes_Colors($studentResults['Result']); ?>
                                                <td><?php symps($studentResults['Symp']); ?></td>
                                                <td><?php echo $studentResults["Added_By"];  ?></td>
                                                <td><?php echo $studentResults["Device"];  ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row formcontainer" id="Teachers_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title"> Teachers </h4>
                                <table id="Teacher_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> Img </th>
                                            <th> Created </th>
                                            <th> Name </th>
                                            <th> Result </th>
                                            <th> Risk </th>
                                            <th> Symptoms </th>
                                            <th> Added By </th>
                                            <th> Device </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($Teacher_list as $TeacherResults) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $TeacherResults['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $TeacherResults['Creat'] ?></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal">
                                                        <?php echo $TeacherResults['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                        <?=  $this->schoolHelper->teacherClasses($TeacherResults['Id'] , true); ?></p>
                                                </td>
                                                <?php boxes_Colors($TeacherResults['Result']); ?>
                                                <td><?php symps($TeacherResults['Symp']) ?></td>
                                                <td><?php echo $TeacherResults["Added_By"];  ?></td>
                                                <td><?php echo $TeacherResults["Device"];  ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <!-- Required datatable js -->
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            //$('#Students_table').DataTable(); //Buttons examples

            var table_st = $('#Students_table').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
            table_st.buttons().container().appendTo('#Students_table_wrapper .col-md-6:eq(0)');

            var table_th = $('#Teacher_table').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
            table_th.buttons().container().appendTo('#Teacher_table_wrapper .col-md-6:eq(0)');
        });

        $('#Teachers_list').hide();
        $('#Studnts_list').hide();

        $('#Staffs_list').show();

        $('.control button').click(function() {
            $('.control button').removeClass('btn-primary');
            $(this).addClass('btn-primary');
            $('.formcontainer').hide();
            var to = $(this).attr('form_target');
            $('#' + to).show();
        });
    </script>
</body>
<?php
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

    <td class="Td-Results_font">
		<?php if ($result >= 38.500 && $result <= 45.500 ) { ?> 
	<span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"><?= $result; ?></span>
	<!-- Hight --> 
	<?php } elseif ($result <= 36.200) { ?> 
	<span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"><?= $result; ?></span>
	<!-- Low -->
	<?php } elseif ($result >= 36.201 && $result <= 37.500) { ?> 
	<span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"><?= $result; ?></span>
	<!-- No Risk -->
	<?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
	<span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"><?= $result; ?></span>
	<!-- Moderate -->
	<?php } elseif ($result >= 45.501) { ?>
	<span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"><?= $result; ?></span>
    <!-- Error -->
	<?php } ?>
    </td>
    <td class="Td-Results">
	<?php if ($result >= 38.500 && $result <= 45.500 ) { ?>
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

?>

</html>