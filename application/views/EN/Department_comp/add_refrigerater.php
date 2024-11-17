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
                            <h3 class="card-title">Add Refrigerator</h3>
                            <div class="alert alert-border alert-border-secondary alert-dismissible fade show" role="alert">
                                    <span id="Toast">Please enter the information</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                            </div>
                            <hr>
                            <form class="needs-validation InputForm col-md-12" novalidate style="margin-bottom: 27px;" id="Addmachine">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Add Refrigerator</h3>
                                                <p class="card-text">To Add Refrigerator:<br>
                                                    1- Add Specific Area <br>
                                                    2- Add the Refrigerator’s MAC Address Notes: List Areas Added Before
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="billing-name">MAC Address</label>
                                                    <input type="text" class="form-control" placeholder="Mac Adress" name="name" value="<?php echo $refrigerater_data[0]['mac_adress'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="billing-name">Type</label>
                                                    <select name="type" class="form-control">
                                                        <?php foreach ($types as $type) { ?>
                                                                <option value="<?php echo $type['Id'] ?>" <?php echo $type['Id'] == $refrigerater_data[0]['type'] ? 'selected' : "" ?>>
                                                                    <?php echo $type['device_name'] . "  (" . $type['min_temp'] . "," . $type['max_temp'] . ")" ?>
                                                                </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="control-label">Choose the site</label>
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
                                                    <label for="billing-name"> Description </label>
                                                    <input type="text" class="form-control" placeholder="Description" name="description" value="<?php echo $refrigerater_data[0]['Description']; ?>" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary" id="StudentSub" type="Submit">Add</button>
                                            <button type="button" class="btn btn-light" id="back">Cancel</button>
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
        url: '<?php echo base_url(); ?>EN/Company_Departments/startAddMachine?type=visitor&v_id=<?php echo $refrigerater_data[0]['Id']; ?>',
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