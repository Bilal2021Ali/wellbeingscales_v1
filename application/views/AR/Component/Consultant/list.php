<style>
    .card-header {
        border-bottom: 1px solid;
    }

    .empty {
        width: 100%;
        text-align: center;
    }

    .empty img {
        width: 300px;
        margin-bottom: 10px;
    }

    .badge.rounded-pill {
        top: 10px;
        position: absolute;
        left: 41px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php if (empty($files)) { ?>
                <div class="container text-center p-5 empty">
                    <img src="<?= base_url('assets/images/empty.svg') ?>" class="empty" alt="">
                    <h5 class="mt-2">لا توجد ملفات هنا حتى الان !!</h5>
                </div>
            <?php } else { ?>
                <?php foreach ($files as $sn => $file) { ?>
                    <div class="col-lg-4">
                        <div class="card border border-primary" style="background: url('<?= base_url("assets/images/moroccan-flower.jpg"); ?>');">
                            <div class="card-header bg-transparent border-primary">
                                <h5 class="my-0 text-primary"><i class="uil uil-user me-3 mr-2"></i> تقرير <?= $sn + 1 ?>
                                    <a class="float-right" data-toggle="tooltip" data-placement="top" title="تحدث مع المستشار حول هذا التقرير" href="<?= base_url("AR/" . $this->router->fetch_class() . "/Consultant" . (in_array($sessiondata['type'], ['Ministry', 'Company']) ? 's' : "") . "/chat/" . $file['Id']); ?>">
                                        <?php if ($file['UnreadMessages'] > 0) { ?>
                                            <span class="badge rounded-pill bg-warning text-white"><?= $file['UnreadMessages'] ?></span>
                                        <?php } ?>
                                        <i class="uil-message"></i>
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mt-0"> <a target="_blank" href="<?= base_url('uploads/consultants/' . $file['link']) ?>">رابط التقرير</a></h5>
                                <p class="card-text"><?= $file['Comments'] ?></p>
                                <p class="card-text text-secondary font-weight-light"><?= $file['UploadedAt'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>