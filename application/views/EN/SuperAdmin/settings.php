<style>
    .card {
        text-align: center;
    }

    .card .uil {
        font-size: 100px;
    }

    .logo-control.checked {
        border: 1px solid green;
    }

    .logo-control {
        font-size: 20px;
        padding: 5px;
        border: 1px solid #eaeaea;
        border-radius: 5px;
        cursor: pointer;
    }

    .logo-control .uil {
        float: right;
        cursor: pointer;

    }

    .logo-control img {
        border-top: 1px solid #eaeaea;
    }

    .logo-control .uil-check {
        color: gray;
    }

    .logo-control.checked .uil-check {
        color: green;
    }

    .logo-control .uil-trash {
        color: red;
    }

    .savenewlogo {
        display: none;
    }

    .newlogo {
        display: none;
    }

    .newlogo.active {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0px;
        left: 0px;
        display: grid;
        align-items: center;
        justify-content: center;
        z-index: 100000;
        background: #fff;
    }
</style>
<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
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
        background-color: #A2A2A2;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #27AD00;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #27AD00;
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
<link href="<?= base_url() ?>assets/libs/toastr/build/toastr.min.css" rel="stylesheet">

<div class="main-content">
    <div class="page-content">

        <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Logos List</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="min-height: 210px;">
                        <div class="row">
                            <form id="newlogo" class="newlogo">
                                <div class="text-center">
                                    <h3> Upload New </h3>
                                    <input type="file" name="newlogo">
                                    <button type="Submit" class="btn btn-outline-primary waves-effect waves-light w-100 mt-2 uploadnewlogo">Upload</button>
                                </div>
                            </form>
                        </div>
                        <div class="row logos">
                            <div class="col-lg-6 mt-2">
                                <div class="logo-control checked default">
                                    <i class="uil uil-check"></i> <i class="uil uil-trash DeleteLogo" data-file-name="<?= $settings['logo_url'] ?>"></i>
                                    <img class="w-100" src="<?= base_url("assets/images/settings/logos/" . $settings['logo_url']) ?>" alt="">
                                </div>
                            </div>
                            <?php if (isset($logos)) { ?>
                                <?php foreach ($logos as $logo) { ?>
                                    <?php if ($logo !== $settings['logo_url']) { ?>
                                        <div class="col-lg-6 mt-2">
                                            <div class="logo-control" data-logo-name="<?= $logo ?>">
                                                <i class="uil uil-check"></i> <i class="uil uil-trash DeleteLogo" data-file-name="<?= $logo ?>"></i>
                                                <img class="w-100" src="<?= base_url("assets/images/settings/logos/" . $logo) ?>" alt="">
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary showupload">Upload New Logo</button>
                        <button type="button" class="btn btn-primary savenewlogo">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="apicopy" tabindex="-1" role="dialog" aria-labelledby="apicopyTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="apicopyTitle">Api Copy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="min-height: 210px;display: grid;align-items: center;text-align: center;">
                        <div>
                            <label class="switch">
                                <input type="checkbox" name="apicopying" class="give_permission" <?= $settings['api_copy'] ? 'checked' : '' ?>>
                                <span class="slider round"></span>
                            </label>
                            <br>
                            <br>
                            Change status (auto save)
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 015: White label - System</h4>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <i class="uil uil-image"></i>
                        <h3 class="w-100 text-center"> Logo Control </h3>
                        <button type="button" data-toggle="modal" data-target="#exampleModalScrollable" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Upload white label logo</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <i class="uil uil-brush-alt"></i>
                        <h3 class="w-100 text-center"> Control monitors pages colors </h3>
                        <a href="<?= base_url("EN/Dashboard/dialosticbp") ?>" type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1"> Settings </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <i class="uil uil-file"></i>
                        <h3 class="w-100 text-center"> Control students dashboard cards </h3>
                        <a href="<?= base_url("EN/Dashboard/StudentsCards") ?>" type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1"> Settings </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <i class="uil uil-copy"></i>
                        <h3 class="w-100 text-center"> Api copy</h3>
                        </h3>
                        <button type="button" data-toggle="modal" data-target="#apicopy" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">Open the control</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <i class="uil uil-file"></i>
                        <h3 class="w-100 text-center"> Classes </h3>
                        <a href="<?= base_url("EN/Dashboard/classes") ?>" type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1"> Settings </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <i class="uil uil-chat-bubble-user"></i>
                        <h3 class="w-100 text-center"> The welcome page </h3>
                        <a href="<?= base_url("EN/Dashboard/welcome") ?>" type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1"> Control </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
    <script>
        var urlname = "";
        $('.logo-control').click(function() {
            if (!$(this).hasClass('default')) {
                $('.savenewlogo').show();
            } else {
                $('.savenewlogo').hide();
            }
            $('.logo-control').removeClass('checked');
            $(this).addClass('checked');
            urlname = $(this).attr('data-logo-name');
        });

        $('.showupload').click(function() {
            $('.newlogo').toggleClass('active');
            if ($('.newlogo').hasClass('active')) {
                $('.showupload').html('back to list');
            } else {
                $('.showupload').html('upload new logo');
            }
        });

        $('.savenewlogo').click(function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Dashboard/updatelogo',
                data: {
                    url_name: urlname
                },
                beforeSend: function() {
                    $('.savenewlogo').attr('disabled', "");
                    $('.savenewlogo').html(' please wait !! ');
                },
                success: function(data) {
                    $('.savenewlogo').removeAttr('disabled', "");
                    $('.savenewlogo').html(' save changes ');
                    if (data == "ok") {
                        Swal.fire({
                            title: "Updated",
                            text: 'the logo has been updated in the whole system',
                            icon: 'success',
                            confirmButtonColor: '#5b73e8'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        Swal.fire({
                            title: "error",
                            text: 'sorry wa have a error',
                            icon: 'error',
                            confirmButtonColor: '#5b73e8'
                        });
                    }
                },
                ajaxError: function() {
                    Swal.fire({
                        title: "error",
                        text: 'sorry wa have a error',
                        icon: 'error',
                        confirmButtonColor: '#5b73e8'
                    });
                }
            });
        });

        $('.DeleteLogo').click(function() {
            var filename = $(this).attr('data-file-name');
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
                        url: '<?php echo base_url(); ?>EN/Dashboard/updatelogo',
                        data: {
                            url_name: filename
                        },
                        beforeSend: function() {
                            $('.savenewlogo').attr('disabled', "");
                            $('.savenewlogo').html(' please wait !! ');
                        },
                        success: function(data) {
                            $('.savenewlogo').removeAttr('disabled', "");
                            $('.savenewlogo').html(' save changes ');
                            if (data == "ok") {
                                Swal.fire({
                                    title: "Deleted",
                                    text: 'the logo has been Deleted ',
                                    icon: 'success',
                                    confirmButtonColor: '#5b73e8'
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 800);
                            } else {
                                Swal.fire({
                                    title: "error",
                                    text: 'sorry wa have a error',
                                    icon: 'error',
                                    confirmButtonColor: '#5b73e8'
                                });
                            }
                        },
                        ajaxError: function() {
                            Swal.fire({
                                title: "error",
                                text: 'sorry wa have a error',
                                icon: 'error',
                                confirmButtonColor: '#5b73e8'
                            });
                        }
                    });
                }
            });
        });


        $("#newlogo").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Dashboard/settings',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.uploadnewlogo').attr('disabled', "");
                    $('.uploadnewlogo').html(' please wait !! ');
                },
                success: function(data) {
                    $('.uploadnewlogo').removeAttr('disabled', "");
                    $('.uploadnewlogo').html(' save changes ');
                    if (data.status == "ok") {
                        Swal.fire({
                            title: "Updated",
                            text: 'the logo has been updated in the whole system',
                            icon: 'success',
                            confirmButtonColor: '#5b73e8'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        Swal.fire({
                            title: "error",
                            text: data.messages,
                            icon: 'error',
                            confirmButtonColor: '#5b73e8'
                        });
                    }
                },
                ajaxError: function() {
                    $('.alert.alert-info').css('background-color', '#DB0404');
                    $('.alert.alert-info').html("Ooops! Error was found.");
                }
            });
        });

        $('input[name="apicopying"]').change(function() {
            var status = $(this).is(':checked') ? '1' : '0';
            $.ajax({
                type: 'POST',
                data: {
                    status: status,
                },
                url: '<?= base_url(); ?>EN/Dashboard/apicopying',
                success: function(data) {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 300,
                        "timeOut": 3000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "slideDown",
                        "hideMethod": "fadeOut"
                    }
                    Command: toastr["success"](data, "success")
                }
            });
        });
    </script>