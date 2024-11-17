<link href="<?= base_url("assets/libs/magnific-popup/magnific-popup.css") ?>" rel="stylesheet" type="text/css"/>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
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

    .choose_file input {
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

    .placeholder-image {
        border-radius: 5px;
    }

    .readmore {
        color: #5b73e8;
        text-decoration: underline;
        cursor: pointer;
    }

    .delete {
        font-size: 20px;
        color: red;
        cursor: pointer;
    }

    .edit {
        font-size: 20px;
        color: #5b73e8;
        cursor: pointer;
    }

    .w-250 {
        width: 250px;
    }
</style>
<div class="main-content">
    <div class="page-content"><br>
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
            Circulars</h4>
        <div class="container-fluid">
            <div id="update-the-title" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                 aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update The Title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="modal-body">
                            <label>Title <span class="text-danger">*</span> :</label>
                            <input class="form-control" name="title" placeholder="The New Title" type="text">
                            <input type="hidden" name="id">
                            <input type="hidden" name="key">
                            <button type="submit" class="btn btn-primary w-100 mt-2">save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger text-center" role="alert"></div>
            <form class="row" id="newarticles">
                <input type="hidden" name="add" value="yes"/>
                <div class="col-lg-6 articles">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Resources Title</h3>
                            <hr>

                            <div class="tab-content p-3 text-muted">
                                <?php if (strtolower($type) == "students") { ?>
                                    <?php /*?> <div class="row">
                <div class="col-md-6 mt-2">
                  <label>For Class:</label>
                  <select name="classes[]" multiple class="form-control select2" id="">
                    <?php foreach ($classes as $class) { ?>
                    <option value="<?= $class["Id"] ?>">
                    <?= $class["Class"] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6 mt-2">
                  <label>For Grades:</label>
                  <select name="grades[]" multiple class="form-control select2" id="">
                    <?php foreach ($this->config->item('av_grades') as $grade) { ?>
                    <option value="<?= $grade["value"] ?>">
                    <?= $grade["name"] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div><?php */ ?>
                                <?php } ?>
                                <div class="tab-pane active mt-2" id="en" role="tabpanel">
                                    <input type="text" name="en_title" id="en_title" class="form-control"
                                           placeholder="Title for English version users">
                                    <?php /*?>
<label for="en_article" class="mt-1">“My Resources” Text En</label>
<textarea name="en_article" id="en_article" cols="30" rows="10"></textarea><?php */ ?>
                                </div>

                            </div>
                        </div>
                        <div class="choose_file">
                            <label for="choose_file">
                                <input accept="application/pdf" type="file"
                                       onchange="readURL(this,'#en_image_preview');" id="choose_file"
                                       name="en_image">
                                <span>Select file (EN)</span> </label>
                        </div>
                        <div class="col-12"><img id="en_image_preview"
                                                 src="<?= base_url("assets/images/Placeholder-Icon.png") ?>"
                                                 class="w-100 placeholder-image" alt="" srcset=""></div>
                        <br>
                        <div class="col-12">
                            <button type="submit"
                                    class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Save My
                                Resources
                            </button>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 images">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Resources List</h3>
                            <hr>
                            <?php if (!empty($data)) { ?>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-centered table-nowrap">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>File</th>
                                                    <th class="text-center">Date &amp; Time</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($data as $k => $about_us) { ?>
                                                        <tr id="about_<?= $about_us['Id'] ?>">
                                                            <td><?= $k + 1 ?></td>
                                                            <td class="item-title-<?= $k ?>">
                                                                <span>
                                                                    <?= $about_us['En_title'] ?>
                                                                </span>
                                                                <i class="uil uil-edit-alt edit"
                                                                   data-id="<?= $about_us['Id'] ?>"
                                                                   data-key="<?= $k ?>"></i>
                                                            </td>
                                                            <td><a target="_blank"
                                                                   class="<?= in_array((explode(".", $about_us['en_image'])[1] ?? ""), ['png', 'jpg', 'jpeg']) ? "image-popup-no-margins" : "" ?>"
                                                                   href="<?= base_url("uploads/l3_about_us/" . $about_us['en_image']) ?>">File
                                                                    link</a></td>
                                                            <td>
                                                                <div data-key="<?= $about_us['Id'] ?>"
                                                                     class="input-daterange input-group w-250 about-datepicker"
                                                                     id="datepicker6" data-date-format="yyyy-mm-dd"
                                                                     data-date-autoclose="true"
                                                                     data-provide="datepicker">
                                                                    <input type="text"
                                                                           id="date-<?= $about_us['Id'] ?>-from"
                                                                           class="form-control" name="start"
                                                                           autocomplete="off"
                                                                           placeholder="Start Date"
                                                                           value="<?= $about_us['datefrom'] ?>"/>
                                                                    <input type="text"
                                                                           id="date-<?= $about_us['Id'] ?>-to"
                                                                           class="form-control" name="end"
                                                                           autocomplete="off"
                                                                           placeholder="End Date"
                                                                           value="<?= $about_us['dateto'] ?>"/>
                                                                </div>
                                                            </td>
                                                            <td><input type="checkbox" class="about-status"
                                                                       id="about-status-<?= $k ?>"
                                                                       data-key="<?= $about_us['Id'] ?>"
                                                                       switch="success" <?= $about_us['status'] == 1 ? "checked" : "" ?> />
                                                                <label for="about-status-<?= $k ?>" data-on-label="on"
                                                                       data-off-label="off"></label></td>
                                                            <td class="text-center">
                                                                <i class="uil uil-trash delete"
                                                                   data-id="<?= $about_us['Id'] ?>"></i>
                                                                <?php /*?><a href="<?= base_url("EN/schools/edit_about_us/" . $about_us['Id']); ?>">
							 <i class="uil uil-edit-alt edit" data-id="<?= $about_us['Id'] ?>">
							 </i><?php */ ?>
                                                                </a></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php /*?>
<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#enimg" role="tab">
            <span class="d-block d-sm-none">EN</span>
            <span class="d-none d-sm-block">English version</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#arimg" role="tab">
            <span class="d-block d-sm-none">AR</span>
            <span class="d-none d-sm-block">Arabic version</span>
        </a>
    </li>
</ul>
            <?php */ ?>
                            <?php /*?>
<div class="tab-content p-3 text-muted">
    <div class="tab-pane active" id="enimg" role="tabpanel">
        <div class="choose_file">
            <label for="choose_file">
                <input accept="application/pdf" type="file" onchange="readURL(this,'#en_image_preview');" id="choose_file" name="en_image">
                <span>Select file (EN)</span>
            </label>
        </div>
        <div class="col-12">
            <img id="en_image_preview" src="<?= base_url("assets/images/Placeholder-Icon.png") ?>" class="w-100 placeholder-image" alt="" srcset="">
        </div>
    </div>
    <div class="tab-pane" id="arimg" role="tabpanel">
        <div class="choose_file">
            <label for="choose_file1">
                <input accept="application/pdf" type="file" onchange="readURL(this,'#ar_image_preview');" id="choose_file1" name="ar_image">
                <span>Select file (AR)</span>
            </label>
        </div>
        <div class="col-12">
            <img id="ar_image_preview" src="<?= base_url("assets/images/Placeholder-Icon.png") ?>" class="w-100 placeholder-image" alt="" srcset="">
        </div>
    </div>
</div>
            <?php */ ?>
                        </div>

                    </div>

                </div>


            </form>

        </div>

    </div>

    <script src="<?= base_url("assets/libs/magnific-popup/jquery.magnific-popup.min.js") ?>"></script>
    <script src="<?= base_url("assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js") ?>"></script>
    <script src="<?= base_url("assets/libs/tinymce/tinymce.min.js") ?>"></script>
    <script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
    <script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
    <script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
    <script>
        $('.select2').select2({
            closeOnSelect: false,
            allowClear: true
        });

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $("table").on("change", ".about-datepicker", function () {
            const item = $(this).data("key");
            $.ajax({
                type: "POST",
                url: "<?= base_url("EN/schools/about-us-date") ?>",
                data: {
                    target: item,
                    from: $("#date-" + item + "-from").val() ?? "",
                    to: $("#date-" + item + "-to").val() ?? "",
                },
                success: function (response) {
                    if (response.status !== "ok") {
                        alert("sorry we had an error");
                    } else {
                        toastr["success"]("Changes have been saved.")
                    }
                }
            });
        });

        $("table").on("change", ".about-status", function () {
            const target = $(this).data("key");
            const isChecked = $(this).is(":checked");
            $.ajax({
                type: "POST",
                url: "<?= base_url("EN/schools/about-us-status") ?>",
                data: {
                    target,
                    status: isChecked
                },
                success: function (response) {
                    if (response.status !== "ok") {
                        alert("sorry we had an error");
                    } else {
                        toastr["success"]("Changes have been saved.")
                    }
                }
            });
        });

        $('.table').DataTable();
        $('.alert-danger').hide();
        $('.nav a').unbind('click');
        $('.articles .nav-link').click(function () {
            $(".articles .nav-link").removeClass('active');
            $(".articles .tab-pane").removeClass('active');
            const linkTab = $(this).attr('href');
            $(this).addClass('active');
            $(linkTab).addClass('active');
        });
        $('.images .nav-link').click(function () {
            $(".images .nav-link").removeClass('active');
            $(".images .tab-pane").removeClass('active');
            var linkTab = $(this).attr('href');
            $(this).addClass('active');
            $(linkTab).addClass('active');
        });

        function readURL(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(preview).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // editors
        $(document).ready(function () {
            if ($("textarea").length > 0) {
                tinymce.init({
                    selector: "textarea",
                    file_picker_types: 'file image media',
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    },
                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },
                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },
                        {
                            title: 'Table styles'
                        },
                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }
                    ]
                });
            }
        });
        $("#newarticles").on('submit', function (e) {
            e.preventDefault();
            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: "<?= current_url(); ?>",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data == "ok") {
                            $('.alert-danger').hide();
                            location.reload();
                        } else {
                            $('.alert-danger').show();
                            $('.alert-danger').html(data);
                        }
                    },
                    ajaxError: function () {
                        $('.alert-danger').html("oops!! We have an error !");
                    }
                });
            }, 500);
        });
        $(".table").on('click', '.readmore', function (e) {
            var id = $(this).attr('data-id');
            var lang = $(this).attr('data-lang');
            $.ajax({
                type: "POST",
                url: "<?= current_url(); ?>",
                data: {
                    article: id,
                    lang: lang,
                },
                success: function (response) {
                    $('.fullarticle').html(response);
                }
            });
        });
        $('.image-popup-no-margins').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            }
        });
        $(".table").on('click', '.delete', function (e) {
            var id = $(this).attr('data-id');
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "<?= current_url(); ?>",
                        data: {
                            id: id,
                        },
                        success: function (response) {
                            if (response == "ok") {
                                $('#about_' + id).remove();
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'data deleted successfully',
                                    icon: 'success'
                                });
                            } else {
                                Swal.fire({
                                    title: 'error!',
                                    text: 'sorry !! we have uexpected error , please try again later',
                                    icon: 'error'
                                });
                            }
                        }
                    });
                }
            });
        });

        $(".table").on('click', '.edit', function (e) {
            const key = $(this).data("key");
            const id = $(this).data("id");
            //key
            $("#update-the-title input[name='title']").val($(".item-title-" + key + " span").html().trim());
            const title = $("#update-the-title input[name='title']").val();
            $("#update-the-title input[name='id']").val(id);
            $("#update-the-title input[name='key']").val(key);
            $("#update-the-title").modal("show");
        });

        $("#update-the-title form").submit(function (e) {
            e.preventDefault();

            const title = $("#update-the-title input[name='title']").val().trim();
            const id = $("#update-the-title input[name='id']").val();
            const key = $("#update-the-title input[name='key']").val();

            $("#update-the-title form button").attr("disabled", "disabled");
            if (title.length < 1) {
                Swal.fire({
                    title: 'error!',
                    text: 'The Title Is Required',
                    icon: 'error'
                });
                return;
            }
            $.ajax({
                type: "PUT",
                url: "<?= current_url(); ?>",
                data: {
                    id,
                    title
                },
                success: function (response) {
                    $("#update-the-title form button").removeAttr("disabled");
                    if (response === "ok") {
                        $(".item-title-" + key + " span").html(title)
                        Swal.fire({
                            title: 'Success!',
                            text: 'title updated successfully',
                            icon: 'success'
                        });
                        $("#update-the-title").modal("hide");
                    } else {
                        Swal.fire({
                            title: 'error!',
                            text: 'sorry !! we have unexpected error , please try again later',
                            icon: 'error'
                        });
                    }
                }
            });
        });

    </script>