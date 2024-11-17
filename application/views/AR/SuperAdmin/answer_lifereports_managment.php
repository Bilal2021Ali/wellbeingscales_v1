<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<style>
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }

    .zoom-in {
        transform: scale(0) !important;
        opacity: 0;
        -webkit-transition: 0.5s all 0s;
        -moz-transition: 0.5s all 0s;
        -ms-transition: 0.5s all 0s;
        -o-transition: 0.5s all 0s;
        transition: 0.5s all 0s;
        display: block !important;
    }

    .zoom-in.show {
        opacity: 1;
        transform: scale(1) !important;
        transform: none;
    }

    .floating_action_btn:hover {
        transform: rotateZ(45deg);
    }

    .empty {
        width: 100%;
        text-align: center;
    }

    .empty img {
        width: 240px;
        margin-bottom: 10px;
    }

    .group_content {
        height: 500px;
        overflow: auto;
    }
</style>
<style>
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

    .actions {
        font-size: 25px;
        text-align: center;
    }

    .actions .uil {
        cursor: pointer;
    }

    .input_hidden {
        background-color: transparent;
        border: 0px;
        outline: none;
    }

    .table .btn-rounded {
        padding: 2px;
        width: 30px;
        height: 30px;
        float: right;
        transform: scale(0);
        transition: 0.1s all;
    }

    .table .btn-rounded.active {
        transform: scale(1);
        transition: 0.1s all;
    }

    .approvechanges .spinner-border {
        width: 1rem !important;
        height: 1rem !important;
        font-size: 10px !important;
        color: #fff;
    }
</style>
<div class="main-content">
	
    <div class="page-content">
	<h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 046: list of complaints topics</h4>
        <div  class="page-title-box d-flex align-items-center justify-content-between">
            <a href="<?= base_url('EN/Dashboard/lifereports') ?>"> <h4 class="mb-0"><i class="uil uil-arrow-left"></i>Back to list</h4> </a>
        </div>
		
        <button type="button" data-toggle="modal" data-target="#Add_choice" class="floating_action_btn waves-effect waves-light" onClick="addquestion();">
            <i class="uil uil-plus"></i>
        </button>
        <div class="modal fade zoom-in" id="Add_choice" tabindex="-1" role="dialog" aria-labelledby="Add_choiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Add_choiceModalLabel">Add complaint topic: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					
                    <form id="creat_choice" class="p-2 needs-validation" novalidate>
                        <label for="">Title EN:</label>
                        <input type="text" name="title_en" data-parsley-minlength="3" data-parsley-maxlength="200" required class="form-control" placeholder="Title EN">
                        <label class="mt-1">Title AR:</label>
                        <input type="text" name="title_ar" data-parsley-minlength="3" data-parsley-maxlength="200" required class="form-control" placeholder="Title AR">
                        <input type="hidden" name="requestFor" value="new">
                        <input type="hidden" name="q_id" value="<?= $parent_data[0]['Id'] ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="Submit" class="btn btn-primary add_q_btn">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
        <div class="row">
		
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-2"><?= $parent_data[0]['title_en'] ?> | <?= $parent_data[0]['title_ar'] ?></h3>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Title EN</th>
                                <th>Title AR</th>
                                <th class="text-center">Delete</th>
                            </thead>
                            <tbody>
                                <?php foreach ($choices as $sn => $choice) { ?>
                                    <tr>
                                        <td class="indexcounters"><?= $sn + 1 ?></td>
                                        <td>
                                            <input type="text" data-key="<?= $choice['Id'] ?>" data-original-val="<?= $choice['title_en'] ?>" class="input_hidden" data-lang="en" name="" value="<?= $choice['title_en'] ?>">
                                            <button class="btn btn-success btn-rounded approvechanges"><i class="uil uil-check"></i></button>
                                        </td>
                                        <td>
                                            <input type="text" data-key="<?= $choice['Id'] ?>" data-original-val="<?= $choice['title_ar'] ?>" class="input_hidden" data-lang="ar" name="" value="<?= $choice['title_ar'] ?>">
                                            <button class="btn btn-success btn-rounded approvechanges"><i class="uil uil-check"></i></button>
                                        </td>
                                        <td class="actions">
                                            <i class="uil uil-trash text-danger delete" data-key="<?= $choice['Id'] ?>"  data-original-title="Delete" data-placement="top" data-toggle="tooltip"></i>
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
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>

<script>
    $('.table').DataTable();
    //creat_choice
    $('#creat_choice').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>EN/Dashboard/addlifereports_library',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#creat_choice button[type="Submit"]').html('Please wait..');
                $('#creat_choice button[type="Submit"]').attr('disabled', '');
            },
            success: function(respons) {
                $('#creat_choice button[type="Submit"]').removeAttr('disabled');
                $('#creat_choice button[type="Submit"]').html('Save');
                if (respons.status == "ok") {
                    Swal.fire({
                        title: "success",
                        text: 'complaint topic added successfully',
                        icon: 'success',
                        confirmButtonColor: '#5b73e8',
                    });
                    setTimeout(() => {
                        // location.reload();
                    }, 800);
                }
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    var lang = "";
    var value = "";
    var key = 0;
    $(".table").on('keyup', ".input_hidden", function(e) {
        e.preventDefault();
        lang = $(this).attr('data-lang');
        value = $(this).val();
        key = $(this).attr('data-key');
        var oldvalue = $(this).attr('data-original-val');
        if (value !== oldvalue) {
            $(this).parent().children('.approvechanges').addClass('active');
        } else {
            $(this).parent().children('.approvechanges').removeClass('active');
        }
    });


    $(".table").on('click', ".approvechanges", function(e) {
        $(this).html('<div class="spinner-border text-white m-1" role="status"> <span class="sr-only">Loading...</span></div>')
        $(this).attr('disabled', "");
        var hadi = $(this);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/addlifereports_library',
            data: {
                requestFor: 'Update',
                title: value,
                id: key,
                language: lang
            },
            success: function(data) {
                if (data == "Updated") {
                    hadi.html('<i class="uil uil-check"></i>')
                    hadi.removeAttr('disabled');
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
                    Command: toastr["success"]("The title updated successfully", "Updated")

                    setTimeout(() => {
                        hadi.removeClass('active');
                    }, 200);

                }
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! لدينا خطأ',
                    'error'
                )
            }
        });
    });

    $(".table").on('click', ".delete", function(e) {
        var id = $(this).attr('data-key');
        var hadi = $(this);
        Swal.fire({
            title: "هل أنت متأكد",
            text: "لن تتمكن من التراجع عن هذا!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Dashboard/addlifereports_library',
                data: {
                    requestFor: 'Delete',
                    id: id,
                },
                success: function(data) {
                    // set loader to checked
                    if (data.status == "ok") {
                        hadi.parents('tr').remove();
                        var count = 0;
                        $t('.indexcounters').each(function() {
                            $(this).html(count++);
                        });
                    }
                },
                ajaxError: function() {
                    // 
                }
            });
        });
    });
</script>