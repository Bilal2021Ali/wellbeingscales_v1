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
            <div class="row">
                <?php if(!empty($surveys)){ ?>
                    <?php foreach($surveys as $Key=>$survey){ ?>
                        <div class="col-md-4">
                            <a href="<?php echo base_url("AR/Parents/start_survey/".$survey['survey_id']); ?>">
                                <div class="card notstatic">
                                    <div class="card-body">
                                        <h3 class="card-title"> <?php echo ($Key+1)." . ".$survey['Title_ar']; ?> <span class="font-size-10 card-title-desc float-right"><?php echo $survey['Created_date'] ?></span> </h3>
                                        <p class="card-title-desc"><?php echo $survey['Message']; ?></p>
                                        <span class="font-size-10 card-title-desc mt-1">(من: <?php echo $survey['From_date'] ?> , إلى: <?php echo $survey['To_date'] ?>)</span> 
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="container text-center">
                        <img src="<?php echo base_url("assets/images/no_surveys_found.svg") ?>" class="noserv_img" alt="">
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>