<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
</head>

<style>
.select2-container--default .select2-selection--single {
    height: 37px;
    padding-top: 3px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 35px;
    width: 31px;
}
.InfosCards h4, .InfosCards p {
    color: #fff;
}
.InfosCards .card-body {
    border-radius: 5px;
}
.InfosCards .card-body {
    border-radius: 5px;
}
.InfosCards .card {
    box-shadow: 11px 7px 20px 0px rgba(0, 0, 0, 0.44);
    transition: 0.2s all;
}
.InfosCards .card:hover {
    transform: scale(1.02);
    transition: 0.2s all;
}
.image_container img {
    margin: auto;
    width: 100%;
    max-width: 800px;
}
.active {
}
.btn-group .btn:not(.btn-secondary) {
    transform: translateX(-30px);
    margin-left: 10px;
    opacity: 0;
    transition: 0.2s all;
    display: none;
}
.btn-group.active .btn:not(.btn-secondary) {
    display: inline;
    transform: translateX(0px);
    margin-left: 0px;
    opacity: 1;
    transition: 0.2s all;
}
</style>

<body>
<div class="main-content">
  <div class="page-content">
    <div class="row">
      <div class="col-12">
        <div class="card"> <br>
          <div class="row image_container"> <img src="<?= base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools"> </div>
          <br>
        </div>
      </div>
    </div>
    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 013: إضافة جهاز جديد - قائمة الأجهزة</h4>
    <div class="row">
      <div class="col-md-3 col-xl-3 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #3df0f0;padding: 5px">
            <div class="card-body" style="background-color: #022326;">
              <div class="float-right mt-2"> 
                <!-- <div id="CharTTest1"></div>--> 
                <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px"> </div>
              <div>
                <?php
                $idd = $sessiondata[ 'admin_id' ];
                $all = $this->db->query( "SELECT * FROM `l2_devices` WHERE `Added_By` = $idd  " )->num_rows();
                $lasts = $this->db->query( "SELECT * FROM `l2_devices`  WHERE `Added_By` = $idd  ORDER BY Id DESC LIMIT 1 " )->result_array();
                ?>
                <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                  <?= $all ?>
                  </span></h4>
                <p class="mb-0"> عداد الأجهزة</p>
              </div>
              <?php if (!empty($lasts)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1">
                <?php foreach ($lasts as $last) { ?>
                <?= $last['Created'] ?>
                </span><br>
                آخر جهاز مسجل </p>
              <?php } ?>
              <?php } else { ?>
              <p class="mt-3 mb-0"><span class="mr-1">
                <?= "--/--/--" ?>
                </span><br>
                آخر جهاز مسجل </p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-3 col-xl-3 InfosCards">
        <div class="card-body" style="background-color: #ff26be;padding: 5px">
          <div class="card-body" style="background-color: #2e001f;">
            <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px"> </div>
            <div>
              <?php
              $allDevices = 0;
              $ListOfThisDevice;
              $All_added_Devices = $this->db->query( "SELECT * FROM `l2_devices`
                                WHERE `Added_By` = $idd AND `Comments` = 'Thermometer'  " )->result_array();
              foreach ( $All_added_Devices as $DevCr ) {
                  $allDevices++;
                  $ListOfThisDevice[] = $DevCr[ "Created" ];
              }
              ?>
              <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                <?= $allDevices ?>
                </span> </h4>
              <p class="mb-0"> عداد موازين الحرارة </p>
            </div>
            <?php if (!empty($ListOfThisDevice)) { ?>
            <p class="mt-3 mb-0"> <span class="mr-1">
              <?= $ListOfThisDevice[0] ?>
              </span><br>
              آخر ميزان حرارة تم تسجيله </p>
            <?php } else { ?>
            <p class="mt-3 mb-0"> <span class="mr-1">
              <?= "--/--/--"; ?>
              </span><br>
              آخر ميزان حرارة تم تسجيله</p>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-3 col-xl-3 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #ffd70d;padding: 5px">
            <div class="card-body" style="background-color: #262002;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px"> </div>
              <div>
                <?php
                $allDevices = 0;
                $ListOfThisDevice;
                $All_added_Devices_lab = $this->db->query( "SELECT * FROM `l2_devices`
               WHERE `Added_By` = $idd AND `Comments` = 'Lab'  " )->result_array();
                foreach ( $All_added_Devices_lab as $DevCr ) {
                    $allDevices++;
                    $ListOfThisDevicelab[] = $DevCr[ "Created" ];
                }
                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                  <?= $allDevices ?>
                  </span> </h4>
                <p class="mb-0">عداد أجهزة المختبر</p>
              </div>
              <?php if (!empty($ListOfThisDevicelab)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1">
                <?= $ListOfThisDevicelab[0] ?>
                </span><br>
                آخر جهاز معمل مسجل </p>
              <?php } else { ?>
              <p class="mt-3 mb-0"> <span class="mr-1">
                <?= "--/--/--"; ?>
                </span><br>
                آخر جهاز معمل مسجل </p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- end col-->
      <div class="col-md-3 col-xl-3 InfosCards">
        <div class="card">
          <div class="card-body" style="background-color: #3cf2a6;padding: 5px">
            <div class="card-body" style="background-color: #00261a;">
              <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/device.png" alt="schools" width="50px"> </div>
              <div>
                <?php
                $allDevicesGateway = 0;
                $ListOfThisDevice;
                $All_added_Devices_Gateway = $this->db->query( "SELECT * FROM `l2_devices`
                                    WHERE `Added_By` = $idd AND `Comments` = 'Gateway'  " )->result_array();
                foreach ( $All_added_Devices_Gateway as $DevGateway ) {
                    $allDevicesGateway++;
                    $ListOfThisDeviceGateway[] = $DevGateway[ "Created" ];
                }
                ?>
                <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                  <?= $allDevicesGateway ?>
                  </span> </h4>
                <p class="mb-0">عداد أجهزة البوابة</p>
              </div>
              <?php if (!empty($ListOfThisDeviceGateway)) { ?>
              <p class="mt-3 mb-0"><span class="mr-1">
                <?= $ListOfThisDeviceGateway[0] ?>
                </span><br>
                آخر جهاز بوابة مسجل </p>
              <?php } else { ?>
              <p class="mt-3 mb-0"> <span class="mr-1">
                <?= "--/--/--"; ?>
                </span><br>
                آخر جهاز بوابة مسجل </p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- end col--> 
    </div>
    <!-- end row-->
    <div class="row">
      <div class="col-xl-8">
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 017:
          <?= isset($device_data) ? "تحديث بيانات الجهاز" : "أضف أجهزة جديدة للمختبر وميزان الحرارة والبوابة" ?>
        </h4>
        <div class="custom-accordion">
          <div class="card"> <a href="#checkout-billinginfo-collapse" class="text-dark" data-toggle="collapse">
            <div class="p-4">
              <div class="media align-items-center">
                <div class="mr-3"> <i class="uil uil-receipt text-primary h2"></i> </div>
                <div class="media-body overflow-hidden">
                  <h5 class="font-size-16 mb-1">
                    <?= isset($device_data) ? "تعديل بيانات الجهاز" : "أضف جهازًا جديدًا" ?>
                  </h5>
                  <p class="text-muted text-truncate mb-0"></p>
                  <h3 id="Statusbox"></h3>
                </div>
                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i> </div>
            </div>
            </a>
            <form id="AddDevice">
              <div id="checkout-billinginfo-collapse" class="collapse show">
              <div class="p-4 border-top">
                <div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="Device_Id">عنوان MAC للجهاز</label>
                        <input id="input-ip" class="form-control input-mask" value="<?= $device_data["D_Id"] ?? "" ?>" placeholder="MAC address" data-inputmask="'alias': 'mac'" name="Device_Id" im-insert="true">
                      </div>
                      <span> <strong> ملاحظة: </strong> يجب أن يكون عنوان MAC فريدًا </span> </div>
                    <div class="col-lg-6">
                      <div class="form-group mb-4">
                        <label>نوع الجهاز</label>
                        <select name="Comments" class="form-control custom-select">
                          <option value="Lab" <?= isset($device_data["Comments"]) ? ($device_data["Comments"] == "Lab" ? "selected" : "") : "" ?>>مختبر</option>
                          <option value="Thermometer" <?= isset($device_data["Comments"]) ? ($device_data["Comments"] == "Thermometer" ? "selected" : "") : "" ?>>ثيرمومتر</option>
                          <option value="Gateway" <?= isset($device_data["Comments"]) ? ($device_data["Comments"] == "Gateway" ? "selected" : "") : "" ?>>بوابة</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-6">
                      <div class="form-group mb-4">
                        <label> مكان الموقع بالانجليزي </label>
                        <?php $r_sites = $this->db->query(" SELECT * FROM `l2_site` ")->result_array();?>
                        <select name="Site" class="form-control custom-select">
                          <?php foreach ($r_sites as $site) { ?>
                          <option value="<?= $site["Description"] ?>">
                          <?= $site["Description"] ?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                      <span> <strong> ملاحظة: </strong> لإضافة موقع ==> إضافة أعضاء => + موقع </span> </div>
                    <div class="col-lg-6">
                      <div class="form-group mb-4">
                        <label for="billing-name">وصف هذا الجهاز </label>
                        <input type="text" value="<?= $device_data['Description'] ?? ""; ?>" class="form-control" placeholder="وصف هذا الجهاز" name="Description_ar">
                      </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-lg-6">
                        <div class="form-group mb-4">
                          <label>موقع الجهاز بالعربي</label>
                          <select name="Site_ar" class="form-control custom-select">
                            <?php foreach ($r_sites as $site) { ?>
                            <option value="<?= $site["Description_ar"] ?>">
                            <?= $site["Description_ar"] ?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group mb-4">
                          <label for="billing-name">وصف الجهاز بالعربي</label>
                          <input type="text" class="form-control" placeholder="وصف الجهاز بالعربي" name="Description_ar">
                        </div>
                      </div>
                      <?php if (!empty($vehicles)) { ?>
                      <div class="col-6">
                        <label for="car_id">اختر المركبة:</label>
                        <select name="car_id" class="form-control" id="car_id">
                          <option value="0">بدون مركبة</option>
                          <?php foreach ($vehicles as $vehicle) { ?>
                          <option value="<?= $vehicle['Id'] ?>">
                          <?= $vehicle['No_vehicle'] ?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                      <?php } else { ?>
                      <input type="hidden" name="car_id" value="0">
                      <?php } ?>
                      <div class="col-<?= !empty($vehicles) ? "6" : "12" ?>">
                        <label for="device_type">نوع المركبة:</label>
                        <select name="device_type" class="form-control" id="device_type">
                          <?php foreach ($devices_types as $device_type) { ?>
                          <option value="<?= $device_type['Id'] ?>">
                          <?= $device_type['device_type_en'] ?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" style="padding: 10px;">
                  <div class="col"> <a href="<?= base_url(); ?>AR/schools/" class="btn btn-link text-muted"> <i class="uil uil-arrow-right mr-1"></i> إلغاء </a> </div>
                  <!-- end col -->
                  <div class="col">
                    <div class="text-sm-right mt-2 mt-sm-0">
                      <button type="reset" class="btn"> <i class="uil uil-reload mr-1"></i> إلغاء </button>
                      <button type="Submit" class="btn btn-success"> <i class="uil uil-save mr-1"></i> إضافة </button>
                    </div>
                  </div>
                  <!-- end col --> 
                </div>
              </div>
            </form>
          </div>
          <?php

          ?>
        </div>
      </div>
      <div class="col-xl-4">
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 018: قائمة الأجهزة المضافة / نوع الجهاز</h4>
        <div class="card">
          <div class="card-body">
            <div class="p-3 bg-light mb-4">
              <?php
              $alldev = $this->db->query( "SELECT * FROM l2_devices 
                                WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "' AND `UserType` = 'school' " )->result_array();
              $alldev_lab = $this->db->query( "SELECT * FROM l2_devices 
                                WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "' AND `UserType` = 'school' AND `Comments` = 'Lab' " )->result_array();
              $alldev_Thermometer = $this->db->query( "SELECT * FROM l2_devices 
                                WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "' AND `UserType` = 'school' AND `Comments` = 'Thermometer' " )->result_array();
              $alldev_Gateway = $this->db->query( "SELECT * FROM l2_devices 
                                WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "' AND `UserType` = 'school' AND `Comments` = 'Gateway' " )->result_array();
              ?>
              <h5 class="font-size-16 mb-0">قائمة الأجهزة<span class="float-right ml-2"> <a href="<?= base_url(); ?>AR/schools/ListofDevices">
                <?= sizeof($alldev); ?>
                </a> </span> </h5>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-selected="true"> <span class="d-block d-sm-none"><i class="fas fa-home"></i></span> <span class="d-none d-sm-block">مختبر</span> </a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile1" role="tab" aria-selected="false"> <span class="d-block d-sm-none"><i class="far fa-user"></i></span> <span class="d-none d-sm-block">ميزان الحرارة</span> </a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages1" role="tab" aria-selected="false"> <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span> <span class="d-none d-sm-block">بوابة</span> </a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
              <div class="tab-pane active" id="home1" role="tabpanel">
                <?php foreach ($alldev_lab as $device) : ?>
                <div class="btn-group mt-2 mr-1" style="width: 100%;">
                  <button type="button" class="btn btn-secondary waves-effect waves-light">
                  <?= $device['D_Id']; ?>
                  </button>
                </div>
                <?php endforeach; ?>
              </div>
              <div class="tab-pane" id="profile1" role="tabpanel">
                <?php foreach ($alldev_Thermometer as $device) : ?>
                <div class="btn-group mt-2 mr-1" style="width: 100%;">
                  <button type="button" class="btn btn-secondary waves-effect waves-light">
                  <?= $device['D_Id']; ?>
                  </button>
                </div>
                <?php endforeach; ?>
              </div>
              <div class="tab-pane" id="messages1" role="tabpanel">
                <?php foreach ($alldev_Gateway as $device) : ?>
                <div class="btn-group mt-2 mr-1" style="width: 100%;">
                  <button type="button" class="btn btn-secondary waves-effect waves-light">
                  <?= $device['D_Id']; ?>
                  </button>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
<script src="<?= base_url("assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"); ?>"></script>
<script>
    // $(".input-mask").inputmask();
    $("#AddDevice").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/startAddDevice',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#Statusbox').html(data);
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("oops!! لدينا خطأ");
            }
        });
    });

    $("#AddBatch").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/schools/startAddBatch',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#Statusbox').html(data);

            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("oops!! لدينا خطأ");
            }
        });
    });
</script>
</html>