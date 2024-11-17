<script src="https://unpkg.com/gauge-chart@latest/dist/bundle.js"></script>
<style>
    .empty-chart {
        width: 90%;
        padding: 10px;
    }

    svg text {
        font-size: 10px;
    }

    .icon {
        width: 40px;
        margin: auto;
        margin: 5px;
    }

    .l-c-r {
        border-bottom-right-radius: 60px;
        border-top-right-radius: 60px;
    }

    .f-c-r {
        border-bottom-left-radius: 60px;
        border-top-left-radius: 60px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= $fulldata['set_name_en'] ?></h4>
        <div class="col-12 card">
            <div class="card-body">
                <h3 class="card-title">Age Filter :</h3>
                <form class="row" method="POST">
                    <div class="col-lg-6">
                        <label>From :</label>
                        <input autocomplete="off" type="number" name="age_from" value="<?= $age['from'] ?>" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label>To:</label>
                        <input autocomplete="off" type="number" name="age_to" value="<?= $age['to'] ?>" class="form-control">
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-primary w-100">Regenerate</button>
                    </div>
                </form>
            </div>
        </div>
        <?php foreach ($types as $type) { ?>
            <div class="w-100 reportschartsfor_<?= $type ?>">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title" style="background: #52d155; padding: 20px;color: #1E1E1E;border-radius: 25px; "><?= str_replace(['1', '2', '3', '4'], ['Staff', 'Students', 'Teachers', 'Parents'], $type) ?></h2>
                        <div class="all">
                            <div class="col-12">
                                <h4 class="text-center w-100 mb-2 " style="background: #add138; padding: 10px;color: #1E1E1E;border-radius: 25px;">By User Type</h4>
                            </div>
                            <div class="row">
                                <?php foreach ($choices as $choice) { ?>
                                    <div class="col chartcontainer text-center reportschartsfor_<?= $type ?>_type_choice_<?= $choice['id'] ?>">
                                        <img src="<?= base_url('assets/images/nodatainchart.svg') ?>" class="empty-chart">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row p-2">
                                <?php foreach ($choices as $i => $choice) { ?>
                                    <div class="col text-center pt-2 <?= $i == 0 ? "f-c-r" : ((sizeof($choices) == ($i + 1)) ? 'l-c-r' : '') ?>" style="background-color: <?= $colors[$i] ?>;">
                                        <img class="icon" src="<?= $choice['icon_en'] == null ? base_url('assets/images/loading.png') : base_url('uploads/climate_choices_icons/' . $choice['icon_en']) ?>">
                                        <p class="text-white reportscolfor_<?= $type ?>_type_choice_<?= $choice['id'] ?>"><?= $choice['title_en'] ?><br><span>No answers yet</span></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="male">
                            <div class="col-12">
                                <h4 class="text-center w-100 mb-2" style="background: #add138; padding: 10px;color: #1E1E1E;border-radius: 25px;">By Gender: Male </h4>
                            </div>
                            <div class="row">
                                <?php foreach ($choices as $choice) { ?>
                                    <div class="col chartcontainer text-center reportschartsfor_<?= $type ?>_male_choice_<?= $choice['id'] ?>">
                                        <img src="<?= base_url('assets/images/nodatainchart.svg') ?>" class="empty-chart">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row p-2">
                                <?php foreach ($choices as $i => $choice) { ?>
                                    <div class="col text-center pt-2 <?= $i == 0 ? "f-c-r" : ((sizeof($choices) == ($i + 1)) ? 'l-c-r' : '') ?>" style="background-color: <?= $colors[$i] ?>;">
                                        <img class="icon" src="<?= $choice['icon_en'] == null ? base_url('assets/images/loading.png') : base_url('uploads/climate_choices_icons/' . $choice['icon_en']) ?>">
                                        <p class="text-white reportscolfor_<?= $type ?>_type_choice_<?= $choice['id'] ?>"><?= $choice['title_en'] ?><br><span>No answers yet</span></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="female">
                            <div class="col-12">
                                <h4 class="text-center w-100 mb-2" style="background: #add138; padding: 10px;color: #1E1E1E;border-radius: 25px;">By Gender: Female</h4>
                            </div>
                            <div class="row">
                                <?php foreach ($choices as $choice) { ?>
                                    <div class="col chartcontainer text-center reportschartsfor_<?= $type ?>_female_choice_<?= $choice['id'] ?>">
                                        <img src="<?= base_url('assets/images/nodatainchart.svg') ?>" class="empty-chart">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row p-2">
                                <?php foreach ($choices as $i => $choice) { ?>
                                    <div class="col text-center pt-2 <?= $i == 0 ? "f-c-r" : ((sizeof($choices) == ($i + 1)) ? 'l-c-r' : '') ?>" style="background-color: <?= $colors[$i] ?>;">
                                        <img class="icon" src="<?= $choice['icon_en'] == null ? base_url('assets/images/loading.png') : base_url('uploads/climate_choices_icons/' . $choice['icon_en']) ?>">
                                        <p class="text-white reportscolfor_<?= $type ?>_type_choice_<?= $choice['id'] ?>"><?= $choice['title_en'] ?><br><span>No answers yet</span></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class=" age">
                            <div class="col-12">
                                <h4 class="text-center w-100 mb-2" style="background: #add138; padding: 10px;color: #1E1E1E;border-radius: 25px;">By Age: (<?= $age['from'] ?>- <?= $age['to'] ?> ) </h4>
                            </div>
                            <div class="row">
                                <?php foreach ($choices as $choice) { ?>
                                    <div class="col chartcontainer text-center reportschartsfor_<?= $type ?>_age_choice_<?= $choice['id'] ?>">
                                        <img src="<?= base_url('assets/images/nodatainchart.svg') ?>" class="empty-chart">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row p-2">
                                <?php foreach ($choices as $i => $choice) { ?>
                                    <div class="col text-center pt-2 <?= $i == 0 ? "f-c-r" : ((sizeof($choices) == ($i + 1)) ? 'l-c-r' : '') ?>" style="background-color: <?= $colors[$i] ?>;">
                                        <img class="icon" src="<?= $choice['icon_en'] == null ? base_url('assets/images/loading.png') : base_url('uploads/climate_choices_icons/' . $choice['icon_en']) ?>">
                                        <p class="text-white reportscolfor_<?= $type ?>_type_choice_<?= $choice['id'] ?>"><?= $choice['title_en'] ?><br><span>No answers yet</span></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    const colors = ["#34c38f", "#fe1d23", "#f16d01", "#fbc00a", "#76ba49", "#01ac50", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
</script>
<?php foreach ($types as $type) { ?>
    <?php foreach ($filters as $filter) { ?>
        <?php $fullfilters = array_merge(['surveyid' => $surveyid, 'usertype' => $type], $filter['filters']);
        $all = $this->sv_school_reports->ClimateChoices($fullfilters);  ?>
        <?php if (!empty($all)) { ?>
            <?php
            $counts = array_column($all, "ChooseingTimes");
            // print_r(array_column($all , "id"));
            foreach ($all as $sn => $choice) {  ?>
                <script>
                    var selector = '.reportschartsfor_<?= $type ?>_<?= $filter['name'] ?>_choice_<?= $choice['id'] ?>';
                    var colselector = '.reportscolfor_<?= $type ?>_<?= $filter['name'] ?>_choice_<?= $choice['id'] ?> span';
                    <?php $labels = array(); ?>
                    var element = document.querySelector(selector);
                    console.log(element);
                    var chartWidth = ($(selector).width() / 2) + 150;
                    var options = {
                        arcOverEffect: false,
                        hasNeedle: true,
                        needleColor: "black",
                        needleStartValue: 0,
                        arcColors: colors,
                        arcDelimiters: [0.1, 20, 40, 60, 80, 99.9],
                        arcLabels: ["0%", "20%", "40%", "60%", "80%", "100%"],
                        centralLabel: '',
                    }
                    $(selector).html('');
                    $(colselector).html('Selected <?= $counts[$sn] ?> out of <?= array_sum($counts) ?>');
                    GaugeChart.gaugeChart(element, chartWidth, options).updateNeedle(<?= get_percentage(array_sum($counts), $counts[$sn]); ?>);
                </script>
    <?php }
        }
    } ?>
<?php } ?>

<?php
function get_percentage($total, $number)
{
    if ($total > 0) {
        return round($number / ($total / 100), 2) ;
    } else {
        return 0;
    }
}
?>