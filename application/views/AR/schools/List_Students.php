<!doctype html>
<style>
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
    background-color: #ccc;
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

  .change-attendance-status {
    width: 25px;
    height: 25px;
    margin-bottom: 6px;
  }
</style>
<html lang="en">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
  .uil-trash {
    color: #DB0002;
    cursor: pointer;
  }

  .uil-credit-card {
    color: rgba(2, 110, 17, 1.00);
  }
</style>
<?php
$get_Classes = $this->db->query("SELECT DISTINCT `Class` FROM `l2_student` 
WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
$active = array_column($get_Classes, "Class");
$active_classes = array();
?>
<link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body class="light menu_light logo-white theme-white">
  <section class="content">
    <div class="main-content">
      <div class="page-content">
        <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 034 قائمة المراحل الدراسية</h4>
        <div class="row">
          <div class="col-md-6 col-xl-4 InfosCards">
            <div class="card">
              <div class="card-body" style="background-color: #2a3143;">
                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/staff.png" alt="schools" width="64px"> </div>
                <div>
                  <?php
                  $allStaff = $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                  $lastsStaff = $this->db->query("SELECT * FROM `l2_staff` ORDER BY Id DESC LIMIT 1 ")->result_array();
                  ?>
                  <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                      <?= $allStaff ?>
                    </span></h4>
                  <p class="mb-0">مجموع الموظفين</p>
                </div>
                <?php if (!empty($lastsStaff)) { ?>
                  <?php foreach ($lastsStaff as $lastStaff) { ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                        <?= $lastStaff['TimeStamp'] ?>
                      </span><br>
                      آخر موظف مضاف
                    <?php } ?>
                    </p>
                  <?php } else { ?>
                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                      Last Registered Staff </p>
                  <?php } ?>
              </div>
            </div>

          </div>
          <!-- end col-->
          <div class="col-md-6 col-xl-4 InfosCards">
            <div class="card">
              <div class="card-body" style="background-color: #8a1327;">
                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/teachers.png" alt="schools" width="64px"> </div>
                <div>
                  <?php
                  $all_Teachers = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                  $lasTeachers = $this->db->query("SELECT * FROM `l2_teacher` ORDER BY Id DESC LIMIT 1 ")->result_array();
                  ?>
                  <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                      <?= $all_Teachers ?>
                    </span> </h4>
                  <p class="mb-0">مجموع المعلمين</p>
                  </p>
                </div>
                <?php if (!empty($lasTeachers)) { ?>
                  <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php foreach ($lasTeachers as $Teachers) { ?>
                        <?= $Teachers['TimeStamp'] ?>
                    </span><br>
                    آخر معلم مضاف
                  <?php } ?>
                <?php } else { ?>
                  <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                    آخر معلم مضاف </p>
                <?php } ?>
              </div>
            </div>
          </div>
          <!-- end col-->

          <div class="col-md-6 col-xl-4 InfosCards">
            <div class="card">
              <div class="card-body" style="background-color: #123360;">
                <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/Students.png" alt="schools" width="64px"> </div>
                <div>
                  <?php
                  $allStudents = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                  $lastsStudents = $this->db->query("SELECT * FROM `l2_student` ORDER BY Id DESC LIMIT 1 ")->result_array();

                  ?>
                  <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                      <?= $allStudents ?>
                    </span></h4>
                  <p class="mb-0">مجموع الطلاب</p>
                </div>
                <?php if (!empty($lastsStudents)) { ?>
                  <?php foreach ($lastsStudents as $lastStudents) { ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                        <?= $lastStudents['TimeStamp'] ?>
                      </span><br>
                      آخر طالب مضاف
                    <?php } ?>
                    </p>
                  <?php } else { ?>
                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                      آخر طالب مضاف </p>
                  <?php } ?>
              </div>
            </div>
          </div>
          <!-- end col-->

        </div>
        <div class="row">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <label for="SelectFromClass">اختيار المرحلة الدراسية:</label>
                <select name="StudentClass" class="form-control" id="SelectFromClass">
                  <?php $ClassesList = $this->db->query("SELECT * FROM `r_levels`")->result_array(); ?>
                  <?php
                  $classes = $this->schoolHelper->getActiveSchoolClassesByStudents();
                  if (!empty($classes)) {
                  ?>
                    <option value="">اختيار المرحلة الدراسية</option>
                    <?php foreach ($classes as $class) { ?>
                      <option value="<?= $class['Id'] ?>">
                        <?= $class['Class']; ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>


          <!-- end col-->
          <?php /*?>
<div class="container-fluid">
    <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 035 Today’s Student Temperature Record</h4>
    <div class="card">
        <div class="card-body">
            <div id="hereGetedStudents">
                <h4 class="card-title mb-4">Select The Class</h4>
            </div>
        </div>
    </div>
    <!--end card-->
</div>
        <?php */ ?>
        </div>
        <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 036 تحرير وحذف وطباعة رمز QR للطلاب</h4>
        <div class="container-fluid" style="overflow: auto;">
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="javascript: void(0);">الطلاب</a></li>
              <li class="breadcrumb-item active">قائمة</li>
            </ol>
          </div>
          <div class="card">
            <div class="card-body" id="studentsList">
              <div class="w-100 text-center">لم يتم اختيار أي مرحلة دراسية</div>
            </div>
          </div>
          </table>
        </div>
      </div>
    </div>
  </section>
  <script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
  <!-- Datatable init js -->
  <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
  <!-- Datatable init js -->
  <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script>
  $(document).ready(function() {
    // Checkbox change event listener
    $('input[type="checkbox"]').on('change', handleCheckboxChange);

    // Flash message
    <?php if ($this->session->flashdata('email_sended')) { ?>
      displayFlashMessage();
    <?php } ?>

    // SelectFromClass change event listener
    $("#SelectFromClass").on('change', handleSelectFromClassChange);
  });

  function handleCheckboxChange() {
    var theAdminId = $(this).attr('theAdminId');
    console.log(theAdminId);
    console.log(this.checked);
    makeAjaxRequest('<?= base_url(); ?>AR/DashboardSystem/changeSchoolstatus', { adminid: theAdminId }, handleSchoolStatusChange);
  }

  function handleSchoolStatusChange(data) {
    Swal.fire('success', data, 'success');
  }

  function displayFlashMessage() {
    try {
      setTimeout(function() {
        $('.alert.alert-success').addClass('alert-hide');
        $('.container-fluid').css('margin-top', '0px');
      }, 3000);
    } catch (err) {}
  }

  function handleSelectFromClassChange() {
    var selectedClass = $(this).children("option:selected").val();
    makeAjaxRequest('<?= base_url(config_item("env")["INDEX_PAGE"] . "/AR/Schools/ListofStudentsForThisClass"); ?>', { NumberOfClass: selectedClass }, updateStudentsList);
  }

  function updateChart(data) {
    $('#hereGetedStudents').html(data);
  }

  function updateStudentsList(data) {
    $('#studentsList').html(data);
  }

  function makeAjaxRequest(url, data, onSuccess) {
    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      beforeSend: function() {
        // setting a timeout
        $("#hereGetedStudents").html('إنتظر من فضلك');
      },
      success: onSuccess,
      error: function() {
        Swal.fire('error', 'oops!! لدينا خطأ', 'error');
      }
    });
  }
</script>

</body>

</html>