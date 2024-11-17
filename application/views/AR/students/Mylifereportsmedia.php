<link href="<?php echo base_url('assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="main-content">
    <div class="page-content">
        <div class="container row">
        <div class="col-lg-2"></div>
            <div class="col-lg-8 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h3>تحميل الصور أو مقاطع الفيديو</h3>
                        <hr>
                        <form method="post" action="<?= current_url() ?>" class="dropzone" id='fileupload'></form>
                        <button class="btn btn-success btn-block mt-1 goback" type="button"> إذا انتهيت ، انقر هنا.</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("assets/libs/dropzone/min/dropzone.min.js"); ?>"></script>
<script>
    Dropzone.options.fileupload = {
        acceptedFiles: 'image/*,mp4,mp3',
        maxFilesize: 30,
    };

    $('.goback').click(function() {
        Swal.fire({
            title: " اشكرك  ",
            text: ' سنراجع تقريرك لاحقًا ، شكرًا لك',
            icon: 'success',
        });
        setTimeout(() => {
            location.href = "<?= base_url("AR/Students/Mylifereports") ?>";
        }, 1100);
    });
</script>