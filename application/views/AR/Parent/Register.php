<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <style>
        .footer {
            width: 100%;
            left : 0px !important;
        }
    </style>
</head>
<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card notstatic">
                        <div class="card-body p-4"> 
                            <div class="text-center mt-2">
                                <h5 class="text-primary">أهلا "<?php echo $sessiondata['username']; ?>" !</h5>
                                <p class="text-muted">يرجى تقديم الأجزاء التالية من المعلومات لاستخدام حسابك.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <div class="alert alert-danger" role="alert" style="display: none;"></div>
                                <form id="Register">
                                    <div class="form-group">
                                        <label for="name_en">الإسم بالإنجليزي</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Name EN" autocomplete="off">
                                    </div>
            
                                    <div class="form-group">
                                        <label for="name_ar">الإسم بالعربي</label>
                                        <input type="text" class="form-control" id="name_ar" name="name_ar" placeholder="Name AR" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="DOP">تاريخ الميلاد</label>
                                        <input type="text" id="DOP" name="DOP" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Date of birth">
                                    </div>

                                    <div class="form-group">
                                        <label for="gender">الجنس</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male">ذكر</option>
                                            <option value="female">أنثى</option>
                                        </select>
                                    </div>
                                    <!-- 2021-02-01 -->
                                    <div class="mt-3 text-right">
                                        <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit">حفظ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo base_url('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script> 
<script>
$("#Register").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/Parents/Register',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            $('.alert').slideUp();
            $('button').attr('disabled','');
            $('button').html("إنتظر من فضلك...");
          },
          success: function (data) {
            if(data !== "ok"){
                $('.alert').slideDown();
                $('.alert').html(data);
                $('button').removeAttr('disabled','');
                $('button').html("إحفظ");
            }else{
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-success');
                $('.alert').html('تم الحفظ ,نشكرك لوقتك');
                location.href = "<?php echo base_url("AR/Parents"); ?>";
            }  
          },
          ajaxError: function(){
               $('.alert').css('background-color','#DB0404');
               $('.alert').html("Ooops! Error was found.");
          }
     });
});
</script>
</body>
</html>