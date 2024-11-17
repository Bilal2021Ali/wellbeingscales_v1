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
</style>

<?php
$categorys = $this->sv_reports->usedcategorys($sessiondata['admin_id']);
?>
<div class="col-lg-12 firstview">
    <h4 class="card-title" style="background: #fca301;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 061 Infographics and articles</h4>
    <div class="row slides_images">
        <div class="col-lg-6" id="slide_img_1">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-5">Infographics</h3>
                    <?php foreach ($categorys as $category) { ?>
                        <?php
                        $files = $this->db->query("SELECT * FROM `st_sv_categorys_resources` WHERE `cat_id` = '" . $category['Id'] . "'  AND `language_resource` = 'en' ")->result_array();
                        $haveplaceholder = false;
                        ?>
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
                            <div class="card-body">
                                <h4 class="card-title mt-0"><?= $category['Cat_en'] ?></h4>
                                <hr>
                                <a class="btn btn-primary waves-effect waves-light takemeto_Infographics" data-view-id="<?= $category['Id']; ?>">show</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6" id="slide_img_1">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-5">Articles</h3>
                    <?php foreach ($categorys as $category) { ?>
                        <?php $articles = $this->db->query("SELECT * FROM `st_sv_categorys_articles` WHERE `cat_id` = '" . $category['Id'] . "'  AND `language` = 'en' ORDER BY `st_sv_categorys_articles`.`Id` DESC  LIMIT 1")->result_array(); ?>
                        <div class="card">
                            <img class="card-img-top img-fluid w-100" src="<?= base_url(isset($articles[0]['img_url']) ? "uploads/articles_files/" . $articles[0]['img_url'] : "assets/images/Placeholder-Icon-File.png"); ?>" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title mt-0"><?= $category['Cat_en'] ?></h4>
                                <hr>
                                <a href="#" class="btn btn-primary waves-effect waves-light takemeto_articles" data-view-id="<?= $category['Id']; ?>">Show ++</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 detailed_view_Infographics hidden">
    <div class="row">
        <?php foreach ($categorys as $category) { ?>
            <div class="col-lg-12 detailedDiv hidden" id="detailed_view_Infographics_<?= $category['Id'] ?>">
                <?php $files = $this->db->query("SELECT * FROM `st_sv_categorys_resources` WHERE `cat_id` = '" . $category['Id'] . "'  AND `language_resource` = 'en' ")->result_array();  ?>
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title"><?= $category['Cat_en'] ?></h3>
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
        <?php } ?>
    </div>
</div>

<div class="col-lg-12 detailed_view_articles hidden">
    <div class="row">
        <?php foreach ($categorys as $category) { ?>
            <div class="col-lg-12 detailedDiv hidden" id="detailed_view_articles_<?= $category['Id'] ?>">
                <?php $articles = $this->db->query("SELECT * FROM `st_sv_categorys_articles` WHERE `cat_id` = '" . $category['Id'] . "' AND `language` = 'en' ")->result_array();  ?>
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title"><?= $category['Cat_en'] ?></h3>
                        <div class="row">
                            <i class="back uil uil-arrow-left"></i>
                        </div>
                        <?php foreach ($articles as $article) { ?>
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="<?= base_url('uploads/articles_files/' . $article['img_url']) ?>" class="w-100" alt="">
                                </div>
                                <div class="col-lg-8">
                                    <h3 class="card-title"><?= $article['title']; ?></h3>
                                    <article><?= $article['Article']; ?></article>
                                </div>
                            </div>
                        <?php } ?>
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