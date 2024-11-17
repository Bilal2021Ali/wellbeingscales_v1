<style>
    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }

    .icon {
        margin: auto;
        width: 100px;
        height: 100px;
        margin-bottom: 7px;
    }

    .link-comp {
        cursor: pointer;
    }

    .link-comp .card {
        background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php foreach ($categories as $category) { ?>
                <a href="<?= base_url($language . "/schools/courses-category/") . $category['Id']; ?>"
                   class="col-md-3 link-comp">
                    <div class="card card-body">
                        <img class="icon" src="<?= base_url("assets/images/linksicons/online-library.png") ?>" alt="">
                        <h3 class="card-title mt-2 text-white text-center"><?= ucfirst($category['title']) ?></h3>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>

