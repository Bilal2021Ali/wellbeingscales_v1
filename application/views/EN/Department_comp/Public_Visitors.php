<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" 
    rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" 
    rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" 
    rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
        <h4>Visitors</h4>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="visitors_table">
                            <thead>
                                <th>#</th>
                                <th>Full name</th>
                                <th>National ID</th>
                                <th>Added By</th>
                                <th>Watch MAC Address </th>
                                <th>Machine MAC Address </th>
                                <th>Add</th>
                            </thead>
                            <tbody>
                                <?php foreach($visitors as $key=>$visitor):  ?>
                                <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $visitor['full_name']; ?></td>
                                    <td><?php echo $visitor['National_Id']; ?></td>
                                    <td><?php echo $visitor['Added_By']; ?></td>
                                    <td><?php echo $visitor['watch_mac']; ?></td>
                                    <td><?php echo $visitor['machine_mac']; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url(); ?>EN/Company_Departments/add_visitor/<?php echo $visitor['user_id'] ?>" 
                                        class="btn btn-success  waves-effect waves-light">
                                          Add <i class="uil uil-plus ml-2"></i> 
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script> 
<!-- Required datatable js --> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> 
<!-- Buttons examples --> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script> 
<!-- Responsive examples --> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script> 
<!-- Datatable init js --> 
<script>
var table_st = $('#visitors_table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis']
});
table_st.buttons().container().appendTo('#visitors_table_wrapper .col-md-6:eq(0)');

</script>
</html>