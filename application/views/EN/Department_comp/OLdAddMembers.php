<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
    <link href="<?php echo base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
    <link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    </head>

    <style>
        .select2-container--default .select2-selection--single {
            height: 37px;
            padding-top: 3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
            width: 31px;
        }

        .control {
            margin: 10px auto;
        }

        .control i {
            margin: 4px;
            font-size: 16px;
            margin-left: -1px;
        }

        .InfosCards h4,
        .InfosCards p {
            color: #fff;
        }

        .InfosCards .card-body {
            border-radius: 5px;
        }
    </style>
    <div class="outer"></div>
    <?php
    $today = date("Y-m-d");
    $allUsersTypes = $this->db->query("SELECT * FROM `r_usertype`")->result_array();

    function actionsCounter($action, $id)
    {
        $today = date("Y-m-d");
        $ci = &get_instance();
        $ci->load->library('session');
        $sessiondata = $ci->session->userdata('admin_details');

        $allUsersTypes = $ci->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`UserType`
	 FROM `r_usertype` 
	 JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
	 AND `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();

        foreach ($allUsersTypes as $type) {
            $count_home = 0;
            $u_type = $type['UserType'];
            $ours = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE `Added_By` = '" . $id . "' AND `UserType` = '" . $u_type . "' ")->result_array();
            $listusers = array();
            foreach ($ours as $user) {
                $getResults_Teacheer = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $user['Id'] . "'
     AND UserType = '" . $u_type . "'  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                if (!empty($getResults_Teacheer)) {
                    $listusers[] = $getResults_Teacheer;
                }
                //print_r($listusers);
            }

            $count_home += sizeof($listusers);
            echo $count_home . ",";
        }
    }
    $prms = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
    FROM `l1_co_department` 
    JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
    JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
    AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
    AND  `v0_permissions`.`Air_quality` = '1'
    WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();

    ?>

    <div class="main-content">

        <div class="page-content">
            <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                Add System Users, Sites to be Monitored, and Thermal Tracking Devices - <?php echo $sessiondata['f_name'] ?>
            </h4>

            <div class="row">
                <div class="col-xl-12">
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div id="column_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="">
                        <div class="card-body">
                            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                <span id="Toast">Please enter the information</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                            </div>
                            <div class="control col-md-12">
                                <?php
                                $prms = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
								  FROM `l1_co_department` 
								  JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
								  JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
								  AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
								  AND  `v0_permissions`.`Air_quality` = '1'
								  WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                                ?>
                                <button type="button" form_target="patient" class="btn w-md contr_btn btn-primary">
                                    <i class="uil uil-plus"></i>User
                                </button>
                                <button type="button" form_target="Site" class="btn w-md contr_btn">
                                    <i class="uil uil-plus"></i>Site
                                </button>
                                <button type="button" form_target="Refrigerator" class="btn w-md contr_btn">
                                    <i class="uil uil-plus"></i> Refrigerator
                                </button>
                                <?php if (!empty($prms)) {  ?>
                                    <button type="button" form_target="Area" class="btn w-md contr_btn">
                                        <i class="uil uil-plus"></i> Area
                                    </button>
                                <?php  }  ?>
                            </div>
                            <div class="col-md-12 formcontainer" id="patient">
                                <div class="row">
                                    <form class="needs-validation InputForm col-md-12" novalidate style="margin-bottom: 27px;" id="Addpatient">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <a href="<?php echo base_url(); ?>EN/Company_Departments/LoadFromCsv">
                                                        Uploade the CSV Users Form
                                                    </a>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2" style="margin-bottom: 11px;">
                                                        <label>User Type</label>
                                                        <select class="custom-select" id="Prefix" name="Prefix">
                                                            <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
                                                            <?php foreach ($tbl_prefix as $pref) : ?>
                                                                <option value="<?php echo $pref['UserType']; ?>">
                                                                    <?php echo $pref['UserType']; ?>
                                                                </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                                        <h3 style="margin-top: 30px;color: #5b73e8;" id="generatedName"></h3>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding: 0px;">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="validationCustom02"> First Name in English </label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="First name in English" name="First_Name_EN" equired>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="validationCustom01">Middle Name in English</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Middle name in English" name="Middle_Name_EN" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="validationCustom01">Last Name in English</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Last name in English" name="Last_Name_EN" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="validationCustom02">First Name in Arabic </label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="first name in arabic" name="First_Name_AR" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="validationCustom01">Middle Name in Arabic</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Middle name in arabic" name="Middle_Name_AR" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="validationCustom01">Last Name in Arabic</label>
                                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Last name in arabic" name="Last_Name_AR" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label> Date of Birth </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd-m-yyyy" name="DOP">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                            <!-- input-group -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <div class="input-group">
                                                                <input type="tel" class="form-control" required placeholder="Phone" name="Phone">
                                                            </div>
                                                            <!-- input-group -->
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Gender</label>
                                                        <select class="custom-select" name="Gender">
                                                            <option value="1">Male</option>
                                                            <option value="0">female</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-6" style="margin-bottom: 11px;">
                                                        <div class="form-group">
                                                            <label>National ID</label>
                                                            <input type="text" class="form-control" id="validationCustom02" placeholder="National ID" name="N_Id" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="margin-bottom: 11px;">
                                                        <div class="form-group">
                                                            <label>Nationality</label>
                                                            <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array();   ?>
                                                            <select class="custom-select" name="Nationality">
                                                                <option value="Qatar"> Qatar </option>
                                                                <?php foreach ($contriesarray as $contries) { ?>
                                                                    <option value="<?php echo $contries['name']; ?>" class="option">
                                                                        <?php echo $contries['name']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $positions = $this->db->query("SELECT * FROM `r_positions` 
																 ORDER BY `Position` DESC ")->result_array();
                                                    ?>
                                                    <div class="col-md-6" style="margin-bottom: 11px;">
                                                        <div class="form-group">
                                                            <label> Position </label>
                                                            <select name="Position" class="custom-select">
                                                                <?php foreach ($positions as $position) { ?>
                                                                    <option value="<?php echo $position['Position'] ?>" class="option">
                                                                        <?php echo $position['Position'] ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="margin-bottom: 11px;">
                                                        <div class="form-group">
                                                            <label> Email </label>
                                                            <input type="email" class="form-control" id="validationCustom02" placeholder="email" name="Email" required>
                                                            <div class="valid-feedback">
                                                                looks good
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div style="margin-top: 10px;">
                                    <button class="btn btn-primary" id="Teachersub" type="Submit">Add</button>
                                    <button type="button" class="btn btn-light" id="back">Cancel</button>
                                </div>
                                </form>

                            </div>

                            <div class="col-md-12 formcontainer" id="Site">
                                <div class="row">
                                    <form class="needs-validation InputForm col-md-12" novalidate="" style="margin-bottom: 27px;" id="AddSite">
                                        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 025: Add a New General Site</h4>
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="control-label">Type of Site</label>
                                                            <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="Site">
                                                                <?php
                                                                $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                                foreach ($list as $site) {
                                                                ?>
                                                                    <option value="<?php echo $site['Site_Name'];  ?>"> <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name']; ?> </option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">Description</label>
                                                            <input type="text" class="form-control" placeholder="Description" name="Description">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-4">
                                                            <label class="control-label"> This site is for:</label>
                                                            <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="Site_for">
                                                                <option value="1"> Lab Test </option>
                                                                <option value="2"> Thermometer </option>
                                                                <option value="3"> Gateway </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div style="margin-top: 10px;">
                                    <button class="btn btn-primary" id="StudentSub" type="Submit">Submit form</button>
                                    <button type="reset" class="btn btn-light">Cancel</button>
                                </div>
                                </form>
                                <br>
                                <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 026: List of Last Added General Sites </h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table>
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Type Site</th>
                                                        <th>Description</th>
                                                        <th>For</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php $codes = array(1, 2, 3); ?>
                                                        <?php $names = array('Lab Test', 'Thermometer', 'Gateway'); ?>
                                                        <?php foreach ($sites as $sn => $site) { ?>
                                                            <tr>
                                                                <td><?= $sn + 1 ?></td>
                                                                <td><?= $site['Site_Code']  ?></td>
                                                                <td><?= $site['Description'] ?></td>
                                                                <td><?= $site['Site_For'] == "" ? "not found" : str_replace($codes, $names, $site['Site_For']); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 formcontainer" id="Refrigerator">
                                <div class="row">
                                    <form class="needs-validation InputForm col-md-12" novalidate style="margin-bottom: 27px;" id="Addmachine">
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h3>Add Refrigerator</h3>
                                                        <p class="card-text">To Add Refrigerator:<br>
                                                            1- Add Area for Specific <br>
                                                            2- Add Refrigerator MAC Address
                                                            Notes: list Area added before
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">Mac Adress</label>
                                                            <input type="text" class="form-control" placeholder="Mac Adress" name="name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name">Type</label>
                                                            <?php
                                                            $types = $this->db->query("SELECT * FROM  `refrigerator_levels`")->result_array();
                                                            ?>
                                                            <select name="type" class="form-control">
                                                                <?php foreach ($types as $type) { ?>
                                                                    <option value="<?php echo $type['Id'] ?>">
                                                                        <?php echo $type['device_name'] . "  (" . $type['min_temp'] . "," . $type['max_temp'] . ")" ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="control-label">Choose Site</label>
                                                            <select class="form-control" name="Site">
                                                                <?php
                                                                $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                                foreach ($list as $site) { ?>
                                                                    <option value="<?php echo $site['Id'];  ?>">
                                                                        <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name']; ?>
                                                                    </option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="billing-name"> Description </label>
                                                            <input type="text" class="form-control" placeholder="Description" name="description" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $Refrigerators = $this->db->query(" SELECT * ,
															`refrigerator_levels`.`TimeStamp` AS Added_in , 
															`refrigerator_area`.`Description` AS  The_Site_Name
															FROM `refrigerator_area` 
															JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type` 
															JOIN `r_sites` ON `r_sites`.`Id` = `refrigerator_area`.`Site_Id` 
															WHERE 
															`refrigerator_area`.`source_id` = '" . $sessiondata['admin_id'] . "'
															AND `refrigerator_area`.`user_type` = 'company_department'
															ORDER BY `refrigerator_area`.`Id` DESC ")->result_array();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary" id="StudentSub" type="Submit">Add</button>
                                            <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-lg-12">
                                                    <h3>last added Refrigerators</h3>
                                                </div>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th> # </th>
                                                            <th> Mac </th>
                                                            <th> Type </th>
                                                            <th> Site </th>
                                                            <th> Date &amp; Time </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0;
                                                        foreach ($Refrigerators as $Refrigerator) {  ?>
                                                            <tr>
                                                                <td><?php $i++;
                                                                    echo $i;  ?></td>
                                                                <td><?php echo $Refrigerator['mac_adress']  ?></td>
                                                                <td>
                                                                    <?php
                                                                    echo $Refrigerator['device_name'] . '(' . $Refrigerator['min_temp'] . '-' . $Refrigerator['max_temp'] . ')';
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $Refrigerator['The_Site_Name']  ?></td>
                                                                <td><?php echo $Refrigerator['Added_in']  ?></td>
                                                            </tr>
                                                        <?php   } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <?php if (!empty($prms)) { ?>
                                <div class="col-md-12 formcontainer" id="Area">
                                    <div class="row">
                                        <form class="needs-validation InputForm col-md-12" novalidate style="margin-bottom: 27px;" id="AddArea">
                                            <div class="card" style="width: 100%;">
                                                <div class="card-body">
                                                    <h3 class="card-title">Add Area</h3>
                                                    <p class="card-text">This area is specific for Air Quality.</p>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group mb-4">
                                                                <label class="control-label">Choose Site</label>
                                                                <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="Site">
                                                                    <?php
                                                                    $list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
                                                                    foreach ($list as $site) { ?>
                                                                        <option value="<?php echo $site['Id'];  ?>">
                                                                            <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name']; ?>
                                                                        </option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group mb-4">
                                                                <label for="billing-name">MAC Address</label>
                                                                <input type="text" class="form-control" placeholder="MAC address" name="MAC" id="MAC">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group mb-4">
                                                                <label for="billing-name">Description</label>
                                                                <input type="text" class="form-control" placeholder="the description" name="Description">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <button class="btn btn-primary" id="AreaSub" type="Submit">Add</button>
                                        <button type="button" class="btn btn-light" id="back">Cancel</button>
                                    </div>
                                    <?php
                                    $get_areas = $this->db->query("SELECT * ,
                                    `air_areas`.`TimeStamp` AS DateTime ,
                                    `r_sites`.`Site_Name` AS Added_in
                                    FROM `air_areas`
                                    JOIN `r_sites` ON `r_sites`.`Id` = `air_areas`.`Site_Id`
                                    WHERE `user_type` = 'Company_Department' AND
                                    `source_id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                                    ?>
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="col-lg-12">
                                                <h3>last added Areas</h3>
                                            </div>
                                            <table class="table no-footer">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Description </th>
                                                        <th> MAC Address </th>
                                                        <th> Site </th>
                                                        <th> Date &amp; Time </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0;
                                                    foreach ($get_areas as $area) {  ?>
                                                        <tr>
                                                            <td><?php $i++;
                                                                echo $i;  ?></td>
                                                            <td>
                                                                <?php echo $area['Description']  ?>
                                                            </td>
                                                            <td><?php echo $area['mac_adress']  ?></td>
                                                            <td><?php echo $area['Added_in']  ?></td>
                                                            <td><?php echo $area['DateTime']  ?></td>
                                                        </tr>
                                                    <?php   } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card -->
    </div>
    </div>
    </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/rating-init.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
    <script>
        // ajax sending
        $("table").DataTable();
        $("#Addpatient").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Company_Departments/startAddpatient',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#Toast').html(data);
                    $('#Teachersub').removeAttr('disabled');
                    $('#Teachersub').html('add');
                },
                beforeSend: function() {
                    $('#Teachersub').attr('disabled', '');
                    $('#Teachersub').html('Please wait...');
                },
                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });

        $("#AddSite").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Company_Departments/startAddSite',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#Toast').html(data);
                    $('#StudentSub').removeAttr('disabled');
                    $('#StudentSub').html('add');
                },
                beforeSend: function() {
                    $('#StudentSub').attr('disabled', '');
                    $('#StudentSub').html('Please wait...');
                },

                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });

        $("#Addmachine").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Company_Departments/startAddMachine',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#Toast').html(data);
                    $('#StudentSub').removeAttr('disabled');
                    $('#StudentSub').html('add');
                },
                beforeSend: function() {
                    $('#StudentSub').attr('disabled', '');
                    $('#StudentSub').html('please wait....');
                },

                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });

        <?php if (!empty($prms)) {  ?>
            $("#AddArea").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Company_Departments/startAddArea',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $('#Toast').html(data);
                        $('#AreaSub').removeAttr('disabled');
                        $('#AreaSub').html('add');
                    },
                    beforeSend: function() {
                        $('#AreaSub').attr('disabled', '');
                        $('#AreaSub').html('please wait....');
                    },

                    ajaxError: function() {
                        $('.alert.alert-info').css('background-color', '#DB0404');
                        $('.alert.alert-info').html("Ooops! Error was found.");
                    }
                });
            });
        <?php  } ?>


        $('#back').click(function() {
            location.href = "<?php echo base_url() . "EN/Company_Departments"; ?>";
        });

        // Cancel *
        function back() {
            location.href = "<?php echo base_url() . "EN/Company_Departments"; ?>";
        }

        $("input[name='Min'],input[name='Max']").TouchSpin({
            verticalbuttons: true
        }); //Bootstrap-MaxLength



        $(document).ready(function() {

            $("#UnitType").change(function() {
                var selectedunit = $(this).children("option:selected").val();
                if (selectedunit == 0) {
                    $('#1').hide();
                    $('#0').show();
                } else {
                    $('#0').hide();
                    $('#1').show();
                }

            });


            var prex = '';
            var firstname = '';
            var lastname = '';

            $('#Prefix').change(function() {
                prex = $(this).children("option:selected").val();
            });

            $('input[name="First_Name_EN"], input[name="Last_Name_EN"]').on("keyup keypress blur", function() {
                var firstname = $('input[name="First_Name_EN"]').val();
                var lastname = $('input[name="Last_Name_EN"]').val();
                var all = prex + " " + firstname + " " + lastname;
                $('#generatedName').html(all);
            });

        });

        $('.formcontainer').hide();
        $('#patient').show();

        $('.control button').click(function() {
            $('.control button').removeClass('btn-primary');
            $(this).addClass('btn-primary');
            $('.formcontainer').hide();
            var to = $(this).attr('form_target');
            $('#' + to).show();
        });


        <?php

        $supported_types = $this->db->query("SELECT DISTINCT `r_usertype`.`UserType` , `r_usertype`.`UserType`
FROM `r_usertype` 
JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
AND `l2_co_patient`.`Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();

        ?>

        options = {
            chart: {
                height: 350,
                type: "bar",
                toolbar: {
                    show: !1
                }

            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "45%",
                    endingShape: "rounded"
                }
            },
            dataLabels: {
                enabled: !0,
                formatter: function(e) {
                    return e
                },
            },
            stroke: {
                show: !0,
                width: 2,
                colors: ["transparent"]
            },
            series: [{
                name: "all",
                data: [
                    <?php
                    foreach ($supported_types as $type) {
                        $allUsersByType =  $this->db->query("SELECT * FROM `l2_co_patient` 
				WHERE `UserType` = '" . $type['UserType'] . "'
				AND `Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC ")->result_array();
                        echo sizeof($allUsersByType) . ",";
                    }
                    ?>
                ],
            }, {
                name: "Quarantine",
                data: [<?php actionsCounter("Quarantine", $sessiondata['admin_id']); ?>],
            }, {
                name: "Home",
                data: [<?php actionsCounter("Home", $sessiondata['admin_id']); ?>],
            }, ],
            colors: ["#f1b44c", "#5b73e8", "#34c38f"],
            xaxis: {
                categories: [
                    <?php
                    foreach ($supported_types as $type) {
                        echo '"' . ucfirst($type['UserType']) . '",';
                    }
                    ?>
                ]
            },
            yaxis: {
                title: {
                    text: "Counter"
                }
            },
            grid: {
                borderColor: "#f1f1f1"
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(e) {
                        return e
                    }
                }
            }
        };
        (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render();

        function isHex(char) {
            if (!isNaN(parseInt(char))) {
                return true;
            } else {
                switch (char.toLowerCase()) {
                    case "a":
                    case "b":
                    case "C":
                    case "d":
                    case "e":
                    case "f":
                        return true;
                        break;
                }
                return false;
            }
        }

        document.getElementById("MAC").addEventListener('keyup', function() {
            var mac = document.getElementById('MAC').value;
            if (mac.length < 2) {
                return;
            }
            var newMac = mac.replace("-", "");
            if ((isHex(mac[mac.length - 1]) && (isHex(mac[mac.length - 2])))) {
                newMac = newMac + ":";
            }
            document.getElementById('MAC').value = newMac;
        });
    </script>

</body>

</html>