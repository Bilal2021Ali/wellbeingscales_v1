<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<?php
$staffs_of_this_school = $this->db->query("SELECT * FROM l2_staff WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$teachers_of_this_school = $this->db->query("SELECT * FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$Stuents_of_this_school = $this->db->query("SELECT * FROM l2_student WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
?>
<style>
    .ShowData {
        width: 100%;
        background: transparent;
        border: 0px;
        font-size: 18px;
        margin-bottom: -15px;
        text-align: center;
        transition: 0.2s all;
    }

    .ShowData:hover {
        transition: 0.2s all;
        font-size: 22px;
    }

    #preloader {
        background: rgba(255, 255, 255, 0.49);
    }

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>

<body>
    <div id="preloader" style="display: none;">
        <div id="status" style="display: none;">
            <div class="spinner">
                <!--                    <i class="uil-shutter-alt spin-icon"></i>  -->
                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="">
            </div>
        </div>
    </div>
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
            <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">REP 040: Monthly | Temperature and other Tests’ Report</h4>
            <div class="container-fluid">
                <form id="getData">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Date Range</label>
                                                <div>
                                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-m-dd" data-date-autoclose="true">
                                                        <input type="text" class="form-control" placeholder="From" name="Start">
                                                        <input type="text" class="form-control" placeholder="To" name="End">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Select User:</label>
                                                <select class="form-control select2" name="User">
                                                    <?php if (!empty($staffs_of_this_school)) {  ?>
                                                        <optgroup label="Staff">
                                                            <?php foreach ($staffs_of_this_school as $staff) { ?>
                                                                <option value="Staff,<?php echo $staff['Id'] ?>,<?php echo $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN'] ?>">
                                                                    <?php echo $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </optgroup>
                                                    <?php } ?>
                                                    <?php if (!empty($teachers_of_this_school)) {  ?>
                                                        <optgroup label="Teacher">
                                                            <?php foreach ($teachers_of_this_school as $Teacher) { ?>
                                                                <option value="Teacher,<?php echo $Teacher['Id'] ?>,<?php echo $Teacher['F_name_EN'] . " " . $Teacher['M_name_EN'] . " " . $Teacher['L_name_EN']; ?>"><?php echo $Teacher['F_name_EN'] . " " . $Teacher['M_name_EN'] . " " . $Teacher['L_name_EN']; ?></option>
                                                            <?php } ?>
                                                        </optgroup>
                                                    <?php } ?>
                                                    <?php if (!empty($Stuents_of_this_school)) {  ?>
                                                        <optgroup label="Teacher">
                                                            <?php foreach ($Stuents_of_this_school as $Student) { ?>
                                                                <option value="Student,<?php echo $Student['Id'] ?>,<?php echo $Student['F_name_EN'] . " " . $Student['M_name_EN'] . " " . $Student['L_name_EN']; ?>"><?php echo $Student['F_name_EN'] . " " . $Student['M_name_EN'] . " " . $Student['L_name_EN']; ?></option>
                                                            <?php } ?>
                                                        </optgroup>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pl-2 pr-2">
                                        <button type="Submit" class="btn btn-primary waves-effect w-100" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Get the Data">Show Results <i class="uil uil-angle-down"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row" id="SetData">

                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
</body>
<script>
    //getData
    $("#getData").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Ajax/GetDataSchoolMonthResults',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#preloader,#status').attr('style', 'display: block;');
            },
            success: function(data) {
                $('#preloader,#status').attr('style', 'display: none;');
                $('#SetData').html(data);
            },
            ajaxError: function() {
                $('#Toast').css('background-color', '#B40000');
                $('#Toast').html("Ooops! Error was found.");
            }
        });
    });
</script>

</html>