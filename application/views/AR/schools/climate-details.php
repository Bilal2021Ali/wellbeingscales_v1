<style>
    .img-icon {
        width: 50px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php foreach ($climate_survyes as $survey) { ?>
                <div class="card">
                    <div class="card-body">
                        <h1 class="card text-center"
                            style="background: #add138; padding: 30px;color: #2E1E1E;border-radius: 20px;"><?= $survey['set_name_ar'] ?> </h1>
                        <hr>
                        <p><?= $serv_data['reference'] ?? "--" ?></p>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card" style="background : #98d077;">
                                    <div class="card-body">
                                        <h3 class="text-white">
                                            <img class="img-icon"
                                                 src="<?= base_url("assets/images/forcharts/Respondents.png") ?>"
                                                 alt="">
                                            مجموع المشاركين
                                            <span class="float-right"><?= $this->sv_school_reports->GetClimatesurveys(['surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?></span>
                                        </h3>
                                        <h3 class="text-white"><img class="img-icon"
                                                                    src="<?= base_url("assets/images/forcharts/male_counter.png") ?>"
                                                                    alt=""> الذكور <span
                                                    class="float-right"><?= $this->sv_school_reports->GetClimatesurveys(['gender' => "M", 'surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?></span>
                                        </h3>
                                        <h3 class="mb-0 text-white"><img class="img-icon"
                                                                         src="<?= base_url("assets/images/forcharts/female_counter.png") ?>"
                                                                         alt=""> الإناث <span
                                                    class="float-right"><?= $this->sv_school_reports->GetClimatesurveys(['gender' => "F", 'surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?></span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card" style="background : #98d077;">
                                    <div class="card-body">
									<h3 class="mb-0 text-white"><img class="img-icon"
                                                                         src="<?= base_url("assets/images/forcharts/teachers.png") ?>"
                                                                         style="width:55px" alt=""> المعلمين
                                            <span class="float-right"><?= $this->sv_school_reports->GetClimatesurveys(['usertype' => 3, 'surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?></span>
                                        </h3>
                                        <h3 class="text-white"><img class="img-icon"
                                                                    src="<?= base_url("assets/images/forcharts/Staffs.png") ?>"
                                                                    style="width:55px" alt=""> الموظفين <span
                                                    class="float-right"> <?= $this->sv_school_reports->GetClimatesurveys(['usertype' => 1, 'surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?> </span>
                                        </h3>
                                        <h3 class="text-white"><img class="img-icon"
                                                                    src="<?= base_url("assets/images/forcharts/Students.png") ?>"
                                                                    style="width:55px" alt=""> الطلاب <span
                                                    class="float-right"> <?= $this->sv_school_reports->GetClimatesurveys(['usertype' => 2, 'surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?> </span>
                                        </h3>
                                        <h3 class="text-white"><img class="img-icon"
                                                                    src="<?= base_url("assets/images/forcharts/Parents.png") ?>"
                                                                    style="width:55px" alt=""> أولياء الأمور <span
                                                    class="float-right"><?= $this->sv_school_reports->GetClimatesurveys(['usertype' => 4, 'surveyid' => $survey['survey_id']])[0]['answers_counter'] ?? 0 ?></span>
                                        </h3>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 px-5 default-choices-colors"
                                 style="display: grid;align-items: center;">
                                <?php $choices = $this->sv_school_reports->ClimateChoices(['surveyid' => $survey['survey_id']]); ?>
                                <div class="row">
                                    <?php foreach ($choices as $sn => $used_choice) { ?>
                                        <div class="text-center col">
                                            <?= $used_choice['title_ar'] ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <?php foreach ($choices as $sn => $used_choice) { ?>
                                        <div class="choice col p-2 <?= $sn == 0 ? 'start-b-r' : '' ?>"
                                             style="background-color: <?= $colors[$sn]; ?>"></div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <?php foreach ($choices as $sn => $used_choice) { ?>
                                        <div class="text-center col">
                                            <?= $used_choice['ChooseingTimes'] ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <p class="mt-2">
                                    <br><b>التصنيف:</b> <?= $survey['Cat_ar'] ?>
                                    <br><b>الاستبيان:</b> <?= $survey['set_name_ar'] ?> <br>
                                    <br>
                                <h3> السؤال: <?= $survey['question'] ?></h3> <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>