<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?php echo base_url() ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<?php
//the site
$ref_data = $Refrigerator_infos[0];
$new_to_connect = $this->db->query("SELECT DISTINCT(`l0_organization`.Id),EN_Title,Type 
FROM `l0_organization`
JOIN `v0_area_device_permission` ON `v0_area_device_permission`.`system_id` != `l0_organization`.`Id` ")->result_array();

$connecteds = $this->db->query("SELECT 
`l0_organization`.`EN_Title` AS dept_title ,
CONCAT(`refrigerator_levels`.`device_name`,' ( ',`refrigerator_levels`.`min_temp`,' / ',`refrigerator_levels`.`max_temp` , ' )' )  AS REF_type,
`l0_organization`.`Type` AS dept_Type ,
`refrigerator_area`.`Description` AS  The_Site_Name ,
`v0_area_device_permission`.`Id` AS conn_id
FROM `v0_area_device_permission`
JOIN `refrigerator_area` ON `refrigerator_area`.`Id` = `v0_area_device_permission`.`area_id`
JOIN  `l0_organization` ON `l0_organization`.`Id` = `v0_area_device_permission`.`system_id`
JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type` 
WHERE `v0_area_device_permission`.`area_id` = '" . $ref_data['ref_id'] . "' ")->result_array();
?>
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

<body>
    <div class="main-content">
        <div class="page-content">
		<h4 class="card-title" style="background: #0eacd8; padding: 10px;color: #ffffff;border-radius: 4px;"> 0002: Connect Refrigerator with another Company </h4>
            <div class="row">
                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Connect</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="loader" style="display: none;">
                                    <div class="spinner-border text-primary m-1" role="status" style="margin: auto !important;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <form id="connect_new">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Companies List</label><br>
                                                <select class="form-control select2" name="system">
                                                    <?php foreach ($new_to_connect as $sys) {  ?>
                                                        <option value="<?php echo $sys['Id'];  ?>">
                                                            <?php echo $sys['EN_Title'] . ' (' . $sys['Type'] . ')'  ?>
                                                        </option>
                                                    <?php }   ?>
                                                </select>
                                                <input type="hidden" value="<?php echo $ref_data['ref_id']   ?>" name="for">
                                                <input type="hidden" value="0" name="type">
                                            </div>
                                            <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="mb-4">
                                    <img src="<?php echo base_url() ?>uploads/avatars/<?php echo $ref_data['Dept_puc'];  ?>" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                </div>
                                <h5 class="font-size-16 mb-1"><?php echo $ref_data['Dept_Name_EN'];  ?></h5>
                                <p class="text-muted mb-2">
                                    <a href="mailto:<?php echo $ref_data['Email'];  ?>" class="text-dark">
                                        <?php echo $ref_data['Email'];  ?>
                                    </a>
                                </p>
                                <hr>
                            </div>
                            <div class="">
                                <p><strong>MAC ADDRESS: </strong><?php echo $ref_data['mac_adress']; ?></p>
                                <p><strong>TYPE: </strong><?php echo $ref_data['device_name'] . '(' . $ref_data['min_temp'] . ' / ' . $ref_data['max_temp'] . ')';  ?></p>
                                <p><strong>SITE: </strong><?php echo $ref_data['The_Site_Name']  ?></p>
                                <p><strong>DATE &amp; TIME: </strong><?php echo $ref_data['Added_in']  ?></p>
                            </div>
                            <button type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 add" data-toggle="modal" data-target="#myModal">
                                Connect Refrigerator with another Company
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Date &amp; time</th>
                                    <th>Site</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($connecteds as $Key => $connected) {  ?>
                                        <tr class="animate__animated" id="conn_<?php echo $connected['conn_id']; ?>">
                                            <td><?php echo $Key + 1; ?></td>
                                            <td><?php echo $connected['dept_title']  ?></td>
                                            <td><?php echo $ref_data['Added_in']  ?></td>
                                            <td><?php echo $ref_data['The_Site_Name']  ?></td>
                                            <td class="action"><i class="uil uil-trash delete" for="<?php echo $connected['conn_id']  ?>"></i></td>
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
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/select2/js/select2.min.js"></script>
    <script>
        $('.table').DataTable();
        $('.select2').select2();
        $("#connect_new").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>EN/Dashboard/add_new_connect_ref',
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
                            url: '<?php echo base_url(); ?>EN/Dashboard/add_new_connect_ref',
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
    </script>
</body>

</html>