<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= base_url('assets/FeedBack_survey_page/') ?>fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?= base_url('assets/FeedBack_survey_page/') ?>css/style.css">
</head>

<body>
    <div class="main-content">
        <div class="page-content">
            <div>
                <div class="container">
                    <form method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">
                        <h3></h3>
                        <fieldset>
                            <span class="step-current"> <span class="step-current-content"><span class="step-number"><span>01</span>/03</span></span> </span>
                            <div class="fieldset-flex">
                                <figure>
                                    <img src="<?= base_url('assets/FeedBack_survey_page/') ?>images/signup-img-1.png" alt="">
                                </figure>
                                <div class="fieldset-content">
                                    <h2>What do you think about AU services ?</h2>
                                    <div class="form-flex">
                                        <label for="rating_quanlity">Subject of the questionnaire </label>
                                        <div class="form-rating">
                                            <input type="radio" id="rating_quanlity_5" name="questionnaire" value="5" checked /><label for="questionnaire_5" title="Rocks!"></label>
                                            <input type="radio" id="rating_quanlity_4" name="questionnaire" value="4" checked /><label for="questionnaire_4" title="Pretty good"></label>
                                            <input type="radio" id="rating_quanlity_3" name="questionnaire" value="3" checked /><label for="questionnaire_3" title="Meh"></label>
                                            <input type="radio" id="rating_quanlity_2" name="questionnaire" value="2" /><label for="questionnaire_2" title="Kinda bad"></label>
                                            <input type="radio" id="rating_quanlity_1" name="questionnaire" value="1" /><label for="questionnaire_1" title="Sucks big time"></label>
                                        </div>
                                    </div>
                                    <div class="form-flex">
                                        <label for="rating_use">Ease of understanding questions</label>
                                        <div class="form-rating">
                                            <input type="radio" id="rating_use_5" name="questions" value="5" /><label for="questions_5" title="Rocks!"></label>
                                            <input type="radio" id="rating_use_4" name="questions" value="4" /><label for="questions_4" title="Pretty good"></label>
                                            <input type="radio" id="rating_use_3" name="questions" value="3" /><label for="questions_3" title="Meh"></label>
                                            <input type="radio" id="rating_use_2" name="questions" value="2" /><label for="questions_2" title="Kinda bad"></label>
                                            <input type="radio" id="rating_use_1" name="questions" value="1" /><label for="questions_1" title="Sucks big time"></label>
                                        </div>
                                    </div>
                                    <div class="form-flex">
                                        <label for="rating_features">Ease of understanding the options</label>
                                        <div class="form-rating">
                                            <input type="radio" id="rating_features_5" name="options" value="5" /><label for="options_5" title="Rocks!"></label>
                                            <input type="radio" id="rating_features_4" name="options" value="4" /><label for="options_4" title="Pretty good"></label>
                                            <input type="radio" id="rating_features_3" name="options" value="3" /><label for="options_3" title="Meh"></label>
                                            <input type="radio" id="rating_features_2" name="options" value="2" /><label for="options_2" title="Kinda bad"></label>
                                            <input type="radio" id="rating_features_1" name="options" value="1" /><label for="options_1" title="Sucks big time"></label>
                                        </div>
                                    </div>
                                    <div class="form-flex">
                                        <label for="rating_features">Ease of interaction with the questionnaire <br> (clarity of the buttons ...)</label>
                                        <div class="form-rating">
                                            <input type="radio" id="rating_features_5" name="interaction" value="5" /><label for="interaction_5" title="Rocks!"></label>
                                            <input type="radio" id="rating_features_4" name="interaction" value="4" /><label for="interaction_4" title="Pretty good"></label>
                                            <input type="radio" id="rating_features_3" name="interaction" value="3" /><label for="interaction_3" title="Meh"></label>
                                            <input type="radio" id="rating_features_2" name="interaction" value="2" /><label for="interaction_2" title="Kinda bad"></label>
                                            <input type="radio" id="rating_features_1" name="interaction" value="1" /><label for="interaction_1" title="Sucks big time"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h3></h3>
                        <fieldset>
                            <span class="step-current"><span class="step-current-content"><span class="step-number"><span>02</span>/03</span></span></span>
                            <div class="fieldset-flex">
                                <figure>
                                    <img src="<?= base_url('assets/FeedBack_survey_page/') ?>images/signup-img-2.png" alt="">
                                </figure>
                                <div class="fieldset-content">
                                    <div class="form-textarea">
                                        <label for="your_review" class="form-label">Your Review (optional)</label>
                                        <textarea name="your_review" id="your_review" placeholder="Write your comment here"></textarea>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h3></h3>
                        <fieldset>
                            <span class="step-current"><span class="step-current-content"><span class="step-number"><span>03</span>/03</span></span></span>
                            <div class="fieldset-flex">
                                <figure>
                                    <img src="<?= base_url('assets/FeedBack_survey_page/') ?>images/signup-img-3.png" alt="">
                                </figure>
                                <div class="fieldset-content text-center" style="display: grid;align-items: center;">
                                    <h6>Thank you so mush for you time </h6>
                                    <p>We appreciate your time that you spent in giving us your opinion,
                                        you can press the Submit button to receive your respected opinions,
                                        or go back to check and correct if you want them, take your time 🖤</p>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- JS -->
    <script src="<?= base_url('assets/FeedBack_survey_page/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/FeedBack_survey_page/') ?>vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/FeedBack_survey_page/') ?>vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="<?= base_url('assets/FeedBack_survey_page/') ?>vendor/jquery-steps/jquery.steps.min.js"></script>
    <script>
        (function($) {

            var form = $("#signup-form");
            form.steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "fade",
                labels: {
                    previous: 'Prev',
                    next: 'Next',
                    finish: 'Submit',
                    current: ''
                },
                titleTemplate: '<h3 class="title">#title#</h3>',
                onStepChanging: function(event, currentIndex, newIndex) {
                    if (currentIndex === 0) {

                        form.find('.content .body .step-current-content').find('.step-inner').removeClass('.step-inner-0');
                        form.find('.content .body .step-current-content').find('.step-inner').removeClass('.step-inner-1');
                        form.find('.content .body .step-current-content').append('<span class="step-inner step-inner-' + currentIndex + '"></span>');
                    }
                    if (currentIndex === 1) {
                        form.find('.content .body .step-current-content').find('.step-inner').removeClass('step-inner-0').addClass('step-inner-' + currentIndex + '');
                    }
                    return true;
                },
                onFinished: function(event, currentIndex) {
                    event.preventDefault();
                    var questionnaire = $('input[name="questionnaire"]').val();
                    var questions = $('input[name="questions"]').val();
                    var options = $('input[name="options"]').val();
                    var interaction = $('input[name="interaction"]').val();
                    var your_review = $('input[name="your_review"]').val();
                    var review_key = <?= $enter_key // passed from controller ?>;
                    // start submit 
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>EN/Users/startlogin',
                        data: {
                            "questionnaire": questionnaire,
                            "questions": questions,
                            "options": options,
                            "interaction": interaction,
                            "your_review": your_review,
                            "key": review_key,
                        },
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            // loagin animation
                            $('')
                        },
                        success: function(data) {
                            // when added
                        },
                        ajaxError: function() {
                            $('.alert.alert-info').css('background-color', '#DB0404');
                            $('.alert.alert-info').html("Ooops! Error was found.");
                        }
                    });
                }
            });

            $(".toggle-password").on('click', function() {
                $(this).toggleClass("zmdi-eye zmdi-eye-off");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
            // for check if user use mobile
            function isMobile() {
                var check = false;
                (function(a) {
                    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
                        check = true;
                })(navigator.userAgent || navigator.vendor || window.opera);
                return check;
            };

            function checkbname() {
                var nVer = navigator.appVersion;
                var nAgt = navigator.userAgent;
                var browserName = navigator.appName;
                var fullVersion = '' + parseFloat(navigator.appVersion);
                var majorVersion = parseInt(navigator.appVersion, 10);
                var nameOffset, verOffset, ix;

                // In Opera 15+, the true version is after "OPR/" 
                if ((verOffset = nAgt.indexOf("OPR/")) != -1) {
                    browserName = "Opera";
                    fullVersion = nAgt.substring(verOffset + 4);
                }
                // In older Opera, the true version is after "Opera" or after "Version"
                else if ((verOffset = nAgt.indexOf("Opera")) != -1) {
                    browserName = "Opera";
                    fullVersion = nAgt.substring(verOffset + 6);
                    if ((verOffset = nAgt.indexOf("Version")) != -1)
                        fullVersion = nAgt.substring(verOffset + 8);
                }
                // In MSIE, the true version is after "MSIE" in userAgent
                else if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
                    browserName = "Microsoft Internet Explorer";
                    fullVersion = nAgt.substring(verOffset + 5);
                }
                // In Chrome, the true version is after "Chrome" 
                else if ((verOffset = nAgt.indexOf("Chrome")) != -1) {
                    browserName = "Chrome";
                    fullVersion = nAgt.substring(verOffset + 7);
                }
                // In Safari, the true version is after "Safari" or after "Version" 
                else if ((verOffset = nAgt.indexOf("Safari")) != -1) {
                    browserName = "Safari";
                    fullVersion = nAgt.substring(verOffset + 7);
                    if ((verOffset = nAgt.indexOf("Version")) != -1)
                        fullVersion = nAgt.substring(verOffset + 8);
                }
                // In Firefox, the true version is after "Firefox" 
                else if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
                    browserName = "Firefox";
                    fullVersion = nAgt.substring(verOffset + 8);
                }
                // In most other browsers, "name/version" is at the end of userAgent 
                else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) <
                    (verOffset = nAgt.lastIndexOf('/'))) {
                    browserName = nAgt.substring(nameOffset, verOffset);
                    fullVersion = nAgt.substring(verOffset + 1);
                    if (browserName.toLowerCase() == browserName.toUpperCase()) {
                        browserName = navigator.appName;
                    }
                }
                // trim the fullVersion string at semicolon/space if present
                if ((ix = fullVersion.indexOf(";")) != -1)
                    fullVersion = fullVersion.substring(0, ix);
                if ((ix = fullVersion.indexOf(" ")) != -1)
                    fullVersion = fullVersion.substring(0, ix);

                majorVersion = parseInt('' + fullVersion, 10);
                if (isNaN(majorVersion)) {
                    fullVersion = '' + parseFloat(navigator.appVersion);
                    majorVersion = parseInt(navigator.appVersion, 10);
                }

                return ('Browser name  = ' + browserName + '<br>' +
                    'Full version  = ' + fullVersion + '<br>' +
                    'Major version = ' + majorVersion + '<br>' +
                    'navigator.appName = ' + navigator.appName + '<br>' +
                    'navigator.userAgent = ' + navigator.userAgent + '<br>');
            }
        })(jQuery);
    </script>
</body>

</html>