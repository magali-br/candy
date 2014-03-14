<?php

class Customer_Controller extends MY_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    function loginForm() {
        $data['title'] = 'Login';
        $data['main'] = 'customer/loginForm.php';
        $this->load->view('utils/template.php',$data);
    }

    function createCustomerForm() {
	    $data['title'] = 'New Account';
        $data['main'] = 'customer/createCustomerForm.php';
        $this->load->view('utils/template.php',$data);
    }

    function createCustomer() {

        // have to load this helper????
        //$this->load->helper('email');



    	$this->load->library('form_validation');

        if ($this->form_validation->run()) {
            $this->load->model('customer_model');

            $customer = new Customer();
            $customer->first = $this->input->get_post('firstName');
            $customer->last = $this->input->get_post('lastName');
            $customer->login = $this->input->get_post('username');
            $customer->password = $this->input->get_post('password');
            $customer->email = $this->input->get_post('email');

            $this->customer_model->insert($customer);

            // Get id of customer just created
            $customer_id = $this->db->insert_id();

            $this->loginManually($customer->login, $customer_id, $customer->first, 
                    $customer->last, $customer->email);

            redirect('candystore/storefront', 'refresh');
        } else {
            $this->createCustomerForm();
        }  
    }

    function login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username', 'required');
        $this->form_validation->set_rules('password','Password', 'required');

        if ($this->form_validation->run()) {
           $this->load->model('customer_model');
            
            $login = $this->input->get_post('username');

            //Check customer against the database
            $customer = $this->customer_model->getByLogin($login);

            if ($customer) {


                if (strcmp($customer->password, $this->input->get_post('password')) == 0) {
                    $_SESSION["loggedIn"] = true;
                    $_SESSION["login"] = $login;
                    $_SESSION["id"] = $customer->id;
                    $_SESSION["first"] = $customer->first;
                    $_SESSION["last"] = $customer->last;
                    $_SESSION["email"] = $customer->email;
                    $this->loginManually($login, $customer->id, $customer->first, 
                        $customer->last, $customer->email);
                } 

            } else {
                //error handling: no such customer
            }

        } else {
            // error handling
        }   
        redirect('candystore/index', 'refresh');
    }

    function loginManually($login, $id, $first, $last, $email) {

        if (!isset($_SESSION)) {
            $_SESSION = array();
        }

        $_SESSION["loggedIn"] = true;
        $_SESSION["login"] = $login;
        $_SESSION["id"] = $id;
        $_SESSION["first"] = $first;
        $_SESSION["last"] = $last;
        $_SESSION["email"] = $email;

    }

    function logout() {
        session_destroy();
        $_SESSION = array();
        redirect(base_url());
    }

}
?>