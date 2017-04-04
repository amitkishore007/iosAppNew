<?php 
// admin controller 

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class Login extends CI_Controller
{
	

	public function __construct() {

		parent::__construct();

		// if ($this->session->userdata('is_logged_in')) {
		// 	return redirect('admin/dashboard');
		// }

		$this->load->model('adminModel');

	}


	public function index() {

		$this->load->view('admin/login');
	}

	private function set_message($status, $msg) {
	
		return  ['status'=>$status,'message'=>$msg];
	
	}

	public function login() {

		if ($this->input->post('submit')) {
			

			unset($_POST['submit']);

			
			$admin = $this->adminModel->check_login($this->input->post());
			  
			echo json_encode($admin);

				
		} else {

			 return json_encode($this->set_message(TRUE,'no direct access'));
		}

	}

	public function send() {

		$this->load->model('userModel');
		$this->userModel->send_email('kishoreamit5@gmail.com','kishoreamit5@gmail.com');
	}


}
