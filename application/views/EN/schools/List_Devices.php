<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- DataTables -->
    <link href="<?= base_url() ?>aassets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>aassets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>aassets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>aassets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>aassets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>aassets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
   <style>
.InfosCards * {
  color: #fff;
}

    .InfosCards .card-body {
        border-radius: 5px;
    }
    .seebatches {
        font-size: 24px;
        color: #384db3;
        cursor: pointer;
    }
    #SetBatchesList .spinner-border {
        position: absolute;
        text-align: center;
        margin: auto;
        top: 50%;
        left: 46%;
    }
    .modal-body {
        min-height: 170px;
    }
    .InfosCards .card {
        box-shadow: 11px 7px 20px 0px rgba(0, 0, 0, 0.44);
        transition: 0.2s all;
    }
    .InfosCards .card:hover {
        transform: scale(1.02);
        transition: 0.2s all;
    }
    .InfosCards h4,
    .InfosCards p {
        color: #fff;
        cursor: default;
    }
    .delet {
        cursor: pointer;
    }
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #CB0002;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }
    input:checked+.slider {
        background-color: #2196F3;
    }
    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }
    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }
    .slider.round:before {
        border-radius: 50%;
    }
    .bx.bxs-trash-alt {
        font-size: 24px;
        color: #e8625b;
        margin-left: 9px;
    }
    .delet_desabled {
        color: #d0d0d0 !important;
    }
</style>

<body>
    <!-- <body data-layout="horizontal" data-topbar="colored"> -->
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">CH 039 Counters of Devices- Thermometers, Labs, and Gateways</h4>
                   <div class="row">
        <div class="col-md-3 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #3df0f0;padding: 5px">
              <div class="card-body" style="background-color: #022326;">
                <div class="float-right mt-2">
                  <!-- <div id="CharTTest1"></div>-->
                  <img src="<?= base_url(); ?>assets/images/icons/png_icons/adddevicescounter.png" alt="schools" width="64px">
                </div>
                <div>
                  <?php
                  $idd = $sessiondata['admin_id'];
                  $all = $this->db->query("SELECT * FROM `l2_devices` WHERE `Added_By` = $idd  ")->num_rows();
                  $lasts = $this->db->query("SELECT * FROM `l2_devices`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 ")->result_array();
                  ?>
                  <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                      <?= $all ?>
                    </span></h4>
                  <p class="mb-0"> Devices</p>
                </div>
                <?php if (!empty($lasts)) { ?>
                  <p class="mt-3 mb-0"><span class="mr-1">
                      <?php foreach ($lasts as $last) { ?>
                        <?= $last['Created'] ?>
                    </span><br>
                    Last added device </p>
                <?php } ?>
              <?php } else { ?>
                <p class="mt-3 mb-0"><span class="mr-1">
                    <?= "--/--/--" ?>
                  </span><br>
                  Last added device </p>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!-- end col-->
        <div class="col-md-3 col-xl-3 InfosCards">
          <div class="card-body" style="background-color: #ff26be;padding: 5px">
            <div class="card-body" style="background-color: #2e001f;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/addThermometerscounter.png" alt="schools" width="64px"> </div>
              <div>
                <?php
                $allDevices = 0;
                $ListOfThisDevice;
                $All_added_Devices = $this->db->query("SELECT * FROM `l2_devices`
                                WHERE `Added_By` = $idd AND `Comments` = 'Thermometer'  ")->result_array();
                foreach ($All_added_Devices as $DevCr) {
                  $allDevices++;
                  $ListOfThisDevice[] = $DevCr["Created"];
                }
                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                    <?= $allDevices ?>
                  </span> </h4>
                <p class="mb-0"> Thermometers</p>
              </div>
              <?php if (!empty($ListOfThisDevice)) { ?>
                <p class="mt-3 mb-0"> <span class="mr-1">
                    <?= $ListOfThisDevice[0] ?>
                  </span><br>
                  Last added thermometer </p>
              <?php } else { ?>
                <p class="mt-3 mb-0"> <span class="mr-1">
                    <?= "--/--/--"; ?>
                  </span><br>
                  Last added thermometer </p>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- end col-->
        <div class="col-md-3 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #ffd70d;padding: 5px">
              <div class="card-body" style="background-color: #262002;">
                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/addlabdevicescounter.png" alt="schools" width="64px"> </div>
                <div>
                  <?php
                  $allDevices = 0;
                  $ListOfThisDevice;
                  $All_added_Devices_lab = $this->db->query("SELECT * FROM `l2_devices`
                                    WHERE `Added_By` = $idd AND `Comments` = 'Lab'  ")->result_array();
                  foreach ($All_added_Devices_lab as $DevCr) {
                    $allDevices++;
                    $ListOfThisDevicelab[] = $DevCr["Created"];
                  }
                  ?>
                  <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $allDevices ?>
                    </span> </h4>
                  <p class="mb-0">Lab Devices</p>
                </div>
                <?php if (!empty($ListOfThisDevicelab)) { ?>
                  <p class="mt-3 mb-0"><span class="mr-1">
                      <?= $ListOfThisDevicelab[0] ?>
                    </span><br>
                    Last added lab device </p>
                <?php } else { ?>
                  <p class="mt-3 mb-0"> <span class="mr-1">
                      <?= "--/--/--"; ?>
                    </span><br>
                    Last added lab device </p>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-xl-3 InfosCards">
          <div class="card">
            <div class="card-body" style="background-color: #3cf2a6;padding: 5px">
              <div class="card-body" style="background-color: #00261a;">
                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/addgatewaydevicescounter.png" alt="schools" width="64px"> </div>
                <div>
                  <?php
                  $allDevicesGateway = 0;
                  $ListOfThisDevice;
                  $All_added_Devices_Gateway = $this->db->query("SELECT * FROM `l2_devices`
                                    WHERE `Added_By` = $idd AND `Comments` = 'Gateway'  ")->result_array();
                  foreach ($All_added_Devices_Gateway as $DevGateway) {
                    $allDevicesGateway++;
                    $ListOfThisDeviceGateway[] = $DevGateway["Created"];
                  }
                  ?>
                  <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $allDevicesGateway ?>
                    </span> </h4>
                  <p class="mb-0">Gateway Devices</p>
                </div>
                <?php if (!empty($ListOfThisDeviceGateway)) { ?>
                  <p class="mt-3 mb-0"><span class="mr-1">
                      <?= $ListOfThisDeviceGateway[0] ?>
                    </span><br>
                    Last added gateway device </p>
                <?php } else { ?>
                  <p class="mt-3 mb-0"> <span class="mr-1">
                      <?= "--/--/--"; ?>
                    </span><br>
                    Last added gateway device </p>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div><!-- end row-->
                    <!-- start page title -->
                    <h4 class="card-body" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">CH 040 List of Devices</h4>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> </h4>
                                    <table id="datatable" class="table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> Device ID</th>
                                                <th> Device Type </th>
                                                <th> Description </th>
                                                <th> Date Created </th>
                                                <th class="actions" style="text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listofadevices as $sn => $data) { ?>
                                                <tr id="<?= $data['Id']; ?>">
                                                    <th><?= $sn+1; ?></th>
                                                    <td scope="row">
                                                        <?= $data['D_Id']; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?= $data['Comments']; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?= $data['Description']; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?= $data['Created']; ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <a href="<?= base_url("EN/schools/AddDevice/") . $data['Id'] ;?>" class="text-success font-size-20"><i class="uil uil-pen"></i></a>
                                                        <?php
                                                        $batches_forThis = $this->db->query("SELECT `Batch_Id` FROM `l2_batches` WHERE `For_Device` = '" . $data['Id'] . "' LIMIT 1 ")->num_rows();
                                                        if ($batches_forThis == 0) {
                                                        ?>
                                                            <i class="bx bxs-trash-alt delet" theId="<?= $data['Id'];  ?>"></i>
                                                        <?php } else { ?>
                                                            <i class="bx bxs-trash-alt delet_desabled"></i>
                                                        <?php } ?>
                                                        <?php /* <i class="bx bxs-comment-detail seebatches" onClick="getBtches(<?= $data['Id'];  ?>);" data-toggle="modal" data-target="#exampleModalScrollable" ></i> */ ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="">
                                    <div class="mt-4">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6">
                                                <!-- Scrollable modal -->
                                                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle"> Batches Enable/Disable </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" id="SetBatchesList">
                                                                <div class="spinner-border text-info m-1" role="status">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <script>
        $('.delet').each(function() {
            $(this).click(function() {
                var theId = $(this).attr('theId');
                console.log(theId);
                Swal.fire({
                    title: 'Do you want to delete this device?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Yes, I am sure!`,
                    icon: 'warning',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>EN/Schools/DeletDevice',
                            data: {
                                Conid: theId,
                            },
                            success: function(data) {
                                Swal.fire(
                                    'success',
                                    data,
                                    'success'
                                );
                                $('#' + theId).remove();
                            },
                            ajaxError: function() {
                                Swal.fire(
                                    'error',
                                    'oops!! we have a error',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });
        });
    </script>
    <!-- JAVASCRIPT -->
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $('input[type="checkbox"]').each(function() {
            $(this).change(function() {
                var theAdminId = $(this).attr('theAdminId');
                console.log(theAdminId);
                console.log(this.checked);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/Dashboard/changestatus',
                    data: {
                        adminid: theAdminId,
                    },
                    success: function(data) {
                        Swal.fire(
                            'success',
                            data,
                            'success'
                        )
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            });
        });
        function getBtches(id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Schools/ListofBatches',
                data: {
                    Deviceid: id,
                },
                beforeSend: function() {
                    $('#SetBatchesList').html('<div class="spinner-border text-info m-1" role="status"><span class="sr-only">Loading...</span></div>');
                },
                success: function(data) {
                    $('#SetBatchesList').html(data);
                },
                ajaxError: function() {
                    Swal.fire(
                        'error',
                        'oops!! we have a error',
                        'error'
                    )
                }
            });
        }
    </script>
</body>
</html>