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

    .ontypecard .card-body * {
        color: #fff;
        cursor: default;
    }

    .ontypecard .card-body {
        border-radius: 5px;
    }
</style>
<div class="col-lg-12">
    <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 036 COUNTER CARDS-ALL SURVEYS</h4>
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--yellow);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>TOTAL PUBLISHED SURVEYS</h4>
                    <h1 data-plugin="counterup"><?= sizeof($our_surveys); ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--blue);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>TOTAL EXPIRED SURVEYS</h4>
                    <h1 data-plugin="counterup"><?= sizeof($expired_surveys) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--green);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>TOTAL COMPLETED SURVEYS</h4>
                    <h1 data-plugin="counterup"><?= sizeof($completed_surveys) ?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-ronded">
                <div class="card-body firstCard text-center" style="background: var(--pink);">
                    <img src="<?= base_url('assets/images/icons/PUBLISHEDSURVEYS.png'); ?>" class="ic_img" alt="">
                    <h4>TOTAL CATEGORIES</h4>
                    <h1 data-plugin="counterup"><?= sizeof($used_categorys) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 038 SUMMARY OF RESPONDENTS BASED ON PUBLISHED RESEARCH SURVEYS</h4>
            <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> SUMMARY OF RESPONDENTS BASED ON PUBLISHED RESEARCH SURVEYS</h4>
            <div class="card">
                <div class="card-body">
                    <div class="hori-timeline mt-5" dir="ltr">
                        <div class="owl-carousel owl-theme navs-carousel events" id="our_surveys_list">
                            <?php
                            foreach ($our_surveys as $survey) { ?>
                                <div class="item ml-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                    <strong class="display-4 m-0 text-primary" style="font-family: 'Almarai';"><?= $survey['answers_counter']; ?></strong>
                                                </div>
                                            </div>
                                            <span>Survey Code: Surv-<?= $survey['survey_id'] ?></span>
                                            <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $survey['Title_en']; ?></a></h5>
                                            <p class="text-muted mb-2"><?= 'From :' . $survey['From_date'] . ' <br> To :' . $survey['To_date'] ?></p>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <?php if ($survey['answers_counter'] > 0) { ?>
                                                <a href="<?= base_url("EN/Company_Departments/survey-reports/" . $survey['survey_id']); ?>" class="btn btn-outline-light text-truncate"><i class="uil uil-notes mr-1"></i>Reports</a>
                                            <?php } ?>
                                            <a href="<?= base_url("EN/Company_Departments/survey-preview/" . $survey['survey_id']); ?>" target="_blank" class="btn btn-outline-light text-truncate"><i class="uil uil-eye mr-1"></i> Preview </a>
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
    <div class="col-12">
        <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 039 SUMMARY OF USER TYPES BASED ON PUBLISHED RESEARCH SURVEYS</h4>
        <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> SUMMARY OF USER TYPES BASED ON PUBLISHED RESEARCH SURVEYS </h4>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="card genders_dunat_card">
                    <div class="card-body">
                        <h3 class="card-title">Graphical Presentation of Responses According to Gender</h3>
                        <h3 class="card-title text-center">
                            <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                        </h3>
                        <div id="genders_dunat"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card basic_type_chart_card">
                    <div class="card-body">
                        <h3 class="card-title">Graphical Presentation of Survey Respondents According to User Type</h3>
                        <h3 class="card-title text-center">
                            <img src="<?= base_url(); ?>assets/images/icons/both.png" alt="" srcset="" width="200px">
                        </h3>
                        <div id="basic_type_chart" class="mb-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($supported_types as $type) { ?>
        <?php $ages = $this->sv_reports->ages($type['typeKey']) ?>
        <?php $matural = $this->sv_reports->matural_status($type['typeKey']) ?>
        <?php $counter_of_published_surveys = sizeof($this->sv_reports->specific_type_surveys($type['typeKey'])) ?>
        <?php $counter_of_expired_surveys = sizeof($this->sv_reports->specific_type_surveys($type['typeKey'], ['expired' => true])) ?>
        <?php $counter_of_completed_surveys = sizeof($this->sv_reports->completed_surveys(['u_type' => $type['typeKey']])) ?>
        <?php $quastions = sizeof($this->sv_reports->specific_type_questions($type['typeKey'])) ?>
        <?php $finishing_time = $this->sv_reports->timeOfFinishing(['type' => $type['typeKey']]) ?>
        <div class="row">
            <div class="col-12">
                <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 045 DATA FREQUENCY OF <?= strtoupper($type['name']) ?></h4>
                <h4 class="card-title bordred_title" style="padding: 30px;background: #0eacd8;border: 2px solid #006a88;font-size: 25px;"> DATA FREQUENCY OF <?= strtoupper($type['name']) ?> </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Graphical Distribution by Gender</h3>
                        <div id="genders_<?= $type['typeKey'] ?>"></div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <h3 class="card-title">Graphical Distribution By Marital Status</h3>
                        <div id="mar_status_<?= $type['typeKey'] ?>"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Graphical Distribution by Age</h3>
                        <div id="ages_<?= $type['typeKey'] ?>"></div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="card-title" style="background: #add138;padding: 10px;color: #1E1E1E;border-radius: 4px;">CHW 046 <?= strtoupper(strtoupper($type['name'])) ?> COUNTERS</h4>
        <div class="row">
            <div class="col-lg-4">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--yellow);">
                        <i class="uil uil-clipboard-notes font-size-70"></i>
                        <h4>TOTAL PUBLISHED SURVEYS</h4>
                        <h1 data-plugin="counterup"><?= $counter_of_published_surveys ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--blue);">
                        <i class="uil uil-calendar-slash font-size-70"></i>
                        <h4>TOTAL EXPIRED SURVEYS</h4>
                        <h1 data-plugin="counterup"><?= $counter_of_expired_surveys ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-ronded">
                    <div class="card-body firstCard text-center" style="background: var(--green);">
                        <i class="uil uil-check font-size-70"></i>
                        <h4>TOTAL COMPLETED SURVEYS</h4>
                        <h1 data-plugin="counterup"><?= $counter_of_completed_surveys; ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ontypecard">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center" style="background: var(--orange);">
                        <i class="uil uil-comment-alt-question font-size-70"></i>
                        <h4> TOTAL QUESTIONS OF SURVEYS</h4>
                        <h1 data-plugin="counterup"><?= $quastions ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center" style="background: var(--orange);">
                        <i class="uil uil-clock-eight font-size-70"></i>
                        <h4> AVERAGE TIME RESPONSE </h4>
                        <h1><?= $finishing_time; ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var ages_options = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                series: [
                    <?php foreach ($ages as $key =>  $dAge) { ?> {
                            name: '<?= $key ?>',
                            data: [<?= $dAge[0]['counter'] ?>]
                        },
                    <?php } ?>
                ],
                grid: {
                    borderColor: '#f1f1f1',
                },
                xaxis: {
                    categories: [<?= implode(',', array_keys($ages)); ?>],
                    position: 'top',
                    labels: {
                        offsetY: -18,

                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        offsetY: -35,

                    }
                },
                fill: {
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function(val) {
                            return val + " users";
                        }
                    }

                },
            }
            var chart_ages = new ApexCharts(document.querySelector("#ages_<?= $type['typeKey'] ?>"), ages_options);
            chart_ages.render();


            <?php
            $s_keys_string = array_map(function ($keyname) {
                return ('"' . $keyname . '"');
            }, array_keys($matural));
            ?>
            var m_students = {
                series: [<?= implode(',', array_values($matural)) ?>],
                labels: [<?= implode(',', $s_keys_string) ?>],
                chart: {
                    height: "100px",
                    type: 'donut',
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 150
                        },
                        legend: {
                            show: false,
                            position: 'bottom',
                            horizontalAlign: 'center',
                            verticalAlign: 'middle',
                            floating: false,
                            fontSize: '14px',
                            offsetX: 0
                        }
                    }
                }]
            };
            var stchart = new ApexCharts(document.querySelector("#mar_status_<?= $type['typeKey'] ?>"), m_students);
            stchart.render();

            var genders_dunat = {
                series: [{
                    name: "counter",
                    data: [<?= sizeof($this->sv_reports->completed_surveys(['u_type' => $type['typeKey'], 'gender' => "M"])) ?>, <?= sizeof($this->sv_reports->completed_surveys(['u_type' => $type['typeKey'], 'gender' => "F"])) ?>]
                }],
                grid: {
                    borderColor: '#f1f1f1',
                },
                xaxis: {
                    categories: ["Males", "Females"],
                },
                chart: {
                    height: 450,
                    type: 'bar'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
            };
            var chart = new ApexCharts(document.querySelector("#genders_<?= $type['typeKey'] ?>"), genders_dunat);
            chart.render();
        </script>
    <?php } ?>
</div>
<script>
    var genders_dunat = {
        series: [{
            name: "counter",
            data: [<?= $surveys_for_males ?>, <?= $surveys_for_females ?>]
        }],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: ["Males", "Females"],
        },
        chart: {
            height: 450,
            type: 'bar'
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: true
        },
    };
    var chart = new ApexCharts(document.querySelector("#genders_dunat"), genders_dunat);
    chart.render();
    
    var options = {
        chart: {
            height: 450,
            type: 'bar'
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: true
        },
        series: [{
            name: "counter",
            data: [<?= implode(',', array_column($types, 'counter')) ?>]
        }],
        colors: ['#34c38f'],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [<?= implode(',', array_column($types, 'name')) ?>],
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#basic_type_chart"),
        options
    );

    chart.render();
</script>