<style>
    .form-validation-issue p {
        margin: 0;
    }

    .close-alert {
        cursor: pointer;
    }

    .document-card i:not(.uil-link-alt) {
        margin-right: 0.3rem;
    }

    .document-card {
        border-radius: 12px;
    }

    .link-container {
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        background: #5b73e8;
        top: 0;
        color: #fff;
        cursor: pointer;
        font-size: 2rem;
        border-radius: 7px 0 0 7px;
    }

    .link-container:hover {
        color: #fff464;
    }

    .document-card .col-md-4 {
        position: relative;
        display: block;
        height: 11rem;
    }

    .document-card .card-title {
        display: inline-block;
        width: 100%;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }

    .document-card .card-text {
        overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .hidden-document {
        display: none !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<script>
    function errorsAlert(messages) {
        return `<div class="alert form-validation-issue alert-danger w-100">
            <i class="uil uil-times close-alert float-right" onclick="closeAlert(this)"></i>
            ${messages}
        </div>`;
    }

    function closeAlert(el) {
        $(el).parent().remove();
    }
</script>
<div class="page-content">
    <div class="main-content">
        <?php $this->load->view("Shared/Schools/users-profile/navigation") ?>
        <div class="card profile">
            <form class="card-body documents">
                <h3 class="card-title"><?= $this->lang->line("documents") ?></h3>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <label><?= $this->lang->line("file") ?>:</label>
                        <label class="btn btn-success w-100" for="file"><?= $this->lang->line("select-file") ?></label>
                        <input hidden="" id="file" type="file" placeholder="" name="file">
                    </div>
                    <div class="col-lg-6">
                        <label><?= $this->lang->line("file-type") ?> :</label>
                        <select class="form-control" name="file_type">
                            <?php foreach ($filesTypes as $fileType) { ?>
                                <option value="<?= $fileType['Id'] ?>"><?= $fileType['Document'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label><?= $this->lang->line("file-for") ?> :</label>
                        <select class="form-control" name="file_for">
                            <option value="0"><?= $this->lang->line("me") ?></option>
                            <?php foreach ($emergencyContacts as $contact) { ?>
                                <option value="<?= $contact['id'] ?>"><?= $contact['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label><?= $this->lang->line("description") ?> :</label>
                        <textarea placeholder="<?= $this->lang->line("description") ?>...." class="form-control"
                                  name="description"></textarea>
                    </div>
                    <button class="btn btn-primary w-100 mt-2" type="submit"><?= $this->lang->line("submit") ?></button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3"><?= $this->lang->line("files") ?> :</h3>
                <div class="row">
                    <div class="col-lg-6">
                        <label><?= $this->lang->line("file-type") ?> :</label>
                        <select class="form-control" name="file_type">
                            <option><?= $this->lang->line("all") ?></option>
                            <?php foreach ($filesTypes as $fileType) { ?>
                                <option value="<?= $fileType['Id'] ?>"><?= $fileType['Document'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label><?= $this->lang->line("search") ?> :</label>
                        <input class="form-control" id="search-by-keywords"
                               placeholder="<?= $this->lang->line("search") ?>...">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($documents as $document) { ?>
                <div class="col-lg-6 col-sm-12 document-container" data-file-type="<?= $document['fileType'] ?>">
                    <div class="card document-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a target="_blank" href="<?= $document['link'] ?>" class="link-container">
                                    <i class="uil uil-link-alt"></i>
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"
                                        title="<?= $document['name'] ?>"><?= $document['name'] ?></h5>
                                    <p class="card-text"><?= $document['description'] ?></p>
                                    <p class="card-text text-muted">
                                        <i class="uil uil-pricetag-alt"></i><?= $document['fileTypeName'] ?>
                                        <span>|</span>
                                        <i class="uil uil-calender"></i><?= $document['created_at'] ?>
                                        <span>|</span>
                                        <i class="uil uil-user"></i><?= $document['documentFor'] ?? $this->lang->line("me") ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js"); ?>"></script>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 300,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $("form.documents").submit(function (e) {
        e.preventDefault();
        const submit = $('.documents button[type="submit"]');

        submit.attr("disabled", "disabled").html(submit.html() + "...");
        $(".documents .form-validation-issue").remove();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                submit.removeAttr("disabled").html("<?= $this->lang->line('submit') ?>");
                if (response.status === "error") {
                    $(".documents").prepend(errorsAlert(response.message));
                    return;
                }
                toastr["success"]("<?= $this->lang->line('saved-successfully') ?>");
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });

    $('select[name="file_type"]').change(function (e) {
        const id = $(this).val();
        if (id.toLowerCase() === "all") {
            $('.document-container').removeClass("hidden-document");
            return;
        }
        $(".document-container").addClass("hidden-document");
        $('.document-container[data-file-type="' + id + '"]').removeClass("hidden-document");
    });

    $('#search-by-keywords').keyup(function () {
        var value = this.value.toLowerCase();
        $('.document-container').each(function () {
            var id = $(this).text().toLowerCase();
            console.log({id});
            $(this).toggle(id.indexOf(value) !== -1);
        })
    });
</script>