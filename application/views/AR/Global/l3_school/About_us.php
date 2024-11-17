<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .bordred_title {
        width: 100%;
        background-color: #16a085;
        padding: 10px;
        text-align: center;
        color: #fff;
        border-radius: 5px;
        margin-bottom: 10px;
        border: 5px solid #00634f;
        margin-top: 10px;
    }

    .title_bl {
        background-color: #0077d6;
        color: #fff;
        padding: 2px;
        margin-top: 7px;
        margin: 8px -5px;
        border-radius: 7px;
        text-align: center;
    }

    .second-title {
        background-color: #16a085;
        color: #fff;
        padding: 4px;
        text-align: center;
        border-radius: 5px;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
		    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">الموارد</h4>
            <?php foreach ($data as $key => $about_us) { ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><?= $about_us['Title'] ?></h3>
                                <hr>
                                <?= $about_us['text'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <img src="<?= base_url('uploads/l3_about_us/' . $about_us['img']) ?>" class="w-100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            <?php } ?>
        </div>
    </div>
</body>

</html>