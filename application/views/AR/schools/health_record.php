<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<style>
    .address {
        height: 100%;
        width: 100%;
        display: grid;
        align-items: center;
        text-align: center;
        border: 1px solid;
        border-radius: 9px;
    }

    .background-black {
        background: #0eacd8;
        color: #fff;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    table,
    tr,
    td,
    th {
        border: 1px solid black;
    }

    th {
        vertical-align: top;
    }

    td:empty:after {
        content: "\00a0";
        /* HTML entity of &nbsp; */
    }

    .custom-control-label.checked::after {
        background-color: #5b73e8;
        border-color: #5b73e8;
        border-radius: .25em;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
        background-size: contain;
    }

    .medicalstatus {
        text-align: left;
    }

    .hasallergies {
        -webkit-animation: blink-1 0.6s infinite both;
        animation: blink-1 0.6s infinite both;
    }

    /* ----------------------------------------------
 * Generated by Animista on 2021-9-23 15:23:14
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info. 
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

    /**
 * ----------------------------------------
 * animation blink-1
 * ----------------------------------------
 */
    @-webkit-keyframes blink-1 {

        0%,
        50%,
        100% {
            opacity: 1;
        }

        25%,
        75% {
            opacity: 0;
        }
    }

    @keyframes blink-1 {

        0%,
        50%,
        100% {
            opacity: 1;
        }

        25%,
        75% {
            opacity: 0;
        }
    }

    .schoolEdite {
        border: 0px;
        outline: none;
					  
    }
</style>
<?php

function getTheColor($value, $visions_color)
{
    $color = '';
    $font_color = '';

    foreach ($visions_color as $row) {
        if ($value > $row['from'] && $value < $row['to']) {
            $color = $row['color'];
            $font_color = $row['font_color'];
            break;
        }
    }

    return [
        'color' => "#" . $color,
        'font_color' => "#" . $font_color
    ];
}
?>
<div class="main-content">
    <div class="page-content">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?= base_url("assets/images/Health_Record_02.png") ?>" height="80" alt="" srcset="">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3" style="display : grid ; align-items: center;">
                            <img src="<?= base_url("uploads/avatars/" . ($student['useravatar'] ?? "default_avatar.jpg")) ?>" style="margin: auto;" class="avatar-xl img-thumbnail" alt="">
                        </div>
                        <div class="col-lg-3">
                            <p>الإسم: <?= $student['F_name_AR'] . " " . $student['M_name_AR'] . " " . $student['L_name_EN'] ?></p>
                            <p>الجنس: <?= $student['Gender'] == 'F' ? "انثى" : "ذكر" ?></p>
                            <p>تاريخ الميلاد: <?= $student['DOP'] ?></p>
							<!-- <p>Father’s Name: <?= $health_record['Parent_Name_Father'] ?? "--" ?> </p>
                            <p>Mother’s Name: <?= $health_record['Parent_Name_Mother'] ?? "--" ?> </p> -->
                        </div>
                        <div class="col-lg-4">
                            <p>المدرسة الابتدائية: <?= $health_record['Elementary'] ?? "----/--/--" ?></p>
                            <p>المدرسة المتوسطة: <?= $health_record['Intermediate'] ?? "----/--/--" ?></p>
                            <p>المدرسة الثانوية: <?= $health_record['High'] ?? "----/--/--" ?></p>
                            <p>المدرسة الثانوية العليا: <?= $health_record['Seniorhighschool'] ?? "----/--/--" ?></p>
                        </div>
                        <div class="col-lg-2">
                            <div class="address <?= !empty($health_record['Allergies']) ? "hasallergies bg-danger text-white" : "" ?>">
                                <?= $health_record['Allergies'] ?? "------" ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <table class="table table-striped table-bordered medicalstatus">
                        <thead>
                            <th colspan="6" class="text-center background-black">الحالة الطبية</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Allergy'] == 1 ? "checked" : "" ?>" for="Allergy"> Allergy </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Allergy">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Asthma'] == 1 ? "checked" : "" ?>" for="Asthma"> Asthma </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Asthma">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Behavioral_Problems'] == 1 ? "checked" : "" ?>" for="Behavioral_Problems"> Behavioral Problems </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Behavioral_Problems">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Cancer_Leukemia'] == 1 ? "checked" : "" ?>" for="Cancer_Leukemia"> Cancer/Leukemia </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Cancer_Leukemia">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Chronic_Cough_Wheezing'] == 1 ? "checked" : "" ?>" for="Chronic_Cough_Wheezing"> Chronic Cough Wheezing </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Chronic_Cough_Wheezing">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Diabetes'] == 1 ? "checked" : "" ?>" for="Diabetes"> Diabetes </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Diabetes">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Hearing_Problems'] == 1 ? "checked" : "" ?>" for="Hearing_Problems"> Hearing Problems </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Hearing_Problems">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Heart_Disease'] == 1 ? "checked" : "" ?>" for="Heart_Disease"> Heart Disease </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Heart_Disease">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Hemophilia'] == 1 ? "checked" : "" ?>" for="Hemophilia"> Hemophilia </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Hemophilia">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Hypertension'] == 1 ? "checked" : "" ?>" for="Hypertension"> Hypertension </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Hypertension">
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['JRA_Arthritis'] == 1 ? "checked" : "" ?>" for="JRA_Arthritis"> JRA Arthritis </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="JRA_Arthritis">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Rheumatic_Heart'] == 1 ? "checked" : "" ?>" for="Rheumatic_Heart"> Rheumatic Heart </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Rheumatic_Heart">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Seizures'] == 1 ? "checked" : "" ?>" for="Seizures"> Seizures </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Seizures">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Sickle_Cell_Anemia'] == 1 ? "checked" : "" ?>" for="Sickle_Cell_Anemia"> Sickle Cell Anemia </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Sickle_Cell_Anemia">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Skin_Problems'] == 1 ? "checked" : "" ?>" for="Skin_Problems"> Skin Problems </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Skin_Problems">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <label class="custom-control-label <?= $medical_status['Vision_Problem'] == 1 ? "checked" : "" ?>" for="Vision_Problem"> Vision Problem </label>
                                        <input type="checkbox" class="custom-control-input form-check-input" id="Vision_Problem">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="text-center background-black p-3"> الرؤية </p>
                            <table class="container-fluid" style="overflow: auto;">
                                <img src="<?= base_url("assets/images/vision_banner.jpg") ?>" class="w-100" alt="">
								<tr>
                                    <th colspan="4">العين اليسرى</th>
                                    <th colspan="4">العين اليمنى</th>
                                </tr>
                                <tr>
                                    <td class="text-center background-black p-3">SPH</td>
                                    <td class="text-center background-black p-3">CYL</td>
                                    <td class="text-center background-black p-3">AXIS</td>
                                    <td class="text-center background-black p-3">PD</td>
                                    <td class="text-center background-black p-3">SPH</td>
                                    <td class="text-center background-black p-3">CYL</td>
                                    <td class="text-center background-black p-3">AXIS</td>
                                    <td class="text-center background bg-success p-3">النتيجة</td>
                                </tr>	 
                                <?php foreach ($vision_tests as $vision_test) { ?>
                                    <tr data-toggle="tooltip" title="<?= $vision_test->TimeStamp ?>">
                                        <td>SPH <?= $vision_test->R_SPH ?? "--" ?></td>
                                        <td>CYL <?= $vision_test->R_CYL ?? "--" ?></td>
                                        <td>AXIS <?= $vision_test->R_AXIS ?? "--" ?></td>
                                        <td class="text-center background-black p-3">PD <?= $vision_test->Pupil_Destance ?? "--" ?></td>
                                        <td>SPH <?= $vision_test->L_SPH ?? "--" ?></td>
                                        <td>CYL <?= $vision_test->L_CYL ?? "--" ?></td>
                                        <td>AXIS <?= $vision_test->L_AXIS ?? "--" ?></td>
                                        <td class="<?= $vision_test->Pass_Fail == 1 ? "bg-success" : "bg-danger" ?> text-white">
                                            <?= $vision_test->Pass_Fail == 1 ? "ناجح" : "غير ناجح" ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <p class="text-center background-black p-3"> السمع </p>
                            <table class="container-fluid" style="overflow: auto;">
							<img src="<?= base_url("assets/images/hearing.png") ?>" class="w-100" alt="">														
                                <tr>
                                    <th colspan="7">الأذن اليسرى</th>
                                    <th colspan="7">الأذن اليمنى</th>
                                </tr>
                                <tr>
								
                                    <td class="text-center background-black p-3">500</td>
                                    <td class="text-center background-black p-3">1000</td>
                                    <td class="text-center background-black p-3">2000</td>
                                    <td class="text-center background-black p-3">3000</td>
                                    <td class="text-center background-black p-3">4000</td>
                                    <td class="text-center background-black p-3">6000</td>
                                    <td class="text-center background-black p-3">8000</td>
                                    <td class="text-center background-black p-3">500</td>
                                    <td class="text-center background-black p-3">1000</td>
                                    <td class="text-center background-black p-3">2000</td>
                                    <td class="text-center background-black p-3">3000</td>
                                    <td class="text-center background-black p-3">4000</td>
                                    <td class="text-center background-black p-3">6000</td>
                                    <td class="text-center background-black p-3">8000</td>
									<td class="text-center background-black p-3 bg-success text-white">النتيجة</td>																			  
                                </tr>
                                <?php foreach ($hearing_tests as $hearing_test) { ?>
                                    <tr data-toggle="tooltip" title="<?= $hearing_test->TimeStamp ?>">
                                        <td style="background-color: <?= getTheColor($hearing_test->L_500 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_500 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_500 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->L_1000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_1000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_1000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->L_2000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_2000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_2000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->L_3000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_3000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_3000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->L_4000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_4000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_4000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->L_6000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_6000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_6000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->L_8000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->L_8000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->L_8000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_500 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_500 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_500 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_1000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_1000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_1000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_2000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_2000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_2000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_3000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_3000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_3000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_4000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_4000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_4000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_6000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_6000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_6000 ?? "--" ?></td>
                                        <td style="background-color: <?= getTheColor($hearing_test->R_8000 ?? "", $visions_color)['color'] ?>;color : <?= getTheColor($hearing_test->R_8000 ?? "", $visions_color)['font_color'] ?>"><?= $hearing_test->R_8000 ?? "--" ?></td>
										<td class="<?= $hearing_test->Pass_Fail == 1 ? "bg-success" : "bg-danger" ?> text-white">
                                            <?= $hearing_test->Pass_Fail == 1 ? "ناجح" : "تحويل" ?>
                                        </td>	 
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="text-center background-black p-3"><b>الطبيب فحص رمز N-العادي; A-غير طبيعي; C-تصحيح; R-تلقي الرعاية</b></p>
                    <table class="table table-bordred table-responsive">
                        <tr>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Grade</th>
                            <th rowspan="2">Height</th>
                            <th rowspan="2">Weight</th>
                            <th rowspan="2">BMI</th>
                            <th rowspan="2">Blood Pressure</th>
                            <th colspan="2">Vision</th>
                            <th colspan="2">Hearing</th>
                            <th rowspan="2">Eyes</th>
                            <th rowspan="2">Ears</th>
                            <th rowspan="2">Nose</th>
                            <th rowspan="2">Throat</th>
                            <th rowspan="2">Teeth</th>
                            <th rowspan="2">Heart</th>
                            <th rowspan="2">Lungs</th>
                            <th rowspan="2">Abdomen</th>
                            <th rowspan="2">Nervous System</th>
                            <th rowspan="2">Skin</th>
                            <th rowspan="2">Scoliosis</th>
                            <th rowspan="2">Extremities</th>
                            <th rowspan="2">Nutrition</th>
                            <th rowspan="2">Varicella immunity</th>
                            <th rowspan="2">Reviewed...</th>
                            <th rowspan="2">Completed...</th>
                            <th rowspan="2">Provider’s Signature</th>
                            <th rowspan="2">Provider’s Stamp</th>
                        </tr>
                        <tr>
                            <td>R.</td>
                            <td>L.</td>
                            <td>R.</td>
                            <td>L.</td>
                        </tr>
                        <?php foreach ($examination_code as $examination) { ?>
                            <tr>
                                <td><?= $examination['TimeStamp'] ?></td>
                                <td><?= $examination['Grade'] ?></td>
                                <td><?= $examination['Height'] ?></td>
                                <td><?= $examination['Weight'] ?></td>
                                <td><?= $examination['BMI'] ?></td>
                                <td><?= $examination['Blood_Pressure'] ?></td>
                                <td><?= $examination['R_Vision'] ?></td>
                                <td><?= $examination['L_Vision'] ?></td>
                                <td><?= $examination['R_Hearing'] ?></td>
                                <td><?= $examination['L_Hearing'] ?></td>
                                <td><?= $examination['Eyes'] ?></td>
                                <td><?= $examination['Ears'] ?></td>
                                <td><?= $examination['Nose'] ?></td>
                                <td><?= $examination['Throat'] ?></td>
                                <td><?= $examination['Teeth'] ?></td>
                                <td><?= $examination['Heart'] ?></td>
                                <td><?= $examination['Lungs'] ?></td>
                                <td><?= $examination['Abdomen'] ?></td>
                                <td><?= $examination['Nervous_System'] ?></td>
                                <td><?= $examination['Skin'] ?></td>
                                <td><?= $examination['Scoliosis'] ?></td>
                                <td><?= $examination['Extremities'] ?></td>
                                <td><?= $examination['Nutrition'] ?></td>
                                <td><?= $examination['varicella_Immunity_Secondary_to_Disease'] ?></td>
                                <td><?= $examination['Reviewed_Immunization_Record'] ?></td>
                                <td><?= $examination['Completed_PPD_Screening'] ?></td>
                                <td><?= $examination['Providers_Signature'] ?></td>
                                <td><?= $examination['Printed_Name'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6" style="overflow: auto;">
                            <table class="table ">
                                <tr>
                                    <th colspan="8" style="<?= empty($dental_examinations) ? "width:900px" : "" ?>" class="text-center background-black"> فحص أسنان الطالب</th>
                                </tr>
                                <?php foreach ($dental_examinations as $dental_examination) { ?>
                                    <tr>
                                        <th colspan="6">فحص الأسنان </th>
                                        <th colspan="6"><?= $dental_examination['Date'] ?? "----/--/--" ?></th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-responsive">
                                <tr>
                                    <th colspan="12" style="<?= empty($vaccines) ? "width:900px" : "" ?>" class="text-center background-black"> التحصينات (التطعيمات، التواريخ المعطاة: شهر/يوم/سنة) </th>
                                </tr>
                                <?php foreach ($vaccines as $vaccine) { ?>
                                    <tr>
                                        <th><?= $vaccine['Vaccines_EN'] ?></th>
                                        <th>تاريخ</th>
                                        <th><?= $vaccine['Date01'] ?? "----/--/--" ?></th>
                                        <th><?= $vaccine['Date02'] ?? "----/--/--" ?></th>
                                        <th><?= $vaccine['Date03'] ?? "----/--/--" ?></th>
                                        <th><?= $vaccine['Date04'] ?? "----/--/--" ?></th>
                                        <th><?= $vaccine['Date05'] ?? "----/--/--" ?></th>
                                        <th><?= $vaccine['Date06'] ?? "----/--/--" ?></th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table>
                        <thead class="background-black ">
                            <th class="text-left">تاريخ</th>
                            <th class="text-left">ملاحظه</th>
                            <th>توقيع</th>
                        </thead>
                        <tbody>
                            <?php foreach ($Signatures as $Signature) { ?>
                                <tr>
                                    <td class="text-left"><?= $Signature['Date'] ?></td>
                                    <td class="text-left"><?= $Signature['Note'] ?></td>
                                    <td><?= $Signature['Signature'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 300,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('.schoolEdite').change(function() {
        var newDate = $(this).val();
        var type = $(this).attr('data-school-type');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: {
                date: newDate,
                type: type,
            },
            success: function(response) {
                if (response.status == "ok") {
                    Command: toastr["success"]("Value Updated Successfully to " + newDate);
                }
                else {
                    Command: toastr["error"]("Sorry we have an unexpected error. Please try again later");
                }
            }
        });
    });
</script>		 
<?php function valtocode($val)
{
    if ($val == 1) {
        return "A";
    } else if ($val == 2) {
        return "B";
    } else if ($val == 3) {
        return "C";
    } else {
        return "D";
    }
} ?>