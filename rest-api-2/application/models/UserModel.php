<?php 


/**
* 
*/
class UserModel extends CI_Model
{
	
		public function get_users() {
			return $this->db->get('users')->result();

		}

		public function get_user_by_id($id) 
		{
			 return $this->db->where(['id'=>$id])->get('users')->result();
			//echo $id;
		}

		public function check_login($info) {

			$this->load->library('form_validation');

			if($this->form_validation->run('login_form_validation')) {
				
				$info = array(
					'email'=>$info['email'],
					'password'=>md5($info['password'])

					);
				$q = $this->db->where($info)->get('users')->result();

				if ($q) {
					
					return $q;
				
				} else {
					return false;
				}

			} else {

				return false;
			}

		}


		public function user_register($info) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('','');
			if ($this->form_validation->run('register_form_validation')==TRUE) {
			 
			$info['password'] = md5($info['password']);
				
			
			if($this->db->insert('users',$info)) {
				$message = array(
					'status'=>TRUE,
					'message'=>'successfuly registered !'
					);
				return $message;

			} else {
				$message = array(
					'status'=>FALSE,
					'message'=>'Unable to register, please try later !'
					);
				return $message;
			}

			} else {
				$message  = array(

					'status'=>FALSE,
					'error'=>array(
						'fname'=>form_error('fname'),
						'lname'=>form_error('lname'),
						'email'=>form_error('email'),
						'phone'=>form_error('phone'),
						'password'=>form_error('password'),
					 )

					);

				return $message;

			}
		}


}