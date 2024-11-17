<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_db2 extends CI_Model {
	
function insert_intable($natinal_id,$name,$gender,$phone,$email,$birthday,$group_id){
   $status = "";
   // Load database
   $db2 = $this->load->database('database2', TRUE);
    $exist = $db2->query("SELECT * FROM `tdx_person` WHERE `person_no` = '".$natinal_id."' LIMIT 1 ")->result_array();
	
	/*if($db2->query("INSERT INTO 
	`tdx_person` (`site_id`,`person_no`,`name`,`type`,`id_card`,`expire_time`,`create_user`,`deleted_flag`,`create_time`)
	 VALUES ('1','".$natinal_id."','".$name."','1','".$natinal_id."',NULL,'anonymousUser','0',now())")){
		$first = true;
	}
	if($db2->query("INSERT INTO 
	`tdx_employee` (`site_id`,`person_no`,`name`,`type`,`id_card`,`expire_time`,`create_user`,`gender`,`phone`,
	`deleted_flag`,`group_id`,`email`,`entry_date`,`attendance_flag`,`attendance_rule_id`,`temperature_alarm`,`create_time`)
	 VALUES ('1','".$natinal_id."','".$name."','1','".$natinal_id."',NULL,'anonymousUser','".$gender."','".$phone."',
	 '0','1','".$email."','".$birthday."','1','1','0',now())")){
		$second = true;
	}*/
	
	if($db2->query("INSERT INTO 
	`tdx_person` (`site_id`,`person_no`,`name`,`type`,`id_card`,`expire_time`,`create_user`,`deleted_flag`,`create_time`)
	 VALUES ('1','".$natinal_id."','".$name."','1','".$natinal_id."',NULL,'anonymousUser','0',now())")){
		$first = true;
	}
	
	$last_added = $db2->query("SELECT `Id` FROM `tdx_person` ORDER BY `Id` DESC LIMIT 1 ")->result_array();
	$l_id  = $last_added[0]['Id']; 
	
   if($db2->query("INSERT INTO 
	`tdx_employee` (`site_id`, `person_id` ,`group_id`,`gender`,`phone`,`email`,`birthday`,`entry_date`,
	`attendance_rule_id`,`attendance_flag`,`temperature_alarm`,`create_time`,`create_user`,`deleted_flag`)
	 VALUES ('1', '".$l_id."' ,'".$group_id."','".$gender."','".$phone."','".$email."','".$birthday."',now(),
	 '1','1','0',now(),'anonymousUser','0')")){
		$second = true;
	} 
	
	if(empty($exist)){
	if($first && $second){
		$status = "Inserted Successfuly";
	}else{
		$status = "Error";
	}
	}
    return $status;
 }

function  getlastid($type){
		  if($type == "Staff"){
		  $last_added = $this->db->query("SELECT `Id` FROM `l2_staff`   ORDER BY `Id` DESC LIMIT 1 ")->result_array();
		  }elseif($type == "Student" ){
		  $last_added = $this->db->query("SELECT `Id` FROM `l2_student` ORDER BY `Id` DESC LIMIT 1 ")->result_array();
		  }elseif($type == "Teacher"){
		  $last_added = $this->db->query("SELECT `Id` FROM `l2_teacher` ORDER BY `Id` DESC LIMIT 1 ")->result_array();
		  }
		  $l_id  = $last_added[0]['Id']; 
	      return($l_id);
}
	
	
function is_exist($national_id){
   $status = "";
   // Load database
   $db2 = $this->load->database('database2', TRUE);
   $exist = $db2->query("SELECT * FROM `tdx_person` WHERE `person_no` = '".$national_id."' LIMIT 1 ")->result_array();
   if(!empty($exist)){
	   $status = "Exist";
   }else{
	   $status = "No";
   }	
   return $status;
 }
	
function insert_result($national_id){
   $status = "";
   // Load database
   $db2 = $this->load->database('database2', TRUE);
   $exist = $db2->query("SELECT * FROM `tdx_person` WHERE `person_no` = '".$national_id."' LIMIT 1 ")->result_array();
   if(!empty($exist)){
	   $status = "Exist";
   }else{
	   $status = "No";
   }	
   return $status;
 }
 
/*

INSERT INTO dbps7tbvc25696.l2_result(TIMESTAMP,UserId,UserType,Added_By,Result,Symptoms,Device,Device_Test,Created,TIME,ACTION,Latitude,Longitude)  
 SELECT tdx_pass_record.create_time ,tdx_person.Ref_ID,tdx_person.Geted_from,tdx_pass_record.device_key,tdx_pass_record.temperature,'',0,'Temperature',tdx_pass_record.create_time,tdx_pass_record.create_time,'School',0.00000000,0.00000000
    FROM `tdx_pass_record`
 JOIN  `tdx_person` ON tdx_pass_record.person_id = tdx_person.id 
 WHERE tdx_pass_record.async=0;


*/	
	
	
function sync_two_databases(){
   $results_array = array();
   $db2 = $this->load->database('database2', TRUE);
   $all_values = $db2->query("SELECT * FROM `tdx_pass_record` WHERE `sync` = '0' ")->result_array();
   // 	tdx_pass_record 
   foreach($all_values as $val){
	   $Result = $val['temperature'];
	   $created = $val['create_time'];
	   $Device = $val['device_key'];
	   
	   $person = $db2->query("SELECT * FROM `tdx_person` WHERE `Id` = '".$val['person_id']."' ")->result_array();
	   foreach($person as $pers){
		   $n_id = $pers['person_no'];
		   $national_id_for = $this->db->query("SELECT `Geted_From` 
		   FROM `v_nationalids` WHERE `National_Id` = '".$n_id."' ")->result_array();
		   foreach($national_id_for as $from){
			  $getedFrom =  $from['Geted_From'];
			   if($getedFrom == "Staff"){
				   $user_data = $this->db->query(" SELECT * FROM `l2_staff` WHERE `National_id` = '".$n_id."' LIMIT 1")->result_array();
				   if(!empty($user_data)){
					  $user_id = $user_data[0]['Added_By'];
					  $Id = $user_data[0]['Id'];
				   }
			   }
			   //creat array 
			   $results_array[] = array("Result" => $Result,"Type" => $getedFrom ,
										"Created" => $created , "Added_By" => $user_id , "Id" => $Id , "Device_id" => $Device  );
		   }
	   }

   }

	$added = false;
	//print_r($results_array);
	/// Start Insert
	foreach($results_array as $sync){
		$Created = $sync['Created'];
		$date = explode(" ",$Created);
		if($this->db->query("INSERT INTO 
		`l2_result`( `UserId`, `UserType` , `Result`, `Created`, `Time`, `Device` , `Added_By` , `Action`) 
		VALUES ('".$sync['Id']."' , '".$sync['Type']."' , '".$sync['Result']."' , 
		'".$date[0]."' , '".$date[1]."' , '".$sync['Device_id']."' , 'SMARTPASS' ,'School' )")){
			$added = true;
		}
	}
	
	if($added){
		echo "Insret Was Success !!";
	}
	
	return($db2->query(" UPDATE `tdx_pass_record` SET  `sync` = '1' "));
	// SET * sync = 1 
    //$db2->query(" UPDATE `tdx_pass_record` SET  `sync` = '1' ");
	//return("Success");
}	
	
	
function sync_avatars($n_id,$type,$id){
$status = "";	
$db2 = $this->load->database('database2', TRUE);
$imglink = $n_id.".jpg";
$old_avatars = $db2->query("SELECT resource_url FROM `tdx_resource_data` WHERE resource_alias = '".$imglink."'
ORDER BY id DESC LIMIT 1 ")->result_array();	
	
foreach($old_avatars as $old_avatar){
$date = date("Y-m-d h:i:s");
/* Source File URL */
$remote_file_url = 'http://51.210.166.165:9000'.$old_avatar['resource_url'];
 	
$local_file = './uploads/avatars/'.$imglink;
 
$copy = copy( $remote_file_url, $local_file );
	
if( !$copy ) {
	$status = "Error";
}else{
	$isexist = $this->db->query(" SELECT Id FROM `l2_avatars` WHERE Type_Of_User = '".$type."' AND For_User = '".$id."' ")->result_array();
	if(empty($isexist)){
	$data = [ 
	  'For_User'     => $id,
	  'Type_Of_User' => $type,
	  'Link'         => $imglink,
	  'Created'      => $date,
	];
	$this->db->insert( 'l2_avatars', $data );
	}else{
	$dataup = [ 
	  'Link'     => $imglink,
	];
	$this->db->where('Id', $id);
	$this->db->where('For_User', $type);
	$this->db->insert( 'l2_avatars',$dataup );
	}
	
	$status = "success";
}
	
}	

return($status);	
}	
function sync_avatars_co($n_id,$type,$id){
$status = "";	
$db2 = $this->load->database('database2', TRUE);
$imglink = $n_id.".jpg";
$old_avatars = $db2->query("SELECT resource_url FROM `tdx_resource_data` WHERE resource_alias = '".$imglink."'
ORDER BY id DESC LIMIT 1 ")->result_array();	
	
foreach($old_avatars as $old_avatar){
$date = date("Y-m-d h:i:s");
/* Source File URL */
$remote_file_url = 'http://51.210.166.165:9000'.$old_avatar['resource_url'];
 	
$local_file = './uploads/co_avatars/'.$imglink;
 
$copy = copy( $remote_file_url, $local_file );
	
if( !$copy ) {
	$status = "Error";
}else{
	$isexist = $this->db->query(" SELECT Id FROM `l2_co_avatars` WHERE 
	Type_Of_User = '".$type."' AND For_User = '".$id."' ")->result_array();
	if(empty($isexist)){
	$data = [ 
	  'For_User'     => $id,
	  'Type_Of_User' => $type,
	  'Link'         => $imglink,
	  'Created'      => $date,
	];
	$this->db->insert( 'l2_co_avatars', $data );
	}else{
	$dataup = [ 
	  'Link'     => $imglink,
	];
	$this->db->where('Id', $id);
	$this->db->where('For_User', $type);
	$this->db->insert( 'l2_co_avatars',$dataup );
	}
	$status = "success";
}
	
}	

return($status);	
}
	
} 