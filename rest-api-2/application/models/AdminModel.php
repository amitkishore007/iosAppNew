<?php 

/**
* 
*/
class AdminModel extends CI_Model
{
	
	
	public function check_login($info) {

		$this->load->library('form_validation');

		$output = array();
		$output['status'] = "";
		$output['msg']    = "";
				

		if ($this->form_validation->run('login_form_validation')==FALSE) {
				
			$output['status'] = "false";
			$output['msg']    = "Email/password did not matched !";

		} else {

		
			$info['password'] = md5($info['password']);
			
			$result = $this->db->where($info)->get('admin');

			if ($result->num_rows()) {
					
				$admin  = $result->row();
				$data = array(
					'admin_id'=>$admin->id,
					'admin_email'=>$admin->email,
					'role'=>$admin->role,
					'is_logged_in'=>true
					);
				$this->session->set_userdata($data);
				$output['status'] = "true";
				$output['msg']    = "success";

			} else {

				$output['status'] = "false";
				$output['msg']          = "Admin not found";
				
			}


		}

		return $output;

	}

	public function find_admin_by_id($id) {

		return $this->db->where(['id'=>$id])->get('admin')->result();
	}


	public function get_all_users() {

		return $this->db->get('users')->result();
	}

	public function add_user($info) {

	}

	public function update_user() {

	}

	public function delete_user() {

	}


}