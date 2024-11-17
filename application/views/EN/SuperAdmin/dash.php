<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php
echo base_url();
?>aassets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<title>Super Admin</title>
<style>
.InfosCards h4, .InfosCards p {
    color: #fff;
}
.InfosCards .card-body {
    border-radius: 5px;
}
</style>
</head>
<body>
<div class="main-content">
  <div class="page-content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-xl-4 InfosCards">
                <div class="card">
                  <div class="card-body" style="background-color: #541039;">
                    <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/oefgcounter.png" alt="schools" width="100px"> </div>
                    <div>
                      <?php
                      $all = $this->db->query( "SELECT * FROM `l0_organization` " )->num_rows();
                      $lasts = $this->db->query( "SELECT * FROM `l0_organization` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                        <?= $all ?>
                        </span></h4>
                      <p class="mb-0">Organizations</p>
                    </div>
                    <?php
                    if ( !empty( $lasts ) ) {
                        ?>
                    <?php
                    foreach ( $lasts as $last ) {
                        ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?= $last['Created'] ?>
                      </span><br>
                      Last registered organization
                      <?php
                      }
                      ?>
                    </p>
                    <?php
                    } else {
                        ?>
                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                      Last registered organization </p>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <!-- end col-->
              <div class="col-md-6 col-xl-4 InfosCards">
                <div class="card">
                  <div class="card-body" style="background-color: #2e4962;">
                    <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/orgministry.png" alt="schools" width="100px"> </div>
                    <div>
                      <?php
                      $all_ministry = $this->db->query( "SELECT * FROM `l0_organization`
                                             WHERE Type = 'Ministry' " )->num_rows();
                      $lastminED = $this->db->query( "SELECT * FROM `l0_organization` WHERE Type = 'Ministry' ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_ministry ?>
                        </span> </h4>
                      <p class="mb-0">Ministry of Education</p>
                    </div>
                    <?php
                    if ( !empty( $lastminED ) ) {
                        ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php
                      foreach ( $lastminED as $last ) {
                          ?>
                      <?= $last['Created'] ?>
                      </span><br>
                      Last registered ministry of education
                      <?php
                      }
                      ?>
                      <?php
                      } else {
                          ?>
                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                      Last registered ministry of education </p>
                    <?php
                    }
                    ?>
                    </p>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-md-6 col-xl-4 InfosCards">
                <div class="card">
                  <div class="card-body" style="background-color: #3f3836;">
                    <div class="float-right mt-2"> <img src="<?= base_url(); ?>assets/images/icons/png_icons/countercompany.png" alt="" width="100px"> </div>
                    <div>
                      <?php
                      $all_Companies = $this->db->query( "SELECT * FROM `l0_organization`
                                             WHERE Type = 'Company' " )->num_rows();
                      $lasCompanies = $this->db->query( "SELECT * FROM `l0_organization` WHERE Type = 'Company' ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_Companies ?>
                        </span> </h4>
                      <p class="mb-0">Company</p>
                      </p>
                    </div>
                    <?php
                    if ( !empty( $lasCompanies ) ) {
                        ?>
                    <p class="mt-3 mb-0"><span class="mr-1" style="color: #e1da6a;">
                      <?php
                      foreach ( $lasCompanies as $Companies ) {
                          ?>
                      <?= $Companies['Created'] ?>
                      </span><br>
                      Last registered company
                      <?php
                      }
                      ?>
                      <?php
                      } else {
                          ?>
                    <p class="mt-3 mb-0"> <span class="mr-1" style="color: #e1da6a;"> --/--/-- </span><br>
                      Last registered company </p>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <!-- end col--> 
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-xl-2 InfosCards">
                <div class="card">
                  <div class="card-body d-flex align-items-center justify-content-center" style="background-color: #3f3836;">
                    <div class="mr-2"> <img src="<?= base_url(); ?>assets/images/icons/superadmin/department.png" alt="" width="50px"> </div>
                    <div>
                      <?php
                      $allDepartment = $this->db->query( "SELECT * FROM `l1_department` " )->num_rows();
                      $lastsDepartment = $this->db->query( "SELECT * FROM `l1_department` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $allDepartment ?>
                        </span> </h4>
                      <p class="mb-0">Department</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col-->
              <div class="col-md-6 col-xl-2 InfosCards">
                <div class="card">
                  <div class="card-body d-flex align-items-center justify-content-center" style="background-color: #3f3836;">
                    <div class="mr-2"> <img src="<?= base_url(); ?>assets/images/icons/superadmin/classroom.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $allSchools = $this->db->query( "SELECT * FROM `l1_school`" )->num_rows();
                      $lastsSchools = $this->db->query( "SELECT * FROM `l1_school` ORDER BY Id DESC LIMIT 1" )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                        <?= $allSchools ?>
                        </span></h4>
                      <p class="mb-0">School</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col-->
              
              <div class="col-md-6 col-xl-2 InfosCards">
                <div class="card">
                  <div class="card-body d-flex align-items-center justify-content-center" style="background-color: #3f3836;">
                    <div class="mr-2"> <img src="<?= base_url(); ?>assets/images/icons/superadmin/team.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $all_Users = $this->db->query( "SELECT * FROM `l2_co_patient` " )->num_rows();
                      $lastsUsers = $this->db->query( "SELECT * FROM `l2_co_patient` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_Users ?>
                        </span> </h4>
                      <p class="mb-0">Company User</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col-->
              
              <div class="col-md-6 col-xl-2 InfosCards">
                <div class="card">
                  <div class="card-body" style="background-color: #2e4962;">
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="mr-2"> <img src="<?= base_url(); ?>assets/images/icons/superadmin/teacher.png" alt="" width="50px"> </div>
                      <div>
                        <?php
                        $all_Teachers = $this->db->query( "SELECT * FROM `l2_teacher`" )->num_rows();
                        $lasTeachers = $this->db->query( "SELECT * FROM `l2_teacher` ORDER BY Id DESC LIMIT 1 " )->result_array();
                        ?>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                          <?= $all_Teachers ?>
                          </span></h4>
                        <p class="mb-0">Teacher</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col-->
              
              <div class="col-md-6 col-xl-2 InfosCards">
                <div class="card">
                  <div class="card-body" style="background-color: #2e4962;">
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="mr-2"> <img src="<?= base_url(); ?>assets/images/icons/superadmin/lecturer.png" alt="" width="50px"> </div>
                      <div>
                        <?php
                        $allStudents = $this->db->query( "SELECT * FROM `l2_student`" )->num_rows();
                        $lastsStudents = $this->db->query( "SELECT * FROM `l2_student` ORDER BY Id DESC LIMIT 1 " )->result_array();
                        ?>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                          <?= $allStudents ?>
                          </span></h4>
                        <p class="mb-0">Student</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col-->
              
              <div class="col-md-6 col-xl-2 InfosCards">
                <div class="card">
                  <div class="card-body" style="background-color: #2e4962;">
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="mr-2"> <img src="<?= base_url(); ?>assets/images/icons/superadmin/staff.png" alt="" width="50px"> </div>
                      <div>
                        <?php
                        $allStaff = $this->db->query( "SELECT * FROM `l2_staff`" )->num_rows();
                        $lastsStaff = $this->db->query( "SELECT * FROM `l2_staff` ORDER BY Id DESC LIMIT 1 " )->result_array();
                        ?>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                          <?= $allStaff ?>
                          </span></h4>
                        <p class="mb-0">Staff</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col--> 
              
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Total Ministry, School, Company and Department</h4>
                    <div class="mt-1">
                      <ul class="list-inline main-chart mb-0 d-flex justify-content-center flex-wrap">
                        <li class="list-inline-item chart-border-left mr-0 border-0 mb-4">
                          <h3 class="text-primary"><span data-plugin="counterup">
                            <?= $all_ministry ?>
                            </span><span class="text-muted d-inline-block font-size-15 ml-3">Ministry</span></h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0 border-0 mb-4">
                          <h3 class="text-primary"><span data-plugin="counterup">
                            <?= $allSchools ?>
                            </span><span class="text-muted d-inline-block font-size-15 ml-3">School</span></h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0 border-0 mb-4">
                          <h3 class="text-primary"><span data-plugin="counterup">
                            <?= $all_Companies ?>
                            </span><span class="text-muted d-inline-block font-size-15 ml-3">Company</span></h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0 border-0 mb-4">
                          <h3 class="text-primary"><span data-plugin="counterup">
                            <?= $allDepartment ?>
                            </span><span class="text-muted d-inline-block font-size-15 ml-3">Department</span></h3>
                        </li>
                      </ul>
                    </div>
                    <div class="mt-3">
                      <div id="schools-ministries-chart" class="apex-charts" dir="ltr"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/superadmin/team.png" alt="schools" width="50px"></div>
                    <div>
                      <?php
                      $allSurveys = $this->db->query( "SELECT * FROM `sv_st_surveys` " )->num_rows();
                      $lastsSurveys = $this->db->query( "SELECT * FROM `sv_st_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                        <?= $allSurveys ?>
                        </span></h4>
                      <p class="mb-0">Super Admin Survey</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- end col-->
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="" width="50px"> </div>
                    <div>
                      <?php
    $all_Active = $this->db->query("SELECT * FROM `sv_st_surveys` WHERE targeted_type = 'M'")->num_rows();
    $lastsActive = $this->db->query("SELECT * FROM `sv_st_surveys` WHERE targeted_type = 'M' ORDER BY Id DESC LIMIT 1")->row_array();
?>

                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_Active ?>
                        </span> </h4>
                      <p class="mb-0">Ministry Survey</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $all_Active = $this->db->query( "SELECT * FROM `sv_st_surveys`  WHERE targeted_type = 'C' " )->num_rows();
                      $lastsActive = $this->db->query( "SELECT * FROM `sv_st_surveys` WHERE targeted_type = 'C' ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_Active ?>
                        </span> </h4>
                      <p class="mb-0">Company Survey</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="" width="50px"> </div>
                    <div>
                      <?php
                      $all_sv_school = $this->db->query( "SELECT * FROM `sv_school_published_surveys` " )->num_rows();
                      $lastsv_school = $this->db->query( "SELECT * FROM `sv_school_published_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_sv_school ?>
                        </span> </h4>
                      <p class="mb-0">School Survey </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $all_sv_school = $this->db->query( "SELECT * FROM `sv_co_published_surveys` " )->num_rows();
                      $lastsv_school = $this->db->query( "SELECT * FROM `sv_co_published_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_sv_school ?>
                        </span> </h4>
                      <p class="mb-0">Department Survey</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col--> 
			  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $all_sv_school = $this->db->query( "SELECT * FROM `sv_co_published_surveys` " )->num_rows();
                      $lastsv_school = $this->db->query( "SELECT * FROM `sv_co_published_surveys` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_sv_school ?>
                        </span> </h4>
                      <p class="mb-0">Department Survey</p>
                    </div>
                  </div>
                </div>
              </div>
			  
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/superadmin/organizations.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $allSurveys = $this->db->query( "SELECT * FROM `scl_st0_climate` " )->num_rows();
                      $lastsSurveys = $this->db->query( "SELECT * FROM `scl_st0_climate` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"><span data-plugin="counterup">
                        <?= $allSurveys ?>
                        </span></h4>
                      <p class="mb-0">Super Admin Climate</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="" width="50px"> </div>
                    <div>
                      <?php
                      $all_Active = $this->db->query( "SELECT * FROM `scl_st0_climate` WHERE targeted_type = 'M'  " )->num_rows();
                      $lastsActive = $this->db->query( "SELECT * FROM `scl_st0_climate` WHERE targeted_type = 'M' ORDER BY Id DESC LIMIT 1  " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_Active ?>
                        </span> </h4>
                      <p class="mb-0">Ministry Climate</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $all_Active = $this->db->query( "SELECT * FROM `scl_st0_climate` WHERE targeted_type = 'C'  " )->num_rows();
                      $lastsActive = $this->db->query( "SELECT * FROM `scl_st0_climate` WHERE targeted_type = 'C' ORDER BY Id DESC LIMIT 1  " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_Active ?>
                        </span> </h4>
                      <p class="mb-0">Company Climate</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterschools.png" alt="" width="50px"> </div>
                    <div>
                      <?php
                      
					  $all_sv_school = $this->db->query( "SELECT * FROM `scl_st_climate` " )->num_rows();
                      $lastsv_school = $this->db->query( "SELECT * FROM `scl_st_climate` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_sv_school ?>
                        </span> </h4>
                      <p class="mb-0">School Climate </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col-->
              
              <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 InfosCards">
                <div class="card">
                  <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #2e4962;">
                    <div class="mr-2"><img src="<?= base_url(); ?>assets/images/icons/png_icons/counterdepartments.png" alt="schools" width="50px"> </div>
                    <div>
                      <?php
                      $all_sv_school = $this->db->query( "SELECT * FROM `scl_st_co_climate` " )->num_rows();
                      $lastsv_school = $this->db->query( "SELECT * FROM `scl_st_co_climate` ORDER BY Id DESC LIMIT 1 " )->result_array();
                      ?>
                      <h4 class="mb-1 mt-1"> <span data-plugin="counterup">
                        <?= $all_sv_school ?>
                        </span> </h4>
                      <p class="mb-0">Department Survey </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end col--> 
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<script>
    var options = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        series: [{
                name: "Company",
                data: [<?= $all_Companies ?>]
            },
            {
                name: "Department",
                data: [<?= $allDepartment ?>]
            },
            {
                name: "Ministry",
                data: [<?= $all_ministry ?>]
            },
            {
				name: "School",
                data: [<?= $allSchools ?>]
            },
        ],
        colors: ['#34c38f', "#5b73e8", "#f1b44c", "#74788d"],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: ["Company", "Department", "Ministry", "School"],
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#schools-ministries-chart"),
        options
    );
    chart.render();
    var myoptions = {
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 20, 36, 40, 54]
        }],
        fill: {
            colors: ["#FFF56B"]
        },
        chart: {
            type: "bar",
            width: 70,
            height: 40,
            sparkline: {
                enabled: !0
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "50%"
            }
        },
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            }
        },
        tooltip: {
            fixed: {
                enabled: !1
            },
            x: {
                show: !1
            },
            y: {
                title: {
                    formatter: function(e) {
                        return ""
                    }
                }
            },
            marker: {
                show: !1
            }
        }
    }
    chart1 = new ApexCharts(document.querySelector("#CharTTest1"), myoptions);
    chart1.render();
    var options = {
        fill: {
            colors: ["#34c38f"]
        },
        series: [70],
        chart: {
            type: "radialBar",
            width: 45,
            height: 45,
            sparkline: {
                enabled: !0
            }
        },
        dataLabels: {
            enabled: !1
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "60%"
                },
                track: {
                    margin: 0
                },
                dataLabels: {
                    show: !1
                }
            }
        }
    }
</script>
</html>