<style>
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
<!-- chackbox style  -->
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
<!-- input of articls style -->
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
<link href="<?php echo base_url('assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />

<div class="main-content">
    <div class="page-content">
        <!-- infographics modal -->
        <div id="uploadresorces" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadresorcesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="mySmallModalLabel">Upload Unlimited Images for Infographics</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('EN/Dashboard/upload_Resources') ?>" class="dropzone" id="fileupload">
                            <input type="hidden" id="cat_id" name="cat_id">
                            <input type="hidden" id="files_language" name="files_language">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Articles modal -->
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
                            <input type="hidden" name="cat_id">
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
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
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
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 009: RESOURCE MANAGEMENT CATEGORIES</h4>
                <div class="card notstatic">
                    <div class="card-body">

                        <div class="div">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Category Title English</th>
                                    <th>Category Title Arabic</th>
                                    <th class="text-center">Infographics EN</th>
                                    <th class="text-center">Infographics AR</th>
                                    <th class="text-center">Articles EN</th>
                                    <th class="text-center">Articles AR</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($Categorys as $key => $Category) { ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $Category['Cat_en'] ?></td>
                                            <td><?= $Category['Cat_ar'] ?></td>
                                            <td class="text-center">
                                                <i data-toggle="modal" data-language="en" data-cat-id="<?= $Category['Id'] ?>" data-target="#uploadresorces" class="uil uil-upload-alt media_upload"></i>
                                                <i data-cat-id="<?= $Category['Id'] ?>" data-language="en" class="uil uil-clipboard-notes showuploadedFiles"></i>
                                            </td>
                                            <td class="text-center">
                                                <i data-toggle="modal" data-language="ar" data-cat-id="<?= $Category['Id'] ?>" data-target="#uploadresorces" class="uil uil-upload-alt media_upload"></i>
                                                <i data-cat-id="<?= $Category['Id'] ?>" data-language="ar" class="uil uil-clipboard-notes showuploadedFiles"></i>
                                            </td>
                                            <td class="text-center">
                                                <i class="uil uil-plus article_upload" data-language="en" data-cat-id="<?= $Category['Id'] ?>" data-toggle="modal" data-target="#Articles"></i>
                                                <i class="uil uil-clipboard-notes articles_show" data-language="en" data-cat-id="<?= $Category['Id'] ?>" data-toggle="modal" data-target="#Articles_show"></i>
                                            </td>
                                            <td class="text-center">
                                                <i class="uil uil-plus article_upload" data-language="ar" data-cat-id="<?= $Category['Id'] ?>" data-toggle="modal" data-target="#Articles"></i>
                                                <i class="uil uil-clipboard-notes articles_show" data-language="ar" data-cat-id="<?= $Category['Id'] ?>" data-toggle="modal" data-target="#Articles_show"></i>
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
</div>

<div class="rightbar-overlay"></div>
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            <h5 class="m-0 me-2">Settings</h5>
            <a href="javascript:void(0);" class="right-bar-toggle ms-auto" style="right: 10;position: absolute;">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <!-- Settings -->
        <hr class="mt-0">
        <h6 class="text-center mb-0"><i class="uil uil-trash delteFiles"></i><span id="files_count"></span></h6>
        <div class="container">
            <!-- list show here -->
        </div>
        <div class="simplebar-placeholder" style="width: auto; height: 852px;"></div>
    </div>
</div> <!-- end slimscroll-menu-->
</div>
<script src="<?= base_url("assets/libs/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/dropzone/min/dropzone.min.js"); ?>"></script>

<script src="<?= base_url("assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js") ?>"></script>
<script src="<?= base_url("assets/libs/tinymce/tinymce.min.js") ?>"></script>
<script>
    $('.table').DataTable();
    //removeFile 
    $(".table").on('click', ".media_upload", function(e) {
        Dropzone.forElement('#fileupload').removeAllFiles(); // remove old files from the upload form
        $('#cat_id').val($(this).attr('data-cat-id'));
        $('#files_language').val($(this).attr("data-language"));
    });

    $(".table").on('click', ".showuploadedFiles", function(e) {
        $('body').addClass('right-bar-enabled');
        $('.delteFiles').removeClass('active');
        $('#files_count').html("");

        $.ajax({
            method: "POST",
            url: '<?php echo base_url('EN/Dashboard/getResorceFilesList'); ?>',
            dataType: 'json',
            data: {
                cat_id: $(this).attr('data-cat-id'),
                language: $(this).attr('data-language')
            },
            success: function(data, status, xhr) {
                if (data.length > 0) {
                    $('.right-bar .container').html('');
                    $('.right-bar h5').html(data[0].Cat_en);
                    console.log(data[0].Cat_en);
                    var images = ['png', 'jpg', 'jpeg', 'gif'];
                    data.forEach(asset => {
                        var newhtml = '<div class="card border shadow-none" data-file-key="' + asset.FileKey + '" >';
                        newhtml += '<input type="checkbox" class="plus-minus"> ';
                        if (images.includes(asset.FileType)) {
                            newhtml += '<img class="card-img-top img-fluid" src=<?= base_url(); ?>uploads/Category_resources/' + asset.file_name + ' alt="sorry this image deleted">';
                        } else {
                            newhtml += '<div class="card-img-top img-fluid file-card"><i class="uil uil-file"></i></div>';
                        }
                        newhtml += '<label class="switch">';
                        newhtml += '<input type="checkbox" class="FileStatus"  ' + (asset.status == "1" ? 'checked' : '') + ' data-file-id="' + asset.FileKey + '">';
                        newhtml += '<span class="slider round"></span>';
                        newhtml += '</label>';
                        newhtml += '<div class="py-2 text-center">';
                        newhtml += '<a href="" class="fw-medium">Download (' + asset.FileType + ')</a>';
                        newhtml += '</div></div>';
                        $('.right-bar .container').append(newhtml);
                    });
                } else {
                    console.log(data.length);
                    $('.right-bar .container').html('<h4> Sorry no Files found here</h4>');
                    $('.right-bar h5').html("Recorces list ");
                }
            },
            error: function(xhr, status, error) {
                alert("sorry unexpexted error");
            }
        });
    });

    $(".table").on('click', ".articles_show", function(e) {
        $.ajax({
            method: "POST",
            url: '<?php echo base_url('EN/Dashboard/getCategoriesList'); ?>',
            dataType: 'json',
            data: {
                cat_id: $(this).attr('data-cat-id'),
                language: $(this).attr('data-language'),
            },
            success: function(data, status, xhr) {
                    var listOfData = data.list;
                    if (Object.keys(listOfData).length > 0) {
                        $('.ArticlesList').html('');
                        listOfData.forEach(article => {
                            var list = '<div class="col-md-6 col-xl-4">';
                            list += '<div class="card" style="border: 1px solid #e0e0e0;">';
                            list += '<label class="switch">';
                            list += '<input type="checkbox" class="ArticleStatus"  ' + (article.status == "1" ? 'checked' : '') + ' data-article-id="' + article.art_id + '">';
                            list += '<span class="slider round"></span>';
                            list += '</label>';
                            list += '<img class="card-img-top img-fluid" src="<?= base_url("uploads/articles_files/"); ?>' + article.img_url + '" alt="Card image cap">';
                            list += '<div class="card-body">';
                            list += ' <h4 class="card-title mt-0">' + article.title + '</h4>';
                            list += '<p class="card-text">';
                            list += article.art_text.slice(0 , 200) + "...Read more" ; 
                            list += '</p>';
                            list += '<button class="btn btn-danger waves-effect waves-light Delet_art mr-1" data-cat-id="' + article.art_id + '" ><i class="uil uil-trash-alt font-size-25 text-white mr-1" ></i>Delete</button>';
                            list += '<button class="btn btn-warning waves-effect waves-light Edite_Art" data-article-id="' + article.art_id + '" ><i class="uil uil-pen font-size-25 text-white mr-1"></i>Edite</button>';
                            list += '</div>';
                            list += '</div>';
                            list += '</div>';
                            list += '</div>';
                            $('.ArticlesList').append(list);
                        });
                }else{
                    $('.ArticlesList').html('<h3 class="text-center w-100"> No Response Found ! </h3>');
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                $('.ArticlesList').html('<h3 class="text-center w-100"> No Response Found ! </h3>');
            }
        });
    });
    //
    $(".right-bar").on('click', ".plus-minus", function(e) {
        $(this).parent('.card').toggleClass('activated_choice');
        if ($('.activated_choice').length > 0) {
            $('#files_count').html($('.activated_choice').length);
            // show delete icon 
            $('.right-bar .container .card').first().addClass('mt-2');
            $('.delteFiles').addClass('active');
        } else {
            $('#files_count').html("");
            $('.right-bar .container .card').first().removeClass('mt-2');
            $('.delteFiles').removeClass('active');
        }
    });

    // same function for all the div
    // $(".right-bar").on('click', ".container .card", function(e) {
    //     $(this).toggleClass('activated_choice');
    //     $(this).parent('.card').toggleClass('activated_choice');
    //     if($(this).children('.plus-minus').attr('checked') == "checked"){
    //         $(this).children('.plus-minus').removeAttr('checked');
    //     }else{
    //         $(this).children('.plus-minus').attr('checked' , "checked") 
    //     }
    //     if ($('.activated_choice').length > 0) {
    //         $('#files_count').html($('.activated_choice').length);
    //         // show delete icon 
    //         $('.right-bar .container .card').first().addClass('mt-2');
    //         $('.delteFiles').addClass('active');
    //     } else {
    //         $('#files_count').html("");
    //         $('.right-bar .container .card').first().removeClass('mt-2');
    //         $('.delteFiles').removeClass('active');
    //     }
    // });
    // on click in delte 
    $(".right-bar").on('click', ".delteFiles.active", function(e) {
        var files_array = [];
        $('.right-bar .activated_choice').each(function() {
            files_array.push($(this).attr('data-file-key'));
        });
        console.log(files_array);
        Swal.fire({
            title: "هل أنت متأكد",
            text: "You will delete " + files_array.length + " File(s) ,  لن تتمكن من التراجع عن هذا!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) { // start deleting files
                $.ajax({
                    method: "DELETE",
                    url: '<?php echo base_url('EN/Dashboard/getResorceFilesList'); ?>',
                    dataType: 'json',
                    data: {
                        files_ids: files_array,
                    },
                    success: function(data, status, xhr) {
                        if (data.status == "ok") {
                            $('.activated_choice').slideUp();
                            $('.right-bar .container .card').first().removeClass('mt-2');
                            $('.delteFiles').removeClass('active');
                            Swal.fire({
                                title: 'Deleted',
                                text: files_array.length + " File(s) , Has been deleted",
                                icon: 'success',
                                confirmButtonColor: '#5b73e8',
                            });
                            $('body').removeClass('right-bar-enabled');
                        }
                    }
                });
            }
        });
    });

    // Add restrictions
    Dropzone.options.fileupload = {
        acceptedFiles: 'image/*,application/pdf,.psd',
        maxFilesize: 50, // MB ,
    };


    // setting the category id 
    $(".table").on('click', ".article_upload", function(e) {
        $('.tox-statusbar__branding').remove();
        $("#Articles input[name='cat_id']").val($(this).attr('data-cat-id'));
        $("#Articles input[name='articles_language']").val($(this).attr('data-language'));
    });

    /*
     * btn name : article_upload
     */
    $("#add_article").on('submit', function(e) {
        e.preventDefault();
        $('#add_article .btn[type="Submit"]').attr('disabled', "disabled");
        $('#add_article .btn[type="Submit"]').html('Please wait ...');
        setTimeout(() => { // this timeout is for generating the article
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Dashboard/articles_controle',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#add_article .btn[type="Submit"]').removeAttr('disabled');
                    $('#add_article .btn[type="Submit"]').html('Save');
                    if (data.status == "ok") {
                        Swal.fire({
                            title: 'Added !',
                            text: 'The Article Added successfully .',
                            icon: 'success'
                        });
                        $('#Articles').modal('hide');
                    } else {
                        Swal.fire({
                            title: 'Sorry !',
                            text: 'We have an error in processing this request',
                            icon: 'error',
                            footer: "Please try again later"
                        });
                    }
                },
                ajaxError: function() {
                    Swal.fire({
                        title: 'Sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error',
                        footer: "Please try again later"
                    });
                }
            });
        }, 500);
    });

    ClassicEditor
        .create(document.querySelector('#classic-editor'), {
            ckfinder: {
                uploadUrl: '<?= base_url('EN/Dashboard/upload_for_articles'); ?>'
            }
        })
        .then()
        .catch(error => {
            console.error(error);
        });

    function readURL(input) {
        if (input.files && input.files[0]) {
            $('.file-upload-btn').html(' The file has been selected');
        } else {
            $('.file-upload-btn').html(' Add Image ');
        }
    }

    $("#Articles_show").on('click', ".Delet_art", function(e) {
        var category_id = $(this).attr('data-cat-id');
        var thediv = this;
        console.log($(this).parents().parents().parents().parents().html());
        Swal.fire({
            title: "Are you sure ? ",
            text: "You won't be able to revert this !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) { // start deleting files
                $.ajax({
                    method: "DELETE",
                    url: '<?php echo base_url('EN/Dashboard/getCategoriesList'); ?>',
                    data: {
                        cat_id: category_id,
                    },
                    success: function(data, status, xhr) {
                        if (data == "ok") {
                            console.log($(thediv).parents().parents().parents().parents().html());
                            $(thediv).parents().parents().parents(".col-md-6").slideUp();
                            Swal.fire({
                                title: 'Deleted',
                                text: " Articles , Has been deleted Successfully",
                                icon: 'success',
                                confirmButtonColor: '#5b73e8',
                            });
                            setTimeout(() => {
                                $(thediv).parents().parents().parents(".col-md-6").remove();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: 'Error !',
                                text: "Sorry We can't delete this article",
                                icon: 'error',
                                confirmButtonColor: '#5b73e8',
                            });
                        }
                    }
                });
            }
        });
    });


    $("#Articles_show").on('click', ".Edite_Art", function(e) {
        var id = $(this).attr('data-article-id');
        location.href = "<?= base_url("EN/Dashboard/article/"); ?>" + id;
    });


    // new editore

    $(document).ready(function() {

        if ($("#elm1").length > 0) {
            tinymce.init({
                selector: "textarea#elm1",
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

    // Prevent Bootstrap dialog from blocking focusin
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
            e.stopImmediatePropagation();
        }
    });

    
    $('.right-bar .container').on('change' ,'.FileStatus' , function () {
        var fileId = $(this).attr('data-file-id');
        $.ajax({
            type: "PUT",
            url: "<?= base_url("EN/Dashboard/getResorceFilesList"); ?>",
            data: {
                id : fileId
            },
            success: function (response) {
                if(response == "error"){
                    alert('Sorry we have an error , please try again later');
                }
            }
        });
    });
    
    $('.ArticlesList').on('change' ,'.ArticleStatus' , function () {
        var fileId = $(this).attr('data-article-id');
        $.ajax({
            type: "PUT",
            url: "<?= base_url("EN/Dashboard/getCategoriesList"); ?>",
            data: {
                id : fileId
            },
            success: function (response) {
                if(response == "error"){
                    alert('Sorry we have an error , please try again later');
                }
            }
        });
    });
</script>