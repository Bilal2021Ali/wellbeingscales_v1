<style>
    .classChoice.checked .card {
        border: 3px solid #35c38f;
    }

    .classChoice .avatar-title {
        color: #5b73e8;
        background-color: rgba(91, 115, 232, .25);
    }

    .classChoice.checked .avatar-title {
        background-color: rgba(52, 195, 143, 0.25) !important;
        color: #34c38f !important;
    }

    .disabled .card {
        border: 1px solid #636363;
        background: #c5c5c5;
        color: #fff;
    }

    .disabled .avatar-title {
        color: #fff !important;
        background: #969595;
    }

    .disabled .text-muted a {
        color: #fff !important;
    }

    .delete-class {
        cursor: pointer;
        position: absolute;
        top: 3px;
        left: 10px;
        font-size: 20px;
        color: #de0000;
    }

    .delete-class.disabled {
        color: gray;
    }

    .edit-class-name,
    .savenewvalue {
        cursor: pointer;
    }

    .spinner-border {
        width: 1rem;
        height: 1rem;
        font-size: 10px;
    }

    .alert p {
        margin: 0px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <button class="feedback_btn" data-toggle="modal" data-target="#Addnew" style="bottom : 65px" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add class">
            <i class="uil uil-plus"></i>
        </button>
        <div id="Addnew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddnewLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" id="addingnewclass">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="AddnewLabel">Add a new class</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" style="display: none"></div>
                        <label>Name en :</label>
                        <input type="text" class="form-control" name="name_en" placeholder="Name EN">
                        <label class="mt-1">Name ar :</label>
                        <input type="text" class="form-control" name="name_ar" placeholder="Name AR">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $ClassesList = $this->db->query("SELECT * ,
        (SELECT COUNT(Id) FROM `l2_school_classes` WHERE  `class_key` = `r_levels`.`Id`  ) AS UsingCounter ,
        (SELECT COUNT(Id) FROM `l2_student` WHERE `Class` = `r_levels`.`Id` ) AS studentsCounter ,
        (SELECT COUNT(Id) FROM `l2_school_classes` WHERE `school_id` = '" . $sessiondata['admin_id'] . "' AND `class_key` = `r_levels`.`Id` ) as isExist
        FROM `r_levels`")->result_array(); ?>
        <div class="row">
            <?php foreach ($ClassesList as $list) { ?>
                <div data-toggle="tooltip" data-placement="top" title="" class="col-xl-3 col-sm-6 classChoice classChoice-<?= $list['Id'] ?>" data-class-id="<?= $list['Id']; ?>">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="uil uil-trash delete-class" data-class-id="<?= $list['Id']; ?>"></i>
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title rounded-circle text-primary">
                                    <i class="uil uil-check display-4 m-0"></i>
                                </div>
                            </div>
                            <h5 class="font-size-16 mb-1 text-dark"> <?= $list['Class']; ?> <i class="uil uil-pen text-success edit-class-name" data-id="<?= $list['Id']; ?>"></i> </h5>
                            <div class="input-group mt-3 mb-3 classupdate" style="display: none" id="class-update-<?= $list['Id'] ?>">
                                <input type="text" class="form-control" placeholder="Class name" value="<?= $list['Class']; ?>">
                                <span class="input-group-text bg-success text-white savenewvalue" data-id="<?= $list['Id']; ?>"><i class="mdi mdi-check"></i></span>
                                <div class="valid-feedback text-danger"></div>
                            </div><!-- input-group -->
                            <p class="text-muted mb-0"><a href="<?= base_url('studentsInClass/' . $list['Id']); ?>"><?= $list['UsingCounter'] > 0 ? "Students in this class : " . $list['studentsCounter'] : "No student in this class yet." ?></a></p>
                            <p class="text-muted mb-2"><?= $list['studentsCounter'] > 0 ? "used in : " . $list['UsingCounter'] . " school(s)" : "Never used in any school" ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('.edit-class-name').click(function() {
        var id = $(this).attr('data-id');
        $('#class-update-' + id).slideToggle();
    });

    $('.savenewvalue').click(function() {
        var newvalue = $(this).parent().find('input').val();
        var $this = $(this);
        if (newvalue.length < 2) {
            $(this).parent().find('.valid-feedback').show();
            $(this).parent().find('.valid-feedback').html("The class name must be at least 3 characters long");
        } else if (newvalue.length > 50) {
            $(this).parent().find('.valid-feedback').show();
            $(this).parent().find('.valid-feedback').html("The class name can't be more than 50 characters long");
        } else {
            $(this).parent().find('.valid-feedback').hide();
            $(this).parent().find('.valid-feedback').html("");
            $(this).parent().find('.savenewvalue').html('<div class="spinner-border text-white m-1" role="status"><span class="sr-only">Loading...</span></div>');
            $.ajax({
                type: "POST",
                url: "<?= current_url() ?>/" + $($this).attr('data-id'),
                data: {
                    newname: newvalue,
                },
                success: function(response) {
                    if (response.status == "ok") {
                        $($this).parent().find('.savenewvalue').html('<i class="mdi mdi-check"></i>');
                        $('#class-update-' + $($this).attr('data-id')).slideUp();
                        $('#class-update-' + $($this).attr('data-id')).parent().find('h5').html(newvalue);
                    } else {
                        alert('Unexpected error , please try again later')
                    }
                }
            });
        }
    });

    $('.delete-class').click(function() {
        var $this = $(this);
        Swal.fire({
            title: 'هل أنت متأكد',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `نعم`,
            cancelButtonText: ` إلغاء `,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url(); ?>/" + $($this).attr('data-class-id'),
                    success: function(response) {
                        if (response.status == "ok") {
                            $(".classChoice-" + $($this).attr('data-class-id')).slideUp(400, function() {
                                $(".classChoice-" + $($this).attr('data-class-id')).remove();
                            });
                        } else {
                            alert('Unexpected error , please try again later')
                        }
                    }
                });
            }
        });
    });

    $('#addingnewclass').submit(function(e) {
        e.preventDefault();
        $('#addingnewclass .alert').hide();
        $('#addingnewclass button[type="submit"]').html('Please wait...');
        $('#addingnewclass button[type="submit"]').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: "<?= current_url() ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#addingnewclass button[type="submit"]').html('Save changes');
                $('#addingnewclass button[type="submit"]').removeAttr('disabled');
                if (response.status == "ok") {
                    $('#addingnewclass .alert').removeClass('alert-danger');
                    $('#addingnewclass .alert').addClass('alert-success');
                    $('#addingnewclass .alert').show();
                    $('#addingnewclass .alert').html('Class added successfully');
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                } else {
                    $('#addingnewclass .alert').show();
                    $('#addingnewclass .alert').html(response.messages);
                }
            }
        });
    });
</script>