<link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div class="main-content">
    <div class="page-content">
        <div class="alert alert-dismissible fade show" role="alert"> <span id="Toast"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
        </div>
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 021: Add New Teacher</h4>
        <div class="row">
            <form class="needs-validation InputForm col-md-12" novalidate="" style="margin-bottom: 27px;" id="AddTeacher">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2" style="margin-bottom: 11px;">
                                <label>Prefix</label>
                                <select class="custom-select" id="Prefix" name="Prefix">
                                    <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                    <?php foreach ($tbl_prefix as $pref) : ?>
                                        <option value="<?= $pref['Prefix']; ?>"> <?= $pref['Prefix']; ?>. </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                <h3 style="margin-top: 30px;color: #5b73e8;" class="generatedNameTeacher"></h3>
                            </div>
                        </div>
                        <div class="row" style="padding: 0px;">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> First Name EN </label>
                                    <input type="text" value="<?= $user_data->full_name ?>" class="form-control FTeacher_Name_EN" placeholder="First Name EN" name="First_Name_EN" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="validationCustom01">Middle Name EN</label>
                                    <input type="text" class="form-control " id="validationCustom01" placeholder="Middle Name EN" name="Middle_Name_EN" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="validationCustom01">Last Name EN</label>
                                    <input type="text" class="form-control LTeacher_Name_EN" id="validationCustom01" placeholder="Last Name EN" name="Last_Name_EN" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> First Name AR </label>
                                    <input type="text" class="form-control" placeholder="First Name AR" name="First_Name_AR" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="validationCustom01">Middle Name AR</label>
                                    <input type="text" class="form-control" id="validationCustom01" placeholder="Middle Name AR" name="Middle_Name_AR" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="validationCustom01">Last Name AR</label>
                                    <input type="text" class="form-control" id="validationCustom01" placeholder="Last Name AR" name="Last_Name_AR" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label> Date of Birth </label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $dop ?>" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd-m-yyyy" name="DOP">
                                        <div class="input-group-append"> <span class="input-group-text"><i class="mdi mdi-calendar"></i></span> </div>
                                    </div>
                                    <!-- input-group -->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <div class="input-group">
                                        <input type="tel" value="<?= $user_data->phone ?>" class="form-control" required placeholder="Phone" name="Phone">
                                    </div>
                                    <!-- input-group -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Gender</label>
                                <select class="custom-select" name="Gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4" style="margin-bottom: 11px;">
                                <div class="form-group">
                                    <label>National ID</label>
                                    <input type="text" value="<?= $user_data->National_Id ?>" class="form-control" placeholder="National ID" name="N_Id" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-bottom: 11px;">
                                <div class="form-group">
                                    <label>Nationality</label>
                                    <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array();   ?>
                                    <select class="custom-select" name="Nationality">
                                        <option value="Qatar"> Qatar </option>
                                        <?php foreach ($contriesarray as $contries) { ?>
                                            <option value="<?= $contries['name']; ?>" class="option"> <?= $contries['name']; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-bottom: 11px;">
                                <div class="form-group">
                                    <label> Position </label>
                                    <select class="form-control" name="Position">
                                        <?php foreach ($Positions_tech as $Position) { ?>
                                            <option value="<?= $Position['Id']  ?>"> <?= $Position['Position']  ?> </option>
                                        <?php } ?>
                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 11px;display: grid;align-items: center;">
                                <div class="form-group">
                                    <label> Email </label>
                                    <input type="email" class="form-control" placeholder="Email" name="Email" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> Classes </label>
                                <div class="form-group">
                                    <?php if (!empty($classes)) { ?>
                                        <select name="Classes[]" class="form-control select2 select2-multiple" multiple="multiple" data-placeholder="Choose ..." id="">
                                            <?php foreach ($classes as $class) { ?>
                                                <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } else { ?>
                                        <p>You don't have any class, Please edit the school profile <a href="<?= base_url() ?>AR/schools/Profile">Profile</a> </p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 11px;">
                                <div class="form-group">
                                    <label> Relationship Type </label>
                                    <select class="form-control" name="relationship">
                                        <?php foreach ($av_relationships as $av_relationship) { ?>
                                            <option value="<?= $av_relationship['Id'] ?>"><?= $av_relationship['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="billing-name">MAC Address</label>
                                    <input id="input-ip" value="<?= $user_data->watch_mac ?>" class="form-control input-mask" data-inputmask="'alias': 'mac'" name="mac_address">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </div>
        </div>
        </form>
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/inputmask/min/jquery.inputmask.bundle.min.js");       ?>"></script>
<script>
    $(".input-mask").inputmask();
    $(".select2").select2();
    $("#AddTeacher").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/startAddTeacher',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Success',
                        text: 'Everything looks good. Thank you! ',
                        icon: 'success'
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "<?= current_url(); ?>",
                        success: function(response) {
                            setTimeout(() => {
                                location.href = "<?= base_url("AR/schools/Public_Visitors") ?>"
                            }, 500);
                        }
                    });
                } else {
                    $('#Toast').html(data);
                    $('#staffsub').removeAttr('disabled');
                    $('#staffsub').html('Submit !');
                }
            },
            beforeSend: function() {
                $('#Teachersub').attr('disabled', '');
                $('#Teachersub').html('Please wait.');
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });
</script>