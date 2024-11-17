<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <form id="resource-form" class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label>Topic Title</label>
                        <input class="form-control" placeholder="" readonly type="text"
                               value="<?= $topic['topicTitle'] ?>">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>Cover</label>
                        <label class="btn btn-outline-success w-100">
                            Select File
                            <input name="cover" hidden="" type="file">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label>Recourse Title</label>
                        <input class="form-control" value="<?= $resource['Courses_Resource_Tile'] ?? '' ?>" name="title"
                               placeholder="Recourse Title" type="text">
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label>File</label>
                        <?php if (strtolower($topic['type']) == "youtube") { ?>
                            <input name="file" class="form-control" type="url"
                                   value="<?= $resource['File_URL'] ?? '' ?>" placeholder="video url...">
                        <?php } else { ?>
                            <label class="btn btn-outline-success w-100">
                                Select File
                                <input name="file" hidden="" type="file">
                            </label>
                        <?php } ?>
                    </div>
                </div>
                <button class="btn btn-primary w-100 mt-1">save</button>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script>
    $("#resource-form").on('submit', function (e) {
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
                        location.href = "<?= base_url("EN/Courses/resources-list/" . $topicId) ?>"
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