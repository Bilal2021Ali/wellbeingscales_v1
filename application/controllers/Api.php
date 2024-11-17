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

     
    public function userLogin(){
        $this->load->library('form_validation');
        $post = $this->input->post();
        if($post){
            $this->form_validation->set_rules('username', 'User Name', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[16]');
            
                $username = $post['Username'];
                $password = $post['password'];
                $getpas   = $this->db->query("Select password from v_login where Username= '$username' and Type ='Staff' limit 1")->row_array();

                if(password_verify($password,$getpas['password'])){
                    $getdata  = $this->db->query("SELECT lvh.`staff_id`,vl.`Type`,lvh.`car_id` ,lvh.`Added_by`,
                                CONCAT(ls.`F_name_AR`,' ',ls.`L_name_AR`) Arabic_name,
                                CONCAT(ls.`F_name_EN`,' ',ls.`L_name_EN`) Arabic_name,
                                vl.`Username`,vl.`Password`
                                FROM `v_login` AS vl, `l2_vehicle_helpers` AS lvh,`l2_staff` AS ls
                                WHERE lvh.staff_id =ls.id
                                AND ls.UserName =vl.UserName
                                AND vl.`Username` = '$username'
                                ANd vl.`password` = '".$getpas["password"]."'
                                AND vl.Type ='Staff'")->row_array();

                    $message = [
                        'success' => 1,
                        'message' => 'Details found successfully!',
                        'details' => $getdata
                    ];
                }else{
                    $message = [
                        'success' => 1,
                        'message' => 'Details not found',
                        'details' => $getdata
                    ]; 
                }
        }else{
            $message = [
                'Success' => 0,
                'message' => 'Username or password field are missing here'
            ];
        }
        echo json_encode($message);
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

			

			if ($this->db->insert ( 'l2_gateway_result',$data )) {

				$response ['success'] = '1';

				$response ['message'] = 'Results Added Successfully!';

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

	                exit(json_encode(['success'=>'1','message'=>'child Added Successfully']));

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

	public function newGetWayResult()
    {
        $dataMac = json_decode(file_get_contents("php://input"), true);
        if (!empty($dataMac)) {
            foreach ($dataMac['obj'] as $list) {
             
                if (!empty($list['dmac'])) {

                    $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                    // $exist = $this->getRecoardForGatPass('watch_mac', $list['dmac']);
                    if (!empty($list['dmac'])){

                        if ($list['temp'] > 25 && $list['temp'] <= 46) {
                            $list['temp'] += 10;
                        }

                        $data = [
                           'Added_By'       => 'Smart GateWay',
                            // 'dData'         => $list['dData'],    
                            // 'AdvData'       => $list['advData'],
                            'Device'        => $dataMac['gmac'],
                            'Watch_Mac'     => $list['dmac'],
                            'Created'       => date('Y-m-d', strtotime($list['time'])),
                            'Time'          => date('h:i:s',strtotime($list['time'])),
                        ];
                        $rs_table = 'temp_ring_data';
                        $this->db->insert($rs_table, $data);
                    }
                }

            }

            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));

        }

       exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));

    }

    public function newGetWayResultRing()
    {
        $dataMac = json_decode(file_get_contents("php://input"), true);
        if (!empty($dataMac)) {
            foreach ($dataMac['obj'] as $list) {
             
                if (!empty($list['dmac'])) {

                    $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                     $exist = $this->getRecoardForGatPass('ring_mac', $list['dmac']);
                    if (!empty($list['dmac'])){

                        if ($list['temp'] > 25 && $list['temp'] <= 46) {
                            $list['temp'] += 10;
                        }

                          $data = [
                            'UserId'        => $exist['id'],
                            'UserType'      => $exist['table'],
                            'Added_By'      => 'Smart GateWay',
                            'Device'        => $dataMac['gmac'],
                            'Result'        => 0,
							'Symptoms'        => '',
							'Device_Test'        => '',
                            'Created'       => date('Y-m-d', strtotime($list['time'])),
                            'Time'          => date('h:i:s', strtotime($list['time'])),
                            'Action'        => 'School',
                            'battery_life'  => 0,
                            //'battery_life'  => ((($list['vbatt']-4130)/-480)*100)
                        ];
                        $rs_table = 'l2_gateway_result';
                        if($exist['table'] == 'co_employee'){
                            $data['Action'] = 'work';
                            $data['UserType'] = $exist['type'];
                            $rs_table = 'l2_co_gateway_result';
                        }
                        if ($exist['table'] == 'Visitor') {
                            $data['Action'] = 'Visitor';
                            $data['UserType'] = 'Visitor';
                            $rs_table = 'l2_visitors_gateway_result';
                        }
                        $this->db->insert($rs_table, $data);
                    }
                }
            }
            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
        }
       exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));
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

                            'battery_life'  => (($list['vbatt']-4130)/480)*100

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

	   $rs_table = 'l2_gateway_result';

	  

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

	               $rs_table = 'l2_co_gateway_result';

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

                $rs_table = 'l2_gateway_result';

                if($exist['table'] == 'co_employee'){

                    $rs_table = 'l2_co_gateway_result';

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

          

            $rs_table = 'l2_gateway_result';



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

                        /*$data['Blood_pressure_min']=$list['systolic_pressure'];
                        $data['Blood_pressure_max']=$list['diatolic_pressure'];
                        $data['Heart_rate'] = $list['heart_rate'];*/

                        $data['Blood_pressure_min']=$list['diatolic_pressure'];
                        $data['Blood_pressure_max']=$list['systolic_pressure'];
                        $data['Heart_rate'] = $list['heart_rate'];

                    }

                    if($exist['table'] == 'co_employee'){

                        $rs_table = 'l2_co_gateway_result';

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

    public function updateSaveRecord()
    {
        $record = json_decode(file_get_contents("php://input"), true);
        $exist = $this->getRecoardForGatHm($record['National_Id']);
       
        if ($exist && $exist['id'] != null) {
            
            if($record['weight'] != ''){
                               
                if ($exist['table'] == 'co_employee') {
                    $data = [
                        'UserId'    => $exist['id'],
                        'UserType'    => $exist['type'],
                        'Added_By'    => 'Mobile Apps',
                        'Result'    => 0,
                        'weight'    => $record['weight'],
                        'Symptoms'  => '',
                        'Device_Test'  => 'Digitalscale',
                        'Created'  => $record['date'],
                        'Time'  => $record['Time'],
                        'Action' => 'work'
                    ];
                    $rs_table = 'l2_co_gateway_result';
                }
                if ($exist['table'] != 'co_employee') {
                    $rs_table = 'l2_gateway_result';
                    $data = [
                        'UserId'    => $exist['id'],
                        'UserType'    => $exist['type'],
                        'Added_By'    => 'Mobile Apps',
                        'Result'    => 0,
                        'weight'    => $record['weight'],
                        'Symptoms'  => '',
                        'Device_Test'  => 'Digitalscale',
                        'Created'  => $record['date'],
                        'Time'  => $record['Time'],
                        'Action' => 'School'
                    ];
                    
                }
                $post = $this->db->insert($rs_table, $data);
				json_encode(print_r($post));die;
                return json_encode([
                    'success' => '1',
                    'message' => 'Data are successfully updated.!'
                ]);    
            }else{
                return json_encode([
                    'success' => '0',
                    'message' => 'Data are not found required in nationalId.!'
                ]);    
            }
        }
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

    public function checkMyTestResult(){
    	// created by pk for some thing test

    	/*$table = ['refrigerator_area'];
        $tableType = ['refrigerator_area'=>'mac_adress'];
        foreach ($table as $tab){
        	$id =  $this->db->select('*')->where('mac_adress', 'DD:34:02:05:D8:C4')->get($tab)->row();
        	print_r($id);
        }*/


            

    	$exist = $this->getRecoardForRef('mac_adress', 'DD:34:02:05:D8:C4');
    	print_r($exist);
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

                            'user_type'      => $exist['type'],

                            'Added_By'      => 'Smart GateWay',

//                             'Device'        => $dataMac['gmac'],

                            'Result'        => $list['temp'],

                            'Humidity'      => $list['humidty'],

                            'Created'       => date('Y-m-d', strtotime($list['time'])),

                            'Time'          => date('h:i:s', strtotime($list['time'])),

                            'Action'        => '',
                            
                            // 'raw_data'        => $list,

                            'MAC_Device'  => $list['dmac']

                        ];

                        $rs_table = 'refrigerator_result_gateway';

//                         if($exist['table'] == 'co_employee'){

//                             $data['Action'] = 'work';

//                             $data['UserType'] = $exist['type'];

//                             $rs_table = 'l2_co_gateway_result';

//                         }

                        

                        $this->db->insert($rs_table, $data);
                        $insert_id = $this->db->insert_id();
                        // $this->db->update($rs_table, ['raw_data'=>print_r($dataMac, true)],['Id'=>$insert_id]);

                    }

                }

            }

            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0", "success" => "1"]));

        }

        exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1", "success" => "0"]));

    }

    private function getRecoardForVehicles($key,$value){
        $table = ['l2_vehicle'];
        $tableType = ['l2_vehicle'=>'vehicle'];
        foreach ($table as $tab){
            $id =  $this->db->select('*')->where($key, $value)->get($tab)->row();
            
            if(!empty($id->Id) &&  $id->Id >0){
                return ['id'=>$id->Id,'table'=>$tableType[$tab],'type'=>$id->Action ?? ''];
            }
        }
        return false;
    }

    public function sendTemperatureVehicles()
        {
            $dataMac = json_decode(file_get_contents("php://input"), true);
            if (! empty($dataMac)) {
                foreach ($dataMac['obj'] as $list) {
                    if (! empty($list['temp'])  ) {
                        $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                        $exist = $this->getRecoardForVehicles('watch_mac', $list['dmac']);
                        if ($exist !== false && $list['temp'] && $list['dmac'] && $exist['id']) {
                            
                            
                            $data = [
                                'VehicleId'        => $exist['id'],
                                'UserType'      => $exist['type'],
                                'Added_By'      => 'Smart GateWay',
                                'Device'        => $dataMac['gmac'],
                                'Result'        => $list['temp'],
                                'Humidity'      => $list['Humidity'] ?? 0,
                                'Created'       => date('Y-m-d', strtotime($list['time'])),
                                'Time'          => date('h:i:s', strtotime($list['time'])),
                                'Action'        => '',
//                                 'MAC_Device'  => $list['dmac']
                            ];
                            $rs_table = 'l2_vehicles_gateway_result';
                            
                            $this->db->insert($rs_table, $data);
                        }
                    }
                }
                exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
            }
            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));
        }

        private function getRecoardForAny($key,$value){
            $table = ['l2_teacher','l2_staff','l2_student','l2_co_patient','l2_visitors','refrigerator_area','refrigerator_visitor','l2_vehicle'];
            $tableType = ['l2_teacher'=>'Teacher','l2_staff'=>'Staff','l2_student'=>'Student','l2_co_patient'=>'co_employee','l2_visitors'=>'Visitor','refrigerator_area'=>'company_department','refrigerator_visitor'=>'RVisitor','l2_vehicle'=>'vehicle'];
            foreach ($table as $tab){
                $id =  $this->db->select('*')->where($key, $value)->get($tab)->row();
              
                if(!empty($id->Id) &&  $id->Id >0){
                    return ['id'=>$id->Id,'table'=>$tableType[$tab],'type'=>$id->UserType ?? ''];
                }
            }
            return false;
        }

        public function notification_for_Mobile_app(){
            $dataMac = json_decode(file_get_contents("php://input"), true);
                if(!empty($this->input->get())){
                   $get = $this->input->get();
                  //  print_r($get);
                 $post = [
                   'RecId' => $get['ID'],
                   'nationId' => $get['National_Id'],
                   'parentnationalId' =>  $get['Parent_NID_1']
                  
                 ];
                     $curl = curl_init();                
                     curl_setopt_array($curl, array(
                     CURLOPT_URL => 'https://qlickhealth.com/admin/index.php/api/user/PushNotificationOffOn',
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_ENCODING => '',
                     CURLOPT_MAXREDIRS => 10,
                     CURLOPT_TIMEOUT => 0,
                     CURLOPT_FOLLOWLOCATION => true,
                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                     CURLOPT_CUSTOMREQUEST => 'POST',
                     CURLOPT_POSTFIELDS =>json_encode($post),
                     ));
                     
                     $return = curl_exec($curl);
                     //echo $return;die;
                     curl_close($curl);
                     if(!empty($return)){
                         if ($return) {
                             $response ['success'] = '1';
                             $response ['message'] = 'Results added successfully';
                             //$response['return']	  = $return;
     
                              exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
                         } else {
                             $response ['message'] = 'There are sum problum with data';
                             exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));
                         }
                     }
                 }else{
                     $response ['success'] = '0';
                     $response ['message'] = 'There are parameters missing';
                 }
                 echo json_encode ( $response );
         }

         public function sendAQI()
         {  if(!empty($this->input->get())){
               $get = $this->input->get();
             //  print_r($get);
             $data = [
              'Temperature' => $get['Temperature'],
               'humidity'   => $get['humidity'],
               'carbon_dioxide' =>  $get['carbon_dioxide'],
               'pm2_5' => $get['pm2_5'],
               'formaldehydea' => $get['formaldehyde'],
               'AQI' => $get['AQI'],
               'Device_Mac' =>$get['Device_Mac']
              ];  
             print_r($data);
                 $rs_table = 'air_result_aqi';
                 
                 
                 $post = $this->db->insert($rs_table, $data);
               
                 
                 if(!empty($return)){
                     if ($return) {
                         $response ['success'] = '1';
                         $response ['message'] = 'Results added successfully';
                         
                     } else {
                         $response ['success'] = '0';
                         $response ['message'] = 'There are parameters missing';
                         
                     }
                 }
         
         }
         exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
         
         
         }

         public function test(){
     
            $get = $this->input->get();
                    //  print_r($get);
                   $post = [
                     'RecId' => $get['ID'],
                     'nationId' => $get['National_Id'],
                     'parentnationalId' =>  $get['Parent_NID_1']
                    
                   ];
                   
                   /*$insrt  =  	$this->db->insert ( $rs_table,$post_data );
                   $select = 	$this->db->select("*");
                               $this->db->from('v_notification_for_Mobile_app');
                               $this->db->where('ID' ,$insrt->ID);
                               $this->db->order_by('ID desc');
                   $last_id =	$this->db->insert_id();
                   $post = [
                     'RecId' => $select->ID,
                     'nationId' => $select->National_Id,
                     'parentnationalId' =>  $select->Parent_NID_1
                   ];*/
       
       include "connection.php";
       //curl header
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
       //the url for api
       $url ='https://qlickhealth.com/admin/index.php/api/user/PushNotificationOffOn';
       curl_setopt($ch, CURLOPT_URL, $url);
       // Set the CURLOPT_RETURNTRANSFER option to true
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       // Set the CURLOPT_POST option to true for POST request
       curl_setopt($ch, CURLOPT_POST, true);
       // Set the request data as JSON using json_encode function
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
       
       $result = curl_exec($ch);
       print_r($url);
       print_r($post);
       curl_close($ch);
       //print the results
       $obj = json_decode($result);
       //print_r($obj);
           return json_encode ( $response );	
           }

           public function test1(){
            if(!empty($this->input->get())){
           $get = $this->input->get();
                  //  print_r($get);
                 $post = [
                   'RecId' => $get['ID'],
                   'nationId' => $get['National_Id'],
                   'parentnationalId' =>  $get['Parent_NID_1']
                  
                 ];
                   //print_r($post);
                 $data_string = json_encode($post);
                 print_r($data_string);
            /* $curl = curl_init();
             curl_setopt_array($curl, array(
                 CURLOPT_URL => 'https://qlickhealth.com/admin/index.php/api/user/PushNotificationOffOn',
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_ENCODING => '',
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 0,
                 CURLOPT_FOLLOWLOCATION => true,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => 'POST',
                 CURLOPT_POSTFIELDS => $data_string,
                 CURLOPT_HTTPHEADER => array(
                     'Content-Type: application/json'
                 ),
                 
             )*/
             
             $curlOptions = [
         CURLOPT_URL => 'http://example.com/upload.php',
         CURLOPT_POST => true,
         CURLOPT_HEADER => false,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_POSTFIELDS => $data_string,
     ];
     
     $ch = curl_init();
     curl_setopt_array($ch, $curlOptions);
     
     $response = curl_exec($ch);
             
             // );
             //print_r($curl);
            // $response = curl_exec($curl);
            // print_r($response);
             
             //curl_close($curl);
             }
             return false;
         }
         
         public function PusherNotificationInOut(){
         	$post = array();
            // include "connection.php";
            //curl header
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            //the url for api
            $url ='https://qlickhealth.com/admin/index.php/api/QA/services/PusherNotificationInOut';
            curl_setopt($ch, CURLOPT_URL, $url);
            // Set the CURLOPT_RETURNTRANSFER option to true
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the CURLOPT_POST option to true for POST request
            curl_setopt($ch, CURLOPT_POST, true);
            // Set the request data as JSON using json_encode function
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            
            $result = curl_exec($ch);
            print_r($url);
            print_r($post);
            curl_close($ch);
            //print the results
            $obj = json_decode($result);
            //print_r($obj);
                return json_encode ( $obj );	
                }
            
                public function ReadGate()
    {
        $post =json_decode(file_get_contents("php://input"), true);
        error_log('log gateway '.print_r( $post,true));
        exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
    }

    public function getWayAnyResult()
        {
            $dataMac = json_decode(file_get_contents("php://input"), true);
            if (! empty($dataMac)) {
                foreach ($dataMac['obj'] as $list) {
                    if (! empty($list['temp'])  ) {
                        $list['dmac'] = implode(':', str_split($list['dmac'], 2));
                        $exist = $this->getRecoardForAny('watch_mac', $list['dmac']);
                        if ($exist !== false && $list['temp'] && $list['dmac'] && $exist['id']) {
                            
                            
                             $data = [
                            'Added_By'      => 'Smart GateWay',
                            'Result'        => $list['temp'],
                            'Created'       => date('Y-m-d', strtotime($list['time'])),
                            'Time'          => date('h:i:s', strtotime($list['time'])),
                            'battery_life'  => ((($list['vbatt']-4130)/-480)*100)
			 ];
                        if ($exist['table'] == 'vehicle') {
			    $data['VehicleId' ] = $exist['id'];
			    $data['Device' ] = $dataMac['gmac'];
                            $data['Action'] = '';
                            $data['UserType'] = $exist['type'];
			    $data['Humidity' ] = $list['humidity'] ?? 0;
                            $rs_table = 'l2_vehicles_gateway_result';
                        }
                            $this->db->insert($rs_table, $data);
                        }
                    }
                }
                exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"0"]));
            }
            exit(json_encode(["msg"=>"advRsp","ctype"=>"1","cause"=>"1"]));
        }



    public function speakOutDataSave(){
        //$data = json_decode(file_get_contents("php://input"), true);
        $data = $this->input->post();  

        if(!empty($data)){
            $userinfo = $this->db->select('*')->from('User_Detail_WellBeing_App')->where(['Username'=>$data['Username']])->get()->row_array();
            if(!empty($userinfo)){
                $getids   = $this->db->select('*')->from('sv_set_template_lifereports_choices')->where(['id'=>$data['Id']])->get()->row_array();
                $datasave = [
                    'TimeStamp'      => date('Y-m-d H:i:s',strtotime($data['Date'].$data['Time'])),
                    'group_id'       => $getids['group_id'],
                    'type_id'        => $getids['Id'],
                    'user_id'        => $userinfo['UserId'],
                    'description_en' => $data['description_en'],
                    'description_ar' => $data['description_ar'],
                    'Added_by'       => 'Mobile Apps',
                    'show_user_name' => $data['show'],
                     
                ];
                if($this->db->insert('l3_mylifereports',$datasave)){
                    if(!empty($_FILES['mobileappspeakout']['name'])){
                        $imagedata = ['file'=>$_FILES,'id'=>$this->db->insert_id(),'datetime'=>$datasave['TimeStamp']];
                        $upload = $this->mediaUpload($imagedata);
                        $message = $upload;
                    }else{
                        $message['success'] = '1';
                        $message['message'] = 'Data are add successfully !';
                    } 
                }else{
                    $message['success'] = '0';
                    $message['message']  = 'Data are not saved !';
                }
            }else{
                $message['success'] = '0';
                $message['message']  = 'User not found!';
            }
        }else{
            $message['success'] = '0'; 
            $message['message']  = 'Some parameter are the missing here filled agained !';
        }
        echo json_encode($message);
    }
    
    private function mediaUpload($data){
        if (!empty($data['file']['mobileappspeakout'])) {
            $error = $data['file']['mobileappspeakout']["error"];
            $ext = pathinfo($data['file']['mobileappspeakout']['name'], PATHINFO_EXTENSION);
            $name1 = $data['datetime'].'_mobileappspeakout.'.$ext;
            $name = str_replace(' ', '_', $name1);
            $liciense_tmp_name = $data['file']['mobileappspeakout']["tmp_name"];
            $liciense_path = 'uploads/Mylifereportsmedia/'.$name;
            $upload = move_uploaded_file($liciense_tmp_name, $liciense_path);
            if($upload > 0){
                $datasave = [
                    'TimeStamp' => $data['datetime'],
                    'report_id' => $data['id'],
                    'file' => $name
                ];
                if($this->db->insert('l3_mylifereportsmedia',$datasave)){
                    
                        $message['success'] = '1';
                        $message['message'] = 'Data are add successfully !';
                }else{
                    $message['success'] = '0';
                    $message['message'] = 'Image not add !';
                }
            }else{
                $message['success'] = '0';
                $message['message'] = 'Image not add !';
            }    
        }else{
            $message['success'] = '0';
            $message['message'] = 'Image parameter are the missing here !';
        }
        return $message;
    }

    public function avatarUplaodProfile(){
        $data = json_decode(file_get_contents("php://input"), true);
        $checkuser = $this->db->get_where('users_detail',['National_Id'=>$data['nationalId']])->row_array();
        $ext  = pathinfo(parse_url($data['url'], PHP_URL_PATH),PATHINFO_EXTENSION); 
        $file = $data['nationalId'].'_'.date('Y-m-d-H:i:s').'.'.$ext;
        
        $content = file_get_contents($data['url']);
        $fields  = [
            'For_User' => $checkuser['id'],
            'link'     => $file,
            'Type_Of_User' => $checkuser['usertype'],
            'Created' => date('Y-m-d H:i:s'),
            'TimeStamp' => date('Y-m-d H:i:s'),
            'added_by'  => "Mobile Apps"
        ];
        if($checkuser['Action'] == 'co_company'){
            $table = 'l2_co_avatars';
            $put   = file_put_contents('uploads/co_avatars/'.$file, $content);
        }elseif($checkuser['Action'] != 'co_company'){
             $table = 'l2_avatars';
            $put = file_put_contents('uploads/avatars/'.$file, $content);
        }else{
            $message['success'] = '0';
            $message['message'] = 'User are not fount';
        }
        
        if(!empty($this->db->get_where($table,['For_User'=>$checkuser['id'],'type_of_user'=>$checkuser['usertype']])->row_array())){
            $savedata = $this->db->update($table,['link'=>$file,'timestamp'=>DATE('Y-m-d H:i:s'),'added_by'=>$fields['added_by']],['For_User'=>$checkuser['id'],'type_of_user'=>$checkuser['usertype']]);
	    $message['table'] = $table;
            $message['status'] = "UPDATED";
        }else{
            $savedata = $this->db->insert($table,$fields);
	    $message['table'] = $table;
            $message['status'] = "INSERT";
        }
        if(!empty($savedata)){
             $message['success'] = '1';
             $message['message'] = 'Imaged are copied & data are successfully for the tracksystem !';
        }else{
            $message['success'] = '1';
            $message['message'] = 'Imaged are not copied & data for the tracksystem !';
        }
        echo json_encode($message);
     }

     public function VisitorChildAddInQlickhealth(){
	    $record = json_decode(file_get_contents("php://input"), true);
	  
	    $response = [
	        'success' => '0',
	        'message' => 'parameter missing'
	    ];
	    if(!empty($record)){
	        $detail = $record['detail'];
                $exist = $this->db->get_where('users_detail',['National_Id'=>$detail['nationalId']])->row_array();
                
                $ext  = pathinfo(parse_url($detail['avatar'], PHP_URL_PATH),PATHINFO_EXTENSION); 
                $file = $detail['nationalId'].'_'.$detail['created'].'.'.$ext;
                $content = file_get_contents($detail['avatar']); 
                $put   = file_put_contents('uploads/avatars/'.$file, $content);
	        if($exist == false){
	            
	            $data = [
	                'Prefix'       => '',
	                'F_name_EN'    => $detail['name'],
	                'DOP'          => $detail['dob'],
	                'Phone'        => $detail['phone'],
	                'TimeStamp' => $detail['created'],
                        'Created'      => $detail['created'],
	                'Gender'       => 0,
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
	            if($this->db->insert('l2_visitors',$data))
                        if ($detail['avatar'] != null && ! empty($detail['avatar'])) {
                        $id = $this->db->insert_id();
                        $this->db->insert('l2_avatars', [
                            'For_User' => $id,
                            'Link' => $file,
                            'Type_Of_User' => $exist['usertype'],
                            'TimeStamp' => $detail['created'],
                            'Created' => $detail['created'],
                            'Added_By'     => 'Mobile Apps'
                        ]);
	                exit(json_encode(['success'=>'1','message'=>'child added successfully']));
	            }else{
	                exit(json_encode(['success'=>'0','message'=>'there are sum problum with data']));
	            }
	          
	        }elseif($exist == true){
	            $avatar = $this->db->get_where('l2_avatars',['For_User'=>$exist['id'],'Type_Of_User'=>$exist['usertype'] ])->row_array();
	            if(!empty($avatar)){
	                $this->db->update('l2_avatars', [
                            'For_User' => $exist['id'],
                            'Link' => $file,
                            'Type_Of_User' => $exist['usertype'],
                            'TimeStamp' => $detail['created'],
                            'Added_By'     => 'Mobile Apps'
                        ],['For_User' => $exist['id'],'Type_Of_User'=>$exist['usertype']]);
                        exit(json_encode(['success'=>'1','message'=>'Child are updated']));
	            }else{
                      $this->db->insert('l2_avatars', [
                        'For_User' => $exist['id'],
                        'Link' => $file,
                        'Type_Of_User' => 'Visitor',
                        'TimeStamp' => $detail['created'],
                        'Created' => $detail['created'],
                        'Added_By'     => 'Mobile Apps'
                    ]);
                    exit(json_encode(['success'=>'1','message'=>'Child are added']));
	            }
	        
	        }
	    }
	    exit(json_encode(['success'=>'0','message'=>'reord not found']));
	}


    public function bindTrackSystemRing(){
        $dataMac = json_decode(file_get_contents("php://input"), true);
        if(!empty($dataMac)){
            $exist = $this->getRecoardForGatHm($dataMac['NationalId']);
            $ring_mac = $dataMac['ring_mac'];
            if ($exist !== false) {
                if ($exist['table'] == 'co_employee') {
                    $this->db->update('l2_co_patient', ['ring_mac'=>$ring_mac], ['National_Id'=>$dataMac['NationalId']]);
                } elseif ($exist['table'] == 'Teacher') {
                    $this->db->update('l2_teacher', ['ring_mac'=>$ring_mac], ['National_Id'=>$dataMac['NationalId']]);
                } elseif ($exist['table'] == 'Staff') {
                    $this->db->update('l2_staff', ['ring_mac'=>$ring_mac], ['National_Id'=>$dataMac['NationalId']]);
                } elseif ($exist['table'] == 'Visitor') {
                    $this->db->update('l2_visitors', ['ring_mac'=>$ring_mac], ['National_Id'=>$dataMac['NationalId']]);
                } elseif ($exist['table'] == 'Student') {
                    $this->db->update('l2_student', ['ring_mac'=>$ring_mac], ['National_Id'=>$dataMac['NationalId']]);
                }
                if ($ring_mac == 'Bind Ring') {
                    exit(json_encode(["message"=>"Ring Un-Binded Successfully","ctype"=>"1","cause"=>"1"]));
                } else {
                    exit(json_encode(["message"=>"Ring Binded Successfully","ctype"=>"1","cause"=>"1"]));
                }
            }else{
                exit(json_encode(["message"=>"National Id not found","ctype"=>"1","cause"=>"1"]));
            }
        } else{
            exit(json_encode(["message"=>"parameter missing","ctype"=>"1","cause"=>"1"]));
        }
    }

    /*public function saveLabReport(){
        $post = $this->input->post();
        if(!empty($post)){
            $data = $this->db->get_where('users_detail',['National_Id'=>$post['nationalId']])->row_array();
            if($data){
                $filename = $_FILES['pdf']['name'];
                 
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if(in_array($extension,['pdf'])){
                        $testId = $post['testId'];
                        $dates = date('d-m-Y-h:i:s',strtotime($post['datetime']));
                        if($data['Action'] == 'School'){
                         $liciense_path = 'uploads/lapteasreport/'.$data['National_Id'].'_'.$dates.'.'.$extension;
                        }elseif($data['Action'] != 'School'){
                            $liciense_path = 'uploads/co_lapteasreport/'.$data['National_Id'].'_'.$dates.'.'.$extension;
                        }
                        $liciense_tmp_name = $_FILES["pdf"]["tmp_name"];
                        move_uploaded_file($liciense_tmp_name, $liciense_path);
                        $fileurl = base_url() . $liciense_path;
                        $get = 
                        $processdata = [
                            'TimeStamp' => date('Y-m-d h:i:s',strtotime($post['datetime'])),
                            'UserId' => $data['id'],
                            'UserType' => $data['usertype'],
                            'Added_By' => 'Mobile App',
                            'Test_Description' => 'Rapid Test Report',
                            'Created' => date('Y-m-d',strtotime($post['datetime'])),
                            'Time' => date('H:i:s',strtotime($post['datetime'])),
                            'Report_link' => $data['National_Id'].'_'.$dates.'.'.$extension,
                        ];
                        if($data['Action'] == 'School'){
                            $processdata['Action'] = $data['Action']; 
                            $savedata = $this->db->insert('l2_labtests_Reports',$processdata);
                        }elseif($data['Action'] != 'School'){
                            $processdata['Action'] = $data['Action'];
                            $savedata = $this->db->insert('l2_co_labtests_Reports',$processdata);
                        }
                        $datasaver = [
                            'TimeStamp' => date('Y-m-d h:i:s',strtotime($post['datetime'])),
                            'UserId' => $data['id'],
                            'UserType' => $data['usertype'],
                            'Added_By' => 'Mobile App',
                            'Result' => (($post['getresult'] == 'Positive' || $post['getresult'] == 'POSITIVE' || $post['getresult'] == 'positive') ? 1 : 0),
                            'Symptoms' => !empty($post['symptoms']) ? $post['symptoms'] : 0,
                            'Device' => 0,
                            'Device_Test' => 'Mobile',
                            'Device_Batch' => 0,
                            'Created' => date('Y-m-d',strtotime($post['datetime'])),
                            'Test_Description' => $post['test_description'],
                            'Time' => date('h:i',strtotime($post['datetime']))
                            
                        ];
                        if (!empty($testId)) {
                            if (!empty($data['Action'] == 'School')) {
                                $this->db->insert('l2_labtests', $datasaver);
                            } elseif (!empty($data['Action'] != 'School')) {
                                $this->db->insert('l2_co_labtests', $datasaver);
                            }
                        }
                        if(!empty($savedata)){
                            if(empty($testId)){
                                $post = [
                                    'userId' => $data['id'],
                                    'familyNationalId' => $data['National_Id'],
                                    'result' =>  $fileurl,
                                     'devicetime' => $post['datetime']
                                ];
                                $url = 'https://qlickhealth.com/admin/index.php/api/user/saveRapidTestResult';
                            } else{
                                $post = [
                                'UserId' => $data['id'],
                                'familyNationalId' => $data['National_Id'],
                                'result' =>  $fileurl,
                                'devicetime' => $post['datetime'],
                                'testId' => $post['testId'],
                                'getresult' => (($post['getresult'] == 'Positive' || $post['getresult'] == 'POSITIVE' || $post['getresult'] == 'positive') ? 1 : 0),
                                'timestamp' => date('Y-m-d h:i:s', strtotime($post['datetime'])),
                                    'Created' => date('Y-m-d', strtotime($post['datetime'])),
                                    'added_by' => 'Mobile App',
                                    'Result' => (($post['getresult'] == 'Positive' || $post['getresult'] == 'POSITIVE' || $post['getresult'] == 'positive') ? 1 : 0),
                                    'Symptoms' => !empty($post['symptoms']) ? $post['symptoms'] : 0,
                                    'National_Id' => $post['nationalId'],
                                    'Device_Test' => 'Mobile',
                                    'Action' => $data['Action'],
                                    'Email' => $data['Email'],
                                    'Device_Batch' => 0,
                                    'type' => 2,
                                    'Test_Description' => $post['test_description'],
                                    'Time' => date('h:i', strtotime($post['datetime']))
                                ];
                                $url = 'https://qlickhealth.com/admin/index.php/api/user/SaveRapidLabReports';
                            }
                            
                            $headers = array(
                                'Authorization: key= gfhjui',
                                'Content-Type: application/json'
                            );                   		
                        		$ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url); 
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
                                $result = curl_exec($ch);
                                curl_close($ch);
                            $message['success'] = '1';
                            $message['message'] = 'Data are save successfully';
                            $message['result'] = $result;        
                        }else{
                            $message['success'] = '0';
                            $message['message'] = 'Data are not saved some problems are occured!';
                        }
                }else{
                    $message['success'] = '0';
                    $message['message'] = 'file is not pdf format!';    
                }
            }else{
                $message['success'] = '0';
                $message['message'] = 'User record are not found!';
            }
        }else{
            $message['success'] = '0';
            $message['message'] = 'Post parameter are the missing here!';
        }
        echo json_encode ($message );
    }*/

    public function saveLabReport(){
        $post = $this->input->post();
        if(!empty($post)){
            $data = $this->db->get_where('users_detail',['National_Id'=>$post['nationalId']])->row_array();
            if($data){
                $filename = $_FILES['pdf']['name'];
                 
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if(in_array($extension,['pdf'])){
                        $dates = date('d-m-Y-h:i:s',strtotime($post['datetime']));
                        if($data['Action'] == 'School'){
                         $liciense_path = 'uploads/lapteasreport/'.$data['National_Id'].'_'.$dates.'.'.$extension;
                        }elseif($data['Action'] != 'School'){
                            $liciense_path = 'uploads/co_lapteasreport/'.$data['National_Id'].'_'.$dates.'.'.$extension;
                        }
                        $liciense_tmp_name = $_FILES["pdf"]["tmp_name"];
                        move_uploaded_file($liciense_tmp_name, $liciense_path);
                        $fileurl = base_url() . $liciense_path;
                        $get = 
                        $processdata = [
                            'TimeStamp' => date('Y-m-d h:i:s',strtotime($post['datetime'])),
                            'UserId' => $data['id'],
                            'UserType' => $data['usertype'],
                            'Added_By' => 'Mobile App',
                            'Test_Description' => (!empty($post['test_description']) ? $post['test_description'] : 'Rapid Test Report'),
                            'Created' => date('Y-m-d',strtotime($post['datetime'])),
                            'Time' => date('H:i:s',strtotime($post['datetime'])),
                            'Symptoms' => !empty($post['symptoms']) ? $post['symptoms'] : 0,
                            'Report_link' => $data['National_Id'].'_'.$dates.'.'.$extension,
                        ];
                        if($data['Action'] == 'School'){
                            $processdata['Action'] = $data['Action']; 
                            $savedata = $this->db->insert('l2_labtests_Reports',$processdata);
                            // $savedata = 1;
                        }elseif($data['Action'] != 'School'){
                            $processdata['Action'] = $data['Action'];
                            $savedata = $this->db->insert('l2_co_labtests_Reports',$processdata);
                            // $savedata = 1;
                        }
                        if(!empty($savedata)){
                        	
                        	if(!empty($post['report_status']) == 'pending'){
                        	    $posts = [
                                  'userId'           => $post['userId'],
                            	  'result_pdf'       =>  $fileurl,
                            	  'deviceTime'       => $post['datetime'],
                            	  'testId'           => $post['testId'],
                            	  'result'           => $post['getresult'],
                            	  'report_status'    => $post['report_status'],
                            	  'ios'              => 1,
                            	  'familyNationalId' => $post['familyNationalId'],
                            	  'symptoms'         => $post['symptoms'],
                            	  'resultSymstoms'   => $post['getresult'],
                            	  'doctorId'         => $post['doctorId']
                        	    ];
                        	    $data  = json_encode($posts);
                        	    $url = 'https://qlickhealth.com/admin/index.php/api/user/saveRapidTestResult';
                        	    
                        	}else{
                        	   $posts = [
                                  'userId'           => $data['id'],
                            	  'familyNationalId' => $data['National_Id'],
                            	  'result'           =>  $fileurl,
                            	  'devicetime'       => $post['datetime'],
                            	  'testId'           => '122',
                            	  'getresult'        =>  'covid-19@specail',
                        	    ];
                        	    $data  = json_encode($posts);
                            	   $url = 'https://qlickhealth.com/admin/index.php/api/user/SaveRapidLabReports';
                        	}	
                        // 	print_r(json_encode($post));die;
                    		$ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            $result = curl_exec($ch);
                            curl_close($ch);
                        		
                            $message['success'] = '1';
                            $message['message'] = 'Data are save successfully';    
                        }else{
                            $message['success'] = '0';
                            $message['message'] = 'Data are not saved some problems are occured!';
                        }
                }else{
                    $message['success'] = '0';
                    $message['message'] = 'file is not pdf format!';    
                }
            }else{
                $message['success'] = '0';
                $message['message'] = 'User record are not found!';
            }
        }else{
            $message['success'] = '0';
            $message['message'] = 'Post parameter are the missing here!';
        }
        echo json_encode ($message );
    }

}



?>

