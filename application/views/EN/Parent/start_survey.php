<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/kineticjs/5.2.0/kinetic.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.enjoyhint.css'); ?>">
</head>
<?php 
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https:/" : "http:/";  
    $CurPageURL = $protocol ."/". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
    $ar_link = str_replace('EN','AR',$CurPageURL);
?>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row pl-4">
                <h3><?= $serv_data[0]['Title_en']; ?></h3><br>
                <p class="text-muted col-12 p-0"><?= $serv_data[0]['Message']  ?><a href="<?= $ar_link ?>" class="btn float-right change_lange">arabic version</a></p>
                
            </div>
            <div class="row">
                <div class="container">
                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-body">
                            <div class="alert alert-danger" role="alert" style="display: none;"></div>
                                <form id="my_answers" token="<?= md5(time()); ?>" method="post">
                                    <input type="hidden" name="choices" value="<?= sizeof($questions); ?>"> 
                                    <table class="table">
                                        <thead>
                                            <th>#</th>
                                            <th>question</th>
                                            <th>Choices</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach($questions as $question_key=>$question): ?>
                                            <tr>
                                                <td><?= $question_key+1 ?></td>
                                                <td><?= $question['en_title'] ?></td>
                                                <td>
                                                    <div class="mt-4 mt-lg-0 form-inline">
                                                        <?php foreach($choices as $key=>$choice): ?>
                                                        <div class="custom-control custom-radio mb-3 mr-2">
                                                            <input type="radio" id="customRadio_<?= $question_key."_".$key  ?>" value="<?= $choice['Id'].'_'.$question['Id'] ?>" name="answer_<?= $question_key  ?>" class="custom-control-input">
                                                            <label class="custom-control-label" for="customRadio_<?= $question_key."_".$key  ?>"><?= $choice['title_en'] ?></label>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary waves-effect waves-light add_here" type="Submit"> Submit Answers </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?= base_url('assets/js/enjoyhint.min.js'); ?>"></script>
<script>
if(!localStorage.getItem('change_lang')){
var enjoyhint_instance = new EnjoyHint({
    onEnd:function(){
        localStorage.setItem('change_lang',true);
    },
    onSkip: function name() {
        localStorage.setItem('change_lang',true);
    }
});
var enjoyhint_script_steps = [
  {
    'click .change_lange ' : 'You can click here to use arabic version of this survey !!'
  }  
];

enjoyhint_instance.set(enjoyhint_script_steps);
enjoyhint_instance.run();
}

$("#my_answers").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?= base_url(); ?>EN/Parents/start_survey?serv=<?= $serv_id; ?>&time=<?= date('H:i:s'); ?>',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            $('.alert').slideUp();
            $('button[type="Submit"]').attr('disabled','');
            $('button[type="Submit"]').html("Please wait...");
          },
          success: function (data) {
            if(data !== "ok"){
                $('.alert').slideDown();
                $('.alert').html(data);
                $('button[type="Submit"]').removeAttr('disabled','');
                $('button[type="Submit"]').html("Save");
            }else{
                $('.alert').slideDown();
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-success');
                $('.alert').html('success , Thank you for your time.');
                setTimeout(function(){
                    location.href = "<?= base_url("EN/Parents/Show_surveys"); ?>";
                },1000);
            }  
          },
          ajaxError: function(){
               $('.alert').css('background-color','#DB0404');
               $('.alert').html("Ooops! Error was found.");
          }
     });
});
</script>
</html>