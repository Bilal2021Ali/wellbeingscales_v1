<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css") ?>">
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css"/>

<div class="main-content">
    <div class="page-content">
        <div class="row h-100">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label">Date Range</label>
                                    <div class="input-daterange input-group" id="datepicker6"
                                         data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                         data-provide="datepicker" data-date-container='#datepicker6'>
                                        <input type="text" class="form-control" autocomplete="off" value="<?= $start ?>"
                                               name="start" placeholder="Start Date"/>
                                        <input type="text" class="form-control" autocomplete="off" name="end"
                                               value="<?= $end ?>" placeholder="End Date"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Tests<span class="text-danger">*</span>:</label>
                                    <select name="tests[]" id="" class="select2 form-control select2-multiple"
                                            multiple="multiple" data-placeholder="All">
                                        <?php foreach ($tests as $test) { ?>
                                            <option <?= in_array($test['Test_Desc'], $selected_tests) ? "selected" : ""; ?>
                                                    value="<?= $test["Test_Desc"] ?>"><?= $test["Test_Desc"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2" type="submit">Generate</button>
                            </div>
                        </form>
                        <hr>
                        <h3 class="card-title mt-2">Teachers:</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive dt-responsive">
                                <thead>
                                <th>#</th>
                                <th>Institution</th>
                                <th>Name of Patient</th>
                                <th>HC Number</th>
                                <th> NID</th>
                                <th> Age</th>
                                <th> Gender</th>
                                <th> Nationality</th>
                                <th> Date of Test</th>
                                <th> Test Type</th>
                                <th> Result</th>
                                <th> View</th>
                                </thead>
                                <tbody>
                                <?php foreach ($teachers as $key => $Result) { ?>
                                    <tr>
                                        <th><?= $key + 1 ?></th>
                                        <td><?= $Result['H_name'] ?></td>
                                        <td><?= $Result['P_name'] ?></td>
                                        <td><?= $Result['HIC_num'] ?></td>
                                        <td><?= $Result['QID'] ?></td>
                                        <td><?= get_age($Result['DOP']) ?></td>
                                        <td><?= $Result['Gender'] ?></td>
                                        <td><?= $Result['Nationality'] ?></td>
                                        <td><?= $Result['Test_Date'] ?></td>
                                        <td><?= $Result['Test_Type'] ?></td>
                                        <td><?= $Result['Result'] == "Positive" ? '<span class="badge rounded-pill bg-danger text-white p-2">Positive</span>'
                                                : '<span class="badge rounded-pill bg-success text-white p-2">Negative</span>' ?></td>
                                        <td>
                                            <a target="_blank"
                                               class="btn btn-rounded btn-<?= $Result['Result'] == "Positive" ? "danger" : "success" ?>"
                                               href="<?= base_url("EN/schools/lab-result/teacher/" . $Result['Id']) ?>">
                                                <i class="uil uil-eye"></i> | View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <h3 class="card-title mt-2">Students:</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive dt-responsive">
                                <thead>
                                <th>#</th>
                                <th>Institution</th>
                                <th>Name of Patient</th>
                                <th>HC Number</th>
                                <th> NID</th>
                                <th> Age</th>
                                <th> Gender</th>
                                <th> Nationality</th>
                                <th> Date of Test</th>
                                <th> Test Type</th>
                                <th> Result</th>
                                <th> View</th>
                                </thead>
                                <tbody>
                                <?php foreach ($students as $key => $Result) { ?>
                                    <tr>
                                        <th><?= $key + 1 ?></th>
                                        <td><?= $Result['H_name'] ?></td>
                                        <td><?= $Result['P_name'] ?></td>
                                        <td><?= $Result['HIC_num'] ?></td>
                                        <td><?= $Result['QID'] ?></td>
                                        <td><?= get_age($Result['DOP']) ?></td>
                                        <td><?= $Result['Gender'] ?></td>
                                        <td><?= $Result['Nationality'] ?></td>
                                        <td><?= $Result['Test_Date'] ?></td>
                                        <td><?= $Result['Test_Type'] ?></td>
                                        <td><?= $Result['Result'] == "Positive" ? '<span class="badge rounded-pill bg-danger text-white p-2">Positive</span>'
                                                : '<span class="badge rounded-pill bg-success text-white p-2">Negative</span>' ?></td>
                                        <td>
                                            <a target="_blank"
                                               class="btn btn-rounded btn-<?= $Result['Result'] == "Positive" ? "danger" : "success" ?>"
                                               href="<?= base_url("EN/schools/lab-result/student/" . $Result['Id']) ?>">
                                                <i class="uil uil-eye"></i> | View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <h3 class="card-title mt-2">Staff:</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive dt-responsive">
                                <thead>
                                <th>#</th>
                                <th>Institution</th>
                                <th>Name of Patient</th>
                                <th>HC Number</th>
                                <th> NID</th>
                                <th> Age</th>
                                <th> Gender</th>
                                <th> Nationality</th>
                                <th> Date of Test</th>
                                <th> Test Type</th>
                                <th> Result</th>
                                <th> View</th>
                                </thead>
                                <tbody>
                                <?php foreach ($staff as $key => $Result) { ?>
                                    <tr>
                                        <th><?= $key + 1 ?></th>
                                        <td><?= $Result['H_name'] ?></td>
                                        <td><?= $Result['P_name'] ?></td>
                                        <td><?= $Result['HIC_num'] ?></td>
                                        <td><?= $Result['QID'] ?></td>
                                        <td><?= get_age($Result['DOP']) ?></td>
                                        <td><?= $Result['Gender'] ?></td>
                                        <td><?= $Result['Nationality'] ?></td>
                                        <td><?= $Result['Test_Date'] ?></td>
                                        <td><?= $Result['Test_Type'] ?></td>
                                        <td><?= $Result['Result'] == "Positive" ? '<span class="badge rounded-pill bg-danger text-white p-2">Positive</span>'
                                                : '<span class="badge rounded-pill bg-success text-white p-2">Negative</span>' ?></td>
                                        <td>
                                            <a target="_blank"
                                               class="btn btn-rounded btn-<?= $Result['Result'] == "Positive" ? "danger" : "success" ?>"
                                               href="<?= base_url("EN/schools/lab-result/staff/" . $Result['Id']) ?>">
                                                <i class="uil uil-eye"></i> | View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/jszip/jszip.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/pdfmake/build/pdfmake.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/pdfmake/build/vfs_fonts.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.html5.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.print.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.colVis.min.js") ?>"></script>
<?php
function get_age($date)
{
    if (empty($date)) return "--";

    $sortedDate = date('Y-m-d', strtotime($date));
    $year = explode("-", $sortedDate)[0];
    $age = date('Y') - intval($year);
    if (date('md') < date('md', strtotime($date))) {
        return $age - 1;
    }

    return $age;
}

?>
<script>
    $('.select2').select2({
        closeOnSelect: false,
        allowClear: true
    });
    $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });
</script>