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
    </style>
</head>
<body>
    <div class="main-content"> 
        <div class="page-content">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card notstatic">
                        <div class="card-body">
                            <h4 class="card-title mb-5"> أرشيف الاستبيانات </h4>
                            <div class="">
                                <ul class="verti-timeline list-unstyled">
                                    <?php foreach($surveys as $survey){ ?>
                                    <?php $answer_data = $newDate = date("M-d", strtotime($survey['answer_date']));   ?>
                                    <?php 
                                    if($survey['To_date'] < date('Y-m-d')){
                                        $expred = "expired";
                                    }else{
                                        $expred = $survey['To_date'];
                                    }
                                    $answer_data = $newDate = date("M-d", strtotime($survey['answer_date']));
                                    ?>
                                    <li class="event-list">
                                        <div class="event-date text-primar"><?php echo $answer_data ?> </span></div>
                                        <h5><?php echo $survey['Title_ar']; ?><span class="text-muted font-size-10 float-right"><?php echo $expred ?></h5>
                                        <p class="text-muted"><?php echo $survey['Message']; ?></p>       
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>