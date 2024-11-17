<?php $havethumb = false; ?>
<div class="col-md-6 col-xl-4">
    <div class="card">
        <?php foreach ($media as $key => $filertest) { ?>
            <?php $file_info = explode('.', $filertest['file_url']);
            $mime_type = $file_info[sizeof($file_info) - 1]; ?>
            <?php if (in_array($mime_type, ['jpg', "jpeg", "png", 'gif'])) { ?>
                <?php $havethumb = true; ?>
                <?php if ($filertest['file_type'] == "1") { ?>
                    <img class="card-img-top img-fluid" src="<?= base_url('uploads/Category_resources/' . $filertest['file_language'] . "/" . $filertest["file_url"]) ?>" alt="Card image cap">
                <?php } else { ?>
                    <img class="card-img-top img-fluid" src="<?= base_url('uploads/Reports_resources/' . $filertest['file_language'] . "/" . $filertest["file_url"]) ?>" alt="Card image cap">
                <?php } ?>
                <?php unset($media[$key]); ?>
            <?php break;
            } ?>
        <?php } ?>
        <?php if (!$havethumb) { ?>
            <img class="card-img-top img-fluid" src="<?= base_url("assets/images/Placeholder-Icon-File.png") ?>" alt="Card image cap">
        <?php } ?>
        <div class="card-body">
            <h4 class="card-title mt-0 text-center">
                <?= $category['media_name_en'] == "" ? "No title" : $category['media_name_en']; ?></h4>
            <hr>
            <div class="linkslist">
                <?php foreach ($media as $link) { ?>
                    <?php if ($link['file_type'] == "1") { ?>
                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_en']) > 30 ? $link['file_name_en'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_en']) > 30 ? substr($link['file_name_en'], 0, 30) . "....." : $link['file_name_en']; ?></a>
                    <?php } else { ?>
                        <a href="<?= base_url('uploads/Category_resources/' . $link['file_language'] . "/" . $link["file_url"]) ?>" target="_blank" title="<?= strlen($link['file_name_en']) > 30 ? $link['file_name_en'] : ""; ?>" class="btn btn-primary waves-effect waves-light w-100 mb-2 mt-1"><?= strlen($link['file_name_en']) > 30 ? substr($link['file_name_en'], 0, 30) . "....." : $link['file_name_en']; ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>