<div class="main-content">
    <div class="page-content">
        <style>
            .gonext_1 {
                position: absolute;
                bottom: 10px;
                left: 16px;
                width: 227px;
                height: 50px;
                background: #ffb600;
                border: 0px;
                color: #fff;
                border: 3px solid #0eacd8;
                text-transform: uppercase;
            }

            .takemetoview {
                cursor: pointer;
            }

            .back {
                font-size: 30px;
                margin-bottom: 10px;
                cursor: pointer;
            }

            .takemeto_Infographics {
                cursor: pointer;
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
        <div class="col-lg-12 firstview">
            <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 061 Infographics and articles</h4>
            <div class="row slides_images">
                <div class="col-lg-6" id="slide_img_1">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="mb-5">Infographics</h3>
                            <?php $haveplaceholder = false; ?>
                            <?php foreach ($files as $placeholder) {
                                $file_info = explode('.', $placeholder['file_name']);
                                $mime_type = $file_info[sizeof($file_info) - 1]; ?>
                                <?php if (in_array($mime_type, ['jpg', "jpeg", "png", 'gif'])) {
                                    $haveplaceholder = true;
                                    $thumbimage = base_url('uploads/Category_resources/' . $placeholder['file_name']);
                                    break;
                                } ?>
                            <?php } ?>
                            <?php if (!$haveplaceholder) {
                                $thumbimage =  base_url("assets/images/Placeholder-Icon-File.png");
                            } ?>
                            <div class="card">
                                <img class="card-img-top img-fluid w-100" src="<?= $thumbimage ?>" alt="Card image cap">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" id="slide_img_1">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="mb-5">Articles</h3>
                            <?php if (!empty($articles)) { ?>
                                <div class="card">
                                    <img class="card-img-top img-fluid w-100" src="<?= base_url(isset($articles[0]['img_url']) ? "uploads/articles_files/" . $articles[0]['img_url'] : "assets/images/Placeholder-Icon-File.png"); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mt-0">Article</hh4>
                                            <hr>
                                            <a href="#" class="btn btn-primary waves-effect waves-light takemeto_articles" data-view-id="<?= $articles[0]['Id']; ?>">Show ++</a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="container text-center p-5 empty " style="max-width : 200px;width : 100%;text-aligne:center">
                                    <img src="<?= base_url('assets/images/empty.svg') ?>" class="empty" alt="">
                                    <h5 class="mt-2">There are no articles here yet.</h5>
                                </div> <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 detailed_view_Infographics hidden">
            <div class="row">
                <div class="col-lg-12 detailedDiv hidden">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="row">
                                <i class="back uil uil-arrow-left"></i>
                            </div>
                            <div class="row">
                                <?php foreach ($files as $file) { ?>
                                    <div class="col-lg-4">
                                        <img src="<?= base_url('uploads/Category_resources/' . $file['file_name']) ?>" class="w-100" alt="">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 detailed_view_articles hidden">
            <div class="row">
                <?php foreach ($articles as $article) { ?>
                    <div class="col-lg-12 detailedDiv hidden" id="detailed_view_articles_<?= $article['Id'] ?>">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="row">
                                    <i class="back uil uil-arrow-left"></i>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <img src="<?= base_url('uploads/articles_files/' . $article['img_url']) ?>" class="w-100" alt="">
                                    </div>
                                    <div class="col-lg-8">
                                        <h3 class="card-title"><?= $article['title']; ?></h3>
                                        <article><?= $article['Article']; ?></article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <script>
            $('.gonext_1').click(function() {
                var current = parseInt($(this).attr('data-img-key'));
                $('.slides_images .col-lg-12').addClass('hidden');
                if ($('#slide_img_' + (current + 1)).length > 0) {
                    $('#slide_img_' + (current + 1)).removeClass('hidden');
                } else {
                    $('#slide_img_').removeClass('hidden');
                }
            });

            $('.takemeto_Infographics').click(function() {
                var to = parseInt($(this).attr('data-view-id'));
                $('.firstview').addClass('hidden');
                $('.detailed_view_Infographics').removeClass('hidden');
                $('.detailed_view_Infographics .detailedDiv').addClass('hidden');
                $('.detailed_view_Infographics  #detailed_view_Infographics_' + to).removeClass('hidden');
            });

            $('.takemeto_articles').click(function() {
                var to = parseInt($(this).attr('data-view-id'));
                $('.firstview').addClass('hidden');
                $('.detailed_view_articles').removeClass('hidden');
                $('.detailed_view_articles .detailedDiv').addClass('hidden');
                $('.detailed_view_articles  #detailed_view_articles_' + to).removeClass('hidden');
            });

            $('.back').click(function() {
                $('.firstview').removeClass('hidden');
                $('.detailed_view_Infographics').addClass('hidden');
                $('.detailed_view_articles').addClass('hidden');
            });
        </script>
    </div>
</div>