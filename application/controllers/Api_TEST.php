<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


class api extends CI_Controller {
	
  function __construct()
    {
       parent::__construct();
       $method = $_SERVER['REQUEST_METHOD'];
		    $this->config->set_item('language', 'arabic');
	  // if($method !== "POST"){
	//	   exit();
	  // }
     }     
     
     
    	public function Get_Parenrt() {
		$response = [ 
				'success' => '0',
				'message' => 'Details not found',
				'details' => [] 
		];
		if ($this->input->post ( 'National_id' )) {
			$national_id = $this->input->post ( 'National_id' );
			// $national_id = '27710007856';
			$kids = $this->db->select("F_name_EN,
                                F_name_AR,
                                M_name_EN,
                                M_name_AR,
                                L_name_EN,
                                L_name_AR,
                                National_Id,
                                Parent_NID,
                                watch_mac,
                                concat('".base_url('uploads/avatars/') ."',l2_avatars.Link) as Link, 'Student' type")
			->from( 'l2_student' )
			->join('l2_avatars',"l2_student.id = l2_avatars.For_User
				and l2_avatars.Type_Of_User ='Student'",'left')
			->where( "l2_student.Parent_NID = '$national_id'" )
			->get ()
			->result_array ();
			$visitor = $this->db->select("F_name_EN,
                                ifnull(F_name_AR,'') F_name_AR,
                                ifnull(M_name_EN,'') M_name_EN ,
                                ifnull(M_name_AR,'') M_name_AR,
                                ifnull(L_name_EN,'') L_name_EN,
                                ifnull(L_name_AR,'') L_name_AR,
                                National_Id,
                                Parent_NID,
                                watch_mac,
                                '' Link,
                                'visitor' type")
			->from('l2_visitors')
			->where("l2_visitors.Parent_NID = '$national_id'")
			->get()
			->result_array();
			$kids = array_merge($kids,$visitor);
            if ($kids) {
				$response ['success'] = '1';
				$response ['message'] = 'Record found successfully';
				$response ['details'] = $kids;
			}
		}
		echo json_encode ( $response );
	}
	public function Insert_Result_Temp() {
		$response = [ 
				'success' => '0',
				'message' => 'parameter missing' 
		];
		if ($this->input->post ( 'Result' ) &&
				$this->input->post ( 'Date' ) &&
				$this->input->post ( 'Time' ) &&
				$this->input->post ( 'id' )) {
			$data = [ 
					'UserId' 	=> $this->input->post ( 'id' ),
					'UserType' 	=> 'Student',
					'Added_By' 	=> 'Father',
					'Device' 	=> 2,
					'Result' 	=> $this->input->post ( 'Result' ),
					'Symptoms' 	=> $this->input->post ( 'Symptoms' ),
					'Created' 	=> $this->input->post ( 'Date' ),
					'Time' 		=> $this->input->post ( 'Time' ),
					'Action' 	=> 'School' ,
			    'battery_life'  => $this->input->post ( 'battery' )
			];
			
			if ($this->db->insert ( 'l2_result',$data )) {
				$response ['success'] = '1';
				$response ['message'] = 'Results Added Successfully';
			} else {
				$response ['message'] = 'There are sum problum with data';
			}
		}
		echo json_encode ( $response );
	}
	
	public function VisitorChildAdd(){
	    $record = json_decode(file_get_contents("php://input"), true);
	  
	    $response = [
	        'success' => '0',
	        'message' => 'parameter missing'
	    ];
	    if(!empty($record)){
	        $detail = $record['detail'];
	        $exist = $this->getRecoardForResult($this->input->post('National_Id'));
	        if($exist == false){
	            
	            $data = [
	                'Prefix'       => '',
	                'F_name_EN'    => $detail['name'],
	                'DOP'          => $detail['dob'],
	                'Phone'        => $detail['phone'],
	                'Gender'       => 0,
	                'Created'      => $detail['created'],
                    'UserName'     => $detail['name'],
	                'National_Id'  => $detail['nationalId'],
	                'Nationality'  => $record['countryName'],
	                'Position'     => 'Visitor',
	                'Email'        => '',
	                'Added_By'     => 'Mobile Apps',
	                'Latitude'     => '',
	                'Longitude'    => '',
	                'otp'          => 0,
	                'relation'     => $detail['relation'],
	                'Parent_NID'   =>$record['nationalId']	                
	            ];
	            if($this->db->insert('l2_visitors',$data)){
	                exit(json_encode(['success'=>'1','message'=>'child added successfully']));
	            }else{
	                exit(json_encode(['success'=>'0','message'=>'there are sum problum with data']));
	            }
	          
	        }
	        exit(json_encode(['success'=>'0','message'=>'Child already added']));
	    }
	    exit(json_encode(['success'=>'0','message'=>'reord not found']));
	}
	public function BindWatchMac() {
		$response = [
				'success' => '0',
				'message' => 'parameter missing'
		];
		if (!empty($this->input->post ( 'id' )) &&	!empty($this->input->post ( 'watch_mac' ))) {
					
					
			if ($this->db->update ( 'l2_student',
					['watch_mac'=>$this->input->post('watch_mac')],
					['Id'=>$this->input->post ( 'id' )])) {
						$response ['success'] = '1';
						$response ['message'] = 'Smart watch binded successfully';
					} else {
						$response ['message'] = 'There are sum problum with data';
					}
				}
				echo json_encode ( $response );
	}
	
	private function getRecoardForResult($nid){
	    $table = ['l2_teacher','l2_staff','l2_co_patient','l2_visitors'];
	    $tableType = ['l2_teacher'=>'Teacher','l2_staff'=>'Staff','l2_co_patient'=>'co_employee','l2_visitors'=>'Visitor'];
	    foreach ($table as $tab){
	        $id =  $this->db->select('*')->where('National_Id', $nid)->get($tab)->row();
	       
	        if(!empty($id) && $id->Id >0){
	            return ['id'=>$id->Id,'table'=>$tableType[$tab],'up_table'=>$tab,'mac'=>$id->watch_mac,'type'=>$id->UserType ?? ''];
	        }
	    }
	    return false;
	}
	
	private function getRecoardForGatHm($nid){
	    $table = ['l2_teacher','l2_staff','l2_student','l2_co_patient','l2_visitors'];
	    $tableType = ['l2_teacher'=>'Teacher','l2_staff'=>'Staff','l2_student'=>'Student','l2_co_patient'=>'co_employee','l2_visitors'=>'Visitor'];
	    foreach ($table as $tab){
	        $id = $this->db->select('*')->where('National_Id', $nid)->get($tab)->row();
	        
	        if(!empty($id->Id) &&  $id->Id >0){
	            return ['id'=>$id->Id,'table'=>$tableType[$tab],'type'=>$id->UserType ?? ''];
	        }
	    }
	    return false;
	}
	private function getRecoardForGatPass($key,$value){
	    $table = ['l2_teacher','l2_staff','l2_student','l2_co_patient','l2_visitors'];
	    $tableType = ['l2_teacher'=>'Teacher','l2_staff'=>'Staff','l2_student'=>'Student','l2_co_patient'=>'co_employee','l2_visitors'=>'Visitor'];
	    foreach ($table as $tab){
	        $id =  $this->db->select('*')->where($key, $value)->get($tab)->row();
	      
	        if(!empty($id->Id) &&  $id->Id >0){
	            return ['id'=>$id->Id,'table'=>$tableType[$tab],'type'=>$id->UserType ?? ''];
	        }
	    }
	    return false;
	}

    public function getWayResult()
    {
        $dataMac = json_decode(file_get_contents("php://input"), true);
        if (! empty($dataMac)) {
            foreach ($dataMac['obj'] as $list) {
                if (! empty($list['temp']) && $list['temp'] >25 && $list['temp'] <43 ) {
                    $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                    $exist = $this->getRecoardForGatPass('watch_mac', $list['dmac']);
                    
                    if ($exist !== false && $list['temp'] && $list['dmac'] && $exist['id']) {
                        if ($list['temp'] > 25 && $list['temp'] <= 26) {
                            $list['temp'] += 10;
                        } else if ($list['temp'] > 26 && $list['temp'] <= 27) {
                            $list['temp'] += 9.3;
                        } else if ($list['temp'] > 27 && $list['temp'] <= 28) {
                            $list['temp'] += 9;
                        } else if ($list['temp'] > 28 && $list['temp'] <= 29) {
                            $list['temp'] += 8.4;
                        } else if ($list['temp'] > 29 && $list['temp'] <= 30) {
                            $list['temp'] += 7.4;
                        } else if ($list['temp'] > 30 && $list['temp'] <= 31) {
                            $list['temp'] += 6.4;
                        } else if ($list['temp'] > 31 && $list['temp'] <= 32) {
                            $list['temp'] += 5.4;
                        } else if ($list['temp'] > 32 && $list['temp'] <= 33) {
                            $list['temp'] += 4.5;
                        } else if ($list['temp'] > 33 && $list['temp'] <= 40) {
                            $list['temp'] += 3.6;
                        }
//                         (3827/4130 )*100 =92.6%
                        
                        $data = [
                            'UserId'        => $exist['id'],
                            'UserType'      => $exist['table'],
                            'Added_By'      => 'Smart GateWay',
                            'Device'        => $dataMac['gmac'],
                            'Result'        => $list['temp'],
                            'Symptoms'      => '',
                            'Created'       => date('Y-m-d', strtotime($list['time'])),
                            'Time'          => date('h:i:s', strtotime($list['time'])),
                            'Action'        => 'School',
                            'battery_life'  => ((4130-$list['vbatt'])/480)*100
                        ];
                        $rs_table = 'l2_gateway_result';
                        if($exist['table'] == 'co_employee'){
                            $data['Action'] = 'work';
                            $data['UserType'] = $exist['type'];
                            $rs_table = 'l2_co_gateway_result';
                        }
                        
                        $this->db->insert($rs_table, $data);
                    }
                }
            }
            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
        }
       exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));
    }
	
	
	public function VisitorStaffResult(){
	    $response = [
	        'success' => '0',
	        'message' => 'parameter missing'
	    ];
	    if(!empty($this->input->post())){
	   $exist = $this->getRecoardForResult($this->input->post('National_Id'));
	   if($exist == false){
	       
	        $data = [
	            'Prefix'       => $this->input->post('Prefix'),
	            'F_name_EN'    => $this->input->post('F_name_EN'),
	            'DOP'          => $this->input->post('DOP'),
	            'Phone'        => $this->input->post('Phone'),
	            'Gender'       => $this->input->post('Gender'),
	            'Created'      => $this->input->post ( 'Date' ),
	            'UserName'     => $this->input->post('F_name_EN'),
	            'National_Id'  => $this->input->post('National_Id'),
	            'Nationality'  => $this->input->post('Nationality'),
	            'Position'     => 'Visitor',
	            'Email'        => $this->input->post('Email'),
	            'Added_By'     => 'Mobile Apps',
	            'Latitude'     => $this->input->post('Latitude'),
	            'Longitude'    => $this->input->post('Longitude'),    	           
	            'otp'          => 0,
	            'watch_mac'    => $this->input->post('watch_mac')
	            
	        ];	
	        $this->db->insert('l2_visitors',$data);
	        $id = $this->db->insert_id();
	        if($id<1){
	            $response ['message'] = 'There are sum problum with profile data';
	        }else{
	            
	        $exist = ['id'=>$id,'table'=>'Visitor'];
	        }
	   }
	   if($exist != false && (empty($exist['mac']) || $exist['mac'] == null || $exist['mac'] == 'Bind Watch' || $this->input->post('watch_mac') != $exist['mac']) ){
	       $this->db->update ( $exist['up_table'],
	           ['watch_mac'=>$this->input->post('watch_mac')],
	           ['Id'=>$exist['id']]);
	   }
	   $rs_table = 'l2_result';
	  
	   if ($this->input->post ( 'Result' ) &&
	       $this->input->post ( 'Date' ) &&
	       $this->input->post ( 'Time' ) &&
	       $exist['id']) {
	           
	           $data = [
	               'UserId' 	=> $exist['id'],
	               'UserType' 	=> $exist['table'],
	               'Added_By' 	=> 'Mobile Apps',
	               'Device' 	=> 2,
	               'Result' 	=> $this->input->post ( 'Result' ),
	               'Symptoms' 	=> $this->input->post ( 'Symptoms' ),
	               'Created' 	=> $this->input->post ( 'Date' ),
	               'Time' 		=> $this->input->post ( 'Time' ),
	               'Action' 	=> 'School',
	               'battery_life'  => $this->input->post ( 'battery' )
	           ];
	           
	           if($exist['table'] == 'co_employee'){
	               $rs_table = 'l2_co_result';
	               $data['Action']     = 'work';
	               $data['UserType'] 	= $exist['type'];
	           }
	           if ($this->db->insert ( $rs_table,$data )) {
	               $response ['success'] = '1';
	               $response ['message'] = 'Results added successfully';
	           } else {
	               $response ['message'] = 'There are sum problum with data';
	           }
	       }
	}
	 echo json_encode ( $response );
	}

	public function ResultHistory()
    {
        $response = [
            'success' => '0',
            'message' => 'parameter missing'
        ];
        if (! empty($this->input->post())) {
            $sDate = $this->input->post('StartDate');
            $eDate = $this->input->post('EndDate');
            $exist = $this->getRecoardForResult($this->input->post('National_Id'));
            if($exist == false){
                $response ['message'] = 'User not found';
            }else{
                $rs_table = 'l2_result';
                if($exist['table'] == 'co_employee'){
                    $rs_table = 'l2_co_result';
                    $exist['table'] = $exist['type'];
                }
            $result = $this->db->where('userId =' . $exist['id'] . ' 
                        AND UserType= "' . $exist['table'] . '" 
                        AND Created between "' . $sDate . '" 
                        AND "' . $eDate . '"')
                        ->order_by('Created','desc')
                  ->get($rs_table)
                ->result_array();
                if(count($result) == 0){
                    
                    $response ['message'] = 'No record found';
                }else{
                    $date =  array_unique(array_column($result, 'Created'));
         
                  $data = [];
                  foreach ($date as $dt){                     
                         $newList = ['title' => $dt];
                         foreach ($result as $list){
                             if($list['Created'] == $dt){
                                 
                                 $sm_result = "'" . str_replace(';', "','", $list['Symptoms'])."'";
                                 
                                 $list['Symptoms'] = str_replace(',',', ',$this->db->query("SELECT group_concat(symptoms_EN) as symptoms_EN FROM `r_symptoms` WHERE `code` in ($sm_result)")->row()->symptoms_EN);
                                $newList['items'][] =  $list;
                             }
                         }
                         
                         $data[]= $newList;
                         
                    }
                    if($data){
                        $response ['success'] = '1';
                        $response ['message'] = ' Rocord found successfully';
                        $response['details'] = $data;
                    }else{
                        $response ['message'] = 'No record found';
                        }
                }
            }
        }
        echo json_encode ( $response );
    }
    
    
    
    public function HealthMoniter(){
        $dataMac = json_decode(file_get_contents("php://input"), true);
//         error_log('test json '.print_r(file_get_contents("php://input"),true));
//        print_r($dataMac);
        $response = [
            'success' => '0',
            'message' => 'parameter missing'
        ];
        if(!empty($dataMac)){
            foreach ($dataMac as $key=>$list1){
                if(in_array($key, ['HMGlucose','HMBloodPressure','HMOximetry','HMTemperature'])){
                    $exist = $this->getRecoardForGatHm($list1['National_Id']);
//                 error_log('exist '.print_r($exist,true));
          
            $rs_table = 'l2_result';

            if ($exist != false && $exist['id'] ) {
                foreach ($list1 as $list){
                    if(!empty($list['dt'])){
                    $data = [
                        'UserId' 	=> $exist['id'],
                        'UserType' 	=> $exist['table'],
                        'Added_By' 	=> 'Mobile Apps',
                        'Device_Test'=>$key,
                        'Device' 	=> 2,
                        'Symptoms' 	=> '',
                        'Created' 	=> $list['dt'],
                        'Time' 		=> $list['time'],
                        'Action' 	=> 'School',
                    ];
                    
//                     if($key != 'HMBloodPressure'){
//                         $data['Blood_pressure_min']=$list['minimum'];
//                         $data['Blood_pressure_max']=$list['maximum'];
//                     }
                    if($key == 'HMGlucose'){
                        $data['Glucose'] = $list['value'];
                        $data['Result']  = $list['type'];
                    }
                    if($key == 'HMOximetry'){
                        $data['Heart_rate'] = $list['heart_rate_value'];
                        $data['Blood_oxygen']     = $list['bov'];
                    }
                    if($key=='HMTemperature'){
                        $data['Result']     = $list['value'];
                    }
                    if($key == 'HMBloodPressure'){
                        $data['Blood_pressure_min']=$list['systolic_pressure'];
                        $data['Blood_pressure_max']=$list['diatolic_pressure'];
                        $data['Heart_rate'] = $list['heart_rate'];
                    }
                    if($exist['table'] == 'co_employee'){
                        $rs_table = 'l2_co_result';
                        $data['Action']     = 'work';
                        $data['UserType'] 	= $exist['type'];
                    }
                   $insrt =  $this->db->insert ( $rs_table,$data );
                   if ($insrt) {
                        $return =  true;
                    } else {
                        $return = false;
                    }
                    }
                }
                }
            }
            }
            if(!empty($return)){
                if ($return) {
                    $response ['success'] = '1';
                    $response ['message'] = 'Results added successfully';
                } else {
                    $response ['message'] = 'There are sum problum with data';
                }
            }
        }
        echo json_encode ( $response );
    }
    
    private function getRecoardForRef($key,$value){
        $table = ['refrigerator_area'];
        $tableType = ['refrigerator_area'=>'mac_adress'];
        foreach ($table as $tab){
            $id =  $this->db->select('*')->where($key, $value)->get($tab)->row();
            
            if(!empty($id->Id) &&  $id->Id >0){
                return ['id'=>$id->Id,'table'=>$tableType[$tab],'type'=>$id->user_type ?? ''];
            }
        }
        return false;
    }
    public function getWayRefResult()
    {
        $dataMac = json_decode(file_get_contents("php://input"), true);
        if (! empty($dataMac)) {
            foreach ($dataMac['obj'] as $list) {
                if (! empty($list['temp'])  ) {
                    $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                    $exist = $this->getRecoardForRef('mac_adress', $list['dmac']);
                    if ($exist !== false && $list['temp'] && $list['dmac'] && $exist['id']) {
                
                        
                        $data = [
                            'Machine_Id'        => $exist['id'],
//                             'UserType'      => $exist['table'],
                            'Added_By'      => 'Smart GateWay',
//                             'Device'        => $dataMac['gmac'],
                            'Result'        => $list['temp'],
                            'Humidity'      => '',
                            'Created'       => date('Y-m-d', strtotime($list['time'])),
                            'Time'          => date('h:i:s', strtotime($list['time'])),
                            'Action'        => '',
                            'MAC_Device'  => $list['dmac']
                        ];
                        $rs_table = 'refrigerator_result_gateway';
//                         if($exist['table'] == 'co_employee'){
//                             $data['Action'] = 'work';
//                             $data['UserType'] = $exist['type'];
//                             $rs_table = 'l2_co_gateway_result';
//                         }
                        
                        $this->db->insert($rs_table, $data);
                    }
                }
            }
            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
        }
        exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));
    }
}

?>
