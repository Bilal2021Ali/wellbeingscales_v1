<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<?php
$staffs_of_this_school = $this->db->query("SELECT * FROM l2_co_patient WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
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
</style>
<style>
    .lds-roller {
        display: inline-block;
        position: absolute;
        width: 64px;
        height: 64px;
        top: 40%;
        left: 50%;
    }

    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 32px 32px;
    }

    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #2D2D2D;
        margin: -3px 0 0 -3px;
    }

    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }

    .lds-roller div:nth-child(1):after {
        top: 50px;
        left: 50px;
    }

    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }

    .lds-roller div:nth-child(2):after {
        top: 54px;
        left: 45px;
    }

    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }

    .lds-roller div:nth-child(3):after {
        top: 57px;
        left: 39px;
    }

    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }

    .lds-roller div:nth-child(4):after {
        top: 58px;
        left: 32px;
    }

    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }

    .lds-roller div:nth-child(5):after {
        top: 57px;
        left: 25px;
    }

    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }

    .lds-roller div:nth-child(6):after {
        top: 54px;
        left: 19px;
    }

    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }

    .lds-roller div:nth-child(7):after {
        top: 50px;
        left: 14px;
    }

    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }

    .lds-roller div:nth-child(8):after {
        top: 45px;
        left: 10px;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body>
    <div id="preloader" style="display: none;">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                            Report by Time Period for Each User-Results of Temperature Checks - <?php echo $sessiondata['f_name'] ?>
                        </h4>
                    </div>
                </div>

                <form id="getData">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Choose Search Date From - To </label>
                                                <div>
                                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-m-dd" data-date-autoclose="true">
                                                        <input type="text" class="form-control" placeholder="from" name="Start" autocomplete="off">
                                                        <input type="text" class="form-control" placeholder="to" name="End" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Choose User Name</label>
                                                <select class="form-control select2" name="User">
                                                    <?php if (!empty($staffs_of_this_school)) {  ?>
                                                        <optgroup label="Users">
                                                            <?php foreach ($staffs_of_this_school as $staff) { ?>
                                                                <option value="<?php echo $staff['UserType'] ?>,<?php echo $staff['Id'] ?>,<?php echo $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN'] ?>">
                                                                    <?php echo $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </optgroup>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pl-2 pr-2">
                                        <button type="Submit" class="btn btn-primary waves-effect w-100"> Show Results <i class="uil uil-angle-down"></i></button>
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
            url: '<?php echo base_url(); ?>EN/Ajax/GetDataSchoolMonthResults?type="dept"',
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