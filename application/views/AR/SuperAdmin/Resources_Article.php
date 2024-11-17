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
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form id="Update_article">
                            <div class="file-upload">
                                <label for="title">Article Title :</label>
                                <input type="text" id="title" name="title" value="<?= $article['title'] ?>" class="form-control mb-2" placeholder="name">
                                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Update Image</button>
                                <div class="image-upload-wrap hidden">
                                    <input class="file-upload-input" type="file" name="art_image" onchange="readURL(this);" accept="image/*" />
                                    <div class="drag-text">
                                        <h3>Drag and drop a file or select add Image</h3>
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
                            <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2">save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js") ?>"></script>
<script src="<?= base_url("assets/libs/tinymce/tinymce.min.js") ?>"></script>
<script>
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

    $("#Update_article").on('submit', function(e) {
        e.preventDefault();
        $('#Update_article .btn[type="Submit"]').attr('disabled', "disabled");
        $('#Update_article .btn[type="Submit"]').html('Please wait ...');
        var Content = tinymce.activeEditor.getContent();
        console.log($('#elm1').val(Content));
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#Update_article .btn[type="Submit"]').removeAttr('disabled');
                $('#Update_article .btn[type="Submit"]').html('Save');
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Updated!​',
                        text: 'The Article Updated successfully .',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error',
                        footer: data.messages
                    });
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    $(document).ready(function() {

if ($("#elm1").length > 0) {
    tinymce.init({
        selector: "textarea#elm1",
        init_instance_callback: "insert_contents",
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

function insert_contents(inst){
    inst.setContent(`<?= $article['Article']; ?>`);  
}

// Prevent Bootstrap dialog from blocking focusin
$(document).on('focusin', function(e) {
if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
    e.stopImmediatePropagation();
}
});
</script>