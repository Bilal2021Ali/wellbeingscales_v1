<?php $counter_of_published_surveys = $this->db->query("SELECT Id FROM `sv_school_published_surveys` 
WHERE `By_school` = '" . $sessiondata['admin_id'] . "'  ")->num_rows(); ?>
<link rel="stylesheet" href="<?= base_url('assets/libs/owl.carousel/assets/owl.carousel.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/jquery.enjoyhint.css'); ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/kineticjs/5.2.0/kinetic.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/libs/owl.carousel/assets/owl.theme.default.min.css'); ?>">
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

    .card {
        border: 0px;
    }
</style>
<?php

if ($type_of_user == "Students") {
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

    $lables_arr = array_map(function ($name) {
        return "'" . $name . "'";
    }, $simple_levels_names_arr);
}

?>

<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHWD 001 التقرير التفصيلي (<?= $type_of_user ?>)</h4>
        <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHWD 002 المجاميع</h4>
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-ronded">
                    <div class="card-body text-center">
                        <i class="uil uil-clipboard-notes font-size-70"></i>
                        <h4>مجموع الإستبيانات المنشورة</h4>
                        <h1 data-plugin="counterup"><?= sizeof($our_surveys); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-ronded">
                    <div class="card-body text-center">
                        <i class="uil uil-calendar-slash font-size-70"></i>
                        <h4>مجموع الإستبيانات المنتهية</h4>
                        <h1 data-plugin="counterup"><?= sizeof($expired_surveys) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-ronded">
                    <div class="card-body text-center">
                        <i class="uil uil-check font-size-70"></i>
                        <h4>مجموع الإستبيانات المكتملة</h4>
                        <h1 data-plugin="counterup"><?= sizeof($completed_surveys) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-ronded">
                    <div class="card-body text-center">
                        <i class="uil uil-bullseye font-size-70"></i>
                        <h4>مجموع التصنيفات المستخدمة</h4>
                        <h1 data-plugin="counterup"><?= sizeof($used_categorys) ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card border-ronded">
                            <div class="card-body text-center">
                                <i class="uil uil-user font-size-70"></i>
                                <h4>مجموع الإستبيانات المستلمة </h4>
                                <h1 data-plugin="counterup"><?= sizeof($surveys) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="uil uil-comment-alt-question font-size-70"></i>
                                <h4> مجموع أسئلة الإستبيانات </h4>
                                <h1 data-plugin="counterup"><?= sizeof($quastions) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="uil uil-comment-alt-verify font-size-70"></i>
                                <h4> مجموع الإستبيانات المكتملة </h4>
                                <h1><?= sizeof($completed_surveys) . ' / ' . $count_all ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="uil uil-clock-eight font-size-70"></i>
                                <h4> متوسط زمن الإستجابة </h4>
                                <h1><?= $finishing_time; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- start charts  -->
        <div class="row">
            <div class="col-lg-6">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHWD 003 الرسم البياني - جنس المشاركين</h4>
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center ">الرسم البياني - جنس المشاركين</h3>
                        <div id="genders_charts"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHWD 004 متوسط زمن الإستجابة</h4>
                <div class="card p-4">
                    <div class="card-body text-center">
                        <i class="uil uil-clock-eight font-size-70"></i>
                        <h4>متوسط زمن الإستجابة</h4>
                        <h1><?= $finishing_time; ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($type_of_user == "Students") { ?>
            <div class="col-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHWD 005 تقارير الإستبيانات التفصيلية</h4>
                <div class="card p-4">
                    <div class="card-body text-center">
                        <div class="col-lg-6 offset-lg-3">
                            <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row p_surv">
            <div class="col-12">
                <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHWD 005 تقارير الإستبيانات التفصيلية</h4>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">تفاصيل الإستبيانات</h3>
                        <hr>
                        <div class="hori-timeline mt-5" dir="ltr">
                            <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                <?php foreach ($our_surveys as $survey) { ?>
                                    <div class="item ml-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="dropdown float-right">
                                                    <a class="text-body dropdown-toggle font-size-16" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                        <i class="uil uil-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="uil uil-pen mr-1"></i>تعديل</a>
                                                        <a class="dropdown-item" href="survey_reports/<?= $survey['survey_id'] ?>">
															<i class="uil uil-notes mr-1"></i>التقارير</a>
                                                        <a class="dropdown-item" href="#"><i class="uil uil-trash mr-1"></i>حذف</a>
                                                        <a class="dropdown-item" href="#"><i class="uil uil-share mr-1"></i>مشاركة</a>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="mb-4">
                                                    <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                        <strong class="display-4 m-0 text-primary" style="font-family: 'Almarai';"><?= $survey['answers_counter']; ?></strong>
                                                    </div>
                                                </div>
                                                <span>رمز الإستبيان: <?= $survey['survey_id'] ?></span>
                                                <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">
												<span>عنوان الإستبيان:  <?= $survey['Title_ar']; ?></a></h5>
                                                <p><span>تصنيف الإستبيان: 
													<?= $survey['set_name_ar'] ?></p>
                                                <p class="text-muted mb-2"><?= 'من تاريخ :' . $survey['From_date'] . ' <br> إلى تاريخ :' . $survey['To_date'] ?></p>
                                            </div>
                                            <div class="btn-group" role="group">
                                                <?php if ($survey['answers_counter'] !== '0') { ?>
                                                    <a href="<?= base_url("AR/Schools/survey_reports/" . $survey['survey_id'] . "/" . $type_of_user_name); ?>" class="btn btn-outline-light text-truncate"><i class="uil uil-notes mr-1"></i>التقارير</a>
                                                <?php } ?>
                                                <a href="<?= base_url("AR/Schools/survey_preview/" . $survey['survey_id']); ?>" target="_blank" class="btn btn-outline-light text-truncate"><i class="uil uil-eye mr-1"></i> معاينة الإستبيان </a>
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

        <script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
        <script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
        <script src="<?= base_url("assets/js/pages/timeline.init.js"); ?>"></script>
        <script src="<?= base_url('assets/js/enjoyhint.min.js'); ?>"></script>

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
                        'click .count_in_list ': 'مجموع الإجابات على هذا الإستبيان '
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
                        name: "ذكور",
                        data: [<?= $surveys_for_males; ?>]
                    },
                    {
                        name: "إناث",
                        data: [<?= $surveys_for_females; ?>]
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
            <?php if ($type_of_user == "Students") { ?>
                var by_classes_options = {
                    chart: {
                        height: 'auto',
                        type: "donut"
                    },

                    series: [<?= implode(',', $levels); ?>],
                    toolbar: {
                        show: true,
                    },
                    labels: [<?= implode(',', $lables_arr); ?>],
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
            <?php } ?>
        </script>
    </div>

</div>
</div>