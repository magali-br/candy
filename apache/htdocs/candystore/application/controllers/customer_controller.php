<?php

class Customer_Controller extends MY_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    function customerList() {
        $data['title'] = 'The Wonderful World of Candy';
        $data['main'] = 'customer/customerList.php';
        $this->load->model('customer_model');
        $customers = $this->customer_model->getAll();
        $data['customers']=$customers;
        $this->load->view('utils/template.php',$data);
    }

    function loginForm() {
        if (isset($_SESSION['errmsg'])) {
            $data['errmsg'] = $_SESSION['errmsg'];
            unset($_SESSION['errmsg']);
        }
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

    	$this->load->library('form_validation');

        if ($this->form_validation->run()) {
            $this->load->model('customer_model');

            $customer = new Customer();
            $customer->first = $this->input->get_post('firstName');
            $customer->last = $this->input->get_post('lastName');
            $customer->login = $this->input->get_post('username');
            $customer->password = $this->input->get_post('password');
            $customer->email = $this->input->get_post('email');

            if (!($this->customer_model->insert($customer))) {
                $this->createCustomerForm();
                //return;
            }

            // Get id of customer just created
            $customer_id = $this->db->insert_id();

            $this->loginManually($customer->login, $customer_id, $customer->first, 
                    $customer->last, $customer->email);

            redirect('candystore/storefront', 'refresh');
        } else {
            $this->createCustomerForm();
        }  
    }

    function deleteCustomer($id) {
        $this->load->model('customer_model');
        
        if (isset($id)) 
            $this->customer_model->delete($id);
        
        $this->customerList();

    }

    function login() {
        $this->load->library('form_validation');

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

                    redirect('candystore/index', 'refresh');
                } 

            } else {

                $_SESSION["errmsg"] = "Incorrect username or password. Please try again!";
                redirect('customer_controller/loginForm', 'refresh');
            }

        }  
        $this->loginForm();
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