<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- 
		Responsive datatable examples
		id="datatables_buttons_info"
		-->
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- Begin page -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <?php
                $parent = $this->db->query("SELECT Added_By FROM `l1_co_department` 
WHERE Id = '" . $sessiondata['admin_id'] . "' ORDER BY `Id` DESC")->result_array();
                $parentId =  $parent[0]['Added_By'];
                $parent_Infos = $this->db->query("SELECT * FROM `l0_organization` 
WHERE Id = '" . $parentId . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
                $parent_name = $parent_Infos[0]['Username'];
                ?>
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
                            التقرير اليومي - نتائج فحوصات درجات الحرارة - <?php echo $sessiondata['f_name'] ?>
                        </h4>
                    </div>
                </div>

                <?php

                function data_of_user($type, $sessiondata)
                {
                    $ci = &get_instance();
                    $list = array();
                    $today = date("Y-m-d");

                    $Ourstaffs = $ci->db->query("SELECT * FROM l2_co_patient WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();


                    foreach ($Ourstaffs as $staff) {
                        $staffname = $staff['F_name_AR'] . ' ' . $staff['L_name_AR'];
                        $ID = $staff['Id'];
                        $Position_Staff = $staff['Position'];
                        $action = $staff['Action'];
                        $getResults = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' ORDER BY `TimeStamp` DESC LIMIT 1 ")->result_array();
                        foreach ($getResults as $results) {
                            $creat = $results['Created'] . ' ' . $results['Time'];
                            $list[] = array(
                                "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $creat, 'position' => $Position_Staff, "Symp" => $results['Symptoms'],
                                "Added_By" => $results['Added_By'], "Device" => $results['Device'], "type" => $type, "Action" => $action
                            );
                        }
                    }
                    return ($list);
                }

                $Staff_list = array();
                $tbl_prefix  = $this->db->query("SELECT * FROM `r_usertype`")->result_array();
                foreach ($tbl_prefix as $pref) {
                    $Staff_list[] = data_of_user($pref['UserType'], $sessiondata);
                }

                function symps($symps)
                {
                    $ci = &get_instance();
                    $Symps_array = explode(';', $symps);
                    $sz =  sizeof($Symps_array);
                    //print_r($Symps_array);  
                    if ($sz > 1) {
                        foreach ($Symps_array as $sympsArr) {
                            //print_r($sympsArr);
                            //echo sizeof($Symps_array);
                            $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                            foreach ($SempName as $name) {
                                echo $name['symptoms_EN'] . ",";
                            }
                        }
                    } else {
                        echo "بلا أعراض ";
                    }
                }
                ?>

                <style>
                    .badge {
                        text-align: center;
                    }

                    .Td-Results {
                        color: #FFFFFF;
                    }
                </style>
                <!-- end page title -->
                <div class="row formcontainer" id="Staff_list">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> </h4>
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> الصورة </th>
                                            <th> الإسم </th>
                                            <th> النتيجة </th>
                                            <th> الحالة </th>
                                            <th> الأعراض </th>
                                            <th> تمت إضافته بواسطة </th>
                                            <th> عنوان MAC </th>
                                            <th> نوع المستخدم </th>
                                            <th> التاريخ والوقت </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($Staff_list as $results) {
                                            foreach ($results as $staffsRes) {
                                                if ($staffsRes['Action'] == "work") {
                                                    $action = "العمل";
                                                } elseif ($staffsRes['Action'] == "الحجر المنزلي") {
                                                    $action = "الحجر المنزلي";
                                                } else {
                                                    $action = "الحجر الصحي";
                                                }
                                        ?>

                                                <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $action ?>  ">
                                                    <td style="width: 20px;">
                                                        <?php
                                                        $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
											 WHERE `For_User` = '" . $staffsRes['Id'] . "' AND 
											 `Type_Of_User` = '" . $staffsRes['type'] . "' LIMIT 1 ")->result_array();
                                                        ?>
                                                        <?php if (empty($avatar)) {  ?>
                                                            <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                            <?php echo $staffsRes['position']; ?></p>
                                                    </td>
                                                    <?php boxes_Colors($staffsRes['Result']); ?>
                                                    <td><?php symps($staffsRes['Symp']) ?></td>
                                                    <td><?php echo $staffsRes["Added_By"];  ?></td>
                                                    <td><?php echo $staffsRes["Device"];  ?></td>
                                                    <?php $userTranslate = $this->db->query("SELECT `AR_UserType` FROM `r_usertype` 
											WHERE UserType = '" . $staffsRes['type'] . "' ")->result_array(); ?>
                                                    <td><?php echo $userTranslate[0]['AR_UserType']; ?></td>
                                                    <td><?php echo $staffsRes['Creat'] ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <!-- Required datatable js -->
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
        $(document).ready(function() {
            //$('#Students_table').DataTable(); //Buttons examples

            var table_st = $('#Students_table').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
            table_st.buttons().container().appendTo('#Students_table_wrapper .col-md-6:eq(0)');

            var table_th = $('#Teacher_table').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
            table_th.buttons().container().appendTo('#Teacher_table_wrapper .col-md-6:eq(0)');
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