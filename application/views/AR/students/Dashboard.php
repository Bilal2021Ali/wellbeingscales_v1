<style>
    .card1 {
        border: 4px solid #000;
        background-color: #ff9c38;
        color: #fff;
    }

    .card2 {
        border: 4px solid #000;
        background-color: #ff9c38;
        color: #fff;
    }

    .card3 {
        border: 4px solid #000;
        background-color: #fedace;
        color: #fff;
    }

    .card4 {
        border: 4px solid #000;
        background-color: #fedace;
        color: #fff;
    }

    .card5 {
        border: 4px solid #000;
        background-color: #aeeaff;
        color: #fff;
    }

    .card6 {
        border: 4px solid #000;
        background-color: #aeeaff;
        color: #fff;
    }

    .card7 {
        border: 4px solid #000;
        background-color: #ffcd05;
        color: #fff;
    }

    .card8 {
        border: 4px solid #000;
        background-color: #ffcd05;
        color: #fff;
    }

    .card9 {
        border: 4px solid #000;
        background-color: #fe0404;
        color: #fff;
    }

    .card10 {
        border: 4px solid #000;
        background-color: #fe0404;
        color: #fff;
    }

    .card11 {
        border: 4px solid #000;
        background-color: #d9eb96;
        color: #fff;
    }

    .card12 {
        border: 4px solid #000;
        background-color: #d9eb96;
        color: #fff;
    }

    .card {
        border: 1px solid #000;
        background-color: #ff6a00;
        color: #fff;
    }

    .card h3 {
        color: #fff;
        font-weight: bold;
    }

    .date {
        font-size: 10px;
    }

    .image-container {
        display: grid;
        align-items: center;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">الرئيسية</h4>
        <div class="container-fluid">
            <div class="row">
                <?php if (!empty($records)) { ?>
                    <?php foreach ($records as $record) { ?>
                        <div class="col-lg-3 col-sm-12 col-md-3">
                            <div class="card<?= rand(1, 12) ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h3><?= $record['value'] ?></h3>
                                            <p><?= $record['title'] ?></p>
                                            <h3><?= $record['goal'] ?></h3>
                                            <p>الهدف</p>
                                            <p class="date"><?= $record['last_update'] ?><br>آخر تحديث</p>
                                        </div>
                                        <div class="col-6 p-0 image-container">
                                            <img src="<?= base_url("uploads/Dashboard_icons/".$record['icon']) ?>" class="img-responsive w-100" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col-md-12 mt-5">
                        <div class="text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="error-img"> <img src="<?= base_url() ?>assets/images/no_data_in_table.svg" alt="" class="img-fluid mx-auto d-block"> </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-uppercase mt-4">لا توجد بيانات لعرضها</h4>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>