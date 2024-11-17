<!doctype html>
<html lang="ar">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">

<body class="light menu_light logo-white theme-white">
<link href="<?php echo base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
      rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"
      rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
<link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>

</head>
<style>
    html[dir="rtl"] .select2-container--default .select2-selection--single {
        text-align: right;
    }

    html[dir="rtl"] .select2-container--default .select2-selection--single .select2-selection__arrow {
        left: auto;
        right: 5px;
    }

    html[dir="rtl"] .control i {
        margin: 4px 0 4px 8px;
        float: left;
        font-size: 16px;
    }

    html[dir="rtl"] label:not(.btn) {
        text-align: right;
    }

    .btn-blue {
        background-color: #07bff3;
        color: #1E1E1E;
    }

    form label:not(.dataTables_wrapper label) {
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        width: 100%;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: #07bff3;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 036
            تحديث معلومات الطالب
            <a style="font-size: 25px;margin-top: -4px;" class="float-right text-white" target="_blank"
               href="<?= base_url(config_item('env')['INDEX_PAGE'] . "/AR/schools/user-profile/student/" . $StaffData[0]['Id']) ?>">
                <i class="uil uil-user"></i>
            </a>
        </h4>
        <div class="row">
            <div class="col-xl-12">
                <div class="">
                    <div class="card-body">
                        <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                            <span id="Toast">يرجى تحديث المعلومات الخاصة بالطالب</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>

                        </div>
                        <div class="col-md-12 formcontainer" id="staff">
                            <div class="row">
                                <?php foreach ($StaffData

                                as $stuffdata) { ?>
                                <form class="needs-validation InputForm col-md-12" novalidate=""
                                      style="margin-bottom: 27px;" id="UpdateStudentData">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2" style="margin-bottom: 11px;">
                                                    <label>الكنية</label>
                                                    <select class="custom-select" id="Prefix" name="Prefix">
                                                        <?php $tbl_prefix = $this->db->query("SELECT * FROM `r_prefix`")->result_array(); ?>
                                                        <?php foreach ($tbl_prefix as $pref) : ?>
                                                            <option value="<?php echo $pref['Prefix']; ?>">
                                                                <?php echo $pref['Prefix_ar']; ?>.
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-10 d-none d-md-block" style="margin-bottom: 11px;">
                                                    <h3 style="margin-top: 30px;color: #5b73e8;"
                                                        id="generatedName"></h3>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 0px;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom02"> الإسم الأول بالإنجليزي </label>
                                                        <input type="text" class="form-control" id="validationCustom02"
                                                               placeholder="First Name EN" name="First_Name_EN"
                                                               required=""
                                                               value="<?php echo $stuffdata['F_name_EN'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأوسط بالإنجليزي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name EN" name="Middle_Name_EN"
                                                               required=""
                                                               value="<?php echo $stuffdata['M_name_EN'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الأخير بالإنجليزي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Last Name EN" name="Last_Name_EN"
                                                               required=""
                                                               value="<?php echo $stuffdata['L_name_EN'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom02"> الإسم الأول بالعربي </label>
                                                        <input type="text" class="form-control" id="validationCustom02"
                                                               placeholder="First Name AR" name="First_Name_AR"
                                                               required=""
                                                               value="<?php echo $stuffdata['F_name_AR'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الإسم الاوسط بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Middle Name AR" name="Middle_Name_AR"
                                                               required=""
                                                               value="<?php echo $stuffdata['M_name_AR'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="validationCustom01">الاسم الاخير بالعربي</label>
                                                        <input type="text" class="form-control" id="validationCustom01"
                                                               placeholder="Last Name AR" name="Last_Name_AR"
                                                               required=""
                                                               value="<?php echo $stuffdata['L_name_AR'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
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
                                                        <label> تاريخ الميلاد </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   data-provide="datepicker" data-date-autoclose="true"
                                                                   data-date-format="dd-m-yyyy" name="DOP"
                                                                   value="<?php echo $stuffdata['DOP'] ?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                            class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>رقم الهاتف</label>
                                                        <div class="input-group">
                                                            <input type="tel" class="form-control" required
                                                                   placeholder="Phone" name="Phone"
                                                                   value="<?php echo $stuffdata['Phone'] ?>">
                                                        </div>
                                                        <!-- input-group -->
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>الجنس</label>
                                                    <select class="custom-select" name="Gender">
                                                        <option value="M" <?php echo $stuffdata['Gender'] == 'M' ? "selected" : "" ?>>
                                                            ذكر
                                                        </option>
                                                        <option value="F" <?php echo $stuffdata['Gender'] == 'F' ? "selected" : "" ?>>
                                                            أنثى
                                                        </option>
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
                                                        <label>الرقم الوطني</label>
                                                        <input type="text" class="form-control" id="validationCustom02"
                                                               value="<?php echo $stuffdata['National_Id'] ?>"
                                                               placeholder="Sorry You Can't Change The National Id  ): "
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Sorry You Can't Change The National Id "
                                                               readonly>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="margin-bottom: 11px;">
                                                    <div class="form-group">

                                                        <label>الجنسية</label>
                                                        <?php $contriesarray = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array(); ?>
                                                        <select class="custom-select" name="Nationality">
                                                            <?php foreach ($contriesarray as $contries) { ?>
                                                                <option value="<?php echo $contries['name']; ?>" <?php echo $stuffdata['Nationality'] == $contries['name'] ? "selected" : "" ?>
                                                                        class="option">
                                                                    <?php echo $contries['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الرقم الوطني لولي أمر الطالب - الأول </label>
                                                        <input type="text" class="form-control editable"
                                                               name="parent_nid" id="validationCustom02"
                                                               value="<?= $stuffdata['Parent_NID'] ?>"
                                                               data-old-value="<?= $stuffdata['Parent_NID'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الرقم الوطني لولي أمر الطالب - الثاني </label>
                                                        <input type="text" class="form-control editable"
                                                               name="parent_nid_2" id="validationCustom02"
                                                               value="<?= $stuffdata['Parent_NID_2'] ?>"
                                                               data-old-value="<?= $stuffdata['Parent_NID_2'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="old_parentid_2"
                                                       value="<?= $stuffdata['Parent_NID_2'] ?>">
                                                <div class="col-md-4" style="margin-bottom: 11px;">
                                                    <div class="form-group">
                                                        <label> الإيميل </label>
                                                        <input type="email" class="form-control" id="validationCustom02"
                                                               placeholder="Email" name="Email" required=""
                                                               value="<?php echo $stuffdata['Email'] ?>">
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 text-center pt-2">
                                                    <label> الصف </label>
                                                    <div class="form-group">
                                                        <select name="Classes" class="form-control"
                                                                id="SelectFromClass">
                                                            <?php $ClassesList = $this->db->query("SELECT * FROM `r_levels`")->result_array(); ?>
                                                            <?php $classes = $this->schoolHelper->school_classes($sessiondata['admin_id']);
                                                            if (!empty($classes)) { ?>
                                                                <option value="">أختيار الصف</option>
                                                                <?php foreach ($classes as $class) { ?>
                                                                    <option value="<?= $class['Id'] ?>" <?= $class['Id'] == $stuffdata['Class'] ? "selected" : "" ?>
                                                                            student-id="<?= $stuffdata['Id'] ?>"
                                                                            c-id="<?= $class['Id'] ?>"><?= $class['Class']; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label> أختيار الشعبة (<?php echo $stuffdata['Grades']; ?>)</label>
                                                    <select name="Grades" class="form-control SelectGrade" searchable>
                                                        <option value="GRADE-A-1">GRADE A (1)</option>
                                                        <option value="GRADE-B-1">GRADE B (1)</option>
                                                        <option value="GRADE-C-2">GRADE C (2)</option>
                                                        <option value="GRADE-D-3">GRADE D (3)</option>
                                                        <option value="GRADE-E-4">GRADE E (4)</option>
                                                        <option value="GRADE-F-5">GRADE F (5)</option>
                                                        <option value="GRADE-G-6">GRADE G (6)</option>
                                                        <option value="GRADE-H-7">GRADE H (7)</option>
                                                        <option value="GRADE-I-8">GRADE I (8)</option>
                                                        <option value="GRADE-J-9">GRADE J (9)</option>
                                                        <option value="GRADE-K-10">GRADE K (10)</option>
                                                        <option value="GRADE-L-11">GRADE L (11)</option>
                                                        <option value="GRADE-M-12">GRADE M (12)</option>
                                                        <option value="GRADE-N-13">GRADE N (13)</option>
                                                        <option value="GRADE-O-14">GRADE O (14)</option>
                                                        <option value="GRADE-P-15">GRADE P (15)</option>
                                                        <option value="GRADE-Q-16">GRADE Q (16)</option>
                                                        <option value="GRADE-R-17">GRADE R (17)</option>
                                                        <option value="GRADE-S-18">GRADE S (18)</option>
                                                        <option value="GRADE-T-19">GRADE T (19)</option>
                                                        <option value="GRADE-U-20">GRADE U (20)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" name="old_NID"
                                                   value="<?php echo $stuffdata['National_Id']; ?>">
                                            <input type="hidden" name="ID" value="<?php echo $stuffdata['Id']; ?>">
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            <a href="<?= base_url() ?>/AR/schools/listOfStudents" class="btn btn-blue">العودة</a>
                        </div>
                        </form>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="<?php echo base_url(); ?>assets/js/pages/form-wizard.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
<script>
    var thisgrade = "<?= $stuffdata['Grades']; ?>";
    if (thisgrade.length > 0) {
        $('option[value="' + thisgrade + '"]').attr("selected", "selected")
    }
    // ajax sending
    $("#UpdateStudentData").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/schools/UpdateStudentData',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#Toast').html(data);
                $('#staffsub').removeAttr('disabled');
                $('#staffsub').html('Submit !');
            },
            beforeSend: function () {
                $('#staffsub').attr('disabled', '');
                $('#staffsub').html('Please wait.');
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    $('#back').click(function () {
        location.href = "<?php echo base_url() . "AR/schools "; ?>";
    });

    // Cancel *

    $('#back').click(function () {
        location.href = "<?php echo base_url() . "AR/schools "; ?>";
    });

    function back() {
        location.href = "<?php echo base_url() . "AR/schools "; ?>";
    }

    $("input[name='Min'],input[name='Max']").TouchSpin({
        verticalbuttons: true
    }); //Bootstrap-MaxLength


    $(document).ready(function () {

        $("#UnitType").change(function () {
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

        $('#Prefix').change(function () {
            prex = $(this).children("option:selected").val();
        });

        $('input[name="First_Name_AR"], input[name="Last_Name_AR"]').on("keyup keypress blur", function () {
            var firstname = $('input[name="First_Name_AR"]').val();
            var lastname = $('input[name="Last_Name_AR"]').val();
            var all = prex + " " + firstname + " " + lastname;
            $('#generatedName').html(all);
        });

    });

    $("#classes").ionRangeSlider({
        skin: "round",
        type: "double",
        grid: true,
        min: 0,
        max: 12,
        from: 0,
        to: 12,
        values: ['KG1', 'KG2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
    });
</script>

</body>

</html>