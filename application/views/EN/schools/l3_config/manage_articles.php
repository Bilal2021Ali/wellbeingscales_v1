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
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container">
            <div class="alert alert-danger text-center" role="alert"></div>
            <form class="row" id="newarticles">
                <div class="col-lg-6 articles">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Creat new article </h3>
                            <hr>
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#en" role="tab">
                                        <span class="d-block d-sm-none">EN</span>
                                        <span class="d-none d-sm-block">English version</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ar" role="tab">
                                        <span class="d-block d-sm-none">AR</span>
                                        <span class="d-none d-sm-block">Arabic version</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="en" role="tabpanel">
                                    <label for="en_title">Article Title</label>
                                    <input type="text" name="en_title" id="en_title" class="form-control" placeholder="Title for EN version users">
                                    <label for="en_article" class="mt-1">Article text EN</label>
                                    <textarea name="en_article" id="en_article" cols="30" rows="10"></textarea>
                                </div>
                                <div class="tab-pane" id="ar" role="tabpanel">
                                    <label for="ar_title">Article Title</label>
                                    <input type="text" name="ar_title" id="ar_title" class="form-control" placeholder="Title for AR version users">
                                    <label for="ar_article" class="mt-1">Article text AR</label>
                                    <textarea name="ar_article" id="ar_article" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 images">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"> Article image</h3>
                            <hr>
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
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="enimg" role="tabpanel">
                                    <div class="choose_file">
                                        <label for="choose_file">
                                            <input type="file" onchange="readURL(this,'#en_image_preview');" id="choose_file" name="en_image">
                                            <span>Choose file (EN)</span>
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <img id="en_image_preview" src="<?= base_url("assets/images/Placeholder-Icon-File.png") ?>" class="w-100 placeholder-image" alt="" srcset="">
                                    </div>
                                </div>
                                <div class="tab-pane" id="arimg" role="tabpanel">
                                    <div class="choose_file">
                                        <label for="choose_file1">
                                            <input type="file" onchange="readURL(this,'#ar_image_preview');" id="choose_file1" name="ar_image">
                                            <span>Choose file (AR)</span>
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <img id="ar_image_preview" src="<?= base_url("assets/images/Placeholder-Icon-File.png") ?>" class="w-100 placeholder-image" alt="" srcset="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Save article</button>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= base_url("assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js") ?>"></script>
    <script src="<?= base_url("assets/libs/tinymce/tinymce.min.js") ?>"></script>
    <script>
        $('.alert-danger').hide();
        $('.nav a').unbind('click');
        $('.articles .nav-link').click(function() {
            $(".articles .nav-link").removeClass('active');
            $(".articles .tab-pane").removeClass('active');
            var linkTab = $(this).attr('href');
            $(this).addClass('active');
            $(linkTab).addClass('active');
        });
        $('.images .nav-link').click(function() {
            $(".images .nav-link").removeClass('active');
            $(".images .tab-pane").removeClass('active');
            var linkTab = $(this).attr('href');
            $(this).addClass('active');
            $(linkTab).addClass('active');
        });

        function readURL(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(preview).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // editors
        $(document).ready(function() {
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

        $("#newarticles").on('submit', function(e) {
            e.preventDefault();
            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: "<?= current_url(); ?>",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data == "ok") {
                            $('.alert-danger').hide();
                            location.reload();
                        } else {
                            $('.alert-danger').show();
                            $('.alert-danger').html(data);
                        }
                    },
                    ajaxError: function() {
                        $('.alert-danger').html("oops!! we have an error !");
                    }
                });
            }, 500);
        });
    </script>