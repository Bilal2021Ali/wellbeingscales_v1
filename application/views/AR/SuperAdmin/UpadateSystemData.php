<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
    <div class="outer"></div>
    <style>
        .Ver,
        .Not {
            font-size: 14px;
            border-radius: 5px;
            width: 100%;
            display: block;
            text-align: center;
            color: #fff;
            height: 30px;
            line-height: 5px;
            font-style: normal;
            font-weight: bold;
            margin-top: 5px;
        }

        .Ver {
            background: green;
        }

        .Not {
            background: red;
        }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="background: #add138;padding: 10px;color: #000;border-radius: 4px;">Update System</h4>
                            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                <span id="Toast">Please Insert New System Information</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                            <?php foreach ($theadminData as $adminData) { ?>
                                <form class="needs-validation InputForm" novalidate="" style="margin-bottom: 27px;" id="UpSysteme">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="validationCustom01">Arabic Title</label>
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="Arabic Title" name="Arabic_Title" value="<?php echo $adminData['AR_Title'] ?>">
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="validationCustom02">English Title</label>
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="English Title" name="English_Title" required="" value="<?php echo $adminData['EN_Title'] ?>">
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Select System Type</label>
                                            <select class="custom-select" name="Client_type">
                                                <option value="<?php echo $adminData['Type']; ?>"> <?php echo $adminData['Type']; ?> </option>
                                                <?php if ($adminData['Type'] == "Ministry") { ?>
                                                    <option value="Company">Company</option>
                                                <?php } else { ?>
                                                    <option value="Department">Department</option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin: 10px 0px;">
                                            <label>Select Divisions</label>
                                            <select class="custom-select" name="Client_Department">
                                                <option value="<?php echo $adminData['Department']; ?>" class="option">
                                                    <?php echo $adminData['Department']; ?>
                                                </option>
                                                <?php if ($adminData['Department'] == "Department") { ?>
                                                    <option value="School">School</option>
                                                <?php } else { ?>
                                                    <option value="Department">Department</option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array();   ?>
                                        <div class="col-md-12" style="margin-bottom: 10px">
                                            <label>Select Country </label>
                                            <select class="custom-select" name="cousntrie">
                                                <?php
                                                $contries = $this->db->query("SELECT * FROM `r_countries` 
                                                WHERE id = '" . $adminData['CountryID'] . "' ORDER BY `name` ASC")->result_array();
                                                foreach ($contries as $contrie) {
                                                    $name_con = $contrie['name'];
                                                    $id_con = $contrie['id'];
                                                }
                                                ?>
                                                <option value="<?php echo $id_con ?>" class="option"> <?php echo $name_con ?> </option>

                                                <?php foreach ($contriesarray as $contries) { ?>
                                                    <option value="<?php echo $contries['id']; ?>" class="option"><?php echo $contries['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationCustom02">User Name </label>
                                        <input type="text" class="form-control" id="validationCustom02" placeholder="Username" name="Username" required="" value="<?php echo $adminData['Username'] ?>">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $adminData['Id']; ?>" name="ID">

                                    <button class="btn btn-primary" type="Submit">Submit form</button>
                                    <button type="button" class="btn btn-light" id="back">Cancel</button>
                                </form>
                            <?php } ?>
                            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="sendToemail">
                                                <div id="statusbox" class="alert alert-primary" role="alert">
                                                    Please Write Email To Send Infos
                                                </div>
                                                <input type="hidden" class="staticinput" id="getedusername" name="getedusername">
                                                <input type="hidden" class="staticinput" id="getedpassword" name="getedpassword">

                                                <div class="form-group">
                                                    <label for="validationCustom02">Email </label>
                                                    <input type="text" class="form-control" id="validationCustom02" placeholder="Email" name="sendToEmail" required="">
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <button type="Submit" style="width: 100%;" class="btn btn-primary w-lg waves-effect waves-light" id="sendingbutton">SEND THE EMAIL</button>
                                            </form>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>

                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body" style="height: 600px;">
                            <h4 class="card-title">List of Registered Systems</h4>
                            <table class="table mb-0">
                                <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                                    <tr>
                                        <th>No</th>
                                        <th>User Name</th>
                                        <th style="width: 30%;">System Type</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $listofadmins = $this->db->query('SELECT * FROM l0_organization ORDER BY `Created` DESC LIMIT 9')->result_array();
                                    ?>
                                    <?php foreach ($listofadmins as $adminData) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $adminData['Id'] ?></th>
                                            <td><?php echo $adminData['Username'] ?></td>
                                            <td><?php echo $adminData['Type'] ?></td>

                                            <td> <?php
                                                    $contriesarray = $this->db->query("SELECT * FROM `r_countries` 
                                                       WHERE id = '" . $adminData['CountryID'] . "' ORDER BY `name` ASC")->result_array();
                                                    foreach ($contriesarray as $contrie) {
                                                        echo $contrie['name'];
                                                    }
                                                    ?>
                                            </td>
                                            <?php
                                            if ($adminData['verify'] == 1) {
                                                $classname = 'Ver';
                                            } else {
                                                $classname = 'Not';
                                            }
                                            ?>
                                            <td class="<?php echo $classname; ?>">
                                                <?php if (!empty($adminData['Manager']) && !empty($adminData['Tel'])) { ?>
                                                    <i class="uil-check" style="font-size: 20px;font-style: normal;"></i>
                                                <?php } else { ?>
                                                    <i class="" style="font-size: 14px;font-style: normal;">X</i>
                                                <?php } ?>
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
    <script>
        $("#UpSysteme").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Dashboard/startUpdatingSystem',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#Toast').css('display', 'block');
                    $('#Toast').html(data);

                },
                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });




        $("#sendToemail").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Dashboard/SendUpdatedInfosEmail',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#statusbox').css('display', 'block');
                    $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>')
                    $('#sendingbutton').attr('disabled', 'disabled');
                    $('#sendingbutton').addClass('mat-button-disabled');
                    $('#sendingbutton').html('please wait !!');
                },
                success: function(data) {
                    $('#statusbox').css('display', 'block');
                    $('#statusbox').html(data);

                },
                ajaxError: function() {
                    $('#statusbox').css('background-color', '#DB0404');
                    $('#statusbox').html("Ooops! Error was found.");
                }
            });
        });

        $('#back').click(function() {
            location.href = "<?php echo base_url() . "Dashboard/UpdateSystem"; ?>";
        });

        function back() {
            location.href = "<?php echo base_url() . "Dashboard/UpdateSystem"; ?>";
        }
    </script>
</body>

</html>