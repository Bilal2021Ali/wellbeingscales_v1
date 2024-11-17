<div class="main-content">
    <div class="page-content">
        <style>
            .catyegory {
                background-color: #eb8642;
                margin-bottom: 40px;
            }

            .catyegory .card-body {
                padding-left: 110px;
                color: #fff;
            }

            .download_res {
                width: 90px;
                height: 90px;
                position: absolute;
                text-align: center;
                display: grid;
                align-items: center;
                background: #29bbe7;
                border-radius: 100%;
                top: -12px;
                left: -12px;
                font-size: 40px;
                color: #fff;
                border: 1px solid #676767;
            }

            .mfp-bg {
                position: fixed !important;
            }

            .empty {
                width: 100%;
                text-align: center;
            }

            .empty img {
                width: 300px;
                margin-bottom: 10px;
            }
        </style>
        <div class="col-lg-12">
            <br>
            <h4 class="card-title" style="background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 059 معرض الوسائط </h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php if (!empty($files)) { ?>
                                    <?php foreach ($files as $link) { ?>
                                        <div class="col-md-6 col-xl-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php
                                                    $linkparts = explode("?", trim($link['link']));
                                                    if (sizeof($linkparts) == 2) {
                                                        $videoid = str_replace("v=", "", $linkparts[1]);
                                                        $thumburl = "https://img.youtube.com/vi/" . $videoid . "/0.jpg";
                                                    } else {
                                                        $thumburl = "https://img.youtube.com/vi/";
                                                    }
                                                    ?>
                                                    <img src="<?= $thumburl ?>" alt="" class="w-100">
                                                    <a href="<?= $link['link'] ?>" target="_blank" title="<?= strlen($link['title']) > 30 ? $link['title'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['title']) > 30 ? substr($link['title'], 0, 30) . "....." : $link['title']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="container text-center p-5 empty " style="max-width : 200px;width : 100%;text-aligne:center">
                                        <img src="<?= base_url('assets/images/empty.svg') ?>" class="empty" alt="">
                                        <h5 class="mt-2">لا توجد ملفات هنا حتى الآن.</h5>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>