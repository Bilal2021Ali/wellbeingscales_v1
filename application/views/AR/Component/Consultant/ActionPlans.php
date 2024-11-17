<style>
    .empty {
        width: 100%;
        text-align: center;
    }

    .empty img {
        width: 300px;
        margin-bottom: 10px;
    }

    .file-preview {
        height: 300px;
        overflow: hidden;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <?php $havethumb = false; ?>
        <?php if (!empty($files)) { ?>
            <div class="card">
                <div class="card-body overflow-auto">
                    <table class="table">
                        <thead>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الرابط</th>
                        </thead>
                        <tbody>
                        <?php foreach ($files as $key => $file) { ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $file['file_name_ar'] ?></td>
                                <td><?= $file['TimeStamp'] ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('uploads/Category_resources/' . $file['file_language'] . "/" . $file["file_url"]) ?>">
                                        <i class="uil uil-arrow-up-left"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--            <div class="row">-->
            <!--                --><?php //foreach ($files as $key => $file) { ?>
            <!--                    <div class="col-md-6 col-xl-4">-->
            <!--                        <div class="card">-->
            <!--                            <div class="file-preview">-->
            <!--                                --><?php //if (file_exists(('./uploads/Category_resources/' . $file['file_language'] . "/" . $file["file_url"]))) { ?>
            <!--                                    --><?php
//                                    $file_info = new finfo(FILEINFO_MIME_TYPE);
//                                    $mime_type = $file_info->buffer(file_get_contents(base_url('uploads/Category_resources/' . $file['file_language'] . "/" . $file["file_url"])));
//                                    $type = explode("/", $mime_type)[1] ?? ""; ?>
            <!--                                    --><?php //if ($type == "pdf") { ?>
            <!--                                        <iframe width="100%" height="100%"-->
            <!--                                                src="--><?php //= base_url('uploads/Category_resources/' . $file['file_language'] . "/" . $file["file_url"]) ?><!--"-->
            <!--                                                frameborder="0" scrolling="no" marginheight="0"-->
            <!--                                                marginwidth="0"></iframe>-->
            <!--                                    --><?php //} else { ?>
            <!--                                        <img class="card-img-top img-fluid"-->
            <!--                                             src=""-->
            <!--                                             alt="Card image cap">-->
            <!--                                    --><?php //} ?>
            <!--                                --><?php //} else { ?>
            <!--                                    <img class="card-img-top img-fluid"-->
            <!--                                         src="--><?php //= base_url('assets/images/Placeholder-Icon-File.png') ?><!--"-->
            <!--                                         alt="Card image cap">-->
            <!--                                    <p class="text-center">File Not Found</p>-->
            <!--                                --><?php //} ?>
            <!--                            </div>-->
            <!--                            <div class="card-body">-->
            <!--                                <hr>-->
            <!--                                <h5 class="card-title text-center">--><?php //= strlen($file['file_name_en']) > 30 ? substr($file['file_name_en'], 0, 30) . "....." : $file['file_name_en']; ?>
            <!--                                    <a title="Open Full Preview In New Window"-->
            <!--                                       href="--><?php //= base_url('uploads/Category_resources/' . $file['file_language'] . "/" . $file["file_url"]) ?><!--"-->
            <!--                                       target="_blank"-->
            <!--                                       title="--><?php //= strlen($file['file_name_en']) > 30 ? $file['file_name_en'] : ""; ?><!--"><i-->
            <!--                                                class="uil uil-arrow-up-right"></i></a></h5>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                --><?php //} ?>
            <!--            </div>-->
        <?php } else { ?>
            <div class="container text-center p-5 empty " style="max-width : 200px;width : 100%;text-aligne:center">
                <img src="<?= base_url('assets/images/empty.svg') ?>" class="empty" alt="">
                <h5 class="mt-2">لا توجد ملفات هنا حتى الآن.</h5>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(".table").DataTable();
</script>