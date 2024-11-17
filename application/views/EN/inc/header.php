<?php

use Menus\MinistryMenus;
use Menus\SchoolMenus;

?>
<!DOCTYPE HTML>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="QlickSystems" name="QlickSystems Helthy Care"/>
    <meta content="Themesbrand" name="author"/>
    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/images/fav_icon.png">
	<title>
		<?= $page_title ?? ""; ?>
	</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Plugins Core Css -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Glegoo:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="<?= base_url(); ?>assets/css/icons.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>
    <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <link href="<?= base_url() ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
          rel="stylesheet" type="text/css"/>
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
            font-size: 11px;
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

        /* * {
                    text-transform: lowercase;
                }
                *::first-letter {
                    text-transform: capitalize;
                }*/
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

        .start_sync {
            background: #fff;
            padding: 10px;
            border-radius: 100%;
            box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        }

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

        .buttons-collection.buttons-colvis {
            text-transform: capitalize !important;
        }

        .right-bar-toggle,
        .show-more-labels {
            cursor: pointer;
        }

        .show-more-labels {
            box-shadow: 0 2px 5px 0 rgba(8, 6, 6, 0.24);
        }

        .dropdown-menu.show {
            transform: translate3d(-40px, 0px, 0px) !important;
        }

        .pointer {
            cursor: pointer;
        }

        #codeigniter_profiler {
            width: 1134px;
            position: fixed;
            bottom: 0;
            right: 0;
            overflow: auto;
            height: 90vh;
        }
    </style>
    <?php
    // get settings
    $settings = $this->db->get('l0_global_settings', 1)->result_array();
    if (empty($settings[0])) {
        ?>
        <h3 class="text-center mt-5">We apologize for any inconvenience, but the website is currently undergoing construction.</h3>
        <?php
        exit();
    }
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
    document.onkeyup = function (e) {
        if (e.keyCode == 17) isCtrl = false;
    }
    document.onkeydown = function (e) {
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
    <button class="feedback_btn" type="button" data-toggle="tooltip" data-placement="left"
            title="Send feed back for this page"><i class="uil uil-bug"></i></button>
</section>

<body language="en" data-sidebar="<?= $sidebar; ?>">
<?php if (!isset($hasntnav)) { ?>
    <link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/prebid-ads.js"></script>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box"> <span class="logo-sm">
                            <button type="button"
                                    class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn"> <i
                                        class="fa fa-fw fa-bars"></i> </button>
                        </span> <a href="<?= $CurPageURL ?>" class="logo logo-dark text-center"> <span class="logo-lg"> <img
                                    src="<?= base_url(); ?>assets/images/fav_icon.png" style="margin-top: 23px;" alt=""
                                    style="margin-left: -19px;" height="70"> </span> </a> <a href="<?= $CurPageURL ?>"
                                                                                             class="logo logo-light text-center">
                        <span class="logo-sm"> <img src="<?= base_url(); ?>assets/images/fav_icon.png"
                                                    style="margin-top: 23px;" alt="" height="22"></span> <span
                                class="logo-lg"> <img src="<?= base_url(); ?>assets/images/fav_icon.png"
                                                      style="margin-top: 23px;" alt="" style="margin-left: -19px;"
                                                      height="70"></span> </a></div>
                <!-- App Search-->
            </div>
            <div class="d-flex">
                <div class="dropdown d-inline-block d-lg-none ml-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="uil-search"></i></button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                           aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="Submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button"
                            class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn"
                            style="position: relative;display: inline;"><i class="fa fa-fw fa-bars"></i></button>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect links-list"
                            style="position: relative;display: inline;"><i class="uil uil-channel"></i></button>
                    <script>
                        const base_url = "<?= base_url();  ?>";
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
                    if (isset($sessiondata) && $sessiondata['type'] !== "super") {
                        ?>
                        <a href="<?= $ar_link; ?>" class="ar_change">
                            <button type="button" class="btn header-item noti-icon waves-effect"><span
                                        class="link">عربي</span></button>
                        </a>
                    <?php } ?>
                </div>
                <?php if ($sessiondata['level'] == 0 && $sessiondata['type'] !== "consultant") { ?>
                    <div class="dropdown d-none d-lg-inline-block ml-1"><a
                                href="<?= base_url('EN/Dashboard/settings') ?>">
                            <button type="button" class="btn header-item noti-icon waves-effect"><i
                                        class="uil-setting"></i></button>
                        </a></div>
                <?php } ?>
                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen"><i
                                class="uil-minus-path"></i></button>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="uil-bell"></i> <span class="badge badge-danger badge-pill"
                                                                                 id="nots"></span></button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-16"> NOTIFICATION </h5>
                                </div>
                                <div class="col-auto"><span class="small set_readed" style="cursor: pointer;"> MARK AS READ </span>
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
                                            <div class="simplebar-content" style="padding: 0px;"><a href=""
                                                                                                    class="text-reset notification-item"
                                                                                                    id="notslist"> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"
                                     style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"
                                     style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        $avatarlist = $this->db->query("SELECT * FROM 
                            `l2_avatars` WHERE For_User = '" . $sessiondata['admin_id'] . "' 
                            AND Type_Of_User = '" . $sessiondata["type"] . "' LIMIT 1 ")->result_array();
                        if (!empty($avatarlist)) {
                            foreach ($avatarlist as $avatar) {
                                ?>
                                <img class="rounded-circle header-profile-user"
                                     src="<?= base_url() . "uploads/avatars/" . $avatar['Link']; ?>" alt="Header Avatar"
                                     id="profile_image">
                                <?php
                            }
                        } else {
                            ?>
                            <img class="rounded-circle header-profile-user"
                                 src="<?= base_url() . "uploads/avatars/default_avatar.jpg"; ?>" alt="Header Avatar"
                                 id="profile_image">
                        <?php } ?>
                        <span class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15">
                                <?= $sessiondata['username']; ?>
                            </span> <i class="uil-angle-down d-none d-xl-inline-block font-size-15"> </i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href="<?= base_url() . "EN/Users/MyProfile" ?>"><i
                                    class="uil uil-user-circle font-size-18 align-middle text-muted mr-1"></i> <span
                                    class="align-middle"> USER PROFILE </span></a>
                        <?php if (in_array($sessiondata['type'], array_keys($this->Helper->TypesReferences()))) { ?>
                            <a class="dropdown-item" href="<?= base_url("EN/Users/timezone") ?>"><i
                                        class="uil uil-clock font-size-18 align-middle text-muted mr-1"></i> <span
                                        class="align-middle"> TIME ZONE </span></a>
                        <?php } ?>
                        <a class="dropdown-item" href="#"><i
                                    class="uil uil-sign-out-alt font-size-18 align-middle mr-1 text-muted"></i> <span
                                    class="align-middle logout"> SIGN OUT </span></a>
                    </div>
                </div>
                <?php $this->load->view("EN/widgets/date-time.php"); ?>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect logout"><i
                                class="uil-sign-out-alt logout"></i></button>
                </div>
            </div>
        </div>
    </header>
    <div class="vertical-menu mm-active">
        <!-- LOGO -->
        <div class="navbar-brand-box"><a href="<?= base_url("" . uri_string()); ?>" class="logo logo-dark text-center">
                <span class="logo-sm"> <img
                            src="<?= base_url("assets/images/settings/logos/") . $settings[0]['logo_url']; ?>" alt=""
                            style="margin-left: -19px;" height="70"> </span> <span class="logo-lg"> <img
                            src="<?= base_url("assets/images/settings/logos/") . $settings[0]['logo_url']; ?>" alt=""
                            style="margin-left: -19px;" height="70"> </span> </a> <a
                    href="<?= base_url("" . uri_string()); ?>" class="logo logo-light text-center"> <span
                        class="logo-sm"> <img
                            src="<?= base_url("assets/images/settings/logos/") . $settings[0]['logo_url']; ?>" alt=""
                            style="margin-left: -19px;" height="70"> </span> <span class="logo-lg"> <img
                            src="<?= base_url("assets/images/settings/logos/") . $settings[0]['logo_url']; ?>" alt=""
                            style="margin-left: -19px;" height="70"> </span> </a></div>
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
                                    <ul class="metismenu list-unstyled mm-show" id="side-menu"
                                        style="margin-top: 20px;">
                                        <?php if ($sessiondata['level'] == 0 && $sessiondata['type'] == "super") { ?>
                                            <li class="menu-title">Welcome Super Admin!</li>
                                            <li class="">
                                                <a href="<?= base_url(); ?>EN/Dashboard">
                                                    <i class="uil-dashboard " style="font-size: 24px;"></i>
                                                    <!-- increase font-size to 24px -->
                                                    <span>Dashboard</span>
                                                </a>
                                            </li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Dashboard/addSystem">
                                                    <i class="uil-plus"></i> <span>Add</span> </a></li>
                                            <?php
                                            $List = $this->db->query('SELECT * FROM l0_organization')->num_rows();
                                            ?>
                                            <li class=""><a href="<?= base_url(); ?>EN/Dashboard/UpdateSystem"> <i
                                                            class="uil-list-ul"></i><span
                                                            class="badge badge-pill badge-primary float-right">
                                                            <?= $List; ?>
                                                        </span> <span>Permissions</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Dashboard/gates">
                                                    <i class="uil-plus"></i> <span> Gates </span> </a></li>

                                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"> <i
                                                            class="uil-user"></i> <span>Climate</span> </a>
                                                <ul class="sub-menu" aria-expanded="true">
                                                    <li class=""><a
                                                                href="<?= base_url(); ?>EN/Dashboard/CreatClimateSurvey">
                                                            <i class="uil-plus"></i> <span> Create Climate</span> </a>
                                                    </li>
                                                    <li class=""><a
                                                                href="<?= base_url(); ?>EN/Dashboard/ClimateSurveys">
                                                            <i class="uil-database"></i> <span> Manage Climate</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"> <i
                                                            class="uil-user"></i> <span>Survey</span> </a>
                                                <ul class="sub-menu" aria-expanded="true">
                                                    <li class=""><a href="<?= base_url(); ?>EN/Dashboard/Addsurveys">
                                                            <i class="uil-plus"></i> <span> Create Survey </span> </a>
                                                    </li>
                                                    <!-- Manage_surveys -->
                                                    <li class=""><a
                                                                href="<?= base_url(); ?>EN/Dashboard/Manage_surveys">
                                                            <i class="uil-plus"></i> <span> Manage Survey </span> </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="javascript: void(0);" class="has-arrow waves-effect"> <i
                                                            class="uil-share-alt"></i> <span> Well being </span> </a>
                                                <ul class="sub-menu mm-collapse" aria-expanded="true">
                                                    <li><a href="javascript: void(0);" class="has-arrow"> <i
                                                                    class="uil uil-database"> </i>
                                                            <span> Library </span> </a>
                                                        <ul class="sub-menu mm-collapse" aria-expanded="true">
                                                            <li class=""><a
                                                                        href="<?= base_url(); ?>EN/Dashboard/Category">
                                                                    <i class="uil-plus"></i> <span> Category </span>
                                                                </a></li>
                                                            <li class=""><a
                                                                        href="<?= base_url(); ?>EN/Dashboard/Resources">
                                                                    <i class="uil-plus"></i> <span> Resources </span>
                                                                </a></li>
                                                            <li class=""><a
                                                                        href="<?= base_url(); ?>EN/Dashboard/ManageSets">
                                                                    <i class="uil-plus"></i>
                                                                    <span> Survey Title </span> </a></li>
                                                            <li class=""><a
                                                                        href="<?= base_url(); ?>EN/Dashboard/Managequestions">
                                                                    <i class="uil-plus"></i> <span> Questions </span>
                                                                </a></li>
                                                            <li class=""><a
                                                                        href="<?= base_url(); ?>EN/Dashboard/manage-answers">
                                                                    <i class="uil-plus"></i> <span> Choices </span> </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                <ul class="sub-menu mm-collapse" aria-expanded="true">
                                                    <li><a href="javascript: void(0);" class="has-arrow"> <i
                                                                    class="uil uil-database"> </i>
                                                            <span> Report Survey </span> </a>
                                                        <ul class="sub-menu mm-collapse" aria-expanded="true">
                                                            <li class=""><a
                                                                        href="<?= base_url(); ?>EN/Dashboard/categorys-reports">
                                                                    <i class="uil-plus"> </i> <span> Category </span>
                                                                </a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>


                                        <?php } elseif ($sessiondata['level'] == 0 && $sessiondata['type'] == "consultant") { ?>
                                            <li class=""><a href="<?= base_url("EN/Consultant"); ?>"> <i
                                                            class="uil-home"></i> <span>Home</span> </a></li>
                                            <li class=""><a href="<?= base_url("EN/Consultant/systemes"); ?>">
                                                    <i class="uil-plus"></i> <span>Reports</span> </a></li>
                                            <li class=""><a href="<?= base_url("EN/Consultant/Reports"); ?>">
                                                    <i class="uil-file"></i> <span>Files</span> </a></li>
                                            <li class=""><a href="<?= base_url("EN/Consultant/chats"); ?>"> <i
                                                            class="uil-message"></i> <span>UNREAD MESSAGES</span> </a>
                                            </li>
                                        <?php } elseif ($sessiondata['level'] == 1 && $sessiondata['type'] == "Ministry") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <style>
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
                                            </style>
                                            <?= new MinistryMenus() ?>
                                        <?php } elseif ($sessiondata['level'] == 1 && $sessiondata['type'] == "Company") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <li class=""><a href="<?= base_url(); ?>EN/schools"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/school/dashboardschool.png"
                                                                width="19px"></i> <span> STATUS </span> </a></li>

                                            <style>
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
                                            </style>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/DASHBOARD.png"
                                                                width="19px"></i> <span> DASHBOARD </span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company/Profile"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Profile.png"
                                                                width="19px"></i> <span> PROFILE </span> </a></li>
                                            <?php
                                            $get_style = $this->db->query(" SELECT `r_style`.`en_co_type`,`r_style`.`en_co_type_sub`
                                                FROM `l0_organization` JOIN `r_style` ON `l0_organization`.`Style_type_id`  = `r_style`.`Id` 
                                                WHERE  `l0_organization`.`Id` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
                                            ?>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company/Monitors_routes_company">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                width="19px"></i> <span>REPORTS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company/addDepartment">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Add.png"
                                                                width="19px"></i>
                                                    <?php foreach ($get_style as $style) { ?>
                                                        <span>ADD
                                                                <?= strtoupper($style['en_co_type_sub']) ?>
                                                            </span>
                                                    <?php } ?>
                                                </a></li>
                                            <?php
                                            $dep = $this->db->query('SELECT * FROM l1_co_department WHERE Added_By = ' . $sessiondata['admin_id'] . ' ')->num_rows();
                                            ?>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company/DepartmentsList">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/ministryicons/DM_list.png"
                                                                width="19px"></i>
                                                    <?php foreach ($get_style

                                                    as $style) { ?>
                                                    <span>
                                                                <?= strtoupper($style['en_co_type_sub']) ?>
                                                                LIST </span> <span data-toggle="tooltip"
                                                                                   data-placement="right" title=""
                                                                                   data-original-title="Total of Departments : <?= $dep; ?>">
                                                            <?php } ?>
                                                </a></li>
                                            <?php
                                            $perm_device_access = $this->db->query("SELECT * FROM `v0_area_device_permission`
                                                WHERE `system_id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                                            $prms_clm = $this->db->query(" SELECT `surveys` ,`Created`
                                                FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`Claimate` = '1' ")->result_array();
                                            if ($prms_clm) {
                                                ?>
                                                <li class=""><a href="<?= base_url(); ?>EN/Company/Message"><i
                                                                class="uil-plus"></i><span>MESSAGE</span> </a></li>
                                                <li class=""><a href="<?= base_url(); ?>EN/Company/ClimatesLinks">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                    width="25px"></i> <span>CLIMATE</span> </a></li>
                                            <?php } ?>
                                            <?php
                                            $prms_surv = $this->db->query(" SELECT `surveys` ,`Created`
                                                FROM `v0_permissions` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `user_type` = 'Company' AND `v0_permissions`.`surveys` = '1' ")->result_array();
                                            if (!empty($prms_surv)) {
                                                ?>
                                                <li class=""><a href="<?= base_url(); ?>EN/Company/categorys-reports">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                    width="25px"></i> <span> CATEGORIES </span> </a>
                                                </li>
                                                <li class=""><a href="<?= base_url(); ?>EN/Company/Wellness">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                    width="25px"></i> <span> WELLBEING </span> </a></li>
                                            <?php } ?>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company/Consultants"><i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                width="25px"></i> <span> CONSULTANTS </span> </a></li>
                                        <?php } elseif ($sessiondata['level'] == 0 && $sessiondata['type'] == "controller") { ?>
                                            <li class="">
                                                <a href="<?= base_url(); ?>EN/controller/transfer"><i class="">
                                                        <img src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                             width="25px"></i>
                                                    <span> TRANSFER </span>
                                                </a>
                                            </li>
                                        <?php } elseif ($sessiondata['level'] == 2 && $sessiondata['type'] == "school") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <style>
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
                                                    border-radius: 5px;
                                                }
                                            </style>
                                            <?= new SchoolMenus() ?>
                                        <?php } elseif ($sessiondata['level'] == 2 && $sessiondata['type'] == "department") { ?>
                                            <style>
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
                                            </style>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/dashboard.png"
                                                                width="19px"></i> <span>DASHBOARD</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/Profile">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/dep_profile.png"
                                                                width="19px"></i> <span>DEPARTMENT PROFILE</span> </a>
                                            </li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/AddDevice">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/device_nav_.png"
                                                                width="19px"></i> <span>ADD DEVICE</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/AddMembers"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/members_add.png"
                                                                width="19px"></i> <span>ADD MEMBERS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/ListOfPatients">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/list_of_members_dep.png"
                                                                width="19px"></i> <span>LIST OF USERS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/listOfSites">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/sites_list_dep.png"
                                                                width="19px"></i> <span>LIST OF SITES</span> </a></li>
                                            <li><a href="<?= base_url(); ?>EN/Departments/Tests"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/temp-tests_dep.png"
                                                                width="19px"></i> <span>TEMPERATURE TESTS</span> </a>
                                            </li>
                                            <li><a href="<?= base_url(); ?>EN/Departments/MembersList"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/members_list_dept.png"
                                                                width="19px"></i> <span>LIST OF USERS</span> </a></li>
                                            <li><a href="<?= base_url(); ?>EN/Departments/Lab-Tests"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/labtests_dept.png"
                                                                width="19px"></i> <span>LAB TESTS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/All-Tests-Today">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/temp_all_tests.png"
                                                                width="19px"></i> <span>DAILY REPORT </span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments/Attendance-Report">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/temp_all_tests.png"
                                                                width="19px"></i> <span>ATTENDANCE REPORT</span> </a>
                                            </li>
                                        <?php } elseif ($sessiondata['level'] == 2 && $sessiondata['type'] == "department_Company") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <style>
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
                                            </style>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company-Departments">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/DASHBOARD.png"
                                                                width="19px"></i> <span> DASHBOARD </span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company-Departments/Profile">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Profile.png"
                                                                width="19px"></i> <span>PROFILE </span> </a></li>
                                            <li class=""><a
                                                        href="<?= base_url(); ?>EN/Company-Departments/Adding-routes">
                                                    <i class=""> <img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Add.png"
                                                                style="width: 30px;"> </i> <span>ADD</span> </a></li>
                                            <li class=""><a
                                                        href="<?= base_url(); ?>EN/Company-Departments/lists-routes">
                                                    <i class=""> <img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/List.png"
                                                                style="width: 30px;"> </i> <span>LISTS</span> </a></li>
                                            <li><a href="<?= base_url(); ?>EN/Company-Departments/Tests"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Temperature.png"
                                                                width="19px"></i> <span> TEMPERATURE</span> </a></li>
                                            <li><a href="<?= base_url(); ?>EN/Company-Departments/Lab_Tests">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Labe.png"
                                                                width="19px"></i> <span> LAB TESTS </span> </a></li>
                                            <li>
                                                <a href="<?= base_url(); ?>EN/Company-Departments/reports_routes">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/REPORTS99.png"
                                                                width="19px"></i> <span> REPORTS </span> </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>EN/Company-Departments/monitors_routes">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Monitor99.png"
                                                                width="19px"></i> <span> MONITOR </span> </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>EN/Company-Departments/visitors_routes">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Monitor99.png"
                                                                width="19px"></i> <span> VISITOR SYSTEM </span> </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>EN/Company-Departments/smartqrcode">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/DepartmentCompany/Monitor99.png"
                                                                width="19px"></i> <span> SMART QR CODE </span> </a>
                                            </li>
                                            <?php
                                            $prms = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`surveys` , `v0_permissions`.`Created`
                                                FROM `l1_co_department` 
                                                JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
                                                JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
                                                AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
                                                WHERE  `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                                            if (!empty($prms)) {
                                                $permission = $prms[0];
                                            } else {
                                                $permission = "";
                                            }
                                            $today = date("Y-m-d");
                                            ?>
                                            <?php if (!empty($permission) && $permission['Air_quality'] == '1') { ?>
                                                <li class=""><a
                                                            href="<?= base_url(); ?>EN/Company-Departments/Air-Quality-Dashboard">
                                                        <i class=""> <img
                                                                    src="<?= base_url(); ?>assets/images/DepartmentCompany/Air Quality99.png"
                                                                    width="19px"> </i> <span>AIR QUALITY</span></a></li>
                                            <?php } ?>
                                            <?php if (!empty($permission) && $permission['surveys'] == '1') { ?>
                                                <li class=""><a
                                                            href="<?= base_url(); ?>EN/Company-Departments/categorys-reports">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/CATEGORIES.png"
                                                                    width="19px"></i> <span>CATEGORIES</span> </a></li>
                                            <?php } ?>
                                            <?php
                                            $prms_survey = $this->db->query("SELECT `v0_permissions`.`Claimate` , `v0_permissions`.`Created`
                                                FROM `l1_co_department` 
                                                JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id` 
                                                JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
                                                AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
                                                AND  `v0_permissions`.`Claimate` = '1'
                                                WHERE `l1_co_department`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                                            if ($prms_survey) {
                                                ?>
                                                <li class=""><a href="<?= base_url(); ?>EN/Company_Departments/Climate">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                    width="25px"></i> <span>CLIMATE </span> </a></li>
                                                <li class=""><a
                                                            href="<?= base_url(); ?>EN/Company_Departments/wellness">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                    width="25px"></i> <span>WELLBEING</span> </a></li>
                                            <?php } ?>
                                            <li class=""><a href="<?= base_url(); ?>EN/Company_Departments/Consultant">
                                                    <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/REPORTS.png"
                                                                width="25px"></i> <span> CONSULTANT </span> </a></li>
                                        <?php } elseif ($sessiondata['level'] == 3 && $sessiondata['type'] == "School_Perm" && $sessiondata["hasperm"]) { ?>
                                            <li class="menu-title">MENU</li>
                                            <li class=""><a href="<?= base_url(); ?>EN/School_Permition/AddDevice">
                                                    <i class="uil-plus"></i> <span>ADD DEVICE</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/School_Permition/AddMembers">
                                                    <i class="uil-plus"></i> <span>ADD MEMBERS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/School_Permition/listOfStaff">
                                                    <i class="uil-list-ul"></i> <span>LIST OF STAFF</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/School_Permition/listOfTeachers">
                                                    <i class="uil-list-ul"></i> <span>LIST OF TEACHERS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/School_Permition/listOfStudents">
                                                    <i class="uil-list-ul"></i> <span>LIST OF STUDENTS</span> </a></li>
                                            <li class=""><a href="<?= base_url(); ?>EN/School_Permition/listOfSites">
                                                    <i class="uil-list-ul"></i> <span>LIST OF SITES</span> </a></li>
                                            <li><a href="<?= base_url(); ?>EN/School_Permition/Tests"> <i
                                                            class="uil-file-medical"></i> <span>TEMPERATURE TESTS</span>
                                                </a></li>
                                        <?php } elseif ($sessiondata['level'] == 3 && $sessiondata['type'] == "Dept_Perm" && $sessiondata['hasperm']) { ?>
                                            <li class="menu-title">MENU</li>
                                            <li class=""><a href="<?= base_url(); ?>EN/Departments_Permition/AddDevice">
                                                    <i class="uil-plus"></i> <span>ADD DEVICE</span> </a></li>
                                            <li class=""><a
                                                        href="<?= base_url(); ?>EN/Departments_Permition/AddMembers">
                                                    <i class="uil-plus"></i> <span>ADD MEMBERS</span> </a></li>
                                            <li class=""><a
                                                        href="<?= base_url(); ?>EN/Departments_Permition/ListOfPatients">
                                                    <i class="uil-list-ul"></i> <span>LIST OF USERS</span> </a></li>
                                            <li class=""><a
                                                        href="<?= base_url(); ?>EN/Departments_Permition/listOfSites">
                                                    <i class="uil-list-ul"></i> <span>LIST OF SITES</span> </a></li>
                                            <li><a href="<?= base_url(); ?>EN/Departments_Permition/Tests"> <i
                                                            class="uil-file-medical"></i> <span>TEMPERATURE TESTS</span>
                                                </a></li>
                                        <?php } elseif ($sessiondata['level'] == 2 && $sessiondata['type'] == "Parent") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <li><a href="<?= base_url("EN/Parents/Home"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>HOME</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/Dashboard"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/dash.png"
                                                                width="19px"></i> <span>DASHBOARD</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/Profile"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/profile.png"
                                                                width="19px"></i> <span>MY PROFILE</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/About-us"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/about.png"
                                                                width="19px"></i> <span>MY RESOURCES</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/Select-Child"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/Total_Students.png"
                                                                width="19px"></i> <span>CHILDREN</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/Show-surveys"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys.png"
                                                                width="19px"></i> <span>SURVEYS</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/Surveys_history"); ?>"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys_history.png"
                                                                width="19px"></i> <span>HISTORY</span> </a></li>
                                            <li><a href="<?= base_url("EN/Parents/aboutus"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/Total_Students.png"
                                                                width="19px"></i> <span>ABOUT US</span> </a></li>
                                            <?php
                                            $Parents_assigned_surveys = $this->db->query("SELECT Id FROM `sv_dedicated_surveys` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `completed` = '0' AND `usertype` = 'Parent' ")->result_array();
                                            if (!empty($Parents_assigned_surveys)) {
                                                ?>
                                                <li><a href="<?= base_url("EN/Parents/DedicatedSurveys"); ?>">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                    width="19px"></i> <span>Dedicated Surveys </span>
                                                    </a></li>
                                            <?php } ?>
                                        <?php } elseif ($sessiondata['level'] == 3 && $sessiondata['type'] == "staff") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <li><a href="<?= base_url("EN/staffs/Home"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>HOME</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/Dashboard"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/dash.png"
                                                                width="19px"></i> <span>DASHBOARD</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/Show-surveys"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/dash.png"
                                                                width="19px"></i> <span>SURVEYS</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/Surveys-history"); ?>"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys_history.png"
                                                                width="19px"></i> <span>HISTORY</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/Profile"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/profile.png"
                                                                width="19px"></i> <span>MY PROFILE</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/About-us"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/about.png"
                                                                width="19px"></i> <span>MY RESOURCES</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/Videos"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                width="19px"></i> <span>VIDEOS</span> </a></li>
                                            <li><a href="<?= base_url("EN/staffs/aboutus"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>ABOUT US</span> </a></li>
                                        <?php } elseif ($sessiondata['level'] == 3 && $sessiondata['type'] == "Teacher") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <li><a href="<?= base_url("EN/teachers/Home"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>HOME</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/Dashboard"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/dash.png"
                                                                width="19px"></i> <span>DASHBOARD</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/Show-surveys"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/dash.png"
                                                                width="19px"></i> <span>SURVEYS</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/Surveys-history"); ?>"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys_history.png"
                                                                width="19px"></i> <span>HISTORY</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/Profile"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/profile.png"
                                                                width="19px"></i> <span>MY PROFILE</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/About-us"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/about.png"
                                                                width="19px"></i> <span>MY RESOURCES</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/Videos"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                width="19px"></i> <span>VIDEOS</span> </a></li>
                                            <li><a href="<?= base_url("EN/teachers/aboutus"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                width="19px"></i> <span>ABOUT US</span> </a></li>
                                            <?php
                                            $teachers_assigned_surveys = $this->db->query("SELECT Id FROM `sv_dedicated_surveys` WHERE `user_id` = '" . $sessiondata['admin_id'] . "' AND `completed` = '0' AND `usertype` = 'teacher' ")->result_array();
                                            if (!empty($teachers_assigned_surveys)) {
                                                ?>
                                                <li>
                                                    <a href="<?= base_url("EN/teachers/DedicatedSurveys"); ?>">
                                                        <i class=""><img
                                                                    src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                    width="19px"></i> <span>Dedicated Surveys </span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } elseif ($sessiondata['level'] == 3 && $sessiondata['type'] == "Student") { ?>
                                            <link rel="stylesheet"
                                                  href="<?= base_url('assets/css/l3usersstyle.css') ?>"/>
                                            <li><a href="<?= base_url("EN/Students/Home"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>HOME</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/Dashboard"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/dash.png"
                                                                width="19px"></i> <span>DASHBOARD</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/Profile"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/profile.png"
                                                                width="19px"></i> <span>MY PROFILE</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/Mylifereports"); ?>"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>SPEAK OUT</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/About-us"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/about.png"
                                                                width="19px"></i> <span>RESOURCES</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/Show-surveys"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys.png"
                                                                width="19px"></i> <span>MY SURVEYS</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/Surveys-history"); ?>"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys_history.png"
                                                                width="19px"></i> <span> MY HISTORY</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/Videos"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                width="19px"></i> <span>MY MEDIA</span> </a></li>
                                            <li><a href="<?= base_url("EN/Students/aboutus"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/media.png"
                                                                width="19px"></i> <span>ABOUT US</span> </a></li>
                                            <img src="<?= base_url('assets/images/l3usersstyle/menu_kids.png') ?>"
                                                 style="width: 100%;margin-bottom: -30px;" alt="">
                                        <?php } elseif ($sessiondata['level'] == 3 && $sessiondata['type'] == "co_Employee") { ?>
                                            <li><a href="<?= base_url("EN/Employee/"); ?>"> <i class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/home.png"
                                                                width="19px"></i> <span>HOME</span> </a></li>
                                            <li><a href="<?= base_url("EN/Employee/Show_surveys"); ?>"> <i class=""><img
                                                                src="<?= base_url("assets/images/icons/png_icons/students_icons/media.png"); ?>"
                                                                width="19px"></i> <span>MY MEDIA</span> </a></li>
                                            <li><a href="<?= base_url("EN/Employee/Surveys-history"); ?>"> <i
                                                            class=""><img
                                                                src="<?= base_url(); ?>assets/images/icons/png_icons/students_icons/surveys_history.png"
                                                                width="19px"></i> <span> MY HISTORY</span> </a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: auto; height: 956px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar"
                     style="width: 112px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
            </div>
            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar"
                     style="height: 164px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
            </div>
        </div>
    </div>
    <script>
        setInterval(function () {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Notifs/notification',
                success: function (data) {
                    $('#nots').html(data);
                },
            });
        }, 10000);
        $('#page-header-notifications-dropdown').click(function () {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Notifs/notificationList',
                success: function (data) {
                    $('#notslist').html(data);
                },
            });
        });
        $(".set_readed").click(function () {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Notifs/SetReaded',
            });
            $('#notslist').html("empty !!");
        });

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
<script src="<?= base_url() ?>assets/js/html2canvas.js"></script>
<div id="feedback" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="feedbackLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="feedbackLabel">send feedback about this page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="loader" style="display: none;">
                    <div class="spinner-border text-primary m-1" role="status" style="margin: auto !important;"><span
                                class="sr-only">Loading...</span></div>
                </div>
                <h5 class="font-size-16">Enter you feed back please</h5>
                <form id="feedBack_Form">
                    <textarea placeholder="any description for the problem , like the actions you take "
                              class="form-control" rows="5" id="feedback_desc" required="" minlength="5"></textarea>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-1">
                        submit the feedback
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    var ScreenShoot = "";
    $('.feedback_btn').click(function () {
        html2canvas($(".main-content")[0], {
            dpi: 192,
        }).then(function (canvas) {
            ScreenShoot = canvas.toDataURL("image/png");
        });
    });
    $("#feedBack_Form").on('submit', function (e) {
        e.preventDefault();
        if ($('#feedback_desc').val().length > 3) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Ajax/FeedBack',
                data: {
                    img_txt: ScreenShoot,
                    url: window.location.href,
                    feedback_desc: $('#feedback_desc').val(),
                    <?php if (isset($sessiondata)) {  ?>
                    sessiondata: `<?= json_encode($sessiondata);  ?>`,
                    <?php  } else {  ?>
                    sessiondata: 'users page',
                    <?php  }  ?>
                },
                beforeSend: function () {
                    $('#feedback .loader').css("display", "grid");
                    $('#feedback .loader').css("opacity", "1");
                },
                success: function () {
                    $('#feedback .loader').css("display", "none");
                    $('#feedback .loader').css("opacity", "0");
                    setTimeout(function () {
                        $('#feedback').modal('hide');
                    }, 500);
                }
            });
        } else {
            $('#feedback_desc').addClass('');
        }
    });
</script>
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
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
    $('.logout').click(function () {
        location.href = '<?= base_url() . "EN/Users/logout"; ?>';
    });
</script>