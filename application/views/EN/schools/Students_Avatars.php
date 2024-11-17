<!doctype html>
<html>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php
$listofaStaffs = $this->db->query("SELECT * FROM 
l2_staff WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array(); 
     
$listofteachers = $this->db->query("SELECT * FROM 
l2_teacher WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();     
         
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <!-- DataTables -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
     .AddedSuccess{
          background-color: #007709;
          text-align: center;
          transition: 0.5s all;
          color: #fff;
          width: 100%;
     } 
     .showInPageCard{
          position: fixed;
          right: 10px;
          bottom: 10px;
          z-index: 1000;
          transition: 0.5s all;
     }
     .hide-card{
          bottom: -200px;
     }

     .showInPageCard .card {
               -webkit-box-shadow: 3px 3px 5px 6px #ccc;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
               -moz-box-shadow:    3px 3px 5px 6px #ccc;  /* Firefox 3.5 - 3.6 */
                box-shadow:         3px 3px 5px 6px #ccc;  /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
     }    
</style>

        <!-- Responsive datatable examples -->
<link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<body>
     <div class="main-content">
          <div class="page-content">
		  <h4 class="card-title" style="background: #07bff3;padding: 10px;color: #1E1E1E;border-radius: 4px;">CH 042 Upload Avatar</h4>
               <div class="row">
		       
               <div class="col-lg-12">
                   <div class="card">
                   <div class="card-body">
                    <?php ListStudentsChangeAvatar($class); ?>
                   </div>
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
<?php
    
function ListStudentsChangeAvatar($class){
          $ci =& get_instance();
          if($class !== ""){
          $ci->load->library( 'session' ); 
          $sessiondata = $ci->session->userdata('admin_details');
          $students = $ci->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '".$sessiondata['admin_id']."' AND `Class` = '".$class."' ")->result_array();
          if(!empty($students)){   ?> 
<table class="Students_Table table" style="width: 100%;">
<thead>
               <tr>
                    <th> # </th>
                    <th> Name </th>
                    <th> National ID </th>
                    <th> Upload </th>
               </tr>
</thead> 
<tbody>
          <?php foreach($students as $stud){ ?>
<tr id="TrStafffId<?php echo $stud['Id']; ?>" role="row" class="odd">
     <th scope="row" class="Avatar" style="text-align: center;" >
    <?php
     $avatar_teach = $ci->db->query("SELECT * FROM `l2_avatars`
     WHERE `For_User` = '".$stud['Id']."' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
     ?>
     <?php if(empty($avatar_teach)){  ?>
     <a href="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="image-popup-no-margins">
     <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="..." >
     </a>
     <?php }else{ ?>
     <a href="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar_teach[0]['Link']; ?>" class="image-popup-no-margins">
     <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar_teach[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="..." >
     </a>
     <?php } ?>          
     </th>
        <td>
        <?php echo $stud['F_name_EN'].' '.$stud['M_name_EN'].' '.$stud['L_name_EN'];?>
        </td>
       <td>
           <?php echo $stud['F_name_EN']; ?>
      </td>

      <td>
     <a href="<?php echo base_url(); ?>EN/Schools/ChangeMemberAvatar/Student/<?php echo $stud['Id']; ?>/<?php echo $class; ?>">
     <i class="uil uil-user"></i>
     </a>
     </td>
</tr>
<?php } ?>
</tbody>
</table>
<?php }   
          }else{
               echo "Please select the class.";
          }
     }      
?>
</html>