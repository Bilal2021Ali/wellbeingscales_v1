<!doctype html>
<html>

<head>
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
</head>
<?php
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
function generate_string($input, $strength = 16)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}
$rand = rand(300, 999);
//$code =  substr(md5(time()), 0, 4).'-'.$rand;     
$code =  generate_string($permitted_chars, 5) . '-' . $rand;
?>

<body>
    <div class="main-content">
        <div class="page-content">
            <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 005: Add Administrative Position User Type for Department</h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" class="needs-validation InputForm col-md-12" novalidate="">
                            <form id="addPosition">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>English Position</label>
                                                <input type="text" class="form-control" placeholder="Please Enter The UserType..." name="UserType" required="">
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Arabic Position</label>
                                                <input type="text" class="form-control" placeholder="Please Enter The UserType AR..." name="UserType_ar" required="">
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Automated Code</label>
                                                <input type="text" class="form-control" placeholder="You Can't Change this Code ): " name="Code" value="<?php echo $code; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="This Code is for System Use" readonly>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
                                        <button type="button" class="btn btn-light" id="back">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="StatusBox"></div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $("#addPosition").on('submit', function(e) {
        var userposition = $('input[name="UserType"]').val();
        console.log(userposition);
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/startAddNewPosition_gm',
            data: {
                userposition: userposition,
                code: '<?php echo $code; ?>',
                UserType_ar: $('input[name="UserType_ar"]').val(),
            },
            success: function(data) {
                $('#StatusBox').html(data);
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });
</script>

</html>