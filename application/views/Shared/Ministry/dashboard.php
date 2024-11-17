<style>
    .InfosCards h4,
    .InfosCards p {
        color: #fff;
    }

    .InfosCards .card-body {
        border-radius: 5px;
    }

    .dropdown-item {
        cursor: pointer;
    }

    .apexcharts-legend-text {
        margin: 5px;
    }

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }

    .metismenu li {
        border-radius: 50px;
        ackground: rgb(116, 83, 163);
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        color: #fff;
        margin-bottom: 10px;
        display: block;
        width: 100%;
        border: 5px solid #ebebeb;
    }

    #userschart, .labtest-chart {
        min-height: 350px !important;
    }
</style>
<script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>
<div class="main-content">
    <div class="page-content">

        <br><br/>
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("daily_dashboard_for_schools_and_departments") ?></h4>
        <div class="row">
            <?php foreach ($cards as $card): ?>
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card" style="background-color: #<?= $card['bg_color'] ?>;">
                        <div class="card-body">
                            <div class="float-right mt-2">
                                <img src="<?= base_url() ?>assets/images/icons/png_icons/<?= $card['icons'] ?>"
                                     alt="<?= $card['Title'] ?>">
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span
                                            data-plugin="counterup"><?= $card['Data']['allCounter'] ?? '--' ?></span>
                                </h4>
                                <p class="mb-0"><?= $card['Title'] ?></p>
                            </div>
                            <p class="mt-3 mb-0" style="color: #ffffff;">
                                <span><?= $card['Data']['LastAdded'] ?? '--/--/--' ?></span><br>
                                <?= $card['last_title'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <?php if ($temperatureandlabs) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("daily_dashboard_counter_results_for_all_schools") ?></h4>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <?php if ($temperatureandlabs) { ?>
                <div class="col-xl-<?= $temperatureandlabs ? "9" : "12" ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="position: relative;min-height: 490px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4"><?= __("lab_test_results_counter") ?>
                                        : <?= $today; ?></h4>
                                    <div id="chart"></div>
                                    <div class="col-lg-12 text-center">
                                        <p>(<?= __("students_staff_teachers") ?>)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($temperatureandlabs) { ?>
                <div class="<?= $temperatureandlabs ? "col-xl-3" : "row w-100" ?>">
                    <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #387cea;">
                                <div class="card-body badge-soft-info">
                                    <div class="float-left mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/Blue.png"
                                                alt="Temperature" style="width: 30px;margin-top: -12px;"></div>
                                    <div class="col-lg-10">
                                        <h4 class="mb-1 mt-1" style="color: #033067;"><span
                                                    data-plugin="counterup"><?= $tempresults['LOW'] ?> </span></h4>
                                        <p class="mb-0" style="color: #033067;"><?= __("low_temperature") ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center alerts_count">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
                                <div class="card-body badge-soft-success">
                                    <div class="float-left mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/green.png"
                                                alt="Temperature" style="width: 30px;"></div>
                                    <div class="col-xl-10">
                                        <h4 class="mb-1 mt-1" style="color: #044300;"><span
                                                    data-plugin="counterup"><?= $tempresults['NORMAL']; ?></span></h4>
                                        <p class="mb-0" style="color: #044300;"><?= __("normal_temperature") ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #FF9600;">
                                <div class="card-body badge-soft-warning">
                                    <div class="float-left mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/orange.png"
                                                alt="Temperature" style="width: 30px;"></div>
                                    <div class="col-xl-10">
                                        <h4 class="mb-1 mt-1" style="color: #674403;"><span
                                                    data-plugin="counterup"><?= $tempresults['MODERATE'] ?></span></h4>
                                        <p class="mb-0" style="color: #674403;"><?= __("moderate_temperature") ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-<?= $temperatureandlabs ? "12" : "3" ?> col-xm-12 InfosCards text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
                                <div class="card-body badge-soft-danger">
                                    <div class="float-left mt-2"><img
                                                src="<?= base_url(); ?>assets/images/icons/png_icons/red.png"
                                                alt="Temperature" style="width: 30px;"></div>
                                    <div class="col-xl-10">
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup"
                                                                    style="color: #670303;"><?= $tempresults['HIGH'] ?></span>
                                        </h4>
                                        <p class="mb-0" style="color: #670303;"><?= __("high_temperature") ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                            <h4 class="card-title"
                                style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("daily_dashboard_counters_and_percentage_gender") ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><?= __("counters_and_percentage") ?></h3>
                                    <div id="userschart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><?= __("genders") ?></h3>
                                    <div id="genders_bars"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("stay_home_counter_results_for_all_schools_1") ?></h4>
                </div>

                <div class="col-xl-12 mb-4">

                    <?php $this->load->view('Shared/Ministry/inc/schools-cards'); ?>
                </div>

                <div class="col-12">
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("stay_home_counter_results_for_all_schools_2") ?></h4>
                </div>

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body overflow-auto">
                                    <?php $this->load->view('Shared/Ministry/inc/schools-table', ['schools' => $our_schools]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--   DEPARTMENTS SECTION START -->
<!--                <div class="col-12">-->
<!--                    <h4 class="card-title"-->
<!--                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;">--><?php //= __("stay_home_counter_results_for_all_schools_3") ?><!--</h4>-->
<!--                </div>-->
<!---->
<!--                <div class="col-xl-12 mb-4">-->
<!--                    --><?php //$this->load->view('Shared/Ministry/inc/departments-cards'); ?>
<!--                </div>-->
<!---->
<!--                <div class="col-12">-->
<!--                    <h4 class="card-title"-->
<!--                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">--><?php //= __("stay_home_counter_results_for_all_schools_4") ?><!--</h4>-->
<!--                </div>-->
<!---->
<!--                <div class="col-xl-12">-->
<!--                    <div class="row">-->
<!--                        <div class="col-xl-12">-->
<!--                            <div class="card">-->
<!--                                <div class="card-body overflow-auto">-->
<!--                                    --><?php //$this->load->view('Shared/Ministry/inc/departments-table', ['departments' => $departments, "disableStatusControl" => true]); ?>
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!--   DEPARTMENTS SECTION END -->

                <div class="col-xl-12"><br>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("being_user_type") ?></h4>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center"><?= __("well_being") ?></h3>
                                    <div id="wellness_chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center"><?= __("user_type") ?></h3>
                                    <div id="user_types_bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($climate_surveys)) { ?>
                    <div class="col-12">
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -7px;"><?= __("climate_survey_results") ?></h4>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($climate_surveys as $survey) { ?>
                                        <div class="climatesurvey col-xl-4 col-sm-6"
                                             data-category-id="<?= $survey['category_id']; ?>">
                                            <div class="text-center" dir="ltr">
                                                <h5 class="font-size-14 mb-3"><?= $survey['title'] ?></h5>
                                                <input class="knob" data-width="150" data-height="150"
                                                       data-linecap=round
                                                       data-fgColor="#0eacd8" value="<?= round($survey['ff'], 1) ?>"
                                                       data-skin="tron" data-angleOffset="180" data-readOnly=true
                                                       data-thickness=".4"/>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($hasPermissionTo("stay_home_counters")) { ?>
                    <div class="col-12">

                        <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("stay_home_counter_results_for_all_schools_5") ?></h4>
                    </div>

                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">
                                            <div class="float-right">
                                                <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                         id="dropdownMenuButton2" data-toggle="dropdown"
                                                                         aria-haspopup="true"
                                                                         aria-expanded="false"> <span
                                                                class="text-muted" data-toggle="modal"
                                                                data-target="#myModal"><?= __("select_test") ?> <i
                                                                    class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2"
                                                         style="z-index: 100001;">
                                                        <li class="dropdown-item"
                                                            onclick="Tempratur_List('#simpl_home_list','#New_home_List');">
                                                            <?= __("temperature") ?>
                                                        </li>
                                                        <?php foreach ($list_Tests as $test) { ?>
                                                            <li class="dropdown-item"
                                                                onClick="home_labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= __("stay_home") ?> (<span
                                                    id="STAYHOMESHOWTESTNAME"><?= __("temperature") ?></span>)
                                        </h4>
                                        <div data-simplebar style="height: 385px;overflow: auto;">
                                            <div id="simpl_home_list">
                                                <table class="table Table_Data" style="column-width: auto;">
                                                    <thead>
                                                    <th class="Img_School" style="width: 10%;"
                                                        width="5%"><?= __("img") ?></th>
                                                    <th width="30%"><?= __("school_name") ?></th>
                                                    <th style="color: #cdfc00;width: 10%;"
                                                        width="10%;"><?= __("low") ?></th>
                                                    <th class="Risk" style="color: #00ab00;"
                                                        width="10%;"><?= __("no_risk") ?></th>
                                                    <th style="color: #ff8200;width: 10%;"
                                                        width="10%;"><?= __("moderate") ?></th>
                                                    <th style="color: #ff2e00;width: 10%;"
                                                        width="10%;"><?= __("high") ?></th>
                                                    <th style="color: #0F0F0F;width: 10%;"
                                                        width="10%;"><?= __("error") ?></th>
                                                    <th style="color: #50a5f1;width: 10%;"
                                                        width="10%;"><?= __("total") ?></th>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($schools_h as $school) { ?>
                                                        <tr>
                                                            <td>
                                                                <img src="<?= base_url("uploads/avatars/" . ($school['avatar'] ?? "default_avatar.jpg")) ?>"
                                                                     class="avatar-xs rounded-circle "
                                                                     alt="unable to load this avatar"></td>
                                                            <td><?= $school['School_Name'] ?></td>
                                                            <td><span class="badge font-size-12"
                                                                      style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;"><?= $school['low'] ?></span>
                                                            </td>
                                                            <td><span class="badge font-size-12"
                                                                      style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;"><?= $school['normal'] ?></span>
                                                            </td>
                                                            <td><span class="badge font-size-12"
                                                                      style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;"><?= $school['moderate'] ?></span>
                                                            </td>
                                                            <td><span class="badge font-size-12"
                                                                      style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"><?= $school['high'] ?></span>
                                                            </td>
                                                            <td><span class="badge font-size-12"
                                                                      style="width: 100%;border-radius: 10px;background: #272727;color: #fff;"><?= $school['error'] ?></span>
                                                            </td>
                                                            <td style="text-align: right;"><span
                                                                        class="badge badge-info font-size-12"
                                                                        style="width: 100%;"><?= $school['total'] ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="New_home_List"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($hasPermissionTo("quarantine_counters")) { ?>
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("quarantine_counter_results_for_all_schools") ?></h4>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                 id="dropdownMenuButton2"
                                                                 data-toggle="dropdown" aria-haspopup="true"
                                                                 aria-expanded="false"> <span class="text-muted"
                                                                                              data-toggle="modal"
                                                                                              data-target="#myModal"><?= __("select_test") ?><i
                                                            class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2"
                                                 style="z-index: 100001;">
                                                <li class="dropdown-item"
                                                    onclick="Tempratur_List('#simpl_Quaran_list','#New_Quaran_List');">
                                                    <?= __("temperature") ?>
                                                </li>
                                                <?php foreach ($list_Tests as $test) { ?>
                                                    <li class="dropdown-item"
                                                        onClick="quarnt_labTests('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?= __("quarantine") ?> (<span
                                            id="SQUAROMESHOWTESTNAME"> <?= __("temperature") ?></span>)
                                </h4>
                                <div data-simplebar style="height: 385px;overflow: auto;">
                                    <div id="simpl_Quaran_list">
                                        <table class="table Table_Data" style="column-width: auto;">
                                            <thead>
                                            <th class="Img_School" style="width: 10%;" width="5%"><?= __("img") ?></th>
                                            <th width="30%"><?= __("school_name") ?></th>
                                            <th style="color: #cdfc00;width: 10%;" width="10%;"><?= __("low") ?></th>
                                            <th class="Risk" style="color: #00ab00;"
                                                width="10%;"><?= __("no_risk") ?></th>
                                            <th style="color: #ff8200;width: 10%;"
                                                width="10%;"><?= __("moderate") ?></th>
                                            <th style="color: #ff2e00;width: 10%;" width="10%;"><?= __("high") ?></th>
                                            <th style="color: #0F0F0F;width: 10%;" width="10%;"><?= __("error") ?></th>
                                            <th style="color: #50a5f1;width: 10%;" width="10%;"><?= __("total") ?></th>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($schools_h as $school) { ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?= base_url("uploads/avatars/" . ($school['avatar'] ?? "default_avatar.jpg")) ?>"
                                                             class="avatar-xs rounded-circle "
                                                             alt="unable to load this avatar"></td>
                                                    <td><?= $school['School_Name'] ?></td>
                                                    <td><span class="badge font-size-12"
                                                              style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;"><?= $school['low'] ?></span>
                                                    </td>
                                                    <td><span class="badge font-size-12"
                                                              style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;"><?= $school['normal'] ?></span>
                                                    </td>
                                                    <td><span class="badge font-size-12"
                                                              style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;"><?= $school['moderate'] ?></span>
                                                    </td>
                                                    <td><span class="badge font-size-12"
                                                              style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"><?= $school['high'] ?></span>
                                                    </td>
                                                    <td><span class="badge font-size-12"
                                                              style="width: 100%;border-radius: 10px;background: #272727;color: #fff;"><?= $school['error'] ?></span>
                                                    </td>
                                                    <td style="text-align: right;"><span
                                                                class="badge badge-info font-size-12"
                                                                style="width: 100%;"><?= $school['total'] ?></span></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="New_Quaran_List"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($hasPermissionTo("stay_home_counters")) { ?>
                    <div class="col-xl-<?= $hasPermissionTo("quarantine_counters") ? 6 : 12 ?>">
                        <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("stay_home_counter_results_for_all_schools_6") ?></h4>
                        <div class="card" style="border-color: #0eacd8;">
                            <div class="card-body"
                                style="min-height: 465px;text-align: center;background: radial-gradient(rgb(14 172 216 / 18%), rgb(14 172 216 / 39%));">
                                <h5 class="m-0"><span style="color:#0eacd8;text-align:center;"><?= __("stay_home") ?></span>
                                </h5>
                                <?php if (!empty($schools_h)) { ?>
                                    <table style="width: 100%;">
                                        <?php foreach ($schools_h as $schools_high) { ?>
                                            <tr>
                                                <td style="text-align: left;"
                                                    class="text-truncate"><?= $schools_high['School_Name']; ?></td>
                                                <td><span class="badge font-size-12"
                                                        style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?= $schools_high['total']; ?></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } else { ?>
                                    <div style="min-height: 409px;display: grid;align-content: center;align-items: center;">
                                        <div class="text-center">
                                            <div class="avatar-sm mx-auto mb-4"><span
                                                        class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i
                                                            class="mdi mdi-Shield-Alert text-primary"></i> </span></div>
                                            <p class="font-16 text-muted mb-2"></p>
                                            <h5><a href="#" class="text-dark"> <?= __("no_data") ?> </a></h5>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($hasPermissionTo("quarantine_counters")) { ?>
                    <div class="col-xl-<?= $hasPermissionTo("stay_home_counters") ? 6 : 12 ?>">
                        <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                        <h4 class="card-title"
                            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("quarantine_counter_results_for_all_schools_2") ?></h4>
                        <div class="card" style="border-color: #F44336;">
                            <div class="card-body"
                                style="min-height: 465px;text-align: center;background: radial-gradient(rgb(216 14 14 / 18%), rgb(247 204 204 / 39%));">
                                <h5 class="m-0"><span style="color:#ff2e00;text-align:center;"> <?= __("quarantine") ?></h5>
                                <?php if (!empty($schools_q)) { ?>
                                    <table style="width: 100%;">
                                        <?php foreach ($schools_q as $schools_high_q) { ?>
                                            <tr>
                                                <td style="text-align: left;"
                                                    class="text-truncate"><?= $schools_high_q['School_Name']; ?></td>
                                                <td><span class="badge font-size-12"
                                                        style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;"> <?= $schools_high_q['total']; ?></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } else { ?>
                                    <div style="min-height: 409;display: grid;align-content: center;align-items: center;">
                                        <div class="text-center">
                                            <div class="avatar-sm mx-auto mb-4"><span
                                                        class="avatar-title rounded-circle bg-soft-primary font-size-24"> <i
                                                            class="mdi mdi-Shield-Alert text-primary"></i> </span></div>
                                            <p class="font-16 text-muted mb-2"></p>
                                            <h5><a href="#" class="text-dark"> <?= __("no_data") ?> </a></h5>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between"></div>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= __("site_counter_results_for_all_schools") ?></h4>
                </div>
                <div class="col-lg-12" style="padding-right: 0px;">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <div class="float-right">
                                        <div class="dropdown"><a class=" dropdown-toggle" href="#"
                                                                 id="dropdownMenuButton2" data-toggle="dropdown"
                                                                 aria-haspopup="true" aria-expanded="false"> <span
                                                        class="text-muted"><?= __("select_test") ?> <i
                                                            class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2"
                                                 style="z-index: 100001;">
                                                <?php foreach ($list_Tests as $test) { ?>
                                                    <li class="dropdown-item"
                                                        onClick="sites_lab('<?= $test['Test_Desc']; ?>');"><?= $test['Test_Desc']; ?></li>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?= __("list_of_sites") ?> (<span id="sites_showType">--</span>)
                                </h4>
                                <div id="">
                                    <table class="table Table_Data" style="width: 100%;">
                                        <thead>
                                        <th>#</th>
                                        <th class="text-center"><?= __("site_name") ?></th>
                                        <th class="text-center"><?= __("positive") ?></th>
                                        <th class="text-center"><?= __("negative") ?></th>
                                        <th class="text-center"><?= __("sterilization") ?></th>
                                        </thead>
                                        <tbody id="table_sites_data">
                                        </tbody>
                                    </table>
                                </div>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
        <?php /*?><?php $this->load->view('EN/Ministry/inc/climate_dashboard' , ['filters' => true])  ?><?php */ ?>
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script>
    $('.Table_Data').DataTable();
    var Chart_Options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: !0,
            formatter: function (e) {
                return e
            },
            offsetY: -20,
            style: {
                fontSize: "12px",
                colors: ["#FFFFFF"]
            }
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "    <?= __("all") ?>   ",
            data: [<?= implode(',', array_column($labresults['all'], "result")) ?>]
        }, {
            name: "   <?= __("negative") ?>      ",
            data: [<?= implode(',', array_column($labresults['Negative'], "result")) ?>]
        }, {
            name: "    <?= __("positive") ?>   ",
            data: [<?= implode(',', array_column($labresults['Positive'], "result")) ?>]
        }],
        colors: ["#5b73e8", "#34c38f", "#C3343C"],
        xaxis: {
            categories: [<?= implode(',', array_column($labresults['all'], "Test")) ?>]
        },
        yaxis: {
            title: {
                text: "all tests"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (e) {
                    if (e >= 1000) {
                        var th = e.slice(0, 1);
                        return th + " <?= __("thousand") ?>"
                    } else {
                        return e
                    }
                }
            }
        }
    };
    chart = new ApexCharts(document.querySelector("#chart"), Chart_Options);
    chart.render();


    function Tempratur_List(id, emp) {
        if (id == '#simpl_home_list' && emp == '#New_home_List') {
            $('#STAYHOMESHOWTESTNAME').html('<?= strtoupper(__("temperature")) ?>');
        } else if (id == '#simpl_quarantin_list' && emp == '.New_quarantin_List') {
            $('#STAYQuarantineNOSHOWTESTNAME').html('<?= strtoupper(__("temperature")) ?> ');
        } else if (id == '#simpl_staff_list' && emp == '#New_Staff_List') {
            $('#STAFFSNOSHOWTESTNAME').html('<?= strtoupper(__("temperature")) ?> ');
        } else if (id == '#simpl_Teacher_list' && emp == '#New_Teacher_List') {
            $('#TEACHERSSNOSHOWTESTNAME').html('<?= strtoupper(__("temperature")) ?> ');
        }
        $(id).slideDown();
        $(emp).html('');
    }

    function home_labTests(type) {
        $('#STAYHOMESHOWTESTNAME').html(type);
        $('#simpl_home_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/ajax/Get_home_List_Ministry',
            data: {
                IN: 'Home',
                TestDesc: type,
            },
            success: function (data) {
                $('#New_home_List').html(data);
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    function quarnt_labTests(type) {
        $('#SQUAROMESHOWTESTNAME').html(type);
        $('#simpl_Quaran_list').slideUp();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/ajax/Get_home_List_Ministry',
            data: {
                IN: 'Home',
                TestDesc: type,
            },
            success: function (data) {
                $('#New_Quaran_List').html(data);
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    function sites_lab(type) {
        $('#sites_showType').html(type);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/ajax/sites_data_table',
            data: {
                TestName: type,
            },
            success: function (data) {
                $('#table_sites_data').html(data);
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    $(function () {
        $(".knob").knob();
        $('.knob').each(function () {
            const $this = $(this);
            const value = $this.val();
            $(this).val(value + "%");

        });
    });

    var options = {
        chart: {
            height: 350,
            type: 'pie',
        },
        series: [<?= $counters['staff'] ?>, <?= $counters['teachers'] ?>, <?= $counters['students'] ?>, <?= $counters['parents'] ?>],
        labels: ["<?= __("staff") ?>", "<?= __("teachers") ?>", "<?= __("students") ?>", "<?= __("parents") ?>"],
        colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1"],
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            verticalAlign: 'middle',
            floating: false,
            fontSize: '18px',
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: false
                },
            }
        }]
    }
    var chart = new ApexCharts(
        document.querySelector("#userschart"),
        options
    );
    chart.render();


    var options = {
        chart: {
            height: 350,
            type: 'bar',
        },
        tooltip: {
            x: {
                show: false
            },
            y: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            formatter: function (val, opt) {
                return val
            },
            offsetX: 0,
            enabledOnSeries: undefined,
            textAnchor: 'end',
            distributed: false,
            offsetX: 0,
            offsetY: 0,
            style: {
                fontSize: '20px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 'bold',
                colors: undefined
            },
            background: {
                enabled: true,
                foreColor: '#fff',
                padding: 4,
                borderRadius: 2,
                borderWidth: 1,
                borderColor: '#fff',
                opacity: 0.9,
                dropShadow: {
                    enabled: false,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: '#000',
                    opacity: 0.45
                }
            },
            dropShadow: {
                enabled: false,
                top: 1,
                left: 1,
                blur: 1,
                color: '#000',
                opacity: 0.45
            }
        },

        series: [{
            name: '<?= __("males") ?>',
            data: [<?= $genders['m'] ?>]
        }, {
            name: '<?= __("females") ?>',
            data: [<?= $genders['f'] ?>]
        }
        ],
        colors: ['#0070c0', '#ff4da6'],
        xaxis: {
            categories: ["<?= __("males") ?>", "<?= __("females") ?>"],
            fillColor: ['#EB8C87', '#5b9cd6'],
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: true,
                fontSize: '16px',
                offsetX: 0
            },
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#genders_bars"),
        options
    );
    chart.render();


    var chart = new ApexCharts(
        document.querySelector("#wellness_chart"),
        {
            ...options,
            colors: <?= json_encode($colors) ?>,
            xaxis: {
                ...options.xaxis,
                categories: [
                    '<?= __("published_surveys") ?>',
                    '<?= __("expired_surveys") ?>',
                    '<?= __("completed_surveys") ?>',
                    '<?= __("categories") ?>',
                ],
            },
            series: [
                {
                    name: '<?= __("published_surveys") ?>',
                    data: [<?= sizeof($our_surveys); ?>]
                },
                {
                    name: '<?= __("expired_surveys") ?>',
                    data: [<?= sizeof($expired_surveys) ?>]
                },
                {
                    name: '<?= __("completed_surveys") ?>s',
                    data: [<?= sizeof($completed_surveys) ?>]
                },
                {
                    name: '<?= __("categories") ?>',
                    data: [<?= sizeof($used_categorys) ?>]
                }
            ],
        }
    )

    chart.render();

    var chart = new ApexCharts(
        document.querySelector("#user_types_bar"),
        {
            ...options,
            colors: <?= json_encode($colors) ?>,
            xaxis: {
                ...options.xaxis,
                categories: [
                    '<?= __("staff") ?>',
                    '<?= __("teachers") ?>',
                    '<?= __("students") ?>',
                    '<?= __("parents") ?>',
                ],
            },
            series: [
                {
                    name: '<?= __("staff") ?>',
                    data: [<?= $counters['staff'] ?>]
                },
                {
                    name: '<?= __("teachers") ?>',
                    data: [<?= $counters['teachers'] ?>]
                },
                {
                    name: '<?= __("students") ?>',
                    data: [<?= $counters['students'] ?>]
                },
                {
                    name: '<?= __("parents") ?>',
                    data: [<?= $counters['parents'] ?>]
                }
            ],
        }
    )

    chart.render();
</script>
