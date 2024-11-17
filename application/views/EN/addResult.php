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
            <a href="<?php echo $dashlink; ?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
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
                                        <div class="user-thumb text-center mb-4">
                                             
                                   <?php
                                   if(isset($Student)){
                                        $changephoto = base_url()."Users/changePhoto/Student/".$userId;
                                   }else{
                                        $changephoto = base_url()."Users/changePhoto";
                                   }          
                                   $avatarlist = $this->db->query("SELECT * FROM 
                                   `l2_avatars` WHERE For_User = '".$userId."' 
                                   AND Type_Of_User = '".$Type."' LIMIT 1 ")->result_array();
                                    if(!empty($avatarlist)){ 
                                    foreach($avatarlist as $avatar){
                                    ?>
                                  <a href="<?php echo $changephoto; ?>">
                                   <img src="<?php echo base_url()."uploads/avatars/".$avatar['Link']; ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                   <div class="changePic">
                                   <i class="uil uil-camera"></i> 
                                   </div>
                                   </a>  
                                   <?php }
                                    }else{ ?>
                                  <a href="<?php echo $changephoto; ?>">
                                   <img src="<?php echo base_url()."uploads/avatars/default_avatar.jpg" ?>" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                   <div class="changePic">
                                   <i class="uil uil-camera"></i> 
                                   </div>
                                   </a>  
                                   <?php } ?>
                                             <h6 class="text-primary" style="position: relative;top: -33px;" id="Toast"> Welcome </h6>
                                            <h5 class="font-size-15 mt-3" style="position: relative;top: -42px;margin: 0px;"><?php echo $sessiondata['username']; ?></h5>
                                        </div>
                                        <form id="AddResult">
            
                                            <div class="form-group">
                                                <label for="userpassword">Temperature (C°) :</label>
                                                <input type="number" class="form-control" placeholder="Enter password" min="36" value="37" max="41" name="Result">
                                            </div>
                                                  <div class="form-group mb-0">
                                                  <label> symptoms </label> 
                                             <div class="form-group">     
                                   <?php $symptoms = $this->db->query("SELECT * FROM r_symptoms ")->result_array(); ?>
                                             </div>                                                
                                                  </div>  
                                             
                                   <select name="symptoms" class="form-control" multiple searchable>
                                     <option value="">Select symptom</option>
                                        <?php foreach($symptoms as $selected){ ?>
                                     <option value="<?php echo $selected['code']; ?>"><?php echo $selected['symptoms_EN']; ?></option> 
                                        <?php } ?>
                                        <?php if(isset($Student)){ ?>     
                                        <input type="hidden" value="<?php echo $userId ?>" name="Stud_Id">     
                                        <?php } ?>
                                             </select>
                                            <div class="mt-3 text-right">
                                                <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit" id="staffsub">Submit</button>
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
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.amsifyselect.js"></script>

     
<script>
  /*   
$('.avatar-lg').mouseenter(function(){
   $('.changePic').addClass('transform');
});   
$('.avatar-lg').mouseout(function(){
   $('.changePic').removeClass('transform');
}); 
  
$(document).ready(function() {
    var interval = 100;

    $('.form-group').each(function () {
        var self = this;
        setTimeout(function() {
            $(self).addClass('rot');
        }, interval);

        interval += 200;
    });

  });   */  
     
$('select').amsifySelect({
  type : 'amsify'
}); 
var valSelect;     
var Templatur;     
     
$('select[name="symptoms"]').change(function(){
valSelect = $('select[name="symptoms"]').val();
console.log(valSelect);    
});  
 
$('select[name="symptoms"]').on('keydown,keypress,keyup',function(){
Templatur = $('select[name="Result"]').val();
console.log(Templatur);    
});
<?php if(isset($Student)){ ?>     
$( "#AddResult" ).on( 'submit', function ( e ) {
     var Templatur = $('input[name="Result"]').val();
     var Stud_Id = $('input[name="Stud_Id"]').val();
     console.log(Templatur);    
     e.preventDefault();
     $.ajax( {
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Results/StartAddResultsForstudent',
          data: {
            symptoms : valSelect,  
            Temp : Templatur,  
            Stud_Id : Stud_Id,  
          },
          success: function ( data ) {
               $( '#Toast' ).html( data );
               $( '#staffsub' ).removeAttr('disabled');
               $( '#staffsub' ).html('Submit !');
          },
          beforeSend : function(){
               $( '#staffsub' ).attr('disabled','');
               $( '#staffsub' ).html('Please wait.');
          },
          ajaxError: function () {
               $( '.alert.alert-info' ).css( 'background-color', '#DB0404' );
               $( '.alert.alert-info' ).html( "Ooops! Error was found." );
          }
     } );
} );
<?php }else{ ?>
$( "#AddResult" ).on( 'submit', function ( e ) {
     var Templatur = $('input[name="Result"]').val();
     console.log(Templatur);    
     e.preventDefault();
     $.ajax( {
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Results/StartAddResults',
          data: {
            symptoms : valSelect,  
            Temp : Templatur,  
          },
          success: function ( data ) {
               $( '#Toast' ).html( data );
               $( '#staffsub' ).removeAttr('disabled');
               $( '#staffsub' ).html('Submit !');
          },
          beforeSend : function(){
               $( '#staffsub' ).attr('disabled','');
               $( '#staffsub' ).html('Please wait.');
          },
          ajaxError: function () {
               $( '.alert.alert-info' ).css( 'background-color', '#DB0404' );
               $( '.alert.alert-info' ).html( "Ooops! Error was found." );
          }
     } );
} );
<?php } ?>     
</script>
    </body>
