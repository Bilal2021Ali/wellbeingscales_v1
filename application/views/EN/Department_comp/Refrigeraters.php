<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="visitors_table" class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Refrigerator MAC Address</th>
                                    <th>Description</th>
                                    <th>Add</th>
                                </thead>
                                <tbody>
                                    <?php foreach($Refrigeraters as $Key=>$Refrigerater): ?>
                                    <tr>
                                        <td><?php echo $Key+1 ?></td>
                                        <td><?php echo $Refrigerater['mac_adress'] ?></td>
                                        <td><?php echo $Refrigerater['Description'] ?></td>
                                        <td class="text-center">
                                        <a href="<?php echo base_url(); ?>EN/Company_Departments/add_refrigerater/<?php echo $Refrigerater['Id'] ?>" 
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
</body>
<script>
var table_st = $('#visitors_table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis']
});
table_st.buttons().container().appendTo('#visitors_table_wrapper .col-md-6:eq(0)');

</script>
</html>