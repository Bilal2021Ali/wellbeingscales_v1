<style>
    .filter-type-blob {
        border-radius: 10%;
        color: #000;
        margin-right: 40px;
        text-transform: capitalize;
        padding: 10px 20px;
        float: right;
    }

    .card-bg {
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-color: #ffffff;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="justify-content-between row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?= $survey['set_name_en'] ?>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?= $survey['Cat_en'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach (['staff', 'students', 'teachers', 'parents'] as $k => $type) { ?>
                <div class="col-md-3 col-sm-12">
                    <div class="card card-bg" style="background: url('<?= base_url($backgrounds[$k]); ?>');">
                        <div class="card-body text-white">
                            <div class="row">
                                <div class="align-items-center col-6 d-flex justify-content-between">
                                    <img src="<?= base_url("assets/images/icons/png_icons/Staffs.png") ?>">
                                    <span><?= ucfirst($type) ?></span>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-white">Daily : <?= $today[$type] ?></h5>
                                    <h5 class="text-white">Weekly : <?= $week[$type] ?></h5>
                                    <h5 class="text-white">Monthly : <?= $month[$type] ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="w-100">
                    <?php foreach (['daily' => "#f8d7da", 'weekly' => "#cfe2ff", 'monthly' => "#d7f0dd"] as $type => $bgColor) { ?>
                        <div class="filter-type-blob" style="background: <?= $bgColor ?>;"><?= $type ?></div>
                        <div class="col-lg-12 px-5 default-choices-colors"
                             style="display: grid;align-items: center;">
                            <div class="row">
                                <?php foreach ($choices[$type] as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        <?= $used_choice['title_en'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($choices[$type] as $sn => $used_choice) { ?>
                                    <div class="choice col p-2 <?= $sn == 0 ? 'start-b-r' : '' ?>"
                                         style="background-color: <?= $colors[$sn]; ?>"></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($choices[$type] as $sn => $used_choice) { ?>
                                    <div class="text-center col">
                                        <?= $used_choice['ChooseingTimes'] ?>
                                        (<?= calc_perc($used_choice['ChooseingTimes'], $choicesTotals[$type]) ?>%)
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
function calc_perc($perc, $all)
{
    $x = $perc;
    $y = $all;
    if ($x > 0 && $y > 0) {
        $percent = $x / $y;
        $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
    } else {
        $percent_friendly = 0;
    }
    return $percent_friendly;
}

?>