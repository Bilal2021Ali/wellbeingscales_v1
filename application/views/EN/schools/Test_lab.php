<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$listofSites = $this->db->query("SELECT * FROM 
l2_site WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

$active_classes = $this->schoolHelper->getActiveSchoolClassesByStudents();

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
    .AddedSuccess {
        background-color: #007709;
        text-align: center;
        transition: 0.5s all;
        color: #fff;
        width: 100%;
    }

    .btn-covid {
        border-radius: 100%;
        width: 30px;
        height: 30px;
        text-align: center;
        margin-left: 10px;
    }

    .btn-covid i {
        margin-left: -5px;
    }

    .COUNTER_USED {
        text-align: center;
        display: grid;
        align-items: center;
    }
		.image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px; }
	
</style>
<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
            </div>	<br>
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH P007: Insert Lab Tests Results Manually for Staff, Teachers, and Students</h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <label>1- Select Type</label>
                                    <select class="custom-select" id="List">
                                        <option value="Staffs">Staff</option>
                                        <option value="Techers">Teachers</option>
                                        <option value="Students">Students</option>
                                        <option value="Site">Sites</option>
                                    </select>
                                </div>
                                <div class="col-xl-4">
                                    <label>2- Select Device</label>
                                    <select class="custom-select" name="Test_device" id="Test_device">
                                        <?php
                                        $Devices = $this->db->query(" SELECT * FROM l2_devices WHERE
                            `Added_by` = '" . $sessiondata['admin_id'] . "' AND `Comments` = 'Lab' ORDER BY `Id` DESC ")->result_array();
                                        ?>
                                        <?php foreach ($Devices as $device) : ?>
                                            <option value="<?php echo $device['D_Id']; ?>"><?php echo $device['D_Id']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="card-text">Note: This is a lab test device. </p>
                                </div>
                                <div class="col-xl-4">
                                    <label>3- Select Lab Test</label>
                                    <select class="custom-select" name="Test_Id" id="Test_Id">
                                        <?php
                                        $TestsCodes = $this->db->query(" SELECT * FROM r_testcode ")->result_array();
                                        ?>
                                        <?php foreach ($TestsCodes as $testCode) : ?>
                                            <option value="<?php echo $testCode['Test_Desc']; ?>"><?php echo $testCode['Test_Desc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php
                                /* <div class="col-xl-5" style="margin-bottom: 10px;">
                                        <label style="float: left;">Select Test type</label>
                                        <select class="form-control" name="Test_device" id="Test_device">
                                        <?php $Devices = $this->db->query(" SELECT * FROM l2_devices WHERE `Added_by` = '".$sessiondata['admin_id']."'  ORDER BY `Id` DESC ")->result_array(); ?>
                                        <?php foreach($Devices as $device): ?>
                                        <?php $d_id =  $device['D_Id']; ?>
                                        <optgroup label="<?php echo $d_id; ?>"></optgroup> 
                                        <?php $device_batches = $this->db->query(" SELECT * FROM l2_batches WHERE `For_Device` = '".$device['Id']."' AND `Status` = '0' ORDER BY `Id` DESC ")->result_array(); ?>
                                        <?php foreach($device_batches as $batch){ ?>
                                           <option value="<?php echo $d_id.'@'.$batch['Batch_Id'].'@'.$batch['Device_Type']; ?>"><?php echo $d_id.' - '.$batch['Batch_Id'].' - '.$batch['Device_Type']; ?></option>
                                        <?php } ?>  
                                        <?php endforeach; ?>   
                                        </select>
                                      </div>
                                      <div class="COUNTER_USED col-xl-1"></div> */
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Staffs">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">List of Staff
                                <hr>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Staff Name </th>
                                        <th> National ID </th>
                                        <th> Enter Batch Number then Press Result Button </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofaStaffs as $s_id => $admin) { ?>
                                        <tr id="Staff_<?= $admin['Id']; ?>">
                                            <th scope="row"> <?= $s_id; ?> </th>
                                            <td><?= $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                                            <td><?= $admin['National_Id']; ?></td>
                                            <td>
                                                <div style="display: flex;">
                                                    <input id="9K3Lt8Gw<?= $admin['Id'] ?>JXNHkS7Q" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                    <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $admin['Id']; ?>,'Staff','Pos');" style="margin-left: 10px;"> <i class="uil uil-plus"></i> </button>
                                                    <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $admin['Id']; ?>,'Staff','Nigative');" style="margin-left: 10px;"> <i class="uil uil-minus"></i> </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Techers">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">List of Teachers
                                <hr>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Teacher Name </th>
                                        <th> National ID </th>
                                        <th> Enter Batch Number then Press Result Button </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_id = 0;
                                    foreach ($listofteachers as $admin) {
                                        $s_id++;
                                    ?>
                                        <tr id="Teacher_<?php echo $admin['Id']; ?>">
                                            <th scope="row"> <?php echo $s_id; ?> </th>
                                            <td><?php echo $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                                            <td><?php echo $admin['National_Id']; ?></td>
                                            <td>
                                                <div style="display: flex;">
                                                    <input id="HmqCUB7<?php echo $admin['Id']; ?>NcRRX62vQ" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                    <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?php echo $admin['Id']; ?>,'Teacher','Pos');"> <i class="uil uil-plus"></i> </button>
                                                    <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?php echo $admin['Id']; ?>,'Teacher','Nigative');"> <i class="uil uil-minus"></i> </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Students">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">List of Students
                                <hr>
                                <div class="">
                                    <div class="card-body">
                                        <label for="SelectFromClass"> Select Class </label>
                                        <select name="StudentClass" class="form-control" id="SelectFromClass">
                                            <?php if (!empty($active_classes)) { ?>
                                                <option> Select Class</option>
                                                <?php foreach ($active_classes as $class) { ?>
                                                    <option value="<?= $class['Id']  ?>"><?= $class['Class']; ?> ( <?= $class['student_count'] ?> Students ) </option>
                                                <?php }  ?>
                                            <?php } else { ?>
                                                <option value="">We Apologize, There is No students This School.  Please add student</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div id="hereGetedStudents"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="Site">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">List of Sites
                                <hr>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Site Type </th>
                                        <th> Description </th>
                                        <th> Enter Batch Number then Press Result Button </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_id = 0;
                                    foreach ($listofSites as $admin) {
                                        $s_id++;
                                    ?>
                                        <tr id="Site_<?php echo $admin['Id']; ?>">
                                            <th scope="row"> <?php echo $s_id; ?> </th>
                                            <td><?php echo $admin['Site_Code']; ?></td>
                                            <td><?php echo $admin['Description']; ?></td>
                                            <td>
                                                <div style="display: flex;">
                                                    <input id="ZtCeTM9<?php echo $admin['Id']; ?>KkLpsj8rA" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                    <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?php echo $admin['Id']; ?>,'Site','Pos');"> <i class="uil uil-plus"></i> </button>
                                                    <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?php echo $admin['Id']; ?>,'Site','Nigative');"> <i class="uil uil-minus"></i> </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="JHZLNS"></div>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
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
    try {
        $("table").DataTable();
    } catch (err) {
        null;
    }

    var batch = "";

    function addCovidTest(id, user_type, val) {
        if (user_type == "Staff") {
            var batch = $("#9K3Lt8Gw" + id + "JXNHkS7Q").val();
        } else if (user_type == "Teacher") {
            var batch = $("#HmqCUB7" + id + "NcRRX62vQ").val();
        } else if (user_type == "Site") {
            var batch = $("#ZtCeTM9" + id + "KkLpsj8rA").val();
        }
        // var test = par.child('input').val();
        console.log("THEST Var Is   " + batch);
        var TestDev = $('#Test_device').children("option:selected").val();
        var Test_id = $('#Test_Id').children("option:selected").val();
        //console.log("THEST DEV"+TestDev);
        //alert('Test'+id+' '+user_type+' '+val);
        var result;
        if (val == 'Pos') {
            result = 1;
        } else {
            result = 0;
        }
        if (batch !== "") {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Results/AddCovidResult',
                data: {
                    UserId: id,
                    Test_type: user_type,
                    Temp: result,
                    Device: TestDev,
                    Batch: batch,
                    Test: Test_id,
                },
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
        } else {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Sorry, you need to enter the batch. ",
                showConfirmButton: !1,
                timer: 1500
            })
        }
    }
    /*
    setInterval(() => {
         var TestDev =  $('#Test_device').children("option:selected").val();
         $.ajax({
         type: 'POST',
         url: '<?php echo base_url(); ?>EN/Results/Batch_Counter',
         data: {
              Device : TestDev,
         },
         success: function (data) {
              $('.COUNTER_USED').html(data);
         },
         ajaxError: function(){
         Swal.fire(
         'error',
         'oops!! we have a error',
         'error'
         )
         }
         });  
    }, 1000);*/
    $("#Techers,#Students,#Site").slideUp();
    $(document).ready(function() {
        $("#List").change(function() {
            var selectedunit = $(this).children("option:selected").val();
            if (selectedunit == "Staffs") {
                $('#Staffs').slideDown();
                $('#Techers').slideUp();
                $('#Students').slideUp();
                $('#Site').slideUp();
            } else if (selectedunit == "Techers") {
                $('#Techers').slideDown();
                $('#Staffs').slideUp();
                $('#Students').slideUp();
                $('#Site').slideUp();
            } else if (selectedunit == "Students") {
                $('#Students').slideDown();
                $('#Staffs').slideUp();
                $('#Techers').slideUp();
                $('#Site').slideUp();
            } else if (selectedunit == "Site") {
                $('#Students').slideUp();
                $('#Staffs').slideUp();
                $('#Techers').slideUp();
                $('#Site').slideDown();
            }

        });
        $("#SelectFromClass").change(function() {
            var selectedclass = $(this).children("option:selected").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Schools/ListOfStudentByClassCovid',
                data: {
                    NumberOfClass: selectedclass,
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
        });

    });
    $('input[type="number"]').attr("max", "40");
    $('input[type="number"]').attr("min", "30");
</script>

</html>