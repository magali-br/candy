<?php

class Customer extends CI_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    function loginForm() {
    	$this->load->view('customer/loginForm.php');
    }

    function createCustomerForm() {
	    $this->load->view('customer/createCustomerForm.php');
    }

    function createCustomer() {
    	$this->load->library('form_validation');

		$this->form_validation->set_rules('firstName','First Name','required');
		$this->form_validation->set_rules('lastName','Last Name','required');

        $this->form_validation->set_rules('username','Username', 'required | min_length[5] | max_length[12] | is_unique[customer.username]'); 

        $this->form_validation->set_rules('email','Email', 'required| valid_email | is_unique[customer.email]');
        $this->form_validation->set_rules('password','Password','required | min_length[5]');
        $this->form_validation->set_rules('passConf','Password Confirmation', 'required | matches[passConf]');

        //and more!

        if ($this->form_validation->run()) {
            //$this->load->model('customer_model');

            // $customer = new Customer();
            // $customer->first = $this->input->get_post('first');
            // $customer->last = $this->input->get_post('last');
            // $customer->first = $this->input->get_post('first');

            
            // $this->customer_model->insert($customer);

            //Then we redirect to the index page again
            redirect('candystore/productList', 'refresh');
        }
        else {
            $this->load->view('customer/createCustomerForm.php');
        }  
    }

    function login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username', 'required');
        $this->form_validation->set_rules('password','Password', 'required');

        if ($this->form_validation->run()) {
            //$this->load->model('customer_model');

            if ( strcmp($this->input->get_post('username'), "admin") == 0
                && strcmp($this->input->get_post('password'), "admin") == 0 ) {
                redirect('candystore/productList');
            }
            else {
                redirect('candystore/index', 'refresh');

            }
        
            // else check against database

            //Then we redirect to the index page again
            //redirect('candystore/index', 'refresh');
        } else {
            $this->load->view('product/list.php');
        }   
    }

}
?>