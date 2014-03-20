<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
		'customer_controller/createCustomer' => array(
				array(
						'field' => 'firstName',
						'label' => 'First Name',
						'rules' => 'required|max_length[24]'
				),
				array(
						'field' => 'lastName',
						'label' => 'Last Name',
						'rules' => 'required|max_length[24]'
				),
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[5]|max_length[16]|is_unique[customer.login]'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required|min_length[6]'
				),
				array(
						'field' => 'passconf',
						'label' => 'Password Confirmation',
						'rules' => 'required|min_length[6]|matches[password]'
				),
				array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|max_length[45]|required|valid_email|is_unique[customer.email]'
				)
		),
		'customer_controller/login' => array(
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required'
				)
		),
		'cart_controller/pay' => array(
				array(
						'field' => 'first',
						'label' => 'First Name',
						'rules' => 'required|alpha_numeric'
				),
				array(
						'field' => 'last',
						'label' => 'Last Name',
						'rules' => 'required|alpha_numeric'
				),
				array(
						'field' => 'creditCard',
						'label' => 'Credit Card Number',
						'rules' => 'required|is_natural_no_zero|exact_length[16]'
				),
				array(
						'field' => 'expiryMonth',
						'label' => 'Credit Card Expiry Month',
						'rules' => 'required|is_natural_no_zero|less_than[13]|exact_length[2]'
				),
				array(
						'field' => 'expiryYear',
						'label' => 'Credit Card Expiry Year',
						'rules' => 'required|is_natural_no_zero|exact_length[2]'
				)
		)

);


