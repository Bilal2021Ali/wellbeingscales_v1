<?php $counter_of_published_surveys = $this->db->query("SELECT Id FROM `sv_school_published_surveys` 
WHERE `By_school` = '" . $sessiondata['admin_id'] . "'  ")->num_rows(); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/libs/owl.carousel/assets/owl.carousel.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.enjoyhint.css'); ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/kineticjs/5.2.0/kinetic.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/libs/owl.carousel/assets/owl.theme.default.min.css'); ?>">
<style>
    .font-size-70 {
        font-size: 70px;
        margin-bottom: 10px;
        display: block;
    }

    .count_in_list {
        width: 120px !important;
        height: 120px !important;
        margin: auto;
    }

    .firstCard * {
        color: #fff;
    }

    .firstCard.card-body {
        border-radius: 5px
    }

    .firstCard .uil-arrow-right {
        margin-left: 10px;
        transition: 0.2s all;
    }

    img.ic_img {
        width: 60px;
        margin-bottom: 20px;
    }

    .ontypecard .col-lg-3 .card-body * {
        color: #fff;
        cursor: default;
    }

    .ontypecard .col-lg-3 .card-body {
        border-radius: 5px;
    }
</style>
<?php
// creating array of counters 
$levels = array();
$accepted_foreach = array();
$simple_levels_names_arr = array();

foreach ($avalaible_types_of_classes as $cl_id => $class) {
    $levels[$class['name']] = 0;
    $simple_levels_names_arr[] = $class['name'];
    $accepted_foreach[$class['name']] = explode(";", $class['Classes']);
}

foreach ($students_completed_surveys as $key => $students) {
    foreach ($levels as $key => $level) {
        if (in_array($students['Student_class'], $accepted_foreach[$key])) {
            $levels[$key] = $levels[$key] + 1;
        }
    }
}
?>

<div class="row">
    <div class="col-lg-3">
        <div class="card border-ronded">
            <div class="card-body firstCard text-center" style="background: var(--yellow);">
                <img src="<?= base_url('assets/images/icons/manage_survey.png'); ?>" class="ic_img" alt="">
                <h4>Total Published Surveys</h4>
                <h1 data-plugin="counterup"><?php echo $counter_of_published_surveys ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card border-ronded">
            <div class="card-body firstCard text-center" style="background: var(--blue);">
                <img src="<?= base_url('assets/images/icons/manage_survey.png'); ?>" class="ic_img" alt="">
                <h4>Total Expired Surveys</h4>
                <h1 data-plugin="counterup"><?php echo sizeof($expired_surveys) ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card border-ronded">
            <div class="card-body firstCard text-center" style="background: var(--green);">
                <img src="<?= base_url('assets/images/icons/manage_survey.png'); ?>" class="ic_img" alt="">
                <h4>Total Completed Surveys</h4>
                <h1 data-plugin="counterup"><?php echo sizeof($completed_surveys) ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card border-ronded">
            <div class="card-body firstCard text-center" style="background: var(--pink);">
                <img src="<?= base_url('assets/images/icons/manage_survey.png'); ?>" class="ic_img" alt="">
                <h4>Total By Categories</h4>
                <h1 data-plugin="counterup"><?php echo sizeof($answerd_quastions) ?></h1>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 061 Teachers Reports </h4>
        <div class="card ontypecard">
            <div class="card-body">
                <h2 class="text-center">Teachers</h2>
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--orange);">
                                <i class="uil uil-user font-size-70"></i>
                                <h4>Total Received Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($teachers_surveys) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--orange);">
                                <i class="uil uil-comment-alt-question font-size-70"></i>
                                <h4> Total Received Questions </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($teachers_quastions) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--orange);">
                                <i class="uil uil-comment-alt-verify font-size-70"></i>
                                <h4> Total completed Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($teachers_completed_surveys) . ' / ' . $count_all_Teachers ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--orange);">
                                <i class="uil uil-clock-eight font-size-70"></i>
                                <h4> Average time response </h4>
                                <h1><?php echo $finishing_time_teachers; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 062 Staff Reports </h4>
        <div class="card ontypecard">
            <div class="card-body">
                <h2 class="text-center">Staff</h2>
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--dark);">
                                <i class="uil uil-user font-size-70"></i>
                                <h4>Total received Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($staff_surveys) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--dark);">
                                <i class="uil uil-comment-alt-question font-size-70"></i>
                                <h4> Total received Questions </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($staff_quastions) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--dark);">
                                <i class="uil uil-comment-alt-verify font-size-70"></i>
                                <h4> Total completed Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($staff_completed_surveys) . ' / ' . $count_all_staffs ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--dark);">
                                <i class="uil uil-clock-eight font-size-70"></i>
                                <h4> Average time response </h4>
                                <h1><?php echo $finishing_time_staff; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 063 Parents Reports </h4>
        <div class="card ontypecard">
            <div class="card-body">
                <h2 class="text-center">Parents</h2>
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--green);">
                                <i class="uil uil-user font-size-70"></i>
                                <h4>Total received Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($parents_surveys) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--green);">
                                <i class="uil uil-comment-alt-question font-size-70"></i>
                                <h4> Total received Questions </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($parents_quastions) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--green);">
                                <i class="uil uil-comment-alt-verify font-size-70"></i>
                                <h4> Total completed Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($parents_completed_surveys) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--green);">
                                <i class="uil uil-clock-eight font-size-70"></i>
                                <h4> Average time response </h4>
                                <h1><?php echo $finishing_time_parents; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 064 Students Reports </h4>
        <div class="card ontypecard">
            <div class="card-body">
                <h2 class="text-center">Students</h2>
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--purple);">
                                <i class="uil uil-user font-size-70"></i>
                                <h4>Total received Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($students_surveys) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--purple);">
                                <i class="uil uil-comment-alt-question font-size-70"></i>
                                <h4> Total received Questions </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($students_quastions) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--purple);">
                                <i class="uil uil-comment-alt-verify font-size-70"></i>
                                <h4> Total completed Surveys </h4>
                                <h1 data-plugin="counterup"><?php echo sizeof($students_completed_surveys) . ' / ' . $count_all_Students ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center" style="background: var(--purple);">
                                <i class="uil uil-clock-eight font-size-70"></i>
                                <h4> Average time response </h4>
                                <h1><?php echo $finishing_time_students; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start charts  -->
<div class="row">
    <div class="col-lg-6">
        <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CH 065 Total Received Surveys by Level</h4>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center ">Total Received Surveys by Level</h3>
                <div id="genders_charts"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CH 066 Average Time Response</h4>
        <div class="card p-4">
            <div class="card-body text-center">
                <i class="uil uil-clock-eight font-size-70"></i>
                <h4> Average Time Response </h4>
                <h1><?php echo $finishing_time_all; ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CH 065 Total Received Surveys by Level</h4>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center ">Chart By Age</h3>
                <div id="ages_charts"> </div>
            </div>
        </div>
    </div>

</div>

<div class="row p_surv">
    <div class="col-12">
        <br><h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"> CH 067 Your Published Surveys Control</h4>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Your Published Surveys</h3>
                <div class="hori-timeline mt-5" dir="ltr">
                    <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                        <?php foreach ($our_surveys as $survey) { ?>
                            <div class="item ml-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                <strong class="display-4 m-0 text-primary" style="font-family: 'Almarai';"><?php echo $survey['answers_counter']; ?></strong>
                                            </div>
                                        </div>
                                        <span>Survey Code: Surv-<?php echo $survey['survey_id'] ?></span>

                                        <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?php echo $survey['Title_en']; ?></a></h5>
                                        <p class="text-muted mb-2"><?php echo 'From :' . $survey['From_date'] . ' <br> To :' . $survey['To_date'] ?></p>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <?php if ($survey['answers_counter'] !== '0') { ?>
                                            <a href="survey_reports/<?php echo $survey['survey_id'] ?>" class="btn btn-outline-light text-truncate"><i class="uil uil-notes mr-1"></i> Reports</a>
                                        <?php } ?>
                                        <a href="survey_preview/<?php echo $survey['survey_id'] ?>" target="_blank" class="btn btn-outline-light text-truncate"><i class="uil uil-eye mr-1"></i> Preview </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/pages/timeline.init.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/enjoyhint.min.js'); ?>"></script>

<script>
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];

    if ($('.count_in_list').length > 0) {
        if (!localStorage.getItem('know_thats_counter')) {

            var enjoyhint_instance = new EnjoyHint({
                onEnd: function() {
                    localStorage.setItem('know_thats_counter', true);
                },
                onSkip: function name() {
                    localStorage.setItem('know_thats_counter', true);
                }
            });
            var enjoyhint_script_steps = [{
                'click .count_in_list ': 'This is the Answer Counter of this survey.'
            }];

            enjoyhint_instance.set(enjoyhint_script_steps);
            enjoyhint_instance.run();
        }
    }

    var genders_chart_options = {
        chart: {
            type: "bar",
            height: 160,
            stacked: true,
            stackType: "100%",
            toolbar: {
                show: false
            }
        },
        series: [{
                name: "Males",
                data: [<?php echo $surveys_for_males; ?>]
            },
            {
                name: "Females",
                data: [<?php echo $surveys_for_females; ?>]
            },
            {
                name: "Both",
                data: [<?php echo $surveys_for_all_genders; ?>]
            }
        ],
        plotOptions: {
            bar: {
                horizontal: true
            }
        },
        dataLabels: {
            dropShadow: {
                enabled: true
            },
            formatter: function(val) {
                return val ? val.toFixed(1) + '%' : ''
            }
        },
        stroke: {
            width: 0
        },
        grid: {
            show: false,
            padding: {
                top: 0,
                bottom: 0,
                right: 0,
                left: 0
            }
        },
        xaxis: {
            categories: [""],
            labels: {
                show: false
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            opacity: 1,
            type: "gradient",
            gradient: {
                shade: "dark",
                type: "vertical",
                shadeIntensity: 0.35,
                gradientToColors: undefined,
                inverseColors: false,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [90, 0, 100]
            }
        },

        legend: {
            position: "bottom",
            horizontalAlign: "center"
        }
    };

    var genders_chart = new ApexCharts(document.querySelector("#genders_charts"), genders_chart_options);
    genders_chart.render();

    <?php
    $lables_arr = array_map(function ($name) {
        return "'" . $name . "'";
    }, $simple_levels_names_arr);
    ?>

    var by_classes_options = {
        chart: {
            height: 320,
            type: "donut"
        },

        series: [<?php echo implode(',', $levels); ?>],
        toolbar: {
            show: true,
        },
        labels: [<?php echo implode(',', $lables_arr); ?>],
        colors: colors,
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: !1
                }
            }
        }]
    };
    (chart = new ApexCharts(document.querySelector("#donut_chart"), by_classes_options)).render();
    var ages_chart = {
        series: [
        <?php foreach($ages as $key => $age){ ?>
            <?php foreach($age['values'] as $name => $vel){ ?>
            {
                name: "<?= $name ?>",
                data: [<?php echo $vel; ?>]
            }, 
            <?php } ?>
        <?php  } ?> ],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            stackType: '100%'
        },
        plotOptions: {
            bar: {
                horizontal: true,
            },
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        title: {
            text: '100% Stacked Bar'
        },
        xaxis: {
            categories: ["Staff", "Students", "Teachers", "Parents"],
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " user(s)"
                }
            }
        },
        fill: {
            opacity: 1

        },
        legend: {
            position: 'top',
            horizontalAlign: 'left',
            offsetX: 40
        }
    };
    (chart = new ApexCharts(document.querySelector("#ages_charts"), ages_chart)).render();
</script>
</div>