<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>

<style>
    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }

</style>
<div class="main-content">
    <div class="page-content">

        <br>

        <div class="container-fluid">
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("profile-title") ?></h4>
            <div class="card"><a class="text-dark">
                    <div class="p-4">
                        <div class="media align-items-center">
                            <div class="mr-3"><i class="uil uil-receipt text-primary h2"></i></div>
                            <div class="media-body overflow-hidden">
                                <h5 class="font-size-16 mb-1"><?= __("profile") ?></h5>

                            </div>
                        </div>
                    </div>
                </a>
                <div class="collapse show">
                    <div class="p-4 border-top">
                        <form id="Minstry_profile">
                            <div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                <?= __("ministry-name-english") ?></h4>
                                            <input type="text" class="form-control"
                                                   placeholder="<?= __("ministry-name-english") ?>"
                                                   value="<?= $profile['EN_Title']; ?>" name="EN_Title">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                <?= __("ministry-name-arabic") ?></h4>
                                            <input type="text" class="form-control"
                                                   placeholder="<?= __("ministry-name-arabic") ?>"
                                                   value="<?= $profile['AR_Title']; ?>" name="AR_Title">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                <?= __("email") ?></h4>
                                            <input type="text" class="form-control"
                                                   placeholder="<?= __("email") ?>"
                                                   value="<?= $profile['Email']; ?>" name="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4"><br>
                                        <div class="form-group mb-0">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                                                <?= __("manager-name") ?></h4>
                                            <input type="text" class="form-control"
                                                   placeholder="<?= __("manager-name") ?>" name="Manager"
                                                   value="<?= $profile['Manager']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <br>
                                        <div class="form-group mb-4">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("phone") ?></h4>
                                            <input type="text" class="form-control" placeholder="<?= __("phone") ?>"
                                                   name="Phone"
                                                   value="<?= $profile['Tel']; ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-lg-4">
                                        <br>
                                        <div class="form-group mb-4 mb-lg-0">
                                            <h4 class="card-title"
                                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("user-name") ?></h4>
                                            <input type="text" class="form-control" placeholder="<?= __("user-name") ?>"
                                                   value="<?= $profile['Username'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="Send" value="Send">
                                <div class="row my-4">
                                    <div class="col">
                                        <a href="<?= base_url($language . "/DashboardSystem"); ?>"
                                           class="btn btn-link text-muted">
                                            <i class="uil uil-arrow-left mr-1"></i>
                                            <?= __("cancel") ?>
                                        </a>
                                    </div>
                                    <!-- end col -->
                                    <div class="col">
                                        <div class="text-sm-right mt-2 mt-sm-0">
                                            <a href="<?= base_url($language . "Users/MyProfile") ?>">
                                                <button class="btn" name="Send" type="button">
                                                    <i class="uil uil-user mr-1"></i>
                                                    <?= __("more-options") ?>
                                                </button>
                                            </a>
                                            <button class="btn btn-success" name="Send" type="submit">
                                                <i class="uil uil-save mr-1"></i>
                                                <?= __("save") ?>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <h4 class="card-title"
                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("new-school") ?></h4>
            <div class="card">

                <div class="card-body">
                    <h3 class="card-title"><?= __("add-school") ?></h3>
                    <form class="needs-validation InputForm" novalidate style="margin-bottom: 27px;" id="addSchool">
                        <hr style="border-width: 4px;border-top-color: #d24d4d;margin: 30px auto;">
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school-english-name") ?></h4>
                                    <input type="text" class="form-control"
                                           placeholder="<?= __("school-english-name") ?>"
                                           name="English_Title" required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school-arabic-name") ?></h4>
                                    <input type="text" class="form-control" id="validationCustom01"
                                           placeholder="<?= __("school-arabic-name") ?>" name="Arabic_Title" required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("manager-english-name") ?></h4>
                                    <input type="text" class="form-control"
                                           placeholder="<?= __("manager-english-name") ?>"
                                           name=" Manager_EN" required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("manager-arabic-name") ?></h4>
                                    <input type="text" class="form-control" id="validationCustom01"
                                           placeholder="<?= __("manager-arabic-name") ?>" name="Manager_AR" required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><br>
                                <h4 class="card-title"
                                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school-type") ?></h4>
                                <select name="Type" class="custom-select">
                                    <option value="Government" class="option"><?= __("government") ?></option>
                                    <option value="Private" class="option"><?= __("private") ?></option>
                                    <option value="Community" class="option"><?= __("community") ?></option>
                                </select>
                            </div>
                            <div class="col-md-6"><br>
                                <h4 class="card-title"
                                    style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school-gender") ?></h4>
                                <select name="School_Gender" class="custom-select">
                                    <option value="Male" class="option"><?= __("male") ?></option>
                                    <option value="Female" class="option"><?= __("female") ?></option>
                                    <option value="mix" class="option"><?= __("male-female") ?></option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-6">
                                    <br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("country") ?></h4>
                                    <select style="width: 100%;display: block;height: 50px;"
                                            class="form-control select2" name="Country">
                                        <?php foreach ($countries as $site) { ?>
                                            <option <?= $site['id'] == $JORDAN ? "selected" : "" ?>
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
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("phone") ?></h4>
                                    <input type="text" class="form-control" placeholder="<?= __("phone") ?>"
                                           name="Phone"
                                           required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("email") ?></h4>
                                    <input type="text" class="form-control" placeholder="<?= __("email") ?>"
                                           name="Email"
                                           required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">
                                <div class="form-group"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("username") ?></h4>
                                    <input type="text" class="form-control" placeholder="<?= __("username") ?>"
                                           name="Username"
                                           required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                            <div class="col-md-6" style="display: grid;align-items: center;margin-top: 10px;">
                                <div class="form-group"><br>
                                    <h4 class="card-title"
                                        style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("school-id") ?></h4>
                                    <input type="text" class="form-control" placeholder="<?= __("school-id") ?>"
                                           name="SchoolId" required>
                                    <div class="valid-feedback"><?= __("good") ?></div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="Submit"><?= __("add") ?></button>
                        <button type="button" class="btn btn-light" id="back"><?= __("cancel") ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-none" id="Toast"></div>
<script src="<?= base_url("assets/libs/sweetalert2/sweetalert2.all.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script>
    $('.select2').select2();
    $("#addSchool").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url($language . "/DashboardSystem/startAddingSchool"); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#addSchool button[type="submit"]').attr('disabled', '');
                $('#addSchool button[type="submit"]').html('<?= __("wait") ?>');
            },
            success: function (data) {
                $('#Toast').css('display', 'block');
                $('#Toast').html(data);
                $('#addSchool button[type="submit"]').removeAttr('disabled', '');
                $('#addSchool button[type="submit"]').html('<?= __("add") ?>');
            },
            ajaxError: function () {
                Swal.fire({
                    title: '<?= __("error") ?>!',
                    text: '<?= __("general-error") ?>',
                    icon: 'error'
                });
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
                url: "<?= base_url($language . "/Ajax/directorate") ?>",
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

    var countryId = $('select[name="Country"]').val();
    getcities(countryId);

    function getcities(cid) {
        var countryId = cid;
        $.ajax({
            type: 'POST',
            url: '<?= base_url($language . "/Ajax/getThisCountrycities"); ?>',
            data: {
                id: countryId,
            },
            beforeSend: function () {
                $('.cities').html('<?= __("wait") ?>');
            },
            success: function (data) {
                $('.cities').html(data);
            },
            ajaxError: function () {
                Swal.fire({
                    title: '<?= __("error") ?>!',
                    text: '<?= __("general-error") ?>',
                    icon: 'error'
                });
            }
        });
    }

    $("#Minstry_profile").on('submit', function (e) {
        const save = $('#Minstry_profile button[type="submit"]');

        save.attr('disabled', '').html('<?= __("wait") ?>');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                save.removeAttr('disabled').html('<?= __("save") ?>');
                if (data.status !== "ok") {
                    Swal.fire({
                        title: '<?= __("error") ?>',
                        html: data.message,
                        icon: 'error'
                    });
                    return;
                }

                Swal.fire({
                    title: '<?= __("success") ?>!',
                    text: '<?= __("updated") ?>',
                    icon: 'success',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function () {
                    location.href = "<?= base_url($language . "/DashboardSystem"); ?>";
                }, 800)
            },
            ajaxError: function () {
                Swal.fire({
                    title: '<?= __("error") ?>!',
                    text: '<?= __("general-error") ?>',
                    icon: 'error'
                });
            }
        });
    });
</script>
