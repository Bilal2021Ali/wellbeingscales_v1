<div class="col-md-6 col-xl-4 file-container-<?= $file["Id"] ?>">
    <div class="card">
        <i class="uil uil-trash delete" data-file-id="<?= $file["Id"] ?>"></i>
        <label class="switch">
            <input type="checkbox" class="FileStatus" <?= $file["status"] == 1 ? "checked" : "" ?> data-file-id="<?= $file["Id"] ?>"><span class="slider round"></span>
        </label>
        <div class="avatar-lg mx-auto mb-4 mt-5">
            <div class="avatar-title bg-soft-primary rounded-circle text-primary"><i class="mdi mdi-file-chart display-4 m-0 text-primary"></i></div>
        </div>
        <h6 class="text-center mb-4"><a href="<?= base_url('uploads/categories_reports/' . $file["file"]) ?>">File link</a></h6>
    </div>
</div>