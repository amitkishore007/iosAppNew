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
				$user = $this->db->where($info)->get('users')->row();

				if ($user) {
					

					$message = array(
						"id"         => $user->id,
						"fname"      => $user->fname,
						"lname"      => $user->lname,
						"email"      => $user->email,
						"password"   => $user->password,
						"phone"      => $user->phone,
						"g_id"       => $user->g_id,
						"fb_id"      => $user->fb_id,
						"image"      => $user->image,
						"created_at" => $user->created_at
					);


					return $this->set_message(TRUE,$user);
				
				} else {
					return false;
				}

			} else {

				return false;
			}

		}


		private function set_message($status, $message) {

			return array( 'status'=>$status, 'message'=>$message );
		}
		
		function find_user_by_email($email) {

			return $this->db->where(['email'=>$email])->get('users')->row();
		}

		public function user_register($info) {

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','');

			if ($this->form_validation->run('register_form_validation')==TRUE) {
			 
			$info['password'] = md5($info['password']);	
			
			if($this->db->insert('users',$info)) {
				
				$user = $this->find_user_by_email($info['email']);

				$message = array(
					"id"         => $user->id,
					"fname"      => $user->fname,
					"lname"      => $user->lname,
					"email"      => $user->email,
					"password"   => $user->password,
					"phone"      => $user->phone,
					"g_id"       => $user->g_id,
					"fb_id"      => $user->fb_id,
					"image"      => $user->image,
					"created_at" => $user->created_at
					);

				return $this->set_message(TRUE, $message);

			} else {
				
				return $this->set_message(FALSE,'Unable to register, please try later !');
			}

			} else {
				
				$errors = array(
						'fname'=>form_error('fname'),
						'lname'=>form_error('lname'),
						'email'=>form_error('email'),
						'phone'=>form_error('phone'),
						'password'=>form_error('password'),
					 );

				return $this->set_message(FALSE,$errors);

			}
		}

		
		public function put_distance($info) {

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','');

			if ($this->form_validation->run('distance_validation')==TRUE) {
			 
			$info['user_id'] = (int) $info['user_id'];
				
			if($this->db->insert('distance',$info)) {

				return $this->set_message(TRUE,'distance covered sent to the server !');

			} else {
				
				return $this->set_message(FALSE,'could not syc with the server !');
			}

			} else {
				
				$message = array(
						'distance'=>form_error('fname'),
						'user_id'=>form_error('lname'),
					 );
				return $this->set_message(FALSE,$message);

			}
		}

		

		public function send_invite_mail($info) {

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','');
			
			$validate_method = 'invite_validate_phone';
			
			if (valid_email($info['invite'])) {
				
			   $validate_method =  'invite_validate_email';
			
			}
			
			if ($this->form_validation->run($validate_method)==TRUE) {
			 
			   $info['user_id'] = (int) $info['user_id'];
				
			if($this->db->insert('invite',$info)) {


				if (valid_email($info['invite'])) {
				// send mail if invite field is an email

					if ($this->send_email('kishoreamit5@gmail.com',$info['invite'])) {
						
						return $this->set_message(TRUE,'invitation mail sent successfuly !');
					
					} else {
						
						return $this->set_message(false,'There was an error, please try later !');
					}
				
				} else {
					// send as message if invite field is an number

					return $this->set_message(TRUE,'invitation message sent successfuly !');
				}


			} else {
				
				return $this->set_message(FALSE,'could not sent invitation, try later !');
			}

			} else {
				
				$message = array(
						'invite'=>form_error('invite'),
						'user_id'=>form_error('user_id'),
					 );
				return $this->set_message(FALSE,$message);

			}
		}

		public function send_email($email_from,$email_to) {
			
			
			$this->email->set_newline("\r\n");
		    $this->email->to($email_to);
	        $this->email->from($email_from);
	        $this->email->subject('marathon forever Invitation mail');
	        $this->email->message('This is an invitation mail from  '.$email_from.' please visit the link to download marathon forever app from play store.');
	        if($this->email->send()) {
	       
	        	return true;
	       
	        } else {
	        	
	        	return false;

	        }
		}


	

}

