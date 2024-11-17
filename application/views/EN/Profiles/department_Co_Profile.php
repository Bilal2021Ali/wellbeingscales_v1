<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
    <link href="<?= base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
    <link href="<?= base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <style>
        .control {
            margin: 10px auto;
        }

        .control i {
            margin: 4px;
            font-size: 16px;
            margin-left: -1px;
        }


        .bx.bxs-trash-alt {
            font-size: 24px;
            color: #e8625b;
            margin-left: 9px;
            cursor: pointer;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="">
                        <div class="card-body">
                            <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                                My Profile <?= $sessiondata['f_name'] ?>
                            </h4>
                            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                <span id="Toast"> Update Your Profile </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                </button>

                            </div>
                            <div class="control col-md-12">
                                <button type="button" form_target="Profile" class="btn btn-primary w-md contr_btn">
                                    <i class="uil uil-user"></i> Company Profile
                                </button>
                                <!-- <button type="button" form_target="Permitions" class="btn w-md contr_btn">
                                            <i class="uil uil-plus"></i>Permitions
                                        </button> -->
                            </div>
                            <div class="col-md-12 formcontainer" id="Profile">
                                <div class="row card">
                                    <?php
                                    $id = $sessiondata['admin_id'];
                                    $schoolData = $this->db->query("SELECT * FROM l1_co_department 
                                    WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array() ?>
                                    <?php foreach ($schoolData as $data) { ?>
                                        <form class="needs-validation InputForm card-body" novalidate style="margin-bottom: 27px;" id="UpdateSchool">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom01"> Name in Arabic </label>
                                                        <input type="text" class="form-control" id="validationCustom01" placeholder="name in arabic " value="<?= $data['Dept_Name_AR'] ?>" name="Dept_Name_AR" required>
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom02"> Name in English </label>
                                                        <input type="text" class="form-control" placeholder="name in english" name="Dept_Name_EN" value="<?= $data['Dept_Name_EN'] ?>" required>
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">Manager Arabic Name</label>
                                                        <input type="text" class="form-control" id="validationCustom01" placeholder="Manager Arabic Name" value="<?= $data['Manager_AR'] ?>" name="Manager_AR" required>
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom02">Manager English Name </label>
                                                        <input type="text" class="form-control" placeholder="Manager English Name" name="Manager_EN" value="<?= $data['Manager_EN'] ?>" required>
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom01"> Phone </label>
                                                        <input type="text" class="form-control" id="validationCustom01" placeholder="Phone" value="<?= $data['Phone'] ?>" name="Phone" required>
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="validationCustom02">Email</label>
                                                        <input type="text" class="form-control" placeholder="الإيميل" name="Email" value="<?= $data['Email'] ?>" required="">
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label class="control-label">Select Country</label>
                                                        <select style="width: 100%;display: block;height: 50px;" class="form-control select2" name="Country">
                                                            <?php
                                                            $list = $this->db->query("SELECT * FROM `r_countries` 
                                                            ORDER BY `name` ASC")->result_array();
                                                            foreach ($list as $site) {
                                                            ?>
                                                                <option value="<?= $site['id'];  ?>" <?= $site['id'] == $data['Country'] ? "selected" : "" ?>> <?= $site['name']; ?> </option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="cities">
                                                        <label for="">Select City</label>
                                                        <input type="hidden" value="<?= $data['Citys'] ?>" readonly class="form-control" name="City" placeholder="Please select a country to show the cities.">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Type</label>
                                                    <select name="Type" class="custom-select">
                                                        <option value="Privat" class="option" <?= $data['Type_Of_Dept'] == "Privat" ? "selected" : "" ?>>Private</option>
                                                        <option value="Government" class="option" <?= $data['Type_Of_Dept'] == "Government" ? "selected" : "" ?>>Government</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4" style="display: grid;align-items: center;">
                                                    <div class="form-group">
                                                        <label> Username </label>
                                                        <input type="text" class="form-control" value="<?= $data['Username'] ?>" placeholder="We apologize. The username cannot be changed." data-toggle="tooltip" data-placement="top" title="" data-original-title=" We apologize. The username cannot be changed." readonly>
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display: grid;align-items: center;">
                                                    <div class="form-group">
                                                        <label> Department ID: </label>
                                                        <input type="text" class="form-control" name="DepartmentId" value="<?= $data['DepartmentId'] ?>" placeholder="Department ID">
                                                        <div class="valid-feedback">
                                                            looks good
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="ID" value="<?= $data['Id']; ?>">
                                            <button class="btn btn-primary" type="Submit">Update</button>
                                            <button type="button" class="btn btn-light" id="back">Cancel</button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12 formcontainer" id="Permitions">
                                <div class="row card">
                                    <form class="needs-validation InputForm card-body" novalidate style="margin-bottom: 27px;" id="addpermition">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-group mb-2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <?php
                                                $Patients = $this->db->query("SELECT * FROM l2_patient
                              WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND Perm = 1 ")->result_array(); ?>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label for="">Select User</label>
                                                        <select class="form-control select2" name="selectedPerm">
                                                            <?php
                                                            $stafflist = $this->db->query("SELECT * FROM l2_patient
     WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND Perm = 0 ")->result_array(); ?>
                                                            <?php if (!empty($stafflist)) { ?>
                                                                <?php foreach ($stafflist as $staff) { ?>
                                                                    <option value="<?= $staff['Id']; ?>">
                                                                        <?= $staff['F_name_EN'] . ' ' . $staff['L_name_EN']; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label> Users Permitions: </label>
                                                        <table class="table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($Patients as $patient) { ?>
                                                                    <tr id="PERM<?= $patient['Id']; ?>">
                                                                        <th scope="row"><?= $patient['Id'] ?></th>
                                                                        <td><?= $patient['F_name_EN'] ?></td>
                                                                        <td><?= $patient['L_name_EN'] ?></td>
                                                                        <td>
                                                                            <i class="bx bxs-trash-alt delet" theId="<?= $patient['Id'];  ?>" TypeOfuser="Stuff"></i>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="Submit">Submit form</button>
                                        <button type="button" class="btn btn-light" id="back">Cancel</button>
                                    </form>
                                </div>
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
    <script src="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/rating-init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
    <script>
        const getCities = (countryId, activeCity = null) => {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Ajax/getThisCountrycities' + (activeCity != null ? '/' + activeCity : ''),
                data: {
                    id: countryId,
                },
                beforeSend: function() {
                    $('.cities').html('Loading....');
                },
                success: function(data) {
                    $('.cities').html(data);
                },
                ajaxError: function() {
                    $('.cities').css('background-color', '#B40000');
                    $('.cities').html("نعتذر لدينا مشكلة");
                }
            });
        }
        getCities(<?= $schoolData[0]['Country'] ?>, <?= $schoolData[0]['Citys'] ?>);
        // ajax sending
        $("#UpdateSchool").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Company_Departments/startUpdatingdepartment',
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

        $("#addpermition").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Departments/startAddPermition',
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


        $('#back').click(function() {
            location.href = "<?= base_url() . "index.php / Dashboard "; ?>";
        });

        // Cancel *

        $('#back').click(function() {
            location.href = "<?= base_url() . "index.php / Dashboard "; ?>";
        });

        function back() {
            location.href = "<?= base_url() . "index.php / Dashboard "; ?>";
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
        $('#Profile').show();

        $('.control button').click(function() {
            $('.control button').removeClass('btn-primary');
            $(this).addClass('btn-primary');
            $('.formcontainer').hide();
            var to = $(this).attr('form_target');
            $('#' + to).show();
        });

        // $("#classes").ionRangeSlider({
        //     skin: "round",
        //     type: "double",
        //     grid: true,
        //     min: 0,
        //     max: 12,
        //     from: 0,
        //     to: 12,
        //     values: ['KG1', 'KG2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        // });

        $('.delet').each(function() {
            $(this).click(function() {
                var theId = $(this).attr('theId');
                var TypeOfuser = $(this).attr('TypeOfuser');
                console.log(theId);


                Swal.fire({
                    title: 'Do you want to remove this permission?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Yes, I am sure!`,
                    icon: 'warning',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>EN/Departments/DeletPermition',
                            data: {
                                Conid: theId,
                                TypeOfuser: TypeOfuser,
                            },
                            success: function(data) {
                                Swal.fire(
                                    'success',
                                    data,
                                    'success'
                                );
                                $('#PERM' + theId).remove();
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
            });
        });

        $('select[name="Country"]').change(function() {
            var countryId = $(this).val();
            getCities(countryId);
        });
    </script>

</body>

</html>