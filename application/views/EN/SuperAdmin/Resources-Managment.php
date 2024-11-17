<style>
    * {
        transition: 0.5s all;
    }

    .multiple-delete {
        transition: 0.4s all;
        transform: scale(0);
    }

    .multiple-delete.seen {
        transform: scale(1);
    }

    /* Modals Animation */
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }

    .zoom-in {
        transform-origin: top;
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
</style>
<div class="main-content">
    <div class="page-content">
        <div id="ManagmentForm" class="modal fade zoom-in" tabindex="-1" role="dialog" aria-labelledby="ManagmentFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ManagmentFormLabel">Resources form</h5>
                        <button type="button" class="btn-close btn-rounded text-danger btn" data-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($backndData->inputs as $key => $column) { ?>
                            <?php if (!isset($column->choices)) { ?>
                               
								<label><?= ucfirst(ucfirst ($column->validation[0])) ?> <span class="text-danger">*</span></label>
                                <input require type="text" class="form-control mb-2" name="<?= $column->input ?>" placeholder="<?= ucfirst(ucfirst ($column->validation[0])) ?>" />
                            <?php } else { ?>
                                
								<label><?= ucfirst(ucfirst($column->validation[0])) ?> <span class="text-danger">*</span></label>
								
								
                                <select class="form-control" name="<?= $column->input ?>">
                                    <option value=""><?= $column->validation[0] ?>...</option>
                                    <?php foreach ($column->choices as $choice) { ?>
                                        <option value="<?= $choice->value ?>"><?= $choice->name ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="activeKey" value="" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-5">
                    <button type="button" class="btn btn-success waves-effect waves-light float-right creat-new ml-1">
                        <i class="uil-plus mr-2"></i><span class="mr-2">|</span> Create
                    </button>
                    <button type="button" class="btn btn-danger waves-effect waves-light float-right multiple-delete">
                        <i class="uil-trash mr-2"></i><span class="mr-2">|</span> Delete
                    </button>
                </h3>
                <table class="table table-striped  table-bordered">
                    <thead>
                        <th>#</th>
                        <?php foreach ($backndData->inputs as $key => $column) { ?>
                            <th><?= $column->validation[0] ?></th>
                        <?php } ?>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $key => $result) { ?>
                            <tr>
                                <td class="key">
                                    <span>
                                        <div class="custom-control custom-checkbox">
                                            <input value="<?= $result['Id'] ?? $result['id'] ?>" type="checkbox" data-key="<?= $result['Id'] ?? $result['id'] ?>" name="result" id="result-check-<?= $result['Id'] ?? $result['id'] ?>" class="custom-control-input key-select">
                                            <label class="custom-control-label" id="result-check-label-<?= $result['Id'] ?? $result['id'] ?>" for="result-check-<?= $result['Id'] ?? $result['id'] ?>"><?= $key + 1 ?></label>
                                        </div>
                                    </span>
                                </td>
                                <?php foreach ($backndData->inputs as $k => $column) { ?>
                                    <?php if (isset($column->formatter)) { ?>
                                      <!-- Assuming this code is inside a loop -->
										<td>
											<?php
											$valueToPrint = ''; // Default value if 'company' or 'ministry' is not found
											if (isset($column->formatter) && isset($result[$column->input])) {
												$formatterArray = json_decode(json_encode($column->formatter), true);
												$inputValue = strtolower($result[$column->input]);

												if ($inputValue === 'c') {
													$valueToPrint = 'Company';
												} elseif ($inputValue === 'm') {
													$valueToPrint = 'Ministry';
												} elseif (isset($formatterArray[$inputValue])) {
													$valueToPrint = $formatterArray[$inputValue];
												}
											}
											echo $valueToPrint;
											?>
										</td>
										
                                    <?php } else { ?>
                                        <td><?= $result[$column->input] ?></td>
                                    <?php } ?>
                                <?php  } ?>
                                <td class="text-center">
                                    <i class="uil uil-trash text-danger font-size-20 btn delete" data-toggle="tooltip" data-placement="top" data-key="<?= $result['Id'] ?? $result['id'] ?>" title="Delete"></i>
                                    <i class="uil uil-pen text-warning font-size-20 btn update" data-toggle="tooltip" data-placement="top" data-key="<?= $result['Id'] ?? $result['id'] ?>" title="Update"></i>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('.table').DataTable({
        responsive: true
    });
    var checkedKeys = [];
    $(".table").on('change', '.key-select', function(e) {
        checkedKeys = [];
        $('.key-select:checked').each(function() {
            checkedKeys.push(this.value);
        });
        if (checkedKeys.length > 0) {
            $('.multiple-delete').addClass('seen');
        } else {
            $('.multiple-delete').removeClass('seen');
        }
    });
    // Show The Modal For Creating nex data
    $('.creat-new').click(function() {
        $('#ManagmentForm').modal('show');
        $('#ManagmentForm input[name="activeKey"]').val('');
    });
    // Handle Saving the Data
    $('#ManagmentForm form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == 'ok') {
                    Swal.fire({
                        title: 'Ok',
                        text: 'The informations has been stored successfully',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 800);
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        html: response.message,
                        icon: 'error'
                    });
                }
            },
            ajaxError: function() {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("oops!! error");
            }
        });
    });
    // update 
    $(".table").on('click', '.update', function(e) {
        const id = $(this).attr('data-key');
        $.ajax({
            type: "GET",
            url: "<?= current_url() ?>/" + id,
            success: function(response) {
                if (response.status == "ok") {
                    $('#ManagmentForm input[name="activeKey"]').val(id);
                    <?php foreach ($backndData->inputs as $key => $column) { ?>
                        $("#ManagmentForm input[name='<?= $column->input ?>']").val(response.data.<?= $column->input ?>);
                    <?php } ?>
                    $('#ManagmentForm').modal('show');
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        html: response.message,
                        icon: 'error'
                    });
                }
            }
        });
    });
    // Delete
    $(".table").on('click', '.delete', function(e) {
        const id = $(this).attr('data-key');
        Swal.fire({
            title: 'Are you sure?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url() ?>/",
                    data: {
                        key: id
                    },
                    success: function(response) {
                        if (response.status == "ok") {
                            Swal.fire({
                                title: 'Ok',
                                text: 'Deleted successfully',
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: 'Sorry !',
                                html: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    });

    // multiple-delete
    $('.multiple-delete').click(() => {
        Swal.fire({
            title: 'Are you sure?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "<?= current_url() ?>/",
                    data: {
                        keys: checkedKeys
                    },
                    success: function(response) {
                        if (response.status == "ok") {
                            Swal.fire({
                                title: 'Ok',
                                text: 'Deleted successfully',
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        } else {
                            Swal.fire({
                                title: 'Sorry !',
                                html: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    });
</script>