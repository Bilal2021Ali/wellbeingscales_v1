<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .verti-timeline {
            max-height: 90vh;
            overflow: auto;
        }

        .privateSurvey .event-date{
            background-color: rgb(232 91 91 / 20%) !important;
        }

        .privateSurvey .verti-timeline .event-list:after {
            border: 2px solid #f46a6a !important;
        }
    </style>
</head>
<body>
    <div class="main-content"> 
        <div class="page-content">
		<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MY HISTORY</h4>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card notstatic">
                        <div class="card-body">
                            <h4 class="card-title mb-5">List of Completed Surveys</h4>
                            <?php if(!empty($surveys) || !empty($private_surveys) ){ ?>
                                <?php if(!empty($surveys)){ ?>
                                    <div class="">
                                        <ul class="verti-timeline list-unstyled">
                                            <?php foreach($surveys as $survey){ ?>
                                            <?php $answer_data = $newDate = date("M-d", strtotime($survey['answer_date']));   ?>
                                            <?php 
                                            if($survey['To_date'] < date('Y-m-d')){
                                                $expred = "Expired";
                                            }else{
                                                $expred = $survey['To_date'];
                                            }
                                            $answer_data = $newDate = date("M-d", strtotime($survey['answer_date']));
                                            ?>
                                            <li class="event-list">
                                                <div class="event-date text-primar"><span><?php echo $answer_data ?> </span></div>
                                                <h5><?php echo $survey['Title_en']; ?><span class="text-muted font-size-10 float-right"><?php echo $expred ?></h5>
                                                       
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php }  ?> 
                                <?php if(!empty($private_surveys)) { ?>
                                    <div class="privateSurvey">
                                        <ul class="verti-timeline list-unstyled">
                                            <?php foreach($private_surveys as $survey){ ?>
                                            <?php $answer_data = $newDate = date("M-d", strtotime($survey['answer_date']));   ?>
                                            <?php 
                                            if($survey['To_date'] < date('Y-m-d')){
                                                $expred = "Expired";
                                            }else{
                                                $expred = $survey['To_date'];
                                            }
                                            $answer_data = $newDate = date("M-d", strtotime($survey['answer_date']));
                                            ?>
                                            <li class="event-list">
                                                <div class="event-date text-danger"><span><?php echo $answer_data ?></span></div>
                                                <h5><?php echo $survey['Title_en']; ?><span class="badge rounded-pill bg-soft-danger font-size-12 text-danger ml-2">Private</span><span class="text-muted font-size-10 float-right"><?php echo $expred ?></h5>
                                                     
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            <?php }else{ ?>
                                <img src="<?php echo base_url("assets/images/register-img.png"); ?>" class="w-100" alt="">
                                <h3 class="w-100 text-center">You haven't filled out any questionnaires.</h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>