<style>
    .toast.toast-error p {
        margin-bottom: 0px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;">
            Category: <?= $category['Cat_en'] ?>
        </h4>
        <div class="card">
            <div class="card-body">
                <form id="course-topic-form" method="post" class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label>Resource Type</label>
                        <select name="resource" class="form-control">
                            <?php foreach ($resources as $resource) { ?>
                                <option value="<?= $resource['Id'] ?>" <?= $course['Resources_Type_Id'] == $resource['Id'] ? "selected" : "" ?>><?= $resource['Resources_Type_EN'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Language</label>
                        <select class="form-control" name="language">
                            <?php foreach ($languages as $language) { ?>
                                <option value="<?= $language['Id'] ?>" <?= $course['Language_Id'] == $language['Id'] ? "selected" : "" ?>>
                                    <?= $language['Language'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Description</label>
                        <input class="form-control" name="description" value="<?= $course['Description'] ?>"
                               placeholder="Description">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Tags (separated with a comma)</label>
                        <input class="form-control" name="tags" value="<?= $course['Tags'] ?>" placeholder="Tags">
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <label>Courses Title</label>
                        <input class="form-control" name="title" value="<?= $course['Courses_Title'] ?>" type="text" placeholder="title...">
                    </div>
                    <div class="col-12 mb-2">
                        <label>Guidance Notes</label>
                        <textarea class="form-control" name="guidance-notes" placeholder="Courses Topic Description..."><?= $course['Guidance_Notes'] ?></textarea>
                    </div>
                    <div class="col-lg-4">
                        <label for="cover-file" class="btn btn-success w-100 text-center">
                            <i class="uil uil-file"></i>
                            | Cover File
                        </label>
                        <input id="cover-file" accept="image/*" type="file" name="cover-file" hidden="">
                    </div>
                    <div class="col-lg-8">
                        <button class="btn btn-primary w-100" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script>
    $("#course-topic-form").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('form button[type="Submit"]').attr('disabled', '').html('Saving...');
            },
            success: function (data) {
                if (data.status === "error") {
                    toastr["error"](data.message);
                } else {
                    toastr["success"](data.message);
                    setTimeout(() => {
                        location.href = "<?= base_url("EN/Courses/courses-list/" . $category['Id']) ?>"
                    }, 200);
                }
                $('button[type="Submit"]').removeAttr('disabled', '').html('Save');
            },
            ajaxError: function () {
                toastr["success"]("Sorry We had An Error");
            }
        });
    });
</script>