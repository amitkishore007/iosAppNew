<?php 


/**
* handle all the users requests
*/

// twilio sms api library 
class UserModel extends CI_Model
{
	
		public function get_users() {

			//TODO: find all the users ranking.
						
			$donations =  $this->db->query('SELECT donations.id as donation_id, SUM(points) as total_points, donations.badge,donations.distance, users.fname,users.lname, users.id ,users.email,users.phone, users.image, users.dob, users.gender  FROM users LEFT OUTER JOIN donations ON users.id = donations.user_id GROUP BY users.id  order by total_points desc, users.fname ASC')->result();

			// return $donations;
        	
        	$rank  = 0;
        	$users = array();
        	//return $donations;
        	$last_points = false;
        	foreach ($donations as $donation ) {
				$user = array();	
				
				$user['id']           = $donation->id;
				$user['fname']        = $donation->fname;
				$user['lname']        = $donation->lname;
				$user['email']        = $donation->email;
				$user['phone']        = $donation->phone;
				$user['image']        = $donation->image;
				$user['distance']     = $donation->distance;
				$user['total_points'] = $donation->total_points;
				$user['badge']        = $this->set_badge($donation->distance);
				$user['dob']          = $donation->dob;
				$user['gender']       = $donation->gender;
			
				  if ($last_points!=$donation->total_points) {
				  	# code...
				  	$last_points = $donation->total_points;
					$rank++;
				  }
				 
				  $user['rank']         = $rank;

				  $users[] = $user;
        	}

        	return $users;

		}

		public function set_badge($distance) {

			
			switch ($distance) {

				case  5: $badge =  base_url('assets/badge/5.png');  break;
				case 10: $badge =  base_url('assets/badge/10.png'); break;
				case 15: $badge =  base_url('assets/badge/15.png'); break;
				case 20: $badge =  base_url('assets/badge/20.png'); break;
				case 21: $badge =  base_url('assets/badge/21.png'); break;
				case 35: $badge =  base_url('assets/badge/35.png'); break;
				case 30: $badge =  base_url('assets/badge/30.png'); break;
				case 35: $badge =  base_url('assets/badge/35.png'); break;
				case 40: $badge =  base_url('assets/badge/40.png'); break;
				case 42: $badge =  base_url('assets/badge/42.png'); break;
				
				default: $badge = ''; break;
		
			}

			return $badge;

		}

		public function get_user_by_id($id) {

			$users = $this->get_users();
			$user  = $this->find_key_value($users,'id', $id);

			if (!empty($user)) {
				
				return array($user);
			
			} else {
				
				return $user;
			}
			
		}

		private function find_key_value($array, $key, $val) {

		    foreach ($array as $item) {

		        if (is_array($item) && $this->find_key_value($item, $key, $val)) return $item;

		        if (isset($item[$key]) && $item[$key] == $val) return $item;
		    }

		    return false;
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
			 
				   $image = 'paceholder.png';

				if (!empty($_FILES['image']['name'])) {

					$image = $this->upload_image();
				}

			$info['password'] = md5($info['password']);	
			$info['image']    = base_url().'uploads/'.$image;	
			
			$this->db->insert('users',$info);
			if($this->db->affected_rows()==1) {
				
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

		private function upload_image() {
          
			$config['upload_path']   = './uploads';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name']  = TRUE;
			$config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {

                $data = $this->upload->data();

				$config['image_library']  = 'gd2';
				$config['source_image']   = './uploads/'.$data['file_name'];
				$config['new_image']      = './uploads/';
				$config['maintain_ratio'] = TRUE;
				$config['width']          = 200;
				$config['height']         = 200;
				$config['overwrite']      = TRUE;
				
				$this->load->library('image_lib', $config); 
				if (!$this->image_lib->resize()) {
				    return $this->set_message(FALSE,'There was en error with image uploading, try later!');
				}

				return $data['file_name'];
            }
	}

		
		public function put_donation($info) {

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','');

			if ($this->form_validation->run('donation_validation')==TRUE) {
			 
			$info['user_id'] = (int) $info['user_id'];
				
			if($this->db->insert('donations',$info)) {

				return $this->set_message(TRUE,'donation sent !');

			} else {
				
				return $this->set_message(FALSE,'could not syc with the server !');
			}

			} else {
				
				$message = array(
						'distance' =>form_error('distance'),
						'user_id'  =>form_error('user_id'),
						'amount'   =>form_error('amount'),
						'type'     =>form_error('type'),
						'paid'     =>form_error('paid'),
						'points'   =>form_error('points'),
						
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

		public function find_user_by_field($user_info) {

			$q = $this->db->where($user_info)->get('users');
			
			if ($q->num_rows()) {

				return $q->row();
			} 
		}

		public function insertFacebookGoogle($info) {

			$this->db->insert('users',$info);
			if ($this->db->affected_rows()==1) {
				return true;
			}

		}

		public function checkFBGLogin($info) {

			if (isset($info['fb_id'])) {
				
				
				$data = array('fb_id'=>$info['fb_id']);

				// check if user exists 
				if ($user = $this->find_user_by_field($data)) { //if exists then find user by fb_if and login
						
						$this->db->set(['image'=>$info['image']])->where(['fb_id'=>$user->fb_id])->update('users');					
						
						$message = array(
							"id"         => $user->id,
							"fname"      => $user->fname,
							"lname"      => $user->lname,
							"email"      => $user->email,
							"password"   => $user->password,
							"phone"      => $user->phone,
							"g_id"       => $user->g_id,
							"fb_id"      => $user->fb_id,
							"image"      => $info['image'],
							"created_at" => $user->created_at,
							'is_logged_in'=> 'true'
						);
					   return $this->set_message(TRUE, $message);

				} else { 	//else register
 				
 					if (!$this->find_user_by_field(['email'=>$info['email']])) {
 						
 					
	 				 	if ($this->insertFacebookGoogle($info)) {
							
							$user = $this->find_user_by_field(['fb_id'=>$info['fb_id']]);

							$message = array(
								"id"           => $user->id,
								"fname"        => $user->fname,
								"lname"        => $user->lname,
								"email"        => $user->email,
								// "password"  => $user->password,
								"phone"        => $user->phone,
								"g_id"         => $user->g_id,
								"fb_id"        => $user->fb_id,
								"image"        => $user->image,
								"created_at"   => $user->created_at,
								'is_logged_in' => 'false'
							);
						   return $this->set_message(TRUE, $message);

						} else {

							 return $this->set_message(FALSE, 'There was an error, please choose other login method');

						}
					} else {

						return $this->set_message(FALSE, 'Email is already registered, please login ');
					}
					
				}

			 } else if(isset($info['g_id'])) {

			 	$data = array('g_id'=>$info['g_id']);
				// check if user exists 
				if ($user = $this->find_user_by_field($data)) {//if exists then find user by fb_if and login

					$this->db->set(['image'=>$info['image']])->where(['g_id'=>$user->g_id])->update('users');	
											
						$message = array(
							"id"         => $user->id,
							"fname"      => $user->fname,
							"lname"      => $user->lname,
							"email"      => $user->email,
							"password"   => $user->password,
							"phone"      => $user->phone,
							"g_id"       => $user->g_id,
							"fb_id"      => $user->fb_id,
							"image"      => $info['image'],
							"created_at" => $user->created_at,
							'is_logged_in'=> 'true'
						);
					   return $this->set_message(TRUE, $message);

				} else { 	//else register
 				
 				 	if ($this->insertFacebookGoogle($info)) {
						
						$user = $this->find_user_by_field(['g_id'=>$info['g_id']]);

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
							"created_at" => $user->created_at,
							'is_logged_in'=> 'false'
						);
					   return $this->set_message(TRUE, $message);

					} else {

						 return $this->set_message(FALSE, 'There was an error, please choose other login method');

					}
					
				}
		
			}

		}


		public function update_user($info) {

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','');

			$user_id = (int) $info['user_id'];

			$user = $this->find_user_by_field(['id'=>$user_id]);

			$image = $user->image;

			if (!empty($_FILES['image']['name'])) {

				$image = $this->upload_image();
			}
			
			if ($user) {
				

				$rules = ($user->email==$info['email']) ? 'update_user_validation_not_unique_email' : 'update_user_validation'; 
				
				if ($this->form_validation->run($rules)==FALSE) {
					
						// give validation error
					$message = array(
							'user_id' =>form_error('user_id'),
							'fname'   =>form_error('fname'),
							'lname'   =>form_error('lname'),
							'email'   =>form_error('email'),
							'phone'   =>form_error('phone'),
							'dob'     =>form_error('dob'),
							'gender'  =>form_error('gender')
							
						 );
					return $this->set_message(FALSE,$message);

				} else {
					
					$data = array(

						'fname'  =>$info['fname'],
						'lname'  =>$info['lname'],
						'email'  =>$info['email'],
						'dob'    =>$info['dob'],
						'gender' =>$info['gender'],
						'phone'  =>$info['phone'],
						
						'image'  =>$image,
						
						);

					$this->db->set($data)->where(['id'=>$user_id])->update('users');

					if ($this->db->affected_rows()>=0) {
						
						// give success message
						
						return $this->set_message(TRUE,'Profile updated successfuly !');

					} else {

						return $this->set_message(FALSE,'Could not update profile, please try later !');
						// give error
					}
							
				}
			} else {

						return $this->set_message(FALSE,'user not found !');	
				}	

		}

		

}

