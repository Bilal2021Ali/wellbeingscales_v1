<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />   

<style>
.changePic{
    width: 60px;
    height: 60px;
    background: rgba(0,0,0,0.61);
    color: #fff;
    display: grid;
    position: relative;
    border-radius: 100%;
    font-size: 24px;
    margin: auto;
    text-align: center;
    top: -76px;
    left: 0px;     
    padding: 10px;
    transform: scale(0);
    transition: 0.4s all;
}
      
.changePic i {
  margin-top: 8px;
}     
      
.transform{
    transform: scale(1);
}     

     .amsify-select-close{
          border: 0px solid #570001;
          background: rgba(208,0,3,1.00);
          color: #fff;
          border-radius: 2px;
          border-bottom: 5px solid #a70303;
     }       
     .amsify-select-clear {
          border: 0px solid #004D57;
          background: rgba(0,178,208,1.00);
          color: #fff;
          border-radius: 2px;
          border-bottom: 5px solid #007CCB;
     }       
</style>   

<body class="authentication-bg">

        <div class="home-btn d-none d-sm-block">
          <?php 
          $link = "";   
          if($sessiondata['type'] == 'super' ){
               $link = "Dashboard";
          }elseif($sessiondata['type'] == 'Ministry' || $sessiondata['type'] == 'Company'){
               $link = "dashboardSystem";
          }elseif($sessiondata['type'] == 'school'){
               $link = "AR/schools";
          }elseif($sessiondata['type'] == 'department'){
               $link = "Departments";
          }elseif($sessiondata['type'] == 'Teacher'){
               $link = "results";
          }elseif($sessiondata['type'] == 'Staff'){
               $link = "School_Permition";
          }elseif($sessiondata['type'] == 'Patient'){
               $link = "Departments_Permition";
          }elseif($sessiondata['type'] == 'Parent'){
               $link = "Results/Select_Child";
          }
          ?>
            <a href="<?php echo base_url().$link; ?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
        </div>
        <div class="account-pages my-5  pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div>
                            <a href="<?php echo base_url(); ?>" class="mb-5 d-block auth-logo">
                                <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" height="50" class="logo logo-dark">
                                <img src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="" height="50" class="logo logo-light">
                            </a>
                            <div class="card">
                                <div class="card-body p-4"> 
                                    <div class="p-2 mt-4" id="DropZon">
                                   <div class="user-thumb text-center mb-4">
                                   <?php 
                                   if(isset($StudentId)){
                                   $avatarlist = $this->db->query("SELECT * FROM 
                                   `l2_avatars` WHERE For_User = '".$StudentId."' 
                                   AND Type_Of_User = 'Student' LIMIT 1 ")->result_array();
                                   }else{
                                   $avatarlist = $this->db->query("SELECT * FROM 
                                   `l2_avatars` WHERE For_User = '".$sessiondata['admin_id']."' 
                                   AND Type_Of_User = '".$sessiondata['type']."' LIMIT 1 ")->result_array();
                                   }    
                                   if(!empty($avatarlist)){         
                                    foreach($avatarlist as $avatar){
                                    ?>
                                  <a href="<?php echo base_url(); ?>AR/Results/changePhoto">
                                   <img src="<?php echo base_url()."uploads/avatars/".$avatar['Link']; ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                   <div class="changePic">
                                   <i class="uil uil-camera"></i> 
                                   </div>
                                   </a>  
                                   <?php } }else{ ?>
                                  <a href="<?php echo base_url(); ?>AR/Results/changePhoto">
                                   <img src="<?php echo base_url()."uploads/avatars/default_avatar.jpg" ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                   <div class="changePic">
                                   <i class="uil uil-camera"></i> 
                                   </div>
                                   </a>  
                                   <?php } ?>
                                   <h6 class="text-primary" style="position: relative;top: -33px;" id="Toast"> Welcome </h6>
                                   <h5 class="font-size-15 mt-3" style="position: relative;top: -42px;margin: 0px;">
                                        <?php echo $sessiondata['username']; ?>
                                   </h5>
                                   </div>
                                         
                                      <form id="AddPhoto" style="margin-top: -50px;">
                                        <input type="text" name="old_password"  
                                        placeholder="Enter The Old Password" 
                                        class="form-control"> 
                                           <div class="form-group">
                                           </div>
                                            <div class="mt-3 text-right">
                                                <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit" id="sub">Change it.</button>
                                            </div>
                                        </form> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
<!-- JAVASCRIPT -->
<?php /* <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script> */ ?>
     
<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<!-- Plugins js -->
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/dropzone/min/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
     
<script>
     
$( "#AddPhoto" ).on( 'submit', function ( e ) {
     var Templatur = $('input[name="Result"]').val();
     console.log(Templatur);    
     e.preventDefault();
     $.ajax( {
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/users/UpdatePassword',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function ( data ) {
               $( '#Toast' ).html( data );
               $( '#sub' ).removeAttr('disabled');
               $( '#sub' ).html('Submit !');
          },
          beforeSend : function(){
               $( '#sub' ).attr('disabled','');
               $( '#sub' ).html('Please wait.');
          },
          ajaxError: function () {
               $( '#Toast' ).css( 'background-color', '#DB0404' );
               $( '#Toast' ).html( "Ooops! Error was found." );
          }
     } );
} );
     
</script>
    </body>
