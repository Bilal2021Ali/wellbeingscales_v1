<?php    

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


class Results_company extends CI_Controller {
   
  function __construct()
    {
       parent::__construct();
       $this->load->library( 'session' );
	   $this->config->set_item('language', 'arabic');
       $sessiondata = $this->session->userdata('admin_details');
       if(!isset($sessiondata)){
          redirect('AR/users');
          exit();
       }
     }  
     
     public function index(){
          $sessiondata = $this->session->userdata('admin_details');
          $data['sessiondata'] = $sessiondata;
          $data['page_title'] = " Qlick Health | Enter Result ";
          $data['hasntnav'] = true;
          $dashlink = ""; 
          if($this->uri->segment(3) && $this->uri->segment(3) == "Student" && $this->uri->segment(4) ){
              $data['userId'] = $this->uri->segment(4);
              $data['Type'] = "Student";
              $data['Student'] = "Student";
          }else{
              if(isset($sessiondata['admin_id']) && isset($sessiondata['type']) ){
              $data['userId'] = $sessiondata['admin_id'];
              $data['Type'] = $sessiondata['type'];
              }else{
                   redirect("Users");
              }     
          }
          
          if($sessiondata['level'] == 2 || $sessiondata['level'] == 3){
          if($sessiondata['type'] = 'Ministry' || $sessiondata['type'] = 'Company' ){
               $dashlink = base_url()."AR/DashboardSystem";
          }else if($sessiondata['type'] = 'Patient' ){
               $dashlink = base_url()."AR/Departments_Permition";
          }else if($sessiondata['type'] = 'Satff' || $sessiondata['type'] = 'Teacher'  ){
               $dashlink = base_url()."AR/School_Permition";
          }else{
               $dashlink = base_url();
          }    
          $data['dashlink'] = $dashlink;
          $this->load->view("inc/header",$data);
          $this->load->view("addResult");
          $this->load->view("inc/footer");
          }else{
          $this->load->view("Global/YouCantEnter");
          }
     }
     
     public function Select_Child(){
          $sessiondata = $this->session->userdata('admin_details');
          $data['sessiondata'] = $sessiondata;
          $data['page_title'] = " Qlick Health | Enter Result ";
          $data['hasntnav'] = true;
          if($sessiondata['level'] == 2 && $sessiondata['type'] == "Parent"){
          $this->load->view("inc/header",$data);
          $this->load->view("Parent/Select_Child");
          $this->load->view("inc/footer");
          }
     }
     
     
     public function StartAddResults(){
          $sessiondata = $this->session->userdata('admin_details');
          $symptoms = $this->input->post("symptoms");
          $Templatur = $this->input->post("Temp");
          $time_HS = date('H:i:s');
          if(is_array($symptoms)){
          $symptomsVal = "";
          foreach($symptoms as $symptom){
              $symptomsVal .= $symptom.";";
          }
          }else{
            $symptomsVal = $symptoms;
          }
          $User_Id = $sessiondata['admin_id'];
          $type = $sessiondata['type'];
          $today =  date("Y-m-d");
          $time =  date("Y-m-d");
          if($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Symptoms`, `Created`,`Time`) VALUES ('".$User_Id."', '".$type."', '".$Templatur."', '".$symptomsVal."', '".date('Y-m-d')."','".$time_HS."');")){ ?>
          <script>
         Swal.fire({
             title: 'Success!',
             text:  ' Successfuly Inserted !! ',
             icon: 'success',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500);    
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
          
     }
     
     
     public function StartAddResultsForstudent(){
          $sessiondata = $this->session->userdata('admin_details');
          $symptoms = $this->input->post("symptoms");
          $Templatur = $this->input->post("Temp");
          $time_HS = date('H:i:s');
          if(is_array($symptoms)){
          $symptomsVal = "";
          foreach($symptoms as $symptom){
              $symptomsVal .= $symptom.";";
          }
          }else{
            $symptomsVal = $symptoms;
          }
          $User_Id = $this->input->post("Stud_Id");
          $type = "Student";
          print_r($sessiondata);
          $today =  date("Y-m-d");
          if($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Added_By`, `Result`, `Symptoms`, `Created`, `Time`) VALUES ('".$User_Id."', '".$type."','".$sessiondata['username']."' , '".$Templatur."', 
          '".$symptomsVal."', '".date('Y-m-d')."','".$time_HS."');")){ ?>
          <script>
         Swal.fire({
             title: 'Success!',
             text:  ' Successfuly Inserted !! ',
             icon: 'success',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500);    
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
          
     }
     
     
     public function AddResultForStaff(){
          $id = $this->input->post("UserId");
          $testtype = $this->input->post("Test_type");
          $Templatur = $this->input->post("Temp");
          $time_HS = date('H:i:s');
          if($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Device_Test` ,`Created`,`Time`) 
          VALUES ( '".$id."', 'Staff' , '".$Templatur."', '".$testtype."' ,'".date('Y-m-d')."','".$time_HS."');")){
		  //$this->db2_first_action($id,'Staff');
		  ?>
          <script>
          $("#TrStafffId<?php echo $id; ?>").addClass("AddedSuccess");
          $("#TrStafffId<?php echo $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function(){
          $("#TrStafffId<?php echo $id; ?>").slideUp();
          },1000);     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
     }
     
/*public function db2_first_action(){
		  $this->load->model('Test_db2');	   
		  $this->Test_db2->sync_two_databases();	   
}*/      
	
     public function AddCovidResult(){
          $id = $this->input->post("UserId");
          $Usertype = $this->input->post("Test_type");
          $Templatur = $this->input->post("Temp");
          $Device_Id = $this->input->post("Device");
          $Device_batch = $this->input->post("Batch");
          $test = $this->input->post("Test");
          //$Test_Description = $Device_array['2'];

          //print_r($Device_array);
          $time_HS = date('H:i:s');
          if(!empty($Device_Id)){
          if($this->db->query("INSERT INTO `l2_labtests` (`UserId`, `UserType`, `Result`, `Device_Test` , 
		  `Device_Batch` , `Test_Description` ,`Created`,`Time`) 
          VALUES ( '".$id."', '".$Usertype."' , '".$Templatur."' , '".$Device_Id."' , '".$Device_batch."' , 
		  '".$test."' ,'".date('Y-m-d')."','".$time_HS."');")){ ?>
          <script>
          $("#<?php echo $Usertype.'_'.$id; ?>").addClass("AddedSuccess");
          $("#<?php echo $Usertype.'_'.$id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function(){
          $("#<?php echo $Usertype.'_'.$id; ?>").slideUp();
          },1000);     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
          }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php 
          }
     }
	
     public function AddCovidResult_Co(){
          $id = $this->input->post("UserId");
          $Usertype = $this->input->post("Test_type");
          $Templatur = $this->input->post("Temp");
          $Device_Id = $this->input->post("Device");
          $Device_batch = $this->input->post("Batch");
          $test = $this->input->post("Test");
          //$Test_Description = $Device_array['2'];
          //print_r($Device_array);

          $time_HS = date('H:i:s');
          if(!empty($Device_Id)){
          if($this->db->query("INSERT INTO `l2_co_labtests` (`UserId`, `UserType`, `Result`, `Device_Test` , 
		  `Device_Batch` , `Test_Description` ,`Created`,`Time`) 
          VALUES ( '".$id."', '".$Usertype."' , '".$Templatur."' , '".$Device_Id."' , '".$Device_batch."' , 
		  '".$test."' ,'".date('Y-m-d')."','".$time_HS."');")){ ?>
          <script>
          $("#<?php echo $Usertype.'_'.$id; ?>").addClass("AddedSuccess");
          $("#<?php echo $Usertype.'_'.$id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function(){
          $("#<?php echo $Usertype.'_'.$id; ?>").slideUp();
          },1000);     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
          }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php 
          }
     }
       
     
     public function AddResultForTeacher(){
          $id = $this->input->post("UserId");
          $Templatur = $this->input->post("Temp");
          $time_HS = date('H:i:s');
          $dev_type = $this->input->post("Test_type");
          if($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Device_Test` , `Created`,`Time`) 
          VALUES ( '".$id."', 'Teacher' , '".$Templatur."', '".$dev_type."' ,'".date('Y-m-d')."','".$time_HS."');")){ ?>
          <script>
          $("#TrTeacherId<?php echo $id; ?>").addClass("AddedSuccess");
          $("#TrTeacherId<?php echo $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function(){
          $("#TrTeacherId<?php echo $id; ?>").slideUp();
          },1000);     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
     }
     
     public function AddResultForStudent(){
          $id = $this->input->post("UserId");
          $Templatur = $this->input->post("Temp");
          $DevType = $this->input->post("ST_Type");
          $time_HS = date('H:i:s');
          if($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Device_Test`,`Created`,`Time`) 
          VALUES ( '".$id."', 'Student' , '".$Templatur."', '".$DevType."' ,'".date('Y-m-d')."','".$time_HS."');")){ ?>
          <script>
          $("#TrStudId<?php echo $id; ?>").addClass("AddedSuccess");
          $("#TrStudId<?php echo $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
          setTimeout(function(){
          $("#TrStudId<?php echo $id; ?>").slideUp();
          },1000);     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
     }
     
     public function AddResultForPatients(){
          if($this->input->post("UserId") && $this->input->post("Temp") && $this->input->post("prefix")){
          $id = $this->input->post("UserId");
          $Templatur = $this->input->post("Temp");
          $prefx = $this->input->post("prefix");
          $time = date('H:i:s');
          if($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Created`,`Time`) 
          VALUES ( '".$id."', '".$prefx."' , '".$Templatur."', '".date('Y-m-d')."','".$time."');")){ ?>
          <script>
        Swal.fire({
             title: 'Success!',
             text:  ' Successfuly Inserted !! ',
             icon: 'success',
             confirmButtonColor: '#5b8ce8',
             timer: 1000,
          });

          $('#TrId<?php echo $id; ?>').remove();     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
          }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Kindly enter data.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
<?php    }
     }
     public function AddResultForCoPatients(){
          if($this->input->post("UserId") && $this->input->post("Temp") && $this->input->post("prefix")){
          $id = $this->input->post("UserId");
          $Templatur = $this->input->post("Temp");
          $prefx = $this->input->post("prefix");
          $time = date('H:i:s');
          if($this->db->query("INSERT INTO `l2_co_gateway_result` (`UserId`, `UserType`, `Result`, `Created`,`Time`) 
          VALUES ( '".$id."', '".$prefx."' , '".$Templatur."', '".date('Y-m-d')."','".$time."');")){ ?>
          <script>
          $('#TrId<?php echo $id; ?>').remove();     
          </script>     
          <?php }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Ooops! An error was encountered.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
          <?php }
          }else{ ?>
          <script>
          Swal.fire({
             title: 'Error!',
             text: 'Kindly enter data.',
             icon: 'error',
             confirmButtonColor: '#5b8ce8',
          });
          setTimeout(function(){
             location.reload();  
          },1500); 
          </script>  
<?php    }
     }
     
     public function SelectByPrefix(){
          if($this->input->post("Pref")){
          $sessiondata = $this->session->userdata('admin_details');
          $pef = $this->input->post("Pref"); 
          $Added_By = $sessiondata['admin_id'];     
          $list = $this->db->query("SELECT * FROM `l2_patient` WHERE `UserType` = '".$pef."'
          AND Added_By = '".$Added_By."' ")->result_array();
          if(empty($list)){ ?>
          <div class="card-body">
             <div class="card-title text-center">عذرا ، لم يتم العثور على بيانات.</div>
           </div>
          <?php }else{ ?>
          <div class="card-body">
               <div class="card-title text-center">The List Of "<?php echo $pef; ?>" :
                    <hr>
               </div>
               <table class="table">
                    <thead>
                         <tr>
                              <th> # </th>
                              <th> Name </th>
                              <th> National ID </th>
                              <th> Enter </th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php foreach($list as $admin){ ?>
                         <tr id="TrId<?php echo $admin['Id']; ?>">
                              <th scope="row">
                                   <?php echo $admin['Id'];?>
                              </th>
                              <td>
                              <?php echo $admin['F_name_EN'].' '.$admin['M_name_EN'].' '.$admin['L_name_EN'];?>
                              </td>
                              <td><?php echo $admin['National_Id'];?></td>
                              <td>
                              <form class="AddResultPatient">   
                              <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37" >   
                              <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId" >
                              <input type="hidden" value="<?php echo $pef; ?>" name="prefix" >
                              </form>     
                              </td>
                         </tr>
                         <?php  } ?>
                    </tbody>
               </table>
               <script>
               $(".AddResultPatient").on('focusout', function (e) {
               e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Results/AddResultForPatients',
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
          </div>
          <?php }      
          }
     }
	
     public function SelectByPrefix_co(){
          if($this->input->post("Pref")){
          $sessiondata = $this->session->userdata('admin_details');
          $pef = $this->input->post("Pref"); 
          $Added_By = $sessiondata['admin_id'];     
          $list = $this->db->query("SELECT * FROM `l2_co_patient` WHERE `UserType` = '".$pef."'
          AND Added_By = '".$Added_By."' ")->result_array();
          if(empty($list)){ ?>
          <div class="card-body">
             <div class="card-title text-center">عذرا ، لم يتم العثور على بيانات.</div>
           </div>
          <?php }else{ ?>
          <div class="card-body">
               <div class="card-title text-center">The List Of "<?php echo $pef; ?>" :
                    <hr>
               </div>
               <table class="table">
                    <thead>
                         <tr>
                              <th> # </th>
                              <th> Name </th>
                              <th> National ID </th>
                              <th> Enter </th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php foreach($list as $admin){ ?>
                         <tr id="TrId<?php echo $admin['Id']; ?>">
                              <th scope="row">
                                   <?php echo $admin['Id'];?>
                              </th>
                              <td>
                              <?php echo $admin['F_name_EN'].' '.$admin['M_name_EN'].' '.$admin['L_name_EN'];?>
                              </td>
                              <td><?php echo $admin['National_Id'];?></td>
                              <td>
                              <form class="AddResultPatient">   
                              <input type="number" class="form-control form-control-sm" placeholder="Enter Data Here " name="Temp" value="37" >   
                              <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId" >
                              <input type="hidden" value="<?php echo $pef; ?>" name="prefix" >
                              </form>     
                              </td>
                         </tr>
                         <?php  } ?>
                    </tbody>
               </table>
               <script>
               $(".AddResultPatient").on('focusout', function (e) {
               e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>AR/Results/AddResultForCoPatients',
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
          </div>
          <?php }      
          }
     }
     

      public function Batch_Counter()
      {
          $devicedata = $this->input->post("Device");
          $Device_array = explode('@',$devicedata);
          $Device_batch = $Device_array['1'];
          $count = $this->db->query("SELECT * FROM `l2_labtests` WHERE Device_Batch = '".$Device_batch."' ")->num_rows();
          echo $count;
      }


      public function GetResultsCounterFor()
      {
       $type = $this->input->post('TeatsType');
       ?>
           <div class="col-xl-12">
           <div class="card-body" style="border-radius: 5px;border: 3px solid #0eacd8;padding: 9px;">
           <h4 class="card-title"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Lab_Counter.png" style="width: 25px;margin: auto 5px;"> <?php echo $type; ?></h4>
           </div>
           </div>
           <div class="col-md-4 col-xl-4 text-center">
                                <div class="card notStatic">
                              <div class="card-body" style="padding: 5px;">
                                    <div class="card-body badge-soft-danger" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #f57d6a;">
                                        <div>
                                             <div class="row">
										<div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
												<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/positive.png" alt="Temperature" style="width: 70px;margin-top: 5px;">
										</div>                                       
										<div class="col-xl-8">
                                            <p class="mb-0 badge badge-danger font-size-12" style="width: 103px;">إيجابي (+)</p>
                                            <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;"> الحجر المنزلي <?php echo $this->GetTotal('1',$type,'Home') ?></span>
                                            <span class="badge font-size-12" style="width: 104px;background-color: #ff0000;color: #fff;margin: 5px auto;display: block;"> الحج الصحي <?php echo $this->GetTotal('1',$type,'Quarantine') ?></span>
                                            <span class="badge font-size-12" style="width: 104px;background-color: #34c38f;color: #fff;margin: 5px auto;display: block;"> بدون إجرائات <?php echo $this->GetTotal('1',$type,'School') ?></span>
                                        </div>
                                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                        <h4 class="mb-1 mt-1">
                                             <span data-plugin="counterup"><?php echo $this->GetTotal('1',$type) ?></span>
                                             </h4>
                                        </div>
                                        </div>
										</div>
                                    </div>
                                </div>
                                </div>
                            </div>  

                            <div class="col-md-4 col-xl-4 text-center">
                                <div class="card notStatic">
                              <div class="card-body" style="padding: 5px;box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);">
                                    <div class="card-body badge-soft-success" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #34ccc7;">
                                        <div>
                                             <div class="row">
										<div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
												<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/negative.png" alt="Temperature" style="width: 70px;margin-top: 5px;">
										</div>                                       
                                         <div class="col-xl-8">
                                            <p class="mb-0 badge badge-success font-size-12" style="width: 103px;">سلبي (-)</p>
										<span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;"> الحجر المنزلي <?php echo $this->GetTotal('0',$type,'Home') ?></span>
										<span class="badge font-size-12" style="width: 104px;background-color: #ff0000;color: #fff;margin: 5px auto;display: block;"> الحجر الصحي <?php echo $this->GetTotal('0',$type,'Quarantine') ?></span>
										<span class="badge font-size-12" style="width: 104px;background-color: #34c38f;color: #fff;margin: 5px auto;display: block;"> بدون إجرائات <?php echo $this->GetTotal('0',$type,'School') ?></span>
                                        </div>
                                        <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                        <h4 class="mb-1 mt-1">
                                             <span data-plugin="counterup"><?php echo $this->GetTotal('0',$type) ?></span>
                                             </h4>
                                        </div>
                                        </div></div>
                                    </div>
                                </div>
                                </div>
                            </div>           
                            <div class="col-md-4 col-xl-4 text-center">
                              <div class="card notStatic">
                              <div class="card-body" style="padding: 5px">
                                   <div class="card-body badge-soft-info" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #50a5f1;">
									   <div class="row">
										<div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
												<img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pandemic-128.png" alt="Temperature" style="width: 50px;margin-top: 5px;">
										</div>                                       
                                        <div class="col-xl-8">
                                        <h4 class="mb-1 mt-1">
                                             <span data-plugin="counterup"><?php echo $this->GetTotal_Not($type); ?></span>
                                             </h4>
                                             <p class="mb-0 badge badge-info font-size-12"  style="width: 103px;">بدون فحوصات</p>
                                        </div>
									   </div>
                                    </div>
                              </div>
                              </div>
                            </div>  
                                     
           <?php
           //print_r($this->input->post());
      }
     

    
     private function GetTotal($where,$type,$action = "")
     {
     $counter = 0;     
     //$this->load->library( 'session' ); 
     $sessiondata = $this->session->userdata('admin_details');
     $today = date("Y-m-d");
     $list = array();
          
     $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '".$sessiondata['admin_id']."' ")->result_array(); 
     foreach($Ourstaffs as $staff){
     $staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
     $ID = $staff['Id'];  
     $u_type = $staff['UserType'];
     if(!empty($action)){
	 //AND `Result` = '".$where."'
     $getResults = $this->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '".$staff['Id']."'
     AND Created = '".$today."' AND UserType = '".$u_type."' AND `Test_Description` = '".$type."'
	 AND `Action` = '".$action."' ORDER BY `Id` DESC LIMIT 1")->result_array(); 
     }else{
     $getResults = $this->db->query("SELECT * FROM l2_co_labtests WHERE `UserId` = '".$staff['Id']."'
     AND Created = '".$today."' AND UserType = '".$u_type."' AND `Test_Description` = '".$type."' 
	 ORDER BY `Id` DESC LIMIT 1")->result_array(); 
     }  

     foreach($getResults as $results){
		 if($results['Result'] == $where){
     		$counter ++;     
		 }
     } 
     }

     return($counter);
     }  
       
	
     private function GetTotal_Not($type,$action = "")
     {
     $counter = 0;     
     //$this->load->library( 'session' ); 
     $sessiondata = $this->session->userdata('admin_details');
     $today = date("Y-m-d");
     $list = array();
          
     $Ourstaffs = $this->db->query("SELECT * FROM l2_co_patient WHERE `Added_By` = '".$sessiondata['admin_id']."' ")->result_array(); 
     foreach($Ourstaffs as $staff){
     $staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
     $ID = $staff['Id'];  
     $u_type = $staff['UserType'];
		 
     if(!empty($action)){
     $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '".$staff['Id']."'
     AND Created = '".$today."' AND UserType = '".$u_type."' AND
	 `Test_Description` = '".$type."'  ORDER BY `Id` DESC LIMIT 1")->result_array(); 
     }else{
     $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '".$staff['Id']."'
     AND Created = '".$today."' AND UserType = 'Staff' AND `Test_Description` = '".$type."' ORDER BY `Id` DESC LIMIT 1")->result_array(); 
     }  
     if(empty($getResults)){
          $counter ++;     
     }  
     
     }

     return($counter);
     }  

						
private function data_of_dept_co($sessiondata,$device){
$ci =& get_instance();
$list = array();
$today = date("Y-m-d");

$Ourstaffs = $ci->db->query("SELECT * FROM l2_co_patient 
WHERE `Added_By` = '".$sessiondata['admin_id']."' ")->result_array(); 
	
foreach($Ourstaffs as $staff){
$staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
$ID = $staff['Id'];
$Position_Staff = $staff['Position']; 
$type = $staff['UserType'];
	
$lastresult = $ci->db->query(" SELECT * FROM l2_co_result  WHERE `UserId` = '".$staff['Id']."'
AND Created = '".$today."' AND UserType = '".$type."' AND `Device` = '".$device."' ORDER BY `Id` DESC LIMIT 1 ")->result_array(); 
$first_result = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '".$staff['Id']."'
AND Created = '".$today."' AND UserType = '".$type."' AND `Device` = '".$device."' ORDER BY `Id` ASC LIMIT 1 ")->result_array(); 

	
if(!empty($lastresult) && !empty($first_result) ){
$list[] = array( "Username" => $staffname, "Id" => $ID , "LastResult"=> $lastresult[0]['Result'], "FirstResult" => $first_result[0]['Result'],
'position' => $Position_Staff ,"first_result_Creat" => $first_result[0]['Created'] , "first_result_time" => $first_result[0]['Time'] , 
"last_result_Creat" => $lastresult[0]['Created'] , "last_result_time" => $lastresult[0]['Time'] );     
}	
	
}
	
return($list);
	
}
	
	
private function data_of_user($type,$sessiondata,$device){
$ci =& get_instance();
$list = array();
$today = date("Y-m-d");
	
if($type == "Staff"){
$Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE
`Added_By` = '".$sessiondata['admin_id']."' ")->result_array(); 
}elseif($type == "Teacher"){
$Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
`Added_By` = '".$sessiondata['admin_id']."' ")->result_array(); 
}elseif($type == "Student"){
$Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
`Added_By` = '".$sessiondata['admin_id']."' ")->result_array(); 
}	
	
foreach($Ourstaffs as $staff){
$staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
$ID = $staff['Id'];
$Position_Staff = $staff['Position']; 
	
$lastresult = $ci->db->query(" SELECT * FROM l2_result WHERE `UserId` = '".$staff['Id']."'
AND Result_Date = '".$today."' AND UserType = '".$type."' AND `Device` = '".$device."' ORDER BY `Id` DESC LIMIT 1 ")->result_array(); 
$first_result = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '".$staff['Id']."'
AND Result_Date = '".$today."' AND UserType = '".$type."' AND `Device` = '".$device."' ORDER BY `Id` ASC LIMIT 1 ")->result_array(); 

	
 //foreach($getResults as $results){
//$creat = $results['Created'].' '.$results['Time'];
	
if(!empty($lastresult) && !empty($first_result) ){
$list[] = array("Username"=>$staffname, "Id" =>$ID , "LastResult"=>$lastresult[0]['Result'], "FirstResult" => $first_result[0]['Result'],
'position' => $Position_Staff ,"first_result_Creat" => $first_result[0]['Result_Date'] , "first_result_time" => $first_result[0]['Time'] , 
"last_result_Creat" => $lastresult[0]['Result_Date'] , "last_result_time" => $lastresult[0]['Time'] );     
}	
	
//} 
}
return($list);
}
	
private function data_of_user_by_id($type,$sessiondata,$id){
$ci =& get_instance();
$list = array();
$today = date("Y-m-d");
	
if($type == "Staff"){
$Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE
`Added_By` = '".$sessiondata['admin_id']."' AND `Id` = '".$id."' LIMIT 1 ")->result_array(); 
}elseif($type == "Teacher"){
$Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
`Added_By` = '".$sessiondata['admin_id']."' AND `Id` = '".$id."' LIMIT 1 ")->result_array(); 
}elseif($type == "Student"){
$Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
`Added_By` = '".$sessiondata['admin_id']."' AND `Id` = '".$id."' LIMIT 1 ")->result_array(); 
}	

	
foreach($Ourstaffs as $staff){
$staffname = $staff['F_name_EN'].' '.$staff['L_name_EN'];     
$ID = $staff['Id'];
$Position_Staff = $staff['Position']; 
	
$lastresult = $ci->db->query(" SELECT * FROM l2_result WHERE `UserId` = '".$staff['Id']."' 
AND Result_Date = '".$today."' AND UserType = '".$type."' AND `Device` != '' ORDER BY `Id` DESC ")->result_array(); 
$first_result = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '".$staff['Id']."'
AND Result_Date = '".$today."' AND UserType = '".$type."' AND `Device` != '' ORDER BY `Id` ASC  ")->result_array(); 

	
 //foreach($getResults as $results){
//$creat = $results['Created'].' '.$results['Time'];

$our_devices = $this->db->query(" SELECT * FROM `l2_devices` ")->result_array();	
	
if(!empty($lastresult) && !empty($first_result) ){
foreach($lastresult as $reslt){
$deviceData = $this->db->query(" SELECT * FROM `l2_devices` WHERE `D_Id` = '".$reslt['Device']."' ")->result_array();
	
$Device_desc = "";	
$Site = "";
	
if(!empty($deviceData)){
$Device_desc = $deviceData[0]['Description'];	
$Site = $deviceData[0]['Site'];	
}
	
$list[] = array("Username"=>$staffname, "Id" =>$ID , "LastResult"=>$reslt['Result'], "FirstResult" => $first_result[0]['Result'],
"position" => $Position_Staff ,"first_result_Creat" => $first_result[0]['Result_Date'] , "first_result_time" => $first_result[0]['Time'] , 
"last_result_Creat" => $reslt['Result_Date'] , "last_result_time" => $reslt['Time'] , "Device_desc" => $Device_desc ,
"Site" => $Site ); 
}	
/*
echo sizeof($lastresult);
	print_r($lastresult);
*/
}	
	
//} 
}
return($list);
}
	
private function data_of_user_by_id_for_co($type,$sessiondata,$id){
$ci =& get_instance();
$list = array();
$today = date("Y-m-d");
	
$Ourstaffs = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE
`Added_By` = '".$sessiondata['admin_id']."' AND `Id` = '".$id."' LIMIT 1 ")->result_array(); 
	
	
foreach($Ourstaffs as $staff){
$staffname = $staff['F_name_AR'].' '.$staff['L_name_AR'];     
$ID = $staff['Id'];
$Position_Staff = $staff['Position']; 
$userType = $staff['UserType']; 
	
$lastresult = $ci->db->query(" SELECT * FROM l2_co_result WHERE `UserId` = '".$staff['Id']."' 
AND Created = '".$today."' AND UserType = '".$type."' AND `Device` != '' ORDER BY `Id` DESC ")->result_array(); 
$first_result = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '".$staff['Id']."'
AND Created = '".$today."' AND UserType = '".$type."' AND `Device` != '' ORDER BY `Id` ASC  ")->result_array(); 

	
 //foreach($getResults as $results){
//$creat = $results['Created'].' '.$results['Time'];

$our_devices = $this->db->query(" SELECT * FROM `l2_co_devices` ")->result_array();	
	
if(!empty($lastresult) && !empty($first_result) ){
foreach($lastresult as $reslt){
$deviceData = $this->db->query(" SELECT * FROM `l2_co_devices` WHERE `D_Id` = '".$reslt['Device']."' ")->result_array();
	
$Device_desc = "";	
$Site = "";
	
if(!empty($deviceData)){
$Device_desc = $deviceData[0]['Description'];	
$Site = $deviceData[0]['Site'];	
}
	
$list[] = array("Username"=>$staffname, "Id" =>$ID , "LastResult"=>$reslt['Result'], "FirstResult" => $first_result[0]['Result'],
"position" => $Position_Staff ,"first_result_Creat" => $first_result[0]['Created'] , "first_result_time" => $first_result[0]['Time'] , 
"last_result_Creat" => $reslt['Created'] , "last_result_time" => $reslt['Time'] , "Device_desc" => $Device_desc ,
"Site" => $Site , "UserType" => $userType ); 
}	
/*
echo sizeof($lastresult);
	print_r($lastresult);
*/
}	
	
//} 
}
return($list);
}
	
private function symps($symps){
  $ci =& get_instance();
  $Symps_array = explode(';',$symps);
  $sz =  sizeof($Symps_array);	  
  //print_r($Symps_array);  
  if($sz > 1){
  foreach($Symps_array as $sympsArr){
	   //print_r($sympsArr);
	   //echo sizeof($Symps_array);
	   $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '".$sympsArr."'")->result_array();
	   foreach($SempName as $name){
	   echo $name['symptoms_EN'].",";
	   }
  } 
  }else{
	  echo "لا يوجد أعراض ";
  }
	  
  }

public function boxes_Colors($result,$risk = ""){
	?>
	 <style>
		 .Td-Results_font span{
			 font-size: 20px !important;
			 padding: 6px;
		 }
		 .Td-Results .badge{
			 padding: 6px;
		 }
	 </style>
	
	 <td class="Td-Results_font">
	 <?php if( $result >= 38.50 && $result <= 45.00){ ?>
	 <!-- Hight Bilal 26 Dec 2020 -->	 
	 <span class="badge" 
	 style="width: 100%;border-radius: 10px;color: #ff2e00;"> <?php echo $result; ?> </span>
	 <?php }elseif($result >= 37.60 && $result <= 38.40 ){ ?>
	 <!-- Moderate -->	 
	 <span class="badge"
	 style="width: 100%;border-radius: 10px;color : #ff8200;"> <?php echo $result; ?> </span>
	 <?php }elseif( $result >= 36.30 && $result <= 37.50 ){ ?>
	 <!-- No Risk -->	 
	 <span class="badge" 
	 style="width: 100%;border-radius: 10px;color : #00ab00;"> <?php echo $result; ?></span>
	 <?php }elseif($result <= 36.20){ ?>
	 <!-- Low -->	 
	 <span class="badge"
	 style="width: 100%;border-radius: 10px;color: #cdfc00;">  <?php echo $result; ?>  </span>
	 <?php }elseif($result > 45 ){ ?>
	 <!-- Error -->	 
	 <span class="badge" 
	 style="width: 100%;border-radius: 10px;color: #272727;"> <?php echo $result; ?> </span>
	 <?php } ?>	 
     </td>

	 <?php if(empty($risk)){ ?>
	 <td class="Td-Results">
     <?php if(  $result >= 38.50 && $result <= 45.00 ){ ?>
	 <span class="badge error" 
	 style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">عالي</span>
	 <!-- Hight Bilal 26 Dec 2020 -->	 
     <?php }elseif($result >= 37.60 && $result <= 38.40 ){ ?>
     <span class="badge"
	 style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">معتدل</span>
 	 <!-- Moderate -->	 
     <?php }elseif( $result >= 36.30 && $result <= 37.50 ){ ?>
     <span class="badge" 
	 style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">طبيعي</span>
     <?php }elseif( $result <= 36.20 ){ ?>
 	 <!-- Low -->	 
     <span class="badge"
	 style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">منخفض</span>
	 <?php }elseif($result > 45 ){ ?>
 	 <!-- Error -->	 
     <span class="badge" 
	 style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">قراءة خاطئة</span>
     <?php } ?>
	 </td>
	<?php  } ?>

	<?php
}	
	

public function getResultsbyDevice(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $this->load->library( 'form_validation' ); 
          $this->form_validation->set_rules( 'type', 'type', 'trim|required' );
          if ( $this->form_validation->run() ) {
		  $device = $this->input->post("type");
		  $Staff_list = $this->data_of_user("Staff",$sessiondata,$device);						
		  $Student_list = $this->data_of_user("Student",$sessiondata,$device);						
		  $Teacher_list = $this->data_of_user("Teacher",$sessiondata,$device);						

			?>
			<div class="container">
						
						<div class="control_results col-md-12" style="padding-bottom: 15px;">
								<button type="button" form_target="Staff_list_results" class="btn btn-primary w-md contr_btn">
									 <i class="uil uil-list"></i>Staff
								</button>

								<button type="button" form_target="Teachers_list_results" class="btn w-md contr_btn">
									 <i class="uil uil-list"></i>Teacher
								</button>
								<button type="button" form_target="Studnts_list_results" class="btn w-md contr_btn">
									 <i class="uil uil-list"></i>Student
								</button>
                        </div>
						<!-- end control -->
						
						<div class="row formcontainer_results" id="Staff_list_results">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"> Staff </h4>
                                         <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
										 style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
												<?php $title_in = "Time in" ?>
												<?php $title_out = "Time out" ?>
                                            <tr>
											   <th> Img </th>
											   <th> Name </th>
											   <th> First Result </th>
											   <th> Last Result </th>
											   <th> <?php echo $title_in; ?> </th>
											   <th> <?php echo $title_out ?> </th>
											   <th> Total </th>
                                            </tr>
                                            </thead>
											
											 <tbody>
										<?php foreach($Staff_list as $staffsRes){ ?>

										<tr>
											 <td style="width: 20px;">
											 <?php 
											 $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '".$staffsRes['Id']."' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
											 ?>
											 <?php if(empty($avatar)){  ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
											 <?php }else{ ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
											 <?php } ?>
											 </td>
											 <td>
												 <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
												 <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> 
													 <?php echo $staffsRes['position']; ?></p>
											 </td>
											<?php $this->boxes_Colors($staffsRes['FirstResult'],"Show"); ?>
											<?php $this->boxes_Colors($staffsRes['LastResult'],"Show"); ?>
											<td><?php echo $staffsRes['first_result_time'] ?></td>
											<td><?php echo $staffsRes['last_result_time'] ?></td>
											<td>
											<?php 
											  $this->between($staffsRes['first_result_time'],$staffsRes['last_result_time']);
											?>
											</td>
										 </tr>          
										<?php } ?>
										</tbody>
        
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
						<!-- end row -->
						
                        <div class="row formcontainer_results" id="Studnts_list_results">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title"> Students </h4>
										<div class="students_button"></div>
                                         <table id="Students_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
      									   <thead>
                                            <tr>
											   <th> Img </th>
											   <th> Name </th>
											   <th> First Result </th>
											   <th> Last Result </th>
											   <th> <?php echo $title_in; ?> </th>
											   <th> <?php echo $title_out ?> </th>
											   <th> Total </th>
                                            </tr>
                                            </thead>											
											 <tbody>
										<?php foreach($Student_list as $studentResults){ ?>

										<tr>
											 <td style="width: 20px;">
											 <?php 
											 $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '".$studentResults['Id']."' AND
											 `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
											 ?>
											 <?php if(empty($avatar)){  ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" 
											 class="avatar-xs rounded-circle " alt="...">
											 <?php }else{ ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>"
											 class="avatar-xs rounded-circle " alt="...">
											 <?php } ?>
											 </td>
											 <td>
												 <h6 class="font-size-15 mb-1 font-weight-normal">
													 <?php echo $studentResults['Username']; ?></h6>
												 <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $studentResults['position']; ?></p>
											 </td>
											<?php $this->boxes_Colors($studentResults['FirstResult'],"Show"); ?>
											<?php $this->boxes_Colors($studentResults['LastResult'],"Show"); ?>
											<td><?php echo $studentResults['first_result_time'] ?></td>
											<td><?php echo $studentResults['last_result_time'] ?></td>
											<td>
											<?php 
										     $this->between($studentResults['first_result_time'],$studentResults['last_result_time']);
											?>
											</td>
										 </tr>          
										<?php } ?>
										</tbody>
        
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> 
						<!-- end row -->
						
                        <div class="row formcontainer_results" id="Teachers_list_results">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title"> Teachers </h4>
                                         <table id="Teacher_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										    <thead>
                                            <tr>
											   <th> Img </th>
											   <th> Name </th>
											   <th> First Result </th>
											   <th> Last Result </th>
											   <th> <?php echo $title_in; ?> </th>
											   <th> <?php echo $title_out ?> </th>
											   <th> Total </th>
                                            </tr>
                                            </thead>											


											
											 <tbody>
										<?php foreach($Teacher_list as $TeacherResults){ ?>

										<tr>
											 <td style="width: 20px;">
											 <?php 
											 $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '".$TeacherResults['Id']."' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
											 ?>
											 <?php if(empty($avatar)){  ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
											 <?php }else{ ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
											 <?php } ?>
											 </td>
											 <td>
												 <h6 class="font-size-15 mb-1 font-weight-normal">
													 <?php echo $TeacherResults['Username']; ?></h6>
												 <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $TeacherResults['position']; ?></p>
											 </td>
											<?php $this->boxes_Colors($TeacherResults['FirstResult'],"Show"); ?>
											<?php $this->boxes_Colors($TeacherResults['LastResult'],"Show"); ?>
											<td><?php echo $TeacherResults['first_result_time'] ?></td>
											<td><?php echo $TeacherResults['last_result_time'] ?></td>
											<td>
											<?php 
										     $this->between($TeacherResults['first_result_time'],$TeacherResults['last_result_time']);
											?>
											</td>
										 </tr>          
										<?php } ?>
										</tbody>
        
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> 
						<!-- end row -->
						</div>
<script>
  $('#Teachers_list_results').hide();
  $('#Studnts_list_results').hide();

  $( '#Staff_list_results' ).show();
	
  $( '.control_results button' ).click( function () {
	   $( '.control_results button' ).removeClass( 'btn-primary' );
	   $( this ).addClass( 'btn-primary' );
	   $( '.formcontainer_results' ).hide();
	   var to = $( this ).attr( 'form_target' );
	   $( '#' + to ).show();
  } );
	

</script>
			<?php
		  }else{
			?>
		   <script>
           Swal.fire({
			   title: ' Sorry.',
			   text: 'Error was found. Please try again later.',
			   icon: 'error'
		   });
           </script>
		  <?php
		  }
	}
	
	
public function getResultsbyDevice_co(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $this->load->library( 'form_validation' ); 
          $this->form_validation->set_rules( 'type', 'type', 'trim|required' );
          if ( $this->form_validation->run() ) {
		  $device = $this->input->post("type");
		  $Staff_list = $this->data_of_dept_co($sessiondata,$device);						
		  ?>
			<div class="container">
						<div class="row formcontainer_results" id="Staff_list_results">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"> Results </h4>
                                         <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
										 style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
												<?php $title_in = "وقت الدخول" ?>
												<?php $title_out = "وقت الخروج" ?>
                                            <tr>
											   <th> الصورة </th>
											   <th> الإسم </th>
											   <th> أول نتيجة </th>
											   <th> أخر نتيجة </th>
											   <th> <?php echo $title_in; ?> </th>
											   <th> <?php echo $title_out ?> </th>
											   <th> المجموع </th>
                                            </tr>
                                            </thead>
											
											 <tbody>
										<?php foreach($Staff_list as $staffsRes){ ?>

										<tr>
											 <td style="width: 20px;">
											 <?php 
											 $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
											 WHERE `For_User` = '".$staffsRes['Id']."' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
											 ?>
											 <?php if(empty($avatar)){  ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
											 <?php }else{ ?>
											 <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
											 <?php } ?>
											 </td>
											 <td>
												 <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
												 <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> 
													 <?php echo $staffsRes['position']; ?></p>
											 </td>
											<?php $this->boxes_Colors($staffsRes['FirstResult'],"Show"); ?>
											<?php $this->boxes_Colors($staffsRes['LastResult'],"Show"); ?>
											<td><?php echo $staffsRes['first_result_time'] ?></td>
											<td><?php echo $staffsRes['last_result_time'] ?></td>
											<td>
											<?php 
											  $this->between($staffsRes['first_result_time'],$staffsRes['last_result_time']);
											?>
											</td>
										 </tr>          
										<?php } ?>
										</tbody>
        
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
						<!-- end row -->
						</div>
<script>
  $('#Teachers_list_results').hide();
  $('#Studnts_list_results').hide();

  $( '#Staff_list_results' ).show();
	
  $( '.control_results button' ).click( function () {
	   $( '.control_results button' ).removeClass( 'btn-primary' );
	   $( this ).addClass( 'btn-primary' );
	   $( '.formcontainer_results' ).hide();
	   var to = $( this ).attr( 'form_target' );
	   $( '#' + to ).show();
  } );
	

</script>
			<?php
		  }else{
			?>
		   <script>
           Swal.fire({
			   title: ' Sorry.',
			   text: 'Error was found. Please try again later.',
			   icon: 'error'
		   });
           </script>
		  <?php
		  }
	}
	
public function getResultsbyname(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $this->load->library( 'form_validation' ); 
          $this->form_validation->set_rules( 'name', 'name', 'trim|required' );
          if ( $this->form_validation->run() ) {
		  $name = $this->input->post("name");
		  $name_tree = explode(" ",$name);
		  if(sizeof($name_tree) >= 3 ){
		  $user_q = $this->db->query(" SELECT Id FROM `l2_staff` WHERE 
		  `F_name_EN` = '".$name_tree[0]."' AND `M_name_EN` = '".$name_tree[1]."'
		  AND `L_name_EN` = '".$name_tree[2]."' ")->result_array();	  
		  if(empty($user_q)){
		  $user_q = $this->db->query(" SELECT Id FROM `l2_teacher` WHERE 
		  `F_name_EN` = '".$name_tree[0]."' AND `M_name_EN` = '".$name_tree[1]."'
		  AND `L_name_EN` = '".$name_tree[2]."' ")->result_array();	
		  $usertype = "Teacher";	  
		  if(empty($user_q)){
		  $user_q = $this->db->query(" SELECT Id FROM `l2_student` WHERE 
		  `F_name_EN` = '".$name_tree[0]."' AND `M_name_EN` = '".$name_tree[1]."'
		  AND `L_name_EN` = '".$name_tree[2]."' ")->result_array();
		  $usertype = "Student";	  
		  }	  
		  }else{
		  $usertype = "Staff";	  
		  }  
		  }	  
		  	  
		  if(isset($usertype) && !empty($user_q) ){
		   $id = $user_q[0]['Id'];
		   $userdata = $this->data_of_user_by_id($usertype,$sessiondata,$id);
		  }	
			if(!empty($userdata)){  
		  ?>
			<div class="container">
						
						<!-- end control -->
						<div class="row formcontainer">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"> Data For : <?php echo $name; ?> </h4>
                                         <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
										 style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
											   <th> Img </th>
											   <th> Name </th>
											   <th> First Result </th>
											   <th> Last Result </th>
											   <th> Time in </th>
											   <th> Time out </th>
											   <th> Total </th>
											   <th> Site </th>
											   <th> Device Desc </th>
                                            </tr>
                                            </thead>
											
											 <tbody>
										<?php foreach($userdata as $staffsRes){ ?>

										<tr>
											 <td style="width: 20px;">
											 <?php 

			  								 $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '".$staffsRes['Id']."' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
											 ?>
											 <?php if(empty($avatar)){  ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
											 <?php }else{ ?>
											 <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
											 <?php } ?>
											 </td>
											 <td>
												 <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
												 <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> 
													 <?php echo $staffsRes['position']; ?></p>
											 </td>
											<?php $this->boxes_Colors($staffsRes['FirstResult'],"Show"); ?>
											<?php $this->boxes_Colors($staffsRes['LastResult'],"Show"); ?>
											<td><?php echo $staffsRes['first_result_time'] ?></td>
											<td><?php echo $staffsRes['last_result_time'] ?></td>
											<td>
											<?php 
												  $this->between($staffsRes['first_result_time'],$staffsRes['last_result_time']);
											?>
											</td>
											<td><?php echo $staffsRes['Site']; ?></td>
											<td><?php echo $staffsRes['Device_desc']; ?></td>
										 </tr>          
										<?php } ?>
										</tbody>
        
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
						<!-- end row -->
						</div> 
			<?php
			}else{ ?>
		   <script>
           Swal.fire({
			   title: ' Sorry.',
			   text: ' No data was found for this user. Please try again later. ',
			   icon: 'error'
		   });
           </script>
			<?php 
		  }
		  }else{
			?>
		   <script>
           Swal.fire({
			   title: ' Sorry.',
			   text: 'Error was found. Please try again later.',
			   icon: 'error'
		   });
           </script>
		  <?php
		  }
	}
	
public function getResultsbyname_co(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $this->load->library( 'form_validation' ); 
          $this->form_validation->set_rules( 'name', 'name', 'trim|required' );
          if ( $this->form_validation->run() ) {
		  $name = $this->input->post("name");
		  $name_tree = explode(" ",$name);
		  if(sizeof($name_tree) >= 3 ){
			  
		  $user_q = $this->db->query(" SELECT Id,UserType FROM `l2_co_patient` WHERE 
		  `F_name_AR` = '".$name_tree[0]."' AND `M_name_AR` = '".$name_tree[1]."'
		   AND `L_name_AR` = '".$name_tree[2]."' LIMIT 1 ")->result_array();	  
		   if(!empty($user_q)){
			   $usertype = $user_q[0]['UserType'];
		   }	  
			  
		  }	  
		  	  
		  if(isset($usertype) && !empty($user_q) ){
		   $id = $user_q[0]['Id'];
		  }	
		  ?>
			<div class="container">
						<?php 
						$today = date("Y-m-d");
						$userdata = $this->db->query("SELECT *,concat(F_name_AR,' ',l_name_AR) as Username,
						`l2_co_patient`.`Position` , `dev_first`.`Site` as DeviceFirst , 
						`dev_last`.`Site` as DeviceLast , `l1_co_department`.`Dept_Name_AR` as ParentName
						FROM `l2_co_attendance_result`
						JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `l2_co_attendance_result`.`UserType`
						JOIN `l2_co_devices` dev_first ON `dev_first`.`D_Id` = `l2_co_attendance_result`.`Device_first`
						JOIN `l2_co_devices` dev_last ON `dev_last`.`D_Id` = `l2_co_attendance_result`.`Device_last`
						JOIN `l1_co_department` ON `l2_co_patient`.`Added_By` = `l1_co_department`.`Id`
						WHERE `UserId` = '".$id."' AND `l2_co_patient`.`Id` = `l2_co_attendance_result`.`UserId` AND
						l2_co_attendance_result.UserType = '".$usertype."' 
						AND `l2_co_attendance_result`.`Created` = '".$today."' 
						ORDER BY `l2_co_attendance_result`.`TimeStamp` DESC ")->result_array();
						?>
						<!-- end control -->
						<!-- end control -->
				<?php if(!empty($userdata)){ ?>
						<div class="row formcontainer">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                     <h4 class="card-title"> معلومات : <?php echo $name; ?> <span class="float-right">
										 <?php echo $userdata[0]['ParentName'] ?>
										 </span> 
									 </h4>
                                         <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
										 style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
											   <th> الصورة </th>
											   <th> الإسم </th>
											   <th> النتيجة الأولى </th>
											   <th> وقت الدخول </th>
											   <th> الموقع </th>
											   <th> النتيجة الأخيرة </th>
											   <th> وقت الخروج </th>
											   <th> الموقع </th>
											   <th> المجموع </th>
                                            </tr>
                                            </thead>
											
											 <tbody>
										<?php
										foreach($userdata as $staffsRes){
										?>
										<tr>
										 <td style="width: 20px;">
										 <?php 

										 $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
										 WHERE `For_User` = '".$staffsRes['Id']."' AND 
										 `Type_Of_User` = '".$staffsRes['UserType']."' LIMIT 1 ")->result_array();
										 ?>
										 <?php if(empty($avatar)){  ?>
										 <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
										 <?php }else{ ?>
										 <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
										 <?php } ?>
										 </td>
										 <td>
											 <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
											 <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> 
												 <?php echo $staffsRes['Position']; ?></p>
										 </td>
										<?php $this->boxes_Colors($staffsRes['Result_first'],"Show"); ?>
										<td><?php echo $staffsRes['Time_first'] ?></td>
										<td><?php echo $staffsRes['DeviceFirst'] ?></td>
										<?php $this->boxes_Colors($staffsRes['Result_last'],"Show"); ?>
										<td><?php echo $staffsRes['Time_last'] ?></td>
										<td><?php echo $staffsRes['DeviceLast'] ?></td>
										<td>
										<?php 
										  $this->between($staffsRes['Time_first'],$staffsRes['Time_last']);
										?>
										</td>
										 </tr>          
										<?php } ?>
										</tbody>
        
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>	
				<?php }else{
				?>
		   <script>
           Swal.fire({
			   title: ' نعتذر ',
			   text: ' لم نستطع إيجاد أي معلومات لهذا المستخدم  ',
			   icon: 'error'
		   });
           </script>
				<?php 
						} ?>
				<!-- end row -->
						</div> 
			<?php
		  }else{
			?>
		   <script>
           Swal.fire({
			   title: ' نعتذر ',
			   text: 'لدينا خطأ يرجى المحاولة لاحقا',
			   icon: 'error'
		   });
           </script>
		  <?php
		  }
	}
 
private function between($f_result_date,$l_result_date){
// Declare and define two dates 
$date1 = strtotime($f_result_date); 
$date2 = strtotime($l_result_date); 

// Formulate the Difference between two dates 
$diff = abs($date2 - $date1); 


// To get the year divide the resultant date into 
// total seconds in a year (365*60*60*24) 
$years = floor($diff / (365*60*60*24)); 


// To get the month, subtract it with years and 
// divide the resultant date into 
// total seconds in a month (30*60*60*24) 
$months = floor(($diff - $years * 365*60*60*24) 
							/ (30*60*60*24)); 


// To get the day, subtract it with years and 
// months and divide the resultant date into 
// total seconds in a days (60*60*24) 
$days = floor(($diff - $years * 365*60*60*24 - 
			$months*30*60*60*24)/ (60*60*24)); 


// To get the hour, subtract it with years, 
// months & seconds and divide the resultant 
// date into total seconds in a hours (60*60) 
$hours = floor(($diff - $years * 365*60*60*24 
	- $months*30*60*60*24 - $days*60*60*24) 
								/ (60*60)); 


// To get the minutes, subtract it with years, 
// months, seconds and hours and divide the 
// resultant date into total seconds i.e. 60 
$minutes = floor(($diff - $years * 365*60*60*24 
		- $months*30*60*60*24 - $days*60*60*24 
						- $hours*60*60)/ 60); 


// To get the minutes, subtract it with years, 
// months, seconds, hours and minutes 
$seconds = floor(($diff - $years * 365*60*60*24 
		- $months*30*60*60*24 - $days*60*60*24 
				- $hours*60*60 - $minutes*60)); 

// Print the result 
/*if($hours !== 0){
	 //echo date("HH:", strtotime($hours));  
	 echo $hours." hour(s), ";
}
	
if($minutes !== 0){
	echo $minutes." second(s) ";
}*/

$alltime = $hours.':'.$minutes;	
	echo date("H:i", strtotime($alltime));
/*printf("%d years, %d months, %d days, %d hours, "
	. "%d minutes, %d seconds", $years, $months, 
			$days, $hours, $minutes, $seconds); */
 	
}
	
private function Get_Counter_of_Tests($id,$testname = "",$result = ""){
	$counter = 0;
	$today = date("Y-m-d");

	$query_users = $this->db->query(" SELECT * FROM `l2_co_patient` WHERE `Added_By` = '".$id."'  ")->result_array();

	if(!empty($testname)){
	if($result !== ""){
	foreach($query_users as $user){
		$type = $user['UserType'];
		$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
		`UserType` = '".$type."' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."' AND 
		`Test_Description` = '".$testname."' AND `Result` = '".$result."' ")->num_rows();
		 $counter += $Results;

	}
	}else{
	foreach($query_users as $user){
		$type = $user['UserType'];
		$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
		`UserType` = '".$type."' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."' AND 
		`Test_Description` = '".$testname."' ")->num_rows();
		 $counter += $Results;
	}
	}	
	}else{
	if($result !== ""){
	foreach($query_users as $user){
		$type = $user['UserType'];
		$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
		`UserType` = '".$type."' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."' AND `Result` = '".$result."' ")->num_rows();
		 $counter += $Results;

	}
	}else{
	foreach($query_users as $user){
		$type = $user['UserType'];
		$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
		`UserType` = '".$type."' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."' ")->num_rows();
		 $counter += $Results;
	}
	}	
}

	
	
	
return($counter);
}

public function getDataChartByTestName_Company(){
        $this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
		$testname = $this->input->post('testname');
		$idd = $sessiondata['admin_id'];	
	    $ours = $this->db->query(" SELECT * FROM `l1_co_department`
	    WHERE `Added_By` = '".$idd."' AND `status` = '1' ")->result_array();
		?>
		<script>
		$('#__dept_chart').html('<?php echo $testname; ?>');
		var chart_by_dept = {
		chart: {
				  height: 200,
				  type: "bar",
				  toolbar: {
					   show: !1
				  }
			 },
			 plotOptions: {
				  bar: {
					   horizontal: !1,
					   columnWidth: "30%",
					   endingShape: "rounded"
				  }
			 },
			 dataLabels: {
				  enabled: !0,
				  formatter: function (e) {
					   return e
				  },
				  offsetY: -20,
				  style: {
					   fontSize: "12px",
					   colors: ["#FFFFFF"]
				  }
			 },
			 stroke: {
				  show: !0,
				  width: 2,
				  colors: ["transparent"]
			 },
			 series: [{
				  name: "الكل",
				  // Get_Counter_of_Tests($id,$testname,$result = "")
				  data: [<?php foreach($ours as $dept){  echo $this->Get_Counter_of_Tests($dept['Id'],$testname,"").","; } ?>]
			 }, {
				  name: "سلبي",
				  data: [<?php foreach($ours as $dept){  echo $this->Get_Counter_of_Tests($dept['Id'],$testname,"0").","; } ?>]
			 }, {
				  name: "إيجابي",
				  data: [<?php foreach($ours as $dept){  echo $this->Get_Counter_of_Tests($dept['Id'],$testname,"1").","; } ?>]
			 }],
			 colors: [ "#5b73e8","#189264","#C3343C"],
			 xaxis: {
				  categories: [<?php foreach($ours as $dept){ echo "'".$dept['Dept_Name_AR']."',"; } ?>]
			 },
			 yaxis: {
				  title: {
					   text: "مجموع التجارب"
				  }
			 },
			 grid: {
				  borderColor: "#f1f1f1"
			 },
			 fill: {
				  opacity: 1
			 },
			 tooltip: {
				  y: {
					   formatter: function (e) {
							if(e >= 1000){
							var th = e.slice(0,1);	
							return  th + "Tounsend"
							}else{
							return  e
							}
					   }
				  }
			 }
		};
		chart = new ApexCharts(document.querySelector("#chart_by_dept"), chart_by_dept);
		chart.render();
		</script>
		<?php
	}
	
private function Get_CounterForThisType_Ministry($id,$testDesc,$in,$result = ""){
	$counter = 0;
	$today = date("Y-m-d");
	if($in !== ""){
	$query_users = $this->db->query(" SELECT * FROM `l2_co_patient`
	WHERE `Added_By` = '".$id."' AND `Action` = '".$in."' ")->result_array();
	}else{
	$query_users = $this->db->query(" SELECT * FROM `l2_co_patient`
	WHERE `Added_By` = '".$id."' ")->result_array();
	}
	
	if($in !== ""){
		if($result !== ""){
			foreach($query_users as $user){
				$type = $user['UserType'];
				$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '".$type."' AND `UserId` = '".$user['Id']."' 
				 AND `Test_Description` = '".$testDesc."' AND `Result` = '".$result."'
				 AND `Action` = '".$in."' ORDER BY `TimeStamp` LIMIT 1 ")->num_rows();
				 if($Results > 0){
						 $counter += $Results;
				 }
			}
		}else{
			foreach($query_users as $user){
				$type = $user['UserType'];
				$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '".$type."' AND `UserId` = '".$user['Id']."' 
				 AND `Test_Description` = '".$testDesc."'  AND `Action` = '".$in."'  LIMIT 1 ")->num_rows();
				 $counter += $Results;
			}
		}
	}else{
		if($result !== ""){
			foreach($query_users as $user){
				$type = $user['UserType'];
				$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '".$type."' AND `UserId` = '".$user['Id']."' 
				 AND `Test_Description` = '".$testDesc."' AND `Result` = '".$result."'
				 ORDER BY `TimeStamp` LIMIT 1 ")->num_rows();
				 if($Results > 0){
						 $counter += $Results;
				 }
			}
		}else{
			foreach($query_users as $user){
				$type = $user['UserType'];
				$Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
				`UserType` = '".$type."' AND `UserId` = '".$user['Id']."' 
				 AND `Test_Description` = '".$testDesc."' LIMIT 1 ")->num_rows();
				 $counter += $Results;
			}
		}
	}
	
	
	return($counter);
}
	
public function Get_home_List_Ministry(){
?>
      <style>
		  .Lab_Table td , .Lab_Table th {
			padding: 0px;
			border: 12px solid white;
			border-radius: 34%;
		}
		  .Lab_Table th {
			  padding: 3px !important;
		  }

	</style>
<table id="Lab_Table" class="table Lab_Table" style="width: 100%;">
	<thead>
	<th style="text-align: right;">الصورة</th>
	<th style="text-align: right;">الإسم</th>
	<th style="color: #ff2e00;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">إيجابي</th>
	<th style="color: #1FBD00;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">سلبي</th>
	<th  style="color: #0056BD;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">المجموع</th>
	</thead>
<tbody>
<?php    
 $List = array();     
 //echo is_numeric($counter);    
 $testDesc = $this->input->post("TestDesc"); 
	
 if($this->input->post("IN")){
 $in = $this->input->post("IN"); 
 }else{
 $in = "";
 }
	
 $sessiondata = $this->session->userdata('admin_details');  
 $testType = $this->input->post('TestDesc'); 
 $our_schools = $this->db->query("SELECT 
 `Dept_Name_AR`,`Id` FROM `l1_co_department`
 WHERE `Added_By` = '".$sessiondata['admin_id']."' AND `status` = '1' 
 ORDER BY `Id` DESC ")->result_array();  
 //print_r($our_schools); 
 foreach($our_schools as $school){ 
   $counter = 0;
   $counter_Positive = 0;
   $counter_Nigative = 0;
   //echo "---".$school['Id']."<br>";
   $counter +=  $this->Get_CounterForThisType_Ministry($school['Id'],$testDesc,$in,"");
   // Positive 
   $counter_Positive +=  $this->Get_CounterForThisType_Ministry($school['Id'],$testDesc,$in,'1');
   // Nigative 
   $counter_Nigative +=  $this->Get_CounterForThisType_Ministry($school['Id'],$testDesc,$in,'0');
   
   ?> 

<tr>
 <td style="width: 20px;">
	 <?php $avatr_school = $this->db->query("SELECT `Link` FROM `l2_avatars` WHERE 
	  `Type_Of_User` = 'department_Company' AND `For_User` = '".$school['Id']."' ORDER BY `Id` DESC LIMIT 1 ")->result_array(); ?>
	 <?php
	 if(!empty($avatr_school)){
	   $link = $avatr_school[0]['Link'];
	 }else{
	   $link = "default_avatar.jpg";
	 } 
	 ?>
	<img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $link; ?>" 
	class="avatar-xs rounded-circle " alt="<?php echo $school['Dept_Name_AR'] ?>">
 </td>
 <td>
	 <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $school['Dept_Name_AR']; ?></h6>
 </td>
	
<td style="background: #ff2e00;color: #fff;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">
	<span class="badge font-size-15" 
	style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;margin-top: 7px;"><?php echo $counter_Positive; ?></span>
</td>
	
<td style="background: #1FBD00;color: #fff;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">
	<span class="badge font-size-15" 
	style="width: 100%;border-radius: 10px;background: #1FBD00;color: #fff;margin-top: 7px;"><?php echo $counter_Nigative; ?></span>
</td>
	
<td style="background: #0056BD;color: #fff;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">
	<span class="badge font-size-15" 
	style="width: 100%;border-radius: 10px;background: #0056BD;color: #fff;margin-top: 7px;"><?php echo $counter; ?></span>
</td>
	
</tr>
   <?php 
 } ?>
</tbody> 
</table>
<script>
$('#Lab_Table').destroy();	
$('#Lab_Table').DataTable({
	language: {
		url: '<?php echo base_url(); ?>assets/js/arabic_datatable.json'
	}
});
</script>
<?php
}

public function sites_data_table(){
?>
		<table class="table Lab_Table" id="" style="width: 100%;">
		<thead>
		<th style="text-align: right;">الصورة</th>
		<th style="text-align: right;">الإسم</th>
        <th style="color: #ff2e00;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;"><center>إيجابي</center></th>
		<th style="color: #1FBD00;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;"><center>سلبي</center></th>
		<th style="color: #0056BD;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;text-align: right;"><center>التعقيم</center></th>
		</thead>
		<tbody>
<?php 
     $List = array();     
	 $testname = $this->input->post('TestName');
     //echo is_numeric($counter);    
     $sessiondata = $this->session->userdata('admin_details');  
     $our_schools = $this->db->query("SELECT 
     `Dept_Name_AR`,`Id` FROM `l1_co_department` 
	 WHERE `Added_By` = '".$sessiondata['admin_id']."' AND `status` = '1' ORDER BY `Id` DESC ")->result_array();  
     //print_r($our_schools); 
     foreach($our_schools as $school){
       $counter = 0;
	   $counter_Positive = 0;
	   $counter_Nigative = 0;
       //echo "---".$school['Id']."<br>";
   	   $counter          +=  $this->counter_of_sites_results($school['Id'],$testname,"","Cleaning");
       // Positive 
       $counter_Positive +=  $this->counter_of_sites_results($school['Id'],$testname,"1");
       // Nigative 
       $counter_Nigative +=  $this->counter_of_sites_results($school['Id'],$testname,"0");
		         $today = date("Y-m-d");
       ?>
		<tr>
			 <td style="width: 20px;">
				 <?php $avatr_school = $this->db->query("SELECT `Link` FROM `l2_avatars` WHERE 
				  `Type_Of_User` = 'department_Company' AND `For_User` = '".$school['Id']."' ORDER BY `Id` DESC LIMIT 1 ")->result_array(); ?>
				 <?php
				 if(!empty($avatr_school)){
				   $link = $avatr_school[0]['Link'];
				 }else{
				   $link = "default_avatar.jpg";
				 } 
				 ?>
				<img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $link; ?>" 
				class="avatar-xs rounded-circle " alt="<?php echo $school['Dept_Name_AR'] ?>">
			 </td>
			 <td>
				 <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $school['Dept_Name_AR']; ?></h6>
			 </td>
			 <td style="background: #ff2e00;color: #fff;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">
				 <span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;margin-top: 7px;"> 
				 <?php echo $counter_Positive; ?>
				 </span>
			 </td>
			 <td style="background: #1FBD00;color: #fff;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;">
				 <span class="badge font-size-15" style="width: 100%;border-radius: 10px;background: #1FBD00;color: #fff;margin-top: 7px;"> 
				 <?php echo $counter_Nigative; ?>
				 </span>
			 </td >
			  <td style="background: #0056BD;color: #fff;border-radius: 12px;margin: 10px;border: 12px solid white;border-radius:30%;padding: 0px;text-align: right;">
				<span class="badge badge-info font-size-15" style="width: 100%;border-radius: 10px;background: #0056BD;color: #fff;margin-top: 7px;"><?php echo $counter; ?></span>
			  </td>
		</tr>
       <?php 
     } ?>
		</tbody>
</table>

<?php }
	
private function counter_of_sites_results($id,$testName,$result = "",$action = ""){
        $counter = 0;
        $today = date("Y-m-d");
	 	$query_users = $this->db->query(" SELECT * FROM `l2_co_site` WHERE `Added_By` = '".$id."'  ")->result_array();
		if($result == "" && $action == "" ){
        foreach($query_users as $user){
            $Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
            `UserType` = 'Site' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."'
			 AND `Test_Description` = '".$testName."'  ")->num_rows();
             $counter += $Results;
        }
		}elseif($result !== "" && $action == "" ){
        foreach($query_users as $user){
            $Results = $this->db->query("SELECT * FROM `l2_co_labtests` WHERE 
            `UserType` = 'Site' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."'
             AND `Result` = '".$result."'  AND `Test_Description` = '".$testName."' ")->num_rows();
             $counter += $Results;
        }
		}elseif($action !== "" && $result == "" ){
        foreach($query_users as $user){
            $Results = $this->db->query("SELECT * FROM `l2_labtests` WHERE 
            `UserType` = 'Site' AND `Created` = '".$today."' AND `UserId` = '".$user['Id']."'
             AND `Test_Description` = '".$testName."' AND `Action` = '".$action."' LIMIT 1 ")->num_rows();
             $counter += $Results;
        }
		}
	 	
        return($counter);
}
	
	
}