<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<link href="<?= base_url('assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<style>
    .infographics_upload {
        cursor: pointer;
    }
    .media_upload,
    .article_upload,
    .showuploadedFiles,
    .articles_show {
        font-size: 25px;
        color: #2196f3;
        cursor: pointer;
    }

    .showuploadedFiles,
    .articles_show {
        color: #93bf04;
    }

    .file-card {
        height: 80px;
        display: grid;
        align-items: center;
        text-align: center;
        background: #71b0ff;
        border-radius: 3px;
    }

    .file-card i {
        color: #fff;
        font-size: 30px;
    }

    .delteFiles {
        cursor: pointer;
        color: red;
        font-size: 0px;
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
    }

    .delteFiles.active {
        color: red;
        font-size: 25px;
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
    }

    .rightbar-overlay {
        z-index: 1003 !important;
    }

    .right-bar .container .card {
        cursor: pointer;
    }
</style>
<style>
    .plus-minus {
        --primary: #1e2235;
        --secondary: #fafbff;
        --duration: 0.5s;
        -webkit-appearance: none;
        -moz-appearance: none;
        -webkit-tap-highlight-color: transparent;
        -webkit-mask-image: -webkit-radial-gradient(white, white);
        outline: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
        perspective: 240px;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        border: 4px solid var(--primary);
        background-size: 300% 300%;
        transition: transform 0.3s;
        transform: scale(var(--scale, 1)) translateZ(0);
        animation: var(--name, unchecked) var(--duration) ease forwards;
    }

    .plus-minus:before,
    .plus-minus:after {
        content: '';
        position: absolute;
        width: 16px;
        height: var(--height, 16px);
        left: 6px;
        top: var(--top, 6px);
        background: var(--background, var(--primary));
        animation: var(--name-icon-b, var(--name-icon, unchecked-icon)) var(--duration) ease forwards;
    }

    .plus-minus:before {
        clip-path: polygon(0 6px, 6px 6px, 6px 0, 10px 0, 10px 6px, 16px 6px, 16px 10px, 10px 10px, 10px 16px, 6px 16px, 6px 10px, 0 10px);
    }

    .plus-minus:after {
        --height: 4px;
        --top: 12px;
        --background: var(--secondary);
        --name-icon-b: var(--name-icon-a, checked-icon);
    }

    .plus-minus:active {
        --scale: 0.95;
    }

    .plus-minus:checked {
        --name: checked;
        --name-icon-b: checked-icon;
        --name-icon-a: unchecked-icon;
    }

    @keyframes checked-icon {
        from {
            transform: translateZ(12px);
        }

        to {
            transform: translateX(16px) rotateY(90deg) translateZ(12px);
        }
    }

    @keyframes unchecked-icon {
        from {
            transform: translateX(-16px) rotateY(-90deg) translateZ(12px);
        }

        to {
            transform: translateZ(12px);
        }
    }

    @keyframes checked {
        from {
            background-image: radial-gradient(ellipse at center, var(--primary) 0%, var(--primary) 25%, var(--secondary) 25.1%, var(--secondary) 100%);
            background-position: 100% 50%;
        }

        to {
            background-image: radial-gradient(ellipse at center, var(--primary) 0%, var(--primary) 25%, var(--secondary) 25.1%, var(--secondary) 100%);
            background-position: 50% 50%;
        }
    }

    @keyframes unchecked {
        from {
            background-image: radial-gradient(ellipse at center, var(--secondary) 0%, var(--secondary) 25%, var(--primary) 25.1%, var(--primary) 100%);
            background-position: 100% 50%;
        }

        to {
            background-image: radial-gradient(ellipse at center, var(--secondary) 0%, var(--secondary) 25%, var(--primary) 25.1%, var(--primary) 100%);
            background-position: 50% 50%;
        }
    }

    html {
        box-sizing: border-box;
        -webkit-font-smoothing: antialiased;
    }

    .plus-minus {
        transform: scale(0.5);
    }

    .activated_choice {
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
        transition: all 0.3s linear;
        border: 5px solid #5b73e8 !important;
        background: #5b73e8;
    }

    .activated_choice .fw-medium {
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
        transition: all 0.3s linear;
        color: #fff;
    }

    .activated_choice .file-card {
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
        transition: all 0.3s linear;
        height: 60px;
        margin: 20px;
        width: 80%;
    }

    .right-bar .container .card {
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
        transition: all 0.3s linear;
    }
</style>
<style>
    .file-upload {
        background-color: #ffffff;
        width: 100%;
        padding-bottom: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #5b73e8;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #2f48c1;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;

    }

    .file-upload-btn:hover {
        background: #2f48c1;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
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
        padding-left: 10px;
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
        <div class="rightbar-overlay"></div>
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
                    <h5 class="m-0 me-2">Settings</h5>
                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto" style="right: 10;position: absolute;">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>
                <hr class="mt-0">
                <h6 class="text-center mb-0"><i class="uil uil-trash delteFiles"></i><span id="files_count"></span></h6>
                <div class="container"></div>
                <div class="simplebar-placeholder" style="width: auto; height: 852px;"></div>
            </div>
        </div>
        <div id="uploadresorces" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadresorcesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="uploadresorcesLabel"> Upload Resources: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"></button>
                                </div>
                                <form action="<?= base_url('EN/Consultant/Upload_Category_resources') ?>" class="dropzone" id="fileupload">
                                    <input type="hidden" id="AccountId" name="AccountId" value="">
                                    <input type="hidden" id="AccountType" name="AccountType" value="<?= $type ?>">
                                    <input type="hidden" id="file_type" name="file_type" value="">
                                    <input type="hidden" id="language" name="language" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="showuploadedfiles" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showuploadedfilesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="showuploadedfilesLabel"> Uploaded Resources: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body listofFiles row">
					</div>
                </div>
            </div>
        </div>
        <div id="media_links" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="media_linksLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="media_linksLabel"> Media links: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body medialinkslist row"></div>
                </div>
            </div>
        </div>
        <div id="add_media_link" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add_media_linkLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="add_media_linkLabel"> Upload Resources: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"></button> </div>
                                <form id="media_link" class="needs-validation custom-validation repeater" novalidate>
                                    <input type="hidden" name="category_id" value="">
                                    <input type="hidden" name="language" value="">
                                    <div class="inner-repeater mb-4">
                                        <div data-repeater-list="media_link" class="inner form-group">
                                            <label class="form-label">Links :</label>
                                            <div data-repeater-item class="inner mb-3 row">
                                                <div class="col-md-10 col-8">
                                                    <input type="text" name="link_title" autocomplete="off" class="inner form-control" placeholder="Link title" />
                                                    <input type="url" parsley-type="url" name="media_link" type="url" autocomplete="off" required="" class="mt-1 inner form-control linkinput" placeholder="https://www.youtube.com/url" />
                                                    <span class="error error-text"></span>
                                                </div>
                                                <div class="col-md-2 col-4 d-grid">
                                                    <button data-repeater-delete type="button" class="btn btn-danger btn-block inner"><i class="uil uil-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-success inner" value="Add another link " />
                                        <button class="btn btn-primary" id="Teachersub" type="Submit">Submit form</button>
                                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="uploadinfographics" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadinfographicsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="mySmallModalLabel">Upload Unlimited Images for Infographics</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('EN/Consultant/upload_Resources') ?>" class="dropzone" id="fileupload">
                            <input type="hidden" name="AccountId" value="">
                            <input type="hidden" name="AccountType" value="<?= $type ?>">
                            <input type="hidden" id="files_language" name="files_language">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="Articles" class="modal fade" tabindex="1" role="dialog" aria-labelledby="ArticlesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="mySmallModalLabel">Upload Unlimited ArticleS (Images, Title, and Article) for Articles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="add_article">
                            <div class="file-upload">
                                <label for="title">Article Title</label>
                                <input type="text" id="title" name="title" class="form-control mb-2" placeholder="name">
                                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                                <div class="image-upload-wrap hidden">
                                    <input class="file-upload-input" type="file" name="art_image" onchange="readURL(this);" accept="image/*" />
                                    <div class="drag-text">
                                        <h3>Drag and Drop Images</h3>
                                    </div>
                                </div>
                                <div class="file-upload-content hidden">
                                    <img class="file-upload-image" src="#" alt="your image" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                    </div>
                                </div>
                            </div>
                            <textarea id="elm1" name="articles"></textarea>
                            <input type="hidden" name="accountid">
                            <input type="hidden" name="accounttype" value="<?= $type ?>">
                            <input type="hidden" name="articles_language">
                            <div class="row">
                                <div class="col-8">
                                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2">Save</button>
                                </div>
                                <div class="col-4">
                                    <button type="reset" class="btn btn-warning btn-lg btn-block waves-effect waves-light mb-1 mt-2">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="Articles_show" class="modal fade" tabindex="1" role="dialog" aria-labelledby="ArticlesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="mySmallModalLabel">Categorys Articles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ArticlesList row">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 select-systemes-container" style="overflow: auto;">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <?php if ($hasparent) { ?>
                                    <th><?= $type == "schools" ? 'Ministry' : 'Company' ?> Name</th>
                                <?php }  ?>
                                <th>Date</th>
                                <th>Action EN</th>
                                <th>Action AR</th>
                                <th>Report EN</th>
                                <th>Report AR</th>
                                <th>Media EN</th>
                                <th>Media AR</th>
                                <th class="text-center">Infographics EN</th>
                                <th class="text-center">Infographics AR</th>
                                <th class="text-center">Articles EN</th>
                                <th class="text-center">Articles AR</th>
                            </thead>
                            <tbody>
                                <?php foreach ($systemes as $sn => $systeme) { ?>
                                    <tr id="systeme-upload-<?= $systeme['Id'] ?>">
                                        <td class="key">
                                            <span>
                                                <div class="custom-control custom-checkbox">
                                                    <input value="<?= $systeme['Id'] ?>" type="checkbox" data-key="<?= $systeme['Id'] ?>" name="systeme" id="systeme-check-<?= $systeme['Id'] ?>" class="custom-control-input school-select">
                                                    <label class="custom-control-label" id="systeme-check-label-<?= $systeme['Id'] ?>" for="systeme-check-<?= $systeme['Id'] ?>"><?= $sn + 1 ?></label>
                                                </div>
                                            </span>
                                        </td>
                                        <td class="name"><?= $systeme['title'] ?></td>
                                        <?php if ($hasparent) { ?>
                                            <td><?= $systeme['ParentName'] ?></td>
                                        <?php } ?>
                                        <td class="added-at"><?= $systeme['TimeStamp'] ?></td>
                                        <td class="text-center">
                                            <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload resorces" data-account-id="<?= $systeme['Id'] ?>" data-file-type="1" data-language="EN"></i>
                                            </span>
                                            <span data-toggle="modal" data-target="#showuploadedfiles">
                                                <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload AR resorces" data-account-id="<?= $systeme['Id'] ?>" data-file-type="1" data-language="AR"></i>
                                            </span>
                                            <span data-toggle="modal" data-target="#showuploadedfiles">
                                                <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload Report" data-account-id="<?= $systeme['Id'] ?>" data-file-type="2" data-language="EN"></i>
                                            </span>
                                            <span data-toggle="modal" data-target="#showuploadedfiles">
                                                <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="upload" data-toggle="modal" data-target="#uploadresorces">
                                                <i class="uil uil-file upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload  AR Report" data-account-id="<?= $systeme['Id'] ?>" data-file-type="2" data-language="AR"></i>
                                            </span>
                                            <span data-toggle="modal" data-target="#showuploadedfiles">
                                                <i class="uil uil-servers able_to_download" data-toggle="tooltip" data-placement="top" data-original-title="show files"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="media_upload" data-toggle="modal" data-target="#add_media_link">
                                                <i class="uil uil-image-check media_upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media EN" data-account-id="<?= $systeme['Id'] ?>" data-language="EN"></i>
                                            </span>
                                            <span class="media_upload" data-toggle="modal" data-target="#media_links" data-account-id="<?= $systeme['Id'] ?>" data-language="EN">
                                                <i class="uil uil-list-ul able_to_open" data-toggle="tooltip" data-placement="top" title="" data-original-title="show links"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="media_upload" data-toggle="modal" data-target="#add_media_link">
                                                <i class="uil uil-image-check media_upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Media AR" data-account-id="<?= $systeme['Id'] ?>" data-language="AR"></i>
                                            </span>
                                            <span class="media_upload" data-toggle="modal" data-target="#media_links" data-account-id="<?= $systeme['Id'] ?>" data-language="AR">
                                                <i class="uil uil-list-ul able_to_open" data-toggle="tooltip" data-placement="top" title="" data-original-title="show links"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <i data-toggle="modal" data-language="en" data-account-id="<?= $systeme['Id'] ?>" data-target="#uploadinfographics" class="font-size-24 infographics_upload text-primary uil uil-upload-alt"></i>
                                            <i data-account-id="<?= $systeme['Id'] ?>" data-language="en" class="uil uil-clipboard-notes showuploadedFiles"></i>
                                        </td>
                                        <td class="text-center">
                                            <i data-toggle="modal" data-language="ar" data-account-id="<?= $systeme['Id'] ?>" data-target="#uploadinfographics" class="font-size-24 infographics_upload text-primary uil uil-upload-alt"></i>
                                            <i data-account-id="<?= $systeme['Id'] ?>" data-language="ar" class="uil uil-clipboard-notes showuploadedFiles"></i>
                                        </td>
                                        <td class="text-center">
                                            <i class="uil uil-plus article_upload" data-language="en" data-account-id="<?= $systeme['Id'] ?>" data-toggle="modal" data-target="#Articles"></i>
                                            <i class="uil uil-clipboard-notes articles_show" data-language="en" data-account-id="<?= $systeme['Id'] ?>" data-toggle="modal" data-target="#Articles_show"></i>
                                        </td>
                                        <td class="text-center">
                                            <i class="uil uil-plus article_upload" data-language="ar" data-account-id="<?= $systeme['Id'] ?>" data-toggle="modal" data-target="#Articles"></i>
                                            <i class="uil uil-clipboard-notes articles_show" data-language="ar" data-account-id="<?= $systeme['Id'] ?>" data-toggle="modal" data-target="#Articles_show"></i>
                                        </td>
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
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?= base_url("assets/libs/dropzone/min/dropzone.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/jquery.repeater/jquery.repeater.min.js"); ?>"></script>
<script src="<?= base_url("assets/js/pages/form-repeater.int.js") ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/tinymce/tinymce.min.js") ?>"></script>
<script>
    $('.table').DataTable({
        responsive: true
    });
    var current_url = '<?= current_url() ?>';
    var type = '<?= $type ?>';
</script>
<script src="<?= base_url('assets/js/categories-actions-min.js') ?>"></script>