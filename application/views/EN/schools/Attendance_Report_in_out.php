<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        .badge {
            text-align: center;
        }

        .Td-Results {
            color: #FFFFFF;
        }
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

        input {
            text-align: center;
        }

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
</head>
<?php
$staffs_of_this_school = $this->db->query("SELECT * FROM l2_staff WHERE
Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$teachers_of_this_school = $this->db->query("SELECT * FROM l2_teacher WHERE 
Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
$Stuents_of_this_school = $this->db->query("SELECT * FROM l2_student WHERE
Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
?>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?= base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">REP 042: Attendance by Date per User</h4>
            <div class="container-fluid">
                <div class="formcontainer">
                    <div class="card">
                        <div class="card-body">
                            <form id="getData">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Date Range</label>
                                            <div>
                                                <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-m-dd" data-date-autoclose="true">
                                                    <input type="text" class="form-control" placeholder="From" name="Start" autocomplete="off">
                                                    <input type="text" class="form-control" placeholder="To" name="End" autocomplete="off">
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
                                                            <option value="Staff,<?= $staff['Id'] ?>,<?= $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN'] ?>"> <?= $staff['F_name_EN'] . " " . $staff['M_name_EN'] . " " . $staff['L_name_EN']; ?> </option>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                                <?php if (!empty($teachers_of_this_school)) {  ?>
                                                    <optgroup label="Teacher">
                                                        <?php foreach ($teachers_of_this_school as $Teacher) { ?>
                                                            <option value="Teacher,<?= $Teacher['Id'] ?>,<?= $Teacher['F_name_EN'] . " " . $Teacher['M_name_EN'] . " " . $Teacher['L_name_EN']; ?>"><?= $Teacher['F_name_EN'] . " " . $Teacher['M_name_EN'] . " " . $Teacher['L_name_EN']; ?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                                <?php if (!empty($Stuents_of_this_school)) {  ?>
                                                    <optgroup label="Teacher">
                                                        <?php foreach ($Stuents_of_this_school as $Student) { ?>
                                                            <option value="Student,<?= $Student['Id'] ?>,<?= $Student['F_name_EN'] . " " . $Student['M_name_EN'] . " " . $Student['L_name_EN']; ?>"><?= $Student['F_name_EN'] . " " . $Student['M_name_EN'] . " " . $Student['L_name_EN']; ?></option>
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
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row" id="SetData"></div>
            </div>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="<?= base_url(); ?>assets/js/app.js"></script>
    <script>
        $("#getData").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Ajax/Attendence_in_of',
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
</body>
<script>
    $(function() {
        var availableTags = [
            <?php foreach ($staffs_of_this_school as $stafff) { ?> "<?= $stafff['F_name_EN'] . " " . $stafff['M_name_EN'] . " " . $stafff['L_name_EN']; ?>",
            <?php } ?>
            <?php foreach ($teachers_of_this_school as $teach) { ?> "<?= $teach['F_name_EN'] . " " . $teach['M_name_EN'] . " " . $teach['L_name_EN']; ?>",
            <?php } ?>
            <?php foreach ($Stuents_of_this_school as $stud) { ?> "<?= $stud['F_name_EN'] . " " . $stud['M_name_EN'] . " " . $stud['L_name_EN']; ?>",
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