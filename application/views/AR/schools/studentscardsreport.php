<link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<style>
    .studentcard {
        border-radius: 20px;
        border: 0px;
        box-shadow: 0px 4px 4px 3px rgb(0 0 1 / 10%);
    }

    .studentcard .studentheader {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .studentcard img:not(.avatar) {
        width: 15px;
        margin-right: 10px;
        margin-bottom: 5px;
    }

    .studentcard span {
        font-size: 18px;
    }

    .studentcard .datetime {
        font-size: 18px;
    }

    .value {
        color: #00a1bb;
    }

    .bg-1 {
        background-color: #0eacd8;
    }

    .bg-2 {
        background-color: #ff5555;
    }

    .bg-3 {
        background-color: #add138;
    }

    .uil-clock {
        float: right;
        color: #0eacd8;
    }

    .card-body .col-2 {
        direction: ltr;
        text-align: left;
    }
</style>
<?php $charts = 0; ?>
<div class="main-content">

    <div class="page-content">
        <br><h4 class="card-title"
                style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            CH 048: بطاقات الطلاب</h4>
        <div class="col-12">
            <div class="card">
                <form class="card-body" method="post">
                    <label for="">اختيار المستوى الدراسي:</label>
                    <select name="class" class="form-control select2" id="class">
                        <option value="">اختيار المستوى الدراسي</option>
                        <?php foreach ($this->schoolHelper->getActiveSchoolClassesByStudents() as $class) { ?>
                            <option value="<?= $class['Id'] ?>" <?= $class['Id'] == $activeclass ? 'selected' : "" ?>><?= $class['Class'] ?> <?= $class['Id'] == $activeclass ? '| active' : "" ?></option>
                        <?php } ?>
                    </select>
                    <button class="btn btn-primary w-100 mt-1" type="submit"
                            style="display: <?= $activeclass == "0" ? "none" : "block" ?>;">بناء التقرير
                    </button>
                </form>
            </div>
        </div>
        <?php if ($activeclass !== 0) { ?>
            <div class="col-12">
                <?php if (!empty($students)) { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $count = 0;
                                ?>
                                <?php foreach ($students as $sn => $student) { ?>
                                    <?php if ($count !== 3) {
                                        $count = $count + 1;
                                    } else {
                                        $count = 1;
                                    }
                                    $charts = $charts + 8;
                                    ?>
                                    <div class="col-12">
                                        <div class="card studentcard">
                                            <div class="card-body studentheader bg-<?= $count ?>">
                                                <div class="d-flex justify-content-around">
                                                    <h3 class="card-title text-white"><?= $student->name ?></h3>
                                                    <h3 class="card-title text-white"><?= $student->Gender == "F" ? "Female" : "Male" ?></h3>
                                                    <h3 class="card-title text-white">
                                                        Age: <?= get_age($student->DOP) ?></h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3 text-center"
                                                         style="display: grid;align-items: center;">
                                                        <div>
                                                            <img src="<?= base_url("uploads/avatars/" . ($student->useravatar ?? "default_avatar.jpg")) ?>"
                                                                 class="avatar img-thumbnail avatar-lg rounded-circle mb-1"
                                                                 alt="..."><br>
                                                            <span><?= $student->Created ?></span>
                                                            <p class="text-center"><?= $student->Time ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <span style="color: #656257;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/03.png") ?>"
                                                                    alt="">BP:</span><br>
                                                        <span style="color: #d5a423;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/08.png") ?>"
                                                                    alt="">SpO2:</span><br>
                                                        <span style="color: #1c468c;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/06.png") ?>"
                                                                    alt="">HR:</span><br>
                                                        <span style="color: #9c884f;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/01.png") ?>"
                                                                    alt="">Glucose:</span><br>
                                                        <span style="color: #dc5c95;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/07.png") ?>"
                                                                    alt="">Temp:</span><br>
                                                        <span style="color: #9c6300;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/04.png") ?>"
                                                                    alt="">Steps:</span><br>
                                                        <span style="color: #3c4054;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/05.png") ?>"
                                                                    alt="">Calories:</span><br>
                                                        <span style="color: #616e9c;"><img
                                                                    src="<?= base_url("assets/images/icons/studentscards/02.png") ?>"
                                                                    alt="">Weight:</span><br>
                                                    </div>
                                                    <div class="col-2">
                                                        <span class="value"><?= $student->Blood_pressure_max ?>/<?= $student->Blood_pressure_min ?? 0 ?></span>
                                                        mmHg <br>
                                                        <span class="value"><?= $student->Blood_oxygen ?? 0 ?></span>
                                                        %<br>
                                                        <span class="value"><?= $student->Heart_rate ?? 0 ?></span>
                                                        bpm<br>
                                                        <span class="value"><?= $student->Glucose ?? 0 ?></span>
                                                        mmol/L<br>
                                                        <span class="value"><?= $student->Result ?? 0 ?></span> C°<br>
                                                        <span class="value"><?= $student->Steps ?? 0 ?></span>Step<br>
                                                        <span class="value"><?= $student->calories ?? 0 ?></span>
                                                        Kcal</i><br>
                                                        <span class="value"><?= $student->weight ?? 0 ?></span> Kg<br>
                                                    </div>

                                                    <div class="col-4">
                                                        <span class="datetime"><?= $student->Blood_pressure_Date ?? "00-00-0000" ?> <?= $student->Blood_pressure_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->Blood_oxygen_Date ?? "00-00-0000" ?> <?= $student->Blood_oxygen_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->Heart_rate_Date ?? "00-00-0000" ?> <?= $student->Heart_rate_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->Glucose_Date ?? "00-00-0000" ?> <?= $student->Glucose_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->Result_Date ?? "00-00-0000" ?> <?= $student->Result_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->Steps_Date ?? "00-00-0000" ?> <?= $student->Steps_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->calories_Date ?? "00-00-0000" ?> <?= $student->calories_Time ?? "00:00:00" ?><br></span>
                                                        <span class="datetime"><?= $student->weight_Date ?? "00-00-0000" ?> <?= $student->weight_Time ?? "00:00:00" ?><br></span>
                                                    </div>
                                                    <div class="col-1">
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_1"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_2"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_3"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_4"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_5"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_6"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_7"></div>
                                                        <div id="chartplaceholder_<?= $sn + 1 ?>_8"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Sorry !! we can't find any results</h3>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<script>
    $('.select2').select2();
    $('select[name="class"]').change(function () {
        if ($(this).val() !== "") {
            $('.btn[type="Submit"]').show();
        } else {
            $('.btn[type="Submit"]').hide();
        }
    });
    var colors = ["#5b73e8", "#34c38f", "#50a5f1", "#f1b44c", "#f46a6a", "#343a40"];
    for (let i = 0; i < <?= $charts ?>; i++) {
        for (let sn = 1; sn < 8; sn++) {
            var color = [];
            color.push(colors[Math.round(Math.random() * (colors.length - 1))]);
            // console.log(Math.round(Math.random(0 , colors.length)));
            var options1 = {
                series: [{
                    data: [25, 66, 41, 89, 63, 25, 44, 20, 36, 40, 54]
                }],
                fill: {
                    colors: color,
                },
                chart: {
                    type: 'bar',
                    width: 30,
                    height: 30,
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                xaxis: {
                    crosshairs: {
                        width: 1
                    },
                },
                tooltip: {
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function (seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            };

            var chart1 = new ApexCharts(document.querySelector("#chartplaceholder_" + i + "_" + sn), options1);
            chart1.render();
        }

    }
</script>
<?php
function get_age($date)
{
    $sortedDate = date('Y-m-d', strtotime($date));
    $year = explode("-", $sortedDate)[0];
    $age = date('Y') - $year;
    if (date('md') < date('md', strtotime($date))) {
        return $age - 1;
    }
    return $age;
}

?>