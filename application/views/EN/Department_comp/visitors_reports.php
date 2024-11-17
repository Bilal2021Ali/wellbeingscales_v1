<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-as-bs4/css/as.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/libs/magnific-popup/magnific-popup.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
</head>
<?php $dialostics = $this->db->query("SELECT * FROM `r_dialosticbp`")->result_array(); ?>
<style>
    .page-item.page-link.active * {
        color: #fff;
    }
</style>

<body>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;"> DOC 023 - TEMPERATURE & VISITOR MONITORING</h4>
                <div class="row">

                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">


                        </div>
                    </div>
                </div>
                <style>
                    .badge {
                        text-align: center;
                    }

                    .Td-Results {
                        color: #FFFFFF;
                    }

                    .result {
                        border: 4px solid #fff !important;
                    }

                    th {
                        text-align: center;
                    }

                    .result .Unit {
                        position: relative;
                        bottom: -8px;
                        left: -40px;
                        font-size: 13px;
                    }

                    span {
                        text-transform: none;
                    }

                    .result .col-sm-6 {
                        border: 1px solid #fff;
                        border-radius: 5px;
                    }

                    .justify-content-center {
                        display: grid;
                        align-content: center;
                        align-items: center;
                        height: 90;
                        background: #eef5fb;
                    }
                </style>

                <div class="row formcontainer" id="Staff_list">
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger w-100">
                            <?= $error ?>
                        </div>
                    <?php } ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= current_url(); ?>" method="post">
                                    <label class="form-label">Date Range:</label>
                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker">
                                        <input type="text" class="form-control" name="start" autocomplete="off" placeholder="Start Date" value="<?= $start ?>" />
                                        <input type="text" class="form-control" name="end" autocomplete="off" placeholder="End Date" value="<?= $end ?>" />
                                    </div>
                                    <button class="btn btn-primary w-100 mt-2" type="submit">Generate</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> </h4>
                                <table id="visi_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th> Img </th>
                                            <?php if (!isset($NoTemp)) { ?>
                                                <th width="14%"> Result </th>
                                            <?php } ?>
                                            <th> Name </th>
                                            <th> Update User Data </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($visitors_results as $sn => $results) {
                                            if (!empty($results['F_name_EN'])) {
                                                $user_name = $results['F_name_EN'];
                                            } else {
                                                $user_name = "Not registered visitor";
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center justify-content-center"><?php echo $sn + 1 ?></td>
                                                <td class="text-center">
                                                    <a class="image-popup-no-margins" href="<?php echo base_url("Proxy/get_image?img_url=") . $results['img_uri']; ?>">
                                                        <img class="img-fluid mr-2" alt="" src="<?php echo base_url("Proxy/get_image?img_url=") . $results['img_uri']; ?>" width=" 75">
                                                    </a>
                                                </td>
                                                <?php !isset($NoTemp) && boxes_Colors($results['Result'], $dialostics[0], "Temperature", "C°", "-59px", "Temperature.png"); ?>
                                                <td class="text-center result">
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $user_name ?></h6>
                                                    <p class="text-muted" style="font-size: 10px;"><?php echo $results['result_time'] ?> </p>
                                                </td>
                                                <td class="text-center flex justify-content-center">
                                                    <a href="<?php echo base_url("EN/Company_Departments/update_visitor/" . $results['UserId']); ?>" class="btn btn-primary btn-rounded waves-effect waves-light">Update User Data</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="col-12 text-center">
                                    <!-- <?= $links ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
        strong {
            font-size: 16px;
        }
    </style>
    <!-- END layout-wrapper -->
    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-as/js/dataTables.as.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-as-bs4/js/as.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-as/js/as.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-as/js/as.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-as/js/as.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/lightbox.init.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            var table_st = $('#visi_table').DataTable({
                lengthChange: false,
                'paging': false,
                as: ['copy', 'excel', 'pdf', 'colvis']
            });
            table_st.as().container().appendTo('#visi_table_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>
<?php
function boxes_Colors($result, $condition, $text, $unit, $left = "-26px", $img = "")
{
    $color_font = "191919";
    $back_font = "f8f9fa";
    settype($result, "float");

    if ($result > $condition['low_from'] && $result < $condition['from_to']) {
        $color_font = $condition['low_font_col'];
        $back_font = $condition['low_back_col'];
    } elseif ($result > $condition['normal_from'] && $result < $condition['normal_to']) {
        $color_font = $condition['normal_font_col'];
        $back_font = $condition['normal_back_col'];
    } elseif ($result > $condition['pre_from'] && $result < $condition['pre_to']) {
        $color_font = $condition['pre_font_col'];
        $back_font = $condition['pre_back_col'];
    } elseif ($result > $condition['high_from'] && $result < $condition['hight_to']) {
        $color_font = $condition['hight_font_col'];
        $back_font = $condition['hight_back_col'];
    } elseif ($result > $condition['high2_from'] && $result < $condition['high2_to']) {
        $color_font = $condition['high2_font_col'];
        $back_font = $condition['high2_back_col'];
    }


    //print_r($condition); 
?>
    <td class="text-center result" style="background: #<?php echo $back_font ?>">
        <h6 style="color: #<?php echo $color_font ?>">
            <img src="<?php echo base_url("assets/images/icons/" . $img)  ?>" alt="" class="icon__"><?php echo $text ?>
        </h6>
        <strong style="color: #<?php echo $color_font ?>;display : block;margin-top: 18px;">
            <?php echo $result; ?>
        </strong>
        <span style="color: #<?php echo $color_font ?>;left: <?php echo $left ?>" class="Unit">
            <?php echo $unit ?>
            </h6>
    </td>
<?php  } ?>
<?php
function Blood_pressure($result_f, $result_l, $condition, $condition_l, $img, $date = "--:--:--")
{
    $color_font_f = "191919";
    $back_font_f = "f8f9fa";
    $color_font_l = "191919";
    $back_font_l = "f8f9fa";
    $bkall = "f8f9fa";
    $ci = &get_instance();
    settype($result_f, "float");
    settype($result_l, "float");
    if ($result_f >= $condition['low_from'] && $result_f <= $condition['from_to']) {
        $color_font_f = $condition['low_font_col'];
        $back_font_f = $condition['low_back_col'];
    } elseif ($result_f >= $condition['normal_from'] && $result_f <= $condition['normal_to']) {
        $color_font_f = $condition['normal_font_col'];
        $back_font_f = $condition['normal_back_col'];
    } elseif ($result_f >= $condition['pre_from'] && $result_f <= $condition['pre_to']) {
        $color_font_f = $condition['pre_font_col'];
        $back_font_f = $condition['pre_back_col'];
    } elseif ($result_f >= $condition['high_from'] && $result_f <= $condition['hight_to']) {
        $color_font_f = $condition['hight_font_col'];
        $back_font_f = $condition['hight_back_col'];
    } elseif ($result_f >= $condition['high2_from'] && $result_f <= $condition['high2_to']) {
        $color_font_f = $condition['high2_font_col'];
        $back_font_f = $condition['high2_back_col'];
    }

    $bkallcond = $ci->db->get_where("r_dialosticbp", ["Id" => "8"])->result_array();
    if ($result_f >= $bkallcond[0]['low_from'] && $result_f <= $bkallcond[0]['from_to']) {
        $bkall = $bkallcond[0]['low_back_col'];
    } elseif ($result_f >= $bkallcond[0]['normal_from'] && $result_f <= $bkallcond[0]['normal_to']) {
        $bkall = $bkallcond[0]['normal_back_col'];
    } elseif ($result_f >= $bkallcond[0]['pre_from'] && $result_f <= $bkallcond[0]['pre_to']) {
        $bkall = $bkallcond[0]['pre_back_col'];
    } elseif ($result_f >= $bkallcond[0]['high_from'] && $result_f <= $bkallcond[0]['hight_to']) {
        $bkall = $bkallcond[0]['hight_back_col'];
    } elseif ($result_f >= $bkallcond[0]['high2_from'] && $result_f <= $bkallcond[0]['high2_to']) {
        $bkall = $bkallcond[0]['high2_back_col'];
    }

    if ($result_l >= $condition_l['low_from'] && $result_l <= $condition_l['from_to']) {
        $color_font_l = $condition_l['low_font_col'];
        $back_font_l = $condition_l['low_back_col'];
    } elseif ($result_l >= $condition_l['normal_from'] && $result_l <= $condition_l['normal_to']) {
        $color_font_l = $condition_l['normal_font_col'];
        $back_font_l = $condition_l['normal_back_col'];
    } elseif ($result_l >= $condition_l['pre_from'] && $result_l <= $condition_l['pre_to']) {
        $color_font_l = $condition_l['pre_font_col'];
        $back_font_l = $condition_l['pre_back_col'];
    } elseif ($result_l >= $condition_l['high_from'] && $result_l <= $condition_l['hight_to']) {
        $color_font_l = $condition_l['hight_font_col'];
        $back_font_l = $condition_l['hight_back_col'];
    } elseif ($result_l >= $condition_l['high2_from'] && $result_l <= $condition_l['high2_to']) {
        $color_font_l = $condition_l['high2_font_col'];
        $back_font_l = $condition_l['high2_back_col'];
    }
    //print_r($condition); 
?>
    <td class="text-center result" style="background: #<?= $bkall ?>">
        <h6 style="color: #<?= $color_font_f ?>">
            <div class="row">
                <div class="col-sm-12">
                    <h6 style="color: #191919">
                        <img src="<?= base_url("assets/images/icons/" . $img)  ?>" alt="" class="icon__"></img>
                    </h6>
                </div>
                <div class="col-sm-6" style="background: #<?= $back_font_f ?>;padding : 10px;"><strong style="color: #<?= $color_font_f ?>;display : block;"><?= $result_f; ?></strong></div>
                <div class="col-sm-6" style="background: #<?= $back_font_l ?>;padding : 10px;"><strong style="color: #<?= $color_font_l ?>;display : block;"><?= $result_l; ?></strong></div>
            </div>
            <span style="color: #<?= $color_font_f ?>;left: 0px;top: 10px;font-weight: lighter;" class="Unit"><?= "mmHg" ?>
                <?= $date !== "00:00:00" ? "<br>" . $date : "<br>" . "--:--:--"; ?> </span>
        </h6>
    </td>
<?php  } ?>

</html>