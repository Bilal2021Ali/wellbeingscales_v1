<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/libs/magnific-popup/magnific-popup.css"); ?>" rel="stylesheet" type="text/css" />
    <style>
    .delete {
        position: absolute;
        top: 6px;
        right: 15px;
        background: #fff;
        width: 35px;
        height: 35px;
        padding: 8px;
        border-radius: 100%;
        font-size: 19px;
        color: red;
        cursor: pointer;
    }

    .hasTrans {
        transition: 0.4s all;
    }

    .scale0 {
        transition: 0.4s all;
        transform: scale(0);
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
		transition: 0.2s all;
	}
	
	.floating_action_btn:hover {
		transform: rotateZ(45deg);
	}


    </style>
</head>

<body>
    <div class="main-content">
        <div class="page-content">
		 <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 006: School Gallery</h4>
            <button  data-toggle="modal" data-target=".bs-example-modal-sm" popup-form class="floating_action_btn waves-effect waves-light">
                <i class="uil uil-plus"></i>
            </button>
            <div class="row popup-gallery">
                <?php foreach ($gallery_files as $key => $g_image) { ?>
                    <div class="col-lg-4 mt-1 hasTrans" id="img_<?php echo $key; ?>">
                        <i class="uil uil-trash delete" img_name="<?php echo $g_image; ?>" imageKey="<?php echo $key; ?>"></i>
                        <a href="<?php echo base_url('assets/images/gallery/' . $g_image); ?>">
                            <div class="img-fluid">
                                <img src="<?php echo base_url('assets/images/gallery/' . $g_image); ?>" alt="" style="width: 100%;">
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <!--  Small modal example -->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="mySmallModalLabel">Small modal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('EN/Dashboard/GalleryfileUpload') ?>" class="dropzone" id='fileupload'>
                            </form>
                            Note : Please refresh the page when you add new images
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
</body>
<script src="<?php echo base_url("assets/libs/magnific-popup/jquery.magnific-popup.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/dropzone/min/dropzone.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/pages/lightbox.init.js") ?>"></script>

<script> 
		// Add restrictions
		Dropzone.options.fileupload = {
		    acceptedFiles: 'image/*',
		    maxFilesize: 1 // MB
		};

    $('.delete').each(function() {
        $(this).click(function () {
            const linkName = $(this).attr('img_name');
            const id = $(this).attr('imageKey');
            Swal.fire({
            title: 'هل أنت متأكد',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم,أحذفها!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
                if (result.value) {
                    deleteFile(linkName,id);
                }
            });
        });
    });

    function deleteFile(file_name,id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/deleteGalleryFile',
            data: {
                filename : file_name,
            },
            success: function(data) {
                if(data == "ok"){
                    $('#img_' + id).addClass('scale0');
                    setTimeout(() => {
                        $('#img_' + id).remove();
                    }, 1000);
                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                );
            }
        });
    }


</script>
</html>