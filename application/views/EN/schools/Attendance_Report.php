<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">

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

        a,
        .title {
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

            #banner-secondary p.intro,
            #banner-secondary .download-box {
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

        .image_container img {
            margin: auto;
            width: 100%;
            max-width: 800px;
        }
    </style>

</head>
<?php
$staffs_of_this_school = $this->db->query("SELECT * FROM l2_staff WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$teachers_of_this_school = $this->db->query("SELECT * FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$Stuents_of_this_school = $this->db->query("SELECT * FROM l2_student WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
?>

<body>
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
            <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">REP 041: Daily Attendance | By Device / By User</h4>
            <div class="container-fluid">


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
                        $Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                    }

                    foreach ($Ourstaffs as $staff) {
                        $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                        $ID = $staff['Id'];
                        $Position_Staff = $staff['Position'];
                        $getResults = $ci->db->query("SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `Id` DESC ")->result_array();
                        foreach ($getResults as $results) {
                            $creat = $results['Created'] . ' ' . $results['Time'];
                            $list[] = array(
                                "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $creat, 'position' => $Position_Staff, "Symp" => $results['Symptoms'],
                                "Added_By" => $results['Added_By'], "Device" => $results['Device']
                            );
                        }
                    }
                    return ($list);
                }

                $Staff_list = data_of_user("Staff", $sessiondata);
                $Student_list = data_of_user("Student", $sessiondata);
                $Teacher_list = data_of_user("Teacher", $sessiondata);

                ?>
                <?php
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

                $devices = $this->db->query("SELECT * FROM l2_devices 
                WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND `UserType` = 'school'  ")->result_array();
                ?>
                <div class="control col-md-12" style="padding: 10px;">
                    <button type="button" form_target="searchbydevice" class="btn btn-primary w-md contr_btn">
                        <i class="uil uil-plus"></i> Search By Device
                    </button>

                    <button type="button" form_target="searchbyname" class="btn w-md contr_btn">
                        <i class="uil uil-plus"></i> Search By Username
                    </button>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Date Range</label>
                                <div>
                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-m-dd" data-date-autoclose="true">
                                        <input type="text" class="form-control" placeholder="From" name="start" autocomplete="off">
                                        <input type="text" class="form-control" placeholder="To" name="end" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formcontainer" id="searchbydevice">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <label>Select Area (Device) :</label>
                                        <select class="custom-select" id="devices">
                                            <option value="">Select Device</option>
                                            <?php if (!empty($devices)) { ?>
                                                <?php foreach ($devices as $device) { ?>
                                                    <option value="<?php echo $device['D_Id']; ?>">
                                                        <?php echo $device['Site'] . " - " . $device['Description']; ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">No device found!</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- class="container"  -->
                    <div id="hereGetedStudents">
                    </div>
                </div>

                <div class="formcontainer" id="searchbyname">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <label for="name">Enter Name :</label>
                                        <select class="select2 form-control" id="name">
                                            <optgroup label="Staff">
                                                <?php foreach ($staffs_of_this_school as $staff) { ?>
                                                    <option value="<?= $staff['Id'] ?>"><?= $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN']; ?></option>
                                                <?php } ?>
                                            </optgroup>
                                            <optgroup label="Teachers">
                                                <?php foreach ($teachers_of_this_school as $teacher) { ?>
                                                    <option value="<?= $teacher['Id'] ?>"><?= $teacher['F_name_EN'] . " " . $teacher['M_name_EN'] . " " . $teacher['L_name_EN']; ?></option>
                                                <?php } ?>
                                            </optgroup>
                                            <optgroup label="Students">
                                                <?php foreach ($Stuents_of_this_school as $student) { ?>
                                                    <option value="<?= $student['Id'] ?>"><?= $student['F_name_EN'] . " " . $student['M_name_EN'] . " " . $student['L_name_EN']; ?></option>
                                                <?php } ?>
                                            </optgroup>
                                        </select>
                                        <!-- <input type="text" placeholder="Enter Name You Want" id="name" class="form-control"> -->
                                    </div>
                                    <div class="col-lg-4" style="padding-top: 30px;">
                                        <button type="button" onClick="GetDataForUser()" style="width: 100%;" class="btn btn-outline-primary waves-effect waves-light">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="getedData">

                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <script src="<?= base_url("assets/libs/select2/js/select2.min.js") ?>"></script>
    <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
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
                    url: '<?php echo base_url(); ?>EN/Results/getResultsbyDevice',
                    data: {
                        type: type,
                        from: $('input[name="start"]').val(),
                        to: $('input[name="end"]').val(),
                    },
                    beforeSend: function() {
                        // setting a timeout
                        $("#hereGetedStudents").html('Please Wait.....');
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
            var id = $('#name').val();
            var type = $("#name option:selected").parent("optgroup").attr("label");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Results/getResultsbyuser',
                data: {
                    userid: id,
                    usertype: type,
                    from: $('input[name="start"]').val(),
                    to: $('input[name="end"]').val(),
                },
                beforeSend: function() {
                    // setting a timeout
                    $("#getedData").html('Please Wait.....');
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
            <?php foreach ($staffs_of_this_school as $stafff) { ?> "<?php echo $stafff['F_name_EN'] . " " . $stafff['M_name_EN'] . " " . $stafff['L_name_EN']; ?>",
            <?php } ?>
            <?php foreach ($teachers_of_this_school as $teach) { ?> "<?php echo $teach['F_name_EN'] . " " . $teach['M_name_EN'] . " " . $teach['L_name_EN']; ?>",
            <?php } ?>
            <?php foreach ($Stuents_of_this_school as $stud) { ?> "<?php echo $stud['F_name_EN'] . " " . $stud['M_name_EN'] . " " . $stud['L_name_EN']; ?>",
            <?php } ?>
        ];
        $("#name").autocomplete({
            source: availableTags
        });
    });
</script>

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
        <?php if ($result >= 38.500 && $result <= 45.500) { ?>
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
        <?php if ($result >= 38.500 && $result <= 45.500) { ?>
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