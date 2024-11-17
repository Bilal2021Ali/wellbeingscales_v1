<style>
    .actions {
        text-align: center;
    }
</style>
<?php
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
function generate_string($input, $strength = 16)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}
$rand = rand(300, 999);
$code =  generate_string($permitted_chars, 5) . '-' . $rand;
?>
<div class="main-content">
    <div class="page-content">
        <div id="positionaddform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="positionaddformLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" id="addPosition">
                    <div class="modal-header">
                        <h5 class="modal-title" id="positionaddformLabel">Add a new Position</h5>
                        <button type="button" class="btn btn-rounded btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>English Position</label>
                                        <input type="text" class="form-control" placeholder="Please Enter The Position..." name="Position" required="">
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Arabic Position ar</label>
                                        <input type="text" class="form-control" placeholder="Please Enter The Position AR..." name="position_ar" required="">
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Automated Code</label>
                                        <input type="text" class="form-control" placeholder="You Can't Change This Code ): " name="Code" value="<?= $code; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="This Code is for System Use" readonly>
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="positionupdateform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="positionupdateformLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="positionupdateformLabel">Add a new Position</h5>
                        <button type="button" class="btn btn-rounded btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>English Position</label>
                                        <input type="text" class="form-control" placeholder="Please Enter The Position..." name="Position" required="">
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Arabic Position ar</label>
                                        <input type="text" class="form-control" placeholder="Please Enter The Position AR..." name="position_ar" required="">
                                        <div class="valid-feedback"> Looks good! </div>
                                    </div>
                                </div>
                                <input type="hidden" value="" name="key">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 004: Add General Position User Type for Department</h4>
        <div class="row">
            <div class="col-12">
			
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title" style="margin-bottom: 40px;">
                            Positions List :
                            <button type="button" class="btn btn-success waves-effect waves-light float-right" data-toggle="modal" data-target="#positionaddform"><i class="uil uil-plus"></i> Add </button>
                        </h3>
                        <table class="table table-bordered mt-">
                            <thead>
                                <th>#</th>
                                <th>AR Name</th>
                                <th>EN Name</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <?php foreach ($positions as $sn => $position) { ?>
                                    <tr id="position_<?= $position['Id'] ?>">
                                        <td><?= $sn + 1 ?></td>
                                        <td class="en"><?= $position['Position'] ?></td>
                                        <td class="ar"><?= $position['AR_Position'] ?></td>
                                        <td><?= $position['Code'] ?></td>
                                        <td class="actions">
                                            <i class="uil uil-trash btn btn-danger waves-effect btn-rounded font-size-15 mr-2 delete" data-key="<?= $position['Id'] ?>"></i>
                                            <i class="uil uil-pen btn btn-warning waves-effect btn-rounded font-size-15 update" data-key="<?= $position['Id'] ?>"></i>
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
<script>
    $('.table').DataTable();
    $(".table").on('click', '.delete', function(e) {
        const id = $(this).attr("data-key");
        console.log(id);
        Swal.fire({
            title: 'Are you sure you want to delete this position ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        Swal.fire(
                            'success',
                            'The Position has been deleted successfully',
                            'success'
                        );
                        $('#position_' + id).remove();
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have an unexpected error',
                            'error'
                        )
                    }
                });
            }
        })
    });

    $(".table").on('click', '.update', function(e) {
        var en = $(this).parent().parent().children('.en').html();
        var ar = $(this).parent().parent().children('.ar').html();
        var id = $(this).attr('data-key');
        $('#positionupdateform input[name="Position"]').val(en);
        $('#positionupdateform input[name="position_ar"]').val(ar);
        $('#positionupdateform input[name="key"]').val(id);
        $('#positionupdateform').modal('show');
    });

    $("#addPosition").on('submit', function(e) {
        var userposition = $('#addPosition input[name="Position"]').val();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: {
                userposition: userposition,
                code: '<?= $code; ?>',
                UserType_ar: $('#addPosition input[name="position_ar"]').val(),
            },
            success: function(data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Saved !',
                        text: "The new Position has been added successfully",
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    handleError(data.message)
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    $("#positionupdateform").on('submit', function(e) {
        var userposition = $('#positionupdateform input[name="Position"]').val();
        e.preventDefault();
        $.ajax({
            type: 'PUT',
            url: '<?= current_url(); ?>',
            data: {
                userposition: userposition,
                code: '<?= $code; ?>',
                UserType_ar: $('#positionupdateform input[name="position_ar"]').val(),
                key: $('#positionupdateform input[name="key"]').val(),
            },
            success: function(data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Saved !',
                        text: "The Position has been updated successfully",
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    handleError(data.message)
                }
            },
            ajaxError: function() {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    });

    function handleError(message) {
        Swal.fire({
            title: 'Error !',
            text: message,
            icon: 'error'
        });
    }
</script>