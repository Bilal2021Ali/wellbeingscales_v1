<!doctype html>
<html>

<head>
    <link href="<?= base_url() ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <meta charset="utf-8">
</head>
<style>
    .select2.select2-container {
        width: 100% !important;
    }

    .loader {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #fff;
        top: 0px;
        left: 0px;
        z-index: 100;
        text-align: center;
        padding: 50px;
    }

    .action {
        text-align: center;
    }

    .action .delete {
        color: #F40003;
        font-size: 20px;
        cursor: pointer;
    }
</style>
<style>
    .connected {
        text-align: center;
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
        background-color: #2196F3;
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
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <form id="connect_new">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="loader" style="display: none;">
                                                <div class="spinner-border text-primary m-1" role="status" style="margin: auto !important;">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <h3 class="text-center"> Admin for this Department </h3>
                                            <div class="form-group">
                                                <label class="control-label">system</label><br>
                                                <select class="form-control select2" name="for">
                                                    <?php foreach ($new_to_connect as $sys) {  ?>
                                                        <option value="<?= $sys['Id'];  ?>">
                                                            <?= $sys['Dept_Name_EN']  ?>
                                                        </option>
                                                    <?php }   ?>
                                                </select>
                                                <input type="hidden" value="<?= $thisId;   ?>" name="from">
                                            </div>
                                            <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">
                                                add
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Dept Name</th>
                                        <th>Date &amp; time</th>
                                        <th>Delete</th>
                                        <th>Add</th>
                                        <th>List</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($connects as $Key => $connected) {  ?>
                                            <tr class="animate__animated" id="conn_<?= $connected['conn_id']; ?>">
                                                <td><?= $Key + 1; ?></td>
                                                <td><?= $connected['Title']  ?></td>
                                                <td><?= $connected['In']  ?></td>
                                                <td class="action"><i class="uil uil-trash delete" for="<?= $connected['conn_id']  ?>"></i></td>
                                                <td class="action">
                                                    <label class="switch">
                                                        <input type="checkbox"  name="changeStatus" data-perm-type="adding" data-connect-id="<?= $connected['conn_id'] ?>" <?= $connected['adding'] ? "checked" : "" ?> >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td class="action">
                                                    <label class="switch">
                                                        <input type="checkbox" name="changeStatus" data-perm-type="list" data-connect-id="<?= $connected['conn_id'] ?>"  <?= $connected['list'] ? "checked" : "" ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        <?php  }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
    <script src="<?= base_url() ?>assets/libs/select2/js/select2.min.js"></script>
    <script>
        $('.table').DataTable();
        $('.select2').select2();
        $("#connect_new").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Dashboard/manage_dept_results_connect_ref',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.loader').fadeIn();
                },
                success: function(data) {
                    if (data == "ok") {
                        location.reload();
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
                        'Oops! We have an unexpected error.',
                        'error'
                    );
                }
            });
        });

        $('.delete').each(function() {
            $(this).click(function() {
                var id = $(this).attr('for');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                            url: '<?= base_url(); ?>EN/Dashboard/manage_dept_results_connect_ref',
                            data: {
                                id: id,
                            },
                            success: function(data) {
                                if (data === "ok") {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Your set has been deleted.',
                                        icon: 'success'
                                    }).then(function(result) {
                                        $('#conn_' + id).addClass('animate__flipOutX');
                                        setTimeout(function() {
                                            $('#conn_' + id).remove();
                                        }, 800);
                                    });
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
        });

        $('.card-body').on('change', 'input[name="changeStatus"]', function(e) { 
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>EN/Dashboard/manage_dept_results_connect_ref',
                data: {
                    connect_id : $(this).attr("data-connect-id") ,
                    perm_name : $(this).attr("data-perm-type")
                },
                success: function(data) {
                    if (data == "ok") {
                        Swal.fire(
                            'success',
                            'Permission status updated successfully',
                            'success'
                        );
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
                        'Oops! We have an unexpected error.',
                        'error'
                    );
                }
            });
        });

    </script>
</body>

</html>