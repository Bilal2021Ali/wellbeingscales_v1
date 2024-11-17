<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .container {
        display: grid;
        align-items: center;
        align-content: center;
        height: 80vh;
    }

    .noserv_img {
        max-width: 250px;
        width: 100%;
        margin: auto;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <?php if (!empty($surveys) || !empty($fillable_surveys)) { ?>
                <?php if (!empty($fillable_surveys)) { ?>
                    <h3> الإستبيانات الخاصة: </h3>
                    <hr>
                    <div class="row">
                        <?php foreach ($fillable_surveys as $sn => $fillable_survey) { ?>
                            <div class="col-md-4 surveyFillable">
                                <a href="<?= base_url("AR/" . $this->router->fetch_class() . "/start_private_survey/" . $fillable_survey['survey_id']); ?>">
                                    <div class="card bg-warning text-white-50" style="border: 0px;">
                                        <div class="card-body">
                                            <h5 class="mt-0 mb-4 text-white"><i class="uil uil-exclamation-triangle me-3"></i> <?= ($sn + 1) . " . " . $fillable_survey['Title_ar']; ?> </h5>
                                            <p class="card-text text-white"><?= $fillable_survey['Message']; ?></p>
                                            <span class="font-size-10 card-title-desc mt-1 text-white">(من : <?= $fillable_survey['From_date'] ?> , إلى : <?= $fillable_survey['To_date'] ?>)</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                <?php } ?>

                <?php if (!empty($surveys)) { ?>
                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">الإستبيانات</h4>
                    <?php foreach ($surveys as $Key => $survey) { ?>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="<?= base_url("AR/" . $this->router->fetch_class() . "/start_survey/" . $survey['survey_id']); ?>">
                                    <div class="card notstatic survey_element">
                                        <div class="card-body">
                                            <h3 class="card-title"> <?= ($Key + 1) . " . " . $survey['Title_ar']; ?> <span class="font-size-10 card-title-desc float-right"><?= $survey['Created_date'] ?></span> </h3>
                                            <p class="card-title-desc"><?= $survey['Message']; ?></p>
                                            <span class="font-size-10 card-title-desc mt-1">(من: <?= $survey['From_date'] ?> , إلى: <?= $survey['To_date'] ?>)</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php  } ?>

            <?php } else { ?>
                <div class="container text-center">
                    <img src="<?php echo base_url("assets/images/no_surveys_found.svg") ?>" class="noserv_img" alt="">
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>