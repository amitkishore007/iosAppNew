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
					

		],
		'distance_validation'=>[

					[
					'field'=>'user_id',
					'label'=>'User id',
					'rules'=>'required|is_natural_no_zero'
					],
					[
					'field'=>'distance',
					'label'=>'Distance covered',
					'rules'=>'required'	
					],
		],
		'invite_validate_email'=>[

					[
					'field'=>'user_id',
					'label'=>'user id',
					'rules'=>'required|is_natural_no_zero'
					],
					[
					'field'=>'invite',
					'label'=>'invite link',
					'rules'=>'required|valid_email'
					],
		],

		'invite_validate_phone'=>[

					[
					'field'=>'user_id',
					'label'=>'user id',
					'rules'=>'required|is_natural_no_zero'
					],
					[
					'field'=>'invite',
					'label'=>'invite link',
					'rules'=>'required|is_natural_no_zero|min_length[10]'
					],
		],

		'donation_validation'=>[


						[
						'field'=>'user_id',
						'label'=>'User id',
						'rules'=>'required|is_natural_no_zero'
					
						],
						[
						'field'=>'amount',
						'label'=>'User id',
						'rules'=>'is_natural_no_zero'
					
						],
						[
						'field'=>'type',
						'label'=>'Donation type',
						'rules'=>'required'
					
						],
						[
						'field'=>'distance',
						'label'=>'Distance covered',
						'rules'=>'is_natural_no_zero'
					
						],
						[
						'field'=>'paid',
						'label'=>'Payment status',
						'rules'=>'is_natural_no_zero|max_length[1]'
					
						],
						[
						'field'=>'points',
						'label'=>'Ponits earned',
						'rules'=>'is_natural_no_zero'
					
						]
		],

		'update_user_validation' =>[

							[
							'field'=>'user_id',
							'label'=>'User id',
							'rules'=>'required|is_natural_no_zero'
							],
							[
							'field'=>'fname',
							'label'=>'First name',
							'rules'=>'required|min_length[3]'
							],
							[
							'field'=>'lname',
							'label'=>'Last name',
							'rules'=>''
							],
							[
							'field'=>'email',
							'label'=>'Email address',
							'rules'=>'required|valid_email|is_unique[users.email]'
							],
							[
							'field'=>'phone',
							'label'=>'Phone number',
							'rules'=>'required|is_natural_no_zero'
							],
							[
							'field'=>'dob',
							'label'=>'Date of birth',
							'rules'=>'required'
							],
							[
							'field'=>'gender',
							'label'=>'Gender',
							'rules'=>'required'
							],
			],
			'update_user_validation_not_unique_email' =>[

							[
							'field'=>'user_id',
							'label'=>'User id',
							'rules'=>'required|is_natural_no_zero'
							],
							[
							'field'=>'fname',
							'label'=>'First name',
							'rules'=>'required|min_length[3]'
							],
							[
							'field'=>'lname',
							'label'=>'Last name',
							'rules'=>''
							],
							[
							'field'=>'email',
							'label'=>'Email address',
							'rules'=>'required|valid_email'
							],
							[
							'field'=>'phone',
							'label'=>'Phone number',
							'rules'=>'required|is_natural_no_zero'
							],
							[
							'field'=>'dob',
							'label'=>'Date of birth',
							'rules'=>'required'
							],
							[
							'field'=>'gender',
							'label'=>'Gender',
							'rules'=>'required'
							],
			],





];