<script src="https://cdn.jsdelivr.net/npm/gauge-chart@0.5.3/dist/bundle.js"></script>
<style>
    .choice {
        height: 10px;
    }

    .col.text-center {
        font-size: 10px;
        margin-bottom: 5px;
    }

    .GaugeChartContainer {
        height: 160px;
    }

    .emptysurvey {
        max-width: 300px;
        margin: auto;
        padding: 20px;
    }

    .disabled {
        background-color: #404040 !important;
        pointer-events: none;
        border: 0px;
        color: #a3a3a3 !important;
    }
</style>
<?php if (isset($fullpage)) { ?>
<div class="main-content">
    <div class="page-content">
        <?php } ?>
        <div class="col-12">
            <h4 class="card-body text-center"
                style="background: #33a2ff; padding: 10px;color: #fcf9f9;border-radius: 4px;">تقارير الجو العام</h4>
            <div class="card">
                <div class="card-body">
                    <form class="row" method="post">
                        <div class="col">
                            <label>حسب الفئة:</label>
                            <select class="form-control categoryfilter">
                                <option value="all">الجميع</option>
                                <?php foreach (array_unique(array_column($climate_survyes, "Cat_id")) as $key => $category) { ?>
                                    <option value="<?= $category ?>"><?= $climate_survyes[$key]['Cat_ar'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($filters)) { ?>
                            <div class="col">
                                <label>حسب المدرسة:</label>
                                <select name="school" class="form-control">
                                    <option value="all">الجميع</option>
                                    <?php foreach ($our_schools as $key => $school) { ?>
                                        <option <?= $this->input->post('school') == $school['Id'] ? "selected" : "" ?>
                                            value="<?= $school['Id'] ?>"><?= $school['School_Name_AR'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <label>حسب عنوان الجو العام:</label>
                                <input placeholder="عنوان الجو العام..." name="search" class="form-control"
                                       type="search" value="<?= $this->input->post('search') ?? "" ?>">
                            </div>
                        <?php } ?>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 mt-2">إبدأ:</button>
                        </div>
                    </form>
                    <?php if (!empty($climate_survyes)) { ?>
                        <div class="hori-timeline mt-5" dir="ltr">
                            <div class="owl-carousel owl-theme navs-carousel events" id="our_surveys_list">
                                <?php foreach ($climate_survyes as $survey) { ?>
                                    <div class="climatesurvey item ml-3" data-category-id="<?= $survey["Cat_id"]; ?>">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h5 class="font-size-12 mb-2 text-dark"><?= $survey['set_name_ar']; ?></h5>
                                                <h3 class="card-title"><?= $survey['question'] ?></h3>
                                                <div class="mb-4">
                                                    <div class="GaugeChartContainer"
                                                         id="GaugeChart_<?= $survey['survey_id'] ?>"></div>
                                                </div>
                                                <span>%</span>
                                                <hr>
                                            </div>
                                            <?php /*?> <a id="GaugeChart_action_<?= $survey['survey_id'] ?>" href="<?= base_url('EN/DashboardSystem/climate-results-chart/' . $survey['survey_id']); ?>" class="w-100 btn btn-warning" style="border-radius: 0px;">Show Details<i class="uil uil-arrow-right"></i></a><?php */ ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="p-5 w-100 text-center">
                            <img style="max-width: 300px;" class="w-100 mb-5"
                                 src="<?= base_url("assets/images/nosurveys.svg") ?>">
                            <h6>لا يوجد بيانات</h6>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if (isset($fullpage)) { ?>
    </div>
</div>
<?php } ?>
<script>
    const colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
</script>
<?php if (!empty($climate_survyes)) {
    foreach ($climate_survyes as $climate_survye) {
        $choices = $this->db
            ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
            sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
            ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
            ->select('COUNT(scl_climate_answers.Id) AS ChooseingTimes')
            ->from('scl_st_choices')
            ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
            ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
            ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
            ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
            ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
            ->join('scl_climate_answers', 'scl_climate_answers.climate_id = ' . $climate_survye['survey_id'] . ' AND  scl_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left')
            ->where('servey_id', $climate_survye['main_survey_id'])
            ->order_by('position', 'ASC')
            ->group_by('scl_st_choices.Id')
            ->get()->result_array();
        // echo $this->db->last_query();
        // print_r($choices);
        $labels = array();
        $isallempty = 0;
        $activeValue = array('times' => 0, "value" => 0);
        foreach ($choices as $key => $choice) {
            $isallempty += $choice['ChooseingTimes'];
            $labels[] = '"' . $choice['title_ar'] . '"';
        }

        if ($isallempty == 0) { ?>
            <script>
                $('#GaugeChart_action_' + <?= $climate_survye['survey_id'] ?>).addClass('disabled');
            </script>
        <?php }

        $count = array();
        for ($i = 1; $i < sizeof($choices) + 1; $i++) {
            $value = round($i / (sizeof($choices) / 100), 2) - 0.1;
            $count[] = $value;
            if ($choices[($i - 1)]['ChooseingTimes'] > $activeValue['times']) {
                $activeValue['times'] = $choices[($i - 1)]['ChooseingTimes'];
                $activeValue['value'] = $value - 5;
            }
        }

        if (!empty($choices)) { ?>
            <script>
                var selector = '#GaugeChart_' + <?= $climate_survye['survey_id'] ?>;
                var element = document.querySelector(selector);
                var chartWidth = ($(selector).parent().parent().parent().parent().parent().width() / 3);
                var options = {
                    arcOverEffect: false,
                    hasNeedle: true,
                    needleColor: "black",
                    needleStartValue: 0,
                    arcColors: colors,
                    arcDelimiters: [<?= implode(',', $count) ?>],
                    // arcLabels: [<?= implode(',', $labels) ?>],
                    // rangeLabel: [<?= $count[0] ?>, <?= $count[sizeof($count) - 1] ?>],
                }
                GaugeChart.gaugeChart(element, chartWidth, options).updateNeedle(<?= $activeValue['value'] ?>);

                <?php if (!empty($choices)) { ?>
                // choices
                var choicesbar = '<div class="row">';
                <?php foreach ($choices as $choice) { ?>
                choicesbar += '<div class="col text-center"><?= $choice['title_ar'] . " (" . ($choice['ChooseingTimes'] > 0 ? $choice['ChooseingTimes'] : "No Data") . ")"  ?></div>';
                <?php } ?>
                choicesbar += '</div>';
                $(selector).parent().parent().append(choicesbar);
                // choices colors
                var choicesbar = '<div class="row">';
                <?php foreach ($choices as $i => $choice) { ?>
                choicesbar += '<div class="col choice" style="background-color : ' + colors[<?= $i ?>] + '"></div>';
                <?php } ?>
                choicesbar += '</div>';
                <?php } else { ?>
                var choicesbar = '00<div class="row h-20"></div>';
                <?php } ?>
                $(selector).parent().parent().append(choicesbar);
            </script>
        <?php } else { ?>
            <script>
                $('#GaugeChart_' + <?= $climate_survye['survey_id'] ?>).html('<div class="w-100 text-center"><img style="max-width: 300px;" class="w-100 emptysurvey" src="<?= base_url("assets/images/nosurveys.svg") ?>"><h6>No data Here Yet !</h6></div>');
            </script>
        <?php } ?>
    <?php } ?>
    <script>
        $('.categoryfilter').change(function () {
            var val = $(this).val();
            if (val !== "all") {
                $('.climatesurvey').hide();
                $('.climatesurvey[data-category-id="' + val + '"]').show();
            } else {
                $('.climatesurvey').show();
            }
        });
    </script>
<?php } ?>