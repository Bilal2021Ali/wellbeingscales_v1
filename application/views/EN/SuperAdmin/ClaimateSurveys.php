<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="preconnect" href="https:/fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
	
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
    <link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
</head>

<style>
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
        background-color: #CB0002;
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
        background-color: #4caf50;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
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

    .delete {
        color: #fd0000;
        cursor: pointer;
    }
</style>
<div class="main-content">

    <div class="page-content">
        <h4 class="card-title" style="background: #800080; padding: 10px;color: #ffffff;border-radius: 4px;">SU 001: Climate list</h4>
        <div class="card">
            <div class="card-body">
                
                <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table class="table dt-responsive nowrap">
                        <thead>
                            <th>No</th>
                            <th>Climate Question</th>
                            <th>Climate set name </th>
                            <th>Climate category name</th>

                            <th>Date </th>
                            <th>Completed</th>

                            <th>Targeted Accounts</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php foreach ($surveys as $key => $survey) { ?>
                                <tr id="serv_<?= $survey['survey_id'] ?>">
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $survey['question'] ?></td>
                                    <td><?= $survey['set_name_en'];  ?><br><?= $survey['set_name_ar']  ?></td>
                                    <td><?= $survey['Cat_en'];  ?><br><?= $survey['Cat_ar']  ?></td>

                                    <td><?= $survey['created_at'] ?></td>
                                    <td><?= $survey['completed'] ?></td>

                                    <td><?= $survey['targeted'] == "M" ? "Ministries" : "Companies" ?></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="ischecked" data-serv-Id="<?= $survey['survey_id'];  ?>" <?= $survey['status'] == 1 ? 'checked' : "";  ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Choices Managment" href="<?php echo base_url("EN/Dashboard/climateChoices/" . $survey['survey_id']); ?>"><i class="uil uil-notes font-size-20"></i></a>
                                        <i class="uil uil-trash font-size-20 <?= $survey['isUsed'] !== '0' ? "disabled-ic" : "delete" ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Forever" for="<?= $survey['survey_id'];  ?>" key="<?= $key + 1  ?>" data-type="notfillable"></i>
                                        <i class="uil uil-file-lock-alt font-size-20 targetedaccounts text-success ml-1 btn" data-key="<?= $survey['survey_id'] ?>"></i>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade zoom-in" id="targetedaccountmodal" tabindex="-1" role="dialog" aria-labelledby="targetedaccountmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="targetedaccountmodalLabel">Targeted Accounts:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="list-content p-2">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>

<script>
    $('table').DataTable();
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
    $('.table').on('click', '.delete', function() {
        var Id = $(this).attr('for');
        var key = $(this).attr('key');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to Revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                //DELETE 	
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {
                        serv_id: Id,
                    },
                    success: function(data) {
                        if (data === "ok") {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your Question has been Deleted.',
                                icon: 'success'
                            }).then(function(result) {
                                $('#serv_' + Id).addClass('animate__flipOutX');
                                setTimeout(function() {
                                    $('#serv_' + Id).remove();
                                }, 800);
                            });
                            reset_count(key);
                        } else {
                            Swal.fire(
                                'error',
                                'Oops! We have an unexpected error.',
                                'error'
                            );
                        }
                    },
                    ajaxError: function() {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('.table').on('change', 'input[name="ischecked"]', function() {
        var surveyId = $(this).attr('data-serv-Id');
        $.ajax({
            type: "PUT",
            url: "<?= current_url() ?>",
            data: {
                surveyId: surveyId
            },
            success: function(response) {
                if (response == "ok") {
                    Command: toastr["success"]("The Status has been successfully updated ");
                }
                else {
                    Command: toastr["error"]("unexpected error , please refresh tha page");
                }
            }
        });
    });

    $('.table').on('click', '.targetedaccounts', function() {
        const key = $(this).attr('data-key');
        $('#targetedaccountmodal').modal('show');
        $.ajax({
            type: "GET",
            url: "<?= base_url("EN/Dashboard/TargetedAccounts/Climate/") ?>" + key,
            success: function(response) {
                $('#targetedaccountmodal .list-content').html(response);
            }
        });
    });
</script>