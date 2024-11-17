<style>
    .toast.toast-error p {
        margin-bottom: 0px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label>Resource Type</label>
                        <select name="resource" disabled class="form-control">
                            <?php foreach ($resources as $resource) { ?>
                                <option value="<?= $resource['Id'] ?>" <?= $course['Resources_Type_Id'] == $resource['Id'] ? "selected" : "" ?>><?= $resource['Resources_Type_EN'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Language</label>
                        <select class="form-control" disabled name="language">
                            <?php foreach ($languages as $language) { ?>
                                <option value="<?= $language['Id'] ?>" <?= $course['Language_Id'] == $language['Id'] ? "selected" : "" ?>>
                                    <?= $language['Language'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Description</label>
                        <input class="form-control" readonly name="description" value="<?= $course['Description'] ?>"
                               placeholder="Description">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Tags (separated with a comma)</label>
                        <input class="form-control" readonly name="tags" value="<?= $course['Tags'] ?>"
                               placeholder="Tags">
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <label>Courses Title</label>
                        <input class="form-control" readonly name="title" value="<?= $course['Courses_Title'] ?>"
                               type="text"
                               placeholder="title...">
                    </div>
                    <div class="col-12 mb-2">
                        <label>Guidance Notes</label>
                        <textarea class="form-control" readonly name="guidance-notes"
                                  placeholder="Courses Topic Description..."><?= $course['Guidance_Notes'] ?></textarea>
                    </div>
                </div>
                <form class="row" id="course-topic-form">
                    <div class="col-lg-6 col-sm-12">
                        <label>Topic Title</label>
                        <input class="form-control" value="<?= $topic['Courses_Topic_Title'] ?? "" ?>"
                               name="topic-title"
                               placeholder="topic title">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>File Type</label>
                        <select class="form-control" name="file-type">
                            <?php foreach ($urlTypes as $type) { ?>
                                <option value="<?= $type['Id'] ?>" <?= $topic['File_URL_Type_Id'] === $type['Id'] ? "selected" : "" ?> ><?= $type['Comments'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label>Topic Description</label>
                        <textarea class="form-control"
                                  name="topic-description"><?= $topic['Description'] ?? "" ?></textarea>
                    </div>
                    <div class="col-12 mt-1">
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
                        location.href = "<?= base_url("EN/Courses/topics-list/" . $course['Id']) ?>"
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