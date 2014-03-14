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
						'rules' => 'required|min_length[5]|max_length[12]|is_unique[customer.login]'
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
						'rules' => 'trim|required|valid_email|is_unique[customer.email]'
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
						'rules' => 'required|is_natural_no_zero|callback_creditcard_check'
				),
				array(
						'field' => 'expiryMonth',
						'label' => 'Credit Card Expiry Month',
						'rules' => 'required|is_natural_no_zero|less_than[13]'
				),
				array(
						'field' => 'expiryYear',
						'label' => 'Credit Card Expiry Month',
						'rules' => 'required|is_natural_no_zero|less_than[31]'
				)
		)

);


