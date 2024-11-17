<!doctype html>
<html lang="en">


<body class="light menu_light logo-white theme-white" cz-shortcut-listen="true">
    <div class="mapouter" style="display: block;z-index: 0;position: absolute;">
        <div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=qatar&t=&z=7&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
        <style>
            .mapouter {
                position: relative;
                text-align: right;
                height: 100%;
                width: 100%;
            }

            .gmap_canvas {
                overflow: hidden;
                background: none !important;
                height: 100%;
                width: 100%;
            }

            .account-pages {
                padding-top: 50px;
            }

            .mt-5,
            .my-5 {
                margin-top: 0px !important;
            }

            .outer {
                position: absolute;
                top: 0px;
                left: 0px;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.55);
            }
        </style>
    </div>
    <div class="outer"></div>

    <body class="authentication-bg">

        <div class="account-pages">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" width="100%" class="logo logo-dark">

                                    <div class="alert alert-primary fade show" id="statusbox" role="alert">
                                        تسجيل الدخول
                                    </div>

                                    <h5 class="text-primary">مرحبا بك</h5>
                                    <p class="text-muted"> الرجاء إدخال المعلومات التالية لتسجيل الدخول </p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="" id="loginform">

                                        <div class="form-group">
                                            <label for="username">إسم المستخدم</label>
                                            <input type="text" class="form-control" id="username" placeholder="إسم المستخدم" name="username">
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">كلمة السر</label>
                                            <input type="password" class="form-control" id="userpassword" placeholder="كلمة المرور" name="password">
                                        </div>

                                        <div class="mt-3 text-right">
                                            <div class="float-left">
                                                <a href="auth-recoverpw" class="text-muted"> نسيت كلمة المرور ؟ </a>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-2" type="Submit">تسجيل الدخول</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <p>© 2022 V2.0 Track Qlickhealth</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    </body>
    <script src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.min.js"></script>
    <script>
        $("#loginform").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/users/startlogin',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('button').attr('disabled', 'disabled');
                    $('button').html('الرجاء الإنتظار');
                    $('#statusbox').css('display', 'block');
                    $('#statusbox').html('<p style="width: 100%;margin: 0px;"> !! الرجاء الإنتظار </p>');
                },
                success: function(data) {
                    $('button').removeAttr('disabled', 'disabled');
                    $('button').html(' تسجيل الدخول');
                    $('#statusbox').html(data);

                },
                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });
    </script>

</html>