<style>
.InfosCards h4, 
.InfosCards p {
    color: #fff;
}
.InfosCards .card-body {
    border-radius: 5px;
}
.dropdown-item {
    cursor: pointer;
}
.apexcharts-legend-text {
    margin: 5px;
}
.image_container img {
    margin: auto;
    width: 100%;
    max-width: 800px;
}
   .metismenu li {
        border-radius: 50px;
        ackground: rgb(116, 83, 163);
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        color: #fff;
        margin-bottom: 10px;
        display: block;
        width: 100%;
        border: 5px solid #ebebeb;
    }

    #userschart, .labtest-chart {
        min-height: 350px !important;
    }	 
</style>
	<script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>	
<div class="main-content">
  <div class="page-content"> <br>
    <br/>
    <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> MOE 001 - لوحة المتابعة اليومية للمدارس والأقسام</h4>
    <div class="row">
            <?php foreach ($cards as $card) { ?>
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #<?= $card['bg_color'] ?>;">
                            <div class="float-right mt-2">
                                <img src="<?= base_url(); ?>assets/images/icons/png_icons/<?= $card['icons'] ?>" alt="<?= $card['Title'] ?>">
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $card['Data']['allCounter'] ?? '--' ?></span></h4>
														  
							
							  
                                <p class="mb-0"><?= $card['Title'] ?></p>
				  
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #ffffff;">
                                    <span><?= $card['Data']['LastAdded'] ?? '--/--/--' ?></span><br>
						 
                                    <?= $card['last_title'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php if ($temperatureandlabs) { ?>
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 002 - نتائج الفحوصات المخبرية</h4>
      </div>
    </div>
    <?php } ?>
    <div class="row">
      <?php if ($temperatureandlabs) { ?>
      <div class="col-xl-<?= $temperatureandlabs ? "9" : "12" ?>">
        <div class="row">
          <div class="col-lg-12">
            <div class="card" style="position: relative;min-height: 490px;">
              <div class="card-body">
                <h4 class="card-title mb-4">لوحة البيانات اليومية - نتائج الفحوصات المخبرية:
                  <?= $today; ?>
                </h4>
                <div id="chart"></div>
                <div class="col-lg-12 text-center">
                  <p>(طلاب- موظفين - معلمين )</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if ($temperatureandlabs) { ?>
      <div class="<?= $temperatureandlabs ? "col-xl-3" : "row w-100" ?>">
        <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
          <div class="card">
            <div class="card-body" style="padding: 0px;border: 6px solid #387cea;">
              <div class="card-body badge-soft-info">
                <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Blue.png" alt="Temperature" style="width: 30px;margin-top: -12px;"> </div>
                <div class="col-lg-10">
                  <h4 class="mb-1 mt-1" style="color: #033067;"> <span data-plugin="counterup">
                    <?= $tempresults['LOW'] ?>
                    </span> </h4>
                  <p class="mb-0" style="color: #033067;"> حرارة منخفضة </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center alerts_count">
          <div class="card">
            <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
              <div class="card-body badge-soft-success">
                <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;"> </div>
                <div class="col-xl-10">
                  <h4 class="mb-1 mt-1" style="color: #044300;"><span data-plugin="counterup">
                    <?= $tempresults['NORMAL']; ?>
                    </span></h4>
                  <p class="mb-0" style="color: #044300;"> حرارة طبيعية </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
          <div class="card">
            <div class="card-body" style="padding: 0px;border: 6px solid #FF9600;">
              <div class="card-body badge-soft-warning">
                <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/orange.png" alt="Temperature" style="width: 30px;"> </div>
                <div class="col-xl-10">
                  <h4 class="mb-1 mt-1" style="color: #674403;"> <span data-plugin="counterup">
                    <?= $tempresults['MODERATE'] ?>
                    </span> </h4>
                  <p class="mb-0" style="color: #674403;"> حرارة معتدلة</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
          <div class="card">
            <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
              <div class="card-body badge-soft-danger">
                <div class="float-left mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/red.png" alt="Temperature" style="width: 30px;"> </div>
                <div class="col-xl-10">
                  <h4 class="mb-1 mt-1"> <span data-plugin="counterup" style="color: #670303;">
                    <?= $tempresults['HIGH'] ?>
                    </span> </h4>
                  <p class="mb-0" style="color: #670303;"> حرارة مرتفعة </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 003 - الحجر المنزلي (الحرارة)</h4>
      </div>
      <div class="col-xl-12">
        <div class="row">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title mb-4">
                  <div class="float-right">
                    <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted" data-toggle="modal" data-target="#myModal">إختر الإختبار <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                        <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');"> الحرارة </li>
                        <?php foreach ($list_Tests as $test) { ?>
                        <li class="dropdown-item" onClick="home_labTests('<?= $test['Test_Desc']; ?>');">
                          <?= $test['Test_Desc']; ?>
                        </li>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  الحجر المنزلي (<span id="STAYHOMESHOWTESTNAME">الحرارة</span>) </h4>
                <div data-simplebar style="height: 385px;overflow: auto;">
                  <div id="simpl_home_list">
                    <table class="table Table_Data" style="column-width: auto;">
                      <thead>
                      <th class="Img_School" style="width: 10%;" width="5%">الصورة</th>
                        <th width="30%">إسم المدرسة</th>
                        <th style="color: #cdfc00;width: 10%;" width="10%;">منخفض</th>
                        <th class="Risk" style="color: #00ab00;" width="10%;">طبيعي</th>
                        <th style="color: #ff8200;width: 10%;" width="10%;">معتدل</th>
                        <th style="color: #ff2e00;width: 10%;" width="10%;">عالي</th>
                        <th style="color: #0F0F0F;width: 10%;" width="10%;">قراءة خاطئة</th>
                        <th style="color: #50a5f1;width: 10%;" width="10%;">المجموع</th>
                          </thead>
                      <tbody>
                        <?php foreach ($schools_h as $school) { ?>
                        <tr>
                          <td><img src="<?= base_url("uploads/avatars/".($school['avatar'] ?? "default_avatar.jpg")) ?>" class="avatar-xs rounded-circle " alt="غير قادر على تحميل الصورة"></td>
                          <td><?= $school['School_Name'] ?></td>
                          <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">
                            <?= $school['low'] ?>
                            </span></td>
                          <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">
                            <?= $school['normal'] ?>
                            </span></td>
                          <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">
                            <?= $school['moderate'] ?>
                            </span></td>
                          <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">
                            <?= $school['high'] ?>
                            </span></td>
                          <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">
                            <?= $school['error'] ?>
                            </span></td>
                          <td style="text-align: right;"><span class="badge badge-info font-size-12" style="width: 100%;">
                            <?= $school['total'] ?>
                            </span></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div id="New_home_List"> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> MOE 004 - الحجر الصحي (الحرارة)</h4>
      </div>
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">
              <div class="float-right">
                <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted" data-toggle="modal" data-target="#myModal">إختر الإختبار<i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                    <li class="dropdown-item" onclick="Tempratur_List('#simpl_Quaran_list','#New_Quaran_List');"> الحرارة </li>
                    <?php foreach ($list_Tests as $test) { ?>
                    <li class="dropdown-item" onClick="quarnt_labTests('<?= $test['Test_Desc']; ?>');">
                      <?= $test['Test_Desc']; ?>
                    </li>
                    <?php } ?>
                  </div>
                </div>
              </div>
              الحجر الصحي (<span id="SQUAROMESHOWTESTNAME"> الحرارة</span>) </h4>
            <div data-simplebar style="height: 385px;overflow: auto;">
              <div id="simpl_Quaran_list">
                <table class="table Table_Data" style="column-width: auto;">
                  <thead>
                  <th class="Img_School" style="width: 10%;" width="5%">الصورة</th>
                    <th width="30%">إسم المدرسة</th>
                    <th style="color: #cdfc00;width: 10%;" width="10%;">منخفض</th>
                    <th class="Risk" style="color: #00ab00;" width="10%;">طبيعي</th>
                    <th style="color: #ff8200;width: 10%;" width="10%;">معتدل</th>
                    <th style="color: #ff2e00;width: 10%;" width="10%;">عالي</th>
                    <th style="color: #0F0F0F;width: 10%;" width="10%;">قراءة خاطئة</th>
                    <th style="color: #50a5f1;width: 10%;" width="10%;">المجموع</th>
                      </thead>
                  <tbody>
                    <?php foreach ($schools_h as $school) { ?>
                    <tr>
                      <td><img src="<?= base_url("uploads/avatars/".($school['avatar'] ?? "default_avatar.jpg")) ?>" class="avatar-xs rounded-circle " alt="غير قادر على تحميل الصورة"></td>
                      <td><?= $school['School_Name'] ?></td>
                      <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">
                        <?= $school['low'] ?>
                        </span></td>
                      <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">
                        <?= $school['normal'] ?>
                        </span></td>
                      <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">
                        <?= $school['moderate'] ?>
                        </span></td>
                      <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">
                        <?= $school['high'] ?>
                        </span></td>
                      <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">
                        <?= $school['error'] ?>
                        </span></td>
                      <td style="text-align: right;"><span class="badge badge-info font-size-12" style="width: 100%;">
                        <?= $school['total'] ?>
                        </span></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div id="New_Quaran_List"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6">
        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 005 - الحجر المنزلي</h4>
        <div class="card" style="border-color: #0eacd8;">
          <div class="card-body" style="min-height: 465px;text-align: center;background: radial-gradient(rgb(14 172 216 / 18%), rgb(14 172 216 / 39%));">
            <h5 class="m-0"> <span style="color:#0eacd8;text-align:center;"> الحجر المنزلي </span> </h5>
            <?php if (!empty($schools_h)) { ?>
            <table style="width: 100%;">
              <?php foreach ($schools_h as $schools_high) { ?>
              <tr>
                <td style="text-align: right;" class="text-truncate"><?= $schools_high['School_Name']; ?></td>
                <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">
                  <?= $schools_high['total']; ?>
                  </span></td>
              </tr>
              <?php } ?>
            </table>
            <?php } else { ?>
            <div style="min-height: 409px;display: grid;align-content: center;align-items: center;">
              <div class="text-center">
                <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                <p class="font-16 text-muted mb-2"></p>
                <h5><a href="#" class="text-dark"> لا يوجد بيانات </a></h5>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-xl-6">
        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MOE 006 - الحجر الصحي</h4>
        <div class="card" style="border-color: #F44336;">
          <div class="card-body" style="min-height: 465px;text-align: center;background: radial-gradient(rgb(216 14 14 / 18%), rgb(247 204 204 / 39%));">
            <h5 class="m-0"> <span style="color:#ff2e00;text-align:center;"> الحجر الصحي </h5>
            <?php if (!empty($schools_q)) { ?>
            <table style="width: 100%;">
              <?php foreach ($schools_q as $schools_high_q) { ?>
              <tr>
                <td style="text-align: right;" class="text-truncate"><?= $schools_high_q['School_Name']; ?></td>
                <td><span class="badge font-size-12" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">
                  <?= $schools_high_q['total']; ?>
                  </span></td>
              </tr>
              <?php } ?>
            </table>
            <?php } else { ?>
            <div style="min-height: 409;display: grid;align-content: center;align-items: center;">
              <div class="text-center">
                <div class="avatar-sm mx-auto mb-4"> <span class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i class="mdi mdi-Shield-Alert text-primary"></i> </span> </div>
                <p class="font-16 text-muted mb-2"></p>
                <h5><a href="#" class="text-dark"> لا يوجد بيانات</a></h5>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between"> </div>
        <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> MOE 007 - قائمة المواقع</h4>
      </div>
      <div class="col-lg-12" style="padding-right: 0px;">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-4">
                <div class="float-right">
                  <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted">إختر الإختبار <i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                      <?php foreach ($list_Tests as $test) { ?>
                      <li class="dropdown-item" onClick="sites_lab('<?= $test['Test_Desc']; ?>');">
                        <?= $test['Test_Desc']; ?>
                      </li>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                قائمة المواقع (<span id="sites_showType">--</span>) </h4>
              <div id="">
                <table class="table Table_Data" style="width: 100%;">
                  <thead>
                  <th>#</th>
                    <th class="text-center">اسم الموقع </th>
                    <th class="text-center">إيجابي</th>
                    <th class="text-center">سلبي</th>
                    <th class="text-center">التعقيم</th>
                      </thead>
                  <tbody id="table_sites_data">
                  </tbody>
                </table>
              </div>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
   <?php /*?> <?php $this->load->view('AR/Ministry/inc/climate_dashboard')  ?><?php */?>
  </div>
</div>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script> 
<script>
    $('.Table_Data').DataTable();
    var Chart_Options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: !0,
            formatter: function(e) {
                return e
            },
            offsetY: -20,
            style: {
                fontSize: "12px",
                colors: ["#FFFFFF"]
            }
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "    All   ",
            data: [<?= implode(',', array_column($labresults['all'], "result")) ?>]
        }, {
            name: "   Negative      ",
            data: [<?= implode(',', array_column($labresults['Negative'], "result")) ?>]
        }, {
            name: "    Positive   ",
            data: [<?= implode(',', array_column($labresults['Positive'], "result")) ?>]
        }],
        colors: ["#5b73e8", "#34c38f", "#C3343C"],
        xaxis: {
            categories: [<?= implode(',', array_column($labresults['all'], "Test")) ?>]
        },
        yaxis: {
            title: {
                text: "all tests"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(e) {
                    if (e >= 1000) {
                        var th = e.slice(0, 1);
                        return th + "thousnd"
                    } else {
                        return e
                    }
                }
            }
        }
    };
    chart = new ApexCharts(document.querySelector("#chart"), Chart_Options);
    chart.render();


    function Tempratur_List(id, emp) {
        if (id == '#simpl_home_list' && emp == '#New_home_List') {
            $('#STAYHOMESHOWTESTNAME').html('TEMPERATURE');
        } else if (id == '#simpl_quarantin_list' && emp == '.New_quarantin_List') {
            $('#STAYQuarantineNOSHOWTESTNAME').html('TEMPERATURE ');
        } else if (id == '#simpl_staff_list' && emp == '#New_Staff_List') {
            $('#STAFFSNOSHOWTESTNAME').html('TEMPERATURE ');
        } else if (id == '#simpl_Teacher_list' && emp == '#New_Teacher_List') {
            $('#TEACHERSSNOSHOWTESTNAME').html('TEMPERATURE ');
        }
        $(id).slideDown();
        $(emp).html('');
    }

    function home_labTests(type) {
        $('#STAYHOMESHOWTESTNAME').html(type);
        $('#simpl_home_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/ajax/Get_home_List_Ministry',
            data: {
                IN: 'Home',
                TestDesc: type,
            },
            success: function(data) {
                $('#New_home_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
    }

    function quarnt_labTests(type) {
        $('#SQUAROMESHOWTESTNAME').html(type);
        $('#simpl_Quaran_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/ajax/Get_home_List_Ministry',
            data: {
                IN: 'Home',
                TestDesc: type,
            },
            success: function(data) {
                $('#New_Quaran_List').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
    }

    function sites_lab(type) {
        $('#sites_showType').html(type);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>AR/ajax/sites_data_table',
            data: {
                TestName: type,
            },
            success: function(data) {
                $('#table_sites_data').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
    }
</script>