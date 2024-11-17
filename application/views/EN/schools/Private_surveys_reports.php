<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/owl.carousel/assets/owl.theme.default.min.css">
<style>
    .count_in_list {
        width: 120px !important;
        height: 120px !important;
        margin: auto;
    }

    .showingmethod {
        display: flex;
    }

    .showingmethod i {
        font-size: 20px;
        float: right;
        margin: 5px;
    }

    .showingmethod button {
        border: 0px;
        background-color: transparent;

}
</style>
<style>
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }
    .user_answered {
        cursor: pointer;
    }
    .zoom-in {
        transform: scale(0) !important;
        opacity: 0;
        -webkit-transition: 0.5s all 0s;
        -moz-transition: 0.5s all 0s;
        -ms-transition: 0.5s all 0s;
        -o-transition: 0.5s all 0s;
        transition: 0.5s all 0s;
        display: block !important;
    }

    .zoom-in.show {
        opacity: 1;
        transform: scale(1) !important;
        transform: none;
    }

    .floating_action_btn:hover {
        transform: rotateZ(45deg);
    }

    .empty {
        width: 100%;
        text-align: center;
    }

    .empty img {
        width: 240px;
        margin-bottom: 10px;
    }

    .group_content {
        height: 500px;
        overflow: auto;
    }
    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px; 
    } 

    .returnuserslist .feed-item {
        width: 100%;
        border: 2px dotted transparent;
    }
    .returnuserslist .feed-item:hover {
        border: 2px dotted #5b73e8 !important;
        border-radius: 5px;
        padding-top: 10px;
    }

</style>
<div class="main-content">
    <div class="page-content">
	<div class="row">
					<div class="col-12">
                    <div class="card">
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div><br>
			<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">REP 045: Interview Guide Reports</h4>
        <div class="modal fade zoom-in" id="userspassedsurvey" tabindex="-1" role="dialog" aria-labelledby="userspassedsurveyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userspassedsurveyModalLabel">List of Users <span>(15 User Passed out of 65)</span> : </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title mb-4">Recent Activity</h4>
                        <div class="w-100 " data-simplebar style="height: 386px;">
                            <ol class="activity-feed mb-0 pl-2 all active returnuserslist">

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade zoom-in" id="user_answers" tabindex="-1" role="dialog" aria-labelledby="user_answersModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="user_answersModalLabel">Answers: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="w-100 " data-simplebar style="height: 386px;">
                            <ol class="activity-feed mb-0 pl-2 all active returnanswerslist">

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="showingmethod">
                            <button type="button" class="changer" data-type="list" ><i class="uil uil-list-ul <?= $active_type == "list" ? "text-primary" : "" ?>"></i></button>
                            <button type="button" class="changer" data-type="owl" ><i class="uil uil-grids <?= $active_type == "owl" ? "text-primary" : "" ?>"></i></button>
                    </div>
                    <?php if($active_type == "owl"){ ?>
                    <div class="hori-timeline mt-5" dir="ltr">
                        <div class="owl-carousel owl-theme navs-carousel events" id="our_surveys_list">
                            <?php foreach ($surveys as $survey) { ?>
                                <div class="item ml-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                    <strong class="display-4 m-0 text-primary" style="font-family: 'Almarai';"><?= $survey['passedUsers']; ?></strong>
                                                </div>
                                            </div>
                                            <span>Survey Code: Surv-<?= $survey['survey_id'] ?></span>
                                            <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $survey['Title_en']; ?></a></h5>
                                            <p class="text-muted mb-2"><?= 'From :' . $survey['From_date'] . ' <br> To :' . $survey['To_date'] ?></p>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <?php if ($survey['report_link'] !== null) { ?>
                                                <a href="<?= base_url('uploads/Category_resources/EN/') . $survey['report_link'] ?>" class="w-100 text-center"><button type="button" class="w-100 btn btn-outline-light text-truncate"><i class="uil uil-user me-1"></i> Reports </button></a>
                                            <?php } else { ?>
                                                <button data-toggle="modal" data-target="#userspassedsurvey" type="button" data-survey-id="<?= $survey['survey_id'] ?>" class="w-100 btn btn-outline-light text-truncate showanswereuser"><i class="uil uil-users-alt me-1"></i> User Answers :</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="row mt-5">
                        <?php foreach ($surveys as $survey) { ?>
                            <div class="col-md-3">
                                <div class="item ml-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list">
                                                    <strong class="display-4 m-0 text-primary" style="font-family: 'Almarai';"><?= $survey['passedUsers']; ?></strong>
                                                </div>
                                            </div>
                                            <span>Survey Code: Surv-<?= $survey['survey_id'] ?></span>
                                            <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $survey['Title_en']; ?></a></h5>
                                            <p class="text-muted mb-2"><?= 'From :' . $survey['From_date'] . ' <br> To :' . $survey['To_date'] ?></p>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <?php if ($survey['report_link'] !== null) { ?>
                                                <a href="<?= base_url('uploads/Category_resources/EN/') . $survey['report_link'] ?>" class="w-100 text-center"><button type="button" class="w-100 btn btn-outline-light text-truncate"><i class="uil uil-user me-1"></i> Reports </button></a>
                                            <?php } else { ?>
                                                <button data-toggle="modal" data-target="#userspassedsurvey" type="button" data-survey-id="<?= $survey['survey_id'] ?>" class="w-100 btn btn-outline-light text-truncate showanswereuser"><i class="uil uil-users-alt me-1"></i> User Answers:</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
<script>
    $('#our_surveys_list').owlCarousel({
        items: 1,
        loop: false,
        margin: 0,
        nav: true,
        navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
        dots: false,
        responsive: {
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            1200: {
                items: 4
            },
        }
    });

    $('body').on('click', '.showanswereuser', function() {
        var survey_id = $(this).attr('data-survey-id');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/listofansererusersinprivatsurvey',
            data: {
                survey_id: survey_id,
            },
            beforeSend: function() {
                $('.returnuserslist').html('Please wait......');
            },
            success: function(data) {
                $('.returnuserslist').html('');
                if(data.status == "ok"){
                    var users = data.users;
                    $('#userspassedsurveyModalLabel span').html("("+ data.passed_counter +" Users Passed, out of "+ data.all_counter +") ")
                    users.forEach(user => {
                        var newhtml =  '<li class="feed-item user_answered" data-answer-id="'+ user.answer_id +'">';
                            newhtml += '<p class="text-muted mb-1 font-size-13"> User Name: '+ user.name +' , finished at : <small class="d-inline-block ml-1">'+ user.Finished_at +'</small></p>';
                            newhtml += '<p class="mt-0 mb-0">User Type: '+ user.type.charAt(0).toUpperCase() + user.type.slice(1) +' </p>';
                            newhtml += '<p class="mt-0 mb-0">Finishing Time: '+ user.Finish_time +' </p>';
                            newhtml += '</li>';
                            $('.returnuserslist').append(newhtml);
                    });
                }else{
                    $('.returnuserslist').html('sorry , we have an errror');
                }
            },
            ajaxError: function() {
                $('#ResultsTableStudents').css('background-color', '#DB0404');
                $('#ResultsTableStudents').html("Ooops! Error was found.");
            }
        });
    });
    
    $('.returnuserslist').on("click" , '.user_answered' , function(){
        var answer_id = $(this).attr('data-answer-id');
        $('#userspassedsurvey').modal('hide');
        $('#user_answers').modal('show');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/schools/listofansererusersinprivatsurvey',
            data: {
                answer_id: answer_id,
            },
            beforeSend: function() {
                $('.returnanswerslist').html('Please wait......');
            },
            success: function(data) {
                $('.returnanswerslist').html('');
                if(data.status == "ok"){
                    var answers = data.answers;
                    var sn = 0;
                    answers.forEach(answer => {
                        sn++;
                        var newhtml =  '<li class="feed-item">';
                            newhtml += '<p class="text-muted mb-1 font-size-13">Question ' + sn + ' : </p>';
                            newhtml += '<p class="mt-0 mb-0"> question: '+ answer.question +' </p>';
                            newhtml += '<p class="mt-0 mb-0"> Answer : '+ answer.answer_Value +' </p>';
                            newhtml += '</li>';
                            $('.returnanswerslist').append(newhtml);
                    });
                }else{
                    $('.returnanswerslist').html('sorry , we have an errror');
                }
            },
            ajaxError: function() {
                $('#ResultsTableStudents').css('background-color', '#DB0404');
                $('#ResultsTableStudents').html("Ooops! Error was found.");
            }
        });
    });
    $('.changer').click(function(){
        location.href = "<?= base_url("EN/schools/Private_surveys"); ?>?type=" + $(this).attr('data-type')
    });
</script>