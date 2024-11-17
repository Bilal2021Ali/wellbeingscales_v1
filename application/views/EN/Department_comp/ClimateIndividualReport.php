<link rel="stylesheet" type="text/css" href="<?= base_url('assets/libs/toastr/build/toastr.min.css') ?>">
<link rel="stylesheet" href="<?= base_url("assets/libs/owl.carousel/assets/owl.carousel.min.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/libs/owl.carousel/assets/owl.theme.default.min.css") ?>">
<style>
    input {
        outline: none;
    }

    .userdata {
        border-left: 1px solid #c5c5c5;
        margin-left: 2px;
        padding-left: 7px;
    }

    .container-fluid {
        margin-top: 0rem !important;
    }

    .col.text-center {
        font-size: 20px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <?php if (!isset($uid)) { ?>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Img</th>
                            <th>Name</th>
                            <th>UserType</th>
                            <th>Go</th>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $key => $user) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td class="text-center"><img class="avatar-sm rounded-circle" src="<?= base_url('uploads/co_avatars/') . ($user['Avatar'] !== "" ? $user['Avatar'] : 'default_avatar.jpg') ?>" alt=""></td>
                                    <td><?= $user['userName'] ?></td>
                                    <td><?= $user['UserType'] ?></td>
                                    <td><a href="<?= base_url('EN/Company_Departments/ClimateIndividualReport/' . $user['Id']) ?>" class="btn btn-primary">View<i class="uil uil-arrow-right"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>

                <h2 class="card-title" style="background: #FFA500;padding: 15px;color: #1E1E1E;border-radius: 4px;"> <img class="avatar-md rounded-circle" src="<?= base_url("uploads/co_avatars/") . ($full_user_data['Avatar'] !== "" ? $full_user_data['Avatar'] : 'default_avatar.jpg') ?>" alt=""> <span class="userdata"><?= $full_user_data['userName'] ?></span></h2>
                <div class="page-title-right">
                    <a href="<?= base_url("EN/Company_Departments/ClimateIndividualReport"); ?>" ></i></a>
                </div>
            
            <div class="card">
                <div class="card-body">
                    <!-- cards -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card" style="background: url('<?= base_url("assets/images/schoolDashboard/staff01.png") ?>');background-position: center;background-repeat: no-repeat;background-size: cover;border-color: #ffffff">
                                <div class="card-body">
                                    <div class="float-right mt-2">
                                        <img src="<?= base_url("assets/images/schoolDashboard/icons/staff.png") ?>" alt="Staff">
                                    </div>
                                    <div>
                                        <p class="mb-0 text-white">Steps</p>
                                        <h4 class="mb-1 mt-1 text-white"><span data-plugin="counterup" class="mt-2"><?= $results['Steps'] ?></span> Step</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="background: url('<?= base_url("assets/images/schoolDashboard/teacher02.png") ?>');background-position: center;background-repeat: no-repeat;background-size: cover;border-color: #ffffff">
                                <div class="card-body">
                                    <div class="float-right mt-2">
                                        <img src="<?= base_url("assets/images/schoolDashboard/icons/staff.png") ?>" alt="Staff">
                                    </div>
                                    <div>
                                        <p class="mb-0 text-white">Calories</p>
                                        <h4 class="mb-1 mt-1 text-white"><span data-plugin="counterup" class="mt-2"><?= $results['calories'] ?></span> Kcal</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="background: url('<?= base_url("assets/images/schoolDashboard/students03.png") ?>');background-position: center;background-repeat: no-repeat;background-size: cover;border-color: #ffffff">
                                <div class="card-body">
                                    <div class="float-right mt-2">
                                        <img src="<?= base_url("assets/images/schoolDashboard/icons/staff.png") ?>" alt="Staff">
                                    </div>
                                    <div>
                                        <p class="mb-0 text-white">Sleep</p>
                                        <h4 class="mb-1 mt-1 text-white"><span data-plugin="counterup" class="mt-2">24</span> Score</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body pt-3">
                            <div class="row">
	
                                <div class="col text-center"><h4>Weight</h4> <p><b><h4><?= $results['weight'] ?></h4></b></p>
                                </div>
                                <div class="col text-center"><h4>Height </h4><p><b><h4>100</h4></b></p>
                                </div>
                                <div class="col text-center"><h4>Goal </h4><p><b><h4>12</h4></b></p>
                                </div>
                            </div>
							<br><br><br><br><br>
                            <div class="col-12 text-center mt-3">
                                <div class="btn btn-rounded btn-info">
                                    Bla bla
                                </div>
                                <div class="btn btn-rounded btn-warning">
                                    Coach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><h4>Calorie Counter​:</h4></h3>
                            <div class="row">
                                <div class="col-4" style="display: grid;justify-items: center;justify-items: center;">
                                    <div style="height: 80px;">
                                        <p class="mb-0"><b><h4>Eaten</h4></b></p>
                                        <span><h4>1230 kcal</h4></span>
                                        <p class="mb-0 mt-1"><b><h4>Burned</h4></b></p>
                                        <span><h4>430 kcal</h4></span>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="text-center" dir="ltr">
                                        <input class="knob" data-readOnly="true" data-linecap="round" data-fgcolor="#f1b44c" value="35">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="spline_area" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php $this->load->view('EN/Department_comp/inc/climate_dashboard', ["nofilter" => true, "Carousel" => true, "userid" => $uid]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
            <script>
                var options = {
                    chart: {
                        height: 350,
                        type: 'area',
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                    },
                    series: [
                        <?php foreach ($climate_survyes as $climate_survye) {  ?>
                            <?php $answersHistory = array_column($this->db->select("scl_st_choices.mark AS mark")
                                ->from("scl_co_climate_answers")
                                ->join('scl_st_choices', 'scl_co_climate_answers.answer_id = `scl_st_choices`.`id` ')
                                ->where('scl_co_climate_answers.user_id',  $uid)
                                ->where('scl_co_climate_answers.climate_id',  $climate_survye['survey_id'])
                                ->get()->result_array(), "mark"); ?> {
                                name: '<?= $climate_survye['set_name_en'] ?>',
                                data: [<?= implode(',', $answersHistory)  ?>]
                            },
                        <?php } ?>
                    ],
                    colors: colors,
                    grid: {
                        borderColor: '#f1f1f1',
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#spline_area"),
                    options
                );

                chart.render();
            </script>
        <?php } ?>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url('assets/libs/jquery-knob/jquery.knob.min.js') ?>"></script>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js") ?>"></script>

<script>
    $('.table').DataTable();
    $('.climate_survyes_list').owlCarousel({
        items: 1,
        loop: false,
        margin: 0,
        nav: true,
        navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
        dots: false,
        responsive: {
            576: {
                items: 2
            },

            768: {
                items: 3
            },
            1200: {
                items: 3
            },
        }
    });
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    <?php if (isset($error)) { ?>
        Command: toastr["error"]("<?= $error ?>");
    <?php } ?>

    $(".knob").knob();
</script>