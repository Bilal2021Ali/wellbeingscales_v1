<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
    <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
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
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card"><br>
                    <div class="row image_container"><img src="<?= base_url(); ?>assets/images/banners/Maintiltles.png"
                                                          alt="schools"></div>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <<h4 class="card-title"
                     style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE 015 - School Profile </h4>
                <div class="card">
                    <div class="card-body"><br>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                            Update School Profile</h4>
                        <h4 class="card-title" id="title"></h4>
                        <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                            <span id="Toast">Verify Information</span></div>
                        <?php foreach ($schoolData

                                       as $data) { ?>
                            <form class="needs-validation InputForm" novalidate="" style="margin-bottom: 27px;"
                                  id="UpdateSchool">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><br>
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                School english name</h4>
                                            <input type="text" class="form-control" id="validationCustom02"
                                                   placeholder="School English Name" name="English_Title"
                                                   value="<?= $data['School_Name_EN'] ?>" required="">
                                            <div class="valid-feedback"> Looks good!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><br>
                                            <h4 class="card-title"
                                                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                School arabic name</h4>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                   placeholder="School Arabic Name"
                                                   value="<?= $data['School_Name_AR'] ?>" name="Arabic_Title"
                                                   required="">
                                            <div class="valid-feedback"> Looks good!</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><br>
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                Manager english name</h4>
                                            <input type="text" class="form-control" id="validationCustom02"
                                                   placeholder="Manager English Name" name="Manager_EN"
                                                   value="<?= $data['Manager_EN'] ?>" required="">
                                            <div class="valid-feedback"> Looks good!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><br>
                                            <h4 class="card-title"
                                                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                Manager arabic name</h4>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                   placeholder="Manager Arabic Name" value="<?= $data['Manager_AR'] ?>"
                                                   name="Manager_AR" required="">
                                            <div class="valid-feedback"> Looks good!</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="validationCustom01">Phone </label>
                                            <input type="text" value="<?= $data['Phone'] ?>" class="form-control"
                                                   placeholder="Phone" name="Phone" required>
                                            <div class="valid-feedback"> looks good</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="validationCustom02">Email</label>
                                            <input type="text" value="<?= $data['Email'] ?>" class="form-control"
                                                   placeholder="Email" name="Email" required>
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
                                            <option <?= $data['Type_Of_School'] == "Government" ? 'selected' : '' ?>
                                                    value="Government" class="option">Government
                                            </option>
                                            <option <?= $data['Type_Of_School'] == "Private" ? 'selected' : '' ?>
                                                    value="Private" class="option">Private
                                            </option>
                                            <option <?= $data['Type_Of_School'] == "Community" ? 'selected' : '' ?>
                                                    value="Community" class="option">Community
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6"><br>
                                        <h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            School Gender</h4>
                                        <select name="School_Gender" class="custom-select">
                                            <option <?= $data['Gender'] == "Male" ? 'selected' : '' ?> value="Male"
                                                                                                       class="option">
                                                Male
                                            </option>
                                            <option <?= $data['Gender'] == "Female" ? 'selected' : '' ?> value="Female"
                                                                                                         class="option">
                                                Female
                                            </option>
                                            <option <?= $data['Gender'] == "mix" ? 'selected' : '' ?> value="mix"
                                                                                                      class="option">
                                                Male & Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-6">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                Country</h4>
                                            <select style="width: 100%;display: block;height: 50px;"
                                                    class="form-control" name="Country">
                                                <?php
                                                $corrent = $this->db->query("SELECT `name` FROM `r_countries` 
													WHERE id = '" . $data['Country'] . "' ")->result_array();
                                                ?>
                                                <option value="<?= $data['Country'] ?>">
                                                    <?= $corrent[0]['name']; ?>
                                                </option>
                                                <?php
                                                $list = $this->db->query("SELECT * FROM `r_countries` 
                                                                      ORDER BY `name` ASC")->result_array();
                                                foreach ($list as $site) {
                                                    ?>
                                                    <option value="<?= $site['id']; ?>">
                                                        <?= $site['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 cities">
                                        <h4 class="card-title"
                                            style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                            City</h4>
                                        <select style="width: 100%;display: block;height: 50px;" class="form-control"
                                                name="city">
                                            <?php
                                            $ceties = $this->db->query("SELECT * FROM `r_cities`  
                                                            WHERE `Country_Id` = '" . $data['Country'] . "'
                                                            ORDER BY `Name_EN` ASC")->result_array();
                                            foreach ($ceties as $city) {
                                                ?>
                                                <option <?= $data['Citys'] == $city['Id'] ? "selected" : "" ?>
                                                        value="<?= $city['Id']; ?>">
                                                    <?= $city['Name_EN']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row <?= ($data['Country'] == $JORDAN) ? '' : 'd-none' ?>"
                                     id="directorate-response"></div>

                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                Username</h4>
                                        </div>
                                        <input type="text" class="form-control" id="validationCustom02"
                                               placeholder="لايمكن التعديل هنا" required=""
                                               value="<?= $data['Username'] ?>"
                                               placeholder="We apologize for this inconvenience. Your account has been disabled by the Admin."
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="We apologize for this inconvenience. Your account has been disabled by the Admin."
                                               readonly>
                                        <div class="valid-feedback"> Looks good!</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                School ID</h4>
                                            <input type="text" class="form-control" id="validationCustom02"
                                                   placeholder="SchoolId" name="SchoolId"
                                                   value="<?= $data['SchoolId'] ?>" required="">
                                            <div class="valid-feedback"> Looks good!</div>
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
            </div>
        </div>
        <div class=" row
                            ">
            <!-- end card -->
            <div class="col-xl-6"><br>
                <h4 class="card-title"
                    style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE
                    016 - Schools List </h4>
                <div class="card">
                    <div class="card-body" style="height: 600px;">
                        <h4 class="card-title">Last schools Added</h4>
                        <table class="table mb-0">
                            <?php
                            $listofadmins = $this->db->query("SELECT * FROM `l1_school` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array();
                            $s_num = 0;
                            ?>
                            <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;">School Name</th>
                                <th>Country</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($listofadmins as $adminData) {
                                $s_num++;
                                ?>
                                <tr>
                                    <th scope="row"> <?= $s_num; ?>
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
                                    if ($adminData['verify'] == 1) {
                                        $classname = 'Ver';
                                    } else {
                                        $classname = 'Not';
                                    }
                                    ?>
                                    <td class="<?= $classname; ?>"><?php if (!empty($adminData['Manager']) && !empty($adminData['Tel'])) { ?>
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
                <!-- end card -->
            </div>
            <div class="col-xl-6"><br>
                <h4 class="card-title"
                    style="background: #0eacd8;padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                    MOE
                    017 - Departments List </h4>
                <div class="card">
                    <div class="card-body" style="height: 600px;">
                        <h4 class="card-title">Last Departments Added</h4>
                        <table class="table mb-0">
                            <?php
                            $listofadmins = $this->db->query("SELECT * FROM `l1_department` WHERE
     Added_By = '" . $sessiondata['admin_id'] . "' LIMIT 9 ")->result_array();
                            $s_num = 0;
                            ?>
                            <thead style="border-top: 2px solid #74788d;border-top-left-radius: 43px;">
                            <tr>
                                <th>#</th>
                                <th style="width: 40%;">Department Name</th>
                                <th>Country</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($listofadmins as $adminData) {
                                $s_num++;
                                ?>
                                <tr>
                                    <th scope="row"> <?= $s_num; ?>
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
                <!-- end card -->
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script>
    $("#UpdateSchool").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/DashboardSystem/startUpdatingSchool',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    function sendbyemail() {
        $('.myModal').addClass('myModalActive');
        $('.outer').css('display', 'block');
    }

    $("#sendToemail").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/DashboardSystem/SendUpdatedInfosEmail',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#statusbox').css('display', 'block');
                $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>')
                $('#sendingbutton').attr('disabled', 'disabled');
                $('#sendingbutton').html('please wait !!');
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
    // Cancel *
    $('#back').click(function () {
        location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
    });

    function back() {
        location.href = "<?= base_url() . "DashboardSystem/AddSchool"; ?>";
    }

</script>

<script>
    $(document).ready(function () {
        $("#addingType").change(function () {
            var selectedunit = $(this).children("option:selected").val();
            if (selectedunit == 'School') {
                $('#addSchool').show();
                $('#addDepartment').hide();
                $('#title').html("Add New School");
            } else if (selectedunit == 'Department') {
                $('#addSchool').hide();
                $('#addDepartment').show();
                $('#title').html("Add New Department");
            } else {
                $('#addSchool').hide();
                $('#addDepartment').hide();
                $('#title').html("Add");
            }
        });
    });
    $('select[name="Country"]').change(function () {
        var countryId = $(this).val();
        console.log("triggered", countryId);
        if (countryId == <?= $JORDAN ?>) {
            $("#directorate-response").removeClass("d-none");
            getdirectorate(countryId);
        } else {
            $("#directorate-response").addClass("d-none");
        }
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Ajax/getThisCountrycities',
            data: {
                id: countryId,
            },
            beforeSend: function () {
                $('.cities').html('Please Wait..');
            },
            success: function (data) {
                $('.cities').html(data);
            },
            ajaxError: function () {
                $('.cities').css('background-color', '#B40000');
                $('.cities').html("Ooops! Error was found.");
            }
        });
    });

    getdirectorate(<?= $schoolData[0]['Country'] ?>, <?= $schoolData[0]['Directorate_Id'] ?? 0 ?>, <?= $schoolData[0]['Directorate_Type_Id'] ?? 0 ?>)

    function getdirectorate(country, directorate = null, directorate_type = null) {
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Ajax/directorate") ?>",
            data: {
                country,
                directorate,
                directorate_type
            },
            success: function (response) {
                $("#directorate-response").html(response);
            }
        });
    }
</script>
</body>

</html>