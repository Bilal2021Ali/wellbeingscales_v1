<div class="main-content">
    <div class="page-content">
        <?php if ($surveys) { ?>
            <div class="row">
                <?php foreach ($surveys as $sn => $survey) { ?>
                    <div class="col-md-4">
                        <a href="<?= base_url("EN/" . $this->router->fetch_class() . "/DedicatedSurvey/" . $survey['survey_id']); ?>">
                            <div class="card notstatic survey_element">
                                <div class="card-body">
                                    <h3 class="card-title"> <?= ($sn + 1) . " . " . $survey['Title_en']; ?> <span class="mt-1 font-size-10 card-title-desc float-right"><?= $survey['Created_date'] ?></span> </h3>
                                    <p class="card-title-desc"><?= $survey['Message']; ?></p>
                                    <span class="font-size-15 card-title-desc mt-1">Targeted students : <?= $survey['students_count'] ?> </span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="container text-center">
                <img src="<?php echo base_url("assets/images/no_surveys_found.svg") ?>" class="noserv_img" alt="">
            </div>
        <?php } ?>
    </div>
</div>