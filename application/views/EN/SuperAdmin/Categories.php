<style>
    * {
        list-style: none;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .title {
        background: #f3f4f8;
        padding: 15px;
        font-size: 18px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .file_upload_list li .file_item {
        display: flex;
        border-bottom: 1px solid #f3f4f8;
        padding: 15px 20px;
    }

    .file_item .format {
        background: #8178d3;
        border-radius: 10px;
        width: 45px;
        height: 40px;
        line-height: 40px;
        color: #fff;
        text-align: center;
        font-size: 12px;
        margin-right: 15px;
    }

    .file_item .file_progress {
        width: calc(100% - 60px);
        font-size: 14px;
    }

    .file_item .file_info,
    .file_item .file_size_wrap {
        display: flex;
        align-items: center;
    }

    .file_item .file_info {
        justify-content: space-between;
    }

    .file_item .file_progress .progress {
        width: 100%;
        height: 4px;
        background: #efefef;
        overflow: hidden;
        border-radius: 5px;
        margin-top: 8px;
        position: relative;
    }

    .file_item .file_progress .progress .inner_progress {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #58e380;
    }

    .file_item .file_size_wrap .file_size {
        margin-right: 15px;
    }

    .file_item .file_size_wrap .file_close {
        border: 1px solid #8178d3;
        color: #8178d3;
        width: 20px;
        height: 20px;
        line-height: 18px;
        text-align: center;
        border-radius: 50%;
        font-size: 10px;
        font-weight: bold;
        cursor: pointer;
    }

    .file_item .file_size_wrap .file_close:hover {
        background: #8178d3;
        color: #fff;
    }

    .choose_file label {
        display: block;
        border: 2px dashed #8178d3;
        padding: 15px;
        width: calc(100% - 20px);
        margin: 10px;
        text-align: center;
        cursor: pointer;
    }

    .choose_file #choose_file {
        outline: none;
        opacity: 0;
        width: 0;
    }

    .choose_file span {
        font-size: 14px;
        color: #8178d3;
    }

    .choose_file label:hover span {
        text-decoration: underline;
    }

    .delete {
        font-size: 20px;
        color: #ff0000;
        cursor: pointer;
    }

    .floating_action_btn {
        position: fixed !important;
        bottom: 70px;
        right: 10px;
        border: 0px;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 100%;
        z-index: 1000;
        -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    }

    .upload,
    .media_upload {
        font-size: 20px;
        color: #2196f3;
        cursor: pointer;
    }

    .uil-download-alt,
    .uil-arrow-up-right {
        font-size: 20px;
        color: #c7c7c7;
        cursor: pointer;
    }

    .able_to_download,
    .able_to_open {
        color: #34c38f;
        font-size: 20px;
        cursor: pointer;
    }

    .alert p {
        margin-bottom: 0px;
        text-align: center;
    }

    .swal2-footer {
        display: block !important;

    }

    .swal2-footer p {
        margin: 0px !important;
    }

    .delete {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 100%;
        padding-top: 4px;
        padding-left: 3px;
        position: absolute;
        top: 10px;
        left: 10px;
        color: #b30000;
        cursor: pointer;
        border: 1px solid #eeee;
    }

    /* .medialinkslist .card {
        padding: 0px;
    } */

    #media_link .d-grid .btn-danger.inner {
        height: 100%;
        font-size: 20px;
    }

    .hiddeninput {
        width: 100%;
        border: 0px;
        outline: none;
        resize: none;
    }

    .show-hide-upload-form {
        position: absolute;
        right: 6px;
        top: 6px;
    }
</style>
<style>
    .switch {
        position: absolute;
        display: inline-block;
        width: 50px;
        height: 24px;
        top: 16px;
        right: 8px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #CB0002;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #75b030;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="col-12">
            <div id="FileUpload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="FileUploadLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="FileUploadLabel">Upload List:</h5>
                            <button type="button" class="btn btn-success show-hide-upload-form">Upload</button>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="select-to-upload" style="display: none">
                                <img src="<?= base_url("assets/images/uploadFilePlaceholder.png") ?>" class="selectFile btn" width="80" alt="">
                                <input type="hidden" name="cat_id">
                                <input type="hidden" name="userType">
                                <input type="hidden" name="lang">
                                <input type="file" accept="application/pdf" name="newFile" class="d-none">
                                <h3 class="mt-1">Click to select a file</h3>
                            </div>
                            <div class="old-files-list row">
                                ........
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?= $isMobile ? "MOBILE ARCHITECTURES PDF LIST" : "MOBILE CATEGORIES PDF LIST" ?></h3>
                    <div class="overflow-auto">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Category</th>
                                <th>Total Surveys</th>
                                <th>EN Staff</th>
                                <th>EN Teacher</th>
                                <th>EN Student</th>
                                <th>EN Parent</th>
                                <th>AR Staff </th>
                                <th>AR Teacher</th>
                                <th>AR Student</th>
                                <th>AR Parent</th>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $sn => $category) { ?>
                                    <?php $files = $this->db->where("Category_id", $category['Id'])->get("sv_st_categories_reports_files")->result_array(); ?>
                                    <tr>
                                        <td><?= $sn + 1 ?></td>
                                        <td><?= $category['Cat_en'] ?></td>
                                        <td><?= $category['counter_of_using'] ?></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="staff" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="teacher" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="student" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="parent" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="staff" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="teacher" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="Student" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" class="show-old-uploades btn btn-rounded waves-effect OpenFileReport" data-key="<?= $category['Id'] ?>" data-user-type="Parent" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.table').DataTable();
    $('.table').on('click', '.OpenFileReport', function() {
        $('#FileUpload form input[name="cat_id"]').val($(this).attr('data-key'));
        $('#FileUpload form input[name="userType"]').val($(this).attr('data-user-type'));
        $('#FileUpload form input[name="lang"]').val($(this).attr('data-lang'));
        $('#FileUpload form input[name="newFile"]').val('');
        $('#FileUpload form h3').html('Click to select a file');
    });

    $('.selectFile').click(function() {
        $('#FileUpload form input[name="newFile"]').trigger('click');
    });

    // show/hide the upload file form
    $(".show-hide-upload-form").click(function() {
        $(".select-to-upload").slideToggle();
    });

    $('#FileUpload form input[name="newFile"]').change(function(e) {
        $('#FileUpload form h3').html('Select File :' + e.target.files[0].name);
    });

    $("table").on("click", ".show-old-uploades", function() {
        $("#FileUpload").modal("toggle");
        const language = $(this).data('lang');
        const userType = $(this).data('user-type');
        const catId = $(this).data('key');
        $.ajax({
            type: "GET",
            url: "<?= current_url(); ?>/" + catId + "/" + userType + "/" + language,
            success: function(response) {
                $(".old-files-list").html(response);
            }
        });
    });

    $('#FileUpload form').on('submit', function(e) {
        e.preventDefault();
        $('#FileUpload button[type="submit"]').attr('disabled', '');
        $('#FileUpload button[type="submit"]').html('Please wait...');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#FileUpload button[type="submit"]').removeAttr('disabled');
                $('#FileUpload button[type="submit"]').html('Save Changes');
                if (response.status == "ok") {
                    $(".action-btn-" + $('#FileUpload form input[name="userType"]').val() + "-" + $('#FileUpload form input[name="cat_id"]').val() + "-" + $('#FileUpload form input[name="lang"]').val()).removeClass("btn-success");
                    $(".action-btn-" + $('#FileUpload form input[name="userType"]').val() + "-" + $('#FileUpload form input[name="cat_id"]').val() + "-" + $('#FileUpload form input[name="lang"]').val()).addClass("btn-warning");
                    console.log(".action-btn-" + $('#FileUpload form input[name="userType"]').val() + "-" + $('#FileUpload form input[name="cat_id"]').val());
                    $('#FileUpload').modal('hide');
                    Swal.fire({
                        title: "Success",
                        text: "File uploaded successfully",
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: "error",
                        text: response.message,
                        icon: "error"
                    });
                }
            }
        });
    });

    // files actions
    $("#FileUpload").on("click", ".FileStatus", function() {
        const id = $(this).data("file-id");
        $.ajax({
            type: "POST",
            url: "<?= base_url("EN/Dashboard/" . ($isMobile ? "mobile-architecture-files" : "categories-files")) ?>",
            data: {
                file: id
            },
            success: function(response) {
                if (response.status !== "ok") {
                    Swal.fire({
                        title: "error",
                        text: response.message,
                        icon: "error"
                    });
                }
            }
        });
    });
    // files actions
    $("#FileUpload").on("click", ".delete", function() {
        const id = $(this).data("file-id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ms-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= base_url("EN/Dashboard/" . ($isMobile ? "mobile-architecture-files" : "categories-files")) ?>/' + id,
                    success: function(data) {
                        if (data.status == "ok") {
                            $(".file-container-" + id).slideUp("slow", function() {
                                $(".file-container-" + id).remove();
                            });
                        } else {
                            Swal.fire({
                                title: 'Sorry !',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    },
                    ajaxError: function() {
                        $('#StatusBox').css('background-color', '#B40000');
                        $('#StatusBox').html("Ooops! Error was found.");
                    }
                });
            }
        });
    });
</script>