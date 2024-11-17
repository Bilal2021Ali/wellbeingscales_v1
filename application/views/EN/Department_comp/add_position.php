<!doctype html>
<html>
<head>
     <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
</head>
<?php
 
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}


$rand = rand(300,999);	
	
//$code =  substr(md5(time()), 0, 4).'-'.$rand;     
$code =  generate_string($permitted_chars, 5).'-'.$rand;     
	
?>	
	

<body>
<div class="main-content">
  <div class="page-content">
    <h4 class="card-title" style="background: #07BFF3;padding: 10px;color: #1E1E1E;border-radius: 4px;">
						           Add and Define Users in <?php echo $sessiondata['f_name'] ?>
							</h4>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body" class="needs-validation InputForm col-md-12" novalidate="">
          <form id="addPosition">
              <div class="col-lg-12">
				  <div class="row">
					 <div class="col-lg-6">
						<div class="form-group">
						  <label for="validationCustom01">User type in English</label>
						  <input type="text" class="form-control" id="validationCustom01" 
						  placeholder=" User type in English " name="UserType_En" required="">
						  <div class="valid-feedback">look good</div>
						</div>
					  </div>	
					 <div class="col-lg-6">
						<div class="form-group">
						  <label for="validationCustom02">User type in Arabic </label>
						  <input type="text" class="form-control" id="validationCustom01" 
						  placeholder="User type in Arabic" name="UserType_Ar" >
						  <div class="valid-feedback">look good</div>
						</div>
				  </div>
				  </div>	
                <div style="margin-top: 10px;">
                  <button class="btn btn-primary" id="Teachersub" type="Submit">Add</button>
                  <button type="button" class="btn btn-light" id="back">Cancel</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
		<div id="StatusBox"></div>
  </div>
</div>
</div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script>
$("#addPosition").on('submit', function (e) {
     e.preventDefault();
	 var UserType_En =  $('input[name="UserType_En"]').val();
	 var UserType_Ar =  $('input[name="UserType_Ar"]').val();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Company_Departments/startAddNewPosition',
          data: {
			  UserType_Ar : UserType_Ar,
			  UserType_En : UserType_En,
			  code : '<?php echo $code; ?>',
		  },
          success: function (data) {
               $('#StatusBox').html(data);
          },
          ajaxError: function(){
               $('#StatusBox').css('background-color','#B40000');
               $('#StatusBox').html("Ooops! Error was found.");
          }
     });
});
</script>	
</html>