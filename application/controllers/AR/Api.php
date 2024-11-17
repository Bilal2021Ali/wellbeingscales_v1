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
			$kids = $this->db->select("l2_student.*,concat('".base_url('uploads/avatars/') ."',l2_avatars.Link) as Link")
			->from( 'l2_student' )
			->join('l2_avatars',"l2_student.id = l2_avatars.For_User
				and l2_avatars.Type_Of_User ='Student'",'left')
			->where( "l2_student.Parent_NID = '$national_id'" )
			->get ()
			->result_array ();
			
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
					'Action' 	=> 'School' 
			];
			
			if ($this->db->insert ( 'l2_result',$data )) {
				$response ['success'] = '1';
				$response ['message'] = 'Results added successfully';
			} else {
				$response ['message'] = 'هناك بعض المشاكل مع البيانات';
			}
		}
		echo json_encode ( $response );
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
						$response ['message'] = 'هناك بعض المشاكل مع البيانات';
					}
				}
				echo json_encode ( $response );
	}
	
	private function getRecoardForResult($nid){
	    $table = ['l2_teacher','l2_staff','l2_visitors'];
	    $tableType = ['l2_teacher'=>'Teacher','l2_staff'=>'Staff','l2_visitors'=>'Visitor'];
	    foreach ($table as $tab){
	        $id =  $this->db->select('id,watch_mac')->where('National_Id', $nid)->get($tab)->row();
	       
	        if(!empty($id) && $id->id >0){
	            return ['id'=>$id->id,'table'=>$tableType[$tab],'up_table'=>$tab,'mac'=>$id->watch_mac];
	        }
	    }
	    return false;
	}
	
	
	private function getRecoardForGatPass($key,$value){
	    $table = ['l2_teacher','l2_staff','l2_visitors','l2_student'];
	    $tableType = ['l2_teacher'=>'Teacher','l2_staff'=>'Staff','l2_visitors'=>'Visitor','l2_student'=>'Student'];
	    foreach ($table as $tab){
	        $id =  $this->db->select('id')->where($key, $value)->get($tab)->row()->id ?? 0;
	        if($id >0){
	            return ['id'=>$id,'table'=>$tableType[$tab]];
	        }
	    }
	    return false;
	}

    public function getWayResult()
    {
        $dataMac = json_decode(file_get_contents("php://input"), true);
        if (! empty($dataMac)) {
            foreach ($dataMac['obj'] as $list) {
                if (! empty($list['temp']) && $list['temp'] >29 && $list['temp'] <43 ) {
                    $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                    $exist = $this->getRecoardForGatPass('watch_mac', $list['dmac']);
                    
                    if ($exist !== false && $list['temp'] && $list['dmac'] && $exist['id']) {
                        
                        
                        
                       
                        if ($list['temp'] <= 31.4) {
                            $list['temp']+= 6;
                        } else if ($list['temp'] > 31.4 && $list['temp'] <= 32) {
                            $list['temp'] += 5;
                        } else if ($list['temp'] > 32 && $list['temp'] <= 33) {
                            $list['temp'] += 4.5;
                        } else if ($list['temp'] > 33 && $list['temp'] <= 40) {
                            $list['temp'] += 3;
                            }
                           
                        
                        $data = [
                            'UserId' => $exist['id'],
                            'UserType' => $exist['table'],
                            'Added_By' => 'Smart GateWay',
                            'Device' => $dataMac['gmac'],
                            'Result' => $list['temp'],
                            'Symptoms' => '',
                            'Created' => date('Y-m-d', strtotime($list['time'])),
                            'Time' => date('h:i:s', strtotime($list['time'])),
                            'Action' => 'School'
                        ];
                        $this->db->insert('l2_gateway_result', $data);
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
	            $response ['message'] = 'هناك بعض المشاكل مع البيانات';
	        }else{
	            
	        $exist = ['id'=>$id,'table'=>'Visitor'];
	        }
	   }
	   if($exist != false && (empty($exist['mac']) || $exist['mac'] == null || $exist['mac'] == 'Bind Watch') ){
	       $this->db->update ( $exist['up_table'],
	           ['watch_mac'=>$this->input->post('watch_mac')],
	           ['Id'=>$exist['id']]);
	   }
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
	               'Action' 	=> 'School'
	           ];
	           
	           if ($this->db->insert ( 'l2_result',$data )) {
	               $response ['success'] = '1';
	               $response ['message'] = 'Results added successfully';
	           } else {
	               $response ['message'] = 'هناك بعض المشاكل مع البيانات';
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
            $result = $this->db->where('userId =' . $exist['id'] . ' 
                        AND UserType= "' . $exist['table'] . '" 
                        AND Created between "' . $sDate . '" 
                        AND "' . $eDate . '"')
                ->get('l2_result')
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
                                 
                                 $list['Symptoms'] = $this->db->query("SELECT group_concat(symptoms_EN) as symptoms_EN FROM `r_symptoms` WHERE `code` in ($sm_result)")->row()->symptoms_EN;
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
}

?>
