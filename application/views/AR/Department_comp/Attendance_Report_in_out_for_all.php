<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/css/app.css" rel="stylesheet">
    <style>
        .badge {
            text-align: center;
        }

        .Td-Results {
            color: #FFFFFF;
        }

        /*
Theme Name: jqueryui-com
Template: jquery
*/

        a,
        .title {
            color: #b24926;
        }

        #content a:hover {
            color: #333;
        }

        #banner-secondary p.intro {
            padding: 0;
            float: left;
            width: 50%;
        }

        #banner-secondary .download-box {
            border: 1px solid #aaa;
            background: #333;
            background: -webkit-linear-gradient(left, #333 0%, #444 100%);
            background: linear-gradient(to right, #333 0%, #444 100%);
            float: right;
            width: 40%;
            text-align: center;
            font-size: 20px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.8);
        }

        #banner-secondary .download-box h2 {
            color: #71d1ff;
            font-size: 26px;
        }

        #banner-secondary .download-box .button {
            float: none;
            display: block;
            margin-top: 15px;
        }

        #banner-secondary .download-box p {
            margin: 15px 0 5px;
        }

        #banner-secondary .download-option {
            width: 45%;
            float: left;
            font-size: 16px;
        }

        #banner-secondary .download-legacy {
            float: right;
        }

        #banner-secondary .download-option span {
            display: block;
            font-size: 14px;
            color: #71d1ff;
        }

        #content .dev-links {
            float: right;
            width: 30%;
            margin: -15px -25px .5em 1em;
            padding: 1em;
            border: 1px solid #666;
            border-width: 0 0 1px 1px;
            border-radius: 0 0 0 5px;
            box-shadow: -2px 2px 10px -2px #666;
        }

        #content .dev-links ul {
            margin: 0;
        }

        #content .dev-links li {
            padding: 0;
            margin: .25em 0 .25em 1em;
            background-image: none;
        }

        .demo-list {
            float: right;
            width: 25%;
        }

        .demo-list h2 {
            font-weight: normal;
            margin-bottom: 0;
        }

        #content .demo-list ul {
            width: 100%;
            border-top: 1px solid #ccc;
            margin: 0;
        }

        #content .demo-list li {
            border-bottom: 1px solid #ccc;
            margin: 0;
            padding: 0;
            background: #eee;
        }

        #content .demo-list .active {
            background: #fff;
        }

        #content .demo-list a {
            text-decoration: none;
            display: block;
            font-weight: bold;
            font-size: 13px;
            color: #3f3f3f;
            text-shadow: 1px 1px #fff;
            padding: 2% 4%;
        }

        .demo-frame {
            width: 70%;
            height: 420px;
        }

        .view-source a {
            cursor: pointer;
        }

        .view-source>div {
            overflow: hidden;
            display: none;
        }

        @media all and (max-width: 600px) {

            #banner-secondary p.intro,
            #banner-secondary .download-box {
                float: none;
                width: auto;
            }

            #banner-secondary .download-box {
                overflow: auto;
            }
        }

        @media only screen and (max-width: 480px) {
            #content .dev-links {
                width: 55%;
                margin: -15px -29px .5em 1em;
                overflow: hidden;
            }
        }
    </style>
    <style>
        .ui-widget.ui-widget-content {
            max-height: 150px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        input {
            text-align: center;
        }

        .ShowData {
            width: 100%;
            background: transparent;
            border: 0px;
            font-size: 18px;
            margin-bottom: -15px;
            text-align: center;
            transition: 0.2s all;
        }

        .ShowData:hover {
            transition: 0.2s all;
            font-size: 22px;
        }

        #preloader {
            background: rgba(255, 255, 255, 0.49);
        }
    </style>
</head>

<body>
    <style>
        .lds-roller {
            display: inline-block;
            position: absolute;
            width: 64px;
            height: 64px;
            top: 40%;
            left: 50%;
        }

        .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 32px 32px;
        }

        .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2D2D2D;
            margin: -3px 0 0 -3px;
        }

        .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
        }

        .lds-roller div:nth-child(1):after {
            top: 50px;
            left: 50px;
        }

        .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
        }

        .lds-roller div:nth-child(2):after {
            top: 54px;
            left: 45px;
        }

        .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
        }

        .lds-roller div:nth-child(3):after {
            top: 57px;
            left: 39px;
        }

        .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
        }

        .lds-roller div:nth-child(4):after {
            top: 58px;
            left: 32px;
        }

        .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
        }

        .lds-roller div:nth-child(5):after {
            top: 57px;
            left: 25px;
        }

        .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
        }

        .lds-roller div:nth-child(6):after {
            top: 54px;
            left: 19px;
        }

        .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
        }

        .lds-roller div:nth-child(7):after {
            top: 50px;
            left: 14px;
        }

        .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
        }

        .lds-roller div:nth-child(8):after {
            top: 45px;
            left: 10px;
        }

        @keyframes lds-roller {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <!-- Begin page -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div id="preloader" style="display: none;">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                            التقرير حسب الفترة الزمنية لجميع المستخدمين - الحضور والانصراف - <?php echo $sessiondata['f_name'] ?>
                        </h4>
                    </div>
                </div>


                <div class="formcontainer">
                    <form id="getData">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>أختر تاريخ البحث من - إلى</label>
                                    <div>
                                        <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-m-dd" data-date-autoclose="true">
                                            <input type="text" class="form-control" placeholder="من" name="Start" autocomplete="off">
                                            <input type="text" class="form-control" placeholder="إلى" name="End" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pl-2 pr-2">
                            <button type="Submit" class="btn btn-primary waves-effect w-100" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Get the Data"> إعرض النتائج <i class="uil uil-angle-down"></i></button>
                        </div>
                    </form>
                </div>

                <div class="row" id="SetData"></div>

            </div>
        </div>

    </div>
    <!-- END layout-wrapper -->
    <script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <!-- Required datatable js -->
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <script>
        $("#getData").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>AR/Ajax/Attendence_in_of_all_co',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#preloader,#status').attr('style', 'display: block;');
                },
                success: function(data) {
                    $('#preloader,#status').attr('style', 'display: none;');
                    $('#SetData').html(data);
                },
                ajaxError: function() {
                    $('#Toast').css('background-color', '#B40000');
                    $('#Toast').html("Ooops! Error was found.");
                }
            });
        });
    </script>
</body>
<?php
function boxes_Colors($result)
{
?>

    <style>
        .Td-Results_font span {
            font-size: 20px !important;
            padding: 6px;
        }

        .Td-Results .badge {
            padding: 6px;
        }
    </style>
    <td class="Td-Results_font">
        <?php if ($result >= 38.50 && $result <= 45.00) { ?>
            <!-- Hight Bilal 26 Dec 2020 -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"> <?php echo $result; ?> </span>
        <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
            <!-- Moderate -->
            <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"> <?php echo $result; ?> </span>
        <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
            <!-- No Risk -->
            <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"> <?php echo $result; ?></span>
        <?php } elseif ($result <= 36.20) { ?>
            <!-- Low -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"> <?php echo $result; ?> </span>
        <?php } elseif ($result > 45) { ?>
            <!-- Error -->
            <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"> <?php echo $result; ?> </span>
        <?php } ?>
    </td>

    <td class="Td-Results">
        <?php if ($result >= 38.50 && $result <= 45.00) { ?>
            <span class="badge error" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">عالي</span>
            <!-- Hight Bilal 26 Dec 2020 -->
        <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">معتدل</span>
            <!-- Moderate -->
        <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
            <span class="badge" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">طبيعي</span>
        <?php } elseif ($result <= 36.20) { ?>
            <!-- Low -->
            <span class="badge" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">منخفض</span>
        <?php } elseif ($result > 45) { ?>
            <!-- Error -->
            <span class="badge" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">قراءة خاطئة</span>
        <?php } ?>
    </td>
<?php
}

?>

</html>