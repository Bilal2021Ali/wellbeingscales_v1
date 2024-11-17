<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


class TempMonitor_Api extends CI_Controller {
	
  function __construct()
    {
       parent::__construct();
       $method = $_SERVER['REQUEST_METHOD'];
	   if($method !== "POST"){
		   //exit();
		   echo "please send some data";
	   }
     }     


	public function AddResult_school(){
		$Result = $this->input->post('Result');
		$MAC_Device = $this->input->post('MAC_Device'); 
		$Humidity = $this->input->post('Humidity');
		$Machine_Id = $this->input->post('Machine_Id');
		
			$response = [ 
				'success' => '0',
				'message' => 'Sorry We Have an Error',
		];
		
		$data = [
			"Result" => $Result,
			"MAC_Device" => $MAC_Device,
			"Humidity" => $Humidity,
			"Machine_Id" => $Machine_Id,
		];
		
		if($this->db->insert('l2_result_machine', $data)){
			$response['success'] = '1';
			$response['message'] = 'Data Inserted Successfuly ';
		}
		echo json_encode ( $response );
	}

} // end controller extand
