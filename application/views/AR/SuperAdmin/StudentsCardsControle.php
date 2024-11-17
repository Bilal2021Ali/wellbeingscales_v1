<style>
    .card1 {
        border: 4px solid #000;
        background-color: #ff9c38;
        color: #fff;
    }

    .card2 {
        border: 4px solid #000;
        background-color: #ff9c38;
        color: #fff;
    }

    .card3 {
        border: 4px solid #000;
        background-color: #fedace;
        color: #fff;
    }

    .card4 {
        border: 4px solid #000;
        background-color: #fedace;
        color: #fff;
    }

    .card5 {
        border: 4px solid #000;
        background-color: #aeeaff;
        color: #fff;
    }

    .card6 {
        border: 4px solid #000;
        background-color: #aeeaff;
        color: #fff;
    }

    .card7 {
        border: 4px solid #000;
        background-color: #ffcd05;
        color: #fff;
    }

    .card8 {
        border: 4px solid #000;
        background-color: #ffcd05;
        color: #fff;
    }

    .card9 {
        border: 4px solid #000;
        background-color: #fe0404;
        color: #fff;
    }

    .card10 {
        border: 4px solid #000;
        background-color: #fe0404;
        color: #fff;
    }

    .card11 {
        border: 4px solid #000;
        background-color: #d9eb96;
        color: #fff;
    }

    .card12 {
        border: 4px solid #000;
        background-color: #d9eb96;
        color: #fff;
    }

    .card {
        border: 1px solid #000;
        background-color: #ff6a00;
        color: #fff;
    }

    .card h3 {
        color: #fff;
        font-weight: bold;
    }

    .date {
        font-size: 10px;
    }

    .image-container {
        display: grid;
        align-items: center;
    }
</style>
<style>
    .action {
        position: absolute !important;
        right: 27px;
        z-index: 10000;
        top: -10px;
        opacity: 0;
        transition: 0.2s all;
    }

    .card-item.active .action {
        transition: 0.2s all;
        top: 20px !important;
        opacity: 1 !important;
    }

    .addnew {
        bottom: 70px !important;
    }

    .modal-body .card * {
        color: #000;
    }

    .imgtrager {
        cursor: pointer;
    }

    .alert p {
        margin: 0px !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <section data-toggle="modal" data-target="#addnew">
            <button class="feedback_btn addnew" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="Send feed back for this page">
                <i class="uil uil-plus"></i>
            </button>
        </section>
        <div class="row">
            <?php foreach ($cards as $card) { ?>
                <div class="col-lg-3 col-sm-12 col-md-3">
                    <div class="card<?= rand(1, 12) ?> card-item card-item-<?= $card['Id'] ?>">
                        <div class="card-body">
                            <button type="button" data-card-id="<?= $card['Id'] ?>" class="btn btn-primary btn-rounded waves-effect waves-light action update"><i class="uil uil-pen"></i></button>
                            <button type="button" data-card-id="<?= $card['Id'] ?>" class="btn btn-danger btn-rounded waves-effect waves-light action mr-5 delete" style="transition-delay: 0.1s;"><i class="uil uil-trash"></i></button>
                            <div class="row">
                                <div class="col-6">
                                    <h3>--</h3>
                                    <p><?= $card['title'] ?></p>
                                    <h3><?= $card['goal'] ?></h3>
                                    <p>Tageted goal</p>
                                    <p class="date">--/--/----<br>Last update</p>
                                </div>
                                <div class="col-6 p-0 image-container">
                                    <img src="<?= base_url("uploads/Dashboard_icons/" . $card['icon']) ?>" class="img-responsive w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="modal fade example-modal-md" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add a new card </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="card bg-white" id="addnewcardform">
                            <div class="card-body">
                                <div class="alert alert-danger text-center" style="display: none;"></div>
                                <div class="row">
                                    <div class="col-6">
                                        <h3 style="margin: left 2px;">--</h3>
                                        <input type="text" name="title" class="form-control mb-1" placeholder="Title">
                                        <input type="number" min="0" name="goal" class="form-control mb-1" placeholder="Goal">
                                        <p style="margin: left 2px;">Tageted goal</p>
                                        <p class="date" style="margin: left 2px;">--/--/----<br>Last update</p>
                                    </div>
                                    <div class="col-6 p-0 image-container">
                                        <img src="<?= base_url("assets/images/login-img.png") ?>" class="img-responsive w-100 imgtrager" height="150" width="100" alt="">
                                        <p class="text-center">click to change the image</p>
                                        <input type="file" class="d-none" name="icon" onchange="readURL(this,'#addnewcardform .imgtrager');" accept="image/*">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 text-white"> Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade example-modal-md" id="update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add a new card </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="card bg-white" id="updatecard">
                            <div class="card-body">
                                <div class="alert alert-danger text-center" style="display: none;"></div>
                                <div class="row">
                                    <div class="col-6">
                                        <h3 style="margin: left 2px;">--</h3>
                                        <input type="text" name="title" class="form-control mb-1" placeholder="Title">
                                        <input type="number" min="0" name="goal" class="form-control mb-1" placeholder="Goal">
                                        <p style="margin: left 2px;">Tageted goal</p>
                                        <p class="date" style="margin: left 2px;">--/--/----<br>Last update</p>
                                    </div>
                                    <div class="col-6 p-0 image-container">
                                        <img src="<?= base_url("assets/images/login-img.png") ?>" class="img-responsive w-100 imgtrager" height="150" width="100" alt="">
                                        <p class="text-center">click to change the image</p>
                                        <input type="file" class="d-none" name="icon" onchange="readURL(this,'#updatecard .imgtrager');" accept="image/*">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="">
                                <button type="submit" class="btn btn-primary w-100 text-white"> Update </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".card-item").hover(
        function() {
            $(this).addClass("active");
        },
        function() {
            $(this).removeClass("active");
        }
    );

    $('#addnewcardform .imgtrager').click(function() {
        $('#addnewcardform input[name="icon"]').trigger('click');
    });

    $('#updatecard .imgtrager').click(function() {
        $('#updatecard input[name="icon"]').trigger('click');
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

    $('#addnewcardform').on('submit', function(e) {
        e.preventDefault();
        $('#addnewcardform .alert-danger').hide();
        $('#addnewcardform .btn[type="submit"]').html('Please wait...');
        $('#addnewcardform .btn[type="submit"]').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#addnewcardform .btn[type="submit"]').html('save');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'The data was inserted.',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    $('#addnewcardform .btn[type="submit"]').removeAttr('disabled');
                    $('#addnewcardform .alert-danger').show();
                    $('#addnewcardform .alert-danger').html(response.messages);
                }
            }
        });
    });

    $('#updatecard').on('submit', function(e) {
        e.preventDefault();
        $('#updatecard .alert-danger').hide();
        $('#updatecard .btn[type="submit"]').html('Please wait...');
        $('#updatecard .btn[type="submit"]').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#updatecard .btn[type="submit"]').html('save');
                if (response.status == "ok") {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'The data was inserted.',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    $('#updatecard .btn[type="submit"]').removeAttr('disabled');
                    $('#updatecard .alert-danger').show();
                    $('#updatecard .alert-danger').html(response.messages);
                }
            }
        });
    });

    $('.delete').click(function() {
        var id = $(this).attr('data-card-id');
        Swal.fire({
            title: 'Are you sure you want to delete this card ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `نعم`,
            cancelButtonText: `No`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url(); ?>",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        if (response.status == "ok") {
                            $('.card-item-' + id).slideUp(400, function() {
                                $('.card-item-' + id).remove();
                            });
                        } else {
                            Swal.fire(
                                'error',
                                'Sorry !! we have an unexpected error, please try again later..',
                                'error'
                            )
                        }
                    }
                });
            }
        });
    });



    $('.update').click(function() {
        var id = $(this).attr('data-card-id');
        var $this = $(this);
        $.ajax({
            type: "GET",
            url: "<?= current_url() ?>/" + id,
            success: function (response) {
                if(response.status == "ok"){
                    $('.card-item-' + id).removeClass('active');
                    $('#update input[name="title"]').val(response.data.title);
                    $('#update input[name="goal"]').val(response.data.goal);
                    $('#update input[name="id"]').val(response.data.Id);
                    $('#update .imgtrager').attr("src" , "<?= base_url('uploads/Dashboard_icons/') ?>" + response.data.icon);
                    $('#update').modal('show');
                }
            }
        });
    });
</script>