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

			return redirect('admin/dashboard');
		
	}

	private function set_message($status, $msg) {
	
		return  ['status'=>$status,'message'=>$msg];
	
	}

	public function dashboard() {

	
		$data['users'] = $this->adminModel->get_all_users();

		$data['main_content'] = 'admin/dashboard';

		$this->load->view('includes/template',$data);
	}

	public function deleteUser() {

		if ($this->input->post('submit')) {

			$status = $this->adminModel->delete_user();

			echo $status;

		} else {

			echo 'Method not allowed !';
		}

	}

 public function do_upload()
        {
            
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        print_r($error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        print_r($data);
                        
                }
        }

        public function loadView() {
            $this->load->view('image');
        }

}
