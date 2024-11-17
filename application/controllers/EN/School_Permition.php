<?php    

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


class School_Permition extends CI_Controller {

   
  function __construct()
    {
         parent::__construct();
          $this->load->library( 'session' );
          $sessiondata = $this->session->userdata('admin_details');
          if(!isset($sessiondata) || !$sessiondata['hasperm'] || $sessiondata['level'] !== 3 
             || $sessiondata['type'] == "Dept_Perm" ){
               redirect('users');
               exit();
          }
    }     
     
     
     
     public function index(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if(!empty($sessiondata)){
          $data['page_title'] = "Qlick Health | Dashboard ";
          $data['sessiondata'] = $sessiondata;
          if($sessiondata['type'] == 1){
           $adminData = $this->db->query("SELECT * FROM l0_organization WHERE Id = '".$sessiondata['admin_id']."'")->result_array();
           $complet['adminData'] = $this->db->query("SELECT * FROM l0_organization WHERE Id = '".$sessiondata['admin_id']."'")->result_array();
              foreach($adminData as $admindata){
               if(empty($admindata['Manager']) || empty($admindata['Tel']) ){
               $data[ 'hasntnav' ] = true;     
               $this->load->view('EN/Complete_registration2',$complet);
               $this->load->view('EN/inc/header',$data);
               $this->load->view('EN/inc/footer',$data);
               }else{
          $this->load->view('EN/dash');
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/inc/footer',$data);
              } 
              }
          }else{
          $this->load->view('EN/dash');
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/inc/footer',$data);
          }     
          }else{
          redirect('users');
          }
     }
     
     public function AddMembers(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | Add Members";
          $data['sessiondata'] = $sessiondata;
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/AddMembers');
          $this->load->view('EN/inc/footer');
     }
     
     public function AddDevice(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | Add Members";
          $data['sessiondata'] = $sessiondata;
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/AddDevice');
          $this->load->view('EN/inc/footer');
     }
     
     public function ListOfStaff(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | List of Staff ";
          $data['sessiondata'] = $sessiondata;
          $data['listofaStaffs'] = $this->db->query("SELECT * FROM l2_staff WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/List_Stuff');
          $this->load->view('EN/inc/footer');
     }
     
     public function UpdateStaffData(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $SUFFID = $this->uri->segment(3);
          $iscorrect = $this->db->query("SELECT * FROM l2_staff WHERE Id =  '".$SUFFID."'
          AND Added_By = '".$sessiondata['admin_id']."' ")->num_rows();
          if($iscorrect > 0){
          $data['page_title'] = "Qlick Health | Update Staff Data ";
          $data['sessiondata'] = $sessiondata;
          $data['StaffData'] = $this->db->query("SELECT * FROM l2_staff WHERE Id  = '".$SUFFID."' LIMIT 1")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/Update_Stuff');
          $this->load->view('EN/inc/footer');
          }else{
               redirect('schools');
          }
     }
     
     public function listOfTeachers(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | List Of Teachers ";
          $data['sessiondata'] = $sessiondata;
          $data['listofaStaffs'] = $this->db->query("SELECT * FROM l2_teacher WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/List_Teachers');
          $this->load->view('EN/inc/footer');
     }
     
     public function UpdateTeacher(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $SUFFID = $this->uri->segment(3);
          $iscorrect = $this->db->query("SELECT * FROM l2_teacher WHERE Id =  '".$SUFFID."'
          AND Added_By = '".$sessiondata['admin_id']."' ")->num_rows();
          if($iscorrect > 0){
          $data['page_title'] = "Qlick Health | Update Teacher ";
          $data['sessiondata'] = $sessiondata;
          $data['StaffData'] = $this->db->query("SELECT * FROM l2_teacher WHERE Id  = '".$SUFFID."' LIMIT 1")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/Update_Teacher');
          $this->load->view('EN/inc/footer');
          }else{
               redirect('schools');
          }
     }
     
     public function UpdateSite(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $SUFFID = $this->uri->segment(3);
          $iscorrect = $this->db->query("SELECT * FROM l2_site WHERE Id =  '".$SUFFID."'
          AND Added_By = '".$sessiondata['admin_id']."' ")->num_rows();
          if($iscorrect > 0){
          $data['page_title'] = "Qlick Health | Update Teacher ";
          $data['sessiondata'] = $sessiondata;
          $data['sitesdata'] = $this->db->query("SELECT * FROM l2_site WHERE Id  = '".$SUFFID."' LIMIT 1")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/Update_site');
          $this->load->view('EN/inc/footer');
          }else{
               redirect('schools');
          }
     }

     public function listOfStudents(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | List of Sites ";
          $data['sessiondata'] = $sessiondata;
          $data['listofaStaffs'] = $this->db->query("SELECT * FROM l2_student WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/List_Students');
          $this->load->view('EN/inc/footer');
     }
     
     public function listOfSites(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | List Of Sites ";
          $data['sessiondata'] = $sessiondata;
          $data['listofaStaffs'] = $this->db->query("SELECT * FROM `l2_site` WHERE Added_By = '".$sessiondata['admin_id']."'")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/List_sites');
          $this->load->view('EN/inc/footer');
     }
     
     public function UpdateStudent(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $SUFFID = $this->uri->segment(3);
          $iscorrect = $this->db->query("SELECT * FROM l2_student WHERE Id =  '".$SUFFID."'
          AND Added_By = '".$sessiondata['admin_id']."' ")->num_rows();
          if($iscorrect > 0){
          $data['page_title'] = "Qlick Health | Update Teacher ";
          $data['sessiondata'] = $sessiondata;
          $data['StaffData'] = $this->db->query("SELECT * FROM l2_student WHERE Id  = '".$SUFFID."' LIMIT 1")->result_array();
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/Update_Students');
          $this->load->view('EN/inc/footer');
          }else{
               redirect('schools');
          }
     }
     
     ///// ajax start
     // staff
     public function startAddStaff(){
          $this->load->library( 'form_validation' ); 
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if($this->input->post('Prefix')){
               
          $this->form_validation->set_rules( 'Prefix', 'Prefix', 'trim|required' );
          // English     
          $this->form_validation->set_rules( 'First_Name_EN', 'First Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_EN', 'Middle Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_EN', 'Last Name EN', 'trim|required' );
          // Arabic     
          $this->form_validation->set_rules( 'First_Name_AR', 'First Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_AR', 'Middle Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_AR', 'Last Name AR', 'trim|required' );
               
          $this->form_validation->set_rules( 'DOP', 'Date of Birth', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]' );
          $this->form_validation->set_rules( 'Gender', 'Gender', 'trim|required' );
          $this->form_validation->set_rules( 'N_Id', 'National Id', 'trim|required' );
          $this->form_validation->set_rules( 'Nationality', 'Nationality', 'trim|required' );
          $this->form_validation->set_rules( 'Position', 'Position', 'trim|required' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
               
          if ( $this->form_validation->run() ) {
          $Prefix = $this->input->post('Prefix');              
          $First_Name_EN = $this->input->post('First_Name_EN');              
          $Middle_Name_EN = $this->input->post('Middle_Name_EN');              
          $Last_Name_EN = $this->input->post('Last_Name_EN');   
          //    AR inputs
          $First_Name_AR = $this->input->post('First_Name_AR');              
          $Middle_Name_AR = $this->input->post('Middle_Name_AR');              
          $Last_Name_AR = $this->input->post('Last_Name_AR');   
           //style="padding: 10px;background: #f3f8fb;"    
          $DOP = $this->input->post('DOP');              
          $Phone = $this->input->post('Phone');              
          $Gender = $this->input->post('Gender');   
          $National_Id = $this->input->post('N_Id');              
          $Nationality = $this->input->post('Nationality');   
          $Position = $this->input->post('Position');   
          $Email = $this->input->post('Email');   
          $password =  "12345678";
          $hash_pass = password_hash($password, PASSWORD_DEFAULT);
          
          $age = explode('-',$DOP);
          $thisyear = date('Y');
          $finalyage = $thisyear - $age[2];  
          if($finalyage > 4 || $finalyage < 70){
          $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '".$National_Id."'")->num_rows();
          if($iscrrent == 0){
           if($this->db->query("INSERT INTO 
          `l2_staff` ( `Prefix`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Position`,`Email`,
          `Password`,`UserName`, `Added_By` ,`Created`)
          VALUES ('".$Prefix."',
          '".$First_Name_EN."', '".$Middle_Name_EN."', '".$Last_Name_EN."', 
          '".$First_Name_AR."', '".$Middle_Name_AR."', '".$Last_Name_AR."', 
          '".$DOP."', '".$Phone."', '".$Gender."', '".$National_Id."', '".$Nationality."','".$Position."',
          '".$Email."','".$hash_pass."','".$National_Id."','".$sessiondata['admin_id']."' ,'".date('Y-m-d')."');")){
          // $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
          // VALUES ('".$National_Id."','Staff','".date('Y-m-d')."')");      
               echo "The Data Is Inserted.";
               echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>"; 
                
          $this->load->library('email');
          $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.hostinger.com',
          'smtp_port' => 465,
          'smtp_user' => 'jobs@qlicksystems.com',
          'smtp_pass' => 'O?#f:Kc19#z',
          'smtp_crypto' => 'ssl',
          'mailtype'  => 'html', 
          'charset'   => 'iso-8859-1'
          );
          //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
          $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : '.$National_Id.' </h3>
          <h3>Your password is : '.$password.' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


          $this->email->initialize($config); 
          $this->email->set_newline('\r\n');
          $this->email->from('jobs@qlicksystems.com','qlicksystems.com'); 
          $this->email->to($Email);
          $this->email->subject(' You User Name And Password ');
          $this->email->message($messg);
               
          if (!$this->email->send()) {
          echo $this->email->print_debugger();     
          echo 'We have an error in sending the email . Please try again later.';
          }else{
         echo "<script>Swal.fire({title: 'Success!',text: 'a Email Was Sended To The Email you Entred !',icon: 'success'});</script>";           
          echo "
          <script>
          location.href = '".base_url()."EN/schools/AddMembers';
          </script>
          ";     
          }
                
          }  
          }else{
               echo "The National ID already exists.";
          }     
          }else{
               echo "Please correct Your Date Of Birth";
          }    
             

               
          }else{
          echo validation_errors();
          }
               
          }

     }
     
     public function UpdateStaff(){
          $this->load->library( 'form_validation' ); 
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if($this->input->post('Prefix')){
               
          $this->form_validation->set_rules( 'Prefix', 'Prefix', 'trim|required' );
          // English     
          $this->form_validation->set_rules( 'First_Name_EN', 'First Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_EN', 'Middle Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_EN', 'Last Name EN', 'trim|required' );
          // Arabic     
          $this->form_validation->set_rules( 'First_Name_AR', 'First Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_AR', 'Middle Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_AR', 'Last Name AR', 'trim|required' );
               
          $this->form_validation->set_rules( 'DOP', 'Date of Birth', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]' );
          $this->form_validation->set_rules( 'Gender', 'Gender', 'trim|required' );
          $this->form_validation->set_rules( 'N_Id', 'National Id', 'trim|required' );
          $this->form_validation->set_rules( 'Nationality', 'Nationality', 'trim|required' );
          $this->form_validation->set_rules( 'Position', 'Position', 'trim|required' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
               
          if ( $this->form_validation->run() ) {
          $Prefix = $this->input->post('Prefix');              
          $First_Name_EN = $this->input->post('First_Name_EN');              
          $Middle_Name_EN = $this->input->post('Middle_Name_EN');              
          $Last_Name_EN = $this->input->post('Last_Name_EN');   
          //    AR inputs
          $First_Name_AR = $this->input->post('First_Name_AR');              
          $Middle_Name_AR = $this->input->post('Middle_Name_AR');              
          $Last_Name_AR = $this->input->post('Last_Name_AR');   
           //style="padding: 10px;background: #f3f8fb;"    
          $DOP = $this->input->post('DOP');              
          $Phone = $this->input->post('Phone');              
          $Gender = $this->input->post('Gender');   
          $National_Id = $this->input->post('N_Id');              
          $Nationality = $this->input->post('Nationality');   
          $Position = $this->input->post('Position');   
          $Email = $this->input->post('Email');   
          $old_NID = $this->input->post('old_NID');   
          $ID = $this->input->post('ID');   
          $password =  "12345678";
          $hash_pass = password_hash($password, PASSWORD_DEFAULT);
          
          $age = explode('-',$DOP);
          $thisyear = date('Y');
          $finalyage = $thisyear - $age[2];  
          if($finalyage > 4 || $finalyage < 70){
          if($National_Id !== $old_NID){
          $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '".$National_Id."'")->num_rows();
          }else{
          $iscrrent = null;    
          }     
          if($iscrrent == 0){
           if($this->db->query("UPDATE `l2_staff` SET Prefix = '".$Prefix."' , 
           F_name_EN = '".$First_Name_EN."' , M_name_EN = '".$Middle_Name_EN."' , L_name_EN = '".$Last_Name_EN."' ,
           F_name_AR = '".$First_Name_AR."' , M_name_AR = '".$Middle_Name_AR."' , L_name_AR = '".$Last_Name_AR."' ,
           DOP = '".$DOP."' , Phone = '".$Phone."' , Gender = '".$Gender."' , UserName = '".$National_Id."' ,
           National_Id = '".$National_Id."' , Nationality = '".$Nationality."' , Password = '".$hash_pass."' , 
           UserName = '".$National_Id."' , Email = '".$Email."' WHERE Id = '".$ID."'
           ")){
           $this->db->query("UPDATE `v_nationalids` SET `National_Id` = '".$National_Id."'
           WHERE National_Id = '".$old_NID."' ");
           $this->db->query("UPDATE `v_login` SET `Username` = '".$National_Id."'
           WHERE Username = '".$old_NID."' ");   
                
           echo "The Data Is Inserted.";
           echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>"; 
                
          $this->load->library('email');
          $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.hostinger.com',
          'smtp_port' => 465,
          'smtp_user' => 'jobs@qlicksystems.com',
          'smtp_pass' => 'O?#f:Kc19#z',
          'smtp_crypto' => 'ssl',
          'mailtype'  => 'html', 
          'charset'   => 'iso-8859-1'
          );
          //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
          $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : '.$National_Id.' </h3>
          <h3>Your password is : '.$password.' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


          $this->email->initialize($config); 
          $this->email->set_newline('\r\n');
          $this->email->from('jobs@qlicksystems.com','qlicksystems.com'); 
          $this->email->to($Email);
          $this->email->subject(' You User Name And Password ');
          $this->email->message($messg);
               
          if (!$this->email->send()) {
          echo $this->email->print_debugger();     
          echo 'We have an error in sending the email . Please try again later.';
          }else{
         echo "<script>Swal.fire({title: 'Success!',text: 'a Email Was Sended To The Email you Entred !',icon: 'success'});</script>";           
          echo "
          <script>
          location.href = '".base_url()."EN/schools/AddMembers';
          </script>
          ";     
          }
                
          }  
          }else{
               echo "The National ID already exists.";
          }     
          }else{
               echo "Please correct Your Date Of Birth";
          }    
             

               
          }else{
          echo validation_errors();
          }
               
          }

     }
     
     // Teacher
     public function startAddTeacher(){
          $this->load->library( 'form_validation' );
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if($this->input->post('Prefix')){
               
          $this->form_validation->set_rules( 'Prefix', 'Prefix', 'trim|required' );
          // English     
          $this->form_validation->set_rules( 'First_Name_EN', 'First Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_EN', 'Middle Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_EN', 'Last Name EN', 'trim|required' );
          // Arabic     
          $this->form_validation->set_rules( 'First_Name_AR', 'First Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_AR', 'Middle Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_AR', 'Last Name AR', 'trim|required' );
               
          $this->form_validation->set_rules( 'DOP', 'Date of Birth', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]' );
          $this->form_validation->set_rules( 'Gender', 'Gender', 'trim|required' );
          $this->form_validation->set_rules( 'N_Id', 'National Id', 'trim|required' );
          $this->form_validation->set_rules( 'Nationality', 'Nationality', 'trim|required' );
          $this->form_validation->set_rules( 'Position', 'Position', 'trim|required' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
          //$this->form_validation->set_rules( 'Classes', 'Classes', 'trim|required' );
               
          if ( $this->form_validation->run() ) {
          $Prefix = $this->input->post('Prefix');              
          $First_Name_EN = $this->input->post('First_Name_EN');              
          $Middle_Name_EN = $this->input->post('Middle_Name_EN');              
          $Last_Name_EN = $this->input->post('Last_Name_EN');   
          //    AR inputs
          $First_Name_AR = $this->input->post('First_Name_AR');              
          $Middle_Name_AR = $this->input->post('Middle_Name_AR');              
          $Last_Name_AR = $this->input->post('Last_Name_AR');  
               
          $DOP = $this->input->post('DOP');              
          $Phone = $this->input->post('Phone');              
          $Gender = $this->input->post('Gender');   
          $National_Id = $this->input->post('N_Id');              
          $Nationality = $this->input->post('Nationality');   
          $Position = $this->input->post('Position');   
          $Email = $this->input->post('Email'); 
          $clases = $this->input->post('Classes');
          $i = 0;
          $recent = array();
          $data = array();
          $classesnum = $this->db->query("SELECT * FROM `r_levels` ")->num_rows();
          $Val = '';
          for($i = 0;$i <= $classesnum;$i++){
          if(isset($clases[$i])){
               $Val = $Val.$i.';';
          }
          } 
               
          $password =  "12345678";
          $hash_pass = password_hash($password, PASSWORD_DEFAULT);
          
          $age = explode('-',$DOP);
          $thisyear = date('Y');
          $finalyage = $thisyear - $age[2];  
          if($finalyage > 4 || $finalyage < 70){
          $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '".$National_Id."'")->num_rows();
          if($iscrrent == 0){
           if($this->db->query("INSERT INTO 
          `l2_teacher` ( `Prefix`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Position`,`Email`,
          `Password`,`UserName`, `Classes` , `Added_By` , `Created`)
          VALUES ('".$Prefix."',
          '".$First_Name_EN."', '".$Middle_Name_EN."', '".$Last_Name_EN."', 
          '".$First_Name_AR."', '".$Middle_Name_AR."', '".$Last_Name_AR."', 
          '".$DOP."', '".$Phone."', '".$Gender."', '".$National_Id."', '".$Nationality."','".$Position."',
          '".$Email."','".$hash_pass."','".$National_Id."', '".$Val."', '".$session['admin_id']."' , '".date('Y-m-d')."');")){
          // $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
          // VALUES ('".$National_Id."','Teacher','".date('Y-m-d')."')");      
         echo "The Data Is Inserted.";
         echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>"; 
                
          $this->load->library('email');
          $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.hostinger.com',
          'smtp_port' => 465,
          'smtp_user' => 'jobs@qlicksystems.com',
          'smtp_pass' => 'O?#f:Kc19#z',
          'smtp_crypto' => 'ssl',
          'mailtype'  => 'html', 
          'charset'   => 'iso-8859-1'
          );
          $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2> 
          <h3>Your User name is : '.$National_Id.' </h3>
          <h3>Your password is : '.$password.' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';


          $this->email->initialize($config); 
          $this->email->set_newline('\r\n');
          $this->email->from('jobs@qlicksystems.com','qlicksystems.com'); 
          $this->email->to($Email);
          $this->email->subject(' You User Name And Password ');
          $this->email->message($messg);
               
          if (!$this->email->send()) {
          echo $this->email->print_debugger();     
          echo 'We have an error in sending the email . Please try again later.';
          }else{
         echo "<script>Swal.fire({title: 'Success!',text: 'a Email Was Sended To The Email you Entred !',icon: 'success'});</script>";           
          echo "
          <script>
          location.href = '".base_url()."EN/schools/AddMembers';
          </script>
          ";
          }
                
          }  
          }else{
               echo "The National ID already exists.";
          }     
          }else{
               echo "Please correct Your Date Of Birth";
          }    
             

               
          }else{
          echo validation_errors();
          }
               
          }

     }
     
     public function UpdateTeacherData(){
          $this->load->library( 'form_validation' ); 
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if($this->input->post('Prefix')){
               
          $this->form_validation->set_rules( 'Prefix', 'Prefix', 'trim|required' );
          // English     
          $this->form_validation->set_rules( 'First_Name_EN', 'First Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_EN', 'Middle Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_EN', 'Last Name EN', 'trim|required' );
          // Arabic     
          $this->form_validation->set_rules( 'First_Name_AR', 'First Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_AR', 'Middle Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_AR', 'Last Name AR', 'trim|required' );
               
          $this->form_validation->set_rules( 'DOP', 'Date of Birth', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]' );
          $this->form_validation->set_rules( 'Gender', 'Gender', 'trim|required' );
          $this->form_validation->set_rules( 'N_Id', 'National Id', 'trim|required' );
          $this->form_validation->set_rules( 'Nationality', 'Nationality', 'trim|required' );
          $this->form_validation->set_rules( 'Position', 'Position', 'trim|required' );
          //$this->form_validation->set_rules( 'Classes', 'Classes', 'trim|required' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
               
          if ( $this->form_validation->run() ) {
          $Prefix = $this->input->post('Prefix');              
          $First_Name_EN = $this->input->post('First_Name_EN');              
          $Middle_Name_EN = $this->input->post('Middle_Name_EN');              
          $Last_Name_EN = $this->input->post('Last_Name_EN');   
          //    AR inputs
          $First_Name_AR = $this->input->post('First_Name_AR');              
          $Middle_Name_AR = $this->input->post('Middle_Name_AR');              
          $Last_Name_AR = $this->input->post('Last_Name_AR');   
           //style="padding: 10px;background: #f3f8fb;"    
          $DOP = $this->input->post('DOP');              
          $Phone = $this->input->post('Phone');              
          $Gender = $this->input->post('Gender');   
          $National_Id = $this->input->post('N_Id');              
          $Nationality = $this->input->post('Nationality');   
          $Position = $this->input->post('Position');   
          $Email = $this->input->post('Email');   
          $old_NID = $this->input->post('old_NID');   
          $ID = $this->input->post('ID');   
          $password =  "12345678";
          $hash_pass = password_hash($password, PASSWORD_DEFAULT);
          ////clases     
          $clases = $this->input->post('Classes');
          $i = 0;
          $recent = array();
          $data = array();
          $classesnum = $this->db->query("SELECT * FROM `r_levels` ")->num_rows();
          $Val = '';
          for($i = 0;$i <= $classesnum;$i++){
          if(isset($clases[$i])){
               $Val = $Val.$i.';';
          }
          } 

          $age = explode('-',$DOP);
          $thisyear = date('Y');
          $finalyage = $thisyear - $age[2];  
          if($finalyage > 4 || $finalyage < 70){
          if($National_Id !== $old_NID){
          $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '".$National_Id."'")->num_rows();
          }else{
          $iscrrent = null;    
          }     
          if($iscrrent == 0){
           if($this->db->query("UPDATE `l2_teacher` SET Prefix = '".$Prefix."' , 
           F_name_EN = '".$First_Name_EN."' , M_name_EN = '".$Middle_Name_EN."' , L_name_EN = '".$Last_Name_EN."' ,
           F_name_AR = '".$First_Name_AR."' , M_name_AR = '".$Middle_Name_AR."' , L_name_AR = '".$Last_Name_AR."' ,
           DOP = '".$DOP."' , Phone = '".$Phone."' , Gender = '".$Gender."' , UserName = '".$National_Id."' ,
           National_Id = '".$National_Id."' , Nationality = '".$Nationality."' , Password = '".$hash_pass."' , 
           UserName = '".$National_Id."' , Email = '".$Email."' , Classes = '".$Val."' WHERE Id = '".$ID."'
           ")){
           $this->db->query("UPDATE `v_nationalids` SET `National_Id` = '".$National_Id."'
           WHERE National_Id = '".$old_NID."' ");
           $this->db->query("UPDATE `v_login` SET `Username` = '".$National_Id."'
           WHERE Username = '".$old_NID."' ");   
                
           echo "The Data Is Inserted.";
           echo "<script>
           Swal.fire({title: 'Good !',text: 'The data was updated.',icon: 'success'});
           setTimeout(function(){
            location.href = '".base_url()."EN/schools/listOfTeachers'; 
           });
           </script>"; 
                
          }  
          }else{
               echo "The National ID already exists.";
          }     
          }else{
               echo "Please correct Your Date Of Birth";
          }    
               
          }else{
          echo validation_errors();
          }
               
          }

     } 
     
     public function UpdateStudentData(){
          $this->load->library( 'form_validation' ); 
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if($this->input->post('Prefix')){
               
          $this->form_validation->set_rules( 'Prefix', 'Prefix', 'trim|required' );
          // English     
          $this->form_validation->set_rules( 'First_Name_EN', 'First Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_EN', 'Middle Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_EN', 'Last Name EN', 'trim|required' );
          // Arabic     
          $this->form_validation->set_rules( 'First_Name_AR', 'First Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_AR', 'Middle Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_AR', 'Last Name AR', 'trim|required' );
               
          $this->form_validation->set_rules( 'DOP', 'Date of Birth', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]' );
          $this->form_validation->set_rules( 'Gender', 'Gender', 'trim|required' );
          $this->form_validation->set_rules( 'N_Id', 'National Id', 'trim|required' );
          $this->form_validation->set_rules( 'Nationality', 'Nationality', 'trim|required' );
          $this->form_validation->set_rules( 'Classes', 'Classes', 'trim|required|numeric' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
               
          if ( $this->form_validation->run() ) {
          $Prefix = $this->input->post('Prefix');              
          $First_Name_EN = $this->input->post('First_Name_EN');              
          $Middle_Name_EN = $this->input->post('Middle_Name_EN');              
          $Last_Name_EN = $this->input->post('Last_Name_EN');   
          //    AR inputs
          $First_Name_AR = $this->input->post('First_Name_AR');              
          $Middle_Name_AR = $this->input->post('Middle_Name_AR');              
          $Last_Name_AR = $this->input->post('Last_Name_AR');   
           //style="padding: 10px;background: #f3f8fb;"    
          $DOP = $this->input->post('DOP');              
          $Phone = $this->input->post('Phone');              
          $Gender = $this->input->post('Gender');   
          $National_Id = $this->input->post('N_Id');              
          $PN_ID = $this->input->post('PN_ID');              
          $Nationality = $this->input->post('Nationality');   
          $Position = $this->input->post('Position');   
          $Email = $this->input->post('Email');   
          $old_NID = $this->input->post('old_NID');   
          $ID = $this->input->post('ID');   
          $password =  "12345678";
          $hash_pass = password_hash($password, PASSWORD_DEFAULT);
          ////clases     
          $clases = $this->input->post('Classes');
               
          $age = explode('-',$DOP);
          $thisyear = date('Y');
          $finalyage = $thisyear - $age[2];  
          if($finalyage > 4 || $finalyage < 70){
          if($National_Id !== $old_NID){
          $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '".$National_Id."'")->num_rows();
          }else{
          $iscrrent = null;    
          }     
          if($iscrrent == 0){
           if($this->db->query("UPDATE `l2_student` SET Prefix = '".$Prefix."' , 
           F_name_EN = '".$First_Name_EN."' , M_name_EN = '".$Middle_Name_EN."' , L_name_EN = '".$Last_Name_EN."' ,
           F_name_AR = '".$First_Name_AR."' , M_name_AR = '".$Middle_Name_AR."' , L_name_AR = '".$Last_Name_AR."' ,
           DOP = '".$DOP."' , Phone = '".$Phone."' , Gender = '".$Gender."' , UserName = '".$National_Id."' ,
           National_Id = '".$National_Id."' , Nationality = '".$Nationality."' , Password = '".$hash_pass."' , 
           UserName = '".$National_Id."' , Email = '".$Email."' ,  Parent_NID = '".$PN_ID."' , Class = '".$clases."'
           , Created = '".date('Y-m-d')."'
           WHERE Id = '".$ID."'
           ")){
           $this->db->query("UPDATE `v_nationalids` SET `National_Id` = '".$National_Id."'
           WHERE National_Id = '".$old_NID."' ");
           $this->db->query("UPDATE `v_login` SET `Username` = '".$National_Id."'
           WHERE Username = '".$old_NID."' ");   
                
           echo "The Data Is Inserted.";
           echo "<script>
           Swal.fire({title: 'Good !',text: 'The data was updated.',icon: 'success'});
           setTimeout(function(){
            location.href = '".base_url()."EN/schools/listOfStudents'; 
           },1200);
           </script>"; 
                
          }  
          }else{
               echo "The National ID already exists.";
          }     
          }else{
               echo "Please correct Your Date Of Birth";
          }    
               
          }else{
          echo validation_errors();
          }
               
          }

     }     
     
     public function startAddStudent(){
          $this->load->library( 'form_validation' ); 
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          if($this->input->post('Prefix')){
          $this->form_validation->set_rules( 'Prefix', 'Prefix', 'trim|required' );
          // English     
          $this->form_validation->set_rules( 'First_Name_EN', 'First Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_EN', 'Middle Name EN', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_EN', 'Last Name EN', 'trim|required' );
          // Arabic     
          $this->form_validation->set_rules( 'First_Name_AR', 'First Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Middle_Name_AR', 'Middle Name AR', 'trim|required' );
          $this->form_validation->set_rules( 'Last_Name_AR', 'Last Name AR', 'trim|required' );
               
          $this->form_validation->set_rules( 'DOP', 'Date of Birth', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]' );
          $this->form_validation->set_rules( 'Gender', 'Gender', 'trim|required' );
          $this->form_validation->set_rules( 'N_Id', 'National Id', 'trim|required' );
          $this->form_validation->set_rules( 'Nationality', 'Nationality', 'trim|required' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
          $this->form_validation->set_rules( 'P_NID', 'Parent Natinal Id', 'trim|required' );
          $this->form_validation->set_rules( 'Classes', 'Classes', 'trim|required|numeric' );
               
          if ( $this->form_validation->run() ) {
          $Prefix = $this->input->post('Prefix');              
          $First_Name_EN = $this->input->post('First_Name_EN');              
          $Middle_Name_EN = $this->input->post('Middle_Name_EN');              
          $Last_Name_EN = $this->input->post('Last_Name_EN');   
          //    AR inputs
          $First_Name_AR = $this->input->post('First_Name_AR');              
          $Middle_Name_AR = $this->input->post('Middle_Name_AR');              
          $Last_Name_AR = $this->input->post('Last_Name_AR');  
               
          $DOP = $this->input->post('DOP');              
          $Phone = $this->input->post('Phone');              
          $Gender = $this->input->post('Gender');   
          $National_Id = $this->input->post('N_Id');              
          $Nationality = $this->input->post('Nationality');   
          $Email = $this->input->post('Email');   
          $P_NID = $this->input->post('P_NID');  
          $clases = $this->input->post('Classes');

          $password =  "12345678";
          $hash_pass = password_hash($password, PASSWORD_DEFAULT);
          
          $age = explode('-',$DOP);
          $thisyear = date('Y');
          $finalyage = $thisyear - $age[2];  
          if($finalyage > 4 || $finalyage < 70){
          $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '".$National_Id."'")->num_rows();
          if($iscrrent == 0){
           if($this->db->query("INSERT INTO 
          `l2_student` ( `Prefix`,
          `F_name_EN`, `M_name_EN`,`L_name_En`,
          `F_name_AR`, `M_name_AR`,`L_name_AR`,
          `DOP`, `Phone`, `Gender`, `National_Id`, `Nationality`,`Email`,
          `Password`,`UserName`, `Parent_NID` , `Class` , `Added_By` ,`Created`)
          VALUES ('".$Prefix."',
          '".$First_Name_EN."', '".$Middle_Name_EN."', '".$Last_Name_EN."', 
          '".$First_Name_AR."', '".$Middle_Name_AR."', '".$Last_Name_AR."', 
          '".$DOP."', '".$Phone."', '".$Gender."', '".$National_Id."', '".$Nationality."',
          '".$Email."','".$hash_pass."','".$National_Id."', '".$P_NID."','".$clases."', '".$session['admin_id']."'
          , '".date('Y-m-d')."');")){
          $this->db->query("INSERT INTO  `v_nationalids` ( `National_Id`, `Geted_From` ,`Created`)
          VALUES ('".$National_Id."','Student','".date('Y-m-d')."')"); 
          $num_Username = $this->db->query("SELECT * FROM `v_login` WHERE Username = '".$P_NID."' LIMIT 1 ")->num_rows();     
           if($num_Username == 0){
          // $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`,`Created`) VALUES ('".$P_NID."','".$hash_pass."','Parent','".date('Y-m-d')."')");     
           }     

          echo "The Data Is Inserted.";
          echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>"; 
          $this->load->library('email');
          $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.hostinger.com',
          'smtp_port' => 465,
          'smtp_user' => 'jobs@qlicksystems.com',
          'smtp_pass' => 'O?#f:Kc19#z',
          'smtp_crypto' => 'ssl',
          'mailtype'  => 'html', 
          'charset'   => 'iso-8859-1'
          );
          //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
          $messg = '<center>
          <img src="<?= base_url('assets/images/defaulticon.png'); ?>" alt="Wellbeing Scales" class="logo logo-dark">
          <h2> Hi there <h2>      
          <h3>Your User name is : '.$P_NID.' </h3>
          <h3>Your password is : '.$P_NID.' </h3>
          <a href="https://wellbeinggo.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          <p>Please Update Your Password !!</p>     
          </center>';


          $this->email->initialize($config); 
          $this->email->set_newline('\r\n');
          $this->email->from('jobs@qlicksystems.com','qlicksystems.com'); 
          $this->email->to($Email);
          $this->email->subject(' You User Name And Password ');
          $this->email->message($messg);
               
          if (!$this->email->send()) {
          echo $this->email->print_debugger();     
          echo 'We have an error in sending the email . Please try again later.';
          }else{
         echo "<script>Swal.fire({title: 'Success!',text: 'a Email Was Sended To The Email you Entred !',icon: 'success'});</script>";           
          echo "
          <script>
          location.href = '".base_url()."EN/schools/AddMembers';
          </script>
          ";     
          }
                
          }  
          }else{
               echo "The National ID already exists.";
          }     
          }else{
               echo "Please correct Your Date Of Birth";
          }    
             

               
          }else{
          echo validation_errors();
          }
               
          }

     }
     
     public function startUpdatingSchool(){
     // this function well get the infos from "add_level1_system" view .form id addSysteme .
     // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
          
          
          $this->load->library( 'form_validation' ); 
          if($this->input->post('Arabic_Title') && $this->input->post('English_Title')){
          $this->form_validation->set_rules( 'Arabic_Title', 'Arabic Title', 'trim|required' );
          $this->form_validation->set_rules( 'English_Title', 'English Title', 'trim|required' );
          $this->form_validation->set_rules( 'Manager_AR', 'Manager Arabic Name', 'trim|required' );
          $this->form_validation->set_rules( 'Manager_EN', 'Manager English Name', 'trim|required' );
          $this->form_validation->set_rules( 'Username', 'Username', 'trim|required' );
          $this->form_validation->set_rules( 'Phone', 'Phone', 'trim|required|numeric' );
          $this->form_validation->set_rules( 'Email', 'Email', 'trim|required|valid_email' );
          $this->form_validation->set_rules( 'Username', 'Username', 'trim|required' );
          $id = $this->input->post('ID');  
               
          if ( $this->form_validation->run() ) {
          if(is_numeric($id)){ 
          $Arabic_Title = $this->input->post('Arabic_Title');
          $English_Title = $this->input->post('English_Title');
          $Manager_AR = $this->input->post('Manager_AR');
          $Manager_EN = $this->input->post('Manager_EN');
          $Phone = $this->input->post('Phone');
          $Email = $this->input->post('Email');
          $username = $this->input->post('Username');
     
          $iscorrent = $this->db->query("SELECT *
          FROM `l1_school` WHERE username = '".$username."' AND Id != '".$id."' ")->result_array(); 
          if(empty($iscorrent)){     
          if($this->db->query("UPDATE l1_school
          SET School_Name_AR = '".$Arabic_Title."', School_Name_AR = '".$English_Title."', 
          Manager_EN = '".$Manager_EN."', Manager_AR = '".$Manager_AR."' , Email = '".$Email."', Phone = '".$Phone."' ,
          Username = '".$username."'
          WHERE id = '".$id."' ")){
               
          echo "<script>Swal.fire({title: 'Success!',text: 'The data is updated successfully.',icon: 'success'});</script>";           
               
          }
           }else{
               echo 'This User Name Is Already Used';
          }    
                          
          }else{
               echo "<script>
                    location.reload();
                    </script>";
          }     
    
          }else{
          echo validation_errors();
          }
               
          }     
     }
     
     public function AddClasses(){
               /////// adding classes
               $this->load->library( 'session' ); 
               $sessiondata = $this->session->userdata('admin_details');
               $clases = $this->input->post('Classes');
               $isExist = $this->db->query("SELECT * FROM l2_grades WHERE Id = '".$sessiondata['admin_id']."'")->result_array();
               $i = 0;
               $recent = array();
               $data = array();
               $classesnum = $this->db->query("SELECT * FROM `r_levels` ")->num_rows();
               $Val = '';
               for($i = 0;$i <= $classesnum;$i++){
               if(isset($clases[$i])){
                    $data["`".$i."`"] = '1';
                    $Val = $Val.$i.';';
               }else{
                    $data["`".$i."`"] = '0';
               }
               }
               echo $Val;
               if(empty($isExist)){
               $data['id'] = $sessiondata['admin_id'];
               $this->db->insert('l2_grades',$data);
               $this->db->query("INSERT INTO `v_schoolgrades` 
               (`S_id`, `Levels`, `Created`) VALUES ('".$sessiondata['admin_id']."', '".$Val."', '".date('Y-m-d')."');");
               echo "The data was inserted successfully.";    
               echo "<script>
               Swal.fire({title: 'Success!',text: 'The data is inserted successfully.',icon: 'success'});
               location.reload();     
               </script>";           
               }else{
               $this->db->query("UPDATE  `v_schoolgrades` SET `Levels` = '".$Val."' , `Created` = '".date('Y-m-d')."' WHERE 
               `S_id` = '".$sessiondata['admin_id']."' ");
               echo "The data was updated successfully.";    
               echo "<script>
               Swal.fire({title: 'Success!',text: 'The data is updated successfully.',icon: 'success'});
               location.reload();     
               </script>";   
                    
               $this->db->set($data);
               $this->db->where('id',$sessiondata['admin_id']);
               $this->db->update('l2_grades');
               }
     }
     
     public function startAddDevice(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $School_Id = $sessiondata['admin_id'];
          $this->load->library( 'form_validation' );
          if($this->input->post('Device_Id')){
          $Device_Id = $this->input->post('Device_Id');      
          $comments = $this->input->post("Comments"); 
          $conter = $this->db->query("SELECT * FROM `l2_devices` WHERE D_Id = '".$Device_Id."'")->num_rows(); 
          if($conter == 0){
          $this->db->query("INSERT INTO 
          `l2_devices` ( `D_Id`, `Added_by`, `Comments`, `Created`)
          VALUES ('".$Device_Id."', '".$School_Id."', '".$comments."', '".date('Y-m-d')."')");   
               echo "<script>
               Swal.fire({title: 'Success!',text: 'The device is added successfully.',icon: 'success'});
               location.reload();     
               </script>";   
          }else{
               echo "<script>
               Swal.fire({title: 'Error!',text: 'This Device Id is Already Exist !!',icon: 'error'});
               </script>";   
          }     
          }else{
               echo "<script>
               Swal.fire({title: 'Error!',text: 'Please Enter Valid Device Id',icon: 'error'});
               </script>";   
          }
     }
     
     public function startAddBatch(){
          $this->load->library( 'form_validation' );
          if($this->input->post('Batch')){
          $Batch = $this->input->post('Batch');      
          $ForDevice = $this->input->post("ForDevice"); 
          $conter = $this->db->query("SELECT * FROM `l2_batches` WHERE Batch_Id = '".$Batch."'")->num_rows(); 
          if($conter == 0){
          $this->db->query("INSERT INTO 
          `l2_batches` ( `Batch_Id`, `For_Device`,`Created`)
          VALUES ('".$Batch."', '".$ForDevice."', '".date('Y-m-d')."')");   
               echo "<script>
               Swal.fire({title: 'Success!',text: 'The Batch is Added successfully.',icon: 'success'});
               location.reload();     
               </script>";   
          }else{
               echo "<script>
               Swal.fire({title: 'Error!',text: 'This Batch Id is Already Exist !!',icon: 'error'});
               </script>";   
          }     
          }else{
               echo "<script>
               Swal.fire({title: 'Error!',text: 'Please Enter Valid Batch',icon: 'error'});
               </script>";   
          }
     }
     
     public function startAddSite(){
          $this->load->library( 'form_validation' ); 
          $this->form_validation->set_rules( 'Site', 'Site', 'trim|required' );
          $this->form_validation->set_rules( 'Description', 'Description', 'trim|required' );
          if ( $this->form_validation->run() ) {
          $Site = $this->input->post("Site");     
          $Description = $this->input->post("Description");    
          if($this->db->query("INSERT INTO 
          `l2_site` (`Site_Code`, `Description`, `Created`) 
          VALUES ('".$Site."', '".$Description."', '".date('Y-m-d')."')")){ ?>
               <script>
               Swal.fire({
                    title: 'Success!',
                    text: 'The data was inserted successfully.',
                    icon: 'success'
               });
               setTimeout(function(){
               location.reload();     
               },900);     
               </script>
<?php 
          }     
          }else{
          echo validation_errors();
          }
     }
     
     public function StartUpdateSite(){
          $this->load->library( 'form_validation' ); 
          $this->form_validation->set_rules( 'Description', 'Description', 'trim|required' );
          if ( $this->form_validation->run() ) {
          $Description = $this->input->post("Description");    
          $ID = $this->input->post("AZF_UFGFDX");    
          if($this->db->query("UPDATE `l2_site` SET `Description` = '".$Description."' WHERE `l2_site`.`Id` = $ID ")){ ?>
               <script>
               Swal.fire({
                    title: 'Success!',
                    text: 'The data was updated successfully.',
                    icon: 'success'
               });
               setTimeout(function(){
               location.href = "<?php echo base_url(); ?>EN/schools/listOfSites";     
               },900);     
               </script>
<?php

          }else{
               echo "error";
          }     
          }else{
          echo validation_errors();
          }
     }
     
     public function startAddPermition(){
           $this->load->library( 'form_validation' ); 
           if($this->input->post('selectedPerm')){
           $this->form_validation->set_rules( 'selectedPerm', 'User', 'trim|required' );
               
           if ( $this->form_validation->run() ) {
           $selectedPerm = $this->input->post('selectedPerm');   
           $ex_permition = explode(';',$selectedPerm);
           $Id = $ex_permition[0];     
           $Type = $ex_permition[1]; 
           if($Type == 'Staff' ){
          $this->db->query("UPDATE `l2_staff` SET PermSchool = 1 WHERE Id = '".$Id."'");
          echo "The permission was added.";      
          echo "<script>
          Swal.fire({
          title: 'Success!',
          text: 'The permission was added.',
          icon: 'success'
          });
          </script>";  ?> 
          <script>
               location.href = "<?php echo base_url();  ?>EN/schools";
          </script>
           <?php 
          }elseif($Type == 'Teacher' ){
          $this->db->query("UPDATE `l2_teacher` SET PermSchool = 1 WHERE Id = '".$Id."'");
          echo "The permission was added.";      
          echo "<script>
          Swal.fire({
          title: 'Success!',
          text: 'The permission was added.',
          icon: 'success'
          });
          </script>";  ?>          
          <script>
               location.href = "<?php echo base_url();  ?>EN/schools";
         </script>
           <?php 
           }else{
                echo "Please Select an User !";
           }     
                
           }else{
           echo validation_errors();
           }
               
          }else{
               echo "Please Select A Staff or Teacher !!";
          }
     }
     
     // ajax end tests start
     public function tests(){
          $this->load->library( 'session' ); 
          $sessiondata = $this->session->userdata('admin_details');
          $data['page_title'] = "Qlick Health | Tests";
          $data['sessiondata'] = $sessiondata;
          $this->load->view('EN/inc/header',$data);
          $this->load->view('EN/schools/Test');
          $this->load->view('EN/inc/footer');
     }

     
}//end extand     



