<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
</head>
<style>
    .national-error {
        border: 1px solid red;
    }
</style>
<body>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                    <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                            <span id="Toast">الرجاء إكمال المعلومات</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                    </div>

                        <form class="needs-validation InputForm col-md-12" novalidate style="margin-bottom: 27px;" id="Addpatient">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2" style="margin-bottom: 11px;">
                                            <label>نوع المستخدم</label>
                                            <select class="custom-select" id="Prefix" name="Prefix">
                                                <?php $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array(); ?>
                                                <?php foreach ($tbl_prefix as $pref) : ?>
                                                    <option value="<?php echo $pref['UserType']; ?>">
                                                        <?php echo $pref['AR_UserType']; ?>
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
                                                <label for="validationCustom02"> الإسم الأول بالإنجليزي </label>
                                                <input type="text" class="form-control" id="validationCustom02" 
                                                placeholder="الإسم الأول بالإنجليزي" name="First_Name_EN" required value="<?php echo $user_data[0]['full_name']; ?>"> 
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="validationCustom01">الإسم الأوسط بالإنجليزي</label>
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="الإسم الأوسط بالإنجليزي" name="Middle_Name_EN" required>
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="validationCustom01">الإسم الأخير بالإنجليزي</label>
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="الإسم الأخير بالإنجليزي" name="Last_Name_EN" required>
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="validationCustom02">الإسم الأول بالعربي </label>
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="الإسم الأول بالعربي" name="First_Name_AR" required>
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="validationCustom01">الإسم الأوسط بالعربي</label>
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="الإسم الأوسط بالعربي" name="Middle_Name_AR" required>
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="validationCustom01">الإسم الأخير بالعربي</label>
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="الإسم الأخير بالعربي" name="Last_Name_AR" required>
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
                                                <label> تاريخ الميلاد</label>
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $dop; ?>" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd-m-yyyy" name="DOP">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>رقم الهاتف</label>
                                                <div class="input-group">
                                                    <input type="tel" class="form-control" required placeholder="phone number" name="Phone" value="<?php echo $user_data[0]['phone'] ?>" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>الجنس</label>
                                            <select class="custom-select" name="Gender">
                                                <option value="1">ذكر</option>
                                                <option value="0">أنثى</option>
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
                                                <label>الرقم الوطني </label>
                                                <input type="text" class="form-control" id="national_id"
                                                placeholder="الرقم الوطني" name="N_Id" required value="<?php echo $user_data[0]['National_Id']; ?>" readonly>
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-bottom: 11px;">
                                            <div class="form-group">
                                                <label>الجنسية</label>
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
                                                <label> الوظيفة </label>
                                                <select name="Position" class="custom-select">
                                                    <?php foreach ($positions as $position) { ?>
                                                        <option value="<?php echo $position['Position'] ?>" class="option">
                                                            <?php echo $position['AR_Position'] ?>
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
                                                <label> الإيميل </label>
                                                <input type="email" class="form-control" id="validationCustom02" placeholder="الإيميل" name="Email" required>
                                                <div class="valid-feedback">
                                                    looks good
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <input type="hidden" value="<?php echo $user_data[0]['watch_mac']; ?>" name="machene">
                    <div class="mt-1 col-lg-12">
                        <button class="btn btn-primary" type="Submit" id="Teachersub">إضافة</button>
                        <button type="button" class="btn btn-light" id="back">إلغاء</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
</body>
<script>
var prex  = "";
$( '#Prefix' ).change( function () {
    prex = $( this ).children( "option:selected" ).val();
} );

$( 'input[name="First_Name_EN"], input[name="Last_Name_EN"]' ).on( "keyup keypress blur", function () {
    var firstname = $( 'input[name="First_Name_EN"]' ).val();
    var lastname = $( 'input[name="Last_Name_EN"]' ).val();
    var all = prex + " " + firstname + " " + lastname;
    $( '#generatedName' ).html( all );
} );


$( "#Addpatient" ).on( 'submit', function ( e ) {
    e.preventDefault();
    $.ajax( {
        type: 'POST',
        url: '<?php echo base_url(); ?>AR/Company_Departments/startAddpatient?type=visitor&v_id=<?php echo $user_data[0]['user_id']; ?>' ,
        data: new FormData( this ),
        contentType: false,
        cache: false,
        processData: false,
        success: function ( data ) {
                const all = document.body;
                all.scrollTop = 0;
                $( '#Toast' ).html( data );
                $( '#Teachersub' ).removeAttr('disabled');
                $( '#Teachersub' ).html('add');
        },
        beforeSend : function(){
                $( '#Teachersub' ).attr('disabled','');
                $( '#Teachersub' ).html('إنتظر من فضلك...');
        },
        ajaxError: function () {
                $( '.alert.alert-info' ).css( 'background-color', '#DB0404' );
                $( '.alert.alert-info' ).html( "Ooops! Error was found." );
        }
    } );
} );

</script>
</html>