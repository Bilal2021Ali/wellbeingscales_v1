<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
    <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <style>
        .slidecontainer {
            width: 100%;
            /* Width of the outside container */
        }

        /* The slider itself */
        .slider {
            -webkit-appearance: none;
            /* Override default CSS styles */
            appearance: none;
            width: 100%;
            /* Full-width */
            height: 25px;
            /* Specified height */
            background: #d3d3d3;
            /* Grey background */
            outline: none;
            /* Remove outline */
            opacity: 0.7;
            /* Set transparency (for mouse-over effects on hover) */
            -webkit-transition: .2s;
            /* 0.2 seconds transition on hover */
            transition: opacity .2s;
        }

        /* Mouse-over effects */
        .slider:hover {
            opacity: 1;
            /* Fully shown on mouse-over */
        }

        /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            /* Override default look */
            appearance: none;
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #4CAF50;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
        }

        .slider::-moz-range-thumb {
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #4CAF50;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
        }

        .InfosCards h4,
        .InfosCards p {
            color: #fff;
        }

        .InfosCards .card-body {
            border-radius: 5px;
        }
    </style>
</head>

<body class="light menu_light logo-white theme-white">
<style>
    .Ver i {
        background: #019C00;
        color: #fff;
        text-align: center;
        font-size: 20px;
        display: grid;
        height: 20px;
        border-radius: 13px;
        font-style: normal;
        font-weight: bold;
        line-height: 19px;
    }

    .Not i {
        background: #F8002E;
        color: #fff;
        text-align: center;
        font-size: 20px;
        display: grid;
        height: 20px;
        border-radius: 13px;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        line-height: 19px;
    }

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>
<div class="main-content">
    <div class="page-content"><br>
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            MOE 009 - School and Department Counters</h4>
        <div class="row">
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #344267;">
                        <div class="float-right mt-2">
                            <!-- <div id="CharTTest1"></div>-->
                            <img src="<?= base_url(); ?>assets/images/icons/counterschools.png" alt="schools"
                                 width="50px"></i>
                        </div>
                        <div>
                            <?php
                            $idd = $sessiondata['admin_id'];
                            $all = $this->db->query("SELECT * FROM `l1_school` WHERE `Added_By` = $idd ")->num_rows();
                            $lasts = $this->db->query("SELECT * FROM `l1_school`  WHERE `Added_By` = $idd  
					ORDER BY Id DESC LIMIT 1 ")->result_array();
                            ?>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                    <?= $all ?>
                  </span></h4>
                            <p class="mb-0">Schools</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                  <?php if (!empty($lasts)) { ?>
                  <?php foreach ($lasts

                  as $last) { ?>
                  <?= $last['Created'] ?>
                </span><br>
                            Last registered school
                            <?php } ?>
                            <?php } else { ?>
                                <?= "--/--/--"; ?>
                                </span><br>
                                Last registered school
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #605091;">
                        <div class="float-right mt-2"><img
                                    src="<?= base_url(); ?>assets/images/icons/counterdepartments.png" alt="department"
                                    width="50px"></div>
                        <div>
                            <?php
                            $all_ministry = $this->db->query("SELECT * FROM `l1_department`
                                             WHERE Added_By = $idd ")->num_rows();
                            $lastminED = $this->db->query("SELECT * FROM `l1_department` WHERE Added_By = $idd ORDER BY Id DESC LIMIT 1 ")->result_array();
                            ?>
                            <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                    <?= $all_ministry ?>
                  </span></h4>
                            <p class="mb-0"> Departments</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                  <?php if ($lastminED) { ?>
                  <?php foreach ($lastminED

                  as $last) { ?>
                  <?= $last['Created'] ?>
                </span><br>
                            Last registered department
                            <?php } ?>
                            <?php } else { ?>
                                <?= "--/--/--"; ?>
                                </span><br>
                                Last registered department
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #344267;">
                        <div class="float-right mt-2"><img
                                    src="<?= base_url(); ?>assets/images/icons/counterschools.png" alt="device"
                                    width="50px"></div>
                        <div>
                            <?php
                            $allEn = $this->db->query("SELECT * FROM `l1_school`
               WHERE `Added_By` = $idd AND `status` = '1' ")->num_rows();
                            $allDes = $this->db->query("SELECT * FROM `l1_school`
               WHERE `Added_By` = $idd AND `status` = '0' ")->num_rows();
                            ?>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                    <?= $allEn ?>
                  </span></h4>
                            <p class="mb-0">Enabled Schools</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
                  <?= $allDes ?>
                        </p>
                        <p class="mb-0">Disabled Schools</p>
                    </div>
                </div>
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3 InfosCards">
                <div class="card">
                    <div class="card-body" style="background-color: #605091;">
                        <div class="float-right mt-2"><img
                                    src="<?= base_url(); ?>assets/images/icons/counterdepartments.png" alt="device"
                                    width="50px"></div>
                        <div>
                            <?php
                            $allEn = $this->db->query("SELECT * FROM `l1_department`
               WHERE `Added_By` = $idd AND `status` = '1' ")->num_rows();
                            $allDes = $this->db->query("SELECT * FROM `l1_department`
               WHERE `Added_By` = $idd AND `status` = '0' ")->num_rows();
                            ?>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                    <?= $allEn ?>
                  </span></h4>
                            <p class="mb-0">Enabled Departments</p>
                        </div>
                        <p class="mt-3 mb-0"><span class="mr-1" style="color: #FFFFFF;">
                  <?= $allDes ?>
                        </p>
                        <p class="mb-0">Disabled Departments</p>
                    </div>
                </div>
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->
        <div class="row">
            <div class="col-12">
                <div class="card"><br>
                    <div class="row image_container"><img src="<?= base_url(); ?>assets/images/banners/Maintiltles.png"
                                                          alt="schools"></div>
                    <br>
                </div>
            </div>
        </div>
        <?php /*?><div class="row">
            <div class="col-xl-12"><br>
                <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE 010 - Add a New School or Department</h4>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" id="title">Add a new department</h4>
                        <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                            <span id="Toast"></span></div>
                        <div class="col-md-12" style="margin: 18px auto;padding: 0px;">
                            <label>Select School or Department:</label>
                            <select name="addingType" id="addingType" class="custom-select">
                                <option value="0" class="option">Select here</option>
                                <option value="School" class="option">+ School</option>
                                <option value="Department" class="option">+ Department</option>
                            </select>
                        </div>
                        <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;" id="addSchool">
                            <hr style="border-width: 4px;border-top-color: #d24d4d;margin: 30px auto;">
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            School english name</h4>
                                        <input type="text" class="form-control" placeholder="School english name"
                                               name="English_Title" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            School arabic name</h4>
                                        <input type="text" class="form-control" id="validationCustom01"
                                               placeholder="School arabic name" name="Arabic_Title" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Manager english name</h4>
                                        <input type="text" class="form-control" placeholder="Manager english name"
                                               name="Manager_EN" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Manager arabic name</h4>
                                        <input type="text" class="form-control" id="validationCustom01"
                                               placeholder="Manager arabic name" name="Manager_AR" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        School Type</h4>
                                    <select name="Type" class="custom-select">
                                        <option value="Government" class="option">Government</option>
                                        <option value="Private" class="option">Private</option>
                                        <option value="Community" class="option">Community</option>
                                    </select>
                                </div>
                                <div class="col-md-6"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        School Gender</h4>
                                    <select name="School_Gender" class="custom-select">
                                        <option value="Male" class="option">Male</option>
                                        <option value="Female" class="option">Female</option>
                                        <option value="mix" class="option">Male &amp; Female</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-6">
                                        <br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Country</h4>
                                        <select style="width: 100%;display: block;height: 50px;"
                                                class="form-control select2" name="Country">
                                            <?php
                                            $list = $this->db->query("SELECT * FROM `r_countries` ORDER BY `name` ASC")->result_array();
                                            foreach ($list as $site) {
                                                ?>
                                                <option <?= $site['id'] == '173' ? "selected" : "" ?>
                                                        value="<?= $site['id']; ?>">
                                                    <?= $site['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"><br>
                                    <div class="cities">
                                        <input type="text" readonly class="form-control" placeholder="City">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="directorate-response"></div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Phone</h4>
                                        <input type="text" class="form-control" placeholder="Phone" name="Phone"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Email</h4>
                                        <input type="text" class="form-control" placeholder="Email" name="Email"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">
                                    <div class="form-group"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Username</h4>
                                        <input type="text" class="form-control" placeholder="User Name" name="Username"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">
                                    <div class="form-group"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            School ID</h4>
                                        <input type="text" class="form-control" placeholder="School Id" name="SchoolId"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="Submit">Add</button>
                            <button type="button" class="btn btn-light" id="back">Cancel</button>
                        </form>
                        <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;"
                              id="addDepartment">
                            <hr style="border-width: 3px;border-top-color: #219824;margin: 30px auto;">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Department english name</h4>
                                        <input type="text" class="form-control" id="validationCustom01"
                                               placeholder="Department Arabic Name" name="Arabic_Title" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Department arabic name</h4>
                                        <input type="text" class="form-control" placeholder="Department English Name"
                                               name="English_Title" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Manager english name</h4>
                                        <input type="text" class="form-control" placeholder="Manager english name"
                                               name="Manager_EN" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Manager arabic name</h4>
                                        <input type="text" class="form-control" id="validationCustom01"
                                               placeholder="Manager arabic name" name="Manager_AR" required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Phone</h4>
                                        <input type="text" class="form-control" placeholder="Phone" name="Phone"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Email</h4>
                                        <input type="text" class="form-control" placeholder="Email" name="Email"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            Country</h4>
                                        <select style="width: 100%;display: block;height: 50px;"
                                                class="form-control select2" name="Country">
                                            <?php
                                            $list = $this->db->query("SELECT * FROM `r_countries` ORDER BY `name` ASC")->result_array();
                                            foreach ($list as $site) {
                                                ?>
                                                <option <?= $site['id'] == '173' ? "selected" : "" ?>
                                                        value="<?= $site['id']; ?>">
                                                    <?= $site['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="cities">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            City</h4>
                                        <input type="text" readonly class="form-control" placeholder="City">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                        Department type</h4>
                                    <select name="Type" class="custom-select">
                                        <option value="Government" class="option">Government</option>
                                        <option value="Private" class="option">Private</option>
                                        <option value="Community" class="option">Community</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            User Name</h4>
                                        <input type="text" class="form-control" placeholder="User Name" name="Username"
                                               required>
                                        <div class="valid-feedback"> looks good</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="Submit"> Add</button>
                            <button type="button" class="btn btn-light" id="back">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><?php */?>
        <div class="row">
            <div class="col-xl-6"><br>
                <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE 011 - List of Schools</h4>
                <div class="card">
                    <div class="card-body" style="height: 600px;overflow: auto">
                        <h4 class="card-title">List of Latest Schools</h4>
                        <table class="table mb-0">
                            <?php
                            $listofadmins = $this->db->query("SELECT * FROM `l1_school` WHERE
                                Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array();
                            ?>
                            <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;">School Name</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Logged</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $s_number = 0;
                            foreach ($listofadmins as $adminData) {
                                $s_number++;
                                ?>
                                <tr>
                                    <th scope="row"> <?= $s_number; ?>
                                    </th>
                                    <td><?= $adminData['School_Name_EN'] ?></td>
                                    <td><?php
                                        $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                        foreach ($contriesarray as $contrie) {
                                            echo $contrie['Name_EN'];
                                        }
                                        ?></td>
                                    <?php
                                    if ($adminData['status'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?= $classname; ?>">
                                        <?php if ($adminData['status']) { ?>
                                            <i class="uil-check" style="font-size: 20px;"></i>
                                        <?php } else { ?>
                                            <i class="" style="font-size: 14px;">X</i>
                                        <?php } ?>
                                    </td>
                                    <?php
                                    if ($adminData['verify'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    $ClassesCho = $this->db->query("SELECT * FROM `l2_grades`
                                            WHERE Id = '" . $adminData['Id'] . "' LIMIT 1")->result_array();
                                    ?>
                                    <td class="<?= $classname; ?>"><?php if (!empty($ClassesCho)) { ?>
                                            <i class="uil-check" style="font-size: 20px;"></i>
                                        <?php } else { ?>
                                            <i class="" style="font-size: 14px;">X</i>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6"><br>
                <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE 012 - List of Departments</h4>
                <div class="card">
                    <div class="card-body" style="height: 600px;">
                        <h4 class="card-title">List of Latest Departments</h4>
                        <table class="table mb-0">
                            <?php
                            $listofadmins = $this->db->query("SELECT * FROM `l1_department` WHERE
                                Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array();
                            ?>
                            <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;"> Department Name</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Logged in</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $s_number = 0;
                            foreach ($listofadmins as $adminData) {
                                $s_number++;
                                ?>
                                <tr>
                                    <th scope="row"> <?= $s_number; ?>
                                    </th>
                                    <td><?= $adminData['Dept_Name_EN'] ?></td>
                                    <td><?php
                                        $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                WHERE id = '" . $adminData['Citys'] . "' ORDER BY `Name_EN` ASC")->result_array();
                                        foreach ($contriesarray as $contrie) {
                                            echo $contrie['Name_EN'];
                                        }
                                        ?></td>
                                    <?php
                                    if ($adminData['status'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?= $classname; ?>">
                                        <?php if ($adminData['status']) { ?>
                                            <i class="uil-check" style="font-size: 20px;"></i>
                                        <?php } else { ?>
                                            <i class="" style="font-size: 14px;">X</i>
                                        <?php } ?>
                                    </td>
                                    <?php
                                    if ($adminData['verify'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?= $classname; ?>"><?php if (!empty($adminData['Manager']) && !empty($adminData['Phone'])) { ?>
                                            <i class="uil-check" style="font-size: 20px;"></i>
                                        <?php } else { ?>
                                            <i class="" style="font-size: 14px;">X</i>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
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
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/rating-init.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
<script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script>
    $('.select2').select2();
    $("#addSchool").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/DashboardSystem/startAddingSchool',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('button[type="submit"]').attr('disabled', '');
                $('button[type="submit"]').html('loading...  ');
            },
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);
                $('button[type="submit"]').removeAttr('disabled', '');
                $('button[type="submit"]').html('send');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    $('select[name="Country"]').change(function () {
        var countryId = $(this).val();
        getcities(countryId);

        if (countryId == <?= $JORDAN ?>) {
            $("#directorate-response").removeClass("d-none");
            $.ajax({
                type: "POST",
                url: "<?= base_url("EN/Ajax/directorate") ?>",
                data: {
                    country: countryId
                },
                success: function (response) {
                    $("#directorate-response").html(response);
                }
            });
        } else {
            $("#directorate-response").addClass("d-none");
        }
    });

    function getcities(cid) {
        var countryId = cid;
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Ajax/getThisCountrycities',
            data: {
                id: countryId,
            },
            beforeSend: function () {
                $('.cities').html('please wait...');
            },
            success: function (data) {
                $('.cities').html(data);
            },
            ajaxError: function () {
                $('.cities').css('background-color', '#B40000');
                $('.cities').html("Ooops! Error was found.");
            }
        });
    }

    function sendbyemail() {
        $('.myModal').addClass('myModalActive');
        $('.outer').css('display', 'block');
    }

    getcities(173);

    $("#sendToemail").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/DashboardSystem/SendSchoolInfosEmail',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#statusbox').css('display', 'block');
                $('#statusbox').html('<p style="width: 100%;margin: 0px;"> Please wait... </p>')
                $('#sendingbutton').attr('disabled', 'disabled');
                $('#sendingbutton').html('Please wait...');
            },
            success: function (data) {
                $('#statusbox').css('display', 'block');
                $('#statusbox').html(data);
            },
            ajaxError: function () {
                $('#statusbox').css('background-color', '#DB0404');
                $('#statusbox').html("Ooops! Error was found.");
            }
        });
    });
    $("#addDepartment").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/DashboardSystem/startAddingDep',
            data: new FormData(this),


            contentType: false,
            cache: false,
            processData: false,
            beforeSend: () => {
                $('button[type="submit"]').attr('disabled', '');
                $('button[type="submit"]').html('loading...  ');
            },
            success: function (data) {
                $('button[type="submit"]').removeAttr('disabled', '');
                $('button[type="submit"]').html('send');
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);
            },
            ajaxError: function () {
                $('#Toast').css('background-color', '#B40000');
                $('#Toast').html("Ooops! Error was found.");
            }
        });
    });
    // Cancel *
    $('#back').click(function () {
        location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
    });

    function back() {
        location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
    }

    $('form:not(#sendToemail)').hide();
    // $(document).ready(function () {
    //     getcities('173');
    //     $("#addingType").change(function () {
    //         var selectedunit = $(this).children("option:selected").val();
    //         if (selectedunit == 'School') {
    //             $('#addSchool').show();
    //             $('#addDepartment').hide();
    //             $('#title').html(" Add a School ");
    //         } else if (selectedunit == 'Department') {
    //             $('#addSchool').hide();
    //             $('#addDepartment').show();
    //             $('#title').html("Add a Department");
    //         } else {
    //             $('#addSchool').hide();
    //             $('#addDepartment').hide();
    //             $('#title').html("Add");
    //         }
    //     });
    // });
</script>
</body>

</html>