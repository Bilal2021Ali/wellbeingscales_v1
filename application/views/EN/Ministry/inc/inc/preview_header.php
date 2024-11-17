<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="QlickSystems" name="QlickSystems Helthy Care" />
    <meta content="Themesbrand" name="author" />
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/fav_icon.png">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Plugins Core Css -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <style>
        .app-search span {
            top: 0px;
        }

        .badge {
            border-radius: 14px;
        }

        .InfosCards h4,
        .InfosCards p {
            color: #fff;
        }

        .InfosCards .card-body {
            border-radius: 5px;
        }

        .card {
            border: 1px solid #0eacd8;
        }

        .menu-title {
            font-size: 20px;
        }

        .notStatic {
            border: 0px;
        }


        .sidebar li img {
            width: 28px;
        }

        .sidebar li span {
            font-size: 17px;
            margin-left: 13px;
        }

        .metismenu li {
            display: block;
            width: 100%;
            margin: 2px auto;
        }

        .InfosCards p.mb-0:not(.mt-3) {
            font-weight: bolder;
        }

        .table th {
            font-size: 15px;
        }


        .ar_change {
            font-family: 'Almarai', sans-serif;
        }


        #sidebar-menu ul li a {
            display: block;
            padding: .6rem 1.1rem;
            color: #55affe;
            position: relative;
            font-size: 15px;
            font-weight: 500;
            -webkit-transition: all .4s;
            transition: all .4s;
            margin: 0 10px;
            border-radius: 3px;
        }

        *:not(input) {
            text-transform: capitalize;
        }

        .start_sync {
            background: #fff;
            padding: 10px;
            border-radius: 100%;
            box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        }
    </style>
    <style>
        .feedback_btn {
            position: fixed;
            bottom: 10px;
            right: 10px;
            border: 0px;
            width: 50px;
            height: 50px;
            background: #fff;
            border-radius: 100%;
            z-index: 1000;
            -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
            box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        }

        #feedback .loader {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #fff;
            top: 0px;
            left: 0px;
            z-index: 100;
        }


        .icon__ {
            display: inline-block;
            width: 23px;
            margin: 10px;
        }
    </style>
    <?php
    $sidebar = "";
    if (isset($sessiondata) && $sessiondata['level'] == 0) {
        $sidebar = "dark";
    }

    $dashlink = "";
    if (isset($sessiondata)) {
        if ($sessiondata['type'] == 'Ministry' || $sessiondata['type'] == 'Company') {
            $dashlink = base_url() . "EN/DashboardSystem";
        } else if ($sessiondata['type'] == 'Patient') {
            $dashlink = base_url() . "EN/Departments_Permition";
        } else if ($sessiondata['type'] == 'Satff' || $sessiondata['type'] == 'Teacher') {
            $dashlink = base_url() . "EN/School_Permition";
        } else {
            $dashlink = base_url();
        }
    }

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https:/" : "http:/";
    $CurPageURL = $protocol . "/" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    ?>



    <?php

    if (!isset($hasntnav)) {
        $userlevel = $sessiondata['level'];
        $usertype = $sessiondata['type'];
        if ($userlevel == 0) {
            $profile_url = base_url() . "assets/images/lo1.png";
            $user_title = " Super Admin ";
        } elseif (!empty($sessiondata['Logo'])) {
            $profile_url = $sessiondata['Logo'];
            $user_title = " Admin ";
        } else {
            $profile_url = base_url() . "assets/images/default-avatar.png";
            $user_title = " Admin ";
        }
    }


    ?>


</head>
<script>
    var isCtrl = false;
    document.onkeyup = function(e) {
        if (e.keyCode == 17) isCtrl = false;
    }

    document.onkeydown = function(e) {
        if (e.keyCode == 17) isCtrl = true;
        if (e.keyCode == 83 && isCtrl == true) {
            //run code for CTRL+S -- ie, save!
            alert('Test');
            return false;
        }
    }
</script>
<!-- FeedBack section  ---->
<section data-toggle="modal" data-target="#feedback">
    <button class="feedback_btn" type="button" data-toggle="tooltip" data-placement="left" title="Send feed back for this page">
        <i class="uil uil-bug"></i>
    </button>
</section>


<body data-sidebar="<?php echo $sidebar; ?>">
    <?php if (!isset($hasntnav)) {  ?>
        <link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/prebid-ads.js"></script>
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?php echo $CurPageURL  ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?php echo base_url(); ?>assets/images/fav_icon.png" style="margin-top: 23px;" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url(); ?>assets/images/fav_icon.png" style="margin-top: 23px;" alt="" style="margin-left: -19px;" height="70">
                            </span>
                        </a>

                        <a href="<?php echo $CurPageURL  ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?php echo base_url(); ?>assets/images/fav_icon.png" style="margin-top: 23px;" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url(); ?>assets/images/fav_icon.png" style="margin-top: 23px;" alt="" style="margin-left: -19px;" height="70">
                            </span>
                        </a>
                    </div>
                    <!-- App Search-->

                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ml-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-search"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="Submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="dropdown d-none d-lg-inline-block ml-1">
                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn" style="position: relative;display: inline;">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <script>
                            const base_url = "<?php echo base_url();  ?>";
                        </script>
                        <style>
                            .weatherwidget-io {
                                position: static !important;
                            }

                            .Mic_On {
                                /* Chrome, Safari*/
                                -webkit-animation-name: ease-in-outAnimation;
                                -webkit-animation-duration: 0.7s;
                                -webkit-animation-timing-function: ease-in-out;
                                -webkit-animation-iteration-count: infinite;
                                -webkit-animation-direction: alternate;
                                -webkit-animation-play-state: running;
                                /* Mozilla */
                                -moz-animation-name: ease-in-outAnimation;
                                -moz-animation-duration: 0.7s;
                                -moz-animation-timing-function: ease-in-out;
                                -moz-animation-iteration-count: infinite;
                                -moz-animation-direction: alternate;
                                -moz-animation-play-state: running;
                                /* Standard syntax */
                                animation-name: ease-in-outAnimation;
                                animation-duration: 0.7s;
                                animation-timing-function: ease-in-out;
                                animation-iteration-count: infinite;
                                animation-direction: alternate;
                                animation-play-state: running;

                            }

                            /* Chrome, Safari */
                            @-webkit-keyframes ease-in-outAnimation {
                                0% {
                                    transform: scale(0.8);
                                }

                                100% {
                                    transform: scale(1.05);
                                }
                            }

                            /* Firefox */
                            @-moz-keyframes ease-in-outAnimation {
                                0% {
                                    transform: scale(0.8);
                                }

                                100% {
                                    transform: scale(1.05);
                                }
                            }

                            /* Standard syntax */
                            @keyframes ease-in-outAnimation {
                                0% {
                                    transform: scale(0.8);
                                }

                                100% {
                                    transform: scale(1.05);
                                }
                            }
                        </style>
                        <?php
                        $ar_link = str_replace('EN', 'AR', $CurPageURL);
                        if (isset($sessiondata) && $sessiondata['level'] !== 0) {
                        ?>
                            <a href="<?php echo $ar_link; ?>" class="ar_change">
                                <button type="button" class="btn header-item noti-icon waves-effect">
                                    <span class="link">عربي</span>
                                </button>
                            </a>
                        <?php  }  ?>
                    </div>



                    <div class="dropdown d-none d-lg-inline-block ml-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="uil-minus-path"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-bell"></i>
                            <span class="badge badge-danger badge-pill" id="nots"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notification </h5>
                                    </div>
                                    <div class="col-auto">
                                        <span class="small set_readed" style="cursor: pointer;"> mark as read </span>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar="init" style="max-height: 230px;">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <a href="" class="text-reset notification-item" id="notslist">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <?php $avatarlist = $this->db->query("SELECT * FROM 
                            `l2_avatars` WHERE For_User = '" . $sessiondata['admin_id'] . "' 
                            AND Type_Of_User = '" . $sessiondata["type"] . "' LIMIT 1 ")->result_array();
                            if (!empty($avatarlist)) {
                                foreach ($avatarlist as $avatar) {   ?>
                                    <img class="rounded-circle header-profile-user" src="<?php echo base_url() . "uploads/avatars/" . $avatar['Link']; ?>" alt="Header Avatar" id="profile_image">
                                <?php }
                            } else {   ?>
                                <img class="rounded-circle header-profile-user" src="<?php echo base_url() . "uploads/avatars/default_avatar.jpg"; ?>" alt="Header Avatar" id="profile_image">
                            <?php }  ?>
                            <span class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15">
                                <?php echo $sessiondata['username']; ?>
                            </span>
                            </span>
                            <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a class="dropdown-item" href="<?php echo base_url() . "EN/Users/MyProfile" ?>"><i class="uil uil-user-circle font-size-18 align-middle text-muted mr-1"></i> <span class="align-middle"> user profile </span></a>
                            <a class="dropdown-item" href="#"><i class="uil uil-sign-out-alt font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle logout"> sign out </span></a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect logout">
                            <i class="uil-sign-out-alt logout"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>
        <div class="vertical-menu mm-active">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php    ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo base_url(); ?>assets/images/fav_icon.png" alt="" height="42" style="margin-left: -10px;">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" style="margin-left: -19px;" height="70">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo base_url(); ?>assets/images/fav_icon.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" style="margin-left: -19px;" height="70">
                    </span>
                </a>
            </div>

            <div data-simplebar="init" class="sidebar-menu-scroll mm-show sidebar">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                <div class="simplebar-content" style="padding: 0px;">

                                    <!--- Sidemenu -->
                                    <div id="sidebar-menu" class="mm-active">
                                        <!-- Left Menu Start -->
                                        <style>
                                            .jusprev {
                                                position: absolute;
                                                text-align: center;
                                                top: 0px;
                                                width: 100%;
                                                height: 100%;
                                                display: grid;
                                                align-items: center;
                                                opacity: 0;
                                                transition: 0.2s all;
                                                z-index: 10000;
                                                padding: 10px;
                                            }

                                            .jusprev i {
                                                font-size: 100px;
                                            }

                                            .jusprev:hover {
                                                transition: 0.2s all;
                                                opacity: 1;
                                            }


                                            .blured {
                                                transition: 0.2s all;
                                                filter: blur(5px);
                                                -webkit-filter: blur(8px);
                                            }
                                        </style>
                                        <ul class="metismenu list-unstyled mm-show" id="side-menu" style="margin-top: 20px;">
                                            <div class="jusprev">
                                                <div class="con">
                                                    <i class="uil uil-info-circle"></i>
                                                    <h5>Sorry</h5>
                                                    <p>You cannot use these links. This is just a preview.</p>
                                                </div>
                                            </div>
                                            <div class="list w-100 h-100">
                                            <li>
                                                <a>
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/dashboard.png" width="19px"></i>
                                                    <span>Dashboard</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a >
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/student_card.png" width="19px"></i>
                                                    <span>My Profile</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/waiting.png" width="19px"></i>
                                                    <span>Home</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/team.png" width="19px"></i>
                                                    <span>About us</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/device.png" width="19px"></i>
                                                    <span>Videos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/menu.png" width="19px"></i>
                                                    <span>Surveys</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    <i class=""><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/menu.png" width="19px"></i>
                                                    <span>Survey History</span>
                                                </a>
                                            </li>
                                            </div>

                                        </ul>
                                        <script>
                                            $('.jusprev').hover(function(){
                                                $('.list').toggleClass('blured');
                                            });
                                            $('.jusprev').mouseleave(function(){
                                                $('.list').removeClass('blured');
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: auto; height: 956px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 112px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                    <div class="simplebar-scrollbar" style="height: 164px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                </div>
            </div>
        </div>
        <script>
            setInterval(function() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Notifs/notification',
                    success: function(data) {
                        $('#nots').html(data);
                    },
                });
            }, 10000);

            $('#page-header-notifications-dropdown').click(function() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Notifs/notificationList',
                    success: function(data) {
                        $('#notslist').html(data);
                    },
                });
            });

            $(".set_readed").click(function() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Notifs/SetReaded',
                });
                $('#notslist').html("empty !!");
            });

            /*function playSound(url) {
             document.getElementById("notifsound").play();
             //audio.play();
            }   
            */
            /*function ipLookUp () {
              $.ajax('http://ip-api.com/json')
              .then(
                  function success(response) {
                      console.log('User\'s Location Data is ', response);
                      console.log('User\'s Country', response.country);
                  },

                  function fail(data, status) {
                      console.log('Request failed.  Returned status of', status);
                  }
              );
            }
            ipLookUp();*/

            var rgb = getAverageRGB(document.getElementById('profile_image'));
            ///document.body.style.backgroundColor = ;
            //$('#page-topbar').css('background','rgb('+rgb.r+','+rgb.g+','+rgb.b+')')
            //$('.vertical-menu').css('background','rgb('+rgb.r+','+rgb.g+','+rgb.b+')')
            function getAverageRGB(imgEl) {

                var blockSize = 5, // only visit every 5 pixels
                    defaultRGB = {
                        r: 0,
                        g: 0,
                        b: 0
                    }, // for non-supporting envs
                    canvas = document.createElement('canvas'),
                    context = canvas.getContext && canvas.getContext('2d'),
                    data, width, height,
                    i = -4,
                    length,
                    rgb = {
                        r: 0,
                        g: 0,
                        b: 0
                    },
                    count = 0;

                if (!context) {
                    return defaultRGB;
                }

                height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
                width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

                context.drawImage(imgEl, 0, 0);

                try {
                    data = context.getImageData(0, 0, width, height);
                } catch (e) {
                    alert(e);
                    /* security error, img on diff domain */
                    alert('x');
                    return defaultRGB;
                }

                length = data.data.length;

                while ((i += blockSize * 4) < length) {
                    ++count;
                    rgb.r += data.data[i];
                    rgb.g += data.data[i + 1];
                    rgb.b += data.data[i + 2];
                }

                // ~~ used to floor values
                rgb.r = ~~(rgb.r / count);
                rgb.g = ~~(rgb.g / count);
                rgb.b = ~~(rgb.b / count);

                return rgb;

            }
        </script>
    <?php } ?>

    <script src="<?php echo base_url() ?>assets/js/html2canvas.js"></script>
    <div id="feedback" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="feedbackLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="feedbackLabel">send feedback about this page</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="loader" style="display: none;">
                        <div class="spinner-border text-primary m-1" role="status" style="margin: auto !important;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <h5 class="font-size-16">Enter you feed back please</h5>
                    <form id="feedBack_Form">
                        <textarea placeholder="any description for the problem , like the actions you take " class="form-control" rows="5" id="feedback_desc" required="" minlength="5"></textarea>
                        <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-1">
                            submit the feedback
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <script>
        var ScreenShoot = "";
        $('.feedback_btn').click(function() {
            html2canvas($(".main-content")[0], {
                dpi: 192,
            }).then(function(canvas) {
                ScreenShoot = canvas.toDataURL("image/png");
            });

        });

        $("#feedBack_Form").on('submit', function(e) {
            e.preventDefault();
            if ($('#feedback_desc').val().length > 3) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Ajax/FeedBack',
                    data: {
                        img_txt: ScreenShoot,
                        url: window.location.href,
                        feedback_desc: $('#feedback_desc').val(),
                        <?php if (isset($sessiondata)) {  ?>
                            sessiondata: `<?php echo json_encode($sessiondata);  ?>`,
                        <?php  } else {  ?>
                            sessiondata: 'users page',
                        <?php  }  ?>
                    },
                    beforeSend: function() {
                        $('#feedback .loader').css("display", "grid");
                        $('#feedback .loader').css("opacity", "1");
                    },
                    success: function() {
                        $('#feedback .loader').css("display", "none");
                        $('#feedback .loader').css("opacity", "0");
                        setTimeout(function() {
                            $('#feedback').modal('hide');
                        }, 500);
                    }
                });
            } else {
                $('#feedback_desc').addClass('');
            }
        });
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
    <?php

    function dateDifference($start_date, $end_date)
    {
        // calulating the difference in timestamps 
        $diff = strtotime($start_date) - strtotime($end_date);

        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds
        return ceil(abs($diff / 86400));
    }

    ?>
    <script>
        $('.logout').click(function() {
            location.href = '<?php echo base_url() . "EN/Users/logout"; ?>';
        });
    </script>