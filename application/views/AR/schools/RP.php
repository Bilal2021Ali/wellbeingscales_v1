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
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>

<style>
    /*
	 error Moderate no_Risk Low Error
	*/


    .Td-Results_font span {
        font-size: 20px !important;
        padding: 6px;
    }

    .Td-Results .badge {
        padding: 6px;
        animation-iteration-count: infinite;
        animation-direction: alternate;
    }

    .error {
        -webkit-animation: bgColor_red 1s;
        /* Firefox */
        -moz-animation: bgColor_red 1s;
        /* Standard Syntax */
        animation: bgColor_red 1s;
    }

    @-webkit-keyframes bgColor_red {
        from {
            background: #ff2e00;
            color: #E1E1E1;
        }

        to {
            background: #FFFFFF;
            color: #212121;
        }
    }

    @-moz-keyframes bgColor_red {
        from {
            background: #ff2e00;
            color: #E1E1E1;
        }

        to {
            background: #FFFFFF;
            color: #212121;
        }
    }

    @keyframes bgColor_red {
        from {
            background: #ff2e00;
            color: #E1E1E1;
        }

        to {
            background: #FFFFFF;
            color: #212121;
        }
    }
</style>

<body>
    <!-- Begin page -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <?php
                $parent = $this->db->query("SELECT Added_By FROM `l1_school` 
WHERE Id = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC")->result_array();
                $parentId = $parent[0]['Added_By'];
                $parent_Infos = $this->db->query("SELECT * FROM `l0_organization` 
WHERE Id = '" . $parentId . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $parent_name = $parent_Infos[0]['Username'];
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Recorded Temperature Today</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $parent_name ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $sessiondata['username']; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
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
                        $Ourstaffs = $ci->db->query("SELECT `l2_student`.* , `r_levels`.`Class_ar` AS StudentClass 
                        FROM `l2_student`
                        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                        WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'  ORDER BY `Id` DESC")->result_array();                        
                }

                    $class = null;
                    $grade = null;

                    foreach ($Ourstaffs as $staff) {
                        $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
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
AND Result_Date = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
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
                        echo "لا يوجد أعراض ";
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

                    .showmoreinfos h6 {
                        cursor: pointer;
                        color: #003CFC;
                    }
                </style>
                <div class="control col-md-12" style="padding-bottom: 15px;">
                    <button type="button" form_target="Staff_list" class="btn btn-primary w-md contr_btn"> <i class="uil uil-list"></i>Staff </button>
                    <button type="button" form_target="Teachers_list" class="btn w-md contr_btn"> <i class="uil uil-list"></i>Teacher </button>
                    <button type="button" form_target="Studnts_list" class="btn w-md contr_btn"> <i class="uil uil-list"></i>Student </button>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="">
                            <div class="card-body">
                                <div>
                                    <!-- sample modal content -->
                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="myModalLabel">User Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row justify-content-center">
                                                        <div class="spinner-grow text-info m-1" role="status"> <span class="sr-only">Loading...</span> </div>
                                                        <div class="row col-lg-12">
                                                            <p class="text-center col-xl-12 mt-2">Loading...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <th> img </th>
                                            <th> Name </th>
                                            <th> Result </th>
                                            <th> Risk </th>
                                            <th> Symptoms </th>
                                            <th> Added By </th>
                                            <th> Device </th>
                                            <th> Created </th>
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
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td data-toggle="modal" data-target="#myModal" class="showmoreinfos" onClick="GetUserData('Staff','<?php echo $staffsRes['Id'] ?>')">
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $staffsRes['position']; ?></p>
                                                </td>
                                                <?php boxes_Colors($staffsRes['Result']); ?>
                                                <td><?php symps($staffsRes['Symp']) ?></td>
                                                <td><?php echo $staffsRes["Added_By"];  ?></td>
                                                <td><?php echo $staffsRes["Device"];  ?></td>
                                                <td><?php echo $staffsRes['Creat'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <div class="row formcontainer" id="Studnts_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Students </h4>
                                <div class="students_button"></div>
                                <table id="Students_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> img </th>
                                            <th> Name </th>
                                            <th> Result </th>
                                            <th> Risk </th>
                                            <th> Symptoms </th>
                                            <th> Added By </th>
                                            <th> Device </th>
                                            <th> Created </th>
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
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td data-toggle="modal" data-target="#myModal" class="showmoreinfos" onClick="GetUserData('Student','<?php echo $staffsRes['Id'] ?>')">
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"> <?php echo $studentResults['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?= $studentResults['Class'] . ", " . $studentResults['grade']; ?> </p>
                                                </td>
                                                <?php boxes_Colors($studentResults['Result']); ?>
                                                <td><?php symps($studentResults['Symp']); ?></td>
                                                <td><?php echo $studentResults["Added_By"];  ?></td>
                                                <td><?php echo $studentResults["Device"];  ?></td>
                                                <td><?php echo $studentResults['Creat'] ?></td>
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
                <div class="row formcontainer" id="Teachers_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Teachers </h4>
                                <table id="Teacher_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> img </th>
                                            <th> Name </th>
                                            <th> Result </th>
                                            <th> Risk </th>
                                            <th> Symptoms </th>
                                            <th> Added By </th>
                                            <th> Device </th>
                                            <th> Created </th>
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
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td data-toggle="modal" data-target="#myModal" class="showmoreinfos" onClick="GetUserData('Teacher','<?php echo $staffsRes['Id'] ?>')">
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"> <?php echo $TeacherResults['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> 
                                                    <?= $this->schoolHelper->teacherClasses($TeacherResults['Id'] , true) ?></p>
                                                </td>
                                                <?php boxes_Colors($TeacherResults['Result']); ?>
                                                <td><?php symps($TeacherResults['Symp']) ?></td>
                                                <td><?php echo $TeacherResults["Added_By"];  ?></td>
                                                <td><?php echo $TeacherResults["Device"];  ?></td>
                                                <td><?php echo $TeacherResults['Creat'] ?></td>
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
            <!-- container-fluid -->
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


        function GetUserData(type, id) {
            //alert(" The UserType :"+type);
            /*  
						  <div class="row justify-content-center">
                        	<div class="spinner-grow text-info m-1" role="status"> <span class="sr-only">Loading...</span> </div>
								<div class="row col-lg-12">
									<p class="text-center col-xl-12 mt-2">Loading...</p>  
								</div>
						  </div>
	 */
            var loading = "";
            loading += '<div class="row justify-content-center">';
            loading += '<div class="spinner-grow text-info m-1" role="status"><span class="sr-only">Loading...</span></div>';
            loading += '<div class="row col-lg-12">';
            loading += '<p class="text-center col-xl-12 mt-2">Loading...</p></div></div>';
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/schools/GetTheUserData',
                data: {
                    type: type,
                    id: id,
                },
                beforeSend: function() {
                    $('.modal-body').html('');
                    $('.modal-body').html(loading);
                },
                success: function(data) {
                    $('.modal-body').html(data);
                },
                ajaxError: function() {
                    $('.modal-body').css('background-color', '#DB0404');
                    $('.modal-body').html("Ooops! Error was found.");
                }
            });
        }
    </script>
</body>
<?php
function boxes_Colors($result)
{
?>
    <td class="Td-Results_font"><?php if ($result >= 38.50) { ?>

            <!-- Hight -->
            <span class="badge error" style="width: 100%;border-radius: 10px;color: #ff2e00;"><?php echo $result; ?></span>
        <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>

            <!-- Moderate -->
            <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"><?php echo $result; ?></span>
        <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>

            <!-- No Risk -->
            <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"><?php echo $result; ?></span>
        <?php } elseif ($result >= 36.20 && $result <= 36.29) { ?>

            <!-- Low -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"><?php echo $result; ?></span>
        <?php } else { ?>

            <!-- Error -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"><?php echo $result; ?></span>
        <?php } ?>
    </td>
    <td class="Td-Results"><?php if ($result >= 38.50) { ?>
            <span class="badge error" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">عالي</span>
        <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">معتدل</span>
        <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">طبيعي</span>
        <?php } elseif ($result >= 36.20 && $result <= 36.29) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">منخفض</span>
        <?php } else { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">قراءة خاطئة</span>
        <?php } ?>
    </td>
<?php
}
?>

</html>