<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
		'customer_controller/createCustomer' => array(
				array(
						'field' => 'firstName',
						'label' => 'First Name',
						'rules' => 'required'
				),
				array(
						'field' => 'lastName',
						'label' => 'Last Name',
						'rules' => 'required'
				),
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[5]|max_length[12] 
							| is_unique[customer.username]'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required|min_length[4]'
				),
				array(
						'field' => 'passconf',
						'label' => 'Password Confirmation',
						'rules' => 'required|min_length[4]|matches[password]'
				),
				array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim | required | valid_email | is_unique[customer.email]'
				)
		)
);


