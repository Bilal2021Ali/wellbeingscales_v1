<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Driver extends CI_Controller
{
	
public function __construct()
{
    // date_default_timezone_set('Asia/Qatar');
    parent::__construct();

    $availableDatabases = [
        'QA' => 'dbQa',
        'JO' => 'dbJo',
        'KSA' => 'dbksa',
    ];

    $segment = $this->uri->segment(2);
    $db = 'default'; // Default database if no match found

    if (array_key_exists($segment, $availableDatabases)) {
        $db = $availableDatabases[$segment];
    }

    // Replace 'default' with your actual default database group name
    $this->db = $this->load->database($db, TRUE);

    error_reporting(0);
}

    
    public function userLogin(){
            $this->load->library('form_validation');
			$post = $this->input->post();
            if($post){
                $this->form_validation->set_rules('username', 'User Name', 'trim|required');
                $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[16]');
                
                    $username = $post['username'];
                    $password = $post['password'];

                    $getpas   = $this->db->query("SELECT Password FROM Staff_Ligin_Vehicle WHERE Username= '$username' AND Position IN ('Driver', 'Admin', 'Teacher') limit 1")->row_array();
                    if(password_verify($password,$getpas['Password'])){
                        $getdata  = $this->db->query(" SELECT  vl.* FROM `Staff_Ligin_Vehicle` AS vl WHERE vl.`Username` = '$username' AND vl.`Password` = '".$getpas["Password"]."'")->row_array();
 
                    	foreach($getdata as &$val){
                            $getdata['Adminname'] = (!empty($getdata['language'] == 'ar') ?  $getdata['Arabic_name'] :   $getdata['English_name']);
                            $getdata['Device'] = $getdata['Device'];
                            $getdata['PositionA'] = $getdata['Position'];
                   	    }
			unset($getdata['PASSWORD']);	
                        $message = [
                            'success' => '1',
                            'message' => 'login successfully!',
                            'details' => $getdata
                        ];
                    }else{
                        $message = [
                            'success' => '0',
                            'message' => 'Please enter valid login credentials!' 
                        ]; 
                    }
            }else{
                $message = [
                    'Success' => '0',
                    'message' => 'Username or password field are missing here'
                  ];
            }
            echo json_encode($message);
    }
    
    public function driverStudent(){
	$post = $this->input->post();
	if($post){
	        $query = $this->db->query("SELECT *,  (CASE WHEN (Time_rule > '".$post['deviceTime']."') THEN 0 ELSE 1  END) ShowLeave, (CASE WHEN ('".$post['language']."' = 'ar') THEN Arabic_Name ELSE English_Name END) `Name`  FROM `Student_Detail_Vehicle` WHERE Added_By = ".$post['addedBy']." AND  `car_id` = ".$post['carId']." ORDER BY Present ASC ")->result_array();
                   if($query){
                       $message = [
                           'success' => '1',
                           'message' => 'Data found successfully!',
                           'details' => $query
                       ];
                    }else{
                        $message = [
                            'success' => '0',
                            'message' => 'Data not found!'
                        ];
                    }
		}else{
			$message = [
                            'success' => '0',
                            'message' => 'Parameter missing!'
                        ];
		}
		echo json_encode($message);
    } 
    public function studentApiLinkDriver(){
        $get = $this->input->get();
	pre($get);die;
    }
    public function markStatusPresent(){
        $post = $this->input->post();
        if($post){
            $getid = $this->getStudentType(['student_id'=>$post['UserId']]);
            $data = [
                'UserId' => $getid['id'],
                'UserType' => $getid['usertype'],
                'Added_By' => 'Smart GateWay',
                'Result' => '0',
                'Symptoms' => '',
                'Device_Test' => 'Mobile Buss',
                'Created' => date('Y-m-d',strtotime($post['Created'])),
                'Time' => $post['Time'],
                'Action' => 'Shool',
                'Device' => $post['Device'],
                'battery_life' => '0',
                'Message_code'=> $post['Message_code'],
            ];
            $datasave = $this->db->insert('l2_gateway_result', $data);
            if($datasave){
                if($post['language'] == 'ar'){
                    $message = [
                        'success' => '1',
                        'message' => '!حفظ البيانات بنجاح'
                    ];
                } else{
                    $message = [
                        'success' => '1',
                        'message' => 'Data save have successfully!'
                    ];
                }
            }else{
                $message = [
                    'success' => '0',
                    'message' => 'Data are not save some problems!'
                ];
            }
        }else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
    }
     public function markStatusPresentDriver(){
        $post = $this->input->post();
        if($post){
            $getid = $this->getStudentType(['student_id'=>$post['UserId']]);
            $data = [
                'UserId' => $getid['id'],
                'UserType' => $getid['usertype'],
                'Added_By' => $post['Device'],
                'Result' => '0',
                'Symptoms' => '',
                'Device_Test' => 'School Tablet',
                'Created' => date('Y-m-d',strtotime($post['Created'])),
                'Time' => $post['Time'],
                'Action' => 'Shool',
                'Device' => $post['Device'],
                'battery_life' => '0',
                'Message_code' => $post['Message_code'],
            ];
            $datasave = $this->db->insert('l2_gateway_result', $data);
            if ($post['button'] == 1)
                $this->db->update('l2_vehicle_students', ['P_Buss_am'=> $post['Created']], ['student_id' => $post['UserId']]);
            else if ($post['button'] == 2)
                $this->db->update('l2_vehicle_students', ['Off_Buss_am'=> $post['Created']], ['student_id' => $post['UserId']]);
            else if ($post['button'] == 3)
                $this->db->update('l2_vehicle_students', ['P_Buss_pm'=> $post['Created']], ['student_id' => $post['UserId']]);
            else if ($post['button'] == 4)
                $this->db->update('l2_vehicle_students', ['Off_Buss_pm'=> $post['Created']], ['student_id' => $post['UserId']]);
            if($datasave){
                if($post['language'] == 'ar'){
                    $message = [
                        'success' => '1',
                        'message' => '!حفظ البيانات بنجاح'
                    ];
                } else{
                    $message = [
                        'success' => '1',
                        'message' => 'Data save have successfully!'
                    ];
                }
            }else{
                $message = [
                    'success' => '0',
                    'message' => 'Data are not save some problems!'
                ];
            }
        }else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
    }
    public function markStatusAbsent(){
        $post = $this->input->post();
        if ($post) {
            $rm = $this->db->query("(SELECT rm.* from `r_messages` AS rm where id = 10)")->row_array();
            $getid = $this->getStudentType(['student_id'=>$post['UserId']]);
		
            $data = [
                'UserId' => $getid['id'],
                'UserType' => $getid['usertype'],
                'DeviceType' => 'Mobile Buss',
                'Added_By' => 'Smart GateWay',
                'National_Id' => $getid['National_Id'],
                'Parent_NID_1' => $getid['Parent_NID'],
                'Parent_NID_2' => $getid['Parent_NID_2'],
                'Result' => 0,
                'Humidity' => 0,
                'Created' => date('Y-m-d',strtotime($post['Created'])),
                'Time' => $post['Time'],
                'Action' => 'Shool',
                'Device' => $post['Device'],
                'battery_life' => '0',
                'Message_AR' => $getid['Arabic_Name'].' '.$rm['message_ar'],
                'Message_EN' => $getid['English_Name'].' '.$rm['message_en'],
                'Message_code' => $rm['Id'],
            ];
            $datasave = $this->db->insert('v_notification_for_Mobile_app', $data);
            if($datasave){
                if($post['language'] == 'ar'){
                    $message = [
                        'success' => '1',
                        'message' => '!حفظ البيانات بنجاح'
                    ];
                } else{
                    $message = [
                        'success' => '1',
                        'message' => 'Data save have successfully!'
                    ];
                }
            }else{
                $message = [
                    'success' => '0',
                    'message' => 'Data are not save some problems!'
                ];
            }
        }else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
	echo json_encode($message);
    }
    public function studentAbsentMarkAll(){
        $post = $this->input->post();
        if($post){
            $rm = $this->db->query("(SELECT rm.* from `r_messages` AS rm where id = 10)")->row_array();
            if($post['Position'] == 'Driver')
                $getallabsent = $this->db->query("SELECT * FROM Student_Detail_Vehicle where Added_By = ".$post['addedBy']." AND  `car_id` = ".$post['carId']." and Present = 0")->result_array();
            else
                $getallabsent = $this->db->query("SELECT * FROM  Student_School_Class_Grade_v sscgv WHERE  added_by = '".$post['addedBy']."' AND sscgv.class_id = '".$post['class_id']."' AND sscgv.Grades ='".$post['Grades']."' AND Present = 0 ")->result_array();
            if(!empty($getallabsent)){
        	    foreach($getallabsent as $val){
                        $data = [
                        'UserId' => $val['id'],
                        'UserType' => $val['Position'],
                        'DeviceType' => 'Mobile Buss',
                        'Added_By' => 'Smart GateWay',
                        'National_Id' => $val['National_Id'],
                        'Parent_NID_1' => $val['Parent_NID'],
                        'Parent_NID_2' => $val['Parent_NID_2'],
                        'Result' => 0,
                        'Humidity' => 0,
                        'Created' => date('Y-m-d',strtotime($post['Created'])),
                        'Time' => $post['Time'],
                        'Action' => 'School',
                        'Device' => $post['Device'],
                        'battery_life' => '0',
                        'Message_AR' => $val['Arabic_Name'].' '.$rm['message_ar'],
                        'Message_EN' => $val['English_Name'].' '.$rm['message_en'],
                        'Message_code' => $rm['Id'],
                        ];
                        $datasave = $this->db->insert('v_notification_for_Mobile_app', $data);   
                }
		        if($post['language'] == 'ar'){
                    $message = [
                        'success' => '1',
                        'message' => '!حفظ البيانات بنجاح'
                    ];
                } else{
                    $message = [
                        'success' => '1',
                        'message' => 'Data save have successfully!'
                    ];
                }
            	
	    }else{
            	if($post['language'] == 'ar'){
                    $message = [
                        'success' => '0',
                        'message' => '!لم يتم العثور على بيانات'
                    ];
                } else{
                    $message = [
                        'success' => '0',
                        'message' => 'Data Not found!'
                    ];
                }
	    }
        }else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
    }
 public function markStatusLeave(){
        $post = $this->input->post();
        if ($post) {
            $rm = $this->db->query("(SELECT rm.* from `r_messages` AS rm where id = 8)")->row_array();
            // $getid = $this->getStudentType(['addedBy'=>$post['addedBy'],'carId'=>$post['carId'],'student_id'=>$post['UserId']]);
            $getid = $this->getStudentType(['student_id'=>$post['UserId']]);
		
            $data = [
                'UserId' => $post['UserId'],
                'UserType' => $getid['usertype'],
                'DeviceType' => 'Mobile Buss',
                'Added_By' => 'Smart GateWay',
                'National_Id' => $getid['National_Id'],
                'Parent_NID_1' => $getid['Parent_NID'],
                'Parent_NID_2' => $getid['Parent_NID_2'],
                'Result' => 0,
                'Humidity' => 0,
                'Created' => date('Y-m-d',strtotime($post['Created'])),
                'Time' => $post['Time'],
                'Action' => 'Shool',
                'Device' => $post['Device'],
                'battery_life' => '0',
                'Message_AR' => $getid['Arabic_Name'].' '.$rm['message_ar'],
                'Message_EN' => $getid['English_Name'].' '.$rm['message_en'],
                'Message_code' => $rm['Id'],
            ];
            $datasave = $this->db->insert('v_notification_for_Mobile_app', $data);
            if($datasave){
                if($post['language'] == 'ar'){
                    $message = [
                        'success' => '1',
                        'message' => '!حفظ البيانات بنجاح'
                    ];
                } else{
                    $message = [
                        'success' => '1',
                        'message' => 'Data save have successfully!'
                    ];
                }
            }else{
                $message = [
                    'success' => '0',
                    'message' => 'Data are not save some problems!'
                ];
            }
        }else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
	echo json_encode($message);
    }
    public function getSchoolClasses(){
        $post = $this->input->post();
        if(!empty($post)){
            if($post['Position'] == 'Admin'){
                 $where = ['added_by'=>$post['added_by'] ];
            }else{
                 $where = ['added_by'=>$post['added_by'], 'staff_id'=>$post['staff_id'] ];
            }
            $this->db->select("Class_Id, Class_ar, Class_en, Absent, (CASE WHEN ('".$post['language']."' = 'ar') THEN Class_ar ELSE Class_en END) `Class`");
            $this->db->from('school_classes_v');
            $this->db->where($where);
            $this->db->group_by('Class_Id, Class_ar, Class_en, Absent');
            $userresult = $this->db->get()->result_array();
            $message = [
                'success' => '1',
                'message' => 'Data found successfully!',
                'details' => $userresult
            ];
        } else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
        
    }
    public function getClassGrades(){
        $post = $this->input->post();
        if(!empty($post)){
            $userresult = $this->db->select('*')->from('school_class_grades_v')->where(['added_by'=>$post['added_by'],'class_id '=>$post['class_id']])->get()->result_array();
            $message = [
                'success' => '1',
                'message' => 'Data found successfully!',
                'details' => $userresult
            ];
        } else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
        
    }
    public function getSchoolClassGrades(){
        $post = $this->input->post();
        if(!empty($post)){
            $where = ['added_by'=>$post['added_by'], 'Grades'=>$post['Grades'], 'class_id'=>$post['class_id'] ];
            // $userresult = $this->db->select("*, (CASE WHEN ('".$post['language']."' = 'ar') THEN Arabic_Name ELSE English_Name END) `Name`")->from('Student_School_Class_Grade_v')->where($where)->get()->result_array();
            /*$userresult = $this->db->select("*, LEVEL AS leaveColor,(CASE WHEN (Time_rule > NOW()) THEN 0 ELSE 1  END) ShowLeave, (CASE WHEN (time_P IS NULL  AND time_l IS NULL) THEN 0 ELSE 1 END ) Day_absent, (CASE WHEN ('".$post['language']."' = 'ar') THEN Arabic_Name ELSE English_Name END) `Name`")->from('Student_School_Class_Grade_v')->where($where)->get()->result_array();*/
            $userresult = $this->db->select("*, (CASE WHEN ('".$post['language']."' = 'ar') THEN Arabic_Name ELSE English_Name END) `Name` ")->from('Student_School_Class_Grade_v')->where($where)->get()->result_array();
            $query = $this->db->last_query();
            $message = [
                'success' => '1',
                // 'query' => $query,
                'message' => 'Data found successfully!',
                'details' => $userresult
            ];
        } else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
        
    }
    public function updateLanguage(){
        $post = $this->input->post();
        if(!empty($post)){
            if($post['Position'] == 'Teacher'){
                $update = $this->db->update('l2_teacher', ['language'=>$post['language']], ['Id' => $post['staff_id']]);
            } else{
                $update = $this->db->update('l2_staff', ['language'=>$post['language']], ['Id' => $post['staff_id']]);
            }
            if ($update) {
                $message = [
                    'success' => '1',
                    'message' => 'Language updated succssfully'
                ];
            } else{
                $message = [
                    'success' => '0',
                    'message' => 'Issue in query'
                ];
            }
        } else{
            $message = [
                'success' => '0',
                'message' => 'Parameter are missing!'
            ];
        }
        echo json_encode($message);
    }
    public function getAllSchoolName(){
        $data = $this->db->select('id, School_Name_EN')->get('l1_school')->result_array();
        echo json_encode($data);
    }	
    public function getStudentType($data){
        if($data){
            // $getid = $this->db->query("SELECT * FROM `Student_Detail_Vehicle` WHERE Added_By = ".$data['addedBy']." AND  `car_id` = ".$data['carId']." AND id = ".$data['student_id']."")->row_array();
            $getid = $this->db->query("SELECT * FROM `users_detail_student` WHERE  id = '".$data['student_id']."' ")->row_array();
            return $getid;    
        }else{
            return false;
        }
    }
			
}