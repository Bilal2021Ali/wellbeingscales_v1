<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
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

    .alert p{
        margin: 0px;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">STU 001: SPEAK OUT</h4>
            <div class="container">
                <div class="col-lg-8 offset-lg-2 mt-5">
                    <div class="alert alert-danger" role="alert">
                        ....
                    </div>
                    <?php if ($show == 1) { ?>
                        <div class="card">
                            <div class="card-body">
                                <h3>1. Select the complaint type:</h3>
                                <hr>
                                <?php foreach ($groups as $group) { ?>
                                    <div class="card type" data-id="<?= $group['Id'] ?>">
                                        <div class="card-body">
                                            <h3 class="card-title m-0"><i class="uil uil-check"></i> <?= $group['title_en'] ?> </h3>
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
                                location.href = '<?= base_url('EN/Students/Mylifereports') ?>/' + $('.type.active').attr('data-id');
                            });
                        </script>
                    <?php } elseif ($show == 2) { ?>
                        <div class="card">
                            <div class="card-body">
                                <h3>2. Select the complaint topic:</h3>
                                <hr>
                                <?php foreach ($groups as $group) { ?>
                                    <div class="card type" data-id="<?= $group['Id'] ?>">
                                        <div class="card-body">
                                            <h3 class="card-title m-0"><i class="uil uil-check"></i> <?= $group['title_en'] ?> </h3>
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
                                location.href = '<?= current_url() ?>/' + $('.type.active').attr('data-id');
                            });
                        </script>
                    <?php } elseif ($show == 3) { ?>
                        <div class="card">
                            <form class="card-body" id="creat">
                                <h3>3. Description:</h3>
                                <hr>
                                <label for="">Problem description: </label>
                                <textarea name="description_en" id="" cols="30" rows="10" class="form-control mb-2" placeholder="Description in en..."></textarea>
                                <textarea name="description_ar" id="" cols="30" rows="10" class="form-control mb-2" placeholder="Description in ar..."></textarea>
                                <input type="hidden" value="<?= $group ?>" name="groupid">
                                <input type="hidden" value="<?= $choice ?>" name="choiceid">
                                <p>If you have any media/file (photo, video or audio file), kindly check the box below. </p>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="phontos" class="custom-control-input" id="phontos">
                                    <label class="custom-control-label" for="phontos">I have media/file to upload​ </label>
                                </div>
                                <button type="Submit" class="btn btn-primary btn-block go mt-2"> Submit </button>
                            </form>
                        </div>
                        <script>
                            $("#creat").on('submit', function(e) {
                                $('.alert-danger').slideUp();
                                e.preventDefault();
                                $.ajax({
                                    type: "POST",
                                    url: "<?= current_url() ?>",
                                    data: new FormData(this),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(response) {
                                        if (response.status == "ok") {
                                            if ($('#phontos').is(":checked")) {
                                                location.href = "<?= base_url("EN/Students/Mylifereportsmedia/") ?>" + response.id;
                                            } else {
                                                Swal.fire({
                                                    title: " Success  ",
                                                    text: ' Thank you for your time.',
                                                    icon: 'success',
                                                });
                                                setTimeout(() => {
                                                    Location.href = "<?= base_url("EN/Students/Home"); ?>"
                                                }, 1000);
                                            }
                                        }else{
                                            $('.alert-danger').slideDown();
                                            $('.alert-danger').html(response.errors);
                                        }
                                    }
                                });
                            });
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('.alert-danger').slideUp();
</script>
</html>