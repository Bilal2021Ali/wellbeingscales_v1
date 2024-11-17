<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php 
$types = $this->db->query("SELECT * FROM  `refrigerator_levels`")->result_array(); 
$list = $this->db->query("SELECT * FROM `r_sites`")->result_array();
?>
<body>

    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                    <span id="Toast">أدخل المعلومات أسفله</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                            </div>
                            <hr>
                            <form class="needs-validation InputForm col-md-12" novalidate style="margin-bottom: 27px;" id="Addmachine">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>أضف جهاز</h3>
                                                <p class="card-text">لإضافة جهاز: <br>
                                                    1- أضف منطقة لتحديدها <br>
                                                    2-  أضف عنوان Mac للجهاز<br>
                                                    ملاحظة: قائمة المنطقة المضافة من قبل
                                                    عنوان Mac                                               
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="billing-name">عنوان Mac</label>
                                                    <input type="text" class="form-control" placeholder="عنوان Mac" name="name" value="<?php echo $refrigerater_data[0]['mac_adress'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="billing-name">النوع</label>
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
                                                    <label class="control-label">إختر الموقع</label>
                                                    <select class="form-control" name="Site">
                                                        <?php foreach ($list as $site) { ?>
                                                            <option value="<?php echo $site['Id'];  ?>">
                                                                <?php echo $site['Site_Code'] . ' - ' . $site['Site_Name']; ?>
                                                            </option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="billing-name"> الوصف </label>
                                                    <input type="text" class="form-control" placeholder="الوصف" name="description" value="<?php echo $refrigerater_data[0]['Description']; ?>" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary" id="StudentSub" type="Submit">أضف</button>
                                            <button type="button" class="btn btn-light" id="back">إلغاء</button>
                                        </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<script>
$("#Addmachine").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>AR/Company_Departments/startAddMachine?type=visitor&v_id=<?php echo $refrigerater_data[0]['Id']; ?>',
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
</script>
</html>