<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Sync extends CI_Controller {

	function Devices_sync(){
		$this->load->view('Devices_sync');
	}

}

