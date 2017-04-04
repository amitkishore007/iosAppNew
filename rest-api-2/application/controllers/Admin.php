<?php 
// admin controller 

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class Admin extends CI_Controller
{
	

	public function __construct() {

		parent::__construct();
		
		if (!$this->session->userdata('is_logged_in')) {
			return redirect('login');
		}
		

		$this->load->model('adminModel');

	}



	public function index() {

		$this->load->view('admin/login');
	}

	private function set_message($status, $msg) {
	
		return  ['status'=>$status,'message'=>$msg];
	
	}

	public function dashboard() {

	
		$data['users'] = $this->adminModel->get_all_users();

		$data['main_content'] = 'admin/dashboard';

		$this->load->view('includes/template',$data);
	}


	public function register() {

	}

	public function edit_user() {

	}

	public function delete_user() {

		$user_id = $this->uri->segment(3);

		if(isset($user_id)&&$user_id>0) {
			$id = (int) $user_id;
			$admin = $this->adminModel->delete_user($this->input->post());
			  
			echo json_encode($message);

		 } else {

		 	return json_encode($this->set_message(TRUE,'no direct access'));

		 }




			

			

			
			

					
			
	}

	public function store_data() {

	}


}
