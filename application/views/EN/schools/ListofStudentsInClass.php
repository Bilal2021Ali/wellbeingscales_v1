<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query( "SELECT * FROM 
l2_staff WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "'" )->result_array();

$listofteachers = $this->db->query( "SELECT * FROM 
l2_teacher WHERE Added_By = '" . $sessiondata[ 'admin_id' ] . "'" )->result_array();

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
.AddedSuccess {
    background-color: #007709;
    text-align: center;
    transition: 0.5s all;
    color: #fff;
    width: 100%;
}
.showInPageCard {
    position: fixed;
    right: 10px;
    bottom: 10px;
    z-index: 1000;
    transition: 0.5s all;
}
.hide-card {
    bottom: -200px;
}
.showInPageCard .card {
    -webkit-box-shadow: 3px 3px 5px 6px #ccc;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
    -moz-box-shadow: 3px 3px 5px 6px #ccc;  /* Firefox 3.5 - 3.6 */
    box-shadow: 3px 3px 5px 6px #ccc;  /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
}
</style>

<!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<body>
<div class="main-content">
  <div class="page-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <?php
            if ( $class !== "" ) {
                $students = $this->db->query( "SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata[ 'admin_id' ] . "' AND `Class` = '" . $class . "' " )->result_array();
                if ( !empty( $students ) ) {
                    ?>
            <table class="Students_Table" style="width: 100%;">
              <thead>
                <tr>
                  <th> # </th>
                  <th> Name </th>
                  <th> National ID </th>
                  <th> Enter </th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ( $students as $stud ) {
                    ?>
                <tr id="TrStudId<?php echo $stud['Id']; ?>">
                  <th scope="row"> <?php echo $stud['Id'];?> </th>
                  <td><?php echo $stud['F_name_EN'].' '.$stud['M_name_EN'].' '.$stud['L_name_EN'];?></td>
                  <td><?php echo $stud['National_Id'];?></td>
                  <td><form class="AddResultStudent">
                      <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37" min="30" max="40">
                      <input type="hidden" value="<?php echo $stud['Id']; ?>" name="UserId">
                      <input type="hidden" name="ST_Type" class="Test_type">
                    </form></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <script>
var  Test_type_ST = $("#Test_type").children("option:selected").val();
$('.Test_type').val(Test_type_ST);     
$(".AddResultStudent").on('focusout', function (e) {
e.preventDefault();
 $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/Results/AddResultForStudent',
     data: new FormData(this),
     contentType: false,
     cache: false,
     processData: false,
     success: function (data) {
          $('.JHZLNS').html(data);
     },
     ajaxError: function(){
     Swal.fire(
     'error',
     'oops!! we have a error',
     'error'
     )
     }
     });
});
</script>
            <?php }else{ ?>
            <div>
              <div class="row justify-content-center">
                <div class="col-sm-4">
                  <div class="error-img"> <img src="<?php echo base_url(); ?>assets/images/register-img.png" alt="" style="width: 300px;margin: auto;display: block;"> </div>
                </div>
              </div>
            </div>
            <h4 class="text-uppercase mt-4" style="text-align: center;">Sorry, page not found</h4>
            <div class="mt-5" style="text-align: center;"> <a class="btn btn-primary waves-effect waves-light"  href="<?php echo base_url(); ?>EN/schools/Tests">Back to tests Page</a> </div>
          </div>
          <?php
          }
          } else {
              echo "Please select the class.";
          }
          ?>
        </div>
        <div class="JHZLNS"></div>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
<script>
$("table").DataTable();
 
$('input[type="number"]').attr("max","40");
$('input[type="number"]').attr("min","30");
     
</script>
</html>