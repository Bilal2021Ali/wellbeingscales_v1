<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row pl-4">
                <h3><?= $serv_data[0]['Title_en']; ?></h3><br>
                <p class="text-muted col-12 p-0"><?= $serv_data[0]['Message']  ?></p>
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
                                            <th>السؤال</th>
                                            <th>الإجابات</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach($questions as $question_key=>$question): ?>
                                            <tr>
                                                <td><?= $question_key+1 ?></td>
                                                <td><?= $question['ar_title'] ?></td>
                                                <td>
                                                    <div class="mt-4 mt-lg-0 form-inline">
                                                        <?php foreach($choices as $key=>$choice): ?>
                                                        <div class="custom-control custom-radio mb-3 mr-2">
                                                            <input type="radio" id="customRadio_<?= $question_key."_".$key  ?>" value="<?= $choice['Id'].'_'.$question['Id'] ?>" name="answer_<?= $question_key  ?>" class="custom-control-input">
                                                            <label class="custom-control-label" for="customRadio_<?= $question_key."_".$key  ?>"><?= $choice['title_ar'] ?></label>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary  waves-effect waves-light" type="Submit"> حفظ </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
$("#my_answers").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?= base_url(); ?>AR/Students/start_survey?serv=<?= $serv_id; ?>&time=<?= date('H:i:s'); ?>',
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
                $('.alert').html('success , Thank you for your time !!');
                setTimeout(function(){
                    location.href = "<?= base_url("AR/Students/Show_surveys"); ?>";
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