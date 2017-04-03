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

	}

	public function store_data() {

	}


}
