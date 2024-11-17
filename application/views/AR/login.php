<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Choose Country Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('<?= base_url("assets/images/bg-01.jpg"); ?>') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Almarai', sans-serif;
        }

        .container {
            /* إزالة خاصية التوسيط العمودي */
            margin-top: 20px;
            /* إضافة مسافة من الأعلى (اختياري) */
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
        }

        .card {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 10px;

            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-body img {
            width: auto;
            height: auto;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .card-body img:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #fff;
            font-size: 1rem;
        }

        .footer-links {
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-control {
            padding: 15px;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        @media (max-width: 767px) {
            .card {
                width: 90%;
            }

            .card-body {
                padding: 20px;
            }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            /* إضافة بعض المسافة من الأسفل */
        }

        .logo {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="logo-container">
                                <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
                            </div>
                            <div class="text-center mt-2">
                                <div class="alert alert-primary alert-dismissible fade show" id="statusbox" role="alert">
                                    Welcome to Wellbeing Scales
                                </div>
                            </div>
                            <div class="p-2 mt-4">
                                <form id="loginform">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Password" name="password" required>
                                    </div>
                                    <div class="mt-3 text-right">
                                        <button class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-2" type="submit">Login</button>
                                        <div class="float-left">
                                            <a href="<?= base_url('EN/Users/ForgetPassword'); ?>" class="text-muted">
                                                <p class="text-muted"><span style="color: #0eacd8; font-weight: bold;">Forgot Password?</span></p>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <hr>
                            <p>Copyright © <span id="currentYear"></span> Wellbeing Scales. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#loginform").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('index.php/EN/Users/startlogin'); ?>',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#statusbox').css('display', 'block');
                    $('#statusbox').html('<p style="width: 100%;margin: 0px;"> please wait !!</p>');
                },
                success: function(data) {
                    $('#statusbox').html(data);
                },
                error: function() {
                    $('#statusbox').html('<p style="color: red;">Ooops! Error was found.</p>');
                }
            });
        });
        // Set current year for the footer copyright
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>

</html>