<?php 



$config = [

		'login_form_validation'=>[

							[
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'required|valid_email'
        
							],
							[
							
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'required'
        
							]

		],

		'register_form_validation' =>[
					[
					'field' => 'fname',
					'label' => 'First name',
					'rules' => 'required|min_length[3]'
					],
					
					[
					'field' => 'email',
					'label' => 'Email address',
					'rules' => 'required|valid_email|is_unique[users.email]'
					],
					[
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|min_length[8]'
					],
					

		]

];