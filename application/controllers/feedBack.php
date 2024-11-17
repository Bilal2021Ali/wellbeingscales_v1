<?php
defined( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class FeedBack extends CI_Controller {

    public function index() {
		$this->load->view('FeedBack/Log');
    }
	
	public function startlogin(){
		if($this->input->post("email") && $this->input->post("password")){
			$email = $this->input->post("email");
			$password = $this->input->post("password");
			if($email == "BECLOSE2015@email.com" && $password == "12345678"){
				$this->load->library( 'session' );
				$sess_array = array(
                    'Token' => md5(time()),
				);
				$this->session->set_userdata( 'Login', $sess_array );
				?>
				loged in
				<script>
					location.href = "<?php echo base_url() ?>FeedBack/ShowFeedBacks";
				</script>
				<?php
			}else{
				echo "you can't enter !";
			}
		}else{
			print_r($this->input->post());
		}
	}	
	
	
	
	public function ShowFeedBacks(){
        $this->load->library( 'session' );
        $sessiondata = $this->session->userdata('Login');
        if(!isset($sessiondata['Token']) || $sessiondata['Token'] == "" ){
            $this->load->view('FeedBack/disabledAccess');
        }else{
            $data['FeedsList'] = $this->db->query("SELECT * FROM `feedBack` WHERE `status` = '0' ORDER BY Id DESC")->result_array();
            $this->load->view('FeedBack/FeedsList' , $data);
            //print_r($sessiondata);
        }
	}
	
	
	public function Done(){
		$id  = $this->input->post("id");
		$this->db->query("UPDATE `feedBack` SET status = '1' WHERE Id = '".$id."' ");
	}
	
}
