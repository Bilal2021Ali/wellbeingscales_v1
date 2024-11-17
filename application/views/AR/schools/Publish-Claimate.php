<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" />
<style>
    .type {
        cursor: pointer;
    }

    .type.active {
        background-color: #34c38f;
    }

    .type.active * {
        color: #fff;
    }

    .alert p {
        margin: 0px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">STU 001: CLIMATE</h4>
        <div class="container">
            <div class="col-lg-8 offset-lg-2 mt-5">
                <div class="alert alert-danger" role="alert">
                    ....
                </div>
                <?php if ($show == 1) { ?>
                    <div class="card">
                        <div class="card-body">
                            <h3>1. Select The User type:</h3>
                            <hr>
                            <?php foreach ($types as $type) { ?>
                                <div class="card type" data-id="<?= $type['code'] ?>">
                                    <div class="card-body">
                                        <h3 class="card-title m-0"><i class="uil uil-check"></i> <?= $type['type'] ?> </h3>
                                    </div>
                                </div>
                            <?php } ?>
                            <button class="btn btn-primary btn-block go" disabled>Next step</button>
                        </div>
                    </div>
                    <script>
                        $('.type').click(function() {
                            $('.type').removeClass('active');
                            $(this).addClass('active');
                            $('.btn-primary').removeAttr('disabled');
                        });
                        $('.go').click(function() {
                            location.href = '<?= base_url('EN/schools/Publish-Claimate/') . $id ?>/' + $('.type.active').attr('data-id');
                        });
                    </script>
                <?php } elseif ($show == 2) { ?>
                    <div class="card">
                        <form id="publish_this_serv" class="card-body">
                            <h3>2. Select The Genders <?= in_array($type, ['2', '3']) ? "/ Levels" : "" ?> :</h3>
                            <hr>
                            <div class="form-group">
                                <label for="">Genders : </label>
                                <select class="select2 form-control select2-multiple select-survey-genders" multiple="multiple" data-placeholder="Choose ..." name="gender[]">
                                    <?php foreach ($genders as $gender) { ?>
                                        <option value="<?= $gender['code'] ?>"><?= $gender['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (isset($levels)) { ?>
                                <div class="form-group">
                                    <label for="">Levels : </label>
                                    <select class="select2 form-control select2-multiple select-survey-levels" multiple="multiple" data-placeholder="Choose ..." name="levels[]">
                                        <?php foreach ($levels as $level) { ?>
                                            <option value="<?= $level['Id'] ?>"><?= $level['Class'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="serv_id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-primary btn-block go">Save</button>
                        </form>
                    </div>
                    <script>
                        $("#publish_this_serv").on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url("AR/schools/ClaimateSurveys/") . $type; ?>',
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                beforeSend: function() {
                                    // loading
                                    $('#publish_this_serv button[type="Submit"]').attr('disabled', 'disabled');
                                    $('#publish_this_serv button[type="Submit"]').html('Please wait ..');
                                },
                                success: function(data) {
                                    if (data == "okokokok") {
                                        Swal.fire(
                                            'success',
                                            'Created Successfully...',
                                            'success'
                                        );
                                        setTimeout(() => {
                                            location.href = "<?= base_url("AR/schools/ClaimateSurveys/") ?>";
                                        }, 800);
                                    } else {
                                        Swal.fire(
                                            'error',
                                            'oops!! we have a error , Please check the inputs',
                                            'error'
                                        );
                                    }
                                    $('#publish_this_serv button[type="Submit"]').removeAttr('disabled');
                                    $('#publish_this_serv button[type="Submit"]').html('Publish');
                                },
                                ajaxError: function() {
                                    Swal.fire(
                                        'error',
                                        'oops!! we have a error , Please Try again later',
                                        'error'
                                    );
                                }
                            });
                        });
                    </script>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script>
    $('.alert-danger').slideUp();
    $('.select2').select2({
        closeOnSelect: false
    });
</script>