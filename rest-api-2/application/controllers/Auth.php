<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller
{
	 function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('userModel');

    }


     public function users_get()
    {
        // Users from a data store e.g. database
        // $id = $this->get('id');

        $id =  $this->uri->segment(3);

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {

            // Check if the users data store contains users (in case the database result returns NULL)
	        $users =  $this->userModel->get_users();

            if ($users)
            {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

         	$user =  $this->userModel->get_user_by_id($id);
            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.


            if (!empty($user))
            {
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

	
	public function login_post() {

		if ($this->input->post('email')) {

			 if($user = $this->userModel->check_login($this->input->post())) {

			 	$this->set_response($user,REST_Controller::HTTP_OK);

			 } else {

			 	$this->set_response([
                    'status' => FALSE,
                    'message' => 'username/password did not match'
                ], REST_Controller::HTTP_UNAUTHORIZED); // NOT_FOUND (404) being the HTTP response code

			 }
			// $this->userModel->check_login($this->input->post());

		} else {

			$this->set_response([
                    'status' => FALSE,
                    'message' => 'Access denied'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}

	}	

    public function register_post() {

        if ($this->input->post('email')) {
            
            $status = $this->userModel->user_register($this->input->post());
            
            if($status['status']) {

                $this->set_response($status,REST_Controller::HTTP_OK);


            } else {

                $this->set_response($status,REST_Controller::HTTP_NOT_FOUND);
            }

        } else {

            $this->set_response([
                    'status' => FALSE,
                    'message' => 'Access denied'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }

    public function index_get() {
        echo 'Access denied no direct access';
    }

    public function distance_post() {

         if ($this->input->post('distance')) {
            
            $status = $this->userModel->put_distance($this->input->post());
            
            if($status['status']) {

                $this->set_response($status,REST_Controller::HTTP_OK);


            } else {

                $this->set_response($status,REST_Controller::HTTP_NOT_FOUND);
            }

        } else {

            $this->set_response([
                    'status' => FALSE,
                    'message' => 'Access denied'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }

    // public function send_notification_get() {

    //     $users = $this->userModel->get_all_users_notification();

    //     if (count($users)) {
            
    //         foreach ($users as $user) {
                

    //         }
    //     }

    // }


    public function invite_post(){


        if ($this->input->post('invite')) {
                
            $status = $this->userModel->send_invite_mail($this->input->post());
            
            if ($status['status']) {
                    
                $this->set_response($status,REST_Controller::HTTP_OK);

            } else {

                $this->set_response($status,REST_Controller::HTTP_NOT_FOUND);

            }

        } else {

                $this->set_response(FALSE,REST_Controller::HTTP_NOT_ACCEPTABLE);

        }

    }



	
}

