<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   * 		http://example.com/EN/welcome
   *	- or -
   * 		http://example.com/EN/welcome/index
   *	- or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /EN/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function index()
  {
    $datalink = "./assets/data/links.json";
    $data['links'] = json_decode(file_get_contents($datalink), true);
    $this->load->view('Welcome/index' , $data);
  }
}
