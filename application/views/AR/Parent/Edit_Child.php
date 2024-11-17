<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />   

<style>
.changePic {
    width: 88px;
    height: 86px;
    background: rgba(0,0,0,0.61);
    color: #fff;
    display: grid;
    position: relative;
    border-radius: 100%;
    font-size: 24px;
    margin: auto;
    text-align: center;
    top: -93px;
    left: 0px;
    padding: 30px;
    opacity: 0;
    transition: 0.4s all;
}     
     
      
.changePic:hover{
     opacity: 1;
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
            <a href="<?php echo base_url()."Results/Select_Child";?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
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
                                    <div class="p-2 mt-4">
                                        <div class="user-thumb text-center">
                                               <?php foreach($studentdata as $data){ ?>
                                   <?php 
                                   $avatarlist = $this->db->query("SELECT * FROM 
                                   `l2_avatars` WHERE For_User = '".$CH_ID."' 
                                   AND Type_Of_User = 'Student' LIMIT 1 ")->result_array();
                                   if(!empty($avatarlist)){      
                                    foreach($avatarlist as $avatar){
                                    ?>
                                  <a href="<?php echo base_url() ?>AR/users/changePhoto/Student/<?php echo $CH_ID; ?>">
                                   <img src="<?php echo base_url()."uploads/avatars/".$avatar['Link']; ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                   <div class="changePic">
                                   <i class="uil uil-camera"></i> 
                                   </div>
                                   </a>  
                                   <?php }
                                   }else{    ?>
                                  <a href="<?php echo base_url(); ?>AR/users/changePhoto/Student/<?php echo $data['Id']; ?>">
                                   <img src="<?php echo base_url()."uploads/avatars/default_avatar.jpg" ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                   <div class="changePic">
                                   <i class="uil uil-camera"></i> 
                                   </div>
                                   </a>  
                                   <?php }   ?>
                                             <h6 class="text-primary" style="position: relative;top: -33px;" id="Toast"> Welcome </h6>
                                            <h5 class="font-size-15 mt-3" style="position: relative;top: -42px;margin: 0px;"><?php echo $sessiondata['username']; ?></h5>
                                        </div>
                                        <div id="AddResult" class="row">
                                             <div class="col-md-6">
                                            <div class="form-group">
                                               <label >
                                                  First Name : <?php echo $data['F_name_EN']; ?>
                                               </label>
                                            </div>                                            
                                            <div class="form-group">
                                               <label >
                                                  Middle Name : <?php echo $data['M_name_AR']; ?>
                                               </label>
                                            </div>                                            
                                            <div class="form-group">
                                               <label >
                                                  Last Name : <?php echo $data['L_name_EN']; ?>
                                               </label>
                                            </div> 
                                             </div>                                           
                                             <div class="col-md-6">
                                            <div class="form-group">
                                               <label >
                                                 Date Of Birth : <?php echo $data['DOP']; ?>
                                               </label>
                                            </div>                                            
                                            <div class="form-group">
                                               <label >
                                                  Phone : <?php echo $data['Phone']; ?>
                                               </label>
                                            </div>                                            
                                            <div class="form-group">
                                               <label style="font-size: 12px; ">
                                                  National ID : <?php echo $data['UserName']; ?>
                                               </label>
                                            </div> 
                                             </div>                                           
                                             <?php } ?>
                                            <div class="mt-3 text-right btn-block">
                                                <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit" id="Back">Back</button>
                                            </div>
                                        </div>
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
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.amsifyselect.js"></script>

     
<script>
$('#Back').click(function(){
     location.href = "<?php echo base_url() ?>AR/results/Select_Child";
});

</script>
    </body>
