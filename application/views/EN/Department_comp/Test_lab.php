<!doctype html>
<html>
<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php

$listofaStaffs = $this->db->query("SELECT * FROM 
l2_co_patient WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

$listofasites = $this->db->query("SELECT * FROM 
l2_co_site WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();

?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
        padding-top: 3px;
    }

    .btn-covid i {
        margin-left: -5px;
    }



    .COUNTER_USED {
        text-align: center;
        display: grid;
        align-items: center;
    }

    input {
        margin-left: 7px;
    }
</style>
<!-- Responsive datatable examples -->
<link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                        Add Lab Test Results for System <?= $sessiondata['f_name'] ?>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <label>Choose Name of the Test </label>
                                    <select class="custom-select" name="Test_device" id="Test_device">
                                        <?php
                                        $Devices = $this->db->query(" SELECT * FROM l2_co_devices WHERE
                                        `Added_by` = '" . $sessiondata['admin_id'] . "'  ORDER BY `Id` DESC ")->result_array();
                                        ?>
                                        <?php foreach ($Devices as $device) : ?>
                                            <option value="<?= $device['Description']; ?>"><?= $device['Description']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-xl-4">
                                    <label>Choose the Department to Enter the Test Results</label>
                                    <select class="custom-select" name="departments">
                                        <option value="<?= $sessiondata['admin_id'] ?>">This active department</option>
                                        <?php if (!empty($supported_departments)) { ?>
                                            <?php foreach ($supported_departments as $dept) : ?>
                                                <option value="<?= $dept['by_dept']; ?>"><?= $dept['Dept_Name_EN']; ?></option>
                                            <?php endforeach; ?>
                                        <?php } ?>
                                        <?php foreach ($permission_depts as $schoolPerm) { ?>
                                            <option value="school_<?= $schoolPerm['by_school'] ?>">school : <?= $schoolPerm['School_Name_EN'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xl-4">
                                    <label>Choose the Type of Test</label>
                                    <select class="custom-select" name="Test_Id" id="Test_Id">
                                        <?php
                                        $TestsCodes = $this->db->query(" SELECT * FROM r_testcode ")->result_array();
                                        ?>
                                        <?php foreach ($TestsCodes as $testCode) : ?>
                                            <option value="<?= $testCode['Test_Desc']; ?>"><?= $testCode['Test_Desc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control col-md-12" style="padding-bottom: 10px;">
                    <button type="button" form_target="Users" class="btn btn-primary w-md contr_btn">
                        <i class="uil uil-plus"></i>Users
                    </button>

                    <button type="button" form_target="Sites" class="btn w-md contr_btn">
                        <i class="uil uil-plus"></i>Sites
                    </button>
                </div>
                <div class="col-lg-12 formcontainer" id="Users">
                    <div class="card usersList" id="usersOf_<?= $sessiondata['admin_id'] ?>">
                        <div class="card-body">
                            <h3 class="card-title mb-4">List of Users</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Img </th>
                                        <th> Name </th>
                                        <th> National ID </th>
                                        <th> User Type </th>
                                        <th> Input </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofaStaffs as $admin) { ?>
                                        <tr id="<?= str_replace(" ", "__", $admin['UserType']) . '_' . $admin['Id']; ?>">
                                            <td style="width: 20px;">
                                                <?php
                                                $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                                                WHERE `For_User` = '" . $admin['Id'] . "' AND `Type_Of_User` = '" . $admin["UserType"] . "' LIMIT 1 ")->result_array();
                                                ?>
                                                <?php if (empty($avatar)) {  ?>
                                                    <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                <?php } else { ?>
                                                    <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <?= $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?>
                                            </td>
                                            <td><?= $admin['National_Id']; ?></td>
                                            <td><?= $admin['UserType']; ?></td>
                                            <td>
                                                <div style="display: flex;">
                                                    <input id="9K3Lt8Gw<?= $admin['Id'] ?>JXNHkS7Q" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;margin-left: 7px;">
                                                    <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $admin['Id']; ?>,'<?= $admin['UserType']; ?>','Pos');" style="margin-left: 10px;text-align: center;padding-right: 7px;">
                                                        <i class="uil uil-plus"></i>
                                                    </button>
                                                    <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $admin['Id']; ?>,'<?= $admin['UserType']; ?>','Nigative');" style="margin-left: 10px;text-align: center;padding-right: 7px;">
                                                        <i class="uil uil-minus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php foreach ($supported_departments as $key => $supported_department) {
                        $listofaStaffs = $this->db->query("SELECT * FROM 
                        l2_co_patient WHERE Added_By = '" . $supported_department['by_dept'] . "'")->result_array(); ?>
                        <div class="card usersList hidden" id="usersOf_<?= $supported_department['by_dept'] ?>">
                            <div class="card-body">
                                <h3 class="card-title mb-4"><?= $supported_department['Dept_Name_EN'] ?>'s Users :</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Img </th>
                                            <th> Name </th>
                                            <th> National ID </th>
                                            <th> User Type </th>
                                            <th> Input </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listofaStaffs as $admin) { ?>
                                            <tr id="<?= str_replace(" ", "__", $admin['UserType']) . '_' . $admin['Id']; ?>">
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
                                                WHERE `For_User` = '" . $admin['Id'] . "' AND `Type_Of_User` = '" . $admin["UserType"] . "' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?= base_url(); ?>uploads/co_avatars/<?= $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?= $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?>
                                                </td>
                                                <td><?= $admin['National_Id']; ?></td>
                                                <td><?= $admin['UserType']; ?></td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <input id="9K3Lt8Gw<?= $admin['Id'] ?>JXNHkS7Q" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;margin-left: 7px;">
                                                        <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $admin['Id']; ?>,'<?= $admin['UserType']; ?>','Pos');" style="margin-left: 10px;text-align: center;padding-right: 7px;">
                                                            <i class="uil uil-plus"></i>
                                                        </button>
                                                        <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $admin['Id']; ?>,'<?= $admin['UserType']; ?>','Nigative');" style="margin-left: 10px;text-align: center;padding-right: 7px;">
                                                            <i class="uil uil-minus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>

                    <?php foreach ($permission_depts as $school) { ?>
                        <?php $listofaStaffs = $this->db->query("SELECT * FROM 
                                    l2_staff WHERE Added_By = '" . $school['by_school'] . "'")->result_array();
                        $listofteachers = $this->db->query("SELECT * FROM 
                                    l2_teacher WHERE Added_By = '" . $school['by_school'] . "'")->result_array();
                        $students = $this->db->query("SELECT * FROM 
                                l2_student WHERE Added_By = '" . $school['by_school'] . "'")->result_array(); ?>
                        <div class="card usersList hidden" id="usersOf_school_<?= $school['by_school'] ?>">
                            <div class="card-body">
                                <h4 class="card-title"><?= $school['School_Name_EN'] ?>'s Users :</h4>
                                <hr>
                                <h3 class="mb-2">Staff :</h3>
                                <table class="Staff_table table">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Staff Name </th>
                                            <th> National ID </th>
                                            <th> Enter Batch Number then Press Result Button </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $s_id = 0;
                                        foreach ($listofaStaffs as $admin) {
                                            $s_id++;
                                        ?>
                                            <tr id="Staff_<?= $admin['Id']; ?>">
                                                <th scope="row"> <?= $s_id; ?> </th>
                                                <td><?= $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                                                <td><?= $admin['National_Id']; ?></td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <input id="9K3Lt8Gw<?= $admin['Id'] ?>JXNHkS7Q" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                        <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTestForSchool(<?= $admin['Id']; ?>,'Staff','Pos');" style="margin-left: 10px;"> <i class="uil uil-plus"></i> </button>
                                                        <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTestForSchool(<?= $admin['Id']; ?>,'Staff','Nigative');" style="margin-left: 10px;"> <i class="uil uil-minus"></i> </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                                <hr>
                                <h3 class="mb-2">Teachers :</h3>
                                <table class="Teachers_table table">
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
                                        foreach ($listofteachers as $s_id =>  $admin) {
                                        ?>
                                            <tr id="Teacher_<?= $admin['Id']; ?>">
                                                <th scope="row"> <?= $s_id + 1; ?> </th>
                                                <td><?= $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?></td>
                                                <td><?= $admin['National_Id']; ?></td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <input id="HmqCUB7<?= $admin['Id']; ?>NcRRX62vQ" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                        <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTestForSchool(<?= $admin['Id']; ?>,'Teacher','Pos');"> <i class="uil uil-plus"></i> </button>
                                                        <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTestForSchool(<?= $admin['Id']; ?>,'Teacher','Nigative');"> <i class="uil uil-minus"></i> </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <hr>
                                <h3 class="mt-2">Students :</h3>
                                <table class="Students_Table table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Student Name </th>
                                            <th> National ID </th>
                                            <th> Enter Batch Number then Press Result Button </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $sn => $stud) { ?>
                                            <tr id="Student_<?= $stud['Id']; ?>">
                                                <th scope="row">
                                                    <?= $sn + 1; ?>
                                                </th>
                                                <td>
                                                    <?= $stud['F_name_EN'] . ' ' . $stud['M_name_EN'] . ' ' . $stud['L_name_EN']; ?>
                                                </td>
                                                <td>
                                                    <?= $stud['National_Id']; ?>
                                                </td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <input id="KKZBBSQ<?= $stud['Id']; ?>NZIOAZS11" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                        <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTestStudent(<?= $stud['Id']; ?>,'Student','Pos');">
                                                            <i class="uil uil-plus"></i>
                                                        </button>
                                                        <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTestStudent(<?= $stud['Id']; ?>,'Student','Nigative');">
                                                            <i class="uil uil-minus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-12 formcontainer" id="Sites">
                    <div class="card SitesList" id="SitesOf_<?= $sessiondata['admin_id'] ?>">
                        <div class="card-body">
                            <table>
                                <thead>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Input</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($listofasites as $sn => $site) { ?>
                                        <tr id="Site_<?= $site['Id'] ?>">
                                            <td><?= $sn + 1 ?></td>
                                            <td><?= $site['Site_Code'] ?></td>
                                            <td><?= $site['Description'] ?></td>
                                            <td>
                                                <div style="display: flex;">
                                                    <input id="ZtCeTM9<?= $site['Id']; ?>KkLpsj8rA" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                    <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $site['Id']; ?>,'Site','Pos');">
                                                        <i class="uil uil-plus"></i>
                                                    </button>
                                                    <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $site['Id']; ?>,'Site','Nigative');">
                                                        <i class="uil uil-minus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php foreach ($supported_departments as $department) { ?>
                        <?php $listofasites = $this->db->get_where('l2_co_site' , ["Added_By" => $department['by_dept']])->result_array();  ?>
                        <div class="card SitesList hidden" id="SitesOf_<?= $department['by_dept'] ?>">
                            <div class="card-body">
                                <h4 class="card-title"><?= $department['Dept_Name_EN'] ?>'s Sites :</h4>
                                <table>
                                    <thead>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Input</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listofasites as $sn => $site) { ?>
                                            <tr id="Site_<?= $site['Id'] ?>">
                                                <td><?= $sn + 1 ?></td>
                                                <td><?= $site['Site_Code'] ?></td>
                                                <td><?= $site['Description'] ?></td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <input id="ZtCeTM9<?= $site['Id']; ?>KkLpsj8rA" type="text" placeholder="Batch" class="form-control" style="width: auto;display: inherit;">
                                                        <button class="btn btn-danger waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $site['Id']; ?>,'Site','Pos');">
                                                            <i class="uil uil-plus"></i>
                                                        </button>
                                                        <button class="btn btn-success waves-effect waves-light btn-covid" onClick="addCovidTest(<?= $site['Id']; ?>,'Site','Nigative');">
                                                            <i class="uil uil-minus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="JHZLNS"></div>
        </div>
    </div>

</body>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    try {
        $("table").DataTable();
    } catch (err) {
        null;
    }

    var batch = "";

    <?php if (!empty($permission_depts)) { ?>

        function addCovidTestForSchool(id, user_type, val) {
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
                    url: '<?= base_url(); ?>EN/Results/AddCovidResult',
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

        function addCovidTestStudent(id, user_type, val) {
            var batch = $("#KKZBBSQ" + id + "NZIOAZS11").val();
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
                    url: '<?= base_url(); ?>EN/Results/AddCovidResult',
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
    <?php } ?>

    function addCovidTest(id, user_type, val) {
        if (user_type == "Site") {
            var batch = $("#ZtCeTM9" + id + "KkLpsj8rA").val();
        } else {
            var batch = $("#9K3Lt8Gw" + id + "JXNHkS7Q").val();
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
                url: '<?= base_url(); ?>EN/Results/AddCovidResult_Co',
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
                title: "Sorry. You Need To Enter The Batch",
                showConfirmButton: !1,
                timer: 1500
            })
        }

    }


    $(document).ready(function() {

        $('select[name="departments"]').change(function() {
            var id = $(this).children("option:selected").val();
            $('.usersList').addClass("hidden");
            $('.SitesList').addClass("hidden");
            $('#usersOf_' + id).removeClass("hidden");
            $('#SitesOf_' + id).removeClass("hidden");
        });

        $("#SelectFromClass").change(function() {
            var selectedclass = $(this).children("option:selected").val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Schools/ListOfStudentByClassCovid',
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

    $('#staff').show();
    $('#Sites').hide();


    $('.control button').click(function() {
        $('.control button').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $('.formcontainer').hide();
        var to = $(this).attr('form_target');
        $('#' + to).show();
    });


    function addLabTest() {
        alert('just test');
    }
</script>

</html>