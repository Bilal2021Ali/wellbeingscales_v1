<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<style>
    .icon {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .valueShow {
        display: flex;
        flex-flow: row;
        justify-content: space-between;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div id="UploadIcon" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="UploadIconLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="UploadIconLabel">Icon Upload</h5>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="uil uil-upload mb-2" style="font-size: 25px;"></i><br>
                        (recommended dimensions : 40px * 40px)
                        <label class="btn btn-primary w-100 waves-effect mt-1">
                            Select icon to upload
                            <input hidden type="file" name="icon" accept="image/png, image/jpeg">
                        </label>
                        <input type="hidden" name="activeChoice">
                        <input type="hidden" name="activeLanguage">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="UpdateMark" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="UpdateMarkLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="UpdateMarkLabel">Mark</h5>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body text-center">
                        <label> Enter mark To update : </label>
                        <p>This value will take effect in ar version too </p>
                        <input type="number" class="form-control" name="Mark">
                        <input type="hidden" name="activeChoice">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <span class="float-right">EN</span>
                        <h3 class="card-title w-100">Category :</h3>
                        <h3 class="card-title w-100 mb-3 valueShow"><span><?= $choices[0]['Cat_en'] ?? '----' ?></h3>
                        <h3 class="card-title w-100">Title :</h3>
                        <h3 class="card-title w-100 mb-3 valueShow"><span><?= $choices[0]['set_name_en'] ?? '----' ?></h3>
                        <h3 class="card-title w-100">Question :</h3>
                        <h3 class="card-title w-100 mb-3 valueShow mb-5"><span><?= $choices[0]['questionName_en'] ?? '----' ?></h3>
                        <div id="ChoicesSortEn">
                            <?php foreach ($choices as $choice) { ?>
                                <div class="card type" data-id="<?= $choice['id'] ?>">
                                    <div class="card-body">
                                        <h3 class="card-title m-0">
                                            <p class="mt-1 mb-0">
                                                <?php if ($choice['icon_en'] !== null) { ?>
                                                    <img class="icon" src="<?= base_url('uploads/climate_choices_icons/' . $choice['icon_en']); ?>">
                                                <?php } else { ?>
                                                    <i class="uil uil-check"></i>
                                                <?php } ?>
                                                <?= $choice['title_en'] ?>
                                                <i data-lang="ar" id="choice_en_<?= $choice['id'] ?>" data-id="<?= $choice['id'] ?>" data-toggle="tooltip" data-placement="top" data-old-mark="<?= $choice['mark'] ?>" data-original-title="Update Mark Value" class="uil uil-abacus float-right btn waves-effect rounded font-size-18 p-1 MarkValue"></i>
                                                <i data-lang="en" data-id="<?= $choice['id'] ?>" class="uil uil-image float-right btn waves-effect rounded font-size-18 p-1 iconUpload"></i>
                                            </p>
                                        </h3>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <button class="btn btn-primary btn-block go" disabled>Save (just for preview)</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" dir="rtl">
                    <div class="card-body">
                        <span class="float-left">AR</span>
                        <h3 class="card-title w-100 text-right"> التصنيف :</h3>
                        <h3 class="card-title w-100 mb-3 valueShow"><span><?= $choices[0]['Cat_ar'] ?? '----' ?></h3>
                        <h3 class="card-title w-100 text-right">  العنوان :</h3>
                        <h3 class="card-title w-100 mb-3 valueShow"><span><?= $choices[0]['set_name_ar'] ?? '----' ?></h3>
                        <h3 class="card-title w-100 text-right">السؤال :</h3>
                        <h3 class="card-title w-100 mb-3 valueShow mb-5"><span><?= $choices[0]['questionName_ar'] ?? '----' ?></h3>
                            <?php foreach ($choices as $choice) { ?>
                                <div class="card type" dir="rtl" data-id="<?= $choice['id'] ?>">
                                    <div class="card-body">
                                        <h3 class="card-title m-0">
                                            <p class="mt-1 mb-0 text-right" >
                                                <?php if ($choice['icon_ar'] !== null) { ?>
                                                    <img class="icon ml-1 mr-0" src="<?= base_url('uploads/climate_choices_icons/' . $choice['icon_ar']); ?>">
                                                <?php } else { ?>
                                                    <i class="uil uil-check"></i>
                                                <?php } ?>
                                                <?= $choice['title_ar'] ?>
                                                <i data-lang="ar" data-id="<?= $choice['id'] ?>" class="uil uil-image float-left btn waves-effect rounded font-size-18 p-1 iconUpload"></i>
                                            </p>
                                        </h3>
                                    </div>
                                </div>
                            <?php } ?>
                        <button class="btn btn-primary btn-block go" disabled>Save (just for preview)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" integrity="sha512-zYXldzJsDrNKV+odAwFYiDXV2Cy37cwizT+NkuiPGsa9X1dOz04eHvUWVuxaJ299GvcJT31ug2zO4itXBjFx4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
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
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    // new Sortable(ChoicesSortEn, {
    //     animation: 150,
    //     ghostClass: 'sortable-ghost',
    //     onChange: function(evt) {
    //         var newsorting = [];
    //         $(evt.to).children().each(function() {
    //             newsorting.push($(this).attr('data-id'));
    //         });
    //         console.log(newsorting);
    //         updateChoicessorting(newsorting);
    //     }
    // });



    function updateChoicessorting(newsorting) {
        $.ajax({
            type: "POST",
            url: "<?= current_url() ?>",
            data: {
                newsorting: newsorting,
                type: "sorting",
            },
            success: function(response) {
                if (response.status == "ok") {
                    Command: toastr["success"]("The sorting has been successfully updated ");
                }
                else {
                    Command: toastr["error"]("Sorry !! we have an unexpected error, please try again later");
                }
            }
        });
    }

    $('.iconUpload').click(function() {
        $('#UploadIcon').modal('show');
        $('#UploadIcon input[name="activeChoice"]').val($(this).attr('data-id'));
        $('#UploadIcon input[name="activeLanguage"]').val($(this).attr('data-lang'));
    });

    $("#UploadIcon form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.status == "ok") {
                    Command: toastr["success"]("The Icon has been successfully updated ");
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
                else {
                    Command: toastr["error"](response.message);
                }
            }
        });
    });

    $('.MarkValue').click(function(){
        var $this = $(this);
        var oldmark = $($this).attr('data-old-mark');
        $('#UpdateMark').modal('show');
        $('#UpdateMark input[name="activeChoice"]').val($(this).attr('data-id'));
        $('#UpdateMark input[name="Mark"]').val($(this).attr('data-old-mark'));
    });

    $("#UpdateMark form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.status == "ok") {
                    Command: toastr["success"]("The Mark has been successfully updated ");
                    $('#choice_en_'  + $('#UpdateMark input[name="activeChoice"]').val()).attr('data-old-mark' , $('#UpdateMark input[name="Mark"]').val());
                    $('#UpdateMark').modal('hide');
                } else {
                    Command: toastr["error"](response.message);
                }
            }
        });
    });
</script>